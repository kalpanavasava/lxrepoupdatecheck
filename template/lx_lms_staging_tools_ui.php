<?php 
/**** for staging tool settings ui ****/
global $square_icon;
?>
<div class="pt-3"></div>
<!--<hr> -->
<div class="row form-group admin_section_title ai_center">
	<div class="col-md-3">
		<h4 for="dev_tools_toggle" class="col-form-label head_h4">DEVELOPER TOOLS</h4>
	</div>
	<div class="col-md-3">
		<?php
			$dev_tool=get_option('developer_tools');
			if($dev_tool=='on')
			{
				$checked='checked';
			}else{
				$checked='';
			}
		?>
		<label class="lx_toggle">
			<input type="checkbox" class="dev_tools_toggle" id="dev_tools_toggle" name="staging_tool[dev_tools]" <?php echo $checked;?>>
			<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
			<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
		</label>
	</div>
	<div class="col-md-6"></div>
</div>
<!--<hr> -->
<div class="row form-group" style="display: none;">
	<div class="col-md-6 stagging_mode_main">
		<label class="switch" style="margin-right: 5px;">
			<input type="checkbox" class="stagging_mode_toggle" id="stagging_mode_toggle" name="staging_tool[stagging_mode]">
			<span class="slider"></span>
		</label>
		<label for="stagging_mode_toggle" class="col-form-label">Staging Mode</label>
	</div>
	<div class="col-md-6">
	</div>
</div>
<div style="display: none;">
<div class="row">
	<div class="col-md-12">
		<h3>Prepare for moving to Production</h3>
	</div>
</div>
<div class="row">
	<div class="col-md-6"></div>
	<div class="col-md-3"><h6>Progress</h6></div>
	<div class="col-md-3"><h6>Run Outcome</h6></div>
</div>
<div class="row">
	<div class="col-md-6">
		<label class="checkbox-inline pt-2" for="move_to_prod_1">
			<input type="checkbox" class="move_to_prod" id="move_to_prod_1" name="staging_tool[move_to_prod_1]">
			Remove all Content/Posts with 'dev_test' as part of their name
		</label>
	</div>
	<div class="col-md-3">-%</div>
	<div class="col-md-3"></div>
</div>
<div class="row">
	<div class="col-md-6">
		<label class="checkbox-inline pt-2" for="move_to_prod_2">
			<input type="checkbox" class="move_to_prod" id="move_to_prod_2" name="staging_tool[move_to_prod_2]">
			Remove all Users with 'dev_test' as part of their name
		</label>
	</div>
	<div class="col-md-3">-%</div>
	<div class="col-md-3"></div>
</div>
<div class="row">
	<div class="col-md-6">
		<label class="checkbox-inline pt-2" for="move_to_prod_3">
			<input type="checkbox" class="move_to_prod" id="move_to_prod_3" name="staging_tool[move_to_prod_3]">
			Disconnect from the Staging S3
		</label>
	</div>
	<div class="col-md-3">-%</div>
	<div class="col-md-3"></div>
</div>
<div class="row">
	<div class="col-md-6">
		<label class="checkbox-inline pt-2" for="move_to_prod_4">
			<input type="checkbox" class="move_to_prod" id="move_to_prod_4" name="staging_tool[move_to_prod_4]">
			Connect with Production S3
		</label>
	</div>
	<div class="col-md-3">-%</div>
	<div class="col-md-3"></div>
</div>
<div class="row">
	<div class="col-md-6">
		<label class="checkbox-inline pt-2" for="move_to_prod_5">
			<input type="checkbox" class="move_to_prod" id="move_to_prod_5" name="staging_tool[move_to_prod_5]">
			Disconnect from the Staging LRS
		</label>
	</div>
	<div class="col-md-3">-%</div>
	<div class="col-md-3"></div>
</div>
<div class="row">
	<div class="col-md-6">
		<label class="checkbox-inline pt-2" for="move_to_prod_6">
			<input type="checkbox" class="move_to_prod" id="move_to_prod_6" name="staging_tool[move_to_prod_6]">
			Connect with Production LRS
		</label>
	</div>
	<div class="col-md-3">-%</div>
	<div class="col-md-3"></div>
</div>
<div class="row">
	<div class="col-md-6">
		<label class="checkbox-inline pt-2" for="move_to_prod_7">
			<input type="checkbox" class="move_to_prod" id="move_to_prod_7" name="staging_tool[move_to_prod_7]">
			Disconnect from the Staging/Test Stripe
		</label>
	</div>
	<div class="col-md-3">-%</div>
	<div class="col-md-3"></div>
</div>
<div class="row">
	<div class="col-md-6">
		<label class="checkbox-inline pt-2" for="move_to_prod_8">
			<input type="checkbox" class="move_to_prod" id="move_to_prod_8" name="staging_tool[move_to_prod_8]">
			Connect with Production Stripe
		</label>
	</div>
	<div class="col-md-3">-%</div>
	<div class="col-md-3"></div>
</div>
<div class="row">
	<div class="col-md-12">
		<button class="btn_normal_state run_move_to_production">Run</button>
	</div>
</div>
</div>
<div class="row pt-3">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">Plugin Health Check</h4>
	</div>
</div>
<div class="row pt-2">
	<div class="col-md-9">
		<div class="row">
			<div class="col-md-3"><h6>Plugin</h6></div>
			<div class="col-md-3"><h6>Required?</h6></div>
			<div class="col-md-3"><h6>Status</h6></div>
		</div>
	</div>
	<div class="col-md-3"></div>
</div>
<form id="check_plugin_health" method="post">
<?php 
$learningx_plugins=array('learningx_lms_lite'=>'LearningX LMS Lite','lx_login'=>'Lx Login');
if(is_plugin_active('learningx_lms_pro/learningx_lms_pro.php')){
	$learningx_plugins=array('learningx_lms_lite'=>'LearningX LMS Lite','learningx_lms_pro'=>'LearningX LMS PRO','lx_login'=>'Lx Login');
}
foreach($learningx_plugins as $slug=>$plugin){
?>
<div class="row">
	<div class="col-md-9">
		<div class="row pt-1">
			<input type="hidden" class="plugins" name="plugins[]" value="<?php echo $slug;?>">
			<div class="col-md-3"><?php echo $plugin;?></div>
			<div class="col-md-3">Yes</div>
			<div class="col-md-6 plugin_status status_<?php echo $slug;?>"></div>
		</div>
	</div>
	<div class="col-md-3"></div>
</div>
<?php } ?>
<div class="row pt-2">
	<div class="col-md-12">
		<button type="submit" class="btn_normal_state plugin_health_check">Check</button>
	</div>
</div>
<div>
	<?php 
	$last_health_check = get_option('last_checked_plugin_health_time');
	if( !empty($last_health_check) ){
		$last_health_check = date('Y-m-d H:i:s',get_option('last_checked_plugin_health_time'));
	}else{
		$last_health_check = 'none';
	}
	?>
	<span>Last Checked <?php echo $last_health_check; ?></span>
</div>
</form>