/* window.addEventListener('load', pageAccessed, false);

function pageAccessed() {
	var activity_id = jQuery('#activity_id').val();
	var user_email = jQuery('#mailto').val();
	var verb = "http://adlnet.gov/expapi/verbs/passed";
	
}
jQuery(document).ready(function(){
	var lession_id_arr = [];var activity_id_arr = [];
	jQuery('.lx_allesson_id').each(function(){
		var lession_id = jQuery(this).val();
		var activity_id = jQuery('#lx_alactivity_id_'+lession_id).val();
		lession_id_arr.push(lession_id);
		activity_id_arr.push(activity_id);
	});
	sendStatement(lession_id_arr, activity_id_arr);
});
function sendStatement(lession_id_arr, activity_id_arr){
	var verb = "http://adlnet.gov/expapi/verbs/passed";
	var user_email = jQuery('#mailto').val();
	var completedStmts = LRSDataGet();
	
	var i;var count = [];var lession_id_arr_in = [];var completedtime = [];
	for( var j=0; j< (lession_id_arr).length; j++ ){
		var activity_id = activity_id_arr[j];
		
		for( i = 0 ; i < (completedStmts.statements).length; i++){
			
			if( completedStmts.statements[i].object.id == activity_id && completedStmts.statements[i].actor.mbox == 'mailto:'+decodeURIComponent(user_email)){
				count.push(completedStmts.statements[i]);
				lession_id_arr_in.push(lession_id_arr[j]);
				completedtime.push( completedStmts.statements[i].stored );
			}
		}
	}
	if( count.length > 0 ){
		var passed_results = count;
		if(jQuery('#lesson_status').val()!='completed')
		{
			jQuery('.lp-screen').show();
			var open_in=jQuery('#open_in').val();
			var post_data={'lesson_id':lession_id_arr_in,course_id:jQuery('#vw_course_id').val(),'completedtime':completedtime,'action':'add_lesson_completion2'};
			jQuery.ajax({
				url:my_ajax_object.ajax_anchor,
				type: 'POST',
				data: post_data,
				success:function(response){
					var lession_ar = jQuery.parseJSON(response).lession_id;
					for(var k =0; k<(lession_ar).length;k++){
						var color = jQuery.parseJSON(response).color_completed;
						jQuery('.content_list_item_'+lession_ar[k]).css('border-left','4px solid '+color);
					}
					jQuery('.course_percent').html(jQuery.parseJSON(response).completion_status+"% COMPLETE");
					jQuery('.lx-progress-bar-percentage').css('width',jQuery.parseJSON(response).completion_status+'%');
					jQuery('.lp-screen').hide();
				}
			});
		}
	}
		
}   */