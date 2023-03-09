<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}
get_header();
global $color_palette,$font_family,$flipicons,$lx_plugin_urls,$square_icon;

if( !is_user_logged_in() || current_user_can('subscriber') ){
	echo "<div class='text-center' style='color:".$color_palette['red']."'>You are not allowed to view this page</div>";
	return;
}
?>
<style>
<?php if(is_user_logged_in()){ ?>
.loggedin_logo,.join-site,.main-navigation,.site-footer{
	display: none;
}
<?php } ?>

a {
	transition: background 0.2s, color 0.2s;
}

a:hover,
a:focus {
	text-decoration: none;
}
.main_header .div_border {
	border-right: 1px solid #e2e7ed;
}

.mb_toggle_btn {
	color: #000;
	font-size: 22px;
}

.main_header .ld_progress .progress_percentage {
	text-transform: uppercase;
	color: <?php echo $color_palette['hyperlinks']?>;
}

.main_header .ld_progress .progress {
	height: 8px;
}

#wrapper {
	padding-left: 0;
	transition: all 0.5s ease;
	position: relative;
}

#sidebar-wrapper {
	z-index: 1000;
	position: fixed;
	left: 350px;
	width: 0;
	height: 100%;
	margin-left: -350px;
	overflow-x: hidden;
	background-color: <?php echo $color_palette['white']?>;
	border-right: 1px solid #e2e7ed;
	transition: all 0.5s ease;
}
.sidebar-nav{
	overflow-y: auto;
}
#wrapper.toggled #sidebar-wrapper {
	width: 350px;
}

.sidebar-brand {
	position: absolute;
	top: 0;
	width: 350px;
	text-align: center;
	padding: 20px 10px;
	background-color: <?php echo $color_palette['hyperlinks']?>;
}

.sidebar-brand h2 {
	margin: 0;
	font-weight: 600;
	font-size: 24px;
	color: <?php echo $color_palette['white']?>;
}

.sidebar-nav {
	position: absolute;
	width: 350px;
	margin: 0;
	padding: 0;
	list-style: none;
}

.sidebar-nav>li {
	padding: 10px;
	border-bottom: 1px solid #e2e7ed;
	background-color: <?php echo $color_palette['white']?>;
}

.sidebar-nav>li a {
	text-decoration: none;
	color: #757575;
	font-weight: 600;
	font-size: 18px;
	align-items: center;
}

.sidebar-nav>li>a:hover,
.sidebar-nav>li.active>a {
	color: <?php echo $color_palette['hyperlinks']?>;
}

.sidebar-nav>li>a i.fa {
	font-size: 24px;
	width: 60px;
}

#navbar-wrapper {
	width: 100%;
	position: absolute;
	z-index: 2;
}

#wrapper.toggled #navbar-wrapper {
	position: absolute;
	margin-right: -350px;
}

#navbar-wrapper .navbar {
	border-width: 0 0 0 0;
	background-color: #eee;
	margin-bottom: 0;
	border-radius: 0;
}
#navbar-wrapper .navbar .navbar-header .toggle_btn {
   transform: translateY(-50%) translateX(25%);
	position: absolute;
	top: 33px;
	left: -30px;
	border-radius: 50%;
	color: <?php echo $color_palette['white']?>;
	background-color: <?php echo $color_palette['hyperlinks']?>;
	z-index: 1;
	font-size: 14px;
	padding: 5px 11px
}

#navbar-wrapper .navbar a {
	color:<?php echo $color_palette['hyperlinks']?>;
}

#navbar-wrapper .navbar a:hover {
	color: <?php echo $color_palette['hyperlinks']?>;
}

#content-wrapper {
	width: 100%;
	position: absolute;
	top: 100px;
}

#wrapper.toggled #content-wrapper {
	position: absolute;
	margin-right: -250px;
}

.sidebar-brand .parentfliprecord_title {
	color: <?php echo $color_palette['white']?>;
	margin-right: 35px;
}

.sidebar-brand .ld_icon {
	font-size: 20px;
	margin-right: 10px;
	color: <?php echo $color_palette['white']?>;
}

.sidebar-brand .parentfliprecord_title {
	font-weight: 500;
}

.ld_status_icon {
	width: 15px;
	height: 15px;
	flex: 0 0 15px;
	border: 0;
	text-align: center;
	margin-right: 10px;
	margin-top: .15em;
	border-radius: 50%;
}

