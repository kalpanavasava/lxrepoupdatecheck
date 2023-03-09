/* for login password user readable format */
jQuery(document).on('click','.login_password_formate',function(e){
	if( jQuery('.login_password').attr('type') != 'password'){
		jQuery('.login_password_formate .svg-inline--fa').removeClass('fa-eye');
		jQuery('.login_password_formate .svg-inline--fa').addClass('fa-eye-slash');
		jQuery('.login_password_formate .svg-inline--fa').attr('data-icon','eye-slash');
		jQuery('.login_password').attr('type','password');
	}else{
		jQuery('.login_password_formate .svg-inline--fa').removeClass('fa-eye-slash');
		jQuery('.login_password_formate .svg-inline--fa').addClass('fa-eye');
		jQuery('.login_password_formate .svg-inline--fa').attr('data-icon','eye');
		jQuery('.login_password').attr('type','text');
	}
});

/* for join password user readable format */	
jQuery(document).on('click','.join_work_psw .join_password_formate',function(e){
	if( jQuery('.join_work_psw .join_password').attr('type') != 'password'){
		jQuery('.join_work_psw .join_password_formate .svg-inline--fa').removeClass('fa-eye');
		jQuery('.join_work_psw .join_password_formate .svg-inline--fa').addClass('fa-eye-slash');
		jQuery('.join_work_psw .join_password_formate .svg-inline--fa').attr('data-icon','eye-slash');
		jQuery('.join_work_psw .join_password').attr('type','password');
	}else{
		jQuery('.join_work_psw .join_password_formate .svg-inline--fa').removeClass('fa-eye-slash');
		jQuery('.join_work_psw .join_password_formate .svg-inline--fa').addClass('fa-eye');
		jQuery('.join_work_psw .join_password_formate .svg-inline--fa').attr('data-icon','eye');
		jQuery('.join_work_psw .join_password').attr('type','text');
	}
});
jQuery(document).on('click','.join_retype_psw .join_password_formate',function(e){
	if( jQuery('.join_retype_psw .retype_password').attr('type') != 'password'){
		jQuery('.join_retype_psw .join_password_formate .svg-inline--fa').removeClass('fa-eye');
		jQuery('.join_retype_psw .join_password_formate .svg-inline--fa').addClass('fa-eye-slash');
		jQuery('.join_retype_psw .join_password_formate .svg-inline--fa').attr('data-icon','eye-slash');
		jQuery('.join_retype_psw .retype_password').attr('type','password');
	}else{
		jQuery('.join_retype_psw .join_password_formate .svg-inline--fa').removeClass('fa-eye-slash');
		jQuery('.join_retype_psw .join_password_formate .svg-inline--fa').addClass('fa-eye');
		jQuery('.join_retype_psw .join_password_formate .svg-inline--fa').attr('data-icon','eye');
		jQuery('.join_retype_psw .retype_password').attr('type','text');
	}
});

/* for reset password user readable format */
jQuery(document).on('click','.reset_password_formate',function(e){
	if( jQuery('.password_info').attr('type') != 'password'){
		jQuery('.reset_password_formate .svg-inline--fa').removeClass('fa-eye');
		jQuery('.reset_password_formate .svg-inline--fa').addClass('fa-eye-slash');
		jQuery('.reset_password_formate .svg-inline--fa').attr('data-icon','eye-slash');
		jQuery('.password_info').attr('type','password');
	}else{
		jQuery('.reset_password_formate .svg-inline--fa').removeClass('fa-eye-slash');
		jQuery('.reset_password_formate .svg-inline--fa').addClass('fa-eye');
		jQuery('.reset_password_formate .svg-inline--fa').attr('data-icon','eye');
		jQuery('.password_info').attr('type','text');
	}
});

