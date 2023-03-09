jQuery(document).ready(function(){
	
	if( jQuery('.fliplist_title').length > 0 ){
		/* fliplist title */
		var maxLength = 80;
		var length = jQuery('.fliplist_title').val().length;
		var length = maxLength-length;
		jQuery('#fliplist_title_chars').text(length);
		jQuery('.fliplist_title').keyup(function(){
			var maxLength = 80;
			var length = jQuery(this).val().length;
			var length = maxLength-length;
			jQuery('#fliplist_title_chars').text(length);
		});

		/* fliplist subtitle */
		var maxLength = 80;
		var length = jQuery('.fliplist_subtitle').val().length;
		var length = maxLength-length;
		jQuery('#fliplist_subtitle_chars').text(length);
		jQuery('.fliplist_subtitle').keyup(function(){
			var maxLength = 80;
			var length = jQuery(this).val().length;
			var length = maxLength-length;
			jQuery('#fliplist_subtitle_chars').text(length);
		});
		
		/* fliplist description */
		var maxLength = 800;
		var length = jQuery('.fliplist_description').val().length;
		var length = maxLength-length;
		jQuery('#fliplist_description_chars').text(length);
		jQuery('.fliplist_description').keyup(function(){
			var maxLength = 800;
			var length = jQuery(this).val().length;
			var length = maxLength-length;
			jQuery('#fliplist_description_chars').text(length);
		});
	}
	/* popover for tips formatting */
	jQuery(function(){
		jQuery("#formatting-popover").popover({
			html : true, 
			content: function() {
			  return jQuery("#formatting-popover-content").html();
			},
			title: function() {
			  return jQuery("#formatting-popover-title").html();
			}
		});
	});
	
	/* popover for 'Attach this Fl1plist' text */
	jQuery("#fliplist-popover").popover({
		html : true, 
		content: function() {
		  return jQuery("#fliplist-popover-content").html();
		},
		title: function() {
		  return jQuery("#fliplist-popover-title").html();
		}
	});

});

jQuery(document).on('click','#fliprec_crop_image_btn,.fliprec_cropping_close',function(e){
	jQuery('#fliprecthumbnailmodal').modal('hide');
	jQuery('#flipsettingmodal').modal('show');
});
jQuery(document).on('change','.fliprecording_thumbnail',function(e){
	e.stopImmediatePropagation();
	var files = e.target.files;
	filename = files[0].name;
	var ext = filename.split('.').pop().toLowerCase();
	if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
		jQuery('.alert_box').html("Please Choose PNG/JPG/JPEG file.");
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('.alert_box').hide();
		},3000);
		return false;
	}
	
	jQuery('#flipsettingmodal').modal('hide');

	var done = function (url) {
	  document.getElementById('tofliprecimage').src = url;
	  jQuery('#fliprecthumbnailmodal').modal({backdrop:'static', keyboard:false});
	};
	var url;
	if (files && files.length > 0) {
	  done(URL.createObjectURL(files[0]));
	}else{
		jQuery('.tofliprecimage').attr('src','');
		jQuery('.tofliprecimage').hide();
	}
});

