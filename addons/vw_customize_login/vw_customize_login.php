<?php 
global $wpdb/* ,$login_settings */;
global $lx_customize_login_plugin_url;
global $lx_customize_login_plugin_path,$login_settings;
$lx_customize_login_plugin_url = plugin_dir_url(__FILE__);
$lx_customize_login_plugin_path = plugin_dir_path(__FILE__);

/******************* Classes **********************/
require_once $lx_customize_login_plugin_path.'/classes/class_vw_customize_login.php';
$lx_customize_login = new Customize_login();
/******************* Ajax **********************/
require_once $lx_customize_login_plugin_path.'/classes/class_vw_customize_login_ajax.php';
$lx_customize_login_ajax=new Customize_login_ajax();
/******************* Shortcodes **********************/
include($lx_customize_login_plugin_path.'includes/shortcodes/customize_login.php');
/******************* Shortcodes **********************/
include($lx_customize_login_plugin_path.'functions/functions.php');

/* Function to change sender name */
function vw_sender_name( $original_email_from ) {
	$sender_name = get_option('blogname')." Learning Team";
    return $sender_name;
}
function vw_custom_wp_mail_from( $original_email_address ) {
	/* $from_email = $login_settings['from_email']; */
    return str_replace( 'wordpress@','learningxliteteam@', $original_email_address );
}
 
/* Hooking up our functions to WordPress filters  */
add_filter( 'wp_mail_from', 'vw_custom_wp_mail_from' );
add_filter( 'wp_mail_from_name', 'vw_sender_name' );

if($login_settings['google_login']=="off"){
	add_action('init','vw_custom_login_redirection');
}
function vw_custom_login_redirection(){
	global $pagenow;
	if( 'wp-login.php' == $pagenow && !is_user_logged_in()) {
		$url = site_url().'/login/';
		wp_redirect($url);
		exit();
	}
}

add_action('wp_head', 'LxRewriteruleLoginPuchase', 10, 1);
function LxRewriteruleLoginPuchase($post) {
	global $pagenow;
	add_rewrite_rule('^login/', 'index.php?login_page=login&is_purchase=$matches[1]', 'top');
	add_rewrite_rule('^join-next-step/', 'index.php?redirect_key=join-next-step&join-next-step=$matches[1]', 'top');
	add_rewrite_rule('^email-verification/', 'index.php?redirect_key=email-verification&redirection=purchase&redirection=$matches[1]', 'top');
	add_rewrite_rule('^email-verification/', 'index.php?redirect_key=email-verification&redirection=community_purchase&redirection=$matches[1]', 'top');
	add_rewrite_rule('^payment/', 'index.php?redirect_key=lx_payment&redirection=purchase&redirection=$matches[1]', 'top');
	add_rewrite_rule('^print-receipt/', 'index.php?redirect_key=print-receipt&order_id=$matches[1]', 'top');
	
	flush_rewrite_rules();
}

function LxRewriteruleLoginPuchaseRegisterQuery( $vars ) {
	
    $vars[] = 'is_purchase';
    $vars[] = 'login_page';
    $vars[] = 'redirect_key';
    $vars[] = 'redirection';
	
    return $vars;
}
add_filter( 'query_vars', 'LxRewriteruleLoginPuchaseRegisterQuery' );