.ld_status_incomplete {
	border: 2px solid #e2e7ed;
}

.parentfliprecord_title .head_h3{
	padding:unset;
	margin:unset;
}
.parentfliprecord_title {
	font-size: 1em;
	font-weight: 400;
	flex: 1;
	display: flex;
	font-family: <?php echo $font_family['heading_font'];?>;
}
.fliprecord_title,.fliprecord_subtitle{
	font-size: 14px;
	font-weight: 400;
	flex: 1;
	display: flex;
	font-family: <?php echo $font_family['body_font'];?>;
}
.breadcrumb_item_size {
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
	align-items: center;
}
.btn_brd_home{ 
	height: unset !important;
	padding: 2px 20px !important;
	margin-right: 5px;
	font-size: 16px;
	font-weight: 500;
}
.breadcrumb-item+.breadcrumb-item::before {
	display: inline-block;
	padding-right: .5rem;
	color: #6c757d;
	content: ">";
}
.breadcrumb-item{
	font-family: <?php echo $font_family['body_font'];?>;
	color: <?php echo $color_palette['charcoal'];?> !important;
}
.ld_content_action{
	display: flex;
}
.content_list_href .fa-check-circle{
	color: <?php echo $color_palette['hyperlinks'];?>;
	font-size: 15px;
}
.progress-bar{
	background-color: <?php echo $color_palette['hyperlinks'];?> !important;
}
@media (min-width: 992px) {
	.main_header .ld_content_action {
		border-top: none;
	}

	.mb_toggle_btn {
		display: none;
	}

	#wrapper {
		padding-left: 50px;
	}

	#wrapper.toggled {
		padding-left: 350px;
	}

	#sidebar-wrapper {
		width: 350px;
		left: unset;
		z-index: 0;
	}

	#wrapper.toggled #sidebar-wrapper .sidebar-nav {
		opacity: 1;
	}
	#sidebar-wrapper .sidebar-nav {
		opacity: 0;
	}

	#wrapper.toggled #navbar-wrapper {
		position: absolute;
		margin-right: -190px;
	}

	#wrapper.toggled #content-wrapper {
		position: absolute;
		margin-right: -190px;
	}

	#navbar-wrapper {
		position: relative;
	}
	
	#content-wrapper {
		position: relative;
		top: 0;
	}

	#wrapper.toggled #navbar-wrapper,
	#wrapper.toggled #content-wrapper {
		position: relative;
		margin-right: 60px;
	}
}

@media (min-width: 768px) and (max-width: 991px) {
	.main_header .div_border {
		border-right: none;
	}

	#navbar-wrapper .navbar .navbar-header .toggle_btn {
		display: none;
	}

	#wrapper.toggled #navbar-wrapper {
		position: absolute;
		margin-right: -250px;
	}

	#wrapper.toggled #content-wrapper {
		position: absolute;
		margin-right: -250px;
	}

	#navbar-wrapper {
		position: relative;
	}

	#content-wrapper {
		position: relative;
		top: 0;
	}

	#wrapper.toggled #navbar-wrapper,
	#wrapper.toggled #content-wrapper {
		position: relative;
		margin-right: 250px;
	}
}

.imagesthumb img{
	height:56vh;
    opacity: 0.2;
	width:100%;
}
@media (max-width: 767px) {
	.main_header .ld_content_action {
		border-top: 1px solid #e2e7ed;
	}

	.main_header .div_border {
		border-right: none;
	}

	#navbar-wrapper .navbar .navbar-header .ld_status {
		width: 100%;
		float: unset;
	}

	#wrapper {
		padding-left: 0;
	}

	#sidebar-wrapper {
		width: 0;
	}

	#wrapper.toggled #navbar-wrapper {
		position: absolute;
		margin-right: -250px;
	}

	#wrapper.toggled #content-wrapper {
		position: absolute;
		margin-right: -250px;
	}

	#navbar-wrapper {
		position: relative;
	}
	
	#navbar-wrapper .navbar .navbar-header .toggle_btn {
		display: none;
	}

	#content-wrapper {
		position: relative;
		top: 0;
	}

	#wrapper.toggled #navbar-wrapper,
	#wrapper.toggled #content-wrapper {
		position: relative;
		margin-right: 250px;
	}
	.imagesthumb img{
		height:unset;
	}
}
.fliprecord_content{
	width: 100%;
	position: absolute;
	top: 0;
	overflow:auto;
}
.fliprecord_innercon{
	width:95%;
	margin:auto;
}
.fliprecord_textblock{
	height:170px;
	overflow:auto;
}
.flipviewtextzoom{
	position: absolute;
    right: 24px;
    bottom: 3px;
    cursor: pointer;
}
.flipviewarrowleft,.flipviewarrowright{
	opacity:0.4;
	background-color:#000;
	height: 50px;
    width: 50px;
    border-radius: 50%;
    top: 42%;
}
.flipviewarrowleft:hover,.flipviewarrowright:hover{
	opacity:0.4;
	background-color:#000;
}
#MultiImagesCarousal{
	height:27vw;
}
@media (max-width: 767px) {
	#MultiImagesCarousal{
		height:45vw;
	}
}

