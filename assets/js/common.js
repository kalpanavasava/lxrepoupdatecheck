var Base64 = {

	_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
	
	encode : function (input) {
		
		var output = "";
		var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
		var i = 0;
	
		input = Base64._utf8_encode(input);
		
		while (i < input.length) {
	
			chr1 = input.charCodeAt(i++);
			chr2 = input.charCodeAt(i++);
			chr3 = input.charCodeAt(i++);
	
			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;
	
			if (isNaN(chr2)) {
				enc3 = enc4 = 64;
			} else if (isNaN(chr3)) {
				enc4 = 64;
			}
	
			output = output +
			this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
			this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
		}
		return output;
	},
	
	decode : function (input) {
		var output = "";
		var chr1, chr2, chr3;
		var enc1, enc2, enc3, enc4;
		var i = 0;
	
		input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
	
		while (i < input.length) {
	
			enc1 = this._keyStr.indexOf(input.charAt(i++));
			enc2 = this._keyStr.indexOf(input.charAt(i++));
			enc3 = this._keyStr.indexOf(input.charAt(i++));
			enc4 = this._keyStr.indexOf(input.charAt(i++));
	
			chr1 = (enc1 << 2) | (enc2 >> 4);
			chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
			chr3 = ((enc3 & 3) << 6) | enc4;
	
			output = output + String.fromCharCode(chr1);
	
			if (enc3 != 64) {
				output = output + String.fromCharCode(chr2);
			}
			if (enc4 != 64) {
				output = output + String.fromCharCode(chr3);
			}
	
		}
	
		output = Base64._utf8_decode(output);
	
		return output;
	
	},
	
	_utf8_encode : function (string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";
	
		for (var n = 0; n < string.length; n++) {
	
			var c = string.charCodeAt(n);
	
			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}
	
		}
	
		return utftext;
	},
	
	_utf8_decode : function (utftext) {
		var string = "";
		var i = 0;
		var c = c1 = c2 = 0;
	
		while ( i < utftext.length ) {
	
			c = utftext.charCodeAt(i);
	
			if (c < 128) {
				string += String.fromCharCode(c);
				i++;
			}
			else if((c > 191) && (c < 224)) {
				c2 = utftext.charCodeAt(i+1);
				string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
				i += 2;
			}
			else {
				c2 = utftext.charCodeAt(i+1);
				c3 = utftext.charCodeAt(i+2);
				string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
				i += 3;
			}
	
		}
	
		return string;
	}
	
	}

/* click event for view all podcast */
jQuery(document).on('click','.all-podcast',function(){
	jQuery('.lp-screen').show();
	window.history.pushState('obj', 'Home', my_site_path.site_url);
	var postdata = {action:'get_podcasts2'};
	jQuery.ajax({					
		url  : my_ajax_object.ajax_anchor,					
		type : 'POST',					
		data : postdata,					
		dataType : 'html',					
		success: function(response) {
			jQuery('.entry-content').html(response);
			jQuery('.all-podcast').addClass('current-menu-item');
			jQuery('.lp-screen').hide();
		}
	});
});


jQuery(document).ready(function(){
	jQuery('.swap_up_down .but').click(function(e) {
        e.preventDefault();
        jQuery('.order_save').show();
        var parent = $(this).parent().parent().parent();
        if ($(this).hasClass('swap_up')) {
            parent.insertBefore(parent.prev('div'));
        }
        else if ($(this).hasClass('swap_down')) {
            parent.insertAfter(parent.next('div'));
        }
    });
    jQuery('.arrange_order').on('click',function(){
    	jQuery('.lp-screen').show();
    	var order=[];
    	jQuery('.content_list_link').each(function(){
    		var lesson_ids=jQuery(this).data('lession_id');
    		order.push(lesson_ids);
    	});
    	var postdata={'order_arr':order,'action':'rearrange_lesson_order'}
    	jQuery.ajax({
    		url  : my_ajax_object.ajax_anchor,					
			type : 'POST',					
			data : postdata,					
			dataType : 'html',					
			success: function(response) {
				 jQuery('.order_save').hide();
				 jQuery('.lp-screen').hide();
			}
    	});
    });
    jQuery('.cancle_lesson_order').on('click',function(){
    	location.reload();
    });
});

/* click event for home course */
jQuery(document).on('click','.home_course',function(){
	var course_id = jQuery(this).data('course_id');
	var course_url = jQuery(this).data('url');
	window.location = course_url;		
});

