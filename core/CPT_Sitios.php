<?php
namespace Wp_multisite_manager\Core;

//Fixme : Puede que haya cosas que agregar o modificar

class CPT_Sitios {

    // Registra el Post Type Sitio
    function cpt_sitios_register() {

        $labels = array(
            "name" => __("Sitios CPT", ""),
            "singular_name" => __("Sitio CPT", ""),

            "menu_name" => __("Sitios CPT", ""),
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
            'publicly_queryable' => true,
            'show_in_menu' => true, 
            'show_in_admin_bar' => true,
            'show_ui' => true,
            'menu_icon' => "dashicons-info", //Falta poner
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
    * Agrega al rol admin las capabilites (de las que ya existen) para editar el custom post.
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


    /*
     * Formulario custom post
     */
    public function sitios_display_callback()
    {
        $dir = plugin_dir_path( __FILE__ ) . '../admin/views/CPT_Sitios_Form.php';
        include_once($dir);
    }

    /*
    * Agrega los campos personalizados para el custom post.
    */
    function sitios_custom_metabox() {
        add_meta_box('sitios_meta',__('Informacion del sitio'),array($this,'sitios_display_callback'),'cpt-sitios');
    }


    /*
     * Guarda los campos personalizados del post
     */
        function sitios_save_metas($idsitio) {  
            $sitio = get_post($idsitio);
        
            if ($sitio->post_type === 'cpt-sitios') {
                # Campos personalizados del CPT
                $fields = [
                    'site_url'        => 'text',
                    'site_description'=> 'text',
                    'site_screenshot' => 'image',
                    'site_dependence'   => 'text',
                    'site_isUNLP'    => 'bool',
                    'site_isCIC'    => 'bool',
                ];
             
                foreach ($fields as $field => $type) {
                    $value = $_POST[$field] ?? null;
                    update_post_meta($idsitio, $field, $this->process_field($type, $value, $idsitio));
                }
            }
        }



        function process_field($type,$value,$idsitio){
            $sanitizers = [
                'text'  => fn($value) => sanitize_text_field($value),
                'bool'  => fn($value) => $value === "1" || $value === "on" ? 1 : 0, 
                'image' => fn($value) => $this->process_screenshot($idsitio)
            ];
            return $sanitizers[$type]($value ?? '');
        }
        



    
        

    public function process_screenshot($idsitio){
        $field = "site_screenshot";
        $image_id = null;
        
        if( (!empty($_FILES)) and (!empty($_FILES[$field]['name'])) ){
        
                // Si esta seteada correctamente la imagen
            if (!is_wp_error($_FILES[$field]['name'])){
                    // Si quiero cargar una imagen, y ya existe una, elimino la anterior
                if(get_post_meta(get_the_ID(),'site_screenshot')){
                    wp_delete_attachment(get_post_meta(get_the_ID(),'site_screenshot')[0]);
                }
        
                    // Manejo de la carga de la imagen
                    $image_id = media_handle_upload($field, 0);
                }
            }
        
            // Si no hubo error, retorno el ID de la imagen
            return is_wp_error($image_id) ? null : $image_id;
        }
        

    function delete_cpt_screenshot($post_id){

        if('cpt-sitios' == get_post_type($post_id)){
            if(get_post_meta($post_id,'site_screenshot')){
                wp_delete_attachment(get_post_meta($post_id,'site_screenshot')[0]);
            }
            
        }
    }

    // Permite cargar imagenes en el formulario de CPT Sitios
    public function update_edit_form() {
        echo 'enctype="multipart/form-data"';
    }
        
        #FIXME: Hay que hacer un refactoring para eliminar los condicionales
       

}       

?>