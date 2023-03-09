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
	global $wp_query;
	$wp_query->is_404 = false;
	status_header( '200' );
	get_header();
?>
	<div class="modal pt-4" tabindex="-1" role="dialog" id="modal_join" style="display:block;position:relative !important;z-index:0;">
		<div class="modal-dialog" role="document">
			<div class="modal-content text-center">
				<div class="modal-header">
					<div class="main_header_div">
						<?php
							header_info();
						?>
					</div>
				</div>
				<?php 
				$toacheck = get_option( 'lx_lms_login_toasetting' );
				
				$toalabel = $toacheck['lms_toa_label'];
				if( empty($toalabel) ){
					$toalabel = 'Terms of Agreement';
				}
				$privacylabel = $toacheck['lms_toa_privacylabel'];
				if( empty($privacylabel) ){
					$privacylabel = 'Privacy Policy';
				}
				
				$toadesturl = $toacheck['lms_toa_agreeurl'];
				$toadesturl = ltrim($toadesturl,"/");
				if( empty($toadesturl) ){
					$toadesturl = 'terms-of-agreement';
				}
				$toadesturl = site_url() . '/' . $toadesturl;
				
				$ppdesturl = $toacheck['lms_toa_privacyurl'];
				$ppdesturl = ltrim($ppdesturl,"/");
				if( empty($ppdesturl) ){
					$ppdesturl = 'privacy-policy';
				}
				$ppdesturl = site_url() . '/' . $ppdesturl;
				?>
				<div class="modal-body">
					<div style="text-align: left;padding: 15px;">We have recently had an update to our Terms of Agreement and Privacy Policy</div>
					<div class="row" style="text-align: left;">
						<div class="form-check" style="margin: 0px 36px;width:100%;">
							<input class="form-check-input" type="checkbox" value="" id="registertermsaggrement">
							<label class="form-check-label" for="registertermsaggrement">
							I agree to the <a href="<?php echo $toadesturl;?>" style="<?php echo "color:".$color_palette['hyperlinks']?>"><?php echo $toalabel;?></a> and <a href="<?php echo $ppdesturl;?>" style="<?php echo "color:".$color_palette['hyperlinks']?>"><?php echo $privacylabel;?></a>
							</label>
						</div>
						<span id="agreement_error_msg" class="" style="margin-left: 36px;color:red;display:none;">
						<?php 
						$default_prompt = 'This is required for access to the platform';
						if( !empty( $toacheck['lms_toa_warningprompt'] ) ){
							$default_prompt = $toacheck['lms_toa_warningprompt'];
						} 
						echo $default_prompt;
						?>
						</span>
					</div>
					<div style="padding:10px;">
						<button type="button" class="btn_normal_state w-100 aggrementcontinue" name="">CONTINUE</button>
					</div>
					<div style="padding:10px;">
						<style>
						.btn_disabled_state,.btn_disabled_state:hover{
							pointer-events: unset;
						}
						</style>
						<button type="button" class="btn_disabled_state w-100 aggrementcancel" name="">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php 
	get_footer();
?>