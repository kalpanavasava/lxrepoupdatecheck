/*********************************************************************************/
/********************************* Save Podcast***********************************/
/*********************************************************************************/
 /* change event of hide category selection error msg */
jQuery(document).on('change','#lx_course_category',function(){
	var value=jQuery(this).val();
	if(value!='0')
	{
		jQuery('.error_course_cat').css('display','none');
	}
});
/* function for crop course thumb */
function crop_course_thumb(){
	window.addEventListener('DOMContentLoaded', function () {
	  var avatar = document.getElementById('blah');
	  var image = document.getElementById('image');
	  var input = document.getElementById('lx_course_thumbnail');
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
			jQuery('.crop_img_course').css({'width':'100%','height': '170px'});
			jQuery('#blah').attr('src',jQuery('#blah_img').val());
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
		var canvas;
		$modal.modal('hide');	
		if (cropper) {
		    canvas = cropper.getCroppedCanvas();
			if(jQuery('.edited_course_status').val()=='edit')
			{
				var course_id=jQuery('.edited_course_id').val();
				var mode='edit';
			}else{
				var course_id=jQuery('#course_id').val();
				var mode='add';
			}
			var course_thumb = jQuery('#lx_course_thumbnail')[0].files[0];
			var fd=new FormData();		
			fd.append('course_id',course_id);
			fd.append('thumb',course_thumb);
			fd.append('dataurl',canvas.toDataURL());
			fd.append('mode',mode);
			fd.append('action','upload_course_thumb');	
			var progressbar=jQuery('#cthumb_upload_progress');
			var percentage=0;
			var percentage = 0;
			var timer = setInterval(function(){
				percentage = percentage + 2;
				if( percentage > 100 ){
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
					clearInterval(timer);
					progressbar.attr('aria-valuenow', 100);
					progressbar.css('width',"100%");
					progressbar.text("100%");
					var res = jQuery.parseJSON(response);
					if(mode=="edit"){
						jQuery('.thumbnail_progress_main_div').addClass('pb-4');
					}
					if(res.status=="1")
					{
						jQuery('.course_img').attr('src',res.imageURL);
						jQuery('.course_img').attr('data-uploaded',"1");
						jQuery('.course_img').show();
						/*jQuery('.course_cost_main_div').css('margin-top','45px');*/
						jQuery('.cthumb_upload_status').css({'color':'#09980f !important','font-weight': '600'});
						jQuery(".cthumb_upload_status").html(res.msg);
						if(mode=='add'){
							jQuery('.course_have_edit').show();
						}
					}else{
						jQuery('.alert_box').html(res.msg);
						jQuery('.alert_box').show();
						setTimeout(function(){
								jQuery('.alert_box').hide();
						},3000);
					}
				},
			}); 
		  $progress.show();
		  $alert.removeClass('alert-success alert-warning');
		  canvas.toBlob(function (blob) {});
		}
	  });
	});
}
/* For course canvas form submission */
jQuery(document).on('submit','#lx_form_savecourses',function(e){
	e.preventDefault();
	if(jQuery('.lx_course_title').val()==''){	
		jQuery('.alert_box').html('Title is a required field.');
		jQuery('.alert_box').show();
		setTimeout(function(){
				jQuery('.alert_box').hide();
		},3000);
		return false;	
	}
	if(jQuery('.lx_course_description').val()==''){	
		jQuery('.alert_box').html('Description is a required field.');
		jQuery('.alert_box').show();
		setTimeout(function(){
				jQuery('.alert_box').hide();
		},3000);
		return false;	
	}
	
	if(jQuery('.lx_course_cost').is(':visible') && (jQuery('.lx_course_cost').val() == 0 || jQuery('.lx_course_cost').val() == '')){
		jQuery('.alert_box').html("Please check course fee");
		jQuery('.alert_box').show();
		setTimeout(function(){
				jQuery('.alert_box').hide();
		},2000);
		return false;	
	}
	if( jQuery('.edited_course_status').val() == "edit" && jQuery('#course_save_status').val() == 'draft' && jQuery('#darft_save_info').val() != 'save_as_draft_yes' && jQuery('#old_save_info').val() != 'draft'){ 
		jQuery('.alert_box').addClass('alert_box_draft_popup');
		jQuery('.alert_box').html('<div>This will cause all items (Sub-Communities, Courses, and Lessons) to go into Draft mode.  Are you ok with this?</div><div class="draft_popup_btn_main_class"><button class="btn_normal_state btn_draft_popup_yes" data-dismiss="modal" aria-label="Close">Yes</button><button class="btn_dark_state btn_draft_popup_cancel" data-dismiss="modal" aria-label="Close">Cancel</button></div>');
		jQuery('.alert_box').show();
		$alert = jQuery('.alert_box');
		$alert.modal({backdrop:'static', keyboard:false});
		return false;
	}
	if(jQuery('.error_course_title').is(':visible') == true){
		jQuery('.alert_box').html('Please check the entry.');
		jQuery('.alert_box').show();
		setTimeout(function(){
				jQuery('.alert_box').hide();
		},3000);
	}else{		
		if(jQuery('.lx_course_title').val()==''){
			jQuery('.error_emptycourse_title').show();
		} else if( jQuery('.lx_course_category').val() == '0' ){
			jQuery('.error_course_cat').show();
		}
		else{
			jQuery('.lp-screen').show();
			var fd = new FormData(this);
			fd.append('action','save_course');
			fd.append('edited_course_status',jQuery('.edited_course_status').val());
			fd.append('edited_course_id',jQuery('.edited_course_id').val());
			fd.append('old_avail_option',jQuery('#hid_old_avalibility_option').val());
			fd.append('save_status_info',jQuery('#course_save_status').val());
			jQuery.ajax({					
				url  : my_ajax_object.ajax_anchor,	
				type: 'POST',
				data: fd,
				contentType: false,
				processData: false,						
				success  : function(response) {
					var res = jQuery.parseJSON(response);
					jQuery('.lp-screen').hide();
					if(res.msg=='error'){
						jQuery('.lp-screen').hide();
						jQuery('.lp-screen').hide();
						jQuery('.alert_box').html('Please Check the Image you Uploded');
						jQuery('.alert_box').show();
						setTimeout(function(){
								jQuery('.alert_box').hide();
						},3000);	
					}
					if(res.msg=='exist'){
						jQuery('.lp-screen').hide();
						jQuery('.alert_box').html('Title already Exist!	');
						jQuery('.alert_box').show();
						setTimeout(function(){
								jQuery('.alert_box').hide();
						},3000);	
					}else if(res.msg=='course_inserted'){
						jQuery('.lx_course_thumbnail').val('');
						jQuery('.lx_course_title').val('');
						jQuery('.lx_course_description').val('');
						jQuery('.lx_course_category').val('');
						jQuery('.lp-screen').hide();
						window.location.href=res.link;
					}else if(res.msg=='Updated'){
						jQuery('.lp-screen').hide();
						window.location.href=res.link;
					}
				}
			});
		}
	}
});
/* keyup event for hide course title error msg */
jQuery(document).on('keyup','.lx_course_title',function(){
	jQuery('.error_course_title').hide();
	jQuery('.error_emptycourse_title').hide();
});

