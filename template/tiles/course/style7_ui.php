<?php
	global $lx_plugin_urls,$color_palette;
	/* $post_title_len = wp_strip_all_tags($post_title);
	if(strlen($post_title_len) > 50 ){
		$post_title = substr($post_title_len, 0, 40);		
		$length = strripos($post_title,' ');	
		$post_title = substr($post_title, 0, $length).'...';
	}else{
		$post_title = $post_title_len;
	} */			
	if(!empty($thumbnail_image)){ 
		$thumb_img = $thumbnail_image; 
	}else{ 
		$thumb_img = $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg'; 
	} 
?>
<style>
.course_category_featured{
	color:white;
	background-color:<?php echo $color_palette['hyperlinks'];?>;
	text-align:center;
	margin-bottom: -8px;
}
.course_draft_status{
	color:white;
	background-color:<?php echo $color_palette['red'];?>;
	text-align:center;
	margin-left:8px;
	margin-bottom: -8px;
}
.course_publish_status{
	color:white;
	background-color:<?php echo $color_palette['green'];?>;
	text-align:center;
	margin-left:8px;
	margin-bottom: -8px;
}
</style>
<div class="card style7_main_div">
	<div class="row">
		<div class="col-md-4 col-xs-4 col-4">
			<?php if( $post_status == 'draft' ){?>
				<div class="course_draft_status">Draft</div>
			<?php	
			}
			if( $post_status == 'publish' ){?>
				<div class="course_publish_status">Published</div>
			<?php		
			}
			?>
		</div>	
		<div class="col-md-4 col-xs-4 col-4"></div>
		<div class="col-md-4 col-xs-4 col-4 text-left">
			<?php if(in_category('featured',$course_id)){ ?>
				<div class="course_category_featured">FEATURED</div>
			<?php
				}
			?>
		</div>
	</div>
	<div class="row no-gutters">
		<div class="col-sm-6">
			<div class="p-2">
				<img class="card-img" src="<?php echo $thumb_img;?>">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="card-body com_body p-2">
				<div class="card-title course_title">	
					<a <?php echo $course_id; ?> href="<?php echo $url;?>" style="width: 100%;text-decoration: none;"><h3 class="head_h3"><?php echo $post_title;?></h3>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
