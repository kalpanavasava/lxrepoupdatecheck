<?php /** * The template for displaying all pages. * * This is the template that displays all pages by default. * Please note that this is the WordPress construct of pages * and that other 'pages' on your WordPress site will use a * different template. * * @package GeneratePress */
if ( ! defined( 'ABSPATH' ) ) {	exit;}	
	get_header();	
	global $lx_lms_settings,$wpdb,$lx_customize_login_plugin_path;	
	include($lx_customize_login_plugin_path.'/assets/css/vw_customize_login.php');	
	$base64_data = base64_decode( end( explode( '/', rtrim( $_SERVER['REQUEST_URI'] , '/' ) ) ) );	
	parse_str($base64_data, $array);	
	$receipt_prefix = $lx_lms_settings['receipt_prefix'];	
	$currentdate = date('d/m/Y');	
	$date_info = str_replace("/","",$currentdate);	
	$old_url = $_SERVER['HTTP_REFERER'];	
	$site_icon=get_option('site_icon');	
	$favicon=wp_get_attachment_image_src( $site_icon , 'full' )[0];	
	$course_info = get_posts(			
				array(				
						'post_type' => 'lx_course',				
						'post_status' => 'publish',				
						'posts_per_page' => -1,				
						'post__in'=> array(
							$array['course_id']
						),				
						'meta_query' => array(				
							array(					
							'key' => 'community_id',
							'compare' => 'NOT EXISTS'					
							),				
						)			
					)		
				);	
	if(!empty($course_info)){
			$purchase_type = 2;	
	} else if(empty($course_info)){		
		$purchase_type = 1;	
	}	
	if(isset($array['redirection_process']) && ( $array['redirection_process']=='login' || $array['redirection_process']=='logincoursepurchase' ) ){		
		$step = 'four';		
		$finished_step = array("Login","Payment");		
		$active_step = 'Receipt';		
		$remaining_step = 0;		
		$step_info = array( 'step' => $step, 'active_step' => $active_step,'finished_step' => $finished_step, 'remaining_step' => $remaining_step );		
	} else if(isset($array['redirection_process']) && $array['redirection_process']=='verification'){				
		$step = 'five';		
		$finished_step = array("Join","Validate Email","Payment");		
		$active_step = 'Receipt';		$remaining_step = 0;		
		$step_info = array( 'step' => $step, 
		'active_step' => $active_step,
		'finished_step' => $finished_step, 
		'remaining_step' => $remaining_step );	
	}	
	$course_id = $array['course_id'];		
	$course_title = get_the_title($course_id);	
	$cost = get_post_meta( $course_id,'lx_course_cost',true );	
	$order_id = $array['order_id'];	
	$get_lx_receipt_CIDE = get_option('lx_receipt_CIDE');	
	if(empty($get_lx_receipt_CIDE)){		
		$lx_receipt_CIDE_inc = 1;	
	} else{		
		$lx_receipt_CIDE_inc = $get_lx_receipt_CIDE+1;	
	}	
	$receipt_prefix = $lx_lms_settings['receipt_prefix'];	
	$currentdate = date('d/m/Y');	
	$date_info = str_replace("/","",$currentdate);	
	$course_info = get_posts(	
						array(		
							'post_type' => 'lx_course',		
							'post_status' => 'publish',	
							'posts_per_page' => -1,	
							'post__in'=> array($course_id),	
							'meta_query' => array(		
								array(			
								'key' => 'community_id',	
								'compare' => 'NOT EXISTS'	
								),		
							)
						)
					);	
	if(!empty($course_info)){		
		$purchase_type = 2;	
	} else if(empty($course_info)){		
		$purchase_type = 1;	
	}	
	$count_main = 4;	
	$count_lx_receipt_CIDE = strlen($lx_receipt_CIDE_inc);	
	$count_lx_receipt_CIDE_digit = $count_main - $count_lx_receipt_CIDE;	
	if($count_lx_receipt_CIDE_digit == 3){		
		$receipt_CIDE = '000'.$lx_receipt_CIDE_inc;	
	} elseif($count_lx_receipt_CIDE_digit == 2){		
		$receipt_CIDE = '00'.$lx_receipt_CIDE_inc;	
	} elseif($count_lx_receipt_CIDE_digit == 1){		
		$receipt_CIDE = '0'.$lx_receipt_CIDE_inc;	
	} elseif($count_lx_receipt_CIDE_digit == 0){		
		$receipt_CIDE = $lx_receipt_CIDE_inc;	
	}	
	$get_transaction_date = get_post_meta($order_id,'lx_trans_date',true);	
	$get_date_filter_date = 
		get_posts(		
					array(			
						'post_type' => 'lx_course_order',	
						'post_status' => 'publish',		
						'posts_per_page' => -1,			
						'order'  => 'ASC',		
						'meta_query' => array(	
							'relation' => 'AND',			
							array(				
								'key' => 'lx_trans_date',	
								'value' => $get_transaction_date	
							),			
							array(			
								'key' => 'lx_order_status',		
								'value' => 'paid'			
							),		
						)	
					)
			);	
	foreach( $get_date_filter_date as $key => $value ){		
		if($value->ID == $order_id){			
			$key_info = $key+1;		
		}	
	}
	
	$count_lx_trans_number = strlen($key_info);	
	$count_trans_number_digit = $count_main - $count_lx_trans_number;	
	if($count_trans_number_digit == 3){		
		$receipt_trans_number = '000'.$key_info;	
	} elseif($count_trans_number_digit == 2){		
		$receipt_trans_number = '00'.$key_info;	
	} elseif($count_trans_number_digit == 1){		
		$receipt_trans_number = '0'.$key_info;	
	} elseif($count_trans_number_digit == 0){		
		$receipt_trans_number = $key_info;	
	}	
	
	$receipt_number = $receipt_prefix."".$purchase_type."".$receipt_CIDE."".$date_info."".$receipt_trans_number;
	$temp_order_id = get_post_meta( $order_id,'lx_order_asp_id',true );	
	$EmailofPayee = get_post_meta( $temp_order_id,'order_data',true );	
	$date_paid = get_posts( $order_id )[0]->post_date;  	
	$old_date_timestamp = strtotime($EmailofPayee['purchase_date']);	
	$date_paid = date('d/m/Y', $old_date_timestamp);   	
	$time_paid = date('h:i A', strtotime($EmailofPayee['purchase_date']));
