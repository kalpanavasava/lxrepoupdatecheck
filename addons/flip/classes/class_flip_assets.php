<?php
class ClassFlipAssets {
	public function __construct() {
		/** Enqueue Flip Canvas Scripts and Styles **/
		add_action( 'wp_enqueue_scripts', array( $this ,'FlipCanvasEnqueueScriptsStyles') );
		
		/** Enqueue Fliplist Canvas Dynamic CSS **/
		add_action( 'wp_head' , array( $this ,'FliplistCanvasDynamicCSS') );
		
		/** Register Fliplist Custom Post Type **/
		add_action( 'init', array( $this , 'FliplistCustomPostType' ) );
		
		/** Function For Fliplist Template **/
		add_filter('single_template', array( $this ,'FliplistViewTemplate' ) );
		
		/** Register Flip Recording Custom Post Type **/
		add_action( 'init', array( $this , 'FlipRecordingCustomPostType' ) );
		
	}
	public function FlipCanvasEnqueueScriptsStyles() {
		
		wp_enqueue_style( 'flip_style',FL1PURL.'/assets/css/flip.css');
		wp_enqueue_script( 'fliplist_js',FL1PURL.'/assets/js/fliplist.js',array('jquery'));
		wp_localize_script( 'fliplist_js', 'ajax_ob',
							array( 
								'ajax_url' => admin_url( 'admin-ajax.php' ),
								'site_url' => site_url(),
							) 
						);
		wp_enqueue_script( 'flip_recording_js',FL1PURL.'/assets/js/flip_recording.js',array('jquery'));
		wp_localize_script( 'flip_recording_js', 'recording_ob',
							array( 
								'ajax_url' => admin_url( 'admin-ajax.php' ),
								'site_url' => site_url(),
							) 
						);
	}
	public function FliplistCanvasDynamicCSS(){
		if( is_page('create-fl1plist') || is_page('create-fl1p-recording') ){
			include FL1PPATH . '/assets/css/flip_css.php' ;
		}
	}
	public function FliplistCustomPostType() {
		register_post_type( 'flip_list',
			array(
				'labels' => array(
					'name' => __( 'Fl1plist' ),
					'singular_name' => __( 'Fl1plist' )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'fliplist'),
				'taxonomies'=>array('category')
			)
		);
	}
	
	public function FlipRecordingCustomPostType(){
		register_post_type('flip_recording',
			array(
				'labels' => array(
					'name' => __('Fl1p Recording'),
					'singular_name' => __('Fl1p Recording'),
					'show_in_rest' => false,
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'fliprecording'),
				'show_in_menu' => 'edit.php?post_type=flip_list',
				'taxonomies' => array('category')
			)
		);
	}
	
	public function FliplistViewTemplate( $template ) {
		global $post;
		if ( $post->post_type == 'flip_list' ) {
			$template = dirname(dirname(__FILE__)) . '/templates/single-flip_list.php';
		}
		return $template;
	}
}

?>