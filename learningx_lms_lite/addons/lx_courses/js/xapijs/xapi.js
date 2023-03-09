window.addEventListener('load', pageAccessed, false);
function pageAccessed() {
	/*var activity_id = "http://h1KaMSKqiVRuMQ7ye9Ea06gvHxjNbp4v_rise";
	var user_email = "mailto:User26105@user.com";*/
	var activity_id = jQuery('#activity_id').val();
	var user_email = jQuery('#mailto').val();
	var verb = "http://adlnet.gov/expapi/verbs/passed";
	
	var compstatus = jQuery('#lesson_status').val();
	if( compstatus !== 'completed' ){
		var completedStmts = LRSDataGet( activity_id );
		if( completedStmts.statements.length > 0 ){
			jQuery('.lp-screen').show();
			var post_data = {
				'activity': activity_id,
				'lesson_id': jQuery('#vw_lesson_id').val(),
				'endtime': completedStmts.statements[0].stored,
				'action' : 'savexapidata'
			}
			jQuery.ajax({
				url: ajax_ob.ajax_url,
				type: 'POST',
				data: post_data,
				success: function(response){
					location.reload();
				}
			});
		}
	}
}

/* function sendStatement( activity_id, user_email, verb ){
	var conf = {  
		"endpoint" : learning_locker.endpoint + "/",
		"auth" : "Basic " + toBase64(learning_locker.auth_key+":"+learning_locker.auth_secret)
	}; 
	ADL.XAPIWrapper.changeConfig(conf); 
	
	var myparams = ADL.XAPIWrapper.searchParams();
	
	myparams['verb'] = verb;
	myparams['agent'] = '{"mbox": "mailto:'+decodeURIComponent(user_email)+'"}';
	myparams['limit'] = 1000000;
	
	var completedStmts = ADL.XAPIWrapper.getStatements(myparams);
	
	var i;var count = [];var completedtime = [];
	for( i = 0 ; i < (completedStmts.statements).length; i++){

		if( completedStmts.statements[i].object.id == activity_id && completedStmts.statements[i].actor.mbox == 'mailto:'+decodeURIComponent(user_email)){
			count.push(completedStmts.statements[i]);
			completedtime.push( completedStmts.statements[i].stored );
		}
	}
	if( count.length > 0 ){
		var passed_results = count;
		if(jQuery('#lesson_status').val()!='completed')
		{
			var open_in=jQuery('#open_in').val();
			var post_data={'user_id':jQuery('#vw_user_id').val(),'lesson_id':jQuery('#vw_lesson_id').val(),'completedtime':completedtime,'action':'add_lesson_completion'};
			jQuery.ajax({
				url:my_ajax_object.ajax_anchor,
				type: 'POST',
				data: post_data,
				success:function(response){
					if(open_in!='lightbox'){
						location.reload();
					}
				}
			});
		}
	}
		
}   */