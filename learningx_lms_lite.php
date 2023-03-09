<?php
/*
Plugin Name: LearningX LMS Lite
Description: LearningX Admin Settings
Version: 3.03.07.2
Author: Voidek Webolutions
*/
 
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

function run_activate_plugin_lite( $plugin ) {
    $current = get_option( 'active_plugins' );
    $plugin = plugin_basename( trim( $plugin ) );

    if ( !in_array( $plugin, $current ) ) {
        $current[] = $plugin;
        sort( $current );
        do_action( 'activate_plugin', trim( $plugin ) );
        update_option( 'active_plugins', $current );
        do_action( 'activate_' . trim( $plugin ) );
        do_action( 'activated_plugin', trim( $plugin) );
    }

    return null;
}
global $wpdb;
global $lx_plugin_paths,$lx_plugin_urls;

define('LX_LMS_PRO','learningx_lms_pro/learningx_lms_pro.php');
$lx_plugin_paths=array(
    'lx_lms_lite'=>plugin_dir_path(__FILE__),
    'lx_lms_pro'=>dirname(plugin_dir_path(__FILE__)).'/learningx_lms_pro/'
);
$lx_plugin_urls=array(
    'lx_lms_lite'=>plugin_dir_url(__FILE__),
    'lx_lms_pro'=>dirname(plugin_dir_url(__FILE__)).'/learningx_lms_pro/'
);
if(is_plugin_active(LX_LMS_PRO)){
    define('lx_lms_plugin_path',$lx_plugin_paths['lx_lms_pro']);
    define('lx_lms_plugin_url',$lx_plugin_urls['lx_lms_pro']);
}else{ 

	define('lx_lms_plugin_path',$lx_plugin_paths['lx_lms_lite']);
    define('lx_lms_plugin_url',$lx_plugin_urls['lx_lms_lite']);
	update_option( 'lx_lms_site_wide_certificate_settings', 'ON' );
 } 

include_once( plugin_dir_path(__FILE__) . '/constant/constant.php' );
 
/*******Learningx LMS Required Resources*******/
require_once $lx_plugin_paths['lx_lms_lite'].'/classes/class_lx_lms.php';
$lx_lms = new Lx_lms(); 

require_once  $lx_plugin_paths['lx_lms_lite'].'classes/class_lx_lms_ajax.php';
$lx_lms_ajax = new lx_lms_ajax();

require_once $lx_plugin_paths['lx_lms_lite'].'/classes/class_include_addons.php';
$lx_addons=new include_addons();

require_once $lx_plugin_paths['lx_lms_lite'].'/functions/functions.php';
require_once $lx_plugin_paths['lx_lms_lite'].'/functions/general_fns.php';

require_once $lx_plugin_paths['lx_lms_lite'].'/functions/store_default_lms_settings.php';

require_once $lx_plugin_paths['lx_lms_lite'].'/shortcodes/shortcodes.php';

require_once $lx_plugin_paths['lx_lms_lite'].'/shortcodes/ajax.php';
require_once $lx_plugin_paths['lx_lms_lite'].'/api/index.php';

/**** global variables for store settings ****/
global $frontend_icon,$square_icon,$button_styling,$color_palette,$menu_settings,$community_tiles_interface,$menu_interface,$font_family,$tiles_style,$page_style,$style_2_tiles_interface,$s3_settings,$lexicon,$breakpoint,$page_devider,$login_settings,$lightbox_settings,$learning_locker_setting,$site_wide_certificate,$kit_code,$flipicons;
/**** get all stored lms settings ****/
$button_styling = get_option( 'user_interface_button_styling' );
$color_palette = get_option( 'user_interface_color_palette' );
$color_palette['hyperlinks'] =$color_palette[strtolower( str_replace(' ','_',$color_palette['hyperlinks']))];
$color_palette['heading_text'] = $color_palette[strtolower( str_replace(' ','_',$color_palette['heading_text']))];
$color_palette['body_text'] = $color_palette[strtolower( str_replace(' ','_',$color_palette['body_text']))];
$color_palette['border'] =$color_palette[strtolower( str_replace(' ','_',$color_palette['border']))];
$color_palette['infobox_border'] =$color_palette[strtolower( str_replace(' ','_',$color_palette['infobox_border']))];
$color_palette['infobox_icon'] =$color_palette[strtolower( str_replace(' ','_',$color_palette['infobox_icon']))];
$color_palette['course_completed'] =$color_palette[strtolower( str_replace(' ','_',$color_palette['course_completed']))];
$color_palette['course_partially_completed'] =$color_palette[strtolower( str_replace(' ','_',$color_palette['course_partially_completed']))];
$color_palette['course_not_started'] =$color_palette[strtolower( str_replace(' ','_',$color_palette['course_not_started']))];
$frontend_icon = get_option('user_interface_front_page');
$flipicons = get_option('flipicons');
$square_icon = get_option('user_interface_items_with_square_button_background');
$menu_settings = get_option('user_interface_menu_settings');
$menu_settings['background_color']=$color_palette[strtolower( str_replace(' ','_',$menu_settings['background_color']))];
$menu_settings['text_color']=$color_palette[strtolower( str_replace(' ','_',$menu_settings['text_color']))];
$menu_settings['menu_hover_text_color']=$color_palette[strtolower( str_replace(' ','_',$menu_settings['menu_hover_text_color']))];
$menu_settings['menu_hover_bg_color']=$color_palette[strtolower( str_replace(' ','_',$menu_settings['menu_hover_bg_color']))];
$menu_settings['submenu_text_color']=$color_palette[strtolower( str_replace(' ','_',$menu_settings['submenu_text_color']))];
$menu_settings['submenu_bg_color']=$color_palette[strtolower( str_replace(' ','_',$menu_settings['submenu_bg_color']))];
$menu_settings['sub_menu_hover_text_color']=$color_palette[strtolower( str_replace(' ','_',$menu_settings['sub_menu_hover_text_color']))];
$menu_settings['sub_menu_hover_bg_color']=$color_palette[strtolower( str_replace(' ','_',$menu_settings['sub_menu_hover_bg_color']))];
$menu_settings['logged_in_menu_bg_color']=$color_palette[strtolower( str_replace(' ','_',$menu_settings['logged_in_menu_bg_color']))];
$menu_settings['logged_out_menu_bg_color']=$color_palette[strtolower( str_replace(' ','_',$menu_settings['logged_out_menu_bg_color']))];
$menu_settings['icon_color']=$color_palette[strtolower( str_replace(' ','_',$menu_settings['icon_color']))];
$community_tiles_interface = get_option('user_interface_community_tiles_settings');
$tiles_style = get_option('user_interface_tile_style');
$style_2_tiles_interface = get_option('user_interface_style_2_tiles_settings');
$font_family = get_option('user_interface_font_settings');
$s3_settings = get_option('user_interface_s3_settings');
$page_style = get_option('user_interface_page_settings');
$lexicon = get_option('user_interface_lexicon');
$breakpoint=get_option('lx_lms_breakpoint_setting');
$page_devider=get_option('lx_lms_page_devider_setting');
$login_settings=get_option('lx_lms_login_setting');
$lightbox_settings=get_option('lightbox_settings');
$lightbox_settings['bg_overlay_color']=$color_palette[strtolower( str_replace(' ','_',$lightbox_settings['bg_overlay_color']))];
$lightbox_settings['modal_header_color']=$color_palette[strtolower( str_replace(' ','_',$lightbox_settings['modal_header_color']))];
$lightbox_settings['modal_header_icon_color']=$color_palette[strtolower( str_replace(' ','_',$lightbox_settings['modal_header_icon_color']))];
$lightbox_settings['modal_body_color']=$color_palette[strtolower( str_replace(' ','_',$lightbox_settings['modal_body_color']))];
$lightbox_settings['modal_border_color']=$color_palette[strtolower( str_replace(' ','_',$lightbox_settings['modal_border_color']))];
$lightbox_settings['modal_title_color']=$color_palette[strtolower( str_replace(' ','_',$lightbox_settings['modal_title_color']))];
$learning_locker_setting=get_option('lx_lms_learning_locker_setting');
$site_wide_certificate=get_option('lx_lms_site_wide_certificate_settings');
$kit_code=get_option('fa_kit_code');

