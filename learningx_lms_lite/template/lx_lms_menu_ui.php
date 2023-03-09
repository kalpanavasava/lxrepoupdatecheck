<?php 
/**** for menu settings ui ****/
global $square_icon;
$menu_settings = get_option('user_interface_menu_settings');
$color_array = array('Blue','Green','Orange','Red','Purple','Black','Charcoal','White','Grey','Light Grey','Mid Grey','Custom1','Custom2','Custom3','Custom4');
?>
<div class="row pt-5 pb-4">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">MENU LAYOUTS</h4>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="rb_menu_logged_in_layout" class="col-form-label">Layout – Logged in</label>
	</div>
	 <div class="col-md-6">
		<label class="checkbox-inline">
			<input type="radio" class="menu_layout" id="rb_menu_logged_in_layout" name="menu[logged_in_layout]" value="traditional" <?php if($menu_settings['logged_in_menu_layout']=='traditional'){ echo 'checked'; }else{ echo 'checked'; } ?>>Traditional
		</label>
		<div style="height: 65px;display:flex;">
			<div class="card-header" style="width:30%;background:#dcd4d4;"></div>
			<div class="card-header" style="width: 25%;"></div>
			<div class="card-header" style="width: 45%;">
				<label class="layout_traditional_lbl">___&nbsp;&nbsp;&nbsp;___&nbsp;&nbsp;&nbsp;___</label>
			</div>
		</div>
	</div>
	<div class="col-md-3"></div>	
</div>
<div class="row form-group">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<label class="checkbox-inline">
			<input type="radio" class="menu_layout" id="rb_menu_logged_in_layout" name="menu[logged_in_layout]" value="centered" <?php if($menu_settings['logged_in_menu_layout']=='centered'){ echo 'checked'; } ?>>Centered
		</label>
		<div class="card-header text-center" style="width: 100%;">
			<div class="card-header text-center layout_center"></div>
			<label class="layout_center_label">___&nbsp;&nbsp;&nbsp;&nbsp;___&nbsp;&nbsp;&nbsp;&nbsp;___</label>
		</div>
	</div>
	<div class="col-md-3"></div>	
</div>

<div class="row form-group">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<label class="checkbox-inline">
			<input type="radio" class="menu_layout" id="rb_menu_logged_in_layout" name="menu[logged_in_layout]" value="minimulist" <?php if($menu_settings['logged_in_menu_layout']=='minimulist'){ echo 'checked'; } ?>>Minimulist(default)
		</label>
		<div style="height: 65px;display:flex;">
			<div class="card-header text-center" style="width: 100%;">
				<label class="layout_minimul_lbl">___&nbsp;&nbsp;&nbsp;___&nbsp;&nbsp;&nbsp;___</label>
			</div>
		</div>
	</div>
	<div class="col-md-3"></div>	
</div>

<div class="row form-group">
	<div class="col-md-3">
		<label for="rb_menu_logged_out_layout" class="col-form-label">Layout –Logged out</label>
	</div>
	 <div class="col-md-6">
		<label class="checkbox-inline">
			<input type="radio" class="menu_layout" id="rb_menu_logged_out_layout" name="menu[logged_out_layout]" value="traditional" <?php if($menu_settings['logged_out_menu_layout']=='traditional'){ echo 'checked'; }else{ echo 'checked'; } ?>>Traditional
		</label>
		<div style="height: 65px;display:flex;">
			<div class="card-header" style="width:30%;background:#dcd4d4;"></div>
			<div class="card-header" style="width: 25%;"></div>
			<div class="card-header" style="width: 45%;">
				<label class="layout_traditional_lbl">___&nbsp;&nbsp;&nbsp;___&nbsp;&nbsp;&nbsp;___</label>
			</div>
		</div>
	</div>
	<div class="col-md-3"></div>	
</div>
<div class="row form-group">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<label class="checkbox-inline">
			<input type="radio" class="menu_layout" id="rb_menu_logged_out_layout" name="menu[logged_out_layout]" value="centered" <?php if($menu_settings['logged_out_menu_layout']=='centered'){ echo 'checked'; } ?>>Centered
		</label>
		<div class="card-header text-center" style="width: 100%;">
			<div class="card-header text-center layout_center"></div>
			<label class="layout_center_label">___&nbsp;&nbsp;&nbsp;&nbsp;___&nbsp;&nbsp;&nbsp;&nbsp;___</label>
		</div>
	</div>
	<div class="col-md-3"></div>	
</div>

