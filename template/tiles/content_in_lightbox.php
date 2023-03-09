<?php
global $lightbox_settings,$tiles_style,$lx_plugin_paths,$color_palette,$font_family,$page_devider;
$course_id=get_post_meta($content->ID,'course_id',true);
if(get_post_meta($course_id,'display_in',true)=='in_community'){
	$category=get_the_terms($course_id,'membership_tag')[0]->name;
}else{
	$category="";
}
$content_type=get_post_meta($content->ID,'content_type',true);
?>
<style>
	/* .card{
		cursor: pointer;
	} */
	<?php if($content_type=='poll'){ ?>
		.modal_iframe_<?php echo $content->ID;?>{
			overflow: scroll;
		}
	<?php }else{ ?>
		.modal_iframe_<?php echo $content->ID;?>{
			overflow: hidden !important;
		}
	<?php }?>
	content_course_title{
		text-align: right;
		font-family: <?php echo $font_family['body_font'];?>;
		color: <?php echo $color_palette['hyperlinks'];?>;
		font-size:1em;
	}
	.content_title{
		font-family: <?php echo $font_family['heading_font'];?>;
		color: <?php echo $color_palette['hyperlinks'];?>;
		min-height: 47px;
	}
	.modal_iframe_<?php echo $content->ID;?> .modal-dialog{
	  position: relative;
	  max-width:unset;
	  width: 100%;
	  margin:unset;
	}
	.content_activity{
	    height: 150px;
	    background-color:<?php echo $color_palette['hyperlinks'];?>;
	    text-align: center;
	    padding-top: 62px;
	    color: #FFF;
	}
	.modal_iframe_<?php echo $content->ID;?>{
		background: <?php echo $lightbox_settings['bg_overlay_color'];?>;
		padding: unset !important;
	}
	.modal_iframe_<?php echo $content->ID;?> .modal-header{
		background: <?php echo $lightbox_settings['modal_header_color'];?>;
		align-items: center;
	} 
	.modal_iframe_<?php echo $content->ID;?> .close{
		color: <?php echo $lightbox_settings['modal_header_icon_color'];?>;
	} 
	.modal_iframe_<?php echo $content->ID;?> .content_body{
		background: <?php echo $lightbox_settings['modal_body_color'];?>;
	} 
	.modal_iframe_<?php echo $content->ID;?> .modal-content{
		border: 1px solid <?php echo  $lightbox_settings['modal_border_color']; ?>;
	}
	.modal_iframe_<?php echo $content->ID;?> .content_body object{
	  position: relative;
	  width: 100%;
	  height: calc(100vh - 112px);
	}
	.modal_iframe_<?php echo $content->ID;?> .modal-title{
		color: <?php echo $lightbox_settings['modal_title_color'];?>;
		font-size: <?php echo $lightbox_settings['modal_title_size'];?>;
		flex: 1;
		text-align:<?php echo $lightbox_settings['modal_top_bar_title_alignment'];?>;
		padding-left: 10px;
	}
	.content_card{
		z-index: 99;
	}
</style>
<div class="<?php echo $breakpoint['class'];?>">
	<?php 
		$site_icon=get_option('site_icon');
		$favicon=wp_get_attachment_image_src( $site_icon , 'full' );
		$user_id=get_current_user_id();
		$completed=0;
		$color='';
		$progress=lx_lesson_progress($content->ID);
		$bg=$progress['background'];
		$status=$progress['status'];
		$post_title = $content->post_title;
		$info = "course_content_info";
		$open_in = 'lightbox';
		$thumbnail_image = get_post_meta($content->ID,'module_thumb',true);
		$content_data=get_post_meta($content->ID,'xapi_content',true);
		if( !empty($content_data) ){
			if( trim($status) == 'In progress' ){
				?>
				<input type="hidden" class="tilelboxlessonid" value="<?php echo $content->ID; ?>" />
				<input type="hidden" class="tilelboxcid<?php echo $content->ID; ?>" value="<?php echo $course_id; ?>" />
				<input type="hidden" class="tilelboxactid<?php echo $content->ID; ?>" value="<?php echo $content_data['activity_id']; ?>" />
				<?php
			}
		}
		if(!empty($tiles_style['course_content_tile'])){
			include($tiles_style['course_content_tile'] );
		}else{
			include($lx_plugin_paths['lx_lms_lite'].'template/tiles/tiles_style_3_ui.php' );
		}
	?>
