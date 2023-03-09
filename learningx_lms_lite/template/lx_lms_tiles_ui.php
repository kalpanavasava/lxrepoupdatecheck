<?php
/**** for lms tiles ui ****/ 
global $lx_plugin_paths,$lx_plugin_urls;
$tile_style_info = array(
	'Style 1' => $lx_plugin_paths['lx_lms_lite'].'template/tiles/tiles_style_1_ui.php',
	'Style 2' => $lx_plugin_paths['lx_lms_lite'].'template/tiles/tiles_style_2_ui.php',
	'Style 3' => $lx_plugin_paths['lx_lms_lite'].'template/tiles/tiles_style_3_ui.php',
 );
 $course_content_tile_style_info = array(
	'Style 1' => $lx_plugin_paths['lx_lms_lite'].'template/tiles/tiles_style_1_ui.php',
	'Style 2' => $lx_plugin_paths['lx_lms_lite'].'template/tiles/tiles_style_2_ui.php',
	'Style 3' => $lx_plugin_paths['lx_lms_lite'].'template/tiles/tiles_style_3_ui.php'
 ); 
 $flip_tiles=flip_tiles_info();
 lx_lms_lite_page_setting();
 ?>
<div class="row pt-5 pb-4 test-1">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">TILE TYPES</h4>
	</div>