/* for reset retype password user readable format */	
jQuery(document).on('click','.reset_retype_password_formate',function(e){
	if( jQuery('.confirm_password_info').attr('type') != 'password'){
		jQuery('.reset_retype_password_formate .svg-inline--fa').removeClass('fa-eye');
		jQuery('.reset_retype_password_formate .svg-inline--fa').addClass('fa-eye-slash');
		jQuery('.reset_retype_password_formate .svg-inline--fa').attr('data-icon','eye-slash');
		jQuery('.confirm_password_info').attr('type','password');
	}else{
		jQuery('.reset_retype_password_formate .svg-inline--fa').removeClass('fa-eye-slash');
		jQuery('.reset_retype_password_formate .svg-inline--fa').addClass('fa-eye');
		jQuery('.reset_retype_password_formate .svg-inline--fa').attr('data-icon','eye');
		jQuery('.confirm_password_info').attr('type','text');
	}
});
	
jQuery(document).ready(function(){
	/* for manage scroll view in registration part  */
	var info = jQuery('#redirection_info').val();
	if( info == 'register_info' ){
		jQuery( ".btn-register" ).trigger( "click" );
		window.scrollTo(300, 440);
	}
	/* for add unique class for password field */
	jQuery('.login_container .uwp-login-form .c-pointer').addClass('login_password_formate');
	jQuery('.login_container .uwp-login-form #password').addClass('login_password');
	jQuery('.login_container .uwp-join-form .c-pointer').addClass('join_password_formate');
	jQuery('.login_container .uwp-join-form #work_password').addClass('join_password');
	jQuery('.login_password_formate').removeAttr('onclick');
	
	jQuery('.main_div_reset_password #password').addClass('password_info');
	jQuery('.main_div_reset_password #confirm_password').addClass('confirm_password_info');
	jQuery('.main_div_reset_password .c-pointer').first().addClass('reset_password_formate');
	jQuery('.reset_password_formate').removeAttr('onclick');
	jQuery('.main_div_reset_password .c-pointer').last().addClass('reset_retype_password_formate');
	jQuery('.reset_retype_password_formate').removeAttr('onclick');
});