</div>
<?php 
global $square_icon;
?>
<div class="modal modal_iframe_<?php echo $content->ID?>" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header lb_if_header">
			<?php
			/* vwpr($square_icon['close_icon']); */
			$lesson_progress = lx_lesson_progress($content->ID);
			
			if( !isset($lightbox_settings['favicon_visibility']) || $lightbox_settings['favicon_visibility']=="ON" ){ ?>
					<img src="<?php echo $favicon[0]; ?>" class="alt_modal_favicon" style="width:40px;float: left;"></img>
			<?php } ?>
			<h4 class="modal-title"><?php echo $content->post_title;?></h4>
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
			}?>
      </div>
      <div class="modal-body content_body">
    		
      </div>
    </div>
  </div>
</div>
<script>
	jQuery(document).on('click','.modal_iframe_'+<?php echo $content->ID?>+" .mdl_close",function(e){
		e.preventDefault();
		jQuery('body').css('position','relative');
		jQuery('.main-navigation').show();
		jQuery('.loggedin_logo').show();
		jQuery('.site-info').show();
		jQuery('.modal_iframe_'+<?php echo $content->ID?>).hide();
		jQuery('.modal-backdrop').remove();
		
		/** check if it is completed **/
		var checkstatus = jQuery('.card_course_content_lightbox .course_status_'+<?php echo $content->ID?>).html();
		
		var tileno = jQuery('.course_content_tileno_'+<?php echo $content->ID?>).val();
		var textcolor = global_var.hyperlinks_color;
		if( tileno == 2 ){
			textcolor = '#fff';
		}
		
		if( jQuery('.card_course_content_lightbox .course_content_type_'+<?php echo $content->ID?>).val() !== 'poll' ){
		
			var actid = jQuery('.modal_iframe_'+<?php echo $content->ID?>+" #activity_id").val();
			if( actid !== undefined && jQuery.trim(checkstatus) !== 'Completed' ){
				var completedStmts = LRSDataGet( actid );
				if( completedStmts.statements.length > 0 ){
					jQuery('.lp-screen').show();
					var post_data = {
						'activity': actid,
						'lesson_id': <?php echo $content->ID?>,
						'endtime': completedStmts.statements[0].stored,
						'action' : 'savexapidata'
					}
					jQuery.ajax({
						url: ajax_ob.ajax_url,
						type: 'POST',
						data: post_data,
						success: function(response){
							jQuery('.card_course_content_lightbox .content_status_'+<?php echo $content->ID?>).css('background',global_var.course_completed_color);
							jQuery('.card_course_content_lightbox .course_status_'+<?php echo $content->ID?>).css('color',textcolor);
							jQuery('.card_course_content_lightbox .course_status_'+<?php echo $content->ID?>).html('Completed');
							jQuery('.lp-screen').hide();
						}
					});
				}
			}
		}
		if( jQuery('.card_course_content_lightbox .course_content_type_'+<?php echo $content->ID?>).val() == 'poll' && checkstatus !== 'Completed' ){
			/** call ajax to fetch from the database **/
			jQuery('.lp-screen').show();
			var post_id = <?php echo $content->ID?>;
			var post_data = {
				'post_id': post_id,
				'action' : 'getpollcompletedstatus'
			}
			jQuery.ajax({
				url: ajax_ob.ajax_url,
				type: 'POST',
				data: post_data,
				success: function(response){
					if( jQuery.trim(response) == 'completed' ){
						jQuery('.card_course_content_lightbox .content_status_'+<?php echo $content->ID?>).css('background',global_var.course_completed_color);
						jQuery('.card_course_content_lightbox .course_status_'+<?php echo $content->ID?>).css('color',textcolor);
						jQuery('.card_course_content_lightbox .course_status_'+<?php echo $content->ID?>).html('Completed');
					}
					/* if( response = 'in_progress' ){
						jQuery('.card_course_content_lightbox .content_status_'+<?php echo $content->ID?>).css('background',global_var.course_partially_completed_color);
						jQuery('.card_course_content_lightbox .course_status_'+<?php echo $content->ID?>).css('color',global_var.hyperlinks_color);
						jQuery('.card_course_content_lightbox .course_status_'+<?php echo $content->ID?>).html('In progress');
					} */
					jQuery('.lp-screen').hide();
				}
			});
		}
	});
</script>