<?php
/**
	@Author: Voidek Webolution
	@Description: Poll Courses Canvas
**/	

global $frontend_icon,$square_icon,$wpdb,$lx_plugin_urls;

/* echo "<pre>";print_r($frontend_icon); */
$course_id=$_POST['course_id'];
$poll_id=isset($_POST['poll_id'])?$_POST['poll_id']:'';  
$author_id = get_current_user_id();
if($poll_id=='')
{
    $temp_poll= $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."posts WHERE post_title='temp-poll' and post_type='lx_lessons' and post_status='draft' and post_author='".$author_id."'");
    if(empty($temp_poll))
    {
        $arr=array(
            'post_type'=>'lx_lessons',
            'post_status'=>'draft',
            'post_title'=>'temp-poll',
            'post_author'=>$author_id
        );
        $poll_id=wp_insert_post($arr);
    }else{
    	$poll_id=$temp_poll[0]->ID;
    }
    $mode='add';
}else{
	$mode='edit';
	$poll=get_post($poll_id);
	$title=$poll->post_title;
	$subtitle=get_post_meta($poll_id,'subtitle',true);	
	$primary_email=get_post_meta($poll_id,'primary_recipient',true);
	$secondary_email=get_post_meta($poll_id,'secondary_recipient',true);
	$restart=get_post_meta($poll_id,'restart_poll',true);
	$req_for_compl=get_post_meta($poll_id,'lx_xapi_certificate',true);
	$avail_in_course=get_post_meta($poll_id,'available_in_course',true);
	$button_label=get_post_meta($poll_id,'button_label',true);
	$include_back_btn=get_post_meta($poll_id,'include_back_button',true);
	$back_nav_link=get_post_meta($poll_id,'back_nav_link',true);
	$submit_prompt=get_post_meta($poll_id,'submit_prompt',true);
}


