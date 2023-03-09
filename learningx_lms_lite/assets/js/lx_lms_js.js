jQuery(document).ready(function(){ 
      jQuery('.user_interface #blue_color,.user_interface #green_color,.user_interface #orange_color,.user_interface #red_color,.user_interface #purple_color,.user_interface #black_color,.user_interface #charcoal_color,.user_interface #white_color,.user_interface #grey_color,.user_interface #light_grey_color,.user_interface #mid_grey_color,.user_interface #custom1_color,.user_interface #custom2_color,.user_interface #custom3_color,.user_interface #custom4_color').change(function(){ 
			var changed = jQuery(this).data('change');
			jQuery(changed).val(jQuery(this).val());
       }); 
});
jQuery(document).ready(function(){ 
      jQuery('.user_interface #txt_blue,.user_interface #txt_green,.user_interface #txt_orange,.user_interface #txt_red,.user_interface #txt_purple,.user_interface #txt_black,.user_interface #txt_charcoal,.user_interface #txt_white,.user_interface #txt_grey,.user_interface #txt_light_grey,.user_interface #txt_mid_grey,.user_interface #txt_custom1,.user_interface #txt_custom2,.user_interface #txt_custom3,.user_interface #txt_custom4').change(function(){ 
			var changed = jQuery(this).data('change');
			jQuery(changed).val(jQuery(this).val());
       }); 
		  jQuery('.lx_toggle').each(function(){
				if(jQuery(this).find('input[type=checkbox]').is(':checked')){
					jQuery(this).find('.off').hide();
					jQuery(this).find('.on').show();
				}
			});
});
jQuery(document).on('click','.lx_toggle',function(){
	if(jQuery(this).find('input[type=checkbox]').is(':checked')){
		jQuery(this).find('.off').hide();
		jQuery(this).find('.on').show();
	}else{
		jQuery(this).find('.on').hide();
		jQuery(this).find('.off').show();	
	}
});
/* submit event for user interface settings */
jQuery(document).on('submit','#user_interface_settings',function(e){
	e.preventDefault();
	jQuery('.lp-screen').show();
	var fd=new FormData(this);
	fd.append('action','fn_lx_lms_user_interface');
	var ajax_path = vw_user_interface_path.ajaxurl;
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: fd,
		dataType: 'html',
		contentType: false,
		processData: false,			
		success  : function(response) {
			jQuery('.lp-screen').hide();
		}
	});
});

/* submit event for  general settings form */
jQuery(document).on('submit','#general_settings_form',function(e){
	e.preventDefault();
	jQuery('.lp-screen').show();
	var fd=new FormData(this);
	fd.append('action','fn_general_site_settings');
	var ajax_path = vw_user_interface_path.ajaxurl;
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: fd,
		dataType: 'html',
		contentType: false,
		processData: false,			
		success  : function(response) {
			jQuery('.lp-screen').hide();
		}
	});
});

/* click evebt for base64 encode toggle */
jQuery(document).on('click','.base64_encode_toggle',function(e){
  var checkBox = document.getElementById("base64_encode_toggle");
  if (checkBox.checked == true){
    jQuery('.base64_encode_selection').show();
  } else {
	jQuery('.base64_encode_selection').removeClass('base64_encode_selection1');
	jQuery('.custom_post_selection').removeClass('custom_post_selection1');
	jQuery("#base64_encode_memberships,#base64_encode_course,#base64_encode_custom_modules,#base64_encode_post,#base64_encode_page,#base64_encode_custom_post_info").prop('checked', false);
	jQuery('input.base64_encode_custom_post').each(function(){ 
       
       jQuery('.base64_encode_custom_post').prop('checked', false);
     
   });
    jQuery('.base64_encode_selection').hide();
    jQuery('.custom_post_selection').hide();
  }
});

/* click evebt for base64 encode custom post type */
jQuery(document).on('click','.base64_encode_custom_post_info',function(e){
  var checkBox = document.getElementById("base64_encode_custom_post_info");
  if (checkBox.checked == true){
    jQuery('.custom_post_selection').show();
  } else {
	jQuery('input.base64_encode_custom_post').each(function(){ 
       
       jQuery('.base64_encode_custom_post').prop('checked', false);
     
   });
    jQuery('.custom_post_selection').hide();
  }
});

