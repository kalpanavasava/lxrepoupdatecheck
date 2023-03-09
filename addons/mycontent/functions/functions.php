<?php
function EnrolledCoursesUI(){
	global $wpdb,$lx_plugin_paths,$lx_lms_settings;
	$user_id = get_current_user_id();
	if(!is_plugin_active(LX_LMS_PRO)){ 
		$all_courses = get_posts(
			array(
				'post_type'=>'lx_course',
				'post_status' => array('publish', 'draft'),
				'posts_per_page'=>-1,
				'meta_query'=>array(
					array(
						'key'=>'course_display',
						'value'=>'under_catgeory'
					)
				) 
			)
		);
	}else{
		$all_courses = get_posts(
			array(
				'post_type' => 'lx_course',
				'post_status' => array('publish', 'draft'),
				'posts_per_page' =>-1,
			)
		);
	}
	$enrolled_course_ids=array();
	foreach($all_courses as $course){
		if( $course->post_title != 'temp-course'){
			$course_id = $course->ID;
			$all_courseorders = get_posts(
				array(
					'post_type'=>'lx_course_order',
					'post_status'=> 'publish',
					'meta_query'=> array(
						'relation'=>'AND',
						array(
							'key'=>'lx_product_id',
							'value'=>$course_id,
							'compare'=>'='
						),
						array(
							'key'=>'lx_order_user_id',
							'value'=> get_current_user_id(),
							'compare'=>'IN'
						)
					)
				)
			);
			foreach($all_courseorders as $courseorders){
				$course_order_id = $courseorders->ID;
				$lx_product_id = get_post_meta($course_order_id,'lx_product_id',true);
				if( !empty($lx_product_id) && $lx_product_id==$course_id ){
					$enrolled_course_ids[]=$lx_product_id;
				}
			}  		
		}  		
	}
	if(!empty($enrolled_course_ids)){
		$count_courses = count($enrolled_course_ids);
		$all_enrolled_courses = get_posts(
			array(
				'post_type' => 'lx_course',
				'post_status' => array('publish','draft'),
				'post__in' => $enrolled_course_ids,
				'posts_per_page' => 6,
			)
		);
	}
?>
<div class="mt-3 courses_tab_main">
	<div class="courses_tab_inner">
		<div class="courses_head">
			<h6 class="head_h6 vw_ml-20">Enrolled Courses</h6>		
		</div>
		<?php if(!empty($all_enrolled_courses)){ ?>
			<div class="row courses_row">
			<?php
			$count=0;
			$countn=0;
			foreach($all_enrolled_courses as $course){
				if($count == 5){
					$countn = $count+1;
				}else{
					$countn = 0;
				}
				$course_id = $course->ID;
				$post_title = $course->post_title;
				$url = get_permalink($course_id);
				$thumbnail_image = get_post_meta($course_id,'lx_course_thumbnail_path',true);
				$post_status = $course->post_status;
			?>
				<div class="col-md-4 courses_info_row">
					<?php include($lx_plugin_paths['lx_lms_lite'].'template/tiles/course/style7_ui.php'); ?>
				</div>
			<?php
				$count++;
			}
			?>
			</div>
			<div class="show_more_courses_div all_courses">
			<?php if($countn == 0 || $count==$count_courses){}else{?>
					<center>
						<button class="btn_normal_state show_more_courses_btn" data-last_show="<?php echo $countn; ?>" data-total_courses="<?php echo $count_courses;?>" data-display="<?php echo 'all_courses';?>">Show More</button>
					</center>
					<center><img src="<?php echo get_stylesheet_directory_uri().'/assets/icons/spinner.gif';?>" style="width:100px; display:none;" class="spinner_forum"/></center>
				<?php
				}
				?>
			</div>
			<?php	
		}else{ ?>
			<div class="course_existance text-center">You have not enrolled in any Courses yet.</div>
		<?php	
		}
		?>
	</div>
</div>
<?php
}
function AdditionalResources(){
	global $wpdb,$lx_plugin_paths,$lexicon;
	$user_id = get_current_user_id();
	$additionalResources = get_posts(
		array(
			'post_type' => 'lx_articulate',
			'author' => $user_id,
			'posts_per_page' => -1,
			'post_status' => array('publish','draft'),
		)
	);
	if( !empty( $additionalResources ) ){
		
		$articulate_heading = $lexicon['lexicon_additional_resources'];
		if( empty($articulate_heading) ){
			$articulate_heading = 'Additional Resources';
		}
		?>
		<div class="articulate_heading mt-4">
			<h6 class="head_h6 vw_ml-20"><?php echo $articulate_heading; ?></h6>		
		</div>
		<div class="row articulate_contents_row">
		<?php
		foreach( $additionalResources as $data ){
			$artiid = $data->ID;
			$post_title = $data->post_title;
			$post_status = $data->post_status;
			$url = get_permalink($artiid);
			$thumbnail_image = get_post_meta($artiid,'articulate_web_thumb',true);
			?>
			<div class="col-md-4 articulate_info">
				<?php include($lx_plugin_paths['lx_lms_lite'].'template/tiles/articulate/style7_ui.php'); ?>
			</div>
			<?php
		}
		?>
		</div>
		<?php
	}
}
function CoursesContentUI(){
	global $wpdb,$lx_plugin_paths;
	$user_id = get_current_user_id();
	if(!is_plugin_active(LX_LMS_PRO)){ 
		$all_courses = get_posts(
			array(
				'post_type'=>'lx_course',
				'author' => $user_id,
				'post_status' => array('publish', 'draft'),
				'posts_per_page'=>-1,
				'meta_query'=>array(
					array(
						'key'=>'course_display',
						'value'=>'under_catgeory'
					)
				)
			)
		);
	}else{
		$all_courses = get_posts(
			array(
				'post_type' => 'lx_course',
				'author' => $user_id,
				'post_status' => array('publish', 'draft'),
				'posts_per_page' => -1
			)
		);
	}
	
	$get_user_membership = $wpdb->get_results("select * from ".$wpdb->prefix."mepr_members where user_id='".$user_id."'");
	$user_memberships = $get_user_membership[0]->memberships;
	if(!empty($user_memberships)){
		$user_membership_ids = explode(',',$user_memberships);
		$community_ids = array();
		foreach( $user_membership_ids as $cid ){
			$community_ids[] = $cid;
		}
	}
	if(!empty($community_ids)){
		$args = array(
			'post_type' => 'memberpressproduct',
			'author' => $user_id,
			'post_status' => array('publish','draft'),
			'post__in' => $community_ids,
			'posts_per_page' => -1
		);
		$all_communities = get_posts($args);
	}
	if(!empty($all_courses)){	
?>
<div class="mt-4 manage_content_tab_main">
	<div class="manage_content_tab_inner">
	<?php if(!is_plugin_active(LX_LMS_PRO) || empty($all_communities)){ ?>
		<div class="manage_content_main_head">
			<h4 class="head_h4">Content I Own or Manage</h4>		
		</div>
	<?php
		}	 
	?>
		<div class="row mt-4">
			<div class="col-md-7">
				<div class="">
					<h6 class="head_h6 desk_txt">Courses</h6>
				</div>
			</div>
			<div class="col-md-1">
				<div class="desk_txt"><b>Enrolled</div></b>
			</div>
			<div class="col-md-1">
				<div class="desk_txt"><b>Completed</div></b>
			</div>
			<div class="col-md-2">
				<div class="desk_txt"><b>In-active</div></b>
			</div>
		</div><hr>
		<?php
		foreach($all_courses as $course){
			$course_id = $course->ID;
			$post_id = $course_id;
			$post_title = $course->post_title;
			$sub_title = get_post_meta($post_id,'lx_course_subtitle',true);
			$thumbnail_image = get_post_meta($post_id,'lx_course_thumbnail_path',true);
			$post_status = $course->post_status;
		?>
		<div class="row">
			<h6 class="head_h6 mb_txt vw_mll-20">Courses</h6>
			<div class="col-md-4">
				<?php
				include($lx_plugin_paths['lx_lms_lite'].'template/tiles/community/styleX_ui.php');
				?>
			</div>
			<div class="col-md-3 d-flex vw_ml-10 btn_margin_top">
				<div class="course_edit_btn_div">
					<form action="<?php echo site_url().'/create-courses/';?>" method="post">
						<input type="hidden" name="edit_course_id" value="<?php echo $post_id;?>">
						<button type="submit" class="btn_normal_state btn_courses_edit" style="padding-left: 35px; padding-right:35px;">Edit</button>
					</form>
					<?php if( $post_status == 'draft' ){?>
						<small class="content_draft_status">Draft</small>
					<?php	
					}
					?>
				</div>
				<div>
					<a href="<?php echo get_permalink($post_id); ?>">
						<button class="btn_normal_state btn_courses_view" style="padding-left:35px; padding-right:35px;">View</button>
					</a>
				</div>
			</div>
			<?php CoursesActivity($course_id);?>
		</div><hr>		
		<?php
		}	
		?>
	</div>		
</div>	
<?php	
	}
}
function CoursesActivity($course_id){
	global $wpdb,$lx_lms_settings;
	$course_enrolled_users = "enrolled";
	$course_completed_users = "completed";
	$course_inactive_users = "inactive";
	$course_display = get_post_meta($course_id,'course_display',true);
	$all_membership = $wpdb->get_results("select * from ".$wpdb->prefix."mepr_members");
	$all_users_data = $wpdb->get_results("select * from ".$wpdb->prefix."users");
	if($course_enrolled_users == "enrolled"){
		$all_courseorders = get_posts(
			array(
				'post_type'=>'lx_course_order',
				'post_status'=> 'publish',
				'meta_query'=> array(
					'relation'=>'AND',
					array(
						'key'=>'lx_product_id',
						'value'=>$course_id,
						'compare'=>'='
					)
				)
			)
		);
		$all_enrolled_users=array();
		foreach($all_courseorders as $courseorders){
			$course_order_id = $courseorders->ID;
			$lx_order_user_id = get_post_meta($course_order_id,'lx_order_user_id',true);
			if( !empty($lx_order_user_id) ){
				$all_enrolled_users[$lx_order_user_id]=$lx_order_user_id;
			}
		}  	
		if(!empty($all_enrolled_users)){
			$total_enrolled_users=count($all_enrolled_users);
		}
	}
	if($course_inactive_users == "inactive"){
		$all_inactive_users=array();
		if($course_display=='in_community'){
			$community_id=get_post_meta($course_id,'community_id',true);
			$all_users=array();
			$total_active=array();
			$total_inactive=array();
			$active_days=$lx_lms_settings['active_learner_time_period'];
			foreach($all_membership as $memberships_data){
				$memberships=explode(',',$memberships_data->memberships);
				if(in_array($community_id,$memberships)){
					$all_users[]=$memberships_data->user_id;
				}
			}
			$course_content = get_posts(
				array(
					'post_type'=>'lx_lessons',
					'post_status' => array('publish', 'draft'),
					'posts_per_page'=>-1,
					'meta_query'=>array(
						array(
							'key'=>'course_id',
							'value'=>$course_id,
							'compare'=>'='
						)
					)
				)
			);
			if(!empty($course_content)){
				foreach($all_users as $user_id){
					foreach($course_content as $lesson_data){
						$lesson_id = $lesson_data->ID;
						$min60 = strtotime( date('Y-m-d', strtotime("-".$active_days." days")) );
						$lesson_time_stamp = get_user_meta($user_id,'lesson_last_accessed_'.$lesson_id,true);
						if($min60 > $lesson_time_stamp && !empty($lesson_time_stamp)){
							$total_inactive[$user_id]=$user_id;
						}else{
							$total_active[$user_id]=$user_id;
						}
					}
				}
			}
			if(!empty($total_inactive)){
				if(!in_array($total_inactive,$total_active)){
					$all_inactive_users[] = $total_inactive[$user_id];
				}
			} 	
		}
		if(!empty($all_inactive_users)){
			$total_inactive_users=count($all_inactive_users);
		} 
	} 
	if( $course_completed_users == "completed" ){
		$all_course_completed_user=array();$completed_user=array();
		if($course_display=='in_community'){
			$community_id=get_post_meta($course_id,'community_id',true);
			$user_ids=array();
			foreach($all_membership as $memberships_data){
				$memberships=explode(',',$memberships_data->memberships);
				if(in_array($community_id,$memberships)){
					$user_ids[]=$memberships_data->user_id;
				}
			}	
			$course_content = get_posts(
				array(
					'post_type'=>'lx_lessons',
					'post_status' => array('publish', 'draft'),
					'posts_per_page'=>-1,
					'meta_query'=>array(
						array(
							'key'=>'course_id',
							'value'=>$course_id,
							'compare'=>'='
						)
					)
				)
			);
			if(!empty($course_content)){
				$total_course_content = count($course_content);
				foreach($course_content as $lesson_data){
					foreach($user_ids as $user_id){
						$lesson_id = $lesson_data->ID;
						$progress=lx_lesson_progress($lesson_id,$user_id);
						if($progress['status']=='Completed'){
							$completed_user[$user_id][] = 1;
						}
					}
					foreach($completed_user as $key => $value ){ 
						$count=count($completed_user[$key]);
						if($total_course_content == $count){
							$all_course_completed_user[]=1;
						}
					}
				}
			}
		}else{
			$course_content = get_posts(
				array(
					'post_type'=>'lx_lessons',
					'post_status' => array('publish', 'draft'),
					'posts_per_page'=>-1,
					'meta_query'=>array(
						array(
							'key'=>'course_id',
							'value'=>$course_id,
							'compare'=>'='
						)
					)
				)
			);
			if(!empty($course_content)){
				$total_course_content = count($course_content);
				foreach($course_content as $lesson_data){
					foreach($all_users_data as $user){
						$user_id = $user->ID;
						$lesson_id = $lesson_data->ID;
						$progress=lx_lesson_progress($lesson_id,$user_id);
						if($progress['status']=='Completed'){
							$completed_user[$user_id][] = 1;
						}
					}
					foreach($completed_user as $key => $value ){ 
						$count=count($completed_user[$key]);
						if($total_course_content == $count){
							$all_course_completed_user[]=1;
						}
					}
				}
			}
		} 
		if(!empty($all_course_completed_user)){
			$total_course_completed_users = count($all_course_completed_user);
		}
	}
	?>
	<div class="col-md-1">
		<span class="mb_txt vw_ml-20"><b>Enrolled : </b></span>
		<h6 class="head_h6">
		<?php if(!empty($total_enrolled_users)){
			echo "&nbsp;".$total_enrolled_users;
		}else{
			echo "&nbsp;".'N/A';
		}	
		?>
		</h6>
	</div>
	<div class="col-md-1">
		<span class="mb_txt vw_ml-20"><b>Completed : </b></span>
		<h6 class="head_h6">
		<?php
		if(!empty($total_course_completed_users)){
			echo "&nbsp;".$total_course_completed_users;
		}else{
			echo "&nbsp;".'N/A';
		}
		?>
		</h6>
	</div>
	<div class="col-md-2">
		<span class="mb_txt vw_ml-20"><b>In-active : </b></span>
		<h6 class="head_h6">
		<?php if(!empty($total_inactive_users)){
			echo "&nbsp;".$total_inactive_users;
		}else{
			echo "&nbsp;".'N/A';
		}	
		?>
		</h6>
	</div>
	<?php	
}
function Fl1plistsContentUI(){
	global $wpdb,$lx_plugin_paths;
	$user_id = get_current_user_id();
	if(!is_plugin_active(LX_LMS_PRO)){ 
		$all_fliplists = get_posts(
			array(
				'post_type' => 'flip_list',
				'post_status' => array('publish', 'draft'),
				'author' => $user_id,
				'posts_per_page' => -1,
				'meta_query'=>array(
					array(
						'key'=>'display_in',
						'value'=>'under_catgeory',
						'compare'=>'='
					),
				)
			)
		);
	}else{
		$all_fliplists = get_posts(
			array(
				'post_type' => 'flip_list',
				'post_status' => array('publish', 'draft'),
				'author' => $user_id,
				'posts_per_page' => -1,
				'meta_query'=>array(
					'relation' => 'OR',
					array(
						'key'=>'display_in',
						'value'=>'under_catgeory',
						'compare'=>'='
					),
					array(
						'key'=>'display_in',
						'value'=>'in_community',
						'compare'=>'='
					)
				)
			)
		);
	}
	if(!empty($all_fliplists) && !current_user_can('subscriber')){	
?>
<div class="mt-4 flip_content_tab_main">
	<div class="flip_content_tab_inner">
		<div class=" flip_content_head">
			<h6 class="head_h6">
				<img class="flip_content_flips_logo" src="<?php echo get_stylesheet_directory_uri().'/assets/icons/flips_logo.png';?>">
			</h6>		
		</div>
		<div class="row">
			<div class="col-md-7">
				<div class="">
					<h6 class="head_h6 desk_txt">My Fl1plists</h6>
				</div>
			</div>
			<div class="col-md-3">
				<h6 class="head_h6 desk_txt">Date Created</h6>
			</div>
		</div><hr>
		<?php
		foreach($all_fliplists as $fliplist){
			$fliplist_id = $fliplist->ID;
			$post_id = $fliplist_id;
			$post_title = $fliplist->post_title;
			$sub_title = get_post_meta($post_id,'fliplist_subtitle',true);
			$fliplist_image = get_post_meta($post_id,'fliplist_cropped_thumb',true);
			$thumbnail_image = $fliplist_image;
			$post_date = $fliplist->post_date;
			$post_status = $fliplist->post_status;
			
			if( $post_title != 'temp-fliplist' ){
			?>
			<div class="row">
				<h6 class="head_h6 mb_txt vw_mll-20">My Fl1plists</h6>
				<div class="col-md-4">
					<?php
					include($lx_plugin_paths['lx_lms_lite'].'template/tiles/community/styleX_ui.php');
					?>
				</div>
				<div class="col-md-3 d-flex vw_ml-10 btn_margin_top">
					<div class="fliplist_edit_btn_div">
						<form action="<?php echo site_url().'/create-fl1plist/';?>" method="post">
							<input type="hidden" name="fliplist_id" value="<?php echo $post_id;?>">
							<button type="submit" class="btn_normal_state btn_fliplists_edit" style=" padding-left: 35px; padding-right: 35px;">Edit</button>
						</form>
						<?php if( $post_status == 'draft'){?>
							<small class="content_draft_status">Draft</small>
						<?php	
						}
						?>
					</div>
					<div>
						<a href="<?php echo get_permalink($post_id); ?>">
							<button class="btn_normal_state btn_fliplists_view" style=" padding-left: 35px; padding-right: 35px;">View</button>
						</a>
					</div>
				</div>
				
				<div class="col-md-3">
					<h6 class="head_h6 mb_txt vw_ml-10">Date Created :</h6>
					<h6 class="head_h6"><?php echo '&nbsp;'.$post_date; ?></h6>
				</div>
			</div><hr>
			<?php
			}
		}
		?>
	</div>
</div>
<?php
	}
}
function Fl1pRecordingContentUI(){
	global $wpdb,$lx_plugin_paths;
	$user_id = get_current_user_id();
	$all_flip_recording = get_posts(
		array(
			'post_type' => 'flip_recording',
			'post_status' => array('publish', 'draft'),
			'author' => $user_id,
			'posts_per_page' => -1,
			'meta_query' =>array(
				array(
					'key' => 'parent_recording_id',
					'compare' => 'NOT EXISTS'
				)
			)
		)
	);
	if(!is_plugin_active(LX_LMS_PRO)){ 
		$flip_lists = get_posts(
			array(
				'post_type' => 'flip_list',
				'post_status' => array('publish', 'draft'),
				'author' => $user_id,
				'posts_per_page' => -1,
				'meta_query'=>array(
					array(
						'key'=>'display_in',
						'value'=>'under_catgeory',
						'compare'=>'='
					),
				)
			)
		);
	}else{
		$flip_lists = get_posts(
			array(
				'post_type' => 'flip_list',
				'post_status' => array('publish', 'draft'),
				'author' => $user_id,
				'posts_per_page' => -1,
				'meta_query'=>array(
					'relation' => 'OR',
					array(
						'key'=>'display_in',
						'value'=>'under_catgeory',
						'compare'=>'='
					),
					array(
						'key'=>'display_in',
						'value'=>'in_community',
						'compare'=>'='
					)
				)
			)
		);
	}
	if(!empty($all_flip_recording)){
	?>
<div class="mt-4 flip_content_tab_main">
	<div class="flip_content_tab_inner">
		<?php if(empty($flip_lists)) { ?>
		<div class="flip_content_head">
			<h6 class="head_h6">
				<img class="flip_content_flips_logo" src="<?php echo get_stylesheet_directory_uri().'/assets/icons/flips_logo.png';?>">
			</h6>		
		</div>
		<?php	
		}
		?>
		<div class="row mt-4">
			<div class="col-md-7">
				<div class="">
					<h6 class="head_h6 desk_txt">My Fl1p Recordings</h6>
				</div>
			</div>
			<div class="col-md-3">
				<h6 class="head_h6 desk_txt">Date Created</h6>
			</div>
		</div><hr>
		<?php
		foreach($all_flip_recording as $flip_recording){
			$recording_id = $flip_recording->ID;
			$post_id = $recording_id;
			$post_title = $flip_recording->post_title;
			$sub_title = get_post_meta($post_id,'subtitle',true);
			$post_date = $flip_recording->post_date;
			$post_status = $flip_recording->post_status;
			if( $post_title != 'temp-recording' ){
			?>
			<div class="row">
				<h6 class="head_h6 mb_txt vw_mll-20">My Fl1p Recordings</h6>
				<div class="col-md-4">
					<?php
					include($lx_plugin_paths['lx_lms_lite'].'template/tiles/community/styleX_ui.php');
					?>
				</div>
				<div class="col-md-3 d-flex vw_ml-10 btn_margin_top">
					<div class="recording_edit_btn_div">
						<form action="<?php echo site_url().'/create-fl1p-recording/';?>" method="post">
							<input type="hidden" name="recording_id" value="<?php echo $post_id;?>">
							<button type="submit" class="btn_normal_state btn_recordings_edit" style=" padding-left: 35px; padding-right: 35px;">Edit</button>
						</form>
						<?php if( $post_status == 'draft'){?>
							<small class="content_draft_status">Draft</small>
						<?php	
						}
						?>
					</div>
					<div>
						<a href="<?php echo get_permalink($post_id); ?>">
							<button class="btn_normal_state btn_recordings_view" style=" padding-left: 35px; padding-right: 35px;">View</button>
						</a>
					</div>
				</div>
				<div class="col-md-3">
					<h6 class="head_h6 mb_txt vw_ml-10">Date Created :</h6>
					<h6 class="head_h6"><?php echo '&nbsp;'.$post_date; ?></h6>
				</div>
			</div><hr>		
			<?php
			}
		}
		?>
	</div>		
</div>
	<?php
	}
}