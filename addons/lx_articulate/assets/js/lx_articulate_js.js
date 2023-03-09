jQuery(document).ready(function(){
	/* change event for articulate web upload */
	jQuery('.articulate_zip_upload').on('change',function(e){
		var files=e.target.files;
		var length=files.length;
		var filesize=files[0].size;
		var filename=files[0].name;
		var extension = filename.substr( (filename.lastIndexOf('.') +1) );
		if(!jQuery('.articulate_category').is(':checked'))
		{
			jQuery('.alert_box').html("Please Choose Content Type.");
			jQuery('.alert_box').show();
			setTimeout(function(){
				jQuery('.alert_box').hide();
				jQuery('.lbl_articulate_zip_upload').text('');
				jQuery('.articulate_zip_upload').val('');
			},3000);
			return false;
		}
		if(extension !="zip")
		{
			jQuery('.alert_box').html("File Type Must be ZIP.");
			jQuery('.alert_box').show();
			setTimeout(function(){
				jQuery('.alert_box').hide();
				jQuery('.lbl_articulate_zip_upload').text('');
				jQuery('.articulate_zip_upload').val('');
			},3000);
			return false;
		}
		else{
			var fd=new FormData();
			var content_category=[];
			jQuery('.articulate_content_category:checked').each(function(){
				content_category.push(jQuery(this).val());
			});
			fd.append('articulate_id',jQuery('#articulate_id').val());
			fd.append("zip_content", document.getElementById('articulate_zip_upload').files[0]);
			fd.append("format",jQuery('#articulate_format_val').val());
			fd.append("tool",jQuery('.articulate_category:checked').val());
			fd.append("content_category",content_category);
			fd.append("process",'verify_package');
			fd.append('action','articulate_zip_upload_process');
			var percentage=0;
			var progressbar=jQuery('#verify_pkg_progress');
			var timer=setInterval(function(){
				percentage=percentage+10;
				if(percentage>80){
					clearInterval(timer);
				}else{
					progressbar.attr('aria-valuenow', percentage);
					progressbar.css('width',percentage+"%");
					progressbar.text(percentage+"%");
				}
			},1000);
			jQuery.ajax({
				url:lx_articulate_ajax.ajax_url,
				type: 'POST',
				data: fd,
				contentType: false,
				processData: false,	
				beforeSend :function(){
					jQuery('.articulate_save').attr('disabled','disabled');
					jQuery('.articulate_save').removeClass('btn_normal_state');
					jQuery('.articulate_save').addClass('btn_disabled_state');
				},			
				success  : function(response){
					var res = jQuery.parseJSON(response);
					if(res.status == 400)
					{
						clearInterval(timer);
						jQuery('.verify_pkg_status').html(res.msg);
						jQuery('.verify_pkg_status').css('color','#ff0000');
						jQuery('.lbl_articulate_zip_upload').text('');
						jQuery('.articulate_zip_upload').val('');
						
					}else{
						jQuery('.verify_pkg_status').html('');
						var timer=setInterval(function(){
						percentage=percentage+10;
						if(percentage>100){
								clearInterval(timer);
								jQuery('#params').val(JSON.stringify(res.data))
								articulate_upload_zip();
							}else{
								progressbar.attr('aria-valuenow', percentage);
								progressbar.css('width',percentage+"%");
								progressbar.text(percentage+"%");
							}
						},100);	
					}
				}
			});
		}
	});
});
/* for articulate web upload */
function articulate_upload_zip(){
	var articulate_id=jQuery('#articulate_id').val();
	var params=jQuery('#params').val();
	var file_url=jQuery('#hid_file_url').val();
	var post_data={'articulate_id':articulate_id,'params':params,'old_file':file_url,'process':'upload_zip','action':'articulate_zip_upload_process'};
	var percentage=0;
	var progressbar=jQuery('#upload_progress');
	var timer=setInterval(function(){
		percentage=percentage+2;
		if(percentage>100){
			clearInterval(timer);
		}else{
			progressbar.attr('aria-valuenow', percentage);
			progressbar.css('width',percentage+"%");
			progressbar.text(percentage+"%");
		}
	},3000);
	jQuery.ajax({
		url  : lx_articulate_ajax.ajax_url,	
		type: 'POST',
		data: post_data,
		dataType:'json',
		beforeSend :function(){
			jQuery('.articulate_save').attr('disabled','disabled');
			jQuery('.articulate_save').removeClass('btn_normal_state');
			jQuery('.articulate_save').addClass('btn_disabled_state');
		},
		success  : function(response){
			if(response.status==200)
			{
				var timer=setInterval(function(){
					percentage=percentage+2;
					if(percentage>100){
						clearInterval(timer);
						jQuery('.api_inclusions_main_div').addClass('pt-3');
						jQuery('.upload_status').html('Uploded Successfully.')
					 	jQuery('.upload_status').css({'color':'#09980f !important','font-weight': '600'});
					 	jQuery('.articulate_save').removeAttr('disabled');
					 	jQuery('.articulate_save').removeClass('btn_disabled_state');
						jQuery('.articulate_save').addClass('btn_normal_state');
					}else{
						jQuery('.api_inclusions_main_div').removeClass('pt-3');
						progressbar.attr('aria-valuenow', percentage);
						progressbar.css('width',percentage+"%");
						progressbar.text(percentage+"%");
					}
				},100);	
			}
		}
	});

}
/* for save articulate web content */
jQuery(document).on('submit','#lx_articulate_form',function(e){
	e.preventDefault();
	var title=jQuery('#articulate_title').val();
	if(title==''){
		jQuery('.alert_box').html("Please Add Title.");
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('.alert_box').hide();
		},3000);
		return false;
	}
	else if(!jQuery('.articulate_content_category').is(':checked'))
	{
 		jQuery('.alert_box').html("Please Choose Content Category.");
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('.alert_box').hide();
		},3000);
		return false;
	}
	else if(jQuery('.articulate_category:checked').val() != 'articulate_web' && 	jQuery('#hid_file_url').val()=='' && document.getElementById("articulate_zip_upload").files.length == 0){ 
		jQuery('.alert_box').html("Please Choose Zip Package.");
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('.alert_box').hide();
		},3000);
		return false;
	} 
	
	else if(jQuery('.articulate_category:checked').val() == 'articulate_web' && jQuery('#alt_resource_url').val() == ''){ 
		jQuery('.alert_box').html("Please Add Web Link.");
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('.alert_box').hide();
		},3000);
		return false;
	}
	else{
		jQuery('.lp-screen').show();
		var fd=new FormData(this);
		fd.append('action','save_articulate_content');
		jQuery.ajax({
			url:lx_articulate_ajax.ajax_url,
			type: 'POST',
			data: fd,
			contentType: false,
			processData: false,	
			success : function(response){
				var res = jQuery.parseJSON(response);
				if(res.status == "title_existance"){
					jQuery('.lp-screen').hide();
					jQuery('.alert_box').html("Title is already exist.");
					jQuery('.alert_box').show();
					setTimeout(function(){
						jQuery('.alert_box').hide();
					},3000);
				} else if( res.status == 1 ){
					jQuery('.alert_box').html(res.msg);
					jQuery('.alert_box').show();
					setTimeout(function(){
						jQuery('.alert_box').hide();
					},3000);
					jQuery('.lp-screen').hide();
				} else{
					window.location.href=res.href;
					jQuery('.lp-screen').hide();
				}
			}
		});
	}
});
/* for delete articulate web content */
jQuery(document).on('click','.articulate_delete',function(){
	var articulate_id=jQuery(this).data('post_id');
	jQuery(".rm_link_"+articulate_id).removeAttr("target");
	jQuery(".rm_link_"+articulate_id).removeAttr("href");
	jQuery('.lp-screen').show();
	var post_data={'articulate_id':articulate_id,'action':"delete_articulate_content"};
	jQuery.ajax({
		url:lx_articulate_ajax.ajax_url,
		type:'POST',
		data:post_data,
		success: function(response){
			location.reload();
		}
	});
});
/* for articulate web articulate_category change */
jQuery(document).on('change','.articulate_category',function(){
	var selection_info = jQuery(this).val();
	if( selection_info == 'articulate_storyline' || selection_info == 'articulate_rise' ){
		jQuery('.alt_add_link').hide();
		jQuery('.alt_view_selection').hide();
		jQuery('.alt_zip_upload').show();
	} else if( selection_info == 'articulate_web' ){
		jQuery('.alt_zip_upload').hide();
		jQuery('.alt_add_link').show();
		jQuery('.alt_view_selection').show();
	}
});
/* for delete articulate web content thumbnail */
jQuery(document).on('click','.delete_articulate_thumbnail',function(e){
	e.preventDefault();
	jQuery('.alert_box').addClass('alert_box_del_thumb_popup');
	jQuery('.alert_box').html('<div>Are you sure you want to delete the thumbnail!</div><div class="del_thumb_popup_main_class"><button class="btn_normal_state btn_del_alt_thumb_popup_yes" data-dismiss="modal" aria-label="Close">Yes</button><button class="btn_dark_state btn_del_alt_thumb_popup_cancel" data-dismiss="modal" aria-label="Close">Cancel</button></div>');
	jQuery('.alert_box').show();
	$alert = jQuery('.alert_box');
	$alert.modal({backdrop:'static', keyboard:false});
});
/* for delete articulate web content thumbnail confirmation */
jQuery(document).on('click','.btn_del_alt_thumb_popup_yes',function(e){
	e.preventDefault();
	jQuery('.alert_box_del_thumb_popup').hide();
	jQuery('.lp-screen').show();
	var articulate_id = jQuery('.delete_articulate_thumbnail').data('id');
	var post_data = {'articulate_id':articulate_id,action:'fn_delete_articulate_thumbnail'};
	jQuery.ajax({					
				url  : my_ajax_object.ajax_anchor,	
				type: 'POST',
				data: post_data,
				dataType: 'html',						
				success  : function(response) {
					location.reload();
					jQuery('.lp-screen').hide();
				}
		});
});
/* for delete articulate web content thumbnail confirmation deny*/
jQuery(document).on('click','.btn_del_alt_thumb_popup_cancel',function(e){
	jQuery('.alert_box_del_thumb_popup').hide();
	jQuery('.modal-backdrop').remove();
});
/* for  articulate web content back link operations */
jQuery(document).on('click','.articulate_back_link',function(e){
	e.preventDefault();
	jQuery('.lp-screen').show();
	if(jQuery('#articulate_status').val()=='add'){
		var articulate_id=jQuery('#articulate_id').val();
		var post_data={'articulate_id':articulate_id,'status_info_backlink':'yes','action':'fn_delete_articulate_thumbnail'};
		jQuery.ajax({
			url  : my_ajax_object.ajax_anchor,	
			type: 'POST',
			data: post_data,
			dataType: 'html',						
			success : function(response) {
				jQuery('.lp-screen').hide();
				window.location.href=jQuery('.hidden_back_link').val();
			}
		});
	} else{
		window.location.href=jQuery('.hidden_back_link').val();
	} 
	
});