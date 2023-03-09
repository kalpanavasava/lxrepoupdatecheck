<?php 
/**** for store default frontend icon settings ****/
function store_default_frontend_icon_settings(){
	$all_defaults_array = 
	array(
		'connect' => 'fas fa-plug','learn'=>'fas fa-graduation-cap','grow'=>'fas fa-seedling','create'=>'fad fa-pencil-paintbrush','articulate_popups'=>'fad fa-photo-video','articulate_popups_link'=>'fad fa-link',
	);
	
	$getfronticon = get_option('user_interface_front_page',true);
	
	$iconarr['connect'] = isset($getfronticon['connect']) ? $getfronticon['connect'] : $all_defaults_array['connect'];
	$iconarr['learn'] = isset($getfronticon['learn']) ? $getfronticon['learn'] : $all_defaults_array['learn'];
	$iconarr['grow'] = isset($getfronticon['grow']) ? $getfronticon['grow'] : $all_defaults_array['grow'];
	$iconarr['create'] = isset($getfronticon['create']) ? $getfronticon['create'] : $all_defaults_array['create'];
	$iconarr['articulate_popups'] = isset($getfronticon['articulate_popups']) ? $getfronticon['articulate_popups'] : $all_defaults_array['articulate_popups'];
	$iconarr['articulate_popups_link'] = isset($getfronticon['articulate_popups_link']) ? $getfronticon['articulate_popups_link'] : $all_defaults_array['articulate_popups_link'];
	
	/* $front_page = array(
		'connect'=> 'fas fa-plug',
		'learn'=> 'fas fa-graduation-cap',
		'grow'=> 'fas fa-seedling',
		'create'=> 'fas fa-pencil-paintbrush',
		'articulate_popups'=> 'fad fa-photo-video',
		'articulate_popups_link'=> 'fad fa-link'
	); */
	update_option( 'user_interface_front_page', $iconarr );
	return;
}

