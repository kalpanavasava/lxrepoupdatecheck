<?php
/** Funtion to return the auth token **/
function SFAPIAuthentication( $args ){
	
	$end_point = $args[0];
	$clientid = $args[1];
	$clientsecret = $args[2];
	$username = $args[3];
	$password = $args[4];
	
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $end_point,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => array('username' => $username,'password' => $password,'grant_type' => 'password','client_id' => $clientid,'client_secret' => $clientsecret)
	));

	$response = curl_exec($curl);

	curl_close($curl);
	/* echo $response; */
	return $response;
}

/** Lead create functions **/
function SFAPICreateNewLead( $auth, $data ){
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $auth['instance_url'].'/services/data/v52.0/sobjects/Lead',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS =>$data,
	  CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json',
		'Authorization: Bearer '.$auth['auth_token']
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	return $response;
	
}