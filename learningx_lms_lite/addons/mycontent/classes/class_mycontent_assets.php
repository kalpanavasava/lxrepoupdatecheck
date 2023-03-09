<?php
class ClassMyContentAssetsLite{
	public function __construct(){
		/** Enqueue MyContent Scripts and Styles **/
		add_action('wp_enqueue_scripts',array($this,'MyContentEnqueueScriptsStyles'));
	}
	public function MyContentEnqueueScriptsStyles(){
		wp_enqueue_style('mycontent_style_lite',MyContetntURLLite .'/assets/css/mycontent.css');
		wp_enqueue_script( 'mycontent_js_lite',MyContetntURLLite .'/assets/js/mycontent.js',array('jquery'));
		wp_localize_script( 'mycontent_js_lite', 'ajax_object',
							array( 
								'ajax_url' => admin_url( 'admin-ajax.php' ),
								'site_url' => site_url(),
							) 
						);
	}
	
}