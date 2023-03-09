/** recorder **/
URL = window.URL || window.webkitURL;
var gumStream;var rec;var input;
var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext;
var recordButton = document.getElementById("audio_start");
var stopButton = document.getElementById("btn_save_recording");
var pauseButton = document.getElementById("audio_pause");
recordButton.addEventListener("click", startRecording);
stopButton.addEventListener("click", stopRecording);
pauseButton.addEventListener("click", pauseRecording);

var check = null;
var lastdistance=null;
var distance=null;

function Timer(){
	if (check == null) {
		var countDownDate = new Date().getTime();
		check  = setInterval(function() {
			var now = new Date().getTime();
			distance = now - countDownDate + lastdistance;
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			var sec = seconds < 10 ?  "0"+ seconds : seconds;
			document.getElementById("timer").innerHTML =  minutes + ":" + sec;
			jQuery('#timer_text').show();
			if (distance >= (15 * 60 * 1000)) {
				clearInterval(check);
				jQuery('.audio_pause').click();
				return false;
			}
		}, 1000);
	}
}
function startRecording() {
	jQuery('.pwaaudiouploadbtn').addClass('pwaaudiouploadbtndis');
	jQuery('.pwaaudioupload').attr('disabled','disabled');
	
    var constraints = { audio: true, video:false }
	jQuery('.audio_start').hide();
	jQuery('.audio_pause').show();
	jQuery('.btn_save_recording').removeAttr('disabled','disabled');
	jQuery('.rectooltxt').hide();
	
	jQuery('.flipreccolone').hide();
	jQuery('.flipreccoltwo').hide();
	
	navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
		Timer();
		audioContext = new AudioContext();
		gumStream = stream;
		input = audioContext.createMediaStreamSource(stream);

		rec = new Recorder(input,{numChannels:1, sampleRate: 96000});
		rec.record()
		console.log(rec);

	}).catch(function(err) {
		alert('You have some problem in your micro phone');
    	recordButton.disabled = false;
    	stopButton.disabled = true;
    	pauseButton.disabled = true
	});
}
function pauseRecording(){
	if (rec.recording){
		var starticon = jQuery('.starticon').val();
		jQuery('.audio_pause').html( '<i class="'+starticon+'" aria-hidden="true"></i>' );
		rec.stop();
		var lap = jQuery('.reclap').val();
		lastdistance=distance;
		jQuery('.reclap').val(parseInt(lap)+1);
		clearInterval(check); 
		console.log(lastdistance);
		check = null; 
	}else{
		var pauseicon = jQuery('.pauseicon').val();
		jQuery('.audio_pause').html( '<i class="'+pauseicon+'" aria-hidden="true"></i>' );
		rec.record();
		Timer();
	}
}
function stopRecording() {
	stopButton.disabled = true;
	recordButton.disabled = false;
	pauseButton.disabled = true;
	rec.stop();
	gumStream.getAudioTracks()[0].stop();
	rec.exportWAV(createDownloadLink);
}

jQuery(document).ready(function(){
	readAllData('fliprecording').then(function(fetcheddata) {
		readAllData('fliprecording').then(function(fetcheddata) {
		for( var i=0; i <= fetcheddata.length; i++ ){
				if( fetcheddata[i] !== undefined ){
					if( fetcheddata[i].flag == 'tempdata' ){
						var uniID = fetcheddata[i].id;
						dbPromise.then(function(db) {
							var tx = db.transaction('fliprecording', 'readwrite');
							var store = tx.objectStore('fliprecording');
							store.delete(uniID);
							return tx.complete;
						});
					}
				}
			}
		});
	});
});

function dataURItoBlob(dataURI) {
    // convert base64 to raw binary data held in a string
    var byteString = atob(dataURI.split(',')[1]);

    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

    // write the bytes of the string to an ArrayBuffer
    var ab = new ArrayBuffer(byteString.length);
    var ia = new Uint8Array(ab);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }

    return new Blob([ab], {type: mimeString});
}

