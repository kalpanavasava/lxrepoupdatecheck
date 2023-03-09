<?php global $square_icon,$color_palette;?>
<div class="lxed_block_padding lxed_block_padding<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>">
	<h2 class="text-divider">
		<span class="lxed_add_section" data-section_id="<?php echo $section_id;?>"><i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
		</span>
	</h2>
	<div class="mb-2" style="text-align:end;">
		<span class="lx_area_delete" data-section_id="<?php echo $section_id;?>" type="button"><i class="<?php echo $square_icon['trash'];?> lxed_font_20" data-section_id="<?php echo $section_id;?>" aria-hidden="true"></i></span>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="row lxed_delete_buttonblock mb-2">
				<?php if(current_user_can('administrator')): ?>
				<div class="col-md-12" style="text-align:end;">
					<button class="lxed_swith_txtimg_to_html lxed_swith_txtimg_to_html<?php echo $section_id;?>" data-click="txt_imghtml" style="display:none;" data-section_id="<?php echo $section_id;?>">Html</button>
					
					<button class="lxed_swith_txtimg_to_editor lxed_swith_txtimg_to_editor<?php echo $section_id;?>"  data-click="txt_imgeditor" data-section_id="<?php echo $section_id;?>">Editor</button>
					
					<button class="lxed_reset_html lxed_reset_html<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>" style="display:none;" data-click="txt_imgeditor">Reset</button>
				</div>
				<?php endif; ?>
				
			</div>
			<div contenteditable="true" name="lx_editor_textimg_area lx_editor_textimg_area<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>" id="lx_editor_textimg_area<?php echo $section_id;?>" class="lx_editor_textimg_area lx_editor_textimg_area<?php echo $section_id;?> lxed_inp_css">
				<h4>Heading</h4>
				<p>When we show up to the present moment with all of our senses, we invite the world to fill us with joy. The pains of the past are behind us. The future has yet to unfold. But the now is full of beauty simply waiting for our attention.</p>
			</div>
			<textarea class="lx_editor_textimg_area_editor<?php echo $section_id;?> lxed_inp_css" rows="4" style="display:none;"></textarea>
		</div>
		<div class="col-md-6">
			<div class="image-upload">
			  <label for="lxed_txt_img_block_inp<?php echo $section_id;?>">
				<img class="lxed_txt_img_block_inpimg lxed_txt_img_block_inpimg<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>" src="<?php echo lx_plugin_url.'assets/img/sample_broken_img.jpg';?>" style="border:1px solid <?php echo $color_palette['black'];?>;width:100%;" />
			  </label>

			  <input type="file" id="lxed_txt_img_block_inp<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>" class="lxed_txt_img_block_inp lxed_txt_img_block_inp<?php echo $section_id;?> upload-input" name="lxed_txt_img_block_inp" accept="image/jpg, image/jpeg, image/png"/>
			</div>
		</div>
	</div>
</div>