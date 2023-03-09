<?php
/**** for settings ui ****/
function settings_ui(){
	global $s3_settings,$base64_encode_setting,$lx_lms_settings,$color_palette,$login_settings,$learning_locker_setting,$lx_plugin_paths;
		include($lx_plugin_paths['lx_lms_lite'].'assets/css/lms_user_interface_settings.php');
	?>
	<div class="lp-screen" style="display:none;"><span><img class="user_interface_loader_img" src="<?php echo get_stylesheet_directory_uri().'/assets/loader/05.svg'?>"></div>
		<div class="container user_interface lx_lms_setting">
			<div class="row lx_lms_settings_top pt-5">
				<div class="col-md-12">
					<h2 class='head_h2'>Settings</h2>
				</div>
			</div>
			<hr/>
			
			<div class="main_div">
				<div class="row row_tab seven-cols text-center">
					<div class="active col staging_tools_settings_info tab_bottom col-md-3">
						<a class="tablinks" onclick="opentab(event, 'staging_tools_settings','staging_tools_settings_info');" style="cursor: pointer;">Staging Tools</a>
					</div>
					<div class="col ui_general_settings_info col-md-3">
						<a class="tablinks" onclick="opentab(event, 'ui_general_settings','ui_general_settings_info');" style="cursor: pointer;">General Site Settings</a>
					</div>
					<div class="ui_apis_setting_info col-md-3">
						<a class="tablinks" onclick="opentab(event, 'ui_apis_settings','ui_apis_setting_info');" style="cursor: pointer;">3rd Party Integrations</a>
					</div>
					<div class="col ui_login_settings_info col-md-2">
						<a class="tablinks" onclick="opentab(event, 'ui_login_settings','ui_login_settings_info');" style="cursor: pointer;">Login Settings</a>
					</div>
					
				</div>

				<div class="staging_tools_settings tabcontent" id="staging_tools_settings">
					<?php 
						require_once $lx_plugin_paths ['lx_lms_lite'].'template/lx_lms_staging_tools_ui.php';
					?>
				</div>
				<div class="general_settings tabcontent tab_view" id="ui_general_settings">
					<div class="container user_interface">
					<?php 
						require_once lx_lms_plugin_path.'template/lx_lms_general_site_settings_ui.php';
					?>
					</div>
				</div>
				<div class="apis_settings tabcontent tab_view" id="ui_apis_settings">
					<?php 
						require_once $lx_plugin_paths['lx_lms_lite'].'template/lx_lms_apis_settings_ui.php';
					?>
				</div>
				<div class="login_settings tabcontent tab_view" id="ui_login_settings">
					<?php 
						require_once $lx_plugin_paths['lx_lms_lite'].'template/lx_lms_login_settings_ui.php';
					?>
				</div>
			</div>
		</div>
	<?php
}

/**** for user interface settings ui ****/
function user_interface_settings_ui(){
	global $lx_plugin_paths,$frontend_icon,$square_icon,$button_styling,$color_palette,$menu_settings,$community_tiles_interface,$font_family,$s3_settings,$tiles_style,$style_2_tiles_interface,$lightbox_settings,$kit_code;
		include($lx_plugin_paths['lx_lms_lite'].'assets/css/lms_user_interface_settings.php');
	?>
	<script src="https://kit.fontawesome.com/<?php echo $kit_code;?>.js" crossorigin="anonymous"></script>
	<div class="lp-screen" style="display:none;"><span><img class="user_interface_loader_img" src="<?php echo get_stylesheet_directory_uri().'/assets/loader/05.svg'?>"></div>
	<form method="post" id="user_interface_settings">
			<div class="container user_interface">
				<div class="row user_interface_setting_top pt-5">
					<div class="col-md-12">
						<h2 class="head_h2">User Interface Settings</h2>
					</div>
				</div>
				<hr/>
				
				<div class="main_div">
					<div class="row row_tab seven-cols text-center">
						<div class=" ui_settings_color_palette_info tab_bottom col-md-3">
							<a class="tablinks" onclick="opentab(event, 'ui_settings_color_palette','ui_settings_color_palette_info');" style="cursor: pointer;">Color Palette</a>
						</div>
						<div class=" col ui_settings_fonts_info col-md-3">
							<a class="tablinks" onclick="opentab(event, 'ui_settings_fonts','ui_settings_fonts_info')" style="cursor: pointer;">Fonts</a>
						</div>
						<div class="col ui_settings_iconography_info col-md-3">
							<a class="primary tablinks" style="cursor: pointer;" onclick="opentab(event, 'ui_settings_iconography','ui_settings_iconography_info');">Iconography</a> 
						</div>	
						<div class="col ui ui_settings_buttons_info col-md-3">
							<a class="primary tablinks" style="cursor: pointer;" onclick="opentab(event, 'ui_settings_buttons','ui_settings_buttons_info');">Button Styling</a> 
						</div>	
					</div>
					<div class="color_palette tabcontent" id="ui_settings_color_palette">
						<?php 
							require_once $lx_plugin_paths['lx_lms_lite'].'template/lx_lms_color_palette_ui.php';
						?>
					</div>
					<div class="settings_fonts tabcontent tab_view" id="ui_settings_fonts">
						<?php 
							require_once $lx_plugin_paths['lx_lms_lite'].'template/lx_lms_fonts_ui.php';
						?>
					</div>
					<div class="settings_iconography tabcontent tab_view" id="ui_settings_iconography">
						<?php 
							require_once $lx_plugin_paths['lx_lms_lite'].'template/lx_lms_iconography_ui.php';
						?>
					</div>
					
					<div class="settings_buttons tabcontent tab_view" id="ui_settings_buttons">
						<?php 
							require_once $lx_plugin_paths['lx_lms_lite'].'template/lx_lms_buttons_ui.php';
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn_normal_state btn_save_user_settings">Save</button>
					</div>
				</div>
			</div>
		</form>
	<?php
	return;
}

