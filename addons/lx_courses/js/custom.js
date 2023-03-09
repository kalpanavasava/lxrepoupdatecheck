
URL = window.URL || window.webkitURL;

var gumStream; 						/* //stream from getUserMedia() */
var rec; 							/* //Recorder.js object */
var input; 						/* 	//MediaStreamAudioSourceNode we'll be recording */


var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext 

var recordButton = document.getElementById("recordButton");
var stopButton = document.getElementById("stopButton");
var pauseButton = document.getElementById("pauseButton");

recordButton.addEventListener("click", startRecording);
stopButton.addEventListener("click", stopRecording);
pauseButton.addEventListener("click", pauseRecording);

/* function for downsampleBuffer */
function downsampleBuffer(buffer, rate) {
    if (rate == sampleRate) {
        return buffer;
    }
    if (rate > sampleRate) {
        throw "downsampling rate show be smaller than original sample rate";
    }
    var sampleRateRatio = sampleRate / rate;
    var newLength = Math.round(buffer.length / sampleRateRatio);
    var result = new Float32Array(newLength);
    var offsetResult = 0;
    var offsetBuffer = 0;
    while (offsetResult < result.length) {
        var nextOffsetBuffer = Math.round((offsetResult + 1) * sampleRateRatio);
        var accum = 0, count = 0;
        for (var i = offsetBuffer; i < nextOffsetBuffer && i < buffer.length; i++) {
            accum += buffer[i];
            count++;
        }
        result[offsetResult] = accum / count;
        offsetResult++;
        offsetBuffer = nextOffsetBuffer;
    }
    return result;
}

function startRecording() {
	
    var constraints = { audio: true, video:false }
	
	recordButton.disabled = true;
	stopButton.disabled = false;
	pauseButton.disabled = false

	navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
		
		audioContext = new AudioContext();

		
		/*  assign to gumStream for later use  */
		gumStream = stream;
		
		/* use the stream */
		input = audioContext.createMediaStreamSource(stream);

		/* 
			Create the Recorder object and configure to record mono sound (1 channel)
			Recording 2 channels  will double the file size
		*/
		rec = new Recorder(input,{numChannels:1, sampleRate: 96000});

		/* start the recording process */
		rec.record()

		/* console.log("Recording started"); */

	}).catch(function(err) {
	  	/* enable the record button if getUserMedia() fails */
		alert('You have some problem in your micro phone');
		/* jQuery('.refresh').trigger('click');  */
		jQuery('.recordButton').show();
		jQuery('.refresh').hide();
		jQuery('.stopButton').hide();
		jQuery('.pauseButton').hide();
    	recordButton.disabled = false;
    	stopButton.disabled = true;
    	pauseButton.disabled = true
	});
}

function pauseRecording(){
			
	if (rec.recording){
		/* pause */
		rec.stop();
		pauseButton.innerHTML='<i class="fa fa-circle"></i> Continue';
	}else{
		
		rec.record()
		pauseButton.innerHTML='<i class="fa fa-pause" aria-hidden="true"></i> Pause';

	}
}

function stopRecording() {
	/* console.log("stopButton clicked"); */

	/* disable the stop button, enable the record too allow for new recordings */
	stopButton.disabled = true;
	recordButton.disabled = false;
	pauseButton.disabled = true;

	/* reset button just in case the recording is stopped while paused */
	pauseButton.innerHTML="Pause";
	
	/* tell the recorder to stop the recording */
	rec.stop();

	/* stop microphone access */
	gumStream.getAudioTracks()[0].stop();
	rec.exportWAV(createDownloadLink);
}


