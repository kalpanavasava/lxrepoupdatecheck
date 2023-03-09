<?php 
/* wp_set_post_categories(26414,array(24,28)); */
/* $user = wp_get_current_user(); */
global $square_icon,$color_palette,$wpdb;
?>
<div class="p-2 mt-2 lx_editor_addnew_blog">
	<div class="row">
		<div class="col-md-12 d-flex justify-content-end">
			<input type="hidden" id="hid_blog_post_id" value="<?php echo $blog_post_id;?>">
			<input type="hidden" class="lxed_hid_post_id" id="lxed_hid_post_id" value="<?php echo $blog_post_id;?>">
			<div class="top_button" style="margin-top:10px;">
				<button class="btn btn_dark_state lxed_cancle_blog_post">CANCEL / DELETE</button>
				<button class="btn btn_normal_state lxed_preview_blog_post lxed_button">PREVIEW</button>
				<button class="btn btn_normal_state lxed_save_draft_blog_post lxed_button"><i class="<?php  echo $square_icon['save'];?>"></i>&nbsp;&nbsp;SAVE AS DRAFT</button>
				<button class="btn btn_normal_state lxed_publish_blog_post lxed_button">PUBLISH</button>
			</div>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col-md-4">
			<div class="image-upload">
			  <label for="lxed_add_thumbnail">
				<div class="dropzone crop_img_course lx_editor_new_blog">	
					<style>
						.crop_img_course{
							top: 210px;
						}
					</style>	
					<img class="lxed_thumbnail_img" style="position: relative;"/>	
						<style>
						.cropping_show_extra_div{
							display:block;
						}
						</style>
					
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
						<div class="btn_normal_state have_edit btn_edit_icon">
							<i class="<?php echo $square_icon['edit'];?>"></i>
						</div>	
						</div>
			  </label>
			  <input type="file" id="lxed_add_thumbnail" class="lxed_add_thumbnail upload-input" name="lxed_add_thumbnail" accept="image/jpg, image/jpeg, image/png" id="file-input" />
				<input type="hidden" id="x" name="x" />
				<input type="hidden" id="y" name="y" />
				<input type="hidden" id="w" name="w" />
				<input type="hidden" id="h" name="h" />
				<input type="hidden" id="hid_thumb_dataurl" name="hid_thumb_dataurl"/>
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
				<input class="form-control lx_input lxed_var_post_title" type="text" placeholder="Title" />
			</div>
			<div class="form-group">
				<textarea class="form-control lx_input lxed_blog_post_excerpt" rows='4' placeholder="Description/Excerpt goes here.."></textarea>
			</div>
		</div>
		<div class="col-md-3">
			<div class="">
				<label class="label_heading">Content Format</label>
				<div class="form-check">
				  <input class="form-check-input lxed_blog_format" type="radio" name="lxed_blog_format" id="lxed_blog_format_break_section" value="break_section" checked>
				  <label class="form-check-label" for="lxed_blog_format_break_section">
					Infinite scroll (each 'BREAK' is represented as a grey line on the page)
				  </label>
				</div>
				<div class="form-check">
				  <input class="form-check-input lxed_blog_format" type="radio" name="lxed_blog_format" id="lxed_blog_format_slideshow" value="slide_show" >
				  <label class="form-check-label" for="lxed_blog_format_slideshow">
					Course-like (each 'BREAK' creates a navigation bar that will display the following section when clicked)
				  </label>
				</div>
			</div>
			
			<div class="mt-2">
				<label class="label_heading">Available In</label>
				<div class="form-check option_div1">
					<?php 
					$comm_checked = '';$comm_checked_divvis = 'display: none;';
					if( current_user_can('community_blog_author') ){
						$comm_checked = 'checked';$comm_checked_divvis = "";
					}
					?>
				  <input class="form-check-input availablity_option" <?php echo $comm_checked;?> type="radio" name="availablity_option" id="lxed_blog_format_in_community" value="in_community">
				  <label class="form-check-label" for="lxed_blog_format_in_community">
					Only Available in My Community
				  </label>
				</div>
				<?php 
				if(is_super_admin() || current_user_can('site_owner')){
				?>
				<div class="form-check option_div2">
				  <input class="form-check-input availablity_option" type="radio" name="availablity_option" id="lxed_blog_format_in_public" value="public">
				  <label class="form-check-label" for="lxed_blog_format_in_public">
					Public
				  </label>
				</div>
				<?php } ?>
			</div>
			 <div class="mt-2 community_select" style="<?php echo $comm_checked_divvis;?>">
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
				<select class="form-check lx_community vw_border_charcoal" id="lx_community" name="lx_community">
					<option value='0'>Select Community</option>
						<?php
						foreach ($communities as $community) {
							?>
							<option value="<?php echo $community->ID;?>"><?php echo $community->post_title;?></option>
							<?php
						}
				?>
				</select>
				<span class="error_course_community" style="display:none;color:<?php echo $color_palette['red'];?>;">Community can't be empty</span>
			</div>
			<div class="mt-2 category_select" style="display: none;">
				<label class="label_heading">Select Category/s</label>
				<div class="" style="height:100px;overflow-y: auto;">
					<?php 
					foreach($vw_var_get_all_publib_categories as $lxed_all_categories_data){
						$lxed_cat_name = $lxed_all_categories_data->name;
						$lxed_term_id = $lxed_all_categories_data->term_id;
						$lxed_term_taxonomy_id = $lxed_all_categories_data->term_taxonomy_id;
					?>
					<div class="form-check">
						<input type="checkbox" class="form-check-input vw_lxed_categories" id="vw_lxed_categories<?php echo $lxed_term_id;?>" value="<?php echo $lxed_term_id;?>" data-term_texo_id = "<?php echo $lxed_term_taxonomy_id;?>">
						<label class="form-check-label" for="vw_lxed_categories<?php echo $lxed_term_id;?>"><?php echo $lxed_cat_name;?></label>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="lxed_border_bottom"></div>
	<div class="lx_editor_blocks_load_here" ></div>
	<div class="lx_editor_blocks">
		<?php
			$imgurl = lx_plugin_url.'assets/img/sample_broken_img.jpg';
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
		</div>
		<div class="lx_block_jt">
			<div class="lx_editor_blocks_inner lx_editor_button_eblock" data-click="lxed_blkbutton" data-is_modal="no">
				<img src="<?php echo lx_plugin_url.'assets/img/buttonimg.png';?>" class="lx_block_button">
			</div>
		</div>
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
					?>
					<div class=""> CLICK AN ICON TO ADD CONTENT </div>
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
<form method="post" id="lxed_fm_edit" action="<?php echo site_url().'/create-blog-post/';?>">
	<input type="hidden" name="mode" value="edit">
	<input type="hidden" name="lxed_blog_post_id" class="hid_lxed_blog_post_id" value="">
	<input type="hidden" name="lxed_blog_post_status" class="hid_lxed_blog_post_status" value="">
	<button type="submit" style="width: 100%;display:none;" name="lxed_edit_mode" class="btn btn_normal_state lxed_edit_mode">Edit</button>
</form>
<input type="hidden" class="hid_file_name" value="" />
<input type="hidden" class="hid_class_click" value="" />
<input type="hidden" class="hid_section_id" value="" />

<script>
	var site_path={'site_url':"<?php echo site_url();?>"};
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
		   jQuery('.crop_img_course').css({'height':cropper.getCropBoxData().height,'width':cropper.getCropBoxData().width});
			jQuery('.lxed_thumbnail_img').css({'height':cropper.getCropBoxData().height,'width':cropper.getCropBoxData().width});		
			jQuery('#x').val(Math.round(cropper.getData().x));
			jQuery('#y').val(Math.round(cropper.getData().y));
			jQuery('#h').val(Math.round(cropper.getData().height));
			jQuery('#w').val(Math.round(cropper.getData().width));
			jQuery('.lp-screen').show();
			jQuery('.upload-icon').css('margin-top', '0px');
			jQuery('.have_edit').show();
			jQuery('.cropping_show_extra_div').hide();
			var blog_post_id=jQuery('#hid_blog_post_id').val();
			if(jQuery('.availablity_option:checked').val()=='in_community')
			{
				var community_id=jQuery('#lx_community').val();
				var dataimage={'mode':'add','blog_post_id':blog_post_id,'dataurl':canvas.toDataURL(),'filename':jQuery('.hid_file_name').val(),'community_id':community_id,'action':'fn_lx_editor_upload_thumbnail'};
			}
			else{
				var dataimage={'mode':'add','blog_post_id':blog_post_id,'dataurl':canvas.toDataURL(),'filename':jQuery('.hid_file_name').val(),'action':'fn_lx_editor_upload_thumbnail'};
			}
			jQuery.ajax({					
				url  : lx_path.ajaxurl,
				type: 'POST',
				data: dataimage,
				dataType: 'html',						
				success  : function(response) {
					jQuery('.lp-screen').hide();
					if(jQuery('.hid_class_click').val() == 'lxed_add_thumbnail'){
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