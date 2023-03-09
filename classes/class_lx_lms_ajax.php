<?php
class lx_lms_ajax{
	public function __construct() {
		/** fn_lx_lms_user_interface **/
		add_action("wp_ajax_fn_lx_lms_user_interface", array($this,"fn_lx_lms_user_interface"),10);
		add_action( 'wp_ajax_nopriv_fn_lx_lms_user_interface', array($this,'fn_lx_lms_user_interface'),10);
		add_action("wp_ajax_fn_general_site_settings", array($this,"fn_general_site_settings"),20);
		add_action( 'wp_ajax_nopriv_fn_general_site_settings', array($this,'fn_general_site_settings'),20);
		add_action("wp_ajax_fn_upload_logo_thumb", array($this,"fn_upload_logo_thumb"),20);
		add_action( 'wp_ajax_nopriv_fn_upload_logo_thumb', array($this,'fn_upload_logo_thumb'),20);
		add_action("wp_ajax_fn_upload_logo_favicon_thumb", array($this,"fn_upload_logo_favicon_thumb"),20);
		add_action( 'wp_ajax_nopriv_fn_upload_logo_favicon_thumb', array($this,'fn_upload_logo_favicon_thumb'),20);
		add_action("wp_ajax_fn_lx_lms_layout_template_setting",array($this,'fn_lx_lms_layout_template_setting'),20);
		add_action('wp_ajax_nopriv_fn_lx_lms_layout_template_setting', array($this,'fn_lx_lms_layout_template_setting'),20);
		add_action('wp_ajax_fn_filter_course_selection',array($this,'fn_filter_course_selection'),20);
		add_action('wp_ajax_nopriv_fn_filter_course_selection', array($this,'fn_filter_course_selection'),20);
		add_action('wp_ajax_fn_lx_lms_lexicon_setting',array($this,'fn_lx_lms_lexicon_setting'),20);
		add_action('wp_ajax_nopriv_fn_lx_lms_lexicon_setting',array($this,'fn_lx_lms_lexicon_setting'),20);
		add_action('wp_ajax_view_more_articulate_content',array($this,'view_more_articulate_content'),20);
		add_action('wp_ajax_nopriv_view_more_articulate_content',array($this,'view_more_articulate_content'),20);
		add_action("wp_ajax_fetch_content_body", array($this,"fetch_content_body"));
		add_action('wp_ajax_nopriv_fetch_content_body', array($this,'fetch_content_body'));
		add_action("wp_ajax_certificate_template_upload",array($this,'certificate_template_upload'),20);
		add_action('wp_ajax_nopriv_certificate_template_upload',array($this,'certificate_template_upload'),20);
		add_action("wp_ajax_delete_certificate_template",array($this,'delete_certificate_template'),20);
		add_action('wp_ajax_nopriv_delete_certificate_template',array($this,'delete_certificate_template'),20);
		add_action('wp_ajax_save_s3_settings_data',array($this,'save_s3_settings_data'));
		add_action('wp_ajax_nopriv_save_s3_settings_data',array($this,'save_s3_settings_data'));
		add_action('wp_ajax_save_lrs_data',array($this,'save_lrs_data'));
		add_action('wp_ajax_nopriv_save_lrs_data',array($this,'save_lrs_data'));
		add_action('wp_ajax_test_s3_connection',array($this,'test_s3_connection'));
		add_action('wp_ajax_nopriv_test_s3_connection',array($this,'test_s3_connection'));
		add_action('wp_ajax_lrs_test_connection',array($this,'lrs_test_connection'));
		add_action('wp_ajax_nopriv_lrs_test_connection',array($this,'lrs_test_connection'));
		add_action('wp_ajax_lx_plugin_health_check',array($this,'lx_plugin_health_check'));
		add_action('wp_ajax_nopriv_lx_plugin_health_check',array($this,'lx_plugin_health_check'));
		add_action('wp_ajax_save_login_settings',array($this,'save_login_settings'));
		add_action('wp_ajax_nopriv_save_login_settings',array($this,'save_login_settings'));
		
		/** Setting for developertool on/off **/
		add_action('wp_ajax_change_dev_tools_mode',array($this,'change_dev_tools_mode'));
		add_action('wp_ajax_nopriv_change_dev_tools_mode',array($this,'change_dev_tools_mode'));
		
		add_action('wp_ajax_fnajaxsavepluginupdatekey',array($this,'fnajaxsavepluginupdatekey'));
		add_action('wp_ajax_nopriv_fnajaxsavepluginupdatekey',array($this,'fnajaxsavepluginupdatekey'));
		
		add_action('wp_ajax_savexapidata',array($this,'savexapidata'));
		add_action('wp_ajax_nopriv_savexapidata',array($this,'savexapidata'));
	}

