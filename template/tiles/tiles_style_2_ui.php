<?php 
global $lx_plugin_urls,$lx_plugin_paths,$style_2_tiles_interface;
if( $info == "course_content_info" ){
	$url = $link;
}elseif(!is_user_logged_in() && $info=='course_info'){
	$data=base64_encode('is_purchase=yes&course_id='.$post_id);
	$redirect_link=site_url().'/login/'.$data;
}else{
	$redirect_link = get_permalink( $post_id );
}

if($info=='community_info'){
	include $lx_plugin_paths['lx_lms_lite'].'template/tiles/community/style2_ui.php';
}elseif($info=='course_info'){
	include $lx_plugin_paths['lx_lms_lite'].'template/tiles/course/style2_ui.php';
}else{
	include $lx_plugin_paths['lx_lms_lite'].'template/tiles/course_content/style2_ui.php';
}
?>