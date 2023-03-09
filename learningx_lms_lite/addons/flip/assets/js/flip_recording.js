jQuery(document).ready(function(){
	/* For  Additional Notes */
	if( jQuery('.fliprecadditional_notes').length > 0 ){
		var maxLength = 2000;
		var length = jQuery('.fliprecadditional_notes').val().length;
		var length = maxLength-length;
		jQuery('#additional_notes_chars').text(length);
		jQuery('.fliprecadditional_notes').keyup(function(){
			var maxLength = 2000;
			var length = jQuery(this).val().length;
			var length = maxLength-length;
			jQuery('#additional_notes_chars').text(length);
		});
	}
	/* Popover for Tips Formatting */
	jQuery("#formatting-popover").popover({
		html : true, 
		content: function() {
		  return jQuery("#formatting-popover-content").html();
		},
		title: function() {
		  return jQuery("#formatting-popover-title").html();
		}
	});
	
	/* For Attachment */
	/* const actualBtn = document.getElementById('actual-btn');
	const fileChosen = document.getElementById('file-chosen');
	actualBtn.addEventListener('change', function(){
		fileChosen.textContent = this.files[0].name
	}); */
	
	jQuery('.title_option').each(function(){
		if( jQuery(this).text() == '' ){
			jQuery(this).remove(); 
		}
	});
	
});  

jQuery(document).on('change',function(){
	var title = jQuery( "#add_to_this_fliplist option:selected" ).text();
	var trash_icon = jQuery('.trash_icon').val();
	var title_id = '';
	jQuery('.trash_icon_recording').each(function(){
		title_id = jQuery(this).data('title_id');
	});
	var new_title_id = title_id+1;
	
	var html = '<tr class="title_row'+new_title_id+'">'+
					'<td class="d-flex align-items-center">'+
						'<div><a href="javascript:void(0);" class="btn p-1 trash_icon_recording trash_icon_recording'+new_title_id+'" data-title_id="'+new_title_id+'"><i class="'+trash_icon+'" aria-hidden="true"></i></a></div>'+
						'<div><span>'+title+'</span></div>'+
					'</td>'+
				'</tr>';
	jQuery( html ).insertAfter( '.playlist_titles' );
});
var title_id = '';
jQuery(this).each(function(){
	title_id = jQuery(this).data('title_id');
});
var new_title_id = title_id+1;
jQuery(document).on('click','.trash_icon_recording',function(){
	var title_id = '';
	jQuery(this).each(function(){
		title_id = jQuery(this).data('title_id');
	});
	jQuery('.title_row'+title_id).remove(); 
});

jQuery(document).on('click','.trash_icon_recording'+new_title_id,function(){
	var title_id = '';
	jQuery(this).each(function(){
		title_id = jQuery(this).data('title_id');
	});
	var new_title_id = title_id+1;
	jQuery('.title_row'+new_title_id).remove(); 
});

jQuery(document).on('click','.fliprecsampletextblockntn',function(){
	jQuery('.fliprectextblockdiv').show();
	jQuery('.fliprecsampletextblock').hide();
});

jQuery(document).on('click','.fliprecsamplepdfblockbtn',function(){
	jQuery('.fliprecpdfblockdiv').show();
	jQuery('.fliprecsamplepdfblock').hide();
});

jQuery(document).on('click','.flirecsamplemulimageblockbtn',function(){
	jQuery('.flirecmulimageblock').show();
	jQuery('.flirecsamplemulimageblock').hide();
});

jQuery(document).on('click','.flipsettingbtn',function(){
	jQuery('#flipsettingmodal').modal('show');
});
/* jQuery(document).mouseup(function(e) {
    var container = jQuery(".fliprectextblockdiv");
    if (!container.is(e.target) && container.has(e.target).length === 0){
        container.hide();
		jQuery('.fliprecsampletextblock').hide();
    }
}); */

/********** Recording JS **********/
jQuery(document).on('click','.selectadd_fliplists',function(){
	if( jQuery(this).hasClass('selectedmycommfliplist') ){
		jQuery(this).removeClass('selectedmycommfliplist');
		jQuery('.add_to_this_fliplist_div').hide();
	}else{
		jQuery(this).addClass('selectedmycommfliplist');
		jQuery('.add_to_this_fliplist_div').show();
	}
});