/* for join user */
jQuery(document).on('submit','#join_user',function(e){
	e.preventDefault();
	var captcha_info = jQuery('.uwp-join-form .g-recaptcha-response').val();
	if( captcha_info == "" ){
		jQuery('#recaptcha_error_msg').show();
		jQuery('#recaptcha_error_msg').text("Invalid reCAPTCHA. Please try again..");
	}else{
		jQuery('#recaptcha_error_msg').hide();
	}
	var email = jQuery('#work_email').val();
	var fname = jQuery('#first_name').val();
	var lname = jQuery('#last_name').val();
	var work_password = jQuery('#work_password').val();
	var retype_password = jQuery('#retype_password').val();
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if( email=="" ){
		var email_error_msg = "Email can't be blank";
	} else if( email != "" ){
		if(!regex.test(email)) {
			var email_error_msg = "Email is invalid";
		} else if(jQuery('#work_email_error_msg').text() != ""){
			var email_error_msg = jQuery('#work_email_error_msg').text();
		} else {
	
			var email_error_msg = "";
		} 
	} else {
		var email_error_msg = "";
	}
	if( email_error_msg != "" ){
		jQuery('#work_email_error_msg').show();
		jQuery('#work_email_error_msg').text(email_error_msg);
		jQuery('#work_email').css('border-color','#ff0000');
	}else{
		jQuery('#work_email_error_msg').hide();
		jQuery('#work_email').css('border','1px solid #ccc');
	}
	if( fname == "" ){
		var fname_error_msg = "First Name can't be blank";
	} else{
		var fname_error_msg = "";
	}
	if( fname_error_msg != "" ){
		jQuery('#first_name_error_msg').show();
		jQuery('#first_name_error_msg').text(fname_error_msg);
		jQuery('#first_name').css('border-color','#ff0000');
	}else{
		jQuery('#first_name_error_msg').hide();
		jQuery('#first_name').css('border','1px solid #ccc');
	}
	if( lname == "" ){
		var lname_error_msg = "Last Name can't be blank";
	} else{
		var lname_error_msg = "";
	}
	if( lname_error_msg != "" ){
		jQuery('#last_name_error_msg').show();
		jQuery('#last_name_error_msg').text(lname_error_msg);
		jQuery('#last_name').css('border-color','#ff0000');
	}else{
		jQuery('#last_name_error_msg').hide();
		jQuery('#last_name').css('border','1px solid #ccc');
	}
	if( work_password == "" ){
		var psw_error_msg = "Password can't be blank";
	} else if( work_password != "" ){
		if(jQuery('#work_password_error_msg').text() != ""){
			var psw_error_msg = jQuery('#work_password_error_msg').text();
		}else{
			var psw_error_msg = "";
		}
	} else{
		var psw_error_msg = "";
	}
	if( psw_error_msg != "" ){
		if(jQuery('#work_password_error_msg').text() == "Strong" || jQuery('#work_password_error_msg').text() == "Medium"){
			jQuery('#work_password_error_msg').hide();
			jQuery('#work_password').css('border','1px solid #ccc');
			psw_error_msg = "";
		} else{
			jQuery('#work_password_error_msg').show();
			jQuery('#work_password_error_msg').text(psw_error_msg);
			jQuery('#work_password').css('border-color','#ff0000');
		}
	} else{
		jQuery('#work_password_error_msg').hide();
		jQuery('#work_password').css('border','1px solid #ccc');
	}
	if( retype_password == "" ){
		var retype_password_error_msg = "Retype Password can't be blank";
	}else if( jQuery('#retype_password_error_msg').text() != " " ){
		var retype_password_error_msg = jQuery('#retype_password_error_msg').text();
	} else{

		var retype_password_error_msg = "";
	}
	if( retype_password_error_msg != "" ){
		jQuery('#retype_password_error_msg').show();
		jQuery('#retype_password_error_msg').text(retype_password_error_msg);
		jQuery('#retype_password').css('border-color','#ff0000');
	}else{
		jQuery('#retype_password_error_msg').hide();
		jQuery('#retype_password').css('border','1px solid #ccc');
	}
	
	jQuery('#agreement_error_msg').hide();
	if( jQuery('#registertermsaggrement').prop('checked') == false && jQuery('.hidchecktoa').val() !='' ){
		jQuery('#agreement_error_msg').show();
	}
	
	var email_val = jQuery('#work_email_error_msg').text();
	if( email_val == "" && psw_error_msg == "" && fname_error_msg == ""  && lname_error_msg == ""  && retype_password_error_msg == "" && captcha_info != "" && jQuery('#agreement_error_msg').is(':visible') == false ){
		jQuery('.lp-screen').show();
		var fd=new FormData(this);
		fd.append('action','fn_vw_join_user');
		var ajax_path = vw_custom_login_path.ajaxurl;
		jQuery.ajax({					
			url  : ajax_path,
			type: 'POST',
			data: fd,
			dataType: 'html',
			contentType: false,
			processData: false,			
			success  : function(response) {
				window.location.href = response;
				jQuery('.lp-screen').hide();
			}
		});
	}	
});

/* for resend email */
jQuery(document).on('click','.resend_email',function(e){
	e.preventDefault();
	jQuery('.lp-screen').show();
	var ajax_path = vw_custom_login_path.ajaxurl;
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: { userid:jQuery('#hd_userid').val(),redirection:jQuery('#redirection').val(),course_id:jQuery('#course_id').val(),process:'send_verification_link',is_restricted:jQuery('#is_restricted').val(),action:'fn_vw_resend_email'},
		dataType: 'html',		
		success  : function(response) {
			jQuery('.lp-screen').hide();
		}
	}); 
});

