<?php global $square_icon,$breakpoint,$color_palette; ?>
<?php 
$user_id = get_current_user_id();
$display_name = get_user_by('id',$user_id)->display_name;
$fname = get_user_meta( $user_id, 'first_name', true );
$lname = get_user_meta( $user_id, 'last_name', true );
if( !empty($fname) && !empty($lname) ){
	$display_name = $fname .' '. $lname;
}
$course_title = get_post( $contentcarouselcourse )->post_title;
$author_id = get_post( $contentcarouselcourse )->post_author;
$completion_time = max($end_time);
$post_info = $contentcarouselcourse;
$unique_str = site_url() .'/certificate/'. base64_encode($user_id.'##'.$post_info.'##'.$completion_time);

$ctr = 0;
if( !empty($progress) ){
	foreach( $progress as $p ){
		if( $p['status'] == 'Completed' ){
			$ctr +=1;
		}
	}
}
$target = '';
if( $lbcontent == 'yes' ){
	$target = 'target="_blank"';
}
$thumbnail = get_post_meta( $community_id, 'community_thumbnail_path' ,true );
?>
<div class="<?php echo $breakpoint['class'];?>">
	<div class="card style_2_main_div" data-lession_id="" data-content_type="" data-is_login="">
		<div class="card-image">
			<?php 
				$image = $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg';
				if( !empty($thumbnail) ){
					$image = $thumbnail;
				}
			?>
			<img src="<?php echo $image;?>" style="width:100%;">
			
			<?php
			$completedbg = get_option('user_interface_color_palette')[strtolower(get_option('user_interface_color_palette')['course_completed'])];
			$partiallybg = get_option('user_interface_color_palette')[strtolower(get_option('user_interface_color_palette')['course_partially_completed'])];
			if( $ctr == count($progress) ){
			?>
				<div class="div_bottom div_bottom_course" style="background: <?php echo $style_2_tiles_interface['completion_bg_color']; ?>;opacity: 95%;height:50px;display: flex;align-items: center;">
					<span class="favicon favicon_course" style="width:50%;" >
						<div class="content_status" style="background: <?php echo $completedbg;?>;"></div>
						<span class="course_status" style="width: 50%;color:<?php echo $style_2_tiles_interface['completion_status_color']; ?>;">Available</span>
					</span>
					<a <?php echo $target;?> href="<?php echo $unique_str;?>" style="width:50%;margin:auto;"><span style="float: right;"><button  class="btn_normal_state btn-view" data-status="<?php echo $completed;?>">View</button></span></a>
				</div>
			<?php }else{
				?>
				<div class="div_bottom div_bottom_course" style="background: <?php echo $style_2_tiles_interface['completion_bg_color']; ?>;opacity: 95%;height:50px;display: flex;align-items: center;">
					<span class="favicon favicon_course" style="width:50%;" >
						<div class="content_status" style="background: <?php echo $partiallybg;?>;"></div>
						<span class="course_status" style="width: 50%;color:<?php echo $style_2_tiles_interface['completion_status_color']; ?>;">Course is incomplete</span>
					</span>
					<div style="width: 50%;margin: auto;"><span style="float: right;"><button  class="btn_disabled_state btn-view" data-status="<?php echo $completed;?>">View</button></span></div>
				</div>
				<?php
			} ?>
		</div>
		<div class="card-body" style="padding: 0.9rem;">
			<div class="card-title content_title mb-0">
				<h3 class="head_h3">Certificate</h3>
			</div>
		</div>
	</div>
</div>