/** Filter by A-Z **/
jQuery(document).on('click','.lxed_title_filter',function(){
	jQuery('.lp-screen').show();
	var ajax_path = lx_path.ajaxurl;
	var post_data = {
		'action':'fn_lx_filter'
	};
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			jQuery('.lxed_main_page_listing').html(response);
			jQuery('.lp-screen').hide();
		}
	});
});

/** text block click **/
jQuery(document).on('click','.lx_editor_blocks_inner',function(){
	
	var ajax_path = lx_path.ajaxurl;
	/* if(jQuery('.lxed_block_padding').length == 0){ */
		var section_id = jQuery('.lxed_block_padding').length+1;
	/* }else{
		var section_id = (jQuery('.lxed_block_padding').length);
	} */
	var is_modal = jQuery(this).data('is_modal');
	

	var this_click = jQuery(this).data('click');
	/* if(jQuery(this).hasClass('lx_editor_new_section')){
		jQuery('.lp-screen').show();
		this_click = 'lx_editor_new_section';
	} */
	/* alert(jQuery('.lx_editor_blocks_load_here').length); */
	if(this_click == 'lxed_page_break' && jQuery('.lxed_block_padding').length == 0){
		alert("Please select block first");
		return false;
	}
	jQuery('.lp-screen').show();
	var post_data = {
		'section_id':section_id,
		'lx_block_click':this_click,
		'action':'fn_lx_editor_clicks'
	};
	/* return false; */
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			/* jQuery('.lx_editor_blocks_load_here').hide(); */
			if(is_modal == 'yes'){
				jQuery('.lxed_block_padding'+jQuery('.lxed_section_prepand').val()).before(response);
				jQuery('#lxed_block_modal').modal('hide');
			}else{
				jQuery('.lx_editor_blocks_load_here').append(response);
			}
			
			/* jQuery('.lx_editor_blocks_load_here').slideUp(500); */
			jQuery('.lp-screen').hide();
		}
	});
});

/** Add new Section **/
jQuery(document).on('click','.lxed_add_section',function(){
	var this_section_id = jQuery(this).data('section_id');
	var section_id = (jQuery('.lxed_block_padding').length+1);
	jQuery('.lxed_section_prepand').val(this_section_id);
	jQuery('#lxed_block_modal').modal('show');
});

jQuery(document).on('click','.lx_area_edit',function(){
	var section_id= jQuery(this).data('section_id');
	jQuery('.lx_new_section_area_block'+section_id).modal('show');
	
});


/* jQuery(document).on('dblclick','.lx_section_title',function(){
	var section_id= jQuery(this).data('section_id');
	
	jQuery('.lx_section_title'+section_id).hide();
	jQuery('.lx_sectiontitle_input'+section_id).val(jQuery('.lx_section_title'+section_id).html());
	jQuery('.lx_sectiontitle_input'+section_id).show();
	jQuery('.lx_sectiontitle_input'+section_id).focus();
	jQuery('.lx_sectiontitle_input'+section_id).focusout(function(e){
		var text_box_val = jQuery(this).val();
		if(text_box_val.length == 0){
			jQuery('.lx_section_title'+section_id).html('SECTION TITLE');
		}else{
			jQuery('.lx_section_title'+section_id).html(text_box_val);
		}
		jQuery('.lx_section_title'+section_id).show();
		jQuery('.lx_sectiontitle_input'+section_id).hide();
		
	});
	
}); */

jQuery(document).on('click','.lx_collapse',function(){
	var section_id= jQuery(this).data('section_id');
	jQuery('.lx_new_section_area_block'+section_id).hide();
});

jQuery(document).on('click','.lx_area_delete',function(){
	var section_id= jQuery(this).data('section_id');
	var section_img=jQuery('.lxed_block_padding'+section_id+' img').attr('src');
	if(section_img!=undefined)
	{
		jQuery('.lp-screen').show();
		if(jQuery('.hid_lxed_blog_post_id').val()!='')
		{
			var blog_post_id=jQuery('.hid_lxed_blog_post_id').val();
		}else{
			var blog_post_id=jQuery('#hid_blog_post_id').val();
		}
		var ajax_path=lx_path.ajaxurl;
		var post_data={'blog_post_id':blog_post_id,'section_img':section_img,'action':'fn_lx_delete_section_img'};
		jQuery.ajax({
			url : ajax_path,
			type: 'POST',
			data: post_data,
			dataType: 'html',						
			success  : function(response) {
				jQuery('.lxed_block_padding'+section_id).slideUp('slow',function(){
					jQuery(this).remove();
				});
				jQuery('.lp-screen').hide();
			}
		});
	}
	else{
		jQuery('.lxed_block_padding'+section_id).slideUp('slow',function(){
			jQuery(this).remove();
		});
	}
});

