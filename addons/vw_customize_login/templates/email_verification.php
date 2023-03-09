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
		exit;  /* Exit if accessed directly. */
	}
	get_header();
	?>
	<form method="post">
	<?php
	$site_icon=get_option('site_icon');
	$favicon=wp_get_attachment_image_src( $site_icon , 'full' );
	$title = get_option('blogname');
	global $wpdb,$lx_customize_login_plugin_path;
	include($lx_customize_login_plugin_path.'/assets/css/vw_customize_login.php');
	$url = $_SERVER['REQUEST_URI']; 
	$base64_data = base64_decode( end( explode( '/', rtrim( $_SERVER['REQUEST_URI'] , '/' ) ) ) );
	parse_str($base64_data, $array);
	
	/* echo "<pre>";print_r($array); */
	
	$data = base64_encode('redirect_key=lx_payment&login_data='.$array['login_data'].'&redirection='.$array['redirection'].'&course_id='.$array['course_id'].'&redirection_process=verification');
	
	if ( $array['redirect_key'] == 'email-verification' && !empty($array['login_data'])) {
		$userid = $array['login_data'];
		$user_activation_status = get_user_meta($userid,'user_status',true);
	
		if(is_user_logged_in()){ ?> 
			<script>
				window.location = "<?php echo site_url(); ?>";
			</script>
			<?php
		} else{
			if($user_activation_status == "Inactive"){
				$user_password = get_user_meta($userid,'user_psw',true);
				$user_info = get_user_by('ID', $userid);
				$user_login = $user_info->user_login;
				$login_info = array();  
				$login_info['user_login'] = $user_login;  
				$login_info['user_password'] = $user_password;
				?>
				<input type="hidden" name="user_login" id="user_login" value="<?php echo $user_login; ?>" />
				<input type="hidden" name="user_pass" id="user_pass" value="<?php echo $user_password; ?>" />
				<input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>" />
				<input type="hidden" name="redirection" id="redirection" value="<?php echo $array['redirection']; ?>" />
				<input type="hidden" name="url_info" id="url_info" value="<?php echo $array['redirection']; ?>" />
				<input type="hidden" name="redirect_url_info" id="redirect_url_info" value="<?php echo get_permalink($array['course_id']); ?>" />
				<?php
				$msg = 'The email is successfully verified.';
				$btn_text = "Continue";
				$verification_val = 'login';
				
			}else if($user_activation_status == "Active"){
				$msg = 'Your email is already verified. Please login to continue.';
				$btn_text = "Login";
				$verification_val = 'not_login';
			}
		}
	}
?>
	<div class="modal pt-4" tabindex="-1" role="dialog" id="modal_join" style="display:block;position:relative !important;">
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
					<span>ACCESS</span>
					<hr>
					<?php
						$redirection=$array['redirection'];
						if($redirection=='purchase'){
							$step = 'five';
							$finished_step = array('Join');
							$active_step = 'Validate Email';
							$remaining_step = 3;
						}else{
							$step = 'three';
							$finished_step = array("Provide details","Validate Email");
							$active_step = 'Access';
							$remaining_step = '';
						}
						$step_info = array( 'step' => $step, 'active_step' => $active_step,'finished_step' => $finished_step, 'remaining_step' => $remaining_step );
						lx_steps_info($step_info);
					?>
					<div class="mt-2"><?php echo $msg; ?></div>
					<span class="verification_err"></span>
					<div style="padding:20px;">
						<button class="btn_normal_state btn_verification" name="btn_verification" data-info="<?php echo $verification_val; ?>" data-encode_url="<?php echo $data; ?>"><?php echo $btn_text; ?></button>
					</div>
				</div>
			</div>
		</div>
	</div>
	</form>
<?php 
	get_footer();
?>