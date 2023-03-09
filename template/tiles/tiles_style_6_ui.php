<?php 
	global $lx_plugin_urls;
?>
<style>
	.sub_com_main{
		display: flex;	
		align-items: center;
	}
	.sub_com_img{
		margin: 10px 0;
	}
</style>
<div class="row">
	<div class="card col-md-12" style="border:none;">
		<a href="<?php echo get_permalink($post_id ); ?>" class="sub_com_main">
			<div class="col-md-4 col-4">
				<?php if(!empty($thumbnail_image)){ ?>			
					<img class="card-img-top sub_com_img" src="<?php echo $thumbnail_image;?>" alt="Card image cap">		
				<?php }else{
					?>			
					<img class="card-img-top sub_com_img" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg';?>" alt="Card image cap">		
				<?php } 
				if(!empty($favicon_img)){ ?>
					<span class="home_favicon"><img src="<?php echo $favicon_img; ?>" style="position: absolute;left: 18px;width: 10%;bottom: 18%;"></span> 
				<?php } ?>
			</div>
			<div class="col-md-8 col-8">
				<div class="card-title card_blog_title  sub_community_title mb-0">
					<h5><?php echo $post_title; ?></h5>
				</div>
				<p class="card-text card_blog_description about lx_lms_sub_text">
					<?php echo $post_description;?>
				</p>
			</div>
		</a>
	</div>
</div>	
	