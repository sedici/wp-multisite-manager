<?php
// Registra el Post Type Sitio
function cpt_sitios_register() {

    $labels = array(
        "name" => __("Sitio", ""),
        "singular_name" => __("Sitio", ""),

        "menu_name" => __("Sitio", ""),
        "all_items" => __("Todos los Sitios", ""),
        "add_new" => __("Agregar Sitio", ""),
        "add_new_item" => __("Agregar nuevo Sitio", ""),
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
        'public'        => true,
        'has_archive'   => true,
    );


    register_post_type( 'sitios', $args );
    
}


?>