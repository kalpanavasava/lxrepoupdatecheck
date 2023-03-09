<?php 
global $lx_plugin_urls,$color_palette,$lx_lms_settings,$community_tiles_interface,$square_icon; 
/* echo "<pre>";print_r($community_tiles_interface); */
?>
<style>
.style_5_main_div .mepr-price-box-button , .style_5_main_div .mepr-price-box-button:hover , .style_5_main_div .mepr-price-box-button:focus{	
	padding-top: 9px !important;
}
.color_palette_info{
	color:<?php echo $color_palette['charcoal'];?> !important ;
}
.community_row .status_bar{
	opacity:<?php echo $community_tiles_interface['tiles_colored_bg_opacity'];?> !important;
}
.community_row .c_desc{
	color : <?php echo $community_tiles_interface['tiles_body_text_color']; ?> !important;
}
.hm_btn{
	height:unset;
	font-size: 12px;
	bottom: 70px;
}
.hm_btn:hover{
	height:unset;
}
</style>
<?php 
/* echo "<pre>";print_r($color_palette['blue']); */
if(!empty($thumbnail_image)){ $thumb_img = $thumbnail_image; }else{ $thumb_img = $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg'; } ?>
<a <?php echo $post_id; ?> href="<?php echo get_permalink($post_id);?>" style="width: 100%;text-decoration: none;">
	<div class="card style_5_main_div" style="border: 2px solid <?php echo $color_palette['border'];?>;">
		<div class="mepr-price-box-title">
			<?php
				$author_id=get_post($post_id)->post_author;
				if((current_user_can('administrator') || current_user_can('site_owner') || current_user_can('community_owner')) && get_current_user_id()==$author_id){
				?>
				<div style="display:flex;flex:1;">
					<h3 class="head_h3" style="flex:0.8;"><?php echo $post_title; ?></h3>
					<form action="<?php echo site_url().'/create-community/';?>" method="post" style="flex: 0.2;">
						<input type="hidden" name="community_edit_id" value="<?php echo $post_id;?>">
						<button type="submit" class="btn_normal_state btn_edit_icon btn_community_edit"><i class="<?php echo $square_icon['edit'];?>"></i></button>
					</form>
				</div>
				<?php
				}else{
			?>
				<h3 class="head_h3"><?php echo $post_title; ?></h3>
			<?php } ?>
		</div>
		<div class="card-body community_tile_body" style="text-align: center;">
			<div class="community_thumb" style="background-image: url(<?php echo $thumb_img;?>);background-repeat: no-repeat;background-size: cover;">
				<?php 
				$author_id=get_post($post_id)->post_author;
				if((current_user_can('administrator') || current_user_can('site_owner') || current_user_can('community_owner')) && get_current_user_id()==$author_id){
					$pstatus = '';
					if( get_post($post_id)->post_status == 'publish' ){
						$pstatus = 'PUBLISHED';
					}
					?>
					<div style="height: fit-content;padding: 4px;background-color: <?php echo $color_palette['green'];?>;color: #fff;"><?php echo $pstatus;?></div>
					<?php
				} 
				?>
				<?php if(!empty($favicon_img)){ ?>
				<span class="home_favicon"><img src="<?php echo $favicon_img; ?>"></span> 
				<?php } ?>
				<?php 
				
				$ctype = '';
				if( in_category('public',$post_id) ){
					$overlay_clr = "background-color:".$community_tiles_interface['tiles_colored_background'];
					$joiningfee = get_post_meta($post_id,'joiningfee',true);
					$cost = get_post_meta($post_id,'_mepr_product_price',true);
					if( $joiningfee == 'on' && !empty($cost) ){
						$ctype = "<button class='btn_normal_state' style='cursor-pointer:none;'>".$lx_lms_settings['course_currency_setting'].$lx_lms_settings['course_currency_symbol'].$cost."</button>";
					}
				}
				if( in_category('invite-only',$post_id) ){
					$overlay_clr = "background-color:".$community_tiles_interface['invite_only_background'];
					$ctype = "INVITE-ONLY";
				}
				if( in_category('restricted-access',$post_id) ){
					$overlay_clr = "background-color:".$community_tiles_interface['restricted_only_background'];
					$ctype = "RESTRICTED";
				}
				if( in_category('unlisted',$post_id) ){
					$overlay_clr = "background-color:".$community_tiles_interface['tiles_colored_background'];
					$ctype = "UNLISTED";
				}
				
				/* echo $ctype; */
				?>
				<div class="status_bar" style ="<?php echo $overlay_clr;?> !important;">
					<span class="community_type_color description_body"><?php echo $ctype;?></span>
					<div class="c_desc description_body"><?php  echo FnFormatMytextNLignore($post_description); ?></div>
				</div>
				<?php
					$class='';
					$btn_color='';
					if($info == "community_info" ){
						$membership=$wpdb->get_results("select memberships from ".$wpdb->prefix."mepr_members where user_id='".$user_id."'");
						$ms_id=explode(',',$membership[0]->memberships);
						
						if(in_array($all_memberships_data->ID,$ms_id)){
							$btn_text = 'View';
						}else{
							if( in_category('restricted-access',$post_id) ){
								if(is_user_logged_in()){
									$btn_text = 'Enter Access Code';
								}else{
									/* $btn_text = 'Login/Register'; */
									$btn_text = 'View';
								}
							}
							elseif( in_category('invite-only',$post_id) ){
								if(is_user_logged_in()){
									$invited_users=explode(',',get_post_meta($post_id,'invited_users',true));
									$uemail=get_userdata(get_current_user_id())->user_email;
									if(in_array($uemail,$invited_users)){
										$btn_text = 'Request Sent';
										$btn_color = "background:".$color_palette['mid_grey'].";border:1px solid ".$color_palette['mid_grey'].";color:".$color_palette['white'];
									}else{
										$btn_text = 'Request invite';
										$class='send_request_invite';
									}
								}else{
									$btn_text = 'Login/Register';
								}
							}else{
								$btn_text = 'Join';	
							}
						} 
						?>
						<div class="hm_btn mepr-price-box-button btn_normal_state <?php echo $class;?>" data-community_id="<?php echo $post_id;?>" style="<?php echo $btn_color;?>"><?php echo $btn_text;?></div>
						<?php
					}
				?>
			</div>
			<div class="row" style="min-height: 40px;">
				<div class='col-md-6'>
					<div style="background-color:<?php echo $color_palette['green'];?>;color:#fff;">
					<?php 
						if(in_category('featured',$post_id)){
							echo "FEATURED";
						} 
					?>
					</div>
				</div>
				<div class='col-md-6' style="color:#ccc;">
				<?php 
					$commcat = get_term_by('slug','community-category','category');
					/* $args = array(
						 'child_of'      => $commcat->term_id,
						 'hide_empty' => false, 
					); 
					$get_community_category = get_terms('category', $args); */
					$get_community_category = $wpdb->get_results("select * from ".$wpdb->prefix."term_taxonomy as tt,".$wpdb->prefix."terms as t where tt.parent='".$commcat->term_id."' and tt.term_id=t.term_id");
					foreach( $get_community_category as $ccdata ){
						if( in_category($ccdata->slug,$post_id) ){
							echo $ccdata->name;
						}
					}
				?>
				</div>
			</div>				
		</div>
	</div>
</a>