/** Swith to editor **/
jQuery(document).on('click','.lxed_swith_to_editor,.lxed_swith_txtimg_to_editor,.lxed_swith_img_text_to_editor',function(){
	var ajax_path = lx_path.ajaxurl;
	var section_id = jQuery(this).data('section_id');
	var this_click = jQuery(this).data('click');
	
	if(this_click == 'txt_imgeditor'){
		var html = jQuery('.lx_editor_textimg_area'+section_id).html();
	}
	if(this_click == 'txteditor'){
		var html = jQuery('.lx_editor_text_area'+section_id).html();
	}
	if(this_click == 'img_txteditor'){
		var html = jQuery('.lx_editor_img_text_area'+section_id).html();
	}
	
	jQuery('.lp-screen').show();
	var post_data = {
		'html':html,
		'action':'fn_lx_switchto_editor'
	};
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
		
			if(this_click == 'txt_imgeditor'){
				jQuery('.lxed_swith_txtimg_to_editor'+section_id).hide();
				jQuery('.lxed_swith_txtimg_to_html'+section_id).show();
				jQuery('.lx_editor_textimg_area'+section_id).hide();
				jQuery('.lx_editor_textimg_area_editor'+section_id).show();
				jQuery('.lx_editor_textimg_area_editor'+section_id).val(jQuery.trim(html));
			}
			if(this_click == 'txteditor'){
				jQuery('.lxed_swith_to_editor'+section_id).hide();
				jQuery('.lxed_swith_to_html'+section_id).show();
				jQuery('.lx_editor_text_area'+section_id).hide();
				jQuery('.lx_editor_text_area_editor'+section_id).show();
				jQuery('.lx_editor_text_area_editor'+section_id).val(jQuery.trim(html));
			}
			if(this_click == 'img_txteditor'){
				jQuery('.lxed_swith_img_text_to_editor'+section_id).hide();
				jQuery('.lxed_swith_img_text_to_html'+section_id).show();
				jQuery('.lx_editor_img_text_area'+section_id).hide();
				jQuery('.lx_editor_img_text_area_editor'+section_id).show();
				jQuery('.lx_editor_img_text_area_editor'+section_id).val(jQuery.trim(html));
			}
			jQuery('.lxed_reset_html'+section_id).show();
			jQuery('.lp-screen').hide();
			
		}	
	});
});
/** Swith to html **/
jQuery(document).on('click','.lxed_swith_to_html,.lxed_swith_img_text_to_html,.lxed_swith_txtimg_to_html',function(){
	var ajax_path = lx_path.ajaxurl;
	var section_id = jQuery(this).data('section_id');
	
	var this_click = jQuery(this).data('click');
	if(this_click == 'txt_imghtml'){
		var html = jQuery('.lx_editor_textimg_area_editor'+section_id).val();
	}
	if(this_click == 'txthtml'){
		var html = jQuery('.lx_editor_text_area_editor'+section_id).val();
	}
	if(this_click == 'img_txthtml'){
		var html = jQuery('.lx_editor_img_text_area_editor'+section_id).val();
	}
	
	jQuery('.lp-screen').show();
	var post_data = {
		'html':html,
		'action':'fn_lx_switchto_html'
	};
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			if(this_click == 'txt_imghtml'){
				jQuery('.lxed_swith_txtimg_to_editor'+section_id).show();
				jQuery('.lxed_swith_txtimg_to_html'+section_id).hide();
				jQuery('.lx_editor_textimg_area_editor'+section_id).hide();
				jQuery('.lx_editor_textimg_area'+section_id).show();
				jQuery('.lx_editor_textimg_area'+section_id).html(response);
			}
			if(this_click == 'txthtml'){
				jQuery('.lxed_swith_to_editor'+section_id).show();
				jQuery('.lxed_swith_to_html'+section_id).hide();
				jQuery('.lx_editor_text_area_editor'+section_id).hide();
				jQuery('.lx_editor_text_area'+section_id).show();
				jQuery('.lx_editor_text_area'+section_id).html(response);
			}
			if(this_click == 'img_txthtml'){
				jQuery('.lxed_swith_img_text_to_editor'+section_id).show();
				jQuery('.lxed_swith_img_text_to_html'+section_id).hide();
				jQuery('.lx_editor_img_text_area_editor'+section_id).hide();
				jQuery('.lx_editor_img_text_area'+section_id).show();
				jQuery('.lx_editor_img_text_area'+section_id).html(response);
			}
			jQuery('.lxed_reset_html'+section_id).hide();
			jQuery('.lp-screen').hide();
		}	
	});
});