/** set stripe global **/
function setstripesettings(){
	global $lx_lms_settings;
	$lx_lms_settings = get_option('lx_lms_settings');
	
	$stripeoptions['currency_code'] = $stripesymbol = '';
	if(is_plugin_active(VWPLUGIN_STRIPE)){
		$stripeoptions = get_option('AcceptStripePayments-settings',true);
		$stripesymbol = AcceptStripePayments::get_currencies()[$stripeoptions['currency_code']][1];
	}
	
	$lx_lms_settings['course_currency_setting'] = $stripeoptions['currency_code'];
	$lx_lms_settings['course_currency_symbol'] = $stripesymbol;
}
add_action('init','setstripesettings');

/**** add css ****/
if( !function_exists( 'dynamic_css' ) ) {
    function dynamic_css() {
         include  dirname(__FILE__) . '/assets/css/lms_user_interface_settings.php';
		 include  dirname(__FILE__) . '/assets/css/flip-view-css.php';
    }
    add_action( 'wp_head', 'dynamic_css' );
}

/**** for google login on off ****/
if($login_settings['google_login']=='on'){
	activate_auth0('auth0/WP_Auth0.php');
}else{
    if(is_plugin_active('auth0/WP_Auth0.php')){
	   deactivate_plugins('auth0/WP_Auth0.php');
    }
}

/**** for activate google login auth0 ****/
function activate_auth0( $plugin ) {
    $current = get_option( 'active_plugins' );
    $plugin = plugin_basename( trim( $plugin ) );
    if ( !in_array( $plugin, $current ) ) {
        $current[] = $plugin;
        sort( $current );
        do_action( 'activate_plugin', trim( $plugin ) );
        update_option( 'active_plugins', $current );
        do_action( 'activate_' . trim( $plugin ) );
        do_action( 'activated_plugin', trim( $plugin) );
    }
    return null;
}
add_action( 'wp_enqueue_scripts', 'fl1p_enqueue_viewscripts' );

/**** filter for display user status column ****/
add_filter( 'manage_users_columns', 'user_status_column' );
function user_status_column($column){
    $column['u_status']= __('Status');
    return $column;
}

/**** filter for manage user status column ****/
add_filter( 'manage_users_custom_column', 'display_user_status_field',10,3);
function display_user_status_field($val,$column_name,$user_id){
     switch ($column_name) {
        case 'u_status' :
            $status=get_user_meta($user_id,'user_status',true);
			if($status=='')
            {
                $status='Inactive';
            }
            $html="<span class='u_status_activation' data-uid=".$user_id.">".$status."</span>";
            return $html;
        default:
    }
    return $val;
}

/**** for user activation status ****/
function user_status_activation(){
    $user_id=$_POST['user_id'];
    $status=get_user_meta($user_id,'user_status',true);
    if($status=='Active'){
        update_user_meta($user_id,'user_status','Inactive');
        /* update_user_meta($user_id,'uwp_mod','email_unconfirmed'); */
    }
    else{
        update_user_meta($user_id,'user_status','Active');
		/* update_user_meta($user_id,'uwp_mod',''); */
    }
    echo "updated";
    die;
}
add_action('wp_ajax_user_status_activation','user_status_activation');
add_action('wp_ajax_nopriv_user_status_activation','user_status_activation');

/**** for enqueue fl1p css ****/
function fl1p_enqueue_viewscripts() {
    global $lx_plugin_urls,$lx_lms_course_url;
  wp_enqueue_style( 'bootstrap_css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css' ); 
  wp_enqueue_style( 'oswald_font_css',$lx_plugin_urls['lx_lms_lite'].'assets/fonts/oswald_font.css' );
  wp_enqueue_style( 'bootstrap_css1','https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'); 

  wp_enqueue_script( 'jquery_js', $lx_lms_course_url.'js/jquery.js', array( 'jquery' ) );
  wp_enqueue_script('jqueryui_js','https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js',array("jquery"));
  wp_enqueue_script( 'bootstrap_js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js' ,array("jquery"));
  wp_enqueue_script( 'common_js', $lx_plugin_urls['lx_lms_lite'].'assets/js/common.js' ,array("jquery"));
  wp_enqueue_script( 'proper_js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' ,array("jquery"));
  wp_enqueue_script( 'mx_bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' ,array("jquery"));
}