/* click events for save course message dismiss */
jQuery(document).ready(function(){
	jQuery('.lx_save_course_suc_dismiss').click(function(){
		jQuery('.lx_save_course_suc').hide();
	});
	jQuery('.course_up_success_dismiss').click(function(){
		jQuery('.course_up_success').hide();
	});
});

/* click event delete course thumbnail */
jQuery(document).on('click','.delete_course_thumbnail',function(e){
	e.preventDefault();
	jQuery('.alert_box').addClass('alert_box_del_thumb_popup');
	jQuery('.alert_box').html('<div>Are you sure you want to delete the thumbnail!</div><div class="del_thumb_popup_main_class"><button class="btn_normal_state btn_del_thumb_popup_yes" data-dismiss="modal" aria-label="Close">Yes</button><button class="btn_dark_state btn_del_thumb_popup_cancel" data-dismiss="modal" aria-label="Close">Cancel</button></div>');
	jQuery('.alert_box').show();
	$alert = jQuery('.alert_box');
	$alert.modal({backdrop:'static', keyboard:false});
});

/* click event delete course module thumbnail */
jQuery(document).on('click','.delete_module_thumbnail',function(e){
	e.preventDefault();
	var r = confirm("Are you sure you want to delete the thumbnail!");
	if (r == true) {
		jQuery('.lp-screen').show();
		var course_id=jQuery(this).data('cid');
		var module_id=jQuery(this).data('id');
		var post_data = {'course_id':course_id,'module_id':module_id,action:'delete_module_thumbnail'};
		jQuery.ajax({					
					url  : my_ajax_object.ajax_anchor,	
					type: 'POST',
					data: post_data,
					dataType: 'html',						
					success  : function(response) {
						location.reload();
						jQuery('.lp-screen').hide();
					}
			});
	} 
});

/* submit event for add fl1p content */
jQuery(document).on('submit','#add_fl1p_content',function(e){
	e.preventDefault();
	var podcast_id=jQuery('#fl1p_forum').val();
	var topic_id=jQuery('#fl1p_topic').val();
	if(jQuery('#fl1p_title').val()=='')
	{
		jQuery('.alert_box').html('Please Enter Title.');
		jQuery('.alert_box').show();
		setTimeout(function(){
				jQuery('.alert_box').hide();
		},3000);
	}
	else if(podcast_id==''){
		jQuery('.alert_box').html("Please Select Forum.!")
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('.alert_box').hide();
		},3000);
	}
	else if(topic_id==''){
		jQuery('.alert_box').html("Please Select Topic.")
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('.alert_box').hide();
		},3000);
	}
	else{
		 jQuery('.lp-screen').show(); 
		var fd=new FormData(this);
		fd.append('edit_lesson_id',jQuery('#lesson_id').val());
		fd.append('action','save_flip_module');
		jQuery.ajax({
			url  : my_ajax_object.ajax_anchor,	
			type: 'POST',
			data: fd,
			contentType: false,
			processData: false,						
			success  : function(response){
				var res = jQuery.parseJSON(response);
				if(res.msg=="exist")
				{
					jQuery('.error_flip_title').show();
					jQuery('.lp-screen').hide();
				}
				else if(res.msg=="inserted")
				{
					window.location.href=http_referer.back;
					jQuery('.lp-screen').hide();
				}else if(res.msg=="updated")
				{
					window.location.href=http_referer.back;
					jQuery('.lp-screen').hide();
				}
			}
		});
	}

});

