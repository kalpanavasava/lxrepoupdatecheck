<?php

class pollCourseAjax{
	public function __construct() {
		add_action( 'wp_ajax_lx_pollcourse_preview', array($this,'lx_pollcourse_preview'));
		add_action( 'wp_ajax_nopriv_lx_pollcourse_preview', array($this,'lx_pollcourse_preview' )); 
		add_action( 'wp_ajax_upload_poll_thumb', array($this,'upload_poll_thumb'));
		add_action( 'wp_ajax_nopriv_upload_poll_thumb', array($this,'upload_poll_thumb' ));
		add_action('wp_ajax_add_question_section',array($this,'add_question_section'));
		add_action('wp_ajax_nopriv_add_question_section',array($this,'add_question_section'));
		add_action('wp_ajax_lx_save_poll',array($this,'lx_save_poll'));
		add_action('wp_ajax_nopriv_lx_save_poll',array($this,'lx_save_poll'));
		add_action('wp_ajax_lx_poll_delete_answer',array($this,'lx_poll_delete_answer'));
		add_action('wp_ajax_nopriv_lx_poll_delete_answer',array($this,'lx_poll_delete_answer'));
		add_action('wp_ajax_lx_poll_delete_question',array($this,'lx_poll_delete_question'));
		add_action('wp_ajax_nopriv_lx_poll_delete_question',array(
			$this,'lx_poll_delete_question'));

		add_action('wp_ajax_PollCourseSaveUserResponse',array($this,'PollCourseSaveUserResponse'));
		add_action('wp_ajax_nopriv_PollCourseSaveUserResponse',array($this,'PollCourseSaveUserResponse'));
		
		add_action('wp_ajax_getpollcompletedstatus',array($this,'getpollcompletedstatus'));
		add_action('wp_ajax_nopriv_getpollcompletedstatus',array($this,'getpollcompletedstatus'));
		
		add_action('wp_ajax_LxRestatPoll',array($this,'LxRestatPoll'));
		add_action('wp_ajax_nopriv_LxRestatPoll',array($this,'LxRestatPoll'));

		add_action('wp_ajax_lx_poll_cancle',array($this,'lx_poll_cancle'));
		add_action('wp_ajax_nopriv_lx_poll_cancle',array($this,'lx_poll_cancle'));
		
		/* start */
		add_action( 'wp_ajax_FNPollDocumentUpload', array($this,'FNPollDocumentUpload'));
		add_action( 'wp_ajax_nopriv_FNPollDocumentUpload', array($this,'FNPollDocumentUpload' ));
		
		add_action( 'wp_ajax_FNPollDocumentDelete', array($this,'FNPollDocumentDelete'));
		add_action( 'wp_ajax_nopriv_FNPollDocumentDelete', array($this,'FNPollDocumentDelete' ));
		/* end */
	}

	public function upload_poll_thumb(){
		global $s3_settings,$wpdb;
		$mode=$_POST['mode'];
		$course_id=$_POST['course_id'];
		$poll_id=$_POST['poll_id'];
		$type=$_POST['type'];
		$file=$_FILES['thumb'];
		$filename=$_FILES['thumb']['name'];
		if(isset($_POST['mode']) && $_POST['mode']=='add')
		{		
			$validate=file_validation($_FILES['thumb']);
			if($validate['status']=='0'){
				echo json_encode($validate);
				die;
			}
		}
		$path=store_file_locally($_POST['dataurl'],$filename);
		
		$arr=array(
			'course_id'=>$course_id,
			'module_id'=>$poll_id,
			'files' => $file,
			'path' => $path,
		);
		$arr['dir']='site-assets/course/'.$course_id.'/module-'.$poll_id.'/';
		if($type=="question"){
			$arr['dir']='site-assets/course/'.$course_id.'/module-'.$poll_id.'/question/';
			$arr['question_id']=$_POST['question_id'];
		}
		if($mode=='edit'){
			if($type=="question"){
				$question=$wpdb->get_results('select thumbnail from '.$wpdb->prefix.'vw_questions where question_id='.$_POST['original_qid']);
				$thumb=$question[0]->thumbnail;	
			}elseif($type=='introduction'){
				$thumb=get_post_meta($poll_id,'introduction',true)['image'];
			}else{
				$thumb=get_post_meta($poll_id,'conclusion',true)['image'];
			}
			if($thumb!='broken'){
				$bucket=$s3_settings['s3_bucket'];
				$file=$arr['dir'].basename($thumb);
				$s3=vw_lx_s3_uploadto_s3();
				$result=$s3->deleteObject([
			        'Bucket' => $bucket,
			        'Key'    => $file
			    ]);
			}
		}
		$upload=poll_thumb_upload($arr);
		if($mode=='edit'){
			if($type=="question"){
				$wpdb->update($wpdb->prefix.'vw_questions',array('thumbnail',$upload['cropped']),array('question_id'=>$_POST['original_qid']));
			}elseif($type=='introduction'){
				$intro=get_post_meta($poll_id,'introduction',true);
				$intro['image']=$upload['cropped'];
				update_post_meta($poll_id,'introduction',$intro);
			}else{
				$cncl=get_post_meta($poll_id,'conclusion',true);
				$cncl['image']=$upload['cropped'];
				update_post_meta($poll_id,'conclusion',$cncl);
			}
		}
		unlink($path);
		if(!empty($upload)){
			$data=['status'=>"1",'msg'=>'Uploaded Successfully','imageURL'=>$upload['cropped']];
		}else{
			$data=['status'=>"0",'msg'=>'Uploaded Failed'];
		}

		echo json_encode($data);
		die;
	}

