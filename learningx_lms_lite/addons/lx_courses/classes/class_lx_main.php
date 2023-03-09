<?php
class lx_main{
	public function __construct() {
		/** include the lesson actions **/
		include( dirname(__FILE__).'/class_lx_lesson_actions.php' );
		$lx_lesson_actions_var = new lx_lesson_actions();
		$this->xapi_content_vw();
    }
	public function xapi_content_vw(){
		include( dirname(dirname(__FILE__)).'/template/xapi_content.php' );
	}
}