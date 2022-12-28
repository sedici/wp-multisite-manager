<?php
namespace Wp_multisite_manager\Admin;

use Wp_multisite_manager as MM;


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

    }

    
    public function add_admin_menu(){
        
    }


    // Function to check if a Form was submitted
  /*  public function check_for_event_submissions(){
        if (isset($_POST['event'])){
            
        }
    }
    */

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

    function header_image_save($option){
        die;
        if(!empty($_FILES["image"]["tmp_name"])){
            $urls = wp_handle_upload($_FILES["image"], array('test_form' => FALSE));
            $temp = $urls["url"];
            echo $temp;
            return $temp;  
        }
    }

    function header_update_network_options(){
        #check_admin_referer('config-header-options');
        global $new_allowed_options;
        $options = $new_allowed_options['header_settings'];
        foreach ($options as $option) {
            if($option == "image"){
                $image_id = media_handle_upload('image',0 );
                update_site_option($option, $image_id);
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
            if($option == "image"){
                $image_id = media_handle_upload('image',0 );
                update_site_option($option, $image_id);
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
        $url=plugins_url();
        echo "<h1> Administrar la red de multisitio </h1>
        <p>Este plugin de Wordpress permite administrar configuraciones gloables para todos los sitios
		dentro de una red de Multisitio. </p>
        ";
        echo "<h2> Actualizar información de los CPT de sitios </h2> 
            <button id='update-sites-cpt' > Actualizar </button>
        ";

		#  <a href=$url/wp-dspace/UtilizaciondelPLuginWP-Dspace.docx>Descargar Manual</a>
        
    }

	private function add_block_subpages(){

		## Agregar subpágina HEADER
		$ajax_form_page_hook = add_submenu_page(
            $this->plugin_name, //parent slug
            __('Header', $this->plugin_text_domain), //page title
            __('Header', $this->plugin_text_domain), //menu title
            'manage_options', //capability
            'config-header', //menu_slug
            array($this, 'ajax_form_header_page_content')// pagina que va a manejar la sección
        );

		## Agregar subpágina FOOTER
		$ajax_form_page_hook = add_submenu_page(
            $this->plugin_name, //parent slug
            __('Footer', $this->plugin_text_domain), //page title
            __('Footer', $this->plugin_text_domain), //menu title
            'manage_options', //capability
            'config-footer', //menu_slug
            array($this, 'ajax_form_footer_page_content') // pagina que va a manejar la sección
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

    public function update_button_js() {
        ?>
        
            <script>
            console.log("Add");
            document.addEventListener('DOMContentLoaded', () => {
                
                const button = document.getElementById('update-sites-cpt');
        
                button.addEventListener('click', () => {
                    button.style.color = 'blue';
                });
            }
        
            </script>
            <?php
        } 



}


?>