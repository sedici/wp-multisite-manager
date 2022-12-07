<?php
/**
 * Plugin Name: Multisite-manager
 * Plugin URI: http://sedici.unlp.edu.ar/
 * Description: This plugin allows to create and display a footer or header on all sites of your multisite. 
 * Version: 1.0.0
 * Author: SEDICI
 * Author URI: http://sedici.unlp.edu.ar/   
 * Copyright (c) 2015 SEDICI UNLP, http://sedici.unlp.edu.ar
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 */

 namespace Wp_multisite_manager;

 define( __NAMESPACE__ . '\MM', __NAMESPACE__ . '\\' );
 define( MM . 'PLUGIN_NAME', 'wp-multisite-manager' );
 define( MM . 'PLUGIN_VERSION', '1.0.0' );
 define( MM . 'PLUGIN_NAME_DIR', plugin_dir_path( __FILE__ ) );
 define( MM . 'PLUGIN_NAME_URL', plugin_dir_url( __FILE__ ) );
 define( MM . 'PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
 define( MM . 'PLUGIN_TEXT_DOMAIN', 'wp-multisite-manager' );


 require_once 'core/class-init.php';

 require_once 'configuration.php';

/**
 * Register Activation and Deactivation Hooks
 */
register_activation_hook(
    __FILE__,
    'wp_multisite_manager_context'
);





function wp_multisite_manager_context(){
    if (is_multisite()) {
        echo "This is multisite";
    }
    else{
        echo "Sitio normal";
    }
}

class WP_multisite_manager {
    
    static $curr_dir; 

	static $init;
	/**
	 * Loads the plugin
	 * @access    public
	 */
	public static function init() {

       // Load the header on the DB
      //  $wpdb->insert('bannerCustom', 
     // $banner);
     
		if ( null == self::$init ) {
            self::$init = new Core\Init();
			self::$init->run();
		}

		return self::$init;
	}
    public static function curr_dir() {
        return plugins_url( '.', __FILE__ );
    }
}
/*
 * Comienza la ejecución del plugin
 */


 
function wp_multisite_manager_init(){
	return wp_multisite_manager::init();
}


// Agrega el banner al header
add_action('wp_head', function(){
    ?>  
    <div class="sedici-header">
        <!-- <h1 style="height:5vh; color:#5CB1E3">Desarrollado por prebi sedici -->
        <?php 
        $banner_file=dirname(__FILE__)."/views/banner-structure.html";
        readfile($banner_file); 
        ?>
        <?php 
         if (is_multisite()) {
            echo "This is multisite";
        }
        else{
            echo "<p class='pruebaEst'>Sitio normal</p>";
        }
        ?>
        </h1>
        <img style="height:8vh;width:35vh" src=<?php echo '"'. plugins_url('views/img/prebi-sedici.png',__FILE__) . '"' ?> ></img>
    </div>
    <script>
          alert('Un ejemplo desde Javascript');
      </script>
  <?php
});

/**
 * Si se accede desde afuera de wordpress aborta la ejecución.
 */
if ( ! defined( 'WPINC' ) ) die;
wp_multisite_manager_init();

?>