function createDownloadLink(blob) {
	/* jQuery('#fl1p_form_saveflip').unwrap(); */
	var url = URL.createObjectURL(blob);
	var au = document.createElement('audio');
	var li = document.createElement('li');
	var link = document.createElement('a');

	var d = new Date();/* .toISOString(); */
	
	var month = d.getMonth()+1;
	var day = d.getDate();

	var output = d.getFullYear() + 
		(month<10 ? '0' : '') + month + 
		(day<10 ? '0' : '') + day;
	var filename = "audio"+output+d.getHours() + d.getMinutes() + d.getSeconds()+".wav";
	au.controls = true;
	au.src = url;
	li.appendChild(au);
	
	/* upload link */
	 var upload = document.createElement("BUTTON");
	  var att = document.createAttribute("class");
	  var att2 = document.createAttribute("id");
	  att.value = "btn btn-default uploading_wav_file";
	  att2.value="uploading_wav_file";
	  upload.setAttributeNode(att);
	  upload.setAttributeNode(att2);
	  upload.innerHTML = '<i class="fa fa-save" aria-hidden="true"></i> Save';
	  jQuery('.lp-screen').show();
	  var post_data = {
			'url':url,
			'action':"get_blob"
			};
	  jQuery.ajax({					
			url  : my_ajax.ajax_object,	
			type: 'POST',
			data: post_data,
			dataType:'html',
			success  : function(response) {
				jQuery('.audio_blob').html(response);
				jQuery('.lp-screen').hide();
			}
		});
		
	
	upload.addEventListener("click", function(event){
		jQuery('.lp-screen').show();
		var xhr=new XMLHttpRequest();
		xhr.onload=function(e) {
			if(this.readyState === 4) {
				if(e.target.responseText.trim() == 'updated'){
					if(jQuery('.hid_edit_flip_action').val()=='edit_response')
					{
						var flip_id=jQuery('#hid_edit_res_flip_id').val();
						location.reload();		
					}
				}else if(e.target.responseText.trim() == 'responded'){
					var flip_id=jQuery('.hid_edit_flip_id').val();
					jQuery('.con-playpause').trigger('click');
					location.reload();
				}
			}
		};
		
		var uploaded_audio_file = jQuery('.topic_audio_upload')[0].files[0];
		var flip_title = jQuery('.add_flip_title').val();
		var flip_description = jQuery('.add_flip_discription').val();
		var fd=new FormData();
		fd.append('flip_title',flip_title);
		if(jQuery('.hid_edit_flip_action').val()=='edit_response')
		{
			fd.append('podcast_id',jQuery('#hid_edit_podcast_id').val());
			fd.append('flip_id',jQuery('#hid_edit_res_flip_id').val());
			fd.append('response_id',jQuery('#hid_edit_flip_id_reply').val());
		}
		if(jQuery('.hid_edit_flip_action').val() == 'responder' || jQuery('.hid_edit_flip_action').val()=='edit_response'){
			fd.append('type','response');	
		}
		fd.append("uploaded_audio_file",uploaded_audio_file);
		fd.append('insert_id',jQuery('#insert_id').val());
		fd.append("audio_data",blob, filename);
		fd.append("user_id",current_user.user_id);
		fd.append("flip_description",flip_description);
		fd.append("course_link",jQuery('#course_link').val());
		fd.append("course_title",jQuery('#course_title').val());
		fd.append("lesson_link",jQuery('#lesson_link').val());
		fd.append("lesson_title",jQuery('#lesson_title').val());
		fd.append("hid_edit_flip_id",jQuery('.hid_edit_flip_id').val());
		fd.append("hid_edit_flip_action",jQuery('.hid_edit_flip_action').val());
		fd.append("action",'save_media');
		xhr.open("POST", my_ajax.ajax_object,true);
		xhr.send(fd);
	});
	
	li.appendChild(document.createTextNode (" "));
	jQuery('.save_flip_div').html(upload);
	jQuery('.save_flip_div').prepend("<button type='button' onclick='go_back();' class='btn btn-primary flip_back_linkk' id='' name=''>Cancel</button>&nbsp;");
	recordingsList.appendChild(li);
}