	public function add_question_section(){
		/* echo '<pre>';print_r($_POST);die; */
		global $square_icon,$lx_plugin_urls;
		$question_id=$_POST['question_id'];
		$answer_id = 1;
		$length_answer_id = $answer_id+1;
		$new_answer_id = $length_answer_id;

		$feedback_id = 1;
		$length_feedback_id = $feedback_id+1;
		$new_feedback_id = $length_feedback_id;

		$total_textentry_answer_div = $_POST['textentry_answer'];
		$length_textentry_answer_div_id = $total_textentry_answer_div+1;
		$new_textentry_answer = $length_textentry_answer_div_id;

		$total_multiple_ans = $_POST['multiple_ans'];
		$length_multiple_ans_id = $total_multiple_ans+1;
		$new_multiple_ans = $length_multiple_ans_id;
		
		/* start */
		$total_document_ans = $_POST['document_answer'];
		$length_document_ans_id = $total_document_ans+1;
		$new_document_ans = $length_document_ans_id;
		$new_single_ans = $new_multiple_ans;
		/* end */
		?>
		<div class="main_question_div main_question_div<?php echo $question_id;?>" data-questionid="<?php echo $question_id;?>">
			<div class="row question_heading question_heading<?php echo $question_id;?>">
				<div class="col-md-12">
					<div class="d-flex">
						<div class="question_head"><h6 class="head_h6">QUESTION</h6></div>
						<div class="question_collapsed_expanded question_collapsed_expanded<?php echo $question_id;?>">
							<a class="btn btn-collapse" id="btn_question_collapse<?php echo $question_id;?>" data-toggle="collapse" data-target="#collapse-section" data-questionid="<?php echo $question_id;?>"><i class="fas fa-minus"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div class="question_answer_section<?php echo $question_id;?>">
				<div class="row question_section<?php echo $question_id;?>">
					<div class="col-md-4">
						<div class="question_thumbnail<?php echo $question_id;?>">
							<label class="label">Thumbnail (Optional)
								<div>
									<img class="thumb_prev" id="thumb_prev<?php echo $question_id;?>" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/add.png';?>" data-uploaded="0"/>
								</div>
								<div class="que_thumb<?php echo $question_id;?>" style="display: none;">
									<input type="file" class="upload-input lx_poll_que_thumb" id="lx_poll_que_thumb<?php echo $question_id;?>" name="lx_poll_que_thumb" data-questionid="<?php echo $question_id;?>" accept="image/jpg, image/jpeg, image/png"/>			
								</div>
							</label>
							<div class="form-group thumbnail_progress_main_div">
						        <div class="progress">
						            <div class="progress-bar" id="poll_que_thumb_progress<?php echo $question_id;?>" role="progressbar" aria-valuenow="25" aria-valuemin="0"
						                aria-valuemax="100"></div>
						        </div>
						        <small id="emailHelp" class="form-text small-left poll_thumb_upload_status"></small>
						        <small id="emailHelp" class="form-text text-muted">Upload Thumbnail</small>
						    </div>
							<div class="d-flex ai_center">
								<strong class="ml-3">Required</strong>
								<label class="lx_toggle">
									<input type="checkbox" checked class="ansrequiredtgl" id="ansrequiredtgl<?php echo $question_id;?>" name="ansrequiredtgl" data-question_id="<?php echo $question_id;?>" value="1">
									<span class="off" style="display:none;"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
									<span class="on"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
								</label>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="question<?php echo $question_id;?>'">
							<div class="form-group">
								<textarea type="text" class="form-control pc_question<?php echo $question_id;?> ta_quetion" maxlength="1200" id="pc_question<?php echo $question_id;?>" name="pc_question<?php echo $question_id;?>" value="" placeholder="Click here to add your question"></textarea>
								<div class="textarea_max_chars">
									<small class="question_error question<?php echo $question_id;?>_error">Cannot be empty</small>
									<small class="small_right"><span id="pc_question<?php echo $question_id;?>_chars">1200</span> characters remaining</small>
								</div>
							</div>
						</div>
						<!--  start -->
						<div class="question_type_div question_type_div<?php echo $new_single_ans;?>" data-question_id="<?php echo $new_single_ans;?>">
							<strong>Question Type</strong><div class="break_line"></div><br>
							<input type="hidden" class="question_type" id="question_type<?php echo $question_id;?>" name="question_type" data-qid="<?php echo $question_id;?>" value="0">
							<input type="hidden" class="question_type_meta" id="question_type_meta<?php echo $question_id;?>" name="question_type_meta" data-qid="<?php echo $question_id;?>" value="0">
							
							<div class="form-group single_answer single_answer<?php echo $new_single_ans; ?> " data-single_ans_id="<?php echo $new_single_ans;?>">
								 <label>
									<input type="radio" checked class="single_answer_selection single_answer_selection<?php echo $new_single_ans;?>" id="single_answer_selection<?php echo $new_single_ans; ?>" name="question_type<?php echo $new_single_ans; ?>" data-qid="<?php echo $question_id; ?>" value="0">&nbsp;&nbsp;Single answer (default)
								</label>
							</div>
							<div class="form-group multiple_ans multiple_ans<?php echo $new_multiple_ans;?> ai_center" data-multiple_ans_id="<?php echo $new_multiple_ans;?>">
								<label>
									<input type="radio" class="make_multiple_ans" id="make_multiple_ans<?php echo $new_multiple_ans;?>" name="question_type<?php echo $new_multiple_ans; ?>" data-qid="<?php echo $question_id;?>"  value="0">
									&nbsp;&nbsp;Allow <strong>Multiple answers</strong>
								</label>
								<label class="additional_note_multians additional_note_multians<?php echo $new_multiple_ans;?>" data-add_note_id="<?php echo $new_multiple_ans;?>" style="margin-left:20px;display:none;">
									<input type="checkbox" class="add_note_multians add_note_multians<?php echo $new_multiple_ans;?>" id="additional_note<?php echo $new_multiple_ans;?>" name="additional_note<?php echo $new_multiple_ans;?>" data-qid="<?php echo $question_id;?>" value="0">&nbsp;&nbsp;Allow <strong>Addiitional notes</strong>
								</label>
							</div>
							<div class="form-group textentry_answer_div textentry_answer_div<?php $new_textentry_answer;?> ai_center" data-textentry_answer_div_id="<?php echo $new_textentry_answer;?>">
								<label class="">
									<input type="radio" class="make_textentry_answer" id="make_textentry_answer<?php echo $new_textentry_answer;?>" name="question_type<?php echo $new_textentry_answer; ?>" data-qid="<?php echo $question_id;?>" value="0">
									&nbsp;&nbsp;Make it a <strong>Text Entry</strong> answer (2400 characters)
								</label>
							</div>
							<div class="form-group document_answer document_answer<?php echo $new_document_ans; ?> ai_center" data-document_ans_id="<?php echo $new_document_ans; ?>">
								<label class="">
									<input type="radio" class="make_document_answer" id="make_document_answer<?php echo $new_document_ans; ?>" name="question_type<?php echo $new_document_ans; ?>" data-qid="<?php echo $question_id; ?>" value="0">&nbsp;&nbsp;Make it a <strong>Document Upload</strong> answer
								</label>
								<label class="additional_note_docans additional_note_docans<?php echo $new_document_ans;?>" data-add_note_id="<?php echo $new_document_ans;?>" style="margin-left:20px;display:none;">
									<input type="checkbox" class="add_note_docans add_note_docans<?php echo $new_document_ans;?>" id="additional_note<?php echo $new_document_ans;?>" name="additional_note<?php echo $new_document_ans;?>" data-qid="<?php echo $question_id;?>" value="0">
									&nbsp;&nbsp;Allow <strong>Addiitional notes</strong>
								</label>
							</div>
						</div>
						
						<!--  end -->
						
						<?php
						/* <div class="form-group d-flex multiple_ans multiple_ans<?php echo $new_multiple_ans;?> ai_center" data-multiple_ans_id="<?php echo $new_multiple_ans;?>">
							<label class="lx_toggle">
								<input type="checkbox" class="make_multiple_ans" id="make_multiple_ans<?php echo $new_multiple_ans;?>" name="make_multiple_ans" data-qid="<?php echo $new_multiple_ans;?>"  value="0">
								<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
								<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
							</label>
							<div class="multiple_ans_text">
								<strong>&nbsp;&nbsp;Multiple answers allowed</strong>
							</div>
						</div>
						<div class="form-group d-flex textentry_answer_div textentry_answer_div<?php $new_textentry_answer;?> ai_center" data-textentry_answer_div_id="<?php echo $new_textentry_answer;?>">
							<label class="lx_toggle">
								<input type="checkbox" class="make_textentry_answer" id="make_textentry_answer<?php echo $new_textentry_answer;?>" name="make_textentry_answer" data-qid="<?php echo $new_textentry_answer;?>" value="0">
								<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
								<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
							</label>
							<div class="make_textentry_answer_text">
								<strong>&nbsp;&nbsp;Make it a Text Entry answer</strong>
							</div>
						</div> */
						?>
					</div>
					<div class="col-md-2 remove_Question_btn">
						<button type="button" class="btn btn-danger question_delete" data-quesid="<?php echo $question_id;?>">
							<i class="<?php echo $square_icon['trash'];?>" aria-hidden="true"></i>
						</button>
					</div>
				</div>
				<div class="answer_section<?php echo $question_id;?> mt-4">
					<div class="answer_heading"><h6 class="head_h6 ans_head">ANSWER/S</h6></div>
					<div class="row poll_div ans_main_div<?php echo $question_id;?> ans_main_div<?php echo $question_id.$answer_id;?>" data-questionid="<?php echo $question_id;?>" data-ansid="<?php echo $answer_id;?>" data-feedbackid="<?php echo $feedback_id;?>" style="align-items: end;">
						<div class="col-md-4">
							<div class="form-group answer<?php echo $question_id.$answer_id;?>">
								<strong>Answer (required)</strong>
								<textarea type="text" class="form-control pc_answer<?php echo $question_id.$answer_id;?> ta_answer" maxlength="150" id="pc_answer<?php echo $question_id.$answer_id;?>" name="pc_answer<?php echo $question_id.$answer_id;?>" data-qid="<?php echo $question_id;?>"></textarea>
								<div class="textarea_max_chars">
									<small class="ans_error">Cannot be empty</small>
									<small class="small_right"><span id="pc_answer<?php echo $question_id.$answer_id;?>_chars">150</span> characters remaining</small>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="optional_feedback optional_feedback<?php echo $question_id.$answer_id.$feedback_id;?>">
								<div class="d-flex ai_center">
									<label class="feedback_txt1">Optional feedback</label>
									<strong class="fbAnsToggle_txt ml-3">Use for all answers</strong>
									<label class="lx_toggle">
										<input type="checkbox" class="feedback_toggle" id="feedback_toggle<?php echo $question_id;?>" name="feedback_toggle" data-question_id="<?php echo $question_id;?>" value="0">
										<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
										<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
									</label>
								</div>
								<div class="form-group">
									<textarea type="text" class="form-control feedback<?php echo $question_id.$answer_id.$feedback_id;?> ta_feedback" maxlength="250" id="feedback<?php echo $question_id.$answer_id.$feedback_id;?>" name="feedback<?php echo $question_id.$answer_id.$feedback_id;?> " value="" ></textarea>
									<div class="textarea_max_chars">
										<small class="small_right"><span id="feedback<?php echo $question_id.$answer_id.$feedback_id;?>_chars">250</span> characters remaining</small>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row poll_div ans_main_div<?php echo $question_id;?> ans_main_div<?php echo $question_id.$new_answer_id;?>" data-questionid="<?php echo $question_id;?>" data-ansid="<?php echo $new_answer_id;?>" data-feedbackid="<?php echo $new_feedback_id;?>">
						<div class="col-md-4">
							<div class="form-group answer<?php echo $question_id.$new_answer_id;?>">
								<strong>Answer (required)</strong>
								<textarea type="text" class="form-control pc_answer<?php echo $question_id.$new_answer_id;?> ta_answer" maxlength="150" id="pc_answer<?php echo $question_id.$new_answer_id;?>" name="pc_answer<?php echo $question_id.$new_answer_id;?>" data-qid="<?php echo $question_id;?>"></textarea>
								<div class="textarea_max_chars">
									<small class="ans_error">Cannot be empty</small>
									<small class="small_right"><span id="pc_answer<?php echo $question_id.$new_answer_id;?>_chars">150</span> characters remaining</small>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="optional_feedback optional_feedback<?php echo $question_id.$new_answer_id.$new_feedback_id;?>">
								<div class="form-group">
									<label class="new_feedback_txt">Optional feedback</label>
									<textarea type="text" class="form-control feedback<?php echo $question_id.$new_answer_id.$new_feedback_id;?> ta_feedback" maxlength="250" id="feedback<?php echo $question_id.$new_answer_id.$new_feedback_id;?>" name="feedback<?php echo $question_id.$new_answer_id.$new_feedback_id;?>" value="" ></textarea>
									<div class="textarea_max_chars">
										<small class="small_right"><span id="feedback<?php echo $question_id.$new_answer_id.$new_feedback_id;?>_chars">250</span> characters remaining</small>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<div class="pc_new_answer_section<?php echo $question_id;?>">
								<div class="pc_new_answer_option add_AnsButton" data-question_id="<?php echo $question_id;?>">
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
		<?php
		die;
	}

