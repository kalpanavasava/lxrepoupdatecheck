<?php 
global $lx_plugin_urls,$color_palette,$lx_lms_settings,$community_tiles_interface,$square_icon,$breakpoint; 
/* echo "<pre>";print_r($community_tiles_interface); */
?>
<style>
.style_5_main_div .mepr-price-box-button , .style_5_main_div .mepr-price-box-button:hover , .style_5_main_div .mepr-price-box-button:focus{	
	padding-top: 9px !important;
}

.community_row .status_bar{
	opacity:<?php echo $community_tiles_interface['tiles_colored_bg_opacity'];?> !important;
}
.c_desc .subtitle{
	color : <?php echo $community_tiles_interface['tiles_body_text_color']; ?> !important;
}
.hm_btn{
	height:unset;
	font-size: 12px;
	bottom: 70px;
}
.hm_btn:hover{
	height:unset;
}
</style>
<div class="<?php echo $breakpoint['class']; ?>">
	<?php 
	/* echo "<pre>";print_r($color_palette['blue']); */
	if(!empty($thumbnail_image)){ $thumb_img = $thumbnail_image; }else{ $thumb_img = $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg'; } ?>
	<a <?php echo $post_id; ?> href="<?php echo get_permalink($post_id);?>" style="width: 100%;text-decoration: none;">
		<div class="card style_5_main_div my-2" style="border: 2px solid <?php echo $color_palette['border'];?>;">

			<div class="mepr-price-box-title">
				<?php
					$author_id=get_post($post_id)->post_author;
					if((current_user_can('administrator') || current_user_can('site_owner') || current_user_can('community_owner')) && get_current_user_id()==$author_id){
					?>
					<div style="display:flex;flex:1;">
						<h3 class="head_h3" style="flex:0.8;"><?php echo $post_title; ?></h3>
						<form action="<?php echo site_url().'/create-fl1plist/';?>" method="post">
						<input type="hidden" name="fliplist_id" value="<?php echo $post_id;?>">
						<button type="submit" class="btn_normal_state btn_edit_icon btn_edit_tiles mt-1 mx-1"><i class="<?php echo $square_icon['edit'];?>"></i></button>
						<button type="submit" class="btn_normal_state btn_edit_icon btn_edit_tiles mt-1 mx-1"><i class="<?php echo $square_icon['edit'];?>"></i></button>
						</form>
					</div>
					<?php
					}else{
				?>
					<h3 class="head_h3"><?php echo $post_title; ?></h3>
				<?php } ?>
			</div>
			
			<div class="card-body community_tile_body" style="text-align: center;">
				<div class="community_thumb" style="background-image: url(<?php echo $thumb_img;?>);background-repeat: no-repeat;background-size: cover;">
					<div class="status_bar" style ="background-color:<?php echo $community_tiles_interface['tiles_colored_background']?> !important; <?php echo $overlay_clr;?> !important;">
						<div class="subtitle">	
							<h6 class="head_h6 subtitle" style="color:<?php echo $community_tiles_interface['tiles_body_text_color']; ?> ;"><?php echo $sub_title;?></h6>
						</div>
						<span class="community_type_color description_body"><?php echo $ctype;?></span>
						<div class="c_desc description_body"><?php  echo $post_description; ?></div>
					</div>
					
							<div class="hm_btn mepr-price-box-button btn_normal_state <?php echo $class;?>" data-community_id="<?php echo $post_id;?>" style="<?php echo $btn_color;?>">View</div>
							
					
				</div>
				<div class="row" style="min-height: 40px;">
					<div class='col-md-6'>
						<div style="background-color:<?php echo $color_palette['green'];?>;color:#fff;">
						<?php 
							if(in_category('featured',$post_id)){
								echo "FEATURED";
							} 
						?>
						</div>
					</div>
					
				</div>				
			</div>
		</div>
	</a>
</div>