function FliprecSettings(){
	var is_singlecom = [];var is_singlelist = [];
	jQuery('.mycommfliplistselected').each(function(){
		if( jQuery(this).data('display_in') == 'in_community' ){
			is_singlecom.push(jQuery(this).data('commtitle'));
			is_singlelist.push(jQuery(this).data('fliptitle'));
		}
		if( jQuery(this).data('display_in') == 'under_catgeory' ){
			is_singlelist.push(jQuery(this).data('fliptitle'));
		}
	});
	
	var color_grey = jQuery('.color-grey').val();
	var color_green = jQuery('.color-green').val();
	
	if( is_singlecom.length > 1 ){
		jQuery('.fliprecsetcomm').html('Multiple');
		jQuery('.fliprecsetcomm').css('color',color_green);
	}else if( is_singlecom.length == 1 ){
		jQuery('.fliprecsetcomm').html( is_singlecom[0] );
		jQuery('.fliprecsetcomm').css('color',color_green);
	}else{
		jQuery('.fliprecsetcomm').html('None');
		jQuery('.fliprecsetcomm').css('color',color_grey);
	}
	if( is_singlelist.length > 1 ){
		jQuery('.fliprecsetmyfliplist').html('Multiple');
		jQuery('.fliprecsetmyfliplist').css('color',color_green);
	}else if( is_singlelist.length == 1 ){
		jQuery('.fliprecsetmyfliplist').html( is_singlelist[0] );
		jQuery('.fliprecsetmyfliplist').css('color',color_green);
	}else{
		jQuery('.fliprecsetmyfliplist').html('None');
		jQuery('.fliprecsetmyfliplist').css('color',color_grey);
	}
}

jQuery(document).on('click','.indfliplists',function(){
	var trash_icon = jQuery('.trash_icon').val();
	var flipid = jQuery(this).data('flipid');
	var display_in = jQuery(this).data('display_in');
	var commtitle = jQuery(this).data('commtitle');
	var fliptitle = jQuery(this).data('fliptitle');
	var bordercolor = jQuery(this).data('bordercolor');
	jQuery(this).css('background-color',bordercolor);
	jQuery('.add_to_this_fliplist_div').hide();
	jQuery('.selectadd_fliplists').removeClass('selectedmycommfliplist');
	
	if( jQuery(this).hasClass('mycommfliplistselected') ){
		return false;
	}
	
	if( display_in == 'in_community' ){
		jQuery('.mycommunity_fliplist_mindiv').show();
		var html = "<div class='row myfliplistdivind myfliplistdivind"+flipid+"' data-flipid='"+flipid+"'><div class='col-md-6 mycomfliplistind"+flipid+"'><i class='"+trash_icon+" deletemycomfliplist' data-flip-id='"+flipid+"'></i> "+fliptitle+"</div><div class='col-md-6'>"+commtitle+"</div></div>";
		var htmlplaylist = "<div class='row myplaylistdivind myplaylistdivind"+flipid+"' data-flipid='"+flipid+"'><div class='col-md-12 myplayfliplistind"+flipid+"'><i class='"+trash_icon+" deletemyplayfliplist' data-flip-id='"+flipid+"'></i> "+fliptitle+"</div></div>";
		jQuery('.mycommunity_fliplist_div_dynamicrec').append( html );
		jQuery('.flipmyredsplaylistdiv').append( htmlplaylist );
	}
	/* alert(display_in); */
	if( display_in == 'under_catgeory' ){
		var htmlplaylist = "<div class='row myplaylistdivind myplaylistdivind"+flipid+"' data-flipid='"+flipid+"'><div class='col-md-12 myplayfliplistind"+flipid+"'><i class='"+trash_icon+" deletemyplayfliplist' data-flip-id='"+flipid+"'></i> "+fliptitle+"</div></div>";
		jQuery('.flipmyredsplaylistdiv').append( htmlplaylist );
	}
	jQuery(this).addClass('mycommfliplistselected');
	
	FliprecSettings();
	/* jQuery('.mycommunity_fliplist_div_dynamicrec') */
});