jQuery(document).on('click','.pwaflip_record_save',function(){
	var backlink = jQuery('#backlink').val();
	var rectitle = jQuery('.fliprectitle').val();
	var recsubtitle = jQuery('.fliprecsubtit').val();
	var email = jQuery('#exampleInputEmail1').val();
	var thumbnail_image = jQuery('.recording_img').attr('src');
	var additional_notes = jQuery('.fliprecadditional_notes').val();
	var flag = 'new';
	
	var capturearray = [];
	jQuery('.dynamic_captures').each(function(){
		var dataURL = jQuery(this).find('img').attr('src');
		var blob =dataURItoBlob(dataURL);
		const file = new File([blob], 'fileName.png', {type:"image/png", lastModified:new Date()});
		capturearray.push(file);
	});
	
	var uniqueID = jQuery('.pwa_unique').val();
	if( uniqueID == '' || uniqueID == undefined ){
		readAllData('fliprecording').then(function(fetcheddata) {
			if( jQuery('.pwa_unique').val() !== '' ){
				uniqueID = jQuery('.pwa_unique').val();
			}else{
				uniqueID = parseInt(fetcheddata.length)+1;
			}
			
			dbPromise.then(function(db) {
				var datas = {
					'id':uniqueID,
					'recid':'',
					'rec_title':rectitle,
					'rec_subtitle':recsubtitle,
					'audio_blob':'',
					'rec_additional_notes':additional_notes,
					'thumbnail_image':thumbnail_image,
					'multiple_files':capturearray,
					'settings':'',
					'flag':flag
				};
				var tx = db.transaction('fliprecording', 'readwrite');
				var store = tx.objectStore('fliprecording');
				store.put(datas);
				
				var backlink = jQuery('#backlink').val();
				window.location.href = backlink;

				return tx.complete;
			});
		});
	}else{
		readAllData('fliprecording').then(function(fetcheddata) {
			for( var i=0; i <= fetcheddata.length; i++ ){
				if( fetcheddata[i] !== undefined ){
					if( fetcheddata[i].id == uniqueID && fetcheddata[i].flag == 'tempdata' ){
						var audio = fetcheddata[i].audio_blob;
						if(!jQuery.isEmptyObject(capturearray)) {
							var mutifiles = capturearray;
						}else{
							var mutifiles = fetcheddata[i].multiple_files;
						}
						
						var id = fetcheddata[i].id;
						dbPromise.then(function(db) {
							var datas = {
								'id':id,
								'recid':'',
								'rec_title':rectitle,
								'rec_subtitle':recsubtitle,
								'audio_blob':audio,
								'rec_additional_notes':additional_notes,
								'thumbnail_image':thumbnail_image,
								'multiple_files':mutifiles,
								'settings':'',
								'flag':flag
							};
							var tx = db.transaction('fliprecording', 'readwrite');
							var store = tx.objectStore('fliprecording');
							store.put(datas);
							
							setTimeout(function() {
								var backlink = jQuery('#backlink').val();
								window.location.href = backlink;
							},1000);
							/* */
		
							return tx.complete;
						});
					}
				}
			}
		});
	}
});

