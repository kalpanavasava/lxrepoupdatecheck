<?php
global $lx_lms_course_url,$lx_lms_course_path;
$lx_lms_course_url=plugin_dir_url(__FILE__);
$lx_lms_course_path=plugin_dir_path(__FILE__);
 /******************* Shortcodes**********************/
 include(dirname(__FILE__).'/includes/shortcodes/save_courses.php');
 include(dirname(__FILE__).'/includes/shortcodes/save_flip_content.php');
 include(dirname(__FILE__).'/includes/shortcodes/save_XAPI_content.php'); 
 include(dirname(__FILE__).'/includes/shortcodes/get_flip_content.php');
 
 /* include(dirname(__FILE__).'/includes/manually_update_lession_status_forallusers.php'); */
 /******************* End Shortcodes********************/
 
 /********************Ajax File***********************/
include(dirname(__FILE__).'/includes/ajax/save_media.php');
include(dirname(__FILE__).'/classes/class_lx_main.php');
$init_all = new lx_main();
/********************End Ajax File*******************/

 /********************Function File***********************/
include(dirname(__FILE__).'/functions/functions.php');
/********************End Function File*******************/
 
 add_action( 'wp_enqueue_scripts', 'my_custom_script_load',20);
function my_custom_script_load() {
	$plugin_path =  plugin_dir_url(__FILE__);
	wp_enqueue_style('bootstap_css', $plugin_path.'css/bootstrap/css/bootstrap.min.css');
	wp_enqueue_style('copper_css', $plugin_path.'css/cropper.css');
	wp_enqueue_script( 'copper_js', $plugin_path.'js/cropper.js', array( 'jquery' ) );
	wp_enqueue_script( 'vw_lesson_action', $plugin_path.'js/lesson_actions.js', array( 'jquery' ) );
}
function test_footer_script(){
	$plugin_path =  plugin_dir_url(__FILE__);
	wp_enqueue_script( 'front_js', $plugin_path.'js/front.js', array( 'jquery' ));
}
if ( ! is_admin() ) {
	add_action( 'wp_enqueue_scripts', 'test_footer_script',20,'','in_footer');
}
function dynamic_course_css(){
	$plugin_path = plugin_dir_path(__FILE__);
	if(is_page('create-courses') || is_page('create-flip-content') || is_page('create-xapi-content'))
	{
		include($plugin_path.'/css/save_media.php');
	}
}
add_action('wp_head','dynamic_course_css');
/**
** @MAX GALLERIA **
** - Customization of the max alleria plugin for passing static image **
**/
	function max_gallary_vw_sc( $args ){
		
			global $mx_arr_vw;  /* Making varaible global for passing the array to the max galleria */
			
			$all_images = shortcode_atts( array(
				'images'=> ''
			), $args );	
			
			$mx_arr_vw = explode(',',$all_images['images']); /* array of the images */
			
			echo do_shortcode('[maxgallery name="image-gallary"]');  /*  displaying the max galleria shortcode */
	}
	
	add_shortcode('max_gallary_vw_sc','max_gallary_vw_sc');

/** 
** @FL1P Public Function **
** - Making function global for passing the array to the max galleria  **
**/
	
	function max_gallary_vw_fn(){
			global $mx_arr_vw;
			return $mx_arr_vw;
	}


/**
** Customization End **
**/

include( $lx_lms_course_path. '/classes/class_lx_course_main.php' );
$lx_courses_main = new lx_courses_main();