/* click event for course back link and course close operations */
jQuery(document).on('click','.course_close,.course_back_link',function(e){
	e.preventDefault();
	jQuery('.lp-screen').show();
	/* if(jQuery('.edited_course_status').val()=='add'){ */
		var course_id=jQuery('#course_id').val();
		var mode=jQuery('.edited_course_status').val();
		var post_data={'course_id':course_id,'mode':mode,'action':'delete_course_thumbnail'};
		jQuery.ajax({
			url  : my_ajax_object.ajax_anchor,	
			type: 'POST',
			data: post_data,
			dataType: 'html',						
			success : function(response) {
				jQuery('.lp-screen').hide();
				window.location.href=jQuery('.hidden_back_link_course').val();
			}
		});
	/* }else{
		window.location.href=jQuery('.hidden_back_link_course').val();
	} */
});
/* change event for course content(lesson) upload */
jQuery(document).ready(function(){
	jQuery('.xapi_file_uploads').on('change',function(e){
		var files=e.target.files;
		var length=files.length;
		var filename=files[0].name;
		var extension = filename.substr( (filename.lastIndexOf('.') +1) );
		if(!jQuery('.articulate_cat').is(':checked')) {
			jQuery('.alert_box').html("Please Choose Content Type.");
			jQuery('.alert_box').show();
			setTimeout(function(){
				jQuery('.alert_box').hide();
				jQuery('.xapi_file_uploads_lbl').text('');
				jQuery('.xapi_file_uploads').val('');
			},3000);
			return false;
		}
		if(!jQuery('.xapi_format').is(':checked'))
		{
			jQuery('.alert_box').html("Please Choose Format.");
			jQuery('.alert_box').show();
			setTimeout(function(){
				jQuery('.alert_box').hide();
				jQuery('.xapi_file_uploads_lbl').text('');
				jQuery('.xapi_file_uploads').val('');
			},3000);
			return false;
		}
		if(extension !="zip")
		{
			jQuery('.alert_box').html("File Type Must be ZIP.");
			jQuery('.alert_box').show();
			setTimeout(function(){
				jQuery('.alert_box').hide();
				jQuery('.xapi_file_uploads_lbl').text('');
				jQuery('.xapi_file_uploads').val('');
			},3000);
			return false;
		}
		else
	   {
		var fd=new FormData();
		fd.append("XAPI_attachment", document.getElementById('xapi_file_uploads').files[0]);
		if(jQuery('#lesson_id').val()!=''){
			fd.append("lesson_id",jQuery('#lesson_id').val());
		}else{
			fd.append("lesson_id",jQuery('#insert_id').val());
		}
		fd.append("version_selection",jQuery('#xapi_format_val').val());
		fd.append("tool",jQuery('.articulate_cat:checked').val());
		fd.append('course_id',jQuery('#course_id').val());
		fd.append("process",'verify_package');
		fd.append('action','xapi_zip_upload');
		var progressbar=jQuery('#verify_pkg_progress');
		var percentage=0;
		var timer = setInterval(function(){
			percentage=percentage+10;
			if(percentage>80){
				clearInterval(timer);
			}else{
				progressbar.attr('aria-valuenow', percentage);
				progressbar.css('width',percentage+"%");
				progressbar.text(percentage+"%");
			}
		},1000);
		jQuery.ajax({
			url  : my_ajax_object.ajax_anchor,	
			type: 'POST',
			data: fd,
			contentType: false,
			processData: false,	
			beforeSend :function(){
				jQuery('.xapi_save').attr('disabled','disabled');
				jQuery('.xapi_save').removeClass('btn_normal_state');
				jQuery('.xapi_save').addClass('btn_disabled_state');
			},			
			success  : function(response){
				var res = jQuery.parseJSON(response);
				if(res.status == 400)
				{
					clearInterval(timer);
					jQuery('.verify_pkg_status').html(res.msg);
					jQuery('.verify_pkg_status').css('color','red');
					jQuery('.xapi_file_uploads_lbl').text('');
					jQuery('.xapi_file_uploads').val('');
					
				}else{
					jQuery('.verify_pkg_status').html(" ");
					var timer=setInterval(function(){
					percentage=percentage+10;
					if(percentage>100){
							clearInterval(timer);
							jQuery('#params').val(JSON.stringify(res.data))
							if(jQuery('.xapi_format:checked').val()=='xapi')
							{
								verifyID();
							}else{
								upload_zip();
							}
						}else{
							progressbar.attr('aria-valuenow', percentage);
							progressbar.css('width',percentage+"%");
							progressbar.text(percentage+"%");
						}
					},100);	
				}
			}
		});
	   } 
	});
});
/* function for verify course content package ID */
function verifyID()
{
	var params=jQuery('#params').val();
	var post_data={'params':params,'process':'verify_uid','action':'xapi_zip_upload'};
	var percentage=0;
	var progressbar=jQuery('#verify_uid_progress');
	var timer=setInterval(function(){
		percentage=percentage+10;
		if(percentage>100){
			clearInterval(timer);
		}else{
			progressbar.attr('aria-valuenow', percentage);
			progressbar.css('width',percentage+"%");
			progressbar.text(percentage+"%");
		}
	},100);
	jQuery.ajax({
			url  : my_ajax_object.ajax_anchor,	
			type: 'POST',
			data: post_data,
			dataType: 'json',
			beforeSend :function(){
				jQuery('.xapi_save').attr('disabled','disabled');
				jQuery('.xapi_save').removeClass('btn_normal_state');
				jQuery('.xapi_save').addClass('btn_disabled_state');
			},				
			success  : function(response){
				if(response.status == 400)
				{
					clearInterval(timer); 
					var html='';
					html+='<div style="text-align:left;">This package has already been uploaded once before. If you choose to continue, a copy of the file will be added to this course.';
					html+='<br>- If the previous upload was for this course, it will over-write it (but keep all the learning records).';
					html+='<br>- If the previous upload was for another course, you will need to find and update that course as well.';
					html+='<br><br>What would you like to do?</div>';
					html+='<br><div style="display: flex;justify-content: center;align-items: center;"><button class="btn_dark_state" id="cancle_duplicate" data-title="'+response.file_title+'">Cancel</button>&nbsp;&nbsp;';
					html+='<button class="btn btn_normal_state" id="allow_duplicate">Continue</button></div>';
					jQuery('.alert_box').html(html);
					jQuery('.alert_box').show();
				}
				else{
					upload_zip();	
				}
			} 
		});
}
/* function for upload course content(lesson) */
function upload_zip(){
	var course_id=jQuery('#course_id').val();
	if(jQuery('#lesson_id').val()!='' && jQuery('#insert_id').val()=='')
	{
		var lesson_id=jQuery('#lesson_id').val();
	}else{
		var lesson_id=jQuery('#insert_id').val();
	}
	var params=jQuery('#params').val();
	var file_url=jQuery('#hid_file_url').val();
	var post_data={'course_id':course_id,'lesson_id':lesson_id,'params':params,'process':'upload_zip','old_file':file_url,'action':'xapi_zip_upload'};
	var percentage=0;
	var progressbar=jQuery('#upload_progress');
	var timer=setInterval(function(){
		percentage=percentage+2;
		if(percentage>100){
			clearInterval(timer);
		}else{
			progressbar.attr('aria-valuenow', percentage);
			progressbar.css('width',percentage+"%");
			progressbar.text(percentage+"%");
		}
	},3000);
	jQuery.ajax({
		url  : my_ajax_object.ajax_anchor,	
		type: 'POST',
		data: post_data,
		dataType:'json',
		beforeSend :function(){
			jQuery('.xapi_save').attr('disabled','disabled');
			jQuery('.xapi_save').removeClass('btn_normal_state');
			jQuery('.xapi_save').addClass('btn_disabled_state');
		},
		success  : function(response){
			if(response.status==200)
			{
				var timer=setInterval(function(){
					percentage=percentage+2;
					if(percentage>100){
						clearInterval(timer);
						jQuery('.upload_status').html('Uploded Successfully.')
					 	jQuery('.upload_status').css({'color':'#09980f !important','font-weight': '600'});
					 	jQuery('.xapi_save').removeAttr('disabled');
					 	jQuery('.xapi_save').removeClass('btn_disabled_state');
						jQuery('.xapi_save').addClass('btn_normal_state');
					}else{
						progressbar.attr('aria-valuenow', percentage);
						progressbar.css('width',percentage+"%");
						progressbar.text(percentage+"%");
					}
				},100);	
			}
		}
	});

}

