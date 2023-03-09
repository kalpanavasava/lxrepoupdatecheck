<?php
class lx_articulate_assets{
	public function __construct() {
		add_action('wp_head',array($this,'add_articulate_style'));
		add_action('wp_enqueue_scripts',array($this,'articulate_enqueue_scripts'));
	}
	
	/**function for add stylesheet articulate web canvas**/
	public function add_articulate_style(){
		global $lx_articulate_plugin_path;
		if(is_page('create-articulate-content'))
		{
			include($lx_articulate_plugin_path.'/assets/css/lx_articulate_css.php');
		}
	}
	/**function for add script articulate web canvas**/
	public function articulate_enqueue_scripts(){
		global $lx_articulate_plugin_url;
		wp_enqueue_script('lx_articulate_js',$lx_articulate_plugin_url.'/assets/js/lx_articulate_js.js',array('jquery'));
		wp_localize_script( 'lx_articulate_js', 'lx_articulate_ajax', array('ajax_url'=>admin_url( 'admin-ajax.php' )) );
	}
}