jQuery(document).on('click','.deletemyplayfliplist,.deletemycomfliplist',function(){
	var flipid = jQuery(this).data('flip-id');
	
	jQuery('.myfliplistdivind'+flipid).remove();
	jQuery('.myplaylistdivind'+flipid).remove();
	jQuery('.indfliplists'+flipid).removeClass('mycommfliplistselected');
	jQuery('.indfliplists'+flipid).css('background-color','#fff');
	
	if( jQuery('.myfliplistdivind').length == 0 ){
		jQuery('.mycommunity_fliplist_mindiv').hide();
	}
	FliprecSettings();
});

jQuery(document).on('click','.status_draft',function(){
	jQuery('#fliprec_status').val('draft');
});
jQuery(document).on('click','.status_publish',function(){
	jQuery('#fliprec_status').val('publish');
});

jQuery(document).on('click','.flip_record_save',function(){
	var additional_notes = jQuery('.fliprecadditional_notes').val();
	var fliprecid = jQuery('#recording_id').val();	
	var setcomm =  jQuery('.fliprecsetcomm').html();
	/* var rec_status = jQuery(this).data('status'); */
	var rec_status = jQuery('#fliprec_status').val();
	var bkflip_list_id = jQuery('.flip_list_idparent').val();
	
	var parentrec_id =  jQuery('#parentrec_id').val();
	if( parentrec_id == undefined || parentrec_id == '' ){
		var title = jQuery('.fliprectitle').val();
		var subtitle = jQuery('.fliprecsubtit').val();
		var setreply =  jQuery('.fliprecsetreplies').html();
		var setrest =  jQuery('.fliprecsetrest').html();
		var setmyfliplist =  jQuery('.fliprecsetmyfliplist').html();
		var setcomm =  jQuery('.fliprecsetcomm').html();
		var fliplists = [];
		jQuery('.myplaylistdivind').each(function(){
			fliplists.push( jQuery(this).data('flipid') );
		});
	}else{
		var title = jQuery('.flipresrectitle').val();
		var subtitle = jQuery('.flipresrecsubtitle').val();
	}
	if( subtitle == '' ){
		jQuery('.alert_box').html('Flip Recording Title Required');
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('.alert_box').hide();
		},3000);
		return false;
	}
	
	/* if( setcomm == '' || setmyfliplist == '' ){
		jQuery('.alert_box').html('Please add this recording to atleast one Fliplist');
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('.alert_box').hide();
		},3000);
		return false;
	} */
	jQuery('.lp-screen').show();
	var fliplists = [];
	jQuery('.myplaylistdivind').each(function(){
		fliplists.push( jQuery(this).data('flipid') );
	});
	
	var post_data = {'bkflip_list_id':bkflip_list_id,'additional_notes':additional_notes,'fliprecid':fliprecid,'title':title,'subtitle':subtitle,'rec_status':rec_status,'setreply':setreply,'setrest':setrest,'setcomm':setcomm,'setmyfliplist':setmyfliplist,'fliplists':fliplists,'parentrec_id':parentrec_id,'action':'FNFlipSaveRecoding'};
	jQuery.ajax({
		url  : recording_ob.ajax_url,	
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			var obj = jQuery.parseJSON( response );
			jQuery('.lp-screen').hide();
			if( obj.msg == 'exist' ){
				jQuery('.alert_box').html('Recording Title already Exist');
				jQuery('.alert_box').show();
				setTimeout(function(){
					jQuery('.alert_box').hide();
				},3000);
			}else if( jQuery.trim(obj.msg) == 'updated' ){
				/* Query('.alert_box').html('Flip Recording created successfully');
				jQuery('.alert_box').show();
				setTimeout(function(){
					jQuery('.alert_box').hide();
				},3000); */
				if( jQuery('#parentfliplistid').val() != undefined && jQuery('#parentfliplistid').val() != '' ){
					jQuery('.backtoplay').trigger('click');
				}else{
					var recreturnurl = jQuery( '.recreturnurl' ).val();
					window.location.href=recreturnurl;
				}
			}
		}
	});
	/* console.log( fliplists ); */
});