/* function for make a entry on lx_order */
function vw_fn_ckeck_order(){
	$url = $_SERVER['REQUEST_URI']; 
	$old_url = $_SERVER['HTTP_REFERER'];
	$base64_data = base64_decode( end( explode( '/', rtrim( $_SERVER['HTTP_REFERER'] , '/' ) ) ) );
	parse_str($base64_data, $array);
	if (strpos($url, "/stripe-checkout-result/") !== false) { 
		global $wpdb;
		if ( ! is_admin() ) {
			require_once( ABSPATH . 'wp-admin/includes/post.php' );
		}
		$sess    = ASP_Session::get_instance();
		$aspData = $sess->get_transient_data( 'asp_data' );
		
		if(!empty($sess) && !empty($aspData)){
			if( isset( $aspData['error_msg'] ) && ! empty( $aspData['error_msg'] ) ) {
			} else{
				$args=array(
					'post_type' => 'stripe_order' , 
					'posts_per_page' => -1,	
					'post_status'=>'publish',
					'meta_query' => array(
					'relation' => 'AND',
					   array(
						   'key' => 'asp_product_id',
						   'value' => $aspData['product_id'],
						   'compare' => '='
					   ),
					   array(
						   'key' => 'asp_user_id',
						   'value' => get_current_user_id(),
						   'compare' => '='
					   ),
					   array(
						   'key' => 'asp_order_status',
						   'value' => 'paid',
						   'compare' => '='
					   ),
					   array(
						   'key' => 'trans_id',
						   'value' => $aspData['charge']['id'],
						   'compare' => '='
					   ),
					)
				);
				$temp_course_content=get_posts($args);
				if(!empty($temp_course_content)){
					/* $fount_post = post_exists( 'course 1 cat1','','','lx_course','publish'); */
					/* $fount_post = explode('##',get_the_title($aspData['product_id']))[0]; */
					$fount_post = str_replace("#","",$aspData['charge_description']);
					
					if($fount_post !=0){
						$order_args = array(
							'comment_status' => $temp_course_content[0]->comment_status,
							'ping_status'    => $temp_course_content[0]->ping_status,
							'post_author'    => $temp_course_content[0]->post_author,
							'post_content'   => $temp_course_content[0]->post_content,
							'post_excerpt'   => $temp_course_content[0]->post_excerpt,
							'post_name'      => $temp_course_content[0]->post_name,
							'post_parent'    => $temp_course_content[0]->post_parent,
							'post_password'  => $temp_course_content[0]->post_password,
							'post_status'    => 'publish',
							'post_title'     => $temp_course_content[0]->post_title,
							'post_type'      => 'lx_course_order',
							'to_ping'        => $temp_course_content[0]->to_ping,
							'menu_order'     => $temp_course_content[0]->menu_order
						);
						$check_post_args=array(
							'post_type' => 'lx_course_order' , 
							'posts_per_page' => -1,	
							'post_status'=>'publish',
							'meta_query' => array(
							'relation' => 'AND',
							   array(
								   'key' => 'lx_product_id',
								   'value' => $fount_post,
								   'compare' => '='
							   ),
							   array(
								   'key' => 'lx_order_user_id',
								   'value' => get_current_user_id(),
								   'compare' => '='
							   ),
							   array(
								   'key' => 'lx_order_status',
								   'value' => 'paid',
								   'compare' => '='
							   ),
							   array(
								   'key' => 'lx_trans_id',
								   'value' => $aspData['charge']['id'],
								   'compare' => '='
							   ),
							)
						);
						
						$lx_course_order = get_posts($check_post_args);
						if(empty($lx_course_order)){
							$new_order_course_id = wp_insert_post($order_args);
							$get_post_meta = get_post_meta( $temp_course_content[0]->ID );
							update_post_meta($new_order_course_id, 'lx_order_asp_id', $temp_course_content[0]->ID);
							$pi_id = $get_post_meta['pi_id'][0];
							$asp_product_id = $get_post_meta['asp_product_id'][0];
							$asp_order_status = $get_post_meta['asp_order_status'][0];
							$asp_order_events = $get_post_meta['asp_order_events'][0];
							$asp_user_id = $get_post_meta['asp_user_id'][0];
							$order_data = $get_post_meta['order_data'][0];
							$charge_data = $get_post_meta['charge_data'][0];
							$trans_id = $get_post_meta['trans_id'][0];
							update_post_meta($new_order_course_id, 'lx_pi_id', $pi_id);
							update_post_meta($new_order_course_id, 'lx_product_id', $fount_post);
							update_post_meta($new_order_course_id, 'lx_order_status', $asp_order_status);
							update_post_meta($new_order_course_id, 'lx_order_events', $asp_order_events);
							update_post_meta($new_order_course_id, 'lx_order_user_id', $asp_user_id);
							update_post_meta($new_order_course_id, 'lx_order_data', $order_data);
							update_post_meta($new_order_course_id, 'lx_charge_data', $charge_data);
							update_post_meta($new_order_course_id, 'lx_trans_id', $trans_id);
							update_post_meta($new_order_course_id, 'lx_trans_date', date("d-m-Y"));
							$data=base64_encode('redirect_key=print-receipt&order_id='.$new_order_course_id.'&course_id='.$fount_post.'&redirection_process='.$array['redirection_process']);
							$redirection = site_url()."/print-receipt/".$data;
							
							
							$user_id = get_current_user_ID();
							$totalpaidcoursear = get_user_meta( $user_id , 'course_paid', true );
							
							$getchildcourses = $wpdb->get_results("select pm.* from ".$wpdb->prefix."posts as p, ".$wpdb->prefix."postmeta as pm where p.ID=pm.post_id and pm.meta_key='lx_associated_macro_course' and pm.meta_value like '".$fount_post."' and p.post_status='publish' and p.post_type='lx_course';");
					
							$totalpaidcoursear = get_user_meta( get_current_user_ID() , 'course_paid', true );
					
							$all_child_course = array();$total_carray = array();
							$all_child_course[] = $fount_post;
							$total_carray[] = $fount_post;
							if(!empty($getchildcourses)){
								foreach( $getchildcourses as $chc ){
									$total_carray[] = $chc->post_id;
									if(!empty($totalpaidcoursear)){
										if(!in_array($chc->post_id,$totalpaidcoursear)){
											$all_child_course[] = $chc->post_id;
										}
									}else{
										$all_child_course[] = $chc->post_id;
									}
								}
							}else{
								foreach( $totalpaidcoursear as $chc ){
									$total_carray[] = $chc;
								}
							}
							
							update_user_meta( $user_id ,'course_paid',$total_carray );
							/* echo "<pre>";print_r($total_carray);
							die(); */
							foreach( $all_child_course as $crsid ){
								$webooksettings = get_option('currentwebhookon',true);
								
								if( $webooksettings['course'] == 1 ){
									$is_course_webhookexist = $wpdb->get_results("select * from ".$wpdb->prefix."vw_coursewebhook_master where courseid='".$crsid."'");
									
									if( $is_course_webhookexist[0]->act_enrolled == 1 ){
										$salesforcesetting = get_option('salesforce_environment',true);
										$apis = array_values( $salesforcesetting[$salesforcesetting['environment']] );
										$Auth = SFAPIAuthentication( $apis );
										$auth_token = json_decode( $Auth )->access_token;
										$instance_url = json_decode( $Auth )->instance_url;
										$authenticationar = array('auth_token'=>$auth_token,'instance_url'=>$instance_url);
										
										
										$coursetitle = get_post($crsid)->post_title;
										$comid = get_post_meta($crsid,'lx_attach_this_course',true);
										$commtitle = get_post($comid)->post_title;
										
										$payload_array['Email__c'] = get_userdata($user_id)->user_email;
										$payload_array['FirstName'] = get_user_meta($user_id,'first_name',true);
										$payload_array['LastName'] = get_user_meta($user_id,'last_name',true);
										$payload_array['company'] = get_option('blogname',true);
										$payload_array['CommunityId__c'] = $comid;
										$payload_array['Community_Name__c'] = $commtitle;
										$payload_array['CourseId__c'] = $crsid;
										$payload_array['Course_Name__c'] = $coursetitle;
										$payload_array['Action__c'] = 'Enrolled';
										$payload_array['Form_Type__c'] = 'Course';
										
										$generated_lead = SFAPICreateNewLead( $authenticationar , json_encode( $payload_array ) );
										if( !empty(json_decode( $generated_lead )->id) ){
											$wpdb->insert($wpdb->prefix.'vw_coursewebhook_payload',array('userid'=>$user_id,'com_id'=>$comid,'course_id'=>$crsid,'action'=>'Enrolled','response'=>$generated_lead,'date_created'=>date('Y-m-d H:i:s')));
										}
									}
								}
							}
							?>
							<script>
								window.location = "<?php echo $redirection; ?>";
							</script>
							<?php
						} 
					}
				}
			}			
		}
	}
}
add_action("wp_head",'vw_fn_ckeck_order');