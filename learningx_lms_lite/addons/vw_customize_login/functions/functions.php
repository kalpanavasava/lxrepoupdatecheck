<?php
/* for failed resend verification link */
function failed_resend_verification_link($info){
	ob_start();
	global $lx_customize_login_plugin_path,$color_palette;
	include($lx_customize_login_plugin_path.'/assets/css/vw_customize_login.php');
	?>
	<style>
	a,a:hover{
		color:<?php echo $color_palette['hyperlinks']; ?> !important;
	}
	</style>
	<?php 
		if( $info == "User Not Register" ){ ?>
			<div class="error_msg_div">
				<div class="alert alert-danger">
					<i class="fa fa-exclamation-circle"></i>
					<span class="invalid_error_msg">This email is incorrect, or has not been registered.</span>
				</div>
			</div>
			<div>
				<a href="<?php echo site_url().'/login/?info=register_info';?>" class="btn_register_info"><button class="btn_normal_state btn_register">Register</button></a>
			</div>
			<div class="verification_faild_main_div text-center">
				<div>
					Bots love to try and get into sites using these types of forms.
					So we're sorry, but for security reasons we can't allow additional attempts.
				</div>
				<div>
					You can either try and register again, <a href="<?php echo 'mailto:'.get_option('admin_email'); ?>">contact us</a>,
				</div>
				<div>
					or close this window and return to the site.
				</div>
			</div>
	<?php	
		}
		if( $info == "Active" ){ ?>
			<div>
				<span>
					It look like email already exists and has been validated. You can either login, or reset your password.
				</span>
			</div>
			<div class="forgot_password_link">
				<span class="d-block text-center mt-2 small uwp-forgot-password-link forgot_pwd_css open_forgot_modal">forgot password</span>
			</div>
			<div><a href="<?php echo site_url().'/login/' ?>"><button name="btn_login" class="btn_normal_state btn_verify_login">Login</button></a></div>
	<?php
		}
	$op = ob_get_clean();
	return $op;
}

/* function for set colour Brightness for steps indicators */
function colourBrightness($hex, $percent) {
	$hash = '';
	if (stristr($hex, '#')) {
		$hex = str_replace('#', '', $hex);
		$hash = '#';
	}
	$rgb = [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];
	for ($i = 0; $i < 3; $i++) {
		if ($percent > 0) {
			$rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1 - $percent));
		} else {
			$positivePercent = $percent - ($percent * 2);
			$rgb[$i] = round($rgb[$i] * (1 - $positivePercent));
		}
		if ($rgb[$i] > 255) {
			$rgb[$i] = 255;
		}
	}
	$hex = '';
	for ($i = 0; $i < 3; $i++) {
		$hexDigit = dechex($rgb[$i]);
		if (strlen($hexDigit) == 1) {
			$hexDigit = "0" . $hexDigit;
		}
		$hex .= $hexDigit;
	}
	return $hash . $hex;
}

/* function for set steps */
function lx_steps_info($step_info){
	/* echo "<pre>";print_r($step_info); */
	if( $step_info['step'] == 'three' && $step_info['is_login_access'] != 1){
		$steps = array('Provide details','Validate Email','Access');
	}elseif($step_info['step'] == 'four' && $step_info['is_restricted'] == '1'){
		$steps = array('Join','Validate email','Access code','Access');
	}elseif($step_info['step'] == 'three' && $step_info['is_restricted'] == '1' && $step_info['is_login_access'] == 1){
		$steps = array('Login','Access code','Access');
	}else if( $step_info['step'] == 'four' ){
		$steps = array('Login','Payment','Receipt','Access');
	} else if( $step_info['step'] == 'five' ){
		$steps = array('Join','Validate Email','Payment','Receipt','Access');
	}
	$active_step = $step_info['active_step'];
	$remaining_step = $step_info['remaining_step'];
?>
	<div class="pt-2">
		<ul class="ul_steps" style="margin-top:30px !important;">
		<?php
			$k = 1;
			foreach( $steps as $value ){ 	
				if( $value == $active_step ){
					$class_info = 'follow_step';
					$remaining_step_class ='';
				} else{
					$class_info = 'not_follow_steps';
					$remaining_step_class ='remaining_steps';
				}
				if( in_array($value,$step_info['finished_step'])){
					$finished_step = 'finished_step';
					$remaining_step_class ='';
				} else{
					$finished_step = '';
				}
				if( $value == $active_step || in_array($value,$step_info['finished_step'])){
					$steps_margin = 'steps_margin';
				} else{
					$steps_margin = '';
				}
				if($active_step == 'Receipt' && $value == "Access"){
					$class_info = 'follow_step';
					$remaining_step_class ='';		
				}
			?>
			<li class="<?php echo $class_info." ".$finished_step; ?> lx_steps_info_li">
				<div class="step_info_text_main">
					<div <?php if(!empty($steps_margin)){ ?>class="<?php echo $steps_margin; ?>"<?php } ?>><?php echo $k; ?></div>
					<?php if( $value == 'Validate Email' ){ ?>
						<div class="step_info_text step_info_text_info <?php echo $remaining_step_class; ?>">Validate</div>
						<div class="step_info_text <?php echo $remaining_step_class; ?>">Email</div>
					<?php } else if( $value == 'Provide details' ){ ?>
						<div class="step_info_text step_info_text_info <?php echo $remaining_step_class; ?>">Provide</div>
						<div class="step_info_text <?php echo $remaining_step_class; ?>">details</div>
					<?php } else{ ?>
						<div class="step_info_text <?php echo $remaining_step_class; ?>"><?php echo $value; ?></div>
					<?php } ?>
				</div>
			</li>
		<?php
			$k++;
			}
		?>
		</ul>
	</div>
	<?php
	return;
}
