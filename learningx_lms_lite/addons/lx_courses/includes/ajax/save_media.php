<?php
/** function for get fl1p topic **/
function get_fl1p_topic(){
	$url='http://fl1p.com.au/wp-json/wp1/v1/fl1p_topic_by_podcast?podcast_id="'.$_POST['forum_id'].'"';
    $response=wp_remote_get($url);
    $responsebody=wp_remote_retrieve_body( $response );
    $option='';
    $option.='<option value="">Select</option>';
    if(is_wp_error($response)){
        $res=$response->get_error_message();
    }else{
        $res=json_decode( $responsebody );
    }
    if(isset($_POST['lesson_id']))
    {
    	$topic_id=get_post_meta($_POST['lesson_id'],'flip_topic_id',true);
    }
     if(!empty($res))
    {
        foreach ($res as $flip_topic) {
        	if($topic_id==$flip_topic->ID){
        		 $option.='<option value="'.$flip_topic->ID.'" selected>'.$flip_topic->post_title.'</option>';
        	}
           	else{
           		 $option.='<option value="'.$flip_topic->ID.'">'.$flip_topic->post_title.'</option>';
           	}
        }
    }
    echo $option;
    die();
}
add_action("wp_ajax_get_fl1p_topic", "get_fl1p_topic");
add_action( 'wp_ajax_nopriv_get_fl1p_topic', 'get_fl1p_topic');
/** function for save fl1p module **/
function save_flip_module(){
	global $wpdb;
	$flip_title=$_POST['fl1p_title'];
	$flip_forum=$_POST['fl1p_forum'];
	$flip_topic=$_POST['fl1p_topic'];
	if(isset($_POST['edit_lesson_id']) && $_POST['edit_lesson_id']!='')
	{
		$lesson_id=$_POST['edit_lesson_id'];
		if(isset($flip_topic) && $flip_topic!='')
		{
			$content='[fl1p_content forum_id="'.$flip_forum.'" topic_id="'.$flip_topic.'"]';
		}else{
			$content='[fl1p_content forum_id="'.$flip_forum.'"]';
		}
		$flip_content = array(
			  'ID'  		 =>	 $lesson_id,
			  'post_title'    =>  $flip_title,
			  'post_content'  => (string)$content,
			  'post_status'   => 'publish',
			  'post_type'   => 'lx_lessons',
			  'guid' => sanitize_title_with_dashes($flip_title)
			);
		wp_update_post($flip_content);
		
		update_post_meta($lesson_id,'course_id',$_POST['course_id']);
		update_post_meta($lesson_id,'activity_id',get_permalink($flip_content_id));
		update_post_meta($lesson_id,'flip_forum_id',$flip_forum);
		if(isset($flip_topic) && $flip_topic!=='')
		{
			update_post_meta($lesson_id,'flip_topic_id',$flip_topic);
		}
		else{
			update_post_meta($lesson_id,'flip_topic_id',null);
		}
		$data=['status'=>1,'msg'=>'updated'];
		echo json_encode($data);
		die();
	}else{
		$get_post=$wpdb->get_results("select post_title from ".$wpdb->prefix."posts where post_title='".$flip_title."' and post_type='sfwd-lessons' and post_status='publish'");
		if(!empty($get_post))
		{
			$data=['status'=>0,'msg'=>'exist'];
			echo json_encode($data);
			die;
		}else{
			if(isset($flip_topic) && $flip_topic!='')
			{
				$content='[fl1p_content forum_id="'.$flip_forum.'" topic_id="'.$flip_topic.'"]';
			}else{
				$content='[fl1p_content forum_id="'.$flip_forum.'"]';
			}
			$flip_content = array(
				  'post_title'    =>  $flip_title,
				  'post_content'  => (string)$content,
				  'post_status'   => 'publish',
				  'post_type'   => 'lx_lessons',
				  'guid' => sanitize_title_with_dashes($flip_title)
				);
			$flip_content_id = wp_insert_post($flip_content);
			
			$term_id=get_category_by_slug('fl1p')->term_id;
			$insert_relation_ship = $wpdb->query("insert into ".$wpdb->prefix."term_relationships (object_id,term_taxonomy_id,term_order) values ('".$flip_content_id."','".$term_id."','0')");  
			add_post_meta($flip_content_id,'course_id',$_POST['course_id']);
			add_post_meta($flip_content_id,'activity_id',get_permalink($flip_content_id));
			add_post_meta($flip_content_id,'flip_forum_id',$flip_forum);
			if(isset($flip_topic) && $flip_topic!=='')
			{
				add_post_meta($flip_content_id,'flip_topic_id',$flip_topic);
			}
			else{
				add_post_meta($flip_content_id,'flip_topic_id',null);
			}
			
			$data=['status'=>1,'msg'=>'inserted'];
			echo json_encode($data);
			die();
		}
	}
	
}
add_action("wp_ajax_save_flip_module", "save_flip_module");
add_action( 'wp_ajax_nopriv_save_flip_module', 'save_flip_module');
/** function for save course **/
function save_course(){
	global $wpdb;
	$title = $_POST['lx_course_title'];
	
	$fount_post = post_exists( $title,'','','lx_course','publish' );
	if( $fount_post != $course_id && $fount_post != 0){
		$data=['msg'=>'exist'];
		echo json_encode($data);
		die;
	}

	if(isset($_POST['edited_course_status']) && $_POST['edited_course_status']=='edit'){
		$course_id=$_POST['edited_course_id'];
	}else{
		$course_id=$_POST['course_id'];
		$enrollcoursetitle = $title.' '.'Enrolled'.' '.get_current_user_ID();
		$args_array = array(
			'post_type' => 'lx_course_order',
			'post_author' => get_current_user_ID(),
			'post_status' => 'publish',
			'post_title' => $enrollcoursetitle
		);
		$courseorder_id = wp_insert_post($args_array);
		update_post_meta($courseorder_id,'lx_product_id',$course_id);
		update_post_meta($courseorder_id,'lx_order_user_id',get_current_user_ID()); 
		update_post_meta($courseorder_id,'lx_trans_date',date("d-m-Y"));
	}
	
	$course_id=course_update($_POST);
	wp_update_post( $lx_courses );
	update_course_meta($course_id,$_POST);	
	$data=array('msg'=>'Updated','link'=>get_permalink($course_id));	
	echo json_encode($data);
	die;
}