</div>
<div class="row tiles_ui">
	<div class="col-md-6">
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ddl_course_tile" class="col-form-label">COURSE TILE</label>
			</div>
			<div class="col-md-6">
				<select name="tiles[course_tile]" type="text" id="ddl_course_tile" class="form-control">
					<?php foreach($tile_style_info as $key => $value){ ?>
						<option value="<?php echo $value; ?>" <?php if(isset($tiles_style['course_tile'])){ if($tiles_style['course_tile'] == $value ){ echo 'selected'; } }else if($tile_style_info['Style 1'] == $value){ echo 'selected'; } ?>><?php echo $key; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<?php
		/* <div class="row form-group">
			<div class="col-md-6">
				<label for="ddl_blog_tile" class="col-form-label">BLOG TILE</label>
			</div>
			<div class="col-md-6">
				<select name="tiles[blog_tile]" type="text" id="ddl_blog_tile" class="form-control">
					<?php foreach($tile_style_info as $key => $value){ ?>
						<option value="<?php echo $value; ?>" <?php if(isset($tiles_style['blog_tile'])){ if($tiles_style['blog_tile'] == $value ){ echo 'selected'; } }else if($tile_style_info['Style 1'] == $value){ echo 'selected'; } ?>><?php echo $key; ?></option>
					<?php } ?>
				</select>
			</div>
		</div> */
		?>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ddl_course_content_tile" class="col-form-label">COURSE CONTENT TILE</label>
			</div>
			<div class="col-md-6">
				<select name="tiles[course_content_tile]" type="text" id="ddl_course_content_tile" class="form-control">
					<?php foreach($course_content_tile_style_info as $key => $value){ ?>
						<option value="<?php echo $value; ?>" <?php if(isset($tiles_style['course_content_tile'])){ if($tiles_style['course_content_tile'] == $value ){ echo 'selected'; } }else if($tile_style_info['Style 1'] == $value){ echo 'selected'; } ?>><?php echo $key; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ddl_fl1p_forum_tile" class="col-form-label">Fl1p forum tile</label> 
			</div>
			<div class="col-md-6">
				<select name="tiles[fl1p_forum_tile]" type="text" id="ddl_fl1p_forum_tile" class="form-control">
					<?php foreach($flip_tiles['flip_forum'] as $key => $value){ ?>
						<option value="<?php echo $value; ?>" <?php if(isset($tiles_style['fl1p_forum_tile'])){ if($tiles_style['fl1p_forum_tile'] == $value ){ echo 'selected'; } }else if($flip_tiles['flip_forum']['Style 3'] == $value){ echo 'selected'; } ?>><?php echo $key; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ddl_Fl1p_topic_tile" class="col-form-label">Fl1p topic tile</label> 
			</div>
			<div class="col-md-6">
				<select name="tiles[fl1p_topic_tile]" type="text" id="ddl_Fl1p_topic_tile" class="form-control">
					<?php foreach($flip_tiles['flip_topic'] as $key => $value){ ?>
						<option value="<?php echo $value; ?>" <?php if(isset($tiles_style['fl1p_topic_tile'])){ if($tiles_style['fl1p_topic_tile'] == $value ){ echo 'selected'; } }else if($flip_tiles['flip_topic']['Style 1'] == $value){ echo 'selected'; } ?>><?php echo $key; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ddl_articulate_tile" class="col-form-label">ARTICULATE TILE</label>
			</div>
			<div class="col-md-6">
				<?php 
				$articulate_tile_ar = array( 
				'Style 1' => $lx_plugin_paths['lx_lms_lite'].'template/tiles/articulate/style1_ui.php', 
				'Style 2' => $lx_plugin_paths['lx_lms_lite'].'template/tiles/articulate/style2_ui.php', 
				'Style 3' => $lx_plugin_paths['lx_lms_lite'].'template/tiles/articulate/style3_ui.php', 
				'Style 4' => $lx_plugin_paths['lx_lms_lite'].'template/tiles/tiles_style_4_ui.php', 
				);
				
				?>
				<select name="tiles[articulate_tile]" type="text" id="ddl_articulate_tile" class="form-control">
					<?php
					foreach( $articulate_tile_ar as $atkey => $attile ){
					?>
					<option <?php if(isset($tiles_style['articulate_tile'])){ if($tiles_style['articulate_tile'] == $attile ){ echo 'selected'; } } ?> value="<?php echo $attile; ?>"><?php echo $atkey; ?></option>
					<?php 
					}
					?>
				</select>
			</div>
		</div>
		<div class="row pt-5">
			<div class="col-md-12 admin_section_title">
				<h4 class="head_h4">ADDITIONAL STYLE OPTIONS</h4>
			</div>
		</div>
		<div class="row pt-1 pb-1">
			<div class="col-md-12 pt-4">
				<h4 class="head_h4">If Style 2 Is Selected:</h4>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ddl_completion_bg_color" class="col-form-label">Course completion background</label>
			</div>
			<div class="col-md-6">
				<select name="tiles[completion_bg_color]" type="text" id="ddl_completion_bg_color" class="form-control">
					<?php 
						foreach($color_palette as $key=>$value){

							if( $key !='hyperlinks' && $key !='heading_text' && $key !='body_text' && $key !='border' &&  $key !='course_completed' && $key !='course_partially_completed' && $key !='course_not_started'&& $key!='infobox_border' && $key!='infobox_icon'){ ?>
								<option value="<?php echo $value; ?>" <?php if(isset($style_2_tiles_interface['completion_bg_color'])){ if($style_2_tiles_interface['completion_bg_color'] == $value ){ echo 'selected'; } }else if($key == "charcoal"){ echo 'selected'; } ?>><?php echo ucwords(str_replace("_", " ", $key)); ?></option>
					<?php	}
						}
					?>
				</select>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="ddl_completion_status_color" class="col-form-label">Course completion text</label>
			</div>
			<div class="col-md-6">
				<select name="tiles[completion_status_color]" type="text" id="ddl_completion_status_color" class="form-control">
					<?php 
						foreach($color_palette as $key=>$value){

							if( $key !='hyperlinks' && $key !='heading_text' && $key !='body_text' && $key !='border' &&  $key !='course_completed' && $key !='course_partially_completed' && $key !='course_not_started'&& $key!='infobox_border' && $key!='infobox_icon'){ ?>
								<option value="<?php echo $value; ?>" <?php if(isset($style_2_tiles_interface['completion_status_color'])){ if($style_2_tiles_interface['completion_status_color'] == $value ){ echo 'selected'; } }else if($key == "white"){ echo 'selected'; } ?>><?php echo ucwords(str_replace("_", " ", $key)); ?></option>
					<?php	}
						}
					?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="row form-group">
			<div class="col-md-6">
				<?php 
					lx_lite_tile_style_1();
					lx_lite_tile_style_3();
				?>
			</div>
			<div class="col-md-6">
				<?php 
					lx_lite_tile_style_2();
					lx_lite_tile_style_4();
				?>
			</div>
		</div>
	</div>
</div>