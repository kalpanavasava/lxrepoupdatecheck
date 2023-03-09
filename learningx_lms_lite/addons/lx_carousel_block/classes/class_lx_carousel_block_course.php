<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class course_guttenberg_block {

	function __construct() {
		/* Register Blocks. */
		add_action('init', array($this, 'lx_register_editor_blocks'),20 );
		add_action( 'enqueue_block_editor_assets', array( $this, 'lx_register_editor_assets' ),20 );
		add_filter( 'block_categories', array($this,'block_category'), 10, 2);
		if(isset($_GET['post'])){
			$post = get_post($_GET['post']); 
			if ( has_blocks( $post->post_content ) ) {
				$blocks = parse_blocks( $post->post_content );
				$blockname=array();
				foreach($blocks as $key=>$value){
					$blockname[]=$value['blockName'];
				}
				if (  in_array('lx-course-blocks/lx-block',$blockname) ) {
					add_action('admin_head',array( $this, 'lx_block_custom_css' ),20 );
				}
			}
		}
	}
	function lx_register_editor_blocks() {
		/* Blocks. */
		$this->lx_carousel_block_course();
		
	}
	/** function for add js and css **/
	function lx_register_editor_assets() {
		global $lx_carousel_block_urls,$lx_carousel_block_paths,$lx_plugin_urls,$kit_code;
		$lx_block_data = $this->lx_get_block_data();
		wp_enqueue_script(
		    'course_custom_blocks',
		    $lx_carousel_block_urls.'/assets/js/lx_carousel_block_course.js',
		    array('jquery', 'wp-blocks','wp-editor','wp-element')
		);
		wp_enqueue_script(
		    'custom_blocks1',
		   'https://kit.fontawesome.com/'.$kit_code.'.js'
		);
		wp_enqueue_style(
			'my-new-block1',
			'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css'
		);
		wp_enqueue_script( 'block_common_js', $lx_plugin_urls['lx_lms_lite'].'/assets/js/common.js');
		wp_enqueue_script( 'block_front_js', $lx_plugin_urls['lx_lms_lite'].'/assets/js/lx_lms_front.js'); 		
		wp_localize_script('course_custom_blocks','lx_block_data_lite', $lx_block_data);
	}
	
	/** function for add css **/
	function lx_block_custom_css(){
		global $lx_carousel_block_urls,$lx_carousel_block_paths,$vw_flip_plugin_path,$lx_plugin_paths;
		include($lx_plugin_paths['lx_lms_lite'].'assets/css/lms_user_interface_settings.php');
		include($lx_carousel_block_paths.'assets/css/lx_carousel_block.php');
	}
	
	function lx_get_block_data(){
		$category_info = array(); 
		$parent_cat_id = get_term_by('slug', 'content-category', 'category')->term_id;
		$course_taxonomy_info = get_terms( array(
			'taxonomy' => 'category',
			'hide_empty' => false,
			'parent' => $parent_cat_id
		) );	
		foreach( $course_taxonomy_info as $course_taxonomy){
			if( $course_taxonomy->name == "Sponsored" ){
				$course_taxonomy->name = "PUBLIC ARTICLES";
				$category_info[] = $course_taxonomy;
			} else{
				$category_info[] = $course_taxonomy;
			}
			
		}
		$arrayOfValues = array(
			'custom_block_title'=> __("Lx - Course Carousel Block Settings"),
			'custom_block_desc'	=> __("Lx - Course Carousel Block Settings can be added here..."),
			'selection_content' => __("Course Selection"),
			'courses'	=> __("Courses"), 
			'categories'=> __("Categories"),
			'not_in_categories'=> __("Not In Categories"),
			'category_info' => $category_info,
			'selection_title' => __("Section Title"),
			'need_login' => __("Need Login"),
			'tab_view' => __("Tab View"),
			'list_view' => __("List View"),
			'view_selection_lbl' => __("View Selection"),
			'lx_course_publish' => __("Publish"),
			'lx_course_draft' => __("Draft"),
			'lx_course_paid' => __("Paid"),
			'lx_course_free' => __("Free"),
			'course_status_selection' => __("Course Status Selection"),
			'course_access_selection' => __("Course Access Selection")
		);
		return $arrayOfValues;
	}
	function block_category( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug' => 'lx-blocks',
					'title' => __( 'Lx - Carousel Block' ),
				),
			)
		);
	} /* end of block_category function */
	function lx_carousel_block_course() {
	  	register_block_type( 'lx-course-blocks/lx-block', array(
	        'render_callback' => array($this,'lx_block_render_callback'),
	        'attributes' => array(
				'lx_selection' => array(
					'type' => 'string'
				),
				'lx_course_selection' => array(
					'type' => 'string'
				),
				'lx_course_selection_result' => array(
					'type' => 'string'
				),
				'lx_category_selection' => array(
					'type' => 'string'
				),
				'lx_need_login' => array(
					'type' => 'string'
				),
				'lx_section_title' => array(
					'type' => 'string',
				),
				'lx_view_selection' => array(
					'type' => 'string'
				),
				'lx_section_class' => array(
					'type' => 'string'
				),
				'lx_course_status' => array(
					'type' => 'string'
				),
				'lx_course_access' => array(
					'type' => 'string'
				),
				'className' => array(
					'type' => 'string'
				)
			),
	    ),20 );

	}
	
	function lx_block_render_callback($attributes = array(), $content = ""){
		global $wpdb,$color_palette,$breakpoint,$page_devider,$page_style,$lx_lms_plugin_path,$vw_flip_plugin_path;
		ob_start();
		if(empty($attributes['lx_view_selection'])){
			$view_selection = 'List';
		} else{
			$view_selection = $attributes['lx_view_selection'];
		}
		if(empty($attributes['lx_course_selection'])){
			$lx_course_selection = 'categories';
		} else{
			$lx_course_selection = $attributes['lx_course_selection'];
		}
		if($lx_course_selection == "categories" ){			
			if(empty($attributes['lx_category_selection'])){
				echo "<div class='selection_msg' style='display:none'>Please select category to preview courses.</div>";
			} else {
				if(empty($attributes['lx_course_status'])){
					echo "<div class='selection_msg' style='display:none'>Please select course status to preview courses.</div>";
				} else if(empty($attributes['lx_course_access'])){
					echo "<div class='selection_msg' style='display:none'>Please select course access type to preview courses.</div>";
				} else{	
					get_category_content($attributes,$view_selection);
				}
			}
		} else if($lx_course_selection == "not_in_categories"){
			if(empty($attributes['lx_course_status'])){
				echo "<div class='selection_msg' style='display:none'>Please select course status to preview courses.</div>";
			} else if(empty($attributes['lx_course_access'])){
				echo "<div class='selection_msg' style='display:none'>Please select course access type to preview courses.</div>";
			} else{	
				get_course_content($attributes);
			}
		}
		$course_data = ob_get_clean();
		if( $attributes['lx_need_login'] == 'need_login' ){
			if(is_user_logged_in()){
				if(isset($course_data)){
					return $course_data;
				}
			}
		} else{
			if(isset($course_data)){
				return $course_data;
			}
		}
	}
}
if(function_exists( 'register_block_type' ))
new course_guttenberg_block();