/**** for layout template settings ui ****/
function layout_template_settings_ui(){
	global $lx_plugin_paths,$color_palette,$menu_settings,$community_tiles_interface,$tiles_style,$style_2_tiles_interface,$lexicon,$lightbox_settings,$page_style,$breakpoint,$page_devider;
		include($lx_plugin_paths['lx_lms_lite'].'assets/css/lms_user_interface_settings.php');
	?>
	<div class="lp-screen" style="display:none;"><span><img class="user_interface_loader_img" src="<?php echo get_stylesheet_directory_uri().'/assets/loader/05.svg'?>"></div>
	<form method="post" id="layout_template_settings">
			<div class="container user_interface">
				<div class="row user_interface_setting_top pt-5">
					<div class="col-md-12">
						<h2 class="head_h2">Layouts and templates</h2>
					</div>
				</div>
				<hr/>
				
				<div class="main_div">
					<div class="row row_tab seven-cols text-center">
						<div class="active col ui ui_settings_menu_info tab_bottom col-md-3">
							<a class="primary tablinks" style="cursor: pointer;" onclick="opentab(event, 'ui_settings_menu','ui_settings_menu_info');">Menu</a> 
						</div>	
						<div class="col ui_page_settings_info col-md-3">
							<a class="tablinks" onclick="opentab(event, 'ui_page_settings','ui_page_settings_info');" style="cursor: pointer;">Break points & Page dividers</a>
						</div>
						<div class="col ui ui_settings_tiles_info col-md-3">
							<a class="primary tablinks" style="cursor: pointer;" onclick="opentab(event, 'ui_settings_tiles','ui_settings_tiles_info');">Page and tiles templates</a> 
						</div>
						<div class="col ui iframe_content_settings_info col-md-3">
							<a class="primary tablinks" style="cursor: pointer;" onclick="opentab(event, 'iframe_content_settings','iframe_content_settings_info');">Lightbox styling</a> 
						</div>
					</div>
					<div class="settings_menu tabcontent" id="ui_settings_menu">
						<?php 
							require_once $lx_plugin_paths['lx_lms_lite'].'template/lx_lms_menu_ui.php';
						?>
					</div>
					<div class="page_settings tabcontent tab_view" id="ui_page_settings">
						<?php 
							require_once $lx_plugin_paths['lx_lms_lite'].'template/lx_lms_page_settings_ui.php';
						?>
					</div>
					<div class="settings_tiles tabcontent tab_view" id="ui_settings_tiles">
						<?php 
							require_once lx_lms_plugin_path.'template/lx_lms_tiles_ui.php';
						?>
					</div>
					<div class="iframe_settings tabcontent tab_view" id="iframe_content_settings">
						<?php 
							require_once $lx_plugin_paths['lx_lms_lite'].'template/lx_lms_iframe_content_settings_ui.php';
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn_normal_state btn_save_user_settings">Save</button>
					</div>
				</div>
			</div>
		</form>
	<?php
	return;
}

/**** for lexicon settings ui ****/
function lexicon_settings_ui(){
	global $lexicon,$lx_plugin_paths;
	include($lx_plugin_paths['lx_lms_lite'].'assets/css/lms_user_interface_settings.php');
	?>
	<div class="lp-screen" style="display:none;"><span><img class="user_interface_loader_img" src="<?php echo get_stylesheet_directory_uri().'/assets/loader/05.svg'?>"></div>
	<form method="post" id="lx_lms_lexicon_settings">
		<div class="container user_interface">
			<div class="row user_interface_setting_top pt-5">
				<div class="col-md-12">
					<h2 class="head_h2">Lexicon Setting</h2>
				</div>
			</div>
			<hr/>
			<?php require_once lx_lms_plugin_path.'template/lx_lms_lexicon_ui.php'; ?>
			<div class="row" style="margin-top: 50px;">
				<div class="col-md-12">
					<button type="submit" class="btn_normal_state btn_save_lexicon_setting">Save</button>
				</div>
			</div>
		</div>
	</form>
	<?php
	return;
}

/**** for store base64 settings ****/
function save_base64_settings($post){
	if ($post['switch']=='on') {
		$switch='ON';
	}else{
		$switch='OFF';
	}
	if ($post['page']=='on') {
		$page = 'ON';
	}else{
		$page = 'OFF';
	}
	if($post['post']=='on') {
		$posts = 'ON';
	}else{
		$posts = 'OFF';
	}
	$cout_elements = count($post['custom_post']);
	if($cout_elements > 0) {
		for($i = 0; $i <= $cout_elements; $i++) {
			if(isset($post['custom_post'][$i])){
				$custom_post_type[] = $post['custom_post'][$i];
			}
		}
	}
	$base_encode = array(
			'switch'=>$switch,
			'page'=>$page,
			'post'=>$posts,
			'custom_post_type'=>$custom_post_type
	);
	update_option( 'base64_encode_setting', $base_encode );
	return;
}

