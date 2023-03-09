/* Poll Course Canvas jQuery*/

jQuery(document).ready(function(){
	//title
	var maxLength = 80;
	var length = jQuery('.pc_title').val().length;
	var length = maxLength-length;
	jQuery('#pc_title_chars').text(length);
	jQuery('.pc_title').keyup(function(){
		var maxLength = 80;
		var length = jQuery(this).val().length;
		var length = maxLength-length;
		jQuery('#pc_title_chars').text(length);
	});

	//subtitle
	var maxLength = 80;
	var length = jQuery('.pc_subtitle').val().length;
	var length = maxLength-length;
	jQuery('#pc_subtitle_chars').text(length);
	jQuery('.pc_subtitle').keyup(function(){
		var maxLength = 80;
		var length = jQuery(this).val().length;
		var length = maxLength-length;
		jQuery('#pc_subtitle_chars').text(length);
	});

	//introduction
	var maxLength = 1200;
	var length = jQuery('.pc_intro_text').val().length;
	var length = maxLength-length;
	jQuery('#pc_intro_text_chars').text(length);
	jQuery('.pc_intro_text').keyup(function(){
		var maxLength = 1200;
		var length = jQuery(this).val().length;
		var length = maxLength-length;
		jQuery('#pc_intro_text_chars').text(length);
	});

	var maxLength = 2400;
	jQuery('.addandTextarea').each(function(){
		var elID=jQuery(this).attr('id');
		var length = jQuery(this).val().length;
		var length = maxLength-length;
		jQuery('#'+elID+'_chars').text(length);
	});
	jQuery(document).on('keyup','.addandTextarea',function(){
		var elID=jQuery(this).attr('id');
		var maxLength = 2400;
		var length = jQuery(this).val().length;
		var length = maxLength-length;
		jQuery('#'+elID+'_chars').text(length);
	});
	
	//Quetion
	var maxLength = 1200;
	jQuery('.ta_quetion').each(function(){
		var elID=jQuery(this).attr('id');
		var length = jQuery(this).val().length;
		var length = maxLength-length;
		jQuery('#'+elID+'_chars').text(length);
	});
	jQuery(document).on('keyup','.ta_quetion',function(){
		var elID=jQuery(this).attr('id');
		var maxLength = 1200;
		var length = jQuery(this).val().length;
		var length = maxLength-length;
		jQuery('#'+elID+'_chars').text(length);
	});

	//Answer's
	var maxLength = 150;
	jQuery('.ta_answer').each(function(){
		var elID=jQuery(this).attr('id');
		var length = jQuery(this).val().length;
		var length = maxLength-length;
		jQuery('#'+elID+'_chars').text(length);
	});
	
	jQuery('.ta_answer').keyup(function(){
		var elID=jQuery(this).attr('id');
		var maxLength = 150;
		var length = jQuery(this).val().length;
		var length = maxLength-length;
		jQuery('#'+elID+'_chars').text(length);
	});

	//feedback's
	var maxLength = 250;
	jQuery('.ta_feedback').each(function(){
		var elID=jQuery(this).attr('id');
		var length = jQuery(this).val().length;
		var length = maxLength-length;
		jQuery('#'+elID+'_chars').text(length);
	});
	jQuery('.ta_feedback').keyup(function(){
		var elID=jQuery(this).attr('id');
		var maxLength = 250;
		var length = jQuery(this).val().length;
		var length = maxLength-length;
		jQuery('#'+elID+'_chars').text(length);
	});

	//conclusion
	var maxLength = 1200;
	var length = jQuery('.pc_conclusion_text').val().length;
	var length = maxLength-length;
	jQuery('#pc_conclusion_text_chars').text(length);
	jQuery('.pc_conclusion_text').keyup(function(){
		var maxLength = 1200;
		var length = jQuery(this).val().length;
		var length = maxLength-length;
		jQuery('#pc_conclusion_text_chars').text(length);
	});

	//Submit Prompt
	var maxLength = 300;
	var length = jQuery('#submit_prompt_text').val().length;
	var length = maxLength-length;
	jQuery('#submit_prompt_text_chars').text(length);
	jQuery('#submit_prompt_text').keyup(function(){
		var maxLength = 300;
		var length = jQuery(this).val().length;
		var length = maxLength-length;
		jQuery('#submit_prompt_text_chars').text(length);
	});
	
	/* Additional Notes */
	var maxLength = 300;
	jQuery('.additional_note_txt').each(function(){
		var id=jQuery(this).attr('id');
		var length = jQuery(this).val().length;
		var length = maxLength-length;
		jQuery('#'+id+'_chars').text(length);
	});
	jQuery(document).on('keyup','.additional_note_txt',function(){
		var id=jQuery(this).attr('id');
		var maxLength = 300;
		var length = jQuery(this).val().length;
		var length = maxLength-length;
		jQuery('#'+id+'_chars').text(length);
	});
	
});
/*----------------Toggle Make it a Text Entry answer (500 characters)----------------*/
/* jQuery(document).on('change','.make_textentry_answer',function(){
	var qID=jQuery(this).data('qid');
	if( jQuery(this).is(":checked") === true ){
		jQuery(this).val('1');
		jQuery( "#make_multiple_ans"+qID).attr( "disabled", "disabled" );
		jQuery( "#make_multiple_ans"+qID).prop( "checked", "" );
		jQuery('.multiple_ans'+qID+' .off').show();	
		jQuery('.multiple_ans'+qID+' .on').hide();	
		jQuery( "#make_multiple_ans"+qID).val("0");
		jQuery('.answer_section'+qID).hide();
	} 
	if( jQuery(this).is(":checked") === false ){
		jQuery(this).val('0');
		jQuery( "#make_multiple_ans"+qID ).removeAttr( "disabled" );	
		jQuery('.answer_section'+qID).show();
	}  
}); */
/* start */
jQuery(document).on('change','.single_answer_selection',function(){
	var qID=jQuery(this).data('qid');
	if( jQuery(this).is(":checked") === true ){
		jQuery(this).val('1');
		jQuery("#question_type"+qID).val("0");
		jQuery('#question_type_meta'+qID).val('0');
		jQuery("#make_multiple_ans"+qID).val("0");
		jQuery("#make_textentry_answer"+qID).val("0");
		jQuery("#make_document_answer"+qID).val("0");
		jQuery('.answer_section'+qID).show();
		jQuery('.additional_note_multians'+qID).hide();
		jQuery('.additional_note_docans'+qID).hide();
		jQuery('.add_note_multians'+qID).val("0");
		jQuery('.add_note_docans'+qID).val("0");
		jQuery('.add_note_multians'+qID ).removeAttr("checked");
		jQuery('.add_note_docans'+qID ).removeAttr("checked");
	} 
	if( jQuery(this).is(":checked") === false ){
		jQuery(this).val('0');
		jQuery('.answer_section'+qID).hide();
	}   
});
jQuery(document).on('change','.make_multiple_ans',function(){
	var qID=jQuery(this).data('qid');
	if( jQuery(this).is(":checked") === true ){
		jQuery(this).val('1');
		jQuery("#question_type"+qID).val("1");
		jQuery('#question_type_meta'+qID).val('0');
		jQuery("#make_textentry_answer"+qID).val("0");
		jQuery("#make_document_answer"+qID).val("0");
		jQuery('.answer_section'+qID).show();
		jQuery('.additional_note_multians'+qID).show();
		jQuery('.additional_note_docans'+qID).hide();
		jQuery('.add_note_multians'+qID).val("0");
		jQuery('.add_note_docans'+qID).val("0");
		jQuery('.single_answer_selection'+qID).val("0");
		jQuery('.single_answer_selection'+qID).removeAttr("checked");
		jQuery('.add_note_docans'+qID).removeAttr("checked"); 
	} 
	if( jQuery(this).is(":checked") === false ){
		jQuery(this).val('0');
		jQuery( "#make_multiple_ans"+qID).val("0");
		jQuery('.answer_section'+qID).hide();
		jQuery('.additional_note_multians'+qID).hide();
		jQuery('.add_note_multians'+qID ).removeAttr("checked");
	}  
});
jQuery(document).on('change','.make_textentry_answer',function(){
	var qID=jQuery(this).data('qid');
	if( jQuery(this).is(":checked") === true ){
		jQuery(this).val('1');
		jQuery("#question_type"+qID).val("2");
		jQuery('#question_type_meta'+qID).val('0');
		jQuery("#make_multiple_ans"+qID).val("0");
		jQuery("#make_document_answer"+qID).val("0");
		jQuery('.answer_section'+qID).hide();
		jQuery('.additional_note_multians'+qID).hide();
		jQuery('.additional_note_docans'+qID).hide();
		jQuery('.add_note_multians'+qID).val("0");
		jQuery('.add_note_docans'+qID).val("0");
		jQuery('.single_answer_selection'+qID).val("0");
		jQuery('.single_answer_selection'+qID).removeAttr("checked");
		jQuery('.add_note_multians'+qID).removeAttr("checked");
		jQuery('.add_note_docans'+qID ).removeAttr("checked");
	} 
	if( jQuery(this).is(":checked") === false ){
		jQuery(this).val('0');
		jQuery('.answer_section'+qID).show();
	}  
}); 
jQuery(document).on('change','.add_note_multians',function(){
	var qID=jQuery(this).data('qid');
	if( jQuery(this).is(":checked") === true ){
		jQuery(this).val('1');
		jQuery('.add_note_multians'+qID).attr('checked','checked');
		jQuery('.add_note_docans'+qID).removeAttr("checked");
	} 
	if( jQuery(this).is(":checked") === false ){
		jQuery(this).val('0');
		jQuery('.add_note_multians'+qID).removeAttr("checked");
		
	} 
	if( jQuery('.add_note_multians'+qID).val() == 1 && jQuery('.add_note_docans'+qID).val()==0 ){
		jQuery('#question_type_meta'+qID).val('1');
	}else{
		jQuery('#question_type_meta'+qID).val('0');
	}
});
jQuery(document).on('change','.add_note_docans',function(){
	var qID=jQuery(this).data('qid');
	if( jQuery(this).is(":checked") === true ){
		jQuery(this).val('1');
		jQuery('.add_note_docans'+qID).attr('checked','checked');
		jQuery('.add_note_multians'+qID).removeAttr("checked");
	} 
	if( jQuery(this).is(":checked") === false ){
		jQuery(this).val('0');
		jQuery('.add_note_docans'+qID).removeAttr("checked");
	} 
	if( jQuery('.add_note_multians'+qID).val() == 0 && jQuery('.add_note_docans'+qID).val()==1 ){
		jQuery('#question_type_meta'+qID).val('1');
	}else{
		jQuery('#question_type_meta'+qID).val('0');
	}
});
jQuery(document).on('change','.make_document_answer',function(){
	var qID=jQuery(this).data('qid');
	if( jQuery(this).is(":checked") === true ){
		jQuery(this).val('1');
		jQuery("#question_type"+qID).val("3");
		jQuery('#question_type_meta'+qID).val('0');
		jQuery("#make_textentry_answer"+qID).val("0");
		jQuery('.answer_section'+qID).hide();
		jQuery('.additional_note_docans'+qID).show();
		jQuery('.additional_note_multians'+qID).hide();
		jQuery('.add_note_multians'+qID).val("0");
		jQuery('.add_note_docans'+qID).val("0");
		jQuery('.single_answer_selection'+qID).val("0");
		jQuery('.single_answer_selection'+qID).removeAttr("checked");
		jQuery('.add_note_multians'+qID ).removeAttr("checked");
	} 
	if( jQuery(this).is(":checked") === false ){
		jQuery(this).val('0');
		jQuery('.answer_section'+qID).show();
		jQuery('.additional_note_docans'+qID).hide();
		jQuery('.add_note_docans'+qID ).removeAttr("checked"); 
	}  
});
 
