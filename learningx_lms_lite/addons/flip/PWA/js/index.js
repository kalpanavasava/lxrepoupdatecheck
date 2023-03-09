/* Register Service Worker */
/* if ('serviceWorker' in navigator) {
	navigator.serviceWorker
	.register(flipurl+'PWA/sw.js')
	.then(function () {
		console.log('Service worker registered!');
	})
	.catch(function(err) {
		console.log(err);
	});
} */
/* var add_cache_file = ['http://localhost/learningxpwa/ajax.php?action=']; */

/* caches.open('list_recordings').then(function(cache) {
  return cache.addAll();
}) */
	
if( navigator.onLine == false ){
	jQuery('.pwadownloadofflinemenu').attr('disabled','disabled');
	jQuery('.pwasyncmenu').attr('disabled','disabled');
}

var dbPromise = idb.open('learningxpwadb',1,function( db ){ 
	db.createObjectStore('fliprecording',{keyPath:'id'});
	db.createObjectStore('recording_active',{keyPath:'id'});
});

jQuery(document).on('click','.pwadownloadofflinemenu',function(){
	var defaultfliplistid = jQuery('.defaultfliplistid').val();
	var dataPost = {'defaultfliplistid':defaultfliplistid,'action':'PWADownloadOffline'};
	jQuery.ajax({
		url  : admin_ajax,	
		type: 'POST',
		data: dataPost,
		dataType: 'html',
		success  : function(response) {
			var jr = jQuery.parseJSON( response );
			
			dbPromise.then(function(db) {
				/* console.log(db); */
				for( var i=0; i<=jr.length; i++ ){
					if( jr[i] !== undefined ){
						var datas = {
							'id':i,
							'recid':jr[i].recid,
							'rec_title':jr[i].rec_title,
							'rec_subtitle':jr[i].rec_subtitle,
							'audio_blob':jr[i].audio_blob,
							'multiple_files':jr[i].multiple_files,
							'rec_additional_notes':jr[i].rec_additional_notes,
							'thumbnail_image':jr[i].thumbnail_image,
							'settings':jr[i].settings,
							'total_fliplist':jr[i].total_fliplist,
							'flag':'downloaded'
						};
						
						var tx = db.transaction('fliprecording', 'readwrite');
						var store = tx.objectStore('fliprecording');
						store.put(datas);
						/* console.log(datas);
						console.log(db); */
						/* store.put(datas); */
					}
				}
				return tx.complete;
			});
			
			alert('Download offline successful');
			/* dbPromise.then(function(db) {
				var tx = db.transaction('testtable', 'readwrite');
				var store = tx.objectStore('testtable');
				store.put(datas);
				return tx.complete;
			}); */
			
		}
	});
});

