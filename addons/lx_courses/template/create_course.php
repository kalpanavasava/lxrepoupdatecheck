<?php 
global $wpdb,$color_palette,$square_icon,$page_devider,$lx_lms_settings;

$current_user_id=get_current_user_id();

$temp_course=$wpdb->get_results("select * from ".$wpdb->prefix."posts where post_title='temp-course' and  post_author='".$current_user_id."'");

if(empty($temp_course)){
	$arr=array(
		'post_title'=>'temp-course',
		'post_status'=>'draft',
		'post_type'=>'lx_course',
		'post_author'=>$current_user_id
	);
	$course_id=wp_insert_post($arr);
}

$course_id=isset($course_id)?$course_id:$temp_course[0]->ID;
$plugin_name =  plugin_basename(dirname(dirname(dirname(( __FILE__ )))));
$plugin_path =  plugins_url().'/'.$plugin_name;
/* echo $course_id.'---'; */
if(isset($edit_id)){
	$edit_course_id = $edit_id;
	$status_info = get_post($edit_course_id)->post_status;
	if($status_info == 'draft'){
		$btn_text = 'SAVE AS DRAFT';
		$btn_publish_text = 'PUBLISH';
	}else if($status_info == 'publish'){
		$btn_text = 'UNPUBLISH';
		$btn_publish_text = 'UPDATE';
	}
}else{
	$edit_course_id ='';
	$btn_text = 'SAVE AS DRAFT';
	$btn_publish_text = 'PUBLISH';
	$status_info='';
}
if(!empty($edit_course_id)){
	?>
	<input type="hidden" class="edited_course_id" value="<?php echo $edit_course_id;?>"/>
	<input type="hidden" class="edited_course_status" value="edit"/>
	<?php
}else{
	?>
	<input type="hidden" class="edited_course_status" value="add"/>
	<?php
}
?>
<style>
.loggedin_logo{
display: none;
}
.entry-content{
padding:25px;
}
.main-navigation{
display: none;
}

