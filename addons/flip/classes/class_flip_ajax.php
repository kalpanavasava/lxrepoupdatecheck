<?php

class ClassFlipAjax {
	public function __construct() {
		/** Fliplist Thumbnail Uploading **/
		add_action( 'wp_ajax_UploadFliplistThumbnail', array($this,'UploadFliplistThumbnail'));
		add_action( 'wp_ajax_nopriv_UploadFliplistThumbnail', array($this,'UploadFliplistThumbnail' ));
		
		/** Fliplist Thumbnail Delete **/
		add_action( 'wp_ajax_DeleteFliplistThumbnail', array($this,'DeleteFliplistThumbnail'));
		add_action( 'wp_ajax_nopriv_DeleteFliplistThumbnail', array($this,'DeleteFliplistThumbnail' ));
		
		/** Save Fliplist Data **/
		add_action( 'wp_ajax_SaveFliplistData', array($this,'SaveFliplistData'));
		add_action( 'wp_ajax_nopriv_SaveFliplistData', array($this,'SaveFliplistData' ));
		
		/** Save Recording **/
		add_action( 'wp_ajax_SaveRecording', array($this,'SaveRecording'));
		add_action( 'wp_ajax_nopriv_SaveRecording', array($this,'SaveRecording'));
		
		/** Delete Recording **/
		add_action('wp_ajax_DeleteRecording', array($this,'DeleteRecording'));
		add_action( 'wp_ajax_nopriv_DeleteRecording', array($this,'DeleteRecording'));
		
		/** Fl1p Recording Multi Thumbnail Uploading **/
		add_action('wp_ajax_UploadRecordingMultiThumbnail', array($this,'UploadRecordingMultiThumbnail'));
		add_action( 'wp_ajax_nopriv_UploadRecordingMultiThumbnail', array($this,'UploadRecordingMultiThumbnail'));
		
		/** Fl1p Recording Multi Thumbnail Delete **/
		add_action( 'wp_ajax_DeleteRecordingMultiThumbnail', array($this,'DeleteRecordingMultiThumbnail'));
		add_action( 'wp_ajax_nopriv_DeleteRecordingMultiThumbnail', array($this,'DeleteRecordingMultiThumbnail' ));
		
		add_action( 'wp_ajax_FNFlipSaveRecoding', array($this,'FNFlipSaveRecoding'));
		add_action( 'wp_ajax_nopriv_FNFlipSaveRecoding', array($this,'FNFlipSaveRecoding' ));
		
		/** delete the flip recording **/
		add_action( 'wp_ajax_DeleteMainFlipRecording', array($this,'DeleteMainFlipRecording'));
		add_action( 'wp_ajax_nopriv_DeleteMainFlipRecording', array($this,'DeleteMainFlipRecording' ));
		
		add_action( 'wp_ajax_UploadFlipRecThumbnail', array($this,'UploadFlipRecThumbnail'));
		add_action( 'wp_ajax_nopriv_UploadFlipRecThumbnail', array($this,'UploadFlipRecThumbnail' ));
		
		add_action( 'wp_ajax_FNMulPdfRecording', array($this,'FNMulPdfRecording'));
		add_action( 'wp_ajax_nopriv_FNMulPdfRecording', array($this,'FNMulPdfRecording' ));
		
		add_action( 'wp_ajax_FNrecdeletePDFFiles', array($this,'FNrecdeletePDFFiles'));
		add_action( 'wp_ajax_nopriv_FNrecdeletePDFFiles', array($this,'FNrecdeletePDFFiles' ));
		
		/** Fl1p Recording Multi Thumbnail Uploading **/
		add_action('wp_ajax_UploadRecordingMultipleImage', array($this,'UploadRecordingMultipleImage'));
		add_action( 'wp_ajax_nopriv_UploadRecordingMultipleImage', array($this,'UploadRecordingMultipleImage'));
		
		/** Fl1p Recording Multi Thumbnail Delete **/
		add_action( 'wp_ajax_DeleteRecordingMultipleImage', array($this,'DeleteRecordingMultipleImage'));
		add_action( 'wp_ajax_nopriv_DeleteRecordingMultipleImage', array($this,'DeleteRecordingMultipleImage' ));
		
		add_action( 'wp_ajax_CancelReturnstate', array($this,'CancelReturnstate'));
		add_action( 'wp_ajax_nopriv_CancelReturnstate', array($this,'CancelReturnstate' ));
		
		add_action( 'wp_ajax_Recordingloadreplies', array($this,'Recordingloadreplies'));
		add_action( 'wp_ajax_nopriv_Recordingloadreplies', array($this,'Recordingloadreplies' ));
	}
	public function UploadFliplistThumbnail() {
		$mode = $_POST['mode'];
		$fliplist_id = $_POST['fliplist_id'];
		$file = $_FILES['thumb'];
		$filename = $_FILES['thumb']['name'];
		$path = store_file_locally($_POST['dataurl'],$filename);
		$old_image['original'] = get_post_meta($fliplist_id,'fliplist_original_thumb',true);
		$old_image['cropped'] = get_post_meta($fliplist_id,'fliplist_cropped_thumb',true);
		if( isset($_POST['mode']) && $_POST['mode']=='add' ){		
			$validate = fliplist_file_validation($_FILES['thumb']);
			if( $validate['status'] == '0' ){
				echo json_encode($validate);
				die;
			}
		}
		$arr = array(
			'fliplist_id'=>$fliplist_id,
			'files' => $file,
			'path' => $path,
			'dir' => 'site-assets/fliplist/'.$fliplist_id.'/'
		);
		$upload = FliplistS3ThumbnailUpload($arr);
		update_post_meta($fliplist_id,'fliplist_original_thumb',$upload['original']);
		update_post_meta($fliplist_id,'fliplist_cropped_thumb',$upload['cropped']);
		unlink($path);
		if( !empty($upload) ){
			$data=['status'=>"1",'msg'=>'Uploaded Successfully','imageURL'=>$upload['cropped'] ];  
		}else{
			$data=['status'=>"0",'msg'=>'Uploaded Failed'];
		}
		echo json_encode($data);
		die;	
	} 
	public function DeleteFliplistThumbnail(){
		global $s3_settings;
		$s3 = vw_lx_s3_uploadto_s3();
		$bucket = $s3_settings['s3_bucket'];
		$fliplist_id = $_POST['fliplist_id'];
		
		$mode = $_POST['mode'];
		
		if( $mode == 'add' ){
			$thumb['original'] = get_post_meta($fliplist_id,'fliplist_original_thumb')[0];
			$thumb['cropped'] = get_post_meta($fliplist_id,'fliplist_cropped_thumb')[0];
			foreach($thumb as $img){
				$filepath = explode('site-assets/',dirname($img))[1];
				$dir = 'site-assets/'.$filepath.'/';
				$filename = basename($img);
				$file = $dir.$filename;
				$delete_image = $s3->deleteObject([
					'Bucket' => $bucket,
					'Key'    => $file
				]);
			}
			update_post_meta($fliplist_id,'fliplist_original_thumb',null);
			update_post_meta($fliplist_id,'fliplist_cropped_thumb',null);
			echo 'deleted';
		}
		$post_title = get_post($fliplist_id)->post_title;
		$post_status = get_post($fliplist_id)->post_status;
		if( $post_title == 'temp-fliplist' && $post_status == 'draft' ){
			wp_delete_post( $fliplist_id );
		}
		die();
	}

