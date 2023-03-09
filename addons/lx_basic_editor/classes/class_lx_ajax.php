<?php
class lx_ajax{
	
	public $lxed_all_data;
	
	public function __construct() {
		/** fn_lx_editor_clicks **/
		add_action("wp_ajax_fn_lx_editor_clicks", array($this,"fn_lx_editor_clicks"));
		add_action( 'wp_ajax_nopriv_fn_lx_editor_clicks', array($this,'fn_lx_editor_clicks'));
		
		/** fn_lx_filter for the filter **/
		add_action("wp_ajax_fn_lx_filter", array($this,"fn_lx_filter"));
		add_action( 'wp_ajax_nopriv_fn_lx_filter', array($this,'fn_lx_filter'));
		
		/** ------- **/
		add_action("wp_ajax_fn_lx_editor_upload_thumbnail", array($this,"fn_lx_editor_upload_thumbnail"));
		add_action( 'wp_ajax_nopriv_fn_lx_editor_upload_thumbnail', array($this,'fn_lx_editor_upload_thumbnail'));
		
		/** ----fn_lx_publish_post for publish post --- **/
		add_action("wp_ajax_fn_lx_publish_post", array($this,"fn_lx_publish_post"));
		add_action( 'wp_ajax_nopriv_fn_lx_publish_post', array($this,'fn_lx_publish_post'));
		
		/** ----fn_lx_editor_rendered for render the blog post --- **/
		add_action("wp_ajax_fn_lx_editor_rendered", array($this,"fn_lx_editor_rendered"));
		add_action( 'wp_ajax_nopriv_fn_lx_editor_rendered', array($this,'fn_lx_editor_rendered'));
		
		/** ----fn_lx_switchto_html for switch to html --- **/
		add_action("wp_ajax_fn_lx_switchto_html", array($this,"fn_lx_switchto_html"));
		add_action( 'wp_ajax_nopriv_fn_lx_switchto_html', array($this,'fn_lx_switchto_html'));	
		
		/** ----fn_lx_reset_html for reset html --- **/
		add_action("wp_ajax_fn_lx_reset_html", array($this,"fn_lx_reset_html"));
		add_action( 'wp_ajax_nopriv_fn_lx_reset_html', array($this,'fn_lx_reset_html'));
		
		/** ----fn_lx_switchto_editor for switch to editor --- **/
		add_action("wp_ajax_fn_lx_switchto_editor", array($this,"fn_lx_switchto_editor"));
		add_action( 'wp_ajax_nopriv_fn_lx_switchto_editor', array($this,'fn_lx_switchto_editor'));
		
		/** ----fn_lx_delete_section_img from s3--- **/
		add_action("wp_ajax_fn_lx_delete_section_img", array($this,"fn_lx_delete_section_img"));
		add_action( 'wp_ajax_nopriv_fn_lx_delete_section_img', array($this,'fn_lx_delete_section_img'));

		/** ----fn_lx_delete_folder_from_s3 delete folder from s3 while cancle blog post--- **/
		add_action("wp_ajax_fn_lx_delete_folder_from_s3", array($this,"fn_lx_delete_folder_from_s3"));
		add_action( 'wp_ajax_nopriv_fn_lx_delete_folder_from_s3', array($this,'fn_lx_delete_folder_from_s3'));
		
		/** fn_lx_ajax_video_upload_tos3 upload video to s3 **/
		add_action("wp_ajax_fn_lx_ajax_video_upload_tos3", array($this,"fn_lx_ajax_video_upload_tos3"));
		add_action( 'wp_ajax_nopriv_fn_lx_ajax_video_upload_tos3', array($this,'fn_lx_ajax_video_upload_tos3'));
		
		/** ----fn_lx_add_more_single_choice for adding more single choice --- **/
		add_action("wp_ajax_fn_lx_add_more_single_choice", array($this,"fn_lx_add_more_single_choice"));
		add_action( 'wp_ajax_nopriv_fn_lx_add_more_single_choice', array($this,'fn_lx_add_more_single_choice'));
		
		/** ----fn_lx_add_more_single_choice for adding more single choice --- **/
		add_action("wp_ajax_fn_lx_add_more_single_choice_questions", array($this,"fn_lx_add_more_single_choice_questions"));
		add_action( 'wp_ajax_nopriv_fn_lx_add_more_single_choice_questions', array($this,'fn_lx_add_more_single_choice_questions'));
		
		/** ----lx_delete_blog_post for delete blog post --- **/
		add_action("wp_ajax_lx_delete_blog_post", array($this,"lx_delete_blog_post"));
		add_action( 'wp_ajax_nopriv_lx_delete_blog_post', array($this,'lx_delete_blog_post'));
		
		add_action("wp_ajax_get_category_blogpost", array($this,"get_category_blogpost") );
		add_action( 'wp_ajax_nopriv_get_category_blogpost', array($this,'get_category_blogpost') );
		
		add_action("wp_ajax_fn_lx_editor_delete_thumbnail", array($this,"fn_lx_editor_delete_thumbnail") );
		add_action( 'wp_ajax_nopriv_fn_lx_editor_delete_thumbnail', array($this,'fn_lx_editor_delete_thumbnail') );
    }
	