/* function for open tab  */
function opentab(evt, tabevent, class_info) {
	var i, tabcontent, tablinks;
	jQuery('.user_interface').find('.tab_bottom').removeClass('tab_bottom');
	if(class_info=='ui_apis_setting_info'){
		jQuery('.btn_save_user_settings').hide();
	}else{
		jQuery('.btn_save_user_settings').show();
	}
	jQuery('.'+ class_info).addClass('tab_bottom');
	jQuery('.'+ class_info).children().css('color' , "#000000");
	tabcontent = document.getElementsByClassName("tabcontent");
	for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}
	tablinks = document.getElementsByClassName("tablinks");
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	}
	document.getElementById(tabevent).style.display = "block";
	evt.currentTarget.className += " active";

}

/* click event delete logo thumbnail */
jQuery(document).on('click','.delete_logo_thumbnail',function(e){
	e.preventDefault();
	
	var r = confirm("Are you sure you want to delete the  logo!");
	if (r == true) {
		jQuery('.lp-screen').show();
		var ajax_path = vw_user_interface_path.ajaxurl;
		var post_data = {action:'fn_delete_logo_thumb'};
		jQuery.ajax({					
					url  : ajax_path,	
					type: 'POST',
					data: post_data,
					dataType: 'html',						
					success  : function(response) {
						jQuery('.crop_img_logo_main_div').html(response);
						jQuery('.lp-screen').hide();
					}
			});
	} 
});

/* click event delete logo favicon */
jQuery(document).on('click','.delete_logo_favicon',function(e){
	e.preventDefault();
	var r = confirm("Are you sure you want to delete the favicon!");
	if (r == true) {
		jQuery('.lp-screen').show();
		var ajax_path = vw_user_interface_path.ajaxurl;
		var post_data = {action:'fn_delete_logo_favicon'};
		jQuery.ajax({					
					url  : ajax_path,	
					type: 'POST',
					data: post_data,
					dataType: 'html',						
					success  : function(response) {
						jQuery('.crop_img_logo_favicon_div').html(response);
						jQuery('.lp-screen').hide();
					}
			});
	} 
});	

/* submit event lexicon settings */
jQuery(document).on('submit','#lx_lms_lexicon_settings',function(e){
	e.preventDefault();
	jQuery('.lp-screen').show();
	var fd=new FormData(this);
	fd.append('action','fn_lx_lms_lexicon_setting');
	var ajax_path = vw_user_interface_path.ajaxurl;
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: fd,
		dataType: 'html',
		contentType: false,
		processData: false,			
		success  : function(response) {
			jQuery('.lp-screen').hide();
		}
	});
});

/* submit event for store layout template settings */
jQuery(document).on('submit','#layout_template_settings',function(e){
	e.preventDefault();
	jQuery('.lp-screen').show();
	var fd=new FormData(this);
	fd.append('action','fn_lx_lms_layout_template_setting');
	var ajax_path = vw_user_interface_path.ajaxurl;
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: fd,
		dataType: 'html',
		contentType: false,
		processData: false,			
		success  : function(response) {
			jQuery('.lp-screen').hide();
		}
	});
});
/* click event for user activation */
jQuery(document).on('click','.u_status_activation',function(){
	var user_id=jQuery(this).data('uid');
	data={'user_id':user_id,'action':'user_status_activation'}
	var ajax_path = vw_user_interface_path.ajaxurl;
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: data,
		dataType: 'html',
		success  : function(response) {
			location.reload();
		}
	});
});
/* submit event for user activation */
jQuery(document).on('submit','#lrs_settings_form',function(e){
	e.preventDefault();
	var fd=new FormData(this);
	fd.append('action','save_lrs_data');
	var ajax_path = vw_user_interface_path.ajaxurl;
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: fd,
		dataType: 'html',
		contentType: false,
		processData: false,	
		success  : function(response) {
			
		}
	});
});

jQuery(document).on('click','#btn_reset',function(){
	  var all_cls=jQuery(this).attr('class');
	  var cls=all_cls.split(' ')[1];
	  jQuery('#'+cls).val('');
});

