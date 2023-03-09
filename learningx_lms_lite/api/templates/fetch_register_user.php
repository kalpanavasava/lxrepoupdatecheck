<?php 
include 'validate_token.php';
global $wpdb;
$q='';
$q1='';
if(isset($_GET['date'])){
	$q.="where user_registered like '%".$_GET['date']."%'";
}
elseif(isset($_GET['from_date']) && isset($_GET['to_date'])){
	$q.="where user_registered between '".$_GET['from_date']."' and '".$_GET['to_date']."'";
	$q1.="where user_registered like '%".$_GET['to_date']."%'";
}
elseif(isset($_GET['from_date']) && !isset($_GET['to_date'])){
	$q.="where user_registered between '".$_GET['from_date']."' and '".date('Y-m-d')."'";
	$q1.="where user_registered like '%".date('Y-m-d')."%'";
}
elseif(isset($_GET['to_date']) && !isset($_GET['from_date']))
{
	$data=array('status'=>400,'error'=>'Please add From Date.');
	echo json_encode($data);
	die;	
}
elseif(isset($_GET['limit']) && isset($_GET['order']))
{
	$q.="order by id ".$_GET['order']." limit ".$_GET['limit'];
}
elseif(isset($_GET['limit'])){
	$q.="limit ".$_GET['limit'];
}
elseif(isset($_GET['user_id'])){
	$q.="where ID='".$_GET['user_id']."'";
}
elseif(isset($_GET['username'])){
	$q.="where user_login='".$_GET['username']."'";
}
if($q1!=''){
	$users_q=$wpdb->get_results("select * from ".$wpdb->prefix."users ".$q);
	$users_q1=$wpdb->get_results("select * from ".$wpdb->prefix."users ".$q1);
	$users=array_merge($users_q,$users_q1);
}else{
	$users=$wpdb->get_results("select * from ".$wpdb->prefix."users ".$q);
}
foreach($users as $key=>$user){
	$filter_users[$key]['id']=$user->ID;
	$filter_users[$key]['email']=$user->user_email;
	$filter_users[$key]['firstname']=get_user_meta($user->ID,'first_name',true);
	$filter_users[$key]['lastname']=get_user_meta($user->ID,'last_name',true);
	$filter_users[$key]['company']=get_user_meta($user->ID,'company_name',true);
	$filter_users[$key]['abn']= get_user_meta($user->ID,'abn_number',true);
}
if(!empty($filter_users)){
	$data=array('status'=>200,'data'=>$filter_users);
}else{
	$data=array('status'=>400,'error'=>'Users not found.');
}
echo json_encode($data);
die;
?>