/* end */
jQuery(document).on('change','.avail_in_course',function(){
	if(jQuery(this).is(':checked')){
		jQuery('.btn_name').css('display','block');
		jQuery(this).val('1');
	}else{
		jQuery('.btn_name').css('display','none');
		jQuery(this).val('0');
	}
});

jQuery(document).on('change','.makeitSpecifictoModule',function(){
	if( jQuery(this).is(':checked') ){
		jQuery('.plXapimoduleselectionDiv').show();
	}else{
		jQuery('.plXapimoduleselectionDiv').hide();
	}
	/* if(jQuery(this).is(':checked')){
		jQuery('.btn_name').css('display','block');
		jQuery(this).val('1');
	}else{
		jQuery('.btn_name').css('display','none');
		jQuery(this).val('0');
	} */
});
/* start */
/* jQuery(document).on('change','.make_multiple_ans',function(){
	var qID=jQuery(this).data('qid');
	if( jQuery(this).is(":checked") === true ){
		jQuery(this).val('1');
	} 
	if( jQuery(this).is(":checked") === false ){
		jQuery(this).val('0');
	}  
}); */

/* end */
jQuery(document).on('change','.feedback_toggle',function(){
	var qID=jQuery(this).data('question_id');
	if( jQuery(this).is(":checked") === true ){
		jQuery(this).val('1');
		jQuery('.ans_main_div'+qID+' .ta_feedback').not(':first').attr('disabled','disabled');
	} 
	if( jQuery(this).is(":checked") === false ){
		jQuery(this).val('0');
		jQuery('.ans_main_div'+qID+' .ta_feedback').not(':first').removeAttr('disabled');
	}  
});
/*----------Question1 (with it's set of answers) can be collapsed/expanded----------*/
jQuery(document).on('click','.btn-collapse',function(){
	var qID=jQuery(this).data('questionid');
	jQuery('.question_answer_section'+qID).toggle(); 
	if ( jQuery('.question_answer_section'+qID).css('display') == 'none' ) {
		jQuery(this).find('svg').attr('data-icon', 'plus'); 
	} else {
		jQuery(this).find('svg').attr('data-icon', 'minus'); 
	}
});