/* upload certificate */
jQuery(document).on('change','#upload_certificates_template', function (e) { 
	e.preventDefault();
	var files = e.target.files;
    filename=files[0].name;
    var ext = filename.split('.').pop().toLowerCase();
	if(jQuery.inArray(ext, ['jpg','jpeg']) == -1) {
		jQuery('.backend_alert_box').html('File must be jpg/jpeg format.');
		jQuery('.backend_alert_box').show();
		setTimeout(function(){
			jQuery('.backend_alert_box').hide();
		},3000);
		return false;
	}
	var ajax_path = vw_user_interface_path.ajaxurl;
	var fd=new FormData();
	fd.append('upload_certificates_template',jQuery('#upload_certificates_template')[0].files[0]);
	fd.append('action','certificate_template_upload');
	jQuery('.lp-screen').show();
	jQuery.ajax({					
		url  : ajax_path,	
		type: 'POST',
		data: fd,
		dataType: 'html',
		processData: false,
        contentType: false, 
		success  : function(response) {
			var res = jQuery.parseJSON(response);
			jQuery('.upload-certificates-file-input .lbl_selection_info').html(res.file_name);
			jQuery('.current_template').html(res.file_name);
			jQuery('.delete_certificate_template').css('z-index','99');
			jQuery('.download_certificate_template').addClass('btn_normal_state');
			jQuery('.download_certificate_template').removeClass('btn_disabled_state');
			jQuery('.download_certificate_template').attr('href',res.upload_thumb['original']);
			jQuery('.lp-screen').hide();
		}
	});
});

/* click event for user activation */
jQuery(document).on('click','.delete_certificate_template',function(e){
	e.preventDefault();
	var community_id = jQuery(this).data('id');
	jQuery('.backend_alert_box').addClass('alert_box_del_popup');
	jQuery('.backend_alert_box').html('<div>Are you sure you want to delete the certificate template!</div><div class="delete_popup_btn_main_class"><button class="btn_normal_state btn_delete_popup_yes" data-dismiss="modal" aria-label="Close" data-del_info="remove_cerfificate_template">Yes</button><button class="btn_dark_state btn_delete_popup_cancel" data-dismiss="modal" aria-label="Close">Cancel</button></div>');
	jQuery('.backend_alert_box').show();
	$alert = jQuery('.backend_alert_box');
	$alert.modal({backdrop:'static', keyboard:false});
});

/* click event for delete popup yes */
jQuery(document).on('click','.btn_delete_popup_yes',function(e){
	e.preventDefault();
	jQuery('.lp-screen').show();
	var post_data = {action:'delete_certificate_template'};
	var ajax_path = vw_user_interface_path.ajaxurl;
	jQuery.ajax({					
		url  : ajax_path,	
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			jQuery('.upload-certificates-file-input .lbl_selection_info').html('No file selected');
			jQuery('.current_template').html('None');
			jQuery('.upload-certificates-file-input .delete_certificate_template').css('z-index','0');
			jQuery('.download_certificate_template').removeClass('btn_normal_state');
			jQuery('.download_certificate_template').addClass('btn_disabled_state');
			jQuery('.download_certificate_template').removeAttr('href');
			jQuery('.lp-screen').hide();
		}
	});
});

/* change event for currency settings */
jQuery(document).on('change','.currency_settings',function(e){
	e.preventDefault();
	var currency_settings = jQuery(this).val();
	if(currency_settings != 0){
		var currency_symbol = jQuery(this).find(':selected').data('currency_symbol');
		jQuery('.display_currency_info').html(currency_settings+''+currency_symbol+'101');
		jQuery('.display_currency_data').css('display','block');
		jQuery('.currency_symbol').val(currency_symbol);
	} else if(currency_settings == 0){
		jQuery('.display_currency_info').html('');
		jQuery('.display_currency_data').css('display','none');
		jQuery('.currency_symbol').val("");
	}
});

/* submit event for lrs settings form */
jQuery(document).on('submit','#lrs_settings_form',function(e){
	e.preventDefault();
	var fd=new FormData(this);
	fd.append('action','save_lrs_data');
	var ajax_path = vw_user_interface_path.ajaxurl;
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: fd,
		dataType: 'html',
		contentType: false,
		processData: false,	
		success  : function(response) {
			
		}
	});
});

