/* jQuery(document).on('click','.view_more_articulate',function(){
	var last_show = jQuery(this).data('last_show');
	var term_id=jQuery(this).data('term_id');
	var total=jQuery(this).data('total_content');
	jQuery('.more_btn_div').hide();
	var postdata = {'last_show':last_show,'term_id':term_id,'total_content':total,'action':'view_more_articulate_content'};
	jQuery.ajax({					
		url  : my_ajax_object.ajax_anchor,					
		type : 'POST',					
		data : postdata,					
		dataType : 'html',					
		success  : function(response) {
			jQuery('.more_btn_div').remove();
			jQuery('.show_more_content_'+term_id).append(response);
		}
	});
});
 */
 
jQuery(document).on('click','.turncontentwebhookon_pro',function(){
	var prop = jQuery(this).prop('checked');
	
	jQuery('.load_coursetoggleresonsepro').empty();
	jQuery('.load_coursedtatoggleresonsepro').empty();
	
	jQuery('.load_communitytoggleresonsepro').empty();
	
	if( prop == true ){
		var div = 'add';
		jQuery('.turncoursewebhookon_pro').prop('checked',false);
		jQuery('.turncoursewebhookon_pro').parent().find('.off').show();
		jQuery('.turncoursewebhookon_pro').parent().find('.on').hide();
		
		jQuery('.turncommunitywebhookon_pro').prop('checked',false);
		jQuery('.turncommunitywebhookon_pro').parent().find('.off').show();
		jQuery('.turncommunitywebhookon_pro').parent().find('.on').hide();
	}
	if( prop == false ){
		var div = 'remove';
		jQuery('.load_contenttoggleresonsepro').empty();
		jQuery('.load_contentdtatoggleresonsepro').empty();
	}
	
	var postdata = {'div':div,'action':'AjaxFNcheckboxloadContentPro'};
	jQuery.ajax({					
		url  : my_ajax_object.ajax_anchor,					
		type : 'POST',					
		data : postdata,					
		dataType : 'html',					
		success  : function(response) {
			jQuery('.load_contenttoggleresonsepro').html(response);
		}
	});
	
});

jQuery(document).on('click','.turncoursewebhookon_pro',function(){
	var prop = jQuery(this).prop('checked');
	jQuery('.load_communitytoggleresonsepro').empty();
	
	jQuery('.load_contenttoggleresonsepro').empty();
	jQuery('.load_contentdtatoggleresonsepro').empty();
	
	if( prop == true ){
		var div = 'add';
		jQuery('.turncommunitywebhookon_pro').prop('checked',false);
		jQuery('.turncommunitywebhookon_pro').parent().find('.off').show();
		jQuery('.turncommunitywebhookon_pro').parent().find('.on').hide();
		
		jQuery('.turncontentwebhookon_pro').prop('checked',false);
		jQuery('.turncontentwebhookon_pro').parent().find('.off').show();
		jQuery('.turncontentwebhookon_pro').parent().find('.on').hide();
	}
	if( prop == false ){
		var div = 'remove';
		jQuery('.load_coursetoggleresonsepro').empty();
		jQuery('.load_coursedtatoggleresonsepro').empty();
	}
	
	var postdata = {'div':div,'action':'AjaxFNcheckboxloadCoursePro'};
	jQuery.ajax({					
		url  : my_ajax_object.ajax_anchor,					
		type : 'POST',					
		data : postdata,					
		dataType : 'html',					
		success  : function(response) {
			jQuery('.load_coursetoggleresonsepro').html(response);
		}
	});
	
});