/* click event for allow duplicate course content(lesson) */
jQuery(document).on('click','#allow_duplicate',function(){
	jQuery('.alert_box').hide();
	var progressbar=jQuery('#verify_uid_progress');
	var percentage=parseInt(progressbar.attr('aria-valuenow'));
	var timer=setInterval(function(){
		percentage=percentage+10;
		if(percentage>100){
			clearInterval(timer);
			upload_zip();
		}else{
			progressbar.attr('aria-valuenow', percentage);
			progressbar.css('width',percentage+"%");
			progressbar.text(percentage+"%");
		}
	},100);
});

/* click event for cancel duplicate course content(lesson) */
jQuery(document).on('click','#cancle_duplicate',function(){
	jQuery('.lp-screen').show();
	var file_title=jQuery(this).data('title');
	var post_data={'title':file_title,'action':'unlink_file_on_cancle'};
	jQuery.ajax({
		url  : my_ajax_object.ajax_anchor,	
		type: 'POST',
		data: post_data,
		success:function(response){
			jQuery('.alert_box').hide();
			jQuery('.xapi_file_uploads_lbl').text('');
			jQuery('.xapi_file_uploads').val('');
			jQuery('#verify_pkg_progress').css('width','0%');
			jQuery('#verify_pkg_progress').text('');
			jQuery('#verify_uid_progress').css('width','0%');
			jQuery('#verify_uid_progress').text('');
			jQuery('.lp-screen').hide();
		}
	});
	
});