	public function SaveFliplistData(){
		/* echo '<pre>'; print_r($_POST); die; */
		global $wpdb;
		if( isset($_POST['fliplist_mode']) && $_POST['fliplist_mode']=='edit' ){
			$fliplist_id = $_POST['edited_fliplist_id'];
		}else{
			$fliplist_id = $_POST['fliplist_id'];
		}
		$mode = $_POST['mode'];
		$user_id = get_current_user_id();
		$fliplist_title = $_POST['fliplist_title'];
		$fliplist_subtitle = $_POST['fliplist_subtitle'];
		$fliplist_description = $_POST['fliplist_description'];
		$featured_chk = $_POST['fliplist_featured_category'];
		$display_in = $_POST['display_in'];
		$category_chk = $_POST['chk_content_categories'];
		$attach_id = $_POST['attach_this_fliplist'];
		$fliplist_status = $_POST['fliplist_save_status'];
		
		$fount_post = post_exists($fliplist_title,'','','flip_list');
		if( $fount_post > 0 && $fount_post != $fliplist_id ){
			echo json_encode(array('msg'=>'exist'));
			die();
		}
		$arr = array(
			'ID'		  => $fliplist_id,
			'post_title'  => $fliplist_title,
			'post_content'=> $fliplist_description,
			'post_status' => $fliplist_status,
			'post_type'	  => 'flip_list',
			'guid' => sanitize_title_with_dashes($fliplist_title)
		);
		wp_update_post($arr);
		$post_cat=array();
		if( isset($_POST['chk_content_categories'])){
			$post_cat=$_POST['chk_content_categories'];
		}
		if( $featured_chk == 'on'){
			$featured_id = get_term_by('slug','featured','category')->term_id;
			array_push($post_cat,$featured_id);
		}
		wp_set_post_terms( $fliplist_id,$post_cat,'category' );
		update_post_meta($fliplist_id,'fliplist_subtitle',$fliplist_subtitle);
	    update_post_meta($fliplist_id,'display_in',$display_in);
		update_post_meta($fliplist_id,'attach_this_fliplist',$attach_id);
		$data=array();
		if( $mode == 'add' ){
			$data = array('msg'=>'inserted','link'=>get_permalink($fliplist_id)); 
		}else{
			$data = array('msg'=>'updated','link'=>get_permalink($fliplist_id));
		}
		echo json_encode($data);
		die;
	}
	