add_action("wp_ajax_save_course", "save_course",20);
add_action( 'wp_ajax_nopriv_save_course', 'save_course',20 );

/** function for delete course thumbnail **/
function delete_course_thumbnail(){
	global $s3_settings;
	$s3 = vw_lx_s3_uploadto_s3();
	$bucket=$s3_settings['s3_bucket'];
	$course_id=$_POST['course_id'];
	
	$mode=$_POST['mode'];
	if( $mode == 'add' ){
		$thumb['original']=get_post_meta($course_id,'lx_course_thumbnail_original')[0];
		$thumb['cropped']=get_post_meta($course_id,'lx_course_thumbnail_path')[0];
		foreach($thumb as $img)
		{

			$filepath=explode('site-assets/',dirname($img))[1];
			$dir='site-assets/'.$filepath.'/';
			$filename=basename($img);
			$file=$dir.$filename;
			$delete_image=$s3->deleteObject([
				'Bucket' => $bucket,
				'Key'    => $file
			]);
		}
		update_post_meta($course_id,'lx_course_thumbnail_path',null);
		update_post_meta($course_id,'lx_course_thumbnail_original',null);
		echo 'deleted';
	}
	$post_title = get_post($course_id)->post_title;
	$post_status = get_post($course_id)->post_status;
	if( $post_title == 'temp-course' && $post_status == 'draft' ){
		wp_delete_post( $course_id );
	}
	die();
}
add_action("wp_ajax_delete_course_thumbnail", "delete_course_thumbnail");
add_action( 'wp_ajax_nopriv_delete_course_thumbnail', 'delete_course_thumbnail' );

/** function for delete module thumbnail **/
function delete_module_thumbnail(){
	$s3 = vw_lx_s3_uploadto_s3();
	global $s3_settings;
	$bucket=$s3_settings['s3_bucket'];
	$course_id=$_POST['course_id'];
	$module_id=$_POST['module_id'];
	$thumb['original']=get_post_meta($module_id,'module_thumb_original',true);
	$thumb['cropped']=get_post_meta($module_id,'module_thumb',true);
	$dir='site-assets/course/'.$course_id.'/module-'.$module_id.'/';
	foreach($thumb as $img)
	{
		$filename=basename($img);
		$file=$dir.$filename;
		$delete_image=$s3->deleteObject([
	        'Bucket' => $bucket,
	        'Key'    => $file
	    ]);
	}
	update_post_meta($module_id,'module_thumb_original',null);
	update_post_meta($module_id,'module_thumb',null);
	echo 'deleted';
	die();
}
add_action("wp_ajax_delete_module_thumbnail", "delete_module_thumbnail");
add_action( 'wp_ajax_nopriv_delete_module_thumbnail', 'delete_module_thumbnail' );

/** function for play topics **/
function play_topic(){
	$flip_id=$_POST['flip_id'];
	$podcast_id=$_POST['podcast_id'];
	$user=wp_get_current_user(); 
	$uemail=$user->user_email;
	if (strpos($uemail, '+') !== false) {
        $email=str_replace('+','%2B',$uemail);
    }
    else{
        $email=$uemail;
    }
	$url='https://fl1p.com.au/wp-json/wp1/v1/fl1p_audio?podcast_id="'.$podcast_id.'"&topic_id="'.$flip_id.'"&uemail="'.$email.'"';
    $response=wp_remote_get($url);
    $responsebody=wp_remote_retrieve_body( $response );
	?>
	<link rel='stylesheet' id='dzsap-css'  href='<?php echo plugins_url().'/dzs-zoomsounds/audioplayer/audioplayer.css?ver=5.78';?>' type='text/css' media='all' />
	<script type='text/javascript' src='<?php echo plugins_url().'/dzs-zoomsounds/audioplayer/audioplayer.js?ver=5.78';?>'></script>
	<?php
    echo $responsebody;
    die;
}
add_action("wp_ajax_play_topic", "play_topic");
add_action('wp_ajax_nopriv_play_topic','play_topic');

/** function for get text **/
function get_text(){
	$flip_id=$_POST['flip_id'];
	$url='https://fl1p.com.au/wp-json/wp1/v1/fl1p_additional_info?topic_id="'.$flip_id.'"';
    $response=wp_remote_get($url);
    $responsebody=json_decode(wp_remote_retrieve_body( $response ));
    echo $responsebody->text;
    die;		
}
add_action("wp_ajax_get_text", "get_text");
add_action( 'wp_ajax_nopriv_get_text', 'get_text' );

/** function for get slider **/
function get_slider(){
	$flip_id=$_POST['flip_id'];
	$url='https://fl1p.com.au/wp-json/wp1/v1/fl1p_additional_info?topic_id="'.$flip_id.'"';
    $response=wp_remote_get($url);
    $responsebody=json_decode(wp_remote_retrieve_body( $response ));
	?>
	<link rel='stylesheet' id='maxgalleria-slick-carousel-slick-css'  href="<?php echo plugins_url().'/maxgalleria-slick/libs/slick/slick.css?ver=5.5.3';?>" type='text/css' media='all' />
	<link rel='stylesheet' id='maxgalleria-slick-theme-carousel-slick-css'  href="<?php echo plugins_url().'/maxgalleria-slick/libs/slick/slick-theme.css?ver=5.5.3';?>" type='text/css' media='all' />
	<link rel='stylesheet' id='maxgalleria-slick-carousel-css'  href="<?php echo plugins_url().'/maxgalleria-slick/maxgalleria-slick-carousel.css?ver=5.5.3';?>" type='text/css' media='all' />
	<link rel='stylesheet' id='maxgalleria-slick-carousel-skin-borderless-css'  href="<?php echo plugins_url().'/maxgalleria-slick/skins/borderless.css?ver=5.5.3';?>" type='text/css' media='all' />
	<script type='text/javascript' src="<?php echo plugins_url().'/maxgalleria-slick/libs/slick/slick.min.js?ver=5.5.3'?>" id='maxgalleria-slick-carousel-slick-js'></script>
	<?php
		echo do_shortcode('[max_gallary_vw_sc images='.implode(',', $responsebody->image).']'); 
		die();
}