	/**
		* blog post filter
		**/
	function fn_lx_filter(){
		/* $get_all_posts = $this->lxed_all_data->fn_lx_get_posts($filter=1); */
		$pub_cat = $this->lxed_all_data->vw_fn_lx_get_publib_cat();
		
		foreach($pub_cat as $pub_cat_data){
		$term_id = $pub_cat_data->term_id;
		$name = $pub_cat_data->name;
		
		$args = array(
			'post_type' => 'post',
			'category' => $term_id,
			'orderby'  => 'title',
			'order'     => 'ASC',
			'post_status' => array('publish', 'draft'),
		);
		$get_postbyterm = get_posts( $args );
		/* echo "<pre>";print_r($get_postbyterm); */
		/* $get_postbyterm = $this->lxed_all_data->vw_fn_get_postby_termid($term_id); */
		if(count($get_postbyterm) > 0){
			?>
			<div class="mt-2 standarized_tab">
				<div class="standarized_tab_innr1">
					<span style="position: relative;"><?php echo $name;?></span>
				</div>
			</div>
			<div class="row lxed_main_page_listing">
			<?php
			}
			/* wp_get_post_terms */
			/* echo "<pre>";print_r($get_postbyterm);  */
			foreach( $get_postbyterm as $get_all_posts_data ){
				$post_id = $get_all_posts_data->ID;
				$post_title = $get_all_posts_data->post_title;
				$post_author = $get_all_posts_data->post_author;
				$post_description = $get_all_posts_data->post_excerpt;
				$thumbnail_image = get_post_meta( $post_id , 'lxed_thumbnail_image' )[0];
				$post_status = $get_all_posts_data->post_status;
				
				include( dirname(dirname(__FILE__)) .'/template/blog_post_list.php');
			}
			?>
			</div>
			<?php
		}
		wp_die();
	}
		
	/**
		* Blocks Clicks add new section blocks
		**/
	function fn_lx_editor_clicks(){
		$section_id = $_POST['section_id'];
		
		$this_click = $_POST['lx_block_click'];

			switch ($this_click) {
				
			  case "lxed_text":
			  		
				include (dirname(dirname(__FILE__)).'/template/blocks/text_block.php');
				break;
				
			  case "lxed_img":
			  
				include (dirname(dirname(__FILE__)).'/template/blocks/img_block.php');
				break;
				
			  case "lxed_text_img":
			  
				include (dirname(dirname(__FILE__)).'/template/blocks/text_img_block.php');
				break;
			
			  case "lxed_img_text":
			  
				include (dirname(dirname(__FILE__)).'/template/blocks/img_text_block.php');
				break;
				
			  case "lxed_video":
			  
				include (dirname(dirname(__FILE__)).'/template/blocks/video_block.php');
				break;
				
			  case "lxed_page_break":
			  
				include (dirname(dirname(__FILE__)).'/template/blocks/page_break.php');
				break;
				
			  case "lx_editor_new_section":
			  
				include (dirname(dirname(__FILE__)).'/template/blocks/newsection_block.php');
				break;
				
			  case "lxed_blkbutton":
			  
				include (dirname(dirname(__FILE__)).'/template/blocks/button_block.php');
				break;
			
			  case "lxed_single_choice":
			  
				include (dirname(dirname(__FILE__)).'/template/blocks/single_choice.php');
				break;
				
			  default:
				echo "";
				
			}
		
		wp_die();
	}
	
	function fn_lx_editor_upload_thumbnail(){
		$data_array = array(
			'blog_post_id'=>$_POST['blog_post_id'],
			'dataurl'=>$_POST['dataurl'],
			'filename'=>$_POST['filename']
		);
		if(isset($_POST['section_img']))
		{
			if(basename($_POST['section_img'])!='sample_broken_img.jpg')
			{
				$data_array['old_image']=$_POST['section_img'];
			}
		}else{
			$old_image=get_post_meta($_POST['blog_post_id'],'lxed_thumbnail_image',true);
			if($old_image!='')
			{
				$data_array['old_image']=$old_image;
			}
		}
		if(isset($_POST['community_id']))
		{
			$data_array['community_id']=$_POST['community_id'];
		}
		$result = vw_fn_lx_s3_uploaduserwise_assets($data_array);
		/*$url = $result->get('ObjectURL');
		$arr_cnt = array_search("lx-media",explode('/',$url))+2;
		if(!empty(explode('/',$url)[$arr_cnt])){*/
		if(!empty($result)){
			echo $result;
		}
		else{
			echo lx_plugin_url.'assets/img/sample_broken_img.png';
		}
		
		wp_die();
	}
	
