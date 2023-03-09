/* for set lesson status complete  */

var vw_lesson = {
	mark_complete_manually: function(e){
		jQuery(e).html('Mark as complete <i class="fa fa-spinner fa-spin"></i>');
		var lession_id = jQuery('.vw_lesson_id').val();
		var post_data = {'lession_id':lession_id,action:'vw_fn_ajax_lesson_mark_ascomplete'};
		jQuery.ajax({
				url  : my_ajax_object.ajax_anchor,	
				type: 'POST',
				data: post_data,
				dataType: 'html',						
				success  : function(response) {
					jQuery('.lp-screen').hide();
					jQuery(e).html(response+' <i class="fa fa-check"></i>');
					jQuery(e).attr('disabled','disabled');
					location.reload();
				}
		});
	}
}

/* for make view lession ifarme responsive   */
jQuery(document).ready(function(){
	var height=parseInt(jQuery('.lx_lesson_view .main_header').height())+parseInt(jQuery('.lx_lesson_view #navbar-wrapper').height());
	if(jQuery('body').children().hasClass('nojq')){
		height=height+parseInt(jQuery('.nojq').height());
	}
	jQuery('.lesson_content').css('height','calc(100vh - '+height+'px)');
	/* jQuery('.lesson_content iframe').css('height','calc(100vh - '+height+'px)'); */
	jQuery('.lesson_content object').css('height','calc(100vh - '+height+'px)');
});
/******For open poll modal******/
jQuery(document).on('click','.btn_poll',function(){
	var lesson_id = jQuery(this).data('pid');
	var post_data = {'lesson_id':lesson_id,action:'vw_fn_loadpollmodal'};
	jQuery.ajax({
			url  : my_ajax_object.ajax_anchor,	
			type: 'POST',
			data: post_data,
			dataType: 'html',						
			success  : function(response) {
				
			}
	});
	jQuery('#poll_modal').modal();
});