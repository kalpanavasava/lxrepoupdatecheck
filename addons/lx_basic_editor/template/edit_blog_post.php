<?php
$lxed_blog_post_status = $_POST['lxed_blog_post_status'];
$lxed_blog_post_id = $_POST['lxed_blog_post_id'];
$lxed_last_post = get_post( $lxed_blog_post_id );
$lxed_post_title = $lxed_last_post->post_title;
$lxed_post_excerpt = $lxed_last_post->post_excerpt;
$lxed_post_content = $lxed_last_post->post_content;
$lxed_thumbnail_image = get_post_meta( $lxed_blog_post_id , 'lxed_thumbnail_image' )[0];
$lxede_blog_format = get_post_meta( $lxed_blog_post_id , 'lxede_blog_format' )[0];
$lxed_post_category = get_the_category( $lxed_blog_post_id );
$lxed_post_avail_in = get_post_meta($lxed_blog_post_id,'display_in',true);
if($lxed_post_avail_in=='in_community')
{
	$community_id=get_post_meta($lxed_blog_post_id,'community_id',true);
}
/* echo "<pre>";print_r($lxed_post_content);echo "</pre>"; */
$all_selected_cat_id = array();
foreach($lxed_post_category as $lxed_post_category_data){
	$all_selected_cat_id[] = $lxed_post_category_data->term_id;
}
/* echo $lxed_post_content; */
/* die(); */
global $square_icon,$color_palette,$wpdb;
?>
<input type="hidden" class="lxed_hid_post_id" value="<?php echo $lxed_blog_post_id;?>"/>
	<div class="lxed_render_editmode_html_hid" style="display:none;">
		<?php echo $lxed_post_content;?>
	</div>