/** Reset html **/
jQuery(document).on('click','.lxed_reset_html',function(){
	var ajax_path = lx_path.ajaxurl;
	var section_id = jQuery(this).data('section_id');
	var this_click = jQuery(this).data('click');
	jQuery('.lp-screen').show();
	if(this_click == 'txt_imgeditor'){
		var html = jQuery('.lx_editor_textimg_area'+section_id).html();
	}
	if(this_click == 'txteditor'){
		var html = jQuery('.lx_editor_text_area'+section_id).html();
	}
	if(this_click == 'img_txteditor'){
		var html = jQuery('.lx_editor_img_text_area'+section_id).html();
	}
	var post_data = {
		'html':html,
		'action':'fn_lx_reset_html'
	};
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			if(this_click == 'txt_imgeditor'){
				jQuery('.lx_editor_textimg_area_editor'+section_id).val(response);
				jQuery('.lx_editor_textimg_area'+section_id).html(response);
			}
			if(this_click == 'txteditor'){
				jQuery('.lx_editor_text_area_editor'+section_id).val(response);
				jQuery('.lx_editor_text_area'+section_id).html(response);
			}
			if(this_click == 'img_txteditor'){
				jQuery('.lx_editor_img_text_area_editor'+section_id).val(response);
				jQuery('.lx_editor_img_text_area'+section_id).html(response);
			}
			jQuery('.lp-screen').hide();
		}
	});
	
});

/** Upload the thumbnail_image **/
jQuery(document).on('change','.lxed_add_thumbnail',function(e){
	if(jQuery('.availablity_option').is(':checked')!=true)
  	{
  		jQuery('.alert_box').html("Please Choose Available In Option First.");
		jQuery('.alert_box').show();
		setTimeout(function(){
				jQuery('.alert_box').hide();
				jQuery('.lxed_add_thumbnail').val('');
		},3000);
		return false;
  	}
  	else{
		jQuery('.lp-screen').show();
		var files = e.target.files;
		filename=files[0].name;
		jQuery('.hid_file_name').val(filename);
		
		var done = function (url) {
		  /* input.value = ''; */
		  image.src = url;
		  jQuery('.alert').hide();
		 /* $modal.modal('show');*/
		  jQuery('#lxed_modal').modal({backdrop:'static', keyboard:false});
		 
		};
		var reader;
		var file;
		var url;
		
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
		jQuery('.lp-screen').hide();
		jQuery('.hid_class_click').val('lxed_add_thumbnail');
	}
});


jQuery(document).on('change','.lxed_img_block_inp',function(e){
	if(jQuery('.availablity_option').is(':checked')!=true)
  	{
  		jQuery('.alert_box').html("Please Choose Available In Option First.");
		jQuery('.alert_box').show();
		setTimeout(function(){
				jQuery('.alert_box').hide();
				jQuery('.lxed_add_thumbnail').val('');
		},3000);
		return false;
  	}
  	else{
  		jQuery('.lp-screen').show();
		var files = e.target.files;
		filename=files[0].name;
		jQuery('.hid_file_name').val(filename);
		
		var done = function (url) {
		  /* input.value = ''; */
		  image.src = url;
		  jQuery('.alert').hide();
		 /* $modal.modal('show');*/
		  jQuery('#lxed_modal').modal({backdrop:'static', keyboard:false});
		 
		};
		var reader;
		var file;
		var url;
		
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
		  jQuery('.lp-screen').hide();
		  jQuery('.hid_class_click').val('lxed_img_block_inp');
		  jQuery('.hid_section_id').val(jQuery(this).data('section_id'));
			/* jQuery('.lxed_img_block_inpimg'+section_id).attr('src',response); */
  	}	
});

jQuery(document).on('change','.lxed_txt_img_block_inp',function(e){
	if(jQuery('.availablity_option').is(':checked')!=true)
  	{
  		jQuery('.alert_box').html("Please Choose Available In Option First.");
		jQuery('.alert_box').show();
		setTimeout(function(){
				jQuery('.alert_box').hide();
				jQuery('.lxed_add_thumbnail').val('');
		},3000);
		return false;
  	}
  	else{
		jQuery('.lp-screen').show();
		var files = e.target.files;
		filename=files[0].name;
		jQuery('.hid_file_name').val(filename);
		
		var done = function (url) {
		  /* input.value = ''; */
		  image.src = url;
		  jQuery('.alert').hide();
		 /* $modal.modal('show');*/
		  jQuery('#lxed_modal').modal({backdrop:'static', keyboard:false});
		 
		};
		var reader;
		var file;
		var url;
		
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
		  jQuery('.lp-screen').hide();
		  jQuery('.hid_class_click').val('lxed_txt_img_block_inp');
		  jQuery('.hid_section_id').val(jQuery(this).data('section_id'));
			/* jQuery('.lxed_txt_img_block_inpimg'+section_id).attr('src',response); */
	}
});
jQuery(document).on('change','.lxed_img_txt_block_inp',function(e){
	if(jQuery('.availablity_option').is(':checked')!=true)
  	{
  		jQuery('.alert_box').html("Please Choose Available In Option First.");
		jQuery('.alert_box').show();
		setTimeout(function(){
				jQuery('.alert_box').hide();
				jQuery('.lxed_add_thumbnail').val('');
		},3000);
		return false;
  	}
  	else{
		jQuery('.lp-screen').show();
		var files = e.target.files;
		filename=files[0].name;
		jQuery('.hid_file_name').val(filename);
		
		var done = function (url) {
		  /* input.value = ''; */
		  image.src = url;
		  jQuery('.alert').hide();
		 /* $modal.modal('show');*/
		  jQuery('#lxed_modal').modal({backdrop:'static', keyboard:false});
		 
		};
		var reader;
		var file;
		var url;
		
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
		  jQuery('.lp-screen').hide();
		  jQuery('.hid_class_click').val('lxed_img_txt_block_inp');
		  jQuery('.hid_section_id').val(jQuery(this).data('section_id'));
		  /* jQuery('.lxed_img_txt_block_inpimg'+section_id).attr('src',response); */
	}
});

