<?php 

require_once WP_PLUGIN_DIR . '/wp-multisite-manager/admin/class-wp-list-table.php'; 



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
        function get_columns() {
            return $columns= array(
                'col_site_cpt_id'=>__('ID'),
                'col_site_title'=>__('Nombre'),
                'col_site_description'=>__('Descripción'),
                'col_site_url'=>__('Url'),
                'col_site_id'=>__('ID del sitio')
            );
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

        function prepare_items(){

           // global $wpdb, $_wp_column_headers;
            //$screen = get_current_screen();        
       // 

            /* -- Preparing your query -- */
         //   $query = "SELECT * FROM $wpdb->links";
       // }

    }
}