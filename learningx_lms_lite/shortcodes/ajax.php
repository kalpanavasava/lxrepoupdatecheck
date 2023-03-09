<?php 
/** Function to save the media **/
function get_podcasts(){
	global $wpdb;
	?>
	<script src="<?php echo plugins_url().'/essential-grid/public/assets/js/jquery.esgbox.min.js?ver=2.3.3';?>"></script> 
	<script src="<?php echo plugins_url().'/essential-grid/public/assets/js/jquery.themepunch.tools.min.js?ver=2.3.3';?>"></script>
	<script src="<?php echo plugins_url().'/essential-grid/public/assets/js/jquery.themepunch.essential.min.js?ver=2.3.3';?>"></script>
	</script>
	<?php
	include(dirname(dirname(__FILE__)).'/template/all-podcast.php');
	die();
}
add_action("wp_ajax_get_podcasts", "get_podcasts");
add_action( 'wp_ajax_nopriv_get_podcasts', 'get_podcasts' );
/**
 *@ For gettingthe PUBLIC liberary forum ** 
 **/
function get_pub_lib_forum(){
	global $wpdb;
	$podcast_taxonomy = get_terms( array(
						'taxonomy' => 'podcast_category',
						'hide_empty' => false,
						'orderby' => 'term_id'
						) );
	foreach($podcast_taxonomy as $podcast_taxonomy_data){
		$slug = $podcast_taxonomy_data->slug;
		$cnt = $podcast_taxonomy_data->count;
		$name = $podcast_taxonomy_data->name;
		if($cnt > 0){
			if($slug != 'sponsored'){
			?>
			<div class="mt-2 standarized_tab">
				<div class="standarized_tab_inner3">
					<?php echo strtoupper($name);?>
				</div>
			</div>
			<div class="pub_lib_forum">
			<?php 
			echo do_shortcode('[ess_grid alias="'.$slug.'"]'); ?>
			</div>
				<?php
			}
		}
	}
	die();
}
add_action("wp_ajax_get_pub_lib_forum", "get_pub_lib_forum");
add_action( 'wp_ajax_nopriv_get_pub_lib_forum', 'get_pub_lib_forum' );

/**** for get podcasts information ****/
function get_podcasts2(){
	global $wpdb;
	include(dirname(dirname(__FILE__)).'/template/mainfile.php');
	die();
}
add_action("wp_ajax_get_podcasts2", "get_podcasts2");
add_action( 'wp_ajax_nopriv_get_podcasts2', 'get_podcasts2' );

/**** for view more course content ****/
function view_more_content()
{
	global $color_palette,$square_icon,$breakpoint,$page_style;
	$last_show=$_POST['last_show'];
	$course_id=$_POST['course_id'];
	$total_content=$_POST['total_content'];
	$args=array(
		'post_type' => 'lx_lessons' , 
		'posts_per_page' => 4,	
		'offset'=>$last_show,
		'post_status'=>'publish',
		'meta_query' => array(
		   array(
			   'key' => 'course_id',
			   'value' => $course_id,
			   'compare' => '='
		   )
		),
		'orderby'=>'menu_order',
		'order'=>'ASC'
	);
	$course_content=get_posts($args);
	$i=$last_show+1;
	$ctr=$last_show;
	$ctrn='';
	$main_cnt[]='';
	$course=get_post($course_id);
	foreach ($course_content as $content) {
		global $lx_plugin_url;
		if($ctr == $last_show+3){
			$ctrn .= $ctr+1;
		}
		$main_cnt[] = $ctr;
		include($page_style['content_tile']);
		$i++;
		$ctr++;
	}
	if(count($main_cnt) < 3 || $ctr==$total_content){}else{
		$plus=$total_content-$ctrn;
	?>
		<div class="col-md-3 mt-5 more_btn_div">
			<span><i class="fa fa-plus" style="color: <?php echo $color_palette['charcoal'];?>"></i> <?php echo $plus;?></span>
		    <button class="btn_normal_state view_more_content" data-last_show="<?php echo $ctrn;?>" data-course_id="<?php echo $course_id;?>" data-total_content="<?php echo $total_content;?>" style="width:50%;">View</button>
		</div>
	<?php } 
	die;
}
add_action("wp_ajax_view_more_content", "view_more_content");
add_action( "wp_ajax_nopriv_view_more_content", "view_more_content" );

/**** for update my account information ****/
function update_my_accountinfo(){
	$user_id = $_POST['user_id'];
	$firstname = $_POST['firstname'];
	$last_name = $_POST['lastname'];
	$email=$_POST['email'];
	$user = get_user_by( 'email', $email );
	if($user && $user->ID!=$user_id){
		echo json_encode(array('status'=>0,'msg'=>"Email Already Exist!"));
		die();
	}
	update_user_meta($user_id,'first_name',$firstname);
	update_user_meta($user_id,'last_name',$last_name);
	wp_update_user( array( 'ID' => $user_id, 'user_email' => $email ) );
	echo json_encode(array('status'=>1,'msg'=>"Updated"));
		die();		 		
}
add_action("wp_ajax_update_my_accountinfo", "update_my_accountinfo");
add_action( 'wp_ajax_nopriv_update_my_accountinfo', 'update_my_accountinfo' );

/**** for rearrange lesson order ****/
function rearrange_lesson_order(){
	foreach ($_POST['order_arr'] as $key => $value) {
		$order=$key+1;
		$menu_order = array(
			'ID' => $value, 
			'menu_order'=>$order
		);
		wp_update_post($menu_order);
	}
	echo "lesson_order_arranged";
	die;
}
add_action("wp_ajax_rearrange_lesson_order", "rearrange_lesson_order");
add_action( 'wp_ajax_rearrange_lesson_order', 'rearrange_lesson_order' );
?>