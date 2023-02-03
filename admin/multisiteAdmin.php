<?php
namespace Wp_multisite_manager\Admin;

use Wp_multisite_manager as MM;

require_once WP_PLUGIN_DIR . '/wp-multisite-manager/helpers.php'; 


class multisiteAdmin{

    public function __construct() {

        $this->plugin_name = MM\PLUGIN_NAME;
		$this->version = MM\PLUGIN_VERSION;
		$this->plugin_basename = MM\PLUGIN_BASENAME;
		$this->plugin_text_domain = MM\PLUGIN_TEXT_DOMAIN;
      
        #  Esta función sirve para saber si se realizo algún POST de un formulario
        #  add_action('template_redirect', 'check_for_event_submissions');
      
        add_action('network_admin_menu',array($this,'add_Multisite_Menu_Pages'),30); 
        add_action( 'admin_init', array($this,'header_settings'), 30 );
        add_action( 'admin_init', array($this,'footer_settings'), 30 );
        add_action('admin-init','update_button_js');
        add_action('network_admin_edit_header_update_network_options',array($this,'header_update_network_options'));
        add_action('network_admin_edit_footer_update_network_options',array($this,'footer_update_network_options'));

        add_action('wp_ajax_update_sites_cpt',array($this,'update_all_cpt')  );
        add_action( 'wp_ajax_nopriv_update_sites_cpt', array($this,'update_all_cpt') );


		// Registro la llamada ajax para invocar
		add_action('admin_enqueue_scripts', array($this,'update_cpt_ajax') );

    }

    function update_cpt_ajax(){
		wp_register_script('update_sitios_cpt',  MM\PLUGIN_NAME_URL . 'admin/js/updateCPT-ajax.js', array('jquery'), '1', true );
		wp_enqueue_script('update_sitios_cpt');	
		wp_localize_script('update_sitios_cpt','ucpt_vars',array('url'=>admin_url('admin-ajax.php')));


	}

	function update_all_cpt(){

        // Recupero los sitios en $sites, creo el array vacío $sitesArray
        $sites = get_sites();
        $sitesArray= array();

        $cant= 0;

        // Guardo todos los IDS de los sitios en el array $sitesArray
        foreach ($sites as $site){
            array_push($sitesArray,$site->blog_id);
        }

        // Recupero todos los CPT de cpt-sitios
 	    $args = array(  
            'post_type' => 'cpt-sitios',
            'post_status' => array('publish', 'pending', 'draft', 'future', 'private', 'inherit'),
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
        );

        // Itero sobre los CPT de sitios
        $loop = new \WP_Query($args); 
        while ( $loop->have_posts() ) : $loop->the_post(); 
  
            $cpt_site_id = get_post_meta(get_the_ID(),'site_blog_id',true);

            /* Si el CPT, tiene asociado un id de sitio, elimino ese id del array $sitesArray, 
            *    para solo dejar los sitios que no tengan un CPT asociado
            */
            if (in_array($cpt_site_id,$sitesArray)){

                $key = array_search($cpt_site_id, $sitesArray);
                if( $key !== false ){
                    unset($sitesArray[$key]);
                }
            }

        endwhile;	
        wp_reset_postdata(); 

        // Para cada ID de sitio que no tiene un CPT, llamo a la función create_cpt_post
        foreach ($sitesArray as $site){

            $this->create_cpt_post($site);
        }
        return $sitesArray;
}

    function create_cpt_post($site){

        switch_to_blog($site);

        global $wpdb;
        $site_creation= $wpdb->get_var( $wpdb->prepare( "SELECT registered FROM $wpdb->blogs WHERE blog_id = %d",$site) );
        $site_name = get_bloginfo('name');
        $site_description = get_bloginfo('description');
        $site_url = get_bloginfo('url');

        restore_current_blog();

        $post_id = wp_insert_post(array (
            'post_type' => 'cpt-sitios',
            'post_title' => $site_name,
            'post_content' => $site_description,
            'post_status' => 'pending',

         ));

         if ($post_id) {
            // insert post meta
            add_post_meta($post_id, 'site_url', $site_url);
            add_post_meta($post_id, 'site_description', $site_description);
            add_post_meta($post_id, 'site_blog_id', $site);
            add_post_meta($post_id, 'site_creation_date', $site_creation);

         }

    }

    // Register all the header settings
    function header_settings() {
        register_setting( 'header_settings', 'enabled' );
        register_setting( 'header_settings', 'title_text' );
        register_setting( 'header_settings', 'title_link' );
        register_setting( 'header_settings', 'image', 'header_image_save' );
        register_setting( 'header_settings', 'image_link' );
        register_setting( 'header_settings', 'header_css');
    }

    // Register all the footer settings
    function footer_settings() {
        register_setting( 'footer_settings', 'footer_enabled' );
        
        // Social Media LINKS
        register_setting( 'footer_settings', 'footer_fb' );
        register_setting( 'footer_settings', 'footer_tw' );
        register_setting( 'footer_settings', 'footer_ig' );
        
        register_setting( 'footer_settings', 'footer_text' );
        register_setting( 'footer_settings', 'footer_text_link' );

        register_setting( 'footer_settings', 'footer_email' );
        register_setting( 'footer_settings', 'footer_phone' );

        register_setting( 'footer_settings', 'footer_logo_1' );
        register_setting( 'footer_settings', 'footer_logo_link_1' );

        register_setting( 'footer_settings', 'footer_logo_2' );
        register_setting( 'footer_settings', 'footer_logo_link_2' );

        register_setting( 'footer_settings', 'footer_css' );
    }


