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
		$this->define_public_hooks();
	}


	public function run() {
		$this->loader->run();
	} 

	function reg_admin_styles(){
		wp_register_style("mainStyle", plugin_dir_url(__FILE__) . 'admin/css/mainStyle.css');

		wp_enqueue_style("mainStyle");
	}

	function reg_public_styles() {
		$public_css_url = MM\PLUGIN_NAME_URL.'views/css/RowsAndColumns.css';
	
		wp_register_style("multisite-manager-public-css", $public_css_url);

		wp_enqueue_style("multisite-manager-public-css");
	}
    private function define_public_hooks() {
		add_action('wp_enqueue_scripts',array($this,'reg_public_styles'),30);
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


}