/* popover for tips formatting */
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


/*---------------------Add New Answer Field---------------------*/
jQuery(document).on('click','.add_AnsButton',function() {
	
	var trashicon = jQuery('.trash_icon').val();
	var question_id = jQuery(this).data('question_id'); 
	var fbForAll=jQuery('#feedback_toggle'+question_id).val();
	var total_ans = jQuery('.ans_main_div'+question_id).length;
	var ansid = jQuery(this).data('ansid');
	var last_ans_id = '';
	var last_fb_id = '';
	jQuery('.ans_main_div'+question_id).each(function(){
		last_ans_id = jQuery(this).data('ansid');
		last_fb_id = jQuery(this).data('feedbackid');
	});
	var length_ansid = total_ans+1;
	var new_ansid = last_ans_id+1; 
	var new_fbid = last_fb_id+1; 
	var disabled='';
	if(fbForAll=='1'){
		disabled='disabled';
	}
	if( length_ansid <= 6 ){
		var html = '<div class="row poll_div ans_main_div'+question_id+' ans_main_div'+question_id+new_ansid+'" data-questionid="'+question_id+'" data-ansid="'+new_ansid+'" data-feedbackid="'+new_fbid+'">'+
						'<div class="col-md-4">'+ 
							'<div class="form-group answer'+question_id+new_ansid+'">'+
								'<label class="new_answer_txt">Answer (optional)</label>'+
								'<textarea type="text" class="form-control pc_answer'+question_id+new_ansid+' ta_answer" maxlength="150" id="pc_answer'+question_id+new_ansid+'" name="pc_answer'+question_id+new_ansid+'" data-qid="'+question_id+'"></textarea>'+
								'<div class="textarea_max_chars">'+
									'<small class="ans_error">Cannot be empty</small>'+
									'<small class="small_right"><span id="pc_answer'+question_id+new_ansid+'_chars">150</span> characters remaining</small>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div class="col-md-4">'+
							'<div class="optional_feedback optional_feedback'+question_id+new_ansid+new_fbid+'">'+
								'<div class="form-group">'+
									'<label class="new_feedback_txt">Optional feedback</label>'+
									'<textarea type="text" class="form-control feedback'+question_id+new_ansid+new_fbid+' ta_feedback" maxlength="250" id="feedback'+question_id+new_ansid+new_fbid+'" name="feedback'+question_id+new_ansid+new_fbid+'" value="" '+disabled+'></textarea>'+
									'<div class="textarea_max_chars">'+
										'<small class="small_right"><span id="feedback'+question_id+new_ansid+new_fbid+'_chars">250</span> characters remaining</small>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div class="col-md-2 remove_Answer_btn">'+
							'<button type="button" class="btn btn-danger ans_delete" data-ansid="'+new_ansid+'" data-quesid="'+question_id+'">'+
								'<i class="'+trashicon+'" aria-hidden="true"></i>'+
							'</button>'+
						'</div>'+
					'</div>';
						
		jQuery( html ).insertAfter( '.ans_main_div'+question_id+last_ans_id );
		
	}else {
		jQuery('.pc_new_answer_section'+question_id).hide();
	}

});

