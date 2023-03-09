<?php 
/**** for login settings ui ****/
global $square_icon;
?>
<div class="container login_setting lx_lms_setting">
	<form id="login_setting_form" method="post">
	<div class="row lx_lms_settings_top pt-5">
		<div class="col-md-12 admin_section_title">
			<h4 class="head_h4">LOGOUT SETTINGS</h4>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="logintimeout" class="col-form-label">Time out</label>
		</div>
		<div class="col-md-3">
			<input type="number" class="form-control logintimeout" id="logintimeout" name="logintimeout" value="<?php echo $login_settings['logintimeout'];?>">
		</div>
		<div class="col-md-6 d-flex align-items-center" style="margin-left: -20px;"><i class="font_gray">(Hours)</i></div>
	</div>
	<div class="row lx_lms_settings_top">
		<div class="col-md-12 admin_section_title">
			<h4 class="head_h4">LOGIN SETTINGS</h4>
		</div>
	</div>
	<div class="row pt-2">
		<div class="col-md-12">
			<label for=""><h4 class="head_h4">Email Verification</h4></label>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="email_subject" class="col-form-label">Subject</label>
		</div>
		<div class="col-md-3">
			<input type="text" class="form-control email_subject" id="email_subject" name="login_setting[email_subject]" value="<?php echo $login_settings['email_subject'];?>">
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="from_email" class="col-form-label">From Email</label>
		</div>
		<div class="col-md-3">
			<input type="text" class="form-control from_email" id="from_email" name="login_setting[from_email]" value="<?php echo $login_settings['from_email'];?>">
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="email_body" class="col-form-label">Body</label>
		</div>
		<div class="col-md-8">
			<?php
				wp_editor( $login_settings['email_body'], 'email_body' ,array('quicktags' => true,'textarea_name'=>'login_setting[email_body]'));
			?>
		</div>
	</div>
	<div class="row form-group admin_section_title">
		<div class="col-md-12">
			<h4 class="head_h4">ReCAPTCHA ON LOGIN</h4>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="site_key" class="col-form-label">Site Key</label>
		</div>
		<div class="col-md-3">
			<input type="text" class="form-control site_key" id="site_key" name="login_setting[site_key]" value="<?php echo $login_settings['site_key'];?>">
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="secret_key" class="col-form-label">Secret Key</label>
		</div>
		<div class="col-md-3">
			<input type="text" class="form-control secret_key" id="secret_key" name="login_setting[secret_key]" value="<?php echo $login_settings['secret_key'];?>">
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<?php 
	$login_toa_settings = get_option( 'lx_lms_login_toasetting' );
	$toatogglechecked = '';
	if( $login_toa_settings['lms_toa_toggle'] == 'on' ){
		$toatogglechecked = 'checked';
	}
	?>
	<div class="row lx_lms_settings_top pt-5">
		<div class="col-md-12 admin_section_title d-flex">
			<h4 class="head_h4">ToA and Privacy requirement</h4>
			<style>.toa_toggle span{top: -14px;left: 24px !important;}</style>
			<label class="lx_toggle toa_toggle" style="position: relative;height: fit-content;margin-bottom: -11px;">
				<input type="checkbox" class="toa_toggle" id="toa_toggle" name="login_toa_settings[toa_toggle]" <?php echo $toatogglechecked; ?>>
				<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
				<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
			</label>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="lms_toa_label" class="col-form-label">Terms of Agreement label</label>
		</div>
		<div class="col-md-3">
			<input type="text" class="form-control lms_toa_label" id="lms_toa_label" name="login_toa_settings[lms_toa_label]" value="<?php echo $login_toa_settings['lms_toa_label'];?>">
		</div>
		<div class="col-md-6 d-flex align-items-center" style="margin-left: -20px;">
			<i class="font_gray">Default: Terms of Agreement</i>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="lms_toa_agreeurl" class="col-form-label">ToA (relative) URL</label>
		</div>
		<div class="col-md-3">
			<input type="text" class="form-control lms_toa_agreeurl" id="lms_toa_agreeurl" name="login_toa_settings[lms_toa_agreeurl]" value="<?php echo $login_toa_settings['lms_toa_agreeurl'];?>">
		</div>
		<div class="col-md-6 d-flex align-items-center" style="margin-left: -20px;">
			<i class="font_gray">Default: /terms-of-agreement</i>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="lms_toa_privacylabel" class="col-form-label">Privacy label</label>
		</div>
		<div class="col-md-3">
			<input type="text" class="form-control lms_toa_privacylabel" id="lms_toa_privacylabel" name="login_toa_settings[lms_toa_privacylabel]" value="<?php echo $login_toa_settings['lms_toa_privacylabel'];?>">
		</div>
		<div class="col-md-6 d-flex align-items-center" style="margin-left: -20px;">
			<i class="font_gray">Default: Privacy Policy</i>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="lms_toa_privacyurl" class="col-form-label">Privacy (relative) URL</label>
		</div>
		<div class="col-md-3">
			<input type="text" class="form-control lms_toa_privacyurl" id="lms_toa_privacyurl" name="login_toa_settings[lms_toa_privacyurl]" value="<?php echo $login_toa_settings['lms_toa_privacyurl'];?>">
		</div>
		<div class="col-md-6 d-flex align-items-center" style="margin-left: -20px;">
			<i class="font_gray">Default: /privacy-policy</i>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="lms_toa_warningprompt" class="col-form-label">Warning prompt</label>
		</div>
		<div class="col-md-3">
			<input type="text" class="form-control lms_toa_warningprompt" id="lms_toa_warningprompt" name="login_toa_settings[lms_toa_warningprompt]" value="<?php echo $login_toa_settings['lms_toa_warningprompt'];?>">
		</div>
		<div class="col-md-6 d-flex align-items-center" style="margin-left: -20px;">
			<i class="font_gray">Default: This is required for access to the platform</i>
		</div>
	</div>
	<div class="row form-group admin_section_title ai_center">
		<div class="col-md-3">
			<label for="google_login" class="col-form-label" style="color:#dbd8d8;">GOOGLE SOCIAL LOGIN</label>
		</div>
		<div class="col-md-3">
			<?php 
				if($login_settings['google_login']=='on')
				{
					$check="checked";
				}else{
					$check="";
				}
			  ?>
			<label class="lx_toggle">
				<input type="checkbox" class="google_login" id="google_login" name="login_setting[google_login]" <?php echo $check; ?> disabled>
				<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
				<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
			</label>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<div class="row" style="margin-top: 50px;">
		<div class="col-md-12">
			<button type="submit" class="btn_normal_state btn_save_user_settings">Save</button>
		</div>
	</div>
	</form>
</div>