#MultiImagesCarousal .carousel-inner,#MultiImagesCarousal .carousel-item,#MultiImagesCarousal .carousel-item img{
	height:inherit;
	margin: 0 auto;
	max-width: -webkit-fill-available;
}
.flipviewfooter{
	z-index: 15;
    bottom: 0;
    width: 100%;
	position: fixed;
	height: auto;
	margin:0px;
}
audio{
	border: 1px solid;
    border-radius: 25px;
    color: #343a40;
}
.sidebar-nav::-webkit-scrollbar{
	width: 6px;
	background-color: <?php echo $color_palette['grey'];?>;
}
.sidebar-nav::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: <?php echo $color_palette['grey'];?>;
}
.sidebar-nav::-webkit-scrollbar-thumb
{
	background-color: <?php echo $color_palette['hyperlinks'];?>;
}

<?php
$hex = $color_palette['blue'];
list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
$rgbcolor = $r.','.$g.','.$b;
?>
audio::-webkit-media-controls-panel {
  background-color: rgba(<?php echo $rgbcolor;?>,0.2);
}
audio::-webkit-media-controls-play-button,audio::-webkit-media-controls-mute-button{
	color:<?php echo $color_palette['blue'];?>;
	background-color:<?php echo $color_palette['blue'];?>;
	border-radius:50%;
}
.add_recording_reply, .view_recording_response{
	border: 1px solid <?php echo $color_palette['purple'];?>;
	border-top-left-radius: 15px;
	border-top-right-radius: 15px;
	height:51px;
	background-color:<?php echo $color_palette['white'];?>;
}
.add_reply_btn, .view_response_btn{
	color:#000000;
	margin-top:7px;
}
.add_reply_btn:hover, .view_response_btn:hover{
	border-top-left-radius: 15px;
	border-top-right-radius: 15px;
	background-color:<?php echo $color_palette['white'];?>;
}
.response_navigation_left,.response_navigation_right{
	font-size:30px;
	color:<?php echo $color_palette['white'];?>;
} 
.repliesnavigatordiv{
	background-color:<?php echo $color_palette['purple']; ?>;
}
.fliprecording_response_edit_div{
    margin-right: -20px;
    margin-left: 30px;
	position:absolute;right: 5%;
}
.sw_floating_widget_button{
	display:none;
}
</style>
<?php 
	$fliprecordingid = get_the_ID();
	$parent_fliplistid = $_POST['parentfliplistid'];
	
	$recording_title = get_post( $fliprecordingid )->post_title;
	$parent_fliplist_html="";
	if( !empty($parent_fliplistid) ){
		$parent_fliplist_html = "<a href='".get_permalink( $parent_fliplistid )."'>".get_post( $parent_fliplistid )->post_title."</a>";
	}
	?>
