<?php
 /** Allow all file to upload to media **/ 
define('ALLOW_UNFILTERED_UPLOADS', true);
require dirname(__FILE__).'/aws/aws-autoloader.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

global $vw_s3_plugin_path,$vw_s3_plugin_url;
$vw_s3_plugin_path=plugin_dir_path(__FILE__);
$vw_s3_plugin_url=plugin_dir_url(__FILE__);

/* function for set s3 bucket credentials and other informations */
function vw_lx_s3_uploadto_s3(){
	global $s3_settings;
	$s3region = 'ap-southeast-2';
	if( !empty($s3_settings['s3_region']) ){
		$s3region = $s3_settings['s3_region'];
	}
	$s3_settings['s3_region'];
	$s3 = new Aws\S3\S3Client([
	  'region' => $s3region,
	  'version' => 'latest',
	  'credentials' => [
			'key'    => $s3_settings['s3_key'],
			'secret' => $s3_settings['s3_access'],
	   ]
	]);
	return $s3;
}

/* function for upload course thumb on s3 */
function course_thumb_upload($atts){
	global $s3_settings;
	$bucket=$s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	$dir=$atts['dir'];
	$file=$atts['files'];
	$path=$atts['path'];
	if(isset($atts['old_image']) && !empty($atts['old_image']))
	{
		foreach($atts['old_image'] as $image) {
			$thumb=basename($image);
			$file=$dir.$thumb;
			$delete_image=$s3->deleteObject([
		        'Bucket' => $bucket,
		        'Key'    => $file
		    ]);
		}
	}
	
	/* $options = array(
                    'params' => array(
                        'Bucket' => $bucket,
                        'Key'    =>  $dir.$atts['files']['name'],
                        'ServerSideEncryption' => 'aws:kms',
                ));
    $upload = $s3->upload(
					$bucket, 
					$dir.$atts['files']['name'], 
					fopen($atts['files']['tmp_name'], 'rb'), 
					'public-read',
					$options
				);
	
	if( $upload->get('ObjectURL') )	{
		$result = $s3->getObject(
			array(
				'Bucket' => $bucket,
				'Key' => $dir.$atts['files']['name'],            
				'ServerSideEncryption' => 'aws:kms'
			)
		);	
		$bodyAsString = (string) $result['Body'];

$bodyAsString = $result['Body']->__toString();
		vwpr($bodyAsString);
	} */
	
	$filename=explode('.', $atts['files']['name']);
	$fname=$filename[0].'_cropped.'.$filename[1];
	$cropped_image=crop_thumb($path,$dir,$fname); 
    $upload = $s3->upload($bucket, $dir.$atts['files']['name'], fopen($atts['files']['tmp_name'], 'rb'), 'public-read');
	$media_path['original']=$upload->get('ObjectURL');
	$media_path['cropped']=$cropped_image->get('ObjectURL');
	return $media_path;
}

/* function for upload course content(lesson) thumb on s3 */
function content_thumb_upload($atts){
	global $s3_settings;
	$bucket=$s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	$course_id=$atts['course_id'];
	$module_id=$atts['module_id'];
	$dir='site-assets/course/'.$course_id.'/module-'.$module_id.'/';
	if(isset($atts['old_image']))
	{
		foreach($atts['old_image'] as $image) {			
			$thumb=basename($image);
			$file=$dir.$thumb;
			$delete_image=$s3->deleteObject([
				'Bucket' => $bucket,
				'Key'    => $file
			]);
		}
	}
	$file=$atts['files'];
	$path=$atts['path'];
	$filename=explode('.', $file['name']);
	$fname=$filename[0].'_cropped.'.$filename[1];
	$cropped_image=crop_thumb($path,$dir,$fname); 
    $upload = $s3->upload($bucket, $dir.$file['name'], fopen($file['tmp_name'], 'rb'), 'public-read');
	$media_path['original']=$upload->get('ObjectURL');
	$media_path['cropped']=$cropped_image->get('ObjectURL');
	return $media_path;
}

