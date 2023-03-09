<?php 
global $color_palette;
?>
<div class="row introduction_section">
	<div class="col-md-4">
		<div class="d-flex">
			<div>
				<h3 class="head_h3">Introduction</h3>
			</div>
			<div class="hide_introduction">
				<button type="button" class="hide_show dblock" data-content="intoduction_content"><i class="fa fa-eye"></i></button>
			</div>
		</div>
		<div class="break_line"></div> 
		<div class="intoduction_content">
			<div class="introduction_thumbnail">
				<label class="label">Thumbnail (Optional)
					<div>
						<img class="thumb_prev" id="thumb_prev" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/add.png';?>"/ data-uploaded="0">
					</div>
					<div style="display:none">
						<input type="file" class="upload-input lx_poll_intro_thumbnail" id="lx_poll_intro_thumbnail" name="lx_poll_intro_thumbnail" accept="image/jpg, image/jpeg, image/png"/>		
					</div>
				</label>
				<div class="form-group thumbnail_progress_main_div">
			        <div class="progress">
			            <div class="progress-bar" id="poll_intro_thumb_progress" role="progressbar" aria-valuenow="25" aria-valuemin="0"
			                aria-valuemax="100"></div>
			        </div>
			        <small id="emailHelp" class="form-text small-left poll_thumb_upload_status"></small>
			        <small id="emailHelp" class="form-text text-muted">Upload Thumbnail</small>
			    </div>
			</div>
			<div class="form-group pc_introduction_text mt-4">
				<strong>Introduction text</strong>
				<textarea type="text" class="form-control pc_intro_text" maxlength="1200" id="pc_intro_text" name="pc_intro_text" value="" placeholder=""></textarea>
				<div class="textarea_max_chars">
					<small>
						<a class="" href="javascript:void(0);" data-toggle="popover" title="" id="formatting-popover" data-placement="bottom" data-original-title="Tips for formatting"><span>Tips for formatting</span></a>
						<div id="formatting-popover-content" class="popover-content">
							<b>Bold</b> = *enter text here*<br>
							<i>Italic</i> = _enter text here_<br>
							Next line = ENTER<br>
							Next paragraph = {N} enter text here<br>
						</div>
					</small>
					<small class="small_right">
						<span id="pc_intro_text_chars">1200</span> characters remaining 
					</small>
				</div>
			</div>
			<div class="break_line"></div>
		</div>
		
	</div>