	function fn_lx_publish_post(){
		global $color_palette;
		/*echo "<pre>";print_r($_POST);die(); */
		$post_avail_in=$_POST['lx_post_avail_in'];
		/* $community_id=$_POST['lx_community']; */
		/* $category = $_POST['lxed_cat_array']; */
		$main_array = array();
		
		if($post_avail_in == 'in_community'){
			$category = array($_POST['lx_community']);
		}else{
			$category = $_POST['lxed_cat_array'];
		}
		/* echo "<pre>";print_r($category); */
		/* echo "<pre>";print_r($category);die(); */
		
		foreach($_POST['section_ids'] as $section_ids){
			if(!empty($_POST['text_block_array'][$section_ids])){
				$main_array[$section_ids]['text_block_array'][] = $_POST['text_block_array'];
			}
			if(!empty($_POST['img_block_array'][$section_ids])){
				$main_array[$section_ids]['img_block_array'][] = $_POST['img_block_array'];
			}
			if(!empty($_POST['txtonly_img_block_array'][$section_ids])){
				$main_array[$section_ids]['txtonly_img_block_array'][] = $_POST['txtonly_img_block_array'];
			}
			if(!empty($_POST['section_break'][$section_ids])){
				$main_array[$section_ids]['section_break'][] = $_POST['section_break'];
			}
			if(!empty($_POST['txt_imgonly_block_array'][$section_ids])){
				$main_array[$section_ids]['txt_imgonly_block_array'][] = $_POST['txt_imgonly_block_array'];
			}
			if(!empty($_POST['img_textonly_html'][$section_ids])){
				$main_array[$section_ids]['img_textonly_html'][] = $_POST['img_textonly_html'];
			}
			if(!empty($_POST['imgonly_text_html'][$section_ids])){
				$main_array[$section_ids]['imgonly_text_html'][] = $_POST['imgonly_text_html'];
			}
			if(!empty($_POST['video_block_array'][$section_ids])){
				$main_array[$section_ids]['video_block_array'][] = $_POST['video_block_array'];
			}
			if(!empty($_POST['btnblock_label'][$section_ids])){
				$main_array[$section_ids]['btnblock_label'][] = $_POST['btnblock_label'];
				$main_array[$section_ids]['btnblock_desturl'][] = $_POST['btnblock_desturl'];
				$main_array[$section_ids]['btnblock_desc'][] = $_POST['btnblock_desc'];
			}
			if(!empty($_POST['single_ans_opt_q_id_sec'])){
				$i=1;
				foreach($_POST['single_ans_opt_q_id_sec'] as $key=>$section_id){
					if($section_id == $section_ids){
					$main_array[$section_id]['single_ans_res'][$_POST['single_ans_opt_q_id'][$key]]['question'] = $_POST['single_questions_array'][$key];
					$main_array[$section_id]['single_ans_res'][$_POST['single_ans_opt_q_id'][$key]]['ans'][$_POST['single_questions_val_array'][$key]] = $_POST['single_ans_opt_array'][$key];
						/* $main_array[$section_id][$_POST['single_ans_opt_q_id'][$key]]['ans_selected'][$_POST['lxed_single_ans_selected_q'][]] = $_POST['lxed_single_ans_selected_ans'][$_POST['single_ans_opt_q_id'][$key]]; */
					$i++;
					}
				}
				
			}
		}
		/* echo "<pre>";print_r($main_array); */
		$aa = array();
		$i = 0;
		foreach($_POST['lxed_single_ans_selected_sec'] as $key=>$sec){
			$aa[$sec][$_POST['lxed_single_ans_selected_q'][$key]][] = $_POST['lxed_single_ans_selected_ans'][$i];
			$i++;
		}
		
		if(!empty($_POST['blog_format']) && $_POST['blog_format'] == 'news_feed'){
			$html = "<hr style='margin-top:30px !important;margin-bottom:30px !important;color:".$color_palette['grey']."'>";
			foreach($main_array as $section_id=>$main_array_data){
				/* echo "<pre>";print_r($main_array_data); */
				if(!empty($main_array_data['btnblock_label'][0][$section_id])){
					$html .="<div class='rendered_block rend_btn_block pb-4' data-section_id='".$section_id."'>
								<div class='row'>
									<div class='col-md-8 rend_btnblk_desc_".$section_id."'>".$main_array_data['btnblock_desc'][0][$section_id]."</div>
									<div class='col-md-4 text-center'><a class='rend_btnblk_dest_".$section_id."' href='".$main_array_data['btnblock_desturl'][0][$section_id]."'><button type='button' class='btn_normal_state rend_btnblk_btn_".$section_id."'>".$main_array_data['btnblock_label'][0][$section_id]."</button></a></div>
								</div>
							</div>";
				}
				if(!empty($main_array_data['single_ans_res'])){
					ksort($main_array_data['single_ans_res']);
					/* echo "<pre>";print_r($main_array_data); */
					$html .= 
							"<div class='rendered_block rend_single_choice_block' data-section_id='".$section_id."'>";
					foreach($main_array_data['single_ans_res'] as $key1=>$main_array_datas){
						
						$html .= 
							"<div class='row mt-4'>
									<div class='col-md-12 single_choice_questext_dv single_choice_questext_dv".$section_id.$key1."' data-section_id='".$section_id."' data-question_id='".$key1."'>".$main_array_datas['question']."</div></div>";
							foreach($main_array_datas['ans'] as $key=>$main_array_datass){
								if(!empty($main_array_datass)){
									if($key == $aa[$section_id][$key1][0]){
										$class = 'lxed_selected_ans_correct';
										$val = 'correct';
									}else{
										$class = 'lxed_selected_ans_wrong';
										$val = 'wrong';
									}
									$html .=  "<div class='row mt-2'>
												<div class='col-md-1 single_choice_checkbox_dv single_choice_checkbox_dv".$section_id.$key1.$key."' data-section_id='".$section_id."' data-loop_id='".$key."' data-question_id='".$key1."'>
													<input type='radio' name='lxed_front_single_choice_radio".$section_id.$key1."' class='ml-3 ".$class." lxed_front_single_choice_radio lxed_front_single_choice_radio".$section_id.$key.$key1." lxed_front_single_choice_radio".$section_id.$key1."' data-section_id='".$section_id."' data-loop_id='".$key."' data-question_id='".$key1."' value='".$val."' />
												</div>
												<div class='col-md-11 single_choice_anstext_dv single_choice_anstext_dv".$section_id.$key1.$key."' data-section_id='".$section_id."' data-loop_id='".$key."' data-question_id='".$key1."'>"
													.$main_array_datass.
												"</div>
											</div>";
								}
							}
						$html .= "<div class='row'>
										<div class='col-md-1'></div>
										<div class='col-md-11 single_choice_results".$section_id.$key1."'></div>
									</div>
									<div class='row mt-3'>
										<div class='col-md-1'></div>
										<div class='col-md-11'>
										<button class='lxed_check_results' data-section_id='".$section_id."' data-question_id='".$key1."'> check results </button>
										</div>
									</div>";
					}
					$html .=  "</div>";
				}
				
				if(!empty($main_array_data['text_block_array'][0][$section_id])){
					
					$html .=" <div class='rendered_block rend_text_block pb-4' data-section_id='".$section_id."'>
								".$main_array_data['text_block_array'][0][$section_id].
							"</div>";
					
				}
				/* echo "<pre>";print_r($main_array_data);
				die(); */
				if(!empty($main_array_data['section_break'][0][$section_id])){
					
					$html .='<div class="rendered_block lxed_border_bottom break_section pb-4" data-section_id="'.$section_id.'" style="margin-bottom: 20px !important;"></div>';
					
				}
				if(!empty($main_array_data['img_block_array'][0][$section_id])){
					
					$html .=' <div class="rendered_block rend_img_block pb-4" data-section_id="'.$section_id.'" style="text-align:center;">
							<img src="'.$main_array_data['img_block_array'][0][$section_id].'">
							</div>';
					
				}
				if(!empty($main_array_data['txtonly_img_block_array'][0][$section_id]) && !empty($main_array_data['txt_imgonly_block_array'][0][$section_id])){
					$html .='
					<div class="row rendered_block rend_text_img_block pb-4" data-section_id="'.$section_id.'" >
						<div style="padding-left:0px;" class="col-md-6 rend_textonly_img_block rend_textonly_img_block'.$section_id.'">'
							.$main_array_data['txtonly_img_block_array'][0][$section_id].
						'</div>
						<div style="padding:0px;" class="col-md-6 rend_text_imgonly_block rend_text_imgonly_block'.$section_id.'" style="text-align:center;">
						<img src="'.$main_array_data['txt_imgonly_block_array'][0][$section_id].'"></div>
					</div>';
				}
				if(!empty($main_array_data['img_textonly_html'][0][$section_id]) && !empty($main_array_data['imgonly_text_html'][0][$section_id])){
					$html .='
					<div class="row rendered_block rend_img_text_block rend_img_text_block'.$section_id.' pb-4" style="text-align:center;" data-section_id="'.$section_id.'" >
						<div style="padding:0px;" class="col-md-6 rend_imgonly_text_block rend_imgonly_text_block'.$section_id.'">
							<img src="'.$main_array_data['imgonly_text_html'][0][$section_id].'">
						</div>
						<div style="padding-right:0px;" class="col-md-6 rend_img_textonly_block rend_img_textonly_block'.$section_id.'">'
							.$main_array_data['img_textonly_html'][0][$section_id].
						'</div>
					</div>';
					
				}
				if(!empty($main_array_data['video_block_array'][0][$section_id])){
					$html .='
					<div class="row rendered_block rend_video_block rend_video_block'.$section_id.' pb-4" style="text-align:center;" data-section_id="'.$section_id.'" >
						<video class="lxed_vid_block_inpvideo lxed_vid_block_inpvideo'.$section_id.'" style="width:100%;" controls data-section_id="'.$section_id.'">
						  <source class="lxed_vid_block_inpsource lxed_vid_block_inpsource'.$section_id.'" data-section_id="'.$section_id.'" src="'.$main_array_data['video_block_array'][0][$section_id].'" type="video/mp4">
						</video>
					</div>';
				}
			}
			/* echo "<pre>";print_r($main_array);
			die(); */
		}
		/* die(); */
		/* echo "<pre>";print_r($main_array); die(); */
		/* echo "<pre>";print_r($html);
		die(); */
		/* $x_html .= "<div class='main_div'>";
		foreach($main_array as $section_id=>$main_array_data){
			
			if(!empty($main_array_data['section_break'][0][$section_id])){
				
				$x_html  .= "<span> next </span></div><div class='main_div'><span> previous </span>";
				
			}else{
				$x_html .= "<section>html</section>";
			}
		}
		
		echo "<pre>";print_r($x_html);die(); */
		if(!empty($_POST['blog_format']) && $_POST['blog_format'] == 'slide_show'){
			$html .= "<div class='lxed_slide_show_main_div'>";
			foreach($main_array as $section_id=>$main_array_data){
				/* echo "<pre>";print_r($main_array_data); */
				if(!empty($main_array_data['btnblock_label'][0][$section_id])){
					$html .="<div class='rendered_block rend_btn_block pt-4' data-section_id='".$section_id."'>
								<div class='row'>
									<div class='col-md-8 rend_btnblk_desc_".$section_id."'>".$main_array_data['btnblock_desc'][0][$section_id]."</div>
									<div class='col-md-4 text-center'><a class='rend_btnblk_dest_".$section_id."' href='".$main_array_data['btnblock_desturl'][0][$section_id]."'><button type='button' class='btn_normal_state rend_btnblk_btn_".$section_id."'>".$main_array_data['btnblock_label'][0][$section_id]."</button></a></div>
								</div>
							</div>";
				}
				if(!empty($main_array_data['single_ans_res'])){
					ksort($main_array_data['single_ans_res']);
					/* echo "<pre>";print_r($main_array_data); */
					$html .= 
							"<div class='rendered_block rend_single_choice_block pt-4' data-section_id='".$section_id."'>";
					foreach($main_array_data['single_ans_res'] as $key1=>$main_array_datas){
						
						$html .= 
							"<div class='row mt-4'>
									<div class='col-md-12 single_choice_questext_dv single_choice_questext_dv".$section_id.$key1."' data-section_id='".$section_id."' data-question_id='".$key1."'>".$main_array_datas['question']."</div></div>";
							foreach($main_array_datas['ans'] as $key=>$main_array_datass){
								if(!empty($main_array_datass)){
									if($key == $aa[$section_id][$key1][0]){
										$class = 'lxed_selected_ans_correct';
										$val = 'correct';
									}else{
										$class = 'lxed_selected_ans_wrong';
										$val = 'wrong';
									}
									$html .=  "<div class='row mt-2'>
												<div class='col-md-1 single_choice_checkbox_dv single_choice_checkbox_dv".$section_id.$key1.$key."' data-section_id='".$section_id."' data-loop_id='".$key."' data-question_id='".$key1."'>
													<input type='radio' name='lxed_front_single_choice_radio".$section_id.$key1."' class='ml-3 ".$class." lxed_front_single_choice_radio lxed_front_single_choice_radio".$section_id.$key.$key1." lxed_front_single_choice_radio".$section_id.$key1."' data-section_id='".$section_id."' data-loop_id='".$key."' data-question_id='".$key1."' value='".$val."' />
												</div>
												<div class='col-md-11 single_choice_anstext_dv single_choice_anstext_dv".$section_id.$key1.$key."' data-section_id='".$section_id."' data-loop_id='".$key."' data-question_id='".$key1."'>"
													.$main_array_datass.
												"</div>
											</div>";
								}
							}
						$html .= "<div class='row'>
										<div class='col-md-1'></div>
										<div class='col-md-11 single_choice_results".$section_id.$key1."'></div>
									</div>
									<div class='row mt-3'>
										<div class='col-md-1'></div>
										<div class='col-md-11'>
										<button class='lxed_check_results' data-section_id='".$section_id."' data-question_id='".$key1."'> check results </button>
										</div>
									</div>";
					}
					$html .=  "</div>";
				}
				
				if(!empty($main_array_data['text_block_array'][0][$section_id])){
					
					$html .=" <div class='rendered_block rendered_block".$section_id." rend_text_block pt-4' data-section_id='".$section_id."'>
								".$main_array_data['text_block_array'][0][$section_id].
							"</div>";
					
				}
				if(!empty($main_array_data['section_break'][0][$section_id])){
					$html  .= '<div style="display:none;" class="rendered_block break_section rendered_block'.$section_id.' pt-4" data-section_id="'.$section_id.'"></div>
					
					<div class="rendered_lxed_page_breaknext rendered_lxed_page_breaknext'.$section_id.' mt-4"  data-section_id="'.$section_id.'">Next &nbsp;&nbsp;<i class="fas fa-angle-down"></i></div></div>
					
					<div class="lxed_slide_show_main_div"><div class="rendered_lxed_page_breakprev rendered_lxed_page_breakprev'.$section_id.' mt-4" data-section_id="'.$section_id.'">Previous &nbsp;&nbsp;<i class="fas fa-angle-up"></i></div>';
					
				/* 	$html .='<div class="rendered_block break_section rendered_block'.$section_id.' mt-4" data-section_id="'.$section_id.'">
								<div class="rendered_lxed_page_breaknext rendered_lxed_page_breaknext'.$section_id.'"  data-section_id="'.$section_id.'">Next<i class="fas fa-angle-down"></i></div>
								
								<div class="rendered_lxed_page_breakprev rendered_lxed_page_breakprev'.$section_id.'" data-section_id="'.$section_id.'">Previous<i class="fas fa-angle-up"></i></div>
							</div>';
					 */
				}
				/* if(!empty($main_array_data['section_break'][0][$section_id])){
					
					$html .='<div class="rendered_block lxed_border_bottom break_section mt-4" data-section_id="'.$section_id.'"></div>';
					
				} */
				if(!empty($main_array_data['img_block_array'][0][$section_id])){
					
					$html .=' <div class="rendered_block rendered_block'.$section_id.' rend_img_block pt-4" data-section_id="'.$section_id.'" style="text-align:center;">
							<img src="'.$main_array_data['img_block_array'][0][$section_id].'">
							</div>';
					
				}
				if(!empty($main_array_data['txtonly_img_block_array'][0][$section_id]) && !empty($main_array_data['txt_imgonly_block_array'][0][$section_id])){
					$html .='
					<div class="row rendered_block rend_text_img_block pt-4" data-section_id="'.$section_id.'" >
						<div class="col-md-6 rend_textonly_img_block rend_textonly_img_block'.$section_id.'">'
							.$main_array_data['txtonly_img_block_array'][0][$section_id].
						'</div>
						<div class="col-md-6 rend_text_imgonly_block rend_text_imgonly_block'.$section_id.'" style="text-align:center;">
						<img src="'.$main_array_data['txt_imgonly_block_array'][0][$section_id].'"></div>
					</div>';
				}
				if(!empty($main_array_data['imgonly_text_html'][0][$section_id]) && !empty($main_array_data['img_textonly_html'][0][$section_id])){
						$html .='
					<div class="row rendered_block rend_img_text_block rend_img_text_block'.$section_id.' pt-4" style="text-align:center;" data-section_id="'.$section_id.'" >
						<div class="col-md-6 rend_imgonly_text_block rend_imgonly_text_block'.$section_id.'">
							<img src="'.$main_array_data['imgonly_text_html'][0][$section_id].'">
						</div>
						<div class="col-md-6 rend_img_textonly_block rend_img_textonly_block'.$section_id.'">'
							.$main_array_data['img_textonly_html'][0][$section_id].
						'</div>
					</div>';
					
				}
				if(!empty($main_array_data['video_block_array'][0][$section_id])){
					$html .='
					<div class="row rendered_block rend_video_block rend_video_block'.$section_id.' pt-4" style="text-align:center;" data-section_id="'.$section_id.'" >
						<video class="lxed_vid_block_inpvideo lxed_vid_block_inpvideo'.$section_id.' mt-4" style="width:100%;" controls data-section_id="'.$section_id.'">
						  <source class="lxed_vid_block_inpsource lxed_vid_block_inpsource'.$section_id.'" data-section_id="'.$section_id.'" src="'.$main_array_data['video_block_array'][0][$section_id].'" type="video/mp4">
						</video>
					</div>';
				}
			}
			$html .= "</div>";
		}
		
		/* die(); */
		if($_POST['this_click'] == 'Publish' || $_POST['this_click'] == 'Update'){
			$status = 'publish';
		}elseif($_POST['this_click'] == 'Preview' || $_POST['this_click'] == 'Draft'){
			$status = 'draft';
		}
	
		$json_array = array(); 
		if(!empty($_POST['update_post_id'])){
			/** Update **/
			$lxed_blog_post_update = 
									array(
									  'ID'    => $_POST['update_post_id'],
									  'post_title'    => wp_strip_all_tags( $_POST['lxed_post_title'] ),
									  'post_content'  => $html,
									  'post_excerpt'  => $_POST['lxed_blog_post_excerpt'],
									  'post_status'  => $status,
									);
				
			$lxed_blogpost_id = wp_update_post( $lxed_blog_post_update );
			update_post_meta( $_POST['update_post_id'], 'lxed_thumbnail_image', $_POST['lxed_thumbnail_img'] );
			update_post_meta( $_POST['update_post_id'], 'lxede_blog_format', $_POST['blog_format'] );
			
			/* if($_POST['this_click'] == 'Preview' || $_POST['this_click'] == 'Draft'){ */
				if($post_avail_in=='in_community'){
					update_post_meta($lxed_blogpost_id,'community_id', $_POST['lx_community']);
					update_post_meta($lxed_blogpost_id,'display_in',$post_avail_in);
				}else{
					/** Add category to the post **/
					update_post_meta( $lxed_blogpost_id, 'display_in' , $post_avail_in );
					/** End Add category to the post **/
				}
				
			/* } */
		}else{
			/** Insert**/
			$lxed_blog_post_insert = 
									array(
									 'ID' => $_POST['insert_post_id'],
									  'post_title'    => wp_strip_all_tags( $_POST['lxed_post_title'] ),
									  'post_content'  => $html,
									  'post_excerpt'  => $_POST['lxed_blog_post_excerpt'],
									  'post_status'   => $status,
									);
			 wp_update_post( $lxed_blog_post_insert );
			$lxed_blogpost_id =$_POST['insert_post_id'];
			if(!empty($lxed_blogpost_id)){
				add_post_meta( $lxed_blogpost_id, 'lxed_thumbnail_image' , $_POST['lxed_thumbnail_img'] );
				add_post_meta( $lxed_blogpost_id, 'lxede_blog_format' , $_POST['blog_format'] );
				/** Add post in community or public area**/
				if($post_avail_in=='in_community'){
					add_post_meta($lxed_blogpost_id,'community_id', $_POST['lx_community']);
					add_post_meta($lxed_blogpost_id,'display_in',$post_avail_in);
				}else{
					/** Add category to the post **/
					add_post_meta( $lxed_blogpost_id, 'display_in' , $post_avail_in );
					/** End Add category to the post **/
				}
				
				/** End Add post in community or public area **/
			}
		}
		wp_set_post_categories( $lxed_blogpost_id , $category );
		$json_array['msg'] = $_POST['this_click'];
		$json_array['link'] = get_permalink($lxed_blogpost_id);
		$json_array['last_post_id'] = $lxed_blogpost_id;
		
			
		
		echo json_encode($json_array);
		wp_die();
	}
	
