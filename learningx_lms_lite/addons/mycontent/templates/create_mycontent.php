<?php
function MyContentPageLite(){
	ob_start();
	if(is_user_logged_in()){
		EnrolledCoursesUI();
		AdditionalResources();
		CoursesContentUI();
		Fl1plistsContentUI();
		Fl1pRecordingContentUI();
	}else{?>
		<div class="login_error">Please login to access My Content.</div>
	<?php	
	}
	$ob = ob_get_clean();
	return $ob;
}
add_shortcode('mycontent','MyContentPageLite',20);
