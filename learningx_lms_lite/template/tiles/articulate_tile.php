<?php
global $lightbox_settings,$color_palette,$font_family,$page_devider,$page_style,$square_icon,$tiles_style,$lx_plugin_paths;
?>
<style>
	.div_top_right {
		position: absolute;
		top: 8px;
		right: 30px;
		display: flex;
		z-index: 99;
	}
	.btn_edit_icon, .btn_delete_icon{
		height: 35px !important;
		width: 35px !important;
		padding: 6px 8px !important;
		min-width:unset !important;
		margin: 2px;
	}
	.btn_edit_icon:hover,.btn_delete_icon:hover{
		height: 35px;
		width: 35px;
		padding: 6px 8px !important;
		min-width:unset !important;
		margin: 2px;
	}
	.btn_edit_icon:hover,.btn_delete_icon:focus{
		height: 35px;
		width: 35px;
		padding: 6px 8px !important;
		min-width:unset !important;
		margin: 2px;
	}
	.content_activity{
	    height: 150px;
	    color: <?php echo $color_palette['hyperlinks'];?>;
	    text-align: center;
	    background-color: #FFF;
	}
	.articulate_activity{
		color: <?php echo $color_palette['hyperlinks'];?>;
	}
	/* .articulate_activity svg{		
		font-size: 8em;
	} */
	.articulate_activity .alt_photo_video_icon{		
		font-size: 4em;
	}
	.articulate_activity .alt_link_icon{		
		font-size: 4em;
	}
	.style_6_main_div .alt_resource_url{
		min-height: 9.2em;
	}
	.articulate_title{
		font-family:<?php echo $font_family['heading_font'];?>;
		color: <?php echo $color_palette['hyperlinks'];?>;
	}
	.articulate_title{
		position: relative;
		top: 25%;
		left: 0%;
	}
	.articulate_content_card{
		width: 100%;
	}
	.articulate_content_card a{
		margin: auto;
		width: 100%;
		padding: 10px 10px;
		height:100%;
	}
	.alt_icon_main_div{
		display:flex;
		align-items: center;
	}
	@media(max-width: 767px){
		.div_top_right{
			top: 15px !important;
		}
	}
</style>
<?php
$content=get_post_meta($post->ID,'xapi_content',true);
$view_selection = get_post_meta($post->ID,'alt_view_selection',true);
if($open_in=='lightbox' || $view_selection == 'popup'){
	?>
<style>	
	.modal_iframe_<?php echo $post->ID;?> .modal-dialog{
	  position: relative;
	  max-width:unset;
	  width: 100%;
	  margin:unset;

	}
	.modal_iframe_<?php echo $post->ID;?>{
		background: <?php echo $lightbox_settings['bg_overlay_color'];?>;
		padding: unset !important;
	}
	.modal_iframe_<?php echo $post->ID;?> .modal-header{
		background: <?php echo $lightbox_settings['modal_header_color'];?>;
	} 
	.modal_iframe_<?php echo $post->ID;?> .close{
		color: <?php echo $lightbox_settings['modal_header_icon_color'];?>;
	} 
	.modal_iframe_<?php echo $post->ID;?> .content_body{
		background: <?php echo $lightbox_settings['modal_body_color'];?>;
	} 
	.modal_iframe_<?php echo $post->ID;?> .modal-content{
		border: 1px solid <?php echo  $lightbox_settings['modal_border_color']; ?>;
	}
	.modal_iframe_<?php echo $post->ID;?> .content_body object{
	  position: relative;
	  width: 100%;
	  height: calc(100vh - 112px);
	}
	/* .card{
		cursor:pointer;
	} */
</style>
<?php 
	if(!empty($tiles_style['articulate_tile'])){
		include ( $tiles_style['articulate_tile'] );
	}else{
		include ( $lx_plugin_paths['lx_lms_lite'].'template/tiles/tiles_style_4_ui.php' );
	}
?>
<?php }else{
?>
<style>
	.content_course_title{
		text-align: right;
		font-family: <?php echo $font_family['body_font'];?>;
		color: <?php echo $color_palette['hyperlinks'];?>;
		font-size:1em;
	}
	.content_title{
		font-family: <?php echo $font_family['heading_font'];?>;
		color: <?php echo $color_palette['hyperlinks'];?>;
	}
}
</style>
<?php
	if(!empty($tiles_style['articulate_tile'])){
		include ( $tiles_style['articulate_tile'] );
	}else{
		include ($lx_plugin_paths['lx_lms_lite'].'template/tiles/tiles_style_4_ui.php' );
	}
} ?>