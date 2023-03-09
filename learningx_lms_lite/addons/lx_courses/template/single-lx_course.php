<?php
	/* single page for display course information */
	if ( ! defined( 'ABSPATH' ) ) {
		exit; 
	}

	global $post,$square_icon,$color_palette,$lx_plugin_urls,$wpdb,$font_family,$lx_lms_settings;
	$is_loggedin=is_user_logged_in();
	$user = new WP_User( get_current_user_id() );
	$user_roles = $user->roles[0];
	$categories = get_the_category();
	if(!empty($categories)){
		$cat_parent_id=$categories[0]->category_parent;
		$category_parent = get_term( $cat_parent_id, 'category' );
		$cat_parent_slug = $category_parent->slug;
	}
	$course_progress=lx_course_progress($post->ID);
	$post_id = get_the_ID();
	update_user_meta(get_current_user_id(),'course_last_accessed_'.$post->ID,time());
	get_header(); 
	if ( have_posts() ) : the_post();
	if(function_exists('course_page_attach_info')){
		$var = course_page_attach_info($post->ID);
	} else{
		$var = 1;
	}
	$lessons = get_lessons(get_the_ID());
	$course_timestamp_info = get_user_meta( get_current_user_id(),'course_last_accessed_'.get_the_ID() )[0];
	$last_activity_timestamp = array();
	if(!empty($lessons)){
		foreach($lessons as $lessons_info){
			$lessons_timestamp_info = get_user_meta( get_current_user_id(),'lx_lesson_progress_date_'.$lessons_info->ID )[0];
			
			$content_type = get_post_meta($lessons_info->ID,'content_type',true);
			$lessonActivityId = get_post_meta($lessons_info->ID,'xapi_activity_id',true); 
			if($content_type!='' && $content_type == 'poll'){
				$lessons_timestamp_info = get_user_meta( get_current_user_id(),'lx_lesson_progress_date_'.$lessons_info->ID )[0];
			}else{
				$lessons_timestamp_info = get_user_meta( get_current_user_id(),'lx_lesson_progress_date_'.$lessonActivityId )[0];
			}
			
			if(!empty($lessons_timestamp_info)){
				if(empty($lessons_timestamp_info['end_timstamp'])){
					if(!empty($lessons_timestamp_info['start_timestamp'])){
						$last_activity_timestamp = array($lessons_timestamp_info['start_timestamp']);
					}
				} else{
					$last_activity_timestamp = array($lessons_timestamp_info['end_timstamp']);
				}
			} else{
				$last_activity_timestamp = '';
			}
		}
		if(!empty($last_activity_timestamp)){
			$last_activity = date('d-m-Y H:i:s',(max($last_activity_timestamp)));
		} else{
			$last_activity_timestamp = $course_timestamp_info;
			$last_activity = date('d-m-Y H:i:s',$last_activity_timestamp);
		}
	} else if(empty($lessons)){
		$last_activity_timestamp = $course_timestamp_info;
		$last_activity = date('d-m-Y H:i:s',$last_activity_timestamp);
	}
	
	if( empty(strtotime($last_activity)) ){
		$last_activity = "<strong>None</strong>";
	}
	$user=get_user_by('id',get_current_user_ID());
	$user_email=$user->user_email;
	$lx_course_summary = get_post_meta( $post_id,'lx_course_summary')[0];
	$lx_course_outcomes = get_post_meta( $post_id,'lx_course_outcomes')[0];
	$lx_course_requirements = get_post_meta( $post_id,'lx_course_requirements')[0];
	$macro_course_id = get_post_meta( $post_id,'lx_associated_macro_course')[0];
	if($macro_course_id != 0 && !empty($macro_course_id)){
		$meta_query=array(
			'relation'=>'AND',
			array(
				'key'=>'lx_associated_macro_course',
				'value'=>$macro_course_id,
				'compare'=>'='
			)
		);
		$check_other_modules = get_posts(
			array(
				'post__not_in'=>array($post->ID),
				'post_type'=>'lx_course',
				'posts_per_page' => -1,
				'post_satus'=>'publish',
				'meta_query'=>$meta_query
			)
		);
	}
	/* push content in tab array */
	$tab_title = array();
	$tab_content = array();
	if(!empty($lx_course_summary)){
		array_push($tab_title ,"Summary");
		array_push($tab_content,$lx_course_summary);
	}
	if(!empty($lx_course_outcomes)){
		array_push($tab_title,"Outcomes");
		array_push($tab_content,$lx_course_outcomes);
	}
	if(!empty($lx_course_requirements)){
		array_push($tab_title,"Requirements");
		array_push($tab_content,$lx_course_requirements);
	}
	if($macro_course_id == 0 || empty($macro_course_id)){
		$class_other_tab_description = 'col-sm-10';
	}else{
		$class_other_tab_description = 'col-sm-6';
	}
	
	/* Enrolled Free Courses */
	if(is_user_logged_in()){
		$course_id = $post->ID;
		$course_purchasing_settings = $lx_lms_settings['course_purchasing_settings'];
		$course_currency_symbol = $lx_lms_settings['course_currency_symbol'];
		$course_feechk = get_post_meta($course_id,'lx_course_feechk',true);
		$coursecost = get_post_meta( $course_id,'lx_course_cost',true);
		$enrollcoursetitle = get_post($course_id)->post_title .' '.'Enrolled'.' '.get_current_user_ID();
		if($course_purchasing_settings == 'on' && !empty($course_currency_symbol) && $course_feechk == 'on' && ($coursecost !='' || $coursecost !=0)){
		}else{
			freecourseenrolled( $course_id, 0, $user_id );
			$meta_query=array(
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
				),
			);
			$args_array = array(
				'post_type'=>'lx_course_order',
				'author' => get_current_user_ID(),
				'posts_per_page' => -1,
				'post_status'=> 'publish',
				'meta_query'=>$meta_query
			);
			$free_courseorder_existance = get_posts($args_array);
			$purchasable_courseorder = check_lx_course_order_exists($course_id,get_current_user_id());
			if( empty($free_courseorder_existance) && empty($purchasable_courseorder) ){
				$args_array['post_title'] = $enrollcoursetitle; 
				$order_id = wp_insert_post($args_array);
				update_post_meta($order_id,'lx_product_id',$course_id);
				update_post_meta($order_id,'lx_order_user_id',get_current_user_ID()); 
				update_post_meta($order_id,'lx_trans_date',date("d-m-Y"));  
			}  
		}
	}
