<?php
class include_addons{
	function __construct() {
		global $lx_plugin_paths;
		/*******Learningx LMS Courses Required Resources*******/
		require_once $lx_plugin_paths['lx_lms_lite'].'/addons/lx_courses/lx_courses.php';

		/*******Learningx LMS Articulate Content Required Resources*******/
		require_once $lx_plugin_paths['lx_lms_lite'].'/addons/lx_articulate/lx_articulate.php';

		/*******Learningx LMS S3 Storage Required Resources*******/
		require_once $lx_plugin_paths['lx_lms_lite'].'/addons/vw-flip-s3/vw-flip-s3.php';

		/*******Learningx LMS Encrypted URL's Required Resources*******/
		require_once $lx_plugin_paths['lx_lms_lite'].'/addons/base64_vw/base64_vw.php';

		/*******Learningx LMS Basic Editor Required Resources*******/
		require_once $lx_plugin_paths['lx_lms_lite'].'/addons/vw_customize_login/vw_customize_login.php';

		/*******Learningx LMS Fl1p Configuration Required Resources*******/
		require_once $lx_plugin_paths['lx_lms_lite'].'/addons/flip_learningex/flip_learningex.php';

		/*******Learningx LMS Iframe configration v1  Required Resources*******/
		require_once $lx_plugin_paths['lx_lms_lite'].'/addons/iframe_learningx/iframe_learningx.php';

		/*******Learningx LMS Iframe configration v1  Required Resources*******/
		require_once $lx_plugin_paths['lx_lms_lite'].'/addons/iframe_learningx2/iframe_learningx.php';

		/*******Learningx LMS Gutenburg block editor*******/
		require_once $lx_plugin_paths['lx_lms_lite'].'/addons/lx_carousel_block/lx_carousel_block_data.php';
		
		/*******Learningx LMS Course Poll Content*******/
		require_once $lx_plugin_paths['lx_lms_lite'].'/addons/pollcourse/pollcourse.php';
		
		/** Flip canvas **/
		require_once $lx_plugin_paths['lx_lms_lite'].'/addons/flip/flip.php';

		/** My Contetnt Page **/
		require_once $lx_plugin_paths['lx_lms_lite'].'/addons/mycontent/mycontent.php';
		
		/** Bolg Editor **/
		require_once $lx_plugin_paths['lx_lms_lite'].'/addons/lx_basic_editor/lx_basic_editor.php';
	}		
}