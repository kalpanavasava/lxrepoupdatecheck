<?php
class ClassMyContentAjaxLite{
	public function __construct(){
		/** Show More Courses **/
		add_action('wp_ajax_ShowMoreCourses',array($this,'ShowMoreCourses'));
		add_action( 'wp_ajax_nopriv_ShowMoreCourses',array($this,'ShowMoreCourses'));
	}
	public function ShowMoreCourses(){
		global $wpdb,$lx_plugin_paths,$lx_lms_settings;
		$user_id = get_current_user_id();
		$last_show = $_POST['last_show'];
		$display = $_POST['display'];
		$total_courses = $_POST['total_courses'];
		
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
		$all_enrolled_courses = get_posts(
			array(
				'post_type' => 'lx_course',
				'post_status' => array('publish','draft'),
				'post__in' => $enrolled_course_ids,
				'posts_per_page' => 6,
				'offset'=>$last_show,
			)
		);
		?>
		<div class="row courses_row">
		<?php
			$count = $last_show;
			foreach($all_enrolled_courses as $course){
				if($count == $last_show+5){
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
		<?php
		if($countn==0 || $count==$total_courses){}else{
		?>
			<center>
				<button class="btn_normal_state show_more_courses_btn" data-last_show="<?php echo $countn; ?>" data-total_courses="<?php echo $total_courses;?>" data-display="<?php echo 'all_courses';?>" >Show More</button>
			</center>
		<?php
		}
		die();
	}
	
}