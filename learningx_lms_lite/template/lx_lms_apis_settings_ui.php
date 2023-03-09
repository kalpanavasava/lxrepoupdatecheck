<?php 

/**** for apis settings ui ****/ 
global $lx_plugin_urls;
$production=get_option('s3_production_setting',true);
$staging=get_option('s3_staging_setting',true);
?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
<script type="text/javascript" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'addons/lx_courses/js/xapijs/xapiwrapper.js';?>"></script>
<div class="row pt-5 pb-4">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">AMAZON S3 STORAGE SETTINGS</h4>
	</div>		
	<?php /* <div class="col-md-6">
		<div><span class="sm_on">STAGING MODE=ON</span></div>
	</div>  */?>
</div>
<form id="s3_settings_form" method='post'>
<div class="row" style="display: none;">
	<div class="col-md-3"></div>
	<div class="col-md-3">
		<label for=""><h6>PRODUCTION VERSION</h6></label>
	</div>
	<div class="col-md-3">
		<label for=""><h6>STAGING/TEST VERSION</h6></label>
	</div>		
	<div class="col-md-3"></div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_bucket" class="col-form-label">Bucket</label>
	</div>
	<div class="col-md-3">
		<input name="s3[pv_bucket]" type="text" id="pv_bucket" class="form-control" value="<?php echo $production['s3_bucket']; ?>">
	</div>
	<div class="col-md-3" style="display: none;">
		<input name="s3[sv_bucket]" type="text" id="sv_bucket" class="form-control" value="<?php echo $staging['s3_bucket']; ?>">
	</div>
	<div class="col-md-3"></div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_key" class="col-form-label">Key</label>
	</div>
	<div class="col-md-3">
		<input name="s3[pv_key]" type="text" id="pv_key" class="form-control" value="<?php echo $production['s3_key']; ?>">
	</div>
	<div class="col-md-3" style="display: none;">
		<input name="s3[sv_key]" type="text" id="sv_key" class="form-control" value="<?php echo $staging['s3_key']; ?>">
	</div>
	<div class="col-md-3"></div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_access" class="col-form-label">Access</label>
	</div>
	<div class="col-md-3">
		<input name="s3[pv_access]" type="password" id="pv_access" class="form-control" value="<?php echo $production['s3_access']; ?>">
	</div>
	<div class="col-md-3" style="display: none;">
		<input name="s3[sv_access]" type="password" id="sv_access" class="form-control" value="<?php echo $staging['s3_access']; ?>">
	</div>
	<div class="col-md-3"></div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_access" class="col-form-label">Region</label>
	</div>
	<div class="col-md-3">
		<input name="s3[s3_region]" type="text" id="s3_region" class="form-control" value="<?php echo $production['s3_region']; ?>">
	</div>
	<div class="col-md-3"></div>
</div>
<div class="row form-group">
	<div class="col-md-3"></div>
	<div class="col-md-3">
		<button type="button" class="btn_normal_state s3_production_test" data-click='p'>Test</button>
		<span class="pv_spinner"><img src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/loader.gif';?>"></span>
		<span class="pv_s3_msg"></span>
	</div>
	<div class="col-md-3" style="display: none;">
		<button class="btn_normal_state s3_staging_test" data-click='s'>Test</button>
		<span class="sv_spinner"><img src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/loader.gif';?>"></span>
		<span class="sv_s3_msg"></span>
	</div>
	<div class="col-md-3"></div>
</div>
<div class="row">
	<div class="col-md-12">
		<button type="button" class="btn_dark_state btn_s3_cancle">Cancel</button>
		<button type="submit" class="btn_normal_state btn_s3_save">Save S3 Settings</button>
	</div>
</div>
</form>
<?php
	require_once $lx_plugin_paths['lx_lms_lite'].'template/lx_lms_learning_locker_ui.php';
?>