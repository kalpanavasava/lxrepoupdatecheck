<?php
/**** for logo settings ui ****/ 
global $square_icon,$site_logo_favicon,$color_palette;
$custom_logo_id = get_theme_mod( 'custom_logo' );
$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
$site_icon=get_option('site_icon');
$favicon=wp_get_attachment_image_src( $site_icon , 'full' );
?>
<style>
.have_edit1,.have_edit{
	display:none;
}
img {
  max-width: 100%;
}
</style>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<div class="logos_main_class">
<div class="row pt-5 pb-4">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">SITE BRANDING</h4>
	</div>		
</div>
<div class="row form-group">
	<div class="col-md-12 crop_img_logo_main_div">
		<label class="col-form-label <?php if(!empty($main_logo)){ echo 'pb-5';} ?>">Login and main menu logo(800x170px)
			<div class="dropzone crop_img_logo crop_img_logo_div">
			<?php if(!empty($image)){ 
				if(!empty($image[0])){	?>
					<div class="btn_normal_state thumb_edit">
						<i class="<?php  echo $square_icon['edit'];?>"></i>
					</div>
					<style>
						.crop_img_logo{
							margin-top: 27px;
							top: 235px;
							height: 130.7px;
							width: 250.8px;
							background:  <?php echo $color_palette['white'];?>;
							border:unset;
						}
						.is_edit_img img{
							top: -20px;
							position: relative;
							width:100%;
							border: 1px solid  <?php echo $color_palette['border'];?>;
						}
					</style>							
					<?php }else{
						?>
					<style>
						.crop_img_logo{
							top: 210px;
						}
					</style>	
						<?php
					}
					if(!empty($image)){ ?>
					<span class="is_edit_img">
						<img src="<?php echo $image[0];?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image thumb_prev">
					</span>
				
					<?php }else{ ?>
					<img class="thumb_prev" id="thumb_prev" style="position: absolute;left: 15px;"/>
					<?php } ?>
			<?php }else{ ?>
				<img class="thumb_prev" id="thumb_prev" style="position: absolute;left: 15px;display:none;"/>
			<?php } ?>
				<?php if(!empty($image)){ ?>
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
				<div class="form-group cropping_show_extra_div crop_img_logo">
					<div  class="upload-icon" >
						<div class="container">
						<i class="<?php echo $square_icon['plus'];?>" aria-hidden="true" style="color: #FFFFFF;font-size: 40px;"></i>
							<input type="file" class="upload-input logo_thumbnail" id="logo_thumbnail" name="logo_thumbnail" accept="image/jpg, image/jpeg, image/png" style="height: 200px;width: 200px;position: absolute;top: 0px;left: 17px;"/>
							<input type="hidden" id="x" name="x" />
							<input type="hidden" id="y" name="y" />
							<input type="hidden" id="w" name="w" />
							<input type="hidden" id="h" name="h" />
							<p><img id="imagePreview" style="display:none;"/></p>
						
						</div>
					</div>
				</div>
				<?php if(!empty($image)){}else{ ?>
					<div class="btn_normal_state have_edit">
						<i class="<?php  echo $square_icon['edit']; ?>"></i>
					</div>
				<?php } ?>
			</div>
		</label>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-12 crop_img_logo_favicon_div">
		<label  class="col-form-label">Favicon(300x300px)
		<div class="dropzone crop_img_logo_favicon">
		
		<?php if(!empty($favicon)){ 
			if(!empty($favicon)){	?>
				<div class="btn_normal_state favicon_edit">
					<i class="<?php echo $square_icon['edit'];?>"></i>
				</div>
				<style>
					.crop_img_logo_favicon{
						/* margin-top: 27px; */
						top: 235px;
						height: 130.7px;
						width: 130.7;
						background:  <?php echo $color_palette['white'];?>;
						border:unset;
					}
					.is_edit_img_1 img{
						position: relative;
						max-width: 100%;
						border: 1px solid  <?php echo $color_palette['border'];?>;
					}
					.favicon_progress {
						margin-top:50px;
					}
					.thumb_prev1{
						width:135px;
					}
				</style>
				<input type="hidden" name="hd_edit_favicon_path" id="hd_edit_favicon_path" value="edit_favicon_path" /> 								
				<?php }else{
					?>
				<style>
					.crop_img_logo_favicon{
						top: 210px;
						background-color: #2196f34d;
						border: 1px solid  <?php echo $color_palette['border'];?>;
						height: 145.5px;
						width: 135.5px;
					}
				</style>	
					<?php
				}
				if(!empty($favicon)){ ?>
				<span class="is_edit_img_1">
					<img src="<?php echo $favicon[0];?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image thumb_prev1">
				</span>
			
				<?php }else{ ?>
				<img class="thumb_prev1" id="thumb_prev1" style="position: absolute;left: 15px;"/>
				<?php } ?>
		<?php }else{ ?>
			<img class="thumb_prev1" id="thumb_prev1" style="position: absolute;left: 15px;display:none;"/>
		<?php } ?>
			<?php if(!empty($favicon)){ ?>
			<style>
			.cropping_show_extra_div_favicon{
				display:none;
			}
			.edit_main_div{
				position: relative;
			}
			</style>
			<?php }else{ ?>
			<style>
			.cropping_show_extra_div_favicon{
				display:block;
			}
			</style>
			<?php } ?>
			
			<div class="form-group cropping_show_extra_div_favicon  crop_img_logo_favicon">
				<div  class="upload-favicon" >
					<div class="container">
					<i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
						<input type="file" class="upload-input favicon_thumbnail" id="favicon_thumbnail" name="favicon_thumbnail" accept="image/jpg, image/jpeg, image/png" style=""/>
						<input type="hidden" id="x_1" name="x_1" />
						<input type="hidden" id="y_1" name="y_1" />
						<input type="hidden" id="w_1" name="w_1" />
						<input type="hidden" id="h_1" name="h_1" />
						<p><img id="imagePreview1" style="display:none;"/></p>
					
					</div>
				</div>
				
			</div>
		<?php /* if(!empty($favicon)){}else{ ?>
				<div class="btn_normal_state have_edit1">
					<i class="<?php echo $square_icon['edit'];?>"></i>
				</div>
			<?php } */ ?>
		</label>
		</div>
	</div>
	<img id="blah" class="card-img-top" src="<?php echo get_stylesheet_directory_uri().'/assets/icons/image_preview2.jpg';?>" style="display:none;">
	<img id="favicon_blah" class="card-img-top" src="<?php echo get_stylesheet_directory_uri().'/assets/icons/image_preview2.jpg';?>" style="display:none;">
	<div class="alert" role="alert"></div>
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
	<div class="modal fade" id="favicon_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
			  <img id="favicon_image" src="https://avatars0.githubusercontent.com/u/3456749">
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn_normal_state" id="favicon_crop">Crop</button>
		  </div>
		</div>
	  </div>
	</div>
</div>
</div>
<script>
 window.addEventListener('DOMContentLoaded', function () { 
	var input = document.getElementById('logo_thumbnail');
	var input1 = document.getElementById('favicon_thumbnail');	
	var avatar = document.getElementById('blah');
	var avatar1 = document.getElementById('favicon_blah');
	var image = document.getElementById('image');
	var image1 = document.getElementById('favicon_image');
	var $alert = jQuery('.alert');
	var $modal = jQuery('#modal');
	var $modal1 = jQuery('#favicon_modal');
	var cropper;
	var filename='';
	
	var ajax_path = vw_user_interface_path.ajaxurl;
	
	jQuery('[data-toggle="tooltip"]').tooltip();
	 input.addEventListener('change', function (e) { 
		var $modal = jQuery('#modal');
		var cropper;
		var filename='';
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
			jQuery('.crop_img_logo').css({'width':'280px','height': '170px'});
			jQuery('#blah').attr('src','<?php echo get_stylesheet_directory_uri().'/assets/icons/image_preview2.jpg';?>');
		}
	});
	



	input1.addEventListener('change', function (e) {
		var $modal1 = jQuery('#favicon_modal');
		var cropper;
		var filename='';
		var files = e.target.files;
		
		filename=files[0].name;
		var done = function (url) {
			image1.src = url;
			$alert.hide();
			$modal1.modal({backdrop:'static', keyboard:false});
		};
		var reader;
		var file;
		var url;
		if (files && files.length > 0) {
			file = files[0];
			
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
			jQuery('.thumb_prev1').attr('src','');
			jQuery('.thumb_prev1').hide();
			jQuery('.crop_img_logo_favicon').css({'width':'280px','height': '170px'});
			jQuery('#favicon_blah').attr('src','<?php echo get_stylesheet_directory_uri().'/assets/icons/image_preview2.jpg';?>');
		}
	});
  
	$modal.on('shown.bs.modal', function () {
		cropper = new Cropper(image, {
		  aspectRatio: 80 / 17,
		  viewMode: 1,
		});
	}).on('hidden.bs.modal', function () {
		cropper.destroy();
		cropper = null;
	});
	$modal1.on('shown.bs.modal', function () {
		cropper = new Cropper(image1, {
		  aspectRatio:  1 / 1,
		  viewMode:1,
		});
	}).on('hidden.bs.modal', function () {
		cropper.destroy();
		cropper = null;
	});
	
	document.getElementById('crop').addEventListener('click', function () {
		jQuery('.lp-screen').show();
		var initialAvatarURL;
		var canvas;
		$modal.modal('hide');
		if (cropper) {
			canvas = cropper.getCroppedCanvas();
			jQuery('.crop_img_logo').css({'height':cropper.getCropBoxData().height,'width':cropper.getCropBoxData().width,'background-color':'#fff'});
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
		
			var main_logo_thumb=jQuery('#logo_thumbnail')[0].files[0];
			var fd=new FormData();		

			fd.append('thumb',main_logo_thumb);
			fd.append('dataurl',canvas.toDataURL());

			fd.append('action','fn_upload_logo_thumb');	
			var progressbar=jQuery('#thumb_upload_progress');
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
				url : ajax_path,			
				type: 'POST',
				data: fd,
				contentType: false,
				processData: false,	
				success:function(response){
					var res = jQuery.parseJSON(response);
					if(res.status=="1")
					{
						jQuery(".cthumb_upload_status").html(res.msg);
					}else{
						jQuery('.alert_box').html(res.msg);
						jQuery('.alert_box').show();
						setTimeout(function(){
								jQuery('.alert_box').hide();
						},3000);
					}
					jQuery('.lp-screen').hide();
				}	
			}); 
			/* $progress.show(); */
			$alert.removeClass('alert-success alert-warning');
			canvas.toBlob(function (blob) {});
		}
	});
	
	document.getElementById('favicon_crop').addEventListener('click', function () {
		jQuery('.lp-screen').show();
		var initialAvatarURL;
		var canvas;
		$modal1.modal('hide');
		if (cropper) {
			canvas = cropper.getCroppedCanvas();
			jQuery('.crop_img_logo_favicon').css({'height':cropper.getCropBoxData().height,'width':cropper.getCropBoxData().width,'background-color':'#fff'});
			jQuery('.thumb_prev1').css({'height':cropper.getCropBoxData().height,'width':cropper.getCropBoxData().width});
			jQuery('#x_1').val(Math.round(cropper.getData().x));
			jQuery('#y_1').val(Math.round(cropper.getData().y));
			jQuery('#h_1').val(Math.round(cropper.getData().height));
			jQuery('#w_1').val(Math.round(cropper.getData().width));

			initialAvatarURL = avatar.src;
			avatar1.src = canvas.toDataURL("image/png");
			jQuery('.thumb_prev1').attr('src',avatar1.src);
			jQuery('.thumb_prev1').show();
			jQuery('.have_edit1').show();
			
			var com_thumb=jQuery('#favicon_thumbnail')[0].files[0];
			console.log('com_thumb',com_thumb);
			var fd=new FormData();		
			fd.append('favicon',com_thumb);
			fd.append('dataurl',canvas.toDataURL());
			fd.append('action','fn_upload_logo_favicon_thumb');	
			var progressbar=jQuery('#thumb_upload_progress1');
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
				url : ajax_path,			
				type: 'POST',
				data: fd,
				contentType: false,
				processData: false,	
				success:function(response){
					var res = jQuery.parseJSON(response);
					if(res.status=="1")
					{
						jQuery(".fthumb_upload_status").html(res.msg);
					}else{
						jQuery('.alert_box').html(res.msg);
						jQuery('.alert_box').show();
						setTimeout(function(){
								jQuery('.alert_box').hide();
						},3000);
					}
					jQuery('.lp-screen').hide();
				}	
			});
			$alert.removeClass('alert-success alert-warning');
			canvas.toBlob(function (blob) {});
		} 
	});
	
});
</script>