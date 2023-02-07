<?php 

require_once plugin_dir_path( __DIR__ ) . 'admin/class-wp-list-table.php'; 

require_once plugin_dir_path( __DIR__ ) . 'helpers.php'; 


    class Sites_table extends TablitaDemo\WP_List_Table{
        
        function __construct() {
            parent::__construct( array(
           'singular'=> 'wp_list_site_cpt', //Singular label
           'plural' => 'wp_list_sites_cpt', //plural label, also this well be one of the table css class
           'ajax'   => false //We won't support Ajax for this table
           ) );
         }

         /**
         * Agrega información arriba y abajo de la tabla
         * @param string $which, es el que permite saber si agregamos la "marca" antes (bottom) o después (top) de la tabla
         */
         function extra_tablenav( $which ) {
            if ( $which == "top" ){
               //Código para agregar arriba de la tabla
               echo "Listado de CPT sitios";
            }
            if ( $which == "bottom" ){
               //Código para agregar abajo de la tabla
               echo "";
            }
         }


         /**
         * Define las columnas de la tabla
         * @return array $columns, devuelve este array con las columnas
         */
        public function get_columns() {
            $table_columns= array(
                'cb'		=> '<input type="checkbox" />',
                'ID'=>__('ID'),
                'post_title'=>__('Nombre'),
                'description'=>__('Descripción'),
                'url'=>__('Url'),
                'creation'=>__('Fecha de creación')
            );
            return $table_columns;
        }

        public function no_items() {
            _e( 'No hay CPT de sitios aún.');
        }		

        /**
         * Indica según que columnas se podra ordenar las filas de la tabla
         * @return array $sortable, el array de columnas que pueden ser ordenadas
         *
         * public function get_sortable_columns() {
         *   return $sortable = array(
         *   'col_link_id'=>'link_id',
         *   'col_link_name'=>'link_name',
         *   'col_link_visible'=>'link_visible'
         *   );
        *}
        */

        public function get_cpt_data(){

            $args = array(
                'post_type' => 'cpt-sitios',
                'posts_per_page' => -1
            );
    
            $query = new \WP_Query($args);


            return  array_map( fn($post) =>
                                        array_merge(
                                            $post->to_array(),
                                            [
                                                "description"=>get_post_meta($post->ID,'site_description',true), 
                                                "creation"=>get_post_meta($post->ID,'site_creation_date',true),
                                                "url"=>get_post_meta($post->ID,'site_url',true)
                                            ]
                                        ), $query->get_posts() );

           


        }





        public function prepare_items(){

            $this->items = $this->get_cpt_data();
     
        }

        public function column_default( $item, $column_name ) {		
            switch ( $column_name ) {			
                case 'post_title':  
                case 'description':
                case 'url':
                case 'creation':
                case 'post_ID':
                    return $item[$column_name];
                default:
                  return $item[$column_name];
            }
        }


}