<?php 

require_once plugin_dir_path( __DIR__ ) . 'admin/class-wp-list-table.php'; 

require_once plugin_dir_path( __DIR__ ) . 'helpers.php'; 


    class Sites_table extends TablitaDemo\WP_List_Table{


    // ---------------------- FUNCIONES ORIGINALES DE WP_LIST_TABLE ------------------------------------
        
        function __construct() {
            parent::__construct( array(
           'singular'=> 'wp_list_site_cpt', //Singular label
           'plural' => 'wp_list_sites_cpt', //plural label, also this well be one of the table css class
           'ajax'   => false //We won't support Ajax for this table
           ) );
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
                'screenshot'=>__('Screenshot'),
                'url'=>__('Url'),
                'creation'=>__('Fecha de creación')
            );
            return $table_columns;
        }

        protected function get_views(){
            $status_links = array(
                __("Todos") => "<a href='admin.php?page=wp-multisite-manager&ss=false'>". __("Todos") . "</a>",
                __("Sin screenshot") =>"<a href='admin.php?page=wp-multisite-manager&ss=true'>".  __("Sin screenshot") . "</a>",
            );
            return $status_links;
        }

        public function no_items() {
            _e( 'No hay CPT de sitios aún.');
        }		

    /*
         * Indica según que columnas se podra ordenar las filas de la tabla
         * @return array $sortable, el array de columnas que pueden ser ordenadas
         */
          public function get_sortable_columns() {
            return $sortable = array(
            'post_title'=>'post_title',
            'creation'=>'creation',
            );
        }
 

        public function prepare_items(){

            // Obtengo todos los CPT de sitios
            $items = $this->get_cpt_data();

            // Si esta activo el filtro, elimino los posts que no tienen screenshot
            $screenshot_filter = ( isset( $_GET['ss'] ) ) ? $_GET['ss'] : 'false';

            if($screenshot_filter !== "false"){
                $items =  array_filter($items,fn($post)=> (
                                            $this->has_screenshot($post['ID']) == "No")
                                        );
            }

            // Ordeno los items
            $items = $this->order_items($items);

            // Pagino los items
            $this->paginate_items($items);
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

    // ---------------------- FUNCIONES PROPIAS de esta clase ------------------------------------

      
        /**  Obtiene todos los CPT de sitios.
         * 
         * @return array , devuelve un array donde cada elemento es un array que representa a un CPT de sitios
         */
        public function get_cpt_data(){

            $args = array(
                'post_type' => 'cpt-sitios',
                'posts_per_page' => -1
            );
    
            $query = new \WP_Query($args);
                                 
            $result =  array_map( fn($post) =>
                                        array_merge(
                                            $post->to_array(),
                                            [
                                                "description"=>get_post_meta($post->ID,'site_description',true), 
                                                "creation"=>get_post_meta($post->ID,'site_creation_date',true),
                                                "url"=>get_post_meta($post->ID,'site_url',true),
                                                "screenshot"=>$this->has_screenshot($post->ID)
                                            ]
                                        ), $query->get_posts() );
            return $result;
        }

            
         /**  Encargada de paginar los CPT de sitios que ya recuperamos
         * 
         * @param array $items, es un array de CPT de sitios.
         * 
         * @return array , devuelve solo los datos a mostrar según la página que estemos
         */
        private function paginate_items($items){
            $sites_per_page = 10;

            $table_page = $this->get_pagenum();

            // Dividimos manualmente el array para obtenerlo paginado


            $this->items = array_slice( $items, ( ( $table_page - 1 ) * $sites_per_page ), $sites_per_page );

	        // set the pagination arguments		
	        $total_sites = count( $items );
	        $this->set_pagination_args( array (
		                                        'total_items' => $total_sites,
		                                        'per_page'    => $sites_per_page,
		                                        'total_pages' => ceil( $total_sites/$sites_per_page )
	                                    ) );
            return $items;
        }


        /**  Ordena los items de un arreglo según los criterios dados.
         * 
         * @param array $items, es un array de CPT de sitios.
         * 
         * @return array , devuelve el mismo array que recibe como parámetro, pero ordenado
         */
        function order_items($items){

            // Obtengo el campo según el que ordenar, y si es ascendente o descendente
            $orderby = ( isset( $_GET['orderby'] ) ) ? esc_sql( $_GET['orderby'] ) : 'post_title';
            $order = ( isset( $_GET['order'] ) ) ? esc_sql( $_GET['order'] ) : 'ASC';
   
            $key = array_column($items, $orderby);
                                                                                
            if($order == "desc"){
                array_multisort($key, SORT_DESC, $items);
            }
            else{
                array_multisort($key, SORT_ASC, $items);
            }

            return $items;
        }


        function get_image($post_id,$field){
            return get_post_meta($post_id, $field,true);
        }


        /**  En base a un id de post, si es posible obtiene su imagen e indica si tiene o no.
         * 
         * @param integer $post_id , es el ID de un Custom Post Type de sitios.
         * 
         * @return string "Si" o "No", indica si el post tiene screenshot o no 
         */
        public function has_screenshot($post_id){
            if(get_post_meta($post_id,'site_screenshot') and (!empty(get_post_meta($post_id,'site_screenshot')[0]) ))
            {
                $image = $this->get_image($post_id,'site_screenshot');
                if(!is_wp_error($image)){
                    return __("Si");
             } 
            }
            else{
                return __("No");
            }
        }



       


}