/** Upload the video **/
jQuery(document).on('change','.lxed_vid_block_inp',function(e){
	var ajax_path = lx_path.ajaxurl;
	var section_id = jQuery(this).data('section_id');
	var file = jQuery(this)[0].files[0];
	var blog_post_id = jQuery('.lxed_hid_post_id').val();
	jQuery('.lp-screen').show();
	
	var fd = new FormData();
	
	fd.append('section_id', section_id);
	fd.append('file', file);
	fd.append('blog_post_id', blog_post_id);
	fd.append('action', 'fn_lx_ajax_video_upload_tos3');
	
	console.log(file);
	/* var post_data = {
		'file':file,
		'action':'fn_lx_ajax_video_upload_tos3'
	}; */
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: fd,
		contentType: false,		
		processData: false,				
		success  : function(response) {
			if(response !=''){
				jQuery('.lxed_vid_block_inpvideo_section_load'+section_id).html(response);
			}
			jQuery('.lp-screen').hide();
		}
	});
	/* alert(); */
});

/* Previous Button Click */
jQuery(document).on('click','.lxed_next_but',function(){
	var section_id = jQuery(this).data('section_id');
	var next_secid = section_id+1;
	
	if(jQuery('.render_main_section'+next_secid).length == 0){
		jQuery('.render_block_section'+section_id).show();
		jQuery('.render_main_section'+section_id).show();
	}else{
		jQuery('.render_block_section'+section_id).hide();
		jQuery('.render_block_section'+next_secid).show();
		
		jQuery('.render_main_section'+section_id).hide();
		jQuery('.render_main_section'+next_secid).show();
	}
		
});

jQuery(document).on('click','.lxed_prev_but',function(){
	var section_id = jQuery(this).data('section_id');
	var next_secid = section_id+1;
	
	if(jQuery('.render_main_section'+section_id).length == 0){
		jQuery('.render_block_section'+section_id).show();
		jQuery('.render_main_section'+section_id).show();
	}else{
	
		jQuery('.render_block_section'+section_id).show();
		jQuery('.render_block_section'+next_secid).hide();
		
		jQuery('.render_main_section'+section_id).show();
		jQuery('.render_main_section'+next_secid).hide();
	}
		
});