/* click event for save course content(lesson) */
jQuery(document).on('click','.xapi_save',function(e){
	e.preventDefault();
	var course_id=jQuery('#course_id').val();
	var insert_id=jQuery('#insert_id').val();
	var lesson_id=jQuery('#lesson_id').val();
	var xapi_id=jQuery('#xapi_id').val();
	var module_title=jQuery('#xapi_module_title').val();
	var tool=jQuery('.articulate_cat:checked').val();
	var lx_xapi_certificate = jQuery('#chk_xapi_certificate:checked').val();
	if(lesson_id!='')
	{
		if(module_title=='')
		{
			jQuery('.alert_box').html("Please Fill Title.");
			jQuery('.alert_box').show();
			setTimeout(function(){
				jQuery('.alert_box').hide();
				jQuery('.xapi_file_uploads_lbl').text('');
				jQuery('.xapi_file_uploads').val('');
			},3000);
			return false;
		}
		var post_data={'course_id':course_id,'lesson_id':lesson_id,'module_title':module_title,'mode':'edit','tool':tool,'lx_xapi_certificate':lx_xapi_certificate,'action':'save_xapi_module'}
	}
	else{
		if(module_title=='')
		{
			jQuery('.alert_box').html("Please Fill Title.");
			jQuery('.alert_box').show();
			setTimeout(function(){
				jQuery('.alert_box').hide();
				jQuery('.xapi_file_uploads_lbl').text('');
				jQuery('.xapi_file_uploads').val('');
			},3000);
			return false;
		}
		if( document.getElementById("xapi_file_uploads").files.length == 0 ){
	    	jQuery('.alert_box').html("Please Upload File.");
			jQuery('.alert_box').show();
			setTimeout(function(){
				jQuery('.alert_box').hide();
			},3000);
			return false;
		}
		var post_data={'course_id':course_id,'lesson_id':insert_id,'module_title':module_title,'mode':'add','tool':tool,'lx_xapi_certificate':lx_xapi_certificate,'action':'save_xapi_module'}
	}
	jQuery('.lp-screen').show();
	jQuery.ajax({
		url  : my_ajax_object.ajax_anchor,	
		type: 'POST',
		data: post_data,
		success:function(response){
			var res = jQuery.parseJSON(response);
			if( res.status == 1 ){
				console.log('test');
				jQuery('.alert_box').html(res.msg);
				jQuery('.alert_box').show();
				setTimeout(function(){
					jQuery('.alert_box').hide();
				},3000);
				jQuery('.lp-screen').hide();
			}else if(res.msg=="exist")
			{
				jQuery('.lp-screen').hide();
				jQuery('.alert_box').html("Title is already exist.");
				jQuery('.alert_box').show();
				setTimeout(function(){
					jQuery('.alert_box').hide();
				},3000);
			}else{
				window.location.href=res.link;
				jQuery('.lp-screen').hide();
			}
		}	
	});	
});

/* click event for play topic */
jQuery(document).on('click','.play_topic',function(){
	jQuery('.lp-screen').show();
	var flip_id=jQuery(this).data('flip_id');
	var podcast_id=jQuery('.flip_content').data('podcast_id');
	var postdata={'flip_id':flip_id,'podcast_id':podcast_id,'action':'play_topic'};
	jQuery.ajax({
		url  : my_ajax.ajax_object,	
		type: 'POST',
		data: postdata,
		success:function(response){
			jQuery('.play_load_here').html(response);
			jQuery('.con-playpause').trigger('click');
			jQuery('.nav-clipper .menu-item .the-name:not(:first)').each(function(){
				var text=jQuery(this).text();
				var substr1=text.substr(0,text.length-13);
				var substr2=text.substr(text.length-13);
				var html='<span class="the-name"><span class="the-name-title">'+substr1+'</span><span class="the-name-date">'+substr2+'</span></span>'
				jQuery(this).replaceWith(html);
			});
			jQuery('.lp-screen').hide();
			if(user_logged_in.login=="loggedin")	
			{
				if(current_user.user_id==podcast_author_id.author_id)
				{
					jQuery('.response_icon').insertAfter('.nav-clipper .menu-item .the-name');	
					jQuery('.response_icon').each(function(){
						var playerid=jQuery(this).parent().data('playerid');
						jQuery(this).attr('data-flip_id',playerid);
					});

					jQuery('.response_icon .btn').each(function(){
						var playerid=jQuery(this).parent().data('flip_id');
						jQuery(this).attr('data-flip_id',playerid);
						jQuery(this).attr('data-flip_parent_id',flip_id);
					});
				}
			}
			reply_cnt=jQuery('.nav-clipper .menu-item').length-1;
			jQuery('.reply_count').html('('+reply_cnt+')');
			if(jQuery('.nav-clipper .menu-item').length > 1){
				reply_cnt=jQuery('.nav-clipper .menu-item').length-1;
				jQuery('.reply_count').html('('+reply_cnt+')');
				jQuery('.play_on_thumb').insertBefore('.nav-clipper .menu-item .menu-item-thumb-con .menu-item-thumb');
			}
			else{
                jQuery('.play_on_thumb').hide();
				jQuery('.reply_count').html('(0)');
			}		
		}
	});
});

