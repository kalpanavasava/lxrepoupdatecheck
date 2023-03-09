<?php global $lx_plugin_urls,$color_palette,$lx_lms_settings,$square_icon; ?>
<div class="card style_3_main_div">
	<div class="content_thumb" style="position:relative;">
		<style>
		.communitytilelabel{
			height: inherit;
			position: absolute;
			width: 100%;
			color:#fff;left: 0px;
		}
		.home_favicon{
			max-width: unset !important;
			position: absolute;
			bottom: 10px;
			left: 5px;
			width: 37px !important;
			padding: 0px !important;
		}
		.comm_pstatus{
			height: fit-content;
			padding: 2px;
			background-color: <?php echo $color_palette['green'];?>;
			color: #fff;
			position: absolute;
			float: right;
			right: 5px;
			bottom: 10px;
		}
		.comm_tile_catshow{
			font-size:11px;
		}
		.communitytilesubtitle{
			overflow: hidden;
			display: -webkit-box;
			-webkit-box-orient: vertical;
			-webkit-line-clamp: 2;
		}
		.commtile_subtitle{
			display: -webkit-box;
			-webkit-line-clamp: 2;
			-webkit-box-orient: vertical;
			overflow: hidden;
			text-overflow: ellipsis;
		}
		</style>
		<?php 
		/* echo "<pre>";print_r($color_palette); */
		$ctype = '';
		if( in_category('public',$post_id) ){
			
			$joiningfee = get_post_meta($post_id,'joiningfee',true);
			$cost = get_post_meta($post_id,'_mepr_product_price',true);
			if( $joiningfee == 'on' && !empty($cost) ){
				$ctype = "<div class='communitytilelabel text-center' style='background:".$color_palette['blue'].";width: 50%;'>".$lx_lms_settings['course_currency_setting'].$lx_lms_settings['course_currency_symbol'].$cost."</div>";
			}
		}
		if( in_category('invite-only',$post_id) ){
			$ctype = "<div class='communitytilelabel text-center' style='background:".$color_palette['purple']."'>INVITE-ONLY</div>";
		}
		if( in_category('restricted-access',$post_id) ){
			$ctype = "<div class='communitytilelabel text-center' style='background:".$color_palette['orange']."'>RESTRICTED: Code required</div>";
		}
		if( in_category('unlisted',$post_id) ){
			$ctype = "<div class='communitytilelabel'></div>";
		}
		
		?>
		<?php echo $ctype;?>
		<?php 
			$style="";
			if(in_category('invite-only',$post_id) || in_category('restricted-access',$post_id) ){
				$style="style='top:20px;'";
			}
			$author_id=get_post($post_id)->post_author;
			if((current_user_can('administrator') || current_user_can('site_owner') || current_user_can('community_owner')) && get_current_user_id()==$author_id){
			?>
			<form action="<?php echo site_url().'/create-community/';?>" method="post">
				<input type="hidden" name="community_edit_id" value="<?php echo $post_id;?>">
				<button type="submit" class="btn_normal_state btn_edit_icon btn_edit_tiles" <?php echo $style;?>><i class="<?php echo $square_icon['edit'];?>"></i></button>
			</form>
			<?php
			}
		?>
		<a href="<?php echo $redirect_link;?>">
			<?php if(!empty($thumbnail_image)){ ?>
				<img src="<?php echo $thumbnail_image;?>" style="width:100%;">
			<?php } else{ ?>
				<img class="card-img-top" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg';?>" alt="Card image cap">
			<?php } 
			if(!empty($favicon_img)){ ?>
					<img src="<?php echo $favicon_img; ?>" class="style3_fav_img home_favicon">
			<?php } ?>
			<?php 
			$author_id=get_post($post_id)->post_author;
			if((current_user_can('administrator') || current_user_can('site_owner') || current_user_can('community_owner')) && get_current_user_id()==$author_id){
				$pstatus = '';
				if( get_post($post_id)->post_status == 'publish' ){
					$pstatus = 'PUBLISHED';
				}
				?>
				<div class="comm_pstatus"><?php echo $pstatus;?></div>
				<?php
			} 
			?>
		</a>
	</div>
	<?php
		$commcat = get_term_by('slug','community-category','category');
		$get_community_category = $wpdb->get_results("select * from ".$wpdb->prefix."term_taxonomy as tt,".$wpdb->prefix."terms as t where tt.parent='".$commcat->term_id."' and tt.term_id=t.term_id");
		$cnt=0;
		foreach( $get_community_category as $ccdata ){
			if( in_category($ccdata->slug,$post_id) ){
				$cnt++;
				$cat_name=$ccdata->name;
			}
		}
		if(in_category('featured',$post_id) || $cnt>0){
	?>
	<div class="row comm_tile_catshow" style="min-height: 32px;">
			<?php 
		$div_width = 'col-md-12';$text_center='text-center';
		if(in_category('featured',$post_id)){
			?>
			<div class='col-md-6'>
				<div style="background-color:<?php echo $color_palette['green'];?>;color:#fff;text-align: center;">
				<?php 
				$div_width = 'col-md-6';
				$text_center='';
					echo "FEATURED";
				?>
				</div>
			</div>
		<?php } ?>
		<div class='<?php echo $div_width." ".$text_center ;?>' style="color:#ccc;">
			<?php  echo $cat_name; ?>
		</div>
	</div>
	<?php } ?>
	<div class="community_title">
		<a href="<?php echo $redirect_link; ?>"><h3 class="head_h3"><?php echo $post_title;?></h3></a>
	</div>
	<div class="commtile_subtitle">	
		<h6 class="head_h6"><?php echo get_post_meta($post_id,'sub_title',true);?></h5>
	</div>
	<?php /* <h4 class="head_h4 communitytilesubtitle"><?php echo get_post_meta($post_id,'sub_title',true);?></h4> */ ?>
	<div class="description_body card_blog_description"><?php echo FnFormatMytextNLignore($post_description);?></div>
	<div style="display: flex;align-items: center;">
		<?php
			$class='';
			if( $info == "community_info" && $open_in != "lightbox" ){
				$membership=$wpdb->get_results("select memberships from ".$wpdb->prefix."mepr_members where user_id='".$user_id."'");
				$ms_id=explode(',',$membership[0]->memberships);
				/* if(in_array($all_memberships_data->ID,$ms_id)){
					$btn_text = "View";
				} else{
					$btn_text = "Join";
				} */
				$btn_color = '';
				if(in_array($all_memberships_data->ID,$ms_id)){
					/* if( in_category('invite-only',$post_id) ){
						?>
						<style>
							.main_commnity_homebtn:hover{
								color:<?php echo $color_palette['purple'];?>
							}
						</style>
						<?php
						$btn_color = "background:".$color_palette['purple'];
					} */
					$btn_text = 'View';
				}else{
					if( in_category('restricted-access',$post_id) ){
						if(is_user_logged_in()){
							$btn_text = 'Enter Access Code';
							?>
							<style>
								.main_commnity_homebtn<?php echo $post_id;?>:hover{
									color:#fff;
								}
							</style>
							<?php
							$btn_color = "background:".$color_palette['orange'].";border:1px solid ".$color_palette['orange'];
						}else{
							
							$btn_text = 'Login/Register';
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
								
								?>
								<style>
									.main_commnity_homebtn<?php echo $post_id;?>:hover{
										color:#fff;
									}
								</style>
								<?php
									$btn_color = "background:".$color_palette['purple'].";border:1px solid ".$color_palette['purple'];
								}
						}else{
							$btn_text = 'Login/Register';
						}
					}else{
						$btn_text = 'Join';	
					}
				} 
			} else if( $info != "community_info" && $open_in != "lightbox" ){
				$btn_text = "View";
			}
		?>
		<div style="display:flex;">
		<?php 
		$author_id = get_post( $post_id )->post_author;
		/* echo $post_id; */
		$user = get_userdata( $author_id );

		// Get all the user roles as an array.
		$user_roles = $user->roles;
		$comm_owner = 0;
		if(in_array('community_owner',$user_roles)){
			$comm_owner = 1;
		}
		/* echo "<pre>";print_r($user_roles); */
		?>
			<div>
				<a href="<?php echo $redirect_link;?>">
					<button class="btn_normal_state main_commnity_homebtn<?php echo $post_id;?> <?php echo $class;?>" style="position: relative;margin:2px;<?php echo $btn_color;?>" data-community_id="<?php echo $post_id;?>"><?php echo $btn_text; ?></button>
				</a>
			</div>
			<?php 
			if( $comm_owner == 1 ){
				$firstname = get_user_meta($author_id,'first_name',true);
				$lastname = get_user_meta($author_id,'last_name',true);
				?>
				<div style="padding-left: 10px;">
					<b>Communnity owner:</b>
					<div><?php echo $firstname.' '.$lastname;?></div>
				</div>
				<?php 
			}
			?>
		</div>
	</div>
</div>