/* for check email is exists or not */
jQuery(document).on('change','.work_email',function(e){
	var work_email = jQuery('#work_email').val();
	var ajax_path = vw_custom_login_path.ajaxurl;
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: { work_email:work_email , action:'fn_vw_email_validation'},
		dataType: 'html',		
		success  : function(response) {
			if(response == 1){
				jQuery('#work_email_error_msg').text("It looks like you might already be registered on this site. Click 'Cancel' and Login instead.");
				jQuery('#work_email_error_msg').show();
				jQuery('#work_email').css('border-color','#ff0000');
				jQuery('.btn-join').attr('disabled','disabled');
				
			} else{
				jQuery('#work_email_error_msg').text('');
				jQuery('#work_email_error_msg').hide();
				jQuery('#work_email').css('border','1px solid #ccc');
				jQuery('.btn-join').removeAttr('disabled');
			}
		}
	}); 
});

/* for show registration form */
jQuery(document).on('click','.btn-register',function(e){
	jQuery('.uwp-login-form').hide();
	jQuery('.btn-login2').hide();
	jQuery('.divider_form').hide();
	jQuery('.uwp-join-form').show();
	jQuery('.purchase_login').hide();
	jQuery(this).hide();
});

/* for check password is strong or not */
jQuery(document).on('keyup','#work_password',function(){
		jQuery('#work_password_error_msg').html(checkStrength(jQuery('#work_password').val()));
		var password_val = jQuery("#work_password").val();
		var confirmPassword = jQuery("#retype_password").val();
		if(confirmPassword!=""){
			if (password_val != confirmPassword){
				jQuery('#retype_password_error_msg').show();
				jQuery("#retype_password_error_msg").html("Password doesn't match!");
				jQuery('#retype_password').css('border-color','#ff0000');
			
			}else{
				jQuery('#retype_password_error_msg').hide();
				jQuery('#retype_password').css('border','1px solid #ccc');
				jQuery("#retype_password_error_msg").html(" ");
			}
		}
});

/* for check retype password match with password or not */
jQuery(document).on('keyup','#retype_password',function(){
	jQuery('.progress').remove();
    var password_val = jQuery("#work_password").val();
    var confirmPassword = jQuery("#retype_password").val();

    if (password_val != confirmPassword){
		jQuery('#retype_password_error_msg').show();
		jQuery('#retype_password').css('border-color','#ff0000');
        jQuery("#retype_password_error_msg").html("Password doesn't match!");
		
    } else {
		jQuery('#retype_password_error_msg').hide();
		jQuery('#retype_password').css('border','1px solid #ccc');
        jQuery("#retype_password_error_msg").html(" ");
	}
});

/* function for check password strength */
function checkStrength(password) {
	var strength = 1
	if (password.length < 8) {
		jQuery('#work_password_error_msg').removeClass()
		jQuery('#work_password_error_msg').addClass('short')
		jQuery('#work_password').css('border-color','#ff0000')
		return 'Too short'
	}
	if (password.length > 7) strength += 1
	
	if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/) && password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1

	if (password.match(/[A-Z]/)) strength += 1
	
	if (strength == 2) {
		jQuery('#work_password_error_msg').removeClass()
		jQuery('#work_password_error_msg').addClass('weak')
		jQuery('#work_password').css('border-color','#ff0000')
		return 'Weak'
		
	} else if (strength == 3) {
		jQuery('#work_password_error_msg').removeClass()
		jQuery('#work_password_error_msg').addClass('medium')
		jQuery('#work_password').css('border','1px solid #ccc')
		return 'Medium'
	} else if(strength > 3) {
		jQuery('#work_password_error_msg').removeClass()
		jQuery('#work_password_error_msg').addClass('strong')
		jQuery('#work_password').css('border','1px solid #ccc')
		return 'Strong'
	}
}