add_action("wp_ajax_get_slider", "get_slider");
add_action( 'wp_ajax_nopriv_get_slider', 'get_slider' );

/** function for get slider count **/
function get_slider_count(){
	$flip_id=$_POST['flip_id'];
	$url='https://fl1p.com.au/wp-json/wp1/v1/fl1p_additional_info?topic_id="'.$flip_id.'"';
    $response=wp_remote_get($url);
    $responsebody=json_decode(wp_remote_retrieve_body( $response ));
	echo $responsebody->image_count; 
	die();
}
add_action("wp_ajax_get_slider_count", "get_slider_count");
add_action( 'wp_ajax_nopriv_get_slider_count', 'get_slider_count' );

/** function for get course attachment **/
function get_attachment(){
	$flip_id=$_POST['flip_id'];
	$url='https://fl1p.com.au/wp-json/wp1/v1/fl1p_additional_info?topic_id="'.$flip_id.'"';
    $response=wp_remote_get($url);
    $responsebody=json_decode(wp_remote_retrieve_body( $response ));
	if(!empty($responsebody->attachment))
	{
		?>
		<div class="col-md-12 attach_link_div">
		<?php
		foreach($responsebody->attachment as $attachment)
		{
			if(!empty($attachment)){
			?>
			
				<div class="col-sm-6 show_attachment" data-source="<?php echo $attachment;?>"><?php echo basename($attachment);?></div> 
			
			<?php
			}
		}
		?>
		</div>
		<div class="col-md-12 display_attachment" style="display:none;"></div>
		<?php
	}else{
		echo "No Attachments Yet!";
	}
	die();
}
add_action("wp_ajax_get_attachment", "get_attachment");
add_action( 'wp_ajax_nopriv_get_attachment', 'get_attachment' );

/** function for get attachment count **/
function get_attachment_count(){
	$flip_id=$_POST['flip_id'];
	$url='https://fl1p.com.au/wp-json/wp1/v1/fl1p_additional_info?topic_id="'.$flip_id.'"';
    $response=wp_remote_get($url);
    $responsebody=json_decode(wp_remote_retrieve_body( $response ));
	echo $responsebody->attachment_count;
	die();
}
add_action("wp_ajax_get_attachment_count", "get_attachment_count");
add_action('wp_ajax_nopriv_get_attachment_count', 'get_attachment_count');

/** function for open model **/
function open_model(){
	$course_id=get_post_meta($_POST['lesson_id'],'course_id',true);
	$lesson_link=get_permalink($_POST['lesson_id']);
	$course_link=get_permalink($course_id);
	$lesson_title= get_post_field( 'post_title', $_POST['lesson_id'] );
	$course_title= get_post_field( 'post_title', $course_id );
	$flip_id=$_POST['flip_id'];
	$user=wp_get_current_user(); 
	$uemail=$user->user_email;
	if (strpos($uemail, '+') !== false) {
        $email=str_replace('+','%2B',$uemail);
    }
    else{
        $email=$uemail;
    }
    $arr=array(
    	'flip_id'     => $flip_id,
    	'uemail'      => $uemail,
    	'course_link' => $course_link,
    	'lesson_link' => $lesson_link,
    	'course_title'=> $course_title,
    	'lesson_title'=> $lesson_title,
    	'mode'        => 'add'
    );
    $param=http_build_query($arr);
	$url='https://fl1p.com.au/wp-json/wp1/v1/fl1p_add_reply?'.base64_encode($param);
    $response=wp_remote_get($url);
    $responsebody=wp_remote_retrieve_body( $response );
	echo $responsebody;
	 ?>
    <script src="<?php echo plugins_url().'/lx_courses/js/custom.js';?>"></script>
    <?php
	die();
}
add_action("wp_ajax_open_model", "open_model");
add_action('wp_ajax_nopriv_open_model', 'open_model');

/** function for get blob **/
function get_blob(){
	$url = $_POST['url'];
	echo do_shortcode('[zoomsounds_player type="detect" dzsap_meta_source_attachment_id="128" source="'.$url.'" config="default" autoplay="off" loop="off" open_in_ultibox="off" enable_likes="off" enable_views="off" enable_rates="off" play_in_footer_player="default" enable_download_button="off" download_custom_link_enable="off" extra_classes_player="flip_audio_track"]');
	die();
}

add_action("wp_ajax_get_blob", "get_blob");
add_action( 'wp_ajax_nopriv_get_blob', 'get_blob' );

/** function for upload multiple image **/
function upload_mul_image()
{	
	$files = $_FILES['flip_mul_image']; 
	foreach ($files['name'] as $key => $value) {          
		if ($files['name'][$key]) { 
			$file = array( 
				'name' => $files['name'][$key],
				'type' => $files['type'][$key], 
				'tmp_name' => $files['tmp_name'][$key], 
				'error' => $files['error'][$key],
				'size' => $files['size'][$key]
			); 
			$mulimage_file = $file; 
			$upload_overrides3 = array(
				'test_form' => false
				);
	
			$movefile = wp_handle_upload( $mulimage_file, $upload_overrides3 );
			$mul_img[]=$movefile['url'];
		}
	}
	$arr=array(
		'podcast_id' => $_POST['podcast_id'],
		'topic_id'   => $_POST['edit_id'],
		'res_id'     => $_POST['insert_id'],
		'files'      => array(
			'mul_img'=> $mul_img
		),
		'type'       => 'response',
		'mode'		 => $_POST['mode'],
	);
	$param=http_build_query($arr);
	$url='https://fl1p.com.au/wp-json/wp1/v1/fl1p_s3_upload?'.base64_encode($param);
	$args = array(
	    'timeout'     => 300,
	    'sslverify' => false,
	); 
    $response=wp_remote_get($url,$args);
    $responsebody=wp_remote_retrieve_body( $response );
    echo str_replace('"','',$responsebody);
    foreach ($mul_img as $img) {
      unlink($img);
    }
	die;
}
add_action("wp_ajax_upload_mul_image", "upload_mul_image");
add_action( 'wp_ajax_nopriv_upload_mul_image', 'upload_mul_image' );

