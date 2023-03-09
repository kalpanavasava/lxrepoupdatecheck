<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}
get_header(); 
global $wpdb,$post,$lx_plugin_urls,$square_icon,$color_palette;
$post_id = get_the_ID();

if( !is_user_logged_in() || current_user_can('subscriber') ){
	echo "<div class='text-center' style='color:".$color_palette['red']."'>You are not allowed to view this page</div>";
	return;
}
/* if ( have_posts() ) : the_post(); */
?>
<style>
.breadcrumbs_fliplist_nav{	
	background:  <?php echo $color_palette['light_grey'];?>;
    padding: .5rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.nav_fliplist_parent_community_name{	
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.nav_fliplist_parent_community_name:hover{	
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.nav_fliplist_parent_community_name:focus{	
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.flipreclist_innerdiv{
	border-top: 2px solid <?php echo $color_palette['border'];?>;
    border-bottom: 2px solid <?php echo $color_palette['border'];?>;
    margin: -2px 10px 0px 10px;
}
.flipreclist_div::-webkit-scrollbar {
	width: 5px;
	background-color: #ccc;
}
.flipreclist_div::-webkit-scrollbar-track {
	-webkit-box-shadow: inset 0 0 6px #333;
	background-color: #ccc;
}
.flipreclist_div::-webkit-scrollbar-thumb {
	background-color: <?php echo $color_palette['hyperlinks'];?>;
	border: 0px solid <?php echo $color_palette['charcoal'];?>;
}
.add_new_recording_div{
	text-align:center;
	border:2.5px solid <?php echo $color_palette['border'];?>;
	border-style:dashed;
	border-radius: 5px;
    padding: 15px;
	color: <?php echo $color_palette['hyperlinks'];?>;
	cursor:pointer;
}
</style>
<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
	<main id="main" <?php generate_do_element_classes( 'main' );  ?>>
		<div class="entry-content" itemprop="text">
			<?php
			if( function_exists('FliplistViewPageBreadcrumbs')) { 
				FliplistViewPageBreadcrumbs($post_id); 
			} else { ?>
				<div class="breadcrumbs_fliplist_nav" style="width:100%;margin-top:0px;">
					<span><?php echo get_post($post->ID)->post_title; ?></span>
				</div>
			<?php
			} 
			?>
			<article>
				<div class="container-fluid fliplist_content_main">
					<div class="row fliplist_content">
						<div class="col-md-4 content_tab1">
							<div class="fliplist_thumb_content">
								<?php
								$fliplist_thumb = get_post_meta($post->ID,'fliplist_cropped_thumb')[0];
								if( empty($fliplist_thumb) ){
									$fliplist_thumb = $lx_plugin_urls['lx_lms_lite'].'assets/img/flip_thumbnail.png';
								} 
								?>		
								<div class="thumb"><img src="<?php echo $fliplist_thumb; ?>"/>
								</div>								
							</div>
							<div style="padding: 1px;">
								<?php 
								if( is_user_logged_in() ) { 
									$user_id = get_current_user_id();
									$author_id = $post->post_author;
									if( $user_id == $author_id ) {
								?>
									<div class="edit_fliplist pt-2">
										<form method="post" action="<?php echo site_url().'/create-fl1plist/';?>">
											<input type="hidden" name="fliplist_id" value="<?php echo $post->ID;?>">
											<button class="btn btn_normal_state btn_edit_fliplist" type="submit"><i class="<?php echo $square_icon['edit'];?>"></i></button>
										</form>
									</div>
									<?php 
									}
								} 
								?>
							</div>
							<div>
								<?php
								if( !is_user_logged_in() ){
								?>
								<a href="<?php echo wp_login_url();?>"> <button class="btn_normal_state w-100 mt-2">Login / Register</button></a>
									 <?php
								}
								?>
							</div>
						</div>
						<div class="col-md-8 content_tab2">
							<div class="fliplist_detail_content">
								<div class="col-sm-12">
									<div class="fliplist_title_main_div" id="style-4">
										<div class="fliplist-title">
											<h3 class="head_h3"> <?php echo the_title(); ?></h3>
										</div>
										<?php
										$sub_title = get_post_meta( get_the_ID(),'fliplist_subtitle')[0];
										if( !empty($sub_title) ){ ?>
										<div class="fliplist-subtitle">
											<h4 class="head_h4">
											<?php 
												echo $sub_title;
											?>
											</h4>
										</div>
										<?php 
										} 
										?>
										<div class="fliplist-description scrollbar pt-2" id="style-4">
										<?php echo FnFormatMytext( get_post($post->ID)->post_content );?>
										</div>
									</div>
								</div>
							</div>
							<!--<div class="add_new_recording_div">
								<a href="<?php /* echo site_url().'/fl1p-recording/'; */?>" class="add_new_recording_btn">Add new Recording</a>
							</div>-->
							<?php 
							$get_all_recording = $wpdb->get_results("select pm.* from ".$wpdb->prefix."posts as p,".$wpdb->prefix."postmeta as pm where pm.post_id=p.ID and p.post_type='flip_recording' and p.post_status='publish' and pm.meta_key like '%total_fliplist%'");
							
							$is_fliplist_exist = array();
							foreach( $get_all_recording as $flplists ){
								$meta_value = unserialize( $flplists->meta_value );
								if(!empty($meta_value)){
									if( in_array( $post_id ,$meta_value ) ){
										$is_fliplist_exist[] = $flplists->post_id;
									}
								}
							}
							
							/* echo "<pre>";print_r($is_fliplist_exist); */
							
							?>
							<div class="recordinglist">
								<div class="row p-3 flipreclist_div">
									<?php 
									foreach( $is_fliplist_exist as $pid ){
										
									$recthumbimg = $lx_plugin_urls['lx_lms_lite'].'assets/img/flip_thumbnail.png';
									if( !empty(get_post_meta($pid,'thumbnail_image',true)) ){
										$recthumbimg = get_post_meta($pid,'thumbnail_image',true)['cropped'];
									}
										
									?>
									<div class="row p-3 flipreclist_innerdiv">
										<div class="col-md-2">
											<img src="<?php echo $recthumbimg;?>" />
										</div>
										<div class="col-md-6">
											<div class=""><h5><?php echo get_post($pid)->post_title;?></h5></div>
											<div class=""><?php echo get_post_meta( $pid, 'subtitle', true );?></div>
										</div>
										<div class="col-md-4 d-flex justify-content-end">
											<form method="post" action="<?php echo get_permalink( $pid );?>">
												<input type="hidden" value="<?php echo $post_id; ?>" name="parentfliplistid" />
												<button type="submit" class="btn_normal_state">Play</button>
											</form>
											<?php 
											if( get_post( $pid )->post_author ==  get_current_user_ID() ){
											?>
											<button type="button" class="btn_danger_state ml-2 delete_fliplist" data-fliplist="<?php echo $pid;?>" data-recid="<?php echo $pid;?>" ><i class="<?php echo $square_icon['trash'];?>" aria-hidden="true"></i></button>
											<form method="post" action="<?php echo site_url() . '/create-fl1p-recording/';?>">
												<input type="hidden" name="recording_id" value="<?php echo $pid;?>" />
												<input type="hidden" name="fliplist_id" value="<?php echo $post_id;?>" />
												<button type="submit" class="btn_normal_state ml-2"><i class="<?php echo $square_icon['edit'];?>" aria-hidden="true"></i></button>
											</form>
											<?php } ?>
										</div>
									</div>
									<?php } ?>
								</div>
							</div>
							<?php 
							if( get_post( $post_id )->post_author ==  get_current_user_ID() ){
							?>
							<form method="post" action="<?php echo site_url().'/create-fl1p-recording/';?>">
								<input type="hidden" name="fliplist_id" value="<?php echo $post->ID;?>">
								<button type="submit" class="fliplispagenewrectbtn" style="display:none;"></button>
							</form>
							<div class="add_new_recording_div">
								<span class="add_new_recording_btn">Add new Recording</span>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</article>
		</div>
	</main>
</div>
<script>
	jQuery(window).load(function(){
		var thumbheight = ( jQuery('.fliplist_thumb_content').height() * 2 );
		jQuery('.flipreclist_div').css({'max-height':thumbheight+'px','overflow':'auto'});
	});
	jQuery(document).ready(function(){
		jQuery('.add_new_recording_div').click(function(){
			jQuery('.fliplispagenewrectbtn').trigger('click');
		});
	});
</script>
<?php
/* endif; */
get_footer();  