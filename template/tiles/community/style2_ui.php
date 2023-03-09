<?php global $lx_plugin_urls,$color_palette,$lx_lms_settings,$square_icon;$style_2_tiles_interface ?>
<div class="card style_2_main_div">
	<div class="card-image">
		<style>
		.communitytilelabel{
			height: inherit;
			position: absolute;
			width: 100%;
			color:#fff;
		}
		.btn_normal_state:hover{
			height:unset;
		}
		.btn_normal_state{
			font-size: 12px;
			height:unset;
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
		echo $ctype;
		?>
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
		<?php if(!empty($thumbnail_image)){ ?>
			<a href="<?php echo $url;?>">
				<img class="card-img-top" src="<?php echo $thumbnail_image;?>" alt="Card image cap">
			</a>
		<?php }else{ ?>
				<a href="<?php echo $url;?>">
				<img class="card-img-top" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg';?>" alt="Card image cap">
			</a>
		<?php } ?>
		<div class="div_bottom" style="background: <?php echo $style_2_tiles_interface['completion_bg_color']; ?>;opacity: 95%;height:50px;display: flex;align-items: center;">
				
			<span class="favicon" style="width:50%" >
				<?php  
					if(!empty($favicon_img)){ ?>
						<img src="<?php echo $favicon_img; ?>" style="width: 50px !important;background: #FFFFFF;border: 2px solid #EFEFEF;"/>
				<?php } ?>
			</span>
			<?php 
				$class='';
				if( $info == "community_info" && $open_in != "lightbox" ){
					$membership=$wpdb->get_results("select memberships from ".$wpdb->prefix."mepr_members where user_id='".$user_id."'");
					$ms_id=explode(',',$membership[0]->memberships);
					$btn_color = '';
					if(in_array($all_memberships_data->ID,$ms_id)){
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
				} 
				if( $open_in != "lightbox" ){ ?>
					<a href="<?php echo $url;?>" style="width:50%;margin:auto;"><span style="float: right;"><button  class="btn_normal_state btn-view main_commnity_homebtn<?php echo $post_id;?> <?php echo $class;?>" style="<?php echo $btn_color;?>" data-status="<?php echo $completed;?>" data-community_id="<?php echo $post_id;?>"><?php echo $btn_text; ?></button></span></a>
			<?php } ?>
		</div>
	</div>
	<div class="card-body" style="padding: 0.9rem;">
			<div class="card-title community_title mb-0">	
				<a href="<?php echo $redirect_link; ?>"><h3 class="head_h3"><?php echo $post_title;?></h3></a>	
			</div>
			<div class="description_body card_blog_description"><?php echo FnFormatMytextNLignore($post_description);?></div>
	</div>
</div>