	/************Save all general settings*************/
	function fn_general_site_settings(){
		/****Save Additional Settings****/
		save_additional_settings($_POST['ad_setting']);

		/****Save Base64 Settings****/
		save_base64_settings($_POST['base64_encode']);
		die();
	}

	public function fn_lx_lms_user_interface(){
		
		/****Save Color Settings****/
		save_color_settings($_POST['color']);

		/****Save Font Settings****/
		save_font_settings($_POST['font']);

		/****Save Iconography settings****/
		save_icon_settings($_POST['icon']);

		/****Save Button Styling****/
		save_buttons_styling($_POST['buttons']);
		
		/** flipicons save **/
		$flip_audio_recording = !empty( $_POST['flipicon']['audio_recording'] ) ? $_POST['flipicon']['audio_recording'] : 'fas fa-microphone-lines' ;
		$flip_text = !empty( $_POST['flipicon']['text'] ) ? $_POST['flipicon']['text'] : 'fas fa-font-case';
		$flip_images = !empty( $_POST['flipicon']['images'] ) ? $_POST['flipicon']['images'] : 'fas fa-images';
		$flip_360_image = !empty( $_POST['flipicon']['360_image'] ) ? $_POST['flipicon']['360_image'] : 'fas fa-360-degrees';
		$flip_video = !empty( $_POST['flipicon']['video'] ) ? $_POST['flipicon']['video'] : 'fas fa-video';
		$flip_attachment = !empty( $_POST['flipicon']['attachment'] ) ? $_POST['flipicon']['attachment'] : 'fas fa-paperclip';
		$flip_play = !empty( $_POST['flipicon']['play'] ) ? $_POST['flipicon']['play'] : 'far fa-circle-play';
		$flip_pause = !empty( $_POST['flipicon']['pause'] ) ? $_POST['flipicon']['pause'] : 'far fa-circle-pause';
		$flip_uploadtocloud = !empty( $_POST['flipicon']['uploadtocloud'] ) ? $_POST['flipicon']['uploadtocloud'] : 'fas fa-cloud-arrow-up';
		$flip_fullsceenon = !empty( $_POST['flipicon']['fullsceenon'] ) ? $_POST['flipicon']['fullsceenon'] : 'far fa-up-right-and-down-left-from-center';
		$flip_fullsceenoff = !empty( $_POST['flipicon']['fullsceenoff'] ) ? $_POST['flipicon']['fullsceenoff'] : 'far fa-down-left-and-up-right-to-center';
		
		$flip_reply = !empty( $_POST['flipicon']['reply'] ) ? $_POST['flipicon']['reply'] : 'far fa-comment-plus';
		$flip_responses = !empty( $_POST['flipicon']['responses'] ) ? $_POST['flipicon']['responses'] : 'far fa-comments';
		$flip_navigation_left = !empty( $_POST['flipicon']['navigation_left'] ) ? $_POST['flipicon']['navigation_left'] : 'far fa-chevron-left';
		$flip_navigation_right = !empty( $_POST['flipicon']['navigation_right'] ) ? $_POST['flipicon']['navigation_right'] : 'far fa-chevron-right';
		
		$flipicons_array = array(
			'audio_recording'=>$flip_audio_recording,
			'text'=>$flip_text,
			'images'=>$flip_images,
			'360_image'=>$flip_360_image,
			'video'=>$flip_video,
			'attachment'=>$flip_attachment,
			'play'=>$flip_play,
			'pause'=>$flip_pause,
			'uploadtocloud'=>$flip_uploadtocloud,
			'fullsceenon'=>$flip_fullsceenon,
			'fullsceenoff'=>$flip_fullsceenoff,
			'reply'=>$flip_reply,
			'responses'=>$flip_responses,
			'navigation_left'=>$flip_navigation_left,
			'navigation_right'=>$flip_navigation_right,
		);
		update_option( 'flipicons',$flipicons_array );
	}
	public function fn_lx_lms_layout_template_setting(){

		/****Save Menu Settings****/
		save_menu_settings($_POST['menu']);

		/****Save Page Settings****/
		if(function_exists('save_page_setting_pro')){
			save_page_setting_pro($_POST['page']);
		}
		save_page_settings($_POST['page']);

		/****Save Tiles Settings****/
		save_tiles_settings($_POST['tiles']);

		/****Save Iframe Content Settings****/
		save_iframe_content_settings($_POST['lightbox']);
		
		update_option( 'breakpoint_exclude', $_POST['excludebreakpoint'] );
		
		die();
	}
	