<div class="row pt-5 pb-4">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">MAIN MENU - COLOR PALETTE</h4>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="ddl_background_color" class="col-form-label">Main Background Color</label>
	</div>
	<div class="col-md-3">
		<select name="menu[background_color]" type="text" id="ddl_background_color" class="form-control">
		<?php 
			foreach($color_array as $key=>$value){
				?>
				<option <?php if($menu_settings['background_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
				<?php
			}
		?>
		</select>
	</div>
	<div class="col-md-3">
		<label for="ddl_text_color" class="col-form-label">Text Color</label>
	</div>
	<div class="col-md-3">
		<select name="menu[text_color]" type="text" id="ddl_text_color" class="form-control">
		<?php 
			foreach($color_array as $key=>$value){
				?>
				<option <?php if($menu_settings['text_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
				<?php
			}
		?>
		</select>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="ddl_menu_hover_bg_color" class="col-form-label">Menu Background Color (Hover)</label>
	</div>
	<div class="col-md-3">
		<select name="menu[menu_hover_bg_color]" type="text" id="ddl_menu_hover_bg_color" class="form-control">
		<?php 
			foreach($color_array as $key=>$value){
				?>
				<option <?php if($menu_settings['menu_hover_bg_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
				<?php
			}
		?>
		</select>
	</div>
	<div class="col-md-3">
		<label for="ddl_menu_hover_text_color" class="col-form-label">Menu Text Color (Hover)</label>
	</div>
	<div class="col-md-3">
		<select name="menu[menu_hover_text_color]" type="text" id="ddl_menu_hover_text_color" class="form-control">
		<?php 
			foreach($color_array as $key=>$value){
				?>
				<option <?php if($menu_settings['menu_hover_text_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
				<?php
			}
		?>
		</select>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="ddl_menu_hover_bg_color" class="col-form-label">Sub-menu Background Color</label>
	</div>
	<div class="col-md-3">
		<select name="menu[submenu_bg_color]" type="text" id="ddl_submenu_bg_color" class="form-control">
		<?php 
			foreach($color_array as $key=>$value){
				?>
				<option <?php if($menu_settings['submenu_bg_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
				<?php
			}
		?>
		</select>
	</div>
	<div class="col-md-3">
		<label for="ddl_menu_hover_text_color" class="col-form-label">Sub-menu Text Color</label>
	</div>
	<div class="col-md-3">
		<select name="menu[submenu_text_color]" type="text" id="ddl_submenu_text_color" class="form-control">
		<?php 
			foreach($color_array as $key=>$value){
				?>
				<option <?php if($menu_settings['submenu_text_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
				<?php
			}
		?>
		</select>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="ddl_sub_menu_hover_bg_color" class="col-form-label">Sub-menu Background Color (Hover)</label>
	</div>
	<div class="col-md-3">
		<select name="menu[sub_menu_hover_bg_color]" type="text" id="ddl_sub_menu_hover_bg_color" class="form-control">
		<?php 
			foreach($color_array as $key=>$value){
				?>
				<option <?php if($menu_settings['sub_menu_hover_bg_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
				<?php
			}
		?>
		</select>
	</div>
	<div class="col-md-3">
		<label for="ddl_sub_menu_hover_text_color" class="col-form-label">Sub-menu Text Color (Hover) </label>
	</div>
	<div class="col-md-3">
		<select name="menu[sub_menu_hover_text_color]" type="text" id="ddl_sub_menu_hover_text_color" class="form-control">
		<?php 
			foreach($color_array as $key=>$value){
				?>
				<option <?php if($menu_settings['sub_menu_hover_text_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
				<?php
			}
		?>
		</select>
	</div>
</div>

<div class="row pt-3 pb-3">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">MAIN MENU - FONT SETTINGS</h4>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="ddl_menu_case" class="col-form-label">Case</label>
	</div>
	<div class="col-md-3">
		<select name="menu[menu_case]" type="text" id="ddl_menu_case" class="form-control">
			<option value="uppercase" <?php if(isset($menu_settings['menu_case'])){ if($menu_settings['menu_case'] == 'uppercase' ){ echo 'selected'; } } ?>>Upper</option>
			<option value="capitalize" <?php if(isset($menu_settings['menu_case'])){ if($menu_settings['menu_case'] == 'capitalize' ){ echo 'selected'; } } ?>>Standard</option>
		</select>
	</div>
	<div class="col-md-6">
	</div>
</div>

<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_text_size" class="col-form-label">Text size</label>
	</div>
	<div class="col-md-3">
		<input name="menu[text_size]" type="text" id="txt_text_size" class="form-control" value="<?php echo $menu_settings['text_size']; ?>">
	</div>
	<div class="col-md-6">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_menu_font_weight" class="col-form-label">Font Weight</label>
	</div>
	<div class="col-md-3">
		<input name="menu[menu_font_weight]" type="text" id="txt_menu_font_weight" class="form-control" value="<?php echo $menu_settings['menu_font_weight'] ?>">
	</div>
	<div class="col-md-6">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_menu_font_spacing" class="col-form-label">Font Spacing</label>
	</div>
	<div class="col-md-3">
		<input name="menu[menu_font_spacing]" type="text" id="txt_menu_font_spacing" class="form-control" value="<?php echo $menu_settings['menu_font_spacing'] ?>">
	</div>
	<div class="col-md-6">
	</div>
</div>

<div class="row pt-3 pb-3">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">MAIN MENU - LOGO SETTINGS</h4>
	</div>
</div>
<div class="row form-group">
   <div class="col-md-3">
		<label for="ddl_logged_in_menu_bg_color" class="col-form-label lb_grid">Logo background color<span>(logged in)</span></label>	
	</div>
   <div class="col-md-3">
      <select name="menu[logged_in_menu_bg_color]" type="text" id="ddl_logged_in_menu_bg_color" class="form-control">
      <?php 
			foreach($color_array as $key=>$value){
				?>
				<option <?php if($menu_settings['logged_in_menu_bg_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
				<?php
			}
		?>		
      </select>
   </div>
   <div class="col-md-6">	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="ddl_logged_out_menu_bg_color" class="col-form-label lb_grid">Logo background color<span>(logged out)</span></label>
	</div>
   <div class="col-md-3">
      <select name="menu[logged_out_menu_bg_color]" type="text" id="ddl_logged_in_menu_bg_color" class="form-control">
      <?php 
			foreach($color_array as $key=>$value){
				?>
				<option <?php if($menu_settings['logged_out_menu_bg_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
				<?php
			}
		?>			
      </select>
   </div>
   <div class="col-md-6"></div>
</div>
<div class="row form-group">
	<div class="col-md-3">		
	<label for="txt_logged_in_width" class="col-form-label lb_grid">Logo height(px)<span>(logged in)</span></label>	
	</div>
	<div class="col-md-3">
		<input name="menu[logged_in_logo_height]" type="number" id="txt_logged_in_height" class="form-control" value="<?php echo $menu_settings['logged_in_logo_height'] ?>">	
	</div>
   <div class="col-md-6">	
   </div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_logged_out_width" class="col-form-label lb_grid">Logo height(px)<span>(logged out)</span></label>	
	</div>
   <div class="col-md-3">
		<input name="menu[logged_out_logo_height]" type="number" id="txt_logged_out_height" class="form-control" value="<?php echo $menu_settings['logged_out_logo_height'] ?>">	
	</div>
   <div class="col-md-6"></div>
</div>

<div class="row pt-3 pb-3">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">MAIN MENU - ICON SETTINGS</h4>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_icon_size" class="col-form-label">Size</label>
	</div>
	<div class="col-md-3">
		<input name="menu[icon_size]" type="text" id="txt_icon_size" class="form-control" value="<?php echo $menu_settings['icon_size'] ?>">
	</div>
	<div class="col-md-6">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="ddl_icon_color" class="col-form-label">Color</label>
	</div>
	<div class="col-md-3">
		<select name="menu[icon_color]" type="text" id="ddl_icon_color" class="form-control">
		<?php 
			foreach($color_array as $key=>$value){
				?>
				<option <?php if($menu_settings['icon_color'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
				<?php
			}
		?>
		</select>
	</div>
	<div class="col-md-6">
	</div>
</div>
<div class="row form-group ai_center">
	<div class="col-md-3">
		<label for="menu_icon_visibility" class="col-form-label">Show icons on PC</label>
	</div>
	<div class="col-md-3">
		<?php 
			if(isset($menu_settings['icon_visibility'])){
				if($menu_settings['icon_visibility']=="ON"){
					$checked="checked";
				}else{
					$checked="";
				}
			}else{
				$checked="checked";
			}
		?>
		<label class="lx_toggle">
			<input type="checkbox" class="chk_icon_visibility" id="chk_icon_visibility" name="menu[icon_visibility]" <?php echo $checked;?>>
			<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
			<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
		</label>
	</div>
	<div class="col-md-6">
	</div>
</div>