/* submit event for form flip */
jQuery(document).on('submit','#form_flip_id',function(e){
	e.preventDefault();
	
	var fd = new FormData(this);
	fd.append('insert_id',jQuery('#insert_id').val());
	jQuery('.lp-screen').show();
	
	var uploaded_audio_file = jQuery('.topic_audio_upload')[0].files[0];
    var flip_title = jQuery('.add_flip_title').val();
    var flip_description = jQuery('.add_flip_discription').val();
	fd.append('flip_title',flip_title);
	fd.append("user_id",current_user.user_id);
	fd.append("flip_description",flip_description);
		 
	if(jQuery('.hid_edit_flip_id_reply').val() !== '' && jQuery('.hid_edit_flip_id_reply').val() !== undefined){
	  fd.append("hid_edit_flip_id_reply",jQuery('.hid_edit_flip_id_reply').val());
	}
	  
	if(jQuery('#topic_audio_upload').attr('data-value')!='')
	{
	fd.append("uploaded_audio_file",jQuery('#topic_audio_upload').attr('data-value'));
	}
		  
	
	if(jQuery('.hid_edit_flip_action').val() == 'responder' || jQuery('.hid_edit_flip_action').val()=='edit_response'){
		fd.append('type','response');
	}
	fd.append("course_link",jQuery('#course_link').val());
	fd.append("course_title",jQuery('#course_title').val());
	fd.append("lesson_link",jQuery('#lesson_link').val());
	fd.append("lesson_title",jQuery('#lesson_title').val());
	fd.append("hid_edit_flip_id",jQuery('.hid_edit_flip_id').val());
	fd.append("hid_edit_flip_action",jQuery('.hid_edit_flip_action').val());
	fd.append("action",'save_media');
	jQuery.ajax({					
			url  : my_ajax.ajax_object,	
			type: 'POST',
			data: fd,
			contentType: false,
			processData: false,						
			success  : function(response) {
				if(jQuery.trim(response) == 'record_empty'){
					jQuery('.error_flip_recorder').show();
					jQuery('.lp-screen').hide();
				}
				if(jQuery.trim(response)=='updated'){
					if(jQuery('.hid_edit_flip_action').val()=='edit_response')
					{
						location.reload();
					}
				}
				if(jQuery.trim(response) == 'responded'){
					location.reload();
				 }
				
			}
		});
});
jQuery(document).ready(function() {	
	if (window.File && window.FileList && window.FileReader) {
		jQuery("#add_flip_mul_image").on("change", function(e) {
			e.preventDefault();
			if(jQuery('#add_flipto_podcast').val()==0 && (jQuery('.hid_edit_flip_action').val()=="edit" || jQuery('.hid_edit_flip_action').val()=="add")){
				alert("Please Select Associated Forum before Upload images..!");
				jQuery("#add_flip_mul_image").val('');	
			}
			else{
				var files = e.target.files,	
				filesLength = files.length;
				for (var i = 0; i < filesLength; i++) {
					var f = files[i]
					var fileReader = new FileReader();
					fileReader.onload = (function(e) {
						var file = e.target;
						 jQuery("<span class=\"pip\">" +
						"<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
						"</span>").insertAfter(".dropzone_multiple");
						 
					});
					fileReader.readAsDataURL(f);
				}
				var totalfiles = document.getElementById('add_flip_mul_image').files.length;
				var fd=new FormData();
				for (var index = 0; index < totalfiles; index++) {
					fd.append("flip_mul_image[]", document.getElementById('add_flip_mul_image').files[index]);
				}
				
				var edit_id=jQuery('.hid_edit_flip_id').val();
				var counter = 0;
				var pb=jQuery('.mul_img_status');
				var interval = setInterval(function() {
					counter  = counter+10;
					/* Display 'counter' wherever you want to display it. */
					if (counter > 100) {
						
					}else{
						pb.attr('aria-valuenow', counter);
						pb.css('width', counter + '%');
						pb.text(counter + '%');
					}
				}, 45 * 1000 / 100);
				jQuery('#mul_upload_status').hide();
				if(jQuery('.hid_edit_flip_action').val()=="edit_response")
				{
					fd.append('mode','edit');
					fd.append('type','response');
					fd.append('podcast_id',jQuery('#hid_edit_podcast_id').val());
					fd.append('edit_id',jQuery('#hid_edit_res_flip_id').val());
					fd.append('insert_id',jQuery('#hid_edit_flip_id_reply').val());
					fd.append("action",'upload_mul_image');
					jQuery.ajax({	
						url  : my_ajax.ajax_object,	
						type: 'POST',
						data: fd,
						contentType: false,
						processData: false,
						success:function(response){
							jQuery('#mul_upload_status').show();
							jQuery('#mul_upload_status').html(response);
							console.log('Multiple image Updated..!');
						}
					});
				}
				else if(jQuery('.hid_edit_flip_action').val()=="responder")
				{
					fd.append('mode','add');
					fd.append('type','response');
					fd.append('podcast_id',jQuery('#hid_edit_podcast_id').val());
					fd.append('insert_id',jQuery('#insert_id').val());
					fd.append("edit_id",edit_id);
					fd.append("action",'upload_mul_image');
					jQuery.ajax({	
						url  :  my_ajax.ajax_object,	
						type: 'POST',
						data: fd,
						contentType: false,
						processData: false,
						success:function(response){
							jQuery('#mul_upload_status').show();
							jQuery('#mul_upload_status').html(response);
							console.log('Multiple image Updated..!');
						}
					});
				}
			}
			
		});
	}	
	else {
		alert("Your browser doesn't support to File API")
	}
});

