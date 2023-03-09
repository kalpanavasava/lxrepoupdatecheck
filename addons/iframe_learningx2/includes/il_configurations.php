<?php

class ILConfigurations {
    
    function __construct() {
        add_action( "wp_enqueue_scripts", array($this, "il_func_enqueue_scripts"));
        add_action("wp_head",array($this,'dynamic_rise_content_css'));
    }
    
    function il_func_enqueue_scripts() {
        global $il2_plugin_url;
		if ( in_category( 'rise' ) ) {
			wp_enqueue_script("iframe_learningex", $il2_plugin_url."js/iframe_learningex.js");
		}
    }
    function dynamic_rise_content_css(){
         global $il2_plugin_path;
         ?>
         <script>
             var my_site_path={'site_url':"<?php echo site_url();?>"};
         </script>
         <?php
        if ( in_category( 'rise' ) ) {
            include($il2_plugin_path."/css/iframe_learningex.php");
        }
    }

    
}