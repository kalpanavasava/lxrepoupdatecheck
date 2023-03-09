<?php 
class ClassPCAssets {
	
	public function __construct() {
		/** Shortcode For PollCourse Canvas **/
		add_shortcode( 'pollcourse', array( $this , 'PollCourseCanvas' ) );
		
		/** Enqueue PollCourse Scripts and Styles **/
		add_action( 'wp_enqueue_scripts', array( $this , 'PollCourseEnqueueScriptsStyles' ) );
		
		/** Enqueue PollCourse Dynamic CSS **/
		add_action( 'wp_head' , array( $this , 'PollCourseDynamicCSS' ) );
    }
	
	public function PollCourseCanvas() {
		ob_start();
		require POLLCOURESEPATH . '/templates/pollcoursecanvas.php' ;
		$ob=ob_get_clean();
		return $ob;
	}
	
	public function PollCourseEnqueueScriptsStyles() {
		wp_enqueue_style( 'pollcourse_style',POLLCOURESEURL.'/assets/css/pollcourse.css');
		wp_enqueue_script( 'pollcourse_js',POLLCOURESEURL.'/assets/js/pollcourse.js',array('jquery'));
		wp_localize_script( 'pollcourse_js', 'ajax_ob',
							array( 
								'ajax_url' => admin_url( 'admin-ajax.php' ),
								'site_url' => site_url(),
							) 
						); 	
	}
	
	public function PollCourseDynamicCSS(){
		global $post;
		$content_type=get_post_meta($post->ID,'content_type',true);
		if( is_page( 'create-poll' ) || $content_type=='poll') {
			include ( POLLCOURESEPATH . '/assets/css/pollcourse_css.php' );
		}
	} 
}