/** On click of the view **/
jQuery(document).on('click','.lxed_view_blog_post',function(){
	var href = jQuery(this).data('href');
	window.open(href, '_blank');
});
/** Render the blocks **/
jQuery(document).on('click','.lxed_publish_blog_post,.lxed_preview_blog_post,.lxed_save_draft_blog_post,.lxed_update_blog_post',function(){
	
	var ajax_path = lx_path.ajaxurl;
	var blog_format = jQuery('.lxed_blog_format:checked').val();
	var lxed_thumbnail_img = jQuery('.lxed_thumbnail_img').attr('src');
	
	var lxed_post_title = jQuery('.lxed_var_post_title').val();
	if(lxed_post_title == ''){
		/* alert("Please insert title first"); */
		jQuery('.alert_box').show();
		jQuery('.alert_box').html("Please insert title first");
		setTimeout(function(){
				jQuery('.alert_box').hide();
		},2000);
		return false;
	}
	/* alert(jQuery('.availablity_option:checked').val()); */
	if(jQuery('.availablity_option:checked').val() == undefined){
		jQuery('.alert_box').show();
		jQuery('.alert_box').html("Please choose available in option first.");
		setTimeout(function(){
				jQuery('.alert_box').hide();
		},2000);
		return false;
	}
	/** lxed Blog Post Except **/
	var lxed_blog_post_excerpt = jQuery('.lxed_blog_post_excerpt').val();
	
	/** lxed checkbox value **/
	var lxed_cat_array = [];
	jQuery('.vw_lxed_categories:checked').each(function(){
		lxed_cat_array.push(jQuery(this).val());
	});
	
	if(jQuery(this).hasClass('lxed_publish_blog_post')){
		var this_click = 'Publish';
	}
	if(jQuery(this).hasClass('lxed_preview_blog_post')){
		var this_click = 'Preview';
	}
	if(jQuery(this).hasClass('lxed_save_draft_blog_post')){
		var this_click = 'Draft';
	}
	if(jQuery(this).hasClass('lxed_update_blog_post')){
		var this_click = 'Update';
	}
	
	/** Section array **/
	var section_ids = [];
	jQuery('.lxed_block_padding').each(function(){
		section_ids.push(jQuery(this).data('section_id'));
	});
	
	/** Text Block Value  **/
	var text_block_array = [];
	jQuery('.lx_editor_text_area').each(function(section_id,ck_value){
		var section_id = jQuery(this).data('section_id');
		/* alert(section_id); */
		text_block_array[section_id] =jQuery(this).html();
		
		
	});
	/** Img Block Value **/
	var img_block_array = [];
	jQuery('.lxed_img_block_inpimg').each(function(section_id,img_block){
		var section_id = jQuery(this).data('section_id');
		img_block_array[section_id] = jQuery(this).attr('src');
		
	});
	
	/** Text + img Block Value **/
	var txtonly_img_block_array = [];var txt_imgonly_block_array = [];
	jQuery('.lx_editor_textimg_area').each(function(){
		var section_id = jQuery(this).data('section_id');
		txtonly_img_block_array[section_id] = jQuery(this).html();
		txt_imgonly_block_array[section_id] = jQuery('.lxed_txt_img_block_inpimg'+section_id).attr('src');
		
	});
	
	/** Img + TextBlock Value **/
	var img_textonly_html = [];var imgonly_text_html = [];
	jQuery('.lx_editor_img_text_area').each(function(){
		var section_id = jQuery(this).data('section_id');
		img_textonly_html[section_id] = jQuery(this).html();
		imgonly_text_html[section_id] =jQuery('.lxed_txt_img_block_inpimg'+section_id).attr('src');
		
	});
	
	var btnblock_label = [];var btnblock_desturl = [];var btnblock_desc = [];
	jQuery('.lxed_buttonblocklabel').each(function(){
		var section_id = jQuery(this).data('section_id');
		btnblock_label[section_id] = jQuery(this).val();
		btnblock_desturl[section_id] = jQuery('.lxed_buttonblockdestination'+section_id).val();
		btnblock_desc[section_id] = jQuery('.lxed_buttonblockdesc'+section_id).html();
	});
	/* console.log(btnblock_label);
	console.log(btnblock_desturl);
	console.log(btnblock_desc);
	return false; */
		/* console.log(img_textonly_html);
		console.log(imgonly_text_html);return false; */
	/** break id **/
	var section_break_array = [];
	jQuery('.lxed_border_bottom_break').each(function(){
		var section_id = jQuery(this).data('section_id');
		section_break_array[section_id] = 'break';
	});
	
	/** Video src **/
	var video_block_array = [];
	jQuery('.lxed_vid_block_inpsource').each(function(){
		var section_id = jQuery(this).data('section_id');
		video_block_array[section_id] = jQuery(this).attr('src');
	});
	
	
	/* console.log(video_block_array);
	jQuery('.lp-screen').hide();
	return false; */
	/** Get the full rendered Html **/
	
	var single_questions_array = [];
	var single_ans_opt_q_id_sec = [];
	var single_ans_opt_array = [];
	var single_ans_opt_q_id = [];
	
	jQuery('.lx_editor_singleans_opt').each(function(){
		var section_id = jQuery(this).data('section_id');
		var question_id = jQuery(this).data('question_id');
		single_ans_opt_q_id_sec.push(section_id);
		single_ans_opt_q_id.push(question_id);
		single_ans_opt_array.push(jQuery(this).html());
		single_questions_array.push(jQuery('.lx_editor_questions'+section_id+question_id).html());
		
	});
	
	var single_questions_val_array = [];
	jQuery('.lxed_single_answer_radio').each(function(){
		single_questions_val_array.push(jQuery(this).val());
	});
	/* console.log(single_questions_val_array); */
	
	var lxed_single_ans_selected_sec = [];var lxed_single_ans_selected_ans = [];var lxed_single_ans_selected_q = [];
	jQuery('.lxed_single_answer_radio').each(function(){
		if(jQuery(this).is(':checked')){
			var section_id = jQuery(this).data('section_id');
			var question_id = jQuery(this).data('question_id');
			var ans_sel = jQuery(this).val();
			lxed_single_ans_selected_sec.push(section_id);
			lxed_single_ans_selected_ans.push(ans_sel);
			lxed_single_ans_selected_q.push(question_id);
		}
	});
	
	/* console.log(lxed_single_ans_selected_sec); */
	/* console.log(lxed_single_ans_selected_ans); */
	/* jQuery('.lp-screen').hide();
	return false; */
	
	if(blog_format == 'slide_show'){
		var full_rendered_html = jQuery('.lxed_render_block_here_slide_show').html();
		var blog_format = 'slide_show';
	}else{
		var full_rendered_html = jQuery('.lxed_render_block_here').html();
		var blog_format = 'news_feed';
	}
	
	/** Editable HTML **/
	var lxede_editable_html = jQuery('.lx_editor_blocks_load_here').html();
	var lx_post_avail_in=jQuery('.availablity_option:checked').val();
	var lx_community=jQuery('#lx_community').val();
	 var post_data = {
		'lxed_post_title':lxed_post_title,
		'lxed_thumbnail_img':lxed_thumbnail_img,
		'lxed_blog_post_excerpt':lxed_blog_post_excerpt,
		'lxed_cat_array':lxed_cat_array,
		'this_click':this_click,
		'insert_post_id':jQuery('#hid_blog_post_id').val(),
		'update_post_id':jQuery('.lxed_hid_post_id').val(),
		/* 'full_rendered_html':full_rendered_html,
		'lxede_editable_html':lxede_editable_html, */
		'section_break':section_break_array,
		'section_ids':section_ids,
		'text_block_array':text_block_array,
		'img_block_array':img_block_array,
		'txtonly_img_block_array':txtonly_img_block_array,
		'txt_imgonly_block_array':txt_imgonly_block_array,
		'img_textonly_html':img_textonly_html,
		'imgonly_text_html':imgonly_text_html,
		'blog_format':blog_format,
		'lx_post_avail_in':lx_post_avail_in,
		'lx_community':lx_community,
		'single_questions_array':single_questions_array,
		'single_ans_opt_q_id':single_ans_opt_q_id,
		'single_ans_opt_array':single_ans_opt_array,
		'single_ans_opt_q_id_sec':single_ans_opt_q_id_sec,
		'single_questions_val_array':single_questions_val_array,
		'video_block_array':video_block_array,
		'btnblock_label':btnblock_label,
		'btnblock_desturl':btnblock_desturl,
		'btnblock_desc':btnblock_desc,
		
		'lxed_single_ans_selected_ans':lxed_single_ans_selected_ans,
		'lxed_single_ans_selected_q':lxed_single_ans_selected_q,
		'lxed_single_ans_selected_sec':lxed_single_ans_selected_sec,
		
		'action':'fn_lx_publish_post'
	};
	jQuery('.lp-screen').show();
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			/* console.log(jQuery.parseJSON(response).msg);
			console.log(lx_path.blog_url); */
			if(jQuery.parseJSON(response).msg == 'Preview'){
				window.open(jQuery.parseJSON(response).link, '_blank');
			}
			if(jQuery.parseJSON(response).msg == 'Draft' || jQuery.parseJSON(response).msg == 'Preview'){
				jQuery('.hid_lxed_blog_post_id').val(jQuery.parseJSON(response).last_post_id);
				jQuery('.hid_lxed_blog_post_status').val('draft');
			}
			if(jQuery.parseJSON(response).msg == 'Publish'){
				jQuery('.hid_lxed_blog_post_id').val(jQuery.parseJSON(response).last_post_id);
				jQuery('.hid_lxed_blog_post_status').val('publish');
			}
			if(jQuery.parseJSON(response).msg == 'Update'){
				location.reload();
			}
			if(jQuery.parseJSON(response).msg == 'Draft' || jQuery.parseJSON(response).msg == 'Publish' || jQuery.parseJSON(response).msg == 'Preview'){
				jQuery('.lxed_edit_mode').trigger('click');
			}
			
			jQuery('.lp-screen').hide();
		}
	});
});

