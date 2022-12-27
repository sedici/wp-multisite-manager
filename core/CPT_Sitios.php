<?php
namespace Wp_multisite_manager\Core;

//Fixme : Puede que haya cosas que agregar o modificar

//Se muestra el cpt sitios en los sitios del multisitio, no deberia suceder esto

class CPT_Sitios {

    // Registra el Post Type Sitio
    function cpt_sitios_register() {

        $labels = array(
            "name" => __("Sitio", ""),
            "singular_name" => __("Sitio", ""),

            "menu_name" => __("Sitios", ""),
            "all_items" => __("Todos los Sitios", ""),
            "add_new" => __("Agregar Sitio", ""),
            "add_new_item" => __("Agregar nuevo sitio", ""),
            "edit_item" => __("Editar Sitio", ""),
            "new_item" => __("Nuevo Sitio", ""),
            "view_item" => __("Ver Sitio", ""),
            "view_items" => __("Ver Sitios", ""),
            "search_items" => __("Buscar Sitios", ""),
            "not_found" => __("No se encontro el Sitio", ""),
            "not_found_in_trash" => __("No se encontro el Sitio en la papelera", ""),
            "parent_item_colon" => __("Sitio Padre", ""),

            "featured_image" => __("Foto del Sitio", ""),
            "set_featured_image" => __("Seleccionar la imagen", ""),
            "remove_featured_image" => __("Remover la imagen", ""),
            "use_featured_image" => __("Utilizar la imagen", ""),

            /* No estoy seguro de si estas labels sirven
            "archives" => __("Archivar al personal", ""),
            "insert_into_item" => __("Insert en Personal", ""),
            "uploaded_to_this_item" => __("Subir al personal", ""),
            */
            "filter_items_list" => __("Filtrar lista de sitios", ""),
            "items_list_navigation" => __("Navegación de la lista de sitios", ""),
            "items_list" => __("Lista de Sitios", ""),
            "attributes" => __("Atributos del Sitio", ""),   
        );

        $args = array (
            'labels'        => $labels,
            'description'   => "",
            'public'        => true, //No deberia ser publico para todos los sitios, sino para quien administra multistio
            'has_archive'   => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true, 
            'show_in_admin_bar' => true,
            'menu_icon' => "none", //Falta poner
            'capabilities' => array(
                'create_posts' => 'create_sitio',
                'delete_others_posts' => 'delete_others_sitios',
                'delete_private_posts' => 'delete_private_sitios',
                'delete_published_posts' => 'delete_published_sitios',
                'edit_private_posts' => 'edit_private_sitios',
                'edit_published_posts' => 'edit_published_sitios',
                'edit_post' => 'edit_sitio',
                'edit_posts' => 'edit_sitios',
                'edit_others_posts' => 'edit_other_sitios',
                'publish_posts' => 'publish_sitios',
                'read_post' => 'read_sitio',
                'read_private_posts' => 'read_private_sitios',
                'delete_post' => 'delete_sitio'
            ),
        
        );


        register_post_type( 'cpt-sitios', $args );
        
    }

    /*
    * Agrega las capabilites para editar el custom post.
    */
    function add_sitio_capabilities() {

        $rolAdmin = get_role('administrator');

        $caps = ['create_sitio', 'delete_private_sitios','delete_others_sitios',
        'delete_published_sitios','edit_published_sitios','edit_sitio','edit_sitios',
        'publish_sitios', 'read_sitio','delete_sitio','edit_private_sitios',
        'edit_other_sitios','read_private_sitios'];
    
        foreach ($caps as $cap)
            $rolAdmin->add_cap($cap);    
    }


    /**
     * Formulario custom post
     */
    // PARA QUE ME SIRVE EL ARG QUE RECIBE?
    public function sitios_display_callback($unArg)
    {
        $dir = plugin_dir_path( __FILE__ ) . '../views/sitios-view.php';
        include_once($dir);
    }

    /*
    * Agrega los campos personalizados para el custom post.
    */
    function personal_custom_metabox()
    {
        //Fixme : No estoy seguro de que los parametros esten bien pasados y el arg pasado a display callback no se de que me sirve
        add_meta_box('sitios_meta',__('Informacion del sitio'),array($this,'sitios_display_callback'),'cpt-sitios');
    }

}




?>