/* for email verification */
jQuery(document).on('click','.btn_verification',function(e){
	e.preventDefault();
	/* alert(); */
	var verification_val = jQuery(this).data('info');
	var encode_url = jQuery(this).data('encode_url');
	var user_login = jQuery('#user_login').val();
	var user_pass = jQuery('#user_pass').val();
	var userid = jQuery('#userid').val();
	var redirection = jQuery('#redirection').val();
	var ajax_path = vw_custom_login_path.ajaxurl;
	jQuery('.lp-screen').show();
	jQuery.ajax({					
		url  : ajax_path,
		type: 'POST',
		data: { encode_url:encode_url,verification_val:verification_val , userid:userid , user_login:user_login , user_pass:user_pass , action:'fn_vw_email_verification'},
		dataType: 'html',		
		success  : function(response) {
			jQuery('.lp-screen').hide();
			if( verification_val == 'login' && redirection == 'purchase' ){
				window.location.href = my_site_path.site_url+'/payment/'+encode_url;
			}else if(verification_val==''){
				jQuery('.verification_err').html("Something went wrong. Please click <a href='"+response+"'>here</a> to resend the verification email");
			}else {
				window.location.href = response;
			}
			
		}
	}); 
});

/* for resend email verification link */
jQuery(document).on('click','.vw_customize_login_main .resend_verification_email',function(e){
	e.preventDefault();
	var email = jQuery('#txt_resend_email').val();
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if( $.trim(email)=="" ){
		var email_error_msg = "Email can't be blank";
	} else if( $.trim(email) != "" ){
		if(!regex.test($.trim(email))) {
			var email_error_msg = "Email is invalid";
		} else if(jQuery('#work_email_error_msg').text() != ""){
			var email_error_msg = jQuery('#work_email_error_msg').text();
		} else {
	
			var email_error_msg = "";
		} 
	} else {
		var email_error_msg = "";
	}
	var captcha_info = jQuery('.g-recaptcha-response').val();
	if( captcha_info == "" ){
		jQuery('#recaptcha_error_msg').show();
		jQuery('#recaptcha_error_msg').text("Invalid reCAPTCHA. Please try again..");
		var flag_captcha = 0;
	}else{
		jQuery('#recaptcha_error_msg').hide();
		var flag_captcha = 1;
	}
	if( email_error_msg != "" ){
		jQuery('#email_error_msg').show();
		jQuery('#email_error_msg').text(email_error_msg);
		jQuery('#txt_resend_email').css('border-color','#ff0000');
		var flag_email = 0;
	}else{
		jQuery('#email_error_msg').hide();
		jQuery('#txt_resend_email').css('border','1px solid #ccc');
		var flag_email = 1;
	}
	if( flag_email == 1 && flag_captcha == 1 ){
		jQuery('.lp-screen').show();
		var ajax_path = vw_custom_login_path.ajaxurl;
		jQuery.ajax({					
			url  : ajax_path,
			type: 'POST',
			data: { user_email:jQuery('#txt_resend_email').val(),process:'resend_verification_link' , action:'fn_vw_resend_email'},
			dataType: 'html',		
			success  : function(response) {
				var obj = jQuery.parseJSON(response);
				console.log('response',obj['flag']);
				if( obj['flag'] == true ){
					window.location.href = obj['data'];
				} else if( obj['flag'] == false ){
					jQuery('.verification_resend').html(obj['data']);
				}
				jQuery('.lp-screen').hide();
			}
		}); 
	}
});

