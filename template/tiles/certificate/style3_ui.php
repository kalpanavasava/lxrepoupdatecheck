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
	<div class="card style_3_main_div" data-lession_id="" data-content_type="" data-is_login="">
		<div class="content_thumb">
			<?php 
				$image = $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg';
				if( !empty($thumbnail) ){
					$image = $thumbnail;
				}
			?>
			<img src="<?php echo $image;?>" style="width:100%;">
		</div>
		<div class="card-title content_title">
			<h3 class="head_h3">Certificate</h3>
		</div>
		<div style="display: flex;align-items: center;">
			<?php
			$completedbg = get_option('user_interface_color_palette')[strtolower(get_option('user_interface_color_palette')['course_completed'])];
			$partiallybg = get_option('user_interface_color_palette')[strtolower(get_option('user_interface_color_palette')['course_partially_completed'])];
			if( $ctr == count($progress) ){
			?>
			<div style="width:50%;">
				<a <?php echo $target;?> href="<?php echo $unique_str;?>" style="position: relative;"><button type="button" class="btn_normal_state" style="position: relative;margin:2px;">View</button></a>
			</div>
			<div class="view_status_div" style="width:50%;">
				<div class="view_content_status_div" style="float:left;">
					<div class="content_status" style="background: <?php echo $completedbg;?>;" data-status="<?php echo $completed;?>"></div>
					<span class="course_status" style="color:<?php echo $color_palette['hyperlinks']; ?>;">Available</span>
				</div>
			</div>
			<?php }else{
				?>
				<div style="width:50%;">
					<button type="button" class="btn_disabled_state" style="position: relative;margin:2px;">View</button>
				</div>
				<div class="view_status_div d-flex align-items-center" style="height: 35px;">
					<div class="view_content_status_div" style="float:left;">
						<div class="content_status" style="background: <?php echo $partiallybg;?>;" data-status="<?php echo $completed;?>"></div>
						<span class="course_status" style="color:<?php echo $color_palette['hyperlinks']; ?>;">Course is incomplete</span>
					</div>
				</div>
				<?php
			} ?>
		</div>
	</div>
</div>