/* function for upload articulate content thumb on s3 */
function articulate_content_thumb_upload($atts){
	global $s3_settings;
	$bucket=$s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	$articulate_id=$atts['articulate_id'];
	$dir='site-assets/articulate-web/'.$articulate_id.'/';
	if(isset($atts['old_image']))
	{
		foreach($atts['old_image'] as $image) {			
			$thumb=basename($image);
			$file=$dir.$thumb;
			$delete_image=$s3->deleteObject([
				'Bucket' => $bucket,
				'Key'    => $file
			]);
		}
	}
	$file=$atts['files'];
	$path=$atts['path'];
	$filename=explode('.', $file['name']);
	$fname=$filename[0].'_cropped.'.$filename[1];
	$cropped_image=crop_thumb($path,$dir,$fname); 
    $upload = $s3->upload($bucket, $dir.$file['name'], fopen($file['tmp_name'], 'rb'), 'public-read');
	$media_path['original']=$upload->get('ObjectURL');
	$media_path['cropped']=$cropped_image->get('ObjectURL');
	return $media_path;
}

/* function for upload course content(lesson) package on s3 */
function zip_package_upload($atts){
	global $s3_settings;
	$bucket=$s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	$course_id=$atts['course_id'];
	$module_id=$atts['lesson_id'];
	$xapi_id=$atts['xapi_id'];
	$dir=get_module_upload_dir($course_id,$module_id);
	if(isset($atts['old_file']) && !empty($atts['old_file']))
	{
		$filename=$atts['old_file'];
		$s3->deleteMatchingObjects($bucket, $dir.$filename);
	}
	$folder=$atts['files'];
	uploadfolder($folder,$dir);	 
	$files=explode(PHP_EOL,file_get_contents(dirname(__FILE__).'/temp_storage.txt'));
	$media_path['folder']=$files;
	return $media_path;
}

/* function for upload articulate content package on s3 */
function articulate_zip_upload($atts){
	global $s3_settings;
	$bucket=$s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
		
	$articulate_id=$atts['articulate_id'];
	$dir='site-assets/articulate-web/'.$articulate_id.'/articulate-content/';
	if(isset($atts['old_file']))
	{
		$filename=$atts['old_file'];
		$s3->deleteMatchingObjects($bucket, $dir.$filename);
	}
	$folder=$atts['files'];
	uploadfolder($folder,$dir);
	$files=explode(PHP_EOL,file_get_contents(dirname(__FILE__).'/temp_storage.txt'));
	$media_path['folder']=$files;
	return $media_path;
}

/* function for poll content thumb upload */
function poll_thumb_upload($atts){
	global $s3_settings;
	$bucket=$s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	$dir=$atts['dir'];
	$file=$atts['files'];
	$path=$atts['path'];
	$filename=explode('.', $file['name']);
	if(isset($atts['question_id'])){
		$fname='q'.$atts['question_id'].'_'.$filename[0].'_cropped.'.$filename[1];
	}else{
		$fname=$filename[0].'_cropped.'.$filename[1];
	}
	$cropped_image=crop_thumb($path,$dir,$fname); 
    $upload = $s3->upload($bucket, $dir.$file['name'], fopen($file['tmp_name'], 'rb'), 'public-read');
	$media_path['original']=$upload->get('ObjectURL');
	$media_path['cropped']=$cropped_image->get('ObjectURL');
	return $media_path;
}

/* function for crop thumb */
function crop_thumb($uploads,$path,$file){
	$s3 = vw_lx_s3_uploadto_s3();
	global $s3_settings;
	$bucket=$s3_settings['s3_bucket'];
	$dir=$path;
	try{
		$result = $s3->putObject(
			array(
				'Bucket' => $bucket,
				'Key' => $dir.$file,
				'SourceFile' => $uploads,
				'StorageClass' => 'REDUCED_REDUNDANCY',
				'ACL'  => 'public-read'
		));
	}catch(S3Exception $e)
	{
		echo $e->getMessage() . "<br>";
	}
	return $result;
}