/* for open forgot password modal */
jQuery(document).on('click','.vw_customize_login_main .open_forgot_modal',function(e){
	e.preventDefault();
	jQuery.ajax({
        type: "POST",
        url: uwp_localize_data.ajaxurl,
        data: { action: "uwp_ajax_forgot_password_form" },
        beforeSend: function () {
            uwp_modal_loading(2);
        },
        success: function (a) {
            a.success &&
                (jQuery(".uwp-auth-modal .modal-content").html(a.data),
                setTimeout(function () {
                    jQuery(".uwp-auth-modal .modal-content input:visible:enabled:first").focus().unbind("focus");
                }, 300),
				jQuery('.center').addClass('forgot_main_div'),
                jQuery(".uwp-auth-modal .modal-content form.uwp-forgot-form").on("submit", function (a) {
                    a.preventDefault(a), uwp_modal_forgot_password_form_process();
                })),
                uwp_init_auth_modal();
        },
    });
});
jQuery(document).on('click','.uwp_login_submit', function(e) {
    e.preventDefault();
    var errors=[];
     var captcha_info = jQuery('.uwp-join-form .g-recaptcha-response').val();
    if(jQuery('.uwp-login-form  #username').val()==''){
    	if(jQuery('.uwp-login-form').children().find('un_error')){
    		jQuery('.un_error').remove();
    	}
    	jQuery('.uwp-login-form #username').css('border-color','red');
    	jQuery("<span class='un_error' style='color:red;font-size:14px;'>Email can't be blanck</span>").insertAfter('.uwp-login-form #username');
    	errors.push('1');
    }else{
    	jQuery('.un_error').remove();	
    }
    if(jQuery('.uwp-login-form #password').val()==''){
    	jQuery('.uwp-login-form #password').css('border-color','red');
    	if(jQuery('.uwp-login-form').children().find('up_error')){
    		jQuery('.up_error').remove();
    	}
    	jQuery("<span class='up_error' style='color:red;font-size:14px;'>Password can't be blanck</span>").insertAfter('.uwp-login-form .input-group');
    	errors.push('1');
    }
    else{
    	jQuery('.up_error').remove();	
    }
    if(errors.length>0){
    	return false;
    }
    uwp_ajax_login('.uwp-login-form');
});
function uwp_ajax_login($this) {
	jQuery('.lp-screen').show();
    jQuery('.uwp-login-ajax-notice').remove();
    var data = jQuery($this).serialize()+ "&action=uwp_ajax_login";
    jQuery.ajax({
        method: "POST",
        url: uwp_localize_data.ajaxurl,
        data: data,
        success: function (response) {
	        if(response.success==false){
	            jQuery('.uwp-login-form').before(response.data);
	            jQuery('.lp-screen').hide();
	        } else {
	            jQuery('.uwp-login-form').before(response.data);
				
				let displayMode = 'browser';
				const mqStandAlone = '(display-mode: standalone)';
				if (navigator.standalone || window.matchMedia(mqStandAlone).matches) {
					displayMode = 'standalone';
				}
				if( displayMode == 'standalone' ){
					window.location.href='/learnx/pwa-fl1plist/';
				}else{
					window.location.href=response;
					/* setTimeout(function(){location.reload()}, 1200) */
				}
	        }
        }
    });
}
jQuery(document).on('click','.btn-login2',function(){
	jQuery('.uwp-login-form ').show();
	if( jQuery('.purchase_login').length > 0 ){
		jQuery('.purchase_login').hide();
	}
	jQuery(this).hide();
});
jQuery(document).on('click','.login_close,.btn_reg_cancel',function(){
	if(jQuery('.uwp-login-form').is(':visible') || jQuery('.uwp-join-form').is(':visible')){
		jQuery('.uwp-login-form').hide();
		jQuery('.uwp-join-form').hide();
		jQuery(".uwp-login-form")[0].reset();
		jQuery("#join_user")[0].reset();
		jQuery('.btn-login2').show();
		jQuery('.btn-register').show();
		jQuery('.divider_form').show();
		if( jQuery('.purchase_login').length > 0 ){
			jQuery('.purchase_login').show();
		}
	}else{
		window.location.href=my_site_path.site_url;
	}
});

/** agreement page js **/
jQuery(document).on('click','.aggrementcancel',function(){
	jQuery('#agreement_error_msg').show();
});
jQuery(document).on('click','.aggrementcontinue',function(){
	var agreement = jQuery('#registertermsaggrement').prop('checked');
	jQuery('#agreement_error_msg').hide();
	if( agreement == false ){
		jQuery('#agreement_error_msg').show();
		return false;
	}
	jQuery('.lp-screen').show();
	var data = { 'action':"fnajaxagreement" };
	jQuery.ajax({
        method: "POST",
        url: uwp_localize_data.ajaxurl,
        data: data,
		success: function (response) {
			window.location.href=my_site_path.site_url;
		}
	});
});