	public function lx_pollcourse_preview(){
		/* echo '<pre>';print_r($_POST);die;  */
		global $lx_plugin_urls,$color_palette,$square_icon;	
		$restart=$_POST['restart_poll'];
		$intro_arr=$_POST['poll_arr']['introduction'];
		$question_arr=$_POST['poll_arr']['questions'];
		$conclusion_arr=$_POST['poll_arr']['conclusion'];
		if(!empty($intro_arr)){
		?>
		<div class="intro_div">
			<div class="intro_heading">
				<h3 class="head_h3">Introduction</h3>
				<div class="break_line"></div>
			</div>
			<div class="intro_content">
				<?php
					$display="block";
					if($intro_arr['image']=='broken'){
						$display="none";
					}
				?>
				<div class="intro_img" style="display:<?php echo $display;?>;"><img src="<?php echo $intro_arr['image'];?>"></div>
				<div class="intro_text mt-2"><?php echo FnFormatMytext(FnEscapeAphostrophys($intro_arr['text']));?></div>
			</div>
			<div class="mt-2 mb-2">
				<div class="break_line"></div>
				<div style="float:right;margin-bottom: 10px;"> 
					<button type="button" class="btn_normal_state btn_preview_next" data-current="intro_div" data-next="question_div1">Next</button>
				</div>
			</div>
		</div>
		<?php
		}
			$main_que_arr=array();					
			foreach($question_arr as $key=>$value){
				$qid=explode('_',$key)[0];
				$data=explode('_',$key)[1];
				if(strpos($data,'answer') !== false){
					$len=strlen($data)-strlen('answer');
					$id=substr($data,-$len);
					$main_que_arr[$qid]['answer'][$id]=FnEscapeAphostrophys($value);
					/*$data['answer'][$id]=$value;*/
				}elseif(strpos($data,'feedback') !== false){
					$len=strlen($data)-strlen('feedback');
					$id=substr($data,-$len);
					$main_que_arr[$qid]['feedback'][$id]=FnEscapeAphostrophys($value);
				}else{
					$main_que_arr[$qid][$data]=FnEscapeAphostrophys($value);
				}
				
			} 
			$i=1;
			$tot_que=count($main_que_arr);
			foreach($main_que_arr as $question){
				if($i==1 && !empty($intro_arr)){
					$prev="intro_div";
				}else{
					$cnt=$i-1;
					$prev="question_div".$cnt;
				}
				if($i==$tot_que){
					$next="conclusion_div";
				}else{
					$cnt=$i+1;
					$next="question_div".$cnt;
				}
				$show='none';
				if(empty($intro_arr) && $i==1){
					$show='block';
				}
				?>
				<div class="question_div_item question_div<?php echo $i;?>" style="display:<?php echo $show;?>;">
					<?php
						$display="block";
						if($question['image']=='broken'){
							$display="none";
						}
					?>
					<div class="question_img" style="display:<?php echo $display;?>;"><img src="<?php echo $question['image'];?>"></div>
					<input type="hidden" value="<?php echo $_POST['questionwiserequiredarr'][$i]; ?>" class="hidreqfield<?php echo $i;?>" />
					<div class="question_text mt-2"><?php echo FnFormatMytext($question['heading']);?></div>
					<div class="answer_div" style="margin-top:1em;color:<?php echo $color_palette['mid_grey'];?>">
						<?php 
							/* if($question['textentry']){ */							
							if( $question['questionType']==0 || $question['questionType']==1 ){
								?>
								<input type="hidden" id="multiple_ans<?php echo $i;?>" value="<?php echo $question['questionType'];?>">
								<?php
								foreach ($question['answer'] as  $key=>$value) {
									?>
									<div class="ans_div_item ans_item<?php echo $i;?> ans_item<?php echo $i.$key;?>" data-qid="<?php echo $i;?>" data-ansid="<?php echo $key;?>"><?php echo FnFormatMytext($value);?></div>
									<?php 
										if(!empty($question['feedback'][$key]) || ($question['fbForAll'] && !empty($question['feedback'][1]))){
									?>
									<div class="feedback_div" id="feedback_div<?php echo $i.$key;?>" style="display:none;">
										<?php 
											if($question['fbForAll']){
												echo FnFormatMytext($question['feedback'][1]);
											}else{
												echo FnFormatMytext($question['feedback'][$key]);
											}
										?>
									</div>
									<?php
									}
								} 
								if( $question['questionTypeMeta']==1 ){
								?>
									<br>
									<input type="hidden" id="add_note_multiple_ans<?php echo $i;?>" value="<?php echo $question['questionType'];?>">
									<div class="additional_note_txt_div additional_note_txt_div<?php echo $i;?>" style="display:none;">
										<strong>Additional notes</strong> (optional)
										<textarea id="additional_note_txt<?php echo $i;?>" class="additional_note_txt" maxlength="300" style="background-color: <?php echo $color_palette['white'];?>;"></textarea>
										<div class="textarea_max_chars">
											<small class="small_right"></span>&nbsp;<span id="additional_note_txt<?php echo $i;?>_chars">300</span> characters remaining</small>
										</div>
									</div>
								<?php
								}
							}elseif( $question['questionType']==2 ){
								?>
								<label><i>Add Your Answer</i></label>
								<textarea id="answer_text<?php echo $i;?>" class="addandTextarea" maxlength="2400" rows="5" style="background-color: <?php echo $color_palette['white'];?>;"></textarea>
								<div class="textarea_max_chars">
									<small class="small_right"></span>&nbsp;<span id="answer_text<?php echo $i;?>_chars">2400</span> characters remaining</small>
								</div>
								<?php
							}elseif( $question['questionType']==3 ){ ?>
								<input type="hidden" id="document_ans<?php echo $i;?>" value="<?php echo $question['questionType'];?>">
								<div class="d-flex">
									<div>
										<input type="file" id="attach_document_answer" hidden>
										<label for="attach_document_answer">
											<button class="btn_normal_state" disabled>Attach file</button>
										</label>
										<span id="file-chosen">&nbsp;&nbsp;Filename.docx</span>
									</div>
									<div style="margin-left:auto;">
										<button type="button" class="btn btn-danger document_answer_delete" data-quesid="<?php echo $i;?>" disabled>
											<i class="<?php echo $square_icon['trash'];?>" aria-hidden="true"></i>
										</button>
									</div>
									<br>
								</div>
								<em>Accepted formats: Document (DOC,DOCX,PDF), Size(Max 2MB)</em><br>
								<?php
								if( $question['questionTypeMeta']==1 ){
								?>
									<br>
									<div class="additional_note_txt_div additional_note_txt_div<?php echo $i;?>">
										<strong>Additional notes</strong> (optional)
										<textarea id="additional_note_txt<?php echo $i;?>" class="additional_note_txt" maxlength="300" style="background-color: <?php echo $color_palette['white'];?>;"></textarea>
										<div class="textarea_max_chars">
											<small class="small_right"></span>&nbsp;<span id="additional_note_txt<?php echo $i;?>_chars">300</span> characters remaining</small>
										</div>
									</div>
								<?php
								}
							}
						?>
					</div>
					<div class="mt-2 mb-2"0>
						<br><div class="break_line"></div>
						<?php 
							if($i==1 && empty($intro_arr)){}else{
						?>
						<button type="button" class="btn_normal_state btn_preview_prev" data-qid="<?php echo $i;?>" data-current="question_div<?php echo $i;?>" data-prev="<?php echo $prev;?>">Prev</button>
						<?php } ?>
						<div style="float:right;margin-bottom: 10px;"> 
							<button type="button" class="btn_normal_state btn_preview_next" data-qid="<?php echo $i;?>" data-current="question_div<?php echo $i;?>" data-next="<?php echo $next;?>">Next</button>
						</div>
					</div>
				</div>
				
				<?php
				$i++;
			}
		?>
		<div class="conclusion_div" style="display:none;">
			<?php if($conclusion_arr['image']!='broken' || !empty($conclusion_arr['text'])){?>
			<div class="cncl_heading">
				<h3 class="head_h3">Conclusion</h3>
				<div class="break_line"></div>
			</div>
			<div class="cncl_content">
				<?php
					$display="block";
					if($conclusion_arr['image']=='broken'){
						$display="none";
					}
				?>
				<div class="cncl_img" style="display:<?php echo $display;?>;"><img src="<?php echo $conclusion_arr['image'];?>"></div>
				<div class="cncl_text mt-2"><?php echo FnFormatMytext(FnEscapeAphostrophys($conclusion_arr['text']));?></div>
			</div>
			<div class="break_line"></div>
			<?php } ?>
			<div class="mt-2 mb-2">
				<button type="button" class="btn_normal_state btn_preview_prev" data-current="conclusion_div" data-prev="question_div<?php echo $tot_que;?>">Prev</button>
				<div style="float:right;margin-bottom: 10px;"> 
					<?php if($restart){ ?>
						<button type="button" class="btn_dark_state btn_start_again">Start Again</button>
					<?php } ?>
					<button type="button" class="btn_normal_state btn_preview_next" data-current="conclusion_div" data-next="submit_prompt_div">Submit</button>
				</div>
			</div>
		</div>
		<div class="submit_prompt_div" style="display:none;text-align: center;">
			<div class="prompt_text"><?php echo FnFormatMytext(FnEscapeAphostrophys($_POST['submit_prompt']));?></div>
			<?php 
				if($_POST['include_back_btn']=='1'){
					?><div class="mt-4 mb-2"><button type="button" class="btn_normal_state">Back</button></div><?php
				}
			?>
		</div>
		<?php
		die;
	}
	public function lx_save_poll(){
		global $wpdb;
		$mode=$_POST['mode'];
		$user_id=get_current_user_id();
		$course_id=$_POST['course_id'];
		$poll_id=$_POST['poll_id'];
		$btn_label=!empty($_POST['btn_label'])?$_POST['btn_label']:'Poll';
		$intro_arr=array_key_exists('introduction', $_POST['poll_arr'])?$_POST['poll_arr']['introduction']:array();
		if(!empty($intro_arr))
		{
			$intro_arr['text']=FnEscapeAphostrophys($intro_arr['text']);
		}
		$cncl_arr=$_POST['poll_arr']['conclusion'];
		$cncl_arr['text']=FnEscapeAphostrophys($cncl_arr['text']);
		$question_arr=$_POST['poll_arr']['questions'];
		$main_que_arr=array();	
		
		/* -------- */
		$fount_post=$wpdb->get_results('select ID from '.$wpdb->prefix.'posts where post_type="lx_lessons" and post_title="'.$_POST['title'].'"');
		if(!empty($fount_post)){
			$fp_ids=array();
			$fpc_ids=array();
			foreach($fount_post as $fp){
				$fp_ids[]=$fp->ID;
				$fpc_ids[]=get_post_meta($fp->ID,'course_id',true);
			}
		}
		if($mode=='add'){
			$menu_order=count(get_lessons($course_id))+1;
			if( !empty($fount_post) && in_array($course_id,$fpc_ids)){
				echo json_encode(array('msg'=>'exist'));
				die;
			}
		}else{
			$menu_order=get_post($poll_id)->menu_order;
			if( !empty($fount_post) && !in_array($poll_id,$fp_ids) && in_array($course_id,$fpc_ids)){
				if( $fount_post !=0 ){
					echo json_encode(array('msg'=>'exist'));
					die;
				}
			}
		}
		/* ----- */
		
		/* $fount_post=post_exists($_POST['title'],'','','lx_lessons');
		if($fount_post>0 && $fount_post!=$poll_id){
			echo json_encode(array('msg'=>'exist'));
			die();
		}
		if($mode=='add'){
			$menu_order=count(get_lessons($course_id))+1;
		}else{
			$menu_order=get_post($poll_id)->menu_order;
		} */
		$arr=array(
			'ID'		  => $poll_id,
			'post_title'  => $_POST['title'],
			'post_status' => $_POST['status'],
			'post_type'	  => 'lx_lessons',
			'guid' => sanitize_title_with_dashes($_POST['title']),
			'menu_order'=>$menu_order
		);
		wp_update_post($arr);
		update_post_meta($poll_id,'course_id',$course_id);
		update_post_meta($poll_id,'subtitle',FnEscapeAphostrophys($_POST['subtitle']));
		update_post_meta($poll_id,'primary_recipient',$_POST['primary_email']);
		update_post_meta($poll_id,'secondary_recipient',$_POST['secondary_email']);
		update_post_meta($poll_id,'restart_poll',$_POST['restart_poll']);
		update_post_meta($poll_id,'available_in_course',$_POST['avail_in_course']);
		update_post_meta($poll_id,'button_label',$btn_label);
		$certificate='off';
		if($_POST['required_completion']==1){
			$certificate='on';
		}
		update_post_meta($poll_id,'lx_xapi_certificate',$certificate);	
		update_post_meta($poll_id,'introduction',$intro_arr);
		update_post_meta($poll_id,'conclusion',$cncl_arr);
		update_post_meta($poll_id,'content_type','poll');
		update_post_meta($poll_id,'submit_prompt',$_POST['submit_prompt']);
		update_post_meta($poll_id,'include_back_button',$_POST['include_back_btn']);
		update_post_meta($poll_id,'back_nav_link',$_POST['back_nav_link']);
		update_post_meta($poll_id,'ismoduletoggleon',$_POST['ismoduletoggleon']);
		update_post_meta($poll_id,'module_apperain',$_POST['module_apperain']);
		foreach($question_arr as $key=>$value){
			/* $qid=substr(explode('_',$key)[0],-1); */
			$qid=str_replace( 'question' , '' , explode('_',$key)[0] );
			$data=explode('_',$key)[1];
			if(strpos($data,'answer') !== false){
				$len=strlen($data)-strlen('answer');
				$id=substr($data,-$len);
				$main_que_arr[$qid]['answer'][$id]=FnEscapeAphostrophys($value);
			}elseif(strpos($data,'feedback') !== false){
				$len=strlen($data)-strlen('feedback');
				$id=substr($data,-$len);
				$main_que_arr[$qid]['feedback'][$id]=FnEscapeAphostrophys($value);
			}else{
				$main_que_arr[$qid][$data]=FnEscapeAphostrophys($value);
			}
			$main_que_arr[$qid]['qrequired'] = $_POST['questionwiserequiredarr'][$qid];
			
		}
	
		/* $_POST['questionwiserequiredarr'] */
		$cnt=array();
		foreach($main_que_arr as $question){
			if(isset($question['orignalqid']) && !empty($question['orignalqid'])){
				$que_arr=array(
					'author_id'=>$user_id,
					'post_id'=>$poll_id,
					'course_id'=>$course_id,
					'question_required'=>$question['qrequired'],
					'name'=>$question['heading'],
					'thumbnail'=>$question['image'],
					/* 'allow_multiple'=>$question['multiAns'],
					'text_entry_answer'=>$question['textentry'], */
					'question_type'=>$question['questionType'],
					'question_type_meta'=>$question['questionTypeMeta'],
					'feedback_for_all'=>$question['fbForAll'],
					'date_updated'=>date('Y-m-d'),
				);
				
				/* $old_text_entry=$wpdb->get_results('select text_entry_answer from '.$wpdb->prefix.'vw_questions where question_id='.$question['orignalqid'])[0]->text_entry_answer;
				if($old_text_entry==0 && $question['textentry']==1){
					foreach($question['answer'] as $key=>$value){
						if(isset($question['orignalaid'.$key]) && !empty($question['orignalaid'.$key])){
							$wpdb->delete($wpdb->prefix.'vw_answers',array('answer_id'=>$question['orignalaid'.$key]));
						}
					}
				} */
				
				if( $question['questionType']==2 ){
					foreach($question['answer'] as $key=>$value){
						if(isset($question['orignalaid'.$key]) && !empty($question['orignalaid'.$key])){
							$wpdb->delete($wpdb->prefix.'vw_answers',array('answer_id'=>$question['orignalaid'.$key]));
						}
					}
				}
				
				$wpdb->update($wpdb->prefix."vw_questions",$que_arr,array('question_id'=>$question['orignalqid']));
				$question_id=$question['orignalqid'];
			}else{
				$que_arr=array(
				'question_id'=>'',
					'author_id'=>$user_id,
					'post_id'=>$poll_id,
					'course_id'=>$course_id,
					'question_required'=>$question['qrequired'],
					'name'=>$question['heading'],
					'thumbnail'=>$question['image'],
					/* 'allow_multiple'=>$question['multiAns'],
					'text_entry_answer'=>$question['textentry'], */
					'question_type'=>$question['questionType'],
					'question_type_meta'=>$question['questionTypeMeta'],
					'feedback_for_all'=>$question['fbForAll'],
					'date_updated'=>date('Y-m-d'),
					'date_created'=>date('Y-m-d')
				);

				$wpdb->insert($wpdb->prefix."vw_questions",$que_arr);
				$question_id=$wpdb->insert_id;
			}
			/* if(!$question['textentry']){ */
			if( $question['questionType'] == 0 || $question['questionType'] == 1 ){
				foreach($question['answer'] as $key=>$value){
					if(isset($question['orignalaid'.$key]) && !empty($question['orignalaid'.$key])){
						$ans_arr=array(
							'question_id'=>$question_id,
							'answer'=>$value,
							'feedback'=>$question['feedback'][$key],
							'date_updated'=>date('Y-m-d'),
						);
						$answer_id=$wpdb->update($wpdb->prefix."vw_answers",$ans_arr,array('answer_id'=>$question['orignalaid'.$key]));
					}else{
						$ans_arr=array(
							'answer_id'=>'',
							'question_id'=>$question_id,
							'answer'=>$value,
							'feedback'=>$question['feedback'][$key],
							'date_updated'=>date('Y-m-d'),
							'date_created'=>date('Y-m-d')
						);
						$answer_id=$wpdb->insert($wpdb->prefix."vw_answers",$ans_arr);
					}
				}
			}
			$cnt[]=1;
		}
		$msg='inserted';
		if($mode='edit'){
			$msg='updated';
		}
		if(count($cnt)>0){
			echo json_encode(array('msg'=>$msg,'link'=>get_permalink($course_id)));
		}else{
			echo json_encode(array('msg'=>'error'));
		}
		die;
	}	