/** function for upload audio file **/
function upload_audio_file(){
	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}
	$file=$_FILES['topic_audio_upload'];
	$upload_overrides = array(
		'test_form' => false
	);
	$movefile = wp_handle_upload( $file, $upload_overrides );	
	
	$arr=array(
		'podcast_id' => $_POST['podcast_id'],
		'topic_id'   => $_POST['edit_id'],
		'res_id'     => $_POST['insert_id'],
		'type'       => 'response',
		'mode'		 => $_POST['mode'],
		'files'		 => array(
			'audio'  => $movefile['url']
		)
	);
	$param=http_build_query($arr);
	$url='https://fl1p.com.au/wp-json/wp1/v1/fl1p_s3_upload?'.base64_encode($param); 
	$args = array(
	    'timeout'   => 300,
		'sslverify' => false
	); 
    $response=wp_remote_get($url,$args);
    $responsebody=wp_remote_retrieve_body( $response );
   	$url=str_replace('"','',$responsebody);
   	echo stripslashes($url);
   	unlink($movefile['url']);
	die;
}
add_action("wp_ajax_upload_audio_file", "upload_audio_file");
add_action( 'wp_ajax_nopriv_upload_audio_file', 'upload_audio_file' );

/** function for upload attachment **/
function upload_attachments(){
	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}
	$file=$_FILES['flip_topic_attachment'];
	$upload_overrides = array(
		'test_form' => false
	);
	$movefile = wp_handle_upload( $file, $upload_overrides );
	if(isset($_POST['mode']) && $_POST['mode']=='add')
	{
		$arr=array(
			'podcast_id' => $_POST['podcast_id'],
			'topic_id'   => $_POST['edit_id'],
			'res_id'     => $_POST['insert_id'],
			'files'      => array(
				'attachment'	 => $movefile['url']
			),
			'type'       => 'response',
			'mode'		 => $_POST['mode'],
			'attach_no'	 => $_POST['attach_no']
		);
	}
	else{
		if(isset($_POST['flip_mul_attach']) && !empty($_POST['flip_mul_attach']))
		{
			$arr=array(
				'podcast_id' => $_POST['podcast_id'],
				'topic_id'   => $_POST['edit_id'],
				'res_id'     => $_POST['insert_id'],
				'files'      => array(
					'attachment'	 => $movefile['url']
				),
				'flip_mul_attach'	 =>$_POST['flip_mul_attach'],
				'type'       => 'response',
				'mode'		 => $_POST['mode'],
				'attach_no'	 => $_POST['attach_no']
			);
		}
		else{
			$arr=array(
				'podcast_id' => $_POST['podcast_id'],
				'topic_id'   => $_POST['edit_id'],
				'res_id'     => $_POST['insert_id'],
				'files'      => array(
					'attachment'	 => $movefile['url']
				),
				'type'       => 'response',
				'mode'		 => $_POST['mode'],
				'attach_no'	 => $_POST['attach_no']
			);
		}
	}
	$param=http_build_query($arr);
	$url='https://fl1p.com.au/wp-json/wp1/v1/fl1p_s3_upload?'.base64_encode($param);
	$args = array(
	    'timeout'     => 300,
	    'sslverify' => false
	); 
    $response=wp_remote_get($url,$args);
    $responsebody=wp_remote_retrieve_body( $response );
	echo str_replace('"','',$responsebody);
	unlink($movefile['url']);
	die;		
}
add_action("wp_ajax_upload_attachments", "upload_attachments");
add_action( 'wp_ajax_nopriv_upload_attachments', 'upload_attachments' );

/** function for save media **/
function save_media(){
	if(isset($_FILES))
	{
		
		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
		$file=$_FILES['audio_data'];
		$upload_overrides = array(
			'test_form' => false
		);
		$movefile = wp_handle_upload( $file, $upload_overrides );
	}
	if(isset($_POST['hid_edit_flip_action']) && $_POST['hid_edit_flip_action']=='edit_response')
	{
		$mode='edit';
	}
	else{
		$mode='add';
	}
	if(isset($_FILES))
	{
		$arr = array('post' => $_POST,'files'=>$movefile['url'] ,'mode'=>$mode);
		$param=http_build_query($arr);
	}else{
		$arr = array('post' => $_POST,'mode'=>$mode);
		$param=http_build_query($arr);
	}
	$url='https://fl1p.com.au/wp-json/wp1/v1/fl1p_save_reply?'.base64_encode($param);
	$args = array(
	    'timeout'     => 300,
	    'sslverify' => false
	); 
    $response=wp_remote_get($url,$args);
    $responsebody=wp_remote_retrieve_body( $response );
	echo str_replace('"','',$responsebody);
	die;
}
add_action("wp_ajax_save_media", "save_media");
add_action( 'wp_ajax_nopriv_save_media', 'save_media' );

