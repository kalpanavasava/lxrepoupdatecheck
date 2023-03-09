<?php
	global $lx_plugin_urls,$color_palette;
	/* $post_title_len = wp_strip_all_tags($post_title);
	if(strlen($post_title_len) > 20 ){
		$post_title = substr($post_title_len, 0, 19);		
		$length = strripos($post_title,' ');	
		$post_title = substr($post_title, 0, $length).'...';
	}else{
		$post_title = $post_title_len;
	}
	$post_subtitle_len = wp_strip_all_tags($sub_title);
	if(strlen($post_subtitle_len) > 20 ){
		$sub_title = substr($post_subtitle_len, 0, 20);		
		$length = strripos($sub_title,' ');	
		$sub_title = substr($sub_title, 0, $length).'...';
	}else{
		$sub_title = $post_subtitle_len;
	} */			
	if(!empty($thumbnail_image)){ 
		$thumb_img = $thumbnail_image; 
	}else{ 
		$thumb_img = $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg'; 
	} 
?>
<style>
.styleX_main_div{
	border-top:1px solid <?php echo $color_palette['mid_grey']; ?>;
	border-bottom:1px solid <?php echo $color_palette['mid_grey']; ?>;
}
</style>
<div class="styleX_main_div" <?php echo $border_left;?>>
	<div class="row no-gutters">
		<div class="col-sm-4">
			<div class="p-2">
				<img class="card-img" src="<?php echo $thumb_img;?>">
			</div>
		</div>
		<div class="col-sm-8">
			<div class="card-body com_body p-2">
				<div class="card-title community_title">	
					<a <?php echo $post_id; ?> href="<?php echo get_permalink($post_id);?>" style="width: 100%;text-decoration: none;"><h3 class="head_h3"><?php echo $post_title;?></h3>
					</a>
				</div>
				<div class="community_subtitle">	
					<h6 class="head_h6"><?php echo $sub_title;?></h6>
				</div>
			</div>
		</div>
	</div>
</div>
