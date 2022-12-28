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

        add_action( 'wp_initialize_site', array($this,'save_site_data')); //Como paso args?
        //add_action( 'wp_update_site', array($this,'update_site_data'));
        //add_action( 'clean_site_cache', array($this,'remove_site_data'));

        }

    
    # Register data about the new page created, creating a CPT site

    function save_site_data ($idsitio) {
        $site = get_post($idsitio);

        if ($site->post_type == 'cpt-sitios') {

            // Tomar info de la request hecha por el usuario al crear el sitio

            // Usar esa info para completar los campos del cpt

            // Guardar CPT con update_post_meta

        }

        
    }


    # Update data about a page (modifying the CPT) when something changes
    # Si lo que se modifica es un CPT, no necesitamos un hook

    function update_site_data () {    

    }

    # Remove a CPT site when a site is removed from the multisite

    function remove_site_data(){

    }
}

?>