	/****save lexicon Settings****/
	public function fn_lx_lms_lexicon_setting(){
		save_lexicon_settings($_POST['lexicon']);
		die;
	}
	
	/**** upload logo thumbnail ****/
	function fn_upload_logo_thumb(){
		global $site_logo,$s3_settings;
		$error = '';
		$filename=$_FILES['thumb']['name'];
		$fileExt = explode('.', $filename)[1];
		if((!empty($_FILES["thumb"])) && ($_FILES["thumb"]["error"] == 0)){
	        if($fileExt != "jpg" && $fileExt != "jpeg" && $fileExt != "png" && $fileExt != "gif"){
	            $error = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
	        }
	    }else{
	        $error = "Select an image file to upload.";
	    } 
		if($error){
			$data=['status'=>"0",'msg'=>$error];
			echo json_encode($data);
			die();
		}
		$data = file_get_contents($_POST['dataurl']);
		$url = wp_upload_dir()['url'].'/'.$filename;
		$path = wp_upload_dir()['path'].'/'.$filename;
		$upload =file_put_contents($path, $data);
		$attachment = array(
			'post_mime_type' => $_FILES['thumb']['type'],
			'post_title' => preg_replace( '/.[^.]+$/','', basename( $filename ) ),
			'post_content' =>'',
			'post_status' => 'inherit',
			'guid' => $path
		);
		$upload_site_logo_id = wp_insert_attachment( $attachment,$path );
		if(!empty($upload_site_logo_id)){
			$attachment_site_logo_data = wp_generate_attachment_metadata( $upload_site_logo_id, $path );
			wp_update_attachment_metadata( $upload_site_logo_id, $path );
			update_post_meta($upload_site_logo_id,'_wp_attachment_context','custom-logo');
			set_theme_mod('custom_logo',$upload_site_logo_id);
		}
		$current_theme=strtolower(get_option('current_theme',true));
		$content=array(
			$current_theme.'::custom_logo' => array(
				'value' =>$upload_site_logo_id,
				'type' => 'theme_mod',
				'user_id'=> get_current_user_id(),
				'date_modified_gmt'=>date('Y-m-d H:i:s')
			)
		);
		$customize=array(
			'post_content' =>json_encode($content),
			'post_status' => 'trash',
			'post_type'=> 'customize_changeset',
			'post_name'=> 'site_logo_data',
		);
		$insert=wp_insert_post($customize);
		update_post_meta($insert,'_wp_trash_meta_status','publish');
		$data=['status'=>"1",'msg'=>"Uploaded"];
		echo json_encode($data);
		die();
	}
	
	/**** upload logo favicon thumbnail ****/
	function fn_upload_logo_favicon_thumb(){
		global $s3_settings;
		$error = '';
		
		$filename=$_FILES['favicon']['name'];
		$fileExt = explode('.', $filename)[1];
		if((!empty($_FILES["favicon"])) && ($_FILES["favicon"]["error"] == 0)){
	        if($fileExt != "jpg" && $fileExt != "jpeg" && $fileExt != "png" && $fileExt != "gif"){
	            $error = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
	        }
	    }else{
	        $error = "Select an image file to upload.";
	    } 
		if($error){
			$data=['status'=>"0",'msg'=>$error];
			echo json_encode($data);
			die();
		}
		$data = file_get_contents($_POST['dataurl']);
		
		$url = wp_upload_dir()['url'].'/'.$filename;
		$path = wp_upload_dir()['path'].'/'.$filename;
		$upload =file_put_contents($path, $data);
		$attachment = array(
			'post_mime_type' => $_FILES['favicon']['type'],
			'post_title' => preg_replace( '/.[^.]+$/','', basename( $filename ) ),
			'post_content' =>'',
			'post_status' => 'inherit',
			'guid' => $path
		);
		$upload_site_icon_id = wp_insert_attachment( $attachment,$path );
		
		if(!empty($upload_site_icon_id)){
			$attachment_site_icon_data = wp_generate_attachment_metadata( $upload_site_icon_id, $path );
			wp_update_attachment_metadata( $upload_site_icon_id, $path );
			update_post_meta($upload_site_icon_id,'_wp_attachment_context','site-icon');
			update_option('site_icon',$upload_site_icon_id);
		}
		/* echo "<pre>";print_r($upload_site_icon_id);
		die(); */
		$content=array(
				'site_icon' => array(
				'value' =>$upload_site_icon_id,
				'type' => 'option',
				'user_id'=> get_current_user_id(),
				'date_modified_gmt'=>date('Y-m-d H:i:s')
			)
		);
		$customize=array(
			'post_content' =>json_encode($content),
			'post_status' => 'trash',
			'post_type'=> 'customize_changeset',
			'post_name'=> 'site_icon_data',
		);
		$insert=wp_insert_post($customize);
		update_post_meta($insert,'_wp_trash_meta_status','publish');
		$data=['status'=>"1",'msg'=>"Uploaded",'path'=>$path];
		echo json_encode($data);
		die();
	}
	