<div class="p-2 mt-2 lx_editor_addnew_blog">
	<div class="row">	
		<div class="col-md-12 d-flex justify-content-end">
			<?php if($lxed_blog_post_status == 'publish'){
				?>
				<div class="top_button" style="margin-top:10px;">
					<button class="btn btn_normal_state lxed_update_blog_post lxed_button">UPDATE</button>
					<button class="btn btn_normal_state lxed_view_blog_post lxed_button" data-href="<?php echo get_permalink($lxed_blog_post_id);?>">VIEW</button>
				</div>
				<?php
			}else{
				?>
				<div class="top_button" style="margin-top:10px;">
					<button class="btn btn_dark_state lxed_cancle_blog_post">CANCEL / DELETE</button>
					<button class="btn btn_normal_state lxed_preview_blog_post lxed_button">PREVIEW</button>
					<button class="btn btn_normal_state lxed_save_draft_blog_post lxed_button"><i class="<?php  echo $square_icon['save'];?>"></i>&nbsp;&nbsp;SAVE AS DRAFT</button>
					<button class="btn btn_normal_state lxed_publish_blog_post lxed_button">PUBLISH</button>
				</div>
				<?php
			} ?>
		</div>
	</div>
	<div class="row mt-2 main_row">
		<div class="col-md-4">
			<div class="image-upload">
			  <label for="lxed_add_thumbnail">
				<div class="dropzone crop_img_course">
						<?php	if(!empty($lxed_thumbnail_image)){	?>
								<div class="btn btn_normal_state blog_thumb_edit btn_edit_icon">
									<i class="<?php  echo $square_icon['edit'];?> "></i>
								</div>
								<div class="btn btn_danger_state blog_thumb_delete btn_delete_icon" data-id="<?php echo $community_id;?>">
									<i class="<?php  echo $square_icon['trash']; ?>"></i>
								</div>	
								<style>
									.main_row{
										padding:35px;	
									}
									.crop_img_course{
										margin-top: 27px;
										top: 235px;
										height: 130.7px;
										width: 250.8px;
										background: <?php echo $color_palette['white'];?>;
										border:unset;
									}
									.is_edit_img img{
										top: -20px;
										position: relative;
										width:100%;
										border: 1px solid <?php echo $color_palette['light_grey'];?>;
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
								if(!empty($lxed_thumbnail_image)){ ?>
								<span class="is_edit_img">
									<img class="lxed_thumbnail_img" src="<?php echo $lxed_thumbnail_image;?>"/>
								</span>
								<?php }else{ ?>
								<img class="lxed_thumbnail_img" style="relative: absolute;"/>
								<?php } ?>
								<?php if(!empty($lxed_thumbnail_image)){ ?>
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
							<div class="form-group cropping_show_extra_div">
							<div class="upload-icon">
								<div class="container">
								<i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
									 <input type="file" id="lxed_add_thumbnail" class="lxed_add_thumbnail upload-input" name="lxed_add_thumbnail" accept="image/jpg, image/jpeg, image/png" id="file-input" />
									<input type="hidden" id="x" name="x" />
									<input type="hidden" id="y" name="y" />
									<input type="hidden" id="w" name="w" />
									<input type="hidden" id="h" name="h" />
									<input type="hidden" id="hid_thumb_dataurl" name="hid_thumb_dataurl"/>
									<p><img class="imagePreview" style="display:none;"></p>
								</div>
							</div>
						</div>
							<?php if(!empty($lxed_thumbnail_image)){}else{ ?>
								<div class="btn_normal_state have_edit btn_edit_icon">
									<i class="<?php echo $square_icon['edit'];?>"></i>
								</div>
							<?php } ?>
						</div>
			  </label>
				<div class="modal fade" id="lxed_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="modalLabel">Crop the image</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<input class="form-control lx_input lxed_var_post_title" type="text" placeholder="Title" value="<?php echo $lxed_post_title;?>"/>
			</div>
			<div class="form-group">
				<textarea class="form-control lx_input lxed_blog_post_excerpt" rows='4' placeholder="Description/Excerpt goes here.."><?php echo $lxed_post_excerpt;?></textarea>
			</div>
		</div>	
		<div class="col-md-3">
			<div class="">
				<label class="label_heading">Content Format</label>
				<div class="form-check">
				  <input class="form-check-input lxed_blog_format" type="radio" name="lxed_blog_format" id="lxed_blog_format_break_section" value="break_section" <?php if($lxede_blog_format == 'slide_show'){ }else{ echo 'checked';} ?> >
				  <label class="form-check-label" for="lxed_blog_format_break_section">
					Infinite scroll (each 'BREAK' is represented as a grey line on the page)
				  </label>
				</div>
				<div class="form-check">
				  <input class="form-check-input lxed_blog_format" type="radio" name="lxed_blog_format" id="lxed_blog_format_slideshow" value="slide_show" <?php if($lxede_blog_format == 'slide_show'){ echo 'checked'; }else{ } ?> >
				  <label class="form-check-label" for="lxed_blog_format_slideshow">
					Course-like (each 'BREAK' creates a navigation bar that will display the following section when clicked)
				  </label>
				</div>
			</div>
			<?php 
			if(($lxed_blog_post_status == 'publish' || $lxed_blog_post_status == 'draft') && $lxed_post_avail_in=='in_community'){
				$attr = 'disabled';
				$check1='';
				$check2='disabled';
			}else{
				$attr = '';	
				$check1='disabled';
				$check2='';
			}
			?>
			<div class="mt-2">
				<label class="label_heading">Available In</label>
				<input type="hidden" id="hid_old_avalibility_option" value="<?php echo $lxed_post_avail_in;?>">
				<div class="form-check option_div1">
				  <input class="form-check-input availablity_option" type="radio" name="availablity_option" id="lxed_blog_format_in_community" value="in_community" <?php if($lxed_post_avail_in=='in_community'){echo "checked";}?> <?php echo $attr.' '.$check1; ?> >
				  <label class="form-check-label" for="lxed_blog_format_in_community">
					Only Available in My Community
				  </label>
				</div>
				<div class="form-check option_div2">
				  <input class="form-check-input availablity_option" type="radio" name="availablity_option" id="lxed_blog_format_in_public" value="public" <?php if($lxed_post_avail_in=='public'){echo "checked";}?> <?php echo $check2; ?> >
				  <label class="form-check-label" for="lxed_blog_format_in_public">
					Public
				  </label>
				</div>
			</div>

			<div class="mt-2 community_select" style="display: none;">
				<?php
					$memberpreships = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix ."mepr_members WHERE user_id=".get_current_user_id());
					$user_memberships = $memberpreships[0]->memberships;
					$community_ids = array();$new_membership='';
					if(!empty($user_memberships)){
						$membership_ids = explode(',',$user_memberships);
						foreach( $membership_ids as $cid ){
							$community_ids[] = $cid;
						}
					}
					
					if( current_user_can('administrator') || current_user_can('site_owner') ){
						$args=array(
							'post_type' => 'memberpressproduct',
							'posts_per_page' => -1,
							'post_status' => 'publish',
							'post__in' => $community_ids
						);
						$communities=get_posts($args);
					}else{
						$comidar = array();
						foreach( $community_ids as $commid ){						
							if( !empty($commid) ){
								$getusers = get_post_meta($commid,'community_blog_author_id',true);
								if( !empty($getusers) ){
									$expusers = explode(',',$getusers);
									if( in_array(get_current_user_ID(),$expusers) ){
										$comidar[] = $commid;
									}
								}
							}	
						}
						$args=array(
							'post_type' => 'memberpressproduct',
							'posts_per_page' => -1,
							'post_status' => 'publish',
							'post__in' => $comidar
						);
						$communities=get_posts($args);
					}
				?>
				<label class="label_heading">My Communities</label>
				<input type="hidden" id="hid_community_id" value="<?php echo $community_id;?>">
				<select class="form-check lx_community vw_border_charcoal" id="lx_community" name="lx_community" <?php echo $attr; ?> >
					<option value='0'>Select Community</option>
						<?php
						foreach ($communities as $community) {
							?>
							<option value="<?php echo $community->ID;?>" <?php if(isset($community_id) && $community_id==$community->ID){echo "selected";}?>><?php echo $community->post_title;?></option>
							<?php
						}
				?>
				</select>
				<span class="error_course_community" style="display:none;color:<?php echo $color_palette['red'];?>">Community can't be empty</span>
			</div>
			<div class="mt-2 category_select" style="display: none;">
				<label class="label_heading">Select Category/s</label>
				<div class="" style="height:100px;overflow-y: auto;">
					<?php 
					foreach($vw_var_get_all_publib_categories as $lxed_all_categories_data){
						$lxed_cat_name = $lxed_all_categories_data->name;
						$lxed_term_id = $lxed_all_categories_data->term_id;
						$lxed_term_taxonomy_id = $lxed_all_categories_data->term_taxonomy_id;
						if(in_array($lxed_term_id,$all_selected_cat_id)){
							?>
							<div class="form-check">
								<input type="checkbox" checked class="form-check-input vw_lxed_categories" id="vw_lxed_categories<?php echo $lxed_term_id;?>" value="<?php echo $lxed_term_id;?>" data-term_texo_id = "<?php echo $lxed_term_taxonomy_id;?>" <?php echo $attr; ?> >
								<label class="form-check-label" for="vw_lxed_categories<?php echo $lxed_term_id;?>"><?php echo $lxed_cat_name;?></label>
							</div>	
							<?php
						}else{
							?>
							<div class="form-check">
								<input type="checkbox" class="form-check-input vw_lxed_categories" id="vw_lxed_categories<?php echo $lxed_term_id;?>" value="<?php echo $lxed_term_id;?>" data-term_texo_id = "<?php echo $lxed_term_taxonomy_id;?>" <?php echo $attr; ?> >
								<label class="form-check-label" for="vw_lxed_categories<?php echo $lxed_term_id;?>"><?php echo $lxed_cat_name;?></label>
							</div>
							<?php
						}
					?>	
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-md-4">
		</div>
	</div>
	<div class="lxed_border_bottom"></div>
	<div class="lx_editor_blocks_load_here" >
	</div>
	<div class="lx_editor_blocks">
		<?php
			$imgurl = lx_plugin_url.'assets/img/sample_broken_img.png';
			$get_style = 'background-image: url('.$imgurl.');';
		?>
		<div class=""> CLICK AN ICON TO ADD CONTENT </div>
		<div class="lx_block_jt">
			<div id="lx_editor_text_eblock" class="lx_editor_blocks_inner lx_editor_text_eblock" data-click="lxed_text" data-is_modal="no">
				<img src="<?php echo lx_plugin_url.'assets/img/ic_text_256x256.png';?>" class="lx_block_button">
			</div>
		</div>
		<div class="lx_block_jt">
			<div id="lx_editor_img_eblock" class="lx_editor_blocks_inner lx_editor_img_eblock" data-click="lxed_img" data-is_modal="no">
				<img src="<?php echo lx_plugin_url.'assets/img/ic_image_256x256.png';?>" class="lx_block_button">
			</div>
		</div>
		<div class="lx_block_jt">
			<div id="lx_editor_text_img_eblock" class="lx_editor_blocks_inner lx_editor_text_img_eblock" data-click="lxed_text_img" data-is_modal="no">
				<img src="<?php echo lx_plugin_url.'assets/img/ic_text_256x256.png';?>" style="margin-right:-26px;" class="lx_block_button">
				<img src="<?php echo lx_plugin_url.'assets/img/ic_image_256x256.png';?>" class="lx_block_button">
			</div>
		</div>
		<div class="lx_block_jt">
			<div id="lx_editor_img_text_eblock" class="lx_editor_blocks_inner lx_editor_img_text_eblock" data-click="lxed_img_text" data-is_modal="no">
				<img src="<?php echo lx_plugin_url.'assets/img/ic_image_256x256.png';?>" style="margin-right:-26px;" class="lx_block_button">
				<img src="<?php echo lx_plugin_url.'assets/img/ic_text_256x256.png';?>" class="lx_block_button">
			</div>
		</div>
		<div class="lx_block_jt">
			<div class="lx_editor_blocks_inner lx_editor_vid_eblock" data-click="lxed_video" data-is_modal="no">
				<img src="<?php echo lx_plugin_url.'assets/img/ic_video_256x256.png';?>" class="lx_block_button">
			</div>
		</div>		<div class="lx_block_jt">			<div class="lx_editor_blocks_inner lx_editor_button_eblock" data-click="lxed_blkbutton" data-is_modal="no">				<img src="<?php echo lx_plugin_url.'assets/img/buttonimg.png';?>" class="lx_block_button">			</div>		</div>
		<div class="lx_block_jt">
			<div class="lx_editor_blocks_inner lx_editor_page_break_eblock" data-click="lxed_page_break" data-is_modal="no">
				<img src="<?php echo lx_plugin_url.'assets/img/ic_break_256x256.png';?>" class="lx_block_button">
			</div>
		</div>
		<?php /* <div class=""> KNOWLEDGE CHECK (non-reporting formative assessment) </div>
		<div class="lx_block_jt">
			<div class="lx_editor_blocks_inner lx_editor_single_choice" data-click="lxed_single_choice" data-is_modal="no">
				<img src="<?php echo lx_plugin_url.'assets/img/ic_knowledge-check-single.png';?>" class="lx_block_button">
			</div>
		</div> */ ?>
	</div>
	<input type="hidden" class="lxed_section_prepand" value="">
	<!-- Modal view block editor -->
	<div class="modal fade" id="lxed_block_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-body">
				<div class="lx_editor_blocks lxed_width_100">
					<?php
						$imgurl = lx_plugin_url.'assets/img/sample_broken_img.png';
						$get_style = 'background-image: url('.$imgurl.');';
					?>					<div class=""> CLICK AN ICON TO ADD CONTENT </div>
					<div class="lx_block_jt">
						<div id="lx_editor_text_eblock" class="lx_editor_blocks_inner lx_editor_text_eblock" data-click="lxed_text" data-is_modal="yes">
							<img src="<?php echo lx_plugin_url.'assets/img/ic_text_256x256.png';?>" class="lx_block_button">
						</div>
					</div>
					<div class="lx_block_jt">
						<div id="lx_editor_img_eblock" class="lx_editor_blocks_inner lx_editor_img_eblock" data-click="lxed_img" data-is_modal="yes">
							<img src="<?php echo lx_plugin_url.'assets/img/ic_image_256x256.png';?>" class="lx_block_button">
						</div>
					</div>
					<div class="lx_block_jt">
						<div id="lx_editor_text_img_eblock" class="lx_editor_blocks_inner lx_editor_text_img_eblock" data-click="lxed_text_img" data-is_modal="yes">
							<img src="<?php echo lx_plugin_url.'assets/img/ic_text_256x256.png';?>" style="margin-right:-26px;" class="lx_block_button">
							<img src="<?php echo lx_plugin_url.'assets/img/ic_image_256x256.png';?>" class="lx_block_button">
						</div>
					</div>
					<div class="lx_block_jt">
						<div id="lx_editor_img_text_eblock" class="lx_editor_blocks_inner lx_editor_img_text_eblock" data-click="lxed_img_text" data-is_modal="yes">
							<img src="<?php echo lx_plugin_url.'assets/img/ic_image_256x256.png';?>" style="margin-right:-26px;" class="lx_block_button">
							<img src="<?php echo lx_plugin_url.'assets/img/ic_text_256x256.png';?>" class="lx_block_button">
						</div>
					</div>
					<div class="lx_block_jt">
						<div class="lx_editor_blocks_inner lx_editor_vid_eblock" data-click="lxed_video" data-is_modal="yes">
							<img src="<?php echo lx_plugin_url.'assets/img/ic_video_256x256.png';?>" class="lx_block_button">
						</div>
					</div>
					<div class="lx_block_jt">
						<div class="lx_editor_blocks_inner lx_editor_button_eblock" data-click="lxed_blkbutton" data-is_modal="yes">
							<img src="<?php echo lx_plugin_url.'assets/img/buttonimg.png';?>" class="lx_block_button">
						</div>
					</div>
					<div class="lx_block_jt">
						<div class="lx_editor_blocks_inner lx_editor_page_break_eblock" data-click="lxed_page_break" data-is_modal="yes">
							<img src="<?php echo lx_plugin_url.'assets/img/ic_break_256x256.png';?>" class="lx_block_button">
						</div>
					</div>
					<?php /* <div class=""> KNOWLEDGE CHECK (non-reporting formative assessment) </div>
					<div class="lx_block_jt">
						<div class="lx_editor_blocks_inner lx_editor_single_choice" data-click="lxed_single_choice" data-is_modal="yes">
							<img src="<?php echo lx_plugin_url.'assets/img/ic_knowledge-check-single.png';?>" class="lx_block_button">
						</div>
					</div> */ ?>
				</div>
		  </div>
		</div>
	  </div>
	</div>
</div>
<input type="hidden" class="hid_file_name" value="" />
<input type="hidden" class="hid_class_click" value="" />
<input type="hidden" class="hid_section_id" value="" />
<script>
var site_path={'site_url':"<?php echo site_url();?>"};
jQuery(document).ready(function(){
	if(jQuery('#hid_old_avalibility_option').val()!='')
	{
		var option=jQuery('#hid_old_avalibility_option').val();
		if(option=='in_community')
		{
			jQuery('.community_select').insertAfter('.option_div1');
			jQuery('.community_select').css('margin-top','1rem');
			jQuery('.community_select').show();
			jQuery('.category_select').hide();
		}
		else if(option=='public'){
			jQuery('.category_select').show();
			jQuery('.community_select').hide();
		}
		else{
			jQuery('.community_select').hide();
			jQuery('.category_select').hide();
		}
	}
});
window.addEventListener('DOMContentLoaded', function () {
  var input = document.getElementById('lxed_add_thumbnail');
  var $progress = jQuery('.progress');
  var $progressBar = jQuery('.progress-bar');
  var $alert = jQuery('.alert');
  var $modal = jQuery('#lxed_modal');
  var cropper;
  var filename='';
  $modal.on('shown.bs.modal', function () {
	cropper = new Cropper(image, {
	  aspectRatio: 16 / 9,
	  viewMode: 3, 
	});
  }).on('hidden.bs.modal', function () {
	cropper.destroy();
	cropper = null;
  });
  document.getElementById('crop').addEventListener('click', function () {
	var canvas;
	var section_id = jQuery(this).data('section_id');
	$modal.modal('hide');
	if (cropper) {
	  canvas = cropper.getCroppedCanvas();
		jQuery('#x').val(Math.round(cropper.getData().x));
		jQuery('#y').val(Math.round(cropper.getData().y));
		jQuery('#h').val(Math.round(cropper.getData().height));
		jQuery('#w').val(Math.round(cropper.getData().width));
		jQuery('.lp-screen').show();
		jQuery('.upload-icon').css('margin-top', '0px');
		jQuery('.have_edit').show();
		jQuery('.cropping_show_extra_div').hide();
		var section_img=jQuery('.lxed_block_padding'+jQuery('.hid_section_id').val()+' .image-upload img').attr('src');
		if(jQuery('#hid_old_avalibility_option').val()=='in_community')
		{
			var community_id=jQuery('#hid_community_id').val();
			var dataimage={'mode':'edit','blog_post_id':jQuery('.lxed_hid_post_id').val(),'section_img':section_img,'dataurl':canvas.toDataURL(),'filename':jQuery('.hid_file_name').val(),'community_id':community_id,'action':'fn_lx_editor_upload_thumbnail'};
		}else{
			var dataimage={'mode':'edit','blog_post_id':jQuery('.lxed_hid_post_id').val(),'section_img':section_img,'dataurl':canvas.toDataURL(),'filename':jQuery('.hid_file_name').val(),'action':'fn_lx_editor_upload_thumbnail'};
		}
		jQuery('.crop_img_course').css({'height':cropper.getCropBoxData().height,'width':cropper.getCropBoxData().width});
		jQuery('.lxed_thumbnail_img').css({'height':cropper.getCropBoxData().height,'width':cropper.getCropBoxData().width});
		jQuery.ajax({					
			url  : lx_path.ajaxurl,
			type: 'POST',
			data: dataimage,
			dataType: 'html',						
			success  : function(response) {
				jQuery('.lp-screen').hide();
				if(jQuery('.hid_class_click').val() == 'lxed_add_thumbnail'){
					jQuery('.lxed_thumbnail_img').css('display','block');	
					jQuery('.lxed_thumbnail_img').attr('src',jQuery.trim(response));	
				}else if(jQuery('.hid_class_click').val() == 'lxed_img_block_inp'){
					jQuery('.lxed_img_block_inpimg'+jQuery('.hid_section_id').val()).attr('src',jQuery.trim(response));
				}else if(jQuery('.hid_class_click').val() == 'lxed_txt_img_block_inp'){
					jQuery('.lxed_txt_img_block_inpimg'+jQuery('.hid_section_id').val()).attr('src',jQuery.trim(response));
				}else if(jQuery('.hid_class_click').val() == 'lxed_img_txt_block_inp'){
					jQuery('.lxed_img_txt_block_inpimg'+jQuery('.hid_section_id').val()).attr('src',jQuery.trim(response));
				}
			}
		});
	  $progress.show();
	  $alert.removeClass('alert-success alert-warning');
	  canvas.toBlob(function (blob) {		
	  });
	}
  });
});
</script>
<script>
/** Get the rendered_html **/
jQuery(document).ready(function(){
	jQuery('.lp-screen').show();
	var ajax_path = lx_path.ajaxurl;
	var section_ids_array = [];
	jQuery('.rendered_block').each(function(){
		section_ids_array.push(jQuery(this).data('section_id'));
	});	
	var rand_text_block_array = [];
	jQuery('.rend_text_block').each(function(){
		var section_id = jQuery(this).data('section_id');
		rand_text_block_array[section_id] = jQuery(this).html();
	});	
	var rand_img_block_array = [];
	jQuery('.rend_img_block').each(function(){
		var section_id = jQuery(this).data('section_id');
		rand_img_block_array[section_id] = jQuery(this).find('img').attr('src');
	});
	var break_section = [];
	jQuery('.break_section').each(function(){
		var section_id = jQuery(this).data('section_id');
		break_section[section_id] = 'break';
	});
	var rend_textonly_img_block_array = [];var rend_text_imgonly_block_array = [];
	jQuery('.rend_text_img_block').each(function(){
		var section_id = jQuery(this).data('section_id');
		rend_textonly_img_block_array[section_id] = jQuery('.rend_textonly_img_block'+section_id).html();
		rend_text_imgonly_block_array[section_id] = jQuery('.rend_text_imgonly_block'+section_id).find('img').attr('src');
	});

	var rend_imgonly_text_block_array = [];var rend_img_textonly_block_array = [];
	jQuery('.rend_img_text_block').each(function(){
		var section_id = jQuery(this).data('section_id');
		rend_img_textonly_block_array[section_id] = jQuery('.rend_img_textonly_block'+section_id).html();
		rend_imgonly_text_block_array[section_id] = jQuery('.rend_imgonly_text_block'+section_id).find('img').attr('src');
	});
	
	var rend_btnblk_label = [];var rend_btnblk_dest = [];var rend_btnblk_desc = [];
	jQuery('.rend_btn_block').each(function(){
		var section_id = jQuery(this).data('section_id');
		rend_btnblk_desc[section_id] = jQuery('.rend_btnblk_desc_'+section_id).html();
		rend_btnblk_dest[section_id] = jQuery('.rend_btnblk_dest_'+section_id).attr('href');
		rend_btnblk_label[section_id] = jQuery('.rend_btnblk_btn_'+section_id).html();
	});
	var question_text_array = []; var sect_id_array =[]; var question_id_array =[];
	var ans_text_array =[];var ans_feedtext_array = [];var ans_selected_array = [];
	jQuery('.lxed_single_chose_feedback').each(function(){
		var section_id = jQuery(this).data('section_id');
		var question_id =jQuery(this).data('question_id');
		var loop_id = jQuery(this).data('val');
		ans_text_array.push(jQuery('.lxed_single_chose_answer'+section_id+question_id+loop_id).html());
		ans_feedtext_array.push(jQuery(this).html());
		sect_id_array.push(section_id);
		question_id_array.push(question_id);
		question_text_array.push(jQuery('.single_choice_questext_dv'+section_id+question_id).html());
		ans_selected_array.push(jQuery('.lxed_front_single_choice_radio'+section_id+loop_id+question_id).val());
	});	
	var video_block_array = [];
	jQuery('.lxed_vid_block_inpsource').each(function(){
		var section_id = jQuery(this).data('section_id');
		video_block_array[section_id] = jQuery(this).attr('src');
	});
	var post_data = {
		'section_ids_array':section_ids_array,
		'rand_text_block_array':rand_text_block_array,
		'rand_break_section':break_section,
		'rand_img_block_array':rand_img_block_array,
		'rend_textonly_img_block_array':rend_textonly_img_block_array,
		'rend_text_imgonly_block_array':rend_text_imgonly_block_array,
		'rend_img_textonly_block_array':rend_img_textonly_block_array,
		'rend_imgonly_text_block_array':rend_imgonly_text_block_array,
		'video_block_array':video_block_array,
		'sect_id_array':sect_id_array,
		'question_id_array':question_id_array,
		'question_text_array':question_text_array,
		'ans_selected_array':ans_selected_array,
		'ans_text_array':ans_text_array,
		'ans_feedtext_array':ans_feedtext_array,	
		'rend_btnblk_desc':rend_btnblk_desc,	
		'rend_btnblk_dest':rend_btnblk_dest,	
		'rend_btnblk_label':rend_btnblk_label,	
		'action':'fn_lx_editor_rendered'
		};
		/* return false; */
		jQuery.ajax({					
			url  : ajax_path,
			type: 'POST',
			data: post_data,
			dataType: 'html',						
			success  : function(response) {
				/* console.log(response); */
				jQuery('.lx_editor_blocks_load_here').html(response);
				jQuery('.lp-screen').hide();
			}
		});
});
</script>
<form method="post" id="lxed_fm_edit" action="<?php echo site_url().'/create-blog-post/';?>">
	<input type="hidden" name="mode" value="edit">
	<input type="hidden" name="lxed_blog_post_id" class="hid_lxed_blog_post_id" value="">
	<input type="hidden" name="lxed_blog_post_status" class="hid_lxed_blog_post_status" value="<?php echo $lxed_blog_post_status;?>">
	<button type="submit" style="width: 100%;display:none;" name="lxed_edit_mode" class="btn btn-primary lxed_edit_mode">Edit</button>
</form>