jQuery(document).on('click','.ans_delete',function(){
	var qid = jQuery(this).data('quesid');
	var aid = jQuery(this).data('ansid');
	var mode = jQuery('#mode').val();
	if(mode=='edit'){
		var oqid = jQuery('.ans_main_div'+qid+aid).data('original_qid');
		var oaid = jQuery('.ans_main_div'+qid+aid).data('original_aid');
		var post_data={'question_id':oqid,'answer_id':oaid,'action':'lx_poll_delete_answer'};
		jQuery.ajax({
			url: ajax_ob.ajax_url,
			type:'POST',
			data: post_data,
			success: function(response) {
				jQuery('.ans_main_div'+qid+aid).remove();
			}
		});
	}else{
		jQuery('.ans_main_div'+qid+aid).remove();
	}
	var total_ans = jQuery('.ans_main_div'+qid).length;
	if( total_ans < 6 ){
		jQuery('.pc_new_answer_section'+qid).show();
	}
});

/*---------------------Add New Question Section---------------------*/
jQuery(document).on('click','.add_QueButton',function() {
	jQuery('.lp-screen').show();
	var trashicon = jQuery('.trash_icon').val();
	var total_question = jQuery('.main_question_div').length;
	var last_question_id = '';
	jQuery('.main_question_div').each(function(){
		last_question_id = jQuery(this).data('questionid');
	});
	var new_question_id = last_question_id+1; 
	var total_textentry_answer_div = jQuery('.textentry_answer_div').length;
	var total_multiple_ans = jQuery('.multiple_ans').length;
	/* start */
	var total_document_ans = jQuery('.document_answer').length;
	/* end */
	var post_data={
		'question_id':new_question_id,
		'textentry_answer':total_textentry_answer_div,
		'multiple_ans':total_multiple_ans,
		/* start */
		'document_answer':total_document_ans,
		/* end */
		'action':'add_question_section'
	};
	jQuery.ajax({
		url: ajax_ob.ajax_url,
		type:'POST',
		data: post_data,
		success: function(response) {
			jQuery(response).insertAfter( '.main_question_div'+last_question_id ); 
			jQuery('.lp-screen').hide();
		}
	});
});