/**
* Previous and next
**/
jQuery(document).ready(function(){
	/* jQuery('.rendered_block').each(function(){
		alert(jQuery(this).data('section_id'));
	}); */
});

jQuery(document).on('change','.availablity_option',function(){
	if(jQuery('.availablity_option:checked').val()=='in_community')
	{
		jQuery('.community_select').insertAfter('.option_div1');
		jQuery('.community_select').css('margin-top','1rem');
		jQuery('.community_select').show();
		jQuery('.category_select').hide();
	}
	else{
		jQuery('.category_select').show();
		jQuery('.community_select').hide();
	}
});
jQuery(document).on('click','.lxed_cancle_blog_post',function(){
	var bp_status=jQuery('.hid_lxed_blog_post_status').val();
	var blog_post_id=jQuery('.lxed_hid_post_id').val();
	var uploaded=new Array();
	jQuery('input[type="file"]').each(function(){
		if(jQuery(this).val()!='')
		{
			uploaded.push(jQuery(this).closest(":has(img)").find('img').attr('src'));
		}
		else if(bp_status=='draft')
		{
			uploaded.push(jQuery(this).closest(":has(img)").find('img').attr('src'));
		}
	});
	if(uploaded.length>0)
	{
		jQuery('.lp-screen').show();
		if(bp_status=='draft')
		{
			var post_data={'blog_post_id':blog_post_id,'uploads':uploaded,'action':'fn_lx_delete_folder_from_s3'}
		}else{
			var post_data={'uploads':uploaded,'action':'fn_lx_delete_folder_from_s3'}
		}
		var ajax_path = lx_path.ajaxurl;
		jQuery.ajax({					
			url  : ajax_path,
			type: 'POST',
			data: post_data,
			dataType: 'html',						
			success  : function(response) {
				window.location.href=site_path.site_url;
			}
		});
	}else{
		window.location.href=site_path.site_url;
	}
	
});

