<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class fl1plist_guttenberg_block {

	function __construct() {
		/* Register Blocks. */
		add_action('init', array($this, 'lx_register_editor_blocks'),20 );
		add_action( 'enqueue_block_editor_assets', array( $this, 'lx_register_editor_assets' ),20 );
		if(isset($_GET['post'])){
			$post = get_post($_GET['post']); 
			if ( has_blocks( $post->post_content ) ) {
				$blocks = parse_blocks( $post->post_content );
				$blockname=array();
				foreach($blocks as $key=>$value){
					$blockname[]=$value['blockName'];
				}
				if (  in_array('lx-fl1plist-blocks/lx-block',$blockname) ) {
					add_action('admin_head',array( $this, 'lx_block_custom_css' ),20 );
				}
			}
		}
	}
	function lx_register_editor_blocks() {
		/* Blocks. */
		$this->lx_fliplist_carousel();
		
	}
	/** function for add js and css **/
	function lx_register_editor_assets() {
		global $lx_carousel_block_urls,$lx_carousel_block_paths,$lx_plugin_urls;
		$lx_block_data = $this->lx_get_block_data();
		wp_enqueue_script(
		    'fl1plist_custom_blocks',
		    $lx_carousel_block_urls.'/assets/js/lx_fliplist_carousel.js',
		    array('jquery', 'wp-blocks','wp-editor','wp-element')
		);
		wp_enqueue_script(
		    'custom_blocks_fl1plist_lite',
		   'https://kit.fontawesome.com/e2254dd01f.js'
		);
		wp_enqueue_style(
			'my-new-block_fl1plist_lite',
			'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css'
		);
		wp_enqueue_script( 'block_common_js', $lx_plugin_urls['lx_lms_lite'].'/assets/js/common.js');
		wp_enqueue_script( 'block_front_js', $lx_plugin_urls['lx_lms_lite'].'/assets/js/lx_lms_front.js'); 		
		wp_localize_script('fl1plist_custom_blocks','lx_fl1plist_block_data', $lx_block_data);
	}
	
	/** function for add css **/
	function lx_block_custom_css(){
		global $lx_carousel_block_urls,$lx_carousel_block_paths,$vw_flip_plugin_path,$lx_plugin_paths;
		include($lx_plugin_paths['lx_lms_lite'].'assets/css/lms_user_interface_settings.php');
		include($lx_carousel_block_paths.'assets/css/lx_carousel_block.php');
	}
	
	function lx_get_block_data(){
		$category_info = array(); 
		$user_id = get_current_user_id();
		$user = new WP_User( $user_id );
		$user_roles = $user->roles;

		$get_subcategofparent = get_terms('category', $args);
		
		$contcat = array();
		foreach( $get_subcategofparent as $all_cat ){
			$contcat[] = $all_cat->term_id;
			/* echo "<pre>";print_r($get_subcategofparent); */
		}
		
		$args=array(
			'post_type' => 'memberpressproduct',
			'post_status' => 'publish',
			'offset'=>0,
			'posts_per_page' => -1,
			'author'=>'-25',
			'post_parent' => '0',
			'category'=> $contcat
		);
		$all_memberships = get_posts($args);

		$parent_cat_id = get_term_by('slug', 'content-category', 'category')->term_id;
		$fl1plist_taxonomy_info = get_terms( array(
			'taxonomy' => 'category',
			'hide_empty' => false,
			'parent' => $parent_cat_id
		) );	
		foreach( $fl1plist_taxonomy_info as $fl1plist_taxonomy){
			if( $fl1plist_taxonomy->name == "Sponsored" ){
				$fl1plist_taxonomy->name = "PUBLIC ARTICLES";
				$category_info[] = $fl1plist_taxonomy;
			} else{
				$category_info[] = $fl1plist_taxonomy;
			}
			
		}
		
		/* echo "<pre>";print_r($community_info);
		die(); */
		$arrayOfValues = array(
			'custom_block_title'=> __("Lx - Fl1plist Carousel Block"),
			'custom_block_desc'	=> __("Lx - Fl1plist Carousel Block  can be added here..."),
			'selection_content' => __("Fl1plist Selection"),
			'categories'=> __("Categories"), 
			'category_info' => $category_info,
			'selection_title' => __("Section Title"),
			'view_selection_lbl' => __("View Selection"),
			'tab_view' => __("Tab View"),
			'list_view' => __("List View"),
			'lx_fl1plist_publish' => __("Publish"),
			'lx_fl1plist_draft' => __("Draft"),
			'fl1plist_status_selection' => __("Fl1plist Status Selection"),
		);
		return $arrayOfValues;
	}
	function lx_fliplist_carousel() {
	  	register_block_type( 'lx-fl1plist-blocks/lx-block', array(
	        'render_callback' => array($this,'lx_block_render_callback'),
	        'attributes' => array(
				'lx_selection' => array(
					'type' => 'string'
				),
				'lx_fl1plist_selection' => array(
					'type' => 'string'
				),
				'lx_fl1plist_selection_result' => array(
					'type' => 'string'
				),
				'lx_category_selection' => array(
					'type' => 'string'
				),
				'lx_section_title' => array(
					'type' => 'string'
				),
				'lx_view_selection' => array(
					'type' => 'string'
				),
				'lx_section_class' => array(
					'type' => 'string'
				),
				'lx_fl1plist_status' => array(
					'type' => 'string'
				),
				'lx_fl1plist_access' => array(
					'type' => 'string'
				),
				'className' => array(
					'type' => 'string'
				)
			),
	    ) );

	}
	
	function lx_block_render_callback($attributes = array(), $content = ""){
		global $wpdb,$color_palette,$breakpoint,$page_devider,$page_style,$lx_lms_plugin_path,$vw_flip_plugin_path;
		ob_start();
		if(empty($attributes['lx_view_selection'])){
			$view_selection = 'List';
		} else{
			$view_selection = $attributes['lx_view_selection'];
		}
		if(empty($attributes['lx_fl1plist_selection'])){
			$lx_fl1plist_selection = 'categories';
		} else{
			$lx_fl1plist_selection = $attributes['lx_fl1plist_selection'];
		}
		if($lx_fl1plist_selection == "categories" ){			
			if(empty($attributes['lx_category_selection'])){
				echo "<div class='selection_msg' style='display:none'>Please select category to preview fl1plist.</div>";
			} else {
				if(empty($attributes['lx_fl1plist_status'])){
					echo "<div class='selection_msg' style='display:none'>Please select fl1plist status to preview fl1plist.</div>";
				}
				 else{	
					get_category_content_fliplist($attributes,$view_selection);
				}
			}
		} 
		$fl1plist_data = ob_get_clean();
		if( $attributes['lx_need_login'] == 'need_login' ){
			if(is_user_logged_in()){
				if(isset($fl1plist_data)){
					return $fl1plist_data;
				}
			}
		} else{
			if(isset($fl1plist_data)){
				return $fl1plist_data;
			}
		}
	}
}
if(function_exists( 'register_block_type' ))
new fl1plist_guttenberg_block();