function LxRewriteruleLoginPuchaseTemplate( $template ) {
	global $lx_customize_login_plugin_path;
	$base64_data = base64_decode( end( explode( '/', rtrim( $_SERVER['REQUEST_URI'] , '/' ) ) ) );
	parse_str($base64_data, $array);
	$page=end( explode( '/', rtrim( $_SERVER['REQUEST_URI'] , '/' ) ) );
	
	/* vwpr($base64_data);
	die(); */
	
	if(is_user_logged_in() && $page=="resend-verification-link"){
		wp_redirect(site_url());exit();
	}elseif( $array['redirect_key'] == 'logincoursepurchase' && !empty($array['course_id']) ){
		return dirname(__FILE__) . '/templates/logincoursepurchase.php';
	}elseif ( $array['is_purchase'] == 'yes' && ( !empty($array['course_id']) ||  !empty($array['community_id']) )) {
		if( is_user_logged_in() ){
			wp_redirect(get_permalink( $array['community_id'] ));exit;
		}else{
			return lxlogin_PATH . '/templates/bootstrap/login.php';
		}
	}else if(($array['redirect_key'] == 'join-next-step' || $array['redirect_key'] == 'email-verification') && is_user_logged_in()){
		wp_redirect(site_url());exit();
	} else if($array['redirect_key'] == 'join-next-step'){ 
		return dirname(__FILE__) . '/templates/join_next_step.php';
	}else if($array['redirect_key'] == 'restricted_access'){ 
	
		return dirname(__FILE__) . '/templates/restricted_access.php';
		
	}else if($array['redirect_key'] == 'access_community'){ 
		return dirname(__FILE__) . '/templates/access_community.php';
	}else if($array['redirect_key'] == 'email-verification' && ( $array['redirection'] == 'purchase' || $array['redirection'] == 'community_purchase' )){
		return dirname(__FILE__) . '/templates/email_verification.php';
	} else if($array['redirect_key'] == 'email-verification'){
		return dirname(__FILE__) . '/templates/email_verification.php';
	} else if($array['redirect_key'] == 'lx_payment' && $array['redirection'] == 'purchase'){
		return dirname(__FILE__) . '/templates/lx_payment.php';
	} else if($array['redirect_key'] == 'print-receipt' && !empty($array['order_id'])){
		return dirname(__FILE__) . '/templates/lx_print_receipt.php';
	} else{
		return $template;
	}
	
}
add_action( 'template_include', 'LxRewriteruleLoginPuchaseTemplate' );

/**
	** Unaccesspage redirection
	**/
function UnaccesspageRedirection( $template ){
	if( strpos($_SERVER['REQUEST_URI'],'profile') !== FALSE ){
		wp_safe_redirect( 'http://localhost/learnx/' );
	}
	return $template;
}
add_action( 'template_include','UnaccesspageRedirection');

/**
Add new actions in bulk action list on send password reset
*/
add_filter('bulk_actions-users', function($bulk_actions) {
	unset($bulk_actions['resetpassword']); 
	$bulk_actions['vwsendpasswordreset'] = __('Send password reset', 'vwsendpasswordreset');
	return $bulk_actions;
});
add_filter('handle_bulk_actions-users', function($redirect_url, $action, $post_ids) { ?>
<?php
	global $wpdb;
	if ($action == 'vwsendpasswordreset') {
		$category_value = $_GET['users'];
		foreach($_GET['users'] as $user_id){
			$user_info = get_userdata($user_id);
			$email[] = $user_info->user_email;
		}
		$email = implode(",",$email);
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<div class="lp-screen" style="display:none;"><span><img class="user_interface_loader_img" src="<?php echo get_stylesheet_directory_uri().'/assets/loader/05.svg'?>"></div>
		<style>
		.lp-screen{
			width: 100%; 
			height: 100%; 
			background-color: rgba(255, 255, 255, 0.94); 
			position: fixed; 
			z-index: 666999; 
			top: 0px; 
			left: 0px;
		}
		.lp-screen span{
			width:120px;position: fixed;top: 50%;left: 50%;transform: translate(-50%, -50%);display: inline-block;
		}
		.lp-screen img{
			cursor:pointer;width:120px;
		}
		</style>
		<script>
			jQuery(document).bind("ajaxStart.mine", function() {
				jQuery('.lp-screen').show();
			});

			jQuery(document).bind("ajaxStop.mine", function() {
				jQuery('.lp-screen').hide();
			});
			jQuery( document ).ready(function() {
				var email = "<?php echo  $email; ?>";
				ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ) ?>';
				var post_data = {'email':email,'vw_bulk_actions_email':true,action:'uwp_ajax_forgot_password'};
				jQuery.ajax({					
				url  : ajaxurl,
				type: 'POST',
				data: post_data,
				dataType: 'html',
				success  : function(response) {
					window.location.href = '<?php echo $redirect_url; ?>';
					alert("Password reset link sent.");
				}
			});
			
		});
		</script>
		<?php
		}
}, 10, 3);