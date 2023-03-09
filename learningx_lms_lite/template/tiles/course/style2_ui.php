<style>
	.favicon_course{
		display: contents;
	}
</style>
<?php 
global $lx_lms_settings,$wpdb,$square_icon;
if(isset($purchase_redirection_link)){
	$redirect_link = $purchase_redirection_link;
}
if($lx_lms_settings['course_purchasing_settings'] == 'on' && !empty($lx_lms_settings['course_currency_symbol'])){
	$redirect_link = $redirect_link;
} else{
	$redirect_link = get_permalink($post_id);	
}
	
$course_cost=get_post_meta($post_id,'lx_course_cost',true);
$order_existance = check_lx_course_order_exists($post_id,get_current_user_id());
$macro_course_id = get_post_meta( $post_id,'lx_associated_macro_course',true);
if($macro_course_id != 0 && !empty($macro_course_id)){
	$micro_course_order_existance = check_lx_course_order_exists($macro_course_id,get_current_user_id());
}

$get_user_membership = $wpdb->get_results("select * from ".$wpdb->prefix."mepr_members where user_id='".get_current_user_id()."'");
$all_membership = $get_user_membership[0]->memberships;
$btn_disabled = '';$btn_class = 'btn_normal_state';$btn_text = '';$course_purchase = 0;$isviewwidth = '';$show_statusbar='';$non_loggedin = 0;$notmember = 0;
?>
<style>
	.coursetilefavicon{
		position: relative;
		width: 35px;
		height: 35px;
		/*bottom: 10px;
		left: 10px;*/
		padding: 3px;
	}
	.coursetilefeatured{
		position:absolute;
		background-color:<?php echo $color_palette['green'];?>;
		top: 52px;
		color:#fff;
		padding:0px 5px;
	}
	.style2_btn_view{
		width: 30%;
	}
	.asp_product_buy_btn_container,.btn_lx_course_purchase{
		width:100% !important;
	}
