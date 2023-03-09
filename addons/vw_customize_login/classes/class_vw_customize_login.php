<?php 
class Customize_login {
	function __construct() {
		add_action('wp_enqueue_scripts',array($this,'lx_custom_login_enqueue_scripts'));
	}
	/* function for enqueue_scripts in custom login */
	function lx_custom_login_enqueue_scripts() {
		global $lx_customize_login_plugin_url,$lx_customize_login_plugin_path;
		wp_enqueue_script('vw_customize_login_js',$lx_customize_login_plugin_url.'/assets/js/customize_login_js.js',array('jquery'));
		$scriptData = array();
        $scriptData['ajaxurl'] = admin_url( 'admin-ajax.php' );
		$ajax_array = array( 
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'blog_url' => site_url().'/blog-post/',
				);
		wp_localize_script( 'vw_customize_login_js', 'vw_custom_login_path', $ajax_array );
	}
}
?>