/** thumbnail upload for the recording **/
window.addEventListener('DOMContentLoaded', function () {
	var flipreccropper;
	jQuery('#fliprecthumbnailmodal').on('shown.bs.modal', function () {
		flipreccropper = new Cropper(document.getElementById('tofliprecimage'), {
		  aspectRatio: 16 / 9,
		  viewMode: 3, 
		});
	}).on('hidden.bs.modal', function () {
		flipreccropper.destroy();
		flipreccropper = null;
	});
	
	 /* document.getElementById('fliprec_crop_image_btn').addEventListener('click', function (e) { */
	jQuery(document).on('click','#fliprec_crop_image_btn',function(e){
		 e.stopImmediatePropagation();
		jQuery('#fliprecthumbnailmodal').modal('hide');
		jQuery('#flipsettingmodal').modal('show');
		var canvas;
		if (flipreccropper) {
			canvas = flipreccropper.getCroppedCanvas();
			var recid = jQuery('#recording_id').val();
			var recthumb = jQuery('#fliprecording_thumbnail')[0].files[0];
			var mode = jQuery('#mode').val();
			var fd = new FormData();      
			fd.append('recid',recid);
			fd.append('thumb',recthumb);
			fd.append('dataurl',canvas.toDataURL());
			fd.append('action','UploadFlipRecThumbnail');  
			var progressbar = jQuery('#fliprec_thumb_progress');
			var percentage = 0;
			var timer = setInterval(function(){
				percentage = percentage + 2;
				if( percentage > 100 ){
					clearInterval(timer);
				}else{
					progressbar.attr('aria-valuenow', percentage);
					progressbar.css('width',percentage+"%");
					progressbar.text(percentage+"%");
				}
			},100);
			jQuery.ajax({
				url : ajax_ob.ajax_url,              
				type: 'POST',
				data: fd,
				contentType: false,
				processData: false, 
				success:function(response){
					progressbar.attr('aria-valuenow', 100);
					progressbar.css('width',"100%");
					progressbar.text("100%");
					var res = jQuery.parseJSON(response);
					if( res.status == "1" ){
						jQuery('.recording_img').attr('src',res.imageURL);
						jQuery('.recording_img').attr('data-uploaded',"1");
						jQuery('.recording_img').show();  
						jQuery('.fliprec_thumb_upload_status').css({'color':'#09980f !important','font-weight': '600'});
						jQuery(".fliprec_thumb_upload_status").html(res.msg);
						var editicon = jQuery('.fliplistediticon').val();
					}else{
						jQuery('.alert_box').html(res.msg);
						jQuery('.alert_box').show();
						setTimeout(function(){
								jQuery('.alert_box').hide();
						},3000);
					} 
				},
				error: function (xhr, ajaxOptions, thrownError) {
					if(xhr.status == 413){
						jQuery('.'+imgCrop+' .recording_img').css('display','none');
						progressbar.attr('aria-valuenow', 0);
						progressbar.css('width',"0%");
						progressbar.text("0%");
						jQuery('.'+imgCrop+' .fliprec_thumb_upload_status').css({'color':'red','font-weight': '600'});
						jQuery('.'+imgCrop+' .fliprec_thumb_upload_status').html('Image size is too large');
					}
				}
			}); 
		}
	  });
});