/**** for store lms lite page settings ****/
function lx_lms_lite_page_setting(){
	global $square_icon;
	?>
	<div class="row pt-5 pb-4">
		<div class="col-md-12 admin_section_title">
			<h4 class="head_h4">PAGE TEMPLATES</h4>
		</div>
	</div>
	<div class="row ai_center">
		<div class="col-md-3">
			<label class="col-form-label">Make these settings site-wide</label>
		</div>
		<div class="col-md-3">
			<label class="lx_toggle">
				<input type="checkbox" class="chk_site_wide" id="site-wide" name="site-wide" checked>
				<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
				<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
			</label>
		</div>
		<div class="col-md-6"></div>
	</div>
	<div class="row pt-3 pb-3">
		<div class="col-md-3">
			<label class="col-form-label">Course Page Template</label>
		</div>
		<div class="col-md-3">
			<input type="text" name="page['course_page']" value="Default Template" disabled style="text-align: center">
		</div>
	</div>
	<?php
}

/**** for save additional settings ****/
function save_additional_settings($post){
	if($post['author_visibility']=='on') {
		$author_visiblity = 'ON';
	}else{
		$author_visiblity = 'OFF';
	}	
	$lx_lms_settings = array(
		'author_visiblity'=> $author_visiblity,
		'course_purchasing_settings' => $post['course_purchasing_settings'],
		'receipt_prefix' => $post['receipt_prefix'],
	);
	update_option( 'lx_lms_settings', $lx_lms_settings );
	update_option( 'lx_lms_site_wide_certificate_settings', 'ON' );
	return;
}


/**** for save font settings ****/
function save_font_settings($post){
	$font_settings = array(
		'heading_font'=>$post['heading_font'],
		'body_font'=>$post['body_font'],
		'body_font_size'=>$post['body_font_size'],
		'h1_font'=>$post['h1_font'],
		'h2_font'=>$post['h2_font'],
		'h3_font'=>$post['h3_font'],
		'h4_font'=>$post['h4_font'],
		'h5_font'=>$post['h5_font'],
		'h6_font'=>$post['h6_font'],
		'body_font_info'=>$post['body_font_info'],
		'body_bold_font'=>$post['body_bold_font'],
		'sub_text_font'=>$post['sub_font']
	);
	update_option( 'user_interface_font_settings', $font_settings );
	return;
}

/**** for save icon settings ****/
function save_icon_settings($post){
	$elements = count($post['menu_info']);
	if($elements > 0) {
		foreach($post['menu_info'] as $key=>$val){
			update_post_meta($post['menu_info'][$key],'user_setting_menu_icon',$post['menu'][$key]);
		}
	}
	
	$items_with_square_button_background = array(
		'edit'=> !empty($post['edit'])?$post['edit']:'fas fa-pen',
		'trash'=> !empty($post['trash'])?$post['trash']:'fas fa-trash',
		'plus'=> !empty($post['plus'])?$post['plus']:'fas fa-plus',
		'save'=> !empty($post['save'])?$post['save']:'fas fa-save',
		'infobox'=>!empty($post['infobox'])?$post['infobox']:'fa fa-info-circle',
		'warning'=> !empty($post['warning'])?$post['warning']:'fal fa-exclamation-triangle',
		'user_management'=> !empty($post['user_management'])?$post['user_management']:'fas fa-user-cog',
		'learning_data'=> !empty($post['learning_data'])?$post['learning_data']:'fas fa-user-chart',
		'support'=> !empty($post['support'])?$post['support']:'fal fa-question-square',
		'reset'=>!empty($post['reset'])?$post['reset']:'fal fa-undo',
		'certificate_icon'=>!empty($post['certificate_icon'])?$post['certificate_icon']:'fas fa-file-certificate',
		'close_icon'=>!empty($post['close_icon'])?$post['close_icon']:'fas fa-xmark',
		'download_icon'=>!empty($post['download_icon'])?$post['download_icon']:'fal fa-downlaod',
		'setting_icon'=>!empty($post['setting_icon'])?$post['setting_icon']:'fal fa-gear',
		'toggle_on'=>!empty($post['toggle_on'])?$post['toggle_on']:'fal fa-toggle-on',
		'toggle_off'=>!empty($post['toggle_off'])?$post['toggle_off']:'fal fa-toggle-off'
	);
	$front_page = array(
		'articulate_popups'=> !empty($post['articulate_popups'])?$post['articulate_popups']:'fad fa-photo-video',
		'articulate_popups_link'=> !empty($post['articulate_popups_link'])?$post['articulate_popups_link']:'fad fa-link'
	);
	update_option('fa_kit_code',$post['kit_code']);
	update_option( 'user_interface_front_page', $front_page );
	update_option( 'user_interface_items_with_square_button_background', $items_with_square_button_background );
	return;
}

