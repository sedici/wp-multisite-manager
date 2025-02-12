<?php
namespace Wp_multisite_manager\Admin;

use Sites_table;
use Wp_multisite_manager as MM;

require_once plugin_dir_path( __DIR__ ) . 'helpers.php'; 

require_once plugin_dir_path( __DIR__ ) . 'admin/class-sites_table.php'; 



class multisiteAdmin{

    private $plugin_name;
    private $version;
    private $plugin_basename;
    private $plugin_text_domain;
    private $sites_table;
    private $cpt_list_table;


    public function __construct() {

        $this->plugin_name = MM\PLUGIN_NAME;
		$this->version = MM\PLUGIN_VERSION;
		$this->plugin_basename = MM\PLUGIN_BASENAME;
		$this->plugin_text_domain = MM\PLUGIN_TEXT_DOMAIN;
      
        #  Esta función sirve para saber si se realizo algún POST de un formulario
        #  add_action('template_redirect', 'check_for_event_submissions');
      
        add_action('network_admin_menu',array($this,'add_Multisite_Menu_Pages'),30); 

            
        // Registro la acción Update_all_cpt para la llamada AJAX
        add_action('wp_ajax_update_sites_cpt',array($this,'update_all_cpt')  );
        add_action( 'wp_ajax_nopriv_update_sites_cpt', array($this,'update_all_cpt') );


		// Registro la llamada ajax para actualizar los Custom Post Type de sitios
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
                if (is_archived($cpt_site_id)){
                    wp_delete_post(get_the_ID());
                }
                $key = array_search($cpt_site_id, $sitesArray);
                if( $key !== false ){
                    unset($sitesArray[$key]);
                }
            }

        endwhile;	
        wp_reset_postdata(); 

        // Para cada ID de sitio que no tiene un CPT, llamo a la función create_cpt_post
        foreach ($sitesArray as $site){
            if (!is_archived($site)){
                $this->create_cpt_post($site);
            }
        }
        return $sitesArray;
}



    /**
     * Crea un CPT y agrega la metadata correspondiente al blog id que recibe por parametro
     *      
     * @param integer $site Es el ID de sitio para el cual vamos a crear el CPT
    */
    function create_cpt_post($site){
        switch_to_blog($site);

        global $wpdb;
        $site_creation= $wpdb->get_var( $wpdb->prepare( "SELECT registered FROM $wpdb->blogs WHERE blog_id = %d",$site) );
        $formatedDate = new \DateTime($site_creation);

        $site_creation = $formatedDate->format('Y-m-d');

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



    function check_updated_image_data($images){

        $updatedImages = $images;
        // Reviso si los ids que tenia en la BD estan presentes en el POST

        if(isset($images)){
            foreach ($images as $key=>$image){
                $link = "link_" . strval($image["id"]);
    
                // Si estan presentes actualizo el link por las dudas
                if(array_key_exists($link, $_POST)){
                    $updatedImages[$key]["link"] = $_POST[$link];
                }
                // Si no esta presente, elimino el dato de la BD
                else{
                    wp_delete_attachment($updatedImages[$key]['id']);
                    unset($updatedImages[$key]);
                }
            }
            return $updatedImages;    
        }
        return false;
    }
    
        

    # Register all the MULTISITE Menu pages --------------------------------------------------------------

	public function add_Multisite_Menu_Pages(){
        $this->cpt_list_table = new Sites_table();

		add_menu_page(__('Administrar Footer y Header', $this->plugin_text_domain),
		__('Configurar multisitio', $this->plugin_text_domain), 
			'manage_options',
			$this->plugin_name,  
			array($this, 'wp_multisite_manager_blocks')
        );

	}
	
	
	public function wp_multisite_manager_blocks()
    {
        if ( ! class_exists( 'WP_List_Table' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
        }
        include plugin_dir_path( __DIR__ ) . 'admin/views/adminMenu/administration-menu.php';
        
    }

    private function print_sites_count(){
        $sites = count(get_sites());
        $sites_cpt = wp_count_posts('cpt-sitios')->publish + wp_count_posts('cpt-sitios')->pending;
        echo  "<span style='font-weight:bold;'> " . $sites .  __(" sitios / ") . $sites_cpt . __(" CPT de sitios");
    }


    public function update_sites_cpt(){
        $sites_list = get_sites();
    }

}
?>