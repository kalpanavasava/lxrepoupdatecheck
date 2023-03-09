<?php
class lx_include_assets{
	
	public function __construct() {
		add_shortcode('lx_basic_editor', array($this,'fn_lx_block_editor'));
		add_action('wp_enqueue_scripts', array($this,'fn_lx_include_scripts'));
		add_action('wp_head',array($this,'dynamic_blogpost_css'));
    }
	public function fn_lx_block_editor(){
		ob_start();
		
		$get_all_posts = $this->lx_get_datas->fn_lx_get_posts($filter_by=0);
		
		/* echo "<pre>";print_r($get_all_posts); */
		include(dirname(dirname(__FILE__)).'/template/index.php');
		
		$op = ob_get_clean();
		return $op;
	}
	
	function fn_lx_include_scripts(){
		wp_enqueue_style( 'lx_boostrap_css' , 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
		wp_enqueue_style( 'lx_font_awesome_css' , 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css');
		
		/*wp_enqueue_style( 'lx_editor_css' , lx_plugin_url . 'assets/css/lx_editor.css');*/
		wp_enqueue_style( 'lx_jqueryui_css' , 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
		wp_enqueue_style( 'lx_cropper_css' , lx_plugin_url . 'assets/css/cropper.css');
		 
		
		wp_enqueue_script( 'jquery_js',  lx_plugin_url . 'assets/js//jquery.js', array( 'jquery' ) );
		wp_enqueue_script( 'lx_boostrap_js' , 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js');
		wp_enqueue_script( 'lx_ck_editor' , 'https://cdn.ckeditor.com/4.5.5/standard/ckeditor.js');
		wp_enqueue_script( 'lx_jqueryui_js' , 'https://code.jquery.com/ui/1.12.1/jquery-ui.js');
		wp_enqueue_script( 'lx_cropper_js' , lx_plugin_url . 'assets/js/cropper.js');
		wp_enqueue_script( 'lx_editor_js' , lx_plugin_url . 'assets/js/lx_block_editor_js.js');
		
		
		wp_localize_script( 'lx_editor_js', 'lx_path',
				array( 
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'blog_url' => site_url().'/blog-post/',
				)
		);
	}  
	function dynamic_blogpost_css()
	{
		global $lx_plugin_path,$post;
		if($post->post_type=='post'|| $post->post_type=='memberpressproduct' || is_page('create-blog-post') || is_page('my-content'))
		{
			include($lx_plugin_path.'assets/css/lx_editor.php');
		}
	}
}