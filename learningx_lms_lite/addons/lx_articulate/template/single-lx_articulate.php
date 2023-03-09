<?php
/**
 * The Template for displaying all single posts.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); 
global $post,$font_family,$square_icon;
$articulate_id=$post->ID;
?>
<style>
	body{
		position: fixed;
		width: 100%;
	}
	.main-navigation ,.site-info,.loggedin_logo{
		display: none;
	}
	.row{
		margin-right: 0px !important;
		margin-left: 0px !important;
	}
	#main{
		height: 100vh;
	}
	.col-md-12{
		padding-right: 0px !important;
		padding-left: 0px !important;
	}
	.content_title{
		display: flex;
	    color: <?php echo $color_palette['hyperlinks'];?>;
	    font-family: <?php echo $font_family['heading_font'];?>;
	    padding: 5px;
	}
	@media (max-width:768px){
		#wpadminbar{
			display:none !important;
		}
	}
</style>
	<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
		<main id="main" <?php generate_do_element_classes( 'main' ); ?>>
			<div class="entry-content">
				<div class="row articulate_content">
					<div class="col-md-12 content_heading">
						<div class="content_title">
							<div style="width: 65%;align-self: center;"><h2 class="head_h2"><?php the_title();?></h2></div>
							<div style="width: 35%;text-align: right;"><button class="btn_normal_state btn_back" onclick="goBack()">Back</button></div>
						</div>	
					</div>
					<div class="col-md-12 content_iframe">
						<div>
							<?php
								$content_category=get_post_meta($articulate_id,'articulate_web_category',true);
								$content = get_post_meta($articulate_id,'web_url',true);
								if( $content_category == 'articulate_web' ){
									$alt_view = get_post_meta($articulate_id,'alt_view_selection',true);
									$alt_view = get_post_meta($articulate_id,'alt_view_selection',true);
									if( $alt_view == 'new_tab' ){
										?>
										<script>
											window.location = "<?php echo $content; ?>";
										</script>
										<?php
									} else{	
										if (strpos($content,'youtube') !== false) {
											$temp = explode('?',$content)[1];
											parse_str($temp,$cus_arr);
											$content= "https://www.youtube.com/embed/".$cus_arr['v'];
										}
										?>
										<iframe src="<?php echo $content;?>" width="100%"></iframe>
										<?php
									}
								} else{
									$content=get_post_meta($articulate_id,'xapi_content',true)['launch_path'];
								?>
									<iframe src="<?php echo $content;?>" width="100%"></iframe>
								<?php
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
	<script>
		jQuery(document).ready(function(){
			var height=parseInt(jQuery('.content_title').height())
			if(jQuery('body').children().hasClass('nojq')){
				height=height+parseInt(jQuery('.nojq').height());
			}
			height=height+10;
			jQuery('.content_iframe iframe').css('height','calc(100vh - '+height+'px)');
		});
		function goBack() {
		  window.history.back();
		}
	</script>
<?php
get_footer();