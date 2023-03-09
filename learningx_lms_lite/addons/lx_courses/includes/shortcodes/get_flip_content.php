<?php
function get_flip_content($atts){
	ob_start();
	$arg = shortcode_atts( array(
		'forum_id' => '',
		'topic_id'=> ''
	), $atts );
	$current_user=wp_get_current_user();
    $uemail=$current_user->user_email;
    if (strpos($uemail, '+') !== false) {
        $email=str_replace('+','%2B',$uemail);
    }
    else{
        $email=$uemail;
    }
    ?>
    <link rel='stylesheet' id='dzsap-css'  href='<?php echo plugins_url().'/dzs-zoomsounds/audioplayer/audioplayer.css?ver=5.78';?>' type='text/css' media='all' />
    <script type='text/javascript' src='<?php echo plugins_url().'/dzs-zoomsounds/audioplayer/audioplayer.js?ver=5.78';?>'></script>
    <div class="lp-screen" style="display:none;"><span><img src="<?php echo get_stylesheet_directory_uri().'/assets/loader/05.svg'?>"></div>
    <?php
	 echo '<div class="flip_content" data-podcast_id="'.$arg['forum_id'].'"><input type="hidden" id="hid_flip_id" value="'.$arg['topic_id'].'"><div class="play_load_here"></div></div>';
    $is_logged_in = '';
    if(is_user_logged_in() == 'true'){
        $is_logged_in .= 'loggedin';
    }else{
        $is_logged_in .= 'loggedin_not';
    }
    ?>
    <script>
        var my_ajax = {'ajax_object':"<?php echo admin_url( 'admin-ajax.php' );?>"}
        var user_logged_in = {'login':"<?php echo $is_logged_in;?>"}
    </script>
    <?php
    ?>
    <?php  

  	return ob_get_clean();
}
add_shortcode('fl1p_content','get_flip_content');
?>