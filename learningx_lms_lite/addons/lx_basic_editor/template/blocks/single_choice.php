<?php global $square_icon;?>
<div class="lxed_block_padding lxed_block_padding<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>">
<input type="hidden" class="new-edit-single" value="1"/>
	<h2 class="text-divider">
		<span class="lxed_add_section" data-section_id="<?php echo $section_id;?>"><i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
		</span>
	</h2>
	
	<div class="row lxed_delete_buttonblock mb-2">
		<div class="col-md-12" style="text-align:end;">
			<span class="lx_area_delete" data-section_id="<?php echo $section_id;?>" type="button"><i class="<?php echo $fontend_icon['trash'];?> lxed_font_20" data-section_id="<?php echo $section_id;?>" aria-hidden="true"></i></span>
		</div>
	</div>
	<!-- Questions -->
	<div class="lxed_main_single_question_div lxed_main_single_question_div<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>">
		<div class="lxed_main_single_question_div_inner lxed_main_single_question_div_inner<?php echo $section_id;?> lxed_main_single_question_div_inner<?php echo $section_id;?>1" data-section_id="<?php echo $section_id;?>">
			<div class="row">
				<!-- <div class="col-md-1"><h3>Q1</h3></div> -->
				<div contenteditable="true" name="lx_editor_questions<?php echo $section_id;?>1" data-section_id="<?php echo $section_id;?>" data-question_id ='1' id="lx_editor_questions<?php echo $section_id;?>1" class="lx_editor_questions lx_editor_questions<?php echo $section_id;?>1 lx_editor_questions<?php echo $section_id;?> lxed_inp_css col-md-11">
					<h3 class="lxed_single_chose_question">Enter the question here ...</h3>
				</div>
				<div class="col-md-1">
					<i class="<?php echo $square_icon['trash'];?> lxed_font_20 lxed_remove_single_ques" style="cursor:pointer;" data-section_id="<?php echo $section_id;?>" data-question_id="1" aria-hidden="true"></i>
				</div>
			</div>
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-11"><strong>Answers</strong></div>
			</div>
			<div class="row mt-4 lxed_single_choice_answeropt_div lxed_single_choice_answeropt_div1 lxed_single_choice_answeropt_div<?php echo $section_id;?>1 lxed_single_choice_answeropt_div<?php echo $section_id;?>11">
				<div class="col-md-1">
					<input class="form-check-input lxed_single_answer_radio lxed_single_answer_radio<?php echo $section_id;?>1 mt-2 ml-2" type="radio" data-question_id="1" data-section_id="<?php echo $section_id;?>" name="lxed_single_answer_radio<?php echo $section_id;?>1" id="lxed_single_answer_radio" value="1" checked>
				</div>
				<div data-loop_id="1" name="lx_editor_singleans_opt lx_editor_singleans_opt<?php echo $section_id;?>" data-question_id="1" data-section_id="<?php echo $section_id;?>" id="lx_editor_singleans_opt<?php echo $section_id;?>" class="lx_editor_singleans_opt lx_editor_singleans_opt<?php echo $section_id;?>1 lx_editor_singleans_opt<?php echo $section_id;?> lxed_inp_css col-md-10">
					<div class="lx_editor_singleans_opt_inner_div" data-question_id="1" data-section_id="<?php echo $section_id;?>" >
						<div contenteditable="true" class="lxed_single_chose_answer lxed_single_chose_answer<?php echo $section_id;?>11 lxed_single_chose_answer<?php echo $section_id;?>1 lx_input_bn" data-loop_id="1" data-question_id="1" data-section_id="<?php echo $section_id;?>" data-val="1" >Answer Option</div>
						<div contenteditable="true" class="mt-2 lxed_single_chose_feedback lxed_single_chose_feedback<?php echo $section_id;?>1 lx_input_bn" data-question_id="1" data-section_id="<?php echo $section_id;?>" data-loop_id="1" data-val="1">Feedback if this answer is selected</div>
					</div>
				</div>
				<div class="col-md-1">
					<i class="<?php echo $square_icon['trash'];?> lxed_font_20 lxed_remove_single_tab" style="cursor:pointer;" data-section_id="<?php echo $section_id;?>" data-question_id="1" data-loop_id="1" aria-hidden="true"></i>
				</div>
			</div>
			<div class="row mt-3 lxed_single_choice_answeropt_div lxed_single_choice_answeropt_div1 lxed_single_choice_answeropt_div<?php echo $section_id;?>1 lxed_single_choice_answeropt_div<?php echo $section_id;?>12">
				<div class="col-md-1">
					<input class="form-check-input lxed_single_answer_radio lxed_single_answer_radio<?php echo $section_id;?>1 mt-2 ml-2" type="radio" data-question_id="1" data-section_id="<?php echo $section_id;?>" name="lxed_single_answer_radio<?php echo $section_id;?>1" id="lxed_single_answer_radio" value="2">
				</div>
				<div data-loop_id="2" name="lx_editor_singleans_opt lx_editor_singleans_opt<?php echo $section_id;?>" data-question_id="1" data-section_id="<?php echo $section_id;?>" id="lx_editor_singleans_opt<?php echo $section_id;?>" class="lx_editor_singleans_opt lx_editor_singleans_opt<?php echo $section_id;?>1 lx_editor_singleans_opt<?php echo $section_id;?> lxed_inp_css col-md-10">
					<div class="lx_editor_singleans_opt_inner_div" data-question_id="1" data-section_id="<?php echo $section_id;?>" >
						<div contenteditable="true" class="lxed_single_chose_answer lxed_single_chose_answer<?php echo $section_id;?>12 lxed_single_chose_answer<?php echo $section_id;?>2 lx_input_bn" data-loop_id="2" data-question_id="1" data-section_id="<?php echo $section_id;?>" data-val="2">Answer Option</div>
						<div contenteditable="true" class="mt-2 lxed_single_chose_feedback lxed_single_chose_feedback<?php echo $section_id;?>2 lx_input_bn" data-question_id="1" data-section_id="<?php echo $section_id;?>" data-loop_id="2" data-val="2">Feedback if this answer is selected</div>
					</div>
				</div>
				<div class="col-md-1">
					<i class="<?php echo $square_icon['trash'];?> lxed_font_20 lxed_remove_single_tab" style="cursor:pointer;" data-section_id="<?php echo $section_id;?>" data-question_id="1" data-loop_id="2" aria-hidden="true"></i>
				</div>
			</div>
			<section class="disabled_single_choice_load<?php echo $section_id;?> disabled_single_choice_load<?php echo $section_id;?>1" data-section_id="<?php echo $section_id;?>"></section>
			
			<div class="row disabled_single_choice disabled_single_choice<?php echo $section_id;?>1 mt-2" data-question_id="1" data-section_id="<?php echo $section_id;?>">
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
		<div class="row mt-4">
			<div class="col-md-1"></div>
			<div class="col-md-11">
				<button class="lxed_button_question" data-section_id="<?php echo $section_id;?>"><i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i> ADD ANOTHER QUESTION</button>
			</div>
		</div>
	
	
	<!-- Questions End -->
</div>