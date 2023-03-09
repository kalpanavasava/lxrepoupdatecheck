<?php
session_start();
global $lx_plugin_paths;
include(ABSPATH.'wp-load.php');
include(ABSPATH . "wp-includes/pluggable.php"); 
$action=$_GET['action'];
switch($action){
	case 'get_token':
		include $lx_plugin_paths['lx_lms_lite'].'api/templates/get_token.php';
		exit();
		break;
	/*case 'completed':
		include  $lx_plugin_paths['lx_lms_lite'].'api/templates/fetch_completion_status.php';
		exit();
		break;
	case 'attempted':
		include  $lx_plugin_paths['lx_lms_lite'].'api/templates/fetch_attempted_module.php';
		exit();
		break;*/
	case 'registered_user':
		include  $lx_plugin_paths['lx_lms_lite'].'api/templates/fetch_register_user.php';
		exit();
		break;
	case 'joined':
	case 'removed':
	case 'inactive':
		include  $lx_plugin_paths['lx_lms_pro'].'crmapis/templates/community_activity.php';
		exit();
		break;
	case 'enrolled':
	case 'progress':
	case 'course_completed':
		include  $lx_plugin_paths['lx_lms_pro'].'crmapis/templates/course_activity.php';
		exit();
		break;
	case 'progressed':
	case 'content_completed':
		include  $lx_plugin_paths['lx_lms_pro'].'crmapis/templates/content_activity.php';
		exit();
		break;
}
?>