	/**
		* @ Rendered Editable Html
		**/
	function fn_lx_editor_rendered(){
		global $wpdb;
		$section_id_array = $_POST['section_ids_array'];
		
		/* echo "<pre>";print_r($_POST['sect_id_array']);
		echo "<pre>";print_r($_POST['question_id_array']);
		 */
		 
		foreach($_POST['sect_id_array'] as $key=>$sec_id){
				
			$sing_choice_main_array[$sec_id][$_POST['question_id_array'][$key]]['ques'] = $_POST['question_text_array'][$key];
			$sing_choice_main_array[$sec_id][$_POST['question_id_array'][$key]]['ans'][] = $_POST['ans_text_array'][$key];
			$sing_choice_main_array[$sec_id][$_POST['question_id_array'][$key]]['ans_feed'][] = $_POST['ans_feedtext_array'][$key];
			$sing_choice_main_array[$sec_id][$_POST['question_id_array'][$key]]['ans_selected'][] = $_POST['ans_selected_array'][$key];
			
		}
		
		/* echo "<pre>";print_r($_POST['rend_img_textonly_block_array']);
		die(); */
		$sing_choice_main_array = array();$sing_sec_idarr = array();
		foreach($section_id_array as $section_id){
			if(!empty($_POST['rand_text_block_array'][$section_id])){
				include (dirname(dirname(__FILE__)).'/template/rendered_block/r_text_only_block.php');
			}
			if(!empty($_POST['rand_img_block_array'][$section_id])){
				include (dirname(dirname(__FILE__)).'/template/rendered_block/r_image_only_block.php');
			}
			if(!empty($_POST['video_block_array'][$section_id])){
				include (dirname(dirname(__FILE__)).'/template/rendered_block/r_video_block.php');
			}
			if(!empty($_POST['rand_break_section'][$section_id])){
				include (dirname(dirname(__FILE__)).'/template/rendered_block/r_section_break_block.php');
			}
			if(!empty($_POST['rend_textonly_img_block_array'][$section_id]) || !empty($_POST['rend_text_imgonly_block_array'][$section_id])){
				include (dirname(dirname(__FILE__)).'/template/rendered_block/r_text_img_block.php');
			}
			if(!empty($_POST['rend_img_textonly_block_array'][$section_id]) || !empty($_POST['rend_imgonly_text_block_array'][$section_id])){
				include (dirname(dirname(__FILE__)).'/template/rendered_block/r_img_text_block.php');
			} 
			if(!empty($_POST['rend_btnblk_label'][$section_id])){
				include (dirname(dirname(__FILE__)).'/template/rendered_block/r_btn_block.php');
			} 
			if(!empty($_POST['sect_id_array'])){
				foreach($_POST['sect_id_array'] as $key=>$sec_id){
					if($sec_id == $section_id){
					 $sing_sec_idarr[$sec_id] = $sec_id;
						$sing_choice_main_array[$sec_id][$_POST['question_id_array'][$key]]['ques'] = $_POST['question_text_array'][$key];
						$sing_choice_main_array[$sec_id][$_POST['question_id_array'][$key]]['ans'][] = $_POST['ans_text_array'][$key];
						$sing_choice_main_array[$sec_id][$_POST['question_id_array'][$key]]['ans_feed'][] = $_POST['ans_feedtext_array'][$key];
						$sing_choice_main_array[$sec_id][$_POST['question_id_array'][$key]]['ans_selected'][] = $_POST['ans_selected_array'][$key];
					}
				}
				if($sing_choice_main_array[$section_id]){
					/* echo "<pre>";print_r($sing_choice_main_array[$section_id]); */
					include (dirname(dirname(__FILE__)).'/template/rendered_block/r_single_choice_question.php');	
				}
				
				/* if(!empty($sing_choice_main_array)){
					
				} */
			}
		}
		
		wp_die();
	}
	function fn_lx_switchto_html(){
		global $wpdb;
		echo str_replace('<a','<a contenteditable="false"',stripslashes_deep($_POST['html']));
		wp_die();
	}
	