/**** for save buttons styling settings ****/
function save_buttons_styling($post){
	$button_styling = array(
		'normal_state'=> $post['normal_state'],
		'hover_state'=> $post['hover_state'],
		'selected_state'=> $post['selected_state'],
		'disabled_state'=> $post['disabled_state'],
		'dark_state'=> $post['dark_state'],
		'danger_state'=> $post['danger_state'],
		'danger_hover_state'=> $post['danger_hover_state'],
		'dark_hover_state'=> $post['dark_hover_state'],
		'inverse_danger_state'=>$post['inverse_danger_state'],
		'inverse_danger_hover_state'=>$post['inverse_danger_hover_state']
	);
	update_option( 'user_interface_button_styling', $button_styling );
	return;
}

/**** for save color settings ****/
function save_color_settings($post){
	$color_palette = array(
		'hyperlinks'=> !empty($post['hyperlinks'])?$post['hyperlinks']:'blue',
		'heading_text'=> !empty($post['heading_text'])?$post['heading_text']:'charcoal',
		'body_text'=> !empty($post['body_text'])?$post['body_text']:'charcoal',
		'border'=> !empty($post['border_text'])?$post['border_text']:'light_grey',
		'infobox_border'=>!empty($post['infobox_border'])?$post['infobox_border']:'purple',
		'infobox_icon'=>!empty($post['infobox_icon'])?$post['infobox_icon']:'purple',
		'course_completed'=> !empty($post['c_completed'])?$post['c_completed']:'green',
		'course_partially_completed'=> !empty($post['c_partially_completed'])?$post['c_partially_completed']:'orange',
		'course_not_started'=> !empty($post['c_not_started'])?$post['c_not_started']:'grey',
		'blue'=> !empty($post['blue'])?$post['blue']:'#03A9F4',
		'green'=> !empty($post['green'])?$post['green']:'#8BC34A',
		'orange'=> !empty($post['orange'])?$post['orange']:'#FF9800',
		'red'=> !empty($post['red'])?$post['red']:'#F44336',
		'purple'=> !empty($post['purple'])?$post['purple']:'#9C27B0',
		'black'=> !empty($post['black'])?$post['black']:'#000000',
		'charcoal'=> !empty($post['charcoal'])?$post['charcoal']:'#333333',
		'white'=> !empty($post['white'])?$post['white']:'#FFFFFF',
		'grey'=> !empty($post['grey'])?$post['grey']:'#808080',
		'light_grey'=> !empty($post['light_grey'])?$post['light_grey']:'#EFEFEF',
		'mid_grey'=> !empty($post['mid_grey'])?$post['mid_grey']:'#CCCCCC',
		'custom1'=> !empty($post['custom1'])?$post['custom1']:'#e32490',
		'custom2'=> !empty($post['custom2'])?$post['custom2']:'#f08fba',
		'custom3'=> !empty($post['custom3'])?$post['custom3']:'#f6f6f6',
		'custom4'=> !empty($post['custom4'])?$post['custom4']:'#03a9f4a6'
	);
	update_option( 'user_interface_color_palette', $color_palette );
	return;
}

/**** for save menu settings ****/
function save_menu_settings($post){
	if(isset($post['icon_visibility'])) {
		$visibility = 'ON';
	}else{
		$visibility = 'OFF';
	}
	$menu_interface = array(
		'logged_in_menu_layout'=> $post['logged_in_layout'],
		'logged_out_menu_layout'=> $post['logged_out_layout'],
		'menu_case'=> $post['menu_case'],
		'background_color'=> $post['background_color'],
		'text_color'=> $post['text_color'],
		'text_size'=> $post['text_size'],
		'menu_font_weight'=> $post['menu_font_weight'],
		'menu_font_spacing'=> $post['menu_font_spacing'],
		'icon_visibility'=> $visibility,
		'icon_size'=> $post['icon_size'],
		'icon_color'=> $post['icon_color'],
		'menu_hover_text_color'=> $post['menu_hover_text_color'],
		'menu_hover_bg_color'=> $post['menu_hover_bg_color'],
		'submenu_text_color'=> $post['submenu_text_color'],
		'submenu_bg_color'=> $post['submenu_bg_color'],
		'sub_menu_hover_text_color'=> $post['sub_menu_hover_text_color'],
		'sub_menu_hover_bg_color'=> $post['sub_menu_hover_bg_color'],
		'logged_in_logo_height'=> $post['logged_in_logo_height'],
		'logged_out_logo_height'=> $post['logged_out_logo_height'],
		'logged_in_menu_bg_color'=> $post['logged_in_menu_bg_color'],
		'logged_out_menu_bg_color'=> $post['logged_out_menu_bg_color'],
	);
	update_option( 'user_interface_menu_settings', $menu_interface );
	return;
}

/**** for save page settings ****/
function save_page_settings($post){
	$breakpoint=array(
		'class'=>$post['breakpoint_class'],
		'xs' => $post['breakpoint_xs'],
		'sm' => $post['breakpoint_sm'],
		'md' => $post['breakpoint_md'],
		'lg' => $post['breakpoint_lg'],
		'xl' => $post['breakpoint_xl'],
		'xxl' => $post['breakpoint_xxl'],
		'xxxl' => $post['breakpoint_xxxl']
	);
	update_option('lx_lms_breakpoint_setting',$breakpoint);
	
	$page_devider=array(
		'style' => $post['devider_style'],
		'color' => $post['devider_color']
	);
	update_option('lx_lms_page_devider_setting',$page_devider);
	return;
}