/* function for favicon image resize */
function imageresize_favicon($filename){ 
	$width = 200; 
	$height=200;
	$source='';
	list($width_orig, $height_orig,$mime) = getimagesize($filename);  
	$source = imagecreatefrompng($filename);
	$dst = imagecreatetruecolor($width, $height); 
	imagealphablending($dst, false);
	imagesavealpha($dst,true);
	$transparency = imagecolorallocatealpha($dst,255, 255, 255, 127);
	imagefilledrectangle($dst, 0, 0, $width, $height, $transparency);
	imagecopyresampled($dst, $source, 0, 0, 0, 0,$width, $height, $width_orig,$height_orig); 
	$filename=wp_upload_dir()['path'].'/'.'resized.png';
	$return=imagejpeg($dst,$filename);
	return $return;
}

/* function for logo favicon image resize */
function imageresize_favicon_logo($filename){ 
	$width = 300; 
	$height= 300;
	$source='';
	list($width_orig, $height_orig,$mime) = getimagesize($filename);  
	$source = imagecreatefrompng($filename);
	$dst = imagecreatetruecolor($width, $height); 
	imagealphablending($dst, false);
	imagesavealpha($dst,true);
	$transparency = imagecolorallocatealpha($dst,255, 255, 255, 127);
	imagefilledrectangle($dst, 0, 0, $width, $height, $transparency);
	imagecopyresampled($dst, $source, 0, 0, 0, 0,$width, $height, $width_orig,$height_orig); 
	$return=imagejpeg($dst,$filename);
	return $return;
}

/* for image resize */
function imageresize($filename){ 
	$width = 800; 
	$height=450;
	$source='';
	list($width_orig, $height_orig,$mime) = getimagesize($filename);  
	$source = imagecreatefrompng($filename);
	$dst = imagecreatetruecolor($width, $height); 
	imagecopyresampled($dst, $source, 0, 0, 0, 0,$width, $height, $width_orig, $height_orig); 
	$return=imagejpeg($dst,$filename,50);
	return $return;
}
/* function for main logo image resize */
function imageresize_main_logo($filename){ 
	$width = 400; 
	$height=85;
	$source='';
	list($width_orig, $height_orig,$mime) = getimagesize($filename);  
	$source = imagecreatefrompng($filename);
	$dst = imagecreatetruecolor($width, $height); 
	imagecopyresampled($dst, $source, 0, 0, 0, 0,$width, $height, $width_orig, $height_orig); 
	$return=imagejpeg($dst,$filename,50);
	return $return;
}

/* function for upload articulate content zip package folder */
function uploadfolder($unzippped,$dir){
	$s3 = vw_lx_s3_uploadto_s3();
	global $s3_settings;
	$bucket=$s3_settings['s3_bucket'];
	$inner_arr=array();
    foreach (glob($unzippped.'/*') as $file) {
	    $file_name = str_replace($unzippped.'/', '', $file);
	  	if(is_dir($unzippped.'/'.$file_name)) {
	  		$file=$unzippped.'/'.$file_name;
	     	uploadfolder($file,$dir);
		}
		else{
			$month = date('m');
			$key=substr($file, strpos($file, '/'.$month.'/') + 4);  
			$result = $s3->putObject([
		        'Bucket' => $bucket,
		        'Key'    => $dir.$key,
		        'SourceFile' => $file,
		        'StorageClass' => 'REDUCED_REDUNDANCY',
				'ACL'  => 'public-read'
		    ]);
		    gc_collect_cycles();
		     file_put_contents(dirname(__FILE__).'/temp_storage.txt', $result->get('ObjectURL').PHP_EOL, FILE_APPEND);
		}

	}
}
/***************************/
/** For LX Editor Plugin **/
/***************************/

