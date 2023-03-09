jQuery(document).ready(function(){
	jQuery('.ld-breadcrumbs-segments').addClass('content_link');
	jQuery('.content_link a:first').addClass('top_course_title');
	jQuery('.content_link a:last').addClass('content_title');
	var course_status = jQuery( "div.ld-status-progress" ).text();
	if( course_status=='In Progress' ){
		jQuery('.ld-status-progress').addClass('progress_status');
	}
	jQuery('.lp-screen').show();
	var flip_id=jQuery('#hid_flip_id').val();
	var podcast_id=jQuery('.flip_content').data('podcast_id');
	var postdata={'flip_id':flip_id,'podcast_id':podcast_id,'action':'play_topic'};
	jQuery.ajax({
		url  : my_ajax.ajax_object,	
		type: 'POST',
		data: postdata,
		success:function(response){
			jQuery('.play_load_here').html(response);
			jQuery('.expander').trigger('click');
			jQuery('.audio_response_up').css('pointer-events','none');
			jQuery('.the-media > audio').attr('autoplay',true);
			/*jQuery(".con-playpause").trigger('click'); */
			jQuery('.the-name:not(:first)').each(function(){
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
					jQuery('.response_icon').insertAfter('.the-name');	
					jQuery('.response_icon .btn').each(function(){
						jQuery(this).attr('data-flip_parent_id',flip_id);
					});
				}
			}

			if(jQuery('.reply_count').data('count') > 0){
				jQuery('.menu-item-thumb').html('<span class="play_on_thumb"><i class="fa fa-play"></i></span>');
			}

		}
	});
});