/** function for open model reply edit **/
function open_model_reply_edit(){
	$flip_id=$_POST['flip_id'];
	$user=wp_get_current_user(); 
	$uemail=$user->user_email;
	if (strpos($uemail, '+') !== false) {
        $email=str_replace('+','%2B',$uemail);
    }
    else{
        $email=$uemail;
    }
	$url='https://fl1p.com.au/wp-json/wp1/v1/fl1p_add_reply?topic_id="'.$flip_id.'"&uemail="'.$email.'"&mode="edit"';
    $response=wp_remote_get($url);
    $responsebody=wp_remote_retrieve_body( $response );
	echo $responsebody;
	 ?>
    <script src="<?php echo plugins_url().'/lx_courses/js/custom.js';?>"></script>
    <?php
	die();
}
add_action("wp_ajax_open_model_reply_edit", "open_model_reply_edit");
add_action( 'wp_ajax_nopriv_open_model_reply_edit', 'open_model_reply_edit' );

/** function for open model reply edit **/
function reply_delete(){
	$res_id=$_POST['flip_id'];
	$topic_id=$_POST['flip_parent_id'];
	$url='https://fl1p.com.au/wp-json/wp1/v1/fl1p_delete_reply?topic_id="'.$topic_id.'"&response_id="'.$res_id.'"';
    $response=wp_remote_get($url);
    $responsebody=wp_remote_retrieve_body( $response );
	echo str_replace('"','',$responsebody);
	die;
}
add_action("wp_ajax_reply_delete", "reply_delete");
add_action( "wp_ajax_nopriv_reply_delete", "reply_delete" ); 

/** function for delete multiple image single **/
function delete_mul_image_single(){
	$forum_id=$_POST['podcast_id'];
	$topic_id=$_POST['flip_id'];
	$res_id=$_POST['response_id'];
	$old_image=$_POST['old_image'];
	$url='https://fl1p.com.au/wp-json/wp1/v1/fl1p_delete_mul_image?podcast_id="'.$forum_id.'"&topic_id="'.$topic_id.'"&response_id="'.$res_id.'"&old_image="'.$old_image.'"';
    $response=wp_remote_get($url);
    $responsebody=wp_remote_retrieve_body( $response );
	echo str_replace('"','',$responsebody);
	die;
}
add_action("wp_ajax_delete_mul_image_single", "delete_mul_image_single");
add_action( 'wp_ajax_nopriv_delete_mul_image_single', 'delete_mul_image_single' );

/** function for delete data from s3 **/
function delete_data_from_s3(){
	$flip_id=$_POST['flip_id'];
	$url='https://fl1p.com.au/wp-json/wp1/v1/fl1p_delete_data_from_s3?topic_id="'.$flip_id.'"';
    $response=wp_remote_get($url);
    $responsebody=wp_remote_retrieve_body( $response );
	echo str_replace('"','',$responsebody);
	die;
}
add_action("wp_ajax_delete_data_from_s3", "delete_data_from_s3");
add_action( 'wp_ajax_nopriv_delete_data_from_s3', 'delete_data_from_s3');

/** function for upload xapi zip **/
function xapi_zip_upload()
{
	global $wpdb,$vw_s3_plugin_path;
	$activity_id = $_POST['activity_id'];
	$count = 0; 
	$array_of_ids = array();
	$process=$_POST['process'];
	if(isset($process) && $process=='verify_package')
	{
		$file = $_FILES['XAPI_attachment'];
		$file_name = $_FILES['XAPI_attachment']['name'];
		$lesson_id = $_POST['lesson_id'];
		$metadata=get_post_meta($lesson_id);
        if(!empty($metadata)){
        	delete_post_meta($lesson_id,'xapi_activity_id');
        	delete_post_meta($lesson_id,'xapi_content');
        	delete_post_meta($lesson_id,'xapi_content_versions');
        	delete_post_meta($lesson_id,'xapi_content_version_no');
        }
		$format = $_POST['version_selection'];
		$content_type=$_POST['tool'];
		$get_tool=get_term_by('id',$content_type,'category')->slug;
		$tool=str_replace('-','_',$get_tool);
		$upload_overrides = array(
	    'test_form' => false
		);
		$newname=explode('.', $file_name)[0]."_".get_current_user_id().".".explode('.', $file_name)[1];
		$data = file_get_contents($file['tmp_name']);
		$url = wp_upload_dir()['url'].'/'.$newname;
		$path = wp_upload_dir()['path'].'/'.$newname;
		$upload_zip =file_put_contents($path, $data);
		$file_info = pathinfo($path);
		$to=wp_upload_dir()['path'].'/'.explode('.', basename($path))[0];
		$zip = new ZipArchive;
		$res = $zip->open($path);
		$filename=explode('.', $newname)[0];
		if ($res === TRUE) {
		  $zip->extractTo($to);
		  $zip->close();  
		} 
		$content_size =get_size($to);
		$upload=array(
			'type' =>'application/'.$file_info['extension'],
			'content_path'=>$to,
			'content_url'=>$to,
			'content_size'=>$content_size,
			'content_filename'=>explode('.', basename($path))[0]
		);
		$posts = get_post($lesson_id);
		$data = get_params($lesson_id);
		$upload = array_merge($data, $upload);
		$params['process_status'] = 0;
		$params = process_xapi_upload($params , $posts , $upload);
		if(isset($params['content_type']) && $params['content_type']!=$format)
		{
			unlink($path);
			deleteDirectory($to);
			$response = array('msg'=>'Your Selected Format is not match.','status'=> 400);
			echo json_encode($response);
			die;
		}
		if($format!='not_xapi')
		{
			if(!isset($params["content_tool"]) || empty($params["content_tool"]))
			{
				$params["content_tool"] = tool( $params );
			}
			if(isset($params['content_tool']) && $params['content_tool']!=$tool)
			{
				unlink($path);
				deleteDirectory($to);
				$response = array('msg'=> "Uploaded File is not ".strtoupper($tool).".",'status'=> 400);
				echo json_encode($response);
				die;
			}
		}
		if ($params['process_status'] == 0) {
			$response= array("path" => @$upload["path"], "upload" => $upload, "response" => 'error', "info" => "Incompatible content. Processing failed.");
			echo json_encode($response);
			die;
		}
		if (array_key_exists('process_status', $params)) {
			unset($params['process_status']);
		}
		$response = array('data'=>$params,'status'=> 200);
		echo json_encode($response);
		die;
	}	
	else if(isset($process) && $process=='verify_uid')
	{
		$params=json_decode(stripcslashes($_POST['params']),true);
		$activity_id=$params['original_activity_id'];
		$xapi_data = array(
			'post_type' => 'lx_lessons',
			'post_status' => 'publish',
			'posts_per_page'=> -1
		);
		$xapi_post = get_posts($xapi_data);
		$array_of_ids=array();
		$cnt=0;
		foreach($xapi_post as $xapi_content)
		{
			$xapi_id = $xapi_content->ID;
			$unique_id = get_post_meta($xapi_id,'xapi_content',true)['activity_id'];
			array_push($array_of_ids, $unique_id);
			if($activity_id == $unique_id){}
			else{
				$cnt++;
			}
		}
		if(count($array_of_ids)==$cnt)
		{
			$response = array('data'=>$params,'status'=> 200);
			echo json_encode($response);
		}
		else{
			$response = array('msg'=>'Already_Exist','file_title'=>$params['content_filename'],'status'=> 400);
			echo json_encode($response);
		}
		die;
	}else if(isset($process) && $process=='upload_zip'){
		$course_id=$_POST['course_id'];
		$lesson_id=$_POST['lesson_id'];
		$params=json_decode(stripcslashes($_POST['params']),true);
		$path=wp_upload_dir()['path'].'/'.$params['content_filename'].'.zip';
		$to=wp_upload_dir()['path'].'/'.$params['content_filename'];
		$arr=array(
			'course_id' => $course_id,
			'lesson_id'   => $lesson_id,
			'files'     => $params['content_url'],
			'type'      => 'module',
		);
		if(isset($_POST['old_file']))
		{
			$arr['old_file']=$_POST['old_file'];
		}
		$upload=zip_package_upload($arr);

		unlink($path);
		deleteDirectory($to);
		$launch_url='';
		foreach($upload['folder'] as $file){
			if(basename($params['launch_path'])==basename($file))
			{
				$launch_url=$file;
			}
		}
		$params['content_path']=dirname($launch_url);
		$params['content_url']=dirname($launch_url);
		$params['launch_path']=$launch_url;
		$params['src']=$launch_url;
		$params['completion_tracking']=1;
		$params['show_here']=1;
		if($params['content_type']=='not_xapi')	
		{
			$params['activity_id']="";
			$params['content_tool']="";
		}
		set_params( $lesson_id, $params);
		unlink($vw_s3_plugin_path.'/temp_storage.txt');
		$response = ['data'=>$lesson_id,'status'=> 200];
		echo json_encode($response);
		die;
	}	
}
add_action("wp_ajax_xapi_zip_upload", "xapi_zip_upload");
add_action( 'wp_ajax_nopriv_xapi_zip_upload','xapi_zip_upload');

