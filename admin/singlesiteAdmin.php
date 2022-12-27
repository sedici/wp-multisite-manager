<?php
namespace Wp_multisite_manager\Admin;

use Wp_multisite_manager as MM;


class SinglesiteAdmin{

    public function __construct() {

        $this->plugin_name = MM\PLUGIN_NAME;
		$this->version = MM\PLUGIN_VERSION;
		$this->plugin_basename = MM\PLUGIN_BASENAME;
		$this->plugin_text_domain = MM\PLUGIN_TEXT_DOMAIN;

        // Hook register


    }
}

?>