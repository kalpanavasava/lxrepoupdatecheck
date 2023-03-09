<?php global $square_icon;?>
<div class="lxed_block_padding lxed_block_padding<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>">
	<h2 class="text-divider">
		<span class="lxed_add_section" data-section_id="<?php echo $section_id;?>"><i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
		</span>
	</h2>
<div class="lxed_delete_buttonblock" style="text-align:end;">
	<span class="lx_area_delete" data-section_id="<?php echo $section_id;?>" type="button"><i class="<?php echo $square_icon['trash'];?> lxed_font_20" data-section_id="<?php echo $section_id;?>" aria-hidden="true"></i></span>
</div>
	<div class="image-upload" style="text-align:center;">
	  <label for="lxed_vid_block_inp<?php echo $section_id;?>">  <input type="file" id="lxed_vid_block_inp<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>" class="lxed_vid_block_inp lxed_vid_block_inp<?php echo $section_id;?> upload-input" name="lxed_vid_block_inp">
	  </label>
		<section class="lxed_vid_block_inpvideo_section_load lxed_vid_block_inpvideo_section_load<?php echo $section_id;?>">
			<video class="lxed_vid_block_inpvideo lxed_vid_block_inpvideo<?php echo $section_id;?> mt-4" style="width:100%;" controls data-section_id="<?php echo $section_id;?>">
			  <source class="lxed_vid_block_inpsource lxed_vid_block_inpsource<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>" src="<?php echo $_POST['video_block_array'][$section_id];?>" type="video/mp4">
			</video>
		</section>
		
	</div>
</div>
