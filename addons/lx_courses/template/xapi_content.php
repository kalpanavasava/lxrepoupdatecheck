<?php 
/* function for view xapi content */
function xapi_content_vw($atts){
	global $learning_locker_setting;
	$a=shortcode_atts(
        array(
        	'lesson_id'=>'',
            'url' => '',
            'activity_id' => '',
            'mailto' => '',
            'open_in'=>','
        ), $atts );

	$activity_id=$a['activity_id'];
	if($a['mailto']!==''){
		$user_email=urlencode($a['mailto']);
		$user=get_user_by('email',$a['mailto']);
		$user_id=$user->ID;
	}else{
		$user_id=get_current_user_id();
		$user=get_user_by('id',$user_id);
		$user_email=urlencode($user->user_email);
	}
	$lesson_id=$a['lesson_id'];
	$status=get_user_meta($user_id,'lx_lesson_progress_'.$activity_id,true);
	freecourseenrolled( 0, $lesson_id, $user_id );
	?>

	<script>
    	var learning_locker = {'endpoint':"<?php echo $learning_locker_setting['end_point'];?>",'auth_key':"<?php echo $learning_locker_setting['auth_key'];?>",'auth_secret':"<?php echo $learning_locker_setting['auth_secret'];?>"}
	</script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
	<script src="<?php echo plugin_dir_url(dirname(__FILE__)).'js/xapijs/xapi.js';?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url(dirname(__FILE__)).'js/xapijs/xapiwrapper.js';?>"></script>

	<input type="hidden" id="activity_id" value="<?php echo $activity_id;?>">
	<input type="hidden" id="mailto" value="<?php echo $user_email;?>">
	<input type="hidden" id="vw_user_id" value="<?php echo $user_id;?>">
	<input type="hidden" class="vw_lesson_id" id="vw_lesson_id" value="<?php echo $a['lesson_id']; ?>"/>
	<input type="hidden" class="lesson_status<?php echo $a['lesson_id']; ?>" id="lesson_status" value="<?php echo $status;?>">
	<input type="hidden" id="open_in" value="<?php echo $a['open_in'];?>">
	
	<object data="<?php echo $a["url"];?>?actor={%22name%22:%22<?php echo $user_email;?>%22,%22mbox%22:%22mailto:<?php echo $user_email;?>%22,%22objectType%22:%22Activity%22}&auth=<?php echo $learning_locker_setting['basic_auth'];?>&endpoint=<?php echo $learning_locker_setting['end_point'];?>&activity_id=<?php echo $activity_id;?>" width="100%" type="text/html"></object>
	<?php /* <iframe width="100%" src="<?php echo $a["url"];?>?actor={%22name%22:%22<?php echo $user_email;?>%22,%22mbox%22:%22mailto:<?php echo $user_email;?>%22,%22objectType%22:%22Activity%22}&auth=<?php echo $learning_locker_setting['basic_auth'];?>&endpoint=<?php echo $learning_locker_setting['end_point'];?>&activity_id=<?php echo $activity_id;?>">
	</iframe> */ ?>
	<?php 
}
add_shortcode('vw_xapi_content','xapi_content_vw');