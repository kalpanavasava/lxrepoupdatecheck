<?php
/** 
	** @Forum For the Forum Page
	**/	
/* $full_urlwo_decode = explode('/',$_SERVER['REDIRECT_URL']);
$fullurl = site_url().'/'.base64_decode(end($full_urlwo_decode));
$exp_url = explode('/',$fullurl);
$user_id = end($exp_url);
$forum_id = $exp_url[count($exp_url)-2];
$string = end($full_urlwo_decode);

if(!empty($string)):
	if(strpos($_SERVER['REDIRECT_URL'],$string) !== false):

		add_action( 'init', 'add_forumk_rules' );
		function add_forumk_rules() {
			add_rewrite_rule($string.'/([^/]*)/?$', 'index.php?forum_id=$matches[1]&user_id=$matches[2]', 'top' );
			flush_rewrite_rules();
			add_filter( 'query_vars', function( $query_vars ) {
				$query_vars[] = 'forum_id';
				$query_vars[] = 'user_id';
				return $query_vars;
			});
			add_action( 'template_include', function( $template ) {
				return dirname(dirname(__FILE__)) . '/vw-flip-view/template/get_perticular_podcast.php';	
			});	
		}			

	endif;
endif; */



/** 
	** @Create-Forum For the Forum Create Page
	**/	
	
/* $edit_pc_id = $_POST['podcast_id'];
if(!empty($edit_pc_id)){}else{
	
	function rudr_url_redirects_frm() {
		$new = base64_encode('create-forum');
		$redirect_rules = array(
			array('old'=>'create-forum','new'=> $new)
		);
		foreach( $redirect_rules as $rule ) :
			if(strpos($_SERVER['REDIRECT_URL'],$rule['old']) !== false):
				wp_redirect( site_url( $rule['new'] ), 301 );
				exit();
			endif;
		endforeach;
	}
	 
	add_action('template_redirect', 'rudr_url_redirects_frm');

	function rudr_rewrite_request_frm($query){
		$new = base64_encode('create-forum');
		$request_uri = basename($_SERVER['REQUEST_URI']);
		if(strpos($_SERVER['REDIRECT_URL'],$new) !== false){
			$query['pagename'] = urlencode('create-forum');
			unset($query['name']);
		}
		return $query;
	}
	 
	add_filter( 'request', 'rudr_rewrite_request_frm', 9999, 1 );
} */
/* 
$flip_editid = $_POST['flip_id'];
if(!empty($flip_editid)){}else{
	
	function rudr_url_redirects_tpk() {
		$new = base64_encode('create-topic');
		$redirect_rules = array(
			array('old'=>'create-topic','new'=> $new)
		);
		foreach( $redirect_rules as $rule ) :
			if(strpos($_SERVER['REDIRECT_URL'],$rule['old']) !== false):
				wp_redirect( site_url( $rule['new'] ), 301 );
				exit();
			endif;
		endforeach;
	}
	 
	add_action('template_redirect', 'rudr_url_redirects_tpk');

	function rudr_rewrite_request_tpk($query){
		$new = base64_encode('create-topic');
		$request_uri = basename($_SERVER['REQUEST_URI']);
		if(strpos($_SERVER['REDIRECT_URL'],$new) !== false){
			$query['pagename'] = urlencode('create-topic');
			unset($query['name']);
		}
		return $query;
	}
	 
	add_filter( 'request', 'rudr_rewrite_request_tpk', 9999, 1 );
}	 */


/* function create_new_url_querystring()
{
    add_rewrite_tag($tagname, $regex, $query);
}
add_action('init', 'create_new_url_querystring');



function create_new_url_querystring()
{
    add_rewrite_rule(
        '^film-year/([^/]*)$',
        'index.php?film_year=$matches[1]',
        'top'
    );

    add_rewrite_tag('%film_year%','([^/]*)');
}
add_action('init', 'create_new_url_querystring'); */

session_start();