/**** for create lms pages ****/
function create_lms_pages(){
    $page=get_page_by_path('home');
    if(!$page){
        $home_page=array(
            'post_title'    => 'Home',
            'post_type'     => 'page',
            'post_status'   => 'publish'
        );
        $page_id=wp_insert_post($home_page);
        update_option('show_on_front','page');
        update_option('page_on_front',$page_id);
    }
    $page=get_page_by_path( 'create-courses' );
    if(!$page){
        $course_page=array(
            'post_title'    => 'Create Courses',
            'post_type'     => 'page',
            'post_content'  => '[save_courses]',
            'post_status'   => 'publish'
        );
        wp_insert_post($course_page);
    }

    $page=get_page_by_path( 'create-xapi-content' );
    if(!$page){
        $xapi_content=array(
            'post_title'    => 'Create xAPI Content',
            'post_type'     => 'page',
            'post_content'  => '[save_XAPI_content]',
            'post_status'   => 'publish'
        );
        wp_insert_post($xapi_content);
    }

    $page=get_page_by_path( 'create-articulate-content' );
    if(!$page){
        $articulate_content=array(
            'post_title'    => 'Create Articulate Content',
            'post_type'     => 'page',
            'post_content'  => '[articulate_canvas]',
            'post_status'   => 'publish'
        );
        wp_insert_post($articulate_content);
    }
    
    $page=get_page_by_path( 'my-content' );
    if(!$page){
        $my_content=array(
            'post_title'    => 'My Content',
            'post_type'     => 'page',
            'post_content'  => '[mycontent]',
            'post_status'   => 'publish'
        );
        wp_insert_post($my_content);
    }

    $page=get_page_by_path( 'join-next-step' );
    if(!$page){
        $join_next_step=array(
            'post_title'    => 'Join Next Step',
            'post_type'     => 'page',
            'post_content'  => '[vw_join_next_step]',
            'post_status'   => 'publish'
        );
        wp_insert_post($join_next_step);
    }
    
    $page=get_page_by_path( 'email-verification' );
    if(!$page){
        $email_verification=array(
            'post_title'    => 'Email Verification',
            'post_type'     => 'page',
            'post_content'  => '[vw_verification_step]',
            'post_status'   => 'publish'
        );
        wp_insert_post($email_verification);
    }
    $page=get_page_by_path('resend-verification-link');
    if(!$page){
        $resend_verification=array(
            'post_title'    => 'Resend Verification Link',
            'post_type'     => 'page',
            'post_content'  => '[vw_resend_verification_link]',
            'post_status'   => 'publish'
        );
        wp_insert_post($resend_verification);
    }
    $page=get_page_by_path('my-account');
    if(!$page){
        $my_account=array(
            'post_title'    => 'My Account',
            'post_type'     => 'page',
            'post_content'  => '[user_profile]',
            'post_status'   => 'publish'
        );
        wp_insert_post($my_account);
    }
    $page=get_page_by_path('create-poll');
    if(!$page){
        $my_account=array(
            'post_title'    => 'My Account',
            'post_type'     => 'page',
            'post_content'  => '[pollcourse]',
            'post_status'   => 'publish'
        );
        wp_insert_post($my_account);
    }
	$page=get_page_by_path('create-fl1plist');
    if(!$page){
        $my_account=array(
            'post_title'    => 'Create Fl1plist',
            'post_type'     => 'page',
            'post_content'  => '[fliplistcanvas]',
            'post_status'   => 'publish'
        );
        wp_insert_post($my_account);
    }
	$page=get_page_by_path('create-fl1p-recording');
    if(!$page){
        $my_account=array(
            'post_title'    => 'Create Fl1p Recording',
            'post_type'     => 'page',
            'post_content'  => '[fliprecording]',
            'post_status'   => 'publish'
        );
        wp_insert_post($my_account);
    }
	
	/** PWA PAGES **/
	$page=get_page_by_path('pwa-recordingview');
    if(!$page){
        $my_account=array(
            'post_title'    => 'Pwa Recordingview',
            'post_type'     => 'page',
            'post_content'  => '[pwa-fl1precview]',
            'post_status'   => 'publish'
        );
        wp_insert_post($my_account);
    }
	
	$page=get_page_by_path('pwa-fl1plist');
    if(!$page){
        $my_account=array(
            'post_title'    => 'PWA Fl1plist',
            'post_type'     => 'page',
            'post_content'  => '[pwa-fl1plist]',
            'post_status'   => 'publish'
        );
        wp_insert_post($my_account);
    }
	
	$page=get_page_by_path('pwa-fl1precording');
    if(!$page){
        $my_account=array(
            'post_title'    => 'PWA Fl1precording',
            'post_type'     => 'page',
            'post_content'  => '[pwa-fl1precording]',
            'post_status'   => 'publish'
        );
        wp_insert_post($my_account);
    }
}

register_activation_hook(__FILE__,'create_lms_pages');
/**** for create require terms ****/
function create_required_term() {
    if(!taxonomy_exists('nav_menu')){
         $args = array(
            'label'        => __( 'nav_menu', 'textdomain' ),
            'public'       => false,
            'rewrite'      => false,
            'hierarchical' => true
        );
     
        register_taxonomy( 'nav_menu', 'post', $args );
    }
    if(!term_exists('custom_menu','nav_menu')){
        wp_insert_term(
            'custom_menu',
            'nav_menu',
            array(
            'slug' => 'custom_menu',
            )
        );
    }
}
register_activation_hook(__FILE__,'create_required_term');

/**** for get dynamic menu items ****/
function get_dynamic_menu_items()
{
    $locations = get_nav_menu_locations();  
    $term_id=get_term_by('slug','custom_menu','nav_menu')->term_id;
    $menu_items=wp_get_nav_menu_items($term_id);
    return $menu_items;
}

