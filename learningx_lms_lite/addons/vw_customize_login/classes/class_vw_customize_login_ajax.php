<?php 
class Customize_login_ajax {
	function __construct() {
		add_action("wp_ajax_fn_vw_resend_email", array($this,"fn_vw_resend_email"));
		add_action( 'wp_ajax_nopriv_fn_vw_resend_email', array($this,'fn_vw_resend_email'));
		add_action("wp_ajax_fn_vw_join_user", array($this,"fn_vw_join_user"));
		add_action( 'wp_ajax_nopriv_fn_vw_join_user', array($this,'fn_vw_join_user'));
		add_action("wp_ajax_fn_vw_email_validation", array($this,"fn_vw_email_validation"));
		add_action( 'wp_ajax_nopriv_fn_vw_email_validation', array($this,'fn_vw_email_validation'));
		add_action("wp_ajax_fn_vw_email_verification", array($this,"fn_vw_email_verification"));
		add_action( 'wp_ajax_nopriv_fn_vw_email_verification', array($this,'fn_vw_email_verification'));
		
		add_action("wp_ajax_check_the_valid_accesscode", array($this,"check_the_valid_accesscode"));
		add_action( 'wp_ajax_nopriv_check_the_valid_accesscode', array($this,'check_the_valid_accesscode'));
		
		add_action("wp_ajax_access_community_fn", array($this,"access_community_fn"));
		add_action( 'wp_ajax_nopriv_access_community_fn', array($this,'access_community_fn'));
		
		add_action("wp_ajax_fnajaxagreement", array($this,"fnajaxagreement"));
		add_action( 'wp_ajax_nopriv_fnajaxagreement', array($this,'fnajaxagreement'));
	}
	/* for join user */
	function fn_vw_join_user(){
		global $wpdb;
		$frm_redirect=$_POST['redirection_info'];
		$title = get_option('blogname');
		$email = $_POST['work_email'];
		$password = $_POST['work_password'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$frm_redirect = $_POST['redirection_info'];
		$course_id = $_POST['course_id'];
		$is_restricted = $_POST['is_restricted'];
		
		$userdata = array(
			'user_login'    =>   $email,
			'user_email'    =>   $email,
			'first_name'    =>   $first_name,
			'last_name'     =>   $last_name,
			'user_pass'		=>   $password
		);
		$userid = wp_insert_user( $userdata );
		update_user_meta($userid,'user_status','Inactive');
		/* update_user_meta($userid,'user_psw',$password); */
		/* $auth0=get_option('wp_auth0_settings');
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://'.$auth0['domain'].'/dbconnections/signup',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => 'client_id='.$auth0['client_id'].'&email='.$email.'&password='.$password.'&connection=Username-Password-Authentication',
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/x-www-form-urlencoded'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl); */
		$page = get_page_by_path("join-next-step");
		$page_id = $page->ID;
		$headers = "Content-Type: text/html; charset=UTF-8";
		$code = sha1( $userid . time() ); 
		$this->send_join_mail($email,$first_name,$userid,$frm_redirect,$course_id,$is_restricted);
		$data=base64_encode('redirect_key=join-next-step&login_data='.$userid.'&redirection='.$frm_redirect.'&course_id='.$course_id);
		if($is_restricted == 1){
			$data=base64_encode('redirect_key=join-next-step&login_data='.$userid.'&redirection='.$frm_redirect.'&course_id='.$course_id.'&is_restricted=1');
		}
		$verification_link = site_url()."/join-next-step/".$data;
		/* echo "<pre>";print_r($verification_link);
		die(); */
		echo $verification_link;
		die();
	}
	
	/* for send join mail */
	function send_join_mail($email,$first_name,$userid,$frm_redirect,$course_id,$is_restricted=null){
		global $login_settings;
		$page = get_page_by_path("join-next-step");
		$page_id = $page->ID;
		$headers = "Content-Type: text/html; charset=UTF-8";
		$code = sha1( $userid . time() );
		$page=''; 
		if($frm_redirect=='purchase'){
			$page=site_url().'/payment/';
		}else{
			$page=site_url().'/email-verification/';
		}
		$query=base64_encode('redirect_key=email-verification&login_data='.$userid.'&redirection='.$frm_redirect.'&course_id='.$course_id);
		if($is_restricted == 1){
			$query=base64_encode('redirect_key=restricted_access&login_data='.$userid.'&redirection='.$frm_redirect.'&course_id='.$course_id.'&is_restricted=1');
		}
		/* vwpr($login_settings['from_email']);
		die(); */
		if( !empty($login_settings['from_email']) ){
			$headers = array('Content-Type: text/html; charset=UTF-8','From: <'.$login_settings['from_email'].'>');
		}else{
			$headers = "Content-Type: text/html; charset=UTF-8";	
		}
		
		$code = sha1( $userid . time() ); 
		$verification_link = add_query_arg( array('key' => $code, 'login_data' => $userid),site_url());
		$title = get_option('blogname');
		$msg=str_replace(array('{username}','{sitename}','{queryparam}','{site_url}'), array($first_name,$title,$query,site_url()), $login_settings['email_body']);
		wp_mail( $email, $login_settings['email_subject'],$msg,$headers);
		
		/* echo "<pre>";print_r($page . $query);die(); */
		/* echo "<pre>";print_r($page . $query);
		die(); */
	}
	
	/* for resend join mail */
	function fn_vw_resend_email(){
		ob_start();
		$frm_redirect = $_POST['redirection'];
		$course_id = $_POST['course_id'];
		$process = $_POST['process'];
		$is_restricted = $_POST['is_restricted'];
		
		if( $process == "resend_verification_link" ){
			$user = get_user_by( 'email', $_POST['user_email'] );
			$user_activation_status = get_user_meta($user->ID,'user_status',true);
			if( !empty($user) && $user_activation_status != 'Active' ){
				$email = $_POST['user_email'];
				$userid = $user->ID;
				$data=base64_encode('redirect_key=join-next-step&login_data='.$userid);
				$verification_link = site_url()."/join-next-step/".$data;
				$op = array(
							'flag' => true,
							'data' => $verification_link
							
						);
			} else if($user_activation_status == 'Active'){
				$info = 'Active';
				$op = array(
					'flag' => false,
					'data' => failed_resend_verification_link($info)
				);
			} else if(empty($user)){
				$info = 'User Not Register';
				$op = array(
					'flag' => false,
					'data' => failed_resend_verification_link($info)
				);
			}
		} else if( $process == "send_verification_link" ){
			$userid = $_POST['userid'];
			$user_info = get_userdata($userid);
			$email = $user_info->user_email;
			$op = true;
		}
		$first_name = get_user_meta($userid,'first_name',true);
		$this->send_join_mail($email,$first_name,$userid,$frm_redirect,$course_id,$is_restricted);
		echo json_encode($op); 
		die();
	}
	
	/* for send email validation(already exists or not)*/
	function fn_vw_email_validation(){
		global $wpdb;
		$email = $_POST['work_email'];
		$user_info = get_user_by_email( $email );
		if($user_info != null){
			$flag = 1;
		}else{
			$flag = 0;
		}
		echo $flag;
		die();
	}
	
	/* for email verification */
	function fn_vw_email_verification(){
		global $wpdb;
		$verification_val = $_POST['verification_val'];
		$userid = $_POST['userid'];
		$base64data = base64_decode( $_POST['encode_url'] );
		parse_str($base64data,$array);
		
		$courseid = $array['course_id'];
		$is_community = get_post($courseid)->post_type;
		
		if( $verification_val == "login" ){
			$user_login = $_POST['user_login'];
			$user_password = $_POST['user_pass'];
			$login_info['user_login'] = $user_login;  
			$login_info['user_password'] = $user_password;
			$title = get_option('blogname');
			update_user_meta($userid,'user_status','Active');
			$toacheck = get_option( 'lx_lms_login_toasetting' );
			if( $toacheck['lms_toa_toggle'] == 'on' ){
				update_user_meta($userid,'user_agreement',strtotime(date('Y-m-d H:i:s')));
			}
			/* wp_signon( $login_info, false ); */
			
			wp_set_current_user($userid);
			wp_set_auth_cookie($userid);
			
			/* delete_user_meta( $userid, 'user_psw' ); */
			
			/** create my fliplist **/
			$fliplistdefault = array(
				'post_title'    => 'My Flip Recordings '.$userid,
				'post_status'   => 'publish',
				'post_type'   => 'flip_list',
				'post_author'   => $userid,
			);
			$insertedid = wp_insert_post( $fliplistdefault );
			update_post_meta($insertedid,'registertimelist','1');
			
			if( $is_community == 'memberpressproduct' ){
				echo get_permalink( $courseid );
			}else{
				echo site_url();
			}
		}elseif( $verification_val == "not_login" ){
			echo site_url().'/login/';
		}elseif($verification_val==''){
			echo site_url().'/resend-verification-link/';
		}
		die();
	}
	function check_the_valid_accesscode(){
		global $wpdb;
		$community_id = $_POST['community_id'];
		$accesscode = $_POST['accesscode'];
		$userid = $_POST['userid'];
		
		$coupon_code = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."postmeta where ".$wpdb->prefix."postmeta.meta_value = '".$community_id."' and ".$wpdb->prefix."postmeta.meta_key = '_mepr_coupons_community_id'");
		/* 1C7C4473 */
		
		
		/* echo "<pre>";print_r($resmembership);
		die(); */
		$json_array = array();
		if(!empty($coupon_code)){
			$coupon_name = get_post( $coupon_code[0]->post_id )->post_title;
			if( $coupon_name == $accesscode ){
				$get_parent=$wpdb->get_results("select post_parent from ".$wpdb->prefix."posts where ID=".$community_id);
				$post_parent = $get_parent[0]->post_parent;
				$which_category = '';
				if( in_category( 'public', $post_parent ) ){
					$which_category = 'public';
				}
				
				$membership=$wpdb->get_results("select memberships from ".$wpdb->prefix."mepr_members where user_id='".$userid."'");
				$ms_ids=explode(',',$membership[0]->memberships);
				
				$resmembership = $membership[0]->memberships.",".$community_id;
				
				$wpdb->insert($wpdb->prefix."mepr_transactions",array('id'=>'','amount'=>'0.00','total'=>'0.00','tax_amount'=>'0.00','tax_rate'=>'0.000','tax_desc'=>'','tax_compound'=>'0','tax_shipping'=>'1','tax_class'=>'standard','user_id'=>$userid,'product_id'=>$community_id,'coupon_id'=>'0','trans_num'=>'','status'=>'complete','txn_type'=>'payment','response'=>NULL,'gateway'=>'free','subscription_id'=>'0','prorated'=>'0','created_at'=>date('Y-m-d H:i:s'),'expires_at'=>'','corporate_account_id'=>'0','parent_transaction_id'=>'0'));
					
				$wpdb->update( $wpdb->prefix."mepr_members", array('memberships' => $resmembership),array('user_id' => $userid ));
				
				if(!in_array($get_parent[0]->post_parent,$ms_ids) && $which_category == 'public' ){
					
					$membership=$wpdb->get_results("select memberships from ".$wpdb->prefix."mepr_members where user_id='".$userid."'");
					/* echo "<pre>";print_r($membership);die(); */
					
					$memberships=$membership[0]->memberships.",".$get_parent[0]->post_parent;
					$insert_transaction = $wpdb->insert($wpdb->prefix."mepr_transactions",array('id'=>'','amount'=>'0.00','total'=>'0.00','tax_amount'=>'0.00','tax_rate'=>'0.000','tax_desc'=>'','tax_compound'=>'0','tax_shipping'=>'1','tax_class'=>'standard','user_id'=>$userid,'product_id'=>$get_parent[0]->post_parent,'coupon_id'=>'0','trans_num'=>'','status'=>'complete','txn_type'=>'payment','response'=>NULL,'gateway'=>'free','subscription_id'=>'0','prorated'=>'0','created_at'=>date('Y-m-d H:i:s'),'expires_at'=>'','corporate_account_id'=>'0','parent_transaction_id'=>'0'));
					$wpdb->update( $wpdb->prefix."mepr_members", array('memberships' => $memberships),array('user_id' => $userid ));
					
				}   
				
				$json_array['msg'] = 'match';
			}else{
				$json_array['msg'] = 'n_exist';
			}
		}else{
			$json_array['msg'] = 'n_exist';
		}
		echo json_encode($json_array);
		/* echo "<pre>";print_r($community_id); */
		wp_die();
	}
	function access_community_fn(){
		global $wpdb;
		/* echo "<pre>";print_r($_POST); */
		$user_id = $_POST['user_id'];
		wp_set_auth_cookie( $user_id );
		echo get_permalink($_POST['community_id']);
		wp_die();
	}
	public function fnajaxagreement(){
		$user_id = get_current_user_ID();
		update_user_meta($user_id,'user_agreement',strtotime(date('Y-m-d H:i:s')));
		wp_die();
	}
}
?>