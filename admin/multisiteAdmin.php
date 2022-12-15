<?php
namespace Wp_multisite_manager\Admin;
class multisiteAdmin{

    public function __construct() {
        add_action('template_redirect', 'check_for_event_submissions');
    }

    
    public function add_admin_menu(){
        
    }

    public function check_for_event_submissions(){
        if (isset($_POST['event'])){
            
        }
    }

    add_action( 'admin_post_add_foobar', 'prefix_admin_add_foobar' );
    
    function prefix_admin_add_foobar() {
        status_header(200);
        //request handlers should exit() when they complete their task
        exit("Server received '{$_REQUEST['data']}' from your browser.");
    }

}


?>