/**** for create dynamic menu items ****/
function create_post_menu(){
    global $wpdb;
    $term_id=get_term_by('slug','custom_menu','nav_menu')->term_id;
    $menus=get_dynamic_menu_items();
    $menu_title=array();
    foreach($menus as $menu){
        $menu_title[]=$menu->title;
    } 
    if(!in_array('Home',$menu_title)){
        $home_page=get_page_by_path('home');
        $home_menu=array(
            'post_type'=>'nav_menu_item',
            'post_status'=>'publish',
            'menu_order'=> '1',  
        );
        $menu_item=wp_insert_post($home_menu);
        $insert_relation_ship = $wpdb->query("insert into ".$wpdb->prefix."term_relationships (object_id,term_taxonomy_id,term_order) values ('".$menu_item."','".$term_id."','0')");
        wp_update_post(array('ID'=>$menu_item,'post_name'=>$menu_item));
        update_post_meta($menu_item,'_menu_item_type','post_type');
        update_post_meta($menu_item,'_menu_item_menu_item_parent','');
        update_post_meta($menu_item,'_menu_item_object_id',$home_page->ID);
        update_post_meta($menu_item,'_menu_item_object','page');
        update_post_meta($menu_item,'user_setting_menu_icon','fal fa-home');
    }  
	/** Admin main menu and 3 submenus mycontent, maydata, usermanagement **/
	if(!in_array('Admin',$menu_title)){
        $mc_menu=array(
            'post_type'=>'nav_menu_item',
            'post_title'=>'Admin',
            'post_name' =>'admin',
            'post_status'=>'publish',
            'menu_order' => '2',
        );
        $admin_menu_item=wp_insert_post($mc_menu);
        $insert_relation_ship = $wpdb->query("insert into ".$wpdb->prefix."term_relationships (object_id,term_taxonomy_id,term_order) values ('".$admin_menu_item."','".$term_id."','0')");
        update_post_meta($admin_menu_item,'_menu_item_type','custom');
        update_post_meta($admin_menu_item,'_menu_item_menu_item_parent','0');
        update_post_meta($admin_menu_item,'_menu_item_object_id',$admin_menu_item);
        update_post_meta($admin_menu_item,'_menu_item_object','custom');
        update_post_meta($admin_menu_item,'_menu_item_target','');
        update_post_meta($admin_menu_item,'_menu_item_classes',array('my_community'));
        update_post_meta($admin_menu_item,'_menu_item_xfn','');
        update_post_meta($admin_menu_item,'_menu_item_url','');
        update_post_meta($menu_item,'user_setting_menu_icon','fas fa-users');
    }
    if(!in_array('My Content',$menu_title)){
        $mycontent_page=get_page_by_path( 'my-content' );
        $mycontent_menu=array(
            'post_type'=>'nav_menu_item',
            'post_status'=>'publish',
            'menu_order'=> '1',  
        );
        $mcmenu_item=wp_insert_post($mycontent_menu);
        $insert_relation_ship = $wpdb->query("insert into ".$wpdb->prefix."term_relationships (object_id,term_taxonomy_id,term_order) values ('".$mcmenu_item."','".$term_id."','0')");
        wp_update_post(array('ID'=>$mcmenu_item,'post_name'=>$mcmenu_item));
        update_post_meta($mcmenu_item,'_menu_item_type','post_type');
        update_post_meta($mcmenu_item,'_menu_item_menu_item_parent',$admin_menu_item);
        update_post_meta($mcmenu_item,'_menu_item_object_id',$mycontent_page->ID);
        update_post_meta($mcmenu_item,'_menu_item_object','page');
    }
	
    if(!in_array('Create',$menu_title)){
        $create_menu=array(
            'post_type'=>'nav_menu_item',
            'post_title'=>'Create',
            'post_name' =>'create',
            'post_status'=>'publish',
            'menu_order' => '6',
        );
        $create_menu_item=wp_insert_post($create_menu);
        $insert_relation_ship = $wpdb->query("insert into ".$wpdb->prefix."term_relationships (object_id,term_taxonomy_id,term_order) values ('".$create_menu_item."','".$term_id."','0')");
        update_post_meta($create_menu_item,'_menu_item_type','custom');
        update_post_meta($create_menu_item,'_menu_item_menu_item_parent','0');
        update_post_meta($create_menu_item,'_menu_item_object_id',$create_menu_item);
        update_post_meta($create_menu_item,'_menu_item_object','custom');
        update_post_meta($create_menu_item,'_menu_item_target','');
        update_post_meta($create_menu_item,'_menu_item_classes',array('create'));
        update_post_meta($create_menu_item,'_menu_item_xfn','');
        update_post_meta($create_menu_item,'_menu_item_url','');
        update_post_meta($create_menu_item,'user_setting_menu_icon','fal fa-pencil-paintbrush');
    }
    /* if(!in_array('Create Courses',$menu_title)){
        $course_page=get_page_by_path('create-courses');
        $course_menu=array(
            'post_type'=>'nav_menu_item',
            'post_status'=>'publish',
            'menu_order'=> '2',
            'post_parent'=>$create_menu_item
        );
        $menu_item=wp_insert_post($course_menu);
        $insert_relation_ship = $wpdb->query("insert into ".$wpdb->prefix."term_relationships (object_id,term_taxonomy_id,term_order) values ('".$menu_item."','".$term_id."','0')");
        wp_update_post(array('ID'=>$menu_item,'post_name'=>$menu_item));
        update_post_meta($menu_item,'_menu_item_type','post_type');
        update_post_meta($menu_item,'_menu_item_menu_item_parent',$create_menu_item);
        update_post_meta($menu_item,'_menu_item_object_id',$course_page->ID);
        update_post_meta($menu_item,'_menu_item_object','page');
    }
    if(!in_array('Articulate Content (Web)',$menu_title)){
        $ac_page=get_page_by_path('create-articulate-content');
        $ac_menu=array(
            'post_type'=>'nav_menu_item',
            'post_title' => 'Articulate Content (Web)',
            'post_status'=>'publish',
            'menu_order'=> '3',
        );
        $menu_item=wp_insert_post($ac_menu);
        $insert_relation_ship = $wpdb->query("insert into ".$wpdb->prefix."term_relationships (object_id,term_taxonomy_id,term_order) values ('".$menu_item."','".$term_id."','0')");
        wp_update_post(array('ID'=>$menu_item,'post_name'=>$menu_item));
        update_post_meta($menu_item,'_menu_item_type','post_type');
        update_post_meta($menu_item,'_menu_item_menu_item_parent',$create_menu_item);
        update_post_meta($menu_item,'_menu_item_object_id',$ac_page->ID);
        update_post_meta($menu_item,'_menu_item_object','page');
    } */
    if(!in_array('User Profile',$menu_title)){
        $create_user_menu=array(
            'post_type'=>'nav_menu_item',
            'post_title'=>'User Profile',
            'post_status'=>'publish',
            'menu_order' => '7',
        );
        $user_menu=wp_insert_post($create_user_menu);
        $insert_relation_ship = $wpdb->query("insert into ".$wpdb->prefix."term_relationships (object_id,term_taxonomy_id,term_order) values ('".$user_menu."','".$term_id."','0')");
        update_post_meta($user_menu,'_menu_item_type','custom');
        update_post_meta($user_menu,'_menu_item_menu_item_parent','0');
        update_post_meta($user_menu,'_menu_item_object_id',$user_menu);
        update_post_meta($user_menu,'_menu_item_object','custom');
        update_post_meta($user_menu,'_menu_item_target','');
        update_post_meta($user_menu,'_menu_item_classes',array('user_menu'));
        update_post_meta($user_menu,'_menu_item_xfn','');
        update_post_meta($user_menu,'_menu_item_url','');
        update_post_meta($user_menu,'user_setting_menu_icon','fas fa-user-circle');
    }
    if(!in_array('My Account',$menu_title)){
        $menu_page=get_page_by_path('my-account');
        $my_account_menu=array(
            'post_type'=>'nav_menu_item',
            'post_title'=>'My Account',
            'post_status'=>'publish',
            'menu_order' => '1',
        );
        $ma_menu=wp_insert_post($my_account_menu);
        $insert_relation_ship = $wpdb->query("insert into ".$wpdb->prefix."term_relationships (object_id,term_taxonomy_id,term_order) values ('".$ma_menu."','".$term_id."','0')");
        wp_update_post(array('ID'=>$ma_menu,'post_name'=>$ma_menu));
        update_post_meta($ma_menu,'_menu_item_type','post_type');
        update_post_meta($ma_menu,'_menu_item_menu_item_parent',$user_menu);
        update_post_meta($ma_menu,'_menu_item_object_id',$menu_page->ID);
        update_post_meta($ma_menu,'_menu_item_object','page');
    }
    if(!in_array('Logout',$menu_title)){
         $logout_menu=array(
            'post_type'=>'nav_menu_item',
            'post_title'=>'Logout',
            'post_status'=>'publish',
            'menu_order' => '2',
        );
        $lg_menu=wp_insert_post($logout_menu);
        $insert_relation_ship = $wpdb->query("insert into ".$wpdb->prefix."term_relationships (object_id,term_taxonomy_id,term_order) values ('".$lg_menu."','".$term_id."','0')");
        update_post_meta($lg_menu,'_menu_item_type','custom');
        update_post_meta($lg_menu,'_menu_item_menu_item_parent',$user_menu);
        update_post_meta($lg_menu,'_menu_item_object_id',$lg_menu);
        update_post_meta($lg_menu,'_menu_item_object','custom');
        update_post_meta($lg_menu,'_menu_item_target','');
        update_post_meta($lg_menu,'_menu_item_xfn','');
        update_post_meta($lg_menu,'_menu_item_url',''); 
    }
}
register_activation_hook(__FILE__,'create_post_menu');

