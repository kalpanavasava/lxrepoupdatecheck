<?php

$learningx_plugins=array('VWPLUGIN_LITE'=>'learningx_lms_lite/learningx_lms_lite.php','VWPLUGIN_PRO'=>'learningx_lms_pro/learningx_lms_pro.php','VWPLUGIN_LOGIN'=>'lx_login/lx-login.php','VWPLUGIN_STRIPE'=>'stripe-payments/accept-stripe-payments.php');

foreach( $learningx_plugins as $name=>$path ){
	
	define($name,$path);
	
}