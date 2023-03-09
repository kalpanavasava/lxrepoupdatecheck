jQuery(document).on('change','.salesforceenv',function(){
	var color_green = jQuery('.color_green').val();
	if( jQuery(this).is(":checked") == true ){
		jQuery('.staging_input').find('input').css({'color':color_green,'border-color':color_green});
		jQuery('.prod_input').find('input').css({'color':'unset','border-color':'unset'});
		jQuery('.btn_staging_test').removeAttr('disabled');
		jQuery('.btn_prod_test').attr('disabled','disabled');
		jQuery('.btn_staging_test').removeClass('btn_dark_state');
		jQuery('.btn_staging_test').addClass('btn_normal_state');
		jQuery('.btn_prod_test').removeClass('btn_normal_state');
		jQuery('.btn_prod_test').addClass('btn_dark_state');
		jQuery('.staging_status').html('Active');
		jQuery('.prod_status').html('Inactive');
	}else{
		jQuery('.staging_input').find('input').css({'color':'unset','border-color':'unset'});
		jQuery('.prod_input').find('input').css({'color':color_green,'border-color':color_green});
		jQuery('.btn_prod_test').removeAttr('disabled');
		jQuery('.btn_staging_test').attr('disabled','disabled');
		jQuery('.btn_staging_test').removeClass('btn_normal_state');
		jQuery('.btn_staging_test').addClass('btn_dark_state');
		jQuery('.btn_prod_test').removeClass('btn_dark_state');
		jQuery('.btn_prod_test').addClass('btn_normal_state');
		jQuery('.staging_status').html('Inactive');
		jQuery('.prod_status').html('Active');
	}
	/* alert(); */
});

jQuery(document).on('click','.save_salesforce_data',function(){
	jQuery('.lp-screen').show();
	var stg_endpoint = jQuery('#bkstgendpoint').val();
	var stg_consumerkey = jQuery('#bkstgconsumerkey').val();
	var stg_consumersecret = jQuery('#bkstgconsumersec').val();
	var stg_username = jQuery('#bkstgusername').val();
	var stg_password = jQuery('#bkstgpassword').val();
	
	var prod_endpoint = jQuery('#bkliveendpoint').val();
	var prod_consumerkey = jQuery('#bkliveconsumerkey').val();
	var prod_consumersecret = jQuery('#bkliveconsumersec').val();
	var prod_username = jQuery('#bkliveusername').val();
	var prod_password = jQuery('#bklivepassword').val();
	
	var environment = jQuery('.salesforceenv').is(':checked');
	var env = 'production';
	if( environment == true ){
		env = 'staging';
	}
	/* 
	alert(environment);
	return false; */
	var post_data = {'env':env,'stg_endpoint':stg_endpoint,'stg_consumerkey':stg_consumerkey,'stg_consumersecret':stg_consumersecret,'stg_username':stg_username,'stg_password':stg_password,'prod_endpoint':prod_endpoint,'prod_consumerkey':prod_consumerkey,'prod_consumersecret':prod_consumersecret,'prod_username':prod_username,'prod_password':prod_password,'action':'CRMAPIAjaxFnSavesalesforceEvn'};
	jQuery.ajax({
		url  : lx_lms_js.ajaxurl,
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			jQuery('.lp-screen').hide();
		}
	});
});