/**** for store default square icon settings ****/
function store_default_square_icon_settings(){
	$all_defaults_array = 
	array(
		'edit' => 'fas fa-pen','trash'=>'fas fa-trash','plus'=>'fas fa-plus','save'=>'fas fa-save','toggle_on'=>'fal fa-toggle-on','toggle_off'=>'fal fa-toggle-off','certificate_icon'=>'fas fa-file-certificate','close_icon'=>'fas fa-xmark','download_icon'=>'fal fa-downlaod','setting_icon'=>'fal fa-gear','infobox'=>'fa fa-info-circle','warning'=>'fal fa-exclamation-triangle','user_management'=>'fas fa-user-cog','learning_data'=>'fas fa-user-chart','support'=>'fal fa-question-square','reset'=>'fal fa-undo','audio_recording'=>'fas fa-microphone-lines','text'=>'fas fa-font-case','images'=>'fas fa-images','360_image'=>'fas fa-360-degrees','video'=>'fas fa-video','attachment'=>'fas fa-paperclip','play'=>'far fa-circle-play','pause'=>'far fa-circle-pause','uploadtocloud'=>'fas fa-cloud-arrow-up','fullsceenon'=>'far fa-up-right-and-down-left-from-center','fullsceenoff'=>'far fa-down-left-and-up-right-to-center','reply'=>'far fa-comment-plus','navigation_left'=>'far fa-chevron-left','navigation_right'=>'far fa-chevron-right'
	);
	
	$getsquareicon = get_option('user_interface_items_with_square_button_background',true);
	$flipicons = get_option('flipicons',true);
	
	$ficonarr['audio_recording'] = isset($flipicons['audio_recording']) ? $flipicons['audio_recording'] : $all_defaults_array['audio_recording'];
	$ficonarr['text'] = isset($flipicons['text']) ? $flipicons['text'] : $all_defaults_array['text'];
	$ficonarr['images'] = isset($flipicons['images']) ? $flipicons['images'] : $all_defaults_array['images'];
	$ficonarr['360_image'] = isset($flipicons['360_image']) ? $flipicons['360_image'] : $all_defaults_array['360_image'];
	$ficonarr['video'] = isset($flipicons['video']) ? $flipicons['video'] : $all_defaults_array['video'];
	$ficonarr['attachment'] = isset($flipicons['attachment']) ? $flipicons['attachment'] : $all_defaults_array['attachment'];
	$ficonarr['play'] = isset($flipicons['play']) ? $flipicons['play'] : $all_defaults_array['play'];
	$ficonarr['pause'] = isset($flipicons['pause']) ? $flipicons['pause'] : $all_defaults_array['pause'];
	$ficonarr['uploadtocloud'] = isset($flipicons['uploadtocloud']) ? $flipicons['uploadtocloud'] : $all_defaults_array['uploadtocloud'];
	$ficonarr['fullsceenon'] = isset($flipicons['fullsceenon']) ? $flipicons['fullsceenon'] : $all_defaults_array['fullsceenon'];
	$ficonarr['fullsceenoff'] = isset($flipicons['fullsceenoff']) ? $flipicons['fullsceenoff'] : $all_defaults_array['fullsceenoff'];
	$ficonarr['reply'] = isset($flipicons['reply']) ? $flipicons['reply'] : $all_defaults_array['reply'];
	$ficonarr['responses'] = isset($flipicons['responses']) ? $flipicons['responses'] : $all_defaults_array['responses'];
	$ficonarr['navigation_left'] = isset($flipicons['navigation_left']) ? $flipicons['navigation_left'] : $all_defaults_array['navigation_left'];
	$ficonarr['navigation_right'] = isset($flipicons['navigation_right']) ? $flipicons['navigation_right'] : $all_defaults_array['navigation_right'];
	
	update_option( 'flipicons',$ficonarr );
	
	$iconarr['edit'] = isset($getsquareicon['edit']) ? $getsquareicon['edit'] : $all_defaults_array['edit'];
	$iconarr['trash'] = isset($getsquareicon['trash']) ? $getsquareicon['trash'] : $all_defaults_array['trash'];
	$iconarr['plus'] = isset($getsquareicon['plus']) ? $getsquareicon['plus'] : $all_defaults_array['plus'];
	$iconarr['save'] = isset($getsquareicon['save']) ? $getsquareicon['save'] : $all_defaults_array['save'];
	$iconarr['toggle_on'] = isset($getsquareicon['toggle_on']) ? $getsquareicon['toggle_on'] : $all_defaults_array['toggle_on'];
	$iconarr['toggle_off'] = isset($getsquareicon['toggle_off']) ? $getsquareicon['toggle_off'] : $all_defaults_array['toggle_off'];
	$iconarr['certificate_icon'] = isset($getsquareicon['certificate_icon']) ? $getsquareicon['certificate_icon'] : $all_defaults_array['certificate_icon'];
	$iconarr['close_icon'] = isset($getsquareicon['close_icon']) ? $getsquareicon['close_icon'] : $all_defaults_array['close_icon'];
	$iconarr['warning'] = isset($getsquareicon['warning']) ? $getsquareicon['warning'] : $all_defaults_array['warning'];
	$iconarr['user_management'] = isset($getsquareicon['user_management']) ? $getsquareicon['user_management'] : $all_defaults_array['user_management'];
	$iconarr['support'] = isset($getsquareicon['support']) ? $getsquareicon['support'] : $all_defaults_array['support'];
	$iconarr['reset'] = isset($getsquareicon['reset']) ? $getsquareicon['reset'] : $all_defaults_array['reset'];
	$iconarr['infobox'] = isset($getsquareicon['infobox']) ? $getsquareicon['infobox'] : $all_defaults_array['infobox'];
	$iconarr['learning_data'] = isset($getsquareicon['learning_data']) ? $getsquareicon['learning_data'] : $all_defaults_array['learning_data'];
	
	update_option( 'user_interface_items_with_square_button_background', $iconarr );
	return;
}

