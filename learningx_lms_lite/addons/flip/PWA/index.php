<?php 
global $wpdb,$post,$lx_plugin_urls,$square_icon,$color_palette;
$userid = get_current_user_ID();
/** My default flip lists **/
$defaultfliplistargs = array(
						'post_status' => 'publish',
						'post_type' => 'flip_list',
						'posts_per_page' => -1,
						'author' => $userid,
						'meta_query' => array(
								array(
									'key' => 'registertimelist',
									'value' => 1,
								)
						)
					);
$getdefaultfliplistargs = get_posts( $defaultfliplistargs );			

$defaultfliplistid = $getdefaultfliplistargs[0]->ID;

$menussettings = get_option('user_interface_menu_settings',true);

$menulogoheight = $menussettings['logged_in_logo_height'];
/* lxprint($color_palette); */

$custom_logo_id = get_theme_mod( 'custom_logo' );
$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
/* echo $image[0]; */
?>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' />
<script>
var ajaxurl = "<?php echo site_url() . '/ajax.php' ; ?>";
var pwapath = "<?php echo site_url() . '/PWA/' ; ?>";
var templatepath = "<?php echo FL1PURL.'PWA/templates/'; ?>";
var admin_ajax = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
var siteUrl = "<?php echo site_url(); ?>";
</script>
<style>
#site-navigation3,.loggedin_logo{
	display:none3;
}
.site-info{
	display:none3;
}
.pwamainmenu{
	background-color:<?php echo $color_palette[strtolower($menussettings['background_color'])]; ?>;
    width: 100%;
    left: 0;
	z-index: 1;
}
</style>
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
.lp-ad-screen{
    width: 100%; 
    height: 100%; 
    background-color: rgba(255, 255, 255, 0.94);
    position: fixed; 
    z-index: 666999; 
    top: 0px; 
    left: 0px;
}
.lp-ad-screen span{
    width:120px;position: fixed;top: 50%;left: 50%;transform: translate(-50%, -50%);display: inline-block;
}
.lp-ad-screen img{
    cursor:pointer;width:120px;
}
.flip_progress_bar, .pwa-cleaning-status, .pwa-progress-bar,.flip_recording_progress_bar .pwa-progress-bar{
	background-color:<?php// echo $color_palette['hyperlinks'];?>;
	background-color:green;
	padding-top: 10px;
	
}
.flip_progress_bar,.flip_recording_progress_bar{
	height: 0.7rem;
    border: 1px solid <?php echo $color_palette['light_grey'];?>;
    background: <?php echo $color_palette['white'];?>;
}
.alert_box {
    position: fixed;
    border: 1px solid #e0e0e0;
    border-radius: 15px;
    text-align: center;
    margin: auto 14%;
    width: 75%;
    padding: 30px;
    z-index: 100;
    background: #fff;
    top: 30%;
    box-shadow: 0px 1px 15px 10px rgb(0 0 0 / 35%);
}
</style>
<input type="hidden" class="current_user_id" value="<?php echo get_current_user_ID(); ?>" />
<input type="hidden" class="defaultfliplistid" value="<?php echo $defaultfliplistid; ?>" />
<div class="container-fluid mt-5 pwamyfliplistmaindiv">
	<div class="sync-progress-bar" style="display:none; padding:10px;box-shadow: 0 0 15px #afaaaa;">
		<div class="form-group thumbnail_progress_main_div" >
			<div classflip_progress_bar="progress ">
				<label for="syncstatus">Sync status:</label>
				<div class="progress " style="height: 13px;text-align: end;">
					<div class="pwa-progress-bar" id="fliprec_thumb_progress1" role="progressbar" style="width: 0%;"></div>
				</div>
				<label class="pwa-progress-bar-label" style="float:right;">0%</label>
			</div>
		</div>
		<div class="form-group thumbnail_progress_main_div1" >
			<div classflip_progress_bar="progress ">
			<label for="cleaningstatus">Clearing device storage:</label>
			<div class="progress " style="height: 13px;text-align: end;">
				<div class="pwa-cleaning-status" id="fliprec_thumb_progress2" role="progressbar" style="width: 0%;"></div>
			</div>
			<label class="pwa-cleaningstatus-label" style="float:right;">0%</label>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="fliplist_thumb_content">
				<?php
				$fliplist_thumb = get_post_meta($defaultfliplistid,'fliplist_cropped_thumb')[0];
				if( empty($fliplist_thumb) ){
					$fliplist_thumb = $lx_plugin_urls['lx_lms_lite'].'assets/img/flip_thumbnail.png';
				} 
				?>		
				<div class="thumb"><img src="<?php echo $fliplist_thumb; ?>"/>
				</div>								
			</div>
		</div>
		<div class="col-md-8 content_tab2">
			<div class="fliplist_detail_content">
				<div class="col-sm-12">
					<div class="fliplist_title_main_div" id="style-4">
						<div class="fliplist-title">
							<input type="hidden" class="pwafliplisttitle" value="<?php echo get_the_title($defaultfliplistid); ?>" />
							<h3 class="head_h3"> <?php echo get_the_title($defaultfliplistid); ?></h3>
						</div>
						<?php
						$sub_title = get_post_meta( $defaultfliplistid,'fliplist_subtitle')[0];
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
						<?php echo get_post($defaultfliplistid)->post_content;?>
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
					if( in_array( $defaultfliplistid ,$meta_value ) ){
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
						
					/* ?>
					<div class="row p-3 flipreclist_innerdiv">
						<div class="col-md-2">
							<img src="<?php echo $recthumbimg;?>" />
						</div>
						<div class="col-md-6">
							<div class=""><h5><?php echo get_post($pid)->post_title;?></h5></div>
							<div class=""><?php echo get_post_meta( $pid, 'subtitle', true );?></div>
						</div>
						<div class="col-md-4 d-flex justify-content-end">
							<button type="submit" class="btn_normal_state">Play</button>
							<button type="button" class="btn_danger_state ml-2 delete_fliplist" data-fliplist="<?php echo $pid;?>" data-recid="<?php echo $pid;?>" ><i class="<?php echo $square_icon['trash'];?>" aria-hidden="true"></i></button>
							<button type="button" class="btn_normal_state ml-2 pwabtn_editfliprec" data-edituniqukey="0"><i class="<?php echo $square_icon['edit'];?>" aria-hidden="true"></i></button>
							<a style="display:none;" href="<?php echo site_url().'/pwa-fl1precording/';?>" class=""><div class="pwaeditclick0">CLick</div></a>
						</div>
					</div>
					<?php */ } ?>
				</div>
			</div>
			<?php 
			/* if( get_post( $post_id )->post_author ==  get_current_user_ID() ){ */
			?>
			<a href="<?php echo site_url().'/pwa-fl1precording/';?>">
				<div class="add_new_recording_div">
					<span class="add_new_recording_btn">Add new Recording</span>
				</div>
			</a>
			<?php /* } */ ?>
		</div>
	</div>
</div>
<script src="http://localhost/learningxpwa/wp-includes/js/jquery/jquery.min.js" id="jqueryjs"></script>
<script src="<?php echo FL1PURL; ?>PWA/js/idb.js" id="MyFlipRecordingManifestjsidb"></script>
<script src="<?php echo FL1PURL; ?>PWA/js/index.js" id="MyFlipRecordingManifestjs"></script>
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js'></script>