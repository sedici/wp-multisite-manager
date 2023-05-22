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
            $template_data = ["logos" => $this->print_logos('header_images','header-image')];
            $templateLoader = Inc\My_Template_Loader::getInstance();	
            $templateLoader->set_template_data($template_data);
	        $templateLoader->get_template_part("banner","structure",true);
            $templateLoader->unset_template_data(); 
        }
    }

    function registerFooter(){
        $enabled = get_site_option('footer_enabled');
        if ($enabled == 1){ 
            $template_data = ["logos" => $this->print_logos('footer_images','footer-image')];
            $templateLoader = Inc\My_Template_Loader::getInstance();	
            $templateLoader->set_template_data($template_data);
		    $templateLoader->get_template_part("footer","structure",true);
            $templateLoader->unset_template_data();

        }
    }

    function print_logos($option, $cssClass){
        switch_to_blog(1);

        $content ="";
        $images = get_site_option($option);

        if($images){
            foreach ($images as $image){
                $url = wp_get_attachment_url($image['id']);
                $content = $content .  "<a class='header-image-container' href=" . $image['link'] .  '>
                                <img class="' . $cssClass . '" src="' . $url . '"></img>
                            </a>';
            }
        }

        restore_current_blog();

        return $content;
       
    }

    
}

    
?>