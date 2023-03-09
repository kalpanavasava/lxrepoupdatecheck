jQuery(document).on('click','.show_more_courses_btn',function(){
	var last_show = jQuery(this).data('last_show');
	var display = jQuery(this).data('display');
	var total_courses = jQuery(this).data('total_courses');
	jQuery('.'+display+' .spinner_forum').show();
	jQuery(this).hide();
	var postdata = {
		'last_show':last_show,
		'display':display,
		'total_courses':total_courses,
		action:'ShowMoreCourses'
	};
	jQuery.ajax({					
		url  : ajax_object.ajax_url, 					
		type : 'POST',					
		data : postdata,					
		dataType : 'html',					
		success  : function(response) {
			jQuery('.'+display+' .spinner_forum').hide();
			jQuery('.'+display).append(response);
		}
	});
});