jQuery(document).on('click','.question_delete',function(){
	var qid = jQuery(this).data('quesid');
	var mode = jQuery('#mode').val();
	if(mode=='edit'){
		var oqid = jQuery('.main_question_div'+qid).data('original_qid');
		var post_data={'question_id':oqid,'action':'lx_poll_delete_question'};
		jQuery.ajax({
			url: ajax_ob.ajax_url,
			type:'POST',
			data: post_data,
			success: function(response) {
				jQuery('.main_question_div'+qid).remove();
			}
		});  
	}else{
		jQuery('.main_question_div'+qid).remove();
	}
});

jQuery(document).on('click','.refresh_preview_pollcourse',function(e){
	e.preventDefault();
	var pollArr=poll_preview();
	var restart=jQuery('.make_restart').val();
	var submit_prompt_text=jQuery('#submit_prompt_text').val();
	var include_back_btn=jQuery('#include_back_btn').val();
	var back_link=jQuery('#sel_back_link').val();
	var cnt=new Array();
	/* start */
	/* jQuery('.question_type_div').each(function(){
		var question_id = jQuery(this).data('question_id');
		if(jQuery('#question_type'+question_id).val()==0 || jQuery('#question_type'+question_id).val()==1){ */
			/* --- */
			jQuery('.ta_answer').each(function(){
				var qid=jQuery(this).data('qid');
				if(jQuery(this).val()==''){
					if(jQuery('#question_type'+qid).val()=='0' || jQuery('#question_type'+qid).val()=='1'){
						var div=jQuery(this).attr('id').split('_')[1];
						jQuery('.'+div+' .ans_error').show();
						cnt.push('1');
					}
				}
			});
			jQuery('.ta_quetion').each(function(){
				if(jQuery(this).val()==''){
					var div=jQuery(this).attr('id').split('_')[1];
					jQuery('.'+div+'_error').show();
					cnt.push('1');
				}
			});
			/* --- */
		/* }
	}); */
	/* end */
	
	var questionwiserequiredarr = [];
	jQuery('.ansrequiredtgl').each(function(){
		var qid = jQuery(this).data('question_id');
		var reqansval = 0;
		if( jQuery(this).prop('checked') == true ){
			var reqansval = 1;
		}
		questionwiserequiredarr[qid] = reqansval;
	});
	if(cnt.length>0){
		return false;
	}
	jQuery('.lp-screen').show();
	var post_data = {
		'poll_arr':pollArr,
		'questionwiserequiredarr':questionwiserequiredarr,
		'restart_poll':restart,
		'submit_prompt':submit_prompt_text,
		'include_back_btn':include_back_btn,
		'back_nav_link':back_link,
		'action':'lx_pollcourse_preview'
	};
	jQuery.ajax({
		url: ajax_ob.ajax_url,
		type:'POST',
		data: post_data,
		success: function(response) {
			jQuery('.preview_slides').html(response);
			jQuery('.lp-screen').hide();
		}
	});   
	
}); 