function PWAPublishData( blob = null ){
	var uniqueID = jQuery('.pwa_unique').val();
	
	if( uniqueID == '' || uniqueID == undefined ){
		readAllData('fliprecording').then(function(fetcheddata) {
			if( jQuery('.pwa_unique').val() !== '' ){
				uniqueID = jQuery('.pwa_unique').val();
			}else{
				uniqueID = parseInt(fetcheddata.length)+1;
			}
			
			jQuery('.pwa_unique').val( uniqueID );
			dbPromise.then(function(db) {
				var datas = {
					'id':uniqueID,
					'recid':'',
					'rec_title':'',
					'rec_subtitle':'',
					'audio_blob':blob,
					'rec_additional_notes':'',
					'thumbnail_image':'',
					'multiple_files':'',
					'settings':'',
					'flag':'tempdata'
				};
				var tx = db.transaction('fliprecording', 'readwrite');
				var store = tx.objectStore('fliprecording');
				store.put(datas);
				return tx.complete;
			});
		});
	}else{
		readAllData('fliprecording').then(function(fetcheddata) {
			for( var i=0; i <= fetcheddata.length; i++ ){
				if( fetcheddata[i] !== undefined ){
					if( fetcheddata[i].id == uniqueID && fetcheddata[i].flag == 'tempdata' ){
						var mutifiles = fetcheddata[i].multiple_files;
						var id = fetcheddata[i].id;
						dbPromise.then(function(db) {
							var datas = {
								'id':id,
								'recid':'',
								'rec_title':'',
								'rec_subtitle':'',
								'audio_blob':blob,
								'rec_additional_notes':'',
								'thumbnail_image':'',
								'multiple_files':mutifiles,
								'settings':'',
								'flag':'tempdata'
							};
							var tx = db.transaction('fliprecording', 'readwrite');
							var store = tx.objectStore('fliprecording');
							store.put(datas);
							return tx.complete;
						});
					}
				}
			}
		});
	}
	
	/* readAllData('fliprecording').then(function(fetcheddata) {
		if( jQuery('.pwa_unique').val() !== '' ){
			uniqueID = jQuery('.pwa_unique').val();
		}else{
			uniqueID = parseInt(fetcheddata.length)+1;
		}
		var rectitle = '';
		var recsubtitle = '';
		var email = '';
		var thumbnail_image = '';
		var additional_notes = '';
		var multifiles = '';
		var flag = 'tempdata';
		
		console.log(fetcheddata);
		
		var datas = {'id':uniqueID,'recid':'','audio_blob':blob,'rec_title':rectitle,'rec_subtitle':recsubtitle,'rec_additional_notes':additional_notes,'thumbnail_image':thumbnail_image,'multiple_files':multifiles,'flag':flag};
		
		jQuery('.pwa_unique').val( uniqueID );
		 
		dbPromise.then(function(db) {
			var tx = db.transaction('fliprecording', 'readwrite');
			var store = tx.objectStore('fliprecording');
			store.put(datas);
			return tx.complete;
		});
	}); */
}

jQuery(document).on('change','.pwaaudioupload',function(){
	var file = jQuery(this)[0].files[0];
	file.arrayBuffer().then((arrayBuffer) => {
		const blob = new Blob([new Uint8Array(arrayBuffer)], {type: file.type });
		var url = URL.createObjectURL(blob);
		jQuery('#auidosource').attr('src',url);
		
		jQuery('.pwaaudiouploadbtn').addClass('pwaaudiouploadbtndis');
		jQuery('.pwaaudioupload').attr('disabled','disabled');
		jQuery('.audio_start').attr('disabled','disabled');
		
		PWAPublishData( blob );
	});
});

jQuery(document).on('click','.pwadelete_multi_img',function(){
	/* setTimeout(function() { */
	var img_name = jQuery(this).data('img_name');
	
	var datakey = jQuery(this).data('key');
	var uniqueID = jQuery('.pwa_unique').val();
	var _e = jQuery(this);
	readAllData('fliprecording').then(function(fetcheddata) {
		for( var i=0;i<=fetcheddata.length;i++ ){
			if( fetcheddata[i] != undefined && fetcheddata[i].flag == 'tempdata' ){
				var multifiles = fetcheddata[i].multiple_files;
				multifiles.splice(datakey, 1);
				var audio_blob = fetcheddata[i].audio_blob;
				var id = fetcheddata[i].id;
				dbPromise.then(function(db) {
					var datas = {
						'id':id,
						'recid':'',
						'rec_title':'',
						'rec_subtitle':'',
						'audio_blob':'',
						'rec_additional_notes':'',
						'thumbnail_image':'',
						'multiple_files':multifiles,
						'settings':'',
						'flag':'tempdata'
					};
					var tx = db.transaction('fliprecording', 'readwrite');
					var store = tx.objectStore('fliprecording');
					store.put(datas);
					setTimeout(function(){
						_e.parent().parent().remove();
					},500);
					return tx.complete;
				});
			}
		}
	});
});