<div class="main_flirecviewdiv">
	<input type="hidden" class="parent_fliplistid" value="<?php echo $parent_fliplistid; ?>" />
	<input type='hidden' class="parent_recid" value="<?php echo $fliprecordingid; ?>">
	<div class="container-fluid main_header">
		<div class="row lesson_progress_row ai_center">
			<div class="col-md-2 col-2 ld_logo">
				<div class="">
					<a href="#" class="mb_toggle_btn" id="mobile-toggle"><i class="fa fa-bars"></i></a>
				</div>
			</div>			
		</div>
	</div>
	<div id="wrapper">
		<aside id="sidebar-wrapper">
			<div class="sidebar-brand">
				<div class="d-flex align-items-center">
					<div class="ld_icon"><i class="<?php echo $flipicons['audio_recording'];?>"></i></div>
					<div class="parentfliprecord_title"><h3 class="head_h3">My Fl1p Recordings<?php /* echo $recording_title; */?></h3></div>
				</div>
			</div>
			<?php 
			$get_all_recording = $wpdb->get_results("select pm.* from ".$wpdb->prefix."posts as p,".$wpdb->prefix."postmeta as pm where pm.post_id=p.ID and p.post_type='flip_recording' and p.post_status='publish' and pm.meta_key like '%total_fliplist%'");
			$is_fliplist_exist = array();
			if(!empty($parent_fliplistid)){
				foreach( $get_all_recording as $flplists ){
					$meta_value = unserialize( $flplists->meta_value );
					if(!empty($meta_value)){
						if( in_array( $parent_fliplistid ,$meta_value ) ){
							$is_fliplist_exist[] = $flplists->post_id;
						}
					}
				}
			}
			/* echo "<pre>";print_r($is_fliplist_exist); */
			?>
			<ul class="sidebar-nav">
				<?php 
				foreach( $is_fliplist_exist as $pid ){
					$is_active = '';
					if( $pid == $fliprecordingid ){
						$is_active = 'active';
					}
					?>
					<form method="post" action="<?php echo get_permalink( $pid );?>">
						<input type="hidden" value="<?php echo $parent_fliplistid; ?>" name="parentfliplistid" />
						<button type="submit" class="next_navigationbutton<?php echo $pid;?>" name="" style="display:none;"></button>
					</form>
					<li class="<?php echo $is_active;?>">
						<a href="javascript:void(0);" class="content_list_href fliprecnavigationsidebar" data-recid="<?php echo $pid;?>">
							<div class="fliprecord_title"><?php echo get_post($pid)->post_title;?></div>
							<div class="fliprecord_subtitle"><?php echo get_post_meta($pid,'subtitle',true);?></div>
						</a>
					</li>
					<?php 
				}		
				?>
			</ul>
			
		</aside>
		<div id="navbar-wrapper">
			<nav class="navbar navbar-inverse lx_lms_sub_text">
				<div class="container-fluid">
					<div class="navbar-header" style="width:100%;">
						<a href="#" class="navbar-brand toggle_btn" id="sidebar-toggle"><i class="fa fa-chevron-left"></i></a>
						<?php /* <div class="ld_logo">
							<div class="p-3">
								<a href="#" class="mb_toggle_btn" id="mobile-toggle"><i class="fa fa-bars"></i></a>
							</div>
						</div> */ ?>
						<div class="d-flex row">
							<div class="col-md-12 col-sm-12 col-xs-12" style="display:flex;margin-left: -15px;align-items:center;">
								<a href="<?php echo site_url();?>" style="color:#fff;"><div class="btn_brd_home btn_normal_state">Home</div></a>
								<ul class="breadcrumb p-0 m-0 breadcrumb_item_size">
									<li class="breadcrumb-item"><?php echo $parent_fliplist_html; ?></li>
									<li class="breadcrumb-item active" aria-current="page"><?php echo $recording_title;?></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</nav>
		</div>
		<div class="Playinnersection">
			<?php
				include dirname( __FILE__ ) . '/flipviewdetailpage.php';
			?>
		</div>
	</div>