function poll_preview(){
	var introArr=[];
	var questionArr=[];
	var cnclArr=[];
	var ansArr=[];
	if(jQuery('.intoduction_content').css('display')=='block'){
		if(jQuery('.introduction_thumbnail .thumb_prev').data('uploaded')=='1'){
			introArr['image']=jQuery('.introduction_thumbnail .thumb_prev').attr('src');
		}else{
			introArr['image']='broken';
		}
		introArr['text']=jQuery('.pc_intro_text').val();
	}
	jQuery('.poll_div').each(function(){
		var question_id=jQuery(this).data('questionid');
		var ans_id = jQuery(this).data('ansid');
		var feedback_id = jQuery(this).data('feedbackid');
		var mode=jQuery('#mode').val();
		if(mode=='edit'){
			var orig_qid=jQuery(this).data('original_qid');
			var orig_aid=jQuery(this).data('original_aid');
			if(typeof orig_qid !== 'undefined' && orig_qid !== false){
				questionArr['question'+question_id+'_orignalqid']=orig_qid;
				if(typeof orig_aid !== 'undefined' && orig_aid !== false){
					questionArr['question'+question_id+'_orignalaid'+ans_id]=orig_aid;
				}
			}
		}
		var uploaded=jQuery('#thumb_prev'+question_id).attr('data-uploaded');
		if(uploaded=='1'){
			questionArr['question'+question_id+'_image'] = jQuery('#thumb_prev'+question_id).attr('src');
		}else{
			questionArr['question'+question_id+'_image'] = 'broken';
		}
		
		questionArr['question'+question_id+'_heading'] = jQuery('.pc_question'+question_id).val();
		questionArr['question'+question_id+'_questionType'] = jQuery('#question_type'+question_id).val();
		questionArr['question'+question_id+'_questionTypeMeta'] = jQuery('#question_type_meta'+question_id).val();
		/* questionArr['question'+question_id+'_multiAns'] = jQuery('#make_multiple_ans'+question_id).val();
		questionArr['question'+question_id+'_textentry'] = jQuery('#make_textentry_answer'+question_id).val();  */
		questionArr['question'+question_id+'_fbForAll'] = jQuery('#feedback_toggle'+question_id).val();
		questionArr['question'+question_id+'_answer'+ans_id] = jQuery('.pc_answer'+question_id+ans_id).val();
		questionArr['question'+question_id+'_feedback'+feedback_id] = jQuery('.feedback'+question_id+ans_id+feedback_id).val();
		
		/* start 
		questionArr['question'+question_id+'_addNoteMultiAns'] = jQuery('.add_note_multians'+question_id).val();
		questionArr['question'+question_id+'_addNoteDocAns'] = jQuery('.add_note_docans'+question_id).val();
		end */
	});
	if(jQuery('.conclusion_thumbnail .thumb_prev').data('uploaded')=='1'){
		cnclArr['image']=jQuery('.conclusion_thumbnail .thumb_prev').attr('src');
	}else{
		cnclArr['image']='broken';
	}
	cnclArr['text']=jQuery('.pc_conclusion_text').val();
	var pollArr = { 
		'introduction':Object.assign({},introArr),
		'questions':Object.assign({},questionArr),
		'conclusion':Object.assign({},cnclArr) 
	};
	return pollArr;
}
jQuery(document).on('change','.lx_poll_que_thumb',function(e){
	var qID=jQuery(this).data('questionid');
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
        jQuery('.alert').hide();
    	jQuery('#modal').modal({backdrop:'static', keyboard:false});
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
        jQuery('.hid_lx_poll_img_click').val('question_thumbnail'+qID);
        jQuery('.hid_lx_poll_img_type').val('question');
    }else{
		jQuery('#thumb_prev'+qID).attr('src','');
		jQuery('#thumb_prev'+qID).hide();
		jQuery('.que_thumb'+qID).css({'width':'280px','height': '170px'});
	}
	
});
jQuery(document).on('change','#lx_poll_cncl_thumb',function(e){
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
        jQuery('.alert').hide();
    	jQuery('#modal').modal({backdrop:'static', keyboard:false});
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
        jQuery('.hid_lx_poll_img_click').val('conclusion_thumbnail');
        jQuery('.hid_lx_poll_img_type').val('conclusion');
    }else{
		jQuery('#cncl_prev').attr('src',jQuery('.hid_prev').val());
	}
});

jQuery(document).on('keyup','.addandTextarea',function(){
	var hyperlinkcolor = jQuery('.hidhyperlinkcolor').val();
	jQuery(this).css('border-color','#cccccc');
});

