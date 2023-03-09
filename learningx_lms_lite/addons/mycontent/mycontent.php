<?php
/**
	@Author: Voidek Webolution
	@Description: My Content
**/
define('MyContetntURLLite',plugin_dir_url(__FILE__));
define('MyContetntPATHLite',plugin_dir_path(__FILE__));

/* Include Files Here */
include MyContetntPATHLite .'/templates/create_mycontent.php';
include MyContetntPATHLite .'/functions/functions.php';
include MyContetntPATHLite .'/classes/class_mycontent_assets.php';
$obj=new ClassMyContentAssetsLite();
include MyContetntPATHLite .'/classes/class_mycontent_ajax.php';
$object_ajax=new ClassMyContentAjaxLite();