/** function for delete Delete **/
function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {	
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }
    return rmdir($dir);
}

/** function for unlink file on cancle **/
function unlink_file_on_cancle()
{
	$path=wp_upload_dir()['path'].'/'.$_POST['title'].'.zip';
	$to=wp_upload_dir()['path'].'/'.$_POST['title'];
	unlink($path);
	deleteDirectory($to);
	echo 'deleted';
	die;
}
add_action("wp_ajax_unlink_file_on_cancle", "unlink_file_on_cancle");
add_action( 'wp_ajax_nopriv_unlink_file_on_cancle','unlink_file_on_cancle');

/** function for save xapi module **/
function save_xapi_module() {
	global $wpdb;
	$course_id=$_POST['course_id'];
	$lesson_id=$_POST['lesson_id'];
	$lesson_cnt=count(get_lessons($course_id));
	$title=$_POST['module_title'];
	$content_type=$_POST['tool'];
	$get_tool=get_term_by('id',$content_type,'category')->slug;
	$tool=str_replace('-','_',$get_tool);
	$mode=$_POST['mode'];
	$certificate=$_POST['lx_xapi_certificate'];
	$launch_url=get_post_meta($lesson_id,'xapi_content',true)['launch_path'];
	$activity_id=get_post_meta($lesson_id,'xapi_content',true)['activity_id'];
	$content="[vw_xapi_content lesson_id='".$lesson_id."' url='".$launch_url."' activity_id='".$activity_id."' open_in='page']";
	/*$fount_post = post_exists( $title,'','','lx_lessons','publish');*/
	$fount_post=$wpdb->get_results('select ID from '.$wpdb->prefix.'posts where post_type="lx_lessons" and post_title="'.$title.'"');
	if(!empty($fount_post)){
		$fp_ids=array();
		$fpc_ids=array();
		foreach($fount_post as $fp){
			$fp_ids[]=$fp->ID;
			$fpc_ids[]=get_post_meta($fp->ID,'course_id',true);
		}
	}
	if(isset($mode) && $mode=='edit'){
		$msg="updated";
		$menu_order=get_post($lesson_id)->menu_order;
		if( !empty($fount_post) && !in_array($lesson_id,$fp_ids) && in_array($course_id,$fpc_ids)){
			if( $fount_post !=0 ){
				$data=['msg'=>'exist','status'=>'title_existance'];
				echo json_encode($data);
				die;
			}
		}
	} else if(isset($mode) && $mode=='add'){
		$msg="inserted";
		$menu_order=$lesson_cnt+1;
		if( !empty($fount_post) && in_array($course_id,$fpc_ids)){
			$data=['msg'=>'exist','status'=>'title_existance'];
			echo json_encode($data);
			die;
		}
	}
	$content_tool = get_post_meta($lesson_id,'xapi_content',true)['content_tool'];
	if( $content_tool ==  $tool){
		$xapi_content = array(
			'ID' => $lesson_id,
			'post_title'    =>  $title,
			'post_content' => $content,
			'post_status'   => 'publish',
			'post_type'   => 'lx_lessons',
			'guid' => sanitize_title_with_dashes($title),
			'menu_order' =>$menu_order
		);
		wp_update_post($xapi_content);
		wp_set_post_terms($lesson_id,array($content_type),'category');
		update_post_meta($lesson_id,'course_id',$course_id);
		update_post_meta($lesson_id,'tool',$tool);
		update_post_meta($lesson_id,'lx_xapi_certificate',$certificate);
		/*$term_id=get_category_by_slug('rise')->term_id;
				$insert_relation_ship = $wpdb->query("insert into ".$wpdb->prefix."term_relationships (object_id,term_taxonomy_id,term_order) values ('".$lesson_id."','".$term_id."','0')");*/
		
		$data=['status'=>0,'msg'=>$msg,'activity_id'=>$activity_id,'link'=>get_permalink($course_id)];
		echo json_encode($data);
		die;
	}else{
		$data=['status'=>1,'msg'=>'Your choosen category does not match with choosen file format'];
		echo json_encode($data);
		die;
	}
}
add_action("wp_ajax_save_xapi_module", "save_xapi_module");
add_action('wp_ajax_nopriv_save_xapi_module','save_xapi_module');

