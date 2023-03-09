/* click event for view articulate content */
jQuery(document).on('click','.view_more_articulate',function(){	
	var last_show = jQuery(this).data('last_show');	
	var term_id=jQuery(this).data('term_id');	
	var total=jQuery(this).data('total_content');	
	jQuery('.show_more_alt_icon').hide();	
	jQuery('.view_more_articulate').hide();	
	jQuery('.spinner_forum').show();	
	var postdata = {'last_show':last_show,'term_id':term_id,'total_content':total,'action':'view_more_articulate_content'};	
	jQuery.ajax({							
		url  : my_ajax_object.ajax_anchor,							
		type : 'POST',							
		data : postdata,							
		dataType : 'html',							
		success  : function(response) {			
			jQuery('.spinner_forum').hide();			
			jQuery('.more_btn_div').remove();			
			jQuery('.show_more_content_'+term_id).append(response);		
		}	
	});
});

jQuery(document).ready(function(){
	var i=1;
	jQuery( ".alt_web_tab_row" ).each(function( index ) {
		jQuery( this ).addClass( "alt_web_tab_row_"+i );
		jQuery(this).find('.alt_web_tablinks').attr('data-id',i);
		i=i+1;
	}); 
	var j=1;
	jQuery( ".course_tab_row" ).each(function( index ) {
		jQuery( this ).addClass( "course_tab_row_"+j );
		jQuery(this).find('.tablinks').attr('data-id',j);
		j=j+1;
	});
});
/* for manage tabs */
function opentabinfo(evt, tabevent, class_info) {
	var i, tabcontent, tablinks;
	var tab_count = evt.path[0].getAttribute('data-id');
	jQuery('.course_tab_row_'+tab_count).find('.tab_bottom').removeClass('tab_bottom');
	jQuery('.course_tab_row_'+tab_count+' .'+ class_info).addClass('tab_bottom');
	jQuery('.'+ class_info).children().css('color' , "#000000");
	tabcontent = document.getElementsByClassName("tabcontent");
	jQuery('.course_tab_row_'+tab_count+' .tab_course_content').hide();
	tablinks = document.getElementsByClassName("course_tab_row_"+tab_count+" "+"tablinks");
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	}
	jQuery('.course_tab_row_'+tab_count+" ."+tabevent).show();
	evt.currentTarget.className += " active";
}

/* for manage articulate tabs */
function opentabinfoAltWeb(evt, tabevent, class_info) {
	var i, tabcontent, tablinks;
	var tab_count = evt.path[0].getAttribute('data-id');
	jQuery('.alt_web_tab_row_'+tab_count).find('.alt_web_tab_bottom').removeClass('alt_web_tab_bottom');
	jQuery('.alt_web_tab_row_'+tab_count+' .'+ class_info).addClass('alt_web_tab_bottom');
	jQuery('.'+ class_info).children().css('color' , "#000000");
	tabcontent = document.getElementsByClassName("alt_web_tabcontent");
	jQuery('.alt_web_tab_row_'+tab_count+' .articulate_content').hide();
	tablinks = document.getElementsByClassName("alt_web_tab_row_"+tab_count+" "+"alt_web_tablinks");
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	}
	jQuery('.alt_web_tab_row_'+tab_count+" ."+tabevent).show();
	evt.currentTarget.className += " active";
}

