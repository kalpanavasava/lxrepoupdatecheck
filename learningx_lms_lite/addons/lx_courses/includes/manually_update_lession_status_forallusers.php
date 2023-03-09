<?php
function ManuallyUpdateLessonStatusForAllUsers(){
	ob_start();
	global $wpdb;
	
	$allActiveUsers = $wpdb->get_results(" select user_id from ".$wpdb->prefix."usermeta where meta_key like 'user_status' and meta_value not like 'Deactive' ");echo "<pre>";
	foreach( $allActiveUsers as $activeuser ){
		$user_id = $activeuser->user_id;
		$userEnreolledCourses = $wpdb->get_results(" SELECT pm.meta_value FROM ".$wpdb->prefix."posts as p, ".$wpdb->prefix."postmeta as pm WHERE p.ID=pm.post_id and meta_key='lx_product_id' and post_author=".$user_id." and post_status='publish' ");
		
		$allEnrolledCourseIds=array();
		foreach( $userEnreolledCourses as $enrolledcourse ){
			$allEnrolledCourseIds[] = $enrolledcourse->meta_value;
		}
		
		$allLessons = $wpdb->get_results("select * from ".$wpdb->prefix."posts as p,".$wpdb->prefix."postmeta as pm where p.ID=pm.post_id and pm.meta_key='course_id' and pm.meta_value IN ".'("'.implode('","',$allEnrolledCourseIds).'")'." and p.post_status='publish' and p.post_type='lx_lessons'");
		
		
		/* $allLessons = get_posts(
			array(
				'post_type' =>'lx_lessons',
				'post_status' => 'publish',
				'meta_query' => array(
					array(
						'key' =>'course_id',
						'value' => $allEnrolledCourseIds,
						'compare' =>'IN'
					)
				)	
			)
		); */
		
		
		/* print_r($allEnrolledCourseIds); */
		
		$lessonActivityId = array();$lesid = array();
		foreach( $allLessons as $ldatas ){
			if( !empty(get_post_meta($ldatas->ID,'xapi_activity_id',true)) ){
				$lesid[get_post_meta($ldatas->ID,'xapi_activity_id',true)][] = $ldatas->ID ;
			}
		}
		
		foreach( $lesid as $key=>$data ){
			$status = array();
			$statusar = array();$stdate_array = array();$eddate_array = array();
			foreach( $data as $ldata ){
				$st = get_user_meta($user_id,'lx_lesson_progress_'.$ldata,true);
				if( !empty($st) ){
					$statusar[$ldata] = $st;
					if( $st == 'completed' ){
						$stdate_array[$ldata] = get_user_meta($user_id,'lx_lesson_progress_date_'.$ldata,true)['start_timestamp'];
						$eddate_array[$ldata] = get_user_meta($user_id,'lx_lesson_progress_date_'.$ldata,true)['end_timstamp'];
					}else{
						$stdate_array[$ldata] = get_user_meta($user_id,'lx_lesson_progress_date_'.$ldata,true)['start_timestamp'];
					}
				}
			}
			sort($stdate_array);
			if( !empty($eddate_array) ){
				sort($eddate_array);
			}
			
			
			if( !empty($statusar) ){
				foreach( $data as $ldata ){
					if( array_count_values($statusar)['completed'] > 0 ){
						if( get_user_meta($user_id,'lx_lesson_progress_'.$ldata,true) != 'completed'  ){
							update_user_meta($user_id,'lx_lesson_progress_'.$ldata,'completed');
							update_user_meta($user_id,'lx_lesson_progress_date_'.$ldata,array('start_timestamp'=>$stdate_array[0],'end_timstamp'=>$eddate_array[0]));
						}
					}
					if( array_count_values($statusar)['in_progress'] > 0 && array_count_values($statusar)['completed'] == 0 ){
						if( get_user_meta($user_id,'lx_lesson_progress_'.$ldata,true) != 'inprogress'  ){
							update_user_meta($user_id,'lx_lesson_progress_'.$ldata,'in_progress');
							update_user_meta($user_id,'lx_lesson_progress_date_'.$ldata,array('start_timestamp'=>$stdate_array[0]));
						}
					}
				}
			}
		}
	}
	
	$ob = ob_get_clean();
	return $ob;
}
add_shortcode('lessonstatusupdate','ManuallyUpdateLessonStatusForAllUsers');
