<?php
	global $lx_plugin_urls,$color_palette,$square_icon;			
	if(!empty($thumbnail_image)){ 
		$thumb_img = $thumbnail_image; 
	}else{ 
		$thumb_img = $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg'; 
	} 
?>

<div class="col-md-3 mt-3 col-xxl-3 col-lg-4 col-md-4 col-sm-6">
	<div class="styleX_main_div border-top border-bottom" style="border:none">

		<div class="row no-gutters">
			<div class="col-sm-4 py-2 px-2">
				<div class="card-image">
				<?php if(!empty($thumbnail_image)){ ?>
				<a href="<?php echo $url;?>">
					<img class="card-img-top" src="<?php echo $thumbnail_image;?>" alt="Card image cap">
				</a>
			<?php }else{ ?>
				<a href="<?php echo $url;?>">
					<img class="card-img-top" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg';?>" alt="Card image cap">
				</a>
			<?php } ?>
			</div>
			</div>
			
			<div class="col-sm-8">
				<?php
				$author_id=get_post($post_id)->post_author;
				if((current_user_can('administrator') || current_user_can('site_owner') || current_user_can('community_owner')) && get_current_user_id()==$author_id){
				?>
				<form action="<?php echo site_url().'/create-fl1plist/';?>" method="post">
					<input type="hidden" name="fliplist_id" value="<?php echo $post_id;?>">
					<button type="submit" class="btn_normal_state btn_edit_icon btn_edit_tiles mt-2"><i class="<?php echo $square_icon['edit'];?>"></i></button>
				</form>
				<?php
				}
			?>
				<div class="card-body com_body p-2">
					<div class="card-title community_title">	
						<div class="title"><a <?php echo $post_id; ?> href="<?php echo get_permalink($post_id);?>" style="width: 100%;text-decoration: none;"><h3 class="head_h3"><?php echo $post_title;?></h3>
						</a></div>
					</div>
					<div class="sub_title">	
						<h6 class="head_h6"><?php echo $sub_title;?></h6>
					</div>
					<div class="description"><?php echo $post_description ?></div>
				</div>
			</div>
		</div>
	</div>
</div>