/* change event for topic audio upload */
jQuery("#topic_audio_upload").on('change',function(e){
	e.preventDefault();
	if(jQuery('#add_flipto_podcast').val()==0 && (jQuery('.hid_edit_flip_action').val()=="edit" || jQuery('.hid_edit_flip_action').val()=="add")){
		alert("Please Select Associated Forum before Upload Audio..!");	
		jQuery('#topic_audio_upload').val('');
	}
	else{
		var files=e.target.files;
		var length=files.length;
		var filename=files[0].name;
		var extension = filename.substr( (filename.lastIndexOf('.') +1) );
		if(extension=="mp3" || extension=="wav" || extension=="ogg" || extension=="aac" || extension=="pcm" || extension=="aiff" || extension=="wma" || extension=="flac" || extension=="alac")
		{
			var fd=new FormData();
			var counter = 0;
			var pb=jQuery('.audio_upload');
			jQuery('#audio_upload_status').hide();
			var interval = setInterval(function() {
				counter  = counter+10;
				/* Display 'counter' wherever you want to display it. */
				if (counter > 100) {
					
				}else{
					pb.attr('aria-valuenow', counter);
					pb.css('width', counter + '%');
					pb.text(counter + '%');
				}
			}, 45 * 1000 / 100);
			fd.append("topic_audio_upload", document.getElementById('topic_audio_upload').files[0]);
			var edit_id=jQuery('.hid_edit_flip_id').val();
			if(jQuery('.hid_edit_flip_action').val()=="edit_response")
			{
				fd.append('mode','edit');
				fd.append('type','response');
				fd.append('podcast_id',jQuery('#hid_edit_podcast_id').val());
				fd.append('edit_id',jQuery('#hid_edit_res_flip_id').val());
				fd.append('insert_id',jQuery('#hid_edit_flip_id_reply').val());
				fd.append("action",'upload_audio_file');
				jQuery.ajax({	
					url  : my_ajax.ajax_object,	
					type: 'POST',
					data: fd,
					contentType: false,
					processData: false,	
					success:function(response){
						jQuery('#topic_audio_upload').attr('data-value',response);
						jQuery('#audio_upload_status').show();	
						jQuery('#audio_upload_status').html(response);		
					}
				});

			}
			else if(jQuery('.hid_edit_flip_action').val()=="responder")
			{
				fd.append('mode','add');
				fd.append('type','response');
				fd.append('podcast_id',jQuery('#hid_edit_podcast_id').val());
				fd.append('insert_id',jQuery('#insert_id').val());
				fd.append("edit_id",edit_id);
				fd.append("action",'upload_audio_file');
				jQuery.ajax({	
					url  : my_ajax.ajax_object,	
					type: 'POST',
					data: fd,
					contentType: false,
					processData: false,
					success:function(response){
						jQuery('#audio_upload_status').show();
						jQuery('#topic_audio_upload').attr('data-value',response);
						jQuery('#audio_upload_status').html('Uploaded');
					}
				});
			}
		}
		else{
			console.log(extension);
			alert("File Type Must be Audio..!");
			jQuery('.audio_upload').width(0);
			jQuery('#topic_audio_upload').attr('data-value','');
			jQuery(this).val('');
			return false;
		}
	}
});

