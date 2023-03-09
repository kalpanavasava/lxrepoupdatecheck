<?php
function lx_pro_save_courses(){
	ob_start();
	global $lx_plugin_urls;
	?>
	<script src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/js/select2.min.js'; ?>" ></script>
	<?php
	$edit_id=$_POST['edit_course_id'];
	if( is_user_logged_in() == true && (is_super_admin() || current_user_can('site_owner') || current_user_can('community_owner') || current_user_can('community_manager'))){
		course_top_ui($edit_id,'lx_form_savecourses');
		course_details_ui($edit_id);
		course_attached_info_ui($edit_id);
		/* course_info_ui($edit_id); */
		course_preview_ui($edit_id);
		course_bottom_ui($edit_id);
		course_popover_ui();
		?>
		<script>
			jQuery(document).ready(function() {
				jQuery('.course_canvas_select').select2();
			});
			crop_course_thumb();
		</script>
		<?php
 	}else{
	?>
	<style>
		.site-content {
    		top: unset !important;
    	}
	</style>
	<?php
		echo "<div style='width:100%;color:#ff0000;text-align:center;padding:20px;'>You Don't have Access to this page.</div>";
	}
	$op=ob_get_clean();
	return $op;
}
add_shortcode('save_courses','lx_pro_save_courses',20);