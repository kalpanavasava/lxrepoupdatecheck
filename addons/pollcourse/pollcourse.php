<?php
/**
	@Author: Voidek Webolution
	@Description: Poll Courses Addons
**/
global $lx_plugin_paths;
define('POLLCOURESEURL',plugin_dir_url(__FILE__));
define('POLLCOURESEPATH',plugin_dir_path(__FILE__));

include(POLLCOURESEPATH.'classes/class_pcassets.php');
$pollcourseObj=new ClassPCAssets();

include(POLLCOURESEPATH.'classes/class_pcajax.php');
$pollcourseAjax=new pollCourseAjax();

function create_poll_tables(){
	ob_start();
	global $wpdb;
	$table_name=$wpdb->prefix."vw_questions";
	/* if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
		$sql="CREATE TABLE ".$table_name." (question_id  int NOT NULL AUTO_INCREMENT,author_id int,post_id int,course_id int,name longtext,thumbnail longtext,allow_multiple int,text_entry_answer int,feedback_for_all int,date_updated date,date_created date,PRIMARY KEY ( question_id ))";
		$wpdb->query($sql);
	} */
	if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
		$sql="CREATE TABLE ".$table_name." (question_id  int NOT NULL AUTO_INCREMENT,author_id int,post_id int,course_id int,name longtext,thumbnail longtext,question_type int,question_type_meta int,feedback_for_all int,date_updated date,date_created date,PRIMARY KEY ( question_id ))";
		$wpdb->query($sql);
	}
	$table_name=$wpdb->prefix."vw_answers";
	if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
		$sql="CREATE TABLE ".$table_name." (answer_id int NOT NULL AUTO_INCREMENT,question_id int,answer longtext,feedback longtext,date_updated date,date_created date,PRIMARY KEY ( answer_id  ))";
		$wpdb->query($sql);
	}
	$table_name = $wpdb->prefix."vw_pollcourse_userdata";
	/* if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
		$sql="CREATE TABLE ".$table_name." (id int NOT NULL AUTO_INCREMENT,user_id int,post_id int,question_id longtext,answer_id longtext,text_answer longtext,status longtext,date_updated date,date_created date,PRIMARY KEY ( id  ))";
		$wpdb->query($sql);
	} */
	if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
		$sql="CREATE TABLE ".$table_name." (id int NOT NULL AUTO_INCREMENT,user_id int,post_id int,question_id longtext,answer_id longtext,text_answer longtext, additional_note text, upload_url text, status longtext,date_updated date,date_created date,PRIMARY KEY ( id  ))";
		$wpdb->query($sql);
	}
	
	$changeqtable = "ALTER TABLE ".$wpdb->prefix."vw_questions MODIFY COLUMN `name` longtext NULL DEFAULT NULL;";
	$changeqtable2 = "ALTER TABLE ".$wpdb->prefix."vw_questions MODIFY COLUMN `thumbnail` longtext NULL DEFAULT NULL;";
	$wpdb->query($changeqtable);
	$wpdb->query($changeqtable2);
	
	$ob=ob_get_clean();
	return $ob;
}
add_shortcode('poll_tables','create_poll_tables');

function create_poll_table_on_activation(){
	global $wpdb;
	$table_name=$wpdb->prefix."vw_questions";
	/* if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
		$sql="CREATE TABLE ".$table_name." (question_id  int NOT NULL AUTO_INCREMENT,author_id int,post_id int,course_id int,name longtext,thumbnail longtext,allow_multiple int,text_entry_answer int,feedback_for_all int,date_updated date,date_created date,PRIMARY KEY ( question_id ))";
		$wpdb->query($sql);
	} */
	
	if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
		$sql="CREATE TABLE ".$table_name." (question_id  int NOT NULL AUTO_INCREMENT,author_id int,post_id int,course_id int,question_required ENUM('1','0') default 1 NOT NULL,name longtext,thumbnail longtext,question_type int,question_type_meta int,feedback_for_all int,date_updated date,date_created date,PRIMARY KEY ( question_id ))";
		$wpdb->query($sql);
	}
	$table_name=$wpdb->prefix."vw_answers";
	if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
		$sql="CREATE TABLE ".$table_name." (answer_id int NOT NULL AUTO_INCREMENT,question_id int,answer longtext,feedback longtext,date_updated date,date_created date,PRIMARY KEY ( answer_id  ))";
		$wpdb->query($sql);
	}
	$table_name=$wpdb->prefix."vw_pollcourse_userdata";
	/* if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
		$sql="CREATE TABLE ".$table_name." (id int NOT NULL AUTO_INCREMENT,user_id int,post_id int,question_id longtext,answer_id longtext,text_answer longtext,status longtext,date_updated date,date_created date,PRIMARY KEY ( id  ))";
		$wpdb->query($sql);
	} */
	if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
		$sql="CREATE TABLE ".$table_name." (id int NOT NULL AUTO_INCREMENT,user_id int,post_id int,question_id longtext,answer_id longtext,text_answer longtext,additional_note text, upload_url text,status longtext,date_updated date,date_created date,PRIMARY KEY ( id  ))";
		$wpdb->query($sql);
	}
	$page=get_page_by_path( 'create-poll' );
    if(!$page){
        $poll_page=array(
            'post_title'    => 'Create Poll',
            'post_type'     => 'page',
            'post_content'  => '[pollcourse]',
            'post_status'   => 'publish'
        );
        wp_insert_post($poll_page);
    }
}
register_activation_hook($lx_plugin_paths['lx_lms_lite'].'learningx_lms_lite.php','create_poll_table_on_activation');