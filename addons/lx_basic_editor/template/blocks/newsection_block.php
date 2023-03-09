<?php global $square_icon,$color_palette;?>
<div class="lx_main_newsection lx_main_newsection<?php echo $section_id;?>">
	<div class="lx_new_section_area lx_new_section_area<?php echo $section_id;?>" style="background:<?php echo $color_palette['light_grey'];?>;padding: 15px;box-shadow: 5px 5px 5px 0px rgb(0 0 0 / 50%);">
		<span class="lx_section_title lx_section_title<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>">SECTION TITLE</span>
		<input type="text" class="lx_sectiontitle_input lx_sectiontitle_input<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>" style="display:none;" value="" placeholder="SECTION TITLE"/>
		<i class="<?php echo $square_icon['trash'];?> lx_area_delete" data-section_id="<?php echo $section_id;?>" aria-hidden="true" style="float: right;right: 4px;"></i>
		<i class="<?php echo $square_icon['edit'];?> lx_area_edit" data-section_id="<?php echo $section_id;?>" aria-hidden="true" style="float: right;right: 2px;"></i>
	</div>

	<div class="lx_new_section_area_block lx_new_section_area_block<?php echo $section_id;?>" style="" data-section_id="<?php echo $section_id;?>">
		<div class="lx_collapse"><i class="fa fa-angle-up lx_collapse lx_collapse_i<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>" aria-hidden="true"></i></div>
		<div class="lx_editor_load_here lx_editor_load_here<?php echo $section_id;?>">
			<div id='lx_editor_drop_zone' ondrop="drop(event)" ondragover="allowDrop(event)" class="lx_editor_drop_zone lx_editor_drop_zone<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>" style="text-align:center;">DROP SECTION HERE</div>
		</div>
	</div>
	<script>
		
	</script>
	<h2 class="text-divider"><span><i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i></span></h2>

</div>