jQuery(document).on('change','.pwarecording_sliderimgagesfld',function(){
	var uniqueID = jQuery('.pwa_unique').val();
	/* alert( unique_id ); */
	var files = jQuery(this)[0].files;
	/* console.log( files ); */
	var trash = jQuery('.trash_icon').val();
	
	/* console.log( files.length ); */
	var filesarr = [];
	for( var j =0; j <= files.length ;j++ ){
		if( jQuery(this)[0].files[j] != undefined ){
			filesarr.push( jQuery(this)[0].files[j] );
		}
	}
	/* console.log( filesarr );  */
	/* console.log( jQuery(this)[0].files[0] ); */
	if( uniqueID == '' || uniqueID == undefined ){
		for( var x=0; x<=files.length; x++ ){
			if( files[x] != undefined ){
				const reader = new FileReader();
				/* console.log(readAsDataURL(files[x])); */
				var datakey = x;
				/* var datakey = 0; */
				 reader.onload = (function(f,n) {
					return function(e) {
						var html = '<div class="dynamic_images"><div class="img_div" style="position: relative;margin: 10px;"><img class="recording_multi_img" src="'+e.target.result+'"/><button type="button" data-img_name="'+f.name+'" class="btn_danger_state trash_recording_img pwadelete_multi_img" data-key="'+n+'" style="position: absolute;right: 0;"><i class="'+trash+'" aria-hidden="true"></i></button></div></div>';
						jQuery('.img_list').append( html );
						jQuery('.pwa_captureimagestart').hide();
					};
				})(files[x],x);
				if ( files[x] ) {
					reader.readAsDataURL(files[x]);
				}
			}
		}
		readAllData('fliprecording').then(function(fetcheddata) {
			if( jQuery('.pwa_unique').val() !== '' ){
				uniqueID = jQuery('.pwa_unique').val();
			}else{
				uniqueID = parseInt(fetcheddata.length)+1;
			}
			jQuery('.pwa_unique').val( uniqueID );
			dbPromise.then(function(db) {
				var datas = {
					'id':uniqueID,
					'recid':'',
					'rec_title':'',
					'rec_subtitle':'',
					'audio_blob':'',
					'rec_additional_notes':'',
					'thumbnail_image':'',
					'multiple_files':filesarr,
					'settings':'',
					'flag':'tempdata'
				};
				var tx = db.transaction('fliprecording', 'readwrite');
				var store = tx.objectStore('fliprecording');
				store.put(datas);
				
				return tx.complete;
			});
		});
	}else{
		readAllData('fliprecording').then(function(fetcheddata) {
			for( var i=0; i <= fetcheddata.length; i++ ){
				if( fetcheddata[i] !== undefined ){
					if( fetcheddata[i].flag == 'tempdata' ){
						
						var final_arfile = fetcheddata[i].multiple_files;
						/* final_arfile.push(filesarr);
						console.log(final_arfile.concat(filesarr)); */
						if( fetcheddata[i].multiple_files == '' ){
							var merged_array = filesarr;
						}else{
							var merged_array = jQuery.merge( fetcheddata[i].multiple_files , filesarr );
						}
						
						/* console.log( jQuery.merge( fetcheddata[i].multiple_files , filesarr ) ); */
						
						jQuery('.img_list').html('');
						for( var x=0; x<merged_array.length; x++ ){
							if( merged_array[x] != undefined ){
								const reader = new FileReader();
								/* console.log(readAsDataURL(files[x])); */
								var datakey = x;
								/* var datakey = 0; */
								 reader.onload = (function(f,n) {
									return function(e) {
										var html = '';
										html = '<div class="dynamic_images"><div class="img_div" style="position: relative;margin: 10px;"><img class="recording_multi_img" src="'+e.target.result+'"/><button type="button" data-img_name="'+f.name+'" class="btn_danger_state trash_recording_img pwadelete_multi_img" data-key="'+n+'" style="position: absolute;right: 0;"><i class="'+trash+'" aria-hidden="true"></i></button></div></div>';
										jQuery('.img_list').append( html );
									};
								})(merged_array[x],x);
								if ( merged_array[x] ) {
									reader.readAsDataURL(merged_array[x]);
								}
							}
						}
						
						var uniqueID = fetcheddata[i].id;
						var blob = fetcheddata[i].audio_blob;
						dbPromise.then(function(db) {
							var datas = {
								'id':uniqueID,
								'recid':'',
								'rec_title':'',
								'rec_subtitle':'',
								'audio_blob':blob,
								'rec_additional_notes':'',
								'thumbnail_image':'',
								'multiple_files':merged_array,
								'settings':'',
								'flag':'tempdata'
							};
							var tx = db.transaction('fliprecording', 'readwrite');
							var store = tx.objectStore('fliprecording');
							store.put(datas);

							return tx.complete;
						});
					}
				}
			}
		});
	}
	
	/* if( jQue)pwa_captureimagestart */
});