/**** for delete lms page ****/
/* function delete_lms_page(){
    global $wpdb;
    $create_menu=$wpdb->get_results("select * from ".$wpdb->prefix."posts where post_name='create' and post_type='nav_menu_item'");
    wp_delete_post($create_menu[0]->ID,true);
    $course_page=get_page_by_path( 'create-courses' );
    wp_delete_post($course_page->ID,true);
    $course_menu=$wpdb->get_results("select post_id from ".$wpdb->prefix."postmeta where meta_key='_menu_item_object_id' and meta_value='".$course_page->ID."'");
    wp_delete_post($course_menu[0]->post_id,true);
    $content_page=get_page_by_path( 'create-xapi-content' );
    wp_delete_post($content_page->ID,true);
    $articulate_page=get_page_by_path( 'create-articulate-content' );
    wp_delete_post($articulate_page->ID,true);
    $articulate_menu=$wpdb->get_results("select post_id from ".$wpdb->prefix."postmeta where meta_key='_menu_item_object_id' and meta_value='".$articulate_page->ID."'");
    wp_delete_post($articulate_menu[0]->post_id,true);
    $join_next_step=get_page_by_path( 'join-next-step' );
    wp_delete_post($join_next_step->ID,true);
    $email_verification=get_page_by_path( 'email-verification' );
    wp_delete_post($email_verification->ID,true);
	$resend_verification=get_page_by_path('resend-verification-link');
    wp_delete_post($resend_verification->ID,true);
}
register_deactivation_hook(__FILE__,'delete_lms_page'); */

/* code for update plugin */
require $lx_plugin_paths['lx_lms_lite'] . 'addons/plugin-update-checker/plugin-update-checker.php';

/** api for git hub integration **/
 $myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/kalpanavasava/lxrepoupdatecheck/',
    __FILE__,
    'learningx_lms_lite'
);

$myUpdateChecker->setBranch('master');

$github_key = get_option('github_key');

$myUpdateChecker->setAuthentication($github_key); 


/** --------------- **/
add_action( 'plugins_loaded', 'my_plugin_override' );

function my_plugin_override() {
    update_option( 'testingupdateoption', rand() );
}

/** upgrader process **/
add_action( 'upgrader_process_complete', 'CustomUpgraderProcess',10, 2 );
function CustomUpgraderProcess( $upgrader_object, $options ) {
    $current_plugin_path_name = plugin_basename( __FILE__ );
	 update_option( 'testingupdateoption', rand() );
    if ($options['action'] == 'update' && $options['type'] == 'plugin' ) {
		foreach($options['plugins'] as $each_plugin) {
			if ($each_plugin==$current_plugin_path_name) {
				FnCreateDefaultPlaylist();
				create_lms_pages();
			}
		}
    }
}

/** --------------- **/


