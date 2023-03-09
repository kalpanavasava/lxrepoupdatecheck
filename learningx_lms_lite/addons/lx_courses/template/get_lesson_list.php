<?php 
/* get lession list */
global $square_icon;
$course_id=$post->ID;
$args=array(
	'post_type' => 'lx_lessons' , 
	'posts_per_page' => -1,	
	'post_status'=>array('publish','draft'),
	'meta_query' => array(
		'relation' => 'OR',
		array(
		   'key' => 'course_id',
		   'value' => $course_id,
		   'compare' => '='
		),
		array(
		   'key' => 'section_heading_course_id',
		   'value' => $course_id,
		   'compare' => '='
		)
	),
	'orderby'=>'menu_order',
	'order'=>'ASC'
);
$course_content=get_posts($args);

$author_id= get_post_field( 'post_author', $course_id );
$course_status_for_certificate = array();
$end_time = array();
foreach($course_content as $course_content_info){
	if($course_content_info->post_status=='draft'){}else{
		$id = $course_content_info->ID;
		$lx_xapi_certificate = get_post_meta( $id,'lx_xapi_certificate',true);
		$content_type = get_post_meta($id,'content_type',true);
		$lessonActivityId = get_post_meta($id,'xapi_activity_id',true); 
		if($content_type!='' && $content_type == 'poll'){
			$lx_lesson_progress = get_user_meta( get_current_user_id(),'lx_lesson_progress_'.$id,true);
		}else{
			$lx_lesson_progress = get_user_meta( get_current_user_id(),'lx_lesson_progress_'.$lessonActivityId,true);
		}
		if( $lx_lesson_progress == "completed" ){
			$course_status_for_certificate[] = "yes";
			if($content_type!='' && $content_type == 'poll'){
				$time_stamp = get_user_meta( get_current_user_id(),'lx_lesson_progress_date_'.$id,true);
			}else{
				$time_stamp = get_user_meta( get_current_user_id(),'lx_lesson_progress_date_'.$lessonActivityId,true);
			}
			if(is_array($time_stamp) && !empty($time_stamp)){
				if(array_key_exists('end_timstamp',$time_stamp)){
					$end_time[] = $time_stamp['end_timstamp'];
				}
			}
		} else{
			if($lx_lesson_progress != "completed" && ($lx_xapi_certificate == "off" || $lx_xapi_certificate == "")){
				$course_status_for_certificate[] = "yes";
			} else{
				$course_status_for_certificate[] = "no";
			}
		}
	}
}

?>
<style>
.modal-body button span{
	font-size:14px;
	font-family: monospace;
	color: #fff !important;
}
.modal-header .close:hover {
	background: #fff !important;
}