jQuery(document).mouseup(function(e) {
    var container = jQuery(".fliprecadditional_notes");
    // if the target of the click isn't the container nor a descendant of the container
    if ((!container.is(e.target) && container.has(e.target).length === 0)){
        /* container.hide(); */
		
		var additionalnotes = jQuery(".fliprecadditional_notes").val();
		
		if(additionalnotes == ''){
			jQuery('.fliprectextblockdiv').hide();
			jQuery('.fliprecsampletextblock').show();
		}
    }
});

var videoCapture;

jQuery(document).ready(function () {
    videoCapture = document.getElementById('capturevideo');
});

/** capture image **/
jQuery(document).on('click','.pwa_cameraenv',function(){
	
	localStream.getTracks().forEach(function (track) {
        if (track.readyState == 'live' && track.kind === 'video') {
            track.stop();
        }
    });
	
	var toggle = jQuery(this).prop('checked');
	if( toggle == true ){
		CameraAccess( 'environment' );
	}
	if( toggle == false ){
		CameraAccess( 'user' );
	}
});

jQuery(document).on('click','.pwa_captureimagestart',function(){
	CameraAccess( 'user' );
});

function CameraAccess( cameramode ){
	if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // access video stream from webcam
        navigator.mediaDevices.getUserMedia({ audio: false, video: {  facingMode: cameramode  } }).then(function (stream) {
            // on success, stream it in video tag 
            window.localStream = stream;
            videoCapture.srcObject = stream;
            videoCapture.play();
			jQuery('#capturevideo').show();
			jQuery('.pwa_captureimagestart').hide();
			jQuery('.pwa_captureimagestop').show();
			jQuery('.pwacapturedimagediv').hide();
			
			/* jQuery('.flirecsamplemulimageblock').hide();
			jQuery('.flirecmulimageblock').show();
			jQuery('.pwasliderimageuploaddiv').hide(); */
			jQuery('.img_list').css('height','258px');
			jQuery('.pwa_cameratoggle').show();
			jQuery('.pwa_galleryimage').hide();
			/* jQuery('.pwarecording_sliderimgagesfld').removeAttr('id'); */
        }).catch(e => {
            // on failure/error, alert message. 
            alert("Please Allow: Use Your Camera!");
        });
    }
}

jQuery(document).on('click','.pwa_captureimagestop',function(){
	
	var width = jQuery('#capturevideo').width();
	var height = jQuery('#capturevideo').height();
	jQuery('#capturecanvas').attr('height',height);
	jQuery('#capturecanvas').attr('width',width);
	var canvas = document.getElementById('capturecanvas');
	canvas.getContext('2d').drawImage(videoCapture, 0, 0, width, height);
	var data_url = canvas.toDataURL();
	var trash = jQuery('.trash_icon').val();
	
	var html = '<div class="dynamic_captures"><div class="img_div" style="position: relative;margin: 10px;"><img class="recording_multi_img" src="'+data_url+'"/><button type="button" data-img_name="" class="btn_danger_state trash_recording_img pwadelete_multi_capture" data-key="" style="position: absolute;right: 0;"><i class="'+trash+'" aria-hidden="true"></i></button></div></div>';
	
	/* var html = "<img class='pwacapturedimage' src='"+data_url+"' />"; */
	jQuery('.img_list').append( html );
	
	jQuery('.pwacapturedimage').attr('src',data_url);
	/* jQuery('#capturevideo').hide(); */
	jQuery('.pwacapturedimagediv').show();
	jQuery('.pwa_captureimagestart').html("Recapture Image");
	
	
	/* jQuery(this).hide(); */
	/* jQuery('.pwa_captureimagestart').show(); */
	
	/* localStream.getTracks().forEach(function (track) {
        if (track.readyState == 'live' && track.kind === 'video') {
            track.stop();
        }
    }); */
});

jQuery(document).on('click','.pwadelete_multi_capture',function(){
	jQuery(this).parent().parent().remove();
});

