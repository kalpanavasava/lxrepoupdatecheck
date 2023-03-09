<?php global $square_icon; 
if(!empty($content_type) && $content_type=='poll'){
	$content_type='poll';
}else{
	$content_type='xapi';
}
$login='not_login';
if(is_user_logged_in()){
	$login='login';
}
?>
<style>
	.card_course_content_lightbox{
		cursor: pointer;
	}
</style>
<div class="card <?php if( $open_in == "lightbox" ){ echo "content_card card_course_content_lightbox"; } ?> style_3_main_div <?php if( $info == "course_content_info" ){ echo "default_com_info"; } ?>" data-lession_id="<?php echo $content->ID;?>" data-content_type="<?php echo $content_type;?>" data-is_login="<?php echo $login;?>">
	<div class="content_thumb">
		<?php 
			if(!empty($thumbnail_image)){
				$image=$thumbnail_image;
			}else{
				$image=$lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg';
			}
		?>
		<a <?php if( $open_in != "lightbox" ){ ?> href="<?php echo $redirect_link;?>" <?php } ?> style="position: relative;">
			<?php 
				$post_id=$content->ID;
				$course_id=get_post_meta($post_id,'course_id',true);
				$content_type=get_post_meta($post_id,'content_type',true);
				if($content_type=='poll'){
					$url=site_url().'/create-poll/';
					$name="poll_id";
				}else{
					$url=site_url().'/create-xapi-content/';
					$name="lesson_id";
					$xapi_cat=get_post_meta($post_id,'tool',true);
					$content_type='xapi';
				}
				$author_id=get_post($post_id)->post_author;
				if((current_user_can('administrator') || current_user_can('site_owner') || current_user_can('community_owner')) && get_current_user_id()==$author_id){
				?>
				<form action="<?php echo $url;?>" method="post">
					<?php if($content_type!='poll'){ ?>
					<input type="hidden" name="xapi_content_category" value="<?php echo $xapi_cat;?>">
					<?php } ?>
					<input type="hidden" name="course_id" value="<?php echo $course_id;?>">
					<input type="hidden" name="<?php echo $name;?>" value="<?php echo $post_id;?>">
					<button type="submit" class="btn_normal_state btn_edit_icon btn_edit_tiles"><i class="<?php echo $square_icon['edit'];?>"></i></button>
				</form>
				<?php
				}
			?>
			<img src="<?php echo $image;?>" style="width:100%;">
			<?php if(!empty($favicon_img)){ ?>
				<span class="home_favicon"><img src="<?php echo $favicon_img; ?>" class="style3_fav_img"></span> 
			<?php } ?>
		</a>
	</div>
	<div class="card-title content_title">
		<?php if($open_in == "lightbox"){
			?><h3 class="head_h3"><?php echo $post_title;?></h3><?php
		}else{ ?>
			<a href="<?php echo $redirect_link; ?>"><h3 class="head_h3"><?php echo $post_title;?></h3></a>
		<?php } ?>
	</div>
	<div style="display: flex;align-items: center;">
		<div style="width:50%;">
			<?php
			if( $open_in != "lightbox" ){
			?>
				<a href="<?php echo $redirect_link;?>">
					<button class="btn_normal_state" style="position: relative;margin:2px;">View</button>
				</a>
			<?php }else{
				?>
				<button type="button" class="btn_normal_state" style="position: relative;margin:2px;">View</button>
				<?php
			} ?>
		</div>
		<?php
			/* if( $open_in != "lightbox" ){ 
			$width = "50%";
		?>
			<div style="width:50%;">
				<a href="<?php echo $redirect_link;?>">
					<button class="btn_normal_state" style="position: relative;margin:2px;">View</button>
				</a>
			</div>
		<?php } else{ 
			$width = "100%"; 
		?>
		<style>
			.content_status{
				margin-left:0px;
			}
		</style>
		<?php
			}  */
		?>
		<div class="view_status_div" style="width:<?php echo $width; ?>;">
			<div class="view_content_status_div" style="float:left;">
				<div class="content_status content_status_<?php echo $content->ID;?>" style="background: <?php echo $bg;?>;" data-status="<?php echo $completed;?>"></div>
				<span class="course_status course_status_<?php echo $content->ID;?>" style="color:<?php echo $color_palette['hyperlinks']; ?>;"><?php echo $status;?></span>
			</div>
		</div>
		<input type="hidden" class="course_content_type_<?php echo $content->ID;?>" value="<?php echo $content_type;?>" />
		<input type="hidden" class="course_content_tileno_<?php echo $content->ID;?>" value="3" />
	</div>
</div>