	/**** for view more articulate content ****/
	public function view_more_articulate_content(){
		global $color_palette,$square_icon,$breakpoint,$page_style,$lx_lms_plugin_path;
		$last_show=$_POST['last_show'];
		$term_id=$_POST['term_id'];
		$total_content=$_POST['total_content'];
		$posts=get_posts(
			array(
				'post_type' => 'lx_articulate',
				'post_status' => 'publish',
				'posts_per_page' => 4,
				'offset' => $last_show,
				'category'=>$term_id
			)
		);
		$i=$last_show+1;
		$ctr=$last_show;
		$ctrn='';
		$main_cnt[]='';
		foreach ($posts as $post) {
			if($ctr == $last_show+3){
				$ctrn .= $ctr+1;
			}
			$main_cnt[] = $ctr;
			include($lx_lms_plugin_path.'/template/tiles/articulate_tile.php');
			$i++;
			$ctr++;
		}
		if(count($main_cnt) < 3 || $ctr==$total_content){}else{
		$plus=$total_content-$ctrn;
		?>
			<div class="col-md-3 mt-5 more_btn_div">
				<span><i class="fa fa-plus" style="color: <?php echo $color_palette['charcoal'];?>"></i> <?php echo $plus;?></span>
			    <button class="btn_normal_state view_more_articulate" data-last_show="<?php echo $ctrn;?>" data-term_id="<?php echo $term_id;?>" data-total_content="<?php echo $total_content;?>" style="width:50%;">View</button>
			</div>
		<?php } 
		die;
	}
	
