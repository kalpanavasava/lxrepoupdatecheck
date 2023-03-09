<?php global $square_icon,$color_palette;?>
<div class="lxed_block_padding lxed_block_padding<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>">
	<h2 class="text-divider">
		<span class="lxed_add_section" data-section_id="<?php echo $section_id;?>"><i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
		</span>
	</h2>
	<div class="lxed_delete_buttonblock" style="text-align:end;">
		<span class="lx_area_delete" data-section_id="<?php echo $section_id;?>" type="button"><i class="<?php echo $square_icon['trash'];?> lxed_font_20" data-section_id="<?php echo $section_id;?>" aria-hidden="true"></i></span>
	</div>
	<div class="image-upload" style="text-align:center;">
	  <label for="lxed_img_block_inp<?php echo $section_id;?>" style="width:unset;">
		<img class="lxed_img_block_inpimg lxed_img_block_inpimg<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>" src="<?php echo $_POST['rand_img_block_array'][$section_id];?>" style="border:1px solid <?php echo $color_palette['black'];?>;" />
	  </label>
	  <input type="file" id="lxed_img_block_inp<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>" class="lxed_img_block_inp lxed_img_block_inp<?php echo $section_id;?> upload-input" name="lxed_img_block_inp" accept="image/jpg, image/jpeg, image/png"/>
	</div>
</div>