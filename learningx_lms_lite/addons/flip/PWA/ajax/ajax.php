<?php
/** Save Recording **/

add_action( 'wp_ajax_PWADownloadOffline', 'PWADownloadOffline');
add_action( 'wp_ajax_nopriv_PWADownloadOffline', 'PWADownloadOffline');
function PWADownloadOffline(){
	$fliplistid = $_POST['defaultfliplistid'];
	global $wpdb,$lx_plugin_urls;

	$userid = get_current_user_ID();
	
	$get_all_recording = $wpdb->get_results("select pm.* from ".$wpdb->prefix."posts as p,".$wpdb->prefix."postmeta as pm where pm.post_id=p.ID and p.post_type='flip_recording' and p.post_status='publish' and pm.meta_key like '%total_fliplist%'");
								
	$is_fliplist_exist = array();
	foreach( $get_all_recording as $flplists ){
		$meta_value = unserialize( $flplists->meta_value );
		if(!empty($meta_value)){
			if( in_array( $fliplistid ,$meta_value ) ){
				$is_fliplist_exist[] = $flplists->post_id;
			}
		}
	}

	$recording_arrays = array();
	foreach( $is_fliplist_exist as $recid ){
		$thumbnailimg = $lx_plugin_urls['lx_lms_lite'].'assets/img/flip_thumbnail.png';
		if(!empty(get_post_meta( $recid ,'thumbnail_image',true ))){
			$thumbnailimg = get_post_meta( $recid ,'thumbnail_image',true )['cropped'];
		}
		
		$audio_file ='';
		if(!empty(get_post_meta( $recid, 'flip_recording_audio', true ))){
			$audio_file = get_post_meta( $recid, 'flip_recording_audio', true );
		}
		
		$multiplefiles = get_post_meta( $recid ,'recording_multiple_image_path',true );
		$mfar = array();
		if(!empty($multiplefiles)){
			foreach( $multiplefiles as $data ){
				$mfar[] = $data['resized'];
			}
		}
			/* echo "<pre>";print_r($mfar);
		die(); */
		$recording_arrays[] = array(
								'audio_blob'=>$audio_file,
								'recid'=>$recid,
								'rec_title'=>get_post( $recid )->post_title,
								'rec_subtitle'=>get_post_meta( $recid ,'subtitle',true ),
								'multiple_files' => $mfar,
								'rec_additional_notes'=>get_post_meta( $recid ,'additional_notes',true ),
								'thumbnail_image'=>$thumbnailimg,
								'settings'=>json_encode(get_post_meta( $recid, 'settings_array', true )),
								'total_fliplist'=>json_encode(get_post_meta( $recid, 'total_fliplist', true )),
								'flag'=>'downloaded',
							);
	}
	
	echo json_encode( $recording_arrays );
	die();
}

add_action( 'wp_ajax_pwasaveRecording', 'pwasaveRecording');
add_action( 'wp_ajax_nopriv_pwasaveRecording', 'pwasaveRecording');
function pwasaveRecording(){
	
	$uid = get_current_user_ID();
	$defaultfliplistargs = array(
			'post_status' => 'publish',
			'post_type' => 'flip_list',
			'posts_per_page' => -1,
			'author' => $uid,
			'meta_query' => array(
					array(
						'key' => 'registertimelist',
						'value' => 1,
					)
			)
		);
	$getdefaultfliplistargs = get_posts( $defaultfliplistargs );			

	$defaultfliplistid = $getdefaultfliplistargs[0]->ID;
	
	$rectitlear = explode(',',$_POST['rectitle']);
	$recsubtitlear = explode(',',$_POST['rec_subtitle']);
	$keys = explode(',',$_POST['key']);
	$flag = explode(',',$_POST['flag']);
	if( !empty($keys) ){
		foreach( $keys as $key=>$val ){
			if( $flag[$key] == 'new' ){
				$rectitle = $rectitlear[$key];
				$recsubtitle = $recsubtitlear[$key];
				
				/** audio blob **/
				$audiofiles = $_FILES['audios_blob'.$val];
				
				/** multiimage blob **/
				$multisliderimage = array();$i=0;$file_path = array();
				foreach( $_FILES as $keymulimg=>$imgslider_data ){
					if( explode('_',$keymulimg)[0] == 'multi' ){
						$file_name = explode('.',$_FILES[$keymulimg]['name'])[0].'_'.$i.'_'.$key.'.'.explode('.',$_FILES[$keymulimg]['name'])[1];
						
						$filename_resized = explode('.',$_FILES[$keymulimg]['name'])[0].'_'.$i.'_'.$key.'_resized.'.explode('.',$_FILES[$keymulimg]['name'])[1];
						$_FILES[$keymulimg]['name'] = $file_name;
						
						$multisliderimage[] = $_FILES[$keymulimg];
						
						$data = file_get_contents($_FILES[$keymulimg]['tmp_name']);
						$url = wp_upload_dir()['url'].'/'.$filename_resized;
						$path = wp_upload_dir()['path'].'/'.$filename_resized;
						$upload =file_put_contents($path, $data);
						$file_path[] = $path;
						$i++;
					}
				}
				
				$argsnewpost = array(
							'post_author'  => get_current_user_ID(),
							'post_title'  => 'temp-recording',
							'post_status' => 'draft',
							'post_type'	  => 'flip_recording',
						);
				$argspostget = $argsnewpost;
				unset($argspostget['post_author']);
				$argspostget['author'] = get_current_user_ID();
				
				if(empty(get_posts($argspostget))){
					$unsetpost_title = get_posts($argspostget);
					$argsnewpost['author'] = get_current_user_ID();
					$recid = wp_insert_post( $argsnewpost );
				}else{
					$recid = get_posts($argspostget)[0]->ID;
				}
				
				if( !empty($recid) ){
					update_post_meta($recid,'subtitle',$recsubtitle);
					update_post_meta($recid,'total_fliplist',array($defaultfliplistid));
				}
				
				if( !empty($file_path) ){
					$arrsliderimg = array(
						'recording_id' => $recid,
						'files' => $multisliderimage,
						'path' => $file_path,
						'dir' => 'site-assets/fl1p-recording/'.$recid.'/slider/'
					);
					
					$upload = RecordingMultipleImageUploadS3($arrsliderimg);
			
					update_post_meta($recid,'recording_multiple_image_path',$upload);
					
					foreach( $file_path as $allpaths ){
						unlink($allpaths);
					}
				}
				
				$uploadpath = wp_upload_dir()['path'];
				$user_id = get_current_user_id();
				$arr = array(
					'recording_id'=>$recid,
					'files' => $audiofiles,
					'dir' => 'site-assets/fl1p-recording/'.$recid.'/audio/'
				);
				$upload = RecordingUploadS3($arr);
				update_post_meta($recid,'flip_recording_audio',$upload['audio']);
				
				$argsupdate = array(
						  'ID' => $recid,
						  'post_status' => 'publish',
						  'post_title' => $rectitle,
						 );
				wp_update_post($argsupdate);
			}
		}
		echo $_POST['key'];
	}
	/* echo json_encode($data); */
	die;
}