/* default lx lms settings */
/* if(empty($frontend_icon)){
	register_activation_hook(__FILE__,'store_default_frontend_icon_settings');
}
if(empty($square_icon)){
	register_activation_hook(__FILE__,'store_default_square_icon_settings');
}
if(empty($button_styling)){
	register_activation_hook(__FILE__,'store_default_button_styling_settings');
}
if(empty($font_family)){
	register_activation_hook(__FILE__,'store_default_font_settings');
}
if(empty($color_palette)){
	register_activation_hook(__FILE__,'store_default_color_palette_settings');
}
if(empty($menu_settings)){
	register_activation_hook(__FILE__,'store_default_menu_settings');
}
if(empty($breakpoint)){
	register_activation_hook(__FILE__,'store_default_breakpoint_settings');
}
if(empty($page_devider)){
	register_activation_hook(__FILE__,'store_default_page_devider_settings');
}
if(empty($lightbox_settings)){
	register_activation_hook(__FILE__,'store_default_articulate_lightbox_popup_settings');
} */

register_activation_hook(__FILE__,'store_default_frontend_icon_settings');
register_activation_hook(__FILE__,'store_default_square_icon_settings');
register_activation_hook(__FILE__,'store_default_button_styling_settings');
register_activation_hook(__FILE__,'store_default_font_settings');
register_activation_hook(__FILE__,'store_default_color_palette_settings');
register_activation_hook(__FILE__,'store_default_menu_settings');
register_activation_hook(__FILE__,'store_default_breakpoint_settings');
register_activation_hook(__FILE__,'store_default_page_devider_settings');
register_activation_hook(__FILE__,'store_default_articulate_lightbox_popup_settings');
register_activation_hook(__FILE__,'RequiredCategoryCreateLite');
register_activation_hook(__FILE__,'RequiredEmailContentLite');

/**** for manage my account redirections ****/
function my_account_redirect(){
    $url = $_SERVER['REQUEST_URI'];
    if(!is_user_logged_in()){
        if( strpos($url, "/my-account/") !== false ){
            wp_redirect(site_url());
            exit();
         }  
    }
}
add_action('wp_loaded','my_account_redirect');

/**** for store user last login ****/
function user_last_login( $user_login, $user ) {
    update_user_meta( $user->ID, 'last_login', time() );
}
add_action( 'wp_login', 'user_last_login', 10, 2 );

add_action('wp_head', 'custom_rewrite_rule2', 10, 1, 'asdasd');

/**** for get dynamic menu items ****/
function custom_rewrite_rule2($post) {
	
	global $wpdb,$post;
	$site_url = explode( '/' , site_url() )[3];
	if(empty($site_url)){
		$site_url = site_url();
	}
	if(!empty($_SERVER['REDIRECT_URL'])){
		$base_url = ltrim( chop( str_replace( $site_url.'/' , '' , $_SERVER['REDIRECT_URL'] ) , '/' ) , '/' );
	}else{
		$base_url = ltrim( chop( str_replace( $site_url.'/' , '' , $_SERVER['REQUEST_URI'] ) , '/' ) , '/' );
	}
	
	add_rewrite_rule('^certificate/', 'index.php?page_id=&post_type=page&is_certificate=yes&unique_id='.explode('/',$base_url)[1], 'top');
		
	flush_rewrite_rules();
	
}

/**** for template redirection query vars ****/
function prefix_register_query_var( $vars ) {
    $vars[] = 'is_certificate';
    $vars[] = 'unique_id';
 
    return $vars;
}
 
add_filter( 'query_vars', 'prefix_register_query_var' );

/**** for template redirection ****/
function prefix_url_rewrite_templates( $template ) {
    /* if ( get_query_var( 'is_certificate' ) == 'yes') { */
    if (strpos($_SERVER['REQUEST_URI'],'certificate') !== false) {
        add_filter( 'template_include', function() {
			/* if(is_user_logged_in()){ */
				return dirname(__FILE__) . '/addons/certificate/certificate.php';
			/* }else{
				wp_redirect( site_url() );
			} */
        });
    }
	
}
 
add_action( 'template_redirect', 'prefix_url_rewrite_templates' );

/** CRM API(Salesforce) **/
include $lx_plugin_paths['lx_lms_lite'] . '/api/crmapis/salseforceapi/apifns.php';
include $lx_plugin_paths['lx_lms_lite'] . '/api/crmapis/lib/api_ajax.php';

/** FLIP Canvas **/
/* include $lx_plugin_paths['lx_lms_lite'] . '/addons/flip/functions/functions.php'; */

