<?php /**** for general settings ui ****/ ?>
<form id="general_settings_form" method="post">
<?php 
require_once $lx_plugin_paths['lx_lms_lite'].'template/lx_lms_logos_ui.php';
footerlmssetting_ui();
certificate_settings_top_ui();
certificate_settings_ui();
additinal_settings_ui();
base64_settings_ui();
course_purchasing_ui();
?>
<div class="row" style="margin-top: 50px;">
	<div class="col-md-12">
		<button type="submit" class="btn_normal_state btn_save_user_settings">Save</button>
	</div>
</div>
</form>