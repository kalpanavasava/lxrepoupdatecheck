<?php
/**
	@Author: Voidek Webolution
	@Description: Fl1p
**/

define('FL1PURL',plugin_dir_url(__FILE__));
define('FL1PPATH',plugin_dir_path(__FILE__));

/** Include Template Files Here **/
include FL1PPATH . '/templates/create_fliplist.php' ;
include FL1PPATH . '/templates/create_flip_recording.php' ;
include FL1PPATH . '/functions/functions.php' ;

/** PWA **/
function FlipPwaShortcode(){
	ob_start();
	if(!is_user_logged_in()){
		echo "<div class='text-center'>Please login to access the app.</div>";
		return false;
	}
	include FL1PPATH . '/PWA/index.php';
	return ob_get_clean();
}
add_shortcode( 'pwa-fl1plist' , 'FlipPwaShortcode' );
function FliprecPwaShortcode(){
	ob_start();
	if(!is_user_logged_in()){
		echo "<div class='text-center'>Please login to access the app.</div>";
		return false;
	}
	include FL1PPATH . '/PWA/templates/add_new_recording.php';
	return ob_get_clean();
}
add_shortcode( 'pwa-fl1precording' , 'FliprecPwaShortcode' );

function FliprecViewPwaShortcode(){
	ob_start();
	if(!is_user_logged_in()){
		echo "<div class='text-center'>Please login to access the app.</div>";
		return false;
	}
	include FL1PPATH . '/PWA/templates/recordingview.php';
	return ob_get_clean();
}
add_shortcode( 'pwa-fl1precview' , 'FliprecViewPwaShortcode' );

function PWAloginextend() {
	global $lx_plugin_urls;
	?>
	<script src='<?php echo $lx_plugin_urls['lx_lms_lite'] . 'addons/flip/PWA/js/idb.js'?>' ></script>
	<script>
	if( navigator.onLine == true ){
		addEventListener('load', (event) => {
			var dbPromise = idb.open('learningxpwadb',1,function( db ){ 
				db.createObjectStore('fliprecording',{keyPath:'id'});
				db.createObjectStore('recording_active',{keyPath:'id'});
				db.createObjectStore('loginsession',{keyPath:'id'});
			});
			dbPromise.then(function(db) {
				var today = new Date();
				var dd = String(today.getDate()).padStart(2, '0');
				var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
				var yyyy = today.getFullYear();
				date = mm + '/' + dd + '/' + yyyy;
				var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
				var datas = {
					'id':1,
					'LastLoginDateTimeStemp' :today,
					'lastlogindate':date,
					'lastlogintime':time,
					'sessionstatus':'continue'
				};
				var tx = db.transaction('loginsession', 'readwrite');
				var store = tx.objectStore('loginsession');
				store.put(datas);
				
				return tx.complete;
			});
		});
	}
	</script>
	<?php
}
add_action('wp_head', 'PWAloginextend');

include FL1PPATH. 'PWA/ajax/ajax.php';
/** End PWA **/

/** Include Class Files Here **/
include FL1PPATH. 'classes/class_flip_assets.php';
$flip_obj = new ClassFlipAssets();

include FL1PPATH. 'classes/class_flip_ajax.php';
$flip_ajax = new ClassFlipAjax();


add_filter( 'single_template', 'FnFlipRecording' );
function FnFlipRecording( $template ){
	global $post;
	if ($post->post_type == 'flip_recording' ) {
		$template = dirname(dirname(__FILE__)) . '/flip/templates/flipview.php';
	}
	return $template;
}
add_filter( 'manage_flip_list_posts_columns', 'FNAddSubtitletoFliplistCPT' );
function FNAddSubtitletoFliplistCPT($columns) {
	$mepr_access = $columns['mepr-access'];
	$categories = $columns['categories'];
	$date = $columns['date'];
	unset($columns['mepr-access']);
	unset($columns['categories']);
	unset($columns['date']);
    $columns['subtitle'] = "Subtitle";
    $columns['categories'] = $categories;
    $columns['date'] = $date;
	?>
	<style>
	.column-mepr-access{
		display:none;
	}
	</style>
	<?php
    return $columns;
}