function rudr_url_redirects_page() {
	global $post;
	if(is_page($post->ID)){
		$full_urlwo_decode = explode('/',$_SERVER['REDIRECT_URL']);
		$fullurl = site_url().'/'.base64_encode($full_urlwo_decode[2].'?post_id='.$post->ID);
		
		$redirect_rules = array(
			array('old'=>$full_urlwo_decode[count($full_urlwo_decode)-2],'new'=>base64_encode($full_urlwo_decode[count($full_urlwo_decode)-2]))
		);
		
		add_option('vw_temp_base64_variable'.session_id(),$_POST);
		foreach( $redirect_rules as $rule ) :
			if( urldecode($_SERVER['REQUEST_URI']) == '/'.$full_urlwo_decode[1].'/'.$rule['old'].'/' ) :
					wp_redirect( $fullurl , 301 );
				exit();
			endif;
		endforeach;
		return ob_clean();
	}
}
add_action('template_redirect', 'rudr_url_redirects_page');

function wdm_add_rewrite_rules_page(){
	/* global $post;
	echo $post->ID; */
	
	$cut = '/'.explode('/',site_url())[3].'/';
	$url  = base64_decode(str_replace($cut,'',$_SERVER['REDIRECT_URL']));
	$page_name = trim(parse_url(urldecode($url))['path']);
	$query_sting = trim(parse_url(urldecode($url))['query']);
	parse_str($query_sting,$get_array);
	
	if(is_page($get_array['post_id'])){
		add_rewrite_rule( '^'.explode('/',$_SERVER['REDIRECT_URL'])[2].'([^/]+)/?$','index.php?'.$query_sting,'top');
	}
}
add_action('init','wdm_add_rewrite_rules_page');

global $wpdb;
$cut = '/'.explode('/',site_url())[3].'/';
$url  = base64_decode(str_replace($cut,'',$_SERVER['REDIRECT_URL']));
$page_name = trim(parse_url(urldecode($url))['path']);
$query_sting = trim(parse_url(urldecode($url))['query']);
parse_str($query_sting,$get_array);



$get_is_page  = $wpdb->get_results("select * from ".$wpdb->prefix."posts where ID='".$get_array['post_id']."'");


if( $get_is_page[0]->post_type == 'page' ){
/* echo "<pre>";print_r(get_option('vw_temp_base64_variable')); */
	add_action( 'template_include', function( $template ) {
		$_POST = get_option('vw_temp_base64_variable'.session_id());
		
		return  get_stylesheet_directory() . '/page_base64.php';
		
	});
	
}

/** only post type post **/
function rudr_url_redirects_post() {
	
	global $post;
	
	if($post->post_type == 'post'){
		
		$full_urlwo_decode = explode('/',$_SERVER['REDIRECT_URL']);
		$fullurl = site_url().'/'.base64_encode($full_urlwo_decode[2].'?post_id='.$post->ID);
		/* echo "<pre>";print_r($full_urlwo_decode);die(); */
		$redirect_rules = array(
			array('old'=>$full_urlwo_decode[count($full_urlwo_decode)-2],'new'=>base64_encode($full_urlwo_decode[count($full_urlwo_decode)-2]))
		);
		add_option('vw_temp_base64_variable'.session_id(),$_POST);
		foreach( $redirect_rules as $rule ) :
			if( urldecode($_SERVER['REQUEST_URI']) == '/'.$full_urlwo_decode[1].'/'.$rule['old'].'/' ) :
					wp_redirect( $fullurl , 301 );
				exit();
			endif;
		endforeach;
		return ob_clean();
	}
}
add_action('template_redirect', 'rudr_url_redirects_post');

function wdm_add_rewrite_rules_post(){
	global $post;
	echo $post->ID;
	$cut = '/'.explode('/',site_url())[3].'/';
	$url  = base64_decode(str_replace($cut,'',$_SERVER['REDIRECT_URL']));
	$page_name = trim(parse_url(urldecode($url))['path']);
	$query_sting = trim(parse_url(urldecode($url))['query']);
	parse_str($query_sting,$get_array);
	
	if($post->post_type == 'post'){
		add_rewrite_rule( '^'.explode('/',$_SERVER['REDIRECT_URL'])[2].'([^/]+)/?$','index.php?'.$query_sting,'top');
	}
}
add_action('init','wdm_add_rewrite_rules_post');