	/**** for fetch articulate content ****/
	function fetch_content_body(){
		global $wpdb,$lx_lms_settings;
		$content_id=$_POST['content_id'];
		$author_id=get_post($content_id)->post_author;
		$content_type = $_POST['content_type'];
		if($content_type == 'articulate_web'){
			$content=get_post_meta($content_id,'web_url',true);
			if (strpos($content,'youtube') !== false) {
				$temp = explode('?',$content)[1];
				parse_str($temp,$cus_arr);
				$content= "https://www.youtube.com/embed/".$cus_arr['v'];
			}
			
			echo "<object data='".$content."' width='100%' height='500px' type='text/html'></object>";
			/* echo "<iframe src='".$content."' width='100%' height='500px'></iframe>"; */
		} else if(isset($_POST['ctype']) && $_POST['ctype']=='lx_articulate'){
			$content=get_post_meta($content_id,'xapi_content',true)['launch_path'];
			echo "<object data='".$content."' width='100%' height='500px' type='text/html'></object>";
			/* echo "<iframe src='".$content."' width='100%' height='500px'></iframe>"; */
		}else{
			if(is_user_logged_in()){
				$is_purchased=false;
				$user_id=get_current_user_id();
				$course_id=get_post_meta($content_id,'course_id',true);
				$community_id=get_post_meta($course_id,'community_id',true);
				$enrolled_course=get_user_meta($user_id,'course_paid',true);
				$cost = get_post_meta( $course_id,'lx_course_cost',true);
				if($lx_lms_settings['course_purchasing_settings']=='on' && !empty($enrolled_course) && in_array($course_id,$enrolled_course)){
					$is_purchased=true;
				}else{
					if($author_id==$user_id){
						$is_purchased=true;
					}else{
						$micro_course_purchased=array();
						$course_purchased=check_lx_course_order_exists($course_id,$user_id);
						$macro_course_id=get_post_meta($course_id,'lx_associated_macro_course',true);
						if($macro_course_id != 0 && !empty($macro_course_id)){
							$micro_course_purchased = check_lx_course_order_exists($macro_course_id,$user_id);
						}
						if(!empty($community_id)){
							$member=$wpdb->get_results('select memberships from '.$wpdb->prefix.'mepr_members where user_id='.$user_id);
							$membership=explode(',',$member[0]->memberships);
							if(in_array($community_id, $membership) && $lx_lms_settings['course_purchasing_settings']=='on')
							{
								if(!empty($course_purchased) || empty($cost)){
									$is_purchased=true;
								}else{
									if(isset($micro_course_purchased) && !empty($micro_course_purchased)){
										$is_purchased=true;
									}
								}
							}elseif(in_array($community_id, $membership) && $lx_lms_settings['course_purchasing_settings']!='on'){
								$is_purchased=true;
							}else{
								$is_purchased=false;
							}
						}else{
							if($lx_lms_settings['course_purchasing_settings']=='on' &&!empty($course_purchased)){
								$is_purchased=true;
							}elseif($lx_lms_settings['course_purchasing_settings']=='on' && isset($micro_course_purchased) && !empty($micro_course_purchased)){
									$is_purchased=true;
							}elseif($lx_lms_settings['course_purchasing_settings']!='on'){
								$is_purchased=true;
							}
						}
					}
				}
				if(!$is_purchased){
					echo "Please Purchase course";
					die();
				}
				
				$content_type = get_post_meta($content_id,'content_type',true);
				$contentActivityId = get_post_meta($content_id,'xapi_activity_id',true); 
				if($content_type!='' && $content_type == 'poll'){
					if(get_user_meta($user_id,'lx_lesson_progress_'.$content_id,true)=='')
					{
						update_user_meta($user_id,'lx_lesson_progress_'.$content_id,'in_progress');
						update_user_meta($user_id,'lx_lesson_progress_date_'.$content_id,array('start_timestamp'=>time()));
					}
				}else{
					if(get_user_meta($user_id,'lx_lesson_progress_'.$contentActivityId,true)=='')
					{
						update_user_meta($user_id,'lx_lesson_progress_'.$contentActivityId,'in_progress');
						update_user_meta($user_id,'lx_lesson_progress_date_'.$contentActivityId,array('start_timestamp'=>time()));
					}
				}	
				
				if($content_type!='' && $content_type == 'poll'){
					$post_id=$content_id;
					$data_main="content_body";
					include ( POLLCOURESEPATH . '/assets/css/pollcourse_css.php' );
	                include POLLCOURESEPATH.'/templates/pollcourse_content.php';
				}else{
					$content_data=get_post_meta($content_id,'xapi_content',true);
					$activity_id=$content_data['activity_id'];
					$launch_url=$content_data['launch_path'];
					echo do_shortcode('[vw_xapi_content lesson_id="'.$content_id.'" url="'.$launch_url.'" activity_id="'.$activity_id.'" open_in="lightbox"]');
				}
			}else{
				?>
				<div style="width: 100%;text-align: center;">
					<a class="btn_normal_state" href="<?php echo site_url().'/login';?>">Login / Register</a>
				</div>
				<?php
			}
		}
		die();
	}
	
	/**** for upload certificate template ****/
	function certificate_template_upload(){
		$filename = $_FILES['upload_certificates_template']['name'];
		$url = wp_upload_dir()['url'].'/'.$filename;
		$path = wp_upload_dir()['path'].'/'.$filename;
		$upload =file_put_contents($path, $data);
		$arr=array(
			'files' => $_FILES['upload_certificates_template'],
			'path' => $path
		);
		$old_image['original'] = get_option('lx_lms_certificate_setting');
		$arr['old_image']=$old_image;
		$upload_thumb=upload_certificate_template($arr);
		update_option('lx_lms_certificate_setting',$upload_thumb['original']);
		unlink($path);
		$certi=explode('.',basename($upload_thumb['original']));
		$fname=substr($certi[0],0,-(strlen($certi[0])-strpos($certi[0], '_lx_cert'))).'.'.$certi[1];
		$upload_info = array('upload_thumb'=>$upload_thumb,'file_name'=>$fname);
		echo json_encode($upload_info); 
		$bgpath = wp_upload_dir()['path'].'/'.$filename;
		$bgurl = wp_upload_dir()['url'].'/'.$filename;
		if( move_uploaded_file($_FILES["upload_certificates_template"]["tmp_name"], $path) ){
			update_option('lx_lms_certificate_bg_img',$url);
		}
		die;
	}
	