/**** for save tiles settings ****/
function save_tiles_settings($post){
	$style_2_tiles_interface = array(
		'completion_bg_color' => $post['completion_bg_color'],
		'completion_status_color' => $post['completion_status_color']
	);
	update_option( 'user_interface_style_2_tiles_settings', $style_2_tiles_interface );
	
	$tiles_style = array(
		'course_tile'=> stripslashes($post['course_tile']),
		'blog_tile'=> stripslashes($post['blog_tile']),
		'course_content_tile'=> stripslashes($post['course_content_tile']),
		'fl1p_forum_tile'=> stripslashes($post['fl1p_forum_tile']),
		'fl1p_topic_tile'=> stripslashes($post['fl1p_topic_tile']),
		'articulate_tile'=> stripslashes($post['articulate_tile'])
	);
	update_option( 'user_interface_tile_style', $tiles_style );
	return;
}

/**** for save iframe settings ****/
function save_iframe_content_settings($post){
	if (isset($post['favicon_visibility'])) {
		$favicon_visibility = 'ON';
	}else{
		$favicon_visibility = 'OFF';
	}
	$lightbox_settings=array(
		'bg_overlay_color'=>$post['bg_overlay_color'],
		'bg_overlay_opacity'=>$post['bg_overlay_opacity'],
		'modal_header_color'=>$post['modal_header_color'],
		'modal_header_icon_color'=>$post['modal_header_icon_color'],
		'modal_body_color'=>$post['modal_body_color'],
		'modal_border_color'=> $post['modal_border_color'],
		'favicon_visibility'=> $favicon_visibility,
		'modal_top_bar_title_alignment'=> $post['modal_top_bar_title_alignment'],
		'modal_title_color'=> $post['modal_title_color'],
		'modal_title_size'=> $post['modal_title_size'],
		'lb_closetext'=> $post['lb_closetext'],
		'lb_closebutton'=> $post['lb_closebutton']
	);
	update_option('lightbox_settings',$lightbox_settings);
	return;
}

/**** for save lexicon settings ****/
function save_lexicon_settings($post){
	$lexicon = array(
		'lexicon_our_courses'=> $post['our_courses'],
		'lexicon_flip_forum'=> $post['flip_forum'],
		'lexicon_blog_articles'=> $post['blog_articles'],
		'lexicon_additional_resources'=> $post['additional_resources']
	);
	update_option( 'user_interface_lexicon', $lexicon );
	return;
}

/**** for save learning locker settings ****/
function save_learning_locker_settings($post){
	$lerning_locker_setting=array(
		'end_point' => $post['end_point'],
		'auth_key' => $post['auth_key'],
		'auth_secret' => $post['auth_secret'],
		'basic_auth' =>  $post['basic_auth']
	);
	update_option('lx_lms_learning_locker_setting',$lerning_locker_setting);
	return;
}


/**** for demo design for tile style one ****/
function lx_lite_tile_style_1(){ 
global $lx_plugin_urls;
?>
	<label style="font-weight: 700;">Style 1</label>
	<div class="card style_1_card">
		<div class="card-image">
			<img class="card-img-top" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'/assets/img/sample_broken_img.jpg';?>" alt="Card image cap">
		</div>
		<div class="card-body" style="padding: 0.5rem; margin-bottom: 10px;margin-top: 5px;">
			<h5 class="head_h5">Title</h5>
			<p>Description</p>						
			<hr class="course_info_hr">						
			<span style="display: flex;margin: auto;">							<div class="content_status" style="background: #CCCCCC;"></div>			<span class="course_status">Not yet started</span>	
			</span>						
			<hr class="course_info_hr">
			<button type="button" class="btn btn_normal_state btn-view" style="margin-left: 0px !important;">View</button>
		</div>
	</div>
<?php
return;	
}

/**** for demo design for tile style two ****/
function lx_lite_tile_style_2(){ 
global $lx_plugin_urls,$color_palette;
?>
	<label style="font-weight:700;">Style 2(default for courses)</label>
	<div class="card style_2_card">
		<div class="card-image">
			<img class="card-img-top" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'/assets/img/sample_broken_img.jpg';?>" alt="Card image cap">
			<div class="div_bottom" style="background: <?php echo $color_palette['black'];?>;opacity: 80%;height: 45px;display: flex;align-items: center;">
				<span class="favicon <?php if($info == "course_info"){ echo "favicon_course"; } ?>" style='display: contents;'></span>
					<div class="content_status" style="background: #CCCCCC;height: 20px;"></div>
					<span class="course_status" style="width: 50%;color:#FFFFFF;">Completed</span>
				</span>
				<div style="width:50%;">
					<button type="button" class="btn btn_normal_state btn-view" style="padding: 2px 15px;float:right;float:right;margin-right: 5px;">View</button>
				</div>
			</div>
		</div>
		<div class="card-body" style="padding: 0.5rem; margin-bottom: 10px;">
			<h5 class="head_h5">Title</h5>
			<p>Description</p>
		</div>
	</div>
<?php
return;
}

