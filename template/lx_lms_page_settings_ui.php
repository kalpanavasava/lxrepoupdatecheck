<?php 
/**** for page settings ui ****/
?>
<div class="row pt-5 pb-4">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">BREAK POINTS</h4>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="lx_lms_brreakpoint_class" class="col-form-label">Breakpoint Class</label></th>
	</div>
	<div class="col-md-6">
		<input type="text" class="form-control" name="page[breakpoint_class]" id="lx_lms_brreakpoint_class" value="<?php echo $breakpoint['class'];?>">
	</div>
	<div class="col-md-6">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="lx_lms_brreakpoint_class" class="col-form-label">xs</label></th>
	</div>
	<div class="col-md-3">
		<input type="text" class="form-control" name="page[breakpoint_xs]" id="lx_lms_brreakpoint_xs" value="<?php echo $breakpoint['xs'];?>">
	</div>
	<div class="col-md-6">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="lx_lms_brreakpoint_class" class="col-form-label">sm</label></th>
	</div>
	<div class="col-md-3">
		<input type="text" class="form-control" name="page[breakpoint_sm]" id="lx_lms_brreakpoint_sm" value="<?php echo $breakpoint['sm'];?>">
	</div>
	<div class="col-md-6">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="lx_lms_brreakpoint_class" class="col-form-label">md</label></th>
	</div>
	<div class="col-md-3">
		<input type="text" class="form-control" name="page[breakpoint_md]" id="lx_lms_brreakpoint_md" value="<?php echo $breakpoint['md'];?>">
	</div>
	<div class="col-md-6">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="lx_lms_brreakpoint_class" class="col-form-label">lg</label></th>
	</div>
	<div class="col-md-3">
		<input type="text" class="form-control" name="page[breakpoint_lg]" id="lx_lms_brreakpoint_lg" value="<?php echo $breakpoint['lg'];?>">
	</div>
	<div class="col-md-6">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="lx_lms_brreakpoint_class" class="col-form-label">xl</label></th>
	</div>
	<div class="col-md-3">
		<input type="text" class="form-control" name="page[breakpoint_xl]" id="lx_lms_brreakpoint_xl" value="<?php echo $breakpoint['xl'];?>">
	</div>
	<div class="col-md-6">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="lx_lms_brreakpoint_class" class="col-form-label">xxl</label></th>
	</div>
	<div class="col-md-3">
		<input type="text" class="form-control" name="page[breakpoint_xxl]" id="lx_lms_brreakpoint_xxl" value="<?php echo $breakpoint['xxl'];?>">
	</div>
	<div class="col-md-6">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="lx_lms_brreakpoint_class" class="col-form-label">xxxl</label></th>
	</div>
	<div class="col-md-3">
		<input type="text" class="form-control" name="page[breakpoint_xxxl]" id="lx_lms_brreakpoint_xxxl" value="<?php echo $breakpoint['xxxl'];?>">
	</div>
	<div class="col-md-6">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="lx_lms_brreakpoint_class" class="col-form-label">Breakpoint exlude page</label>
	</div>
	<div class="col-md-3">
		<?php 
		 $expludepages = get_pages();
		 $selected_excludedpage = get_option('breakpoint_exclude');
		 /* lxprint($selected_excludedpage); */
		?>
		<select class="form-control" name="excludebreakpoint[]" id="excludebreakpoint" multiple >
			<option value="0">--Select--</option>
			<?php
			foreach( $expludepages as $pages ){
				$selpage = '';
				if(in_array($pages->ID,$selected_excludedpage)){
					$selpage = 'selected';
				}
				?>
				<option value="<?php echo $pages->ID;?>" <?php echo $selpage;?>><?php echo $pages->post_title;?></option>
				<?php
			}
			?>
		</select>
	</div>
	<div class="col-md-6">
		
	</div>
</div>
<div class="row pt-5 pb-4">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">PAGE DIVIDER STYLING</h4>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="lx_lms_devider_style" class="col-form-label">Style</label></th>
	</div>
	<div class="col-md-3">
		<select  class="form-control" name="page[devider_style]" id="lx_lms_devider_style">
			<option value="h1" <?php $page_devider['style']=="h1"?print 'selected':'';?>>H1</option>
			<option value="h2" <?php $page_devider['style']=="h2"?print 'selected':'';?>>H2</option>
			<option value="h3" <?php $page_devider['style']=="h3"?print 'selected':'';?>>H3</option>
			<option value="h4" <?php $page_devider['style']=="h4"?print 'selected':'';?>>H4</option>
			<option value="h5" <?php $page_devider['style']=="h5"?print 'selected':'';?>>H5</option>
			<option value="h6" <?php $page_devider['style']=="h6"?print 'selected':'';?>>H6</option>
			<option value="body_text" <?php $page_devider['style']=="body_text"?print 'selected':'';?>>Body Text</option>
			<option value="sub_text" <?php $page_devider['style']=="sub_text"?print 'selected':'';?>>Sub Text</option>
		</select>
	</div>
	<div class="col-md-6">
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="lx_lms_devider_color" class="col-form-label">Color</label></th>
	</div>
	<div class="col-md-3">
		<select  class="form-control" name="page[devider_color]" id="lx_lms_devider_color">
			<?php 
				foreach($color_palette as $key=>$value){
	
					if( $key !='hyperlinks' && $key !='heading_text' && $key !='body_text' && $key !='border' &&  $key !='course_completed' && $key !='course_partially_completed' && $key !='course_not_started'){ ?>
						<option value="<?php echo $value; ?>" <?php if($page_devider['color'] == $value ){ echo 'selected'; } ?>><?php echo ucwords(str_replace("_", " ", $key)); ?></option>
			<?php	}
				}
			?>
		</select>
	</div>
	<div class="col-md-6">
	</div>
</div>