/** function for upload course thumb **/
function upload_course_thumb(){
	$course_id=$_POST['course_id'];
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
	$arr=course_thumb_upload_arr($_POST,$_FILES['thumb'],$path);
	$upload_thumb=course_thumb_upload($arr);
	unlink($path);
	if(!empty($upload_thumb)){
		update_post_meta($course_id,'lx_course_thumbnail_path',$upload_thumb['cropped']);
		update_post_meta($course_id,'lx_course_thumbnail_original',$upload_thumb['original']);
		$data=array('status'=>"1",'msg'=>"Uploaded",'imageURL'=>$upload_thumb['cropped']);
	}else{
		$data=array('status'=>"0",'msg'=>"Uploaded Failed");
	}
	echo json_encode($data);
	die;
}
add_action("wp_ajax_upload_course_thumb", "upload_course_thumb",20);
add_action('wp_ajax_nopriv_upload_course_thumb','upload_course_thumb',20);

/* function add_lesson_completionlb(){
	global $color_palette,$wpdb;
	$user_id=get_current_user_ID();
	$lesson_ids=$_POST['lesson_id'];
	
	foreach($lesson_ids as $lesson_id){
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
		$activityid = get_post_meta($lesson_id,'xapi_activity_id',true);
		$timstamp=get_user_meta($user_id,'lx_lesson_progress_date_'.$activityid,true);
		$timstamp['end_timstamp'] = strtotime($_POST['completedtime'][0]);
		update_user_meta($user_id,'lx_lesson_progress_'.$activityid,'completed');
		update_user_meta($user_id,'lx_lesson_progress_date_'.$activityid,$timstamp);
	}
	die();
}
add_action("wp_ajax_add_lesson_completionlb", "add_lesson_completionlb");
add_action('wp_ajax_nopriv_add_lesson_completionlb','add_lesson_completionlb'); */

/** function for add lesson completion **/
function add_lesson_completion2(){
	global $color_palette,$wpdb;
	$user_id=get_current_user_ID();
	$lesson_ids=$_POST['lesson_id'];
	
	foreach($lesson_ids as $lesson_id){
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
		$activityid = get_post_meta($lesson_id,'xapi_activity_id',true);
		$timstamp=get_user_meta($user_id,'lx_lesson_progress_date_'.$activityid,true);
		$timstamp['end_timstamp'] = strtotime($_POST['completedtime'][0]);
		update_user_meta($user_id,'lx_lesson_progress_'.$activityid,'completed');
		update_user_meta($user_id,'lx_lesson_progress_date_'.$activityid,$timstamp);
	}
	$course_progress=lx_course_progress($_POST['course_id']);
	echo json_encode(array('lession_id'=>$lesson_ids ,'color_completed'=>$color_palette['course_completed'],'completion_status'=>$course_progress['percentage']));
	die;
}
add_action("wp_ajax_add_lesson_completion2", "add_lesson_completion2");
add_action('wp_ajax_nopriv_add_lesson_completion2','add_lesson_completion2');

/** function for mark as started **/
function mark_as_started()
{
	$lession_id=$_POST['lession_id'];
	$user_id=get_current_user_id();
		$content_type = get_post_meta($lession_id,'content_type',true);
	if($content_type!='' && $content_type == 'poll'){
		if(get_user_meta($user_id,'lx_lesson_progress_'.$lession_id,true)=='')
		{
			update_user_meta($user_id,'lx_lesson_progress_'.$lession_id,'in_progress');
			update_user_meta($user_id,'lx_lesson_progress_date_'.$lession_id,array('start_timestamp'=>time()));
		}
	}else{
		$lessonActivityId = get_post_meta($lession_id,'xapi_activity_id',true); 
		if(get_user_meta($user_id,'lx_lesson_progress_'.$lessonActivityId,true)=='')
		{
			update_user_meta($user_id,'lx_lesson_progress_'.$lessonActivityId,'in_progress');
			update_user_meta($user_id,'lx_lesson_progress_date_'.$lessonActivityId,array('start_timestamp'=>time()));
		}
	}
	echo get_permalink($lession_id);
	die;
}
add_action("wp_ajax_mark_as_started", "mark_as_started");
add_action( 'wp_ajax_nopriv_mark_as_started', 'mark_as_started' );

