<?php 
global $square_icon,$breakpoint,$font_family,$color_palette; 
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
		font-size: 8em;
	}
	.articulate_activity.alt_link_icon{		
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
<div class="<?php echo $breakpoint['class'];?> d-flex">
<?php
	$user_id=get_current_user_id();
	if($post->post_author==$user_id){
		?>
		<div class="div_top_right">
			<form method="post" action="<?php echo site_url().'/create-articulate-content/';?>">
				<input type="hidden" name="articulate_id" value="<?php echo $post->ID;?>">
				<button type="submit" name="articulate_edit" class="btn_normal_state btn_edit_icon"><i class="<?php echo $square_icon['edit']; ?>"></i></button>
			</form>
		</div>
	<?php } ?>
	
	<div class="card articulate_content_card style_6_main_div" data-lession_id="<?php echo $post->ID;?>" data-content_type="<?php echo $content_type; ?>" data-type="lx_articulate">
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
		<a href="<?php echo get_permalink($post->ID);?>">
		<div class="alt_icon_main_div <?php echo $max_width_info; ?>">
			<div class="card-image articulate_activity alt_link_icon">
				<i class="<?php echo $icon.' '.$icon_style; ; ?>"></i>
			</div>
			<div class="card-body mt-2">
				<h3 class="head_h3 card-title articulate_title mb-0"><?php echo $post->post_title;?></h3>
			</div>
			
		</div>
		</a>
	</div>
</div>