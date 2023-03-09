<?php 
global $wpdb;

$lessonActivityId = get_post_meta($_POST['lesson_id'],'xapi_activity_id',true); 

$allActiveUsers = $wpdb->get_results(" select user_id from ".$wpdb->prefix."usermeta where meta_key like 'user_status' and meta_value not like 'Deactive' ");

foreach( $allActiveUsers as $activeuser ){
	$user_id = $activeuser->user_id;
	$userEnreolledCourses = $wpdb->get_results(" SELECT pm.meta_value FROM ".$wpdb->prefix."posts as p, ".$wpdb->prefix."postmeta as pm WHERE p.ID=pm.post_id and meta_key='lx_product_id' and post_author=".$user_id." and post_status='publish' ");
	$allEnrolledCourseIds=array();
	foreach( $userEnreolledCourses as $enrolledcourse ){
		$allEnrolledCourseIds[] = $enrolledcourse->meta_value;
	}
	
	$allLessons = get_posts(
		array(
			'post_type' =>'lx_lessons',
			'post_status' => 'publish',
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' =>'course_id',
					'value' => $allEnrolledCourseIds,
					'compare' =>'IN'
				),
				array(
					'key' =>'xapi_activity_id',
					'value' => $lessonActivityId,
					'compare' =>'IN'
				) 
			)	
		)
	);
	
	$statusar = array();$stdate_array = array();$eddate_array = array();
	foreach( $allLessons as $ldata ){
		$st = get_user_meta($user_id,'lx_lesson_progress_'.$ldata->ID,true);
		if( !empty($st) ){
			$statusar[$ldata->ID] = $st;
			if( $st == 'completed' ){
				$stdate_array[$ldata->ID] = get_user_meta($user_id,'lx_lesson_progress_date_'.$ldata->ID,true)['start_timestamp'];
				$eddate_array[$ldata->ID] = get_user_meta($user_id,'lx_lesson_progress_date_'.$ldata->ID,true)['end_timstamp'];
			}else{
				$stdate_array[$ldata->ID] = get_user_meta($user_id,'lx_lesson_progress_date_'.$ldata->ID,true)['start_timestamp'];
			}
		}
	}
	
	/* array_count_values($st); */
	sort($stdate_array);
	if( !empty($eddate_array) ){
		sort($eddate_array);
	}
	if( array_count_values($statusar)['completed'] > 0 ){
		update_user_meta($user_id,'lx_lesson_progress_'.$_POST['lesson_id'],'completed');
		update_user_meta($user_id,'lx_lesson_progress_date_'.$_POST['lesson_id'],array('start_timestamp'=>$stdate_array[0],'end_timstamp'=>$eddate_array[0]));
	}
	if( array_count_values($statusar)['in_progress'] > 0 && array_count_values($statusar)['completed'] == 0 ){
		update_user_meta($user_id,'lx_lesson_progress_'.$_POST['lesson_id'],'in_progress');
		update_user_meta($user_id,'lx_lesson_progress_date_'.$_POST['lesson_id'],array('start_timestamp'=>$stdate_array[0]));
	}
}

	