/* click event for view response */
jQuery(document).on('click','.view_response',function(){
	if(jQuery('.nav-clipper .menu-item').length < 1)
	{
		jQuery('.response_load_here').css('text-align','center');
		jQuery('.response_load_here').text('No Responses Yet!');
		jQuery('.close_btn').show();
	}
	else{
		var response=jQuery('.min_audio_player .navigation-method-mouseover').show();
		jQuery('.response_load_here').prepend(response);
		if(user_logged_in.login=="loggedin")	
		{
			if(current_user.user_id==podcast_author_id.author_id)
			{
				jQuery('.response_load_here .response_icon').show(); 
			}
		}
		jQuery('.close_btn').show();
	}
	jQuery('.response_tab').show();
});

/* click event for add reply button */
/* jQuery(document).on('click','.add_reply_btn',function(){
	jQuery('.lp-screen').show();
	if(jQuery('.con-playpause .pausebtn').css('display')=='block')
	{
		jQuery('.con-playpause').trigger('click');
	}
	var l_id=jQuery('.learndash_post_sfwd-lessons').attr('id');
	var lesson_id=l_id.split('_')[2];
	var flip_id = jQuery(this).data('flip_id');
	var post_data = {'lesson_id':lesson_id,'flip_id':flip_id,'action':"open_model"};
	var modal = document.getElementById("replyModal");
	jQuery.ajax({					
			url  : my_ajax.ajax_object,			
			type: 'POST',
			data: post_data,
			dataType: 'html',						
			success  : function(response) {
				modal.style.display = "block";
				jQuery('.load_reply_here').html(response);
				jQuery('.lp-screen').hide();
			}
		});
}); */

/* click event for add reply button */
jQuery(document).on('click','.add_reply',function(){
	if(jQuery('.active-from-gallery .con-playpause .pausebtn').css('display')=='block')
	{
		jQuery('.active-from-gallery .con-playpause').trigger('click');
	}
});

/* click event for reply edit button */
jQuery(document).on('click','.lx_reply_edit',function(){
	jQuery('.lp-screen').show();
	if(jQuery('.active-from-gallery .con-playpause .pausebtn').css('display')=='block')
	{
		jQuery('.active-from-gallery .con-playpause').trigger('click');
	}
	var data=jQuery(this).parent().parent().attr('data-playerid');
	var arr=data.split('p');
	var flip_id=arr[1];
	var modalEdit = document.getElementById("replyEditModal");
	var post_data = {'flip_id':flip_id,'action':"open_model_reply_edit"};
	jQuery.ajax({					
		url  : my_ajax.ajax_object,			
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			modalEdit.style.display = "block";
			jQuery('.load_reply_edit_here').html(response);
			jQuery('.load_reply_edit_here .flip_back_linkk').attr('onclick','null');
			jQuery('.lp-screen').hide();
		}
	});
});

/* click event for delete reply */
jQuery(document).on('click','.lx_reply_delete',function(){
	jQuery('.lp-screen').show();
	if(jQuery('.active-from-gallery .con-playpause .pausebtn').css('display')=='block')
	{
		jQuery('.active-from-gallery .con-playpause').trigger('click');
	}
	var data=jQuery(this).parent().parent().attr('data-playerid');
	var arr=data.split('p');
	var flip_id=arr[1];
	var flip_parent_id=jQuery(this).data('flip_parent_id');
	var data={flip_id:flip_id,flip_parent_id:flip_parent_id,'action':'reply_delete'}
	jQuery.ajax({
		url : my_ajax.ajax_object,			
		type: 'POST',
		data: data,
		dataType: 'html',						
		success  : function(response) {
			if(jQuery.trim(response) == 'deleted'){
				location.reload();
			}
		}
	});
	
});

/* click event for set lesson progress started */
jQuery(document).on('click','.content_list_href',function(){
	lession_id=jQuery(this).data('lession_id');
	postdata={'lession_id':lession_id,'action':'mark_as_started'};
	jQuery.ajax({
		url  : my_ajax_object.ajax_anchor,					
		type : 'POST',					
		data : postdata,						
		success  : function(response) {
		}
	});
});