/* submit event for s3 settings form */
jQuery(document).on('submit','#s3_settings_form',function(e){
	e.preventDefault();
	jQuery('.lp-screen').show();
	var fd=new FormData(this);
	fd.append('action','save_s3_settings_data');
	var ajax_path = vw_user_interface_path.ajaxurl;
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: fd,
		dataType: 'html',
		contentType: false,
		processData: false,	
		success  : function(response) {
			jQuery('.lp-screen').hide();
		}
	});
});

/* submit event for currency settings */
jQuery(document).on('submit','#lrs_settings_form',function(e){
	e.preventDefault();
	jQuery('.lp-screen').show();
	var fd=new FormData(this);
	fd.append('action','save_lrs_data');
	var ajax_path = vw_user_interface_path.ajaxurl;
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: fd,
		dataType: 'html',
		contentType: false,
		processData: false,	
		success  : function(response) {
			jQuery('.lp-screen').hide();
		}
	});
});

/* click event for s3 production and staging test */
jQuery(document).on('click','.s3_production_test,.s3_staging_test',function(e){
	e.preventDefault();
	var clicked=jQuery(this).data('click');
	if(clicked=='p'){
		jQuery('.pv_spinner').show();
		var data={'bucket':jQuery('#pv_bucket').val(),'key':jQuery('#pv_key').val(),'access':jQuery('#pv_access').val(),'region':jQuery('#s3_region').val(),'action':'test_s3_connection'}
	}else{
		jQuery('.sv_spinner').show();
		var data={'bucket':jQuery('#sv_bucket').val(),'key':jQuery('#sv_key').val(),'access':jQuery('#sv_access').val(),'action':'test_s3_connection'}
	}
	var ajax_path = vw_user_interface_path.ajaxurl;
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: data,
		dataType: 'html',
		success  : function(response) {
			res=jQuery.parseJSON(response);
			if(clicked=='p'){
				jQuery('.pv_spinner').hide();
				jQuery('.pv_s3_msg').html(res.msg);
				jQuery('.pv_s3_msg').css('color',res.color);
			}else{
				jQuery('.sv_spinner').hide();
				jQuery('.sv_s3_msg').html(res.msg);
				jQuery('.sv_s3_msg').css('color',res.color);
			}
			setTimeout(function(){
				jQuery('.pv_s3_msg').html('');
				jQuery('.sv_s3_msg').html('');
			},5000);
		}
	});
});

/* click event for lrs production and staging test */
jQuery(document).on('click','.pv_lrs_test,.sv_lrs_test',function(e){
	e.preventDefault();
	var clicked=jQuery(this).data('click');
	if(clicked=='p'){
		jQuery('.pv_lrs_spinner').show();
		var basic_auth="Basic " + toBase64(jQuery('#pv_auth_key').val()+":"+jQuery('#pv_auth_secret').val());
		var data={'end_point':jQuery('#pv_end_point').val(),'basic_auth':basic_auth,'bauth':jQuery('#pv_basic_auth').val(),'action':'lrs_test_connection'};
	}else{
		jQuery('.sv_lrs_spinner').show();
		var basic_auth="Basic " + toBase64(jQuery('#svv_auth_key').val()+":"+jQuery('#sv_auth_secret').val());
		var data={'end_point':jQuery('#sv_end_point').val(),'basic_auth':basic_auth,'bauth':jQuery('#sv_basic_auth').val(),'action':'lrs_test_connection'};
	}
	var ajax_path = vw_user_interface_path.ajaxurl;
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: data,
		dataType: 'html',
		success  : function(response) {
			res=jQuery.parseJSON(response);
			if(clicked=='p'){
				jQuery('.pv_lrs_spinner').hide();
				jQuery('.pv_lrs_msg').html(res.msg);
				jQuery('.pv_lrs_msg').css('color',res.color);
			}else{
				jQuery('.sv_lrs_spinner').hide();
				jQuery('.sv_lrs_msg').html(res.msg);
				jQuery('.sv_lrs_msg').css('color',res.color);
			}
			setTimeout(function(){
				jQuery('.pv_lrs_msg').html('');
				jQuery('.sv_lrs_msg').html('');
			},5000);
		}
	});
});

