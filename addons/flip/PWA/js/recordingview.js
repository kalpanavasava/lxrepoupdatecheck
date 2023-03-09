var dbPromise = idb.open('learningxpwadb',1,function( db ){ 
	db.createObjectStore('fliprecording',{keyPath:'id'});
	db.createObjectStore('recording_active',{keyPath:'id'});
});

jQuery(window).load(function(){
	
	/** fetch data by id **/
	var uniqueid = '';
	readAllData('recording_active').then(function(fetcheddata) {
		uniqueid = fetcheddata[0].id;
		var fliplist_title = fetcheddata[0].fliplist_title;
		jQuery('.pwafliplisttitle').html( fliplist_title );
	});
	
	/** fetch all recordings **/
	readAllData('fliprecording').then(function(frfetcheddata) {
		for( var i=0;i<=frfetcheddata.length;i++ ){
			if( frfetcheddata[i] != undefined ){
				var allid = frfetcheddata[i].id;
				var rec_title = frfetcheddata[i].rec_title;
				var rec_subtitle = frfetcheddata[i].rec_subtitle;
				var is_active = '';
				if( allid == uniqueid ){
					is_active = 'active';
				}
				
				var html = '<li class="'+is_active+'"><a href="javascript:void(0);" class="pwafliprecnavigationsidebar" data-recid="'+allid+'"><div class="fliprecord_title">'+rec_title+'</div><div class="fliprecord_subtitle">'+rec_subtitle+'</div></li>';
				
				jQuery('.pwasidebar').append( html );
				/* console.log( frfetcheddata[i] ); */
				
				/** get assets by id **/
				if( allid == uniqueid ){
					if( frfetcheddata[i].audio_blob != '' ){
						if( frfetcheddata[i].audio_blob.size ){
							var url = URL.createObjectURL(frfetcheddata[i].audio_blob);
							jQuery('.pwaaudioplay').attr('src',url);
						}else{
							jQuery('.pwaaudioplay').attr('src',frfetcheddata[i].audio_blob);
						}
					}
					if( frfetcheddata[i].rec_title != '' ){
						jQuery('.pwa_posttitle').html( frfetcheddata[i].rec_title );
					}
					if( frfetcheddata[i].rec_subtitle != '' ){
						jQuery('.pwa_postsubtitle').html( '- ' + frfetcheddata[i].rec_subtitle );
					}
					if( frfetcheddata[i].rec_additional_notes != '' ){
						jQuery('.pwafliprecord_textblock').html( frfetcheddata[i].rec_additional_notes );
						jQuery('.pwaadditionltextdisplay').hide();
					}
					/* console.log(frfetcheddata[i].multiple_files.length); */
					if( frfetcheddata[i].multiple_files.length > 0 ){
						var multiimages = frfetcheddata[i].multiple_files;
						jQuery('.pwaimagedisplay').hide();
						if( !jQuery.isEmptyObject(frfetcheddata[i].multiple_files) ){
							for( var j=0;j<=multiimages.length;j++ ){
								if( multiimages[j] != undefined ){
									if( multiimages[j].name !== undefined ){
										const reader = new FileReader();
										reader.onload = (function(f,n) {
											return function(e) {
												var active = '';var active2 = '';
												if( n == 0 ){
													var active = 'active';
												}
												
												var html1 = '<li data-target="#MultiImagesCarousal" data-slide-to="'+n+'" class="'+active+'"></li>'
												var html2 = '<div class="carousel-item '+active+'"><img class="d-block" src="'+e.target.result+'" alt="First slide"></div>';
												
												jQuery('.carousel-indicators').append( html1 );
												jQuery('.carousel-inner').append( html2 );
											};
										})(multiimages[j],j);
										if ( multiimages[j] ) {
											reader.readAsDataURL(multiimages[j]);
										}
									}else{
										var active = '';
										if( j == 0 ){
											var active = 'active';
										}
												
										var html1 = '<li data-target="#MultiImagesCarousal" data-slide-to="'+j+'" class="'+active+'"></li>'
										var html2 = '<div class="carousel-item '+active+'"><img class="d-block" src="'+multiimages[j]+'" alt="First slide"></div>';
										
										jQuery('.carousel-indicators').append( html1 );
										jQuery('.carousel-inner').append( html2 );
									}
								}
							}
						}
						/* setTimeout(function(){
							var totalItems = jQuery('.carousel-item').length;
							var currentIndex = jQuery('div.active').index();
							
							jQuery('.num').html('' + currentIndex + ' of ' + totalItems + ' images');
							
							jQuery('#MultiImagesCarousal').bind('slide.bs.carousel', function() {
								setTimeout(function(){
								currentIndex = jQuery('.carousel-inner').find('.active').index() + 1;
								jQuery('.num').html('' + currentIndex + ' of ' + multiimages.length + ' images');
							  }, 500);
							});
						}, 1000); */
					}else if( frfetcheddata[i].thumbnail_image != '' ){
						var html = '<div class="imagesthumb"><img src="'+frfetcheddata[i].thumbnail_image+'" /></div>';
						jQuery('.pwa_imagethumbnail').html( html );
						jQuery('.pwaslider').hide();
						jQuery('.pwaimagedisplay').hide();
					}else{
						jQuery('.pwaimagedisplay').show();
					}
					
					if( frfetcheddata[i].rec_additional_notes != '' && ( frfetcheddata[i].multiple_files.length > 0 || frfetcheddata[i].thumbnail_image != '' ) ){
						jQuery('.pwadisplaymaindiv').hide();
					}
					/* if( frfetcheddata[i].multiple_files != '' ){
						console.log( frfetcheddata[i].multiple_files );
					} */
				}
			}
		}
	});
});

/** navigation activeness **/
jQuery(document).on('click','.pwafliprecnavigationsidebar',function(){
	var uniqueid = jQuery(this).data('recid');
	var title = jQuery('.pwafliplisttitle').html();
	clearAllData( 'recording_active' );
	dbPromise.then(function(db) {
		var datas = {
			'id':uniqueid,
			'fliplist_title':title,
			'is_active':'1'
		};
		var tx = db.transaction('recording_active', 'readwrite');
		var store = tx.objectStore('recording_active');
		store.put(datas);
		
		setTimeout(function() {
			window.location.href=siteUrl+'/pwa-recordingview/';
		},500);
		
		return tx.complete;
	});
});

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
		store.clear();
		return tx.complete;
	});
}