<?php 
/**** for iframe content settings ui ****/
global $square_icon;
$lightbox_settings=get_option('lightbox_settings',true);
$color_array = array('Blue','Green','Orange','Red','Purple','Black','Charcoal','White','Grey','Light Grey','Mid Grey','Custom1','Custom2','Custom3','Custom4');
?>
<div class="row pt-5">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">IFRAME ARTICULATE WEB AND ADDITIONAL RESOURCES POPUP SETTINGS</h4>
	</div>
</div>
<div class="row pt-3">
	<div class="col-md-6">
		<div class="row form-group">
			<div class="col-md-6">
				<label for="lightbox_bg_overlay_color" class="col-form-label">Background overlay color</label>
			</div>
			<div class="col-md-6">
				<select name="lightbox[bg_overlay_color]" type="text" id="lightbox_bg_overlay_color" class="form-control">
					<?php 
						foreach($color_array as $key=>$value){
							?>
							<option <?php if($lightbox_settings['bg_overlay_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
							<?php
						}
					?>
					<?php 
						/*foreach($color_palette as $key=>$value){

							if( $key !='hyperlinks' && $key !='heading_text' && $key !='body_text' && $key !='border' &&  $key !='course_completed' && $key !='course_partially_completed' && $key !='course_not_started'){ ?>
								<option value="<?php echo $value; ?>" <?php $lightbox_settings['bg_overlay_color']==$value?print 'selected':'';?>><?php echo ucwords(str_replace("_", " ", $key)); ?></option>
					<?php	}
						}*/
					?>	
				</select>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="lightbox_bg_overlay_opacity" class="col-form-label">Background overlay opacity</label>
			</div>
			<div class="col-md-6">
				<input type="text" class="form-control" name="lightbox[bg_overlay_opacity]" id="lightbox_bg_overlay_opacity" value="<?php echo $lightbox_settings['bg_overlay_opacity'];?>">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="lb_modal_body_color" class="col-form-label">iFrame body color</label>
			</div>
			<div class="col-md-6">
				<select name="lightbox[modal_body_color]" type="text" id="lb_modal_body_color" class="form-control">
					<?php 
						foreach($color_array as $key=>$value){
							?>
							<option <?php if($lightbox_settings['modal_body_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
							<?php
						}
					?>
					<?php 
						/*foreach($color_palette as $key=>$value){

							if( $key !='hyperlinks' && $key !='heading_text' && $key !='body_text' && $key !='border' &&  $key !='course_completed' && $key !='course_partially_completed' && $key !='course_not_started'){ ?>
								<option value="<?php echo $value; ?>" <?php $lightbox_settings['modal_body_color']==$value?print 'selected':'';?>><?php echo ucwords(str_replace("_", " ", $key)); ?></option>
					<?php	}
						}*/
					?>	
				</select>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="lb_modal_border_color" class="col-form-label">iFrame border color</label>
			</div>
			<div class="col-md-6">
				<select name="lightbox[modal_border_color]" type="text" id="lb_modal_border_color" class="form-control">
					<?php 
						foreach($color_array as $key=>$value){
							?>
							<option <?php if($lightbox_settings['modal_border_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
							<?php
						}
					?>
					<?php 
						/*foreach($color_palette as $key=>$value){
							if( $key !='hyperlinks' && $key !='heading_text' && $key !='body_text' && $key !='border' &&  $key !='course_completed' && $key !='course_partially_completed' && $key !='course_not_started'){ ?>
								<option value="<?php echo $value; ?>" <?php $lightbox_settings['modal_border_color']==$value?print 'selected':'';?>><?php echo ucwords(str_replace("_", " ", $key)); ?></option>
					<?php	}
						}*/
					?>	
				</select>
			</div>
		</div>
	</div>
</div>
	<div class="row pt-5">
		<div class="col-md-12 admin_section_title">
			<h4 class="head_h4">HEADER SETTINGS</h4>
		</div>
	</div>
<div class="row pt-3 pb-3">
		
		<div class="col-md-6">	
		<div class="row form-group">
			<div class="col-md-6">
				<label for="lb_modal_header_color" class="col-form-label">Bar color</label>
			</div>
			<div class="col-md-6">
				<select name="lightbox[modal_header_color]" type="text" id="lb_modal_header_color" class="form-control">
					<?php 
						foreach($color_array as $key=>$value){
							?>
							<option <?php if($lightbox_settings['modal_header_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
							<?php
						}
					?>
					<?php 
						/*foreach($color_palette as $key=>$value){

							if( $key !='hyperlinks' && $key !='heading_text' && $key !='body_text' && $key !='border' &&  $key !='course_completed' && $key !='course_partially_completed' && $key !='course_not_started'){ ?>
								<option value="<?php echo $value; ?>" <?php $lightbox_settings['modal_header_color']==$value?print 'selected':'';?>><?php echo ucwords(str_replace("_", " ", $key)); ?></option>
					<?php	}
						}*/
					?>	
				</select>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="lb_modal_title_color" class="col-form-label">Title color</label>
			</div>
			<div class="col-md-6">
				<select name="lightbox[modal_title_color]" type="text" id="lb_modal_title_color" class="form-control">
					<?php 
						foreach($color_array as $key=>$value){
							?>
							<option <?php if($lightbox_settings['modal_title_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
							<?php
						}
					?>
					<?php 
						/*foreach($color_palette as $key=>$value){
							if( $key !='hyperlinks' && $key !='heading_text' && $key !='body_text' && $key !='border' &&  $key !='course_completed' && $key !='course_partially_completed' && $key !='course_not_started'){ ?>
								<option value="<?php echo $value; ?>" <?php $lightbox_settings['modal_title_color']==$value?print 'selected':'';?>><?php echo ucwords(str_replace("_", " ", $key)); ?></option>
					<?php	}
						}*/
					?>	
				</select>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="lb_top_bar_title_alignment" class="col-form-label">Text alignment</label>
			</div>
			<div class="col-md-6">
				<?php 
					if(!isset($lightbox_settings['modal_top_bar_title_alignment'])){
						$selected = 'selected';
					} else{
						$selection_value = $lightbox_settings['modal_top_bar_title_alignment'];
					}
				?>
				<select name="lightbox[modal_top_bar_title_alignment]" type="text" id="lb_top_bar_title_alignment" class="form-control">
					<option <?php if($selection_value == 'left'){ echo 'selected'; } ?> value="left" >Left</option>
					<option <?php if($selection_value == 'center'){ echo 'selected'; } else{ echo $selected; } ?> value="center">Center</option>
				</select>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="lb_modal_title_size" class="col-form-label">Font size</label>
			</div>
			<div class="col-md-6">
				<input name="lightbox[modal_title_size]" type="text" id="lb_modal_title_size" class="form-control" value="<?php if(isset($lightbox_settings['modal_title_size'])){ echo $lightbox_settings['modal_title_size']; }else{ echo "1.2em"; } ?>">
			</div>
		</div>
		<div class="row form-group ai_center">
			<div class="col-md-6">
				<label for="lb_favicon_visibility" class="col-form-label">Favicon is Visible on PC/Tablet</label>
			</div>
			<div class="col-md-6">
				<?php 
					if(isset($lightbox_settings['favicon_visibility'])){
						if($lightbox_settings['favicon_visibility']=="ON"){
							$checked="checked";
						}else{
							$checked="";
						}
					}else{
						$checked="checked";
					}
				?>
				<label class="lx_toggle">
					<input type="checkbox" class="chk_favicon_visibility" id="lb_favicon_visibility" name="lightbox[favicon_visibility]" <?php echo $checked;?>>
					<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
					<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
				</label>
			</div>
		</div>	
		<div class="row form-group">
			<div class="col-md-6">
				<label for="lb_modal_header_icon_color" class="col-form-label">Icon color</label>
			</div>
			<div class="col-md-6">
				<select name="lightbox[modal_header_icon_color]" type="text" id="lb_modal_header_icon_color" class="form-control">
					<?php 
						foreach($color_array as $key=>$value){
							?>
							<option <?php if($lightbox_settings['modal_header_icon_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
							<?php
						}
					?>
					<?php 
						/*foreach($color_palette as $key=>$value){

							if( $key !='hyperlinks' && $key !='heading_text' && $key !='body_text' && $key !='border' &&  $key !='course_completed' && $key !='course_partially_completed' && $key !='course_not_started'){ ?>
								<option value="<?php echo $value; ?>" <?php $lightbox_settings['modal_header_icon_color']==$value?print 'selected':'';?>><?php echo ucwords(str_replace("_", " ", $key)); ?></option>
					<?php	}
						}*/
					?>	
				</select>
			</div>
		</div>
			
	</div>
</div>

<div class="row pt-3">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">CLOSE BUTTON</h4>
	</div>
</div>
<div class="row pt-3 pb-3">
<?php 
/* vwpr($lightbox_settings['lb_closetext']); */
?>
	<div class="col-md-6">
		<div class="row form-group">
			<div class="col-md-6 d-flex align-items-center">
				<label for="lb_closetext" class="col-form-label">Include the word 'Close' on the close icon</label>
			</div>
			<div class="col-md-6">
				<label class="lx_toggle">
					<input type="checkbox" <?php if($lightbox_settings['lb_closetext'] == 'on' ){echo 'checked';} ?> class="lb_closetext" id="lb_closetext" name="lightbox[lb_closetext]">
					<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
					<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
				</label>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6 d-flex align-items-center">
				<label for="lb_closebutton" class="col-form-label">Make it look like a button</label>
			</div>
			<div class="col-md-6">
				<label class="lx_toggle">
					<input type="checkbox" <?php if($lightbox_settings['lb_closebutton'] == 'on' ){echo 'checked';} ?> class="lb_closebutton" id="lb_closebutton" name="lightbox[lb_closebutton]">
					<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
					<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
				</label>
			</div>
		</div>
	</div>
</div>