/** Recording Multiple PDFS **/
jQuery(document).on('change','.fliprecmulpdfupload',function(){
	var file_name = jQuery(this)[0].files[0].name;
	/* var extension = file.substr( (file.lastIndexOf('.') +1) ); */
	if( jQuery(this)[0].files[0].size > 15728640 ){
		jQuery('.alert_box').html('File too big should be less then 15 mb');
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('.alert_box').hide();
		},3000);
		return false;
	}
	var fileExtension = (jQuery(this)[0].files[0].name).replace(/^.*\./, '');
	if( fileExtension !== 'pdf'){
		jQuery('.alert_box').html('File should be PDF');
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('.alert_box').hide();
		},3000);
		return false;
	}
	var pdfexist = [];
	jQuery('#all_pdfspans').each(function(){
		if( jQuery( this ).html() == file_name ){
			pdfexist.push( 1 );
		}
	});
	if( pdfexist.length > 0  ){
		jQuery('.alert_box').html('PDF already exist!!');
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('.alert_box').hide();
		},3000);
		return false;
	}
	
	var progressbar = jQuery('#fliprec_mulpdf_progress');
	progressbar.attr('aria-valuenow', 0);
	progressbar.css('width',"0%");
	progressbar.text("0%");
	
	var percentage = 0;
	var timer = setInterval(function(){
		percentage = percentage + 2;
		if( percentage > 99 ){
			clearInterval(timer);
		}else{
			progressbar.attr('aria-valuenow', percentage);
			progressbar.css('width',percentage+"%");
			progressbar.text(percentage+"%");
		}
	},100);	
	jQuery('.ispdfupload').html('');
	
	var fd = new FormData();
		fd.append('recid',jQuery('#recording_id').val());
		fd.append('files',jQuery(this)[0].files[0]);
		fd.append('action','FNMulPdfRecording');
	jQuery.ajax({
		url : ajax_ob.ajax_url,              
		type: 'POST',
		data: fd,
		contentType: false,
		processData: false, 
		success:function(response){
			var obj = jQuery.parseJSON(response);
			if( obj.status == '1' ){
				var trashicon = jQuery('.trash_icon').val();
				var redcolor = jQuery('.redcolor').val();
				var html = '<div class="row mulpdfindrow" style="margin:unset"><div class="col-md-10">'+
									'<i class="fa fa-paperclip fa-lg" aria-hidden="true"></i>'+
									' <span id="all_pdfspans">'+obj.pdfname+'</span>'+
								'</div>'+
								'<div class="col-md-2 d-flex justify-content-end">'+
									' <a href="javascript:void(0);" data-pdfname="'+obj.pdfname+'" class="btn p-0 pdftrashsingle trash_icon_pdf" style="color:'+redcolor+'"><i class="'+trashicon+'" aria-hidden="true"></i></a>'+
								'</div></div>';
				jQuery('.fliprecmulpdfview').append( html );
				jQuery('.ispdfupload').html( obj.msg );
				jQuery('.ispdfupload').css('color','#09980f');
				console.log(progressbar);
				clearInterval(timer);
				progressbar.attr('aria-valuenow', 100);
				progressbar.css('width',"100%");
				progressbar.text("100%");
				
				var total_pdf = [];
				jQuery('.mulpdfindrow').each(function(){
					total_pdf.push(1);
				});
				if( total_pdf.length >= 2 ){
					jQuery('.fliprecmulpdffielddiv').hide();
				}
			}
		}
	});
});

jQuery(document).on('click','.pdftrashsingle',function(){
	var pdfname = jQuery(this).data('pdfname');
	var recid = jQuery('#recording_id').val();
	jQuery(this).parent().parent().remove();

	var total_pdf = [];
	jQuery('.mulpdfindrow').each(function(){
		total_pdf.push(1);
	});
	
	if( total_pdf.length < 2 ){
		jQuery('.fliprecmulpdffielddiv').show();
	}
	
	if( total_pdf.length == 0 ){
		jQuery('#fliprec_mulpdf_progress').css('width','0%');
		jQuery('.ispdfupload').html('');
	}
	/* 
	jQuery('.mulpdfindrow').each(function(){
		
	});
	
	console.log(pdfexist); */
	
	var post_data = {'recid':recid,'pdfname':pdfname,'action':'FNrecdeletePDFFiles'};
	jQuery.ajax({
		url  : recording_ob.ajax_url,	
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
		}
	});
});

