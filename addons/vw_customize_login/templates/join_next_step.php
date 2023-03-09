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
//sleep(3);
	if ( ! defined( 'ABSPATH' ) ) {
		exit; /* Exit if accessed directly. */
	}
	get_header();
	global $font_family,$color_palette;
	$site_icon=get_option('site_icon');
	$favicon=wp_get_attachment_image_src( $site_icon , 'full' );
	$title = get_option('blogname');
	$activation_key = $_GET['key'];
	$base64_data = base64_decode( end( explode( '/', rtrim( $_SERVER['REQUEST_URI'] , '/' ) ) ) );
	parse_str($base64_data, $array);
	/* echo "<pre>";print_r($array); */
	$redirection=$array['redirection'];
	$userid = $array['login_data'];
	global $lx_customize_login_plugin_path;
	include($lx_customize_login_plugin_path.'/assets/css/vw_customize_login.php');
	?>
	<div class="lp-screen" style="display:none;"><span><img class="user_interface_loader_img" src="<?php echo get_stylesheet_directory_uri().'/assets/loader/05.svg'?>"></span></div>
	<input type="hidden" id="hd_userid" value="<?php echo $userid; ?>" />
	<input type="hidden" name="is_restricted" id="is_restricted" value="<?php if($array['is_restricted'] == 1){echo $array['is_restricted'];}else{echo '0';} ?>" />
	<input type="hidden" name="redirection" id="redirection" value="<?php echo $array['redirection']; ?>" />
	<input type="hidden" name="course_id" id="course_id" value="<?php echo $array['course_id']; ?>" />
	<div class="modal vw_customize_login_main" tabindex="-1" role="dialog" id="modal_join" style="display:block;position:relative !important;">
		<div class="modal-dialog" role="document">
			<div class="modal-content text-center">
				<div class="modal-header">
					<div class="main_header_div">
						<?php
							header_info();
						?>
					</div>
				</div>
				<div class="modal-body">
					<label class="text-uppercase lp_label">Email Validation</label>
					<hr/>
					<?php
						$is_restricted = 0;
						if($redirection=='purchase'){
							$step = 'five';
							$finished_step = array("Join");
							$active_step = 'Validate Email';
							$remaining_step = 3; 
						}elseif($array['is_restricted'] == 1){
							$step = 'four';
							$finished_step = array("Join");
							$active_step = 'Validate email';
							$remaining_step = 2; 
							$is_restricted = $array['is_restricted'];
						}else{
							$step = 'three';
							$finished_step = array("Provide details");
							$active_step = 'Validate Email';
							$remaining_step = 1; 
						}
							/* echo "<pre>";print_r($array); */
						
						$step_info = array( 'step' => $step, 'active_step' => $active_step,'finished_step' => $finished_step, 'remaining_step' => $remaining_step ,'is_restricted'=>$is_restricted);
						lx_steps_info($step_info);
					?>
					<div style="margin-top:10px">Thank You!</div>
					<div style="margin-top:10px;font-weight: 700;">
						You will need to verify your email before continuing.
					</div>
					<div>
						Go to your email account and click the link in the verification email.
					</div>
					<div style="margin:0 15px;"><strong>1st time access:</strong> When You view the email and click the link, it will open another tab, where you can access your learning.</div>
					<div style="margin-top:10px;">
						Don't have the email? Check your junk/spam folders or resend it.
					</div>
					<div style="padding:20px;"><button class="btn_normal_state resend_email" name="resend_email">Resend email</button></div>
				</div>
			</div>
		</div>
	</div>
<?php 
	get_footer();
?>