jQuery(document).ready(function(){
	
	/** Remove the IDB Temp Data On Refresh **/
	/* if( navigator.onLine == false ){ */
		readAllData('fliprecording').then(function(fetcheddata) {
			jQuery('.flipreclist_div').html('');
			for( var i=0; i <= fetcheddata.length; i++ ){
				if( fetcheddata[i] !== undefined && fetcheddata[i].flag != 'tempdata' ){
					/* email.push(fetcheddata[i].email);
					fd.append('audios_'+fetcheddata[i].id,fetcheddata[i].file_path); */
					
					var assetsoptions = '';
					if( fetcheddata[i].flag !== 'downloaded' ){
						assetsoptions = '<button type="button" class="btn_danger_state ml-2 pwadelete_fliplist" data-key="'+fetcheddata[i].id+'" ><i class="fa fa-trash" aria-hidden="true"></i></button>';
						
						/* <button type="button" class="btn_normal_state ml-2 pwabtn_editfliprec" data-edituniqukey="'+fetcheddata[i].id+'"><i class="fa fa-pen" aria-hidden="true"></i></button> */
					}
					
					/* console.log(fetcheddata[i].flag); */
					var html = '<div class="row p-3 flipreclist_innerdiv flipreclist_innerdiv'+fetcheddata[i].id+'"><div class="col-md-2"><img src="'+fetcheddata[i].thumbnail_image+'" /></div><div class="col-md-6"><div class=""><h5>'+fetcheddata[i].rec_title+'</h5></div><div class="">'+fetcheddata[i].rec_subtitle+'</div></div><div class="col-md-4 d-flex justify-content-end"><button type="button" class="btn_normal_state pwaplaybtn" data-key="'+fetcheddata[i].id+'">Play</button>'+assetsoptions+'</div></div>';
					jQuery('.flipreclist_div').append(html);
				}
			}
		});
	/* } */
	
	/** on refresh check the login exist **/
	readAllData('loginsession').then(function(fetcheddata) {
		var i=0;	
		if( fetcheddata[i] !== undefined ){
			const LastLoginDateTimeStemp = fetcheddata[i].LastLoginDateTimeStemp;
			const now = new Date();
			const lastloginTimeStamp = (new Date(LastLoginDateTimeStemp)).getTime();
			const nowTimeStamp = now.getTime();
			const microSecondsDiff = Math.abs(lastloginTimeStamp - nowTimeStamp);
			const daysDiff = Math.round(microSecondsDiff / (1000 * 60 * 60  * 24));
			if (daysDiff > 30){
				var html = '<div class="text-center text-danger"><div>Please login to access the app.</div><div><a target="_blank" href="'+siteUrl+'/login/"><button class="btn_normal_state">Login/Register</button></a></div></div>';
				jQuery('.inside-article').html(html);
			}
		}
	});
});

jQuery(document).on('click','.pwainstallappmenu',function(){
	alert();
	window.addEventListener('beforeinstallprompt', (e) => {
		jQuery('.install-app-btn-container').show();
		deferredPrompt = e;
	});
});

/** adding the flip recording **/
jQuery(document).on('click','.pwabtn_editfliprec',function(){
	var uniId = jQuery(this).data('edituniqukey');
	dbPromise.then(function(db) {
		var datas = {
			'id':uniId,
			'is_active':'1'
		};
		var tx = db.transaction('recording_active', 'readwrite');
		var store = tx.objectStore('recording_active');
		store.put(datas);
		return tx.complete;
	});
	jQuery('.pwaeditclick'+uniId).trigger('click');
});

