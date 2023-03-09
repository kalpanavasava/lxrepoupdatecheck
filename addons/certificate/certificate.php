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
	exit; 
}
get_header();
global $site_wide_certificate,$wpdb;

/* if( !is_user_logged_in() ){
	echo '<h3 class="text-center mt-3">Please login to view your certificate</h3>';
	return false;
} */
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js" type="text/javascript"></script>
	<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
		<main id="main" <?php generate_do_element_classes( 'main' ); ?>>
			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );
			if(isset($_POST) && !empty($_POST)){
				$digitial_code = $_POST['unique_id'];
				$user_name = $_POST['username'];
				$course_name = $_POST['course_name'];
				$course_completed_time = $_POST['completion_time'];
				$author_id =$_POST['author_id'];
				$post_info =$_POST['post_info'];
			}else{
				$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
				$fullurl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				$digitial_code = rtrim(str_replace( site_url() .'/certificate/' , '' ,$fullurl),'/');
				$unique_id = base64_decode($digitial_code);
				/* $digitial_code = get_query_var( 'unique_id' );
				$unique_id = base64_decode(get_query_var( 'unique_id' )); */
				$user_id = explode("##",$unique_id)[0];
				$user_name = get_user_by('id',$user_id)->display_name;
				$fname = get_user_meta( $user_id, 'first_name', true );
				$lname = get_user_meta( $user_id, 'last_name', true );
				if( !empty($fname) && !empty($lname) ){
					$user_name = $fname .' '. $lname;
				}
				$post_info = explode("##",$unique_id)[1];
				$course_name = get_post($post_info)->post_title;
				$course_completed_time = explode("##",$unique_id)[2];
				$author_id = get_post($post_info)->post_author;
			}
			
			$course=$wpdb->get_results('select * from '.$wpdb->prefix.'posts where post_type="lx_course" and post_title="'.$course_name.'"');
			$community_id=get_post_meta($course[0]->ID,'lx_attach_this_course',true);
			
			if( is_plugin_active(LX_LMS_PRO) ){
				if(!empty($community_id)){	
					$author=get_post($community_id)->post_title;
				}else{
					$author=get_user_by('id',$author_id)->display_name;
				}
			}else{
				$author=get_user_by('id',$author_id)->display_name;
			}
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			$image = wp_get_attachment_image_src( $custom_logo_id , 'medium' )[0];
			$url= plugin_dir_url( __FILE__ ).'/CecilliaRegular-WyalG.ttf';
			?>
			<style>
			@font-face {
			  font-family: 'CecilliaRegular-WyalG';
			  font-weight: 100;
			  src: url(<?php echo $url;?>);
			}
			.lx_certificate_bgc{
				//background:#88daed;
				color:#000;
			}
			.cf_uname_ot_div{
				font-family:CecilliaRegular-WyalG;font-size:2em;color:#8d8787;
			}
			.cf_coursename_div{
				padding: 7px;margin: auto;text-align: center;width: 40%;
			}
			.cf_color{
				color:#8d8787;
			}
			.cf_date_div{
				
			}
			@media (min-width:1200px){
				.lx_vw_uname_div{
					margin-top: 18%;
				}
				.lx_vw_cname_div{
					margin-top: 9%;
				}
				.lx_vw_date_mdiv{
					padding-left: 21% !important;
				}
				.lx_vw_auth_mdiv{
					padding-right: 14% !important;
				}
				.lx_vw_b_mdiv{
					margin-top: 10%;
				}
				.cf_uname_div{
					margin: auto;text-align: center;font-size: 3em;
				}
				.cf_coursename_div{
					font-size: 3em;
				}
				.lx_vw_dcode_div{
					font-size:10px;
					line-height: 10px;
					padding: 5px;
				}
				.lx_vw_date_idiv,.lx_vw_auth_idiv{
					font-size: 1.5em;
				}
			}
			@media (min-width:992px) and (max-width:1198px) {
				.lx_vw_uname_div{
					margin-top: 18.3%;
				}
				.lx_vw_cname_div{
					margin-top: 9.3%;
				}
				.lx_vw_date_mdiv{
					padding-left: 21% !important;
				}
				.lx_vw_auth_mdiv{
					padding-right: 14% !important;
				}
				.lx_vw_b_mdiv{
					margin-top: 13.3%;
					font-size:10px;
				}
				.cf_uname_div{
					margin: auto;text-align: center;font-size: 2em;
				}
				.cf_coursename_div{
					font-size: 2em;
				}
				.lx_vw_date_idiv,.lx_vw_auth_idiv{
					font-size: 1em;
				}
				.lx_vw_dcode_div{
					font-size:9px;
					line-height: 10px;
					padding: 5px;
				}
			}
			@media (min-width:768px) and (max-width:991px) {
				.lx_vw_uname_div{
					margin-top: 16.3%;
				}
				.lx_vw_cname_div{
					margin-top: 7.3%;
				}
				.lx_vw_date_mdiv{
					padding-left: 21% !important;
				}
				.lx_vw_auth_mdiv{
					padding-right: 14% !important;
				}
				.lx_vw_b_mdiv{
					margin-top: 10%;
					font-size:10px;
				}
				.cf_uname_div{
					margin: auto;text-align: center;font-size: 2em;
				}
				.cf_coursename_div{
					font-size: 2em;
				}
				.lx_vw_date_idiv,.lx_vw_auth_idiv{
					font-size: 1em;
				}
				.lx_vw_dcode_div{
					font-size:9px;
					line-height: 10px;
					padding: 5px;
				}
			}
			@media (min-width:578px) and (max-width:767px) {
				.lx_vw_uname_div{
					margin-top: 15%;
				}
				.lx_vw_cname_div{
					margin-top: 7%;
				}
				.lx_vw_date_mdiv{
					padding-left: 21% !important;
					font-size:7px;
				}
				.lx_vw_auth_mdiv{
					padding-right: 16% !important;
					font-size:7px;
				}
				.lx_vw_b_mdiv{
					margin-top: 10.5%;
				}
				.lx_vw_dcode_div{
					font-size: 10px;
				}
				.cf_uname_div{
					padding: 11px;margin: auto;text-align: center;font-size: 1em;
				}
				.cf_coursename_div{
					font-size: 1em;
				}
				.lx_vw_date_idiv,.lx_vw_auth_idiv{
					font-size: 1em;
				}
				.lx_vw_dcode_div{
					font-size:5px;
					line-height: 7px;
					padding: 5px;
				}
			}
			@media (min-width:485px) and (max-width:578px) {
				.lx_vw_uname_div{
					margin-top: 15.5%;
				}
				.lx_vw_cname_div{
					margin-top: 7%;
				}
				.lx_vw_date_mdiv{
					padding-left: 21% !important;
					width:50%;
					font-size:7px;
				}
				.lx_vw_auth_mdiv{
					padding-right: 16% !important;
					width:50%;
					font-size:7px;
				}
				.lx_vw_b_mdiv{
					margin-top: 10%;
				}
				.lx_vw_dcode_div{
					font-size: 10px;
				}
				.cf_uname_div{
					padding: 0vw;margin: auto;text-align: center;font-size: 4vw;
				}
				.cf_coursename_div{
					font-size: 4vw;
				}
				.lx_vw_date_idiv,.lx_vw_auth_idiv{
					font-size: 2vw;
				}
				.lx_vw_dcode_div{
					font-size:5px;
					line-height: 7px;
					padding: 5px;
				}
			}
			@media (max-width:485px) {
				.lx_vw_uname_div{
					margin-top: 16%;
				}
				.lx_vw_cname_div{
					margin-top: 5%;
				}
				.lx_vw_date_mdiv{
					padding-left: 21% !important;
					width:50%;
					font-size:5px;
				}
				.lx_vw_auth_mdiv{
					padding-right: 16% !important;
					width:50%;
					font-size:5px;
				}
				.lx_vw_b_mdiv{
					margin-top: 9%;
				}
				.lx_vw_dcode_div{
					font-size: 10px;
				}
				.cf_uname_div{
					padding: 0vw;margin: auto;text-align: center;font-size: 4vw;
				}
				.cf_coursename_div{
					font-size: 4vw;
				}
				.lx_vw_date_idiv,.lx_vw_auth_idiv{
					font-size: 2vw;
				}
				.lx_vw_dcode_div{
					font-size:4px;
					line-height: 5px;
					padding: 5px;
				}
			}
			
			</style>
			<?php
				if($site_wide_certificate == 'ON'){
					$certificate_bg_image = get_option('lx_lms_certificate_bg_img');
				} else{
					if ( function_exists( 'get_certificate_bg' ) ) {
						$certificate_bg_image = get_certificate_bg($post_info);
					}
				}
			?>
			<div class="container mt-4 border" id="capture" style="">
				<div class="row">
					<div class="col-md-12" style="padding: unset;">
						<img src='<?php echo $certificate_bg_image; ?>' />
						<div style="position: absolute;width: 100%;top: 0;left:0px;">
							<div class="lx_vw_dcode_div" style="display:flex;width: fit-content;margin-top: 1%;padding-left: 2%;">	
								Certificate Code:</br>
								<?php echo $result = substr($digitial_code, 0, 20).'...'; ?>
								<?php /* echo $digitial_code; */?>
							</div>
							<div class="lx_certificate_bgc">
								<div class="text-center mt-2">
								</div>
							</div>
							<div class="lx_vw_uname_div text-center lx_certificate_bgc">
								<div class="cf_uname_div">
									<?php echo $user_name;?>
								</div>
							</div>
							<div class="lx_vw_cname_div text-center lx_certificate_bgc">
								<div class="cf_coursename_div" style="">
									<?php echo $course_name;?>
								</div>
							</div>
							<div class="row lx_vw_b_mdiv">
								
								<div class="col-md-6 col-sm-6 text-center p-2 lx_vw_date_mdiv" style="">
									<div class="lx_vw_date_idiv cf_date_div lx_certificate_bgc" style=""><?php echo date('d/m/Y',$course_completed_time);?></div>
								</div>
								<div class="lx_vw_auth_mdiv col-sm-6 col-md-6 text-center p-2" style="">
									<div class="lx_vw_auth_idiv cf_date_div lx_certificate_bgc"><?php echo $author;?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
			<?php 
			if(is_user_logged_in()){
			?>
			<div class="text-center mt-3" style="margin-bottom:0px !important;">
				<button class="btn btn_normal_state certificate_download">Download</button>
			</div>
			<?php } ?>
			<div id="canvasImg" class="p-4 text-center"></div>
			<script>
			jQuery(document).ready(function(){
				 
				html2canvas(document.querySelector("#capture"),{scale:2}).then(canvas => {
					var canvas_width = jQuery('#canvasImg').width();
					 //alert( jQuery('#canvasImg').width() );
					 jQuery("#canvasImg").append(canvas);
					 jQuery("#capture").hide();
					 
					 if( jQuery(window).width() < 769 ){
						 /* jQuery('canvas').css('width',canvas_width); */
					 }
				});
				jQuery('.certificate_download').click(function(){
					html2canvas(document.querySelector("#canvasImg canvas"),{scale:6}).then(canvas => {
						var a = document.createElement('a');
						a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
						a.download = 'certificate_<?php echo $digitial_code;?>.jpg';
						a.click();
				  });
				});
			});
			jQuery(document).ready(function() {
				jQuery("#canvasImg").on("contextmenu",function(){
				   return false;
				}); 
			});
			</script>
			<?php
			/**
			 * generate_after_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_after_main_content' );
			?>
		</main>
	</div>

	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	do_action( 'generate_after_primary_content_area' );

	generate_construct_sidebars();

	get_footer();