	public function SaveRecording(){
		$uploadpath = wp_upload_dir()['path'];
		$recording_id = $_POST['recording_id'];
		$user_id = get_current_user_id();
		$arr = array(
			'recording_id'=>$recording_id,
			'files' => $_FILES['audio'],
			'dir' => 'site-assets/fl1p-recording/'.$recording_id.'/audio/'
		);
		$upload = RecordingUploadS3($arr);
		update_post_meta($recording_id,'flip_recording_audio',$upload['audio']);
		
		if( !empty($upload) ){
			$data=['status'=>"1",'msg'=>'Uploaded','audioURL'=>$upload['audio']];  
		}else{
			$data=['status'=>"0",'msg'=>'Upload Failed'];
		}
		echo json_encode($data);
		die;
	}
	public function DeleteRecording(){
		global $s3_settings;
		$s3 = vw_lx_s3_uploadto_s3();
		$bucket = $s3_settings['s3_bucket'];
		$recording_id = $_POST['recording_id'];
		$audio = get_post_meta($recording_id,'flip_recording_audio')[0];
		$filepath = explode('site-assets/',dirname($audio))[1];
		$dir = 'site-assets/'.$filepath.'/';
		$filename = basename($audio);
		$file = $dir.$filename;
		$delete_image = $s3->deleteObject([
			'Bucket' => $bucket,
			'Key'    => $file
		]);
		update_post_meta($recording_id,'flip_recording_audio',null);
		echo 'deleted';
		die();
	}
	
