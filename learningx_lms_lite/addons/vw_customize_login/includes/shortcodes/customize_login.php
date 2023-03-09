<?php
/* for resend verification link */
function resend_verification_link(){
	ob_start();
	global $lx_customize_login_plugin_path,$login_settings;
	include($lx_customize_login_plugin_path.'/assets/css/vw_customize_login.php');
	$site_icon=get_option('site_icon');
	$favicon=wp_get_attachment_image_src( $site_icon , 'full' );
	$title = get_option('blogname');
?>
<style>
.join-site{
	display:none;
}
</style>
<script src="https://www.google.com/recaptcha/api.js"></script> 
<div class="lp-screen" style="display:none;">
	<span><img class="user_interface_loader_img" src="<?php echo get_stylesheet_directory_uri().'/assets/loader/05.svg'?>"></span>
</div>
<input type="hidden" id="hd_userid" value="<?php echo $userid; ?>" />
<div class="modal vw_customize_login_main" tabindex="-1" role="dialog" id="modal_join" style="display:block;position:relative !important;">
	<div class="modal-dialog resend_dialog" role="document">
		<div class="modal-content text-center">
			<div class="modal-header">
				<div class="main_header_div">
					<a href="<?php echo site_url(); ?>"><i class="fa fa-times resend_email_close" aria-hidden="true"></i></a>
					<?php
						header_info();
					?>
				</div>
			</div>
			<div class="modal-body">
				<div class="verification_resend">
					<span class="note">Please check your spam/junk folders. If you can't find the email, please enter your details below and click to resend.</span>
					<div class="email_resend_div">
						<div class="row">
							<div class="col-md-12">
								<input type="text" name="txt_resend_email" id="txt_resend_email" class="form-control txt_resend_email" placeholder="Email" />
								<span id="email_error_msg" class="lbl_error_msg"></span>
							</div>
						</div>
						<div class="row" style="margin-top:20px;">					
							<div class="col-md-12">
								<div class="g-recaptcha" data-sitekey="<?php echo $login_settings['site_key'];?>">
								</div>
							</div>
						</div>
						<div class="row">					
							<div class="col-md-12">
								<span id="recaptcha_error_msg" class="lbl_error_msg"></span>
							</div>
						</div>
					</div>
					<div class="row resend_div">
						<div class="col-md-12">
							<button class="btn_normal_state resend_verification_email" name="resend_verification_email">Resend verification email</button>
						</div>
					</div>
					<div class="row cancel_div">
						<div class="col-md-12">
							<a href="<?php echo site_url(); ?>"><button class="btn_dark_state btn_cancel" name="btn_cancel">Cancel</button></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	$op=ob_get_clean();
	return $op;
}
add_shortcode('vw_resend_verification_link','resend_verification_link');

/* for header information */
function header_info(){ 
	$site_icon=get_option('site_icon');
	$favicon=wp_get_attachment_image_src( $site_icon , 'full' );
	$title = get_option('blogname');
?>
<style>
	.is_logo_img img{
		width:18%;
	}
	.join-site{
		display:none;
	}
	.main_header_div{
		display:flex;
		flex-direction: column;
	}
	.title_info{
		padding: 10px;
		font-weight: 700;
		font-size: 23px;
	}
</style>
	<?php
	if(!empty($favicon)){ ?>
		<span class="is_logo_img">
			<img src="<?php echo $favicon[0];?>">
		</span>
	<?php } ?>
	<span class="title_info"><?php echo $title; ?><span>
<?php
	return;
}