add_action( 'manage_flip_list_posts_custom_column' , 'custom_book_column', 10, 2 );
function custom_book_column( $column, $post_id ) {
    switch ( $column ) {
        case 'subtitle' :
		$authorid = get_post( $post_id )->post_author;
		$subtitle = get_post_meta($post_id,'fliplist_subtitle',true);
		if( empty( $subtitle ) ){
			$subtitle = get_user_meta( $authorid ,'first_name',true ).' '.get_user_meta( $authorid ,'last_name',true );
			if( empty(trim( $subtitle )) ){
				$subtitle = get_user_by( 'id',$authorid )->user_nicename;
			}
		}
		echo $subtitle;
		
		break;
    }
}

add_action( 'wp_head', 'register_swx' );
function register_swx() {
	global $wp_scripts,$wp_styles;
	if ( function_exists( 'wp_register_service_worker' ) ) {
		return;
	}
	if( !is_user_logged_in() ){
		return;
	}
	/* $start_url = get_post_meta(); */
	$json_array = array(
		'name' => 'LearningX',
		'short_name' => 'LX',
		'icons' => array(
			array(
				'src' => get_site_icon_url(),
				'type' => "image/png",
				'sizes' => "48x48",
			),
			array(
				'src' => get_site_icon_url(),
				'type' => "image/png",
				'sizes' => "96x96",
			),
			array(
				'src' => get_site_icon_url(),
				'type' => "image/png",
				'sizes' => "144x144",
			)
		),
		'start_url' => site_url() . '/pwa-fl1plist/',
		'scope' => '.',
		'display' => 'standalone',
		'orientation' => 'portrait',
		'background_color' => '#fff',
		'theme_color' => '#3f51b5',
		'description' => 'My Fliplist Recording PWA',
		'dir' => 'ltr',
		'lang' => 'en-US',
	);
	
	file_put_contents(dirname(__FILE__) . '/PWA/manifest.json', json_encode( $json_array , JSON_PRETTY_PRINT ));
	
	$all_assets = array();
	foreach( $wp_styles->registered as $datacss ){
		$text = '';
		if(!empty($datacss->ver)){
			$text = '?ver='.$datacss->ver;
		}
		$all_assets[] = $datacss->src.$text;
	}
	
	foreach( $wp_scripts->registered as $datajs ){
		$text = '';
		if(!empty($datajs->ver)){
			$text = '?ver='.$datajs->ver;
		}
		$all_assets[] = $datajs->src.$text;
	}
	$all_assets[] = site_url() . '/pwa-fl1plist/';
	$all_assets[] = site_url() . '/pwa-fl1precording/';
	
	$home_url       = trailingslashit( get_site_url() );
	$home_url_parts = parse_url( $home_url );
	$path           = '/';
	if ( array_key_exists( 'path', $home_url_parts ) ) {
		$path = $home_url_parts['path'];
	}
	/* echo "<pre>";print_r(get_sw_urlx()); */
	/* echo "<pre>";print_r($path); */
	/* echo get_sw_urlx();
	die(); */
	$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
	/* if(!empty($iPad)){ */
	?>
	<link rel="manifest" id="MyFlipRecordingManifestId" href="<?php echo FL1PURL; ?>PWA/manifest.json">
	<?php /* } */ ?>
	<script type="text/javascript" id="serviceworker">
		if (navigator.serviceWorker) {
			navigator.serviceWorker.getRegistrations().then(function(registrations) {
				for(let registration of registrations) {
					registration.unregister()
				} 
			})
			
			window.addEventListener('load', function () {
				navigator.serviceWorker.register(
					"<?php echo site_url() . '/sw.js' ; ?>"
				);
			});
		}
	</script>
	<?php
}
function wp_add_service_worker_query_varx( $query_vars ) {
		if ( function_exists( 'wp_register_service_worker' ) ) {
			return $query_vars;
		}
		$query_vars[] = 'wp_service_worker';

		return $query_vars;
	}
function get_sw_urlx( $encoded = true ) {
	$url = add_query_arg( [
		'wp_service_worker' => 1,
	], home_url( '/', 'https' ) );

	if ( $encoded ) {
		return wp_json_encode( $url );
	}

	return $url;
}
?>