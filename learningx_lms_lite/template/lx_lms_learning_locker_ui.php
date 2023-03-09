<?php
/**** for learning locker settings ui ****/ 
$lrs_production=get_option('lrs_production_settings',true);
$lrs_staging=get_option('lrs_staging_settings',true);
?>
<div class="row pt-5 pb-4">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">LEARNING LOCKER SETTINGS</h4>
	</div>
	<?php /* <div class="col-md-6">
		<div><span class="sm_on">STAGING MODE=ON</span></div>
	</div> */ ?>		
</div>
<form id="lrs_settings_form" method="post">
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
		<label for="txt_end_point" class="col-form-label">End point</label>
	</div>
	<div class="col-md-3">
		<input name="locker[pv_end_point]" type="text" id="pv_end_point" class="form-control" value="<?php echo $lrs_production['end_point'];?>">
	</div>
	<div class="col-md-3" style="display: none;">
		<input name="locker[sv_end_point]" type="text" id="sv_end_point" class="form-control" value="<?php echo $lrs_staging['end_point'];?>">
	</div>
	<div class="col-md-3"></div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_auth_key" class="col-form-label">Auth client key</label>
	</div>
	<div class="col-md-3">
		<input name="locker[pv_auth_key]" type="text" id="pv_auth_key" class="form-control" value="<?php echo $lrs_production['auth_key'];?>">
	</div>
	<div class="col-md-3" style="display: none;">
		<input name="locker[sv_auth_key]" type="text" id="sv_auth_key" class="form-control" value="<?php echo $lrs_staging['auth_key'];?>">
	</div>
	<div class="col-md-3"></div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="locker[auth_secret]" class="col-form-label">Auth client Secret</label>
	</div>
	<div class="col-md-3">
		<input name="locker[pv_auth_secret]" type="text" id="pv_auth_secret" class="form-control" value="<?php echo $lrs_production['auth_secret'];?>">
	</div>
	<div class="col-md-3" style="display: none;">
		<input name="locker[sv_auth_secret]" type="text" id="sv_auth_secret" class="form-control" value="<?php echo $lrs_staging['auth_secret'];?>">
	</div>
	<div class="col-md-3"></div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_basic_auth" class="col-form-label">Basic Auth</label>
	</div>
	<div class="col-md-3">
		<input name="locker[pv_basic_auth]" type="text" id="pv_basic_auth" class="form-control" value="<?php echo $lrs_production['basic_auth'];?>">
	</div>
	<div class="col-md-3" style="display: none;">
		<input name="locker[sv_basic_auth]" type="text" id="sv_basic_auth" class="form-control" value="<?php echo $lrs_staging['basic_auth'];?>">
	</div>
	<div class="col-md-3"></div>
</div>
<div class="row form-group">
	<div class="col-md-3"></div>
	<div class="col-md-3">
		<button type="button" class="btn_normal_state pv_lrs_test" data-click="p">Test</button>
		<span class="pv_lrs_spinner"><img src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/loader.gif';?>"></span>
		<span class="pv_lrs_msg"></span>
	</div>
	<div class="col-md-3" style="display: none;">
		<button class="btn_normal_state sv_lrs_test" data-click="s">Test</button>
		<span class="sv_lrs_spinner"><img src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/loader.gif';?>"></span>
		<span class="sv_lrs_msg"></span>
	</div>
	<div class="col-md-3"></div>
</div>
<div class="row">
	<div class="col-md-12">
		<button type="button"  class="btn_dark_state btn_lrs_cancel">Cancel</button>
		<button type="submit" class="btn_normal_state btn_lrs_save">Save LRS settings</button>
	</div>
</div>
</form>
<div class="row pt-5 pb-4">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">STRIPE API SETTINGS</h4>
		<?php
		if(is_plugin_inactive(VWPLUGIN_STRIPE)){
			$path = "javascript:void(0)";
			$stripe_error = '<span style="color:red;">Please activate/install "<b>Accept Stripe Payments</b>" plugin</span>';
		}else{
			$path = admin_url('admin.php?page=stripe-payments-settings#general');
			$stripe_error = '';
		}
		?>
		<a href="<?php echo $path; ?>"><em>Please adjust these in the Stripe Payments plugin.</em></a></br>
		<?php echo $stripe_error; ?>
	</div>
</div>
<div class="row pb-4">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">PLUGIN UPDATE KEY</h4>
	</div>
	
	<div class="col-md-3">
		<label for="plugin_update_key" class="col-form-label">Plugin Update Key</label>
	</div>
	<div class="col-md-3">
		<input name="plugin_update_key" type="password" id="plugin_update_key" class="form-control" value="<?php echo get_option('github_key');?>">
	</div>
</div>
<div class="row">
	<div class="col-md-3">
	</div>
	<div class="col-md-3">
		<button class="btn_normal_state btnsavepluginupdatekey">Save</button>
	</div>
</div>