</div>
<div class="main_question_div main_question_div1" data-questionid="1">
	<div class="row question_heading question_heading1">
		<div class="col-md-12">
			<div class="d-flex">
				<div class="question_head"><h6 class="head_h6">QUESTION</h6></div>
				<div class="question_collapsed_expanded question_collapsed_expanded1">
					<a class="btn btn-collapse" id="btn_question_collapse1" data-toggle="collapse" data-target="#collapse-section" data-questionid="1"><i class="fas fa-minus"></i></a>
				</div>
			</div>
		</div>
	</div>
	<div class="question_answer_section1">
		<div class="row question_section1">
			<div class="col-md-4">	
				<div class="question_thumbnail1">
					<label class="label">Thumbnail (Optional)
						<div>
							<img class="thumb_prev" id="thumb_prev1" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/add.png';?>" data-uploaded="0"/>
						</div>
						<div class="que_thumb1" style="display:none;">	
							<input type="file" class="upload-input lx_poll_que_thumb" id="lx_poll_que_thumb1" name="lx_poll_que_thumb" data-questionid="1" accept="image/jpg, image/jpeg, image/png"/>	
						</div>
					</label>
					<div class="form-group thumbnail_progress_main_div">
				        <div class="progress">
				            <div class="progress-bar" id="poll_que_thumb_progress1" role="progressbar" aria-valuenow="25" aria-valuemin="0"
				                aria-valuemax="100"></div>
				        </div>
				        <small id="emailHelp" class="form-text small-left poll_thumb_upload_status"></small>
				        <small id="emailHelp" class="form-text text-muted">Upload Thumbnail</small>
				    </div>
					<div class="d-flex ai_center">
						<strong class="ml-3">Required</strong>
						<label class="lx_toggle">
							<input type="checkbox" checked class="ansrequiredtgl" id="ansrequiredtgl1" name="ansrequiredtgl" data-question_id="1" value="0">
							<span class="off" style="display:none;"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
							<span class="on"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
						</label>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="question1">
					<div class="form-group">
						<textarea type="text" class="form-control pc_question1 ta_quetion" maxlength="1200" id="pc_question1" name="pc_question1" value="" placeholder="Click here to add your question"></textarea>
						<div class="textarea_max_chars">
							<small class="question_error question1_error">Cannot be empty</small>
							<small class="small_right"><span id="pc_question1_chars">1200</span> characters remaining</small>
						</div>
					</div>
				</div>
				<!-- start -->
				<div class="question_type_div question_type_div1" data-question_id="1">
					<strong>Question Type</strong><div class="break_line"></div><br>
					<input type="hidden" class="question_type" id="question_type1" name="question_type" data-qid="1" value="0">
					<input type="hidden" class="question_type_meta" id="question_type_meta1" name="question_type_meta" data-qid="1" value="0">
					<div class="form-group single_answer single_answer1 ai_center" data-single_ans_id="1">
						 <label>
							<input type="radio" class="single_answer_selection single_answer_selection1" id="single_answer_selection1" name="question_type1" data-qid="1" value="0">&nbsp;&nbsp;Single answer (default)
						</label>
					</div>
					<div class="form-group multiple_ans multiple_ans1 ai_center" data-multiple_ans_id="1">
						<label>
							<input type="radio" class="make_multiple_ans" id="make_multiple_ans1" name="question_type1" data-qid="1" value="0">
							&nbsp;&nbsp;Allow <strong>Multiple answers</strong>
						</label>
						<label class="additional_note_multians additional_note_multians1" data-add_note_id="1" style="margin-left:20px;display:none;">
							<input type="checkbox" class="add_note_multians add_note_multians1" id="additional_note1" name="additional_note1" data-qid="1" value="0">&nbsp;&nbsp;Allow <strong>Addiitional notes</strong>
						</label>
					</div>
					<div class="form-group textentry_answer_div textentry_answer_div1 ai_center" data-textentry_answer_div_id="1">
						<label class="">
							<input type="radio" class="make_textentry_answer" id="make_textentry_answer1" name="question_type1" data-qid="1" value="0">
							&nbsp;&nbsp;Make it a <strong>Text Entry</strong> answer (2400 characters)
						</label>
					</div>
					<div class="form-group document_answer document_answer1 ai_center" data-document_ans_id="1">
						<label class="">
							<input type="radio" class="make_document_answer" id="make_document_answer1" name="question_type1" data-qid="1" value="0">&nbsp;&nbsp;Make it a <strong>Document Upload</strong> answer
						</label>
						<label class="additional_note_docans additional_note_docans1" data-add_note_id="1" style="margin-left:20px;display:none;">
							<input type="checkbox" class="add_note_docans add_note_docans1" id="additional_note1" name="additional_note1" data-qid="1" value="0">&nbsp;&nbsp;Allow <strong>Addiitional notes</strong>
						</label>
					</div>
				</div>
				<!-- end -->
				<?php
				/* <div class="form-group d-flex multiple_ans multiple_ans1 ai_center" data-multiple_ans_id="1">
					<label class="lx_toggle">
						<input type="checkbox" class="make_multiple_ans" id="make_multiple_ans1" name="make_multiple_ans" value="0">
						<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
						<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
					</label>
					<div class="multiple_ans_text">
						<strong>&nbsp;&nbsp;Multiple answers allowed</strong>
					</div>
				</div>
				<div class="form-group d-flex textentry_answer_div textentry_answer_div1 ai_center" data-textentry_answer_div_id="1">
					<label class="lx_toggle">
						<input type="checkbox" class="make_textentry_answer" id="make_textentry_answer1" name="make_textentry_answer" data-qid="1" value="0">
						<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
						<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
					</label>
					<div class="make_textentry_answer_text">
						<strong>&nbsp;&nbsp;Make it a Text Entry answer</strong>
					</div>
				</div> */
				?>
			</div>
		</div>
		<div class="answer_section1 mt-4">
			<div class="answer_heading"><h6 class="head_h6 ans_head">ANSWER/S</h6></div>
			<div class="row poll_div ans_main_div1 ans_main_div11" data-questionid="1" data-ansid="1" data-feedbackid="1" style="align-items: end;">
				<div class="col-md-4">
					<div class="form-group answer11">
						<strong>Answer (required)</strong>
						<textarea type="text" class="form-control pc_answer11 ta_answer" maxlength="150" id="pc_answer11" name="pc_answer11" data-qid="1"></textarea>
						<div class="textarea_max_chars">
							<small class="ans_error">Cannot be empty</small>
							<small class="small_right"><span id="pc_answer11_chars">150</span> characters remaining</small>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="optional_feedback optional_feedback111"> 
						<div class="d-flex ai_center">
							<label class="feedback_txt1">Optional feedback</label>
							<strong class="fbAnsToggle_txt ml-3">Use for all answers</strong>
							<label class="lx_toggle">
								<input type="checkbox" class="feedback_toggle" id="feedback_toggle1" name="feedback_toggle" data-question_id="1" value="0">
								<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
								<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
							</label>
						</div>
						<div class="form-group">
							<textarea type="text" class="form-control feedback111 ta_feedback" maxlength="250" id="feedback111" name="feedback111" value="" ></textarea>
							<div class="textarea_max_chars">
								<small class="small_right"><span id="feedback111_chars">250</span> characters remaining</small>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row poll_div ans_main_div1 ans_main_div12" data-questionid="1" data-ansid="2" data-feedbackid="2">
				<div class="col-md-4">
					<div class="form-group answer12">
						<strong>Answer (required)</strong>
						<textarea type="text" class="form-control pc_answer12 ta_answer" maxlength="150" id="pc_answer12" name="pc_answer12" data-qid="1"></textarea>
						<div class="textarea_max_chars">
							<small class="ans_error">Cannot be empty</small>
							<small class="small_right"><span id="pc_answer12_chars">150</span> characters remaining</small>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="optional_feedback optional_feedback122">
						<div class="form-group">
							<label class="feedback_txt2">Optional feedback</label>
							<textarea type="text" class="form-control feedback122 ta_feedback" maxlength="250" id="feedback122" name="feedback122" value="" ></textarea>
							<div class="textarea_max_chars">
								<small class="small_right"><span id="feedback122_chars">250</span> characters remaining</small>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="pc_new_answer_section1">
						<div class="pc_new_answer_option add_AnsButton" data-question_id="1">
							Add new answer option
						</div>
						<div class="textarea_max_chars">
							<small class="small_right"><span id="pc_answer_option"></span>Max of 6 answer options</small>
						</div>
					</div>
				</div>	
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="break_line"></div>
			</div>	
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-8">
		<div class="pc_new_question_section">
			<div class="pc_new_question_option add_QueButton">
				Add new Question
			</div>
		</div>
	</div>	
