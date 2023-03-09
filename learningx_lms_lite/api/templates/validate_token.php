<?php 
declare(strict_types=1);
use Firebase\JWT\JWT;
require_once(dirname(dirname(__FILE__)).'/vendor/autoload.php');

if (! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
    $error_msg = 'Token not found in request';
    echo json_encode(array('status'=>400,'error'=>$error_msg));
    die;
}
$jwt = $matches[1];
if(!$jwt)
{   
    $error_msg = "Bad Request..";
    echo json_encode(array('status'=>400,'error'=>$error_msg));
    die;
}else{  
    $token=explode('_BASIC_',$jwt)[0];
    $secretKey=explode('_BASIC_',$jwt)[1];
    try{
        $token = JWT::decode($token, $secretKey, array('HS512'));
    }catch(\Exception $e){
        $error_msg = "Token Has Been Expired!";
        echo json_encode(array('status'=>400,'error'=>$error_msg));
        die;
    }
    $now = new DateTimeImmutable();
    $serverName = site_url()."/api/";
    if ($token->iss !== $serverName || $token->nbf > $now->getTimestamp() || $now->getTimestamp() >= $token->exp )
    {
       $error_msg = "Token Has Been Expired!";
       echo json_encode(array('status'=>400,'error'=>$error_msg));
       die;
    }
}
?>