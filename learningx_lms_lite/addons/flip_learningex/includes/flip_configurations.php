<?php

class FlipConfigurations {
    
    function __construct() {
        add_action( "wp_enqueue_scripts", array($this, "flip_func_enqueue_scripts"));
        add_action("wp_head",array($this,'dynamic_flip_content_css'));
    }

    function flip_func_enqueue_scripts() {
        global $flip_plugin_url;
		if ( in_category( 'fl1p' ) ) {
			wp_enqueue_script("flip_learningex_js", $flip_plugin_url."js/flip_learningex.js");
		}
    }
    function dynamic_flip_content_css(){
        global $flip_plugin_path;
        if ( in_category( 'fl1p' ) ) {
           include($flip_plugin_path."/css/flip_learningex.php");
        }
    }
}