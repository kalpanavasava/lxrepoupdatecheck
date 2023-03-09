<?php
class lx_courses_main{
	public function __construct() {
		include( dirname( __FILE__ ) . '/class_lx_course_post_types.php' );
		$lx_course_pt = new lx_course_post_types();
    }
}