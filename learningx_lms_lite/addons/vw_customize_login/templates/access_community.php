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
	$user_id = $array['login_data'];
/* 	wp_set_current_user( $user_id, get_user_by('id',$user_id)->user_login );
	wp_set_auth_cookie( $user_id ); */
	/* echo "<pre>";print_r($array);die(); */
	
	
	$course_cost=get_post_meta($array['course_id'],'lx_course_cost',true);
	$redirectwhen_submit = base64_encode('redirect_key=access_community&login_data='.$array['login_data'].'&community_id='.$array['course_id']);
	
		$is_login_access = 0;$step = 'four';
		if( !empty($array['is_login_access']) ){
			$is_login_access =1;
			$step = 'three';
		}
	/* if( $array['is_restricted'] == 1){ */
		$finished_step = array("Login,Access code");
		$active_step = 'Access';
		$remaining_step = 1;
		$step_info = array( 'step' => $step, 'active_step' => $active_step,'finished_step' => $finished_step, 'remaining_step' => $remaining_step ,'is_restricted' => $array['is_restricted'],'is_login_access'=>$is_login_access);	
	/* } */
	/* echo "<pre>";print_r($step_info);die(); */
	?>
	<div class="lp-screen" style="display:none;"><span><img class="user_interface_loader_img" src="<?php echo get_stylesheet_directory_uri().'/assets/loader/05.svg'?>"></span></div>
		<input type="hidden" id="community_url" value="<?php echo get_permalink($array['community_id']); ?>" />
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
						<span>Access</span>
						<hr/>
						<?php
							lx_steps_info($step_info);
						?>
						<div style="margin-top:10px;">
							Great.
						</div>
						<div style="margin-top:10px;">
							You've now been granted access to this Community and all it's associated content.
						</div>
						<div class="lx_accesscode_main_div">
							<div class="mt-3">
								<button type="button" class="btn_normal_state access_community w-100" name="return_to_access">Go to Community</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			jQuery(document).on('click','.access_community',function(){
				jQuery('.lp-screen').show();
				/* alert(); */
				jQuery.ajax({					
					url  : "<?php echo admin_url('admin-ajax.php'); ?>",
					type: 'POST',
					data: { community_id:"<?php echo $array['community_id'];?>",user_id:"<?php echo $user_id;?>",action:'access_community_fn'},
					dataType: 'html',		
					success  : function(response) {
						window.location.href = response
						jQuery('.lp-screen').hide();
					}
				}); 
			});
		</script>
<?php 
	get_footer();
?>