/**** for demo design for tile style three ****/
function lx_lite_tile_style_3(){ 
global $lx_plugin_urls;
?>
	<label style="font-weight: 700;" class="pt-5">Style 3</label>
	<div class="card style_5_card" style="border: 2px solid rgba(0,0,0,.125);">
		<div class="card-image">						
			<img class="card-img-top" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'/assets/img/sample_broken_img.jpg';?>" alt="Card image cap">
		</div>
		<div class="card-body" style="padding: 0.5rem; margin-bottom: 10px;margin-top: 5px;">
		  <h5 class="head_h5">Title</h5>
		  <p>Description</p>
		  <div style="display:flex;">
				<button type="button" class="btn btn_normal_state btn-view" style="margin-left:0px">View</button>							
				<span style="display: flex;margin: auto;position: relative;left: 9%;">
					<div class="content_status" style="background: #CCCCCC;"></div>
					<span class="course_status">Not yet started</span>	
				</span>
			</div>
		</div>
	</div>
<?php
return;
}

/**** for demo design for tile style four ****/
function lx_lite_tile_style_4(){ 
global $color_palette;
?>
	<script src="https://kit.fontawesome.com/e2254dd01f.js" crossorigin="anonymous"></script>
	<label class="pt-5" style="font-weight: 700;">Style 4(Tile for articulate content)</label>
	<div class="card content_card content_list_href articulate_content_card" style="margin: auto;padding: 10px 10px;" data-type="lx_articulate">
		<div class="alt_icon_main_div" style="display: flex;align-items: center;">
			<div class="card-image articulate_activity" style="color: <?php echo $color_palette['hyperlinks'];?>;">
				<i class="fad fa-photo-video" style="font-size: 8em;"></i>
			</div>
			<div class="card-body">
				<h3 class="card-title articulate_title mb-0 head_h3" style="position: relative;top: 25%;left: 0%;">Title</h3>
			</div>
		</div>
	</div>
	<?php
	return;
}

/* for course purchasing ui backend */
function course_purchasing_ui(){ 
	global $lx_lms_settings,$square_icon;
	$currency_info = array (
		array("USD","$","US Dollars (USD)"),
		array("EUR","€","Euros (EUR)"),
		array("AUD","$","Australian Dollars (AUD)"),
		array("INR","₹","Indian Rupee (INR)")
	);
	
	if(is_plugin_inactive(VWPLUGIN_STRIPE)){
		$path = "javascript:void(0)";
		$stripe_error = '<span style="color:red;">Please activate/install "<b>Accept Stripe Payments</b>" plugin</span>';
		$isstripeactive = 0;
	}else{
		$path = admin_url('admin.php?page=stripe-payments-settings#general');
		$stripe_error = '';
		$isstripeactive = 1;
	}
	?>
	<div class="row pt-5">
		<div class="col-md-12 admin_section_title">
			<h4 class="head_h4">COURSES</h4>
		</div>
	</div>
	<div class="row form-group ai_center">
		<div class="col-md-3">
			<label for="course_purchasing_settings" class="col-form-label">Turn on Course purchasing</label>
		</div>
		<div class="col-md-3">
			<label class="lx_toggle">
				<input type="checkbox" class="course_purchasing_settings" id="course_purchasing_settings" name="ad_setting[course_purchasing_settings]" <?php if($lx_lms_settings['course_purchasing_settings'] == 'on'){ echo 'checked'; } ?>>
				<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
				<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
			</label>
		</div>
		<div class="col-md-6">
			<div class="txt_course_purchase" style="border: 2px solid lightgray;padding:10px; width: fit-content;">
				<span class="col-form-label">Course purchase settings</span><br>
				
				<a href="<?php echo $path; ?>">Please go to the Stripe plugin to adjust Currency etc.</a></br>
				<?php echo $stripe_error; ?>
			</div>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="currency_settings" class="col-form-label">Currency</label>
		</div>
		<?php 
		$stripecurr = 'Please activate stripe plugin';
		$stripesymbol = 'Please activate stripe plugin';
		if( $isstripeactive == 1 ){
			$stripeoptions = get_option('AcceptStripePayments-settings',true);
			$stripecurr = AcceptStripePayments::get_currencies()[$stripeoptions['currency_code']][0];
			$stripesymbol = AcceptStripePayments::get_currencies()[$stripeoptions['currency_code']][1];
		}
		?>
		<div class="col-md-3">
			<?php echo $stripecurr; ?>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<div class="display_currency_data">
		<div class="row form-group" style="align-items: end;">
			<div class="col-md-3">
				<label for="display_currency_info" class="col-form-label">How it will display</label>
			</div>
			<div class="col-md-3">
				<label class="display_currency_info"><?php echo $stripesymbol . '101'; ?></label>	
			</div>
			<div class="col-md-6">
			</div>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="receipt_prefix" class="col-form-label">Receipt Prefix</label>
		</div>
		<div class="col-md-3">
			<input name="ad_setting[receipt_prefix]" type="text" id="receipt_prefix" class="form-control" value="<?php echo $lx_lms_settings['receipt_prefix']; ?>">
		</div>
		<div class="col-md-6">
		</div>
	</div>
<?php
	return;
}