	public function UploadRecordingMultiThumbnail(){
		/* echo '<pre>'; print_r($_FILES); die; */
		$user_id = get_current_user_id();
		$mode = $_POST['mode'];
		$recording_id = $_POST['recording_id'];
		$file = $_FILES['thumb'];
		$filename = $_FILES['thumb']['name'];
		$path = store_file_locally($_POST['dataurl'],$filename);
		$arr = array(
			'recording_id'=>$recording_id,
			'files' => $file,
			'path' => $path,
			'dir' => 'site-assets/'.$user_id.'/fl1p-recording/'.$recording_id.'/'
		);
		$upload = RecordingMultiThumbUploadS3($arr);
		update_post_meta($recording_id,'recording_original_thumb',$upload['original']);
		unlink($path);
		if( !empty($upload) ){
			$data=['status'=>"1",'msg'=>'Uploaded Successfully','imageURL'=>$upload['original'] ];  
		}else{
			$data=['status'=>"0",'msg'=>'Uploaded Failed'];
		}
		echo json_encode($data);
		die;
	}
	public function DeleteRecordingMultiThumbnail(){
		
	}
	
	/** save recording **/
	public function FNFlipSaveRecoding(){
		$bkflip_list_id = $_POST['bkflip_list_id'];
		$rec_id = $_POST['fliprecid'];
		$title = $_POST['title'];
		$parentrec_id = $_POST['parentrec_id'];
		
		/* if( post_exists( $title,'','','flip_recording' ) != $rec_id && !empty(post_exists( $title,'','','flip_recording' )) ){
			echo json_encode(array('msg'=>'exist'));
			die();
		} */
		/* echo post_exists( $title );
		die(); */
		$subtitle = $_POST['subtitle'];
		$additional_notes = $_POST['additional_notes'];
		$rec_status = $_POST['rec_status'];
		if( !empty($rec_id) ){
			/** Insert Post **/
			$recposts = array(
				  'ID'           => $rec_id,
				  'post_title'   => $title,
				  'post_status'  => $rec_status,
				  'post_type'	 => 'flip_recording',
			);
			$updated = wp_update_post( $recposts );
			if( !empty($updated) ){
				if( empty($parentrec_id) ){
					$settings_array = array('replies'=>$_POST['setreply'],'repliesvis'=>$_POST['setrest'],'communities' => $_POST['setcomm'],'my_fliplist'=>$_POST['setmyfliplist']);
					$total_fliplist = $_POST['fliplists'];
					update_post_meta( $rec_id, 'settings_array' , $settings_array );
					update_post_meta( $rec_id, 'total_fliplist' , $total_fliplist );
				}else{
					update_post_meta( $rec_id, 'parent_recording_id' , $parentrec_id );
				}
				update_post_meta( $rec_id, 'subtitle' , $subtitle );
				update_post_meta( $rec_id, 'additional_notes' , $additional_notes );
				echo json_encode(array('url'=>get_permalink( $bkflip_list_id ),'msg'=>'updated'));
			}
		}
		wp_die();
	}
	public function DeleteMainFlipRecording(){
		$fliplistid = $_POST['fliplistid'];
		$recid = $_POST['recid'];
		$deleted = wp_delete_post( $recid );
		wp_die();
	}
	public function UploadFlipRecThumbnail(){
		$recid = $_POST['recid'];
		$dataurl = $_POST['dataurl'];
		$filename = $_FILES['thumb']['name'];
		$croppedname = explode('.',$_FILES['thumb']['name'])[0] . '_thumb_resized.' . explode('.',$_FILES['thumb']['name'])[1] ;
		
		/** old image **/
		$oldthumb = get_post_meta($recid,'thumbnail_image',true);
		
		$path = store_file_locally($dataurl,$croppedname);
		$arr = array(
			'rec_id'=>$recid,
			'files'=>$_FILES['thumb'],
			'croppedname'=>$croppedname,
			'path' => $path,
			'dir' => 'site-assets/fl1p-recording/'.$recid.'/thumbnail/'
		);
		$arr['oldthumbnail'] = array();
		if(!empty($oldthumb)){
			$arr['oldthumbnail'] = $oldthumb;
		}
		
		$return_func = FliprecordingUploadThumbnail( $arr );
		
		if( !empty( $return_func['original'] ) && !empty( $return_func['cropped'] ) ){
			update_post_meta($recid,'thumbnail_image',$return_func);
			$data=['status'=>"1",'msg'=>'Uploaded Successfully','imageURL'=>$return_func['cropped'] ];  
		}else{
			$data=['status'=>"0",'msg'=>'Uploaded Failed'];
		}
		
		unlink($path);
		
		echo json_encode($data);
		
		wp_die();
	}
	public function FNMulPdfRecording(){
		$recid = $_POST['recid'];
		/* $files = $_FILES; */
		$arr = array(
			'rec_id'=>$recid,
			'files'=>$_FILES,
			'dir' => 'site-assets/fl1p-recording/'.$recid.'/pdf/'
		);
		$return_func = FlipRecordingPDFS3Upload( $arr );
		if(!empty($return_func['pdfpath'])){
			$uparr = array();
			if( !empty(get_post_meta($recid,'recordingpdf_upload',true)) ){
				
				$uparre = get_post_meta($recid,'recordingpdf_upload',true);
				foreach( $uparre as $allpdf ){
					$exist_file_name = urldecode( basename($allpdf) );
					if( $exist_file_name != urldecode( basename($return_func['pdfpath']) ) ){
						$uparr[] = $allpdf;
					}
				}
				$uparr[] = $return_func['pdfpath'];
				/* echo "<pre>";print_r($uparre);
				die(); */
			}else{
				$uparr[] = $return_func['pdfpath'];
			}
			update_post_meta( $recid,'recordingpdf_upload',$uparr );
			$data=['status'=>"1",'msg'=>'Uploaded Successfully','pdfname'=>urldecode( basename($return_func['pdfpath']) ) ];
		}else{
			$data=['status'=>"0",'msg'=>'Uploaded Failed']; 
		}
		echo json_encode($data);
		wp_die();
	}
	public function FNrecdeletePDFFiles(){
		$recid = $_POST['recid'];
		$pdfname = $_POST['pdfname'];
		$arr = array(
			'rec_id' => $recid,
			'dir' => 'site-assets/fl1p-recording/'.$recid.'/pdf/'.$pdfname
		);
		
		$return_func = FlipRecordingPDFS3Delete( $arr );
		
		if( !empty($return_func) ){
			$allpdf = get_post_meta($recid,'recordingpdf_upload',true);
			if( !empty( $allpdf ) ){
				$allurls = array();
				foreach( $allpdf as $url ){
					if( urldecode(basename($url)) != $pdfname ){
						$allurls[] = $url;
					}
				}
				/* echo "<pre>";print_r($allpdf); */
				update_post_meta( $recid , 'recordingpdf_upload', $allurls );
			}
		}
		wp_die();
	}
	public function UploadRecordingMultipleImage(){
		$user_id = get_current_user_id();
		$mode = $_POST['mode'];
		$recording_id = $_POST['recording_id'];
		$files = $_FILES['images'];
		$uploadedimages = get_post_meta($recording_id,'recording_multiple_image_path',true);
		$images = array();
		$file_path = array();
		foreach( $files['name'] as $key=>$value ){
			$images[$key]['name'] = $value;
			$images[$key]['type'] = $files['type'][$key];
			$images[$key]['tmp_name'] = $files['tmp_name'][$key];
			$images[$key]['error'] = $files['error'][$key];
			$images[$key]['size'] = $files['size'][$key];
			$filename = explode('.',$value)[0].'_resized.'. explode('.',$value)[1];
			$data = file_get_contents($files['tmp_name'][$key]);
			$url = wp_upload_dir()['url'].'/'.$filename;
			$path = wp_upload_dir()['path'].'/'.$filename;
			$upload =file_put_contents($path, $data);
			$file_path[] = $path;
		}
		
		$arr = array(
			'recording_id' => $recording_id,
			'files' => $images,
			'path' => $file_path,
			'dir' => 'site-assets/fl1p-recording/'.$recording_id.'/slider/'
		); 
		
		
		/* if($mode=='add' && $_POST['uploaded_exist']=='no' && !empty($uploadedimages)){
			global $s3_settings;
			$bucket = $s3_settings['s3_bucket'];
			$s3 = vw_lx_s3_uploadto_s3();
			$s3->deleteMatchingObjects($bucket, $arr['dir']);
			$uploadedimages=array();
			update_post_meta($recording_id,'recording_multiple_image_path',$uploadedimages);
		} */
		
		$upload = RecordingMultipleImageUploadS3($arr);
		
		if(!empty($uploadedimages)){
			$newupload=array_merge($uploadedimages,$upload);
		}else{
			$newupload=$upload;
		}
		$resizedImg = array();
		foreach($upload as $image){
			$resizedImg[] = $image['resized'];
		}
		
		update_post_meta($recording_id,'recording_multiple_image_path',$newupload);
		unlink($file_path);
		if( !empty($upload) ){
			$data=['status'=>"1",'msg'=>'Uploaded Successfully!','imageURL'=>$resizedImg ];  
		}else{
			$data=['status'=>"0",'msg'=>'Upload Failed!'];
		}
		echo json_encode($data);
		die;
	}
	public function DeleteRecordingMultipleImage(){
		global $s3_settings;
		$image_name = $_POST['img_name'];
		$recording_id = $_POST['recording_id'];
		
		$s3 = vw_lx_s3_uploadto_s3();
		$bucket = $s3_settings['s3_bucket'];
		$images = get_post_meta($recording_id,'recording_multiple_image_path',true);
		
		foreach( $images as $imagesdata ){
			if( basename($imagesdata['resized']) == $image_name ){
				foreach( $imagesdata as $imgs ){
					$path = 'site-assets/fl1p-recording/'.$recording_id.'/slider/'.basename($imgs);
					$delete_image = $s3->deleteObject([
						'Bucket' => $bucket,
						'Key'    => $path
					]);
				}
			}
		}
		/* lxprint($image_name);
		lxprint($images); */
		$main_array = array();
		foreach( $images as $imagesdata ){
			$imgname = basename( $imagesdata['resized'] );
			$main_array[$imgname] = $imagesdata;
		}
		unset( $main_array[$image_name] );
		
		update_post_meta($recording_id,'recording_multiple_image_path',array_values($main_array));
		echo 'deleted';  
		die();
	}
	public function CancelReturnstate(){
		$recid = $_POST['recid'];
		$mode = $_POST['mode'];
		if( $mode == 'add' ){
			DeleteFlipDataOnRefresh( $recid );
		}
		$post_title = get_post($recid)->post_title;
		$post_status = get_post($recid)->post_status;
		if( $post_title == 'temp-recording' && $post_status == 'draft' ){
			wp_delete_post( $recid );
		}
		die();
	}
	public function Recordingloadreplies(){
		global $wpdb,$color_palette,$font_family,$flipicons,$lx_plugin_urls,$square_icon;
		$parent_fliplistid = $_POST['parentfliplistid'];
		$repliesid = $_POST['repliesid'];
		$fliprecordingid = $_POST['parentrecid'];
		$parentrecid = $_POST['parentrecid'];
		
		$recording_title = get_post( $fliprecordingid )->post_title;
		$parent_fliplist_html="";
		if( !empty($parent_fliplistid) ){
			$parent_fliplist_html = "<a href='".get_permalink( $parent_fliplistid )."'>".get_post( $parent_fliplistid )->post_title."</a>";
		}
		
		/* die(); */
		include dirname(dirname( __FILE__ )) . '/templates/flipviewdetailpage.php';
		wp_die();
	}
}