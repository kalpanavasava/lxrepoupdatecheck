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
	if(isset($_GET['course_title'])){
		if( empty($_GET['course_title']) && $_GET['course_title']==''){
			$return=array('status'=>400,'error'=>'Course feild is Required.');
			echo json_encode($return);
			die;
		}
		$course_title=$_GET['course_title'];
		$course=get_page_by_title($course_title,'OBJECT','lx_course');
		if(empty($course)){
			$return=array('status'=>400,'error'=>'Course not found.');
			echo json_encode($return);
			die;
		}
		$course_status=lx_course_progress($course->ID,$user->ID);
		$data=array('course_status'=>$course_status['status'],'progress'=>$course_status['percentage'].'%');
		$return=array('status'=>200,'data'=>$data);
		echo json_encode($return);
		die;
	}
	if(isset($_GET['module_title'])){
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
	}
	
}else{
	$return=array('status'=>400,'error'=>'Email feild Required.');
	echo json_encode($return);
}
?>