<?php 

namespace Wp_multisite_manager\Core;

use Wp_multisite_manager as MM;
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

		$this->load_dependencies();
		$this->define_admin_hooks();
		//$this->define_public_hooks();
	}


	private function define_admin_hooks() {
	
	$plugin_adminMultisite = new Admin\multisiteAdmin.php();
	$plugin_adminSinglesite = new Admin\singlesiteAdmin.php();
	// Register Scripts and Styles
		wp_register_style($this->plugin_name, plugin_dir_url(__FILE__) . 'admin/css/style.css', array(), $this->version, 'all');

		wp_enqueue_style($this->plugin_name);


		// SingleSite

		// Multisite

	// Register Admin hooks

		// SingleSite

		// Multisite


	}

}