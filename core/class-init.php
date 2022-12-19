<?php 

namespace Wp_multisite_manager\Core;
use Wp_multisite_manager as MM;
use Wp_multisite_manager\Admin as Admin;

require_once 'class-loader.php';
//require_once '../admin/multisiteAdmin.php';
$dir = plugin_dir_path( __DIR__ ) . 'admin/multisiteAdmin.php';
require  $dir ;

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

	protected $multisite_administrator;

	public function __construct() {

		$this->plugin_name = MM\PLUGIN_NAME;
		$this->version = MM\PLUGIN_VERSION;
		$this->plugin_basename = MM\PLUGIN_BASENAME;
		$this->plugin_text_domain = MM\PLUGIN_TEXT_DOMAIN;

		$this->loader = new Loader();

		$this->multisite_administrator = new admin\multisiteAdmin();

		$this->define_admin_multisite_hooks();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}


	public function run() {
		$this->loader->run();
		
	} 

	# Register ADMIN Styles and Scripts --------------------------------------------------------------------

	function reg_admin_styles(){
		$css_url = MM\PLUGIN_NAME_URL.'admin/css/administrationStyle.css';



		wp_register_style("administrationStyle", $css_url);

		wp_enqueue_style("administrationStyle");
	}

	
	# Register PUBLIC Styles and Scripts --------------------------------------------------------------------
	
	function reg_public_styles() {
		$public_css_url = MM\PLUGIN_NAME_URL.'views/css/RowAndCol-PublicHeader.css';
	
		wp_register_style("multisite-manager-public-css", $public_css_url);

		wp_enqueue_style("multisite-manager-public-css");
	}

	# End of Styles and Scripts register --------------------------------------------------------------------



	# Register ADMIN Hooks --------------------------------------------------------------------

	/*
	* Esta función define los Hooks de ADMIN para SINGLE SITE
	*
	*/


	public function define_admin_multisite_hooks(){
		
		#Registrar sección en el menu para administrar Footer y Header
		add_action('network_admin_menu',array($this,'add_Multisite_Menu_Pages'),30); 

	}


	private function define_admin_hooks() {  
		
	
	// $plugin_adminMultisite = new Admin\multisiteAdmin.php();
	
	// $plugin_adminSinglesite = new Admin\singlesiteAdmin.php();
	
	// Register Scripts and Styles

		add_action('admin_enqueue_scripts',array($this,'reg_admin_styles'),30);

		// SingleSite

		// Multisite

	// Register Admin hooks

		// SingleSite

		// Multisite


	}

	function load_plugin_textdomain() {
		load_plugin_textdomain( 'wp-multisite-manager', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	  }

    private function define_public_hooks() {
	
		  
		add_action( 'plugins_loaded', 'load_plugin_textdomain' );
		add_action('wp_enqueue_scripts',array($this,'reg_public_styles'),30);
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

# ------------------------------------------------------------------------------------


}