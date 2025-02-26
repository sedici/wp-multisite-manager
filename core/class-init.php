<?php 

namespace Wp_multisite_manager\Core;
use Wp_multisite_manager as MM;
use Wp_multisite_manager\Admin as Admin;
use Wp_multisite_manager\Inc as Inc;

require_once 'class-loader.php';

require_once plugin_dir_path( __DIR__ ) . 'helpers.php'; 

require plugin_dir_path( __DIR__ ) . 'Inc/class-My-Template-Loader.php';


$dirMultisite = plugin_dir_path( __DIR__ ) . 'admin/multisiteAdmin.php';
$dirSinglesite = plugin_dir_path( __DIR__ ) . 'admin/singlesiteAdmin.php';

require  $dirSinglesite ;
require  $dirMultisite ;


/**
 * Clase para administrar los hooks y encolar los estilos / scripts
 */
class Init{
    /**
	 * @var      Loader    $loader    es el encargado de mantener y administar los hooks.
	 */
	protected $loader;
	/**
	 * @var      string    $plugin_base_name    string para identificar al plugin
	 */
	protected $plugin_basename;

	protected $multisite_administrator;
y
	protected $singlesite_administrator;

	protected $plugin_name;

	protected $version;

	protected $plugin_text_domain;
	/**
	 * Constructor de la clase
	 */


