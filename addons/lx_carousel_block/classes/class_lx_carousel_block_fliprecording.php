<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class lx_fliprecording{
	function __construct() {
		/* Register Blocks. */
		add_action('init', array($this, 'lx_register_fliprecording_block'),10);
		add_action( 'enqueue_block_editor_assets', array( $this, 'lx_fliprecording_editor_assets' ),10 );
		if(isset($_GET['post'])){
			$post = get_post($_GET['post']); 
			if ( has_blocks( $post->post_content ) ) {
				$blocks = parse_blocks( $post->post_content );
				$blockname=array();
				foreach($blocks as $key=>$value){
					$blockname[]=$value['blockName'];
				}
				if (  in_array('lx-flip-recording-blocks/lx-block',$blockname) ) {
					add_action('admin_head',array( $this, 'lx_block_custom_css' ),10 );
				}
			}
		}
	}

	function lx_block_custom_css(){
		global $lx_carousel_block_urls,$lx_carousel_block_paths,$vw_flip_plugin_path,$lx_plugin_paths;
		include($lx_plugin_paths['lx_lms_lite'].'assets/css/lms_user_interface_settings.php');
		include($lx_carousel_block_paths.'assets/css/lx_carousel_block.php');
	}

	public function lx_fliprecording_editor_assets(){
		global $lx_carousel_block_urls,$lx_carousel_block_paths,$lx_plugin_urls,$kit_code;
		$lx_block_data = $this->lx_fliprecording_data();
		wp_enqueue_script(
		    'fliprecording_custom_block',
		    $lx_carousel_block_urls.'/assets/js/lx_carousel_block_fliprecording.js',
		    array('jquery', 'wp-blocks','wp-editor','wp-element')
		);
		wp_enqueue_script(
		    'custom_blocks1',
		   'https://kit.fontawesome.com/'.$kit_code.'.js'
		);
		wp_enqueue_style(
			'my-new-block1',
			'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css'
		);
		wp_enqueue_script( 'block_common_js', $lx_plugin_urls['lx_lms_lite'].'/assets/js/common.js');
		wp_enqueue_script( 'block_front_js', $lx_plugin_urls['lx_lms_lite'].'/assets/js/lx_lms_front.js'); 		
		wp_localize_script('fliprecording_custom_block','lx_flip_recording_obj', $lx_block_data);
	}

	public function lx_fliprecording_data(){
		$fliplist_info=array();
		if( function_exists('get_fliprecording_blockdata') ){
			$args=get_fliprecording_blockdata();
		}else{
			$args=array(
				'post_type'=>'flip_list',
				'posts_per_page'=>-1,
				'post_status'=>'publish',
				'meta_query' => array(
				    array(
				     'key' => 'display_in',
				     'value'=>'under_catgeory',
				    )
				)
			);
		}
		$fliplist=get_posts($args);
		if(!empty($fliplist)){
			foreach($fliplist as $list)
			{
				$fliplist_info[$list->ID]=$list->post_title;
			}
		}
		$arrayOfValues = array(
			'custom_block_title'=> __("Lx - Fl1p Recording Block"),
			'custom_block_desc'	=> __("Lx - Fl1p Recording Block Settings can be added here..."),
			'selection_content' => __("Fl1pList Selection"),
			'fliplist_info'=>$fliplist_info
		);
		return $arrayOfValues;
	}

	public function lx_register_fliprecording_block(){
		register_block_type('lx-flip-recording-blocks/lx-block', array(
		        'render_callback' => array($this,'lx_fliprecording_callback'),
		        'attributes' => array(
		        	'lx_fliprecording_selection' => array(
						'type' => 'string'
					)
		        )
	    	)
		);
	}

	public function lx_fliprecording_callback($attributes = array(), $content = ""){
		ob_start();
		if(empty($attributes['lx_fliprecording_selection'])){
			echo "<div class='selection_msg' style='display:none'>Please select Fl1plist to preview Fl1p Recording.</div>";
		}else{
			get_fliprecordings($attributes);
		}
		$op=ob_get_clean();
		return $op;
	}
}
if(function_exists( 'register_block_type' ))
new lx_fliprecording();