?>	
	<div class="lp-screen" style="display:none;">
		<span>
			<img class="user_interface_loader_img" src="<?php echo get_stylesheet_directory_uri().'/assets/loader/05.svg'?>">
		</span>
	</div>	
	<input type="hidden" id="hd_courseid" value="<?php echo $array['course_id']; ?>" />	<input type="hidden" id="hd_orderid" value="<?php echo $array['order_id']; ?>" />	
	<input type="hidden" class="get_increment" value="no" />	
	<div class="modal vw_customize_login_main vw_receipt_and_access" tabindex="-1" role="dialog" id="modal_join" style="display:block;position:relative !important;">		
		<div class="modal-dialog" role="document">			
			<div class="modal-content text-center">				
				<div class="modal-header">					
					<div class="main_header_div">						
					<?php							
					header_info();				
					?>					
					</div>				
				</div>				
				<div class="modal-body receipt_and_access_main_div">					
					<span>RECEIPT AND ACCESS</span>					
					<hr/>					
					<?php						
					if(isset($array['redirection_process']) && !empty($array['redirection_process'])){
						lx_steps_info($step_info);						
					}					
					?>	
					<div style="margin-top:10px;">				
						Your payment was successful.				
					</div>					
					<div style="margin-top:10px;">					
						An email has been sent to you with your payment receipt.  Please select what you would like to do next.					
					</div>					
					<div style="padding:20px;">
						<button class="btn_normal_state" name="print_receipt" id="print_receipt">PRINT RECEIPT</button>
						<?php 
						$returntositeurl = site_url();
						if( !empty($array['course_id']) ){
							$returntositeurl = get_permalink($array['course_id']);
						}
						?>
						<a href="<?php echo $returntositeurl; ?>" style="margin-left:20px;">
						<button class="btn_normal_state return_to_site" name="return_to_site">RETURN TO SITE</button></a>
					</div>			
				</div>			
			</div>		
		</div>	
	</div>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>	
	<div id="content" class="receipt_content pt-4 pl-4">		
		<div class="receipt_logo_header" style="display: flex;">			
			<div style="width: 90%;">				
				<img src="<?php echo $favicon; ?>" class="receipt_favicon" />		
			</div>			
			<div>			
				<strong class="receipt_header_text">RECEIPT</strong>			
			</div>				
		</div>		
		<br/>	
		<br/>	
		<div class="" style="width:50%;margin:0 auto;">
			<div class="receipt_font">Course Name: <?php echo $course_title; ?></div>	
				<br/>	
				<br/>	
			<div class="receipt_font">
				Course Cost: <?php echo $lx_lms_settings['course_currency_setting'].''.$lx_lms_settings['course_currency_symbol'].''.$cost; ?>
			</div>	
			<br/>	
			<br/>	
			<div class="receipt_font">Date Paid: <?php echo $date_paid." ".$time_paid; ?></div>		
			<br/>	
			<br/>	
			<div class="receipt_font">Email of Payee: <?php echo $EmailofPayee['stripeEmail']; ?></div>	
			<br/>	
			<br/>
			<div class="receipt_font">Receipt Number: <?php echo $receipt_number; ?></div>	
		</div>
	</div>
	<?php 	get_footer();?>
	<script>
	jQuery('#print_receipt').click(function() {	
		jQuery('.lp-screen').show();	
		setTimeout(function(){	
		jQuery('.lp-screen').hide();
	},3000);	
	jQuery('.receipt_content').css('display','block');	
	var options = {	};	
	var pdf = new jsPDF('p', 'pt', 'a4');	
	pdf.addHTML(jQuery("#content"), 5, 15, options, function() {	
	pdf.save('receipt.pdf');	
	if(jQuery('.get_increment').val()=='no'){		
	<?php update_option( 'lx_receipt_CIDE', $lx_receipt_CIDE_inc ); ?>	
	}		
	jQuery('.get_increment').val('yes');	
	});	jQuery('.receipt_content').css('display','none');});
	jQuery(".vw_receipt_and_access").keydown(function(event) {   
	return false;});
	</script>