function opentabinfo_fl1plist(evt, tabevent, class_info) {
    var j=1;
    jQuery( ".fl1plist_tab_row" ).each(function( index ) {
        jQuery( this ).addClass( "fl1plist_tab_row_"+j );
        jQuery(this).find('.tablinks').attr('data-id',j);
        j=j+1;
    });
    var i, tabcontent, tablinks;
    var tab_count = evt.path[0].getAttribute('data-id');
    jQuery('.fl1plist_tab_row_'+tab_count).find('.tab_bottom').removeClass('tab_bottom');
    jQuery('.fl1plist_tab_row_'+tab_count+' .'+ class_info).addClass('tab_bottom');
    jQuery('.'+ class_info).children().css('color' , "#000000");
    tabcontent = document.getElementsByClassName("tabcontent");
    jQuery('.fl1plist_tab_row_'+tab_count+' .tab_fl1plist_content').hide();
    tablinks = document.getElementsByClassName("fl1plist_tab_row_"+tab_count+" "+"tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    jQuery('.fl1plist_tab_row_'+tab_count+" ."+tabevent).show();
    evt.currentTarget.className += " active";
}

/** LRS Activities **/
function LRSDataGet( actid = null ){
	var verb = "http://adlnet.gov/expapi/verbs/passed";
	var user_email = path.currentemail;
	var conf = {  
		"endpoint" : path.endpoint + "/",
		"auth" : "Basic " + toBase64(path.auth_key+":"+path.auth_secret)
	}; 
	ADL.XAPIWrapper.changeConfig(conf); 
	var myparams = ADL.XAPIWrapper.searchParams();
	myparams['verb'] = verb;
	if( actid !== null ){
		myparams['activity'] = actid;
	}
	myparams['agent'] = '{"mbox": "mailto:'+decodeURIComponent(user_email)+'"}';
	myparams['limit'] = 1000000;
	
	var completedStmts = ADL.XAPIWrapper.getStatements(myparams);
	return completedStmts;
}

jQuery(document).ready(function(){
	if( jQuery('.tilelboxlessonid').length > 0 ){
		var lession_id_arr = [];var activity_id_arr = [];
		jQuery('.tilelboxlessonid').each(function(){
			var lession_id = jQuery(this).val();
			var activity_id = jQuery('.tilelboxactid'+lession_id).val();
			lession_id_arr.push(lession_id);
			activity_id_arr.push(activity_id);
		});
		sendStatementlb(lession_id_arr, activity_id_arr);
	}
});
function sendStatementlb(lession_id_arr, activity_id_arr){
	
	var user_email = path.currentemail;
	var completedStmts = LRSDataGet();
	
	var i;var count = [];var lession_id_arr_in = [];var completedtime = [];
	for( var j=0; j< (lession_id_arr).length; j++ ){
		var activity_id = activity_id_arr[j];
		
		for( i = 0 ; i < (completedStmts.statements).length; i++){
			
			if( completedStmts.statements[i].object.id == activity_id && completedStmts.statements[i].actor.mbox == 'mailto:'+decodeURIComponent(user_email)){
				count.push(completedStmts.statements[i]);
				lession_id_arr_in.push(lession_id_arr[j]);
				completedtime.push( completedStmts.statements[i].stored );
			}
		}
	}
	if( count.length > 0 ){
		jQuery('.lp-screen').show();
		var post_data={'lesson_id':lession_id_arr_in,'completedtime':completedtime,'action':'add_lesson_completion2'};
		jQuery.ajax({
			url:my_ajax_object.ajax_anchor,
			type: 'POST',
			data: post_data,
			success:function(response){
				location.reload();
				jQuery('.lp-screen').hide();
			}
		});
	}
		
}  
/* for manage articulate content iframe */
jQuery(document).on('click','.content_card',function(e){
	var target=e.target.className;
	if(target=='btn_normal_state btn_edit_icon btn_edit_tiles' || target=='[object SVGAnimatedString]'){}else{
		jQuery('.lp-screen').show();
		var content_id=jQuery(this).data('lession_id');
		var content_type = jQuery(this).data('content_type');
		var ctype=jQuery(this).data('type');
		var isLogin=jQuery(this).data('is_login');
		var data={'content_id':content_id,'ctype':ctype,'content_type':content_type,'action':'fetch_content_body'};
		jQuery.ajax({
				url:my_ajax_object.ajax_anchor,
				type : 'POST',					
				data : data,					
				dataType : 'html',	
				success : function(response){
					jQuery('.modal_iframe_'+content_id).find('.content_body').html(response);
					jQuery('.modal_iframe_'+content_id).modal('show');
					if(content_type=='poll' || isLogin=='not_login'){
						var ht=jQuery('.modal_iframe_'+content_id).find('.lb_if_header').height();
						var totalHeight=parseInt(ht)+36;
						/* alert(25 * (100 / document.documentElement.clientWidth)); */
						jQuery('.content_body').css('height','calc(100vh - '+totalHeight+'px)');
					}
					jQuery('body').css('position','fixed');
					
					/* setTimeout(function(){ pageAccessed(); }, 5000); */
					jQuery('.lp-screen').hide();
				}
		});
	}
});

jQuery(document).ready(function(){
	jQuery('body').on('click', function (e) {
		jQuery('[data-toggle="popover"]').each(function () {
			if (!jQuery(this).is(e.target) && jQuery(this).has(e.target).length === 0 && jQuery('.popover').has(e.target).length === 0) {
				jQuery(this).popover('hide');
				
			}
		});
	});
	jQuery('.lx_toggle').each(function(){
		if(jQuery(this).find('input[type=checkbox]').is(':checked')){
			jQuery(this).find('.off').hide();
			jQuery(this).find('.on').show();
		}
	});
});
jQuery(document).on('click','.lx_toggle',function(){
	if(jQuery(this).find('input[type=checkbox]').is(':checked')){
		jQuery(this).find('.off').hide();
		jQuery(this).find('.on').show();
	}else{
		jQuery(this).find('.on').hide();
		jQuery(this).find('.off').show();	
	}
});

/* jQuery(document).ready(function(){
	var completedStmts = LRSDataGet('http://ZweoSnnkncANQBKdo5i9NYEMoH4--anj_rise');
	console.log(completedStmts);
}); */