	public function __construct() {

		$this->plugin_name = MM\PLUGIN_NAME;
		$this->version = MM\PLUGIN_VERSION;
		$this->plugin_basename = MM\PLUGIN_BASENAME;
		$this->plugin_text_domain = MM\PLUGIN_TEXT_DOMAIN;

		$this->loader = new Loader();

		$this->multisite_administrator = new admin\multisiteAdmin($this);
		$this->singlesite_administrator = new admin\singlesiteAdmin($this);

		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	public function run() {
		$this->loader->run();
	} 

	# Register ADMIN Styles and Scripts --------------------------------------------------------------------

	function reg_admin_styles(){

		$js_url = MM\PLUGIN_NAME_URL.'admin/js/';

		wp_register_script('dinamicHeader', $js_url . 'dinamicHeader.js', array('jquery'),'1.1', true);
 
		wp_enqueue_script('dinamicHeader');
	

		$css_url = MM\PLUGIN_NAME_URL.'admin/css/administrationStyle.css';

		wp_register_style("administrationStyle", $css_url);

		wp_enqueue_style("administrationStyle");
	}


	function insert_modal_js (){ 
		wp_register_script('identify-modal',  MM\PLUGIN_NAME_URL . 'templates/js/modal-ajax.js', array('jquery'), '1', true );
		wp_enqueue_script('identify-modal');	
		wp_localize_script('identify-modal','imjs_vars',array('url'=>admin_url('admin-ajax.php')));
	}

	
	# Register PUBLIC Styles and Scripts --------------------------------------------------------------------
	
	function reg_public_styles() {
		$js_url = MM\PLUGIN_NAME_URL.'admin/js/';
		
		$public_css_HYF_url = MM\PLUGIN_NAME_URL.'templates/css/headerAndFooter.css';

	
		wp_register_style("multisite-manager-hyf-css", $public_css_HYF_url);

		wp_enqueue_style("multisite-manager-hyf-css");

		$public_css_GENERAL_url = MM\PLUGIN_NAME_URL.'templates/css/general.css';
		wp_register_style("multisite-manager-general-css", $public_css_GENERAL_url);

		wp_enqueue_style("multisite-manager-general-css");

	}

	# End of Styles and Scripts register --------------------------------------------------------------------

	function add_type_attribute($tag, $handle, $src) {
		// if not your script, do nothing and return original $tag
		if ( 'carrousel' !== $handle ) {
			return $tag;
		}
		// change the script tag by adding type="module" and return it.
		$tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
		return $tag;
	}

	# Register ADMIN Hooks --------------------------------------------------------------------

	/*
	* Esta función define los Hooks de ADMIN para SINGLE SITE
	*
	*/


	private function define_admin_hooks() {

		$dir_cpt_sitios = MM\PLUGIN_NAME_DIR.'core/CPT_Sitios.php';

		require_once $dir_cpt_sitios;

		// Solo debemos registrar el CPT de sitios si es el sitio principal

		if(is_main_site()){
			$sitiosCPT = new CPT_Sitios();

			// Registra el custom post sitios
			add_action('init', array($sitiosCPT,'cpt_sitios_register'),20);

			// Registra las capabilities
			add_action('init', array($sitiosCPT,'add_sitio_capabilities'),20);

			// Agrega los campos meta al custom post sitios
			add_action('add_meta_boxes', array($sitiosCPT,'sitios_custom_metabox'));

			// Guarda los campos meta
			add_action('save_post', array($sitiosCPT, 'sitios_save_metas'));

			// Se encarga de eliminar la imagen del CPT en el caso de que el mismo sea borrado
			add_action('before_delete_post', array($sitiosCPT,'delete_cpt_screenshot'));

			// Permite que se guarden imagenes en el formulario del CPT de Sitios
			add_action('post_edit_form_tag', array($sitiosCPT, 'update_edit_form'));

			// Llama a la función que registra los shortcodes
			add_action('init', array($this,'shortcodes_init'));

			/* wp_enqueue_scripts es el hook usado para encolar el script insertar_modal_js
			que sera usado en el frontend */
			add_action('wp_enqueue_scripts',array($this,'insert_modal_js'));

			add_action('wp_ajax_procesar_request_modal',array($this,'procesar_request_modal')  );
			add_action( 'wp_ajax_nopriv_procesar_request_modal', array($this,'procesar_request_modal') );


			/* wp_enqueue_scripts es el hook usado para encolar el script carga-dinamica.js
			que sera usado en el frontend */
			add_action('wp_enqueue_scripts',array($this,'dynamic_view_js'));

			/* Hook usado para encolar scripts helpers */
			add_action('wp_enqueue_scripts',array($this,'helpers_js'));


			add_action('wp_ajax_load_more',array($this,'load_more')  );
			add_action( 'wp_ajax_nopriv_load_More', array($this,'load_more') );

		}


		if ( ! defined('ABSPATH') ) {
			/** Set up WordPress environment */
			require_once( dirname( __FILE__ ) . '/wp-load.php' );
		}
	
		// Register Scripts and Styles
		

		add_action('admin_enqueue_scripts',array($this,'reg_admin_styles'),30);

	}

	function load_plugin_textdomain() {
		load_plugin_textdomain( 'wp-multisite-manager', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	  }


    private function define_public_hooks() {
		add_action( 'plugins_loaded', 'load_plugin_textdomain' );

		add_filter('script_loader_tag', array($this,'add_type_attribute') , 10, 3);

		add_action('wp_enqueue_scripts',array($this,'reg_public_styles'),30);

	}


    // Función para registrar los shortcodes

    function shortcodes_init(){
        add_shortcode('show_sites_portfolio',array($this,'show_portfolio'));
    }

	function dynamic_view_js (){ 
		wp_register_script('dynamic_addition',  MM\PLUGIN_NAME_URL . 'templates/js/carga-dinamica.js', array('jquery'), '1', true );
		wp_enqueue_script('dynamic_addition');	
	}

	function helpers_js() {
		wp_register_script('helpers_multisite_js',  MM\PLUGIN_NAME_URL . 'templates/js/helpers.js');
		wp_enqueue_script('helpers_multisite_js');
	}

	function show_portfolio($attr){

		$cant_columnas = 3;	

		$possible_values_array = array('none','post_date','ID','title','rand','modified');

		$parameters = shortcode_atts( array(
			'widget_color'=>'dark',
            'box_color' => 'white', 
			//'cant' => -1,
			'order_by' => 'post_date',
			'order' => 'DESC', 
        ), $attr );

		/*
		if ($parameters['cant'] !== -1 && $parameters['cant'] < 1) {
			$parameters['cant'] = -1;
		}
		*/

		if( ! in_array($parameters['order_by'], $possible_values_array)) $parameters['order_by'] = 'post_date';

		$vista_portfolio = "";

		$args = array(
			'posts_per_page' => -1,
			'orderby' => $parameters['order_by'],
    		'order' => $parameters['order'],
            'post_type' => 'cpt-sitios',
			'post_status' => 'publish',
        );

        $query = new \WP_Query($args);
		$vista_portfolio = "  <input type='hidden' id='portfolio-count' value=1 ><div style='display:flex;flex-direction:column'><div class='sites-portfolio' style='background-color:". $parameters['widget_color'] . "'>";

		$array_sitios = array(); /*En cada posicion se guarda una vista de post sitio */

		$i = 0; 

		/* Carga en un arreglo todos los post de sitios */
		while ( $query->have_posts() ): $query->the_post();

			$vista_unica_post_sitio = "";

			$vista_unica_post_sitio =
				"<div class='sites-portfolio-box'>
					<div class='cta' id='" . get_the_ID() . "'> 
						<div style='background-color:" . $parameters['box_color'] ."' >"

							.$this->print_screenshot(get_the_ID(),'site_screenshot', false) .

							"<div class='site-title'>" . get_the_title() . "</div>	

						</div>

					</div>
					
					<div class='portfolio-description'>
						<a href=" . get_post_meta(get_the_ID(),'site_url',true) . "> Visitar el sitio </a>
					</div>

				</div>";
		
			$array_sitios[$i] = $vista_unica_post_sitio;
			$i++;
        endwhile;

		$tam_array = count($array_sitios);

		
		for($i = 0 ; $i < $cant_columnas && $i < $tam_array ; $i++ ) $vista_portfolio = $vista_portfolio . $array_sitios[$i];
		

		wp_localize_script('dynamic_addition','cd_vars',array('tam_max'=>$tam_array,'box_color'=> $parameters['box_color'],'url'=>admin_url('admin-ajax.php'),));


		$vista_portfolio = $vista_portfolio. "<div class='show-more'> <span>Mostrar más</span> </div> </div> </div>";

        wp_reset_postdata();
		return $vista_portfolio;
	}


	/* FIXME : load_more no deberia mostrar más sitios de los establecidos en el shortcode */
	function load_more(){
	
		$args = array(
            'post_type' => 'cpt-sitios',
            'posts_per_page' => 3,
			'post_status' => 'publish',
			'paged' => $_POST['actual_count'],
        );

        $query = new \WP_Query($args);

		$array_sitios = array(); /*En cada posicion se guarda una vista de post sitio */

		/* Carga en un arreglo todos los post de sitios */
		while ( $query->have_posts() ): $query->the_post();

			$vista_unica_post_sitio = ""; /*Se guarda la vista de cada post sitio unico */

			$vista_unica_post_sitio =
				"
				<div class='sites-portfolio-box'>

					<div class='cta' id='" . get_the_ID() . "'>
					
						<div style='background-color:" . $parameters['box_color'] ."' >"

							. $this->print_screenshot(get_the_ID(),'site_screenshot', false) . 

							"<div class='site-title'>" . get_the_title() . "</div>	

						</div>
					
					</div>

						<div class='portfolio-description'> 
							<a href=" . get_post_meta(get_the_ID(),'site_url',true) . "> Visitar el sitio </a> 
						</div>

					</div>

				</div>";
		
			array_push($array_sitios, $vista_unica_post_sitio);
			
        endwhile;

        wp_reset_postdata();
		foreach($array_sitios as $array){
			echo $array;
		}
		exit();
	}

    function print_screenshot($post_id,$css_class){

		$class = "class='site-no-image-container-portfolio'";

		if(get_post_meta(get_the_ID(),'site_screenshot') and (!empty(get_post_meta(get_the_ID(),'site_screenshot')[0]) ))
		{
			$image = $this->get_image($post_id,'site_screenshot');
			if(!is_wp_error($image)){
				$vista_unica_post_sitio ='
					<img class="' . $css_class . '" src="';
				$image_src = wp_get_attachment_url($this->get_image($post_id,'site_screenshot')) ;

				$vista_unica_post_sitio = $vista_unica_post_sitio . $image_src .  '"></img>';
				return $vista_unica_post_sitio;
		 } 
		}
		else{
			return "<div " . $class . "> <span id='site-no-image'> No hay imagen para mostrar </span> </div>";
		}
	}



	/* Esta funcion imprime el modal del portfolio de sitios enviandole a js (modal-ajax) un html con la info. de un sitio ya cargada */
	function procesar_request_modal() {

		$args = array(
			'p'         => $_POST['box_id'], // ID of a page, post, or custom type
			'post_type' => 'cpt-sitios',
			'post_status' => array('publish', 'pending', 'draft', 'future', 'private', 'inherit'),
		  );
		

		/* Proceso el html del modal para poder enviarlo como respuesta */  
		
		$the_query = new \WP_Query($args);

		if($the_query->have_posts()) {

			$the_query->the_post();

			$template_data = [
				'site_title' => get_the_title(),
				'site_description' => print_description(),
				'site_screenshot' => $this->print_screenshot(get_the_ID(),'modal-img-elem',true),
				'screenshot_url' => $this->get_image_url(get_the_ID()),
				'site_URL' => get_post_meta($args['p'],'site_url',true),
				'site_fecha_creacion' => get_post_meta($args['p'],'site_creation_date',true),
			];

			$templateLoader = Inc\My_Template_Loader::getInstance();

			$templateLoader->set_template_data($template_data);
			$templateLoader->get_template_part("modal",true);

			$templateLoader->unset_template_data();

			exit();
		}

	}

	function get_image_url($post_id) {

		if(get_post_meta(get_the_ID(),'site_screenshot') and (!empty(get_post_meta(get_the_ID(),'site_screenshot')[0]) ))
		{
			$image = $this->get_image($post_id,'site_screenshot');

			$image_src = '';

			if(!is_wp_error($image)){
				$image_src = wp_get_attachment_url($this->get_image($post_id,'site_screenshot')) ;
		 	} 

			return $image_src;

		}
	}
	

	function get_image($post_id,$field){
		return get_post_meta($post_id, $field,true);
	}

    




}