</div>
<div class="row mt-4">
	<div class="col-md-4 conclusion_section">
		<div class="d-flex">
			<div>
				<h6 class="head_h6">Conclusion</h6>
			</div>
		</div>
		<div class="break_line"></div>
		<div class="conclusion_content">
			<div class="conclusion_thumbnail">
				<label class="label">Thumbnail (Optional)
					<div>
						<img id="cncl_prev" class="card-img-top thumb_prev" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/add.png';?>" data-uploaded="0">
					</div>
					<div style="display:none;">		
						<input type="file" class="upload-input lx_poll_cncl_thumb" id="lx_poll_cncl_thumb" name="lx_poll_cncl_thumb" accept="image/jpg, image/jpeg, image/png"/>					
					</div>
				</label>
				<div class="form-group thumbnail_progress_main_div">
			        <div class="progress">
			            <div class="progress-bar" id="poll_que_thumb_progress1" role="progressbar" aria-valuenow="25" aria-valuemin="0"
			                aria-valuemax="100"></div>
			        </div>
			        <small id="emailHelp" class="form-text small-left poll_thumb_upload_status"></small>
			        <small id="emailHelp" class="form-text text-muted small_right">Upload Thumbnail</small>
			    </div>
			</div>
			<div class="form-group main_pc_conclusion_text mt-4">
				<strong>Conclusion text</strong>
				<textarea type="text" class="form-control pc_conclusion_text" maxlength="1200" id="pc_conclusion_text" name="pc_conclusion_text"></textarea>
				<div class="textarea_max_chars">
					<small class="small_right"><span id="conclusion_error" class="prompt_error_msg"></span>&nbsp;<span id="pc_conclusion_text_chars">300</span> characters remaining</small>
				</div>
			</div>	
			<div class="form-group mt-4">
				<strong>Submit prompt</strong>
				<textarea type="text" class="form-control submit_prompt_text" maxlength="300" id="submit_prompt_text" name="submit_prompt_text"></textarea>
				<div class="textarea_max_chars">
					<small class="small_right"></span>&nbsp;<span id="submit_prompt_text_chars">1200</span> characters remaining</small>
				</div>
			</div>	
			<div class="form-group d-flex ai_center mt-4">	
				<label class="lx_toggle">
					<input type="checkbox" class="include_back_btn" id="include_back_btn" name="include_back_btn" value="0">
					<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
					<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
				</label>
				<div class="multiple_ans_text">
					<strong>&nbsp;&nbsp;Include 'Back' button</strong>
				</div>
			</div>
			<div class="form-group back_nav_link mt-4" style="display:none;">
				<label>Which page should the back button go to?</label>
				<select class="form-control" id="sel_back_link">
					<?php
						$course_display=get_post_meta($course_id,'course_display',true);
						if(is_plugin_active(VWPLUGIN_PRO) && $course_display=='in_community')
						{
							$community_id=get_post_meta($course_id,'lx_attach_this_course',true);
							?><option value="<?php echo get_permalink($community_id);?>">Community page</option><?php
						}
					?>
					<option value="<?php echo get_permalink($course_id);?>">Course page</option>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-8 main_preview_test_div" style="height: fit-content;">
		<div class="preview_test_div">
			<input type="hidden" class="hidhyperlinkcolor" value="<?php echo $color_palette['hyperlinks']; ?>" />
			<div class="preview_title_div">
				<div class="preview_title"><label>PREVIEW / TEST</label></div>
				<div class="preview_bottom_line"></div>
			</div>
			<div class="d-flex screen_note_div">
				<div class="btn_refresh mb-2">
					<button class="btn_normal_state refresh_preview_pollcourse">Refresh</button>
				</div>
			</div>
			<div class="preview_slides">
				
			</div>
		</div>	
	</div>
</div>