<?php 
/* for articulate web top ui */
function articulate_top_ui($articulate_id,$formid,$mode_info){ 
global $page_devider;
?>
<style>
.entry-content{
	padding:25px;
}
</style>
<div class="container mt-4 lx_articulate_main">
	<form id="<?php echo $formid; ?>" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-12 mt-2">
				<div class="articulate_web_canvas_buttons">
					<div class="articulate_web_canvas_title">
						<<?php echo $page_devider['style'];?>>
							<?php
								if($mode_info == 'edit_articulate'){
									echo "Edit Articulate Zip Package";
								}else{
									echo "Add Articulate Zip Package";
								}
							?>
						</<?php echo $page_devider['style'];?>>
					</div>
					<div class="btn_main_div">
						<div class="btn_inside_div">
							<button class="btn_normal_state articulate_save">PUBLISH</button>
							<button class="btn_dark_state articulate_back_link">CANCEL</button>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
return;
}
/* for articulate web title and other */
function articulate_title_and_other_ui($args){ ?>
	<div class="col-md-6">
	<?php
		global $wpdb,$square_icon;
		if($args['mode_info'] == 'edit_articulate'){
			$articulate_post=get_post($args['articulate_id']);
			$articulate_title = $articulate_post->post_title;
		}
	 ?>
	
		<div class="row pt-4">
			<div class="col-md-12">
				<input type="hidden" name="articulate_id" id="articulate_id" value="<?php echo $args['content_id'];?>">
				<input type="hidden" id="params">
				<input type="hidden" name="articulate_status" id="articulate_status" value="<?php echo $args['status'];?>">
				<input type="hidden" name="articulate_format_val" id="articulate_format_val" value="not_xapi">
				<input type="hidden" class="hidden_back_link" value="<?php echo  $_SERVER['HTTP_REFERER'];?>"/>
				<div class="form-group">
					<label class="lx_label" for="articulate_title">Title</label>
					<input class="form-control" type="text" id="articulate_title" name="articulate_title" value="<?php if(isset($articulate_title)){ echo $articulate_title; }?>" maxlength="80">
					 <small id="rchars" class="form-text text-muted">80 characters remaining</small>
				</div>
			</div>
		</div>
		<?php
		$articulate_id = $args['articulate_id'];
		if($args['mode_info'] == 'edit_articulate'){
			$content=get_post_meta($articulate_id,'xapi_content',true);
			$content_info=get_post_meta($articulate_id,'articulate_web_category',true);
			if(isset($content['content_tool'])){
				$tool=$content['content_tool'];
			} else if(isset($content_info)){
				$tool = $content_info;
			}
			if(isset($content['content_filename'])){
				$filename=$content['content_filename'].'.zip';
			}
			$resource_url = get_post_meta($articulate_id,'web_url',true);
			$view_selection = get_post_meta($articulate_id,'alt_view_selection',true);
		}
	?>
		<div class="row pt-3">
			<div class="col-md-12">
				<div class="div_categories">
					<div class="div_sub_categories">
						<style>
							.alt_zip_upload,.alt_add_link,.alt_view_selection{
								display:none;
							} 
						</style>
						<?php 
							if(isset($tool)){
								if($tool=='articulate_storyline'){
									$checked1='checked';
									$checked2='';
									$checked3='';
								}elseif($tool=='articulate_rise'){
									$checked1='';
									$checked2='checked';
									$checked3='';
								}elseif($tool=='articulate_web'){
									$checked1='';
									$checked2='';
									$checked3='checked';
								}else{
									$checked1='';
									$checked2='';
									$checked3='';
								}
								if($tool=='articulate_rise' || $tool=='articulate_storyline' ){ ?>
									<style>
										.alt_zip_upload{
											display:block;
										}
									</style>
								<?php	
								}else if($tool=='articulate_web'){
									?>
									<style>
										.alt_add_link,.alt_view_selection{
											display:block;
										}
									</style>
									<?php	
								}
								if(isset($view_selection)){
									if($view_selection == 'popup'){
										$popup_checked = 'checked';
										$newtab_checked = '';
									}else if($view_selection == 'new_tab'){
										$popup_checked = '';
										$newtab_checked = 'checked';
									}
								}
								
							}
							?>
						
						<label class="lx_label" for="articulate_category">Content Type</label>
						<div class="form-check">
							<input class="form-check-input articulate_category" type="radio" id="articulate_category_story" name="articulate_category" value="articulate_storyline" <?php echo $checked1;?>>
							<label class="form-check-label lbl_articulate_category" for="articulate_category_story">Articulate Storyline</label>
						</div>
						<div class="form-check">
							<input class="form-check-input articulate_category" type="radio" id="articulate_category_rise" name="articulate_category" value="articulate_rise" <?php echo $checked2;?>>
							<label class="form-check-label lbl_articulate_category" for="articulate_category_rise">Articulate Rise</label>
						</div>
						<div class="form-check">
							<input class="form-check-input articulate_category" type="radio" id="articulate_category_web" name="articulate_category" value="articulate_web" <?php echo $checked3;?>>
							<label class="form-check-label lbl_articulate_category" for="articulate_category_web">Web URL</label>
						</div>
						<div class="pt-2 alt_add_link">
							<input type="text" class="form-control alt_resource_url" name="alt_resource_url" id="alt_resource_url" placeholder="Add Link" value="<?php if(isset($resource_url)){ echo $resource_url; } ?>" />
						</div>
						<div class="form-group pt-3 alt_view_selection">
							<label class="lx_label">Display Options</label>
							<div class="form-check">
									<input class="form-check-input articulate_display_selection" type="radio" id="articulate_open_new_tab" name="articulate_display_selection" value="new_tab" <?php echo $newtab_checked;?>>
									<label class="form-check-label" for="articulate_open_new_tab">Open a new tab</label>
							</div>
							<div class="form-check">
								<input class="form-check-input articulate_display_selection" type="radio" id="articulate_open_popup" name="articulate_display_selection" value="popup" <?php echo $popup_checked;?>>
								<label class="form-check-label" for="articulate_open_popup">Open as popup</label>
							</div>
						</div>
						<div class="form-group pt-4">
							<div class="alt_zip_upload">
								<div class="form-group pt-4">
									<label class="lx_label">Zip Package</label>
									<div class='file-input'>
										<input type='file' id="articulate_zip_upload" class="articulate_zip_upload" name="articulate_zip">
										<input type="hidden" id="hid_file_url" value="<?php isset($filename)?print $filename:"";?>">
										<span class='button'>Choose File</span>
										<span class='label lbl_articulate_zip_upload' data-js-label><?php isset($filename)?print $filename:"No file selected";?></label></span>
									</div>
								</div>
								<div class="form-group articulate_progress">
									<div class="progress">
										<div class="progress-bar" id="verify_pkg_progress" role="progressbar" aria-valuenow="0" aria-valuemin="0"
											aria-valuemax="100"></div>
									</div>
									<small id="emailHelp" class="form-text small-left verify_pkg_status"></small>
									<small id="emailHelp" class="form-text text-muted">Verify Package</small>
								</div>
								<div class="form-group pt-4 articulate_progress">
									<div class="progress">
										<div class="progress-bar" id="upload_progress" role="progressbar" aria-valuenow="25" aria-valuemin="0"
											aria-valuemax="100"></div>
									</div>
									<small id="emailHelp" class="form-text small-left upload_status"></small>
									<small id="emailHelp" class="form-text text-muted">Upload to the Cloud Storage</small>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
			$articulate_api_inclusions=get_post_meta($articulate_id,'articulate_api_inclusions',true);
			if($articulate_api_inclusions == 'on'){
				$api_inclusions = 'checked';
			} else{
				$api_inclusions = '';
			}
		?>
		<div class="api_inclusions_main_div pb-3">
			<strong for="chk_api_inclusions" class="lx_label" data-toggle="popover" title="API Inclusions" id="api_inclusions-popover" data-placement="bottom"> API Inclusions&nbsp;<label class="question_style"><i class="<?php  echo $square_icon['support'];?>" aria-hidden="true"></i></label>
			</strong>
			<div id="api-inclusions-popover-content" class="popover-content">
				<div>
					<span>If selected, then the user will be recorded in the LMS as 'Attempted', and this can be used for letting a CRM (like Salesforce) know that it's been accessed.
					</span>
					<br/>
					<br/>
					<div class="text-center">
						<div class="btn btn_normal_state btn_got_it_api_inclusions" style="cursor: pointer;float:center">Got It</div>
					</div>
				</div>
			</div>
			<div class="form-check">
				<input class="form-check-input chk_api_inclusions" type="checkbox" id="chk_api_inclusions" name="chk_api_inclusions" <?php echo $api_inclusions;?>>
				<label class="form-check-label lbl_articulate_category" for="chk_api_inclusions">Attempted</label>
			</div>
		</div>
		
	</div>
</div>
<?php
return;
}
/* for articulate web content type ui */
function articulate_content_type_info($args){
	global $wpdb;
	$articulate_id = $args['articulate_id'];
	if($args['mode_info'] == 'edit_articulate'){
		$content=get_post_meta($articulate_id,'xapi_content',true);
		$content_info=get_post_meta($articulate_id,'articulate_web_category',true);
		if(isset($content['content_tool'])){
			$tool=$content['content_tool'];
		} else if(isset($content_info)){
			$tool = $content_info;
		}
		if(isset($content['content_filename'])){
			$filename=$content['content_filename'].'.zip';
		}
		$resource_url = get_post_meta($articulate_id,'web_url',true);
		$view_selection = get_post_meta($articulate_id,'alt_view_selection',true);
	}
?>
	<div class="row pt-4">
		<div class="col-md-12">
			<div class="div_categories">
				<div class="div_sub_categories">
					<style>
						.alt_zip_upload,.alt_add_link,.alt_view_selection{
							display:none;
						} 
					</style>
					<?php 
						if(isset($tool)){
							if($tool=='articulate_storyline'){
								$checked1='checked';
								$checked2='';
								$checked3='';
							}elseif($tool=='articulate_rise'){
								$checked1='';
								$checked2='checked';
								$checked3='';
							}elseif($tool=='articulate_web'){
								$checked1='';
								$checked2='';
								$checked3='checked';
							}else{
								$checked1='';
								$checked2='';
								$checked3='';
							}
							if($tool=='articulate_rise' || $tool=='articulate_storyline' ){ ?>
								<style>
									.alt_zip_upload{
										display:block;
									}
								</style>
							<?php	
							}else if($tool=='articulate_web'){
								?>
								<style>
									.alt_add_link,.alt_view_selection{
										display:block;
									}
								</style>
								<?php	
							}
							if(isset($view_selection)){
								if($view_selection == 'popup'){
									$popup_checked = 'checked';
									$newtab_checked = '';
								}else if($view_selection == 'new_tab'){
									$popup_checked = '';
									$newtab_checked = 'checked';
								}
							}
							
						}
						?>
					
					<label class="lx_label" for="articulate_category">Content Type</label>
					<div class="form-check">
						<input class="form-check-input articulate_category" type="radio" id="articulate_category_story" name="articulate_category" value="articulate_storyline" <?php echo $checked1;?>>
						<label class="form-check-label lbl_articulate_category" for="articulate_category_story">Articulate Storyline</label>
					</div>
					<div class="form-check">
						<input class="form-check-input articulate_category" type="radio" id="articulate_category_rise" name="articulate_category" value="articulate_rise" <?php echo $checked2;?>>
						<label class="form-check-label lbl_articulate_category" for="articulate_category_rise">Articulate Rise</label>
					</div>
					<div class="form-check">
						<input class="form-check-input articulate_category" type="radio" id="articulate_category_web" name="articulate_category" value="articulate_web" <?php echo $checked3;?>>
						<label class="form-check-label lbl_articulate_category" for="articulate_category_web">Web URL</label>
					</div>
					<div class="pt-2 alt_add_link">
						<input type="text" class="form-control alt_resource_url" name="alt_resource_url" id="alt_resource_url" placeholder="Add Link" value="<?php if(isset($resource_url)){ echo $resource_url; } ?>" />
					</div>
					<div class="form-group pt-3 alt_view_selection">
						<label class="lx_label">How Would You like to display it?</label>
						<div class="form-check">
								<input class="form-check-input articulate_display_selection" type="radio" id="articulate_open_new_tab" name="articulate_display_selection" value="new_tab" <?php echo $newtab_checked;?>>
								<label class="form-check-label" for="articulate_open_new_tab">Open a new tab</label>
						</div>
						<div class="form-check">
							<input class="form-check-input articulate_display_selection" type="radio" id="articulate_open_popup" name="articulate_display_selection" value="popup" <?php echo $popup_checked;?>>
							<label class="form-check-label" for="articulate_open_popup">Open as popup</label>
						</div>
					</div>
					<div class="form-group pt-4">
						<div class="alt_zip_upload">
							<div class="form-group pt-4">
								<div class='file-input'>
									<input type='file' id="articulate_zip_upload" class="articulate_zip_upload" name="articulate_zip">
									<input type="hidden" id="hid_file_url" value="<?php isset($filename)?print $filename:"";?>">
									<span class='button'>Choose File</span>
									<span class='label' data-js-label><?php isset($filename)?print $filename:"No file selected";?></label></span>
								</div>
							</div>
							<div class="form-group articulate_progress">
								<div class="progress">
									<div class="progress-bar" id="verify_pkg_progress" role="progressbar" aria-valuenow="0" aria-valuemin="0"
										aria-valuemax="100"></div>
								</div>
								<small id="emailHelp" class="form-text small-left verify_pkg_status"></small>
								<small id="emailHelp" class="form-text text-muted">Verify Package</small>
							</div>
							<div class="form-group pt-4 articulate_progress">
								<div class="progress">
									<div class="progress-bar" id="upload_progress" role="progressbar" aria-valuenow="25" aria-valuemin="0"
										aria-valuemax="100"></div>
								</div>
								<small id="emailHelp" class="form-text small-left upload_status"></small>
								<small id="emailHelp" class="form-text text-muted">Upload to the Cloud Storage</small>
							</div>
						</div>
					</div>
				</div>
				<div class="div_sub_categories">
<?php
return;
}
/* for articulate web content categories */
function articulate_content_category_info($args){
	global $wpdb;
	$term_ids=array();
	$articulate_id = $args['articulate_id'];	
	if($args['mode_info'] == 'edit_articulate'){
		$sel_cat=$wpdb->get_results('select term_taxonomy_id from '.$wpdb->prefix.'term_relationships where object_id="'.$articulate_id.'"');
		foreach($sel_cat as $cat){
			$term_ids[]=$cat->term_taxonomy_id;
		}
	}
	?>
	<div class="main_content_category pt-3">
		<label class="lx_label" for="content_category">Content Category</label>
		<?php 
			$lx_articulate_obj=new lx_articulate_post();
			$categories=$lx_articulate_obj->get_public_category();
			foreach($categories as $term){
				if(in_array($term->term_id,$term_ids)){
					$cheked='checked';
				}
				else{
					$cheked='';
				}
				?>
					<div class="form-check">
						<input class="form-check-input articulate_content_category" type="checkbox" id="content_category_<?php echo $term->slug;?>" name="articulate_content_category[]" value="<?php echo $term->term_id;?>" <?php echo $cheked;?>>
						<label class="form-check-label lbl_articulate_category" for="content_category_<?php echo $term->slug;?>"><?php echo $term->name;?></label>
					</div>
				<?php
			}
		?>
	</div>
</div>
<?php
return;
}
/* for articulate web bottom ui */
function articulate_bottom_ui(){ ?>
	<div class="row">
			<div class="col-md-12">
				<div class="action_btn_bottom">
					<div class="btn_bottom_inside_div">
						<button class="btn_normal_state articulate_save">PUBLISH</button>
						<button class="btn_dark_state articulate_back_link">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<?php
return;	
}
/* for articulate web title and other */
function articulate_script_main(){ ?>
<script>
	var maxLength = 80;
    $('#articulate_title').keyup(function () {
        var textlen = maxLength - jQuery(this).val().length;
        $('#rchars').text(textlen + " " + "characters remaining");
    });

    var inputs = document.querySelectorAll('.file-input')

    for (var i = 0, len = inputs.length; i < len; i++) {
        customInput(inputs[i])
    }

    function customInput(el) {
        const fileInput = el.querySelector('[type="file"]')
        const label = el.querySelector('[data-js-label]')

        fileInput.onchange =
            fileInput.onmouseout = function () {
                if (!fileInput.value) return

                var value = fileInput.value.replace(/^.*[\\\/]/, '')
                el.className += ' -chosen'
                label.innerText = value
            }
    }
    jQuery(document).ready(function(){
    	var maxLength = 80;
        var textlen = maxLength - jQuery('#articulate_title').val().length;
        jQuery('#rchars').text(textlen + " " + "characters remaining");

        jQuery('.articulate_category').change(function(){
            if(jQuery('.articulate_category:checked').val()=='articulate_storyline')
            {
                jQuery('.content_height_width').show();
            }else{
                jQuery('.content_height_width').hide();
            }
        })
        if(jQuery('.articulate_category').is(':checked'))
        {
             if(jQuery('.articulate_category:checked').val()=='articulate_storyline')
            {
                jQuery('.content_height_width').show();
            }else{
                jQuery('.content_height_width').hide();
            }
        }
		jQuery('.content_close').click(function(){
        	window.location.href=my_site_path.site_url;
        });
    });
</script>
<?php 
}
/* for articulate web thumb */
function articulate_web_thumb_ui($args){ 
	global $wpdb,$square_icon;
	$articulate_id = $args['articulate_id'];
?>
<div class="row">
	<div class="col-md-6 pt-4">
		<label class="label lx_articulate_web">
			<strong for="" data-toggle="popover" title="Thumbnail" id="art-web-thumb-popover" data-placement="bottom"> Thumbnail (optional)&nbsp;<label class="question_style"><i class="<?php  echo $square_icon['support'];?>" aria-hidden="true"></i></label>
			</strong>
		   <style>
			.popover{
				max-width:35%;
			}
			@media (max-width: 767px){
				.popover{
					max-width:75%;
				}
			}
			.popover-header{	
				text-align: center;	
			}

			</style>
			<div id="art-web-thumb-popover-content" class="popover-content">
				<div>
					<span>If you add a Thumbnail, it will be used in carousels that include it.
					</span>
					<br/>
					<span>Otherwise the default link/resource icon will be used.</span>
					<br/>
					<br/>
					<div class="text-center">
						<div class="btn btn_normal_state btn_got_it_art_thumb" style="cursor: pointer;float:center">Got It</div>
					</div>
				</div>
			</div>

			<div class="dropzone crop_img_articulate_web_content">
				<?php if(!empty($articulate_id)){ 
					if(!empty(get_post_meta($articulate_id,'articulate_web_thumb',true))){   ?>
						<div class="btn btn_normal_state thumb_edit btn_edit_icon edit_articulate_thumbnail">
							<i class="<?php echo $square_icon['edit'];?>"></i>
						</div>
						<?php
						if(!empty(get_post_meta($articulate_id,'articulate_web_thumb',true))){
						?>
						<div class="btn_danger_state thumb_delete delete_articulate_thumbnail btn_delete_icon" data-id="<?php echo $articulate_id;?>" data-cid="<?php echo $course_id;?>">
							<i class="<?php echo $square_icon['trash'];?>"></i>
						</div>
						<?php } ?>
						<style>
							.crop_img_articulate_web_content{
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
							}
						</style>
						<?php }else{
							?>
						<style>
							.crop_img_articulate_web_content{
								top: 210px;
							}
						</style>    
							<?php
						}
						if(!empty(get_post_meta($articulate_id,'articulate_web_thumb',true))){ ?>
						<span class="is_edit_img">
							<img src="<?php echo get_post_meta($articulate_id,'articulate_web_thumb',true);?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image thumb_prev">
						</span>
					
						<?php }else{ ?>
						<img class="thumb_prev" id="thumb_prev" style="position: absolute;left: 15px;"/>
						<?php } ?>
				<?php }else{ ?>
					<img class="thumb_prev" id="thumb_prev" style="position: absolute;left: 15px;display:none;"/>
				<?php } ?>
					<?php if(!empty(get_post_meta($articulate_id,'articulate_web_thumb',true))){ ?>
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
					<div class="form-group cropping_show_extra_div crop_img_art_web">
						<div  class="upload-icon" >
							<div class="container">
							<i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
								<input type="file" class="upload-input art_content_thumb" id="art_content_thumb" name="art_content_thumb" accept="image/jpg, image/jpeg, image/png"/>
								<input type="hidden" id="x" name="x" />
								<input type="hidden" id="y" name="y" />
								<input type="hidden" id="w" name="w" />
								<input type="hidden" id="h" name="h" />
								<p><img id="imagePreview" style="display:none;"/></p>
							</div>
						</div>
					</div>
					<img id="blah" class="card-img-top" src="<?php echo get_stylesheet_directory_uri().'/assets/icons/image_preview2.jpg';?>" style="display:none;">
					<?php if(!empty(get_post_meta($articulate_id,'articulate_web_thumb',true))){}else{ ?>
					<div class="btn btn_normal_state have_edit btn_edit_icon">
						<i class="<?php echo $square_icon['edit'];?>"></i>
					</div>
			<?php } ?>
			</div>
		</label>
		<div class="form-group pt-4">
			<div class="progress" style="margin-top: 1.5em;">
				<div class="progress-bar" id="cthumb_upload_progress" role="progressbar" aria-valuenow="25" aria-valuemin="0"
					aria-valuemax="100"></div>
			</div>
			<small id="emailHelp" class="form-text small-left cthumb_upload_status"></small>
			<small id="emailHelp" class="form-text text-muted">Upload Thumbnail</small>
		</div>
		<div class="alert" role="alert" style="display:none;"></div>
		<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
<?php	
}
/* for articulate web crop and popover */
function crop_img_articulate_web_and_popover(){ ?>
<script>
	/* popover for xapi-thumb */
	jQuery(function(){
		jQuery("#art-web-thumb-popover").popover({
			html : true, 
			content: function() {
			  return jQuery("#art-web-thumb-popover-content").html();
			},
			title: function() {
			  return jQuery("#art-web-thumb-popover-title").html();
			}
		});
	});

	jQuery(document).on('click','.btn_got_it_art_thumb',function(){
		jQuery('#art-web-thumb-popover').popover('hide');
	});
	
	/* popover for api_inclusions */
	jQuery(function(){
		jQuery("#api_inclusions-popover").popover({
			html : true, 
			content: function() {
			  return jQuery("#api-inclusions-popover-content").html();
			},
			title: function() {
			  return jQuery("#api-inclusions-popover-title").html();
			}
		});
	});

	jQuery(document).on('click','.btn_got_it_api_inclusions',function(){
		jQuery('#api_inclusions-popover').popover('hide');
	});
	window.addEventListener('DOMContentLoaded', function () {
		var avatar = document.getElementById('blah');
		var image = document.getElementById('image');
		var input = document.getElementById('art_content_thumb');
		var $progress = $('.progress');
		var $progressBar = $('.progress-bar');
		var $alert = $('.alert');
		var $modal = $('#modal');
		var cropper;
		var filename='';
		$('[data-toggle="tooltip"]').tooltip();

		input.addEventListener('change', function (e) {
			var files = e.target.files;
			filename=files[0].name;
			var done = function (url) {
			image.src = url;
			$alert.hide();
			$modal.modal({backdrop:'static', keyboard:false});

			};
			var reader;
			var file;
			var url;
			if (files && files.length > 0) {
				file = files[0];
				filename=files[0].name;
				if (URL) {
					done(URL.createObjectURL(file));
				} else if (FileReader) {
					reader = new FileReader();
					reader.onload = function (e) {
						done(reader.result);
					};
					reader.readAsDataURL(file);
				}
			}else{
				jQuery('.thumb_prev').attr('src','');
				jQuery('.thumb_prev').hide();
				jQuery('.crop_img_art_web').css({'width':'280px','height': '170px'});
				jQuery('#blah').attr('src','<?php echo get_stylesheet_directory_uri().'/assets/icons/image_preview2.jpg';?>');
			}

		});

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
		var initialAvatarURL;
		var canvas;

		$modal.modal('hide');

		if (cropper) {
			jQuery(".cthumb_upload_status").html('');
			canvas = cropper.getCroppedCanvas();
			jQuery('.crop_img_art_web').css({'height':cropper.getCropBoxData().height,'width':cropper.getCropBoxData().width});
			jQuery('.thumb_prev').css({'height':cropper.getCropBoxData().height,'width':cropper.getCropBoxData().width});
			jQuery('#x').val(Math.round(cropper.getData().x));
			jQuery('#y').val(Math.round(cropper.getData().y));
			jQuery('#h').val(Math.round(cropper.getData().height));
			jQuery('#w').val(Math.round(cropper.getData().width));
			initialAvatarURL = avatar.src;
			avatar.src = canvas.toDataURL("image/png");
			jQuery('.thumb_prev').attr('src',avatar.src);
			jQuery('.thumb_prev').show();
			jQuery('.have_edit').show();
			var course_id=jQuery('#course_id').val();
			var content_thumb=jQuery('#art_content_thumb')[0].files[0];
			var fd=new FormData();      
			fd.append('thumb',content_thumb);
			fd.append('dataurl',canvas.toDataURL());
			fd.append('content_id',jQuery('#articulate_id').val());
			fd.append('action','upload_articulate_content_thumb');  
			var progressbar=jQuery('#cthumb_upload_progress');
			var percentage=0;
			var timer=setInterval(function(){
				percentage=percentage+10;
				if(percentage>100){
					clearInterval(timer);
				}else{
					progressbar.attr('aria-valuenow', percentage);
					progressbar.css('width',percentage+"%");
					progressbar.text(percentage+"%");
				}
			},700);
			jQuery.ajax({
				url : my_ajax_object.ajax_anchor,           
				type: 'POST',
				data: fd,
				contentType: false,
				processData: false, 
				success:function(response){
					var res = jQuery.parseJSON(response);
					if(res.status=="1")
					{
						jQuery('.cthumb_upload_status').css({'color':'#09980f !important','font-weight': '600'});
						jQuery(".cthumb_upload_status").html(res.msg);
					}else{
						jQuery('.alert_box').html(res.msg);
						jQuery('.alert_box').show();
						setTimeout(function(){
						jQuery('.alert_box').hide();
						},3000);
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
<?php
}
?>