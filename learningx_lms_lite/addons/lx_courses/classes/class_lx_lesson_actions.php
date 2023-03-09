<?php
class lx_lesson_actions{
	public function __construct() {
		add_action("wp_ajax_vw_fn_ajax_lesson_mark_ascomplete", array($this,"vw_fn_ajax_lesson_mark_ascomplete"));
		add_action( 'wp_ajax_nopriv_vw_fn_ajax_lesson_mark_ascomplete', array($this,'vw_fn_ajax_lesson_mark_ascomplete'));
		
		add_action("wp_ajax_vw_fn_loadpollmodal", array($this,"vw_fn_loadpollmodal"));
		add_action( 'wp_ajax_nopriv_vw_fn_loadpollmodal', array($this,'vw_fn_loadpollmodal'));
    }
	/** function for lession completion **/
	public function vw_fn_ajax_lesson_mark_ascomplete(){
		$lesson_id = $_POST['lession_id'];
		$user_id=get_current_user_id();
		update_user_meta($user_id,'lx_lesson_progress_'.$lesson_id,'completed');
		echo 'Completed';
		wp_die();
	}
	public function vw_fn_loadpollmodal(){
		$post_id=$_POST['lesson_id'];
		$user_id = get_current_user_id();
		update_user_meta(get_current_user_id(),'lesson_last_accessed_'.$post_id,time());
		$status = get_user_meta($user_id,'lx_lesson_progress_'.$post_id,true);
		
		if( $status=='' && $status != 'in_progress'){
			update_user_meta($user_id,'lx_lesson_progress_'.$post_id,'in_progress');
			update_user_meta($user_id,'lx_lesson_progress_date_'.$post_id,array('start_timestamp'=>time()));
		}
		
		wp_die();
	}
}