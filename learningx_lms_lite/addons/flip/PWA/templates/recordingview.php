<?php 
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
article{
	width:100%;
	overflow-x: unset;
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
</style>
<?php 
$fliprecordingid = get_the_ID();
$recording_title = get_post( $fliprecordingid )->post_title;
$parent_fliplistid = $_POST['parentfliplistid'];
/* echo "<pre>";print_r($_POST); */

$parent_fliplist_html="";
if( !empty($parent_fliplistid) ){
	$parent_fliplist_html = "<a href='".get_permalink( $parent_fliplistid )."'>".get_post( $parent_fliplistid )->post_title."</a>";
}
?>
<script>
var siteUrl = "<?php echo site_url();?>";
</script>
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
		/* $get_all_recording = $wpdb->get_results("select pm.* from ".$wpdb->prefix."posts as p,".$wpdb->prefix."postmeta as pm where pm.post_id=p.ID and p.post_type='flip_recording' and p.post_status='publish' and pm.meta_key like '%total_fliplist%'");
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
		} */
		/* echo "<pre>";print_r($is_fliplist_exist); */
		?>
		<ul class="sidebar-nav pwasidebar">	
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
							<ul class="breadcrumb p-0 m-0 breadcrumb_item_size">
								<li class="breadcrumb-item "><a href="<?php echo site_url().'/pwa-fl1plist/'?>" class="pwafliplisttitle">My Fl1p Recordings</a></li>
								<li class="breadcrumb-item active" aria-current="page"><?php echo $recording_title;?></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</nav>
	</div>
	<section id="content-wrapper">
		<div class="fliprecord_content">
			<div class="fliprecord_innercon mb-2">
				<div class="row pt-4 flipviewwholerow">
					<div class="col-md-4 mt-1">
					 <?php 
					 /* $colmheight = '0px';
					 if( empty(get_post_meta($fliprecordingid,'additional_notes',true)) && empty(get_post_meta($fliprecordingid,'recordingpdf_upload',true))){
						 $colmheight = '56vh';
					 }elseif(!empty(get_post_meta($fliprecordingid,'additional_notes',true)) && empty(get_post_meta($fliprecordingid,'recordingpdf_upload',true))){
						 $colmheight = '26vh';
					 }elseif(empty(get_post_meta($fliprecordingid,'additional_notes',true)) && !empty(get_post_meta($fliprecordingid,'recordingpdf_upload',true))){
						 $colmheight = '26vh';
					 }elseif(!empty(get_post_meta($fliprecordingid,'additional_notes',true)) && !empty(get_post_meta($fliprecordingid,'recordingpdf_upload',true))){
						 $colmheight = '0vh';
					 }
					 if(empty(get_post_meta($fliprecordingid,'recording_multiple_image_path',true))){
						 $colmheight = '44px';
					 } */
					 
					/*  $div_show = '';
					 if( $colmheight == '0px' || $colmheight == '0vh' ){
						$div_show = 'display:none;';
					 } */
					$div_show = '';
					if( !empty(get_post_meta($fliprecordingid,'additional_notes',true)) && !empty(get_post_meta($fliprecordingid,'recordingpdf_upload',true)) && !empty(get_post_meta($fliprecordingid,'recording_multiple_image_path',true))){
						$div_show = 'display:none;';
					}
					 /* lxprint($square_icon); */
					 
					 ?>
					 <div class="row mb-2 pwadisplaymaindiv" style="border:3px solid <?php echo $color_palette['light_grey'];?>;border-radius: 10px;margin:unset;<?php echo $div_show; ?>">
						<div class="col-md-1 col-1 col-xs-1 p-2">
							<i class="<?php echo $square_icon['infobox']; ?>" style="font-size:20px;"></i>
						</div>
						<div class="col-md-11 col-11 col-xs-11 p-2" style="color:<?php echo $color_palette['grey'];?>">
							<div class="pwaimagedisplay">Images: None</div>
							<div class="pwaadditionltextdisplay">Additional text: None</div>
						</div>
					 </div>
						<div>
							<div class="form-group" style="position:relative;">
								<div class="pwafliprecord_textblock">
									<?php echo FnFormatMytext( get_post_meta($fliprecordingid,'additional_notes',true) );?>
								</div>
								<?php /* <i class="fa fa-2x <?php echo $flipicons['fullsceenon'];?> flipviewtextzoom" aria-hidden="true"></i> */ ?>
							</div>
						</div>
						<div class="modal fade" id="flipviewtextzoommodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog modal-lg" role="document" style="max-width: 100%;margin: unset;">
							<div class="modal-content" style="height: 100vh;width: 100vw;">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <i class="<?php echo $flipicons['fullsceenoff'];?> flipviewtextzoomout" aria-hidden="true"></i>
								</button>
							  </div>
							  <div class="modal-body" style="overflow:auto;">
								<?php echo FnFormatMytext( get_post_meta($fliprecordingid,'additional_notes',true) );?>
							  </div>
							</div>
						  </div>
						</div>
						<script>
							jQuery(document).on('click','.flipviewtextzoom',function(){
								jQuery('#flipviewtextzoommodal').modal('show');
							});
						</script>
						<?php 
						$allpdf = get_post_meta($fliprecordingid,'recordingpdf_upload',true);
						if(!empty($allpdf)){
						?>
						<div class="pt-4 view_pdf_block">
							<div style="overflow: auto;height: 90px;">
								<?php 
								foreach( $allpdf as $pdfurl ){
								?>
									<a href="<?php echo $pdfurl;?>" download ><button class="btn btn_normal_inverse_state w-100" style="text-align: justify;margin: 5px 0px;">
										<i class="<?php echo $flipicons['attachment'];?>" aria-hidden="true"></i>
										<span><?php echo basename( $pdfurl );?></span>
									</button></a>
								<?php 
								}
								 ?>
							</div>
						</div>
						<?php } ?>
						<div class="pt-4">
							<?php  
							$audiorec = get_post_meta($fliprecordingid,'flip_recording_audio',true);
							$auidogt = '';
							if( !empty($audiorec) ){
								$auidogt = $audiorec;
							}
							?>
							<audio controls controlsList="nodownload noplaybackrate" class="pwaaudioplay">
							Your browser does not support the audio element.
							</audio>
						</div>
					</div>
					<div class="col-md-8 mt-1">
						<?php 
						$sliderimages = get_post_meta($fliprecordingid,'recording_multiple_image_path',true);
							/* echo "<pre>";print_r(get_post_meta($fliprecordingid,'recording_multiple_image_path',true)); */
						/* if(!empty($sliderimages)){ */
						?>
						<div class="pwaslider">
							<div id="MultiImagesCarousal" class="carousel slide" data-interval="false">
							
								<ol class="carousel-indicators">
								</ol>
								<div class="carousel-inner">
								</div>
								<div class="">
									<a class="carousel-control-prev flipviewarrowleft" href="#MultiImagesCarousal" role="button" data-slide="prev">
										<i class="fa fa-chevron-left" style="font-size: 30px;"></i>
										<span class="sr-only">Previous</span>
									</a>
								</div>
								<div class="">
									<a class="carousel-control-next flipviewarrowright" href="#MultiImagesCarousal" role="button" data-slide="next">
										<i class="fa fa-chevron-right" style="font-size: 30px;"></i>
										<span class="sr-only">Next</span>
									</a>
								</div>
							</div>
						</div>
						<div class="pwa_imagethumbnail"></div>
						<?php /* <div class="d-flex justify-content-center">
							<div class="num"></div>
						</div>  */?>
						<?php /* } */
						/* else{
							$tmbimg = $lx_plugin_urls['lx_lms_lite'].'/assets/img/flip_thumbnail.png';
							?>
							<div class="imagesthumb">
								<img src="<?php echo $tmbimg;?>" />
							</div>
							<?php
						} */ ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="bg-dark flipviewfooter">
		<div class="col-md-4">
			<div class="pt-2 pb-2">
				<h2 class="text-white pwa_posttitle"><?php echo get_post( $fliprecordingid )->post_title;?></h2>
				<div class="text-white pwa_postsubtitle">- <?php echo $subtitle;?></div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="d-flex float-right">
				
			</div>
		</div>  
	</div>
</div>
<script src='<?php echo $lx_plugin_urls['lx_lms_lite'] . 'addons/flip/PWA/js/idb.js'?>' ></script>
<script src='<?php echo $lx_plugin_urls['lx_lms_lite'] . 'addons/flip/PWA/js/recordingview.js'?>' ></script>
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
	});

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
</script>