<?php
function print_f($text){
	echo "<pre>";print_r($text);echo "</pre>";
}

$site_url = explode( '/' , site_url() )[3];
if(empty($site_url)){
	$site_url = site_url();
}
$base_url='';
if(isset($_SERVER['REDIRECT_URL'] )){
	$base_url = ltrim( chop( str_replace( $site_url.'/' , '' , $_SERVER['REDIRECT_URL'] ) , '/' ) , '/' );
}
if(isset($_SERVER['REQUEST_URI'] )){
	$base_url = ltrim( chop( str_replace( $site_url.'/' , '' , $_SERVER['REQUEST_URI'] ) , '/' ) , '/' );
}

$url  = base64_decode( $base_url );
/* print_f($site_url); */
if(empty($_POST) && !empty($url)){
	$query_sting = trim(parse_url(urldecode($url))['query']);

parse_str($query_sting,$get_array);
}else{
	$get_array['post_id'] ='';
}	
if(!empty( $get_array['post_id'] )){
	add_action('init', 'custom_rewrite_rule', 10, 0);
}else{
	add_filter( 'template_redirect', 'rudr_url_redirects_page' );	
}	


function rudr_url_redirects_page() {
	global $post;
	$settings = get_option('base64_encode_setting',true);
	/* print_f($settings);
	die(); */
	$site_url = explode( '/' , site_url() )[3];
	if(empty($site_url)){
		$site_url = site_url();
	}
	
	if ( is_front_page() ){}else{
		/** if have post then ignore **/
		if( !empty( $_POST ) ){}else{
			if( $post->post_type == 'page' && $settings['page'] == 'ON'){
				if(!empty($_SERVER['REDIRECT_URL'])){
					$base_url = ltrim( chop( str_replace( $site_url.'/' , '' , $_SERVER['REDIRECT_URL'] ) , '/' ) , '/' );
				}else{
					$base_url = ltrim( chop( str_replace( $site_url.'/' , '' , $_SERVER['REQUEST_URI'] ) , '/' ) , '/' );
				}
				$fullurl = site_url().'/'.base64_encode($base_url.'?post_id='.$post->ID);
				wp_redirect( $fullurl , 301 );
				
				exit();
			}elseif( $post->post_type == 'post'  && $settings['post'] == 'ON' ){
				if(!empty($_SERVER['REDIRECT_URL'])){
					$base_url = ltrim( chop( str_replace( $site_url.'/' , '' , $_SERVER['REDIRECT_URL'] ) , '/' ) , '/' );
				}else{
					$base_url = ltrim( chop( str_replace( $site_url.'/' , '' , $_SERVER['REQUEST_URI'] ) , '/' ) , '/' );
				}
				$fullurl = site_url().'/'.base64_encode($base_url.'?post_id='.$post->ID);
				wp_redirect( $fullurl , 301 );
				
				exit();
			}else{
				
				$custom_posttype = $settings['custom_post_type'];
				if(!empty($custom_posttype)){
					
					foreach( $custom_posttype as $custom_posttypes){
						if($custom_posttypes == $post->post_type){
							
							if(!empty($_SERVER['REDIRECT_URL'])){
								$base_url = ltrim( chop( str_replace( $site_url.'/' , '' , $_SERVER['REDIRECT_URL'] ) , '/' ) , '/' );
							}else{
								$base_url = ltrim( chop( str_replace( $site_url.'/' , '' , $_SERVER['REQUEST_URI'] ) , '/' ) , '/' );
							}
							
							
							$fullurl = site_url().'/'.base64_encode($base_url.'?post_id='.$post->ID);
							
							wp_redirect( $fullurl , 301 );
							
							exit();
						}
					}
				}
			}
		}
	}
}

function custom_rewrite_rule() {
	
	global $wpdb;
	$settings = get_option('base64_encode_setting',true);
	
	if ( is_front_page() ){}else{
	
	
	/** get the base64 url **/
	$site_url = explode( '/' , site_url() )[3];
	if(empty($site_url)){
		$site_url = site_url();
	}
	if(!empty($_SERVER['REDIRECT_URL'])){
		$base_url = ltrim( chop( str_replace( $site_url.'/' , '' , $_SERVER['REDIRECT_URL'] ) , '/' ) , '/' );
	}else{
		$base_url = ltrim( chop( str_replace( $site_url.'/' , '' , $_SERVER['REQUEST_URI'] ) , '/' ) , '/' );
	}
	
	/**  get the post id  **/
	$cut = '/'.explode('/',site_url())[3].'/';
	$url  = base64_decode($base_url);
	$query_sting = trim(parse_url(urldecode($url))['query']);
	parse_str($query_sting,$get_array);
	
	/** first check if it is a page or the post or the custom post type **/
	$get_is_page  = $wpdb->get_results("select * from ".$wpdb->prefix."posts where ID='".$get_array['post_id']."'");
	
	
	
	if( $get_is_page[0]->post_type == 'page' && $settings['page'] == 'ON'){
		// for page 
		add_rewrite_rule('^'.$base_url.'/?','index.php?page_id='.$get_array['post_id'] ,'top');
	}elseif( $get_is_page[0]->post_type == 'post' && $settings['post'] == 'ON'){
		// for post
		add_rewrite_rule('^'.$base_url.'/?','index.php?p='.$get_array['post_id'] ,'top');
	}else{
		// for custom post post
		
		$custom_posttype = $settings['custom_post_type'];
		
		foreach( $custom_posttype as $custom_posttypes){
			if($custom_posttypes == $get_is_page[0]->post_type){
				add_rewrite_rule('^'.$base_url.'/?', 'index.php?p='.$get_is_page[0]->ID.'&post_type='.$get_is_page[0]->post_type, 'top');
			}
		}
	}
	
	flush_rewrite_rules();
	}
}

/* add_filter( 'query_vars', function( $query_vars ) {
    $query_vars[] = 'myparamname';
	print_f( $query_vars );
    return $query_vars;
} ); */		
	
