<?php
class lx_articulate_ajax{
	public function __construct() {
		/** function for zip upload process **/
		add_action("wp_ajax_articulate_zip_upload_process", array($this,"articulate_zip_upload_process"));
		add_action( 'wp_ajax_nopriv_articulate_zip_upload_process', array($this,'articulate_zip_upload_process'));

		/**function for save articulate content**/
		add_action("wp_ajax_save_articulate_content",array($this,'save_articulate_content'),20);
		add_action('wp-ajax_nopriv_save_articulate_content',array($this,'save_articulate_content'),20);

		/**function for delete articulate post**/
		add_action("wp_ajax_delete_articulate_content",array($this,'delete_articulate_content'));
		add_action('wp_ajax_nopriv_delete_articulate_content',array($this,'delete_articulate_content'));
		
		/**function for upload articulate thumb**/
		add_action("wp_ajax_upload_articulate_content_thumb",array($this,'upload_articulate_content_thumb'));
		add_action('wp_ajax_nopriv_upload_articulate_content_thumb',array($this,'upload_articulate_content_thumb'));
		
		/**function for delete articulate thumb**/
		add_action("wp_ajax_fn_delete_articulate_thumbnail",array($this,'fn_delete_articulate_thumbnail'));
		add_action('wp_ajax_nopriv_fn_delete_articulate_thumbnail',array($this,'fn_delete_articulate_thumbnail'));
	}
	
