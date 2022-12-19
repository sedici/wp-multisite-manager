<?php
namespace Wp_multisite_manager\Admin;
class multisiteAdmin{

    public function __construct() {
        add_action('template_redirect', 'check_for_event_submissions');
        add_action( 'admin_init', array($this,'header_settings'), 30 );

    }

    
    public function add_admin_menu(){
        
    }


    // Function to check if a Form was submitted
    public function check_for_event_submissions(){
        if (isset($_POST['event'])){
            
        }
    }

    // Register all the header settings
    function header_settings() {
	    register_setting( 'header_settings', 'title_text' );
        register_setting( 'header_settings', 'title_link' );

    }

}


?>