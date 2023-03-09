/***************************************** Poll Course Page jQuery *************************************************/

/*-------------- pollcourse content change on button click ----------------*/

var maxLength = 2400;
jQuery(document).on('each','.addandTextarea',function(){
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

/* start */
/* Additional Note for Multiple Answers  */
var maxLength = 300;
jQuery('.addNoteDocAns').each(function(){
	var id=jQuery(this).attr('id');
	var length = jQuery(this).val().length;
	var length = maxLength-length;
	jQuery('#'+id+'_chars').text(length);
});
jQuery(document).on('keyup','.addNoteDocAns',function(){
	var id=jQuery(this).attr('id');
	var maxLength = 300;
	var length = jQuery(this).val().length;
	var length = maxLength-length;
	jQuery('#'+id+'_chars').text(length);
});
/* Additional Note for Document Answers  */
var maxLength = 300;
jQuery('.addNoteMultiAns').each(function(){
	var id=jQuery(this).attr('id');
	var length = jQuery(this).val().length;
	var length = maxLength-length;
	jQuery('#'+id+'_chars').text(length);
});
jQuery(document).on('keyup','.addNoteMultiAns',function(){
	var id=jQuery(this).attr('id');
	var maxLength = 300;
	var length = jQuery(this).val().length;
	var length = maxLength-length;
	jQuery('#'+id+'_chars').text(length);
});
/* end */
jQuery(document).on('keyup','.addandTextarea',function(){
	var hyperlinkcolor = jQuery('.hidhyperlinkcolor').val();
	jQuery(this).css('border-color','#cccccc');
});

jQuery(document).on('click','.btn_next_pollcontent',function(){
	var parent=jQuery(this).data('main');
	var next_div = jQuery(this).data('next');
	var Qid = jQuery(this).data('questionid');
	if( Qid != undefined ){
		var is_required = jQuery('#frontquestionrequired'+Qid).val();
		if( is_required == 1 ){
			if( jQuery('.answer_div'+Qid).length > 0 ){
				var cntofansgiven = 0;
				jQuery('.answer_div'+Qid).each(function(){
					if( jQuery(this).hasClass('selected_answer') ){
						cntofansgiven +=1;
					}
				});
				if( cntofansgiven <= 0 ){
					jQuery('.answer_div'+Qid).css('border','1px solid red');
					return false;
				}
			}
			if( jQuery('.attachDocumentAnswer'+Qid).length > 0 ){
				var file = jQuery('.attachDocumentAnswer'+Qid).prop('files');
				if( file.length <= 0 ){
					jQuery('.attachDocumentAnswer'+Qid).parent().parent().css('border','1px solid red');
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
	var current_div = jQuery(this).data('current');
	jQuery('.'+parent+' .'+current_div).hide();
	jQuery('.'+parent+' .'+next_div).show();
});
jQuery(document).on('click','.btn_previous_pollcontent',function(){
	var parent=jQuery(this).data('main');
	var prev_div = jQuery(this).data('prev');
	var current_div = jQuery(this).data('current');
	jQuery('.'+parent+' .'+current_div).hide();
	jQuery('.'+parent+' .'+prev_div).show();
});
jQuery(document).on('click','.btn_restart_pollcontent',function(e){
	e.preventDefault();
	jQuery('.lp-screen').show();
	var parent=jQuery(this).data('main');
	var post_id = jQuery(this).data('poll_id');
	var course_id = jQuery('.course_id').val();
	var post_data = {
		'post_id': post_id,
		'course_id': course_id,
		'action' : 'LxRestatPoll'
	}
	jQuery.ajax({
		url: ajax_ob.ajax_url,
		type: 'POST',
		data: post_data,
		success: function(response){
			jQuery('.answer_div_content').removeClass('selected_answer');
			jQuery('.feedback_div_main').hide();
			jQuery('.text_answer').val('');
			jQuery('.conclusion_div').hide();
			jQuery('.question_div_main').hide();
			if(jQuery('.'+parent+' .pollcontent_div').children().hasClass('introduction_div')){
				jQuery('.'+parent+' .introduction_div').show();
			}else{
				jQuery('.'+parent+' .question_div1').show();
			}
			jQuery('.lp-screen').hide();
			
			jQuery('.addNoteDocAns').val('');
			jQuery('.addNoteDocAnsDiv ').hide();
			jQuery('.deleteDocumentAnswer').hide();
			jQuery('.addNoteMultiAnsDiv').hide(); 
			jQuery('.addNoteMultiAns').val(''); 
			jQuery('.attachDocName').html('No file chosen'); 
		}
	});
});

/*---------- Allow Answers Selection----------*/
jQuery(document).on('click','.answer_div_content',function(e){
	/* e.preventDefault(); */
	var que_divID = jQuery(this).data('questionid');
	var ans_divID = jQuery(this).data('aid');
	var allow_multiple = jQuery('#allow_multiple'+que_divID).val();
	var hyperlinkcolor = jQuery('.hidhyperlinkcolor').val();
	jQuery('.answer_div'+que_divID).css('border','1px solid '+hyperlinkcolor);
	/* start */
	var add_note=jQuery('#addNote_MultiAns'+que_divID).val();
	/* end */
	if( allow_multiple == 1 ){
		if( jQuery('.answer_div'+que_divID+ans_divID).hasClass('selected_answer') ){
			jQuery('.answer_div'+que_divID+ans_divID).removeClass('selected_answer');
			jQuery('.feedback_div'+que_divID+ans_divID).hide();
		}else{
			jQuery('.answer_div'+que_divID+ans_divID).addClass('selected_answer');
			jQuery('.feedback_div'+que_divID+ans_divID).show();
		}
	}else{
		jQuery('.answer_div'+que_divID).each(function(){
			if(jQuery(this).hasClass('selected_answer')){
				var sqID=jQuery(this).data('questionid');
				var sansID=jQuery(this).data('aid')
				jQuery(this).removeClass('selected_answer');
				jQuery('.feedback_div'+sqID+sansID).hide();
			}
		});
		jQuery('.answer_div'+que_divID+ans_divID).addClass('selected_answer');
		jQuery('.feedback_div'+que_divID+ans_divID).show();	
	} 
	/* start */
	if( jQuery('.answer_div_content').hasClass('selected_answer') && add_note==1 ){
		jQuery('.addNoteMultiAnsDiv'+que_divID).show();
	}else{
		jQuery('.addNoteMultiAnsDiv'+que_divID).hide(); 
	}
	/* end */
});  
jQuery(document).on('change','#send_copy_to_responder',function(){
	if(jQuery(this).is(':checked')){
		jQuery(this).val('1');
	}else{
		jQuery(this).val('0');
	}
});
/*--------------- Save Question Answers ---------------*/
jQuery(document).on('click','.btn_save_questions', function(e){
	e.preventDefault();
	var post_id = jQuery(this).data('poll_id');
	var current_div = jQuery(this).data('current');
	var que_id= jQuery('.'+current_div).data('questionid');
	var original_que_id = jQuery('.'+current_div+' .question_id').val();
	var allow_multiple = jQuery('#allow_multiple'+que_id).val();
	/* var txt_entry_val = jQuery('#text_entry_answer'+que_id).val(); */
	var txt_entry_val = jQuery('#answer_text'+que_id).val();
	/* start */
	var doc_answer = jQuery('.attach_document_s3path'+que_id).val();
	var question_type_val = jQuery('#question_type'+que_id).val();
	var add_note_val='';
	if( question_type_val == 1 ){
		add_note_val = jQuery('#addNoteMultiAns'+que_id).val();
	}else if( question_type_val == 3 ){
		add_note_val = jQuery('#addNoteDocAns'+que_id).val();
	}
	/* end */
	var multi_ans = []; 
	var ans_id = ''; 
	/* if( txt_entry_val == 0 ){
		if( allow_multiple == 1 ){
			ans_id = 0; 
			var multi_ans=[];
			jQuery('.question_div'+que_id+' .selected_answer').each(function(){
				multi_ans.push(jQuery(this).data('answerid')); 
			});
		}else {
			var ans_id = jQuery('.question_div'+que_id+' .selected_answer').data('answerid'); 
		}  
	}else{ 
		var ans_id = jQuery('.question_div'+que_id+' .text_answer').val();
	} */
	/* start */
	if( question_type_val == 1 ){
		if( allow_multiple == 1 ){
			ans_id = 0; 
			var multi_ans=[];
			jQuery('.question_div'+que_id+' .selected_answer').each(function(){
				multi_ans.push(jQuery(this).data('answerid')); 
			});
		}
	}
	if( question_type_val == 0 ){ 
		var ans_id = jQuery('.question_div'+que_id+' .selected_answer').data('answerid'); 
	}
	/* end */
	var post_data = {
		'post_id': post_id,
		'que_id' : original_que_id,
		'ans_id' : ans_id, 
		'is_text':txt_entry_val,
		'multi_ansid' : multi_ans,
		/* start */
		'doc_answer' : doc_answer, 
		'add_note' : add_note_val,
		/* end */
		'click':'next',
		'action' : 'PollCourseSaveUserResponse'
	}
	jQuery.ajax({
		url: ajax_ob.ajax_url,
		type: 'POST',
		data: post_data,
		success: function(response){
			console.log(response);
		}
	});
});

/*--------------- Submit PollCourse ---------------*/
jQuery(document).on('click','.btn_submit_pollcontent', function(e){
	e.preventDefault();
	jQuery('.lp-screen').show();
	var post_id = jQuery(this).data('poll_id');
	var send_email_to_user=jQuery('#send_copy_to_responder').val();
	var post_data = {
		'post_id': post_id,
		'send_user_copy':send_email_to_user,
		'click': 'submit',
		'action' : 'PollCourseSaveUserResponse'
	}
	jQuery.ajax({
		url: ajax_ob.ajax_url,
		type: 'POST',
		data: post_data,
		success: function(response){
			jQuery('.conclusion_div').hide();
			jQuery('.submit_prompt').show();
			jQuery('.lp-screen').hide();
		}
	});
});

/*------- Attach Document(DOC,DOCX,PDF), Size(Max 2MB) Answers For Poll ------*/
jQuery(document).on('change','.attachDocumentAnswer',function(){
	var course_id = jQuery('.course_id').val();
	var poll_id = jQuery('.poll_id').val();
	var question_id = jQuery(this).data('original_qid');
	var mainQid = jQuery(this).data('qid');
	jQuery('.attachDocumentAnswer'+mainQid).parent().parent().css('border','unset');
	var qid = jQuery(this).data('qid');
	var file_name = jQuery(this)[0].files[0].name;
	if( jQuery(this)[0].files[0].size > 2097152 ){
		jQuery('.alert_box').html('File too big should be less then 2 mb');
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('.alert_box').hide();
		},3000);
		return false;
	}
	var fileExtension = (jQuery(this)[0].files[0].name).replace(/^.*\./, '');
	if( fileExtension !== 'doc' && fileExtension !== 'docx' && fileExtension !== 'pdf'){
		jQuery('.alert_box').html('File should be DOC, DOCX, PDF');
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('.alert_box').hide();
		},3000);
		return false;
	}
	
	var fd = new FormData();
		fd.append('course_id',course_id);
		fd.append('poll_id',poll_id);
		fd.append('question_id',question_id);
		fd.append('file',jQuery(this)[0].files[0]);
		fd.append('action','FNPollDocumentUpload');
	
	jQuery.ajax({
		url: ajax_ob.ajax_url,
		type: 'POST',
		data: fd,
		contentType: false,
		processData: false, 
		success:function(response){
			var obj = jQuery.parseJSON(response);
			if( obj.status == '1' ){
				jQuery('.attachDocName'+qid).html(obj.filename);
				jQuery('.attach_document_s3path'+qid).val(obj.filepath);
				jQuery('.attach_document_name'+qid).val(obj.filename);
				jQuery('.addNoteDocAnsDiv'+qid).show();
				jQuery('.deleteDocumentAnswer'+qid).show();
			}else{
				jQuery('.addNoteDocAnsDiv'+qid).hide();
				jQuery('.deleteDocumentAnswer'+qid).hide();
			} 
		}
	});
});

/* Delete Document(DOC,DOCX,PDF), Size(Max 2MB) Answers For Poll */
jQuery(document).on('click','.deleteDocumentAnswer',function(){
	var course_id = jQuery('.course_id').val();
	var poll_id = jQuery('.poll_id').val();
	var question_id = jQuery(this).data('original_qid'); 
	var quesid = jQuery(this).data('quesid'); 
	var docname = jQuery('.attachDocName'+quesid).html();
	var post_data = {
		'course_id':course_id,
		'poll_id':poll_id,
		'question_id':question_id,
		'docname':docname,
		'action':'FNPollDocumentDelete'
	};
	jQuery.ajax({
		url: ajax_ob.ajax_url,
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			jQuery('.attachDocumentAnswer'+quesid).val('');
			jQuery('.attach_document_s3path'+quesid).val('');
			jQuery('.addNoteDocAns'+quesid).val('');
			jQuery('.addNoteDocAnsDiv'+quesid).hide();
			jQuery('.deleteDocumentAnswer'+quesid).hide();
			jQuery('.attachDocName'+quesid).html('No file chosen'); 
		}
	});
});