/* Crop Fliplist Thumbnail JS */
function CropFliplistThumbnail(){
	window.addEventListener('DOMContentLoaded', function () {
	  var avatar = document.getElementById('blah');
	  var image = document.getElementById('image');
	  var input = document.getElementById('fliplist_thumbnail');
	  var $progress = $('.progress');
	  var $progressBar = $('.progress-bar');
	  var $alert = $('.alert');
	  var $modal = $('#modal');
	  var cropper;
	  var filename='';
	  $('[data-toggle="tooltip"]').tooltip();

	  input.addEventListener('change', function (e) {
			var files = e.target.files;
			filename = files[0].name;
			var ext = filename.split('.').pop().toLowerCase();
			if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
				jQuery('.alert_box').html("Please Choose PNG/JPG/JPEG file.");
				jQuery('.alert_box').show();
				setTimeout(function(){
					jQuery('.alert_box').hide();
				},3000);
				return false;
			}
			var done = function (url) {
			  image.src = url;
			  $alert.hide();
			  $modal.modal({backdrop:'static', keyboard:false});
			};
			var reader;
			var file;
			var url;
			if (files && files.length > 0) {
			  file = files[0];
			  if (URL) {
				done(URL.createObjectURL(file));
			  } else if (FileReader) {
				reader = new FileReader();
				reader.onload = function (e) {
				  done(reader.result);
				};
				reader.readAsDataURL(file);
			  }
			}else{
				jQuery('.fliplist_img').attr('src','');
				jQuery('.fliplist_img').hide();
				jQuery('.crop_img_fliplist').css({'width':'280px','height': '170px'});
				jQuery('#blah').attr('src',jQuery('#blah_img').val());
			}
	  });

	  $modal.on('shown.bs.modal', function () {
		cropper = new Cropper(image, {
		  aspectRatio: 16 / 9,
		  viewMode: 3, 
		});
	  }).on('hidden.bs.modal', function () {
		cropper.destroy();
		cropper = null;
	  });
	  
	  document.getElementById('fliplist_crop_image_btn').addEventListener('click', function () {
		var canvas;
		$modal.modal('hide');
		if (cropper) {
			canvas = cropper.getCroppedCanvas();
			var fliplist_id = jQuery('#fliplist_id').val();
			var thumb = jQuery('#fliplist_thumbnail')[0].files[0];
			var mode = jQuery('#mode').val();
			var fd = new FormData();      
			fd.append('fliplist_id',fliplist_id);
			fd.append('thumb',thumb);
			fd.append('mode',mode);
			fd.append('dataurl',canvas.toDataURL());
			fd.append('action','UploadFliplistThumbnail');  
			var progressbar = jQuery('#fliplist_thumb_progress');
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
					clearInterval(timer);
					progressbar.attr('aria-valuenow', 100);
					progressbar.css('width',"100%");
					progressbar.text("100%");
					var res = jQuery.parseJSON(response);
					if( res.status == "1" ){
						jQuery('.fliplist_img').attr('src',res.imageURL);
						jQuery('.fliplist_img').attr('data-uploaded',"1");
						jQuery('.fliplist_img').show();  
						jQuery('.fliplist_thumb_upload_status').css({'color':'#09980f !important','font-weight': '600','margin-right':'115px'});
						jQuery(".fliplist_thumb_upload_status").html(res.msg);
						var editicon = jQuery('.fliplistediticon').val();
						jQuery('.fliplistthumbdiv').append('<div class="btn_normal_state fliplistthumbedit"><i class="'+editicon+'"></i></div>');
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
						jQuery('.'+imgCrop+' .fliplist_img').css('display','none');
						progressbar.attr('aria-valuenow', 0);
						progressbar.css('width',"0%");
						progressbar.text("0%");
						jQuery('.'+imgCrop+' .fliplist_thumb_upload_status').css({'color':'red','font-weight': '600'});
						jQuery('.'+imgCrop+' .fliplist_thumb_upload_status').html('Image size is too large');
					}
				}
			}); 
		  $progress.show();
		  $alert.removeClass('alert-success alert-warning');
		  canvas.toBlob(function (blob) {

		  });
		}
	  });
	});
}

jQuery(document).on('click','.status_draft',function(e){
	jQuery('#fliplist_save_status').val('draft');
});

jQuery(document).on('click','.status_publish',function(e){
	jQuery('#fliplist_save_status').val('publish');
});

/* click event for fliplist status not store as draft  */
jQuery(document).on('click','.btn_draft_popup_cancel',function(){
	jQuery('.alert_box_draft_popup').hide();
	jQuery('#fliplist_darft_info').val('save_as_draft_no');
});

/* click event for fliplist status store as draft  */
jQuery(document).on('click','.btn_draft_popup_yes',function(){
	jQuery('#fliplist_darft_info').val('save_as_draft_yes');
	jQuery('.alert_box_draft_popup').hide();
	jQuery("#save_fliplist_form").trigger( "submit" );
});

/* Save Fliplist JS */
jQuery(document).on('submit','#save_fliplist_form',function(e){
	e.preventDefault();
	var fliplist_title = jQuery('#fliplist_title').val();
	var fliplist_description = jQuery('#fliplist_description').val();
	var status = jQuery('#fliplist_save_status').val(); 
	
	if(jQuery('.fliplist_title').val()==''){	
		jQuery('.alert_box').html('Fl1plist title is a required field.');
		jQuery('.alert_box').show();
		setTimeout(function(){
				jQuery('.alert_box').hide();
		},3000);
		return false;	
	}
	if(jQuery('.fliplist_description').val()==''){	
		jQuery('.alert_box').html('Fl1plist description is a required field.');
		jQuery('.alert_box').show();
		setTimeout(function(){
				jQuery('.alert_box').hide();
		},3000);
		return false;	
	}
	
	if( jQuery('#mode').val() == "edit" && status == 'draft' && jQuery('#fliplist_darft_info').val() != 'save_as_draft_yes' && jQuery('#fliplist_oldstatus').val() != 'draft' ){
		jQuery('.alert_box').addClass('alert_box_draft_popup');
		jQuery('.alert_box').html('<div>This will cause all items (Sub-Communities, Courses, and Lessons) to go into Draft mode.  Are you ok with this?</div><div class="draft_popup_btn_main_class"><button class="btn_normal_state btn_draft_popup_yes" data-dismiss="modal" aria-label="Close">Yes</button><button class="btn_dark_state btn_draft_popup_cancel" data-dismiss="modal" aria-label="Close">Cancel</button></div>');
		jQuery('.alert_box').show();
		$alert = jQuery('.alert_box');
		$alert.modal({backdrop:'static', keyboard:false});
		return false;
	}
	
	var fd = new FormData(this);  
	fd.append("fliplist_save_status",status); 
	fd.append("action",'SaveFliplistData'); 
	jQuery('.lp-screen').show(); 

	jQuery.ajax({
		url: ajax_ob.ajax_url,
		type:'POST',
		data: fd,
		contentType: false,
		processData: false,
		success: function(response) {
			console.log(response);
			var res = jQuery.parseJSON(response);
			if( res.msg == 'exist' ){
				jQuery('.alert_box').html('Title already exists');
				jQuery('.alert_box').show();
				setTimeout(function(){
					jQuery('#fliplist_title').focus();
					jQuery('.alert_box').hide();
				},3000);
				jQuery('.lp-screen').hide(); 
			}else if( res.msg == 'inserted' ){
				jQuery('.lp-screen').hide(); 
				window.location.href = res.link;
			}else if( res.msg == 'updated' ){
				jQuery('.lp-screen').hide(); 
				window.location.href = res.link;
			}     
		}
	});
});