    function header_update_network_options(){
        #check_admin_referer('config-header-options');
        global $new_allowed_options;
        $options = $new_allowed_options['header_settings'];
        foreach ($options as $option) {
            if($option == "image"){
                if($_FILES[$option]['name'] !== null ){
                    $image_id = media_handle_upload($option,0 );
                    update_site_option($option, $image_id);
                }
            }
            else if (isset($_POST[$option])) {
                    update_site_option($option, $_POST[$option]);
            } else {
                delete_site_option($option);
            }
        }
        
        wp_redirect(add_query_arg(array('page' => 'config-header',
        'updated' => 'true'), network_admin_url('admin.php')));
        exit;
    }
    
    function footer_update_network_options(){
        #check_admin_referer('config-header-options');
        global $new_allowed_options;
        $options = $new_allowed_options['footer_settings'];
        foreach ($options as $option) {
            if(($option == "footer_logo_1")|| ($option == "footer_logo_2")) {
                if($_FILES[$option]['name'] !== null ){
                    $image_id = media_handle_upload($option,0 );
                    update_site_option($option, $image_id);
                }
            }
            else if (isset($_POST[$option])) {
                update_site_option($option, $_POST[$option]);
            } else {
                delete_site_option($option);
            }
        }
            
        wp_redirect(add_query_arg(array('page' => 'config-footer',
        'updated' => 'true'), network_admin_url('admin.php')));
        exit;
    }
    
        

    # Register all the MULTISITE Menu pages --------------------------------------------------------------

	public function add_Multisite_Menu_Pages(){
		add_menu_page(__('Administrar Footer y Header', $this->plugin_text_domain),
		__('Configurar multisitio', $this->plugin_text_domain), 
			'manage_options',
			$this->plugin_name,  
			array($this, 'wp_multisite_manager_blocks')
        );
		$this->add_block_subpages();
	}
	
	
	public function wp_multisite_manager_blocks()
    {

        echo 
        "<h1> Administrar la red de multisitio </h1>

        <p>Este plugin de Wordpress permite administrar configuraciones gloables para todos los sitios
		dentro de una red de Multisitio. </p>

        <h2> Actualizar información de los CPT de sitios </h2>

        <button id='update-cpt-button' > Actualizar </button> <br></br>";
        $this->print_sites_count();
        echo "<p id='update-result'></p>";
        echo "<br></br><h2> Sitios actuales </h2>";

        echo $this->print_sites_list();


        # Útil para agregar manual en un futuro:
        #  $url=plugins_url();
		#  <a href=$url/wp-dspace/UtilizaciondelPLuginWP-Dspace.docx>Descargar Manual</a>
        
    }

    private function print_sites_count(){
        $sites = count(get_sites());

        $sites_cpt = wp_count_posts('cpt-sitios')->publish + wp_count_posts('cpt-sitios')->pending;

        echo  "<span style='font-weight:bold;'> " . $sites .  __(" sitios / ") . $sites_cpt . __(" CPT de sitios");

    }

    private function print_sites_list(){

        if ( ! class_exists( 'WP_List_Table' ) ) {

            require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
        }

        $args = array(
            'post_type' => 'cpt-sitios',
            'posts_per_page' => -1
        );

        $query = new \WP_Query($args);
        if ($query->have_posts()): 
            while ($query->have_posts()): $query->the_post();
                    echo "<div class='site-container' id=" . get_the_ID() . ">";
                    echo "<span class='site-title'>" .  get_the_title() . "</span><br></br>" ;
                    echo "<span >" . _e("Descripción") .": </span><br>". print_description();
                    $url= get_post_meta(get_the_ID(),'site_url',true);
                    echo "<br></br><span> Url: <a href='" . $url . "'>" . $url . "</a></span>";
                    $creation_date = get_post_meta(get_the_ID(),'site_creation_date',true);
                    echo "<br></br><span>". __("Fecha de creación") . ": </span><br></br>" . $creation_date ;

                    echo "</div><br></br>";
                    
            endwhile;
            wp_reset_postdata();
        endif;
    }

    private function print_site_screenshot(){
        echo "<span >" . _e("Descripción") .": </span><br>". get_post_meta(get_the_ID(),'site_screenshot')[0];
    }

	private function add_block_subpages(){

		## Agregar subpágina HEADER
		$ajax_form_page_hook = add_submenu_page(
            $this->plugin_name, //parent slug
            __('Header', $this->plugin_text_domain), //page title
            __('Header', $this->plugin_text_domain), //menu title
            'manage_options', //capability
            'config-header', //menu_slug
            array($this, 'ajax_form_header_page_content')// página que va a manejar la sección
        );

		## Agregar subpágina FOOTER
		$ajax_form_page_hook = add_submenu_page(
            $this->plugin_name, //parent slug
            __('Footer', $this->plugin_text_domain), //page title
            __('Footer', $this->plugin_text_domain), //menu title
            'manage_options', //capability
            'config-footer', //menu_slug
            array($this, 'ajax_form_footer_page_content') // página que va a manejar la sección
        );
	}

	public function ajax_form_header_page_content()
    {
        include_once dirname(__DIR__) . '/admin/views/html-form-header-view-ajax.php';
    }


	public function ajax_form_footer_page_content()
    {
        include_once dirname(__DIR__) . '/admin/views/html-form-footer-view-ajax.php';
    }


    public function update_sites_cpt(){
        $sites_list = get_sites();
    }


}


?>