jQuery(document).on('click','.pwasyncmenu',function(){
	if( jQuery(this).hasClass('noclick')){
		return false;
	}
	jQuery('.pwasyncmenu').addClass('noclick');
	if( navigator.onLine == true ){
		
		var syncstatus;
		var newaudios=0;
		readAllData('fliprecording').then(function(fetcheddata) {
			var newaudios=[];
			for( var i=0; i<= fetcheddata.length;i++ ){
				if( fetcheddata[i] !== undefined ){
					if (fetcheddata[i].flag=='new'){
						newaudios++;
					}
				}
			}
			if( newaudios == 0 ){
				jQuery('.alert_box').html('All recordings already synced ...');
				jQuery('.alert_box').show();
				setTimeout(function () {
					jQuery('.alert_box').hide();
				}, 3000);
				return false;
			}
			
			var newaudiosuploded=0;
			var syncperc=0;
			var uploadedvideoskey = [];
			
			
			/* jQuery('.pwasyncmenu').hide(); */
			var ajaxCounter = {
				goal: newaudios,
				total: 0,
				success: 0,
				notmodified: 0,
				error: 0,
				timeout: 0,
				abort: 0,
				parsererror: 0
			}
			jQuery('.sync-progress-bar').css("display", "block");	
			for( var i=0; i<= fetcheddata.length;i++ ){
				var fd = new FormData();
				
				var rectitle = [];var rec_subtitle = [];var flag = []; var key = []; var key_id;
				if( fetcheddata[i] !== undefined && fetcheddata[i].flag=='new' ){
					if( fetcheddata[i].audio_blob !== undefined ){
						fd.append('audios_blob'+fetcheddata[i].id,fetcheddata[i].audio_blob);
					}
					var id =fetcheddata[i].id; 
					var recid=fetcheddata[i].recid;
					var rec_title=fetcheddata[i].rec_title;
					var srec_subtitle=fetcheddata[i].rec_subtitle;
					var audio_blob=fetcheddata[i].audio_blob;
					var rec_additional_notes=fetcheddata[i].rec_additional_notes;
					var thumbnail_image=fetcheddata[i].thumbnail_image;
					var multiple_files=fetcheddata[i].multiple_files;
					var settings=fetcheddata[i].settings;
					var total_fliplist=fetcheddata[i].total_fliplist;
					
					if( fetcheddata[i].multiple_files.length > 0 ){
						for( var j = 0; j<= fetcheddata[i].multiple_files.length; j++ ){
							if( fetcheddata[i].multiple_files[j] != undefined ){
								fd.append('multi_slider_'+fetcheddata[i].id+'_'+j,fetcheddata[i].multiple_files[j]);
								console.log(fetcheddata[i].multiple_files[j] );
							}
						}
					}
					
					
					rectitle.push( fetcheddata[i].rec_title );
					rec_subtitle.push( fetcheddata[i].rec_subtitle );
					flag.push( fetcheddata[i].flag );
					key.push( fetcheddata[i].id );
					fd.append( 'rectitle',rectitle );
					fd.append( 'rec_subtitle',rec_subtitle );
					fd.append( 'flag',flag );
					fd.append( 'key',key );
					fd.append('action','pwasaveRecording');
			
					jQuery.ajax({
						url  : admin_ajax,	
						type: 'POST',
						data: fd,
						contentType: false,
						processData: false, 
					/* 	async : false,	  */
						success  : function(response) {
							uploadedvideoskey[newaudiosuploded]=parseInt(response);
							newaudiosuploded++;
							syncperc=(newaudiosuploded*100/newaudios).toFixed(2);
							
							jQuery('.pwa-progress-bar-label').html(syncperc+"%");
							jQuery('.pwa-progress-bar').animate({width: syncperc+ "%",});
							jQuery('.pwa-cleaningstatus-label').html(syncperc+"%");
							jQuery('.pwa-cleaning-status').animate({width: syncperc+ "%",});
							
							readAllData('fliprecording').then(function(fetcheddata) {
								for( var j=0; j <= fetcheddata.length; j++ ){
									if( fetcheddata[j] !== undefined ){
										
										if( fetcheddata[j].id == parseInt(response) && fetcheddata[j].flag == 'new' ){
											var get_data = fetcheddata[j];
											
											dbPromise.then(function(db) {
												var datas = {
													'id':get_data.id,
													'recid':get_data.recid,
													'rec_title':get_data.rec_title,
													'rec_subtitle':get_data.rec_subtitle,
													'audio_blob':get_data.audio_blob,
													'rec_additional_notes':get_data.rec_additional_notes,
													'thumbnail_image':get_data.thumbnail_image,
													'multiple_files':get_data.multiple_files,
													'settings':get_data.settings,
													'total_fliplist':get_data.total_fliplist,
													'flag':'downloaded'
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
						},/* ,
						 error: function (request, error) {
								alert(" Can't do because: " + error);
								
						}, */
						complete: function (jqXHR, textStatus) {
							ajaxCounter.total++
							ajaxCounter[textStatus]++;
							if (ajaxCounter.total == ajaxCounter.goal){
								if (ajaxCounter.success >= ajaxCounter.goal) {
									var html='';
									html+='<div style="text-align:left;">Your sync is completed and have been saved to the server.  What would you like to do with the files on the device? If you want to view these files in the future when you\'re offline, keep them.  If you\'re happy to only view them when you\'re online, feel free to remove them';
									html+='<br><div style="display: flex;justify-content: center;align-items: center;"><button class="btn_dark_state" id="Keepthem">Keep them</button>&nbsp;&nbsp;';
									html+='<button class="btn btn_normal_state" id="Removethem">Remove them</button></div>';
									jQuery('.alert_box').html(html);
									jQuery('.alert_box').show();
									/* jQuery('.pwasyncmenu').show(); */
									jQuery('.pwasyncmenu').removeAttr('disabled');
									/* window.location.reload(true); */
									
								}
								if (ajaxCounter.error > 0)
								{
									jQuery('.alert_box').html(ajaxCounter.success + ' out of ' + ajaxCounter.total + ' \nSync Unsuccessfull');
									jQuery('.alert_box').show();
									setTimeout(function () {
										window.location.reload(true);
									}, 3000);
									
									jQuery('.pwasyncmenu').removeAttr('disabled');
									/* jQuery('.pwasyncmenu').show(); */
								}
							}
						}
					});
					 
				}
			}
			
			
		});
		
	}else{
		
		jQuery('.alert_box').html('Please check your connectivity');
		jQuery('.alert_box').show();
		setTimeout(function () {
			jQuery('.alert_box').hide();
		}, 3000);
		
	}
});

jQuery(document).on('click','#Keepthem',function(){
	
	jQuery('.alert_box').hide();
	window.location.reload(true);
});
jQuery(document).on('click','#Removethem',function(){
	jQuery('.alert_box').hide();
	clearAllData('fliprecording');
	jQuery('.sync-progress-bar').hide();
	jQuery('.flipreclist_div').html('');
	jQuery('.pwasyncmenu').removeClass('noclick');
});

/** delete recording **/
jQuery(document).on('click','.pwadelete_fliplist',function(){
	var uniqueid = jQuery(this).data('key');
	dbPromise
	.then(function(db) {
		var tx = db.transaction('fliprecording', 'readwrite');
		var store = tx.objectStore('fliprecording');
		store.delete(uniqueid);
		return tx.complete;
	})
	.then(function() {
	});
	
	jQuery('.flipreclist_innerdiv'+uniqueid).remove();
});

/** play click **/
jQuery(document).on('click','.pwaplaybtn',function(){
	var uniqueid = jQuery(this).data('key');
	var fliplist_title = jQuery('.pwafliplisttitle').val();
	clearAllData( 'recording_active' );
	dbPromise.then(function(db) {
		var datas = {
			'id':uniqueid,
			'fliplist_title':fliplist_title,
			'is_active':'1'
		};
		var tx = db.transaction('recording_active', 'readwrite');
		var store = tx.objectStore('recording_active');
		store.put(datas);
		
		window.location.href= siteUrl+'/pwa-recordingview/';
		return tx.complete;
	});
});

function ConfirmDialog(message) {
  $('<div></div>').appendTo('body')
    .html('<div><h6>' + message + '?</h6></div>')
    .dialog({
      modal: true,
      title: 'Sync message',
      zIndex: 10000,
      autoOpen: true,
      width: 700,
      resizable: true,
      buttons: {
        'Keep them': function() {
			$(this).dialog("close");
			window.location.reload(true);
			
        },
        'Remove them': function() {
			clearAllData('fliprecording');
			jQuery('.sync-progress-bar').hide();
			jQuery('.flipreclist_div').html('');
			$(this).dialog("close");
			
        }
      },
      close: function(event, ui) {
			
			$(this).remove();
		//	
      }
    });
};
function readAllData(st) {
	return dbPromise
	.then(function(db) {
		var tx = db.transaction(st, 'readonly');
		var store = tx.objectStore(st);
		return store.getAll();
	});
}

function clearAllData(st) {
	return dbPromise
	.then(function(db) {
		var tx = db.transaction(st, 'readwrite');
		var store = tx.objectStore(st);
		console.log("delete all");
		store.clear();
		return tx.complete;
	});
}
function clearSingleData(st,id) {
	return dbPromise
	.then(function(db) {
		var tx = db.transaction(st, 'readwrite');
		var store = tx.objectStore(st);
		store.delete(id);
		
		return tx.complete;
	});
}

/** -------------------------- **/