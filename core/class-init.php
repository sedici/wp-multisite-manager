<?php 

namespace Wp_multisite_manager\Core;
use Wp_multisite_manager as MM;

require_once 'class-loader.php';

/**
 * Clase para administrar los hooks y encolar los estilos / scripts
 */
class Init{
    /**
	 * @var      Loader    $loader    es el encargado de mantener y administar los hooks.
	 */
	protected $loader;
	/**
	 * @var      string    $plugin_base_name    string para identificar al plugin
	 */
	protected $plugin_basename;

	public function __construct() {

		$this->plugin_name = MM\PLUGIN_NAME;
		$this->version = MM\PLUGIN_VERSION;
		$this->plugin_basename = MM\PLUGIN_BASENAME;
		$this->plugin_text_domain = MM\PLUGIN_TEXT_DOMAIN;

		$this->loader = new Loader();
		$this->define_admin_hooks();
		//$this->define_public_hooks();
	}


	public function run() {
		$this->loader->run();
	} 

	function reg_admin_styles(){
		wp_register_style("mainStyle", plugin_dir_url(__FILE__) . 'admin/css/mainStyle.css');

		wp_enqueue_style("mainStyle");
	}


	private function define_admin_hooks() {
	
	// $plugin_adminMultisite = new Admin\multisiteAdmin.php();
	
	// $plugin_adminSinglesite = new Admin\singlesiteAdmin.php();
	
	// Register Scripts and Styles

		add_action('admin_enqueue_scripts',array($this,'reg_admin_styles'),30);

		add_action('init',array($this,'define_admin_multisite_hooks'),10);
		// SingleSite

		// Multisite

	// Register Admin hooks

		// SingleSite

		// Multisite


	}

	# Falta agregar restriccion para que se vea solo en multisitio

	public function define_admin_multisite_hooks(){
		#Registrar sección en el menu para administrar Footer y Header
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
        include_once dirname(__DIR__) . '/admin/view/html-form-header-view-ajax.php';
    }

	
	public function ajax_form_footer_page_content()
    {
        include_once dirname(__DIR__) . '/admin/view/html-form-footer-view-ajax.php';
    }


}