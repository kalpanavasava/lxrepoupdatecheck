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
    	/* recordButton.disabled = false;
    	stopButton.disabled = true;
    	pauseButton.disabled = true */
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

function createDownloadLink(blob) {
	var lap = jQuery('.reclap').val();
	if( lap > 1 ){
		jQuery('.pauseicon').trigger('click');
	}else{		
		clearInterval(check); 
		check = null; 
	}
	var starticon = jQuery('.starticon').val();
	jQuery('.audio_pause').html( '<i class="'+starticon+'" aria-hidden="true"></i>' );
	setTimeout(function() {
		var url = URL.createObjectURL(blob);
		clearInterval(check); 
		check = null;
		console.log(url);
		jQuery('#auidosource').attr('src',url);
		var fd = new FormData();
		fd.append('audio',blob);
		fd.append('action','SaveRecording');
		var recording_id = jQuery('#recording_id').val();
		fd.append('recording_id',recording_id);
		
		var progressbar = jQuery('#flip_recording_progress');
		var percentage = 0;
		var timer = setInterval(function(){
			percentage = percentage + 2;
			if( percentage > 98 ){
				clearInterval(timer);
			}else{
				progressbar.attr('aria-valuenow', percentage);
				progressbar.css('width',percentage+"%");
				progressbar.text(percentage+"%");
			}
		},100);
		/* jQuery('.audio_control_preview').html("");	 */	
		jQuery.ajax({
			type: 'POST',
			url: recording_ob.ajax_url,
			data: fd,
			contentType: false,
			processData: false,
			success: function (response) {
				var res = jQuery.parseJSON(response);
				if( res.status == "1" ){
					clearInterval(timer);
					progressbar.attr('aria-valuenow', 100);
					progressbar.css('width',"100%");
					progressbar.text("100%");
					jQuery('.flip_recording_upload_status').css({'color':'#34a853','font-weight': '600','text-align':'center'});
					jQuery(".flip_recording_upload_status").html(res.msg);
					/* jQuery('#auidosource').attr('src',res.audioURL);					 */
					/* jQuery('.audio_control_preview').html( '<audio controls src="'+res.audioURL+'"></audio>' ); */
					jQuery('.btn_delete_recording').prop( "disabled", false );
				}else{
					jQuery('.alert_box').html(res.msg);
					jQuery('.alert_box').show();
					setTimeout(function(){
						jQuery('.alert_box').hide();
					},3000);
				} 
				jQuery('.flipreccolone').show();
				jQuery('.flipreccoltwo').show();
			}
		});
	}, 1000);
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
	
	jQuery('.flipreccolone').show();
	jQuery('.flipreccoltwo').show();
	jQuery('#timer').html('');
	
	clearInterval(check); 
	console.log(lastdistance);
	check = null; 
		
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