/********** Muliple Image Uploading JS **********/		
var filename='';
jQuery(document).on('change','#recording_sliderimgagesfld', function (e) {
	var files = e.target.files;
	filename = files[0].name;
	var ext = filename.split('.').pop().toLowerCase();
	if(jQuery.inArray(ext, ['png','jpg','jpeg']) == -1) {
		jQuery('.alert_box').html("Please Choose PNG/JPG/JPEG file.");
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('.alert_box').hide();
		},3000);
		return false;
	}
	var trash_icon = jQuery('.trash_icon').val();
	var progress = jQuery('.progress');
	var recording_id = jQuery('#recording_id').val();
	var mode = jQuery('#mode').val();
	var total_images = document.getElementById('recording_sliderimgagesfld').files.length;
	var fd = new FormData(); 
	fd.append('recording_id',recording_id);
	for (var i = 0; i < total_images; i++) {
	  fd.append('images[]', document.getElementById('recording_sliderimgagesfld').files[i]);
	}
	
	/* var file_nottoupload = [];
	jQuery('.dynamic_images').find('button').each(function(){
		file_nottoupload.push(jQuery(this).data('img_name')); 
	}); */
	
	fd.append('mode',mode);
	/* fd.append('file_nottoupload',file_nottoupload);   */
	fd.append('action','UploadRecordingMultipleImage');  
	var progressbar = jQuery('#recording_images_progress');
	var percentage = 0;
	var timer = setInterval(function(){
		percentage = percentage + 2;
		if( percentage > 100 ){
			clearInterval(timer);
		}else{
			progressbar.attr('aria-valuenow', percentage);
			progressbar.css('width',percentage+"%");
			progressbar.text(percentage+"%");
		}
	},100); 
	jQuery.ajax({
		url : recording_ob.ajax_url,              
		type: 'POST',
		data: fd,
		contentType: false,
		processData: false, 
		success:function(response){
			var res = jQuery.parseJSON(response);
			if( res.status == "1" ){
				progressbar.attr('aria-valuenow', 100);
				progressbar.css('width',"100%");
				progressbar.text("100%"); 
				var img_count = res.imageURL.length;
				var imgs = res.imageURL;
				for(var i = 0; i< img_count; i++) {
					var src = imgs[i];
					var fname = src.substring(src.lastIndexOf('/') + 1);
					var img_name = fname.split('.').slice(0, -1).join('.');
					var html = '<div class="dynamic_images">'+
									'<div class="img_div" style="position:relative;margin:10px">'+
										'<img class="recording_multi_img" src="'+src+'"/>'+
										'<button type="button" data-img_name="'+fname+'" class="btn_danger_state trash_recording_img delete_multi_img" style="position:absolute;right:0;"><i class="'+trash_icon+'" aria-hidden="true"></i></button>'+
									'</div>'+
								'</div>';		
					jQuery('.img_list').append( html );
				} 
				/* TrashRecordingMultiImg();  */
				jQuery('.recording_multi_img').attr('data-uploaded',"1");
				jQuery('.recording_multi_img').show();  
				jQuery('.recording_images_upload_status').css({'color':'#34a853','font-weight': '600'});
				jQuery(".recording_images_upload_status").html(res.msg);
			}else{
				progressbar.attr('aria-valuenow', 0);
				progressbar.css('width',"0%");
				progressbar.text("0%");
				jQuery('.alert_box').html(res.msg);
				jQuery('.alert_box').show();
				setTimeout(function(){
						jQuery('.alert_box').hide();
				},3000);
				jQuery('.recording_images_upload_status').css({'color':'#F44336','font-weight': '600'});
				jQuery(".recording_images_upload_status").html(res.msg);
			} 
		},
		error: function (xhr, ajaxOptions, thrownError) {
			if(xhr.status == 413){
				progressbar.attr('aria-valuenow', 0);
				progressbar.css('width',"0%");
				progressbar.text("0%");
				jQuery('.recording_images_upload_status').css({'color':'#F44336','font-weight': '600'});
				jQuery('.recording_images_upload_status').html('Image size is too large');
			}
		} 
	}); 
	progress.show(); 
});

jQuery(document).on('click','.delete_multi_img',function(){
	jQuery('.lp-screen').show();
	var img_name = jQuery(this).data('img_name');
	jQuery(this).parent().parent().remove();
	var rec_id = jQuery('#recording_id').val();
	var post_data = {'recording_id':rec_id,'img_name':img_name, action:'DeleteRecordingMultipleImage'};
	jQuery.ajax({					
		url  : recording_ob.ajax_url,
		type : 'POST',
		data : post_data,
		dataType : 'html',						
		success  : function(response) {
			/* if (!jQuery(this).hasClass('.dynamic_images')) {
				var progressbar = jQuery('#recording_images_progress');
				progressbar.attr('aria-valuenow', 0);
				progressbar.css('width',"0%");
				progressbar.text("0%");
			} */
			/* jQuery('.dynamic_'+img_name).remove();
			jQuery('.alert_box').show();
			setTimeout(function(){
				jQuery('.alert_box').hide();
			},3000);
			jQuery('.lp-screen').hide(); */
			jQuery('.lp-screen').hide();
		}
	});
});

