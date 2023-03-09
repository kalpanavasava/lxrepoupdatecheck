<?php
/* single page for display lession */
if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}
get_header();
if(is_user_logged_in()){  
    if ( have_posts() ) : the_post();
    global $learning_locker_setting;
    $user_id=get_current_user_id();
    $post_id = get_the_ID();
    $current_post=get_post($post_id);
    $author=$current_post->post_author;
    $menu_order=$current_post->menu_order;
    $course_id=get_post_meta($post_id,'course_id',true);
    $cost=get_post_meta($course_id,'lx_course_cost',true);
    $check_purchase=check_lx_course_order_exists($course_id,get_current_user_id());
    $macro_course_id=get_post_meta($course_id,'lx_associated_macro_course',true);
    $check_macro_purchase=array();
    if(!empty($macro_course_id)){
        $check_macro_purchase=check_lx_course_order_exists($macro_course_id,get_current_user_id());
    }
	
	$lessons= get_posts(
				$args=array(
					'post_type' => 'lx_lessons', 
					'posts_per_page' => -1, 
					'post_status'=>'publish',
					'meta_query' => array(
					   array(
						   'key' => 'course_id',
						   'value' => $course_id,
						   'compare' => '='
					   )
					), 
					'orderby'=>'menu_order',
					'order'=>'ASC',
				)
			);
	
    /* $lessons=get_lessons($course_id); */
    $course_progress=lx_course_progress($course_id);
    $course_title=get_post($course_id)->post_title;
    $lesson_progress=lx_lesson_progress($post_id);
    $cat = wp_get_post_categories( $post_id );
    $term = get_term_by( 'id' , $cat[0] , 'category' )->slug;
	
	$content_type = get_post_meta($post_id,'content_type',true);
	if($content_type!='' && $content_type == 'poll'){
		$status=get_user_meta($user_id,'lx_lesson_progress_'.$post_id,true);
	}else{
		$activityId = get_post_meta($post_id,'xapi_activity_id',true); 
		$status=get_user_meta($user_id,'lx_lesson_progress_'.$activityId,true);
	}
	
    $poll_arr=array();
    foreach($lessons as $main_key => $lession){
        $ctype = get_post_meta($lession->ID,'content_type',true);
        if(!empty($ctype) && $ctype=='poll'){
            $avail_in_course=get_post_meta($lession->ID,'available_in_course',true);
            if($avail_in_course){
                $btn_label=get_post_meta($lession->ID,'button_label',true);
                $poll_arr[$lession->ID]=$btn_label;
            }
        }
    	if($post_id == $lession->ID){
    		$keys = $main_key;
    	} 
    }
    $navigation_options = get_post_meta( $course_id,'lx_navigation_options',true);
    $prevmod=$menu_order-2;
	
	$content_type = get_post_meta($lessons[$prevmod]->ID,'content_type',true);
	if($content_type!='' && $content_type == 'poll'){
		$get_prev_completion = get_user_meta( get_current_user_id(),'lx_lesson_progress_'.$lessons[$prevmod]->ID,true);
	}else{
		$activityId = get_post_meta($lessons[$prevmod]->ID,'xapi_activity_id',true); 
		$get_prev_completion = get_user_meta( get_current_user_id(),'lx_lesson_progress_'.$activityId,true);
	}
	
    $manually=false;
    if(metadata_exists('post',$post_id,'course_content_type')){
        $manually=true;
    }
    if(($term=='articulate-rise' || $term=='articulate-storyline') && !is_page()){
        $post_data=get_post_meta($post_id,'xapi_content',true);
        $content_type=$post_data['content_type'];
        $activity_id=get_post_meta($post_id,'xapi_activity_id',true);
        $user=get_user_by('id',$user_id);
        $user_email=$user->user_email;
    ?>
    <?php if(is_super_admin()){?>
        <style>
        .main_header{
            position: relative;
           /* margin-top: 32px;*/
        }
        @media (max-width: 767px){
            .main_header{
                margin-top: 50px;
            }  
        }
        </style>
        <?php 
        }
    }
    ?>
   <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <input type="hidden" class="vw_lesson_id" id="vw_lesson_id" value="<?php echo $post_id; ?>"/>
    <div class="lx_lesson_view">
        <div class="container-fluid main_header">
            <div class="row lesson_progress_row ai_center">
                <div class="col-md-2 col-2 ld_logo">
                    <div class="p-3">
                        <a href="#" class="mb_toggle_btn" id="mobile-toggle"><i class="fa fa-bars"></i></a>
                    </div>
                </div>
                <?php
                    $total_lesson=count($lessons);
                    if($total_lesson>1){
                        $class="col-md-4 div_border";
                    }
                    else{
                        $class="col-md-8";
                    }
                ?>
                <div class="<?php echo $class;?> col-10 ld_progress">
                    <div class="p-1">
                        <div class="progress_text">
                            <span>Course : </span>
                            <span class="progress_percentage"><?php echo $course_progress['percentage'];?>% complete</span>
                            <span class="progress_steps ml-2"><?php echo $menu_order.' / '.count($lessons);?> Steps</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $course_progress['percentage'];?>%" aria-valuenow="<?php echo $course_progress['percentage'];?>"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                 <?php 
                    $total_lesson=count($lessons);
                    if($total_lesson>1){
                        foreach($lessons as $key=>$lesson){
                            if($key==0){
                                $prev='none';
                                $next='block';
                                $justify='flex-end';
                                $next_href=get_permalink($lessons[1]->ID);
                            }elseif($key==$total_lesson-1){
                                $prev='block';
                                $next='none';
                                $justify='flex-start';
                                $prev_href=get_permalink($lessons[$total_lesson-2]->ID);
                            }else{
                                $prev='block';
                                $next='block';
                                $justify='space-between';
                                $plink=$key-1;
                                $nlink=$key+1;
                                $prev_href=get_permalink($lessons[$plink]->ID);
                                $next_href=get_permalink($lessons[$nlink]->ID);
                            }
                        if($lesson->ID==$current_post->ID){
                    ?>
                    <div class="col-md-4 div_border col-12 ld_content_action" style="justify-content: <?php echo $justify;?>;">              
                        <div class="p-3 d-flex" style="display:<?php echo $prev;?> !important;">
                            <a href="<?php echo $prev_href;?>" class="ml-auto ld_text d-flex ai_center">
                                <span class="mr-2"><i class="fa fa-chevron-left"></i></span>
                                <span>Prev Module</span>
                            </a>
                        </div>
                        <div class="p-3 d-flex" style="display:<?php echo $next;?> !important;">
                            <a href="<?php echo $next_href;?>" class="ml-auto ld_text d-flex ai_center">
                                <span style="text-align:right;">Next Module</span>
                                <span class="ml-2"><i class="fa fa-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                <?php } } }?>
                <div class="col-md-2 col-12 ld_mark_complete">
                    <?php
					/* echo "<pre>";print_r($poll_arr); */
					
                        $is_poll=0;
                         if(metadata_exists('post',$post_id,'content_type') && get_post_meta($post_id,'content_type',true)=='poll'){
                            $is_poll=1;
                         }
						 
						 /** get specific module **/
						 $getInMOdule = $wpdb->get_results("select pm.* from ".$wpdb->prefix."posts as p,".$wpdb->prefix."postmeta as pm where p.ID=pm.post_id and pm.meta_key='module_apperain' and pm.meta_value='".$post_id."' and p.post_status='publish' and p.post_type='lx_lessons'");
						 
						if( !empty($getInMOdule) ){
							 $pid=$getInMOdule[0]->post_id;
							$btnLabelexist = get_post_meta($getInMOdule[0]->post_id,'button_label',true);
							
							$btnLabelText = $btn_label;
							if( !empty($btnLabelexist) ){
								$btnLabelText = $btnLabelexist;
							 }
							?>
							<div>
								<button type="button" data-pid="<?php echo $pid;?>" class="btn_normal_state btn_poll"><?php echo $btnLabelText;?></button>
							</div>
							 <?php
							/* echo "<pre>";print_r($getInMOdule); */
						}elseif(!empty($poll_arr) && !$is_poll){
                            $pid=array_keys($poll_arr)[0];
                            $btn_label=array_values($poll_arr)[0];
							/* if( !empty( get_post_meta($pid,'module_apperain',true) ) ){
								
							} */
                            if($pid!=$post_id){
                            ?>
                            <div>
                                <button type="button" data-pid="<?php echo $pid;?>" class="btn_normal_state btn_poll"><?php echo $btn_label;?></button>
                            </div>
                            <?php
                            }
                         }
                    ?>
                    <?php if($manually || $content_type=='not_xapi'){
                            $attr = '';$html = '';$style="";
                            if( get_user_meta($user_id,'lx_lesson_progress_'.$post_id,true) == 'completed' ){
                                $attr = 'disabled';$html = 'Completed <i class="fa fa-check"></i>';$style="background-color:#03a9f4;";
                            }else{
                                $attr = '';$html = 'Mark as complete';$style="";
                            }
                        ?>
                            <button class="btn btn-primary vw_lession_mark_complete" <?php echo $attr;?> onclick="vw_lesson.mark_complete_manually(this)"><?php echo $html;?></button>
                        <?php
                    }?>
                </div>
            </div>
        </div>
        <div id="wrapper">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <div class="d-flex">
                            <a href="<?php echo get_permalink($course_id);?>" class="d-flex" style="align-items: center;">
                                <div class="ld_icon"><i class="far fa-file-alt"></i></div>
                                <div class="ld_lesson_title"><h3 class="head_h3"><?php echo $course_title;?></h3></div>
                            </a>
                    </div>


                </div>
                <ul class="sidebar-nav">
                    <?php 
                        foreach($lessons as $lesson){
                            ?>
                            <li class="<?php if($post_id==$lesson->ID){echo 'active';}?>">
                                <a href="<?php echo get_permalink($lesson->ID);?>" class="content_list_href" data-lession_id="<?php echo $lesson->ID;?>">
                                    <?php 
										$content_type = get_post_meta($lesson->ID,'content_type',true);
										$lessonActivityId = get_post_meta($lesson->ID,'xapi_activity_id',true); 
										if($content_type!='' && $content_type == 'poll'){
											$lsn_status=get_user_meta($user_id,'lx_lesson_progress_'.$lesson->ID,true);
										}else{
											$lsn_status=get_user_meta($user_id,'lx_lesson_progress_'.$lessonActivityId,true);
										}
                                        if($lsn_status=='in_progress' || $lsn_status==''){
                                        ?>
                                            <div class="ld_status_icon ld_status_incomplete"></div>
                                        <?php 
                                        }else{
                                            ?>
                                            <i class="fas fa-check-circle ld_status_icon"></i>
                                            <?php
                                        }
                                    ?>
                                    <div class="ld_content_title"><?php echo $lesson->post_title;?></div>
                                </a>
                            </li>
                            <?php
                        }
						
					
                    ?>
                </ul>
            </aside>

            <div id="navbar-wrapper">
                <nav class="navbar navbar-inverse lx_lms_sub_text">
                    <div class="container-fluid">
                        <div class="navbar-header" style="width:100%;">
                            <a href="#" class="navbar-brand toggle_btn" id="sidebar-toggle"><i
                                    class="fa fa-chevron-left"></i></a>
                            <div class="d-flex row">
                                <div class="col-md-10" style="display:flex;margin-left: -15px;">
                                    <a href="<?php echo site_url();?>" style="color:#fff;"><div class="btn_brd_home btn_normal_state">Home</div></a>
                                    <ul class="breadcrumb p-0 m-0 breadcrumb_item_size">
                                        <li class="breadcrumb-item"><a href="<?php echo get_permalink($course_id);?>"><?php echo $course_title;?></a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><?php echo $current_post->post_title;?></li>
                                    </ul>
                                </div>
                                <div class="col-md-2">
                                    <div class="btn ld_status ml-auto"><?php echo $lesson_progress['status'];?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <section id="content-wrapper">
                <div class="lesson_content">
                 <?php 
                    $content_type = get_post_meta($post_id,'content_type',true);
					$lead_call = 0;
                    if($content_type!='' && $content_type == 'poll'){
                        $is_display=false;
                        if( $author!=$user_id ){
                            if(isset($cost) && $cost>0 && empty($check_purchase) && empty($check_macro_purchase)){
                                $is_display=false;
                                echo "<div style='text-align:center;color:red;'>You Don't have access to this page.</div>";
                            }
                            elseif( $navigation_options == 'restricted'){
                                if( $keys == 0 || $get_prev_completion == "completed" ){
                                    $is_display=true;
                                }else{
                                    echo "<div style='text-align:center;color:red;'>Please complete the previous module to access this module.</div>";
                                }
                            }else{
                                $is_display=true;
                            }
                        }else{
                            $is_display=true;
                        }
                        if($is_display){
                            update_user_meta(get_current_user_id(),'lesson_last_accessed_'.$post_id,time());
    						
                            if( $status==''){
    							$lead_call = 1;
                                update_user_meta($user_id,'lx_lesson_progress_'.$post_id,'in_progress');
                                update_user_meta($user_id,'lx_lesson_progress_date_'.$post_id,array('start_timestamp'=>time()));
    							
                            }
                            $data_main="lesson_content";
                            include POLLCOURESEPATH.'/templates/pollcourse_content.php';
                        }
                    }else{
						$lessonActivityId = get_post_meta($post_id,'xapi_activity_id',true); 
						$curmodulestatus = get_user_meta($user_id,'lx_lesson_progress_'.$lessonActivityId,true);
                        if( $author!=$user_id ){
                            if(isset($cost) && $cost>0 && empty($check_purchase) && empty($check_macro_purchase)){
                                echo "<div style='text-align:center;color:red;'>You Don't have access to this page.</div>";
                            }
        					elseif( $navigation_options == 'restricted'){
        						if( $keys == 0 || $get_prev_completion == "completed" ){
        							update_user_meta(get_current_user_id(),'lesson_last_accessed_'.$post_id,time());
        							the_content();
        							if( $status==''){
										$lead_call = 1;
										if( $curmodulestatus ){
										}else{
											update_user_meta($user_id,'lx_lesson_progress_'.$lessonActivityId,'in_progress');
											update_user_meta($user_id,'lx_lesson_progress_date_'.$lessonActivityId,array('start_timestamp'=>time()));
										}
        							}
        						} else{
        							echo "<div style='text-align:center;color:red;'>Please complete the previous module to access this module.</div>";
        						}
                            }else{
                                update_user_meta(get_current_user_id(),'lesson_last_accessed_'.$post_id,time());
                                the_content();
                                if( $status==''){
									$lead_call = 1;
									if( $curmodulestatus ){
									}else{
										update_user_meta($user_id,'lx_lesson_progress_'.$lessonActivityId,'in_progress');
										update_user_meta($user_id,'lx_lesson_progress_date_'.$lessonActivityId,array('start_timestamp'=>time()));
									}
                                }
                            }
                        }else{
    						update_user_meta(get_current_user_id(),'lesson_last_accessed_'.$post_id,time());
    						the_content();
    						if( $status==''){
								$lead_call = 1;
    							if( $curmodulestatus ){
								}else{
									update_user_meta($user_id,'lx_lesson_progress_'.$lessonActivityId,'in_progress');
									update_user_meta($user_id,'lx_lesson_progress_date_'.$lessonActivityId,array('start_timestamp'=>time()));
								}
    						}
    					}
                    }
					
					if( $lead_call == 1 ){
						$webooksettings = get_option('currentwebhookon',true);
						if( $webooksettings['content'] == 1 ){
							$is_content_webhookexist = $wpdb->get_results("select * from ".$wpdb->prefix."vw_contentwebhook_master where contentid='".$post_id."'");
							if( $is_content_webhookexist[0]->act_progressed == 1 ){
								$salesforcesetting = get_option('salesforce_environment',true);
								$apis = array_values( $salesforcesetting[$salesforcesetting['environment']] );
								$Auth = SFAPIAuthentication( $apis );
								$auth_token = json_decode( $Auth )->access_token;
								$instance_url = json_decode( $Auth )->instance_url;
								$authenticationar = array('auth_token'=>$auth_token,'instance_url'=>$instance_url);
								$contenttitle = get_post($post_id)->post_title;
								$crs_id = get_post_meta($post_id,'course_id',true);
								$coursetitle = get_post($crs_id)->post_title;
								$comid = get_post_meta($crs_id,'lx_attach_this_course',true);
								$commtitle = get_post($comid)->post_title;
								$cusrid = get_current_user_ID();
			
								$payload_array['Email__c'] = get_userdata($cusrid)->user_email;
								$payload_array['FirstName'] = get_user_meta($cusrid,'first_name',true);
								$payload_array['LastName'] = get_user_meta($cusrid,'last_name',true);
								$payload_array['company'] = get_option('blogname',true);
								$payload_array['CommunityId__c'] = $comid;
								$payload_array['Community_Name__c'] = $commtitle;
								$payload_array['CourseId__c'] = $crs_id;
								$payload_array['Course_Name__c'] = $coursetitle;
								$payload_array['ContentId__c'] = $post_id;
								$payload_array['Content_Name__c'] = $contenttitle;
								$payload_array['Action__c'] = 'Progressed';
								$payload_array['Form_Type__c'] = 'Content';
								
								$generated_lead = SFAPICreateNewLead( $authenticationar , json_encode( $payload_array ) );
								
								if( !empty(json_decode( $generated_lead )->id) ){
									$wpdb->insert($wpdb->prefix.'vw_contentwebhook_payload',array('userid'=>$cusrid,'com_id'=>$comid,'course_id'=>$crs_id,'content_id'=>$post_id,'action'=>'Progressed','response'=>$generated_lead,'date_created'=>date('Y-m-d H:i:s')));
								}
							}
						}
					}
    			?>
                </div>
            </section>
        </div>
    </div>
    <div class="modal poll_modal" id="poll_modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body poll_content">
            <?php
			$data_main="poll_modal";
			$post_id=$pid;
			include POLLCOURESEPATH.'/templates/pollcourse_content.php';
		   /*  $post_id=$pid;
			update_user_meta(get_current_user_id(),'lesson_last_accessed_'.$post_id,time());
			if( $status==''){
				update_user_meta($user_id,'lx_lesson_progress_'.$post_id,'in_progress');
				update_user_meta($user_id,'lx_lesson_progress_date_'.$post_id,array('start_timestamp'=>time()));
			}
			
			include POLLCOURESEPATH.'/templates/pollcourse_content.php'; */
            ?>
          </div>
        </div>
      </div>
    </div>
    <script>
        height=parseInt(jQuery('.sidebar-brand').height()+40);
        jQuery('.sidebar-nav').css('top',height);
        const $button = document.querySelector('#sidebar-toggle');
        const $wrapper = document.querySelector('#wrapper');

        $button.addEventListener('click', (e) => {
            e.preventDefault();
            $wrapper.classList.toggle('toggled');
            jQuery(".toggle_btn .svg-inline--fa").toggleClass('fa-chevron-right fa-chevron-left');
        });

        const $button1 = document.querySelector('#mobile-toggle');
        const $wrapper1 = document.querySelector('#wrapper');

        $button1.addEventListener('click', (e) => {
            e.preventDefault();
            $wrapper1.classList.toggle('toggled');
        });
    </script>
<?php
endif;
}else{
    echo "<div style='text-align:center;color:red;'>You don't have access to this page.</div>";
}
get_footer();
?>