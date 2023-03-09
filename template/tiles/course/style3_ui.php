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
	
	/* if(!empty($com_id)){
		echo $com_id;
	} */
	
$course_cost=get_post_meta($post_id,'lx_course_cost',true);
$order_existance = check_lx_course_order_exists($post_id,get_current_user_id());
$macro_course_id = get_post_meta( $post_id,'lx_associated_macro_course',true);
if($macro_course_id != 0 && !empty($macro_course_id)){
	$micro_course_order_existance = check_lx_course_order_exists($macro_course_id,get_current_user_id());
}
				
$get_user_membership = $wpdb->get_results("select * from ".$wpdb->prefix."mepr_members where user_id='".get_current_user_id()."'");
$all_membership = $get_user_membership[0]->memberships;
$btn_disabled = '';$btn_class = 'btn_normal_state';$btn_text = '';$course_purchase = 0;$isviewwidth = 'width:50%;';$show_statusbar='';$non_loggedin = 0;$notmember = 0;
?>
<style>
	.coursetilefavicon{
		position: absolute;
		width: 35px;
		height: 35px;
		bottom: 10px;
		left: 10px;
	}
	.coursetilefeatured{
		position:absolute;
		background-color:<?php echo $color_palette['green'];?>;
		top: 52px;
		color:#fff;
		padding:0px 5px;
	}
</style>
<?php
if(!empty($com_id)){
	?>
	<style>
	.asp_product_buy_button,.asp_product_buy_btn_container,.btn_lx_course_purchase{
		width:100%;
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
						$isviewwidth = 'width:100%;';
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
					$isviewwidth = 'width:100%;';
					$show_statusbar='display:none;';
					$course_purchase = 1;
				}
			}
		}else{
			$non_loggedin = 1;
		}
	}
}
if( $notmember == 1 ){
	$btn_text = 'View';
	if(!empty($course_cost)){
		$btn_text = $lx_lms_settings['course_currency_setting'].$lx_lms_settings['course_currency_symbol'].$course_cost.' Purchase';
		$isviewwidth = 'width:100%;';
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
		$isviewwidth = 'width:100%;';
		$show_statusbar='display:none;';
	}
	$redirect_link = get_permalink($course_id);
	if(!empty($course_cost) && empty($com_id)){
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
<div class="card style_3_main_div">

	<div class="content_thumb" style="position:relative;">
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
		<?php 
		$subtitle= '';
		if(!empty(get_post_meta($course_id,'lx_course_subtitle',true))){
			$subtitle = get_post_meta($course_id,'lx_course_subtitle',true);
		}
		
		$exall_membership = explode(',',$all_membership);
		if(!in_array($com_id,$exall_membership) && get_post_meta($course_id,'course_display',true) == 'in_community'){
			?>
			<div style="padding:5px;color:#fff;background-color:<?php echo $color_palette['orange'];?>;position: absolute;width: 100%;left: 0px;" class="text-center">Membership Required: <?php echo get_post( $com_id )->post_title;?></div>
			<?php
		}
		?>
		<?php 
		if(in_category('featured',$course_id)){
			?>
			<div class="coursetilefeatured">Featured</div>
			<?php
		} ?>
		<a href="<?php echo $navigate;?>">
			<?php if(!empty($thumbnail_image)){ ?>
				<img src="<?php echo $thumbnail_image;?>" style="width:100%;">
			<?php } else{ ?>
				<img class="card-img-top" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg';?>" alt="Card image cap">
			<?php } 
			/* if(!empty($favicon_img)){ ?>
				<span class="home_favicon"><img src="<?php echo $favicon_img; ?>" class="style3_fav_img"></span> 
			<?php } */ ?>
		</a>
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
			/* lxprint( get_post_meta($com_id,'community_favicon_path',true) ); */
			if(!empty($faviconcourse)){
			?>
			<img class="coursetilefavicon" src="<?php echo $faviconcourse;?>" />
			<?php }
		} ?>
	</div>
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
		/* echo "<pre>";print_r($course_cat); */
		$c_certificated = get_post_meta($course_id ,'lx_certificate',true);
		$cat_div = 'col-md-12';
		if( !empty(get_post_meta($course_id,'lx_course_cpd_points',true)) || !empty($course_cat) ){
			$cat_div = 'col-md-6';
		}
		if( !empty(get_post_meta($course_id,'lx_course_cpd_points',true)) || $c_certificated == 'on'){
			?>
			<div class="<?php echo $cat_div;?>">
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
		/* echo "<pre>";print_r(get_the_category($course_id)); */
		if( !empty($course_cat) ){
			$cat = '';
			if(count($course_cat) > 1){
				$cat = 'Multiple';
			}
			if(count($course_cat) == 1){
				$cat = $course_cat[0]->name;
			}
			?>
			<div class="<?php echo $cat_div;?> d-flex justify-content-end">
				<?php echo $cat;?>
			</div>
			<?php
		}
		?>
	</div>
	<div class="card-title course_title mt-0_75em">
		<a href="<?php echo $navigate; ?>"><h3 class="head_h3"><?php echo $post_title;?></h3></a>
	</div>
	<?php if(!empty($subtitle)){ ?>
	<h6 class="course_subtitle_tile head_h6">
		<?php echo $subtitle;?>
	</h6>
	<?php } ?>
	<div class="description_body card_blog_description"><?php echo FnFormatMytextNLignore( $post_description );?></div>
	<div style="display: flex;align-items: center;">
		<?php
			if( $course_purchase == 1 ){
				echo $payment_content = do_shortcode( '[accept_stripe_payment id="'.$post_id.'" description="#'.$post_id.'" name="'.$post_title.'" price="'.$course_cost.'" button_text="'.$btn_text.'" billing_address="0" shipping_address="0" class="btn_normal_state btn_lx_course_purchase" payment_info= "custom_payment" currency="'.$lx_lms_settings['course_currency_setting'].'"]');
			}else{
				?>
				<div style="<?php echo $isviewwidth;?>">
					<a href="<?php echo $redirect_link; ?>">
						<button type="button" class="<?php echo $btn_class;?> w-100" <?php echo $btn_disabled;?> style="position: relative;margin:2px;"><?php echo $btn_text;?></button>
					</a>
				</div>
				<?php
			}
			?>
		<div class="view_status_div" style="width:50%;<?php echo $show_statusbar; ?>">
			<div class="view_content_status_div">
				<div class="content_status" style="background: <?php echo $bg;?>;" data-status="<?php echo $completed;?>"></div>
				<span class="course_status" style="color:<?php echo $color_palette['hyperlinks']; ?>;width: 65px;"><?php echo $status;?></span>
			</div>
		</div>
	</div>
</div>