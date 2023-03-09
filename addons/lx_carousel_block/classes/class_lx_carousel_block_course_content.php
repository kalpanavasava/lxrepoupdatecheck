<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class course_content_guttenberg_block{
	function __construct(){
		/*Register Block*/
		add_action('init', array($this, 'lx_register_content_blocks'),10 );
		add_action( 'enqueue_block_editor_assets', array( $this, 'lx_register_content_editor_assets' ),10 );
		if(isset($_GET['post'])){
			$post = get_post($_GET['post']); 
			if ( has_blocks( $post->post_content ) ) {
				$blocks = parse_blocks( $post->post_content );
				$blockname=array();
				foreach($blocks as $key=>$value){
					
					$blockname[]=$value['blockName'];
				}
				if (  in_array('lx-course-content-block/lx-block',$blockname) ) {
					add_action('admin_head',array( $this, 'lx_content_block_custom_css' ),10 );
				}
			}
		}
	}

	function lx_content_block_custom_css(){
		global $lx_carousel_block_urls,$lx_carousel_block_paths,$vw_flip_plugin_path,$lx_plugin_paths;
		include($lx_plugin_paths['lx_lms_lite'].'assets/css/lms_user_interface_settings.php');
		include($lx_carousel_block_paths.'assets/css/lx_carousel_block.php');
	}
	function lx_register_content_blocks(){
		register_block_type( 'lx-course-content-block/lx-block', array(
	        'render_callback' => array($this,'lx_content_block_render_callback'),
	        'attributes'=>array(
	        	'lx_course_selection' => array(
					'type' => 'string'
				), 
				'lx_content_open_in'=>array(
					'type'=>'string'
				),
				'lx_login_required' => array(
					'type' => 'string'
				)
	        )
	    ) );
	}

	function lx_register_content_editor_assets(){
		global $lx_carousel_block_urls,$lx_carousel_block_paths,$lx_plugin_urls,$kit_code;
		$lx_content_block_data = $this->lx_get_content_block_data();
		wp_enqueue_script(
		    'course_content_blocks_js',
		    $lx_carousel_block_urls.'/assets/js/lx_carousel_block_course_content.js',
		    array('jquery', 'wp-blocks','wp-editor','wp-element')
		);
		  wp_enqueue_script(
		  'custom_blocks2',
		   'https://kit.fontawesome.com/'.$kit_code.'.js'
		);
		wp_enqueue_style(
			'my-new-block2',
			'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css'
		);
		wp_enqueue_script( 'block_common_js', $lx_plugin_urls['lx_lms_lite'].'/assets/js/common.js');
		wp_enqueue_script( 'block_front_js', $lx_plugin_urls['lx_lms_lite'].'/assets/js/lx_lms_front.js'); 		
		wp_localize_script('course_content_blocks_js','content_block_data', $lx_content_block_data);
	}

	function lx_get_content_block_data(){
		$course_info=array();
		if(function_exists('fetch_course_content_block_data_pro')){
			$array=fetch_course_content_block_data_pro();
		}else{
			$array=array(
				'post_type'=>'lx_course',
				'posts_per_page'=>-1,
				'post_status'=>'publish',
				'meta_query' => array(
				    array(
				     'key' => 'community_id',
				     'compare' => 'NOT EXISTS'
				    )
				)
			);
		}
		$get_courses=get_posts($array);
		if(!empty($get_courses)){
			foreach ($get_courses as $course) {
				$course_info[$course->ID]=$course->post_title;
			}
		}
		$arrayOfValues = array(
			'content_block_title'=> __("Lx - Course Content Carousel Block Settings"),
			'content_block_desc'	=> __("Lx - Course Content Carousel Block Settings can be added here..."),
			'selection_content' => __("Course Content Selection"),
			'course_info' => $course_info,
			'open_in_page' => __("Open in Page"),
			'open_in_lightbox' => __("Open in LightBox"),
			'display_selection_lbl' => __("Display Selection"),
			'login_need' => __("Need Login")
		);
		return $arrayOfValues;
	}
	function lx_content_block_render_callback($attributes = array(), $content = ""){
		ob_start();
		if(empty($attributes['lx_course_selection'])){
				echo "<div class='selection_msg' style='display:none'>Please select course to preview course content.</div>";
		}else{
			get_course_content_block_data($attributes);
		}
		$op=ob_get_clean();
		return $op;
	}
}
if(function_exists( 'register_block_type' ))
new course_content_guttenberg_block();