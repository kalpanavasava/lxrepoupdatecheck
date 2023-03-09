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
	global $wp_query;
	$wp_query->is_404 = false;
	status_header( '200' );

	get_header();
	global $lx_customize_login_plugin_path,$lx_lms_settings;
	include($lx_customize_login_plugin_path.'/assets/css/vw_customize_login.php');
	$base64_data = base64_decode( end( explode( '/', rtrim( $_SERVER['REQUEST_URI'] , '/' ) ) ) );
	parse_str($base64_data, $array);
	/* echo "<pre>";print_r($base64_data);die(); */
	if( $array['is_restricted'] == 1){
		
		$is_login_access = 0;$step = 'four';
		if( !empty($array['is_loginaccess']) ){
			$is_login_access =1;
			$step = 'three';
		}
		
		$finished_step = array("Login");
		$active_step = 'Access code';
		$remaining_step = 2;
		
		$step_info = array( 'step' => $step, 'active_step' => $active_step,'finished_step' => $finished_step, 'remaining_step' => $remaining_step ,'is_restricted' => $array['is_restricted'],'is_login_access'=>$is_login_access);	
	}
	$login_data = $array['login_data'];
	/* if(isset($array['redirection_process']) && $array['redirection_process']=='login'){
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
	} */
	
	$course_cost=get_post_meta($array['course_id'],'lx_course_cost',true);
	$redirectwhen_submit = base64_encode('redirect_key=access_community&login_data='.$array['login_data'].'&community_id='.$array['course_id'].'&is_restricted='.$array['is_restricted'].'&is_login_access='.$is_login_access);
	
	
	if(!empty($array['login_data']) && $array['is_loginaccess'] != 1){
		update_user_meta($array['login_data'],'user_status','Active');
	}
	?>
	<?php 
	/* 
	?>
	<style>
		.receipt_and_access_main_div .description_body{
			overflow: hidden;
			text-overflow: ellipsis;
			display: -webkit-box;
			-webkit-line-clamp: 4;
			-webkit-box-orient: vertical;
		}
	</style>
	<?php  */ ?>
	<div class="lp-screen" style="display:none;"><span><img class="user_interface_loader_img" src="<?php echo get_stylesheet_directory_uri().'/assets/loader/05.svg'?>"></span></div>
		<input type="hidden" id="site_url" value="<?php echo site_url().'/access_community/'; ?>" />
		<input type="hidden" id="redirection" value="<?php echo $redirectwhen_submit; ?>" />
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
						<span>Access Code</span>
						<hr/>
						<?php
							lx_steps_info($step_info);
						?>
						<div style="margin-top:10px;">
							Great.
						</div>
						<div style="margin-top:10px;">
							Enter the Access Code for the following Community
						</div>
						<div class="lx_accesscode_main_div">
						<?php 
						$community_id = $array['course_id'];
						$community_thumbnail = get_post_meta($community_id,'community_thumbnail_path',true);
						if(empty($community_thumbnail)){
							$community_thumbnail = $lx_plugin_urls['lx_lms_lite'].'/assets/img/sample_broken_img.jpg';
						}
						$comm_title = get_post($community_id)->post_title;
						$comm_description = get_post($community_id)->post_content;
						/* echo "<pre>";print_r($comm_description); */
						?>
							<div class="row p-3">
								<div class="col-md-4">
									<img src="<?php echo $community_thumbnail;?>" />
								</div>
								<div class="col-md-8" style="text-align:left;">
									<div>
										<h6 class="head_h6"><?php echo $comm_title;?></h5>
									</div>
									<div>
										<div class="description_body">
										<?php 
										$string = FnFormatMytext( $comm_description );
										
										$cuttedsting = substr($string, 0, strpos(wordwrap($string, 170), "\n"));
										
										$count = strlen( $string );
										if( $count > 170 ){
											echo $cuttedsting.' ...';
										}else{
											echo $string;
										}
										?>
										</div>
									</div>
								</div>
							</div>
							<div class="accesscode_div">
								<input type="text" class="accesscode" name="accesscode" placeholder="Access Code" />
							</div>
							<small style="color:red;" class="error_prompt"></small>
							<div class="mt-3">
								<button type="button" class="btn_normal_state return_to_access" name="return_to_access">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			jQuery(document).on('click','.return_to_access',function(){
				jQuery('.lp-screen').show();
				var accesscode = jQuery('.accesscode').val();
				/* alert(); */
				jQuery.ajax({					
					url  : "<?php echo admin_url('admin-ajax.php'); ?>",
					type: 'POST',
					data: { community_id:"<?php echo $community_id;?>",userid:"<?php echo $array['login_data'];?>",accesscode:accesscode,action:'check_the_valid_accesscode'},
					dataType: 'html',		
					success  : function(response) {
						var obj = jQuery.parseJSON(response);
						if(obj.msg == 'match'){
							window.location.href = jQuery('#site_url').val()+'/'+jQuery('#redirection').val();
						}else{
							jQuery('.error_prompt').html('Incorrect. Please contact the Community Owner for access.');
						}
						jQuery('.lp-screen').hide();
					}
				}); 
			});
		</script>
<?php 
	get_footer();
?>