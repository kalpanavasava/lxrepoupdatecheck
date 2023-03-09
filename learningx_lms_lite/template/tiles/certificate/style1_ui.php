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
	<div class="card">
		<div class="card-image">
			<?php 
				$image = $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg';
				if( !empty($thumbnail) ){
					$image = $thumbnail;
				}
			?>
			<img src="<?php echo $image;?>" style="width:100%;">
		</div>
		<div class="category"><span class="small"></span></div>
		<div class="card-body" style="padding: 0.5rem;">
			<div class="card-title content_title mb-0">	
				<h3 class="head_h3">Certificate</h3>
			</div>
			<?php
			$completedbg = get_option('user_interface_color_palette')[strtolower(get_option('user_interface_color_palette')['course_completed'])];
			$partiallybg = get_option('user_interface_color_palette')[strtolower(get_option('user_interface_color_palette')['course_partially_completed'])];
			?>
			<div style="margin-top:10px;">
				<hr class="course_info_hr">
				<span style="display: flex;margin: auto;">
				<?php 
				if( $ctr == count($progress) ){
				?>
				<div class="content_status" style="background: <?php echo $completedbg;?>;"></div>
				<span class="course_status" style="color:<?php echo $color_palette['hyperlinks']; ?>;">Available</span></span>
				<?php }else{
				?>
				<div class="content_status" style="background: <?php echo $partiallybg;?>;"></div>
				<span class="course_status" style="color:<?php echo $color_palette['hyperlinks']; ?>;">Course is incomplete</span></span>
				<?php
				} ?>
				<hr class="course_info_hr">
			</div>
			<div style="display:flex;margin-top: 10px;">
			<?php 
			if( $ctr == count($progress) ){
				?>
				<a <?php echo $target; ?> href="<?php echo $unique_str; ?>">
					<button type="button" class="btn_normal_state" style="position: relative;margin:2px;">View</button>
				</a>
				<?php
			}else{
				?>
				<button type="button" class="btn_disabled_state" style="position: relative;margin:2px;">View</button>
				<?php
			}
			?>
			</div>
		</div>
	</div>
</div>