	/**** for delete certificate template ****/
	function delete_certificate_template(){
		$s3 = vw_lx_s3_uploadto_s3();
		global $s3_settings;
		$bucket=$s3_settings['s3_bucket'];
		$dir='site-assets/certificate_template/';
		$old_thumb['original']=get_option('lx_lms_certificate_setting');
		if(isset($old_thumb))
		{
			foreach($old_thumb as $image) {
				$thumb=basename($image);
				$file=$dir.$thumb;
				$delete_image=$s3->deleteObject([
					'Bucket' => $bucket,
					'Key'    => $file
				]);
			}
		}
		update_option('lx_lms_certificate_setting',null);
		echo "deleted";
		die;
	}
	/*
	* ajax callback for save s3 configuration
	*/
	public function save_s3_settings_data(){
		$s3_production=array(
			's3_bucket'=>$_POST['s3']['pv_bucket'],
			's3_key'=>$_POST['s3']['pv_key'],
			's3_access'=>$_POST['s3']['pv_access'],
			's3_region'=>$_POST['s3']['s3_region']
		);
		$s3_stagging=array(
			's3_bucket'=>$_POST['s3']['sv_bucket'],
			's3_key'=>$_POST['s3']['sv_key'],
			's3_access'=>$_POST['s3']['sv_access']
		);
		update_option('s3_staging_setting',$s3_stagging);
		update_option('s3_production_setting',$s3_production);
		update_option( 'user_interface_s3_settings', $s3_production );
		echo "saved";
		die;
	}

	/*
	* ajax callback for save Learning Locker LRS configuration
	*/
	public function save_lrs_data(){
		$lrs_data=$_POST['locker'];	
		$lrs_production=array(
			'end_point' => $lrs_data['pv_end_point'],
			'auth_key' => $lrs_data['pv_auth_key'],
			'auth_secret' => $lrs_data['pv_auth_secret'],
			'basic_auth' =>  $lrs_data['pv_basic_auth']
		);
		$lrs_staging=array(
			'end_point' => $lrs_data['sv_end_point'],
			'auth_key' => $lrs_data['sv_auth_key'],
			'auth_secret' => $lrs_data['sv_auth_secret'],
			'basic_auth' =>  $lrs_data['sv_basic_auth']
		);
		update_option('lrs_production_settings',$lrs_production);
		update_option('lrs_staging_settings',$lrs_staging);
		update_option('lx_lms_learning_locker_setting',$lrs_production);
		die;
	}

	/**** for test s3 bucket connection ****/
	function test_s3_connection(){
		$region = 'ap-southeast-2';
		if( !empty($_POST['region']) ){
			$region = $_POST['region'];
		}
		$data=array(
			'bucket'=>$_POST['bucket'],
			'key'=>$_POST['key'],
			'secret'=>$_POST['access'],
			'region'=>$region
		);
		$connect=s3_test_connection($data);
		if($connect){
			echo json_encode(array('msg'=>'Connection Successful','color'=>'green'));
		}else{
			echo json_encode(array('msg'=>'Connection Failed','color'=>'red'));
		}
		die;
	}
	
