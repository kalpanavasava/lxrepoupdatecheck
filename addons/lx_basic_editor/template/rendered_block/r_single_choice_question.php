<?php global $square_icon;?>
<div class="lxed_block_padding lxed_block_padding<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>">
	<input type="hidden" class="new-edit-single" value="1"/>
	<h2 class="text-divider">
		<span class="lxed_add_section" data-section_id="<?php echo $section_id;?>"><i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
		</span>
	</h2>
	
	<div class="row lxed_delete_buttonblock mb-2">
		<div class="col-md-12" style="text-align:end;">
			<span class="lx_area_delete" data-section_id="<?php echo $section_id;?>" type="button"><i class="<?php echo $square_icon['trash'];?> lxed_font_20" data-section_id="<?php echo $section_id;?>" aria-hidden="true"></i></span>
		</div>
	</div>
	<!-- Questions -->
	<?php foreach($sing_choice_main_array[$section_id] as $question_id=>$single_choice_all_data){ ?>
	<div class="lxed_main_single_question_div lxed_main_single_question_div<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>">
		<div class="lxed_main_single_question_div_inner lxed_main_single_question_div_inner<?php echo $section_id;?> lxed_main_single_question_div_inner<?php echo $section_id;?><?php echo $question_id;?>" data-section_id="<?php echo $section_id;?>">
			<div class="row">
				<div contenteditable="true" name="lx_editor_questions<?php echo $section_id;?><?php echo $question_id;?>" data-section_id="<?php echo $section_id;?>" data-question_id ='<?php echo $question_id;?>' id="lx_editor_questions<?php echo $section_id;?><?php echo $question_id;?>" class="lx_editor_questions lx_editor_questions<?php echo $section_id;?><?php echo $question_id;?> lx_editor_questions<?php echo $section_id;?> lxed_inp_css col-md-11">
					<?php echo stripslashes_deep($single_choice_all_data['ques']);?>
				</div>
				<div class="col-md-1">
					<i class="<?php echo $square_icon['trash'];?> lxed_font_20 lxed_remove_single_ques" style="cursor:pointer;" data-section_id="<?php echo $section_id;?>" data-question_id="<?php echo $question_id;?>" aria-hidden="true"></i>
				</div>
			</div>
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-11"><strong>Answers</strong></div>
			</div>
			<?php 
			$i=1;
			foreach($single_choice_all_data['ans'] as $key=>$ans_data){
			/* echo $single_choice_all_data['ans_selected'][$key]; */
			?>
			<div class="row mt-4 lxed_single_choice_answeropt_div lxed_single_choice_answeropt_div1 lxed_single_choice_answeropt_div<?php echo $section_id;?><?php echo $question_id;?> lxed_single_choice_answeropt_div<?php echo $section_id;?><?php echo $question_id;?><?php echo $i;?>">
				<div class="col-md-1">
					<input class="form-check-input lxed_single_answer_radio lxed_single_answer_radio<?php echo $section_id;?>1 mt-2 ml-2" type="radio" data-question_id="<?php echo $question_id;?>" data-section_id="<?php echo $section_id;?>" name="lxed_single_answer_radio<?php echo $section_id;?><?php echo $question_id;?>" id="lxed_single_answer_radio" <?php if($single_choice_all_data['ans_selected'][$key] == 'correct'){echo 'checked';} ?> value="<?php echo $i;?>">
				</div>
				<div data-loop_id="<?php echo $i;?>" name="lx_editor_singleans_opt lx_editor_singleans_opt<?php echo $section_id;?>" data-question_id="<?php echo $question_id;?>" data-section_id="<?php echo $section_id;?>" id="lx_editor_singleans_opt<?php echo $section_id;?>" class="lx_editor_singleans_opt lx_editor_singleans_opt<?php echo $section_id;?><?php echo $question_id;?> lx_editor_singleans_opt<?php echo $section_id;?> lxed_inp_css col-md-10">
					<div class="lx_editor_singleans_opt_inner_div" data-question_id="<?php echo $question_id;?>" data-section_id="<?php echo $section_id;?>" >
						<div contenteditable="true" class="lxed_single_chose_answer lxed_single_chose_answer<?php echo $section_id;?><?php echo $question_id;?><?php echo $i;?> lxed_single_chose_answer<?php echo $section_id;?><?php echo $i;?> lx_input_bn" data-question_id="<?php echo $question_id;?>" data-loop_id="<?php echo $i;?>" data-section_id="<?php echo $section_id;?>" data-val="<?php echo $i;?>"><?php echo $ans_data;?></div>
						<div contenteditable="true" class="lxed_single_chose_feedback lxed_single_chose_feedback<?php echo $section_id;?><?php echo $i;?> lx_input_bn" data-question_id="<?php echo $question_id;?>" data-loop_id="<?php echo $i;?>" data-section_id="<?php echo $section_id;?>" data-val="<?php echo $i;?>"><?php echo $single_choice_all_data['ans_feed'][$key];?></div>
					</div>
				</div>
				<div class="col-md-1">
					<i class="fas <?php echo $square_icon['trash'];?> lxed_font_20 lxed_remove_single_tab" style="cursor:pointer;" data-section_id="<?php echo $section_id;?>" data-question_id="<?php echo $question_id;?>" data-loop_id="<?php echo $i;?>" aria-hidden="true"></i>
				</div>
			</div>
			<?php $i++; } ?>
			<section class="disabled_single_choice_load<?php echo $section_id;?> disabled_single_choice_load<?php echo $section_id;?><?php echo $question_id;?>" data-section_id="<?php echo $section_id;?>"></section>
			
			<div class="row disabled_single_choice disabled_single_choice<?php echo $section_id;?><?php echo $question_id;?> mt-2" data-question_id="<?php echo $question_id;?>" data-section_id="<?php echo $section_id;?>">
				<div class="col-md-1">
					<input class="form-check-input  mt-2 ml-2" type="radio" disabled name="" id="" value="">
				</div>
				<div contenteditable="false" name="" data-section_id="<?php echo $section_id;?>" id="" class="lxed_inp_css col-md-11">
					<strong class="lxed_single_chose_answer">Add another answer here... (optional)</strong>
				</div>
			</div>
			<hr/>
		</div>
	</div>
	<?php } ?>
	
		<div class="row mt-4">
			<div class="col-md-1"></div>
			<div class="col-md-11">
				<button class="lxed_button_question" data-section_id="<?php echo $section_id;?>"><i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i> ADD ANOTHER QUESTION</button>
			</div>
		</div>
	
	
	<!-- Questions End -->
</div>