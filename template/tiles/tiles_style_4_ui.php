<?php 
global $frontend_icon,$breakpoint,$lx_plugin_paths;
if($content_type == 'articulate_web'){
	$view_selection = get_post_meta($post->ID,'alt_view_selection',true);
}
if(isset($resource_type)){
	if( $resource_type == 'resource_url' ){
		$resource_link = get_post_meta($post->ID,'web_url',true);
		if(isset($frontend_icon['articulate_popups_link']) && !empty($frontend_icon['articulate_popups_link'])){
			$icon = $frontend_icon['articulate_popups_link'];
		}else{ 
			$icon = "fad fa-link"; 
		}
		$bootstrap_class = $breakpoint['class'];
		$icon_style = 'alt_link_icon';
		$max_width_info = 'alt_resource_url';
	} else {
		if(isset($frontend_icon['articulate_popups']) && !empty($frontend_icon['articulate_popups'])){
			$icon = $frontend_icon['articulate_popups'];
		}else{ 
			$icon = "fad fa-photo-video"; 
		}
		/* $bootstrap_class ='col-xxl-3 col-lg-4 col-md-6'; */
		$bootstrap_class = $breakpoint['class'];
		$icon_style = 'alt_photo_video_icon';
		$max_width_info = 'alt_resource_zip';
	}
}
?>
<div class="<?php echo $bootstrap_class; ?> equal-height mt-3">
<?php
if( $resource_type == 'resource_url' ){
	if( $view_selection == '' || $view_selection=="new_tab" ){
		$view = 'page';
	} else if($view_selection=="popup"){
		$view = 'popup';
	}
} else if( $resource_type == 'zip_package' ){
	if( ( $open_in=='in_page' || $open_in == '' ) && $open_in !='lightbox' ){
		$view = 'page';
	} else if($open_in=="lightbox"){
		$view = 'popup';
	}
}
if( $open_in=='in_page' || $open_in=='' || $view=="page" ){
	include $lx_plugin_paths['lx_lms_lite'].'template/tiles/articulate/articulate_open_in_page.php';
} else if($view=="popup"){
	include $lx_plugin_paths['lx_lms_lite'].'template/tiles/articulate/articulate_open_in_lightbox.php';
}
?>
</div>