jQuery(document).on('click','.btn_prod_test,.btn_staging_test',function(){
	jQuery('.lp-screen').show();
	var env = jQuery(this).data('env');
	if( env == 'prod' ){
		var prod_endpoint = jQuery('#bkliveendpoint').val();
		var prod_consumerkey = jQuery('#bkliveconsumerkey').val();
		var prod_consumersecret = jQuery('#bkliveconsumersec').val();
		var prod_username = jQuery('#bkliveusername').val();
		var prod_password = jQuery('#bklivepassword').val();
		var post_data = {'prod_endpoint':prod_endpoint,'prod_consumerkey':prod_consumerkey,'prod_consumersecret':prod_consumersecret,'prod_username':prod_username,'prod_password':prod_password,'action':'CRMAPIAjaxFntestauth'};
	}
	if( env == 'staging' ){
		var stg_endpoint = jQuery('#bkstgendpoint').val();
		var stg_consumerkey = jQuery('#bkstgconsumerkey').val();
		var stg_consumersecret = jQuery('#bkstgconsumersec').val();
		var stg_username = jQuery('#bkstgusername').val();
		var stg_password = jQuery('#bkstgpassword').val();
		var post_data = {'stg_endpoint':stg_endpoint,'stg_consumerkey':stg_consumerkey,'stg_consumersecret':stg_consumersecret,'stg_username':stg_username,'stg_password':stg_password,'action':'CRMAPIAjaxFntestauth'};
	}
	
	jQuery.ajax({
		url  : lx_lms_js.ajaxurl,
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			var classes = '';
			if( env == 'prod' ){
				classes = 'stg_prodprompt';
			}
			if( env == 'staging' ){
				classes = 'stg_testprompt';
			}
			if(jQuery.trim(response) == 'auth_failed'){
				jQuery('.'+classes).show();
				jQuery('.'+classes).html('Authentication failed.');
				jQuery('.'+classes).css('color','red');
			}else if(jQuery.trim(response) == 'nlead'){
				jQuery('.'+classes).show();
				jQuery('.'+classes).html('Authentication passed. Failed Test.');
				jQuery('.'+classes).css('color','red');
			}else{
				jQuery('.'+classes).show();
				jQuery('.'+classes).html('Payload sent');
				jQuery('.'+classes).css('color','green');
			}
			jQuery('.lp-screen').hide();
		}
	});
});

jQuery(document).on('click','.bkcreatenewapikey',function(){
	jQuery('.lp-screen').show();
	var post_data = {'action':'CRMAPIAjaxFnShomodal'};
	jQuery.ajax({
		url  : lx_lms_js.ajaxurl,
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			jQuery('.modal_body_cusapi').html(response);
			jQuery('#bkcreatnewcusapiauthmodal').modal('show');
			jQuery('.lp-screen').hide();
		}
	});
});

jQuery(document).on('click','.bkbtncreatenewauth',function(){
	var roleid = jQuery('.bktechrole').val();
	if( roleid == 0 ){
		jQuery('.usernotselected_prompt').html('Please select user');
		return false;
	}
	
	jQuery('.lp-screen').show();
	/* alert( roleid ); */
	var post_data = {'roleid':roleid,'action':'CRMAPIAjaxFnGtRolewiseApi'};
	jQuery.ajax({
		url  : lx_lms_js.ajaxurl,
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			jQuery('.bktablebody').append(response);
			jQuery('.lp-screen').hide();
			jQuery('#bkcreatnewcusapiauthmodal').modal('hide');
		}
	});
});

jQuery(document).on('click','.bkcusapideletebtn',function(){
	jQuery('#bkdeleteauthmodal').modal('show');
	var techid = jQuery(this).data('id');
	jQuery('.bkcusapideletebtnper').attr('data-id',techid);
});
jQuery(document).on('click','.bkcusapideletebtnper',function(){
	jQuery('.lp-screen').show();
	var techid = jQuery(this).data('id');
	var post_data = {'techid':techid,'action':'CRMAPIAjaxFnDelete'};
	jQuery.ajax({
		url  : lx_lms_js.ajaxurl,
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			/* jQuery('.bktablebody').append(response); */
			jQuery('.bkapitable_row'+techid).remove();
			jQuery('.lp-screen').hide();
			jQuery('#bkdeleteauthmodal').modal('hide');
		}
	});
});

/** copy client key **/
jQuery(document).on('click','.btncpyclientkey',function(){
	var id = jQuery(this).data('id');
	 var text = jQuery('.bkclientidcusapihid'+id).val();
	var listener = function(ev) {
	 ev.clipboardData.setData("text/plain", text);
	 ev.preventDefault();
    };
	document.addEventListener("copy", listener);
    document.execCommand("copy");
    document.removeEventListener("copy", listener);
	jQuery('.keycopied'+id).show();
	setTimeout(function() {
		jQuery('.keycopied'+id).hide()
	 }, 2000);
});

/** copy client sec **/
jQuery(document).on('click','.btncpyclientsec',function(){
	var id = jQuery(this).data('id');
	 var text = jQuery('.bkclientseccusapihid'+id).val();
	var listener = function(ev) {
	 ev.clipboardData.setData("text/plain", text);
	 ev.preventDefault();
    };
	document.addEventListener("copy", listener);
    document.execCommand("copy");
    document.removeEventListener("copy", listener);
	jQuery('.seccopied'+id).show();
	setTimeout(function() {
		jQuery('.seccopied'+id).hide()
	 }, 2000);
});