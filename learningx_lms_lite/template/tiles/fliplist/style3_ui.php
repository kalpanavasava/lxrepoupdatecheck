<?php
global $lx_plugin_urls,$square_icon,$breakpoint;

?>
<div class="<?php echo $breakpoint['class']; ?>">
	<div class="card style_3_card my-2">
		<?php 
			$author_id=get_post($post_id)->post_author;
			if((current_user_can('administrator') || current_user_can('site_owner') || current_user_can('community_owner')) && get_current_user_id()==$author_id){
			?>
			<form action="<?php echo site_url().'/create-fl1plist/';?>" method="post">
				<input type="hidden" name="fliplist_id" value="<?php echo $post_id;?>">
				<button type="submit" class="btn_normal_state btn_edit_icon btn_edit_tiles mt-1 mx-1"><i class="<?php echo $square_icon['edit'];?>"></i></button>
			</form>
			<?php
			}
		?>
		<div class="card-image py-1 px-1">
			<?php if(!empty($thumbnail_image)){ ?>
			<a href="<?php echo get_permalink($post_id);?>">
				<img class="card-img-top" src="<?php echo $thumbnail_image;?>" alt="Card image cap">
			</a>
		<?php }else{ ?>
				<a href="<?php echo get_permalink($post_id);?>">
				<img class="card-img-top" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/flip_thumbnail.png';?>" alt="Card image cap">
			</a>
		<?php } ?>
		</div>
		<div class="card-body" style="padding: 0.5rem;text-align: left;">
			<div class="title"><a href="<?php echo get_permalink($post_id);?>"><h3 class="head_h3"><?php  echo $post_title;  ?></h3></a></div>
			<?php 
			if( !empty($sub_title) ){
			?>
			<div class="sub_title"><p><?php echo $sub_title ?></p></div>					
			<?php } ?>
			<?php 
			if(strlen($post_description) > 90 ){
				$post_description = substr($post_description, 0, 90);		
				$length = strripos($post_description,' ');	
				$post_description = substr($post_description, 0, $length).'...';
			}else{
				$post_description = $post_description;
			}
			?>
			<div class="description"><p><?php echo FnFormatMytextNLignore( $post_description ); ?></p></div>	
		<div>											
		<a href="<?php echo get_permalink($post_id);?>"><span style="float: left;"><button type="button" class="btn btn_normal_state btn-view" style="padding: 2px 15px;float:right;float:right;margin-right: 5px;">View</button></span></a>
		</div>
		</div>
	</div>
</div>