	public function lx_poll_delete_answer(){
		global $wpdb;
		$question_id=$_POST['question_id'];
		$answer_id=$_POST['answer_id'];	
		$delete=$wpdb->delete($wpdb->prefix.'vw_answers',array('answer_id'=>$answer_id));
		$find=$wpdb->get_results('select * from '.$wpdb->prefix.'vw_pollcourse_userdata where answer_id like "%'.$answer_id.'%"');
		if(!empty($find)){
			foreach($find as $response){
				if($response->answer_id==$answer_id){
					$ur_delete=$wpdb->delete($wpdb->prefix.'vw_pollcourse_userdata',array('id'=>$response->id));
				}else{
					$ids=explode(',',$response->answer_id);
					$nids=array();
					foreach($ids as $k=>$v){
						if($v==$answer_id){
							unset($ids[$k]);
						}else{
							$nids[]=$v;
						}
					}
					$aids=implode(',',$nids);
					$update=$wpdb->update($wpdb->prefix.'vw_pollcourse_userdata',array('answer_id'=>$aids),array('id'=>$response->id));
				}
			}
		}
		echo 'deleted';
		die();
	}

	public function lx_poll_delete_question(){
		global $wpdb,$s3_settings;
		$question_id=$_POST['question_id'];
		$question=$wpdb->get_results('select * from '.$wpdb->prefix.'vw_questions where question_id='.$question_id);
		$thumb=basename($question[0]->thumbnail);
		$course_id=$question[0]->course_id;
		$post_id==$question[0]->post_id;
		$bucket=$s3_settings['s3_bucket'];
		$file='site-assets/course/'.$course_id.'/module-'.$post_id.'/question/'.$thumb;
		$s3=vw_lx_s3_uploadto_s3();
		$result=$s3->deleteObject([
	        'Bucket' => $bucket,
	        'Key'    => $file
	    ]);
		$delete_q=$wpdb->delete($wpdb->prefix.'vw_questions',array('question_id'=>$question_id));
		$delete_a=$wpdb->delete($wpdb->prefix.'vw_answers',array('question_id'=>$question_id));
		$find=$wpdb->get_results('select * from '.$wpdb->prefix.'vw_pollcourse_userdata where question_id='.$question_id);
		if(!empty($find)){
			foreach($find as $response){
				$delete_ur=$wpdb->delete($wpdb->prefix.'vw_pollcourse_userdata',array('id'=>$response->id));
			}
		}
		echo 'deleted';
		die();
	}