/**** for store default button styling settings ****/
function store_default_button_styling_settings(){
	$button_styling = array(
'normal_state'=>'background:#03A9F4;
color:#FFFFFF;
border:1px solid #03A9F4;
border-radius:5px;
height:35px;
padding: 5px 10px;',
'hover_state'=> 'background:#FFFFFF;
color:#03A9F4;
border:1px solid #03A9F4;
border-radius:5px;
height:35px;
padding: 5px 10px;',
'selected_state'=> 'background:#03A9F4;
color:#FFFFFF;
border:1px solid #03A9F4;
border-radius:5px;
padding: 5px 10px;',
'disabled_state'=> 'background:#9d9d9c;
color:#FFFFFF;
border:1px solid #9d9d9c;
border-radius:5px;
height:35px;
padding: 5px 10px;
pointer-events:none;',
'dark_state'=> 'background:#333333;
color:#FFFFFF;
border:1px solid #333333;
border-radius:5px;
height:35px;
padding: 5px 10px;',
'danger_state'=> 'background:#F44336;
color:#FFFFFF;
border:1px solid #F44336;
border-radius:5px;
height:35px;
padding: 5px 10px;',
'danger_hover_state'=> 'background: #EFEFEF;
color:#F44336;
border:1px solid #EFEFEF;
border-radius:5px;
height:35px;
padding: 5px 10px;',
'dark_hover_state'=> 'background:#FFFFFF;
color:#333333;
border:1px solid #333333;
border-radius:5px;
height:35px;
padding: 5px 10px;'
);
	update_option( 'user_interface_button_styling', $button_styling );
	return;
}

/**** for store default font settings ****/
function store_default_font_settings(){
	
	$all_defaults_array = 
	array(
		'heading_font' => 'Nunito Sans',
		'body_font'=>'Nunito Sans','body_font_size'=>'14',
		'h1_font'=>'font-size: 1.8em;
					font-weight: 700;
					text-transform: none;
					margin-bottom:0px;
					line-height:3em;',
		'h2_font'=> 'font-size: 1.6em;
					font-weight: 600;
					text-transform: none;
					margin-bottom:0px;',
		'h3_font'=> 'font-size: 1.4em;
					font-weight: 400;
					text-transform: none;
					margin-bottom:0px;',
		'h4_font'=> 'margin-bottom:0px;
					font-size: 1.2em;
					text-transform: capitalize;
					text-align:left;
					color:#575756;',
		'h5_font'=> 'margin-top:1.2em;
					color: black;',
		'body_font_info'=> 'font-size: 1em;
							line-height:1.2em;
							padding-top:0px!important;
							margin-top:0px!important;
							margin-bottom:4px!important;
							weight: 400;',
		'body_bold_font'=>	'font-size: 1em;
							line-height:1.2em;
							padding-top:0px!important;
							margin-top:0px!important;
							margin-bottom:4px!important;
							weight: 600;',
		'sub_text_font'=> 	'font-size: 0.8em;
							line-height:1.2em;
							padding-top:0px!important;
							margin-top:4px;
							margin-bottom:4px;
							weight: 400;',
	);
	
	$getfontset = get_option('user_interface_font_settings',true);
	
	$font_settings['heading_font'] = isset($getfontset['heading_font']) ? $getfontset['heading_font'] : $all_defaults_array['heading_font'];
	$font_settings['body_font'] = isset($getfontset['body_font']) ? $getfontset['body_font'] : $all_defaults_array['body_font'];
	$font_settings['h1_font'] = isset($getfontset['h1_font']) ? $getfontset['h1_font'] : $all_defaults_array['h1_font'];
	$font_settings['h2_font'] = isset($getfontset['h2_font']) ? $getfontset['h2_font'] : $all_defaults_array['h2_font'];
	$font_settings['h3_font'] = isset($getfontset['h3_font']) ? $getfontset['h3_font'] : $all_defaults_array['h3_font'];
	$font_settings['h4_font'] = isset($getfontset['h4_font']) ? $getfontset['h4_font'] : $all_defaults_array['h4_font'];
	$font_settings['h5_font'] = isset($getfontset['h5_font']) ? $getfontset['h5_font'] : $all_defaults_array['h5_font'];
	$font_settings['body_font_info'] = isset($getfontset['body_font_info']) ? $getfontset['body_font_info'] : $all_defaults_array['body_font_info'];
	$font_settings['body_bold_font'] = isset($getfontset['body_bold_font']) ? $getfontset['body_bold_font'] : $all_defaults_array['body_bold_font'];
	$font_settings['sub_text_font'] = isset($getfontset['sub_text_font']) ? $getfontset['sub_text_font'] : $all_defaults_array['sub_text_font'];

	update_option( 'user_interface_font_settings', $font_settings );
	return;
}

