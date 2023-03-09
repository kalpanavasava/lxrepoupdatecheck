<?php global $square_icon,$breakpoint,$lx_plugin_urls; 
/* $content_type=get_post_meta($content->ID,'content_type',true); */
?>
<div class="<?php echo $breakpoint['class'];?>">
	<div class="card <?php if( $open_in == "lightbox" ){ echo "content_card card_course_content_lightbox"; } ?>" data-content_type="<?php echo $content_type;?>" data-lession_id="<?php echo $post->ID;?>" data-is_login="<?php echo $login;?>">
		<div class="card-image">
			<?php 
				$thumbnail_image = get_post_meta( $post->ID , 'articulate_web_thumb' , true );
				if(!empty($thumbnail_image)){
					$image=$thumbnail_image;
				}else{
					$image=$lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg';
				}
			?>
			<a  <?php if( $open_in != "lightbox" ){ ?>href="<?php echo get_permalink($post->ID);?>"<?php } ?> style="position: relative;">
				<?php 
					$post_id=$post->ID;
					$author_id=get_post($post_id)->post_author;
					$user_id=get_current_user_id();
					if($author_id==$user_id){
					?>
					<form style="position: absolute;float: right;right: 0;" action="<?php echo site_url().'/create-articulate-content/';?>" method="post">
						<input type="hidden" name="articulate_id" value="<?php echo $post->ID;?>">
						<button type="submit" name="articulate_edit" class="btn_normal_state btn_edit_icon"><i class="<?php echo $square_icon['edit']; ?>"></i></button>
					</form>
					<?php
					}
				?>
				<img class="card-img-top" src="<?php echo $image;?>" alt="Card image cap">
				<?php if(!empty($favicon_img)){ ?>
					<span class="home_favicon"><img src="<?php echo $favicon_img; ?>" class="fav_img"></span> 
				<?php } ?>
			</a>
		</div>
		<div class="category"><span class="small"><?php echo $tag;?></span></div>
		<div class="card-body" style="padding: 0.5rem;">
			<div class="card-title content_title mb-0">	
				<?php if($open_in == "lightbox"){
					?><h3 class="head_h3"><?php echo $post->post_title;?></h3><?php
				}else{ ?>
					<a href="<?php echo get_permalink($post->ID);?>"><h3 class="head_h3"><?php echo $post->post_title;?></h3></a>
				<?php } ?>
			</div>
			<?php if($open_in != "lightbox"){ ?>
			<div style="display:flex;margin-top: 10px;">
				<a href="<?php echo get_permalink($post->ID);?>"><span><button  class="btn_normal_state" data-status="<?php echo $completed;?>">View</button></span></a>
			</div>
			<?php }else{
					?>
					<button type="button" class="btn_normal_state" style="position: relative;margin:2px;">View</button>
					<?php
				} ?>
		</div>
	</div>
</div>

<div class="modal modal_iframe_<?php echo $post->ID;?> style_6_modal_main_div" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<?php 
			if( !isset($lightbox_settings['favicon_visibility']) || $lightbox_settings['favicon_visibility']=="ON" ){ ?>
				<img src="<?php echo $favicon[0]; ?>" class="alt_modal_favicon" style="width:40px;float: left;"></img>
			<?php } ?>
			<h4 class="modal-title alt_modal_title"><?php echo $post->post_title;?></h4>
			<?php if($lightbox_settings['lb_closetext'] == 'on' && $lightbox_settings['lb_closebutton'] != 'on' ){ ?>
					<div class="close mdl_close" style="cursor:pointer;font-size: <?php echo $lightbox_settings['modal_title_size'];?>;" data-dismiss="modal" aria-label="Close"><i style="color:<?php echo $lightbox_settings['modal_header_icon_color'];?>" class="<?php echo $square_icon['close_icon'];?>"></i> <span style="color:<?php echo $lightbox_settings['modal_title_color'];?>">Close</span></div>
			<?php }elseif($lightbox_settings['lb_closebutton'] == 'on' && $lightbox_settings['lb_closetext'] != 'on' ){
				?>
				<button data-dismiss="modal" type="button" class="btn_normal_state mdl_close"><i class="<?php echo $square_icon['close_icon'];?>"></i></button>
				<?php
			}elseif($lightbox_settings['lb_closebutton'] == 'on' && $lightbox_settings['lb_closetext'] == 'on' ){
				?>
				<button data-dismiss="modal" type="button" class="btn_normal_state mdl_close"><i class="<?php echo $square_icon['close_icon'];?>"></i> Close</button>
				<?php
			}else{
				?>
				<i data-dismiss="modal" style="font-size: <?php echo $lightbox_settings['modal_title_size'];?>;cursor:pointer;color:<?php echo $lightbox_settings['modal_header_icon_color'];?>" class="<?php echo $square_icon['close_icon'];?> mdl_close"></i>
				<?php
			} ?>
		</div>
		<div class="modal-body content_body">
			
		</div>
	</div>
  </div>
</div>
<script>
	jQuery(document).on('click','.modal_iframe_<?php echo $post->ID?> .mdl_close',function(e){
		e.preventDefault();
		 jQuery('.alt-iframe').each(function(index) {
			jQuery(this).attr('src', jQuery(this).attr('src'));
			return false;
		  });
		jQuery('body').css('position','relative');
		jQuery('.modal_iframe_<?php echo $post->ID;?>').hide();
		jQuery('.modal-backdrop').remove();
	});
</script>