function vw_fn_lx_s3_uploaduserwise_assets($data_array){
	$s3 = vw_lx_s3_uploadto_s3();
	global $s3_settings;
	$bucket=$s3_settings['s3_bucket'];
	/*if(isset($data_array['community_id']))
	{
		$dir='site-assets/community-'.$data_array['community_id'].'/blog_post-'.$data_array['blog_post_id'].'/';
	}else{
		$dir='site-assets/blog_post-'.$data_array['blog_post_id'].'/';
	}*/
	$dir='site-assets/user-'.get_current_user_id().'/blog_post-'.$data_array['blog_post_id'].'/';
	if(isset($data_array['old_image']))
	{
		$thumb=basename($data_array['old_image']);
		$file=$dir.$thumb;
		$delete_image=$s3->deleteObject([
	        'Bucket' => $bucket,
	        'Key'    => $file
	    ]);
	}
	$data = file_get_contents($data_array['dataurl']);
	$url = wp_upload_dir()['url'].'/'.$data_array['filename'];
	$path = wp_upload_dir()['path'].'/'.$data_array['filename'];
	$upload =file_put_contents($path, $data);
	$cropped_image=crop_thumb($path,$dir,$data_array['filename']); 
	return $cropped_image->get('ObjectURL');
}

/* function for upload certificate template in s3 */
function upload_certificate_template($atts){
	global $s3_settings;
	$bucket=$s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	$file=$atts['files'];
	$dir='site-assets/certificate_template/';
	if(isset($atts['old_image']) && !empty($atts['old_image']))
	{
		foreach($atts['old_image'] as $image) {			
			$thumb=basename($image);
			$file_name=$dir.$thumb;
			$delete_image=$s3->deleteObject([
				'Bucket' => $bucket,
				'Key'    => $file_name
			]);
		}
	}
	$path=$atts['path'];
	$filename=explode('.',$file['name']);
	$fname=$filename[0].'_lx_cert.'.$filename[1];
    $upload = $s3->upload($bucket, $dir.$fname, fopen($file['tmp_name'], 'rb'), 'public-read');
	$media_path['original']=$upload->get('ObjectURL');
	return $media_path;
}

/* for test s3 connection */
function s3_test_connection($data){
	global $s3_settings;
	/** default ap-southeast-2 **/
	$s3 = new Aws\S3\S3Client([
	  'region' => $data['region'],
	  'version' => 'latest',
	  'credentials' => [
			'key'    => $data['key'],
			'secret' => $data['secret'],
	   ]
	]);
	$bucket=$data['bucket'];
	$keyname='test.txt';
	try {
	    $result = $s3->putObject(array(
	        'Bucket' => $bucket,
	        'Key'    => $keyname,
	        'Body'   => 'Test Connection!',
	        'ACL'    => 'public-read'
	    ));
	    if($result){
	    	$return=true;
	    }else{
	    	$return=false;
	    }
	} catch (S3Exception $e) {
	    $return=false;
	}
	return $return;
}

/** all flip functions **/
function FliplistS3ThumbnailUpload($atts){
	global $s3_settings;
	$bucket = $s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	$dir = $atts['dir'];
	$file = $atts['files'];
	$path = $atts['path'];
	if( isset($atts['old_image']) && !empty($atts['old_image']) ){
		foreach($atts['old_image'] as $image) {
			$thumb = basename($image);
			$file = $dir.$thumb;
			$delete_image = $s3->deleteObject([
		        'Bucket' => $bucket,
		        'Key'    => $file
		    ]);
		}
	}
	$filename = explode('.', $file['name']);
	$fname = $filename[0].'_cropped.'.$filename[1];
	$cropped_image = crop_thumb($path,$dir,$fname); 
    $upload = $s3->upload($bucket, $dir.$file['name'], fopen($file['tmp_name'], 'rb'), 'public-read');
	$media_path['original'] = $upload->get('ObjectURL');
	$media_path['cropped'] = $cropped_image->get('ObjectURL');
	return $media_path; 
}