	public function PollCourseSaveUserResponse(){
		global $wpdb;
		$flag=1;
		$user_id = get_current_user_id();
		$post_id = $_POST['post_id'];
		$que_id = isset($_POST['que_id']) ? $_POST['que_id']:'';
		$ans_id = isset($_POST['ans_id']) ? $_POST['ans_id']:'';	
		$check = $wpdb->get_results('select * from '.$wpdb->prefix.'vw_pollcourse_userdata where user_id='.$user_id.' and question_id='.$que_id);
		if(!empty($check)){
			$wpdb->delete($wpdb->prefix.'vw_pollcourse_userdata',array('id'=>$check[0]->id));
		}
		/* start */
		$add_note='';
		if( isset($_POST['multi_ansid']) && !empty($_POST['multi_ansid']) ){
			$ans_id = implode(",",$_POST['multi_ansid'] );
			if( isset($_POST['add_note']) && !empty($_POST['add_note']) ){
				$add_note= $_POST['add_note'];
			}
		}
		if( isset($_POST['is_text']) && $_POST['is_text'] ){
			$ans_id = '';
			$text_answer = $_POST['is_text'];
		}else{
			$text_answer = '';
		}
		/* start */
		$doc_answer='';
		if( isset($_POST['doc_answer']) && !empty($_POST['doc_answer']) ){
			$doc_answer= $_POST['doc_answer'];
			if( isset($_POST['add_note']) && !empty($_POST['add_note']) ){
				$add_note= $_POST['add_note'];
			}
		}
		
		/* end */
		$table_name = $wpdb->prefix.'vw_pollcourse_userdata'; 
		$status = '';
		if( $_POST['click'] == 'submit' ){
			$primary_recipient = get_post_meta($post_id,'primary_recipient',true);
			$secondary_recipient = get_post_meta($post_id,'secondary_recipient',true);
			$poll_title = get_post($post_id)->post_title;
			$course_id = get_post_meta($post_id,'course_id',true);
			$course_title = get_post($course_id)->post_title;	
			$user_response = $wpdb->get_results('select * from '.$wpdb->prefix.'vw_pollcourse_userdata where user_id='.$user_id.' and post_id='.$post_id.' and status="completed"');
			
			if( empty($user_response) ){
				$flag=1;
				$que_id = '';
				$ans_id = '';
				$text_answer = '';
				$status = 'completed';
				update_user_meta($user_id,'lx_lesson_progress_'.$post_id,'completed');
				$progress_date = get_user_meta($user_id,'lx_lesson_progress_date_'.$post_id,true);
				$progress_date['end_timstamp'] = time();
				update_user_meta($user_id,'lx_lesson_progress_date_'.$post_id,$progress_date);
				
				/** create completion lead **/
				$webooksettings = get_option('currentwebhookon',true);
				if( $webooksettings['content'] == 1 ){
					$is_content_webhookexist = $wpdb->get_results("select * from ".$wpdb->prefix."vw_contentwebhook_master where contentid='".$post_id."'");
					if( $is_content_webhookexist[0]->act_progressed == 1 ){
						$salesforcesetting = get_option('salesforce_environment',true);
						$apis = array_values( $salesforcesetting[$salesforcesetting['environment']] );
						$Auth = SFAPIAuthentication( $apis );
						$auth_token = json_decode( $Auth )->access_token;
						$instance_url = json_decode( $Auth )->instance_url;
						$authenticationar = array('auth_token'=>$auth_token,'instance_url'=>$instance_url);
						$contenttitle = get_post($post_id)->post_title;
						$crs_id = get_post_meta($post_id,'course_id',true);
						$coursetitle = get_post($crs_id)->post_title;
						$comid = get_post_meta($crs_id,'lx_attach_this_course',true);
						$commtitle = get_post($comid)->post_title;
						$cusrid = get_current_user_ID();
						
						$payload_array['Email__c'] = get_userdata($cusrid)->user_email;
						$payload_array['FirstName'] = get_user_meta($cusrid,'first_name',true);
						$payload_array['LastName'] = get_user_meta($cusrid,'last_name',true);
						$payload_array['company'] = get_option('blogname',true);
						$payload_array['CommunityId__c'] = $comid;
						$payload_array['Community_Name__c'] = $commtitle;
						$payload_array['CourseId__c'] = $crs_id;
						$payload_array['Course_Name__c'] = $coursetitle;
						$payload_array['ContentId__c'] = $post_id;
						$payload_array['Content_Name__c'] = $contenttitle;
						$payload_array['Action__c'] = 'Completed';
						$payload_array['Form_Type__c'] = 'Content';
						
						$generated_lead = SFAPICreateNewLead( $authenticationar , json_encode( $payload_array ) );
										
						if( !empty(json_decode( $generated_lead )->id) ){
							$wpdb->insert($wpdb->prefix.'vw_contentwebhook_payload',array('userid'=>$cusrid,'com_id'=>$comid,'course_id'=>$crs_id,'content_id'=>$post_id,'action'=>'Completed','response'=>$generated_lead,'date_created'=>date('Y-m-d H:i:s')));
						}
					}
				}
			}else{
				$flag=0;
			}
			$user=get_userdata(get_current_user_id());
			$to = $primary_recipient;
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
			$headers[] = 'CC:'.$secondary_recipient;
			$subject = 'Subject:'.$poll_title;
			$body='';
			$body.= "<b>".$course_title."</b><br>".$poll_title."<br>";
			$body.= "<b>Response submitted by:</b><br>";
			$body.="Username: ".$user->user_login."<br>";
			$body.="Name: ".$user->first_name." ".$last_name."<br>";
			$body.="Email: ".$user->user_email."<br>";
			$user_response_data = $wpdb->get_results('select * from '.$wpdb->prefix.'vw_pollcourse_userdata where user_id='.$user_id.' and post_id='.$post_id.' and status=""');
			$i=1;
			foreach($user_response_data as $response){
				$question=$wpdb->get_results('select * from '.$wpdb->prefix.'vw_questions where question_id='.$response->question_id)[0];
				/* $is_multiple=$question->allow_multiple;
				$is_text=$question->text_entry_answer; */
				
				$body.= '<br>'.'Question '.$i."<br>"; 
				$body.= '<b>'.$question->name.'</b><br>';
				$query='';
				/* if($is_text){
					$body.='<p>'.$response->text_answer.'<p>';
				}else{
					if($is_multiple){
						$query='answer_id IN('.$response->answer_id.')';
					}else{
						$query='answer_id='.$response->answer_id;
					}
					$answers=$wpdb->get_results('select * from '.$wpdb->prefix.'vw_answers where '.$query);
					foreach($answers as $ans){
						if($is_multiple==1){
							$body.= '<li type="1">'.$ans->answer.'</li>'; 	
						}else{
							$body.='<p>'.$ans->answer.'</p>'; 
						}
					}
				} */
				
				if( $question->question_type == 0 ){
					$query='answer_id='.$response->answer_id;
					$is_multiple=0;
				}
				if( $question->question_type == 1 ){
					$query='answer_id IN('.$response->answer_id.')';
					$is_multiple=1;
				}
				$answers=$wpdb->get_results('select * from '.$wpdb->prefix.'vw_answers where '.$query);
				foreach($answers as $ans){
					/* if($is_multiple==1){
						$body.= '<li type="1">'.$ans->answer.'</li>'; 	
					}else{
						$body.='<p>'.$ans->answer.'</p>'; 
					} */
					if( $is_multiple == 1 ){
						$body.= '<li type="1">'.$ans->answer.'</li>';
					}else{
						$body.='<p>'.$ans->answer.'</p>'; 
					}
				}
				if( $question->question_type == 1 ){
					$body.='<p>'.$response->additional_note.'</p>';
				}
				if( $question->question_type == 2 ){
					$body.='<p>'.$response->text_answer.'</p>';
				}
				if( $question->question_type == 3 ){
					/* $body.='<a href="'.$response->upload_url.'">'.urldecode(basename($response->upload_url)).'</a>'; */
					$body.='<p>'.'Attachment Below : '.urldecode(basename($response->upload_url)).'</a>'; 
					$attachment = wp_upload_dir()['path'].'/'.urldecode(basename($response->upload_url));
					$body.='<p>'.$response->additional_note.'</p>';
				}
				
				$i++;
			}
			$mail = wp_mail($to,$subject,$body,$headers,$attachment);
			if($_POST['send_user_copy']=='1'){
				$to=$user->user_email;
				$headers[] = 'Content-Type: text/html; charset=UTF-8';
				wp_mail($to,$subject,$body,$headers,$attachment);
			}
			unlink($attachment);			
		}
		$data = array( 
			'id'			=> '',
			'user_id'		=> $user_id,
			'post_id'		=> $post_id, 
			'question_id'	=> $que_id, 
			'answer_id'		=> $ans_id, 
			'text_answer'	=> $text_answer,
			'upload_url'	=> $doc_answer,
			'additional_note'=> $add_note,
			'status'		=> $status,
			'date_updated'	=> date("Y-m-d"),
			'date_created'	=> date("Y-m-d")
		);
		if( $flag == 1 ){
			$result = $wpdb->insert( $table_name, $data );
		}
		die;  
	}
	public function getpollcompletedstatus(){
		global $wpdb;
		$postid = $_POST['post_id'];
		$userid = get_current_user_ID();
		$get_response = $wpdb->get_results("select * from ".$wpdb->prefix."vw_pollcourse_userdata where user_id='".$userid."' and post_id='".$postid."' and status='completed'");
		
		if( !empty($get_response) ){
			echo 'completed';
		}
		wp_die();
	}
	public function LxRestatPoll(){
		global $wpdb;
		$user_id = get_current_user_id();
		$post_id = $_POST['post_id'];
		
		/* start */
		$course_id = $_POST['course_id'];
		$all_uploads = $wpdb->get_results("select * from ".$wpdb->prefix."vw_pollcourse_userdata where user_id='".$user_id."' and post_id='".$post_id."'");
		foreach( $all_uploads as $upload ){
			$upload_url=$upload->upload_url;
			if( !empty($upload_url) && $upload_url !=''){
				$data = $wpdb->get_results("select question_id from ".$wpdb->prefix.'vw_pollcourse_userdata where upload_url="'.$upload_url.'" and user_id="'.$user_id.'" and post_id="'.$post_id.'" ');
				
				$question_id = $data[0]->question_id;
				$docname = urldecode( basename($upload_url) );
				$arr = array(
					'poll_id' => $post_id,
					'dir' => 'site-assets/course/'.$course_id.'/module-'.$post_id.'/question/'.$user_id.'/'.$question_id.'/attachments/'
				); 
				$return_func = PollDocumentS3Delete( $arr ); 
				if( !empty($return_func) ){
					unlink(wp_upload_dir()['path'].'/'.$docname);
				}
			}	
		}
		
		if(!empty($all_uploads)){
			foreach($all_uploads as $response){
				$delete=$wpdb->delete($wpdb->prefix.'vw_pollcourse_userdata',array('id'=>$response->id));
			}
		}  
		echo 'deleted';
		die;
	}

