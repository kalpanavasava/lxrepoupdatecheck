<?php
/**
	@Author: Voidek Webolution
	@Description: Poll Courses Page For Poll Content
**/
global $color_palette,$square_icon;
$user_id=get_current_user_id();

/* start */
$poll_id = get_the_ID();
$course_id = get_post_meta($poll_id,'course_id',true);
freecourseenrolled( 0 , $post_id, $user_id );
?>
<input type="hidden" class="poll_id" value="<?php echo $poll_id; ?>">
<input type="hidden" class="course_id" value="<?php echo $course_id; ?>">

<div class="container mt-4" id="pollcontent_main_div">
	<form method="post" class="pollcontent_form">
		<input type="hidden" class="hidhyperlinkcolor" value="<?php echo $color_palette['hyperlinks']; ?>" />
		<div class="card pollcontent_card">
		  <div class="card-body">
			<div class="main_pollcontent_div">
				<div class="mt-2 standarized_tab">
					<div class="standarized_tab_inner_top pollcontent_heading_div">
						<div class="top_div_head">
							<h3 class="head_h3"><?php echo get_post($post_id)->post_title;?></h3>
						</div>
					</div>
				</div>
				<div class="pollcontent_div">
					<?php 
						$introduction = get_post_meta($post_id,'introduction',true);
						if(!empty($introduction)){
						?>
							<div class="introduction_div">
								<div class="introduction_heading">
									<h3 class="head_h3">Introduction</h3>
								</div>
								<div class="break_line_poll_ui"></div>
								<div class="introduction_body">
									<?php 
										$display="block";
										if($introduction['image']=='broken'){
											$display="none";
										}
									?>
									<div class="introduction_thumbnail" style="display: <?php echo $display;?>;"><img class="pollcontent_thumbnail" src="<?php echo $introduction['image']; ?>"/></div> 
									<div class="introduction_text"><p> <?php echo FnFormatMytext($introduction['text']); ?> </p></div>
								</div>
								<div class="btn_next_intro_main mt-2 mb-2">
									<div class="break_line_poll_ui"></div>
									<div class="btn_next_intro"> 
										<button type="button" class="btn_normal_state btn_next_pollcontent" data-current="introduction_div" data-next="question_div1" data-main="<?php echo $data_main;?>">Next</button>
									</div>
								</div>
							</div>	
						<?php
						}
						global $wpdb;
						$result = $wpdb->get_results(" SELECT * FROM ".$wpdb->prefix."vw_questions WHERE post_id=".$post_id);
						$tot_que = count($result);
						
						$n=1; 
						foreach( $result as $question ){ 
							if( $n == 1 && !empty($introduction)){
								$prev="introduction_div";
							}else{
								$cnt = $n-1;
								$prev = "question_div".$cnt;
							}
							if( $n == $tot_que ){
								$next="conclusion_div";
							}else{
								$cnt = $n+1;
								$next = "question_div".$cnt;
							}
							$display='none';
							if($n==1 && empty($introduction)){
								$display='block';
							}
						?>
							<div class="question_div_main question_div<?php echo $n;?>" data-questionid="<?php echo $n; ?>" data-original_qid="<?php echo $question->question_id;?>" style="display: <?php echo $display;?>;">
								<?php 
									$multipleAns=0; $txtEntryAns=0; $documentAns=0;
									if( $question->question_type == 1 ){
										$multipleAns = 1;
									}
									if( $question->question_type == 2 ){
										$txtEntryAns = 2;
									}
									
									if( $question->question_type == 3 ){
										$documentAns = 3;
									}
								?>
								<input type="hidden" class="question_id" value="<?php echo $question->question_id; ?>">
								<input type="hidden" id="question_type<?php echo $n;?>" value="<?php echo $question->question_type;?>">
								<input type="hidden" id="doc_answer<?php echo $n; ?>" value="<?php echo $documentAns; ?>">
								<input type="hidden" id="allow_multiple<?php echo $n; ?>" value="<?php echo $multipleAns; ?>"> 
								<?php /* $txtEntryAns = $question->text_entry_answer; */ ?>
								<input type="hidden" id="text_entry_answer<?php echo $n; ?>" value="<?php echo $txtEntryAns; ?>"> 
								<input type="hidden" id="frontquestionrequired<?php echo $n; ?>" value="<?php echo $question->question_required; ?>">
								
								<div class="">
									<div><?php echo FnFormatMytext($question->name);?></div>
									<?php 
										/* $ans_select_val = $question->allow_multiple; */
										$ans_select_val = $question->question_type;
										if( $ans_select_val == 1 ){ ?>
											<span class="multiple_answer_text">Select all that apply</span>
									<?php	
										}
									?>
								</div>
								<div class="break_line_poll_ui"></div>
								<div class="question_body">
									<?php
										$thumbnail=$question->thumbnail;
										$display="block";
										if( $thumbnail == 'broken' ){ 
											$display="none";
										}
									?>
									<div class="question_thumbnail" style="display:<?php echo $display;?>;"><img class="pollcontent_thumbnail" src="<?php echo $thumbnail; ?>"/></div>
									<div class="answer_div_main">
										<?php
											$ansRes = $wpdb->get_results(" SELECT * FROM ".$wpdb->prefix."vw_answers WHERE question_id=".$question->question_id );
											
											if( $question->question_type == 0 || $question->question_type == 1 ){
												foreach( $ansRes as $key=>$value ){ 
													$aid=$key+1;
													$u_ans=$wpdb->get_results('select answer_id from '.$wpdb->prefix.'vw_pollcourse_userdata where question_id="'.$question->question_id.'" and user_id='.$user_id);
													$ur_answer_id=explode(',',$u_ans[0]->answer_id);
													$selected_ans='';
													$display='none';
													if(in_array($value->answer_id,$ur_answer_id)){
														$selected_ans='selected_answer';
														$display='block';
													}
													?>
													<input type="hidden" id="answer_id" name="answer_id" value="<?php echo $value->answer_id; ?>">
													<div class="answer_div_content answer_div<?php echo $n; ?> answer_div<?php echo $n.$aid; ?> <?php echo $selected_ans;?>" data-aid="<?php echo $aid;?>" data-questionid="<?php echo $n; ?>" data-answerid="<?php echo $value->answer_id; ?>">
														<?php echo FnFormatMytext($value->answer) ;?>
													</div>
													<?php if(!empty($ansRes[$key]->feedback) || ( $fbForAns && !empty($ansRes[0]->feedback))){ ?>
													<div class="feedback_div_main feedback_div<?php echo $n.$aid;?>" style="display: <?php echo $display;?>;">
														<?php 
															$fbForAns = $question->feedback_for_all;
															if( $fbForAns == 0 ){
																echo FnFormatMytext($value->feedback);
															}else{
																echo FnFormatMytext($ansRes[0]->feedback);
															}
														?>
													</div> 
													<?php
													} 
												} 
												if( $question->question_type_meta == 1 ){
													$addNoteStyle='display:none;';
													if( !empty($selected_ans) ){
														$addNoteStyle='display:block;';
														$add_note_multians=$wpdb->get_results('select additional_note from '.$wpdb->prefix.'vw_pollcourse_userdata where question_id="'.$question->question_id.'" and user_id='.$user_id); 
														$multians_note = $add_note_multians[0]->additional_note;
													}
												?>
													<br>
													<input type="hidden" id="addNote_MultiAns<?php echo $n;?>" value="<?php echo $question->question_type_meta;?>">
													<div id="addNoteMultiAnsDiv<?php echo $n;?>" class="addNoteMultiAnsDiv addNoteMultiAnsDiv<?php echo $n;?>" style="<?php echo $addNoteStyle;?>">
														<strong>Additional notes</strong> (optional)
														<textarea id="addNoteMultiAns<?php echo $n;?>" class="addNoteMultiAns addNoteMultiAns<?php echo $n;?>" maxlength="300" style="background-color: <?php echo $color_palette['white'];?>;"><?php echo $multians_note;?></textarea>
														<div class="textarea_max_chars">
															<small class="small_right"></span>&nbsp;<span id="addNoteMultiAns<?php echo $n;?>_chars">300</span> characters remaining</small>
														</div>
													</div>
												<?php
												}
											}
											
											if( $question->question_type == 2 ){ ?>
												<div class="text_answer_div_content text_answer_div<?php echo $n; ?>" data-questionid="<?php echo $n; ?>" style="margin-top:1em;color:<?php echo $color_palette['mid_grey'];?>">
													<?php 
														$u_ans=$wpdb->get_results('select text_answer from '.$wpdb->prefix.'vw_pollcourse_userdata where question_id="'.$question->question_id.'" and user_id='.$user_id);
													?>
													<i>Add Your Answer</i>
													<textarea id="answer_text<?php echo $n;?>" type="text" class="text_answer addandTextarea" name="text_answer" maxlength="2400" rows="5"><?php echo $u_ans[0]->text_answer;?></textarea>
													<div class="textarea_max_chars">
														<small class="small_right"></span>&nbsp;<span id="answer_text<?php echo $n;?>_chars">2400</span> characters remaining</small>
													</div>
												</div>
												<?php	
											}
											
											if( $question->question_type == 3 ){
											?>
												<input type="hidden" id="document_ans<?php echo $n;?>" value="<?php echo $question->question_type;?>">
												<input type="hidden" class="attach_document_s3path attach_document_s3path<?php echo $n;?>" value="">
												<input type="hidden" class="attach_document_name attach_document_name<?php echo $n;?>" value="">
												<div class="d-flex">
													<?php 
														$doc_url=$wpdb->get_results('select upload_url from '.$wpdb->prefix.'vw_pollcourse_userdata where question_id="'.$question->question_id.'" and user_id='.$user_id);
													?>
													<div>
														<input type="file" id="attachDocumentAnswer<?php echo $n;?>" class="attachDocumentAnswer attachDocumentAnswer<?php echo $n;?>" accept=".doc,.docx,.pdf" data-original_qid="<?php echo $question->question_id;?>" data-qid="<?php echo $n;?>" hidden>
														<label for="attachDocumentAnswer<?php echo $n;?>">
															<div class="btn_normal_state">Attach file</div>
														</label>
														<?php
														$doc_element_style='';
														$upload_url = urldecode(basename($doc_url[0]->upload_url));
														if( !empty( $upload_url ) ){
															$doc_element_style='display:block;'; ?>
															<span class="attachDocName attachDocName<?php echo $n;?> docuploadname<?php echo $n;?>"><?php echo $upload_url; ?></span>
														<?php 
														}else{ 
															$doc_element_style='display:none;';
														?>
															<span class="attachDocName attachDocName<?php echo $n;?> docdefaultname<?php echo $n;?>">No file chosen</span>
														<?php } ?>
													</div>
													<div style="margin-left:auto;">
														<button href="javascript:void(0)" type="button" id="deleteDocumentAnswer<?php echo $n;?>" class="btn_danger_state deleteDocumentAnswer deleteDocumentAnswer<?php echo $n;?>" data-quesid="<?php echo $n;?>" data-docname="<?php echo $upload_url; ?>" data-original_qid="<?php echo $question->question_id;?>" style="<?php echo $doc_element_style;?>">
														<i class="<?php echo $square_icon['trash'];?>" aria-hidden="true"></i>
														</button>
													</div>
													<br>
												</div>
												<em>Accepted formats: Document (DOC,DOCX,PDF), Size(Max 2MB)</em><br>
												<?php
												if( $question->question_type_meta == 1 ){
													$add_note_doc=$wpdb->get_results('select additional_note from '.$wpdb->prefix.'vw_pollcourse_userdata where question_id="'.$question->question_id.'" and user_id='.$user_id);
													
													$doc_note='';
													if( !empty($add_note_doc) ){
														$doc_note= $add_note_doc[0]->additional_note;
													} 
												?>
													<br>
													<div id="addNoteDocAnsDiv<?php echo $n;?>" class="addNoteDocAnsDiv addNoteDocAnsDiv<?php echo $n;?>" style="<?php echo $doc_element_style;?>">
														<strong>Additional notes</strong> (optional)
														<textarea id="addNoteDocAns<?php echo $n;?>" class="addNoteDocAns addNoteDocAns<?php echo $n;?>" maxlength="300" style="background-color: <?php echo $color_palette['white'];?>;"><?php echo $doc_note;?></textarea>
														<div class="textarea_max_chars">
															<small class="small_right"></span>&nbsp;<span id="addNoteDocAns<?php echo $n;?>_chars">300</span> characters remaining</small>
														</div>
													</div>
												<?php
												}
											}
										?>
									</div>
								</div>
								<div class="mt-2 mb-2">
									<div class="break_line_poll_ui"></div>
									<?php 
									if( $n == 1 && empty($introduction)){}else{
									?>
									<button type="button" class="btn_normal_state btn_previous_pollcontent" data-current="question_div<?php echo $n;?>" data-prev="<?php echo $prev;?>"  data-main="<?php echo $data_main;?>">Prev</button>
									<?php } ?>
									<div class="btn_next_question"> 
										<button type="button" class="btn_normal_state btn_next_pollcontent btn_save_questions" data-current="question_div<?php echo $n;?>" data-questionid="<?php echo $n;?>" data-next="<?php echo $next;?>" data-poll_id="<?php echo $post_id;?>" data-main="<?php echo $data_main;?>">Next</button>
									</div>
								</div>
							</div>
					<?php	
							$n++;
						}

					?>	
					<div class="conclusion_div" style="display:none;">
						<?php
							$conclusion = get_post_meta($post_id,'conclusion',true);
							if($conclusion['image']!='broken' || $conclusion['text']!=''){
						?>
						<div class="conclusion_heading">
							<h3 class="head_h3">Conclusion</h3>
						</div>
						<div class="break_line_poll_ui"></div>
						<div class="conclusion_body">
							<?php 
								$display="block";
								if($conclusion['image']=='broken'){
									$display="none";
								}
							?>
							<div class="conclusion_thumbnail" style="display:<?php echo $display;?>;"><img class="pollcontent_thumbnail" src="<?php echo $conclusion['image']; ?>"/></div> 
							<div class="conclusion_text"><p> <?php echo FnFormatMytext($conclusion['text']); ?> </p></div>
						</div>
						<div class="break_line_poll_ui"></div>
						<?php } ?>
						<div class="btns_conclusion_main mt-2 mb-2">
							<button type="button" class="btn_normal_state btn_previous_pollcontent" data-current="conclusion_div" data-prev="question_div<?php echo $tot_que;?>" data-main="<?php echo $data_main;?>">Prev</button>
							<div class="btns_conclusion"> 
								<?php $restart_poll = get_post_meta($post_id,'restart_poll',true); 
									if( $restart_poll == 1 ){ ?>
										<button type="button" class="btn_dark_state btn_restart_pollcontent" data-poll_id="<?php echo $post_id;?>" data-main="<?php echo $data_main;?>">Start again</button> 
								<?php } ?>
								<button type="button" class="btn_normal_state btn_submit_pollcontent" data-poll_id="<?php echo $post_id;?>"  data-main="<?php echo $data_main;?>">Submit</button>
							</div>
						</div>
						<div class="form-group d-flex ai_center" style="float:right;">
							<label class="form-check-label mr-2"><i>Send me a copy of my answers</i></label>
							<input type="checkbox" class="form-check" id="send_copy_to_responder" value="0">
						</div>
					</div>
					<div class="submit_prompt" style="text-align:center;display: none;">
						<?php 
							$prompt_text=get_post_meta($post_id,'submit_prompt',true);
							$include_back_btn=get_post_meta($post_id,'include_back_button',true);
						?>
						<div class="prompt_text"><?php echo FnFormatMytext($prompt_text);?></div>
						<?php
							if($include_back_btn){
								$back_link=get_post_meta($post_id,'back_nav_link',true);
								?>
								<div class="mt-4"><a href="<?php echo $back_link;?>" class="btn_normal_state">Back</a></div>
								<?php
							}
						?>
					</div>
					<input type="hidden" id="current_user_id" value="<?php echo get_current_user_id(); ?>">
					<input type="hidden" id="current_post_id" value="<?php echo $post_id; ?>">
				</div>
			</div>
		  </div>
		</div>
	</form>
</div>