?>
<script>
	var learning_locker = {'endpoint':"<?php echo $learning_locker_setting['end_point'];?>",'auth_key':"<?php echo $learning_locker_setting['auth_key'];?>",'auth_secret':"<?php echo $learning_locker_setting['auth_secret'];?>"}
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
<script src="<?php echo plugin_dir_url(dirname(__FILE__)).'js/xapijs/xapi2.js';?>"></script>
<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)).'js/xapijs/xapiwrapper.js';?>"></script>
<input type="hidden" id="mailto" value="<?php echo $user_email;?>">
<input type="hidden" id="vw_user_id" value="<?php echo $user_id;?>">
<input type="hidden" id="vw_course_id" value="<?php echo get_the_ID();?>">
<div class="lp-screen" style="display:none;"><span>
	<img class="user_interface_loader_img" src="<?php echo get_stylesheet_directory_uri().'/assets/loader/05.svg'?>">
</div>
<?php
foreach( $lessons as $lessons_data ){
	$content_type = get_post_meta($lessons_data->ID,'content_type',true);
	if($content_type!='' && $content_type == 'poll'){
		$lessonStatus = get_user_meta(get_current_user_ID(),'lx_lesson_progress_'.$lessons_data->ID,true);
	}else{
		$activity_id = get_post_meta($lessons_data->ID,'xapi_activity_id',true);
		$lessonStatus = get_user_meta(get_current_user_ID(),'lx_lesson_progress_'.$activity_id,true);
		if( $lessonStatus == 'in_progress' ){
			?>
			<input type="hidden" class="lx_allesson_id tilelboxlessonid" id="lx_allesson_id" value="<?php echo $lessons_data->ID;?>">
			<input type="hidden" class="tilelboxactid<?php echo $lessons_data->ID;?>" id="lx_alactivity_id_<?php echo $lessons_data->ID;?>" value="<?php echo $activity_id;?>">
			<?php
		}
	}
}
?>
<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
	<main id="main" <?php generate_do_element_classes( 'main' ); ?>>
		<div class="entry-content" itemprop="text">
			<?php
			if( function_exists('course_page_breadcrumbs')) { 
				course_page_breadcrumbs($post_id); 
			} else { ?>
				<div class="ld-breadcrumbs-course-nav lx_lms_sub_text" style="width:100%;margin-top:0px;">
					<span><?php echo get_post($post->ID)->post_title; ?></span>
				</div>
			<?php
			} 
			?>
			<article>
			<?php
			if($var==1){ ?>
			
			<div class="container-fluid course_content_main">
				<div class="row progress_main_div">
					<div class="col-sm-12">
						<div class="course_progress mt-2">
							<div class="lx_progress_bar">
								<div class="lx-progress-bar-percentage" style="width:<?php echo  $course_progress['percentage'];?>%;"></div>

							</div>
							<div class="status_label_text">
								<span>Course :&nbsp;</span>
								<span class="course_percent"><?php echo $course_progress['percentage'];?>% COMPLETE
							</div>
							<div class="last_time_stamp">
								<span>&nbsp;&nbsp;&nbsp;Last Activity on <?php echo $last_activity; ?></span>
							</div>
							<?php 
								$status='';
								if($course_progress['status']=='Partially completed'){
									$status='In Progress';
								}else{
									$status=$course_progress['status'];
								}
							?>
							<div class="progress_ststus_main_div">
								<div class="course_status btn_normal_state_who"><?php echo $status;?></div>
							</div>
						</div>
					</div>
				</div>
				<div class="row course_content mt-4">
					<div class="col-sm-4 content_tab1">
					<div class="course_content_tab">
						<?php 
							$course_thumb = get_post_meta($post->ID,'lx_course_thumbnail_path')[0];
							if(empty($course_thumb)){
								$course_thumb = $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg';
							}
						?>
						<div class="the_thumb" style="margin-top: 6px;position: relative;">
							<?php 
								if(is_user_logged_in()) {
									$user_id=get_current_user_id();
									$author_id=$post->post_author;
									if($user_id==$author_id) {
								?>
									<form method="post" action="<?php echo site_url().'/create-courses/';?>" style="position: absolute;right: 0;">
										<input type="hidden" name="edit_course_id" value="<?php echo $post->ID?>">
										<button class="btn btn_normal_state btn_course_edit btn_edit_icon" type="submit"><i class="<?php echo $square_icon['edit'];?>"></i></button>
									</form>
									<?php 
									}
								}
							 ?>	
							<img src="<?php echo $course_thumb; ?>"/>
						</div>
						
						<div class="course_info_left_div">
							<div class="course_info_left_inside_div">
								<div class="cpd_points_main pt-2">
								<?php 
									$cpd_points = get_post_meta( $post->ID,'lx_course_cpd_points',true);
									if(!empty($cpd_points)){ ?>
									<div class="course_cpd_points lx_lms_sub_text">
										<span>CPD Points:&nbsp;</span><b><?php echo get_post_meta( $post->ID,'lx_course_cpd_points',true); ?></b>
									</div>
									<?php } 
									$course_time = get_post_meta( $post->ID,'lx_course_time',true);
									if(!empty($course_time)){
									?>
									<div class="course_time lx_lms_sub_text">
										<span>Time:&nbsp;</span><b><?php echo $course_time.'hrs'; ?></b>
									</div>
									<?php } ?>
								</div>
								<?php if(!empty($cpd_points)){ ?>
								<div class="cpd_ceu_pda_level_main pt-1 lx_lms_sub_text">
									<span>CPD/CEU/PDA Level:&nbsp;</span><b><?php echo ucfirst(get_post_meta( $post->ID,'lx_course_levels',true)); ?></b>
								</div>
								<?php } ?>
							</div>		
						</div>
						<?php
							/* set course purchase button for purchase course */
							$cost = get_post_meta( $post->ID,'lx_course_cost',true);
							if($lx_lms_settings['course_purchasing_settings'] == 'on' && !empty($lx_lms_settings['course_currency_symbol']) && ($cost !='' || $cost !=0)){
								if(!empty($cost)){
									$cost_info = $cost;
								} else{
									$cost_info = '';
								}
								$order_existance = check_lx_course_order_exists($post->ID,get_current_user_id());
								
								if($macro_course_id != 0 && !empty($macro_course_id)){
									$micro_course_order_existance = check_lx_course_order_exists($macro_course_id,get_current_user_id());
								}
								
								$author_id = get_post($post->ID)->post_author;
								if($author_id != get_current_user_id()){
									
									if(!is_user_logged_in()){
										
										$data=base64_encode('is_purchase=yes&course_id='.$post->ID);
										$redirect_link=site_url().'/login/'.$data;
										
										$is_purchaseon = get_post_meta( $post->ID, 'lx_course_feechk', true );
										if( $is_purchaseon == 'on' ){
											?>
											<div class="mt-2">
											<a href="<?php echo $redirect_link;?>">
												<button class="btn_normal_state w-100 mt-2">PURCHASE: <?php echo $lx_lms_settings['course_currency_symbol'].''.$cost_info; ?></button></br>
											</a>
											</div>
											<?php
										}
									}else{
										if(!empty($cost) && empty($order_existance)){
											if(!isset($micro_course_order_existance) || empty($micro_course_order_existance)){
												$payment_content = do_shortcode( '[accept_stripe_payment id="'.$post->ID.'" description="#'.$post->ID.'" name="'.get_post($post->ID)->post_title.'" class="btn_normal_state w-100" price="'.$cost_info.'" button_text="PURCHASE: '.$lx_lms_settings['course_currency_symbol'].''.$cost_info.'" billing_address="0" shipping_address="0" payment_info= "custom_payment" currency="'.$lx_lms_settings['course_currency_setting'].'"]');
							
												$static_content = '[accept_stripe_payment id="'.$post->ID.'" description="#'.$post->ID.'" name="'.get_post($post->ID)->post_title.'" class="btn_normal_state w-100" price="'.$cost_info.'" button_text="PURCHASE: '.$lx_lms_settings['course_currency_symbol'].''.$cost_info.'" billing_address="0" shipping_address="0" payment_info= "custom_payment" currency="'.$lx_lms_settings['course_currency_setting'].'"]';
												
												if( $payment_content != $static_content ){
													echo $payment_content;
												}else{
													echo "<span class='lx_lms_sub_text'>No payment method available</span>";
												}
											}									
										}
									}
								} /* else if($author_id == get_current_user_id() && $lx_lms_settings['course_purchasing_settings'] == 'on' && !empty($lx_lms_settings['course_currency_symbol'])){ ?>
									<button class="btn_normal_state"><?php echo $lx_lms_settings['course_currency_setting'].''.$lx_lms_settings['course_currency_symbol'].''.$cost_info; ?></button>
								<?php
								} */
						 } 
						 
						 if( !is_user_logged_in() ){
							 ?>
							<a href="<?php echo wp_login_url();?>"> <button class="btn_normal_state w-100 mt-2">Login / Register</button></a>
							 <?php
						 }
						 /* check current login user lession list display or not */
						 if(is_user_logged_in()){
							 if(!empty($cost) && $lx_lms_settings['course_purchasing_settings'] == 'on' && !empty($lx_lms_settings['course_currency_symbol'])){
								 if($author_id != get_current_user_id()){
									 if(isset($micro_course_order_existance) && !empty($micro_course_order_existance)){
										 $display_lessons = 'yes';
									 } else if(!empty($order_existance)){
										 $display_lessons = 'yes';
									 } else {
										 $display_lessons = 'yes';
									 }
								 } else if($author_id == get_current_user_id()){
									 $display_lessons = 'yes';
								 } else{
									 $display_lessons = 'none';
								 }
							 } else{
								 $display_lessons = 'yes';
							 }
						 } else{
							  $display_lessons = 'yes';
						 }
						 $other_modules_array = array(
							'check_other_modules'=>$check_other_modules,
							'micro_course_order_existance'=>$micro_course_order_existance,
							'macro_course_id'=>$macro_course_id
						);
						if(!empty($check_other_modules)){
							array_push($tab_title,"Other modules in this Series");
							array_push($tab_content,"other_modules");
						}
						?>
					</div>
					
					</div>
					
					<div class="col-sm-8">
						<div class="row course_right_row">
							<div class="col-sm-12">
								<div class="course_title_main_div" id="style-4">
									<div class="c_title">
										<h3 class="head_h3"> <?php echo the_title(); ?></h3>
									</div>
									<?php
									$sub_title_info = get_post_meta( get_the_ID(),'lx_course_subtitle')[0];
									$certificate = get_post_meta( get_the_ID(),'lx_certificate',true);
									if(!empty($sub_title_info)){ ?>
									<div class="course_sub_title">
										<h4 class="head_h4">
										<?php 
											echo $sub_title_info;
										?>
										</h4>
									</div>
									<?php } ?>
									<?php
									if( $lx_lms_settings['author_visiblity']== "ON" ){
										?>
										<div class="course_author lx_lms_sub_text"><span>@</span><?php echo get_the_author();?></div>
										<?php
									}
									?>
									<div class="description_body pt-2" id="style-4"><?php echo FnFormatMytext(get_post(get_the_ID())->post_content);?></div>
								</div>
							</div>
							<div class="col-sm-12">
								<?php if($display_lessons == 'yes'){ ?>
									<div class="course_lession_list_main">
										<div class="course_lession_list pt-2">
											<?php
												include(dirname(__FILE__).'/get_lesson_list.php');
											?>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="tab_main_class pt-4">
					<div class="row row_tab">
						<?php	
						if( $lx_course_summary !='' ){ ?>
							<div class="col-md-2 col-sm-2 tab_title_col active_tab" data-count="0" id="tab_title_0">
								Summary							
							</div>
							<?php	
						} 
						if( $lx_course_outcomes !='' ){ 
							$active='active_tab';
							if($lx_course_summary !=''){
								$active='not_active_tab';
							}
							?>
							<div class="col-md-2 col-sm-2 tab_title_col <?php echo $active;?>" data-count="1" id="tab_title_1">
								Outcomes	 						
							</div>
							<?php
						}
						if( $lx_course_requirements !='' ){ 
							$active='active_tab';
							if($lx_course_summary !='' || $lx_course_outcomes !=''){
								$active='not_active_tab';
							}
							?>
							<div class="col-md-2 col-sm-2 tab_title_col <?php echo $active;?>" data-count="2" id="tab_title_2">
								Requirements							
							</div>
							<?php 
						} 
						if( !empty($check_other_modules) ){
							$active='active_tab';
							if($lx_course_summary !='' || $lx_course_outcomes !='' || $lx_course_requirements !=''){
								$active='not_active_tab';
							}
						?>
							<div class="col-md-2 col-sm-2 tab_title_col <?php echo $active;?>" data-count="3" id="tab_title_3">
								Other modules in this Series
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="tab_content_main_div">
					<div class="row">
						<div class="col-md-12">
							<div class="row pt-4">
								<div class="col-sm-1"></div>
								<?php 
									$display='none';
									if($lx_course_summary !=''){
										$display='block';
									}
								?>
								<div class="col-md-6 tab_content_row tab_content_0" style="display:<?php echo $display;?>;">
									<div class="description_body">
										<?php 
											echo FnFormatMytext( get_post_meta(get_the_ID(),'lx_course_summary',true) ); 
										?>
									</div>
								</div>
								<?php 
									$display='none';
									if($lx_course_summary =='' && $lx_course_outcomes!=''){
										$display='block';
									}
								?>
								<div class="col-md-6 tab_content_row tab_content_1" style="display:<?php echo $display;?>;">
									<div class="description_body">
										<?php 
										echo FnFormatMytext( get_post_meta(get_the_ID(),'lx_course_outcomes',true) ); 
										?>
									</div>
								</div>
								<?php 
									$display='none';
									if($lx_course_summary =='' && $lx_course_outcomes==''&& $lx_course_requirements!=''){
										$display='block';
									}
								?>
								<div class="col-md-6 tab_content_row tab_content_2" style="display:<?php echo $display;?>;">
									<div class="description_body">
										<?php 
											echo FnFormatMytext( get_post_meta(get_the_ID(),'lx_course_requirements',true) ); 
										?>
									</div>
								</div>
								<?php
								if( !empty($check_other_modules) ){
									$display='none';
									if($lx_course_summary =='' && $lx_course_outcomes=='' && $lx_course_requirements==''){
										$display='block';
									}
								?>
								<div class="col-md-6 tab_content_row tab_content_3" style="display:<?php echo $display;?>;">
									<div class="description_body">
										<?php 
										echo course_other_modules_in_series($other_modules_array); 
										?>
									</div>
								</div>
								<?php 
								}
								if($lx_course_summary !='' || $lx_course_outcomes!='' || $lx_course_requirements!='' || !empty($check_other_modules)){
									if(!empty($macro_course_id) && $macro_course_id!='0'){
									?>
									<div class="col-sm-4">
									<?php
										$macro_course_thumbnail= get_post_meta( $macro_course_id,'lx_course_thumbnail_path')[0];
										if(empty($macro_course_thumbnail)){
											$macro_course_thumbnail = $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg';
										}
										$macro_title = get_post($macro_course_id)->post_title;
									?>
										<div class="card card_micro">
											<div class="text-center pt-2 description_body">This Micro Course is part of a larger Course</div>
											<h3 class="card-title text-center head_h3"><?php echo $macro_title; ?></h3>
											<div class="pt-2">
												<img class="card-img-top" src="<?php echo $macro_course_thumbnail; ?>" alt="Card image cap">
											</div>
											<div class="card-body">
												<p class="card-text"><?php echo $macro_course_description; ?></p>
											</div>
											<a href="<?php echo get_permalink($macro_course_id); ?>">
												<div class="btn_normal_state text-center">
													View Full Course
												</div>
											</a>
										</div>
									</div>
									<?php
										}
									} 
								?>
								
								<div class="col-sm-1"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			}else{
					if(!is_user_logged_in()){
						$premsg="Please login and join";
					}else{
						$premsg="Please join";
					}
					echo "<div style='width:100%;color:red;text-align:center;padding:20px;'>".$premsg." the community to access this course</div>";
			}?>
			</article>
		</div>
	</main>
</div>
<script type="text/javascript">
/* count height to set description and lesson list scrollbar */
jQuery(window).load(function() {
	var height=jQuery( ".course_content_tab" ).height() - jQuery( ".course_progress" ).height() - jQuery( ".course_content_heading" ).height();
	/* jQuery( ".course_content_scrollbar" ).css('max-height',parseInt(height*2)); */
    var http_referer = {'back':"<?php echo $_SERVER['HTTP_REFERER'];?>"}
});
jQuery(window).scroll(function() {
	var height=jQuery( ".course_content_tab" ).height() - jQuery( ".course_progress" ).height() - jQuery( ".course_content_heading" ).height();
	/* jQuery( ".course_content_scrollbar" ).css('max-height',parseInt(height*2)); */
});
</script>
<?php
endif;
get_footer(); 	
?>
