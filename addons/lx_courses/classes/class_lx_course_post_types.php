<?php
class lx_course_post_types{
	
	public function __construct() {
		add_action( 'init', array( $this , 'lx_courses_pt_course' ) );
		add_action( 'init', array( $this , 'lx_courses_pt_lessson' ) );
		add_action( 'init', array( $this , 'lx_courses_order' ) );
		add_action( 'admin_menu', array( $this , 'lx_course_remove_addnew_from_coursepost_type' ) );
		add_filter('single_template', array( $this , 'lx_course_template' ) );
		add_action('wp_head',array($this,'enqueue_lesson_style'));
		add_action('wp_head',array($this,'add_course_css'));
    }
	/** function for register lx-course type **/
	public function lx_courses_pt_course() {
 
		register_post_type( 'lx_course',
			array(
				'labels' => array(
					'name' => __( 'Lx Courses' ),
					'singular_name' => __( 'Lx Courses' )
				),
				'public' => true,
				'has_archive' => true,

				'rewrite' => array('slug' => 'courses'),
				'taxonomies' => array('category')
			)
		);
	}
	/** function for register lx-lessons type **/
	public function lx_courses_pt_lessson() {
		register_post_type( 'lx_lessons',
			array(
					'labels' => array(
						'name' => __( 'Lx Lessons' ),
						'singular_name' => __( 'Lx Lessons' ),
						'show_in_rest' => false,
					),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'lessons'),
			'show_in_menu' => 'edit.php?post_type=lx_course',
			'taxonomies' => array('category')
			)
		);
	}
	/** function for register lx-order type **/
	public function lx_courses_order() {
		register_post_type( 'lx_course_order',
			array(
					'labels' => array(
						'name' => __( 'Lx Course Order' ),
						'singular_name' => __( 'Lx Order' ),
						'show_in_rest' => false,
					),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'lx_order'),
			'show_in_menu' => 'edit.php?post_type=lx_course',
			'taxonomies' => array('category')
			)
		);
	}
	/** function for remove add new option in lx-course type **/
	public function lx_course_remove_addnew_from_coursepost_type(){
		 global $submenu;
		 unset($submenu['edit.php?post_type=lx_course'][10]);
	}
	/** function for course template **/
	public function lx_course_template( $template ) {
		global $post;
		if ($post->post_type == 'lx_course' ) {
			$template = dirname(dirname(__FILE__)) . '/template/single-lx_course.php';
		}
		if ($post->post_type == 'lx_lessons' ) {
			$template = dirname(dirname(__FILE__)) . '/template/single-lx_lesson.php';
		}
		return $template;
	}
	/** function for add or enqueue lession style **/
	public function enqueue_lesson_style(){
		global $post,$lx_lms_course_path;
		if($post->post_type=='lx_lessons')
		{
			include($lx_lms_course_path.'/css/lx_lesson_css.php');
		}
	}
	/** function for add or enqueue course style **/
	public function add_course_css()
	{
		global $post,$lx_lms_course_path;
		if( $post->post_type=="lx_course" ){
			include($lx_lms_course_path.'/css/course.php');
		}
	}
}