/** function for delete lesson **/
function delete_lesson(){
	global $s3_settings;
	$bucket=$s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	$lesson_id=$_POST['lesson_id'];
	$filename=get_post_meta($lesson_id,'xapi_content',true)['content_filename'];
	$dir='site-assets/course/'.$_POST['course_id'].'/module-'.$lesson_id.'/';
	$data = $s3->deleteMatchingObjects($bucket, $dir);
	$user_id=get_current_user_id();
	if( isset($_POST['status_info_backlink']) && $_POST['status_info_backlink'] == "yes" ){
		
	} else{	
		wp_delete_post($lesson_id);
	}
	
	$content_type = get_post_meta($lesson_id,'content_type',true);
	$activityId = get_post_meta($lesson_id,'xapi_activity_id',true); 
	if($content_type!='' && $content_type == 'poll'){
		delete_user_meta($user_id,'lx_lesson_progress_'.$lesson_id);
	}else{
		delete_user_meta($user_id,'lx_lesson_progress_'.$activityId);
	}
	
	echo 'deleted';
	die();
}
add_action("wp_ajax_delete_lesson", "delete_lesson",20);
add_action( 'wp_ajax_nopriv_delete_lesson', 'delete_lesson',20);

/** function for upload content thumb **/
function upload_content_thumb(){
	$course_id=$_POST['course_id'];
	$module_id=$_POST['module_id'];
	$filename=$_FILES['thumb']['name'];
	$data = file_get_contents($_POST['dataurl']);
	$url = wp_upload_dir()['url'].'/'.$filename;
	$path = wp_upload_dir()['path'].'/'.$filename;
	$upload =file_put_contents($path, $data);
	$resize=imageresize($path);
	$old_image['original']=get_post_meta($module_id,'module_thumb_original',true);
	$old_image['cropped']=get_post_meta($module_id,'module_thumb',true);
	$arr=array(
		'course_id'=>$course_id,
		'module_id'=>$module_id,
		'files' => $_FILES['thumb'],
		'path' => $path,
		'type'=> 'module_thumb',
	);
	if(!empty($old_image)){
		$arr['old_image']=$old_image;
	}
	$upload_thumb=content_thumb_upload($arr);
	update_post_meta($module_id,'module_thumb_original',$upload_thumb['original']);
	update_post_meta($module_id,'module_thumb',$upload_thumb['cropped']);
	$data=array('status'=>"1",'msg'=>"Uploaded");
	echo json_encode($data);
	die;
}
add_action("wp_ajax_upload_content_thumb", "upload_content_thumb");
add_action('wp_ajax_nopriv_upload_content_thumb','upload_content_thumb');

/** function for add certificate in course page **/
function add_certificate_in_course_page(){
	update_post_meta($_POST['course_id'],'lx_certificate',$_POST['lx_certificate']);
	die;
}
add_action("wp_ajax_add_certificate_in_course_page", "add_certificate_in_course_page");
add_action('wp_ajax_nopriv_add_certificate_in_course_page','add_certificate_in_course_page');

/** function for delete certificate in course page **/
function del_certificate_in_course_page(){
	update_post_meta($_POST['course_id'],'lx_certificate',null);
	die;
}
add_action("wp_ajax_del_certificate_in_course_page", "del_certificate_in_course_page");
add_action('wp_ajax_nopriv_del_certificate_in_course_page','del_certificate_in_course_page');

function chk_certificate_onchange_action(){
	$course_id = $_POST['course_id'];
	$chk_certificate = $_POST['chk_certificate'];
	$attach_course = $_POST['attach_course'];
	$site_wide_certificate = get_option('lx_lms_site_wide_certificate_settings');
	$certificate_template = get_option('lx_lms_certificate_setting');
	if( is_plugin_active(LX_LMS_PRO) ){
		if( $site_wide_certificate =='ON' && empty($certificate_template ) ){
			$msg = ['msg'=>'An Admin user will need to upload a site-wide certificate.'];
			echo json_encode($msg);
			die;
		} else if( $site_wide_certificate =='ON' && !empty($certificate_template )){
			$msg = ['msg'=>'This site uses site-wide certificates.'];
			echo json_encode($msg);
			die;
		}else if( $site_wide_certificate =='OFF' && $attach_course ==0 ){
			$msg = ['msg'=>'You will need to attach this Course to a Community to generate a Certificate.'];
			echo json_encode($msg);
			die;
		}else if( $site_wide_certificate =='OFF' && $attach_course !=0 ){
			$msg = ['msg'=>'The Community you attached this course to does not have a certificate template uploaded.'];
			echo json_encode($msg);
			die;
		}									
	}else{
		$msg = ['msg'=>'This site uses site-wide certificates.'];
		echo json_encode($msg);
		die;
	}
	die;
}
add_action("wp_ajax_chk_certificate_onchange_action", "chk_certificate_onchange_action");
add_action('wp_ajax_nopriv_chk_certificate_onchange_action','chk_certificate_onchange_action');

function AddCourseContentHeadingDividers(){
	$post_title = $_POST['title'];
	$course_id = $_POST['course_id'];
	$menu_order = count(get_lessons($course_id))+1;
	$args = array(
		'post_type'   => 'lx_lessons' , 
		'author'      => get_current_user_id(),
		'post_status' => publish,
		'post_title'  => $post_title,
		'menu_order'  => $menu_order,
	);
	$id = wp_insert_post($args);
	update_post_meta($id,'section_heading_course_id',$course_id );
	die;
}
add_action("wp_ajax_AddCourseContentHeadingDividers", "AddCourseContentHeadingDividers");
add_action("wp_ajax_nopriv_AddCourseContentHeadingDividers", "AddCourseContentHeadingDividers");

function EditCourseContentHeadingDivider(){
	$lesson_id = $_POST['lesson_id'];
	$course_id = $_POST['course_id'];
	$post_title = $_POST['title'];
	$menu_order=get_post($lesson_id)->menu_order;
	$args = array(
		'ID' => $lesson_id,
		'post_type'   => 'lx_lessons', 
		'post_status' => 'publish',
		'post_title'  => $post_title,
		'menu_order'  => $menu_order,
	);
	$updatedID = wp_update_post($args);
	update_post_meta($updatedID,'section_heading_course_id',$course_id );
	die;
}
add_action("wp_ajax_EditCourseContentHeadingDivider", "EditCourseContentHeadingDivider");
add_action("wp_ajax_nopriv_EditCourseContentHeadingDivider", "EditCourseContentHeadingDivider");
?>