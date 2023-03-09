<?php 
function save_XAPI_content()
{
ob_start();
if( is_user_logged_in() == true && (is_super_admin() || current_user_can('site_owner') || current_user_can('community_owner') || current_user_can('community_manager'))){
global $wpdb,$color_palette,$square_icon,$page_devider;
$course_id=$_POST['course_id'];
$lesson_id=isset($_POST['lesson_id'])?$_POST['lesson_id']:'';  
$category=str_replace('_','-',$_POST['xapi_content_category']);
$author_id = get_current_user_id();
if($lesson_id=='')
{
    $temp_lesson= $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."posts WHERE post_title='temp-lesson' and post_type='lx_lessons' and post_status='draft' and post_author='".$author_id."'");
    if(empty($temp_lesson))
    {
        $arr=array(
            'post_type'=>'lx_lessons',
            'post_status'=>'draft',
            'post_title'=>'temp-lesson',
            'post_author'=>$author_id
        );
        $temp_lesson_id=wp_insert_post($arr);
    }else{
        $metadata=get_post_meta($temp_lesson[0]->ID);
        if(!empty($metadata)){
            foreach($metadata as $key => $val){
                delete_post_meta($temp_lesson[0]->ID,$key);
            }
        }
    }
}
if(!empty($lesson_id)){
    $xapi_content=get_post_meta($lesson_id,'xapi_content',true);
	$certificate=get_post_meta($lesson_id,'lx_xapi_certificate',true);
    $content_type=isset($xapi_content['content_type'])?$xapi_content['content_type']:'';
    $file=isset($xapi_content['content_filename'])?$xapi_content['content_filename']:'';
    $len=strlen("_".get_current_user_id());
    if($file!==''){
        $filename=substr($file,0,-$len).'.zip';
    }
}   
?>
    <style>
        #site-navigation3,.site-footer,.loggedin_logo{
            display: none;
        }
        .form-group small {
            float: right;
        }
        .small-left{
            float: left !important;   
            margin-bottom: .25rem !important;  
        }
        .form-group .title_bottom {
            border-bottom: 1px solid <?php echo $color_palette['light_grey'];?>;
        }

        .file-input {
            display: inline-block;
            text-align: left;
            background: <?php echo $color_palette['white'];?>;
            padding: 4px;
            width: 100%;
            position: relative;
            border-radius: 3px;
            border: 1px solid <?php echo $color_palette['border'];?>;
        }

        .file-input>[type='file'] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            z-index: 10;
            cursor: pointer;
        }

        .file-input>.button {
            display: inline-block;
            cursor: pointer;
            background: <?php echo $color_palette['hyperlinks'];?>;
            color: <?php echo $color_palette['white'];?>;
            padding: 3px 6px;
            border-radius: 4px;
            margin-right: 8px;
        }

        .file-input:hover>.button {
            background: <?php echo $color_palette['hyperlinks'];?>;
            color: <?php echo $color_palette['white'];?>;
        }

        .file-input>.label {
            color: <?php echo $color_palette['charcoal'];?>;
            white-space: nowrap;
        }

        .file-input.-chosen>.label {
            opacity: 1;
        }

        .progress {
            display: -ms-flexbox;
            display: flex;
            height: 0.7rem;
            overflow: hidden;
            line-height: 0;
            font-size: .75rem;
            background-color: <?php echo $color_palette['white'];?>;
            border: 1px solid <?php echo $color_palette['border'];?>;
            border-radius: .25rem;
        }
        .form-check{
            margin-left: 2em !important;
        }
        .form-group .title_bottom {
            padding-bottom: 10px;
            border-bottom: 2px solid <?php echo $color_palette['border'];?>;
        }
        input[type="text"] {
            background: <?php echo $color_palette['white'];?> !important;
        }
        .progress-bar{
            background: <?php echo $color_palette['hyperlinks'];?> !important;
        }
        .disabled{
            width: 100%;
            background: <?php echo $color_palette['light_grey'];?> !important;
        }
    </style>
	<form id="xapi_form">
		<div class="container xapi_container">
			<div class="row">
				<div class="col-md-12 xapi_content">
					<input type="hidden" name="course_id" id="course_id" value="<?php echo $course_id;?>">
                    <input type="hidden" name="lesson_id" id="lesson_id" value="<?php if(!empty($lesson_id)){echo $lesson_id;}?>">
					<input type="hidden" class="hidden_back_link" value="<?php echo  $_SERVER['HTTP_REFERER'];?>"/>
                    <input type="hidden" name="insert_id" id="insert_id" value="<?php if(!empty($temp_lesson_id)){echo $temp_lesson_id;}else{echo $temp_lesson[0]->ID;}?>">
                    <input type="hidden" id="params">
                    <div class="mt-2 mb-4 standarized_tab2">
						<div class="standarized_tab_inner4 course_button_div">
							<div class="button_top_inside_div">
								<<?php echo $page_devider['style'];?>>
								 <?php
									if(isset($lesson_id) && $lesson_id!=''){
										?><div class="heading">Edit Articulate xAPI Zip Package</div><?php
									 }else{   
									   ?><div class="heading">Add Articulate xAPI Zip Package</div>
								<?php } ?>
								</<?php echo $page_devider['style'];?>>
							</div>
							<div class="button_top_inside_div course_buttons">
								<button class="btn btn_normal_state xapi_save"><i class="<?php echo $square_icon['save'];?>"></i>&nbsp;&nbsp;PUBLISH</button>
								<button class="btn_dark_state xapi_back_link">CANCEL</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<label class="lx_xapi_thumbnail">
						<strong for="" data-toggle="popover" title="Thumbnail" id="xapi-thumb-popover" data-placement="bottom"> Thumbnail (optional)&nbsp;<label class="question_style"><i class="<?php  echo $square_icon['support'];?>" aria-hidden="true"></i></label>
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
						<div id="xapi-thumb-popover-content" class="popover-content">
							<div>
								<span>This platform has micro-credentials that can be used to add up to a 'whole' course.
								</span>
								<br/>
								<span>If this course is a micro-credential, you can select the associated main course here.</span>
								<br/>
								<br/>
								<div class="text-center">
									<div class="btn btn_normal_state btn_got_it_xapi_thumb" style="cursor: pointer;float:center">Got It</div>
								</div>
							</div>
						</div>
			
                        <div class="dropzone crop_img_course_content">
                            <?php if(!empty($lesson_id)){ 
                                if(!empty(get_post_meta($lesson_id,'module_thumb',true))){   ?>
                                    <div class="btn btn_normal_state thumb_edit btn_edit_icon">
                                        <i class="<?php echo $square_icon['edit'];?>"></i>
                                    </div>
                                    <?php
                                    if(!empty(get_post_meta($lesson_id,'module_thumb',true))){
                                    ?>
                                    <div class="btn_danger_state thumb_delete delete_module_thumbnail btn_delete_icon" data-id="<?php echo $lesson_id;?>" data-cid="<?php echo $course_id;?>">
                                        <i class="<?php echo $square_icon['trash'];?>"></i>
                                    </div>
                                    <?php } ?>
                                    <style>
                                        .crop_img_course_content{
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
                                            border: 1px solid <?php echo $color_palette['border'];?>;
                                        }
                                    </style>
                                    <?php }else{
                                        ?>
                                    <style>
                                        .crop_img_course_content{
                                            top: 210px;
                                        }
                                    </style>    
                                        <?php
                                    }
                                    if(!empty(get_post_meta($lesson_id,'module_thumb',true))){ ?>
                                    <span class="is_edit_img">
                                        <img src="<?php echo get_post_meta($lesson_id,'module_thumb',true);?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image thumb_prev">
                                    </span>
                                
                                    <?php }else{ ?>
                                    <img class="thumb_prev" id="thumb_prev" style="position: absolute;left: 15px;"/>
                                    <?php } ?>
                            <?php }else{ ?>
                                <img class="thumb_prev" id="thumb_prev" style="position: absolute;left: 15px;display:none;"/>
                            <?php } ?>
                                <?php if(!empty(get_post_meta($lesson_id,'module_thumb',true))){ ?>
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
                                <div class="form-group cropping_show_extra_div crop_img_module">
                                    <div  class="upload-icon" >
                                        <div class="container">
                                        <i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
                                            <input type="file" class="upload-input course_content_thumb" id="course_content_thumb" name="course_content_thumb" accept="image/jpg, image/jpeg, image/png"/>
                                            <input type="hidden" id="x" name="x" />
                                            <input type="hidden" id="y" name="y" />
                                            <input type="hidden" id="w" name="w" />
                                            <input type="hidden" id="h" name="h" />
                                            <p><img id="imagePreview" style="display:none;"/></p>
                                        
                                        </div>
                                    </div>
                                </div>
                                <img id="blah" class="card-img-top" src="<?php echo get_stylesheet_directory_uri().'/assets/icons/image_preview2.jpg';?>" style="display:none;">
                                <?php if(!empty(get_post_meta($lesson_id,'module_thumb',true))){}else{ ?>
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
				</div>
				<div class="col-md-6">
					<div class="form-group" style="margin-top:2rem;">
                        <input type="text" class="form-control" id="xapi_module_title" maxlength="80" aria-describedby="emailHelp" value="<?php !empty($lesson_id)? print get_post($lesson_id)->post_title : '';?>" placeholder="Click to add the Module/Lesson Title">
                        <small id="rchars" class="form-text text-muted">80 characters remaining</small>
                    </div>
					<strong class="xapi_label">Content Type</strong>
                    <?php 
                        $parent_cat=get_term_by('slug','content-type-category','category')->term_id;
                        $content_type_cat=get_terms(
                            array(
                                'taxonomy'=>'category',
                                'parent'=>$parent_cat,
                                'hide_empty'=>false
                            )
                        );
                       foreach($content_type_cat as $type){
                        ?>
                        <div class="form-group">
                            <input class="articulate_cat" type="radio" name="articulate_cat" id="<?php echo $type->slug;?>" value="<?php echo $type->term_id;?>" <?php if(isset($category) &&  $category==$type->slug){echo "checked";}?>>
                            <label class="form-check-label" for="<?php echo $type->slug;?>">
                              <?php echo $type->name;?>
                            </label>
                        </div>
                        <?php
                       }
                    ?>
                    <strong class="xapi_label">Format</strong>
                     <div class="form-group">
                        <input type="hidden" name="xapi_format_val" id="xapi_format_val" value="xapi">
                        <input class="xapi_format" type="radio" name="version_selection" id="xapi_format" value="xapi" checked disabled>
                        <label class="form-check-label" for="XAPI_version">
                            XAPI
                        </label>
                    </div>
					<div class="form-group">
                        <strong>Zip Package</strong>
                        <div class='file-input'>
                            <input type='file' id="xapi_file_uploads" class="xapi_file_uploads">
                             <input type="hidden" id="hid_file_url" value="<?php isset($file)? print $file:'';?>">
                            <span class='button'>Choose File</span>
                            <span class='label xapi_file_uploads_lbl' data-js-label><?php isset($filename)?print $filename:"No file selected";?></label></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
							<strong>Certificate</strong>
						</div>
						<div class="chk_xapi_certificate_div">
							<input type="checkbox" class="chk_xapi_certificate" id="chk_xapi_certificate" name="lx_xapi_certificate" <?php if($certificate == 'on'){ echo 'checked';} ?>>&nbsp;
							<label class="checkbox-inline pt-2 lbl_lx_xapi_certificate">
								Completion of this item is required for the certificate
							</label>			
						</div>
                    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
                    <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar" id="verify_pkg_progress" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                        <small id="emailHelp" class="form-text small-left verify_pkg_status"></small>
                        <small id="emailHelp" class="form-text text-muted">Verify Package</small>
                    </div>
                    <div class="form-group pt-4">
                        <div class="progress">
                            <div class="progress-bar  <?php if($content_type=='not_xapi'){echo "disabled";}?>" id="verify_uid_progress" role="progressbar" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                        <small id="emailHelp" class="form-text small-left verify_uid_status"></small>
                        <small id="emailHelp" class="form-text text-muted">Verify Unique ID</small>
                    </div>
                    <div class="form-group pt-4">
                        <div class="progress">
                            <div class="progress-bar" id="upload_progress" role="progressbar" aria-valuenow="25" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                        <small id="emailHelp" class="form-text small-left upload_status"></small>
                        <small id="emailHelp" class="form-text text-muted">Upload to the Cloud Storage</small>
                    </div>
				<div>
			</div>
		</div>
	</div>
	<div class="row pt-4">
		<div class="col-md-12">
			<div class="mt-2 standarized_tab2">
				<div class="standarized_tab_inner4 course_button_div course_bottom_button_div">
					<div class="button_top_inside_div">
					</div>
					<div class="button_top_inside_div course_buttons">
						<button class="btn_normal_state xapi_save"><i class="<?php echo $square_icon['save'];?>"></i>&nbsp;&nbsp;PUBLISH</button>
						<button class="btn_dark_state xapi_back_link">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</form>
    <script>
        var maxLength = 80;
        var textlen = maxLength - jQuery('#xapi_module_title').val().length;
        jQuery('#rchars').text(textlen + " " + "characters remaining");
        jQuery(' #xapi_module_title').keyup(function () {
            var maxLength = 80;
            var textlen = maxLength - $(this).val().length;
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
    </script>
    <script>
        var maxLength = 80;
        var textlen = maxLength - jQuery('#xapi_module_title').val().length;
        jQuery('#rchars').text(textlen + " " + "characters remaining");


        jQuery(document).on('click','.xapi_canvas_close',function(){
            window.history.back();
        });
    </script>
    <script>
        window.addEventListener('DOMContentLoaded', function () {
          var avatar = document.getElementById('blah');
          var image = document.getElementById('image');
          var input = document.getElementById('course_content_thumb');
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
                    jQuery('.crop_img_module').css({'width':'280px','height': '170px'});
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
              canvas = cropper.getCroppedCanvas();
               jQuery('.crop_img_module').css({'height':cropper.getCropBoxData().height,'width':cropper.getCropBoxData().width});
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
                if(jQuery('#lesson_id').val()!=''){
                    var module_id=jQuery('#lesson_id').val();
                }else{
                    var module_id=jQuery('#insert_id').val();
                }
                var course_id=jQuery('#course_id').val();
                var content_thumb=jQuery('#course_content_thumb')[0].files[0];
                var fd=new FormData();      
                fd.append('course_id',course_id);
                fd.append('thumb',content_thumb);
                fd.append('dataurl',canvas.toDataURL());
                fd.append('module_id',module_id);
                fd.append('action','upload_content_thumb');  
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
		
        jQuery(document).on('click','.xapi_canvas_close',function(){
            window.history.back();
        });
		/* popover for xapi-thumb */
			jQuery(function(){
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

			jQuery(document).on('click','.btn_got_it_xapi_thumb',function(){
				jQuery('#xapi-thumb-popover').popover('hide');
			});
    </script>
    <script type="text/javascript">
        var http_referer = {'back':"<?php echo $_SERVER['HTTP_REFERER'];?>"}
    </script>
<?php 
}else{
    echo "<div style='width:100%;color:red;text-align:center;padding:20px;'>You Don't have Access to this page.</div>";
} 
$op=ob_get_clean();
return $op;
}
add_shortcode('save_XAPI_content','save_XAPI_content')
?>