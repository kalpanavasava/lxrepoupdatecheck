<?php
	global $color_palette,$font_family,$page_devider,$tiles_style,$lx_plugin_paths;
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
		min-height: 47px;
	}
	.content_status1{
		width: 22px;
	    height: 22px;
	    border: 2px solid <?php echo $color_palette['border'];?>;
	    border-radius: 50%;
	    flex-basis: 22px;
	    flex-shrink: 0
	}
	.associated_course{
		display: flex;
	}
	.associated_course img{
		width: 30%;
		margin: 10px;
		border: 1px solid <?php echo $color_palette['border'];?>;
	}
	.associated_course span{
		margin-top: 12px;
		min-height: 2.2em;
		font-family: <?php echo $font_family['heading_font'];?>;
	}
	.content_title a, .content_title a :hover, .content_title a :focus{
		color:<?php echo $color_palette['hyperlinks'];?>;
	}
	.content_course_title a , .content_course_title a :hover , .content_course_title a :focus {
		color:<?php echo $color_palette['hyperlinks'];?>;
	}
</style>
<?php
	if(is_user_logged_in())
	{
		$link=get_permalink($content->ID);
	}else{
		$link=site_url().'/login/';
	}
?>
<div class="<?php echo $breakpoint['class'];?>">
	<?php 
		$user_id=get_current_user_id();
		$completed=0;
		$progress=lx_lesson_progress($content->ID);
		$bg=$progress['background'];
		$status=$progress['status'];
		$post_title = $content->post_title;
		$info = "course_content_info";
		$thumbnail_image = get_post_meta($content->ID,'module_thumb',true);
		if(!empty($tiles_style['course_content_tile'])){
			include ( $tiles_style['course_content_tile'] );
		}else{
			include ( $lx_plugin_paths['lx_lms_lite'].'template/tiles/tiles_style_3_ui.php' );
		}
	?>		
</div>