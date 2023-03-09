<?php 
include 'validate_token.php';
if(isset($_GET['email']) && !empty($_GET['email']) && $_GET['email']!=''){
	$user_email=urldecode($_GET['email']);
	$user=get_user_by('email',$user_email);
	if(!username_exists($user->user_login)){
		$return=array('status'=>400,'error'=>'User is not registered.');
		echo json_encode($return);
		die;
	}
	if(isset($_GET['module_title']) && empty($_GET['module_title']) && $_GET['module_title']==''){
		$return=array('status'=>400,'error'=>'Module title is required.');
		echo json_encode($return);
		die;
	}
	$module_title=$_GET['module_title'];
	$module=get_page_by_title($module_title,'OBJECT','lx_lessons');
	if(empty($module)){
		$return=array('status'=>400,'error'=>'Module not found.');
		echo json_encode($return);
		die;
	}
	$progress=lx_lesson_progress($module->ID,$user->ID);
	$return=array('status'=>200,'data'=>array('module_status'=>$progress['status']));
	echo json_encode($return);
	die;
}else{
	$return=array('status'=>400,'error'=>'Email field is required.');
	echo json_encode($return);
	die;
}
?>