/* change event for dev tools */
jQuery(document).on('change','.dev_tools_toggle',function(){
		jQuery('.lp-screen').show();
		var fd=new FormData();
		if(jQuery(this).is(':checked')){
			fd.append('dev_tools','on');
		}else{
			fd.append('dev_tools','off');
		}
		fd.append('action','change_dev_tools_mode');
		var ajax_path = vw_user_interface_path.ajaxurl;
		jQuery.ajax({					
			url  : ajax_path,
			type: 'POST',
			data: fd,
			dataType: 'html',
			contentType: false,
			processData: false,	
			success  : function(response) {
				location.reload();
				jQuery('.lp-screen').hide();
			}
		});

});

/* submit event for check plugin health */
jQuery(document).on('submit','#check_plugin_health',function(e){
	e.preventDefault();
	var pluginscnt=jQuery('.plugins').length;
	fd=new FormData(this);
	fd.append('action','lx_plugin_health_check');
	var ajax_path = vw_user_interface_path.ajaxurl;
	jQuery.ajax({
		url  : ajax_path,
		type: 'POST',
		data: fd,
		dataType: 'html',
		contentType: false,
		processData: false,	
		success  : function(response) {
			var res=jQuery.parseJSON(response);
			var pmlength=Object.keys(res.pagemissing).length;
			if(res.okplugin.length>0 && res.okplugin.length==pluginscnt){
				jQuery('.plugin_status').html('Ok');
			}else if(pmlength>0 && pmlength==pluginscnt){
				jQuery.each(res.pagemissing,function(key,page){
					if(page!=null){
						jQuery('.status_'+key).html(page+' Page Missing');
					}else{
						jQuery('.status_'+key).html('Ok');
					}
				});
			}else if(res.not_installed.length>0 && res.not_installed.length==pluginscnt){
				jQuery('.plugin_status').html('Not Installed');
			}else if(res.versioncheck.length>0 && res.versioncheck.length==pluginscnt){
				jQuery('.plugin_status').html('Needs Update');
			}else if((res.okplugin.length>0 && res.okplugin.length<pluginscnt) || (pmlength>0 && pmlength<pluginscnt) || (res.not_installed.length>0 && res.not_installed.length<pluginscnt) || (res.versioncheck.length>0 && res.versioncheck.length<pluginscnt)){
				jQuery.each(res.okplugin,function(key,plugin){
					jQuery('.status_'+plugin).html('Ok');
				});
				jQuery.each(res.pagemissing,function(key,page){
					jQuery('.status_'+key).html(page+' Page Missing');
				});
				jQuery.each(res.not_installed,function(key,plugin){
					if(key==plugin){
						jQuery('.status_'+key).html('Not Installed');
					}else{
						jQuery('.status_'+key).html('Required '+plugin);
					}
				});
				jQuery.each(res.versioncheck,function(key,plugin){
					jQuery('.status_'+plugin).html('Needs Update');
				});
			}
		}
	});
});

jQuery(document).on('submit','#login_setting_form',function(e){
	e.preventDefault();
	jQuery('.lp-screen').show();
	var fd=new FormData(this);
	fd.append('email_body_tinymce',tinymce.get('email_body').getContent());
	fd.append('action','save_login_settings');
	var ajax_path = vw_user_interface_path.ajaxurl;
	jQuery.ajax({
		url  : ajax_path,
		type: 'POST',
		data: fd,
		dataType: 'html',
		contentType: false,
		processData: false,	
		success  : function(response) {
			jQuery('.lp-screen').hide();
		}
	});
});

/** save pluginupdate key **/
jQuery(document).on('click','.btnsavepluginupdatekey',function(e){
	var githubkey = jQuery('#plugin_update_key').val();
	jQuery('.lp-screen').show();
	var data={'githubkey':githubkey,'action':'fnajaxsavepluginupdatekey'};
	var ajax_path = vw_user_interface_path.ajaxurl;
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: data,
		dataType: 'html',
		success  : function(response) {
			jQuery('.lp-screen').hide();
		}
	});
});