/**** for store default color palette settings ****/
function store_default_color_palette_settings(){
	$all_defaults_array = 
	array(
		'hyperlinks' => 'Blue','heading_text'=>'Charcoal','body_text'=>'Charcoal','border'=>'Light Grey','infobox_border'=>'Purple','infobox_icon'=>'Orange','course_completed'=>'Blue','course_partially_completed'=>'Orange','course_not_started'=>'Grey','blue'=>'#03A9F4','green'=>'#8BC34A','orange'=>'#FF9800','red'=>'#F44336','purple'=>'#9C27B0','black'=>'#9C27B0','charcoal'=>'#333333','white'=>'#FFFFFF','grey'=>'#808080','light_grey'=>'#EFEFEF','mid_grey'=>'#CCCCCC'
	);
	
	$colorcode = get_option( 'user_interface_color_palette' ,true );
	$colorcodearr['hyperlinks'] = isset($colorcode['hyperlinks']) ? $colorcode['hyperlinks'] : $all_defaults_array['hyperlinks'];
	$colorcodearr['heading_text'] = isset($colorcode['heading_text']) ? $colorcode['heading_text'] : $all_defaults_array['heading_text'];
	$colorcodearr['body_text'] = isset($colorcode['body_text']) ? $colorcode['body_text'] : $all_defaults_array['body_text'];
	$colorcodearr['border'] = isset($colorcode['border']) ? $colorcode['border'] : $all_defaults_array['border'];
	$colorcodearr['infobox_border'] = isset($colorcode['infobox_border']) ? $colorcode['infobox_border'] : $all_defaults_array['infobox_border'];
	$colorcodearr['infobox_icon'] = isset($colorcode['infobox_icon']) ? $colorcode['infobox_icon'] : $all_defaults_array['infobox_icon'];
	$colorcodearr['course_completed'] = isset($colorcode['course_completed']) ? $colorcode['course_completed'] : $all_defaults_array['course_completed'];
	$colorcodearr['course_partially_completed'] = isset($colorcode['course_partially_completed']) ? $colorcode['course_partially_completed'] : $all_defaults_array['course_partially_completed'];
	$colorcodearr['course_not_started'] = isset($colorcode['course_not_started']) ? $colorcode['course_not_started'] : $all_defaults_array['course_not_started'];
	$colorcodearr['blue'] = isset($colorcode['blue']) ? $colorcode['blue'] : $all_defaults_array['blue'];
	$colorcodearr['green'] = isset($colorcode['green']) ? $colorcode['green'] : $all_defaults_array['green'];
	$colorcodearr['orange'] = isset($colorcode['orange']) ? $colorcode['orange'] : $all_defaults_array['orange'];
	$colorcodearr['red'] = isset($colorcode['red']) ? $colorcode['red'] : $all_defaults_array['red'];
	$colorcodearr['purple'] = isset($colorcode['purple']) ? $colorcode['purple'] : $all_defaults_array['purple'];
	$colorcodearr['black'] = isset($colorcode['black']) ? $colorcode['black'] : $all_defaults_array['black'];
	$colorcodearr['charcoal'] = isset($colorcode['charcoal']) ? $colorcode['charcoal'] : $all_defaults_array['charcoal'];
	$colorcodearr['white'] = isset($colorcode['white']) ? $colorcode['white'] : $all_defaults_array['white'];
	$colorcodearr['grey'] = isset($colorcode['grey']) ? $colorcode['grey'] : $all_defaults_array['grey'];
	$colorcodearr['light_grey'] = isset($colorcode['light_grey']) ? $colorcode['light_grey'] : $all_defaults_array['light_grey'];
	$colorcodearr['mid_grey'] = isset($colorcode['mid_grey']) ? $colorcode['mid_grey'] : $all_defaults_array['mid_grey'];
	
	update_option( 'user_interface_color_palette', $colorcodearr );
	return;
}

