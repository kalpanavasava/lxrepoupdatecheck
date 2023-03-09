<?php
function FnFormatMytext( $description ){
	if( !empty( $description ) ) {
		$pattern = '/\*(.*?)\*/';
		$pattern2 = '/\_(.*?)\_/';
		$replacement = '<b>$1</b>';
		$replacement2 = '<i>$1</i>';
		$description = nl2br(str_replace('{N}','<br/><p>',preg_replace(array($pattern,$pattern2), array($replacement,$replacement2), $description)));
	}
	return $description;
}
function FnFormatMytextNLignore( $description ){
	if( !empty( $description ) ) {
		$pattern = '/\*(.*?)\*/';
		$pattern2 = '/\_(.*?)\_/';
		$replacement = '<b>$1</b>';
		$replacement2 = '<i>$1</i>';
		$description = str_replace('{N}','',preg_replace(array($pattern,$pattern2), array($replacement,$replacement2), $description));
	}
	return $description;
}
function FnEscapeAphostrophys($string){
	if(!empty($string)){
		if(strpos($string,"\'")!==false){
			$string=str_replace("\'","&apos;",$string);
		}elseif(strpos($string,"'")!==false){
			$string=str_replace("'","&apos;",$string);
		}
	}
	return $string;
}
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
function lxprint( $data , $is_pre = null ){
	
	$bt = debug_backtrace();
	$caller = array_shift($bt);
	$arr['file'] = $caller['file'];
	$arr['line'] = $caller['line'];
	$arr['all_given_data'] = $data;
	
	echo "<pre>";
	print_r($arr);
	if( $is_pre == 1 ){
		echo "</pre>";
	}
}
function vwpr( $str ){
	echo "<pre>";print_r($str);echo "</pre>";
}
?>