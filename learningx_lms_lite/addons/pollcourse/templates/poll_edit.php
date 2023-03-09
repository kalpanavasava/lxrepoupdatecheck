<?php global $lx_plugin_urls,$wpdb,$square_icon,$color_palette; ?>
<div class="row introduction_section">
	<div class="col-md-4">
		<div class="d-flex">
			<div>
				<h3 class="head_h3">Introduction</h3>
			</div>
			<?php 
				$introduction=get_post_meta($poll_id,'introduction',true);
				$class='dblock';
				$icon='fa fa-eye';
				$display='block';
				if(empty($introduction)){
					$class='hide';
					$icon='fa fa-eye-slash';
					$display='none';
				}
			?>
			<div class="hide_introduction">
				<button type="button" class="hide_show <?php echo $class;?>" data-content="intoduction_content"><i class="<?php echo $icon;?>"></i></button>
			</div>
		</div>
		<div class="break_line"></div> 
		<div class="intoduction_content" style="display:<?php echo $display;?>">
			<div class="introduction_thumbnail">
				<label class="label">Thumbnail (Optional)
					<div>
						<?php 
							$image=$introduction['image'];
							$d_uploaded=1;
							if(empty($introduction) || $image=='broken'){
								$image=$lx_plugin_urls['lx_lms_lite'].'assets/img/add.png';
								$d_uploaded=0;
							}
						?>
						<img class="thumb_prev" id="thumb_prev" src="<?php echo $image;?>"/ data-uploaded="<?php echo $d_uploaded;?>">
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
			        <small id="emailHelp" class="form-text text-muted small_right">Upload Thumbnail</small>
			    </div>
			</div>
			<div class="form-group pc_introduction_text mt-4">
				<strong>Introduction text</strong>
				<textarea type="text" class="form-control pc_intro_text" maxlength="1200" id="pc_intro_text" name="pc_intro_text" placeholder=""><?php echo $introduction['text'];?></textarea>
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
<?php
$all_questions=$wpdb->get_results('select * from '.$wpdb->prefix.'vw_questions where post_id='.$poll_id);
/*echo "<pre>";print_r($all_questions);die;*/
foreach($all_questions as $key=>$question){
	$dqid=$key+1;
?>
<div class="main_question_div main_question_div<?php echo $dqid;?>" data-questionid="<?php echo $dqid;?>" data-original_qid="<?php echo $question->question_id;?>">
	<div class="row question_heading question_heading<?php echo $dqid;?>">
		<div class="col-md-12">
			<div class="d-flex">
				<div class="question_head"><h6 class="head_h6">QUESTION</h6></div>
				<div class="question_collapsed_expanded question_collapsed_expanded<?php echo $dqid;?>">
					<a class="btn btn-collapse" id="btn_question_collapse<?php echo $dqid;?>" data-toggle="collapse" data-target="#collapse-section" data-questionid="<?php echo $dqid;?>"><i class="fas fa-minus"></i></a>
				</div>
			</div>
		</div>
	</div>
	<div class="question_answer_section<?php echo $dqid;?>">
		<div class="row question_section<?php echo $dqid;?>">
			<div class="col-md-4">	
				<div class="question_thumbnail<?php echo $dqid;?>">
					<label class="label">Thumbnail (Optional)
						<div>
							<?php 
								$image=$question->thumbnail;
								$d_uploaded=1;
								if($image=='broken'){
									$image=$lx_plugin_urls['lx_lms_lite'].'assets/img/add.png';
									$d_uploaded=0;
								}
							?>
							<img class="thumb_prev" id="thumb_prev<?php echo $dqid;?>" src="<?php echo $image;?>" data-uploaded="<?php echo $d_uploaded;?>"/>
						</div>
						<div class="que_thumb1" style="display:none;">	
							<input type="file" class="upload-input lx_poll_que_thumb" id="lx_poll_que_thumb<?php echo $dqid;?>" name="lx_poll_que_thumb" data-questionid="<?php echo $dqid;?>" accept="image/jpg, image/jpeg, image/png"/>	
						</div>
					</label>
					<div class="form-group thumbnail_progress_main_div">
				        <div class="progress">
				            <div class="progress-bar" id="poll_que_thumb_progress<?php echo $dqid;?>" role="progressbar" aria-valuenow="25" aria-valuemin="0"
				                aria-valuemax="100"></div>
				        </div>
				        <small id="emailHelp" class="form-text small-left poll_thumb_upload_status"></small>
				        <small id="emailHelp" class="form-text text-muted small_right">Upload Thumbnail</small>
				    </div>
					<div class="d-flex ai_center">
						<strong class="ml-3">Required</strong>
						<label class="lx_toggle" style="margin: -20px 0px 0px 11px;">
							<?php 
							$qreqcheckbox = '';
							if($question->question_required == 1 || $question->question_required == ''){
								$qreqcheckbox = 'checked';
							}
							?>
							<input type="checkbox" <?php echo $qreqcheckbox; ?> class="ansrequiredtgl" id="ansrequiredtgl<?php echo $dqid;?>" name="ansrequiredtgl<?php echo $dqid;?>" data-question_id="<?php echo $dqid;?>" value="0">
							<span class="off" <?php if($question->question_required == 1 || $question->question_required == ''){ echo "style='display:none;'";} ?> ><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
							<span class="on" <?php if($question->question_required == 0){ echo "style='display:none;'";} ?>><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
						</label>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="question1">
					<div class="form-group">
						<textarea type="text" class="form-control pc_question<?php echo $dqid;?> ta_quetion" maxlength="1200" id="pc_question<?php echo $dqid;?>" placeholder="Click here to add your question"><?php echo $question->name;?></textarea>
						<div class="textarea_max_chars">
							<small class="question_error question<?php echo $dqid;?>_error">Cannot be empty</small>
							<small class="small_right"><span id="pc_question<?php echo $dqid;?>_chars">1200</span> characters remaining</small>
						</div>
					</div>
				</div>

				<!-- start -->
				<div class="question_type_div question_type_div1" data-question_id="1">
					<strong>Question Type</strong><div class="break_line"></div><br>
					
					<input type="hidden" class="question_type" id="question_type<?php echo $dqid;?>" name="question_type" data-qid="<?php echo $dqid;?>" value="<?php echo $question->question_type; ?>">
					<input type="hidden" class="question_type_meta" id="question_type_meta<?php echo $dqid;?>" name="question_type_meta" data-qid="<?php echo $dqid;?>" value="<?php echo $question->question_type_meta; ?>">
					
					<div class="form-group single_answer single_answer<?php echo $dqid;?> ai_center" data-single_ans_id="<?php echo $dqid;?>">
						<?php
						$single_ans='';
						$val=0;
						if( $question->question_type==0 ){
							$single_ans='checked';
							$val=1;
						}
						?>
						 <label>
							<input type="radio" class="single_answer_selection single_answer_selection<?php echo $dqid;?>" id="single_answer_selection<?php echo $dqid;?>" name="question_type<?php echo $dqid;?>" data-qid="<?php echo $dqid;?>" value="<?php echo $val; ?>" <?php echo $single_ans; ?> >&nbsp;&nbsp;Single answer (default)
						</label>
					</div>
					<div class="form-group multiple_ans multiple_ans<?php echo $dqid;?> ai_center" data-multiple_ans_id="<?php echo $dqid;?>">
						<?php
						$val=0;
						$multiple_ans='';
						if( $question->question_type==1 ){
							$multiple_ans='checked';
							$val=1;
						}
						$add_note_multians='';
						$style='margin-left:20px;display:none;';
						if( $question->question_type==1 && $question->question_type_meta==1 ){
							$add_note_multians='checked';
							$val=1;
							$style='margin-left:20px;display:block;';
						}
						if( $question->question_type==1 ){
							$style='margin-left:20px;display:block;';
						}
						?>
						<label>
							<input type="radio" class="make_multiple_ans" id="make_multiple_ans<?php echo $dqid;?>" name="question_type<?php echo $dqid;?>" data-qid="<?php echo $dqid;?>" value="<?php echo $val; ?>" <?php echo $multiple_ans; ?>>
							&nbsp;&nbsp;Allow <strong>Multiple answers</strong>
						</label>
						<label class="additional_note_multians additional_note_multians<?php echo $dqid;?>" data-add_note_id="<?php echo $dqid;?>" style="<?php echo $style;?>">
							<input type="checkbox" class="add_note_multians add_note_multians<?php echo $dqid;?>" id="additional_note<?php echo $dqid;?>" name="additional_note<?php echo $dqid;?>" data-qid="<?php echo $dqid;?>" value="<?php echo $val; ?>" <?php echo $add_note_multians; ?>>&nbsp;&nbsp;Allow <strong>Addiitional notes</strong>
						</label>
					</div>
					<div class="form-group textentry_answer_div textentry_answer_div<?php echo $dqid;?> ai_center" data-textentry_answer_div_id="<?php echo $dqid;?>">
						<?php
						$val=0;$textentry_ans='';	
						if( $question->question_type==2 ){
							$textentry_ans='checked';
							$val=1;
						}
						?>
						<label class="">
							<input type="radio" class="make_textentry_answer" id="make_textentry_answer<?php echo $dqid;?>" name="question_type<?php echo $dqid;?>" data-qid="<?php echo $dqid;?>" value="<?php echo $val; ?>" <?php echo $textentry_ans; ?>>
							&nbsp;&nbsp;Make it a <strong>Text Entry</strong> answer (2400 characters)
						</label>
					</div>
					<div class="form-group document_answer document_answer<?php echo $dqid;?> ai_center" data-document_ans_id="<?php echo $dqid;?>">
						<?php
						$val=0;
						$document_ans='';
						if( $question->question_type==3 ){
							$document_ans='checked';
							$val=1;
						}
						$add_note_docans='';
						$style='margin-left:20px;display:none;';
						if( $question->question_type==3 && $question->question_type_meta==1 ){
							$add_note_docans='checked';
							$val=1;
							$style='margin-left:20px;display:block;';
						}
						?>
						<label class="">
							<input type="radio" class="make_document_answer" id="make_document_answer<?php echo $dqid;?>" name="question_type<?php echo $dqid;?>" data-qid="<?php echo $dqid;?>" value="<?php echo $val; ?>" <?php echo $document_ans; ?>>&nbsp;&nbsp;Make it a <strong>Document Upload</strong> answer
						</label>
						<label class="additional_note_docans additional_note_docans<?php echo $dqid;?>" data-add_note_id="<?php echo $dqid;?>" style="<?php echo $style;?>">
							<input type="checkbox" class="add_note_docans add_note_docans<?php echo $dqid;?>" id="additional_note<?php echo $dqid;?>" name="additional_note<?php echo $dqid;?>" data-qid="<?php echo $dqid;?>" value="<?php echo $val; ?>" <?php echo $add_note_docans; ?>>&nbsp;&nbsp;Allow <strong>Addiitional notes</strong>
						</label>
					</div>
				</div>
				
				<!-- end -->
				
				<?php
				/* <div class="form-group d-flex multiple_ans multiple_ans<?php echo $dqid;?> ai_center" data-multiple_ans_id="<?php echo $dqid;?>">
					<?php
						$checked='';
						$val=0;
						if($question->allow_multiple==1){
							$checked='checked';
							$val=1;
						}
					?>
					<label class="lx_toggle">
						<input type="checkbox" class="make_multiple_ans" id="make_multiple_ans<?php echo $dqid;?>" name="make_multiple_ans" value="<?php echo $val;?>" <?php echo $checked;?>>
						<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
						<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
					</label>
					<div class="multiple_ans_text">
						<strong>&nbsp;&nbsp;Multiple answers allowed</strong>
					</div>
				</div>
				<div class="form-group d-flex textentry_answer_div textentry_answer_div<?php echo $dqid;?> ai_center" data-textentry_answer_div_id="<?php echo $dqid;?>">
					<?php
						$checked='';
						$val=0;
						if($question->text_entry_answer==1){ 
							$checked='checked';
							$val=1;
						}
					?>
					<label class="lx_toggle">
						<input type="checkbox" class="make_textentry_answer" id="make_textentry_answer<?php echo $dqid;?>" name="make_textentry_answer" data-qid="<?php echo $dqid;?>" value="<?php echo $val;?>" <?php echo $checked;?>>
						<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
						<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
					</label>
					<div class="make_textentry_answer_text">
						<strong>&nbsp;&nbsp;Make it a Text Entry answer</strong>
					</div>
				</div> */
				?>
				
			</div>
			<?php if($dqid>1){ ?>
			<div class="col-md-2 remove_Question_btn">
				<button type="button" class="btn btn-danger question_delete" data-quesid="<?php echo $dqid;?>">
					<i class="<?php echo $square_icon['trash'];?>" aria-hidden="true"></i>
				</button>
			</div>
			<?php } ?>
		</div>
		<?php 
			/* $display="block";
			/* if($question->text_entry_answer==1){ 
				$display="none";
			} */
			$display="block";
			if( $question->question_type==2 || $question->question_type==3 ){ 
				$display="none";
			}
		?>
		<div class="answer_section<?php echo $dqid;?> mt-4" style="display: <?php echo $display;?>;">
			<div class="answer_heading"><h6 class="head_h6 ans_head">ANSWER/S</h6></div>
			<?php 
				if( $question->question_type==2 || $question->question_type==3 ){ ?>
					<div class="row poll_div ans_main_div<?php echo $dqid;?> ans_main_div<?php echo $dqid;?>1" data-questionid="<?php echo $dqid;?>" data-ansid="1" data-feedbackid="1" data-original_qid="<?php echo $question->question_id;?>" style="align-items: end;">
						<div class="col-md-4">
							<div class="form-group answer<?php echo $dqid;?>1">
								<strong>Answer (required)</strong>
								<textarea type="text" class="form-control pc_answer<?php echo $dqid;?>1 ta_answer" maxlength="150" id="pc_answer<?php echo $dqid;?>1" data-qid="<?php echo $dqid;?>"></textarea>
								<div class="textarea_max_chars">
									<small class="ans_error">Cannot be empty</small>
									<small class="small_right"><span id="pc_answer<?php echo $dqid;?>1_chars">150</span> characters remaining</small>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="optional_feedback optional_feedback<?php echo $dqid;?>11">
								<div class="d-flex ai_center">
									<label class="feedback_txt1">Optional feedback</label>
									<strong class="fbAnsToggle_txt ml-3">Use for all answers</strong>
									<label class="lx_toggle">
										<input type="checkbox" class="feedback_toggle" id="feedback_toggle1" name="feedback_toggle" data-question_id="<?php echo $dqid;?>" value="0">
										<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
										<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
									</label>
								</div>
								<div class="form-group">
									<textarea type="text" class="form-control feedback<?php echo $dqid;?>11 ta_feedback" maxlength="250" id="feedback<?php echo $dqid;?>11"></textarea>
									<div class="textarea_max_chars">
										<small class="small_right"><span id="feedback<?php echo $dqid;?>11_chars">250</span> characters remaining</small>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row poll_div ans_main_div<?php echo $dqid;?> ans_main_div<?php echo $dqid;?>2" data-questionid="<?php echo $dqid;?>" data-ansid="2" data-feedbackid="2" data-original_qid="<?php echo $question->question_id;?>">
						<div class="col-md-4">
							<div class="form-group answer<?php echo $dqid;?>2">
								<strong>Answer (required)</strong>
								<textarea type="text" class="form-control pc_answer<?php echo $dqid;?>2 ta_answer" maxlength="150" id="pc_answer<?php echo $dqid;?>2" data-qid="<?php echo $dqid;?>"></textarea>
								<div class="textarea_max_chars">
									<small class="ans_error">Cannot be empty</small>
									<small class="small_right"><span id="pc_answer<?php echo $dqid;?>_chars">150</span> characters remaining</small>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="optional_feedback optional_feedback<?php echo $dqid;?>22">
								<div class="form-group">
									<label class="feedback_txt2">Optional feedback</label>
									<textarea type="text" class="form-control feedback<?php echo $dqid;?>22 ta_feedback" maxlength="250" id="feedback<?php echo $dqid;?>22"></textarea>
									<div class="textarea_max_chars">
										<small class="small_right"><span id="feedback<?php echo $dqid;?>22_chars">250</span> characters remaining</small>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php }else{
					$all_answers=$wpdb->get_results('select * from '.$wpdb->prefix.'vw_answers where question_id='.$question->question_id);
					foreach($all_answers as $key=>$answer){
						$dAnsid=$key+1;
						$dfbid=$dAnsid;
						$style='';
						if($dAnsid==1){
							$style="style='align-items:end;'";
						}
						?>
						<div class="row poll_div ans_main_div<?php echo $dqid;?> ans_main_div<?php echo $dqid.$dAnsid;?>" data-questionid="<?php echo $dqid;?>" data-ansid="<?php echo $dAnsid;?>" data-feedbackid="<?php echo $dfbid;?>" data-original_qid="<?php echo $question->question_id;?>" data-original_aid="<?php echo $answer->answer_id;?>" <?php echo $style?>>
							<div class="col-md-4">
								<div class="form-group answer<?php echo $dqid.$dAnsid;?>">
									<?php if($dAnsid<3){ ?>
										<strong>Answer (required)</strong>
									<?php }else{ ?>
										<label class="new_answer_txt">Answer (Optional)</label>
									<?php } ?>
									<textarea type="text" class="form-control pc_answer<?php echo $dqid.$dAnsid;?> ta_answer" maxlength="150" id="pc_answer<?php echo $dqid.$dAnsid;?>" data-qid="<?php echo $dqid;?>"><?php echo $answer->answer;?></textarea>
									<div class="textarea_max_chars">
										<small class="ans_error">Cannot be empty</small>
										<small class="small_right"><span id="pc_answer<?php echo $dqid.$dAnsid;?>_chars">150</span> characters remaining</small>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="optional_feedback optional_feedback<?php echo $dqid.$dAnsid.$dfbid;?>">
									<?php 
										if($dAnsid<3){
											$class='feedback_txt'.$dfbid; 
										}else{ 
											$class='new_feedback_txt';
										} 
										if($dAnsid==1){
									?>
									<div class="d-flex ai_center">
										<label class="<?php echo $class;?>">Optional feedback</label>
										<strong class="fbAnsToggle_txt ml-3">Use for all answers</strong>
										<?php
											$checked='';
											$disabled='';
											$val=0;
											if($question->feedback_for_all==1){
												$checked='checked';
												$disabled='disabled';
												$val=1;
											}
										?>
										<label class="lx_toggle">
											<input type="checkbox" class="feedback_toggle" id="feedback_toggle<?php echo $dqid;?>" data-question_id="<?php echo $dqid;?>" value="<?php echo $val;?>" <?php echo $checked;?>>
											<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
											<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
										</label>
										
									</div>
									<?php } ?>
									<div class="form-group">
										<?php if($dAnsid>1){
											?><label class="<?php echo $class;?>">Optional feedback</label><?php
										}?>
										<textarea type="text" class="form-control feedback<?php echo $dqid.$dAnsid.$dfbid;?> ta_feedback" maxlength="250" id="feedback<?php echo $dqid.$dAnsid.$dfbid;?>" <?php if($dfbid!=1){echo $disabled;}?>><?php echo $answer->feedback;?></textarea>
										<div class="textarea_max_chars">
											<small class="small_right"><span id="feedback<?php echo $dqid.$dAnsid.$dfbid;?>_chars">250</span> characters remaining</small>
										</div>
									</div>
								</div>
							</div>
							<?php if($dAnsid>2){
								?>
									<div class="col-md-2 remove_Answer_btn">
										<button type="button" class="btn btn-danger ans_delete" data-ansid="<?php echo $dAnsid;?>" data-quesid="<?php echo $dqid;?>">
											<i class="<?php echo $square_icon['trash'];?>" aria-hidden="true"></i>
										</button>
									</div>
							<?php } ?>
						</div>
						<?php
					}
				}
			?>
			<div class="row">
				<div class="col-md-8">
					<div class="pc_new_answer_section<?php echo $dqid;?>">
						<div class="pc_new_answer_option add_AnsButton" data-question_id="<?php echo $dqid;?>">
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
<?php } ?>
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
						<?php 
							$conclusion=get_post_meta($poll_id,'conclusion',true);
							$image=$conclusion['image'];
							$d_uploaded=1;
							if($image=='broken'){
								$image=$lx_plugin_urls['lx_lms_lite'].'assets/img/add.png';
								$d_uploaded=0;
							}
						?>
						<img id="cncl_prev" class="card-img-top thumb_prev" src="<?php echo $image;?>" data-uploaded="<?php echo $d_uploaded;?>">
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
			        <small id="emailHelp" class="form-text text-muted  small_right">Upload Thumbnail</small>
			    </div>
			</div>
			<div class="form-group main_pc_conclusion_text mt-4">
				<strong>Conclusion text</strong>
				<textarea type="text" class="form-control pc_conclusion_text" maxlength="1200" id="pc_conclusion_text"><?php echo $conclusion['text'];?></textarea>
				<div class="textarea_max_chars">
					<small class="small_right"><span id="conclusion_error" class="prompt_error_msg"></span>&nbsp;<span id="pc_conclusion_text_chars">1200</span> characters remaining</small>
				</div>
			</div>
			<div class="form-group mt-4">
				<strong>Submit prompt</strong>
				<textarea type="text" class="form-control submit_prompt_text" maxlength="300" id="submit_prompt_text" name="submit_prompt_text"><?php echo $submit_prompt;?></textarea>
				<div class="textarea_max_chars">
					<small class="small_right"></span>&nbsp;<span id="submit_prompt_text_chars">300</span> characters remaining</small>
				</div>
			</div>
			<div class="form-group d-flex ai_center mt-4">	
				<?php
					$checked='';
					$val='0';
					$display='none';
					if($include_back_btn){
						$checked="checked";
						$val='1';
						$display='block';
					}
				?>
				<label class="lx_toggle">
					<input type="checkbox" class="include_back_btn" id="include_back_btn" name="include_back_btn" value="<?php echo $val;?>" <?php echo $checked;?>>
					<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
					<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
				</label>
				<div class="multiple_ans_text">
					<strong>&nbsp;&nbsp;Include 'Back' button</strong>
				</div>
			</div>
			<div class="form-group back_nav_link mt-4" style="display:<?php echo $display;?>;">
				<label>Which page should the back button go to?</label>
				<select class="form-control" id="sel_back_link">
					<?php
						$selected='';
						$course_display=get_post_meta($course_id,'course_display',true);
						if(is_plugin_active(VWPLUGIN_PRO) && $course_display=='in_community')
						{
							$community_id=get_post_meta($course_id,'lx_attach_this_course',true);
							$back1=get_permalink($community_id);
							if($back1==$back_nav_link){
								$selected='selected';
							}
							?><option value="<?php echo $back1;?>" <?php echo $selected;?>>Community page</option><?php
						}
						$back2=get_permalink($course_id);
						if($back2==$back_nav_link){
								$selected='selected';
							}
					?>
					<option value="<?php echo $back2;?>" <?php echo $selected;?>>Course page</option>
				</select>
			</div>
		</div>
		
	</div>
	<div class="col-md-8 main_preview_test_div"  style="height: fit-content;">
		<div class="preview_test_div">
			<input type="hidden" class="hidhyperlinkcolor" value="<?php echo $color_palette['hyperlinks']; ?>" />
			<div class="preview_title_div">
				<div class="preview_title"><label>PREVIEW / TEST</label></div>
				<div class="preview_bottom_line"></div>
			</div>
			<div class="d-flex screen_note_div">
				<div class="btn_refresh mb-2">
					<button class="btn_normal_state refresh_preview_pollcourse" >Refresh</button>
				</div>
			</div>
			<div class="preview_slides">
				
			</div>
		</div>	
	</div>
</div>