/**** for store default menu settings ****/
function store_default_menu_settings(){
	$menu_interface = array(
		'logged_in_menu_layout'=> 'minimulist',
		'logged_out_menu_layout'=> 'centered',
		'menu_case'=> 'uppercase',
		'background_color'=> 'charcoal',
		'text_color'=> 'white',
		'text_size'=> '1em',
		'menu_font_weight'=> '500',
		'menu_font_spacing'=> '0px',
		'icon_visibility'=> '',
		'icon_size'=> ' 1.2em',
		'icon_color'=> 'white',
		'menu_hover_text_color'=> 'white',
		'menu_hover_bg_color'=> 'blue',
		'sub_menu_hover_text_color'=> 'white',
		'sub_menu_hover_bg_color'=> 'blue',
		'logged_in_width'=> '18',
		'logged_out_width'=> '35',
		'logged_in_menu_bg_color'=> 'charcoal',
		'logged_out_menu_bg_color'=> 'charcoal',
	);
	update_option( 'user_interface_menu_settings', $menu_interface );
	return;
}

/**** for store default breakpoint settings ****/
function store_default_breakpoint_settings(){
	$all_defaults_array = 
	array(
		'class' => 'col-md-3 mt-3 col-xxl-3 col-lg-3 col-md-4 col-sm-6','xs'=>'100','sm'=>'100','md'=>'100','lg'=>'90','xl'=>'80','xxl'=>'80','xxxl'=>'80'
	);
	
	$breakpoint = get_option( 'lx_lms_breakpoint_setting' ,true );
	
	$break_point['class'] = isset($breakpoint['class']) ? $breakpoint['class'] : $all_defaults_array['class'];
	$break_point['xs'] = isset($breakpoint['xs']) ? $breakpoint['xs'] : $all_defaults_array['xs'];
	$break_point['sm'] = isset($breakpoint['sm']) ? $breakpoint['sm'] : $all_defaults_array['sm'];
	$break_point['md'] = isset($breakpoint['md']) ? $breakpoint['md'] : $all_defaults_array['md'];
	$break_point['lg'] = isset($breakpoint['lg']) ? $breakpoint['lg'] : $all_defaults_array['lg'];
	$break_point['xl'] = isset($breakpoint['xl']) ? $breakpoint['xl'] : $all_defaults_array['xl'];
	$break_point['xxl'] = isset($breakpoint['xxl']) ? $breakpoint['xxl'] : $all_defaults_array['xxl'];
	$break_point['xxxl'] = isset($breakpoint['xxxl']) ? $breakpoint['xxxl'] : $all_defaults_array['xxxl'];
	
	update_option('lx_lms_breakpoint_setting',$break_point);
	return;
}

/**** for store default page devider settings ****/
function store_default_page_devider_settings(){
	
	$all_defaults_array = 
	array(
		'style' => 'h1','color'=>'#EFEFEF'
	);
	
	$pgdiv = get_option( 'lx_lms_page_devider_setting' ,true );
	$page_devider_info['class'] = isset($pgdiv['style']) ? $pgdiv['style'] : $all_defaults_array['style'];
	$page_devider_info['color'] = isset($pgdiv['color']) ? $pgdiv['color'] : $all_defaults_array['color'];
	
	update_option('lx_lms_page_devider_setting',$page_devider_info);
	return;
}

/**** for store default articulate lightbox popup settings ****/
function store_default_articulate_lightbox_popup_settings(){
	$lightbox_settings=array(
		'bg_overlay_color'=>'#333333',
		'bg_overlay_opacity'=>'',
		'modal_header_color'=>'#FFFFFF',
		'modal_header_icon_color'=>'#333333',
		'modal_body_color'=>'#FFFFFF',
		'modal_border_color'=>'#EFEFEF',
		'favicon_visibility'=>'',
		'modal_top_bar_title_alignment'=>'',
		'modal_title_color'=>'',
		'modal_title_size'=>'1.2em'
	);
	update_option('lightbox_settings',$lightbox_settings);
	return;
}

