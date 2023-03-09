<?php
	if( isset($resource_type) && $resource_type == 'resource_url' && $view_selection == 'new_tab' ){
		$target = "_blank";
		$class_info = "rm_link_".$post->ID;
	} else{
		$target = "";
		$class_info = "";
	}
	$user_id=get_current_user_id();
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
		<a href="<?php echo get_permalink($post->ID);?>" <?php if(!empty($target)){ echo "target=".$target; } ?> class="<?php echo $class_info;	?>">
		<div class="alt_icon_main_div <?php echo $max_width_info; ?>">
			<div class="card-image articulate_activity">
				<i class="<?php echo $icon.' '.$icon_style; ; ?>"></i>
			</div>
			<div class="card-body mt-2">
				<h3 class="head_h3 card-title articulate_title mb-0"><?php echo $post->post_title;?></h3>
			</div>
			
		</div>
		</a>
	</div>
