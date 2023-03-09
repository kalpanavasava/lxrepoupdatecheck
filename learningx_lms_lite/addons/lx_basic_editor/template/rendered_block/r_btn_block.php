<?php global $square_icon;?>
<?php 
/* vwpr($_POST); */
?>
<div class="lxed_block_padding lxed_block_padding<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>">
	<h2 class="text-divider">
		<span class="lxed_add_section" data-section_id="<?php echo $section_id;?>"><i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
		</span>
	</h2>
	<div class="lxed_delete_buttonblock" style="text-align:end;">
		<span class="lx_area_delete" data-section_id="<?php echo $section_id;?>" type="button"><i class="<?php echo $square_icon['trash'];?> lxed_font_20" data-section_id="<?php echo $section_id;?>" aria-hidden="true"></i></span>
	</div>
	<div class="form-group">
		<label for="lxed_buttonblocklabel<?php echo $section_id;?>"><strong>Button label</strong></label>
		<input type="text" class="form-control lxed_buttonblocklabel lxed_buttonblocklabel<?php echo $section_id;?>" id="lxed_buttonblocklabel<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>" name="lxed_buttonblocklabel" placeholder="Go to location 1" value="<?php echo $_POST['rend_btnblk_label'][$section_id];?>">
	</div>
	<div class="form-group">
		<label for="lxed_buttonblockdestination<?php echo $section_id;?>"><strong>Destination</strong></label>
		<div class="d-flex align-items-center">
			<i class="fal fa-link simple mr-2" aria-hidden="true"></i><input type="text" class="form-control lxed_buttonblockdestination lxed_buttonblockdestination<?php echo $section_id;?>" id="lxed_buttonblockdestination<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>" name="lxed_buttonblockdestination" placeholder="Enter a web url" value="<?php echo $_POST['rend_btnblk_dest'][$section_id];?>" />
		</div>
	</div>
	<div class="form-group">
		<label for="lxed_buttonblockdesc<?php echo $section_id;?>"><strong>Title and description</strong></label>
		<div class="lxed_buttonblockdesc lxed_buttonblockdesc<?php echo $section_id;?>" contenteditable="true" id="lxed_buttonblockdesc<?php echo $section_id;?>">
			<?php 
			echo $_POST['rend_btnblk_desc'][$section_id];
			?>
		</div>
	</div>
</div>