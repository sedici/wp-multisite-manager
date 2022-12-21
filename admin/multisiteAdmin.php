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
	    register_setting( 'header_settings', 'title_text' );
        register_setting( 'header_settings', 'title_link' );

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


}


?>