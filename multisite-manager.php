<?php
/**
 * Plugin Name: Multisite-manager
 * Plugin URI: http://sedici.unlp.edu.ar/
 * Description: This plugin allows to create and display a footer or header on all sites of your multisite. 
 * Version: 
 * Author: SEDICI
 * Author URI: http://sedici.unlp.edu.ar/   
 * Copyright (c) 2015 SEDICI UNLP, http://sedici.unlp.edu.ar
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 */

 namespace Wp_multisite_manager;


/**
 * Register Activation and Deactivation Hooks
 */
register_activation_hook();
register_deactivation_hook();

 /*
 * Starts plugin execution 
 */

 /**
 * Si se accede desde afuera de wordpress aborta la ejecución.
 */

?>