/* function for flip recording upload */
function RecordingUploadS3($atts){
	global $s3_settings;
	$bucket = $s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	$dir = $atts['dir'];
	$file = $atts['files'];
	$recording_id = $atts['recording_id'];
	$user_id = get_current_user_id();
    $upload = $s3->upload($bucket, $dir.'fl1p-recording_'.$user_id.'_'.$recording_id.'.mp3', fopen($file['tmp_name'], 'rb'), 'public-read');
	$media_path['audio'] = $upload->get('ObjectURL');
	return $media_path; 
}
/* function for recording multi thumb upload */
function RecordingMultiThumbUploadS3($atts){
	global $s3_settings;
	$bucket = $s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	$user_id = get_current_user_id();
	$recording_id = $atts['recording_id'];
	$file = $atts['files'];
	$path = $atts['path'];
	$dir = $atts['dir'];
	/* if( isset($atts['old_image']) && !empty($atts['old_image']) ){
		foreach($atts['old_image'] as $image) {
			$thumb = basename($image);
			$file = $dir.$thumb;
			$delete_image = $s3->deleteObject([
		        'Bucket' => $bucket,
		        'Key'    => $file
		    ]);
		}
	} */
	/* $new_upload = array();
	$upload = $s3->upload($bucket, $dir.$file['name'], fopen($file['tmp_name'], 'rb'), 'public-read');
	foreach($upload[0] as $key => $value)
	$new_upload[$key] = $value; */
    $upload = $s3->upload($bucket, $dir.$file['name'], fopen($file['tmp_name'], 'rb'), 'public-read');
	$media_path['original'] = $upload->get('ObjectURL');
	return $media_path; 
}
function FliprecordingUploadThumbnail( $atts ){
	global $s3_settings;
	$bucket = $s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	$recording_id = $atts['rec_id'];
	$file = $atts['files'];
	$path = $atts['path'];
	$dir = $atts['dir'];
	$resizedname = $atts['croppedname'];
	
	if(!empty($atts['oldthumbnail'])){
		foreach($atts['oldthumbnail'] as $image) {
			$thumb = basename($image);
			$defile = $dir.$thumb;
			$delete_image = $s3->deleteObject([
		        'Bucket' => $bucket,
		        'Key'    => $defile
		    ]);
		}
	}
	$cropped_image=crop_thumb($path,$dir,$resizedname); 
	try{
		$upload = $s3->upload($bucket, $dir.$file['name'], fopen($file['tmp_name'], 'rb'), 'public-read');
		$media_path['original']=$upload->get('ObjectURL');
		$media_path['cropped']=$cropped_image->get('ObjectURL');
	}catch(S3Exception $e){
		echo $e->getMessage() . "<br>";
	}
	return $media_path;
}

