<?php 
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package GeneratePress
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; /*  Exit if accessed directly. */
}
	get_header();
	global $lx_customize_login_plugin_path,$lx_lms_settings;
	include($lx_customize_login_plugin_path.'/assets/css/vw_customize_login.php');
	$base64_data = base64_decode( end( explode( '/', rtrim( $_SERVER['REQUEST_URI'] , '/' ) ) ) );
	parse_str($base64_data, $array);
	if(isset($array['redirection_process']) && $array['redirection_process']=='login'){
		$step = 'four';
		$finished_step = array("Login");
		$active_step = 'Payment';
		$remaining_step = 2;
		$step_info = array( 'step' => $step, 'active_step' => $active_step,'finished_step' => $finished_step, 'remaining_step' => $remaining_step );	
	} else{		
		$step = 'five';
		$finished_step = array("Join","Validate Email");
		$active_step = 'Payment';
		$remaining_step = 2;
		$step_info = array( 'step' => $step, 'active_step' => $active_step,'finished_step' => $finished_step, 'remaining_step' => $remaining_step );
	}
	$course_cost=get_post_meta($array['course_id'],'lx_course_cost',true);
	?>
	<div class="lp-screen" style="display:none;"><span><img class="user_interface_loader_img" src="<?php echo get_stylesheet_directory_uri().'/assets/loader/05.svg'?>"></span></div>
		<input type="hidden" id="hd_userid" value="<?php echo $userid; ?>" />
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
						<span>PAYMENT METHOD</span>
						<hr/>
						<?php
							
							lx_steps_info($step_info);
						?>
						<div style="margin-top:10px;">
							Great.
						</div>
						<div style="margin-top:10px;">
							Confirm your product, and enter your payment details.
						</div>
						<div class="lx_payment_buttons_main_div">
							<div>
								<?php 
									global $wpdb;
									$community_id=get_post_meta($array['course_id'],'community_id',true);
									if($community_id!='' && $community_id>0){
										$user_id=get_current_user_id();
										$member=$wpdb->get_results('select memberships from '.$wpdb->prefix.'mepr_members where user_id='.$user_id);
										$memberships=explode(',',$member[0]->memberships);
									}
									if($community_id!='' && $community_id>0  && !in_array($community_id,$memberships)){
										
										?>
										<div style="width:50%;">
											<a href="<?php echo get_permalink($community_id);?>">
												<button class="btn_normal_state" style="position: relative;margin:2px;">Purchase</button>
											</a>
										</div>
										<?php
									}else{
										echo do_shortcode( '[accept_stripe_payment id="'.$array['course_id'].'" description="#'.$array['course_id'].'" name="'.get_the_title( $array['course_id'] ).'" price="'.$course_cost.'" class="btn_normal_state btn_lx_course_purchase" button_text="Pay Now" billing_address="0" shipping_address="0" payment_info= "custom_payment" currency="'.$lx_lms_settings['course_currency_setting'].'"]');
									}
								?>
							</div>
							<div>
								<a href="<?php echo site_url(); ?>" style="margin-left:20px;"><button class="btn_normal_state return_to_site" name="return_to_site">RETURN TO SITE</button></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php 
	get_footer();
?>