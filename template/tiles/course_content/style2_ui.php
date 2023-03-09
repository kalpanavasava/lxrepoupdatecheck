<?php 
global $square_icon,$style_2_tiles_interface;
$content_type=get_post_meta($content->ID,'content_type',true);
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
	.favicon_course{
		display: contents;
	}
</style>
<div class="card style_2_main_div <?php if( $open_in == "lightbox" ){ echo "content_card card_course_content_lightbox"; } ?>" data-lession_id="<?php echo $content->ID;?>" data-content_type="<?php echo $content_type;?>" data-is_login="<?php echo $login;?>">
	<div class="card-image">
		<?php 
			if(!empty($thumbnail_image)){
				$image=$thumbnail_image;
			}else{
				$image=$lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg';
			}
		?>
		<a <?php if( $open_in != "lightbox" ){ ?> href="<?php echo $url;?>" <?php } ?> style="position: relative;">
			<?php 
				$post_id=$content->ID;
				$course_id=get_post_meta($post_id,'course_id',true);
				$content_type=get_post_meta($post_id,'content_type',true);
				if($content_type=='poll'){
					$urle=site_url().'/create-poll/';
					$name="poll_id";
				}else{
					$urle=site_url().'/create-xapi-content/';
					$name="lesson_id";
					$xapi_cat=get_post_meta($post_id,'tool',true);
					$content_type='xapi';
				}
				$author_id=get_post($post_id)->post_author;
				if((current_user_can('administrator') || current_user_can('site_owner') || current_user_can('community_owner')) && get_current_user_id()==$author_id){
				?>
				<form action="<?php echo $urle;?>" method="post">
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
			<img class="card-img-top" src="<?php echo $image;?>" alt="Card image cap">
		</a>
	
		<div class="div_bottom div_bottom_course" style="background: <?php echo $style_2_tiles_interface['completion_bg_color']; ?>;opacity: 95%;height:50px;display: flex;align-items: center;">
			<span class="favicon favicon_course" style="width:50%;" >
				<div class="content_status content_status_<?php echo $content->ID;?>" style="background: <?php echo $bg;?>;"></div>
				<span class="course_status course_status_<?php echo $content->ID;?>" style="width: 50%;color:<?php echo $style_2_tiles_interface['completion_status_color']; ?>;"><?php echo $status;?></span>
			</span>
			<?php if( $open_in != "lightbox" ){ ?>
				<a href="<?php echo $url;?>" style="width:50%;margin:auto;"><span style="float: right;"><button  class="btn_normal_state btn-view" data-status="<?php echo $completed;?>">View</button></span></a>
			<?php } ?>
		</div>
		<input type="hidden" class="course_content_type_<?php echo $content->ID;?>" value="<?php echo $content_type;?>" />
		<input type="hidden" class="course_content_tileno_<?php echo $content->ID;?>" value="2" />
	</div>
	<div class="card-body" style="padding: 0.9rem;">
		<div class="card-title content_title mb-0">
			<?php if($open_in == "lightbox"){
				?><h3 class="head_h3"><?php echo $post_title;?></h3><?php
				}else{ ?>
					<a href="<?php echo $url; ?>"><h3 class="head_h3"><?php echo $post_title;?></h3></a>
			<?php } ?>
		</div>
	</div>
</div>