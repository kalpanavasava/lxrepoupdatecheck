<?php
class lx_articulate_post{
	public function __construct() {
		global $lx_articulate_plugin_path;
		add_action( 'init', array( $this , 'lx_register_articulate_post' ) );
		add_shortcode('articulate_canvas',array($this,'add_articulate_canvas'));
		add_filter('single_template', array( $this , 'lx_articulate_template' ) );
	}
	
	/**function for register articulate web post**/
	public function lx_register_articulate_post() {
 
		register_post_type( 'lx_articulate',
			array(
				'labels' => array(
					'name' => __( 'Lx Articulate' ),
					'singular_name' => __( 'Lx Articulate' )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'lx_articulate'),
				'taxonomies' => array('category')
			)
		);
	}
	
	/**function for add articulate web canvas**/
	public function add_articulate_canvas(){
		ob_start();
		global $lx_articulate_plugin_path,$page_devider;
		include($lx_articulate_plugin_path.'/template/save_articulate_content.php');
		$op=ob_get_clean();
		return $op;
	}

	/**function for get public category**/
	public function 
	get_public_category(){
		$parent_cat_id = get_term_by( 'slug','content-category' , 'category')->term_id;
				
		$all_pub_lib_term = get_terms( array(
		  'taxonomy' => 'category',
		  'parent' => $parent_cat_id,
		  'hide_empty'  => false, 
		  'orderby'  => 'term_id',
		  'order' => 'desc'
		) );
		
		return $all_pub_lib_term;
	}
	
	/**function for add articulate web template**/
	public function lx_articulate_template( $template ) {
		global $post,$lx_articulate_plugin_path;
		if ($post->post_type == 'lx_articulate' ) {
			$template = $lx_articulate_plugin_path. '/template/single-lx_articulate.php';
		}
		return $template;
	}
}