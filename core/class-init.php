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
		$css_url = MM\PLUGIN_NAME_URL.'admin/css/administrationStyle.css';



		wp_register_style("administrationStyle", $css_url);

		wp_enqueue_style("administrationStyle");
	}

	
	# Register PUBLIC Styles and Scripts --------------------------------------------------------------------
	
	function reg_public_styles() {
		
		$public_css_HYF_url = MM\PLUGIN_NAME_URL.'templates/css/headerAndFooter.css';

	
		wp_register_style("multisite-manager-hyf-css", $public_css_HYF_url);

		wp_enqueue_style("multisite-manager-hyf-css");

		$public_css_GENERAL_url = MM\PLUGIN_NAME_URL.'templates/css/general.css';
		wp_register_style("multisite-manager-general-css", $public_css_GENERAL_url);

		wp_enqueue_style("multisite-manager-general-css");

	}

	# End of Styles and Scripts register --------------------------------------------------------------------



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

			// Permite que se guarden imagenes en el formulario del CPT de Sitios
			add_action('post_edit_form_tag', array($sitiosCPT, 'update_edit_form'));

			// Llama a la función que registra los shortcodes
			add_action('init', array($this,'shortcodes_init'));

			/* wp_enqueue_scripts es el hook usado para encolar el script insertar_modal_js
			que sera usado en el frontend */
			add_action('wp_enqueue_scripts',array($this,'insert_modal_js'));

			add_action('wp_ajax_charge_modal',array($this,'charge_modal')  );
			add_action( 'wp_ajax_nopriv_charge_modal', array($this,'charge_modal') );
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
		add_action('wp_enqueue_scripts',array($this,'reg_public_styles'),30);
		

	}


    // Función para registrar los shortcodes

    function shortcodes_init(){
        add_shortcode('show_sites_portfolio',array($this,'show_portfolio'));

    }

    function show_portfolio($attr){

		$parameters = shortcode_atts( array(
			'widget_color'=>'dark',
            'box_color' => 'white', 
        ), $attr );
		$content = "";

		$args = array(
            'post_type' => 'cpt-sitios',
            'posts_per_page' => -1,
			'post_status' => array('publish', 'pending', 'draft', 'future', 'private', 'inherit'),
        );

        $query = new \WP_Query($args);
		echo "<div class='sites-portfolio' style='background-color:". $parameters['widget_color'] . "'>";

		while ( $query->have_posts() ): $query->the_post();
					$template_data= [
						'site_title' => get_the_title(),
						'site_description' => print_description(),
						'site_screenshot' => $this->print_screenshot('site_screenshot',get_the_ID()),
                    	'site_id' => get_the_ID(),
						'box-color'=> $parameters['box_color']
					];


					$templateLoader = Inc\My_Template_Loader::getInstance();

					$templateLoader->set_template_data($template_data);
					$templateLoader->get_template_part("PUBLIC","portfolio_box",true);
					$templateLoader->unset_template_data();
         endwhile;

		echo "</div>";
        wp_reset_postdata();
	return true;
	}


	function print_screenshot($field,$post_id){
		if(get_post_meta(get_the_ID(),'site_screenshot') and (!empty(get_post_meta(get_the_ID(),'site_screenshot')[0]) ))
		{
			$image = $this->get_image($post_id,'site_screenshot');
			if(!is_wp_error($image)){
				$content ='
					<div class="cta"><img class="sites-portfolio-img" src="';
				$image_src = wp_get_attachment_url($this->get_image($post_id,$field)) ;

				$content = $content . $image_src .  '"></img></div>';
				return $content;
		 } 
		}
		else{
			return "<span style='color:red;font-weight:bold'> No hay screenshot </p>";
		}
	}


	function insert_modal_js (){ 
		$title_nonce = wp_create_nonce( 'esta_es_mi_request' );

		wp_register_script('identify-modal',  MM\PLUGIN_NAME_URL . 'templates/js/modal-ajax.js', array('jquery'), '1', true );
		wp_enqueue_script('identify-modal');	
		wp_localize_script('identify-modal','imjs_vars',array('url'=>admin_url('admin-ajax.php'),'nonce' => $title_nonce,));
	}

	function charge_modal() {
		/* Verifica la request de ajax, para prevenir procesar request externas */
		/* Deberia devolver el valor 1 o 2, cualquier otra cosa esta mal */
		$valor = check_ajax_referer( 'esta_es_mi_request', 'nonce', false);

		/* Deberia checkear $valor */

		$args = array(
			'p'         => $_POST['box_id'], // ID of a page, post, or custom type
			'post_type' => 'cpt-sitios',
			'post_status' => array('publish', 'pending', 'draft', 'future', 'private', 'inherit'),
		  );
		
		$the_query = new \WP_Query($args);

		if($the_query->have_posts()) {

			$the_query->the_post();
			
			$response = [
				'site_title' => get_the_title(),
				'site_description' => print_description(),
				'site_screenshot' => $this->print_screenshot('site_screenshot',get_the_ID()),
				'site_URL' => '',
			];

			wp_send_json($response);
			
		}
		else console.log('No hay posts con el id indicado');
		
		
	}

	function send_modal(){
		
	}
	

	function get_image($post_id,$field){
		return get_post_meta($post_id, $field,true);
	}
}