jQuery(document).on('click','.turncommunitywebhookon_pro',function(){
	var prop = jQuery(this).prop('checked');
	
	jQuery('.load_coursetoggleresonsepro').empty();
	jQuery('.load_coursedtatoggleresonsepro').empty();
	
	jQuery('.load_contenttoggleresonsepro').empty();
	jQuery('.load_contentdtatoggleresonsepro').empty();
		
	if( prop == true ){
		var div = 'add';
		jQuery('.turncoursewebhookon_pro').prop('checked',false);
		jQuery('.turncoursewebhookon_pro').parent().find('.off').show();
		jQuery('.turncoursewebhookon_pro').parent().find('.on').hide();
		
		jQuery('.turncontentwebhookon_pro').prop('checked',false);
		jQuery('.turncontentwebhookon_pro').parent().find('.off').show();
		jQuery('.turncontentwebhookon_pro').parent().find('.on').hide();
		
	}
	if( prop == false ){
		var div = 'remove';
		jQuery('.load_communitytoggleresonsepro').empty();
	}
	
	var postdata = {'div':div,'action':'AjaxFNcheckboxloadCommunityPro'};
	jQuery.ajax({					
		url  : my_ajax_object.ajax_anchor,					
		type : 'POST',					
		data : postdata,					
		dataType : 'html',					
		success  : function(response) {
			jQuery('.load_communitytoggleresonsepro').html(response);
		}
	});
	/* alert(jQuery(this).prop('checked')); */
});

jQuery(document).on('change','.crmccoursecommselpro',function(){
	var communityid = jQuery(this).val();
	if( communityid == 0 ){
		jQuery('.load_coursedtatoggleresonsepro').empty();
		return false;
	}
	var postdata = {'communityid':communityid,'action':'AjaxFNloadcoursedataPro'};
	jQuery.ajax({					
		url  : my_ajax_object.ajax_anchor,					
		type : 'POST',					
		data : postdata,					
		dataType : 'html',					
		success  : function(response) {
			jQuery('.load_coursedtatoggleresonsepro').html(response);
		}
	});
});

jQuery(document).on('change','.crmconcommselpro',function(){
	var communityid = jQuery(this).val();
	var postdata = {'communityid':communityid,'action':'AjaxFNloadConcoursedataPro'};
	jQuery.ajax({					
		url  : my_ajax_object.ajax_anchor,					
		type : 'POST',					
		data : postdata,					
		dataType : 'html',					
		success  : function(response) {
			jQuery('.crmconcourseselprodiv').html(response);
		}
	});
});

/* jQuery(document).on('change','.crmconcourseselpro',function(){
	
});
 */
jQuery(document).on('change','.crmconcourseselpro',function(){
	var courseid = jQuery(this).val();
	var postdata = {'courseid':courseid,'action':'AjaxFNloadcontentdataPro'};
	jQuery.ajax({					
		url  : my_ajax_object.ajax_anchor,					
		type : 'POST',					
		data : postdata,					
		dataType : 'html',					
		success  : function(response) {
			jQuery('.load_contentdtatoggleresonsepro').html(response);
		}
	});
});

jQuery(document).on('click','.commjoinedcheck',function(){
	var prop = jQuery(this).prop('checked');
	var type = jQuery(this).data('type');
	var commid = jQuery(this).data('id');
	
	if( prop == true ){
		var div = 'add';
	}
	if( prop == false ){
		var div = 'removed';
	}
	var postdata = {'type':type,'div':div,'commid':commid,'action':'AjaxFNSaveCommunityjoineddatapro'};
	jQuery.ajax({					
		url  : my_ajax_object.ajax_anchor,					
		type : 'POST',					
		data : postdata,					
		dataType : 'html',					
		success  : function(response) {
		}
	});
});
jQuery(document).on('click','.commremovedcheck',function(){
	var prop = jQuery(this).prop('checked');
	var type = jQuery(this).data('type');
	var commid = jQuery(this).data('id');
	
	if( prop == true ){
		var div = 'add';
	}
	if( prop == false ){
		var div = 'removed';
	}
	var postdata = {'type':type,'div':div,'commid':commid,'action':'AjaxFNSaveCommunityremoveddatapro'};
	jQuery.ajax({					
		url  : my_ajax_object.ajax_anchor,					
		type : 'POST',					
		data : postdata,					
		dataType : 'html',					
		success  : function(response) {
		}
	});
});