function createDownloadLink(blob) {
	console.log( blob );
	
	var lap = jQuery('.reclap').val();
	if( lap > 1 ){
		jQuery('.pauseicon').trigger('click');
	}else{		
		clearInterval(check); 
		check = null; 
	}
	var starticon = jQuery('.starticon').val();
	jQuery('.audio_pause').html( '<i class="'+starticon+'" aria-hidden="true"></i>' );
	
	var url = URL.createObjectURL(blob);
	jQuery('#auidosource').attr('src',url);
	
	/* readAllData('fliprecording').then(function(fetcheddata) {
		if( jQuery('.pwa_unique').val() !== '' ){
			uniqueID = jQuery('.pwa_unique').val();
		}else{
			uniqueID = parseInt(fetcheddata.length)+1;
		}
		var rectitle = jQuery('.fliprectitle').val();
		var recsubtitle = jQuery('.fliprecsubtit').val();
		var email = jQuery('#exampleInputEmail1').val();
		var thumbnail_image = jQuery('.recording_img').attr('src');
		var additional_notes = jQuery('.fliprecadditional_notes').val();
		var datas = {'id':uniqueID,'recid':'','audio_blob':blob,'rec_title':rectitle,'rec_subtitle':recsubtitle,'rec_additional_notes':additional_notes,'thumbnail_image':thumbnail_image,'flag':'new'};
		
		dbPromise.then(function(db) {
			var tx = db.transaction('fliprecording', 'readwrite');
			var store = tx.objectStore('fliprecording');
			store.put(datas);
			return tx.complete;
		});
	}); */
	PWAPublishData( blob );
	
	jQuery('.flipreccolone').show();
	jQuery('.flipreccoltwo').show();
}

jQuery(document).on('click','.btn_delete_recording', function(e){
	e.preventDefault();
	var recording_id = jQuery('#recording_id').val();
	jQuery('.alert_box').addClass('alert_box_del_recording_popup');
	jQuery('.alert_box').html('<div>Are you sure you want to delete the audio recording!</div><div class="del_recording_popup_main_class"><button class="btn_normal_state btn_del_recording_popup_yes" data-dismiss="modal" aria-label="Close" data-id="'+recording_id+'">Yes</button><button class="btn_dark_state btn_del_recording_popup_cancel" data-dismiss="modal" aria-label="Close">Cancel</button></div>');
	jQuery('.alert_box').show();
	$alert = jQuery('.alert_box');
	$alert.modal({backdrop:'static', keyboard:false});
});


jQuery(document).on('click','.btn_del_recording_popup_yes',function(e){
	jQuery('.lp-screen').show();
	jQuery('.btn_delete_recording').attr('disabled','disabled');
	/* jQuery('.btn_delete_recording').hide();
	jQuery('.audio_start').show();
	jQuery('.audio_start').prop( "disabled", false );
	jQuery('.audio_pause').hide();
	jQuery('.flip_recording_progress_div').hide();
	jQuery('.btn_save_recording').prop( "disabled", true );
	jQuery('.btn_save_recording').hide();
	jQuery('.alert_box_del_recording_popup').hide();
	jQuery('.lp-screen').show();
	jQuery('#timer_text').hide();
	jQuery('#before_recording_text').show(); */
	
	var recording_id = jQuery(this).data('id');
	var post_data = {'recording_id':recording_id, action:'DeleteRecording'};
	jQuery.ajax({					
		url  : recording_ob.ajax_url,
		type: 'POST',
		data: post_data,
		dataType: 'html',						
		success  : function(response) {
			var progressbar = jQuery('#flip_recording_progress');
			progressbar.attr('aria-valuenow', 0);
			progressbar.css('width',"0%");
			progressbar.text("0%");
			/* jQuery('#auidosource').attr('src',''); */
			jQuery('#auidosource').attr( 'src' ,"" );
			jQuery('.alert_box').html('Current audio recording is discarded!');
			jQuery('.alert_box').show();
			setTimeout(function(){
				jQuery('.alert_box').hide();
			},3000);
			jQuery('.lp-screen').hide();
			jQuery('.flip_recording_upload_status').html('');
			jQuery('#audio_start').show();
			jQuery('#audio_pause').hide();
			jQuery('#audio_start').removeAttr('disabled');
			jQuery('#audio_pause').removeAttr('disabled');
			jQuery('#timer').html('');
			jQuery('.rectooltxt').show();
			jQuery('.lp-screen').hide();
		}
	});
});	