function GenerateCourseProgressCompleted(){
	global $wpdb;
	$userid = get_current_user_ID();
	$webooksettings = get_option('currentwebhookon',true);
	if( $webooksettings['course'] == 1 ){
		$get_course = $wpdb->get_results("select courseid from ".$wpdb->prefix."vw_coursewebhook_master");
		
		$all_progresses_array = array();$all_com_array = array();
		foreach( $get_course as $cdata ){
			$courseid = $cdata->courseid;
			$fullcourse = get_post( $courseid );
			$get_userleadcallProg = $wpdb->get_results("select * from ".$wpdb->prefix."vw_coursewebhook_payload where userid='".$userid."' and action='Progressed' and course_id='".$courseid."'");
			$get_userleadcallComp = $wpdb->get_results("select * from ".$wpdb->prefix."vw_coursewebhook_payload where userid='".$userid."' and action='Completed' and course_id='".$courseid."'");
			if( $fullcourse->post_status == 'publish' && $fullcourse->post_type == 'lx_course' ){
				$coursearray = lx_course_progress( $courseid,$userid );
				if( $coursearray['status'] == 'Partially completed' && empty($get_userleadcallProg) ){
					$all_progresses_array[] = $courseid;
				}
				if( $coursearray['status'] == 'Completed' && empty($get_userleadcallComp) ){
					$all_com_array[] = $courseid;
				}
			}
		}
		
		if(!empty($all_com_array)){
			foreach( $all_com_array as $acmpdata ){
				$is_course_webhookexist = $wpdb->get_results("select * from ".$wpdb->prefix."vw_coursewebhook_master where courseid='".$acmpdata."'");
				if( $is_course_webhookexist[0]->act_completed == 1 ){
					$salesforcesetting = get_option('salesforce_environment',true);
					$apis = array_values( $salesforcesetting[$salesforcesetting['environment']] );
					$Auth = SFAPIAuthentication( $apis );
					$auth_token = json_decode( $Auth )->access_token;
					$instance_url = json_decode( $Auth )->instance_url;
					$authenticationar = array('auth_token'=>$auth_token,'instance_url'=>$instance_url);
					
					$coursetitle = get_post($acmpdata)->post_title;
					$comid = get_post_meta($acmpdata,'lx_attach_this_course',true);
					$commtitle = get_post($comid)->post_title;
					
					$payload_array['Email__c'] = get_userdata($userid)->user_email;
					$payload_array['FirstName'] = get_user_meta($userid,'first_name',true);
					$payload_array['LastName'] = get_user_meta($userid,'last_name',true);
					$payload_array['company'] = get_option('blogname',true);
					$payload_array['CommunityId__c'] = $comid;
					$payload_array['Community_Name__c'] = $commtitle;
					$payload_array['CourseId__c'] = $acmpdata;
					$payload_array['Course_Name__c'] = $coursetitle;
					$payload_array['Action__c'] = 'Completed';
					$payload_array['Form_Type__c'] = 'Course';
					
					$generated_lead = SFAPICreateNewLead( $authenticationar , json_encode( $payload_array ) );
					if( !empty(json_decode( $generated_lead )->id) ){
						$wpdb->insert($wpdb->prefix.'vw_coursewebhook_payload',array('userid'=>$userid,'com_id'=>$comid,'course_id'=>$acmpdata,'action'=>'Completed','response'=>$generated_lead,'date_created'=>date('Y-m-d H:i:s')));
					}
				}
			}
		}
		if(!empty($all_progresses_array)){
			foreach( $all_progresses_array as $aprgdata ){
				$is_course_webhookexist = $wpdb->get_results("select * from ".$wpdb->prefix."vw_coursewebhook_master where courseid='".$aprgdata."'");
				if( $is_course_webhookexist[0]->act_progress == 1 ){
					$salesforcesetting = get_option('salesforce_environment',true);
					$apis = array_values( $salesforcesetting[$salesforcesetting['environment']] );
					$Auth = SFAPIAuthentication( $apis );
					$auth_token = json_decode( $Auth )->access_token;
					$instance_url = json_decode( $Auth )->instance_url;
					$authenticationar = array('auth_token'=>$auth_token,'instance_url'=>$instance_url);
					
					$coursetitle = get_post($aprgdata)->post_title;
					$comid = get_post_meta($aprgdata,'lx_attach_this_course',true);
					$commtitle = get_post($comid)->post_title;
					
					$payload_array['Email__c'] = get_userdata($userid)->user_email;
					$payload_array['FirstName'] = get_user_meta($userid,'first_name',true);
					$payload_array['LastName'] = get_user_meta($userid,'last_name',true);
					$payload_array['company'] = get_option('blogname',true);
					$payload_array['CommunityId__c'] = $comid;
					$payload_array['Community_Name__c'] = $commtitle;
					$payload_array['CourseId__c'] = $aprgdata;
					$payload_array['Course_Name__c'] = $coursetitle;
					$payload_array['Action__c'] = 'Progressed';
					$payload_array['Form_Type__c'] = 'Course';
					
					$generated_lead = SFAPICreateNewLead( $authenticationar , json_encode( $payload_array ) );
					if( !empty(json_decode( $generated_lead )->id) ){
						$wpdb->insert($wpdb->prefix.'vw_coursewebhook_payload',array('userid'=>$userid,'com_id'=>$comid,'course_id'=>$aprgdata,'action'=>'Progressed','response'=>$generated_lead,'date_created'=>date('Y-m-d H:i:s')));
					}
				}
			}
		}
	}
}
add_action('wp_head','GenerateCourseProgressCompleted');

function role_exists( $role ) {

  if( ! empty( $role ) ) {
    return $GLOBALS['wp_roles']->is_role( $role );
  }
  
  return false;
}

function lx_add_roles(){
    if(!role_exists('site_owner')){
       add_role( 'site_owner', __( 'Site Owner' ), array( 'read'  => true, ) );
    }
    if(!role_exists('community_owner')){
       add_role( 'community_owner', __( 'Community Owner' ), array( 'read'  => true, ) );
    }
    if(!role_exists('technology_manager')){
       add_role( 'technology_manager', __( 'Technology Manager' ), array( 'read'  => true, ) );
    }
	if(!role_exists('community_blog_author')){
       add_role( 'community_blog_author', __( 'Community Blog Author' ), array( 'read'  => true, ) );
    }
}
register_activation_hook(__FILE__,'lx_add_roles');

function FooterCreateMenuModalFN(){
	if(!current_user_can('subscriber')){
	?>
	<!-- Create Menu modal -->
	<div class="modal fade" id="menucreatemodal" >
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="menucreatemodaltitle">Create something new...</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
				<?php 
				if(is_plugin_active(LX_LMS_PRO)){
				?>
				<div class="row">
					<div class="col-md-4">
						<a href="<?php echo site_url();?>/create-community/"><button class="btn_normal_state w-100">Select</button></a>
					</div>
					<div class="col-md-8">
						<div><b>Community or Sub-Community</b></div>
						<div><small><i>Organise content for a specific audience</i></small></div>
					</div>
				</div>
				<?php
				}
				?>
				<div class="row mt-3">
					<div class="col-md-4">
						<a href="<?php echo site_url();?>/create-courses/"><button class="btn_normal_state w-100">Select</button></a>
					</div>
					<div class="col-md-8">
						<div><b>Course</b></div>
						<div><small><i>Create a Course with Rise content, Polls, and Fl1ps</i></small></div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-4">
						<a href="<?php echo site_url();?>/create-fl1plist/"><button class="btn_normal_state w-100">Select</button></a>
					</div>
					<div class="col-md-8">
						<div><b>Fl1plist</b></div>
						<div><small><i>A playlist to add/organise Fl1p Recordings</i></small></div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-4">
						<a href="<?php echo site_url();?>/create-fl1p-recording/"><button class="btn_normal_state w-100">Select</button></a>
					</div>
					<div class="col-md-8">
						<div><b>Fl1p Recording</b></div>
						<div><small><i>Use audio + text/images to share knowledge and ideas</i></small></div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-4">
						<a href="<?php echo site_url();?>/create-articulate-content/"><button class="btn_normal_state w-100">Select</button></a>
					</div>
					<div class="col-md-8">
						<div><b>Articulate (Web) Content</b></div>
						<div><small><i>Like a blog, but using Articulate Rise or Storyline</i></small></div>
					</div>
				</div>
		  </div>
		</div>
	  </div>
	</div>
	<?php
	}
}
add_action('wp_footer','FooterCreateMenuModalFN');