.blog_builder .blog_builder_link{
	font-size: 14px !important;
	font-family: monospace !important;
	width: 68px !important;
}
.content_selection{align-items: center;}
.content_selection .col-md-3{
	text-align: center;
}
</style>
<?php if(!empty($course_content)){
	
	$disable_link = '';
	$enrolled_course=get_user_meta(get_current_user_id(),'course_paid',true);
	if($lx_lms_settings['course_purchasing_settings']=='on' && !empty($enrolled_course) && !in_array($course_id,$enrolled_course) && !empty($cost)){
		$disable_link = 'true';
	}else{
		if(!empty($community_id) && $community_id>0){
			$mepr_user = new MeprUser( get_current_user_id() );
			$is_active = $mepr_user->is_already_subscribed_to( $community_id );
			if(!$is_active){
				$disable_link = 'true';
			}
		}elseif(!empty($cost) && $lx_lms_settings['course_purchasing_settings'] == 'on' && !empty($lx_lms_settings['course_currency_symbol'])){
			$order_existance = check_lx_course_order_exists($post->ID,get_current_user_id());
			$macro_course_id=get_post_meta($course_id,'lx_associated_macro_course',true);
			if($macro_course_id != 0 && !empty($macro_course_id)){
				$macro_course_order_existance=check_lx_course_order_exists($macro_course_id,get_current_user_id());
			}
			 if($author_id != get_current_user_id() && $cost !='' && ( empty($order_existance) &&empty($macro_course_order_existance) )){
				 $disable_link = 'true';
			 }
		}
	}
?>
<div class="course_content scrollbar course_content_scrollbar" id="style-4">
	<div class="content_list course_content_list">
		<?php
		 	$i=1;
			foreach($course_content as $content) {
				$user_id=get_current_user_id();
				$content_id=$content->ID;
				$content_status=$content->post_status;
				$content_author=$content->post_author;
				$content_title=$content->post_title;
				$content_link=get_permalink($content_id);
				if( $disable_link == 'true' ){
					$content_link = 'javascript:void(0);';
				}
				if($content_status=='draft'){
					$content_link = 'javascript:void(0);';
				}
				$progress=lx_lesson_progress($content_id);
				$color=$progress['background'];
				if($content_status=='draft' && $content_author!=$user_id){}else{
					$section_heading_course_id = get_post_meta($content_id,'section_heading_course_id',true);
					if( $section_heading_course_id ){ ?>						
						<div class="content_list_items content_list_item_head" data-count="<?php echo $i;?>">
							<input type="hidden" name="course_id" value="<?php echo $post->ID;?>">
							<div class="content_list_link sectionHeadingMain p-1" data-lession_id="<?php echo $content_id;?>">
								<div class="pl-2 sectionheadprevdivmain sectionheadprevdivmain<?php echo $content_id;?>" data-lession_id="<?php echo $content_id;?>">
									<h3 class="head_h3 sectionheadprevdiv sectionheadprevdiv<?php echo $content_id;?>" data-lession_id="<?php echo $content_id;?>"><?php echo $content_title;?></h3>
									<input type="hidden" class="hidsectionheadprevdiv<?php echo $content_id;?>" value="<?php echo $content_title;?>">
								</div>
								<div class="pl-2 sectionheadinputdivmain sectionheadinputdivmain<?php echo $content_id;?>" style="display:none" data-lession_id="<?php echo $content_id;?>">
									<h3 class="head_h3"><input type="text" class="sectionheadinputdiv sectionheadinputdiv<?php echo $content_id;?>" id="sectionheadinput<?php echo $content_id;?>" data-lession_id="<?php echo $content_id;?>" value="<?php echo $content_title;?>"></h3>
								</div>
							</div>
							<?php 
								if( get_current_user_id()==$author_id ){
							?>
							<div class="content_action">
								<button class="btn btn_danger_state content_delete btn_delete_icon" data-lesson_id="<?php echo $content_id;?>"><i class="<?php echo $square_icon['trash'];?>"></i></button>
								<button class="btn btn_normal_state btn_edit_icon editsectionheadingbtn editsectionheadingbtn<?php echo $content_id;?>" data-lesson_id="<?php echo $content_id;?>"><i class="<?php echo $square_icon['edit'];?>"></i></button>
								<div class="swap_up_down">
									<button class="but swap_up" data-lesson_id="<?php echo $content_id;?>" data-order="<?php echo $i;?>"><i class="fa fa-angle-up"></i></button>
									<button class="but swap_down" data-lesson_id="<?php echo $content_id;?>" data-order="<?php echo $i;?>"><i class="fa fa-angle-down"></i></button>
								</div>
							</div>
						<?php }?>
						</div>
					<?php
					}else{
						?>
						<div class="content_list_item content_list_item_<?php echo $content_id;?>" data-count="<?php echo $i;?>" style="border-left:4px solid <?php echo $color;?>">
							<a class="content_list_link color_palette_hyperlinks" href="<?php echo $content_link;?>" data-lession_id="<?php echo $content_id;?>">
								<input type="hidden" id="hid_completed" value="<?php echo $completed;?>">
								<?php /* <div class="content_status is_content_status_<?php echo $content_id;?>" style="background: <?php echo $color;?>;" data-status="<?php echo $completed;?>"></div> */ ?>
								<div class="pl-2"><h5 class="head_h5"><?php echo $content_title;?></h5></div>
							</a>
							<?php 
								if(get_current_user_id()==$author_id)
								{
							?>
							<div class="content_action">
								<button class="btn btn_danger_state content_delete btn_delete_icon" data-lesson_id="<?php echo $content_id;?>"><i class="<?php echo $square_icon['trash'];?>"></i></button>
								<?php 
									if ( metadata_exists( 'post', $content_id, 'content_type' ) && get_post_meta($content_id,'content_type',true)=='poll')
									{
										$url=site_url().'/create-poll/';
										$name='poll_id';
										$value=$content_id;
									}elseif( metadata_exists( 'post', $content_id, 'tool' ) ){
										$url=site_url().'/create-xapi-content/';
										$name='xapi_content_category';
										$value=get_post_meta($content_id,'tool',true);
									}
								?>
								<form action="<?php echo $url;?>" method="post">
									<input type="hidden" name="<?php echo $name;?>" value="<?php echo $value;?>">
									<input type="hidden" name="lesson_id" value="<?php echo $content_id;?>">
									<input type="hidden" name="course_id" value="<?php echo $post->ID;?>">
									<button class="btn btn_normal_state  content_edit btn_edit_icon"><i class="<?php echo $square_icon['edit'];?>"></i></button>
								</form>
								<div class="swap_up_down">
									<button class="but swap_up" data-lesson_id="<?php echo $content_id;?>" data-order="<?php echo $i;?>"><i class="fa fa-angle-up"></i></button>
									<button class="but swap_down" data-lesson_id="<?php echo $content_id;?>" data-order="<?php echo $i;?>"><i class="fa fa-angle-down"></i></button>
								</div>
							</div>
						<?php }?>
						</div>
						<?php
					} ?>
				<?php
					$i++;
				}
			}
		?>
	</div>
	</div>
	<?php }else{
		if(get_current_user_id()!=$post->post_author){
		?>
		<div class="col-md-12" style="text-align:center"><strong>This Course doesn't have any Content yet.  Please check back later.</strong></div>		<?php
		}
	}
		
		/* for certificate link */
		if($certificate == 'on'){
			if(!empty($course_content)){
				if(!empty($end_time) && isset($end_time)){
					if(!in_array('no',$course_status_for_certificate)){
					$user_id = get_current_user_id();
					$display_name = get_user_by('id',$user_id)->display_name;
					$fname = get_user_meta( $user_id, 'first_name', true );
					$lname = get_user_meta( $user_id, 'last_name', true );
					if( !empty($fname) && !empty($lname) ){
						$display_name = $fname .' '. $lname;
					}
					$course_title = get_the_title();
					$author_id = get_the_author_ID();
					$completion_time = max($end_time);
					$post_info = $post_id;
					$unique_str = base64_encode($user_id.'##'.$post_info.'##'.$completion_time);
					?>
					<div class="certificate_del_main">
						<div class="certificate_link">
							<form method="post" action="<?php echo site_url().'/certificate/'.$unique_str;?>"  target='_blank'>
								<input type="hidden" name="unique_id" value="<?php echo $unique_str;?>">
								<input type="hidden" name="username" value="<?php echo $display_name;?>">
								<input type="hidden" name="course_name" value="<?php echo $course_title;?>">
								<input type="hidden" name="author_id" value="<?php echo $author_id; ?>">
								<input type="hidden" name="completion_time" value="<?php echo $completion_time;?>">
								<input type="hidden" name="post_info" value="<?php echo $post_info;?>">
								<button type="submit" class="add_content content_list viewcertificate p-1"><h5 class="head_h5">Course Certificate</h5></button>
							</form>
						</div>
						<?php if($user_id == $author_id){ ?>
						<div class="certificate_del_btn">
							<div class="btn_danger_state btn_delete_certificate_link btn_delete_icon" data-id="<?php echo $community_edit_id;?>">
								<i class="<?php echo $square_icon['trash'];?>"></i>
							</div>
						</div>
					<?php } ?>
					</div>
					<?php } 
				}
			}
		}
		?>	
	<?php
	
		if(is_user_logged_in())
		{
			if(get_current_user_id()==$post->post_author)
			{
				?>
				<div class="add_content_main_div mt-4">
					<div class="add_content_div add_content" data-toggle="modal" data-target="#exampleModalCenter">
						<span class="">Create/Add Content</span>
					</div>
				</div>
				<?php
			}
		}
		
	?>
	
	<div class="col-md-12 order_save" style="display: none;">
		<center><button type="button" class="btn btn_dark_state cancle_lesson_order">Cancel</button>
		<button type="button" class="btn btn_normal_state arrange_order"><i class="<?php  echo $square_icon['save'];?>"></i>&nbsp;&nbsp;Save</button></center>
	</div>
	
	<div class="modal fade course_content_modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title head_h5" id="exampleModalLongTitle">Add Course Content</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row content_selection">
                                <div class="col-md-3 blog_builder">
									<form method="post" action="<?php echo site_url().'/create-blog-post/';?>">
										<input type="hidden" name="course_id" value="<?php echo $post->ID;?>" />
										<button type="submit" class="btn_disabled_state" disabled>Select
										</button>
									</form>
                                </div>
                                <div class="col-md-9">
                                    <span class="content_title1">Block builder (creates a scrolling page of content)</span>
                                </div>
                            </div>
                            <div class="row pt-1 content_selection">
                                <div class="col-md-3">
                                	<form action="<?php echo site_url().'/create-flip-content/';?>" method="post">
                                		<input type="hidden" name="course_id" value="<?php echo $post->ID;?>">
	                                	<button type="submit" class="btn_disabled_state" disabled>
	                                      Select
	                                    </button>
                                	</form>
                                </div>
                                <div class="col-md-9">
                                    <span class="content_title1">Fl1p - Rich Audio Forum or Topic</span>
                                </div>
                            </div>
                           	<div class="row pt-1 content_selection">
                                <div class="col-md-3">
                                   <form action="<?php echo site_url().'/create-xapi-content/';?>" method="post">
                                		<input type="hidden" name="course_id" value="<?php echo $post->ID;?>">
	                                	<button type="submit" class="btn_normal_state">
	                                     	Select
	                                    </button>
                                	</form>
                                </div>
                                <div class="col-md-9">
                                    <span class="content_title1">Articulate zip package</span>
                                </div>
                            </div>
                            <div class="row pt-1 content_selection">
                                <div class="col-md-3">
                                   <form action="<?php echo site_url().'/create-poll/';?>" method="post">
                                		<input type="hidden" name="course_id" value="<?php echo $post->ID;?>">
	                                	<button type="submit" class="btn_normal_state">
	                                     	Select
	                                    </button>
                                	</form>
                                </div>
                                <div class="col-md-9">
                                    <span class="content_title1">Poll Content</span>
                                </div>
                            </div>
							<?php 
								if($certificate == 'on'){ 
									$button_info_class = 'btn_disabled_state btn_cerfificate_disable';
								} else{
									$button_info_class = 'btn_normal_state';
								}
							?>
							<div class="row pt-1 content_selection">
                                <div class="col-md-3">
									<input type="hidden" id="course_id" name="course_id" value="<?php echo $post->ID;?>">
									<button class="<?php echo $button_info_class; ?> add_certificate">
										Select
									</button>
                                </div>
                                <div class="col-md-9">
                                    <span class="content_title1">Certificate</span>
                                </div>
                            </div>
							<?php
							if( get_current_user_id() == $author_id ){
							?>
							<div class="form-group">
								<div class="row pt-1 content_selection">
									<div class="col-md-3">
										<input type="hidden" id="course_id" name="course_id" value="<?php echo $post->ID;?>">
										<button type="button" class="btn_normal_state contentheadingselectbtn">Select</button>
									</div>
									<div class="col-md-9">
										<span class="content_title1 sectionheadingdivspan">Section Heading</span>
									</div>
								</div>
							</div>
							<?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
			<div class="modal" id="certificate_modal" tabindex="-1" role="dialog" aria-labelledby="certificate_modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title head_h5" id="exampleModalLongTitle">Add Certificate</h5>
                        <button type="button" class="certificate_modal_close close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
								<div class="col-md-12">
									<div class="form-group pt-2">
										<div>
											<strong>Certificate</strong>
										</div>
										<div class="pt-2"><label class="certificate_error_msg"></label></div>
										<div>
											<label class="checkbox-inline pt-2 lbl_include_certificate">
												<input type="checkbox" class="chk_certificate" id="chk_certificate" name="lx_certificate">&nbsp;Include Certificate
											</label>			
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="certificate_include_buttons">
										<button class="btn_normal_state add_certificate_link">Add</button>&nbsp;&nbsp;&nbsp;
										<button class="btn_dark_state" data-dismiss="modal" aria-label="Close">cancel</button>
									</div>
								</div>
							</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</div>