/**
 * @Create all Lite Category..
 */
function RequiredCategoryCreateLite(){
	
	/**
	 * @Content Category
	 */
	$content_category = term_exists('content-category');
	if( empty($content_category) ){
		$content_categoryar = array('cat_name' => 'Content Category', 'category_description' => 'Content Category', 'category_nicename' => 'content-category', 'category_parent' => '');
		$content_category = wp_insert_category($content_categoryar);
	}
	
	$content_category_arts = term_exists('arts');
	if(empty($content_category_arts)){
		$content_category_artsar = array( 'cat_name' => 'Arts', 'category_description' => 'Arts', 'category_nicename' => 'arts', 'category_parent' => $content_category );
		$content_category_arts = wp_insert_category($content_category_artsar);
	}
	
	$content_category_education = term_exists('education');
	if(empty($content_category_education)){
		$content_category_educationar = array( 'cat_name' => 'Education', 'category_description' => 'Education', 'category_nicename' => 'education', 'category_parent' => $content_category );
		$content_category_education = wp_insert_category($content_category_educationar);
	}
	
	$content_category_gi = term_exists('general-interest');
	if(empty($content_category_gi)){
		$content_category_giar = array( 'cat_name' => 'General Interest', 'category_description' => 'General Interest', 'category_nicename' => 'general-interest', 'category_parent' => $content_category );
		$content_category_gi = wp_insert_category($content_category_giar);
	}
	
	$content_category_test = term_exists('test');
	if(empty($content_category_test)){
		$content_category_testar = array( 'cat_name' => 'Test', 'category_description' => 'Test', 'category_nicename' => 'test', 'category_parent' => $content_category );
		$content_category_test = wp_insert_category($content_category_testar);
	}
	
	/**
	 * @Content Type Category
	 */
	 
	$contenttype_category = term_exists('content-type-category');
	if( empty($contenttype_category) ){
		$contenttype_categoryar = array('cat_name' => 'Content Type Category', 'category_description' => 'Content Type Category', 'category_nicename' => 'content-type-category', 'category_parent' => '');
		$contenttype_category = wp_insert_category($contenttype_categoryar);
	}
	
	$content_category_ar = term_exists('articulate-rise');
	if(empty($content_category_ar)){
		$content_category_arar = array( 'cat_name' => 'Articulate Rise', 'category_description' => 'Articulate Rise', 'category_nicename' => 'articulate-rise', 'category_parent' => $contenttype_category );
		$content_category_ar = wp_insert_category($content_category_arar);
	}
	
	$content_category_as = term_exists('articulate-storyline');
	if(empty($content_category_as)){
		$content_category_asar = array( 'cat_name' => 'Articulate Storyline', 'category_description' => 'Articulate Storyline', 'category_nicename' => 'articulate-storyline', 'category_parent' => $contenttype_category );
		$content_category_as = wp_insert_category($content_category_asar);
	}
	
	/**
	 * @Featured
	 */
	$feature_category = term_exists('featured');
	if( empty($feature_category) ){
		$contenttype_categoryar = array('cat_name' => 'Featured', 'category_description' => 'Featured', 'category_nicename' => 'featured', 'category_parent' => '');
		$feature_category = wp_insert_category($contenttype_categoryar);
	}
}
function RequiredEmailContentLite(){
	$email_content = get_option('lx_lms_login_setting',true)['email_body'];
	if(empty($email_content)){
		$email_array = array();
		$email_array['email_subject'] = '';
		$email_array['from_email'] = '';
		$email_array['email_body'] = '<p>Hi {username},</p><p>Thanks for signing up to {sitename}. Please <a href="{site_url}/email-verification/{queryparam}" data-wplink-url-error="true">verify your email by clicking this link.</a></p><p>Thanks,</p><p>{sitename} Admin Team</p>';
		$email_array['google_login'] = '';
		$email_array['site_key'] = '';
		$email_array['secret_key'] = '';
		
		update_option('lx_lms_login_setting',$email_array);
	}
}
?>