jQuery(document).on('click','.edittitlebtn',function(){
	jQuery('.fliptitlefielddiv').show();
	jQuery('.flipsubtitlefielddiv').show();
	jQuery('.fliptitleprevdiv').hide();
	jQuery('.flipsubtitleprevdiv').hide();
});
jQuery(document).on('click','.editrestitlebtn',function(){
	jQuery('.fliprestitlefielddiv').show();
	jQuery('.flipressubtitlefielddiv').show();
	jQuery('.fliprestitleprevdiv').hide();
	jQuery('.flipressubtitleprevdiv').hide();
});

jQuery(document).mouseup(function(e) 
{
    var container = jQuery(".flipsubtitlefielddiv");
    var container2 = jQuery(".fliptitlefielddiv");

    // if the target of the click isn't the container nor a descendant of the container
    if ((!container.is(e.target) && container.has(e.target).length === 0) && (!container2.is(e.target) && container2.has(e.target).length === 0)) 
    {
        container.hide();
        container2.hide();
		
		var title = jQuery(".fliprectitle").val();
		var subtitle = jQuery(".fliprecsubtit").val();
		jQuery('.fliptitleprevdivspan').html(title);
		jQuery('.flipsubtitleprevdiv').html(subtitle);
		
		jQuery('.fliptitleprevdiv').show();
		jQuery('.flipsubtitleprevdiv').show();
    }
	
	var restitle = jQuery(".fliprestitlefielddiv");
    var ressubtitle = jQuery(".flipressubtitlefielddiv");
	if ((!restitle.is(e.target) && restitle.has(e.target).length === 0) && (!ressubtitle.is(e.target) && ressubtitle.has(e.target).length === 0)) {
        restitle.hide();
        ressubtitle.hide();
		
		var resrectitle = jQuery(".flipresrectitle").val();
		var resrecsubtitle = jQuery(".flipresrecsubtitle").val();
		jQuery('.fliprestitleprevdivspan').html(resrectitle);
		jQuery('.flipressubtitleprevdiv').html(resrecsubtitle);
		
		jQuery('.fliprestitleprevdiv').show();
		jQuery('.flipressubtitleprevdiv').show();
    }
});

jQuery(document).on('click','.fliprec_cancel',function(){
	jQuery('.lp-screen').show();
	var recording_id = jQuery( '#recording_id' ).val();
	var recreturnurl = jQuery( '.recreturnurl' ).val();
	var mode = jQuery('#mode').val();
	var post_data = {'recid':recording_id,'mode':mode,'action':'CancelReturnstate'};
	jQuery.ajax({
		url  : recording_ob.ajax_url,	
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			if( jQuery('#parentfliplistid').val() != undefined && jQuery('#parentfliplistid').val() != '' ){
				jQuery('.backtoplay').trigger('click');
			}else{
				window.location.href = recreturnurl;
				jQuery('.lp-screen').hide();
			}
		}
	});
});


jQuery(document).on('click','.replies_chk',function(){
	var checked = jQuery(this).prop('checked');
	
	if( checked == true ){
		jQuery('.repliesvis_text_clr').css('color','#000');
		jQuery('#replies_visiblility_chk').removeAttr('disabled','disabled');
		jQuery('.fliprecsetreplies').html('ON');
	}
	if( checked ==  false ){
		jQuery('.repliesvis_text_clr').css('color','#CCC');
		jQuery('.fliprecsetreplies').html('OFF');
		jQuery('.fliprecsetrest').html('Restricted');
		jQuery('#replies_visiblility_chk').attr('disabled','disabled');
		jQuery('#replies_visiblility_chk').prop('checked',false);
		jQuery('#replies_visiblility_chk').parent().find('.off').show();
		jQuery('#replies_visiblility_chk').parent().find('.on').hide();
	}
});
jQuery(document).on('click','.replies_visiblility_chk',function(){
	if(jQuery(this).is(':checked')){
		jQuery('.fliprecsetrest').html('Open');
	}else{
		jQuery('.fliprecsetrest').html('Restricted');
	}
});