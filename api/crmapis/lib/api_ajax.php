<?php
function CRMAPIAjaxFnSavesalesforceEvn(){
	$sfenv = array(
				'environment' => $_POST['env'],
				'staging'=>
					array( 
						'stg_endpoint'=>$_POST['stg_endpoint'], 
						'stg_consumerkey'=>$_POST['stg_consumerkey'], 
						'stg_consumersecret'=>$_POST['stg_consumersecret'],
						'stg_username'=>$_POST['stg_username'],
						'stg_password'=>$_POST['stg_password']
					),
				'production'=>
					array(
						'prod_endpoint'=>$_POST['prod_endpoint'], 
						'prod_consumerkey'=>$_POST['prod_consumerkey'], 
						'prod_consumersecret'=>$_POST['prod_consumersecret'],
						'prod_username'=>$_POST['prod_username'],
						'prod_password'=>$_POST['prod_password']
					)
				);
	/* echo "<pre>";print_r($sfenv); */
	update_option('salesforce_environment',$sfenv);
	wp_die();
}
add_action('wp_ajax_CRMAPIAjaxFnSavesalesforceEvn','CRMAPIAjaxFnSavesalesforceEvn');
add_action('wp_ajax_nopriv_CRMAPIAjaxFnSavesalesforceEvn','CRMAPIAjaxFnSavesalesforceEvn');

function CRMAPIAjaxFntestauth(){
	
	$authresponse = SFAPIAuthentication( array_values( $_POST ) );
	
	if( json_decode( $authresponse )->error ){
		echo 'auth_failed';
	}else{
		/** send the payload **/
		$company = get_bloginfo();
		$user_name = 'api_test_user';
		$firstname = 'Api';
		$lastname = 'Test-user';
		$formtype = 'Test';
		$auth_token = json_decode( $authresponse )->access_token;
		$instance_url = json_decode( $authresponse )->instance_url;
		$authenticationar = array('auth_token'=>$auth_token,'instance_url'=>$instance_url);
		$lead_array = json_encode( array('company'=>$company,'username__c'=>$user_name,'FirstName'=>$firstname,'LastName'=>$lastname,'Form_Type__c'=>$formtype) );
		
		$generated_lead = SFAPICreateNewLead( $authenticationar , $lead_array );
		
		if( empty(json_decode( $generated_lead )->id) ){
			echo 'nlead';
		}
	}
	/* echo "<pre>";print_r( get_bloginfo() ); */
	
	wp_die();
}
add_action('wp_ajax_CRMAPIAjaxFntestauth','CRMAPIAjaxFntestauth');
add_action('wp_ajax_nopriv_CRMAPIAjaxFntestauth','CRMAPIAjaxFntestauth');

function CRMAPIAjaxFnGtRolewiseApi(){
	$roleid = $_POST['roleid'];
	$user = get_user_by( 'id', $roleid );
	$usernicename = $user->user_nicename;

	?>
	<div class="row bkapitable_row<?php echo $roleid;?>">
		<div class="col-md-2">
			<?php echo $usernicename;?>
		</div>
		<div class="col-md-2">
			<div class="input-group mb-3">
				<?php 
				$clientkey = RandomString(40);
				?>
				<input type="hidden" class="bkclientidcusapihid<?php echo $roleid;?>" value="<?php echo $clientkey;?>">
				<input type="text" readonly class="form-control bkclientidcusapi" value="<?php echo substr($clientkey, 0, 9).'...';?>">
				<button type="button" class="btn_normal_state btncpyclientkey" data-id="<?php echo $roleid;?>" id="basic-addon1">copy</button>
				<div class="w-100 keycopied<?php echo $roleid;?>" style="display:none;">copied</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="input-group">
				<?php 
				$clientsec = RandomString(40);
				?>
				<input type="hidden" class="bkclientseccusapihid<?php echo $roleid;?>" value="<?php echo $clientsec;?>">
				<input type="text" readonly class="form-control bkclientseccusapi" value="<?php echo substr($clientsec, 0, 9).'...';?>">
				<button type="button" class="btn_normal_state btncpyclientsec" data-id="<?php echo $roleid;?>" id="basic-addon1">copy</button>
				<div class="w-100 seccopied<?php echo $roleid;?>" style="display:none;">copied</div>
			</div>
		</div>
		<div class="col-md-2">
			NA
		</div>
		<div class="col-md-1">
			<button type="button" class="btn_danger_state bkcusapideletebtn" data-id="<?php echo $roleid;?>" ><i class="fas fa-trash"></i></button>
		</div>
	</div>
	<?php
	
	/** update the user meta and it key **/
	$customapipoint  = array('clientkey'=>$clientkey,'clientsec'=>$clientsec,'last_used'=>'');
	
	update_user_meta($roleid,'customapipoint',$customapipoint);
	
	wp_die();
}
add_action('wp_ajax_CRMAPIAjaxFnGtRolewiseApi','CRMAPIAjaxFnGtRolewiseApi');
add_action('wp_ajax_nopriv_CRMAPIAjaxFnGtRolewiseApi','CRMAPIAjaxFnGtRolewiseApi');

function RandomString($length) {
    $original_string = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
    $original_string = implode("", $original_string);
    return substr(str_shuffle($original_string), 0, $length);
}

function CRMAPIAjaxFnShomodal(){
	$args = array(
		'role__not_in'    => array('subscriber'),
		'orderby' => 'user_nicename',
		'order'   => 'ASC',
		'meta_query' => array(
							array(
								'key' => 'customapipoint',
								'compare' => 'NOT EXISTS'
							),
						)
	);
	
	$techmanager_user = get_users( $args );
	?>
	<div class="form-group">
		<label for="bktechrole">Select user</label>
		<select class="form-control bktechrole" id="bktechrole">
			<option value="0">-- Select user--</option>
			<?php 
			foreach( $techmanager_user as $tu ){
				$techmanagerid = $tu->ID;
				$firstname = get_user_meta($techmanagerid,'first_name',true);
				$lastname = get_user_meta($techmanagerid,'last_name',true);
				$techname = $tu->user_nicename;
				if( !empty($firstname) && !empty($lastname) ){
					$techname = $firstname.' '.$lastname;
				}
				?>
				<option value="<?php echo $techmanagerid;?>"><?php echo $techname; ?></option>
				<?php
			}
			?>
		</select>
	</div>
	<button type="button" class="btn_normal_state bkbtncreatenewauth">Create new</button>
	<span class="usernotselected_prompt"></span>
	<?php
	wp_die();
}
add_action('wp_ajax_CRMAPIAjaxFnShomodal','CRMAPIAjaxFnShomodal');
add_action('wp_ajax_nopriv_CRMAPIAjaxFnShomodal','CRMAPIAjaxFnShomodal');

function CRMAPIAjaxFnDelete(){
	$roleid = $_POST['techid'];
	delete_user_meta($roleid,'customapipoint');
	wp_die();
}
add_action('wp_ajax_CRMAPIAjaxFnDelete','CRMAPIAjaxFnDelete');
add_action('wp_ajax_nopriv_CRMAPIAjaxFnDelete','CRMAPIAjaxFnDelete');