</div>
<?php
function FNFlipRecordingResponses($fliprecordingid, $all_response_ids){
	global $wpdb,$flipicons;
	 ?>
	<div class="col-md-4"> 
		<?php
		if( !empty($all_response_ids) ){	
		/* echo "<pre>";print_r($all_response_ids); */
		$i=1;
		foreach( $all_response_ids as $response_id){
			$res_id = $response_id->post_id;
			$response_title = get_post( $res_id )->post_title;
			$response_subtitle = date('jS F Y - h:i A',strtotime( get_post( $res_id )->post_date ));
			if( !empty(get_post_meta($res_id,'subtitle',true)) ){
				$response_subtitle = get_post_meta($res_id,'subtitle',true);
			} 
			 
			$displayreplies = 'style="display:none;"';$active = '';
			if( $i==1){
				$displayreplies = '';
				$active = 'active';
			}
		?>
		
		<div class="row repliesnavigatordiv repliesnavigatordiv<?php echo $res_id;?> <?php echo $active; ?>" data-replyid="<?php echo $res_id;?>" <?php echo $displayreplies; ?> hidden >
			<div class="col-md-1 d-flex align-items-center">
			<?php if(count($all_response_ids) > 1){ ?>
				<div class=''><a href="javascript:void(0);" data-replyid="<?php echo $res_id;?>" class="text-white previousreplies"><i class="<?php echo $flipicons['navigation_left'];?>" style="font-size:30px;"></i></a></div>
			<?php } ?>
			</div>
			<div class="col-md-10 d-flex justify-content-center">
				<div class="" style="padding: 8px 20px;">
					<div class=""><h2 class="text-white"><?php echo $response_title; ?></h2></div>
					<div class="text-white"><?php echo $response_subtitle; ?></div>
				</div>
			</div>
			<div class="col-md-1 d-flex align-items-center">
			<?php if(count($all_response_ids) > 1){ ?>
				<div class='d-flex align-items-center'><a href="javascript:void(0);" data-replyid="<?php echo $res_id;?>" class="text-white nextreplies"><i class="<?php echo $flipicons['navigation_right'];?>" style="font-size:30px;"></i></a></div>
			<?php } ?>
			</div>
		</div>
		<?php
			$i++;
		} 
	}	
	?>
	</div> 
	<?php
	
}
?>
<script>
	jQuery(document).ready(function(){
		var height=parseInt(jQuery('#navbar-wrapper').height());
		var heightx2=parseInt(jQuery('.flipviewfooter').height());
		if(jQuery('body').children().hasClass('nojq')){
			height=height+parseInt(jQuery('.nojq').height());
		}
		jQuery('.fliprecord_content').css('height','calc(100vh - '+(height+heightx2)+'px)');
		/* jQuery('.fliprecord_content iframe').css('height','calc(100vh - '+height+'px)'); */
		
		jQuery('.fliprecnavigationsidebar').click(function(){
			var recid = jQuery(this).data('recid');
			jQuery('.next_navigationbutton'+recid).trigger('click');
		});
		
	});
	
	var totalItems = jQuery('.carousel-item').length;
	var currentIndex = jQuery('div.active').index() + 1;
	
	jQuery('.num').html('' + currentIndex + ' of ' + totalItems + ' images');
	/* jQuery('#MultiImagesCarousal').carousel({
	  interval: 2000
	});
	jQuery('#MultiImagesCarousal').bind('slide.bs.carousel', function() {
	  currentIndex = jQuery('div.active').index() + 1;
	  jQuery('.num').html('' + currentIndex + ' of ' + totalItems + ' images');
	}); */
	
	height=parseInt(jQuery('.sidebar-brand').height()+40);
	heightx=parseInt(jQuery('.sidebar-brand').height()+40)+parseInt(jQuery('#wpadminbar').height());
	jQuery('.sidebar-nav').css('top',height);
	const $button = document.querySelector('#sidebar-toggle');
	const $wrapper = document.querySelector('#wrapper');
	
	var heightsidbarul = jQuery('.sidebar-nav').height();
	jQuery('.sidebar-nav').css('height','calc( 100% - '+heightx+'px )');
	/* alert(jQuery('.sidebar-nav').height()); */
	$button.addEventListener('click', (e) => {
		e.preventDefault();
		$wrapper.classList.toggle('toggled');
		jQuery(".toggle_btn .svg-inline--fa").toggleClass('fa-chevron-right fa-chevron-left');
		footerWidth();
	});

	jQuery(document).on('resize',function(){
		footerWidth();
	});
	function footerWidth(){
		if(jQuery(window).width() > 768){
			var fwidth = '50px';
			if( jQuery('#wrapper').hasClass('toggled') ){
				fwidth = '350px';
			}
			jQuery('.flipviewfooter').css({'width':'calc(100% - '+fwidth,'transition':'all 0.5s ease'});
		}
	}
	const $button1 = document.querySelector('#mobile-toggle');
	const $wrapper1 = document.querySelector('#wrapper');

	$button1.addEventListener('click', (e) => {
		e.preventDefault();
		$wrapper1.classList.toggle('toggled');
		if(jQuery(window).width() < 767 && jQuery('#wrapper').hasClass('toggled')){
			jQuery('body').css('overflow','hidden');
		}else if(jQuery(window).width() < 767){
			jQuery('body').css('overflow','auto');
		}
	});
	
	/* var total_responses = jQuery('.fliprecresponses').length;
	var res_index ='';
	jQuery('#FlipResponsesCarousal').bind('slide.bs.carousel', function() {
	  res_index = jQuery('div.active').index() + 1;
	  jQuery('.responsenum').html('( ' + res_index + ' of ' + total_responses + ' responses )');
	}); */ 
	
</script>
<?php
get_footer();
?>