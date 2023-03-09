<?php 
/**** for lms settings ui ****/
?>
<div class="row pt-5">
	<div class="col-md-12">
		<label for=""><h4>Additional Settings</h4></label>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="chk_author_visibility" class="col-form-label">Author Name</label>
	</div>
	<div class="col-md-3">
		<label class="checkbox-inline pt-2">
			<input type="checkbox" class="chk_author_visibility" id="chk_author_visibility" name="ad_setting[author_visibility]" <?php if(isset($lx_lms_settings['author_visiblity'])){if($lx_lms_settings['author_visiblity']=="ON"){ echo 'checked'; } } ?>>Show
		</label>
	</div>
	<div class="col-md-6">
	</div>
</div>