	/**** for test lrs connection ****/
	function lrs_test_connection(){
		$endpoint=$_POST['end_point'];
		if(substr($endpoint,-1)!='/'){
			$endpoint=$endpoint.'/';
		}
		$auth=$_POST['basic_auth'];
		$bauth=str_replace(' ','%20',$auth);
		if($bauth==$_POST['bauth']){
			$postdata=array(
				"actor"=>array("mbox"=>"mailto:test@gmail.com"),
				"verb"=> array( "id"=> "http://www.example.org/verb" ),
				"object"=>array("id"=>"http://www.example.org/activity" )
			);
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $endpoint.'statements',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>json_encode($postdata),
			  CURLOPT_HTTPHEADER => array(
			  	'Content-Type: application/json',
	    		'X-Experience-API-Version: 1.0.3',
			    'Authorization:'.$auth
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			if(empty(json_decode($response))){
				echo json_encode(array('msg'=>'Connection Failed','color'=>'red'));
			}else{
				echo json_encode(array('msg'=>'Connection Successful','color'=>'green'));
			}
		}else{
			echo json_encode(array('msg'=>'Client Key or Client Secret invalid','color'=>'red'));
		}
		die;
	}
	
	/**** for lx plugin health check ****/
	function lx_plugin_health_check(){
		require dirname(dirname(dirname(__FILE__))).'/plugin-update-checker/plugin-update-checker.php';
		$plugins=$_POST['plugins'];
		$not_installed=array();$pagemissing=array();$ok=array();$version=array();
		foreach ($plugins as $plugin) {
			if($plugin='lx_login'){
				$slug='lx-login';
			}else{
				$slug=$plugin;
			}
			if(is_plugin_active($plugin.'/'.$slug.'.php')){
				$plugindata=get_plugin_data(dirname(dirname( dirname(__FILE__))).'/'.$plugin.'/'.$plugin.'.php');
				$current_version=$plugindata['Version'];
				if($plugin=='learningx_lms_lite'){
					$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
					    'https://github.com/dev-divers1fy/learningx-lite/',
					    __FILE__,
					    'learningx_lms_lite'
					);
					$myUpdateChecker->setBranch('master');
					$myUpdateChecker->setAuthentication('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');
					$check=$myUpdateChecker->checkForUpdates();
					$newversion=$check->version;
					$pages=array(
						'Course' => get_page_by_path('create-courses'), 
						'Add xAPI Content'	=> get_page_by_path('create-xapi-content'),
						'Create Articulate Content' => get_page_by_path('create-articulate-content'),
						'My Account'=>get_page_by_path('my-account')
					);
					foreach ($pages as $name => $path) {
						if(!$path)
						{
							$missing[$plugin][]=$name;
						}
					}
					if($newversion!='' && $newversion>$current_version){
						$version[]=$plugin;
					}elseif(isset($missing) && !empty($missing)){
						$pagemissing[$plugin]=implode(',', $missing[$plugin]);
					}elseif(!is_plugin_active('lx_login/lx-login.php')){
						$not_installed[$plugin][]='Lx Login';
					}else{
						$ok[]=$plugin;
					}
				}
				if($plugin=='learningx_lms_pro'){
					$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
					     'https://github.com/dev-divers1fy/learningx-professional',
					    __FILE__,
					    'learningx_lms_pro'
					);
					$myUpdateChecker->setBranch('master');
					$myUpdateChecker->setAuthentication('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');
					$check=$myUpdateChecker->checkForUpdates();
					$newversion=$check->version;
					$pages=array(
						'Community' => get_page_by_path('create-community'), 
						'User Management'	=> get_page_by_path('user-management'),
						'My Data' => get_page_by_path('my-data')
					);
					foreach ($pages as $name => $path) {
						if(!$path)
						{
							$missing[$plugin][]=$name;
						}
					}
					if($newversion!='' && $newversion>$current_version){
						$version[]=$plugin;
					}elseif(isset($missing) && !empty($missing)){
						$pagemissing[$plugin]=implode(',', $missing[$plugin]);
					}else if(!is_plugin_active('memberpress/memberpress.php')){
						$not_installed[$plugin][]='MemberPress';
					}else{
						$ok[]=$plugin;
					}
				}
				if($plugin=='lx_login')
				{
					$pages=array(
						'Login' => get_page_by_path('login'), 
						'Join Next Step'	=> get_page_by_path('join-next-step'),
						'Email Verifiction' => get_page_by_path('email-verification'),
						'Resend Verification'=>get_page_by_path('resend-verification-link')
					);
					foreach ($pages as $name => $path) {
						if(!$path)
						{
							$missing[$plugin][]=$name;
						}
					}
					if(isset($missing) && !empty($missing)){
						$pagemissing[$plugin]=implode(',', $missing[$plugin]);
					}else{
						$ok[]=$plugin;
					}
				}
			}else{
				$not_installed[$plugin][]=$plugin;
			}
		}
		update_option('last_checked_plugin_health_time',time());
		$data=array('pagemissing' =>$pagemissing ,'okplugin'=>$ok,'not_installed'=>$not_installed,'versioncheck'=>$version );
		echo json_encode($data);
		die;
	}
	
	public function save_login_settings(){
		$post=$_POST['login_setting'];
		$subject=$post['email_subject'];
		$from_email=$post['from_email'];
		
		$site_key=$post['site_key'];
		$secret_key=$post['secret_key'];
		$body=stripslashes( $_POST['email_body_tinymce'] );
		if($post['google_login']=='on')
		{
			$google_login='on';
		}else{
			$google_login='off';
		}
		$login_option = array(
			'email_subject' => $subject, 
			'from_email' => $from_email, 
			'email_body' => $body,
			'google_login' => $google_login,
			'site_key' => $site_key,
			'secret_key' => $secret_key,
			'logintimeout' => $_POST['logintimeout']
		);
		update_option('lx_lms_login_setting',$login_option);
		
		$login_toaoption = array(
			'lms_toa_toggle' => $_POST['login_toa_settings']['toa_toggle'], 
			'lms_toa_label' => $_POST['login_toa_settings']['lms_toa_label'], 
			'lms_toa_agreeurl' => $_POST['login_toa_settings']['lms_toa_agreeurl'],
			'lms_toa_privacylabel' => $_POST['login_toa_settings']['lms_toa_privacylabel'],
			'lms_toa_privacyurl' => $_POST['login_toa_settings']['lms_toa_privacyurl'],
			'lms_toa_warningprompt' => $_POST['login_toa_settings']['lms_toa_warningprompt']
		);
		update_option('lx_lms_login_toasetting',$login_toaoption);
		die;
	}
	/*
	* function for update developer tools options
	*/
	function change_dev_tools_mode(){
		$dev_tool=$_POST['dev_tools'];
		if($dev_tool=='on'){
			update_option('developer_tools',$dev_tool);
		}else{
			update_option('developer_tools',$dev_tool);
		}
		echo "Updated";
		die;
	}
	
	function fnajaxsavepluginupdatekey(){
		$github_key = $_POST['githubkey'];
		update_option('github_key',$github_key);
		echo "Updated";
		die;
	}
	
	function savexapidata(){
		global $wpdb;
		$user_id = get_current_user_ID();
		$activityid = $_POST['activity'];
		$lesson_id=$_POST['lesson_id'];
		$endtime = strtotime($_POST['endtime']);
		
		$get_prog = get_user_meta( $user_id,'lx_lesson_progress_'.$activityid,true);
		if( $get_prog == 'in_progress' ){
			$stamp = get_user_meta( $user_id ,'lx_lesson_progress_date_'.$activityid,true );
			$stampupdate['start_timestamp'] = $stamp['start_timestamp'];
			$stampupdate['end_timstamp'] = $endtime;
			update_user_meta( $user_id ,'lx_lesson_progress_'.$activityid , 'completed' );
			update_user_meta( $user_id ,'lx_lesson_progress_date_'.$activityid , $stampupdate );
		}
		
		/** Create lead on content completion **/
		$webooksettings = get_option('currentwebhookon',true);
		if( $webooksettings['content'] == 1 ){
			$is_content_webhookexist = $wpdb->get_results("select * from ".$wpdb->prefix."vw_contentwebhook_master where contentid='".$lesson_id."'");
			if( $is_content_webhookexist[0]->act_completed == 1 ){
				$salesforcesetting = get_option('salesforce_environment',true);
				$apis = array_values( $salesforcesetting[$salesforcesetting['environment']] );
				$Auth = SFAPIAuthentication( $apis );
				$auth_token = json_decode( $Auth )->access_token;
				$instance_url = json_decode( $Auth )->instance_url;
				$authenticationar = array('auth_token'=>$auth_token,'instance_url'=>$instance_url);
				$contenttitle = get_post($lesson_id)->post_title;
				$crs_id = get_post_meta($lesson_id,'course_id',true);
				$coursetitle = get_post($crs_id)->post_title;
				$comid = get_post_meta($crs_id,'lx_attach_this_course',true);
				$commtitle = get_post($comid)->post_title;
				
				$payload_array['Email__c'] = get_userdata($user_id)->user_email;
				$payload_array['FirstName'] = get_user_meta($user_id,'first_name',true);
				$payload_array['LastName'] = get_user_meta($user_id,'last_name',true);
				$payload_array['company'] = get_option('blogname',true);
				$payload_array['CommunityId__c'] = $comid;
				$payload_array['Community_Name__c'] = $commtitle;
				$payload_array['CourseId__c'] = $crs_id;
				$payload_array['Course_Name__c'] = $coursetitle;
				$payload_array['ContentId__c'] = $lesson_id;
				$payload_array['Content_Name__c'] = $contenttitle;
				$payload_array['Action__c'] = 'Completed';
				$payload_array['Form_Type__c'] = 'Content';
				
				$generated_lead = SFAPICreateNewLead( $authenticationar , json_encode( $payload_array ) );
								
				if( !empty(json_decode( $generated_lead )->id) ){
					$wpdb->insert($wpdb->prefix.'vw_contentwebhook_payload',array('userid'=>$user_id,'com_id'=>$comid,'course_id'=>$crs_id,'content_id'=>$lesson_id,'action'=>'Completed','response'=>$generated_lead,'date_created'=>date('Y-m-d H:i:s')));
				}
			}
		}
		wp_die();
	}
}	