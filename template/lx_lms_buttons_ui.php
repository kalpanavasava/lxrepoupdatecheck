<?php 
/**** for button css settings ui ****/ 
global $square_icon;
?>
<div class="row pt-5 pb-4">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">STANDARD BUTTON STYLING</h4>
	</div>
</div>

<div class="row form-group">
	<div class="col-md-3">
	<label for="txt_normal_state" class="col-form-label">Normal</label>
	</div>
	<div class="col-md-8">
		<textarea name="buttons[normal_state]" id="txt_normal_state" class="form-control" rows="3"value="<?php if(isset($button_styling['normal_state'])){ echo $button_styling['normal_state']; } ?>"><?php if(isset($button_styling['normal_state'])){ echo $button_styling['normal_state']; } ?></textarea>
		
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_normal_state"><i class="fal fa-undo"></i></span>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
	<label for="txt_hover_state" class="col-form-label">Hover</label>
	</div>
	<div class="col-md-8">
		<textarea name="buttons[hover_state]" id="txt_hover_state" class="form-control" rows="3" value="<?php if(isset($button_styling['hover_state'])){ echo $button_styling['hover_state']; } ?>"><?php if(isset($button_styling['hover_state'])){ echo $button_styling['hover_state']; } ?></textarea>
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_hover_state"><i class="fal fa-undo"></i></span>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_selected_state" class="col-form-label">Selected (Toggle on)</label>
	</div>
	<div class="col-md-8">
		<textarea name="buttons[selected_state]" id="txt_selected_state" class="form-control" rows="3" value="<?php if(isset($button_styling['selected_state'])){ echo $button_styling['selected_state']; } ?>"><?php if(isset($button_styling['selected_state'])){ echo $button_styling['selected_state']; } ?></textarea>
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_selected_state"><i class="fal fa-undo"></i></span>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
	<label for="txt_disabled_state" class="col-form-label">Disabled state</label>
	</div>
	<div class="col-md-8">
		<textarea name="buttons[disabled_state]" id="txt_disabled_state"class="form-control" rows="3" value="<?php if(isset($button_styling['disabled_state'])){ echo $button_styling['disabled_state']; } ?>"><?php if(isset($button_styling['disabled_state'])){ echo $button_styling['disabled_state']; } ?></textarea>
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_disabled_state"><i class="fal fa-undo"></i></span>
	</div>
</div>

<div class="row pt-3 pb-3">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">ADDITIONAL BUTTONS TYPES/STATES</h4>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_dark_state" class="col-form-label">Dark</label>
	</div>
	<div class="col-md-8">
		<textarea name="buttons[dark_state]" id="txt_dark_state" class="form-control" rows="3" value="<?php if(isset($button_styling['dark_state'])){ echo $button_styling['dark_state']; } ?>"><?php if(isset($button_styling['dark_state'])){ echo $button_styling['dark_state']; } ?></textarea>
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_dark_state"><i class="fal fa-undo"></i></span>
	</div>
</div>

<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_dark_hover_state" class="col-form-label">Dark (HOVER)</label>
	</div>
	<div class="col-md-8">
		<textarea name="buttons[dark_hover_state]" id="txt_dark_hover_state" class="form-control" rows="3" value="<?php if(isset($button_styling['dark_hover_state'])){ echo $button_styling['dark_hover_state']; } ?>"><?php if(isset($button_styling['dark_hover_state'])){ echo $button_styling['dark_hover_state']; } ?></textarea>	
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_dark_hover_state"><i class="fal fa-undo"></i></span>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_danger_state" class="col-form-label">Danger</label>
	</div>
	<div class="col-md-8">
		<textarea name="buttons[danger_state]" id="txt_danger_state" class="form-control" rows="3" value="<?php if(isset($button_styling['danger_state'])){ echo $button_styling['danger_state']; } ?>"><?php if(isset($button_styling['danger_state'])){ echo $button_styling['danger_state']; } ?></textarea>
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_danger_state"><i class="fal fa-undo"></i></span>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_danger_hover_state" class="col-form-label">Danger (HOVER)</label>
	</div>
	<div class="col-md-8">
		<textarea name="buttons[danger_hover_state]" id="txt_danger_hover_state" class="form-control" rows="3" value="<?php if(isset($button_styling['danger_state'])){ echo $button_styling['danger_hover_state']; } ?>"><?php if(isset($button_styling['danger_hover_state'])){ echo $button_styling['danger_hover_state']; } ?></textarea>
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_danger_hover_state"><i class="fal fa-undo"></i></span>
	</div>
</div>

<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_inverse_danger_state" class="col-form-label">Inverse Danger</label>
	</div>
	<div class="col-md-8">
		<textarea name="buttons[inverse_danger_state]" id="txt_inverse_danger_state" class="form-control" rows="3" value="<?php if(isset($button_styling['inverse_danger_state'])){ echo $button_styling['inverse_danger_state']; } ?>"><?php if(isset($button_styling['inverse_danger_state'])){ echo $button_styling['inverse_danger_state']; } ?></textarea>	
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_inverse_danger_state"><i class="fal fa-undo"></i></span>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_inverse_danger_hover_state" class="col-form-label">Inverse Danger (HOVER)</label>
	</div>
	<div class="col-md-8">
		<textarea name="buttons[inverse_danger_hover_state]" id="txt_inverse_danger_hover_state" class="form-control" rows="3" value="<?php if(isset($button_styling['inverse_danger_hover_state'])){ echo $button_styling['inverse_danger_hover_state']; } ?>"><?php if(isset($button_styling['inverse_danger_hover_state'])){ echo $button_styling['inverse_danger_hover_state']; } ?></textarea>	
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_inverse_danger_hover_state"><i class="fal fa-undo"></i></span>
	</div>
</div>