<?php
declare(strict_types=1);
use Firebase\JWT\JWT;
require_once(dirname(dirname(__FILE__)).'/vendor/autoload.php');
// Validate the credentials against a database, or other data store.
// ...
// For the purposes of this example, we'll assume that they're valid
$user_id=isset($_GET['user_id'])?$_GET['user_id']:get_current_user_id();
$hasValidCredentials = true;
$basicAuth=explode(' ',$_SERVER['HTTP_AUTHORIZATION'])[1];
$data=explode(':',base64_decode($basicAuth));
$consumer_data=get_user_meta($user_id,'customapipoint',true);
$consumerKey=$consumer_data['clientkey'];
$secretKey=$consumer_data['clientsec'];
if($data[0]!=$consumerKey || $data[1]!=$secretKey){ 
    $hasValidCredentials = false;
    $return=array('status'=>400,'error'=>'Invalid Consumer Key Or Secret.');
    echo json_encode($return);
    die;
}
if ($hasValidCredentials) {
    $secretKey  =$basicAuth;
    $issuedAt   = new DateTimeImmutable();
    $expire     = $issuedAt->modify('+15 minutes')->getTimestamp(); 
    $serverName = site_url()."/api/";                              
    // Create the token as an array
    $data = array(
        'iat'  => $issuedAt->getTimestamp(),   
        'nbf'  => $issuedAt->getTimestamp(),
        'iss'  => $serverName,                  
        'exp'  => $expire,             
    );

    // Encode the array to a JWT string.
   $token=JWT::encode( $data,$secretKey, 'HS512');
   $return=array('status'=>200,'token'=>$token.'_BASIC_'.$basicAuth);
   echo json_encode($return);
}