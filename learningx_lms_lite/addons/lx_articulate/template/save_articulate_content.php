 <?php if(is_user_logged_in() && (is_super_admin() || current_user_can('site_owner') || current_user_can('community_owner') || current_user_can('community_manager'))){ ?>
 <style>
.main-navigation{
	display: none;
}
.loggedin_logo{
	display: none;
}
.site-info{
	display:none;
}
</style>
<?php
	
		global $wpdb,$square_icon;
		$user_id=get_current_user_id();
		/**check articulate web content temp post exists or not**/
		$temp_articulate_content=$wpdb->get_results("select * from ".$wpdb->prefix."posts where post_title='temp-articulate-content' and  post_author='".$user_id."'");
		/**if articulate web content temp post not exists**/
		if(empty($temp_articulate_content))
		{
			$arr=array(
				'post_title'=>'temp-articulate-content',
				'post_status'=>'draft',
				'post_type'=>'lx_articulate',
				'post_author'=>$user_id
			);
			$articulate_id=wp_insert_post($arr);
		} 
		$term_ids=array();
		/**check articulate web content status add or update**/
		if(isset($_POST['articulate_id'])){
			$articulate_id=$_POST['articulate_id'];
			$mode_info = 'edit_articulate';
			$status = 'edit';
		}else{
			$mode_info = 'add_articulate';
			$status = 'add';
		}
		$content_id=isset($articulate_id)?$articulate_id:$temp_articulate_content[0]->ID;
		$args = array('articulate_id'=>$articulate_id,'status'=>$status,'content_id'=>$content_id,'mode_info'=>$mode_info);
		$formid = 'lx_articulate_form';
		/**call functions for articulate web content Canvas**/
		articulate_top_ui($_POST['articulate_id'],$formid,$mode_info);
		articulate_web_thumb_ui($args);
		articulate_content_category_info($args);
		articulate_title_and_other_ui($args);
		articulate_bottom_ui();
		articulate_script_main();
		crop_img_articulate_web_and_popover();
	}else{
		echo "<div style='width:100%;color:#ff0000;text-align:center;padding:20px;'>You Don't have Access to this page.</div>";
	}	
?>