/* click event for delete course content(lesson) */
jQuery(document).on('click','.content_delete',function(){
	jQuery('.lp-screen').show();
	var lesson_id=jQuery(this).data('lesson_id');
	var course_id=jQuery('#vw_course_id').val();
	var postdata={'lesson_id':lesson_id,'course_id':course_id,'action':'delete_lesson'};
	jQuery.ajax({					
		url  : my_ajax_object.ajax_anchor,					
		type : 'POST',					
		data : postdata,					
		dataType : 'html',					
		success: function(response) {
			location.reload();
			jQuery('.lp-screen').hide();
		}
	});
});

/* click event for close course cropping modal */
jQuery(document).on('click','.course_cropping_close',function(){
   jQuery('.lx_course_thumbnail').val('');
});

/* click event for change course status publish */
jQuery(document).on('click','.publish_lx_course',function(e){
	jQuery('#course_save_status').val('publish');
});

/* click event for change course status draft */
jQuery(document).on('click','.draft_lx_course',function(e){
	jQuery('#course_save_status').val('draft');
});

/* click event for course status not store as draft  */
jQuery(document).on('click','.btn_draft_popup_cancel',function(e){
	jQuery('.alert_box_draft_popup').hide();
	jQuery('#darft_save_info').val('save_as_draft_no');
});

/* click event for course status store as draft  */
jQuery(document).on('click','.btn_draft_popup_yes',function(e){
	jQuery('#darft_save_info').val('save_as_draft_yes');
	jQuery('.alert_box_draft_popup').hide();
	jQuery( "#"+jQuery('.lx_course_form').attr('id') ).trigger( "submit" );
});

/* click event for cancel delete course thumb */
jQuery(document).on('click','.btn_del_thumb_popup_cancel',function(e){
	jQuery('.alert_box_del_thumb_popup').hide();
	jQuery('.modal-backdrop').remove();
});

/* click event for conformation of delete course thumb */
jQuery(document).on('click','.btn_del_thumb_popup_yes',function(e){
	jQuery('.alert_box_del_thumb_popup').hide();
	jQuery('.lp-screen').show();
	var course_id=jQuery('.delete_course_thumbnail').data('id');
	var post_data = {'course_id':course_id,action:'delete_course_thumbnail'};
	jQuery.ajax({					
				url  : my_ajax_object.ajax_anchor,	
				type: 'POST',
				data: post_data,
				dataType: 'html',						
				success  : function(response) {
					location.reload();
					jQuery('.lp-screen').hide();
				}
		});
});

/* For Mange course page tabs */
jQuery(document).on('click','.tab_title_col',function(e){
	e.preventDefault();
	/* jQuery('.lp-screen').show();
	setTimeout(function(){
		jQuery('.lp-screen').hide();
	},2000); */
	var count_info = jQuery(this).data('count');
	jQuery('.tab_title_col').addClass('not_active_tab');
	jQuery('#tab_title_'+count_info).removeClass('not_active_tab');
	jQuery('#tab_title_'+count_info).addClass('active_tab');
	jQuery('.tab_content_row').css('display','none');
	jQuery('.tab_content_'+count_info).css('display','block');
});

/* For Make 'Featured' on off */
jQuery(document).on('click','.lx_make_featured',function(e){
  var checkBox = document.getElementById("lx_make_featured");
  if (checkBox.checked == true){
    jQuery('.course_category_info_main').show();
  } else {
	jQuery('input.chk_content_category').each(function(){ 

		jQuery('.chk_content_category').prop('checked', false);

	});
	  jQuery('.course_category_info_main').hide();
  }
});

/*jQuery(document).on('change','#chk_certificate',function(){
	if(jQuery(this).is(':checked')){

	}else{

	}
});*/
/* For add certificate */
jQuery(document).on('click','.add_certificate',function(e){
	jQuery("#exampleModalCenter").modal("hide");
	jQuery("#certificate_modal").modal("show");
});

jQuery(document).on('click','.add_certificate_link',function(e){
	e.preventDefault();
	var lx_course_certificate = jQuery('#chk_certificate:checked').val();
	if(lx_course_certificate == undefined){
		jQuery('.certificate_error_msg').html("Please indicate that the course includes certificate.");
		return false;
	} else{
		jQuery('.certificate_error_msg').html("");
		jQuery('.lp-screen').show(); 
		var course_id = jQuery('#course_id').val();
		var post_data = {'course_id':course_id,'lx_certificate':lx_course_certificate,action:'add_certificate_in_course_page'};
		jQuery.ajax({					
				url  : my_ajax_object.ajax_anchor,	
				type: 'POST',
				data: post_data,
				dataType: 'html',						
				success  : function(response) {
					location.reload();
					jQuery('.lp-screen').hide();
				}
		});
	}
});

/* for delete course certificate link */
jQuery(document).on('click','.btn_delete_certificate_link',function(e){
	e.preventDefault();
	jQuery('.lp-screen').show(); 
	var course_id = jQuery('#course_id').val();
	var post_data = {'course_id':course_id,action:'del_certificate_in_course_page'};
	jQuery.ajax({					
			url  : my_ajax_object.ajax_anchor,	
			type: 'POST',
			data: post_data,
			dataType: 'html',						
			success  : function(response) {
				location.reload();
				jQuery('.lp-screen').hide();
			}
	});
});