jQuery(document).on('click','.disabled_single_choice',function(){
	var ajax_path = lx_path.ajaxurl;
	var section_id = jQuery(this).data('section_id');
	var question_id = jQuery(this).data('question_id');
	var loop_id = jQuery('.lxed_single_choice_answeropt_div'+section_id+question_id).length;
	var post_data = {
		'section_id':section_id,
		'question_id':question_id,
		'loop_id':loop_id,
		'action':'fn_lx_add_more_single_choice'
	};
	/* return false; */
	jQuery('.lp-screen').show();
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			jQuery('.disabled_single_choice_load'+section_id+question_id).append(response);
			jQuery('.lp-screen').hide();
		}
	});
});
jQuery(document).on('click','.lxed_button_question',function(){
	var ajax_path = lx_path.ajaxurl;
	var section_id = jQuery(this).data('section_id');
	var total_question = jQuery('.lxed_main_single_question_div_inner'+section_id).length+1;
	/* alert(total_question); */
	var post_data = {
		'section_id':section_id,
		'total_question':total_question,
		'action':'fn_lx_add_more_single_choice_questions'
	};
	jQuery('.lp-screen').show();
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			jQuery('.lxed_main_single_question_div'+section_id).append(response);
			jQuery('.lp-screen').hide();
		}
	});
});

/* jQuery(document).on('click',function(){
}); */
	

jQuery(document).on('click','.lxed_check_results',function(){
	var section_id= jQuery(this).data('section_id');
	var question_id = jQuery(this).data('question_id');
	jQuery('.lxed_front_single_choice_radio').each(function(){
		
		if(jQuery(this).attr('data-section_id') == section_id && jQuery(this).attr('data-question_id') == question_id){
			var in_sec_id = jQuery(this).attr('data-section_id');
			var in_q_id= jQuery(this).attr('data-question_id');
			var in_loopid= jQuery(this).attr('data-loop_id');
			jQuery('.lxed_front_single_choice_radio'+in_sec_id+in_loopid+in_q_id).each(function(){
				jQuery('.lxed_single_chose_answer'+in_sec_id+in_q_id+in_loopid).css('color','#000;');
				jQuery('.lxed_single_chose_answer'+in_sec_id+in_q_id+in_loopid).css('color','#000;');
				if(jQuery(this).is(':checked') == true){
					
					if(jQuery(this).val() == 'correct'){
						/* alert('sdfsdf'); */
						jQuery('.lxed_single_chose_answer'+in_sec_id+in_q_id+in_loopid).css('color','#5cd532');
						
						var html = jQuery('.lxed_single_chose_feedback'+in_sec_id+in_loopid).html();
						
						jQuery('.single_choice_results'+in_sec_id+in_q_id).html('<div class="mt-2 mb-2" style="border:1px solid #5cd532;padding:5px;background:#fff;">'+html+'</div>');
					}else{
						jQuery('.lxed_single_chose_answer'+in_sec_id+in_q_id+in_loopid).css('color','#ff0505');
						var html = jQuery('.lxed_single_chose_feedback'+in_sec_id+in_loopid).html();
						jQuery('.single_choice_results'+in_sec_id+in_q_id).html('<div class="mt-2 mb-2" style="border:1px solid #ff0505;padding:5px;background:#fff;">'+html+'</div>');
					}
				}
			});
		}
	});
});

jQuery(document).ready(function(){
	var i=1;
	jQuery('.lxed_slide_show_main_div').each(function(){
			jQuery(this).addClass('lxed_slide_show_main_div'+i);
			jQuery('.lxed_slide_show_main_div'+i).find('.rendered_lxed_page_breaknext').attr('data-next_id',(i+1));
			jQuery('.lxed_slide_show_main_div'+i).find('.rendered_lxed_page_breakprev').attr('data-prev_id',(i-1));
			if(i !== 1){
				jQuery('.lxed_slide_show_main_div'+i).hide();	
			}
		i++;
	});
	
	jQuery('.rendered_lxed_page_breaknext').click(function(){
		var id = jQuery(this).data('next_id');
		if(id !==''){
			jQuery('.lxed_slide_show_main_div'+(id-1)).hide();
			jQuery('.lxed_slide_show_main_div'+id).slideDown();
			/* alert(jQuery('.lxed_slide_show_main_div'+id).length); */
		}
	});
	jQuery('.rendered_lxed_page_breakprev').click(function(){
		var id = jQuery(this).data('prev_id');
		if(id !==''){
			jQuery('.lxed_slide_show_main_div'+(id+1)).hide();
			jQuery('.lxed_slide_show_main_div'+id).slideToggle();
			/* alert(jQuery('.lxed_slide_show_main_div'+id).length); */
		}
	});
	
	/** remove the text editor from the front **/
	jQuery('.rend_single_choice_block .lxed_single_chose_answer').removeAttr('contenteditable','true');
	jQuery('.rend_single_choice_block .lxed_single_chose_feedback').removeAttr('contenteditable','true');
});

