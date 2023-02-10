<?php
namespace Wp_multisite_manager\Inc;
use Wp_multisite_manager as MM;

 require 'class-Gamajo_Template_Loader.php';

/**
 * Template loader for PW Sample Plugin.
 *
 * Only need to specify class properties here.
 *
 */

 
class My_Template_Loader extends Gamajo_Template_Loader {
 
	/**
	 * Prefix for filter names.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $filter_prefix = 'mm';


	private static $instances = [];
 
	/**
	 * Directory name where custom templates for this plugin should be found in the theme.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $theme_template_directory = 'templates';
 
	/**
	 * Reference to the root directory path of this plugin.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $plugin_directory = MM\PLUGIN_NAME_DIR;

	public static function getInstance(): My_Template_Loader
	{
		$cls = static::class;
		if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }
	
 
}

?>