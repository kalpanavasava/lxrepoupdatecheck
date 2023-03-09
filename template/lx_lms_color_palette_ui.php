<?php /**** for button css settings ui ****/ ?>
<div class="row pt-5 pb-4">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">DEFAULT SITE-WIDE COLOR SETTINGS</h4>
		<em>(these can be over-ridden by Menu settings or Button CSS)</em>
	</div>		
</div>
<?php
	$color_palette = get_option('user_interface_color_palette');
	$color_array = array('Blue','Green','Orange','Red','Purple','Black','Charcoal','White','Grey','Light Grey','Mid Grey','Custom1','Custom2','Custom3','Custom4');
?>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="txt_hyperlinks" class="col-form-label">Hyperlinks</label>
		</div>
		<div class="col-md-3">
			<select name="color[hyperlinks]" type="text" id="txt_hyperlinks" class="form-control">
			<?php 
				foreach($color_array as $key=>$value){
					?>
					<option <?php if($color_palette['hyperlinks'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
					<?php
				}
			?>		
			</select>
			
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="txt_heading_text" class="col-form-label">Heading Text</label>
		</div>
		<div class="col-md-3">
			<select name="color[heading_text]" type="text" id="txt_heading_text" class="form-control">
			<?php 
				foreach($color_array as $key=>$value){
					?>
					<option <?php if($color_palette['heading_text'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
					<?php
					/* if( $key !='hyperlinks' && $key !='heading_text' && $key !='body_text' && $key !='border' &&  $key !='course_completed' && $key !='course_partially_completed' && $key !='course_not_started'){ ?>
						<option value="<?php echo $value; ?>" <?php if(isset($color_palette['heading_text'])){ if($color_palette['heading_text'] == $value ){ echo 'selected'; } } ?>><?php echo ucwords(str_replace("_", " ", $key)); ?></option>
			<?php	} */
				}
			?>
			
			</select>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="txt_body_text" class="col-form-label">Body Text</label>
		</div>
		<div class="col-md-3">
			<select name="color[body_text]" type="text" id="txt_body_text" class="form-control">
			<?php 
				foreach($color_array as $key=>$value){
					?>
					<option <?php if($color_palette['body_text'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
					<?php
					/* if( $key !='hyperlinks' && $key !='heading_text' && $key !='body_text' && $key !='border' &&  $key !='course_completed' && $key !='course_partially_completed' && $key !='course_not_started'){ ?>
						<option value="<?php echo $value; ?>" <?php if(isset($color_palette['body_text'])){ if($color_palette['body_text'] == $value ){ echo 'selected'; } } ?>><?php echo ucwords(str_replace("_", " ", $key));; ?></option>
			<?php	} */
				}
			?>
			
			</select>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="txt_body_text" class="col-form-label">Border</label>
		</div>
		<div class="col-md-3">
			<select name="color[border_text]" type="text" id="txt_body_text" class="form-control">
			<?php 
				foreach($color_array as $key=>$value){
					?>
					<option <?php if($color_palette['border'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
					<?php
				}
			?>
			
			</select>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="txt_ib_border" class="col-form-label">Info box border</label>
		</div>
		<div class="col-md-3">
			<select name="color[infobox_border]" type="text" id="txt_ib_border" class="form-control">
			<?php 
				foreach($color_array as $key=>$value){
					?>
					<option <?php if($color_palette['infobox_border'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
					<?php
				}
			?>		
			</select>
			
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="txt_hyperlinks" class="col-form-label">Info box icon color</label>
		</div>
		<div class="col-md-3">
			<select name="color[infobox_icon]" type="text" id="txt_hyperlinks" class="form-control">
			<?php 
				foreach($color_array as $key=>$value){
					?>
					<option <?php if($color_palette['infobox_icon'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
					<?php
				}
			?>		
			</select>
			
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<div class="row pt-3 pb-3">
		<div class="col-md-12 admin_section_title"><h4 class="head_h4">COURSE COMPLETION INDICATORS</h4></div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="txt_c_completed" class="col-form-label">Course completion background</label>
		</div>
		<div class="col-md-3">
			<select name="color[c_completed]" type="text" id="txt_c_completed" class="form-control">
			<?php 
				foreach($color_array as $key=>$value){
				?>
					<option <?php if($color_palette['course_completed'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
					<?php
				}	
			?>
			</select>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="txt_c_partially_completed" class="col-form-label">Course partially completion background</label>
		</div>
		<div class="col-md-3">
			<select name="color[c_partially_completed]" type="text" id="txt_c_partially_completed" class="form-control">
			<?php 
				foreach($color_array as $key=>$value){
				?>
					<option <?php if($color_palette['course_partially_completed'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
					<?php
				}	
			?>
			</select>
		</div>
	</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_c_not_started" class="col-form-label">Course Not Started background</label>
	</div>
	<div class="col-md-3">
		<select name="color[c_not_started]" type="text" id="txt_c_not_started" class="form-control">
		<?php 
			foreach($color_array as $key=>$value){
			?>
				<option <?php if($color_palette['course_not_started'] == $value){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
				<?php
			}	
		?>
		</select>
	</div>
	<div class="col-md-6">
	</div>
</div>
<div class="row pt-3 pb-3">
	<div class="col-md-12 admin_section_title"><h4 class="head_h4">CUSTOM COLOR PALLETE</h4></div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_blue" class="col-form-label">Blue</label>
	</div>
	<div class="col-md-3">
		<input name="color[blue]" type="text" id="txt_blue" class="form-control" value="<?php if(isset($color_palette['blue'])){ echo $color_palette['blue']; }else{ echo '#03A9F4'; } ?>" data-change="#blue_color">
	</div>
	<div class="col-md-1">
		<input type="color" id="blue_color" class="form-control" name="blue_color"  data-change="#txt_blue" value="<?php if(isset($color_palette['blue'])){ echo $color_palette['blue']; }else{ echo '#03A9F4'; } ?>">
	</div>
	<div class="col-md-5">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_green" class="col-form-label">Green</label>
	</div>
	<div class="col-md-3">
		<input name="color[green]" type="text" id="txt_green" class="form-control" value="<?php if(isset($color_palette['green'])){ echo $color_palette['green']; }else{ echo '#8BC34A'; } ?>" data-change="#green_color">
	</div>
	<div class="col-md-1">
		<input type="color" id="green_color" class="form-control" name="green_color" data-change="#txt_green" value="<?php if(isset($color_palette['green'])){ echo $color_palette['green']; }else{ echo '#8BC34A'; } ?>">
	</div>
	<div class="col-md-5">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_orange" class="col-form-label">Orange</label>
	</div>
	<div class="col-md-3">
		<input name="color[orange]" type="text" id="txt_orange" class="form-control" value="<?php if(isset($color_palette['orange'])){ echo $color_palette['orange']; }else{ echo '#FF9800'; } ?>" data-change="#orange_color">
	</div>
	<div class="col-md-1">
		<input type="color" id="orange_color" class="form-control" name="orange_color" data-change="#txt_orange" value="<?php if(isset($color_palette['orange'])){ echo $color_palette['orange']; }else{ echo '#FF9800'; } ?>">
	</div>
	<div class="col-md-5">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_red" class="col-form-label">Red</label>
	</div>
	<div class="col-md-3">
		<input name="color[red]" type="text" id="txt_red" class="form-control"  value="<?php if(isset($color_palette['red'])){ echo $color_palette['red']; }else{ echo '#F44336'; } ?>" data-change="#red_color">
	</div>
	<div class="col-md-1">
		<input type="color" id="red_color" class="form-control" name="red_color" data-change="#txt_red" value="<?php if(isset($color_palette['red'])){ echo $color_palette['red']; }else{ echo '#F44336'; } ?>">
	</div>
	<div class="col-md-5">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_purple" class="col-form-label">Purple</label>
	</div>
	<div class="col-md-3">
		<input name="color[purple]" type="text" id="txt_purple" class="form-control"  value="<?php if(isset($color_palette['purple'])){ echo $color_palette['purple']; }else{ echo '#9C27B0'; } ?>" data-change="#purple_color">
	</div>
	<div class="col-md-1">
		<input type="color" id="purple_color" class="form-control" name="purple_color"  data-change="#txt_purple" value="<?php if(isset($color_palette['purple'])){ echo $color_palette['purple']; }else{ echo '#9C27B0'; } ?>">
	</div>
	<div class="col-md-5">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_black" class="col-form-label">Black</label>
	</div>
	<div class="col-md-3">
		<input name="color[black]" type="text" id="txt_black" class="form-control"  value="<?php if(isset($color_palette['black'])){ echo $color_palette['black']; }else{ echo '#000000'; } ?>" data-change="#black_color">
	</div>
	<div class="col-md-1">
		<input type="color" id="black_color" class="form-control" name="black_color" data-change="#txt_black" value="<?php if(isset($color_palette['black'])){ echo $color_palette['black']; }else{ echo '#000000'; } ?>">
	</div>
	<div class="col-md-5">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_charcoal" class="col-form-label">Charcoal</label>
	</div>
	<div class="col-md-3">
		<input name="color[charcoal]" type="text" id="txt_charcoal" class="form-control" value="<?php if(isset($color_palette['charcoal'])){ echo $color_palette['charcoal']; }else{ echo '#333333'; } ?>" data-change="#charcoal_color">
	</div>
	<div class="col-md-1">
		<input type="color" id="charcoal_color" class="form-control" name="charcoal_color" data-change="#txt_charcoal" value="<?php if(isset($color_palette['charcoal'])){ echo $color_palette['charcoal']; }else{ echo '#333333'; } ?>">
	</div>
	<div class="col-md-5">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_white" class="col-form-label">White</label>
	</div>
	<div class="col-md-3">
		<input name="color[white]" type="text" id="txt_white" class="form-control" value="<?php if(isset($color_palette['white'])){ echo $color_palette['white']; }else{ echo '#FFFFFF'; } ?>" data-change="#white_color">
	</div>
	<div class="col-md-1">
		<input type="color" id="white_color" class="form-control" name="white_color" data-change="#txt_white" value="<?php if(isset($color_palette['white'])){ echo $color_palette['white']; }else{ echo '#FFFFFF'; } ?>">
	</div>
	<div class="col-md-5">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_grey" class="col-form-label">Grey</label>
	</div>
	<div class="col-md-3">
		<input name="color[grey]" type="text" id="txt_grey" class="form-control"  value="<?php if(isset($color_palette['grey'])){ echo $color_palette['grey']; }else{ echo '#808080'; } ?>" data-change="#grey_color">
	</div>
	<div class="col-md-1">
		<input type="color" id="grey_color" name="grey_color" class="form-control"  data-change="#txt_grey" value="<?php if(isset($color_palette['grey'])){ echo $color_palette['grey']; }else{ echo '#808080'; } ?>" >
	</div>
	<div class="col-md-5">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_light_grey" class="col-form-label">Light Grey</label>
	</div>
	<div class="col-md-3">
		<input name="color[light_grey]" type="text" id="txt_light_grey" class="form-control"  value="<?php if(isset($color_palette['light_grey'])){ echo $color_palette['light_grey']; }else{ echo '#EFEFEF'; } ?>" data-change="#light_grey_color">
	</div>
	<div class="col-md-1">
		<input type="color" id="light_grey_color" name="light_grey_color" class="form-control"  data-change="#txt_light_grey" value="<?php if(isset($color_palette['light_grey'])){ echo $color_palette['light_grey']; }else{ echo '#EFEFEF'; } ?>">
	</div>
	<div class="col-md-5">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_mid_grey" class="col-form-label">Mid Grey</label>
	</div>
	<div class="col-md-3">
		<input name="color[mid_grey]" type="text" id="txt_mid_grey" class="form-control" value="<?php if(isset($color_palette['mid_grey'])){ echo $color_palette['mid_grey']; }else{ echo '#CCCCCC'; } ?>" data-change="#mid_grey_color">
	</div>
	<div class="col-md-1">
		<input type="color" id="mid_grey_color" class="form-control" name="mid_grey_color" data-change="#txt_mid_grey"   value="<?php if(isset($color_palette['mid_grey'])){ echo $color_palette['mid_grey']; }else{ echo '#CCCCCC'; } ?>">
	</div>
	<div class="col-md-5">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_custom1" class="col-form-label">Custom1</label>
	</div>
	<div class="col-md-3">
		<input name="color[custom1]" type="text" id="txt_custom1" class="form-control" value="<?php if(isset($color_palette['custom1'])){ echo $color_palette['custom1']; } ?>" data-change="#custom1_color">
	</div>
	<div class="col-md-1">
		<input type="color" id="custom1_color" name="custom1_color" class="form-control" data-change="#txt_custom1" value="<?php if(isset($color_palette['custom1'])){ echo $color_palette['custom1']; } ?>">
	</div>
	<div class="col-md-5">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_custom2" class="col-form-label">Custom2</label>
	</div>
	<div class="col-md-3">
		<input name="color[custom2]" type="text" id="txt_custom2" class="form-control" value="<?php if(isset($color_palette['custom2'])){ echo $color_palette['custom2']; } ?>" data-change="#custom2_color">
	</div>
	<div class="col-md-1">
		<input type="color" id="custom2_color" class="form-control" name="custom2_color" data-change="#txt_custom2" value="<?php if(isset($color_palette['custom2'])){ echo $color_palette['custom2']; } ?>">
	</div>
	<div class="col-md-5">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_custom3" class="col-form-label">Custom3</label>
	</div>
	<div class="col-md-3">
		<input name="color[custom3]" type="text" id="txt_custom3" class="form-control" value="<?php if(isset($color_palette['custom3'])){ echo $color_palette['custom3']; } ?>" data-change="#custom3_color">
	</div>
	<div class="col-md-1">
		<input type="color" id="custom3_color" class="form-control" name="custom3_color" data-change="#txt_custom3" value="<?php if(isset($color_palette['custom3'])){ echo $color_palette['custom3']; } ?>">
	</div>
	<div class="col-md-5">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_custom4" class="col-form-label">Custom4</label>
	</div>
	<div class="col-md-3">
		<input name="color[custom4]" type="text" id="txt_custom4" class="form-control" value="<?php if(isset($color_palette['custom4'])){ echo $color_palette['custom4']; } ?>" data-change="#custom4_color">
	</div>
	<div class="col-md-1">
		<input type="color" id="custom4_color" name="custom4_color" data-change="#txt_custom4" class="form-control" value="<?php if(isset($color_palette['custom4'])){ echo $color_palette['custom4']; } ?>">
	</div>
	<div class="col-md-5">
	</div>
</div>