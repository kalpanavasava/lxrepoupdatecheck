jQuery(document).ready(function(){
	jQuery('.ld-breadcrumbs-segments').addClass('content_link');
	jQuery('.content_link a:first').addClass('top_course_title');
	jQuery('.content_link a:last').addClass('content_title');
	jQuery('.ld-course-step-back').text('Back');
	if(jQuery('.ld-focus-content .ld-content-action').length==3){
		jQuery('.ld-focus-content .ld-content-action:nth-child(3)').remove();
		jQuery('.ld-focus-content .ld-content-action:nth-child(1)').remove();
	}
	jQuery('<div class="btn_brc_home"><a href='+my_site_path.site_url+' style="color:#fff !important;">HOME</a></div>').insertBefore('.content_link span:first-child');
	var course_status = jQuery( "div.ld-status-progress" ).text();
	if( course_status=='In Progress' ){
		jQuery('.ld-status-progress').addClass('progress_status');
	}
	var height=parseInt(jQuery('.ld-focus-header').height())+parseInt(jQuery('.ld-lesson-status').height());
	if(jQuery(window).width() > 768){
		if(jQuery('body').children().hasClass('nojq')){
			height=height+parseInt(jQuery('.nojq').height());
		}
	}
	jQuery('.ld-focus-content iframe').css('height','calc(100vh - '+height+'px)');
});