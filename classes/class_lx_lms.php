<?php
/**
 * 
 */
class Lx_lms
{
	function __construct()
	{
		add_action('admin_enqueue_scripts',array($this,'lx_lms_enqueue_scripts'));
		add_action('wp_enqueue_scripts',array($this,'lx_lms_enqueue__front_scripts'));
		add_action('wp_enqueue_scripts',array($this,'lx_lms_enqueue__lx_lms_scripts_pro'),10);
		add_action( 'admin_menu', array( $this, 'add_user_interface' ) );
	}
	function lx_lms_enqueue_scripts()
	{
		global $lx_plugin_urls,$lx_plugin_paths;
		wp_enqueue_style('lx_lms_css',$lx_plugin_urls['lx_lms_lite'].'/assets/css/lx_lms_css.css');
		wp_enqueue_style('lx_lms_cropper_css',$lx_plugin_urls['lx_lms_lite'].'/assets/css/cropper.css');
		wp_enqueue_script('lx_lms_js',$lx_plugin_urls['lx_lms_lite'].'/assets/js/lx_lms_js.js',array('jquery'));
		wp_enqueue_script('lx_lms_cropper_js',$lx_plugin_urls['lx_lms_lite'].'/assets/js/cropper.js',array('jquery'));
		$scriptData = array();
        $scriptData['ajaxurl'] = admin_url( 'admin-ajax.php' );
		$ajax_array = array( 
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'blog_url' => site_url().'/blog-post/',
				);
		wp_localize_script( 'lx_lms_js', 'vw_user_interface_path', $ajax_array );
		
	}
	function lx_lms_enqueue__front_scripts(){
		global $lx_plugin_urls,$learning_locker_setting;
		wp_enqueue_style('lite_common_css',$lx_plugin_urls['lx_lms_lite'].'assets/css/lite_common_css.css');
		wp_enqueue_script('cryptojs','https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js',array('jquery'));
		wp_enqueue_script('lx_lms_front_js',$lx_plugin_urls['lx_lms_lite'].'/assets/js/lx_lms_front.js',array('jquery'));
		wp_enqueue_script('xapiwrapper',$lx_plugin_urls['lx_lms_lite'].'addons/lx_courses/js/xapijs/xapiwrapper.js',array('jquery'));
		
		$user=get_user_by('id',get_current_user_ID());
		$user_email=$user->user_email;
		$ajax_array = array( 
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'currentemail' => $user_email,
					'endpoint' => $learning_locker_setting['end_point'],
					'auth_key' => $learning_locker_setting['auth_key'],
					'auth_secret' => $learning_locker_setting['auth_secret'],
				);
		wp_localize_script( 'lx_lms_front_js', 'path', $ajax_array );
	}
	function lx_lms_enqueue__lx_lms_scripts_pro(){
		global $lx_plugin_urls;
		wp_enqueue_script('lx_lms_front_js_info',$lx_plugin_urls['lx_lms_lite'].'/assets/js/lx_lms_lite.js',array('jquery'));
	}
	function items_with_square_button_background($key){
		$items_with_square_button_background = get_option( 'user_interface_items_with_square_button_background');
		return $items_with_square_button_background[$key];
	}
	/**
     * Add options page
     */
    public function add_user_interface() {
      /* This page will be under "Settings" */
		$menu_info[] = add_menu_page('LearningX LMS', 'LearningX LMS', 'manage_options', 'learningx_lms',array( $this, 'learningx_lms_setting'));
		$menu_info[] = add_submenu_page( 'learningx_lms', 'Settings', 'Settings',
			'manage_options', 'learningx_lms',  array( $this, 'learningx_lms_setting'));
		$menu_info[] = add_submenu_page( 'learningx_lms', 'Styling', 'Styling','manage_options', 'styling-admin',array( $this, 'create_user_interface_setting'));
		$menu_info[] = add_submenu_page( 'learningx_lms', 'Layouts and templates', 'Layouts and templates','manage_options', 'layout_template_settings',array( $this, 'create_layout_template_settings'));
		$menu_info[] = add_submenu_page( 'learningx_lms', 'CRM APIs', 'CRM APIs','manage_options', 'crm_apis',array( $this, 'crm_apis'));
		$menu_info[] = add_submenu_page( 'learningx_lms', 'Lexicon', 'Lexicon','manage_options', 'lexicon',array( $this, 'create_lexicon_setting'));
		foreach($menu_info as $menu){
			add_action('admin_print_styles-'.$menu,array($this,'user_interface_css'));
		}
		
	}
	
	function user_interface_css(){
		global $lx_plugin_urls;
		wp_enqueue_style('styling-admin','https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css');
	}

    /**
     * Options page callback
     */
    public function create_layout_template_settings(){
    	layout_template_settings_ui();
    }
	public function create_user_interface_setting() { 
		user_interface_settings_ui();	
    }
	public function learningx_lms_setting(){ 
		settings_ui();
	}
	public function create_lexicon_setting(){
		lexicon_settings_ui();
	}
	public function crm_apis(){
		global $lx_plugin_paths;
		include ( $lx_plugin_paths['lx_lms_lite'] . 'api/crmapis/backend/templates/crmapis.php' );
	}
}