	function fn_lx_switchto_editor(){
		global $wpdb;
		echo htmlspecialchars_decode($_POST['html']);
		wp_die();
	}
	function fn_lx_reset_html(){
		global $wpdb;
		echo wp_strip_all_tags($_POST['html']);
		wp_die();
	}

	function fn_lx_delete_section_img(){
		$s3 = vw_lx_s3_uploadto_s3();
		global $s3_settings;
		$bucket=$s3_settings['s3_bucket'];
		$blog_post_id=$_POST['blog_post_id'];
		$section_img=$_POST['section_img'];
		$key=substr($section_img, strpos($section_img, '.au/') + 4); 
		$delete_image=$s3->deleteObject([
	        'Bucket' => $bucket,
	        'Key'    => $key
	    ]);
	    echo "deleted";
		wp_die();
	}

	function fn_lx_delete_folder_from_s3(){
		$s3 = vw_lx_s3_uploadto_s3();
		global $s3_settings;
		$bucket=$s3_settings['s3_bucket'];
		$files=$_POST['uploads'];
		foreach ($files as $file) {
			$key=substr($file, strpos($file, '.au/') + 4); 
			$delete_image=$s3->deleteObject([
		        'Bucket' => $bucket,
		        'Key'    => $key
		    ]);
		}
		if(isset($_POST['blog_post_id']))
		{
			wp_delete_post($_POST['blog_post_id']);
		}
		echo "deleted";
		wp_die();
	}
	function fn_lx_ajax_video_upload_tos3(){
		/* echo $_POST['blog_post_id']; */
		/* echo  */
		$section_id = $_POST['section_id'];
		
		$s3 = vw_lx_s3_uploadto_s3();
		global $s3_settings;
		$bucket=$s3_settings['s3_bucket'];
		
		$file = $_FILES['file'];
		/* echo $_POST['blog_post_id']; */
		$dir='site-assets/blog_post-'.$_POST['blog_post_id'].'/';
		
		/* $upload = $s3->upload($bucket, $dir.$file['name'], fopen($file['tmp_name'], 'rb'), 'public-read'); */
		
		$upload = $s3->putObject(
				array(
					'Bucket' => $bucket,
					'Key' => $dir.$file['name'],
					'SourceFile' => $file['tmp_name'],
					'StorageClass' => 'REDUCED_REDUNDANCY',
					'ACL'  => 'public-read'
				));
				
		/* echo $upload->get('ObjectURL'); */
		?>
		<video class="lxed_vid_block_inpvideo lxed_vid_block_inpvideo<?php echo $section_id;?> mt-4" style="width:100%;" controls data-section_id="<?php echo $section_id;?>">
			  <source class="lxed_vid_block_inpsource lxed_vid_block_inpsource<?php echo $section_id;?>" data-section_id="<?php echo $section_id;?>" src="<?php echo $upload->get('ObjectURL');?>" type="video/mp4">
		</video>

		<?php
		/* echo "<pre>";print_r($upload); */
		wp_die();
	}
	function fn_lx_add_more_single_choice(){
		global $wpdb;
		$section_id = $_POST['section_id'];
		$loop_id = $_POST['loop_id']+1;
		$question_id = $_POST['question_id'];
		?>
		<div class="row mt-4 lxed_single_choice_answeropt_div lxed_single_choice_answeropt_div<?php echo $question_id;?> lxed_single_choice_answeropt_div<?php echo $section_id;?><?php echo $question_id;?> lxed_single_choice_answeropt_div<?php echo $section_id;?><?php echo $question_id;?><?php echo $loop_id;?>">
			<div class="col-md-1">
				<input class="form-check-input lxed_single_answer_radio lxed_single_answer_radio<?php echo $section_id;?><?php echo $question_id;?> mt-2 ml-2" type="radio" name="lxed_single_answer_radio<?php echo $section_id;?><?php echo $question_id;?>" data-question_id="<?php echo $question_id;?>" data-section_id="<?php echo $section_id;?>" id="lxed_single_answer_radio<?php echo $section_id;?><?php echo $question_id;?>" value="<?php echo $loop_id;?>">
			</div>
			<div data-loop_id="<?php echo $loop_id;?>" name="lx_editor_singleans_opt lx_editor_singleans_opt<?php echo $section_id;?>" data-question_id="<?php echo $question_id;?>" data-section_id="<?php echo $section_id;?>" id="lx_editor_singleans_opt<?php echo $section_id;?>" class="lx_editor_singleans_opt lx_editor_singleans_opt<?php echo $section_id;?> lx_editor_singleans_opt<?php echo $section_id;?><?php echo $question_id;?> lxed_inp_css col-md-10">
				<div class="lx_editor_singleans_opt_inner_div" data-question_id="<?php echo $question_id;?>" data-section_id="<?php echo $section_id;?>" >
					<div contenteditable="true" class="lxed_single_chose_answer lxed_single_chose_answer<?php echo $section_id;?><?php echo $question_id;?><?php echo $loop_id;?> lxed_single_chose_answer<?php echo $section_id;?><?php echo $loop_id;?> lx_input_bn" data-val="<?php echo $loop_id;?>" data-loop_id="<?php echo $loop_id;?>" data-question_id="<?php echo $question_id;?>" data-section_id="<?php echo $section_id;?>">Answer Option</div>
					<div contenteditable="true" class="mt-2 lxed_single_chose_feedback lxed_single_chose_feedback<?php echo $section_id;?><?php echo $loop_id;?> lx_input_bn" data-loop_id="<?php echo $loop_id;?>" data-val="<?php echo $loop_id;?>" data-question_id="<?php echo $question_id;?>" data-section_id="<?php echo $section_id;?>">Feedback if this answer is selected</div>
				</div>
			</div>
			<div class="col-md-1">
				<i class="fas fa-trash lxed_font_20 lxed_remove_single_tab" style="cursor:pointer;" data-section_id="<?php echo $section_id;?>" data-question_id="<?php echo $question_id;?>" data-loop_id="<?php echo $loop_id;?>" aria-hidden="true"></i>
			</div>
		</div>
		<?php
		wp_die();
	}
	function fn_lx_add_more_single_choice_questions(){
		global $wpdb;
		$section_id = $_POST['section_id'];
		$total_question = $_POST['total_question'];
		include( dirname(dirname(__FILE__)) .'/template/blocks/single_choice_question_template.php');
		wp_die();
	}
	function lx_delete_blog_post(){
		$post_id=$_POST['post_id'];
		$clicked=$_POST['clicked'];
		if($clicked=='change_as_draft')
		{
			$arg=array(
				'ID'=>$post_id,
				'post_status'=>'draft'
			);
			wp_update_post($arg);
		}else{
			$display_in=get_post_meta($post_id,'display_in',true);
			if($display_in=='in_community')
			{
				$community_id=get_post_meta($post_id,'community_id',true);
				$folder='site-assets/community-'.$community_id.'/blog_post-'.$post_id.'/*';
			}else{
				$folder='site-assets/blog_post-'.$post_id.'/*';
			}
			$s3 = vw_lx_s3_uploadto_s3();
			global $s3_settings;
			$bucket=$s3_settings['s3_bucket'];
			$delete_folder=$s3->deleteObject(['Bucket'=>$bucket, 'Key'=>$folder]);
			if($delete_folder)
			{
				wp_delete_post($post_id);
			}
		}
		echo "deleted";
		wp_die();
	}
	function get_category_blogpost(){
		$term_id=$_POST['term_id'];
		$get_term=get_term_by('id',$term_id,'category');
		?>
		<div class="lx_editor_blog_page">
			<?php			
			$get_postbyterm = lx_get_data::vw_fn_get_postby_termid($term_id,$slug);
			if(count($get_postbyterm)>0)
			{
			?>
			<div class="row mt-2">
			<?php
			foreach( $get_postbyterm as $get_all_posts_data ){
				$post_id = $get_all_posts_data->ID;
				$post_title = $get_all_posts_data->post_title;
				$post_author = $get_all_posts_data->post_author;
				$post_description = $get_all_posts_data->post_excerpt;
				$thumbnail_image = get_post_meta( $post_id , 'lxed_thumbnail_image' )[0];
				$post_status = $get_all_posts_data->post_status;
				$category=$get_term->name;
				global $lx_plugin_path;
				include($lx_plugin_path.'template/blog_post_list.php');
			}
			?>
			</div>
			<?php }else{
				?><div class="row mt-10 justify-content-center">No Blogpost Created In This Category.</div><?php
			} ?>
		</div>
		<?php
		wp_die();
	}
	
	function fn_lx_editor_delete_thumbnail(){
		if(isset($_POST['community_id']))
		{
			$dir='site-assets/community-'.$_POST['community_id'].'/blog_post-'.$_POST['blog_post_id'].'/';
		}else{
			$dir='site-assets/blog_post-'.$_POST['blog_post_id'].'/';
		}
		
		$s3 = vw_lx_s3_uploadto_s3();
		global $s3_settings;
		$bucket=$s3_settings['s3_bucket'];
		$old_image =get_post_meta($_POST['blog_post_id'],'lxed_thumbnail_image',true);
		if(isset($old_image))
		{
			$thumb=basename($old_image);
			$file=$dir.$thumb;
			$delete_image=$s3->deleteObject([
				'Bucket' => $bucket,
				'Key'    => $file
			]);
			
		}
		update_post_meta($_POST['blog_post_id'],'lxed_thumbnail_image',null); 
		echo "deleted";
		die();
	}
}