/** Single on click of the single question textarea remove the text and can enter what ever he want to enter **/
jQuery(document).on('click','.lxed_block_padding .lxed_single_chose_answer',function(){
	
		var loop_id = jQuery(this).data("loop_id");
		var old_html = jQuery(this).html();
		if(old_html == 'Answer Option'){
			jQuery(this).html('');
		}
	
});

jQuery(document).on('click','.lxed_block_padding .lxed_single_chose_feedback',function(){
	
		var loop_id = jQuery(this).data("loop_id");
		var old_html = jQuery(this).html();
		if(old_html == 'Feedback if this answer is selected'){
			jQuery(this).html('');
		}
	
});

jQuery(document).on('focusout','.lxed_block_padding .lx_editor_singleans_opt',function(){

		var old_html_ans = jQuery(this).find('.lxed_single_chose_answer').html();
		var old_html_fb = jQuery(this).find('.lxed_single_chose_feedback').html();
/* alert(old_html_ans); */
		var loop_id = jQuery(this).data("loop_id");
		if(old_html_ans == '' || old_html_ans == 'Answer Option' || old_html_ans == '<br>'){
			jQuery(this).find('.lxed_single_chose_answer').html('Answer Option')
		}
		if(old_html_fb == '' || old_html_fb == 'Feedback if this answer is selected' || old_html_fb == '<br>'){
			jQuery(this).find('.lxed_single_chose_feedback').html('Feedback if this answer is selected');
		}
	
});


/** Remove single answer on delete click **/
jQuery(document).on('click','.lxed_remove_single_tab',function(){
	var section_id = jQuery(this).data('section_id');
	var question_id = jQuery(this).data('question_id');
	var loop_id = jQuery(this).data('loop_id');
	jQuery('.lxed_single_choice_answeropt_div'+section_id+question_id+loop_id).empty();
	jQuery('.lxed_single_choice_answeropt_div'+section_id+question_id+loop_id).hide();
});

/** Delete the single question **/
jQuery(document).on('click','.lxed_remove_single_ques',function(){
	var section_id = jQuery(this).data('section_id');
	var question_id = jQuery(this).data('question_id');
	jQuery('.lxed_main_single_question_div_inner'+section_id+question_id).remove();
});

jQuery(document).on('click','.lx_blog_delete',function(){
	var post_id=jQuery(this).data('post_id');
	jQuery('#delete_blog_modal').modal('show');
	html='';
	html+='<button type="button" class="btn btn_dark_state"  data-dismiss="modal">Cancle</button>';
    html+='<button type="button" class="btn btn_normal_state change_as_draft" id="change_as_draft" data-clicked="change_as_draft" data-post_id="'+post_id+'">Change to Draft</button>';
    html+='<button type="button" class="btn btn_danger_state delete_post" id="delete_post"  data-clicked="delete" data-post_id="'+post_id+'">Delete</button>';
    jQuery('#delete_blog_modal .modal-footer').html(html);
});

jQuery(document).on('click','.delete_post,.change_as_draft',function(){
		var post_id=jQuery(this).data('post_id');
		var clicked=jQuery(this).data('clicked');
		var post_data={'post_id':post_id,'clicked':clicked,'action':"lx_delete_blog_post"};
		jQuery('.lp-screen').show();
		jQuery.ajax({					
			url  : lx_path.ajaxurl,
			type: 'POST',
			data: post_data,
			dataType: 'html',						
			success  : function(response) {
				jQuery('#delete_blog_modal').modal('hide');
				location.reload();
				jQuery('.lp-screen').hide();
			}
		});
});

jQuery(document).on('click','.get_category_blog',function(e){
	e.preventDefault();
	jQuery('.lp-screen').show();
	var term_id=jQuery(this).data('term_id');
	jQuery.ajax({					
		url  : my_ajax_object.ajax_anchor,					
		type : 'POST',					
		data : {'term_id':term_id,'action':'get_category_blogpost'},					
		dataType : 'html',					
		success  : function(response) {
			jQuery('.load_blog').html(response);
			jQuery('.lp-screen').hide();
		}
	});
	
});
jQuery(document).on('click','.blog_thumb_delete',function(e){
	e.preventDefault();
	var r = confirm("Are you sure you want to delete the thumbnail!");
	if (r == true) {
		jQuery('.lp-screen').show();
		var blog_id=jQuery('.lxed_hid_post_id').val();
		if(jQuery('#hid_old_avalibility_option').val()=='in_community')
		{
			var community_id=jQuery(this).data('id');
			var post_data={'mode':'edit','blog_post_id':jQuery('.lxed_hid_post_id').val(),'community_id':community_id,'action':'fn_lx_editor_delete_thumbnail'};
		}else{
			var post_data={'mode':'edit','blog_post_id':jQuery('.lxed_hid_post_id').val(),'action':'fn_lx_editor_delete_thumbnail'};
		}
	
		jQuery.ajax({					
					url  : my_ajax.ajax_url,	
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