</style>
<?php
if(!empty($com_id)){
	?>
	<style>
	.asp_product_buy_button,.asp_product_buy_btn_container,.btn_lx_course_purchase{
		width:100% !important;
	}
	.asp_product_buy_button{
		padding-right:5px;
		padding-left:5px;
	}
	</style>
	<?php
	if(is_super_admin() || current_user_can('site_owner')){
		$btn_text = 'View';
	}elseif(is_user_logged_in()){
		if(!empty($all_membership)){
			$exall_membership = explode(',',$all_membership);
			if(in_array($com_id,$exall_membership)){
				if(!empty($order_existance) || !empty($micro_course_order_existance)){
					$btn_text = 'View';
					$redirect_link = get_permalink($course_id);	
				}else{
					$btn_text = 'View';
					if(!empty($course_cost)){
						$btn_text = $lx_lms_settings['course_currency_setting'].$lx_lms_settings['course_currency_symbol'].$course_cost.' Purchase';
						$isviewwidth = 'width: 90%;margin: 0 auto;';
						$show_statusbar='display:none;';
						$course_purchase = 1;
					}
				}
				$redirect_link = get_permalink($course_id);	
			}else{
				$notmember = 1;
			}
		}else{
			$notmember = 1;
		}
	}else{
		if(!empty($course_cost) && empty($com_id)){
			$course_purchase = 1;
		}else{
			$notmember = 1;
		}
		$non_loggedin = 1;
	}
}else{
	if(is_super_admin() || current_user_can('site_owner')){
		$btn_text = 'View';
	}else{
		if(is_user_logged_in()){
			if(!empty($order_existance) || !empty($micro_course_order_existance)){
				$btn_text = 'View';
			}else{
				$btn_text = 'View';
				if(!empty($course_cost)){
					$btn_text = $lx_lms_settings['course_currency_setting'].$lx_lms_settings['course_currency_symbol'].$course_cost.' Purchase';
					$isviewwidth = 'width: 90%;margin: 0 auto;';
					$show_statusbar='display:none;';
					$course_purchase = 1;
				}
			}
		}else{
			$non_loggedin = 1;
			if(!empty($course_cost)){
				$course_purchase = 1;
			}
		}
	}
}
if( $notmember == 1 ){
	$btn_text = 'View';
	if(!empty($course_cost)){
		$btn_text = $lx_lms_settings['course_currency_setting'].$lx_lms_settings['course_currency_symbol'].$course_cost.' Purchase';
		$isviewwidth = 'width: 90%;margin: 0 auto;';
	}
	$redirect_link = 'javascript:void(0);';
	$btn_disabled = 'disabled=disabled';
	$btn_class = 'btn_disabled_state';
	$show_statusbar='display:none;';
}
if( $non_loggedin == 1 ){
	$btn_text = 'View';
	if(!empty($course_cost)){
		$btn_text = $lx_lms_settings['course_currency_setting'].$lx_lms_settings['course_currency_symbol'].$course_cost.' Purchase';
		$isviewwidth = 'width: 90%;margin: 0 auto;';
		$show_statusbar='display:none;';
	}
	
	$redirect_link = get_permalink($course_id);
	if(!empty($course_cost) && empty($com_id) ){
		$data=base64_encode('is_purchase=yes&course_id='.$course_id);
		$redirect_link=site_url().'/login/'.$data;
		/* $redirect_link = 'javascript:void(0);'; */
	}else{
		$redirect_link = 'javascript:void(0);';
	}
	/* $btn_disabled = 'disabled=disabled';
	$btn_class = 'btn_disabled_state'; */
	$show_statusbar='display:none;';
}
$navigate = $redirect_link;
if( empty($com_id) && $non_loggedin == 1 ){
	$navigate = get_permalink($course_id);
}
?>
<div class="card style_2_main_div">
	<?php 
		$author_id=get_post($course_id)->post_author;
		if((current_user_can('administrator') || current_user_can('site_owner') || current_user_can('community_owner')) && get_current_user_id()==$author_id){
		?>
		<form action="<?php echo site_url().'/create-courses/';?>" method="post">
			<input type="hidden" name="edit_course_id" value="<?php echo $post_id;?>">
			<button type="submit" style="z-index:1;" class="btn_normal_state btn_edit_icon btn_edit_tiles"><i class="<?php echo $square_icon['edit'];?>"></i></button>
		</form>
		<?php
		}
	?>
	<div class="card-image" style="position:relative;">
		<?php 
		$subtitle= '';
		if(!empty(get_post_meta($course_id,'lx_course_subtitle',true))){
			$subtitle = get_post_meta($course_id,'lx_course_subtitle',true);
		}
		
		$exall_membership = explode(',',$all_membership);
		if(!in_array($com_id,$exall_membership) && get_post_meta($course_id,'course_display',true) == 'in_community'){
			?>
			<div style="padding:5px;color:#fff;background-color:<?php echo $color_palette['orange'];?>;position: absolute;width: 100%;" class="text-center">Membership Required: <?php echo get_post( $com_id )->post_title;?></div>
			<?php
		}
		?>
		<?php 
		if(in_category('featured',$course_id)){
			?>
			<div class="coursetilefeatured">Featured</div>
			<?php
		} ?>
		<?php if(!empty($thumbnail_image)){ ?>
			<a href="<?php echo $navigate;?>">
				<img class="card-img-top" src="<?php echo $thumbnail_image;?>" alt="Card image cap">
			</a>
		<?php }else{ ?>
				<a href="<?php echo $navigate;?>">
				<img class="card-img-top" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg';?>" alt="Card image cap">
			</a>
		<?php } ?>
		<?php 
		if(!empty($com_id)){ 
			$is_parent_com = get_post($com_id)->post_parent;
			$faviconcourse = '';
			if( $is_parent_com == 0 ){
				$faviconcourse = get_post_meta($com_id,'community_favicon_path',true);
			}else{
				$faviconcourse = get_post_meta($com_id,'community_favicon_path',true);
				if(empty($faviconcourse)){
					$get_parent_comm = get_post($com_id)->post_parent;
					$faviconcourse = get_post_meta($get_parent_comm,'community_favicon_path',true);
				}
			}
			if(!empty($faviconcourse)){
			?>
				<div style="position:absolute;bottom:51px;"><img class="coursetilefavicon" src="<?php echo $faviconcourse;?>" /></div>
			<?php }
		} ?>
		<div class="row div_bottom div_bottom_course" style="background: <?php echo $style_2_tiles_interface['completion_bg_color']; ?>;opacity: 95%;height:50px;display: flex;align-items: center;padding: 5px;margin:unset;">
			<?php
			if( $course_purchase == 1 ){
			?>
				<div class="col-md-6" style="padding-right:5px;padding-left:5px;">
					<a href="<?php echo $navigate;?>"  style="<?php echo $stylefr; ?>;margin-right: 5px;">
						<button class="<?php echo $btn_class;?> w-100" <?php echo $btn_disabled;?> style="position: relative;">View</button>
					</a>
				</div>
				
				<div class="col-md-6" style="padding-right:5px;padding-left:5px;">
					<?php 
					if( is_user_logged_in() ){
						echo $payment_content = do_shortcode( '[accept_stripe_payment id="'.$post_id.'" description="#'.$course_id.'" name="'.$post_title.'" price="'.$course_cost.'" button_text="'.$btn_text.'" billing_address="0" shipping_address="0" class="btn_normal_state btn_lx_course_purchase" payment_info= "custom_payment" currency="'.$lx_lms_settings['course_currency_setting'].'"]');
					}else{
						?>
						<a href="<?php echo $redirect_link;?>"  style="">
							<button class="btn_normal_state w-100" style="position: relative;margin:2px;"><?php echo $btn_text;?></button>
						</a>
						<?php
					} ?>
				</div>
			<?php }else{
				if( is_user_logged_in() ){
					?>
					<div class="col-md-8 p-0 d-flex align-items-center">
						<span class="favicon favicon_course" style="<?php echo $show_statusbar; ?>">
							<div class="content_status" style="background: <?php echo $bg;?>;margin-left: 5px;"></div>
							<span class="course_status" style="width: 50%;color:<?php echo $style_2_tiles_interface['completion_status_color']; ?>;"><?php echo $status;?></span>
						</span>
					</div>
					<div class="style2_btn_view col-md-4 p-0">
						<div class="" >
							<a href="<?php echo $redirect_link;?>"  style="<?php echo $stylefr; ?>;margin-right: 5px;">
								<button class="<?php echo $btn_class;?> w-100" <?php echo $btn_disabled;?> style="position: relative;margin:2px;"><?php echo $btn_text; ?></button>
							</a>
						</div>
					</div>
					<?php
				}else{
					$stylefr='';
					if( $btn_text == 'View' ){
						$stylefr="float:right;";
					}
					?>
					<div class="style2_btn_view col-md-12 p-0">
						<div class="" >
							<a href="<?php echo $redirect_link;?>">
								<button class="<?php echo $btn_class;?> w-100" <?php echo $btn_disabled;?> style="position: relative;margin:2px;"><?php echo $btn_text; ?></button>
							</a>
						</div>
					</div>
				<?php }
			} ?>
		</div>
	</div>
	<?php if(!empty($tag)){ ?>
		<div class="category"><span class="small"><?php echo $tag;?></span></div>
	<?php } ?>
	<div class="card-body" style="padding: 0.9rem;">
		<div class="row" style="color:#ccc;">
			<?php 
			$course_cat = array();
			if( !empty(get_the_category($course_id)) ){
				foreach( get_the_category($course_id) as $catdata ){
					if($catdata->slug != 'featured'){
						$course_cat[] = $catdata;
					}
				}
			}
			$c_certificated = get_post_meta($course_id ,'lx_certificate',true);
			$cat_div = 'col-md-12';
			if( !empty(get_post_meta($course_id,'lx_course_cpd_points',true)) && !empty($course_cat) ){
				$cat_div = 'col-md-6';
			}
			if( !empty(get_post_meta($course_id,'lx_course_cpd_points',true)) || $c_certificated == 'on'){
				?>
				<div class="<?php echo $cat_div;?> d-flex">
					<?php 
					if( !empty(get_post_meta($course_id,'lx_course_cpd_points',true)) ){
					?>
					CPD:<?php echo get_post_meta($course_id,'lx_course_cpd_points',true) . 'pts';?>
					<?php } ?>
					<?php
					if( $c_certificated == 'on' && $status != 'Completed' ){
						?>
						<i class="<?php echo $square_icon['certificate_icon'];?> pl-1"></i>
						<?php
					}
					if( $c_certificated == 'on' && $status == 'Completed' ){
						?>
						<i style="color:<?php echo $bg;?>" class="<?php echo $square_icon['certificate_icon'];?> pl-1"></i>
						<?php
					}
					?>
				</div>
				<?php 
			}
			?>
		</div>
		<div class="card-title course_title mb-0">
			<a href="<?php echo $navigate; ?>"><h3 class="head_h3"><?php echo $post_title;?></h3></a>
		</div>
		<?php if(!empty($subtitle)){ ?>
		<h6 class="course_subtitle_tile head_h6">
			<?php echo $subtitle;?>
		</h6>
		<?php } ?>
		<div class="description_body card_blog_description"><?php echo FnFormatMytextNLignore( $post_description );?></div>
	</div>
</div>