/* click event for view more content */ 
jQuery(document).on('click','.view_more_content',function(){
	var last_show = jQuery(this).data('last_show');
	var course_id=jQuery(this).data('course_id');
	var total=jQuery(this).data('total_content');
	jQuery('.more_btn_div').hide();
	var postdata = {'last_show':last_show,'course_id':course_id,'total_content':total,'action':'view_more_content'};
	jQuery.ajax({					
		url  : my_ajax_object.ajax_anchor,					
		type : 'POST',					
		data : postdata,					
		dataType : 'html',					
		success  : function(response) {
			jQuery('.more_btn_div').remove();
			jQuery('.show_more_content_'+course_id).append(response);
		}
	});
});

/* click event for expander */
jQuery(document).on('click','.expander',function(){
	var vis_check = jQuery('.vis_check').val();
	if (jQuery('.response_but').hasClass('low_rp_22')){ 
		jQuery('.response_tab').hide();
		jQuery('.slide_tab').fadeOut(500);
		jQuery('.slide_image_tab').fadeOut(500);
		jQuery('.information_tab').fadeOut(500);
		jQuery('.attachment_tab').fadeOut(500);
		jQuery('.response_but').html('<i class="fa fa-angle-up fa-2x" aria-hidden="true"></i>');
		jQuery('.audio_response_tab').addClass('col-4');
		jQuery('.audio_response_tab').removeClass('col-12');
		jQuery('.audio_response_tab').removeClass('audio_response_up');
		jQuery('.audio_response_tab').addClass('audio_response_down');
		jQuery('.btn_common').show();
		jQuery('.response_but').css({'background-color':'#fff','color':'#03A9F4'});
		jQuery('.ad_info').css('color','#03A9F4');
		jQuery('.side_tab').hide();
		jQuery('.response_but').removeClass('low_rp_22');
		jQuery('.close_btn').hide();
	}else{
		
		jQuery('.response_tab').hide();
		jQuery('.slide_tab').fadeOut(500);
		jQuery('.slide_image_tab').fadeOut(500);
		jQuery('.attachment_tab').fadeOut(500);
		jQuery('.audio_response_tab').removeClass('col-4');
		jQuery('.audio_response_tab').addClass('col-12');
		jQuery('.audio_response_tab').addClass('audio_response_up');
		jQuery('.audio_response_tab').removeClass('audio_response_down');
		jQuery('.btn_common').hide();
		jQuery('.response_but').css({'background-color':'#4fbdf4 ','color':'#fff'});
		jQuery('.ad_info').css('color','#fff');
		jQuery('.side_tab .text_but').css('background','#333')
		jQuery('.side_tab .slide_but_inner').css('background','#333');
		jQuery('.side_tab .btn_attachment').css('background','#333')
		jQuery('.side_tab .add_i').css('background','#03A9F4');
		jQuery('.side_tab').show();
		jQuery('.information_tab').fadeIn(500);
		/* jQuery('.slide_tab').animate({bottom: '100%'}); */
		jQuery('.slide_but').css('background','#333');
		jQuery('.response_but').html('<i class="fa fa-angle-down fa-2x" aria-hidden="true"></i>');
		jQuery('.response_tab_inner').css('background','#5d5d5d');
		jQuery('.response_but').addClass('low_rp_22');	
	}
});

/* click event for profile edit link */
jQuery(document).on('click','#ld-profile .ld-profile-edit-link',function(e){
	e.preventDefault();
	jQuery('.edit_my_profile').insertBefore('.ld-course-list');
	jQuery('.edit_my_profile').toggle();
});

/* click event for save my account info */
jQuery(document).on('click','.save_my_acc_info',function(){
	jQuery('.lp-screen').show();
	var firstname = jQuery('.my_acc_firstname').val();
	var lastname = jQuery('.my_acc_lastname').val();
	var email=jQuery('.my_acc_email').val();
	var post_data = {'firstname':firstname,'lastname':lastname,'email':email,'user_id':current_user_id.user_id,'action':"update_my_accountinfo"};
	jQuery.ajax({					
		url  : my_ajax_object.ajax_anchor,			
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			var res=jQuery.parseJSON(response);
			if(res.status==0){
				jQuery('.lp-screen').hide();
				jQuery('.alert_box').html(res.msg);
				jQuery('.alert_box').show();
				setTimeout(function(){
					jQuery('.alert_box').hide();
				},3000);
				return false;
			}else{
				jQuery('.lp-screen').hide();
			}
			
		}
	});
});