/**** for additinal settings ui ****/
function additinal_settings_ui(){ 
	global $lx_lms_settings;
?>
	<div class="row pt-5">
		<div class="col-md-12 admin_section_title">
			<h4 class="head_h4">AUTHORING</h4>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-3">
			<label for="chk_author_visibility" class="col-form-label">Author Name</label>
		</div>
		<div class="col-md-3">
			<label class="checkbox-inline pt-2">
				<input type="checkbox" class="chk_author_visibility" id="chk_author_visibility" name="ad_setting[author_visibility]" <?php if(isset($lx_lms_settings['author_visiblity'])){if($lx_lms_settings['author_visiblity']=="ON"){ echo 'checked'; } } ?>>Show
			</label>
		</div>
		<div class="col-md-6">
		</div>
	</div>
<?php	
}

/**** for certificate settings ui****/
function certificate_settings_ui(){ 
	global $lx_lms_settings,$site_wide_certificate;
?>
	<script src="https://kit.fontawesome.com/e2254dd01f.js" crossorigin="anonymous"></script>
	<div class="backend_alert_box" style="display: none;"></div>
	<?php 
		$certificate_template = get_option('lx_lms_certificate_setting');
		$length = strripos($certificate_template,'/');
		$file_name = substr($certificate_template,$length+1);
		if(isset($certificate_template) && !empty($certificate_template)){ ?>
			<style>
				.delete_certificate_template{
					z-index:99;
				}
			</style>
		<?php	
		} else{ ?>
			<style>
				.delete_certificate_template{
					z-index:0;
				}
			</style>
		<?php	
		}
		if($site_wide_certificate == 'ON'){
			$certificate_template = get_option('lx_lms_certificate_setting');
			if(!empty($certificate_template)){
				$certi=explode('.',basename($certificate_template));
				if(strpos(basename($certificate_template),'_lx_cert')){
					$file_name=substr($certi[0],0,-(strlen($certi[0])-strpos($certi[0], '_lx_cert'))).'.'.$certi[1];
				}else{
					$file_name=basename($certificate_template);
				}
				$download_certificate_template = $certificate_template;
				$download_class = 'btn_normal_state';
			} else{
				$file_name = 'None';
				$download_certificate_template = '';
				$download_class = 'btn_disabled_state';
			}
		}else{
			$file_name = 'None';
			$download_certificate_template = '';
			$download_class = 'btn_disabled_state';
		}
	?>
	<div class="row form-group">
		<div class="col-md-4">
			<label for="upload_certificates_template" class="col-form-label">Upload a Certificate template</label>
			<div class="upload-certificates-file-input">	
				<input type="file" name="upload_certificates_template" id="upload_certificates_template" accept="image/jpg,image/jpeg">
				<span class="button">Choose File</span>
				<span class="label lbl_selection_info" data-js-label=""><?php if(isset($certificate_template) && !empty($certificate_template)){ echo $file_name; } else{ echo "No file selected"; } ?></span>
			</div>
			<div class="upload_certificates_temp_prompt" style="color:red"></div>
			<label for="" class="col-form-label">Current Template:</label>
			<label class="current_template">
				<?php 
					if(isset($certificate_template) && !empty($certificate_template)){ 
						echo $file_name; 
					} else{ 
						echo "None"; 
					} 
				?>
			</label>
		</div>
		<div class="col-md-3" style="display: flex;flex-direction: column;">
			<label for="download_certificate_template" class="col-form-label">Download a Certificate template</label>
			<a class="btn_normal_state download_certificate_template" href="https://drive.google.com/file/d/1m4yvVah6yZjStroUIMLuD0tDbBL64Upz/view?usp=sharing" target="_blank" style="width:50%;"><i class="far fa-download" ></i>&nbsp;&nbsp;Download</a>
		</div>
		<div class="col-md-5- pt-2">
			<div class="create_certificate_note">
				<b>How to create a Certificate</b><br>
				1  Download the Certificate Template<br>
				2  Open it in PhotoShop<br>
				3  Add your image behind the placeholders<br>
				4  Adjust your image so the placeholders line up<br>
				&nbsp;&nbsp;&nbsp;&nbsp;(don't move the placeholders)<br>
				5  Hide the placeholders and save the image for uploading<br>
			</div>
		</div>
	</div>
<?php
	return;
}

function footerlmssetting_ui(){
	global $site_wide_certificate,$square_icon;
	?>
	<div class="row pt-5">
		<div class="col-md-12 admin_section_title">
			<h4 class="head_h4">Footer Setting</h4>
		</div>
	</div>
	<div class="row form-group ai_center">
		<div class="col-md-3">
			<label for="footertextlms_set" class="col-form-label">Footer Text</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="footertextlms_set w-100" id="footertextlms_set" name="ad_setting[footertextlms_set]" />
		</div>
		<div class="col-md-3">
		</div>
	</div>
	<?php
	return;
}

/**** for certificate settings top ui****/
function certificate_settings_top_ui(){ 
	global $site_wide_certificate,$square_icon;
?>
	<div class="row pt-5">
		<div class="col-md-12 admin_section_title">
			<h4 class="head_h4">SITE-WIDE CERTIFICATE</h4>
		</div>
	</div>
	<div class="row form-group ai_center">
		<div class="col-md-3">
			<label for="site_wide_certificates" class="col-form-label">Force Site-Level Certificate</label>
		</div>
		<div class="col-md-3">
			<?php 
			$onclick = '';
			if(!is_plugin_active(LX_LMS_PRO)){
				$onclick = 'onclick="return false;"';
			}
			if(isset($site_wide_certificate)){
				if($site_wide_certificate=="ON"){
					$checked="checked";
				}else{
					$checked="";
				}
			}
			?>
			<label class="lx_toggle">
				<input type="checkbox" <?php echo $onclick; ?> class="site_wide_certificates" id="site_wide_certificates" name="ad_setting[site_wide_certificates]" <?php echo $checked;?>>
				<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
				<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
			</label>
		</div>
		<div class="col-md-6">
		</div>
	</div>
<?php
return;
}

/**** for base64 settings ui ****/
function base64_settings_ui(){
	global $square_icon;
	$base64_encode_setting = get_option('base64_encode_setting');
	$args = array(
			   'public'   => true,
			   '_builtin' => false
			);
	  
	$output = 'names'; 
	$operator = 'and'; 
	  
	$custom_post_types = get_post_types( $args, $output, $operator );
	?>
	<?php /* <div class="row user_interface_setting_top pt-5">
		<div class="col-md-12 admin_section_title">
			<h4>Base64 Settings</h4>
		</div>
	</div> */ ?>
	<div class="row form-group admin_section_title mt-4 ai_center">
		<div class="col-md-3">
			<h4 for="txt_home form" class="col-form-label head_h4">BASE64 ENCODING</h4>
		</div>
		<div class="col-md-3">
			<?php 
				if(isset($base64_encode_setting['switch'])){
					if($base64_encode_setting['switch']=="ON"){
						$checked="checked";
					}else{
						$checked="";
					}
				}else{
					$checked="checked";
				}
			?>
			<label class="lx_toggle">
				<input type="checkbox" class="base64_encode_toggle" id="base64_encode_toggle" name="base64_encode[switch]" <?php echo $checked;?>>
				<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
				<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
			</label>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<?php if(isset($base64_encode_setting) && $checked=="checked"){  ?>
		 <style>
			.base64_encode_selection1{
				display:block !important;
			}
		</style>
	<?php } ?>

	<div class="base64_encode_selection base64_encode_selection1">
		<div class="row pt-4 pb-2">
			 <div class="col-md-2">
				<label class="checkbox-inline">
					<input type="checkbox" class="base64_encode_page" id="base64_encode_page" name="base64_encode[page]" <?php if($base64_encode_setting['page']=='ON'){ echo 'checked'; } ?>>Page
				</label>
			</div>
			<div class="col-md-2">
				<label class="checkbox-inline">
					<input type="checkbox" class="base64_encode_post" id="base64_encode_post" name="base64_encode[post]" <?php if($base64_encode_setting['post']=='ON'){ echo 'checked'; } ?>>Post
				</label>
			</div>
			<div class="col-md-2">
				<label class="checkbox-inline">
					<input type="checkbox" class="base64_encode_custom_post_info" id="base64_encode_custom_post_info" <?php if(isset($base64_encode_setting['custom_post_type'])){ echo 'checked'; } ?> >Custom Posts
				</label>
			</div>
			<div class="col-md-6">
			</div>
		</div>
	</div>
	<?php if(!isset($base64_encode_setting['custom_post_type'])){  ?>
		<style>
		.custom_post_selection1{
			display:none;
		}
		</style>
		<?php }else{ ?>
		<style>
		.custom_post_selection1{
			display:block;
		}
		</style>
		<?php } ?>
	<div class="custom_post_selection custom_post_selection1">
		<?php
		/* Columns must be a factor of 12 (1,2,3,4,6,12) */
		$numOfCols = 4;
		$rowCount = 0;
		$bootstrapColWidth = 12 / $numOfCols;
		?>
		<div class="row pt-3">
		<?php
		foreach ($custom_post_types as $value){
		?>  
				<div class="col-md-<?php echo $bootstrapColWidth; ?>">
					<label class="checkbox-inline"><input type="checkbox" class="base64_encode_custom_post" id="base64_encode_custom_post[]" name="base64_encode[custom_post][]" value="<?php echo $value; ?>" <?php if(!empty($base64_encode_setting['custom_post_type'])){if (($key = array_search($value, $base64_encode_setting['custom_post_type'])) !== false) {  echo 'checked'; }}?>><?php echo $value; ?></label>
				</div>
		<?php
			$rowCount++;
			if($rowCount % $numOfCols == 0) echo '</div><div class="row">';
		}
		?>
		</div>
	</div>
<?php
}

function flip_tiles_info(){
	global $lx_plugin_paths;
	$forum_tiles = array(
		'Style 3' => $lx_plugin_paths['lx_lms_lite'].'template/tiles/fliplist/style3_ui.php',
		'Style 5' => $lx_plugin_paths['lx_lms_lite'].'template/tiles/fliplist/style5_ui.php',
		/* 'Style x' => $lx_plugin_paths['lx_lms_lite'].'template/tiles/fliplist/stylex_ui.php' */
	); 
	$topic_tiles = array(
		'Style 1' => $lx_plugin_paths['lx_lms_lite'].'template/tiles/fliprecording/style_1_ui.php',
		'Style 2' => $lx_plugin_paths['lx_lms_lite'].'template/tiles/fliprecording/style_2_ui.php',
		'Style 3' => $lx_plugin_paths['lx_lms_lite'].'template/tiles/fliprecording/style_3_ui.php'
	); 
	$return=array('flip_forum'=>$forum_tiles,'flip_topic'=>$topic_tiles);
	return $return;
}