/** Get only course content (Only XAPI content of perticular course) **/
$getContentsList = $wpdb->get_results("select pm.* from ".$wpdb->prefix."posts as p,".$wpdb->prefix."postmeta as pm where p.ID=pm.post_id and p.post_status='publish' and p.post_type='lx_lessons' and pm.meta_key='course_id' and pm.meta_value='".$course_id."' order by p.menu_order ASC");
?>
<script src="<?php echo POLLCOURESEURL.'assets/js/poll_canvas.js'?>"></script>
<div class="container mt-4" id="pollcourse_main_div">
	<input type="hidden" value="<?php echo $square_icon['trash'];?>" class="trash_icon">
	<div class="vertical-text">
		<form method="post" class="pollcourse_form" id="pollcourse_form">
			<input type="hidden" class="poll_status" value="<?php echo $poll->post_status;?>">
			<input type="hidden" class="course_id" value="<?php echo $course_id;?>">
			<input type="hidden" class="poll_id" value="<?php echo $poll_id;?>">
			<input type="hidden" id="mode" value="<?php echo $mode;?>">
			<div class="mt-2 mb-4 standarized_tab">
				<div class="standarized_tab_inner_top d-flex">
					<div class="top_div_head">
						<h6 class="head_h6">Poll Canvas</h6>
					</div>
					<div class="top_div_button">
						<button type="button" class="btn_normal_state save_poll" data-status="draft">SAVE AS DRAFT</button>
						<button type="button" class="btn_normal_state save_poll" data-status="publish">PUBLISH</button>
						<button type="button" class="btn_dark_state poll_cancle">CANCEL</button>
					</div>
				</div>
			</div>
			<div class="row top_section">
				<div class="col-md-4">
					<div class="form-group title_div">
						<strong>Poll Title</strong>
						<input type="text" class="form-control pc_title" maxlength="80" id="pc_title" name="pc_title" value="<?php isset($title)?print $title:'';?>" placeholder="Click to add the Poll Title" >
						<div class="textarea_max_chars">
							<small class="small_right"><span id="pc_title_chars">80</span> characters remaining</small>
						</div>
					</div>
					<div class="form-group title_div">
						<div>
							<strong>Poll SubTitle</strong>
							<input type="text" class="form-control pc_subtitle" maxlength="80" id="pc_subtitle" name="pc_subtitle" value="<?php isset($subtitle)?print $subtitle:'';?>" placeholder="Click to add a Poll Subtitle (optional)">
							<div class="textarea_max_chars">
								<small class="small_right"><span id="pc_subtitle_chars">80</span> characters remaining</small>
							</div>
						</div>
					</div>
					<?php
						$availincoursechk='';
						$availinval=0;
						$availincoursestyle='display:none;';
						if($avail_in_course=='1'){
							$availincoursechk='checked';
							$availinval=1;
							$availincoursestyle='';
						}
					?>
					<div class="form-group btn_name ai_center" style="<?php echo $availincoursestyle;?>">
						<strong>Button name (eg. 'Reflection')</strong>
						<input type="text" class="form-control" id="in_course_btn_label" style="width:50%;margin-right:10px;" value="<?php isset($button_label)?print $button_label:'';?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group title_div">
						<div>
							<strong>Primary poll results recipient (email)</strong>
							<input type="email" class="form-control" id="primary_recipient_email" name="primary_recipient_email" value="<?php isset($primary_email)?print $primary_email:'';?>">
							<small><span id="recipient_email_error" class="prompt_error_msg"></span></small>
						</div>
					</div>
					<div class="form-group title_div">
						<div>
							<strong>Secondary poll results recipient (optional)</strong>
							<input type="email" class="form-control" id="secondary_recipient_email" name="secondary_recipient_email" value="<?php isset($secondary_email)?print $secondary_email:'';?>">
						</div>
					</div>
					<?php 
					/* lxprint( get_post_meta( $course_id ) ); */
					$isspecificmoduleon = get_post_meta( $poll_id, 'ismoduletoggleon', true );
					$isspecificmoduleid = get_post_meta( $poll_id, 'module_apperain', true );
					$isspecificmodulestyle = 'display:none;';$isspecificmodulechk = '';
					if( $isspecificmoduleon == 1 ){
						$isspecificmodulestyle = '';
						$isspecificmodulechk = 'checked';
					}
					?>
					<div class="form-group title_div plXapimoduleselectionDiv" style="<?php echo $isspecificmodulestyle;?>">
						<div>
							<strong>Module it will appear in:</strong>
							<select class="form-control plXapimoduleselection" name="plXapimoduleselection" id="plXapimoduleselection">
								<option value="0"> Select </option>
								<?php 
								foreach( $getContentsList as $contentmetas ){
									$contentid = $contentmetas->post_id;
									if( !empty(get_post_meta($contentid,'xapi_content',true)) ){
										$isspecificmoduleidsel = '';
										if( !empty($isspecificmoduleid) && $isspecificmoduleid == $contentid ){
											$isspecificmoduleidsel = 'selected';
										}
										?>
										<option <?php echo $isspecificmoduleidsel;?> value="<?php echo $contentid;?>" ><?php echo get_post( $contentid )->post_title?></option>
										<?php
									}
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-4 poll_actions">
					<div class="form-group d-flex main_make_restart ai_center">
							<?php
								$checked='';
								$val=0;
								if($restart==1){
									$checked='checked';
									$val=1;
								}
							?>
							<label class="lx_toggle">
								<input type="checkbox" class="make_restart" id="make_restart" name="make_restart" value="<?php echo $val;?>" <?php echo $checked;?>>
								<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
								<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
							</label>
							<div class="make_restart_text">
								<strong>&nbsp;&nbsp;Allow the user to restart the poll</strong>
							</div>
					</div>
					<div class="form-group d-flex make_course_complete ai_center">
							<?php
								$checked='';
								$val=0;
								if($req_for_compl=='on'){
									$checked='checked';
									$val=1;
								}
							?>
							<label class="lx_toggle">
								<input type="checkbox" class="required_completion" id="required_completion" name="required_completion" value="<?php echo $val;?>" <?php echo $checked;?>>
								<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
								<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
							</label>
							<div class="make_course_complete_text">	
								<strong>&nbsp;&nbsp;Required for Course Completion</strong>
							</div>
					</div>
					<div class="form-group d-flex make_avail_incourse ai_center">
							<label class="lx_toggle">
								<input type="checkbox" class="avail_in_course" id="avail_in_course" name="avail_in_course" value="<?php echo $availinval;?>" <?php echo $availincoursechk;?>>
								<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
								<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
							</label>
							<div class="make_course_complete_text">	
								<strong>&nbsp;&nbsp;Make available 'in-course'</strong>
							</div>
					</div>
					<div class="form-group d-flex makeitSpecifictoModuleDiv ai_center">
						<label class="lx_toggle">
							<input type="checkbox" class="makeitSpecifictoModule" id="makeitSpecifictoModule" name="makeitSpecifictoModule" value="" <?php echo $isspecificmodulechk;?>>
							<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
							<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
						</label>
						<div class="make_course_complete_text">	
							<strong>&nbsp;&nbsp;Make it specific to a module</strong>
						</div>
					</div>
				</div> 
			</div>
			<div style="clear: both;">&nbsp;</div>
			<div class="bottom_section">
				<?php 
					if($mode=='add'){
						include POLLCOURESEPATH.'templates/poll_add.php';
					}else{
						include POLLCOURESEPATH.'templates/poll_edit.php';
					}
				?>
			</div>
			<div class="mt-2 standarized_tab">
				<div class="standarized_tab_inner_bottom">
					<div class="bottom_div_button">
						<button type="button" class="btn_normal_state save_poll" data-status="draft">SAVE AS DRAFT</button>
						<button type="button" class="btn_normal_state save_poll" data-status="publish">PUBLISH</button>
						<button type="button" class="btn_dark_state poll_cancle">CANCEL</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<input type="hidden" class="hidden_back_link_pc" value="<?php echo  $_SERVER['HTTP_REFERER'];?>"/>
</div>
<input type="hidden" class="hid_prev" value="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/add.png';?>">
<input type="hidden" class="hid_lx_poll_img_type" value="">
<input type="hidden" class="hid_lx_poll_img_click" value="">
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
		<button type="button" class="btn btn_normal_state" id="lx_poll_crop_img">Crop</button>
	  </div>
	</div>
  </div>
</div>
<script>
	  window.addEventListener('DOMContentLoaded', function () {
	  	var avatar = document.getElementById('blah');
	  	var image = document.getElementById('image');
		var input = document.getElementById('lx_poll_intro_thumbnail');
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
	        var ext = filename.split('.').pop().toLowerCase();
			if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
				jQuery('.alert_box').html("Please Choose JPG/PNG/JPEG file.");
				jQuery('.alert_box').show();
				setTimeout(function(){
					jQuery('.alert_box').hide();
				},3000);
				return false;
			}
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
	            jQuery('.hid_lx_poll_img_click').val('introduction_thumbnail');
	            jQuery('.hid_lx_poll_img_type').val('introduction');
	        }else{
				jQuery('.thumb_prev').attr('src','');
				jQuery('.thumb_prev').hide();
				jQuery('.crop_intro_img_poll').css({'width':'280px','height': '170px'});
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
		
      	document.getElementById('lx_poll_crop_img').addEventListener('click', function () {
      		var imgCrop=jQuery('.hid_lx_poll_img_click').val();
      		var type=jQuery('.hid_lx_poll_img_type').val();
	        var canvas;
        	$modal.modal('hide');
        	if (cropper) {
          		canvas = cropper.getCroppedCanvas();
				/*jQuery('.'+imgCrop+' .dropzone	').css({'width':'280px','height': '170px'});
				jQuery('.'+imgCrop+' .thumb_prev').css({'width':'280px','height': '170px'});*/
				
				var course_id=jQuery('.course_id').val();
				var poll_id=jQuery('.poll_id').val();
				var mode=jQuery('#mode').val();
				var thumb=jQuery('.'+imgCrop+' input[type=file]')[0].files[0];
				var fd=new FormData();		
				fd.append('course_id',course_id);
				fd.append('poll_id',poll_id)
				fd.append('thumb',thumb);
				fd.append('type',type);
				fd.append('mode',mode);
				if(type=='question'){
					var question_id=jQuery('.'+imgCrop+' .lx_poll_que_thumb').data('questionid');
					if(mode=='edit'){
						fd.append('original_qid',jQuery('.main_question_div'+question_id).data('original_qid'))
					}
					fd.append('question_id',question_id)
				}
				fd.append('dataurl',canvas.toDataURL());
				fd.append('action','upload_poll_thumb');	
				var progressbar = jQuery('.'+imgCrop+' .progress-bar')
				var percentage=0;
				var timer=setInterval(function(){
					percentage=percentage+2;
					if(percentage>99){
						clearInterval(timer);
					}else{
						progressbar.attr('aria-valuenow', percentage);
						progressbar.css('width',percentage+"%");
						progressbar.text(percentage+"%");
					}
				},100);
				jQuery.ajax({
					url : my_ajax_object.ajax_anchor,			
					type: 'POST',
					data: fd,
					contentType: false,
					processData: false,	
					success:function(response){
						progressbar.attr('aria-valuenow', 100);
						progressbar.css('width',"100%");
						progressbar.text("100%");
						
						var res = jQuery.parseJSON(response);
						if(res.status=="1")
						{
							jQuery('.'+imgCrop+' .thumb_prev').attr('src',res.imageURL);
							jQuery('.'+imgCrop+' .thumb_prev').attr('data-uploaded',"1");
							jQuery('.'+imgCrop+' .thumb_prev').show();
							jQuery('.'+imgCrop+' .poll_thumb_upload_status').css({'color':'#09980f !important','font-weight': '600'});
							jQuery('.'+imgCrop+' .poll_thumb_upload_status').html(res.msg);
							clearInterval(timer);
						}else{
							jQuery('.alert_box').html(res.msg);
							jQuery('.alert_box').show();
							setTimeout(function(){
								jQuery('.alert_box').hide();
							},3000);
						}
					},
					error: function (xhr, ajaxOptions, thrownError) {
						if(xhr.status == 413){
							jQuery('.'+imgCrop+' .thumb_prev').css('display','none');
							progressbar.attr('aria-valuenow', 0);
							progressbar.css('width',"0%");
							progressbar.text("0%");
							jQuery('.'+imgCrop+' .poll_thumb_upload_status').css({'color':'red','font-weight': '600'});
							jQuery('.'+imgCrop+' .poll_thumb_upload_status').html('Image size is too large');
						}
					}							
				}); 
				$progress.show();
				$alert.removeClass('alert-success alert-warning');
				canvas.toBlob(function (blob) {});
        	}
        });
    });
</script>	