.site-info{
display:none;
}
.text-muted{
float: right !important;
}
.small-left{
float: left !important;   
}
.progress{
height: 0.7rem !important;
}
.progress-bar {
background: <?php echo $color_palette['hyperlinks'];?> !important;
}
</style>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>	
<div class="container mt-4 save_courses_info">
<div class="vertical-text">
<form method="post" class="lx_course_form" id="lx_form_savecourses">
	<div class="mt-2 mb-4 standarized_tab2">
		<div class="standarized_tab_inner4 course_button_div">
			<div class="button_top_inside_div">
				<<?php echo $page_devider['style'];?>>
				<?php if(!empty($edit_course_id)){
					?>
					Edit Course Canvas
					<?php
				}else{
					?>
					Course Canvas
					<?php
				}?>	
				</<?php echo $page_devider['style'];?>>
			</div>
			<div class="button_top_inside_div course_buttons">
				<button class="btn_normal_state lx_save_course draft_lx_course"><?php echo $btn_text; ?></button>
				<button class="btn_normal_state lx_save_course publish_lx_course"><?php echo $btn_publish_text; ?></button>
				<button class="btn_dark_state course_back_link">CANCEL</button>
			</div>
		</div>
	</div>
	<input type="hidden" name="old_save_info" id="old_save_info" value="<?php echo $status_info; ?>">
	<input type="hidden" name="course_id" id="course_id" value="<?php echo $course_id;?>">
	<input type="hidden" name="course_save_status" id="course_save_status">
	<input type="hidden" name="darft_save_info" id="darft_save_info">
	<input type="hidden" id="blah" value="<?php echo get_stylesheet_directory_uri().'/assets/icons/image_preview2.jpg';?>">
	<div class="row">
		<div class="col-md-4">
			<label class="label">Thumbnail (200KB-2MB recommended)
			<div class="dropzone crop_img_course">
				<?php if(!empty($edit_course_id)){ 
				if(!empty(get_post_meta($edit_course_id,'lx_course_thumbnail_path')[0])){	?>
					<div class="btn btn_normal_state thumb_edit btn_edit_icon">
						<i class="<?php echo $square_icon['edit'];?>"></i>
					</div>
					<?php
					if(!empty(get_post_meta($edit_course_id,'lx_course_thumbnail_path')[0])){
					?>
					<div class="btn btn_danger_state thumb_delete delete_course_thumbnail btn_delete_icon" data-id="<?php echo $edit_course_id;?>">
						<i class="<?php echo $square_icon['trash'];?>"></i>
					</div>
					<?php } ?>
					<style>
						.crop_img_course{
							margin-top: 27px;
							top: 235px;
							height: 130.7px;
							width: 200px;
							background: <?php echo $color_palette['white'];?>;
							border:unset;
						}
						.is_edit_img img{
							top: -20px;
							position: relative;
							width:100%;
							border: 1px solid <?php echo $color_palette['border'];?>;
						}
					</style>
					<?php }else{
						?>
					<style>
						.crop_img_course{
							top: 210px;
						}
					</style>	
						<?php
					}
					if(!empty(get_post_meta($edit_course_id,'lx_course_thumbnail_path')[0])){ ?>
					<span class="is_edit_img">
						<img src="<?php echo get_post_meta($edit_course_id,'lx_course_thumbnail_path')[0];?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image thumb_prev">
					</span>
				
					<?php }else{ ?>
					<img class="thumb_prev" id="thumb_prev" style="position: absolute;left: 15px;"/>
					<?php } ?>
					<?php }else{ ?>
					<img class="thumb_prev" id="thumb_prev" style="position: absolute;left: 15px;display:none;"/>
					
					<?php } ?>
					<?php if(!empty(get_post_meta($edit_course_id,'lx_course_thumbnail_path')[0])){ ?>
					<style>
					.cropping_show_extra_div{
						display:none;
					}
					.edit_main_div{
						position: relative;
					}
					</style>
					<?php }else{ ?>
					<style>
					.cropping_show_extra_div{
						display:block;
					}
					</style>
					<?php } ?>
					<div class="form-group cropping_show_extra_div crop_img_course">
						<div  class="upload-icon" >
							<div class="container">
							<i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
								<input type="file" class="upload-input lx_course_thumbnail" id="lx_course_thumbnail" name="lx_course_thumbnail" accept="image/jpg, image/jpeg, image/png"/>
								<input type="hidden" id="x" name="x" />
								<input type="hidden" id="y" name="y" />
								<input type="hidden" id="w" name="w" />
								<input type="hidden" id="h" name="h" />
								<p><img id="imagePreview" style="display:none;"/></p>
							
							</div>
						</div>
					</div>
					<?php if(!empty(get_post_meta($edit_course_id,'lx_course_thumbnail_path')[0])){}else{ ?>
						<div class="btn btn_normal_state have_edit btn_edit_icon">
							<i class="<?php echo $square_icon['edit'];?>"></i>
						</div>
					<?php } ?>
				</div>
			</label>
			<div class="form-group pt-4 thumbnail_progress_main_div">
				<div class="progress">
					<div class="progress-bar" id="cthumb_upload_progress" role="progressbar" aria-valuenow="25" aria-valuemin="0"
						aria-valuemax="100"></div>
				</div>
				<small id="emailHelp" class="form-text small-left cthumb_upload_status"></small>
				<small id="emailHelp" class="form-text text-muted">Upload Thumbnail</small>
			</div>
			<div class="alert" role="alert"></div>
			<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="modalLabel">Crop the image</h5>
					<button type="button" class="close course_cropping_close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<div class="img-container" style="margin:50px;">
					  <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn_normal_state" id="crop">Crop</button>
				  </div>
				</div>
			  </div>
			</div>
			<?php 
			global $lx_lms_settings;
			/*echo "<pre>";print_r($lx_lms_settings);die;*/
			if($lx_lms_settings['course_purchasing_settings'] == 'on' && !empty($lx_lms_settings['course_currency_symbol'])){ 
				$display = "block";
			} else{
				$display = "none";
			}
			?>
			<div class="form-group course_cost_main_div" style="display:<?php echo $display; ?>;">
				<strong>Cost&nbsp;</strong>
				<div>
					<div class="cost_div">
						<input type="number"  min="0.01" max='9999' step="0.01" class="form-control lx_course_cost" id="lx_course_cost" name="lx_course_cost"  pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==4) return false;" value="<?php if(!empty($edit_course_id)){ echo get_post_meta( $edit_course_id,'lx_course_cost')[0];}?>"><label  class="lbl_site_currency_code">&nbsp;<?php echo $lx_lms_settings['course_currency_setting']; ?></label>
					</div>
					<div>
						<label class="lbl_once_off">Once-off</label>
					</div>
				</div>
			</div>
			<?php
			if(is_plugin_active(LX_LMS_PRO)){
				com_course_info_ui_pro($edit_id);
			}else{
				course_attached_info_ui($edit_id);
			}
			?>
			
				<?php 
				if(!empty($edit_course_id)){ 
					$navigation_options = get_post_meta( $edit_course_id,'lx_navigation_options',true);
					$certificate = get_post_meta( $edit_course_id,'lx_certificate',true);
					$macro_course = get_post_meta( $edit_course_id,'lx_associated_macro_course',true);
					$cpd_points = get_post_meta( $edit_course_id,'lx_course_cpd_points',true);
					$course_time = get_post_meta( $edit_course_id,'lx_course_time',true);
					$course_level = get_post_meta( $edit_course_id,'lx_course_levels',true);
					$make_featured = get_post_meta( $edit_course_id,'lx_make_featured',true);
				}
				$navigation_options_array = array(
					array("free","Free"),
					array("restricted","Restricted"),
				);
				$cpd_ceu_pda_levels_array = array(
					array("basic","Basic"),
					array("intermediate","Intermediate"),
					array("intermediate - advanced","Intermediate - Advanced"),
					array("advanced","Advanced")
				);
				
				?>
				<div class="form-group pt-2">
				<strong for="" data-toggle="popover" title="Navigation options" id="navigation-options-popover" data-placement="bottom" class="label_text"> Navigation options &nbsp;<label class="question_style"><i class="<?php  echo $square_icon['support'];?>" aria-hidden="true"></i></label>
								   </strong>	   
				<div id="navigation-options-popover-content" class="popover-content">
					<div>
						<span>'Free' = User can move anywhere in the Course.</span>
						<br/>
						<span>'Restricted' = The learner must complete the previous module before continuing (i.e. they must be completed in sequence)</span>
						<br/>
						<br/>
						<div class="text-center">
							<div class="btn btn_normal_state btn_got_it_navigation_options" style="cursor: pointer;">Got It</div>
						</div>
					</div>
				</div>
				<div>
					<select name="lx_navigation_options" class="form-control navigation_options_selection course_canvas_select" onmouseover="this.size=3;" onmouseout="this.size=1;" style="overflow: auto;" size="1">
						<option value="0">Please select from dropdown</option>
						<?php foreach( $navigation_options_array as $nav_info ){ ?>
								<option value="<?php echo $nav_info[0]; ?>" <?php if( $navigation_options == $nav_info[0] ){ echo 'selected'; } ?>><?php echo $nav_info[1]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group pt-2">
				<div>
					<strong>Certificate</strong>
				</div>
				<div>
					<label class="checkbox-inline pt-2 lbl_api_inclusion">
						<input type="checkbox" class="chk_certificate" id="chk_certificate" name="lx_certificate" <?php if($certificate == 'on'){ echo 'checked';} ?>>&nbsp;Include Certificate
					</label>			
				</div>
			</div>
			<div class="form-group pt-2">
				<div class="main_cpd_and_time">
					<div class="cpd_points_main_div">
						<strong for="" data-toggle="popover" title="CPD Points" id="cpd-points-popover" data-placement="bottom" class="label_text">CPD Points (optional) &nbsp;<label class="question_style"><i class="<?php  echo $square_icon['support'];?>" aria-hidden="true"></i></label></strong>
						<div id="cpd-points-popover-content" class="popover-content">
							<div>
								<span>
									If your site uses CPD Points, then some Course Tiles will display this information.  Otherwise it will just be displayed on the Course Page.
								</span>
								<br/>
								<br/>
								<div class="text-center">
									<div class="btn btn_normal_state btn_got_it_cpd_points" style="cursor: pointer;">Got It</div>
								</div>
							</div>
						</div>
						<input type="number" name="lx_course_cpd_points" id="lx_course_cpd_points" class="course_cpd_points" <?php if(isset($cpd_points) && !empty($cpd_points)){ echo "value=".$cpd_points; } ?>>
					</div>
					
					<div class="course_time_main_div">
						<strong for="" data-toggle="popover" title="Time" id="course-time-popover" data-placement="bottom" class="label_text">Time (hrs) (optional) &nbsp;<label class="question_style"><i class="<?php  echo $square_icon['support'];?>" aria-hidden="true"></i></label></strong>
						<div id="course-time-popover-content" class="popover-content">
							<div>
								<span>
									Some Course Tiles will display this information.  Otherwise it will just be displayed on the Course Page.
								</span>
								<br/>
								<br/>
								<div class="text-center">
									<div class="btn btn_normal_state btn_got_it_course_time" style="cursor: pointer;">Got It</div>
								</div>
							</div>
						</div>
						<input type="text" name="lx_course_time" id="lx_course_time" class="course_time" <?php if(isset($course_time) && !empty($course_time)){ echo "value=".$course_time; } ?>>
					</div>
				</div>
			
			</div>
			<div class="form-group pt-2">
				<div>
					<strong for="" data-toggle="popover" title="CPD/CEU/PDA Levels" id="course-levels-popover" data-placement="bottom" class="label_text">CPD/CEU/PDA Levels (optional) &nbsp;<label class="question_style"><i class="<?php  echo $square_icon['support'];?>" aria-hidden="true"></i></label></strong>
					<div id="course-levels-popover-content" class="popover-content">
						<div>
							<span>
								If your site uses CPD/CEU/PDA Levels, then some Course Tiles will display this information.  Otherwise it will just be displayed on the Course Page.
							</span>
							<br/>
							<br/>
							<div class="text-center">
								<div class="btn btn_normal_state btn_got_it_course_levels" style="cursor: pointer;">Got It</div>
							</div>
						</div>
					</div>
				</div>
				<div>
					<select name="lx_course_levels" class="form-control lx_course_levels course_canvas_select">
						<option value="0">Please select</option>
						<?php foreach( $cpd_ceu_pda_levels_array as $levels_info ){ ?>
								<option value="<?php echo $levels_info[0]; ?>" <?php if( $course_level == $levels_info[0] ){ echo 'selected'; } ?>><?php echo $levels_info[1]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group pt-2">
				<div class="main_make_featured">
					<div>
						<strong>Make 'Featured'&nbsp;&nbsp;&nbsp;&nbsp;</strong>
					</div>
					<div>
						<label class="lx_make_featured_switch">
							<?php 
								if(isset($make_featured)){
									if($make_featured=="on"){
										$checked="checked";
									}else{
										$checked="";
									}
								} else{
									$checked="";
								}
							?>
							<input type="checkbox" class="lx_make_featured" id="lx_make_featured" name="lx_make_featured" <?php echo $checked;?>>
							<span class="slider"></span>
						</label>
					</div>
				</div>
			</div>
		</div>
		<?php 
		$make_featured = get_post_meta( $edit_course_id,'lx_make_featured',true);
		?>
		<div class="col-md-4">
			<div class="form-group title_div">
				<div>
					<label for=""></label>
					<input type="text" class="form-control lx_course_title" maxlength="80" id="lx_course_title" name="lx_course_title" value="<?php if(!empty($edit_course_id)){ echo get_post($edit_course_id)->post_title;}?>" placeholder="Title" >
					<div class="textarea_max_chars">
						<small style="color:#ccc;"><span id="lx_title_chars">80</span> characters remaining</small>
					</div>
					<span class="error_course_title" style="display:none;color:<?php echo $color_palette['red'];?>;">Title already exist</span>
					<span class="error_emptycourse_title" style="display:none;color:<?php echo $color_palette['red'];?>;">Title can't be empty</span>
				</div>
			</div>
			<div class="form-group title_div">
				<div>
					<label for=""></label>
					<input type="text" class="form-control lx_course_subtitle" maxlength="80" id="lx_course_subtitle" name="lx_course_subtitle" value="<?php if(!empty($edit_course_id)){ echo get_post_meta( $edit_course_id,'lx_course_subtitle')[0];}?>" placeholder="Subtitle (optional)">
					<div class="textarea_max_chars">
						<small style="color:#ccc;"><span id="lx_subtitle_chars">80</span> characters remaining</small>
					</div>
				</div>
			</div>
			<div class="pb-2">
				<strong>Description</strong>
			</div>
			<div class="form-group">
				<textarea class="form-control lx_course_description vw_border_charcoal" id="lx_course_description" name="lx_course_description" rows="5" maxlength="800" placeholder="Description"><?php if(!empty($edit_course_id)){ echo get_post($edit_course_id)->post_content;}?></textarea>
				<div class="textarea_max_chars">
					<small style="color:#ccc;"><span id="chars">800</span> characters remaining</small>
				</div>
			</div>
			<div class="pb-2">
				<strong>Summary</strong>
			</div>
			<div class="form-group">
				<textarea class="form-control lx_course_summary vw_border_charcoal" id="lx_course_summary" name="lx_course_summary" rows="5" maxlength="800" placeholder="Summary (optional)"><?php if(!empty($edit_course_id)){ echo get_post_meta( $edit_course_id,'lx_course_summary')[0];}?></textarea>
				<div class="textarea_max_chars">
					<small style="color:#ccc;"><span id="summary_chars">800</span> characters remaining</small>
				</div>
			</div>
			<div class="pb-2">
				<strong>Outcomes</strong>
			</div>
			<div class="form-group">
				<textarea class="form-control lx_course_outcomes vw_border_charcoal" id="lx_course_outcomes" name="lx_course_outcomes" rows="5" maxlength="800" placeholder="Outcomes (optional)"><?php if(!empty($edit_course_id)){ echo get_post_meta( $edit_course_id,'lx_course_outcomes')[0];}?></textarea>
				<div class="textarea_max_chars">
					<small style="color:#ccc;"><span id="outcomes_chars">800</span> characters remaining</small>
				</div>
			</div>
			<div class="pb-2">
				<strong>Requirements</strong>
			</div>
			<div class="form-group">
				<textarea class="form-control lx_course_requirements vw_border_charcoal" id="lx_course_requirements" name="lx_course_requirements" rows="5" maxlength="800" placeholder="Requirements (optional)"><?php if(!empty($edit_course_id)){  echo get_post_meta( $edit_course_id,'lx_course_requirements')[0];}?></textarea>
				<div class="textarea_max_chars">
					<small style="color:#ccc;"><span id="requirements_chars">800</span> characters remaining</small>
				</div>
			</div>
			<?php 
			if(isset($make_featured)){
				if($make_featured=="on"){
					$display_content_category = "block";
				}else{
					$display_content_category = "none";
				}
			} else{
				$display_content_category = "none";
			}
			?>
			<div class="course_category_info_main" style="display:<?php echo $display_content_category; ?>;">
				<strong>Category</strong>
				<div class="row">
					<?php 
						$parent_cat_id = get_term_by('slug', 'content-category', 'category')->term_id;
						$course_taxonomy_info = get_terms( array(
							'taxonomy' => 'category',
							'hide_empty' => false,
							 'parent' => $parent_cat_id
						) );
						$wpdb->insert($wpdb->prefix."term_relationships", array(
							'term_taxonomy_id' => $term_taxonomy,
							'term_order' => '0',
							'object_id' => $course_id
						));
						if(!empty($edit_course_id)){						
							$content_category_data = $wpdb->get_results("SELECT term_taxonomy_id FROM ".$wpdb->prefix."term_relationships WHERE object_id = '".$edit_course_id."'");
							$content_category_info = array();
							foreach($content_category_data as $term_info){
								array_push($content_category_info,$term_info->term_taxonomy_id);
							}
						}
						foreach($course_taxonomy_info as $course_taxonomy){ 
							if(isset($content_category_info)){
								if (in_array($course_taxonomy->term_id, $content_category_info)){
									$checked_content_info = "checked";
								} else{
									$checked_content_info = "";
								}
							} else{
								$checked_content_info = "";
							}
						?>
						<div class="col-md-4">
							<label class="checkbox-inline pt-2 course_content_category">
								<input type="checkbox" class="chk_content_category" id="chk_content_category" name="chk_content_category[]" value="<?php echo $course_taxonomy->term_id; ?>" <?php echo $checked_content_info; ?>>&nbsp;<?php echo $course_taxonomy->name; ?>
							</label>
						</div>
					<?php
						}
					?>
				</div>
			</div>
			
			<div class="p-2 border mt-2 mb-2" style="background-color:#eee;">
				<a class="" style="text-decoration: underline;" href="javascript:void(0);" data-toggle="popover" title="" id="formatting-popover" data-placement="bottom" data-original-title="Tips for formatting"><span>Tips for formatting</span></a>
				<div id="formatting-popover-content" class="popover-content">
					<b>Bold</b> = *enter text here*<br>
					<i>Italic</i> = _enter text here_<br>
					Next line = ENTER<br>
					Next paragraph = {N} enter text here<br>
				</div>
			</div>
		</div>
		<script>
		jQuery(function(){
			jQuery("#formatting-popover").popover({
				html : true, 
				content: function() {
				  return jQuery("#formatting-popover-content").html();
				},
				title: function() {
				  return jQuery("#formatting-popover-title").html();
				}
			});
		});
		</script>
		<?php 
		if(isset($edit_id)){
			$edit_course_id=$edit_id;
			$status_info = get_post($edit_course_id)->post_status;
			if($status_info == 'draft'){
				$btn_text = 'SAVE AS DRAFT';
				$btn_publish_text = 'PUBLISH';
			}else if($status_info == 'publish'){
				$btn_text = 'UNPUBLISH';
				$btn_publish_text = 'UPDATE';
			}
		}else{
			$edit_course_id='';
			$btn_text = 'SAVE AS DRAFT';
			$btn_publish_text = 'PUBLISH';
		}
		?>
	</div>
	<div class="mt-2 standarized_tab2">
		<div class="standarized_tab_inner4 course_button_div course_bottom_button_div">
			<div class="button_top_inside_div">
			</div>
			<div class="button_top_inside_div course_buttons">
				<button class="btn_normal_state lx_save_course draft_lx_course"><?php echo $btn_text; ?></button>
				<button class="btn_normal_state lx_save_course publish_lx_course"><?php 	 echo $btn_publish_text; ?></button>
				<button class="btn_dark_state course_back_link">CANCEL</button>
			</div>
		</div>
	</div>
	</form>
	</div>
		<input type="hidden" class="hidden_back_link_course" value="<?php echo  $_SERVER['HTTP_REFERER'];?>"/>
	</div>
<script>
var userid_obj = {'userids':"<?php echo get_the_ID();?>"} 
var my_ajax_object = {'ajax_anchor':"<?php echo admin_url( 'admin-ajax.php' );?>"} 
var http_referer = {'back':"<?php echo $_SERVER['HTTP_REFERER'];?>"} 

jQuery('#title-click').click(function() {
   jQuery('.hide_title').css('display','block');
	jQuery('#title-click').css('display','none');
});

jQuery(document).ready(function(){
	var maxLength = 80;
	var length = jQuery('.lx_course_title').val().length;
	var length = maxLength-length;
	jQuery('#lx_title_chars').text(length);
	jQuery('.lx_course_title').keyup(function(){
		var maxLength = 80;
		var length = jQuery(this).val().length;
		  var length = maxLength-length;
		  jQuery('#lx_title_chars').text(length);
	});
});

jQuery(document).ready(function(){
	var maxLength = 80;
	var length = jQuery('.lx_course_subtitle').val().length;
	var length = maxLength-length;
	jQuery('#lx_subtitle_chars').text(length);
	jQuery('.lx_course_subtitle').keyup(function(){
		var maxLength = 80;
		var length = jQuery(this).val().length;
		  var length = maxLength-length;
		  jQuery('#lx_subtitle_chars').text(length);
	});
});

var maxLength = 800;
var length = jQuery('.lx_course_description').val().length;
var length = maxLength-length;
jQuery('#chars').text(length);
jQuery('.lx_course_description').keyup(function() {
  var maxLength = 800;
  var length = jQuery(this).val().length;
  var length = maxLength-length;
  jQuery('#chars').text(length);
});

var maxLength = 800;
var length = jQuery('.lx_course_summary').val().length;
var length = maxLength-length;
jQuery('#summary_chars').text(length);
jQuery('.lx_course_summary').keyup(function() {
  var maxLength = 800;
  var length = jQuery(this).val().length;
  var length = maxLength-length;
  jQuery('#summary_chars').text(length);
});

var maxLength = 800;
var length = jQuery('.lx_course_outcomes').val().length;
var length = maxLength-length;
jQuery('#outcomes_chars').text(length);
jQuery('.lx_course_outcomes').keyup(function() {
  var maxLength = 800;
  var length = jQuery(this).val().length;
  var length = maxLength-length;
  jQuery('#outcomes_chars').text(length);
});

var maxLength = 800;
var length = jQuery('.lx_course_requirements').val().length;
var length = maxLength-length;
jQuery('#requirements_chars').text(length);
jQuery('.lx_course_requirements').keyup(function() {
  var maxLength = 800;
  var length = jQuery(this).val().length;
  var length = maxLength-length;
  jQuery('#requirements_chars').text(length);
});

jQuery('.lx_course_title').on('keydown, keyup', function () {
  if( jQuery('.lx_course_title').val()=='')
  {
	 var texInputValue="example title";
  }else{
	var texInputValue = jQuery('.lx_course_title').val();
  }
   jQuery('.display_title').html(texInputValue);
});

jQuery('.lx_course_description').on('keydown, keyup', function () {
  if( jQuery('.lx_course_description').val()=='')
  {
	 var texInputValue="description";
  }else{
	var texInputValue = jQuery('.lx_course_description').val();
  }
   jQuery('.display_desc').html(texInputValue);
});

</script>
<script>
		/* popover macro course */
		jQuery(function(){
			 /* Enables popover */
			jQuery("#a-macro-course-popover").popover({
				html : true, 
				content: function() {
				  return jQuery("#a-macro-course-popover-content").html();
				},
				title: function() {
				  return jQuery("#a-macro-course-popover-title").html();
				}
			});
			jQuery("#a-this-course-popover").popover({
				html : true, 
				content: function() {
				  return jQuery("#a-this-course-popover-content").html();
				},
				title: function() {
				  return jQuery("#a-this-course-popover-title").html();
				}
			});
		});
		/* popover xapi tumbnail */
		jQuery(function(){
			 /* Enables popover */
			jQuery("#xapi-thumb-popover").popover({
				html : true, 
				content: function() {
				  return jQuery("#xapi-thumb-popover-content").html();
				},
				title: function() {
				  return jQuery("#xapi-thumb-popover-title").html();
				}
			});
		});
		/* popover navigation options */
		jQuery(function(){
			 /* Enables popover */
			jQuery("#navigation-options-popover").popover({
				html : true, 
				content: function() {
				  return jQuery("#navigation-options-popover-content").html();
				},
				title: function() {
				  return jQuery("#navigation-options-popover-title").html();
				}
			});
		});
		/* popover CPD Points*/
		jQuery(function(){
			 /* Enables popover */
			jQuery("#cpd-points-popover").popover({
				html : true, 
				content: function() {
				  return jQuery("#cpd-points-popover-content").html();
				},
				title: function() {
				  return jQuery("#cpd-points-popover-title").html();
				}
			});
		});
		/* popover course time*/
		jQuery(function(){
			 /* Enables popover */
			jQuery("#course-time-popover").popover({
				html : true, 
				content: function() {
				  return jQuery("#course-time-popover-content").html();
				},
				title: function() {
				  return jQuery("#course-time-popover-title").html();
				}
			});
		});
		/* popover course levels*/
		jQuery(function(){
			 /* Enables popover */
			jQuery("#course-levels-popover").popover({
				html : true, 
				content: function() {
				  return jQuery("#course-levels-popover-content").html();
				},
				title: function() {
				  return jQuery("#course-levels-popover-title").html();
				}
			});
		});
		jQuery(document).on('click','.btn_got_it_navigation_options',function(){
			jQuery('#navigation-options-popover').popover('hide');
		});
		jQuery(document).on('click','.btn_got_it_xapi_thumb',function(){
			jQuery('#xapi-thumb-popover').popover('hide');
		});
		jQuery(document).on('click','.btn_got_it_a_macro_course',function(){
			jQuery('#a-macro-course-popover').popover('hide');
		});
		jQuery(document).on('click','.btn_got_it_cpd_points',function(){
			jQuery('#cpd-points-popover').popover('hide');
		});
		jQuery(document).on('click','.btn_got_it_course_time',function(){
			jQuery('#course-time-popover').popover('hide');
		});
		jQuery(document).on('click','.btn_got_it_course_levels',function(){
			jQuery('#course-levels-popover').popover('hide');
		});
	</script>