	/** function for zip upload process **/
	public function articulate_zip_upload_process(){
		global $vw_s3_plugin_path;
		$process=$_POST['process'];
		if(isset($process) && $process=='verify_package')
		{
			$file = $_FILES['zip_content'];
			$file_name = $_FILES['zip_content']['name'];
			$lesson_id = $_POST['articulate_id'];
			$format = $_POST['format'];
			$tool=$_POST['tool'];
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
			$content_size = get_size($to);;
			$upload=array(
				'type' =>'application/'.$file_info['extension'],
				'content_path'=>$to,
				'content_url'=>$to,
				'content_size'=>$content_size,
				'content_filename'=>explode('.', basename($path))[0]
			);
			$posts = get_post($lesson_id);
			$data =get_params($lesson_id);
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
			unset($params["content_tool"]);
			$params["content_tool"] = tool( $params );
			if(empty($params["content_tool"])){
				$params["content_tool"]='articulate_rise';
			}
			if(isset($params['content_tool']) && $params['content_tool']!=$tool)
			{
				unlink($path);
				deleteDirectory($to);
				$response = array('msg'=> "Uploadded File is not ".strtoupper($tool).".",'status'=> 400);
				echo json_encode($response);
				die;
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
		}else if(isset($process) && $process=='upload_zip'){
			$lesson_id=$_POST['articulate_id'];
			$params=json_decode(stripcslashes($_POST['params']),true);
			$path=wp_upload_dir()['path'].'/'.$params['content_filename'].'.zip';
			$to=wp_upload_dir()['path'].'/'.$params['content_filename'];
			$arr=array(
				'articulate_id'   => $lesson_id,
				'files'     => $params['content_url'],
				'type'      => 'articulate_content',
			);
			if(isset($_POST['old_file']))
			{
				$arr['old_file']=$_POST['old_file'];
			}
			$upload=articulate_zip_upload($arr);
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
			if($params['content_type']=='not_xapi')	
			{
				$params['activity_id']="";
			}
			set_params( $lesson_id, $params);
			unlink($vw_s3_plugin_path.'/temp_storage.txt');
			$response = ['data'=>$lesson_id,'status'=> 200];
			echo json_encode($response);
			die;
		}		
	}
	
	/**function for save articulate content**/
	public function save_articulate_content(){
		$content_selection = $_POST['articulate_content_selection'];
		$title=$_POST['articulate_title'];
		$articulate_id=$_POST['articulate_id'];
		$view_selection=$_POST['articulate_display_selection'];
		$category=$_POST['articulate_content_category'];
		$content_type=$_POST['articulate_category'];
		$status = $_POST['articulate_status'];
		$old_content_type=get_post_meta($articulate_id,'articulate_web_category',true);
		$content_tool = get_post_meta($articulate_id,'xapi_content',true)['content_tool'];
		$fount_post = post_exists( $title,'','','lx_articulate','publish');
		if( $fount_post != $articulate_id && $fount_post != 0){
			$data=['status'=>'title_existance'];
			echo json_encode($data);
			die;
		}
		if($content_type != 'articulate_web' && $status == 'edit'){
			if($content_type != $content_tool){
				$return = ['status'=>1,'msg'=>'Your choosen category does not match with choosen file format'];
				echo json_encode($return);
				die();
			}
		}
		if( $content_type == 'articulate_web' ){
			if($old_content_type!='' && $old_content_type=='articulate_zip'){
				global $s3_settings;
				$s3 = vw_lx_s3_uploadto_s3();
				$bucket=$s3_settings['s3_bucket'];
				$dir='site-assets/articulate_content-'.$articulate_id.'/';
				$filename=get_post_meta($articulate_id,'xapi_content',true)['content_filename'];
				$s3->deleteMatchingObjects($bucket, $dir.$filename);
				delete_post_meta($articulate_id,'xapi_content');
				delete_post_meta($articulate_id,'xapi_content_versions');
				delete_post_meta($articulate_id,'xapi_content_version_no');
			}
			update_post_meta($articulate_id,'web_url',$_POST['alt_resource_url']);
			update_post_meta($articulate_id,'articulate_web_category',$content_type);
			update_post_meta($articulate_id,'alt_view_selection',$view_selection );
			update_post_meta($articulate_id,'xapi_content',null);
		}else{
			update_post_meta($articulate_id,'articulate_web_category','articulate_zip');
			update_post_meta($articulate_id,'web_url',null);
			update_post_meta($articulate_id,'web_url',null);
		}
		$lx_articulate_content=array(
			'ID'=>$articulate_id,
			'post_status'=>'publish',
			'post_title'=> $title,
			'post_type'=>'lx_articulate',
			'guid'=> sanitize_title_with_dashes($title)
		);
		wp_update_post($lx_articulate_content);
		update_post_meta($articulate_id,'articulate_api_inclusions',$_POST['chk_api_inclusions'] );
		wp_set_post_categories($articulate_id,$category);
		$return = array('status'=>'200','href'=>site_url());
		echo json_encode($return);
		die();
	}
	
	/**function for delete articulate post**/
	public function delete_articulate_content(){
		$articulate_id=$_POST['articulate_id'];
		$content_type=get_post_meta($articulate_id,'articulate_web_category',true);
		if($content_type=='articulate_zip'){
			global $s3_settings;
			$s3 = vw_lx_s3_uploadto_s3();
			$bucket=$s3_settings['s3_bucket'];
			$dir='site-assets/articulate-web/'.$articulate_id.'/';
			$s3->deleteMatchingObjects($bucket, $dir);
		}
		wp_delete_post($articulate_id);
		echo "deleted";
		die();
	}
	
	/**function for upload articulate thumb**/
	function upload_articulate_content_thumb(){
		$articulate_id=$_POST['content_id'];
		$filename=$_FILES['thumb']['name'];
		$data = file_get_contents($_POST['dataurl']);
		$url = wp_upload_dir()['url'].'/'.$filename;
		$path = wp_upload_dir()['path'].'/'.$filename;
		$upload =file_put_contents($path, $data);
		$resize=imageresize($path);
		$old_image['original']=get_post_meta($articulate_id,'articulate_web_thumb_original',true);
		$old_image['cropped']=get_post_meta($articulate_id,'articulate_web_thumb',true);
		$arr=array(
			'articulate_id'=>$articulate_id,
			'files' => $_FILES['thumb'],
			'path' => $path,
			'type'=> 'articulate_web_thumb',
		);
		if(!empty($old_image)){
			$arr['old_image']=$old_image;
		}
		$upload_thumb=articulate_content_thumb_upload($arr);
		update_post_meta($articulate_id,'articulate_web_thumb_original',$upload_thumb['original']);
		update_post_meta($articulate_id,'articulate_web_thumb',$upload_thumb['cropped']);
		$data=array('status'=>"1",'msg'=>"Uploaded");
		echo json_encode($data);
		die;
	}
	
	/**function for delete articulate thumb**/
	function fn_delete_articulate_thumbnail(){
		global $s3_settings;
		$s3 = vw_lx_s3_uploadto_s3();
		$bucket=$s3_settings['s3_bucket'];
		$articulate_id=$_POST['articulate_id'];
		if( isset($_POST['status_info_backlink']) && $_POST['status_info_backlink'] == "yes" ){
			$dir='site-assets/articulate-web/'.$articulate_id;
			$s3->deleteMatchingObjects($bucket, $dir);
			wp_delete_post($articulate_id);
			echo 'deleted';
			die();

		} else{
			$thumb['original']=get_post_meta($articulate_id,'articulate_web_thumb_original',true);
			$thumb['cropped']=get_post_meta($articulate_id,'articulate_web_thumb',true);
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
			update_post_meta($articulate_id,'articulate_web_thumb',null);
			update_post_meta($articulate_id,'articulate_web_thumb_original',null);
			echo 'deleted';
			die();
		}
	}
}