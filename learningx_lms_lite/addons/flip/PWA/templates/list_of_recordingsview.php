<?php 
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
	
	$recording_arrays[] = array(
							'recid'=>$recid,
							'rec_title'=>get_post( $recid )->post_title,
							'rec_subtitle'=>get_post( $recid )->post_title,
							'rec_additional_notes'=>get_post_meta( $recid ,'additional_notes',true ),
							'thumbnail_image'=>$thumbnailimg,
							'flag'=>'downloaded',
						);
}

echo json_encode( $recording_arrays );

?>