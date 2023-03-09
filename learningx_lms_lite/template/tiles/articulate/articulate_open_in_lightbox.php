<?php 
	$user_id=get_current_user_id();
	$site_icon=get_option('site_icon');
	$favicon=wp_get_attachment_image_src( $site_icon , 'full' );
	if($post->post_author==$user_id){
?>
	<div class="div_top_right">
		<form method="post" action="<?php echo site_url().'/create-articulate-content/';?>">
			<input type="hidden" name="articulate_id" value="<?php echo $post->ID;?>">
			<button type="submit" name="articulate_edit" class="btn_normal_state btn_edit_icon"><i class="<?php echo $square_icon['edit']; ?>"></i></button>
		</form>
		<span class="btn_danger_state btn_delete_icon articulate_delete" data-post_id="<?php echo $post->ID;?>"><i class="<?php echo $square_icon['trash']; ?>"></i></span>
	</div>
<?php } ?>
	<div class="card content_card card_course_content_lightbox articulate_content_card style_6_main_div" data-lession_id="<?php echo $post->ID;?>" data-content_type="<?php echo $content_type; ?>" data-type="lx_articulate" style="z-index:1;">
		<?php 
		$author_id=$post->post_author;
		if((current_user_can('administrator') || current_user_can('site_owner') || current_user_can('community_owner')) && get_current_user_id()==$author_id){
			if( $post->post_status == 'publish' ){
			?>
			<div style="position:absolute;background-color:<?php echo $color_palette['green'];?>;color:#fff;    padding: 0px 5px;">
				PUBLISH
			</div>
			<?php } 
		}?>
		<div class="alt_icon_main_div <?php echo $max_width_info; ?>">
			<div class="card-image articulate_activity">
				<i class="<?php echo $icon.' '.$icon_style; ; ?>"></i>
			</div>
			<div class="card-body mt-2">
				<h3 class="head_h3 card-title articulate_title mb-0"><?php echo $post->post_title;?></h3>
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