jQuery(document).on('click','.btn_preview_next',function(){
	var next_div=jQuery(this).data('next');
	var current_div=jQuery(this).data('current');
	var Qid = jQuery(this).data('qid');
	if( Qid != undefined ){
		var is_required = jQuery('.hidreqfield'+Qid).val();
		if( is_required == 1 ){
			if( jQuery('.ans_item'+Qid).length > 0 ){
				var cntofansgiven = 0;
				jQuery('.ans_item'+Qid).each(function(){
					if( jQuery(this).hasClass('selected_ans') ){
						cntofansgiven +=1;
					}
				});
				console.log(cntofansgiven);
				if( cntofansgiven <= 0 ){
					jQuery('.ans_item'+Qid).css('border','1px solid red');
					return false;
				}
			}
			if( jQuery('#answer_text'+Qid).length > 0 ){
				if( jQuery('#answer_text'+Qid).val() == '' ){
					jQuery('#answer_text'+Qid).css('border','1px solid red');
					return false;
				}
			}
		}
	}
	jQuery('.'+current_div).hide();
	jQuery('.'+next_div).show();
});
jQuery(document).on('click','.btn_preview_prev',function(){
	var prev_div=jQuery(this).data('prev');
	var current_div=jQuery(this).data('current');
	jQuery('.'+current_div).hide();
	jQuery('.'+prev_div).show();
});
jQuery(document).on('click','.btn_start_again',function(){
	jQuery('.conclusion_div').hide();
	jQuery('.question_div_item').hide();
	if(jQuery('.intoduction_content').css('display')=='block'){
		jQuery('.intro_div').show();
	}else{
		jQuery('.question_div1').show();
	}
	jQuery('.ans_div_item').removeClass('selected_ans');
	jQuery('.feedback_div').hide();
	jQuery('.answer_div textarea').val('');
})
jQuery(document).on('change','.make_restart',function(){
	if(jQuery(this).is(':checked') === true ){
		jQuery(this).val("1");
	}
	if(jQuery(this).is(':checked') === false ){
		jQuery(this).val("0");
	}
});
jQuery(document).on('change','.required_completion',function(){
	if(jQuery(this).is(':checked') === true ){
		jQuery(this).val("1");
	}
	if(jQuery(this).is(':checked') === false ){
		jQuery(this).val("0");
	}
});
jQuery(document).on('click','.ans_div_item',function(){
	var qID=jQuery(this).data('qid');
	var ansID=jQuery(this).data('ansid');
	var multiselect=jQuery('#multiple_ans'+qID).val();
	/* start */
	var add_note=jQuery('#add_note_multiple_ans'+qID).val();
	/* end */
	var hyperlinkcolor = jQuery('.hidhyperlinkcolor').val();
	jQuery('.ans_item'+qID).css('border','1px solid '+hyperlinkcolor);
	
	if(multiselect==1){
		if(jQuery('.ans_item'+qID+ansID).hasClass('selected_ans')){
			jQuery('.ans_item'+qID+ansID).removeClass('selected_ans');
			jQuery('#feedback_div'+qID+ansID).hide();
		}else{
			jQuery('.ans_item'+qID+ansID).addClass('selected_ans');
			jQuery('#feedback_div'+qID+ansID).show();
		}
	}else{
		jQuery('.ans_item'+qID).each(function(){
			if(jQuery(this).hasClass('selected_ans')){
				var sqID=jQuery(this).data('qid');
				var sansID=jQuery(this).data('ansid')
				jQuery(this).removeClass('selected_ans');
				jQuery('#feedback_div'+sqID+sansID).hide();
			}
		});
		jQuery('.ans_item'+qID+ansID).addClass('selected_ans');
		jQuery('#feedback_div'+qID+ansID).show();
	}
	/* start */
	if( jQuery('.ans_div_item').hasClass('selected_ans') || add_note==1 ){
		jQuery('.additional_note_txt_div'+qID).show();
	}else{
		jQuery('.additional_note_txt_div'+qID).hide();
	}
	/* end */
});

