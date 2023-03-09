<?php global $square_icon;?>
<div class="lxed_block_padding lxed_block_padding<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>">

	<h2 class="text-divider">
		<span class="lxed_add_section" data-section_id="<?php echo $section_id;?>"><i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
		</span>
	</h2>
	
	<div class="row lxed_delete_buttonblock mb-2">
		<?php if(current_user_can('administrator')): ?>
		<div class="col-md-6">
			<button class="lxed_swith_to_html lxed_swith_to_html<?php echo $section_id;?>" style="display:none;" data-click="txthtml" data-section_id="<?php echo $section_id;?>">Html</button>
			
			<button class="lxed_swith_to_editor lxed_swith_to_editor<?php echo $section_id;?>" data-click="txteditor" data-section_id="<?php echo $section_id;?>">Editor</button>
			
			<button class="lxed_reset_html lxed_reset_html<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>" style="display:none;" data-click="txteditor">Reset</button>
		</div>
		<?php endif; ?>
		<div class="col-md-6" style="text-align:end;">
			<span class="lx_area_delete" data-section_id="<?php echo $section_id;?>" type="button"><i class="<?php echo $square_icon['trash'];?> lxed_font_20" data-section_id="<?php echo $section_id;?>" aria-hidden="true"></i></span>
		</div>
	</div>
	
	
	<div contenteditable="true" name="lx_editor_text_area lx_editor_text_area<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>" id="lx_editor_text_area<?php echo $section_id;?>" class="lx_editor_text_area lx_editor_text_area<?php echo $section_id;?> lxed_inp_css">
		<h4>Heading</h4>
		<p>When we show up to the present moment with all of our senses, we invite the world to fill us with joy. The pains of the past are behind us. The future has yet to unfold. But the now is full of beauty simply waiting for our attention.</p>
	</div>
	<textarea class="lx_editor_text_area_editor<?php echo $section_id;?> lxed_inp_css" rows="4" style="display:none;"></textarea>

</div>