<?php
namespace Wp_multisite_manager\Admin;

use Wp_multisite_manager as MM;

use Wp_multisite_manager\Inc as Inc;



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

    // Funciónes para agregar Footer y Header


    function registerHeader(){


        $enabled = get_site_option('enabled');
        if ($enabled == 1){ 
            $template_data = ["logos" => $this->print_header_logos()];
            $templateLoader = Inc\My_Template_Loader::getInstance();	
            $templateLoader->set_template_data($template_data);
		    $templateLoader->get_template_part("banner","structure",true);
            $templateLoader->unset_template_data();


        }
    }

    function registerFooter(){
        $enabled = get_site_option('footer_enabled');
        if ($enabled == 1){ 
            $templateLoader = Inc\My_Template_Loader::getInstance();	
		    $templateLoader->get_template_part("footer","structure",true);
        }
    }

    function print_header_logos(){
        $content ="";
        $images = get_site_option('header_images');
        if($images){
            foreach ($images as $image){
                $content = $content .  "<a href=" . $image['link'] .  '>
                                <img class="header-image" src="' . wp_get_attachment_url($image['id']) . '"></img>
                            </a>';
            }
        }
        return $content;
       
    }

}

    
?>