function LMSBreakPointExclude(){
	$excludedpage = get_option('breakpoint_exclude');
	$isexist = '';
    if(!empty($excludedpage)){
    	foreach( $excludedpage as $expage ){
    		if(is_page($expage)){
    			$isexist = 1;
    		}
    	}
    }
	if( $isexist == 1 ){
		?>
		<style>
		article{
			width:100%;
		}
		</style>
		<?php
	}
}
add_action('wp_head','LMSBreakPointExclude');

function FnCreateDefaultPlaylist(){
	$allUser = get_users();
	foreach( $allUser as $usersData ){
		$checkdefaultfliplist = array(
					'author' => $usersData->ID,
					'post_type' => 'flip_list',
					'post_status' => 'publish',
				);
		$getdefaultfliplist = get_posts( $checkdefaultfliplist );
		$defaultlist_exists = array();
		foreach( $getdefaultfliplist as $def ){
			$registertime = get_post_meta( $def->ID , 'registertimelist', true );
			if( $registertime == 1 ){
				$defaultlist_exists[] = $def->ID;
			}
		}
		if( empty( $defaultlist_exists ) ){
			$fliplistdefault = array(
				'post_title'    => 'My Flip Recordings '.$userid,
				'post_status'   => 'publish',
				'post_type'   => 'flip_list',
				'post_author'   => $usersData->ID,
			);
			$insertedid = wp_insert_post( $fliplistdefault );
			update_post_meta($insertedid,'registertimelist','1');
		}
	}
}

function RemoveFrontMenusforSomeRoles( $items, $menu, $args ) {
	if( !current_user_can('administrator') && !current_user_can('site_owner') && is_user_logged_in() ){
		foreach ( $items as $key => $item ) {
			if ( $item->post_title == 'Admin' ){
				unset( $items[$key] );
			}
		}
	}
	if( !is_user_logged_in() ){
		foreach ( $items as $key => $item ) {
			if ( $item->post_title == 'Admin' || $item->post_title == 'User Profile' || $item->post_title == 'My Communities' ){
				unset( $items[$key] );
			}
		}
	}
    return $items;
}

add_filter( 'wp_get_nav_menu_items', 'RemoveFrontMenusforSomeRoles', null, 3 );

function agreementredirect(){
	if(is_user_logged_in()){
		$toacheck = get_option( 'lx_lms_login_toasetting' );
		if( $toacheck['lms_toa_toggle'] == 'on' ){
			$uid = get_current_user_ID();
			$agreeementexist = get_user_meta( $uid , 'user_agreement' , true );
			
			$toadesturl = $toacheck['lms_toa_agreeurl'];
			$toadesturl = trim($toadesturl,"/");
			if( empty($toadesturl) ){
				$toadesturl = 'terms-of-agreement';
			}
			$ppdesturl = $toacheck['lms_toa_privacyurl'];
			$ppdesturl = trim($ppdesturl,"/");
			if( empty($ppdesturl) ){
				$ppdesturl = 'privacy-policy';
			}
			$policypath = get_page_by_path( $ppdesturl );
			$termpath = get_page_by_path( $toadesturl );
			if( empty($agreeementexist) ){
				if (strpos($_SERVER['REQUEST_URI'],$ppdesturl) !== false || strpos($_SERVER['REQUEST_URI'],$toadesturl) !== false){
					
				}elseif (strpos($_SERVER['REQUEST_URI'],'agreement') !== false) {
					add_filter( 'template_include', function() {
						return dirname(__FILE__) . '/addons/vw_customize_login/templates/agreement.php';
					});
				}else{
					wp_redirect( site_url() . '/agreement/' );exit;
				}
			}elseif(!empty($agreeementexist) && !empty($termpath) && !empty($policypath) ){
				if (strpos($_SERVER['REQUEST_URI'],$ppdesturl) !== false || strpos($_SERVER['REQUEST_URI'],$toadesturl) !== false){
					
				}else{
					if( ( strtotime( $termpath->post_modified ) > $agreeementexist && $termpath->post_status == 'publish' ) || ( strtotime( $policypath->post_modified ) > $agreeementexist && $policypath->post_status == 'publish' ) ){
						if (strpos($_SERVER['REQUEST_URI'],'agreement') !== false) {
							add_filter( 'template_include', function() {
								return dirname(__FILE__) . '/addons/vw_customize_login/templates/agreement.php';
							});
						}else{
							wp_redirect( site_url() . '/agreement/' );exit;
						}
					}
				}
			}
		}
	}
}
add_action('template_redirect','agreementredirect');

function UserLogoutAfterGivenTime( $expiration, $user_id, $remember ) {
	$logintimeout = get_option( 'lx_lms_login_setting' )['logintimeout'];
	if( !empty($logintimeout) ){
		$expiretimeout = $logintimeout * 60 * 60;
	}else{
		$expiretimeout = 172800;
	}
    return $expiretimeout;
}
add_filter( 'auth_cookie_expiration', 'UserLogoutAfterGivenTime',  99, 3);

function commonjsvar(){
	global $color_palette;
	?>
	<script>
	var global_var = {'course_completed_color':"<?php echo $color_palette['course_completed'];?>",'course_partially_completed_color':"<?php echo $color_palette['course_partially_completed'];?>",'hyperlinks_color':"<?php echo $color_palette['hyperlinks'];?>"};
	</script>
	<?php
}
add_action('wp_head','commonjsvar');

function plugin_rename_lite(){
    $old_name = plugin_basename(dirname(__FILE__));
    $new_name = 'learningx_lms_lite';
    if( $old_name != $new_name ){
        rename( dirname(__FILE__), dirname(dirname(__FILE__)).'/'.$new_name);
        run_activate_plugin_lite( dirname(dirname(__FILE__)).'/'.$new_name.'/learningx_lms_lite.php' );
        wp_redirect('plugins.php');
        die();
   }
}
register_activation_hook(__FILE__,'plugin_rename_lite');