/* Click Event For Fliplist Back Link */
jQuery(document).on('click','.btn_cancel_fliplist',function(e){
	e.preventDefault();
	jQuery('.lp-screen').show();
	var mode = jQuery('#mode').val();
	/* if( mode == 'add' ){ */
		var fliplist_id = jQuery('#fliplist_id').val();
		var post_data = {'fliplist_id':fliplist_id,'mode':mode,'action':'DeleteFliplistThumbnail'};
		jQuery.ajax({
			url  : ajax_ob.ajax_url,	
			type: 'POST',
			data: post_data,
			dataType: 'html',						
			success : function(response) {
				jQuery('.lp-screen').hide();
				window.location.href = jQuery('.hidden_back_link_fliplist').val();
			}
		});
	/* }else{
		window.location.href = jQuery('.hidden_back_link_fliplist').val();
	}  */
});

jQuery(document).on('click','.delete_fliplist',function(e){
	e.stopImmediatePropagation();
	jQuery('.lp-screen').show();
	var fliplistid = jQuery(this).data('fliplist');
	var recid = jQuery(this).data('recid');
	var post_data = {'fliplistid':fliplistid,'recid':recid,'action':'DeleteMainFlipRecording'};
	jQuery.ajax({
		url  : ajax_ob.ajax_url,	
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success : function(response) {
			jQuery('.lp-screen').hide();
			location.reload();
		}
	});
});

jQuery(document).on('click','.nextreplies,.previousreplies',function(e){
	e.stopImmediatePropagation();
	jQuery('.lp-screen').show();
	var parentfliplistid = jQuery('.parent_fliplistid').val();
	if( jQuery(this).data('click') == 'previous' ){
		var repliesid = jQuery(this).parent().parent().parent().prev('.repliesnavigatordiv').data('replyid');
	}
	if( jQuery(this).data('click') == 'next' ){
		var repliesid = jQuery(this).parent().parent().parent().next('.repliesnavigatordiv').data('replyid');
	}
	var parentrecid = jQuery('.parent_recid').val();
	var post_data = {'repliesid':repliesid,'parentrecid':parentrecid,'parentfliplistid':parentfliplistid,'repliesid':repliesid,'action':'Recordingloadreplies'};
	
	jQuery.ajax({
		url  : ajax_ob.ajax_url,	
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success : function(response) {
			jQuery('.Playinnersection').html( response );
			jQuery('.lp-screen').hide();
		}
	});
	/* alert(repliesid); */
	/* console.log(repliesid); */
});

jQuery(document).on('click','.view_response_btn',function(e){
	e.stopImmediatePropagation();
	jQuery(this).css({'background-color':'#FFFFFF','color':'#000000','border-top-left-radius':'15px','border-top-right-radius':'15px'}); 
	jQuery('.repliesnavigatordiv').attr("hidden",false);
	jQuery('.fliprecording_response_edit_div').attr("hidden",false);
	if( jQuery(window).width() <=767 ) {
		if( jQuery('.total_recresponses').val() !=0 ){
			jQuery('.fliprecord_content').css('height','calc(100vh - 300px)');
			/* jQuery('.replies_btns_main').css('margin-top','-73px'); */
			/* jQuery('.fliprecording_response_edit_div').css({'margin-top':'-146px','margin-left':'20px','margin-right': '18px'}); */
		}
	} 
	
	var replyid = '';
	jQuery('.repliesnavigatordiv').each(function(){
		if( jQuery(this).hasClass('active')){
			replyid = jQuery(this).data('replyid');
			jQuery(this).show();
		}
	});
	jQuery('.fliprecording_response_edit_div').show();
	jQuery('.hidrepliesid').val( replyid );
	
	if( jQuery('.repliesnavigatordiv').length > 0 ){
		var parentfliplistid = jQuery('.parent_fliplistid').val();
		var repliesid = jQuery('.repliesnavigatordiv').first().data('replyid');
		var parentrecid = jQuery('.parent_recid').val();
		var post_data = {'repliesid':repliesid,'parentrecid':parentrecid,'parentfliplistid':parentfliplistid,'repliesid':repliesid,'action':'Recordingloadreplies'};
		jQuery('.lp-screen').show();
		jQuery.ajax({
			url  : ajax_ob.ajax_url,	
			type: 'POST',
			data: post_data,
			dataType: 'html',						
			success : function(response) {
				jQuery('.Playinnersection').html( response );
				jQuery('.lp-screen').hide();
			}
		});
	}
});