jQuery(document).on('keyup','#primary_recipient_email',function(){
	var email=jQuery(this).val();
	var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	if(email!='' && !testEmail.test(email)){
		jQuery('#recipient_email_error').html("Check email.  Something doesn't look right");
	}else{
		jQuery('#recipient_email_error').html('');
	}
});
jQuery(document).on('click','.save_poll',function(){
	var status=jQuery(this).data('status');
	var title=jQuery('#pc_title').val();
	var subtitle=jQuery('#pc_subtitle').val();
	var recipient_email=jQuery('#primary_recipient_email').val();
	var secondary_email=jQuery('#secondary_recipient_email').val();
	var restart=jQuery('#make_restart').val();
	var req_completion=jQuery('#required_completion').val();
	var avail_in_course=jQuery('#avail_in_course').val();
	var btn_label=jQuery('#in_course_btn_label').val();
	var include_back_btn=jQuery('#include_back_btn').val();
	var back_nav_link=jQuery('#sel_back_link').val();
	var sumbit_prompt=jQuery('#submit_prompt_text').val();
	var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	var cnt=new Array();
	if(title==''){
		jQuery('.alert_box').html('Please add poll title.');
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('#pc_title').focus();
			jQuery('.alert_box').hide();
		},3000);
		return false;
	}
	if(recipient_email==''){
		jQuery('.alert_box').html('Please add primary poll results recipient(email).');
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('#primary_recipient_email').focus();
			jQuery('.alert_box').hide();
		},3000);
		return false;
	}
	if(!testEmail.test(recipient_email)){
		jQuery('#recipient_email_error').html("Check email.  Something doesn't look right");
		return false;
	}
	
	/* start */
	jQuery('.question_type_div').each(function(){
		var question_id = jQuery(this).data('question_id');
		if(jQuery('#question_type'+question_id).val()==0 || jQuery('#question_type'+question_id).val()==1){
			/* --- */
			jQuery('.ta_answer').each(function(){
				var qid=jQuery(this).data('qid');
				if(jQuery(this).val()==''){
					if(jQuery('#question_type'+qid).val()=='2'){
						var div=jQuery(this).attr('id').split('_')[1];
						jQuery('.'+div+' .ans_error').show();
						cnt.push('1');
					}
				}
			});
			jQuery('.ta_quetion').each(function(){
				if(jQuery(this).val()==''){
					var div=jQuery(this).attr('id').split('_')[1];
					jQuery('.'+div+'_error').show();
					cnt.push('1');
				}
			});
			/* --- */
		}
	});
	/* end */
	/* jQuery('.ta_answer').each(function(){
		var qid=jQuery(this).data('qid');
		if(jQuery(this).val()==''){
			if(jQuery('#make_textentry_answer'+qid).val()=='0'){
				var div=jQuery(this).attr('id').split('_')[1];
				jQuery('.'+div+' .ans_error').show();
				cnt.push('1');
			}
		}
	});
	jQuery('.ta_quetion').each(function(){
		if(jQuery(this).val()==''){
			var div=jQuery(this).attr('id').split('_')[1];
			jQuery('.'+div+'_error').show();
			cnt.push('1');
		}
	}); */
	
	/* if(cnt.length>0){
		return false;
	} */
	
	var module_apperain = 0;var ismoduletoggleon = 0;
	if( jQuery('.makeitSpecifictoModule').is(':checked') ){
		module_apperain = jQuery('.plXapimoduleselection').val();
		ismoduletoggleon = 1;
	}
	var questionwiserequiredarr = [];
	jQuery('.ansrequiredtgl').each(function(){
		var qid = jQuery(this).data('question_id');
		console.log(qid);
		var reqansval = 0;
		if( jQuery(this).prop('checked') == true ){
			var reqansval = 1;
		}
		questionwiserequiredarr[qid] = reqansval;
	});
	
	jQuery('.lp-screen').show();
	var postdata={
		'course_id':jQuery('.course_id').val(),
		'poll_id':jQuery('.poll_id').val(),
		'title':title,
		'subtitle':subtitle,
		'primary_email':recipient_email,
		'secondary_email':secondary_email,
		'restart_poll':restart,
		'required_completion':req_completion,
		'avail_in_course':avail_in_course,
		'btn_label':btn_label,
		'questionwiserequiredarr':questionwiserequiredarr,
		'poll_arr':poll_preview(),
		'status':status,
		'submit_prompt':sumbit_prompt,
		'include_back_btn':include_back_btn,
		'back_nav_link':back_nav_link,
		'mode':jQuery('#mode').val(),
		'module_apperain':module_apperain,
		'ismoduletoggleon':ismoduletoggleon,
		'action':'lx_save_poll'
	};
	jQuery.ajax({
		url: ajax_ob.ajax_url,
		type:'POST',
		data: postdata,
		success: function(response) {
			var res=jQuery.parseJSON(response);
			if(res.msg=='exist'){
				jQuery('.alert_box').html('Title already exists');
				jQuery('.alert_box').show();
				setTimeout(function(){
					jQuery('#pc_title').focus();
					jQuery('.alert_box').hide();
				},3000);
				jQuery('.lp-screen').hide();
			}else if(res.msg=='inserted' || res.msg=='updated'){	
				window.location.href=res.link;
			}
		}
	});
});

jQuery(document).on('click','.hide_show',function(){
	var content=jQuery(this).data('content');
	if(jQuery(this).hasClass('dblock')){
		jQuery(this).removeClass('dblock');
		jQuery(this).addClass('hide');
		jQuery('.'+content).hide();
		jQuery(this).html('<i class="fa-solid fa-eye-slash"></i>');
	}else{
		jQuery(this).removeClass('hide');
		jQuery(this).addClass('dblock');
		jQuery('.'+content).show();
		jQuery(this).html('<i class="fa fa-eye"></i>');
	}
});

jQuery(document).on('click','.poll_cancle',function(){ 
	var status=jQuery('.poll_status').val();
	var course_id=jQuery('.course_id').val();
	var poll_id=jQuery('.poll_id').val();
	var mode=jQuery('#mode').val();
	if( mode=='add'){
		jQuery('.lp-screen').show();
		var post_data={'poll_id':poll_id,'course_id':course_id,'status':status,'action':'lx_poll_cancle'}
		jQuery.ajax({					
			url: ajax_ob.ajax_url,
			type: 'POST',
			data: post_data,
			dataType: 'html',						
			success  : function(response) {
				window.location.href=jQuery('.hidden_back_link_pc').val();
			}
		});
	}else{
		window.location.href=jQuery('.hidden_back_link_pc').val();
	}
});
jQuery(document).on('change','#include_back_btn',function(){
	if(jQuery(this).is(':checked')){
		jQuery('.back_nav_link').show();
		jQuery(this).val('1');
	}else{
		jQuery('.back_nav_link').hide();
		jQuery(this).val('0');
	}
})