/* change event for topic attachment1 */
jQuery('#topic_attachment1').on("change",function(e){
	if(jQuery('#add_flipto_podcast').val()==0 && (jQuery('.hid_edit_flip_action').val()=="edit" || jQuery('.hid_edit_flip_action').val()=="add")){
			alert("Please Select Associated Forum before Upload Attachment..!");	
			jQuery('#topic_attachment1').val('');
	}
    else{
		var files=e.target.files;
		var length=files.length;
		var filesize=files[0].size;
		var filename=files[0].name;
		var extension = filename.substr( (filename.lastIndexOf('.') +1) );
		
		if(extension !="pdf")
		{
			alert("File Type Must be PDF..!");
			jQuery(this).val('');
			
			return false;
		}
		else if(filesize>3145728)
		{
			alert('File size is Greater  then 3MB..!');
			jQuery(this).val('');
			jQuery('.attachment_status1').width(0);
			return false;
		}
		else{
			var fd=new FormData();
			jQuery('#attach_upload_status1').hide();
			var counter = 0;
			var pb=jQuery('.attachment_status1');
			var interval = setInterval(function() {
				counter  = counter+10;
				/* Display 'counter' wherever you want to display it. */
				if (counter > 100) {
					
				}else{
					pb.attr('aria-valuenow', counter);
					pb.css('width', counter + '%');
					pb.text(counter + '%');
				}
			}, 45 * 1000 / 100);
			fd.append('attach_no','1');
			fd.append("flip_topic_attachment", document.getElementById('topic_attachment1').files[0]);
			if(jQuery('.hid_edit_flip_action').val()=="edit_response"){
				fd.append('mode','edit');
				fd.append('type','response');
				fd.append('podcast_id',jQuery('#hid_edit_podcast_id').val());
				fd.append('edit_id',jQuery('#hid_edit_res_flip_id').val());
				fd.append('insert_id',jQuery('#hid_edit_flip_id_reply').val());
				fd.append('flip_mul_attach',jQuery('#hid_edit_attachament1').data('id'));
				fd.append("action",'upload_attachments');
				jQuery.ajax({	
					url  : my_ajax.ajax_object,	
					type: 'POST',
					data: fd,
					contentType: false,
					processData: false,		
					success:function(response){
						jQuery('#hid_attachment_id1').val(response);
						jQuery('#attach_upload_status1').show();
						jQuery('#attach_upload_status1').html('Uploaded');
						console.log('Attachments updated..!');
					}
				});
			}
			else if(jQuery('.hid_edit_flip_action').val()=="responder")
			{
				var edit_id=jQuery('.hid_edit_flip_id').val();
				fd.append('mode','add');
				fd.append("type",'response');
				fd.append("podcast_id",jQuery('#hid_edit_podcast_id').val());
				fd.append("insert_id",jQuery('#insert_id').val());
				fd.append("edit_id",edit_id);
				fd.append("action",'upload_attachments');
				jQuery.ajax({	
					url  : my_ajax.ajax_object,	
					type: 'POST',
					data: fd,
					contentType: false,
					processData: false,
					success:function(response){
						jQuery('#attach_upload_status1').show();
						jQuery('#attach_upload_status1').html(response);
						console.log('Attachments added..!');
					}
				});
			}
		}
	}
});

