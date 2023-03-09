<?php
global $lx_plugin_urls,$square_icon,$breakpoint; 
$post=get_post($post_id);
?>
<div class="<?php echo $breakpoint['class'];?>">
	<div class="card fr_card fr_style2">
		<div class="card-image fr_card_img">
			<a href="<?php echo get_permalink($post_id); ?>">
				<?php
					$author_id=$flip_recording->post_author;
					if((current_user_can('administrator') || current_user_can('site_owner') || current_user_can('community_owner')) && get_current_user_id()==$author_id){
				?>
				<form method="post" action="<?php echo site_url().'/create-fl1p-recording/';?>">
					<input type="hidden" name="recording_id" value="<?php echo $post_id;?>">
					<button type="submit" class="btn_normal_state btn_edit_icon fr_card_edit"><i class="<?php echo $square_icon['edit']?>"></i></button>
				</form>
				<?php } ?>
				<?php 
					$image=get_post_meta($post_id,'thumbnail_image',true)['cropped'];
					if(empty($image)){
						$image=$lx_plugin_urls['lx_lms_lite']."assets/img/flip_thumbnail.png";
					}
				?>
				<img class="card-img-top" src="<?php echo $image;?>" alt="Card image cap">
			</a>
		</div>
		<div class="fr_center_bar_div">
			<div class="fr_view_btn">
				<a href="<?php echo get_permalink($post_id); ?>">
					<button type="button" class="btn_normal_state">View</button>
				</a>
			</div>
		</div>
		<div class="card-body fr_card_body">
			<div class="card-title fr_card_title mb-2 mt-2">	
				<a href="<?php echo get_permalink($post_id); ?>">
					<h3 class="head_h3"><?php echo $post->post_title;?></h3>
				</a>
			</div>
			<?php $subtitle=get_post_meta($post_id,'subtitle',true); ?>
			<div class="fr_card_subtitle"><?php echo $subtitle;?></div>
		</div>
	</div>
</div>