global $wpdb;
$cut = '/'.explode('/',site_url())[3].'/';
$url  = base64_decode(str_replace($cut,'',$_SERVER['REDIRECT_URL']));
$page_name = trim(parse_url(urldecode($url))['path']);
$query_sting = trim(parse_url(urldecode($url))['query']);
parse_str($query_sting,$get_array);
	
$get_is_page  = $wpdb->get_results("select * from ".$wpdb->prefix."posts where ID='".$get_array['post_id']."'");
 /* echo "<pre>";print_r($get_is_page);die(); */
if( $get_is_page[0]->post_type == 'post' ){
	add_action( 'template_include', function( $template ) {
		$_POST = get_option('vw_temp_base64_variable'.session_id());
		return  get_stylesheet_directory() . '/single_base64.php';
	});
}


/** only post type custom Post type **/

function rudr_url_redirects_custom_post() {
	global $post;
	
		$post_type_array = array('memberpressproduct');
		if(in_array($post->post_type, $post_type_array )){
			
			$folder_name = '/'.explode('/',site_url())[3].'/';
			
			
			$full_urlwo_decode = str_replace($folder_name,'',$_SERVER['REDIRECT_URL']);
			
			
			$fullurl = site_url().'/'.base64_encode($full_urlwo_decode.'?post_id='.$post->ID);
			
			
			$redirect_rules = array(
				array('old'=>$full_urlwo_decode,'new'=>base64_encode($full_urlwo_decode))
			);
			
			foreach( $redirect_rules as $rule ) :
			/* echo "<pre>";print_r($rule['old']);
			echo "<pre>";print_r($full_urlwo_decode);
			die(); */
				if( $rule['old'] == $full_urlwo_decode ) :
						wp_redirect( $fullurl , 301 );
					exit();
				endif;
			endforeach;
			return ob_clean();
		}
	
}
add_action('template_redirect', 'rudr_url_redirects_custom_post');

function wdm_add_rewrite_rules_custom_post(){
	$cut = '/'.explode('/',site_url())[3].'/';
	$url  = base64_decode(str_replace($cut,'',$_SERVER['REDIRECT_URL']));
	$page_name = trim(parse_url(urldecode($url))['path']);
	$query_sting = trim(parse_url(urldecode($url))['query']);
	parse_str($query_sting,$get_array);
	
	
	$post_type_array = array('memberpressproduct');
	if(in_array($post->post_type, $post_type_array )){
		add_rewrite_rule( '^'.explode('/',$_SERVER['REDIRECT_URL'])[2].'([^/]+)/?$','index.php?'.$query_sting,'top');
	}
}
add_action('init','wdm_add_rewrite_rules_custom_post');

global $wpdb;
$cut = '/'.explode('/',site_url())[3].'/';
$url  = base64_decode(str_replace($cut,'',$_SERVER['REDIRECT_URL']));
$page_name = trim(parse_url(urldecode($url))['path']);
$query_sting = trim(parse_url(urldecode($url))['query']);
parse_str($query_sting,$get_array);
	
$get_is_page  = $wpdb->get_results("select * from ".$wpdb->prefix."posts where ID='".$get_array['post_id']."'");

$post_type_array = array('memberpressproduct');
/* if( $get_is_page[0]->post_type == $cus_post_type ){ */
if(in_array($get_is_page[0]->post_type, $post_type_array )){
	global $cus_pos_type;
	$cus_pos_type = $get_is_page[0]->post_type;
	
	add_action( 'template_include', function( $template ) {
		global $cus_pos_type;
		return  get_stylesheet_directory() . '/single-'.$cus_pos_type.'.php';
	});
}
