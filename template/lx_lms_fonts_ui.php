<?php 
/**** for font css settings ui ****/
$fonts = array('Cera Pro Bold','Cera Pro Regular Italic','Cera Pro Medium','Gotham Bold','Gotham Regular','Nunito Sans','Montserrat','Oswald','Poppins','Raleway','SourceSansPro');
?>
<div class="row pt-5 pb-4">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">FONT FAMILIES</h4>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="ddl_heading_font" class="col-form-label">Headings</label>
	</div>
	<div class="col-md-3">
		<select name="font[heading_font]" type="text" id="ddl_heading_font" class="form-control">
		<?php foreach($fonts as $value){ ?>
		<option value="<?php echo $value; ?>" <?php if(isset($font_family['heading_font'])){ if($font_family['heading_font'] == $value ){ echo 'selected'; } }else if($fonts[0]== $value){ echo 'selected'; } ?>><?php echo $value; ?></option>
		<?php } ?>
		</select>
	</div>
	<div class="col-md-6">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="ddl_body_font" class="col-form-label">Body</label>
	</div>
	<div class="col-md-3">
		<select name="font[body_font]" type="text" id="ddl_body_font" class="form-control">
			<?php foreach($fonts as $value){ ?>
			<option value="<?php echo $value; ?>" <?php if(isset($font_family['heading_font'])){ if($font_family['body_font'] == $value ){ echo 'selected'; } }else if($fonts[1]== $value){ echo 'selected'; } ?>><?php echo $value; ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-1">
		<div class="form-group d-flex">
			<div class="mr-2">
				<input class="w-100" id="body_font_size" name="font[body_font_size]" type="text" value="<?php if(isset($font_family['body_font_size'])){ echo $font_family['body_font_size']; } ?>">
			</div>
			<div>
				<label for="body_font_size" class="col-form-label">px</label>
			</div>
		</div>
	</div>
	<div class="col-md-5">
	</div>
</div>
<div class="row pt-3 pb-3">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">ADDITIONAL FONT CSS</h4>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_h1_font" class="col-form-label">H1</label>
	</div>
	<div class="col-md-8">
		<textarea name="font[h1_font]" id="txt_h1_font" class="form-control" rows="3" value="<?php if(isset($font_family['h1_font'])){ echo $font_family['h1_font']; } ?>"><?php if(isset($font_family['h1_font'])){ echo $font_family['h1_font']; } ?></textarea>
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_h1_font"><i class="fal fa-undo"></i></span>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_h2_font" class="col-form-label">H2</label>
	</div>
	<div class="col-md-8">
		<textarea name="font[h2_font]" id="txt_h2_font" class="form-control" rows="3" value="<?php if(isset($font_family['h2_font'])){ echo $font_family['h2_font']; } ?>"><?php if(isset($font_family['h2_font'])){ echo $font_family['h2_font']; } ?></textarea>
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_h2_font"><i class="fal fa-undo"></i></span>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_h3_font" class="col-form-label">H3</label>
	</div>
	<div class="col-md-8">
		<textarea name="font[h3_font]" id="txt_h3_font" class="form-control" rows="3" value="<?php if(isset($font_family['h3_font'])){ echo $font_family['h3_font']; } ?>"><?php if(isset($font_family['h3_font'])){ echo $font_family['h3_font']; } ?></textarea>
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_h3_font"><i class="fal fa-undo"></i></span>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_h4_font" class="col-form-label">H4</label>
	</div>
	<div class="col-md-8">
		<textarea name="font[h4_font]" id="txt_h4_font" class="form-control" rows="3" value="<?php if(isset($font_family['h4_font'])){ echo $font_family['h4_font']; } ?>"><?php if(isset($font_family['h4_font'])){ echo $font_family['h4_font']; } ?></textarea>
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_h4_font"><i class="fal fa-undo"></i></span>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_h5_font" class="col-form-label">H5</label>
	</div>
	<div class="col-md-8">
		<textarea name="font[h5_font]" id="txt_h5_font" class="form-control" rows="3" value="<?php if(isset($font_family['h5_font'])){ echo $font_family['h5_font']; } ?>"><?php if(isset($font_family['h5_font'])){ echo $font_family['h5_font']; } ?></textarea>
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_h5_font"><i class="fal fa-undo"></i></span>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_h6_font" class="col-form-label">H6</label>
	</div>
	<div class="col-md-8">
		<textarea name="font[h6_font]" id="txt_h6_font" class="form-control" rows="3" value="<?php if(isset($font_family['h6_font'])){ echo $font_family['h6_font']; } ?>"><?php if(isset($font_family['h6_font'])){ echo $font_family['h6_font']; } ?></textarea>
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_h6_font"><i class="fal fa-undo"></i></span>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_body_font" class="col-form-label">Body</label>
	</div>
	<div class="col-md-8">
		<textarea name="font[body_font_info]" id="txt_body_font" class="form-control" rows="3" value="<?php if(isset($font_family['body_font_info'])){ echo $font_family['body_font_info']; } ?>"><?php if(isset($font_family['body_font_info'])){ echo $font_family['body_font_info']; } ?></textarea>
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_body_font"><i class="fal fa-undo"></i></span>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_body_font" class="col-form-label">Body Bold</label>
	</div>
	<div class="col-md-8">
		<textarea name="font[body_bold_font]" id="txt_body_font" class="form-control" rows="3" value="<?php if(isset($font_family['body_bold_font'])){ echo $font_family['body_bold_font']; } ?>"><?php if(isset($font_family['body_bold_font'])){ echo $font_family['body_bold_font']; } ?></textarea>
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_body_font"><i class="fal fa-undo"></i></span>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_sub_font" class="col-form-label">Sub Text</label>
	</div>
	<div class="col-md-8">
		<textarea name="font[sub_font]" id="txt_sub_font" class="form-control" rows="3" value="<?php echo $font_family['sub_text_font'];?>"><?php if(isset($font_family['sub_text_font'])){ echo $font_family['sub_text_font']; } ?></textarea>
	</div>
	<div class="col-md-1 btn_reset_main">
		<span id="btn_reset" class="btn_normal_state txt_sub_font"><i class="fal fa-undo"></i></span>
	</div>
</div>