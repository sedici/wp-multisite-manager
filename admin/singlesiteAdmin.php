<?php
namespace Wp_multisite_manager\Admin;

use Wp_multisite_manager as MM;


class SinglesiteAdmin{

    public function __construct() {

        $this->plugin_name = MM\PLUGIN_NAME;
		$this->version = MM\PLUGIN_VERSION;
		$this->plugin_basename = MM\PLUGIN_BASENAME;
		$this->plugin_text_domain = MM\PLUGIN_TEXT_DOMAIN;

        // Hook register

        // Agrega el bloque personalizado antes de cargar el header
        add_action('wp_head', array($this,'registerHeader'));

        // Agrega el bloque personalizado antes de cargar el footer
        add_action('wp_footer', array($this,'registerFooter'));

        }


    function registerHeader(){
        $enabled = get_site_option('enabled');
        if ($enabled == 1){ 
            $banner_file=plugin_dir_path( __DIR__ )."/views/banner-structure.php";
            include_once($banner_file); 
        }
    }

    function registerFooter(){
        $enabled = get_site_option('footer_enabled');
        if ($enabled == 1){ 
            $footer_file=plugin_dir_path( __DIR__ )."/views/footer-structure.php";
            include_once($footer_file); 
        }
    }


}

?>