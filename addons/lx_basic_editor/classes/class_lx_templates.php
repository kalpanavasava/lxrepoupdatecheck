<?php
class lx_cl_templates{
	
	public $lx_var_upload_medias3_temp_path;
	
	public function __construct() {
		add_shortcode('lx_create_blog_posts', array($this,'fn_lx_create_blog_posts'));
		add_shortcode('lx_my_content', array($this,'fn_lx_my_template'));
		add_shortcode('home_page', array($this,'display_home_page') );
    }
	 
	public function fn_lx_create_blog_posts(){
		ob_start();
		?>
		<style>
			.main-navigation{
				display: none;
			}
			.loggedin_logo{
				display: none;
			}
		</style>
		<?php
		$vw_var_get_all_categories = $this->vw_var_get_all_categories->vw_fn_lx_get_all_categories();
		$vw_var_get_all_publib_categories = $this->vw_var_get_all_categories->vw_fn_lx_get_publib_cat();
		if(is_super_admin() || current_user_can('site_owner') || current_user_can('community_blog_author') ){
			if( !empty( $_POST['mode'] ) && $_POST['mode'] == 'edit' ){
				require ( dirname( dirname( __FILE__ ) ) . '/template/edit_blog_post.php');
			}else{
				global $wpdb;
				$current_user_id=get_current_user_id();
				$temp_post=$wpdb->get_results("select * from ".$wpdb->prefix."posts where post_title='temp_blog_post' and post_author='".$current_user_id."'");
				if(empty($temp_post))
				{
					$arr=array(
						'post_title' => 'temp_blog_post',
						'post_type' => 'post',
						'post_status' => 'draft',
						'post_author' => $current_user_id
					);
					$inserted_id=wp_insert_post($arr);
				}
				$blog_post_id=isset($inserted_id)?$inserted_id:$temp_post[0]->ID;
				require ( dirname( dirname( __FILE__ ) ) . '/template/add_new_blog_post.php');
			}
		}else{
			echo "<div style='color:red;text-align:center;padding-top: 50px;'>You don't have access to this page.</div>";
		}
		$op = ob_get_clean();
		return $op;
	}
	public function fn_lx_my_template(){
		ob_start();
		$vw_var_get_all_categories = $this->vw_var_get_all_categories->vw_fn_lx_get_all_categories();
		$vw_var_get_all_publib_categories = $this->vw_var_get_all_categories->vw_fn_lx_get_publib_cat();
		require ( dirname( dirname( __FILE__ ) ) . '/template/my_content.php');
		$op = ob_get_clean();
		return $op;
	}
	public function display_home_page(){
		ob_start();
		$op = ob_get_clean();
		require ( dirname( dirname( __FILE__ ) ) . '/template/homepage.php');
		return $op;
	}
}