/* for display some information if CPD points is blank in course canvas */
jQuery(document).on('change','.lx_course_levels',function(e){
	e.preventDefault();
	var cpd = jQuery('#lx_course_cpd_points').val();
	var lx_course_levels = jQuery(this).val();
	if( lx_course_levels !=0 ){
		if( cpd == '' ){
			jQuery('.alert_box').html("If CPD = blank, this will not be displayed.");
			jQuery('.alert_box').show();
			setTimeout(function(){
				jQuery('.alert_box').hide();
			},3000);
		}
	}
});

/* for Articulate xapi back link operations */
jQuery(document).on('click','.xapi_back_link',function(e){
	e.preventDefault();
	jQuery('.lp-screen').show();
	if(jQuery('#lesson_id').val()==''){
		var lesson_id = jQuery('#insert_id').val();
		var course_id = jQuery('#course_id').val();
		var post_data={'lesson_id':lesson_id,'course_id':course_id,'status_info_backlink':'yes','action':'delete_lesson'};
		jQuery.ajax({
			url  : my_ajax_object.ajax_anchor,	
			type: 'POST',
			data: post_data,
			dataType: 'html',						
			success : function(response) {
				jQuery('.lp-screen').hide();
				window.location.href=jQuery('.hidden_back_link').val();
			}
		});
	} else{
		window.location.href=jQuery('.hidden_back_link').val();
	} 
	
});

jQuery(document).on('click','.course_fee',function(){
	if(jQuery(this).is(':checked') == true){
		jQuery('.course_cost_main_div').show();
	}
	if(jQuery(this).is(':checked') == false){
		jQuery('.course_cost_main_div').hide();
	}
});

jQuery(document).on('click','.course_additional_option',function(){
	if(jQuery(this).is(':checked') == true){
		jQuery('.additional_option_div').show();
	}
	if(jQuery(this).is(':checked') == false){
		jQuery('.additional_option_div').hide();
	}
});

jQuery(document).on('change','#chk_certificate',function(e){
	e.preventDefault();
	var course_id = jQuery('#course_id').val();
	var chk_certificate = jQuery('#chk_certificate:checked').val();
	var attach_course = jQuery('.community_selection').val();
	if( jQuery(this).is(':checked') ) {
		var chk_certificate = jQuery(this).val();
		var post_data = {
			'attach_course':attach_course,
			'course_id':course_id,
			'chk_certificate':chk_certificate,
			'action':'chk_certificate_onchange_action'
		};
		jQuery.ajax({					
			url  : my_ajax_object.ajax_anchor,	
			type: 'POST',
			data: post_data,					
			success  : function(response) {
				var res = jQuery.parseJSON(response);
				if(res){
					jQuery('.alert_box').html(res.msg);
					jQuery('.alert_box').show();
					setTimeout(function(){
						jQuery('.alert_box').hide();
					},3000);
				}
			}
		});
	}
});

jQuery(document).on('click','.contentheadingselectbtn',function(){
	jQuery('.lp-screen').show();
	var title = jQuery('.sectionheadingdivspan').html();
	var course_id = jQuery('#course_id').val();
	var postdata={
		'title':title,
		'course_id':course_id, 
		'action':'AddCourseContentHeadingDividers'
	};
	jQuery.ajax({					
		url  : my_ajax_object.ajax_anchor,	
		type: 'POST',
		data: postdata,					
		success  : function(response) {
			location.reload();
			jQuery('.lp-screen').hide();
		}
	});
});

jQuery(document).on('focusout','.sectionheadinputdiv',function(){
	var content_id = jQuery(this).data('lession_id');
	var course_id = jQuery('#course_id').val();
	var title = jQuery(this).val();
	
	if( title == '' ){
		var oldval = jQuery('.hidsectionheadprevdiv'+content_id).val();
		jQuery('.sectionheadinputdiv'+content_id).val( oldval );
		
		jQuery('.sectionheadprevdivmain'+content_id).show();
		jQuery('.sectionheadinputdivmain'+content_id).hide();
	
		return false;
	}
	jQuery('.sectionheadprevdivmain'+content_id).show();
	jQuery('.sectionheadinputdivmain'+content_id).hide();
	jQuery('.sectionheadprevdiv'+content_id).html( title );
	jQuery('.hidsectionheadprevdiv'+content_id).val( title );
	
	var postdata={
		'lesson_id' : content_id,
		'course_id' : course_id,
		'title': title,
		'action':'EditCourseContentHeadingDivider'
	};
	jQuery.ajax({					
		url  : my_ajax_object.ajax_anchor,	
		type: 'POST',
		data: postdata,					
		success  : function(response){
			
		}
	});
	
});

jQuery(document).on('click','.editsectionheadingbtn',function(){
	var content_id = jQuery(this).data('lesson_id');
	jQuery('.sectionheadprevdivmain'+content_id).hide();
	jQuery('.sectionheadinputdivmain'+content_id).show();
});