/** Recording pdf upload **/
function FlipRecordingPDFS3Upload( $atts ){
	global $s3_settings;
	$bucket = $s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	$recording_id = $atts['rec_id'];
	
	$file = $atts['files'];
	$path = $atts['path'];
	$dir = $atts['dir'];
	$upload = $s3->upload($bucket, $dir.$file['files']['name'], fopen($file['files']['tmp_name'], 'rb'), 'public-read');
	$media_path['pdfpath'] = $upload->get('ObjectURL');
	return $media_path;
}
function FlipRecordingPDFS3Delete( $atts ){
	global $s3_settings;
	$bucket = $s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	
	$delete_image = $s3->deleteObject([
		'Bucket' => $bucket,
		'Key'    => $atts['dir']
	]);
	
	return $delete_image;
}
/* Function Recording Multiple Images Upload */
function RecordingMultipleImageUploadS3($atts){
	global $s3_settings;
	$bucket = $s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	$user_id = get_current_user_id();
	$recording_id = $atts['recording_id'];
	$files = $atts['files'];
	$path = $atts['path'];
	$dir = $atts['dir'];
	$media_path=array();
	foreach($files as $key=>$file){
		$resizedwidth = getimagesize( $path[$key] )[0];
		$resizedheight = getimagesize( $path[$key] )[1];
		if( $resizedwidth > 1280 || $resizedheight > 1280 ){
			$resized_image = ResizeRecordingMultipleImage($path[$key],$dir);
		}else{
			$resized_image = $s3->putObject(
				array(
					'Bucket' => $bucket,
					'Key' => $dir.basename($path[$key]),
					'SourceFile' => $path[$key],
					'StorageClass' => 'REDUCED_REDUNDANCY',
					'ACL'  => 'public-read'
			));
		}
		 
		$upload = $s3->upload($bucket, $dir.$file['name'], fopen($file['tmp_name'], 'rb'), 'public-read');
		$media_path[]=array(
			'original'=> $upload->get('ObjectURL'),
			'resized'=> $resized_image->get('ObjectURL')
		);
	}
	return $media_path;
}
/* Resize Recording Multiple Images */
function ResizeRecordingMultipleImage($filename,$dir){
	$image = basename($filename);
	$extention = explode('.',$image)[1];
	$width = 1280; 
	$height = 1280;
	$source ='';
	list($width_orig, $height_orig,$mime) = getimagesize($filename); 
	$ratio_orig = $width_orig/$height_orig; 
	$nwidth=$height*$ratio_orig;
	$nheight=$width/$ratio_orig;
	$nr=$nwidth / $nheight;
	$source = imagecreatefrompng($filename);
	if( $width < $nwidth ){
		$newwidth = $width;
	}else{
		$newwidth = $nwidth;
	}
	if( $height < $nheight ){
		$newheight = $height;
	}else{
		$newheight = $nheight;
	}
	/*$ratio_new=$newwidth/$newheight;
	echo $ratio_orig.'--'.$ratio_new;die;*/
	if($extention=='jpg' || $extention=='JPG'){
		$source = imagecreatefromjpeg($filename);
	}elseif($extention=='png' || $extention=='PNG') {
		$source = imagecreatefrompng($filename);
	}
	$dst = imagecreatetruecolor($newwidth, $newheight); 
	imagecopyresampled($dst, $source, 0, 0, 0, 0,$newwidth, $newheight, $width_orig, $height_orig);
	imagejpeg($dst,$filename);
	$s3 = vw_lx_s3_uploadto_s3();
	global $s3_settings;
	$bucket=$s3_settings['s3_bucket'];
	try{
		$result = $s3->putObject(
			array(
				'Bucket' => $bucket,
				'Key' => $dir.basename($filename),
				'SourceFile' => $filename,
				'StorageClass' => 'REDUCED_REDUNDANCY',
				'ACL'  => 'public-read'
		));
	}catch(S3Exception $e)
	{
		echo $e->getMessage() . "<br>";
	}
	return $result;
}

/* Attach Poll S3 Document */
function PollDocumentS3Upload( $atts ){
	global $s3_settings;
	$bucket = $s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	$poll_id = $atts['poll_id'];
	$file = $atts['file'];
	$dir = $atts['dir'];
	$upload = $s3->upload($bucket, $dir.$file['file']['name'], fopen($file['file']['tmp_name'], 'rb'), 'public-read');
	$media_path['filepath'] = $upload->get('ObjectURL');
	return $media_path; 
}
/* Delete Poll S3 Document */
function PollDocumentS3Delete( $atts ){
	global $s3_settings;
	$bucket = $s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	
	$results = $s3->listObjectsV2([
		'Bucket' => $bucket,
		'Prefix' => $atts['dir']
	]);
	
	$resarr = array();
	if (isset($results['Contents'])) {
		foreach ($results['Contents'] as $result) {
			$resarr[] =	$s3->deleteObject([
				'Bucket' => $bucket,
				'Key' => $result['Key']
			]);
		}
	}
	return $resarr;
} 
/**--------------------------------------------------------------------------------- **/