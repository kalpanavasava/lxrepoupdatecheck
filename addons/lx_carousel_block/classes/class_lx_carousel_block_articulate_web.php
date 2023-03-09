<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class articulate_web_guttenberg_block {

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
				if (  in_array('lx-articulate-web-block/lx-block',$blockname) ) {
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
		global $lx_carousel_block_urls,$lx_carousel_block_paths,$lx_plugin_urls;
		$lx_block_data = $this->lx_get_block_data();
		wp_enqueue_script(
		    'articulate_custom_blocks',
		    $lx_carousel_block_urls.'/assets/js/lx_carousel_block_articulate_web.js',
		    array('jquery', 'wp-blocks','wp-editor','wp-element')
		);
		wp_enqueue_script(
		    'custom_blocks_articulate',
		   'https://kit.fontawesome.com/e2254dd01f.js'
		);
		wp_enqueue_style(
			'my-new-block_articulate',
			'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css'
		);
		wp_enqueue_script( 'block_common_js', $lx_plugin_urls['lx_lms_lite'].'/assets/js/common.js');
		wp_enqueue_script( 'block_front_js', $lx_plugin_urls['lx_lms_lite'].'/assets/js/lx_lms_front.js'); 		
		wp_localize_script('articulate_custom_blocks','lx_block_articulate_lite', $lx_block_data);
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
			'custom_block_title'=> __("Lx - Articulate Web Carousel Block Settings"),
			'custom_block_desc'	=> __("Lx - Articulate Web Carousel Block Settings can be added here..."),
			'selection_content' => __("Articulate Web Selection"),
			'categories'=> __("Categories"),
			'category_info' => $category_info,
			'selection_title' => __("Section Title"),
			'need_login' => __("Need Login"),
			'tab_view' => __("Tab View"),
			'list_view' => __("List View"),
			'view_selection_lbl' => __("View Selection"),
			'articulate_web' => __("Articulate (Web)"),
			'open_in_page' => __("Open in Page"),
			'open_in_lightbox' => __("Open in LightBox"),
			'display_selection_lbl' => __("Display Selection"),
			'resource_type_lbl' => __("Add Resource URL/Zip Package"),
			'resource_url' => __("Resource URL"),
			'zip_package' => __("Zip Package")
		);
		return $arrayOfValues;
	}
	/* end of block_category function */
	function lx_carousel_block_course() {
	  	register_block_type( 'lx-articulate-web-block/lx-block', array(
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
				'lx_articulate_web_selection' => array(
					'type' => 'string'
				),
				'lx_community_selection' => array(
					'type' => 'string'
				),
				'lx_articulate_web_category_selection' => array(
					'type' => 'string'
				),
				'lx_articulate_web_community_selection' => array(
					'type' => 'string'
				),
				'lx_alt_web_view_selection' => array(
					'type' => 'string'
				),
				'lx_alt_web_display_selection' => array(
					'type' => 'string'
				),
				'lx_alt_web_resource_type' => array(
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
		if(isset($attributes['lx_alt_web_view_selection'])){
			$alt_view_selection = $attributes['lx_alt_web_view_selection'];
		} else{
			$alt_view_selection = 'List';
		}
		$attributes['lx_articulate_web_selection'] = 'categories';
		ob_start();
		$id = $attributes['lx_articulate_web_category_selection'];
		$open_in=$attributes['lx_alt_web_display_selection'];
		$resource_type=$attributes['lx_alt_web_resource_type'];
		if($attributes['lx_articulate_web_category_selection'] == null){
			echo  "<div class='selection_msg' style='display:none'>Please select category to preview articulate web content.</div>";
		} else if(empty($attributes['lx_alt_web_resource_type'])){
			echo  "<div class='selection_msg' style='display:none'>Please select Resource URL/Zip Package preview articulate web content.</div>";
		} else{
			get_alt_web_category_content($id,$alt_view_selection,$open_in,$resource_type);
		}
		$alt_web_category = ob_get_clean();
		
		if( $attributes['lx_need_login'] == 'need_login' ){
			if(is_user_logged_in()){		
				if(isset($alt_web_category)){
					return $alt_web_category;
				}
			}
		} else{
			if(isset($alt_web_category)){
				return $alt_web_category;
			}
		}
	}
}
if(function_exists( 'register_block_type' ))
new articulate_web_guttenberg_block();