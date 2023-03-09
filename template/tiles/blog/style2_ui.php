<?php

global $lx_plugin_urls,$square_icon,$color_palette,$style_2_tiles_interface;

$btn_disabled = '';$btn_class = 'btn_normal_state';$isviewwidth = 'width:50%;';
$redirect_link = get_permalink($post_id);
$thumbnail_image = get_post_meta($post_id,'lxed_thumbnail_image',true);	
?>
<style>
	.blogtilefavicon{
		position: relative;
		width: 35px;
		height: 35px;
		padding: 3px;
	}
	.blog_title{
		font-family: Cera Pro Bold;
		margin-top: 15px !important;
		font-size: 18px !important;
		line-height: 19px !important;
		font-weight: 700 !important;
	}
</style>
<div class="card">
	<?php 
		$author_id=get_post($post_id)->post_author;
		$commBlogAuthorIds = explode(',',get_post_meta($community_id,'community_blog_author_id',true));
		
		if( is_super_admin() || current_user_can('site_owner') || current_user_can('community_owner') || ( in_array($user_id,$commBlogAuthorIds) && current_user_can('community_blog_author') ) && get_current_user_id()==$author_id ){
		?>
		<form method="post" id="lxed_fm_edit" action="<?php echo site_url().'/create-blog-post/';?>">
			<input type="hidden" name="mode" value="edit">
			<input type="hidden" name="lxed_blog_post_id" class="hid_lxed_blog_post_id" value="<?php echo $post_id;?>">
			<input type="hidden" name="lxed_blog_post_status" class="hid_lxed_blog_post_status" value="<?php echo get_post($post_id)->post_status;?>">
			<input type="hidden" id="lx_community" class="lx_community" name="lx_community" value="<?php echo $community_id;?>">
			<button type="submit" style="z-index: 1;" class="btn_normal_state btn_edit_icon btn_edit_tiles" name="lxed_edit_mode"><i class="<?php echo $square_icon['edit'];?>"></i></button>
		</form>
		<?php
		}
	?>
	<div class="card-image" style="position:relative;">
		<?php if(!empty($thumbnail_image)){ ?>
			<a href="<?php echo $redirect_link;?>">
				<img class="card-img-top" src="<?php echo $thumbnail_image;?>" alt="Card image cap">
			</a>
		<?php }else{ ?>
				<a href="<?php echo $redirect_link;?>">
				<img class="card-img-top" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg';?>" alt="Card image cap">
			</a>
		<?php } ?>
		<?php 
		if(!empty($com_id)){ 
			$is_parent_com = get_post($com_id)->post_parent;
			$faviconblog = '';
			if( $is_parent_com == 0 ){
				$faviconblog = get_post_meta($com_id,'community_favicon_path',true);
			}else{
				$faviconblog = get_post_meta($com_id,'community_favicon_path',true);
				if(empty($faviconblog)){
					$get_parent_comm = get_post($com_id)->post_parent;
					$faviconblog = get_post_meta($get_parent_comm,'community_favicon_path',true);
				}
			}
			if(!empty($faviconblog)){
			?>
				<div style="position:absolute;bottom:51px;"><img class="blogtilefavicon" src="<?php echo $faviconblog;?>" /></div>
			<?php }
		} ?>
		<div class="row div_bottom div_bottom_course" style="background: <?php echo $style_2_tiles_interface['completion_bg_color']; ?>;opacity: 95%;height:50px;display: flex;align-items: center;padding: 5px;margin:unset;">
			<div class="col-md-6" style="margin-left:auto;">
				<a href="<?php echo $redirect_link;?>"  style="<?php echo $stylefr; ?>;margin-right: 5px;">
					<button class="<?php echo $btn_class;?> w-100" <?php echo $btn_disabled;?> style="position: relative;margin-left:12px;">View</button>
				</a>
			</div>
		</div>
	</div>
	<div class="card-body" style="padding: 0.5rem;">
		<div class="card-title blog_title mb-0">	
			<a href="<?php echo $redirect_link; ?>"><h3 class="head_h3"><?php echo get_post($post_id)->post_title;?></h3></a>
		</div>
	</div>
</div> 