/* change event for topic attachment2 */
jQuery('#topic_attachment2').on("change",function(e){
	if(jQuery('#add_flipto_podcast').val()==0 && (jQuery('.hid_edit_flip_action').val()=="edit" || jQuery('.hid_edit_flip_action').val()=="add")){
		alert("Please Select Associated Forum before Upload Attachment..!");	
		jQuery('#topic_attachment2').val('');
	}
	else{
		var files=e.target.files;
		var length=files.length;
		var filesize=files[0].size;
		var filename=files[0].name;
		var extension = filename.substr( (filename.lastIndexOf('.') +1) );
		if(extension !="pdf")
		{
			alert("File Type Must be PDF..!");
			jQuery(this).val('');
			return false;
		}
		else if(filesize>3145728)
		{
			alert('File size is Greater  then 3MB..!');
			jQuery(this).val('');
			return false;
		}
		else{
			var fd=new FormData()
			fd.append('attach_no','2');
			fd.append("flip_topic_attachment", document.getElementById('topic_attachment2').files[0]);
			if(document.getElementById('topic_attachment2').files[0]!=''){
				var counter = 0;
				var pb=jQuery('.attachment_status2');
				var interval = setInterval(function() {
					counter  = counter+10;
					/* Display 'counter' wherever you want to display it. */
					if (counter > 100) {
						
					}else{
						pb.attr('aria-valuenow', counter);
						pb.css('width', counter + '%');
						pb.text(counter + '%');
					}
				}, 45 * 1000 / 100);
			}
			jQuery('#attach_upload_status2').hide();
			if(jQuery('.hid_edit_flip_action').val()=="edit_response"){
				fd.append('mode','edit');
				fd.append('type','response');
				fd.append('podcast_id',jQuery('#hid_edit_podcast_id').val());
				fd.append('edit_id',jQuery('#hid_edit_res_flip_id').val());
				fd.append('insert_id',jQuery('#hid_edit_flip_id_reply').val());
				fd.append('flip_mul_attach',jQuery('#hid_edit_attachament2').data('id'));
				fd.append("action",'upload_attachments');
				jQuery.ajax({	
					url  : my_ajax.ajax_object,	
					type: 'POST',
					data: fd,
					contentType: false,
					processData: false,		
					success:function(response){
						jQuery('#hid_attachment_id2').val(response);
						jQuery('#attach_upload_status2').show(0);
						jQuery('#attach_upload_status2').html('Uploaded');
						console.log('Attachments updated..!');
					}
				});
			}
			else if(jQuery('.hid_edit_flip_action').val()=="responder")
			{
				var edit_id=jQuery('.hid_edit_flip_id').val();
				fd.append('mode','add');
				fd.append("type",'response');
				fd.append("podcast_id",jQuery('#hid_edit_podcast_id').val());
				fd.append("insert_id",jQuery('#insert_id').val());
				fd.append("edit_id",edit_id);
				fd.append("action",'upload_attachments');
				jQuery.ajax({	
					url  : my_ajax.ajax_object,	
					type: 'POST',
					data: fd,
					contentType: false,
					processData: false,
					success:function(response){
						jQuery('#attach_upload_status2').show(0);
						jQuery('#attach_upload_status2').html(response);
						console.log('Attachments added..!');
					}
				});
			}
		}
	}
});
jQuery(document).ready(function(){
	jQuery('.fl1p_save_success_dismiss').click(function(){
		jQuery('.fl1p_save_success').hide();
	});
	jQuery('.fl1p_update_success_dismiss').click(function(){
		jQuery('.fl1p_update_success').hide();
	});
});
jQuery(document).ready(function(){
		jQuery('.pauseButton').hide();
		jQuery('.stopButton').hide();
		jQuery('.refresh').hide();
		
		jQuery('.recordButton').click(function(){
			jQuery(this).hide();
			jQuery('.pauseButton').show();
			jQuery('.pauseButton').html('<i class="fa fa-pause" aria-hidden="true">Pause');
			jQuery('.stopButton').show();
			jQuery('.refresh').show();
		});
		
		jQuery('.stopButton').click(function(){
			jQuery(this).hide();
			jQuery('.refresh').show();
			jQuery('.pauseButton').hide();
			jQuery('.stopButton').hide();
			jQuery('.counter_interval').hide();
		});
		jQuery('.refresh').click(function(){
			var r = confirm("Your Recording will be deleted!");
			  if (r == true) {
				jQuery('.recordingsList').empty();
				jQuery(this).hide();
				jQuery('.pauseButton').hide();
				jQuery('.stopButton').hide();
				jQuery('.recordButton').show();
				jQuery('.counter_interval').show();
				jQuery('.uploading_wav_file').hide();
				jQuery('.recordButton').removeAttr('disabled');
				jQuery('.save').hide();
				jQuery('.save_flip_div').html("<form method='post' id='form_flip_id'><button type='button' onclick='go_back()' class='btn btn-primary flip_back_linkk' id='' name=''>Cancel</button>&nbsp;<button type='submit' class='btn btn-default uploading_wav_file_save' id='uploading_wav_file_save' name='uploading_wav_file_save'><i class='fa fa-save' aria-hidden='true'></i> Save</button></form>");
			  }
		});
	});