	public function lx_poll_cancle(){
		global $s3_settings;
		$s3 = vw_lx_s3_uploadto_s3();
		$bucket=$s3_settings['s3_bucket'];
		$dir='site-assets/course/'.$_POST['course_id'].'/module-'.$_POST['poll_id'].'/';
		$data = $s3->deleteMatchingObjects($bucket, $dir);
		if(isset($_POST['status']) && $_POST['status']=='draft')
		{
			wp_delete_post($_POST['poll_id']);
		}
		echo "deleted";
		die;
	}
	
	/* start */
	public function FNPollDocumentUpload(){
		$user_id = get_current_user_ID();
		$course_id = $_POST['course_id'];
		$poll_id = $_POST['poll_id'];
		$question_id = $_POST['question_id'];
		$file_name = $_POST['file_name'];
		$arr = array(
			'poll_id'=>$poll_id,
			'file'=>$_FILES,
			'dir' => 'site-assets/course/'.$course_id.'/module-'.$poll_id.'/question/'.$user_id.'/'.$question_id.'/attachments/'
		);
		$return_func = PollDocumentS3Upload( $arr );
		if( $return_func['filepath'] ){
			$filename = urldecode( basename($return_func['filepath']) );
			$uploadpath = wp_upload_dir()['path'].'/'.$filename;
			move_uploaded_file($_FILES['file']['tmp_name'],$uploadpath);
			
			$data=[
				'status'=>"1",
				'filename'=>$filename,
				'filepath'=>$return_func['filepath']
			];
		}else{
			$data=['status'=>"0"]; 
		}
		echo json_encode($data);
		die();
	}
	
	public function FNPollDocumentDelete(){
		global $wpdb;
		$user_id = get_current_user_ID();
		$course_id = $_POST['course_id'];
		$poll_id = $_POST['poll_id'];
		$question_id = $_POST['question_id'];
		$docname = $_POST['docname'];
		$arr = array(
			'poll_id' => $poll_id,
			'dir' => 'site-assets/course/'.$course_id.'/module-'.$poll_id.'/question/'.$user_id.'/'.$question_id.'/attachments/'
		);
		
		$return_func = PollDocumentS3Delete( $arr );
		
		if( !empty($return_func) ){
			$delete_path = $wpdb->get_results("delete from ".$wpdb->prefix.'vw_pollcourse_userdata where question_id="'.$question_id.'" and user_id="'.$user_id); 
			unlink(wp_upload_dir()['path'].'/'.$docname);
		}
		die();
	}
	
	/* end */
}