jQuery(document).ready(function(){
	/* click event for delete multiple image from s3 */
	jQuery('.delete_flip_mul_image').click(function(){
		var cnt=jQuery(this).data('count');
		var old_image = jQuery(this).data('id');	
		var podcast_id=jQuery(this).data('podcast_id');
		var flip_id=jQuery('#hid_edit_res_flip_id').val();
		var response_id=jQuery(this).data('flip_id');
		var post_data = {old_image:old_image,flip_id:flip_id,podcast_id:podcast_id,response_id:response_id,type:'response',action:'delete_mul_image_single'}
		jQuery.ajax({					
					url  : my_ajax.ajax_object,	
					type: 'POST',
					data: post_data,
					dataType: 'html',						
					success  : function(response) {
						if(jQuery.trim(response) === 'deleted'){
							jQuery('.mul_image_showspan').show();
							setTimeout(function() { jQuery('.mul_image_showspan').hide();}, 3000);
							jQuery('.mul_image_showdiv_'+cnt).empty();
							jQuery('.mul_image_showdiv_'+cnt).parent().hide();
						}
					}
			});
	});
});
/* function for delete data from s3 */
function lx_delete_data_from_s3(){
	if(jQuery('.hid_edit_flip_action').val()=='add' || jQuery('.hid_edit_flip_action').val()=='responder'){
		var flip_id=jQuery('.topic_close > a').data('flip_id');
		var post_data={flip_id:flip_id,action:'delete_data_from_s3'};
		jQuery('.lp-screen').show();
		jQuery.ajax({					
			url  : my_ajax.ajax_object,	
			type: 'POST',
			data: post_data,
			dataType:'html',
			success  : function(response) {
				jQuery('.replyModal').hide();
				jQuery('.lp-screen').hide();
			}
		});
	}else{
		jQuery('.replyModal').hide();
	}
}

/* click event for flip back link */
jQuery(document).on('click','.flip_back_link',function(){		
	window.location.href=jQuery('.hidden_back_link_flip').val();
});