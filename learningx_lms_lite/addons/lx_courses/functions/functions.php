<?php
/** function for add xapi content **/
function add_version($post_id, $params) {
	$xapi_content = get_post_meta( $post_id, 'xapi_content', true );
	if($xapi_content == $params)
		return;

	$version_no = get_post_meta( $post_id, 'xapi_content_version_no', true );
	$version_no = empty($version_no)? 1:intVal($version_no + 1);
	$params["version_no"] 	= $version_no;
	$params["timestamp"]	= time();
	update_post_meta( $post_id, 'xapi_content_version_no', $version_no );
	add_post_meta( $post_id, 'xapi_content_versions', $params );
}
/** function for get xapi content size **/
function get_size($path)
{
	if(is_file($path))
		return filesize($path);

    $size = 0;
    foreach( glob(rtrim($path, '/').'/*', GLOB_NOSORT) as $each ) {
        $size += is_file($each) ? filesize($each) : get_size($each);
    }
    return $size;
}
/** function for get tools for xapi content **/
function tool( $content_data ) {

	if(!empty($content_data["content_tool"]))
		return $content_data["content_tool"];

	if(empty($content_data["content_path"]))
		return '';

	if(file_exists($content_data["content_path"]."/res/lms.js"))
		return "ispring";
	else if(file_exists($content_data["content_path"]."/lib/main.bundle.js") || file_exists($content_data["content_path"]."/scormcontent/lib/main.bundle.js"))
		return 'articulate_rise';
	else if(file_exists($content_data["content_path"]."/story.html"))
		return 'articulate_storyline';
	else if(file_exists($content_data["content_path"]."/presentation_content/presentation.js"))
		return 'articulate_presenter';
	else if(file_exists($content_data["content_path"]."/assets/js/CPM.js"))
		return 'captivate';
	else if(file_exists($content_data["content_path"]."/launch.html") && strpos(file_get_contents($content_data["content_path"]."/launch.html"), "learning.elucidat"))
		return 'elucidat';
	else
		return '';
}
/** function for set param for xapi content **/
function set_params($post_id, $params) {

	if(!empty($params["passing_percentage"]))
		$params["passing_percentage"] = number_format(floatval($params["passing_percentage"]), 2);

	$params["content_size"] = empty($params["content_path"])? "":get_size($params["content_path"]);
	$params = apply_filters("xapi_content_params_update", $params, $post_id);

	if(empty($params["content_tool"]))
		$params["content_tool"] = tool( $params );

	if(!empty($params["title"]))
	{
		global $wpdb;
		$wpdb->update($wpdb->posts, array("post_title" => strip_tags( $params["title"] )), array("ID" => $post_id, "post_title" => ""));
	}
	if(!empty($params["description"]))
	{
		global $wpdb;
		if(is_admin() && !empty($_GET["page"]) && $_GET["page"] == "grassblade-bulk-import")
		$wpdb->update($wpdb->posts, array("post_content" => wp_kses_post( $params["description"] )), array("ID" => $post_id, "post_content" => ""));

		unset($params["description"]);
	}

	add_version($post_id, $params);
	update_post_meta( $post_id, 'xapi_content', $params);

	if(isset($params['activity_id']))
		update_post_meta( $post_id, 'xapi_activity_id', $params['activity_id']);
}
/** function for get param for xapi content **/
function get_params($post_id) {
	$xapi_content = (array) get_post_meta( $post_id, 'xapi_content', true);

	if(!isset($xapi_content['version'])) {  //For Version older than V0.5
		$xapi_content['version'] = get_post_meta( $post_id, 'xapi_version', true);
		if(!empty($xapi_content['notxapi'])) {
			$xapi_content['version'] = "none";
			unset($xapi_content['notxapi']);
			set_params( $post_id, $xapi_content);
		}
	}
	if(isset($xapi_content['launch_url'])) {
		$xapi_content['src'] = $xapi_content['launch_url'];
		unset($xapi_content['launch_url']);
		set_params( $post_id, $xapi_content);
	}
	$xapi_content['activity_id'] = isset($xapi_content['activity_id'])? $xapi_content['activity_id']:"";

	return $xapi_content;
}
function lx_file_exists($file) {
	$file = explode("?", $file);
	return file_exists($file[0]);
}
function get_tincanxml($dir) {
	$tincanxml_file = $dir.DIRECTORY_SEPARATOR."tincan.xml";
	
	if(file_exists($tincanxml_file))
		return "";
	else
	{
		$dirlist = scandir($dir);
		foreach($dirlist as $d)
		{
			if($d != "." && $d != "..")
			{
				$tincanxml_file = $dir.DIRECTORY_SEPARATOR.$d.DIRECTORY_SEPARATOR."tincan.xml";
				if(file_exists($tincanxml_file))
					return $d;
			}
		}
	}
	return 0;
}
/** function for upload xapi content **/
function process_xapi_upload($params, $post , $upload) {

	if(!empty($params["response"]) && $params["response"] == "error")
		return $params;
	
	if (empty($params['process_status']) && isset($upload['content_path']) && is_dir($upload["content_path"])) {
		$tincanxml_subdir =get_tincanxml($upload['content_path']);

		if(empty($tincanxml_subdir))
		$tincanxml_file = $upload['content_path'].DIRECTORY_SEPARATOR."tincan.xml";
		else
		$tincanxml_file = $upload['content_path'].DIRECTORY_SEPARATOR.$tincanxml_subdir.DIRECTORY_SEPARATOR."tincan.xml";

		$nonxapi_file = $upload['content_path'].DIRECTORY_SEPARATOR."player.html";  /* Check if No tincan.xml Articulate Studio File */
		$nonxapi_file2 = $upload['content_path'].DIRECTORY_SEPARATOR."story.html"; /* Check if No tincan.xml Articulate Storyline File */
		$nonxapi_file3 = $upload['content_path'].DIRECTORY_SEPARATOR."index.html"; /* Check if No tincan.xml Captivate File */
		$nonxapi_file4 = $upload['content_path'].DIRECTORY_SEPARATOR."presentation.html"; /* Check if No tincan.xml Articulate Studio 13 File */
		$nonxapi_file5 = $upload['content_path'].DIRECTORY_SEPARATOR."content".DIRECTORY_SEPARATOR."index.html"; /* Check if No tincan.xml Articulate Rise File */
		
		if(file_exists($tincanxml_file))
		{
			$tincanxmlstring = trim(file_get_contents($tincanxml_file));
			$tincanxml = simplexml_load_string($tincanxmlstring);
			if(!empty($tincanxml->activities->activity->launch))
			{
				$launch_file = (string)  $tincanxml->activities->activity->launch;
				if(empty($post->post_title)) {
					$content_name = (string)  $tincanxml->activities->activity->name;
					if(!empty($content_name))
					{
						$upload["title"] = $content_name;
					}
				}
				$upload['original_activity_id'] = isset($tincanxml->activities->activity['id'])? (string) $tincanxml->activities->activity['id']:"";
				if(empty($upload['activity_id']))
				$upload['activity_id'] = (string) $upload['original_activity_id'];

			}
			else
				return array("response" => 'error', "info" => "XML Error:  Launch file reference not found in tincan.xml");
			
			$upload['launch_path'] = dirname($tincanxml_file).DIRECTORY_SEPARATOR.$launch_file;
			
			if(empty($tincanxml_subdir))
			$upload['src'] =  $upload['content_url']."/".$launch_file;
			else
			$upload['src'] =  $upload['content_url']."/".$tincanxml_subdir."/".$launch_file;
			if(!lx_file_exists($upload['launch_path']))
				return array("response" => 'error', "info" => 'Error: <i>'.$upload['launch_path'].'</i>. Launch file not found in tincan package');
			
			if(isset($upload['version']) && $upload['version'] == "none")
			$upload['version'] = "";

			$upload["content_type"] = "xapi";
			$upload['process_status'] = 1;
		}
		else if(file_exists($nonxapi_file)) /* Articulate Studio  Non-TinCan Support */
		{
			$upload['src'] =  $upload['content_url']."/player.html";
			$upload['launch_path'] =  dirname($nonxapi_file).DIRECTORY_SEPARATOR."player.html";
			$upload['version'] = "none";
			$upload['process_status'] = 1;
			$upload["content_type"] = "not_xapi";
		}
		else if(file_exists($nonxapi_file2)) /* Articulate Storyline Non-TinCan Support */
		{
			$upload['src'] =  $upload['content_url']."/story.html";
			$upload['launch_path'] =  dirname($nonxapi_file2).DIRECTORY_SEPARATOR."story.html";
			$upload['version'] = "none";
			$upload['process_status'] = 1;
			$upload["content_type"] = "not_xapi";
		}
		else if(file_exists($nonxapi_file3)) /* Captivate Non-TinCan Support */
		{
			$upload['src'] =  $upload['content_url']."/index.html";
			$upload['launch_path'] =  dirname($nonxapi_file3).DIRECTORY_SEPARATOR."index.html";
			$upload['version'] = "none";
			$upload['process_status'] = 1;
			$upload["content_type"] = "not_xapi";
		}
        else if(file_exists($nonxapi_file4)) //Articulate Studio 13
        {
            $upload['src'] =  $upload['content_url']."/presentation.html";
            $upload['launch_path'] =  dirname($nonxapi_file4).DIRECTORY_SEPARATOR."presentation.html";
            //$upload['notxapi'] = true;
            $upload['version'] = "none";
            $upload['process_status'] = 1;
			$upload["content_type"] = "not_xapi";
        }
        else if(file_exists($nonxapi_file5)) /* Articulate Rise */
		{
			$upload['src'] =  $upload['content_url']."/content/index.html";
			$upload['launch_path'] =  dirname($nonxapi_file5).DIRECTORY_SEPARATOR."index.html";
			$upload['version'] = "none";
			$upload['process_status'] = 1;
			$upload["content_type"] = "not_xapi";
		}
		foreach($upload as $k=>$v)
			$params[$k] = addslashes($v);
	
		if(!empty($params['process_status']) && empty($params['title'])) {
			$params['title'] = ucwords( str_replace(array("-", "_"), array(" ", " "), $upload["content_filename"] ));
		}
	}

	if(empty($params['process_status'])) {
		if(isset($params["src"]))
			unset($params["src"]);
		if(isset($params["launch_path"]))
			unset($params["launch_path"]);
	}

	return $params;
}
/** function lesson progress **/
function lx_lesson_progress($lesson_id,$user_id=null){
	global $color_palette;
	if(isset($user_id) && $user_id!=''){
		$user_id=$user_id;
	}else{
		$user_id=get_current_user_id();
	}
	$content_type = get_post_meta($lesson_id,'content_type',true);
	if($content_type!='' && $content_type == 'poll'){
		$progress=get_user_meta((int)$user_id,'lx_lesson_progress_'.$lesson_id,true);
	}else{
		$lessonActivityId = get_post_meta($lesson_id,'xapi_activity_id',true); 
		$progress=get_user_meta((int)$user_id,'lx_lesson_progress_'.$lessonActivityId,true);
	}
	if($progress=='completed')
	{
		$bg=$color_palette['course_completed'];
		$status='Completed';
	}
	elseif($progress=='in_progress') {
		$bg=$color_palette['course_partially_completed'];
		$status='In progress';
	}else{
		$bg=$color_palette['course_not_started'];
		$status='Not started';
	}
	return array('background'=>$bg,'status'=>$status);
}
/** function for course progress **/
function lx_course_progress($course_id,$user_id=null){
	global $color_palette;
	$args=array(
		'post_type' => 'lx_lessons' , 
		'posts_per_page' => -1,	
		'post_status'=>'publish',
		'meta_query' => array(
		   array(
			   'key' => 'course_id',
			   'value' => $course_id,
			   'compare' => '='
		   )
		)
	);
	$course_content=get_posts($args);
	$total_lesson=count($course_content);
	$total_completed=array();
	$total_inprogress=array();
	$total_not_started=array();
	foreach($course_content as $content){
		if(isset($user_id) && $user_id!=''){
			$progress=lx_lesson_progress($content->ID,$user_id);
		}else{
			$progress=lx_lesson_progress($content->ID);
		}
		if($progress['status']=='Completed'){
			$total_completed[]='1';
		}elseif($progress['status']=='In progress'){
			$total_inprogress[]='1';
		}else{
			$total_not_started[]='1';
		}
	}
	if(!empty($total_completed) || !empty($total_inprogress) || !empty($total_not_started)){
		$completed_lesson=count($total_completed);
		$not_completed=count($total_not_started);
		if($completed_lesson==$total_lesson)
		{
			$percent=100;
			$status='Completed';
			$bg=$bg=$color_palette['course_completed'];
		}elseif($not_completed==$total_lesson){
			$percent=0;
			$status='Not started';
			$bg=$bg=$color_palette['course_not_started'];
		}elseif($total_inprogress>0){
			$percent=round((100*$completed_lesson)/$total_lesson,2);
			$status='Partially completed';
			$bg=$bg=$color_palette['course_partially_completed'];
		}
	}else{
		$percent=0;
		$status='Not started';
		$bg=$bg=$color_palette['course_not_started'];
	}
	return array('status'=>$status,'percentage'=>$percent,'background'=>$bg,'total_content'=>$total_lesson,'total_completed'=>$completed_lesson);
}
/** function post in category **/
function lx_post_in_category(){
	$category = get_term_by('name', 'Content Category', 'category');
	$parent=$category->term_id;
	$public_category = get_terms('category',array(
		'hide_empty' => 0,
		'parent' => $parent,
	));
	foreach($public_category as $category_data){
		if(in_category($category_data->slug)){
			$return=1;
		}else{
			$return=0;
		}
	}
	return $return;
}
/** function get lessons **/
function get_lessons($course_id){
	$args=array(
	    'post_type' => 'lx_lessons', 
	    'posts_per_page' => -1, 
	    'post_status'=>'publish',
		   'meta_query' => array(
				'relation' => 'OR',
				array(
				   'key' => 'course_id',
				   'value' => $course_id,
				   'compare' => '='
				),
				array(
				   'key' => 'section_heading_course_id',
				   'value' => $course_id,
				   'compare' => '='
				)
			),
	    'orderby'=>'menu_order',
	    'order'=>'ASC',
	);
	$lessons=get_posts($args);
	return $lessons;
}
/** function course top ui **/
function course_top_ui($edit_id,$formid){
	global $wpdb,$color_palette,$square_icon,$page_devider;
	$current_user_id=get_current_user_id();
	$temp_course=$wpdb->get_results("select * from ".$wpdb->prefix."posts where post_title='temp-course' and  post_author='".$current_user_id."'");
	if(empty($temp_course))
	{
		$arr=array(
			'post_title'=>'temp-course',
			'post_status'=>'draft',
			'post_type'=>'lx_course',
			'post_author'=>$current_user_id
		);
		$course_id=wp_insert_post($arr);
	}
	$course_id=isset($course_id)?$course_id:$temp_course[0]->ID;
	$plugin_name =  plugin_basename(dirname(dirname(dirname(( __FILE__ )))));
	$plugin_path =  plugins_url().'/'.$plugin_name;
	if(isset($edit_id)){
		$edit_course_id = $edit_id;
		$status_info = get_post($edit_course_id)->post_status;
		if($status_info == 'draft'){
			$btn_text = 'SAVE AS DRAFT';
			$btn_publish_text = 'PUBLISH';
		}else if($status_info == 'publish'){
			$btn_text = 'UNPUBLISH';
			$btn_publish_text = 'UPDATE';
		}
	}else{
		$edit_course_id ='';
		$btn_text = 'SAVE AS DRAFT';
		$btn_publish_text = 'PUBLISH';
		$status_info='';
	}
	if(!empty($edit_course_id)){
		?>
		<input type="hidden" class="edited_course_id" value="<?php echo $edit_course_id;?>"/>
		<input type="hidden" class="edited_course_status" value="edit"/>
		<?php
	}else{
		?>
		<input type="hidden" class="edited_course_status" value="add"/>
		<?php
	}
	?>
	<style>
		.loggedin_logo{
			display: none;
		}
		.entry-content{
			padding:25px;
		}
		.main-navigation{
			display: none;
		}

		.site-info{
			display:none;
		}
		.text-muted{
			float: right !important;
		}
		.small-left{
		    float: left !important;   
		}
		.progress{
			height: 0.7rem !important;
		}
		.progress-bar {
			background: <?php echo $color_palette['hyperlinks'];?> !important;
		}
	</style>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>	
	<div class="container mt-4 save_courses_info">
		<div class="vertical-text">
			<form method="post" class="lx_course_form" id="<?php echo $formid;?>">
				<div class="mt-2 mb-4 standarized_tab2">
					<div class="standarized_tab_inner4 course_button_div">
						<div class="button_top_inside_div">
							<<?php echo $page_devider['style'];?>>
							<?php if(!empty($edit_course_id)){
								?>
								Edit Course Canvas
								<?php
							}else{
								?>
								Course Canvas
								<?php
							}?>	
							</<?php echo $page_devider['style'];?>>
						</div>
						<div class="button_top_inside_div course_buttons">
							<button class="btn_normal_state lx_save_course draft_lx_course"><?php echo $btn_text; ?></button>
							<button class="btn_normal_state lx_save_course publish_lx_course"><?php echo $btn_publish_text; ?></button>
							<button class="btn_dark_state course_back_link">CANCEL</button>
						</div>
					</div>
				</div>
				<input type="hidden" name="old_save_info" id="old_save_info" value="<?php echo $status_info; ?>">
			<input type="hidden" name="course_id" id="course_id" value="<?php echo $course_id;?>">
			<input type="hidden" name="course_save_status" id="course_save_status">
			<input type="hidden" name="darft_save_info" id="darft_save_info">
			<input type="hidden" id="blah" value="<?php echo get_stylesheet_directory_uri().'/assets/icons/image_preview2.jpg';?>">
			<div class="row">
	<?php
	return;
}
/** function course category ui **/
function course_category_ui($edit_id,$display=null){
	global $wpdb,$color_palette,$square_icon,$page_devider;
	if(isset($edit_id) && $edit_id!=''){
		$edit_course_id=$edit_id;
		$disabled='disabled';
	}else{
		$edit_course_id='';
		$disabled='';
	}
	?>
		<div class="form-group category_select" style="display:<?php echo $display;?>;">
			<?php 
				 $edit_tex_id = get_the_terms( $edit_course_id, 'category' )[0]->term_id;
				 $term=get_term_by('slug','public-library','category');

				$course_taxonomy = get_terms( array(
					'taxonomy' => 'category',
					'hide_empty' => false,
					 'parent' =>$term->term_id
					) );
			?>
			<label for="">Category</label>
		    <select class="form-control lx_course_category vw_border_charcoal" id="lx_course_category" name="lx_course_category">
				<option value='0'>Select Category</option>	
				<?php 
					foreach($course_taxonomy as $course_taxonomys){
						if(!is_super_admin()){
							if($course_taxonomys->slug !='public-library' && $course_taxonomys->slug !='sponsored'){
								if($edit_tex_id == $course_taxonomys->term_id){
								?>
									<option value="<?php echo $course_taxonomys->term_taxonomy_id;?>" selected><?php echo $course_taxonomys->name;?></option>
								<?php
								}else{
								?>
								<option value="<?php echo $course_taxonomys->term_taxonomy_id;?>"><?php echo $course_taxonomys->name;?></option>
								<?php
								}
							}
						}else{
							if($edit_tex_id == $course_taxonomys->term_id){
							?>
								<option value="<?php echo $course_taxonomys->term_taxonomy_id;?>" selected><?php echo $course_taxonomys->name;?></option>
							<?php
							}else{
							?>
								<option value="<?php echo $course_taxonomys->term_taxonomy_id;?>"><?php echo $course_taxonomys->name;?></option>
							<?php
							}
						}
					}
				?>
	 		</select>
		  	<span class="error_course_cat" style="display:none;color:<?php echo $color_palette['red'];?>;">Category can't be empty</span>
		</div>
	</div>
	<?php
	return;
}
/** function course other details ui **/
function course_details_ui($edit_id){
	global $wpdb,$color_palette,$square_icon,$page_devider,$lx_lms_settings,$lx_plugin_urls;
	if(isset($edit_id)){
		$edit_course_id=$edit_id;
	}else{
		$edit_course_id='';
	}
	?>
	<div class="col-md-4">
		<label class="label"><strong>Thumbnail (200KB-2MB recommended)</strong>
			<div class="coursethumbdiv" style="position:relative">
				<?php 
				$course_thumb = $lx_plugin_urls['lx_lms_lite'].'assets/img/add.png';
				if( !empty($edit_course_id)){
					$course_thumb=get_post_meta($edit_course_id,'lx_course_thumbnail_path',true);
					if(empty($course_thumb)){
						$course_thumb = $lx_plugin_urls['lx_lms_lite'].'assets/img/add.png';
					}
					?>
					<div class="btn_normal_state btn_edit_icon mb-2"><i class="<?php echo $square_icon['edit'];?>"></i></div>
					<div class="btn_danger_state btn_delete_icon mb-2 delete_course_thumbnail" data-id="<?php echo $edit_course_id;?>"><i class="<?php echo $square_icon['trash'];?>"></i></div>
					<?php
				}
				?>
				<div class="btn_normal_state btn_edit_icon course_have_edit" style="position: absolute;right: 0;display:none;"><i class="<?php echo $square_icon['edit'];?>"></i></div>
				<img id="course_img" class="course_img" name="course_img" 
				src="<?php echo $course_thumb;?>" data-uploaded="0"/>
			</div>
			<div class="fliplist_thumb_input">
				<input type="file" class="upload-input lx_course_thumbnail" id="lx_course_thumbnail" name="lx_course_thumbnail" accept="image/jpg, image/jpeg, image/png"/>		
			</div>
		</label>
		<div class="form-group thumbnail_progress_main_div">
	        <div class="progress">
	            <div class="progress-bar" id="cthumb_upload_progress" role="progressbar" aria-valuenow="25" aria-valuemin="0"
	                aria-valuemax="100"></div>
	        </div>
	        <small id="emailHelp" class="form-text small-left cthumb_upload_status"></small>
	        <small id="emailHelp" class="form-text text-muted">Upload Thumbnail</small>
	    </div>
		<div class="alert" role="alert"></div>
		<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Crop the image</h5>
				<button type="button" class="close course_cropping_close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<div class="img-container" style="margin:50px;">
				  <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn_normal_state" id="crop">Crop</button>
			  </div>
			</div>
		  </div>
		</div>
		<div class="form-group pt-2">
			<div class="row main_make_featured">
				<div class="col-md-3" style="color:#ccc;">
					<strong>Sponsored</strong>
				</div>
				<div class="col-md-3">
					<label class="lx_toggle">
						<input type="checkbox" class="lx_make_featured" id="lx_make_featured" name="lx_make_featured" disabled >
						<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
						<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
					</label>
				</div>
				<div class="col-md-3">
					<strong>Featured&nbsp;</strong>
				</div>
				<?php 
				$feature_checked = '';
				if( in_category('featured',$edit_course_id) == 1 ){
					$feature_checked = 'checked';
				}
				?>
				<div class="col-md-3">
					<label class="lx_toggle">
						<input type="checkbox" class="course_featured_cat" id="course_featured_cat" name="course_featured_cat" <?php echo $feature_checked;?>>
						<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
						<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
					</label>
				</div>
			</div>
		</div>
		<div class="form-group pt-2">
			<div class="row main_make_featured">
				<div class="col-md-3">
					<strong>Allow free navigation</strong>
				</div>
				<div class="col-md-3">
					<?php 
					$navchecked = '';
					$navigation_set = get_post_meta($edit_course_id,'lx_navigation_options',true);
					if($navigation_set == 'free'){
						$navchecked = 'checked';
					}
					?>
					<label class="lx_toggle">
						<input type="checkbox" class="lx_free_navigation" id="lx_free_navigation" name="lx_free_navigation" <?php echo $navchecked;?> >
						<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
						<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
					</label>
				</div>
				<div class="col-md-3">
					<strong>Certificate&nbsp;</strong>
				</div>
				<div class="col-md-3">
					<?php 
						$certchecked = '';
						$certificate_set = get_post_meta($edit_course_id,'lx_certificate',true);
						if( $certificate_set == 'on' ){
							$certchecked = 'checked';
						}
					?>
					<label class="lx_toggle">
						<input type="checkbox" class="chk_certificate" id="chk_certificate" name="chk_certificate" <?php echo $certchecked;?>>
						<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
						<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
					</label>
				</div>
			</div>
		</div>
		<?php 
		global $lx_lms_settings;
		/*echo "<pre>";print_r($lx_lms_settings);die;*/
		if(is_plugin_active ( VWPLUGIN_STRIPE ) == 1 && $lx_lms_settings['course_purchasing_settings'] == 'on'){
			$display = "none";
			if( !empty($lx_lms_settings['course_currency_symbol']) ){
				$display = "block";
			}
			
			$coursefee_set = get_post_meta($edit_course_id,'lx_course_feechk',true);
			$cousefee_chk = '';
			if( $coursefee_set == 'on' ){
				$cousefee_chk = 'checked';
			}
			
			$coursecost_set = get_post_meta($edit_course_id,'lx_course_cost',true);
			$coursecost = 0;
			if( !empty($coursecost_set)){
				$coursecost = $coursecost_set;
			}
		?>
			<div class="form-group pt-2" style="display:<?php echo $display?>">
				<div class="main_make_featured">
					<div class="">
						<strong>Course Fee&nbsp;</strong>
					</div>
					<div class="">
						<label class="lx_toggle lx_make_featured_switch">
							<input type="checkbox" class="course_fee" id="course_fee" name="course_fee" <?php echo $cousefee_chk;?>>
							<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
							<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
						</label>
					</div>
				</div>
			</div>
			<?php 
			$display="";
			if( $coursefee_set != 'on' ){
				$display = 'none';
			}
			?>
			<div class="form-group course_cost_main_div" style="display:<?php echo $display?>">
				<strong>Cost&nbsp;</strong>
				<div>
					<div class="cost_div">
						<input type="number" class="form-control lx_course_cost" id="lx_course_cost" name="lx_course_cost"  pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==4) return false;" value="<?php echo $coursecost;?>"><label  class="lbl_site_currency_code">&nbsp;<?php echo $lx_lms_settings['course_currency_setting']; ?></label>
					</div>
					<div>
						<label class="lbl_once_off">Enrolment fee</label>
					</div>
				</div>
			</div>
		<?php } ?>
		<div class="form-group">
			<div>
				<label for=""></label>
				<input type="text" class="form-control lx_course_title" maxlength="80" id="lx_course_title" name="lx_course_title" value="<?php if(!empty($edit_course_id)){ echo get_post($edit_course_id)->post_title;}?>" placeholder="Click to add the Course Title" >
				<div class="textarea_max_chars">
					<small style="color:#ccc;"><span id="lx_title_chars">80</span> characters remaining</small>
				</div>
				<span class="error_course_title" style="display:none;color:<?php echo $color_palette['red'];?>;">Title already exist</span>
				<span class="error_emptycourse_title" style="display:none;color:<?php echo $color_palette['red'];?>;">Title can't be empty</span>
			</div>
		</div>
		<div class="">
			<strong for="">Subtitle</strong>
			<input type="text" class="form-control lx_course_subtitle" maxlength="80" id="lx_course_subtitle" name="lx_course_subtitle" value="<?php if(!empty($edit_course_id)){ echo get_post_meta( $edit_course_id,'lx_course_subtitle')[0];}?>" placeholder="Click to add the Course Subtitle">
			<div class="textarea_max_chars">
				<small style="color:#ccc;"><span id="lx_subtitle_chars">80</span> characters remaining</small>
			</div>
		</div>
		<div class="">
			<strong for="">Description</strong>
			<textarea class="form-control lx_course_description vw_border_charcoal" id="lx_course_description" name="lx_course_description" rows="3" maxlength="2000" placeholder="Click to add a description of your Course"><?php if(!empty($edit_course_id)){ echo get_post($edit_course_id)->post_content;}?></textarea>
			<div class="textarea_max_chars">
				<small style="color:#ccc;"><a class="onhtips" href="javascript:void(0);" data-toggle="popover" title="" id="formatting-popover" data-placement="bottom" data-original-title="Tips for formatting"><span>Tips for formatting</span></a><span id="chars">2000</span> characters remaining</small>
			</div>
			<div id="formatting-popover-content" class="popover-content">
				<b>Bold</b> = *enter text here*<br>
				<i>Italic</i> = _enter text here_<br>
				Next line = ENTER<br>
				Next paragraph = {N} enter text here<br>
			</div>
		</div>
	</div>
	<?php	
	 return;
}
/** function course info ui **/
function course_info_ui($edit_id){ 
	global $square_icon,$wpdb;
	
	
		
?>
	
<?php
return;
}
/** function for attach course **/
function course_attached_info_ui($edit_id){ 
	global $square_icon,$wpdb;
	if(isset($edit_id)){
		$edit_course_id=$edit_id;
	}else{
		$edit_course_id='';
	} 
	
?>
	<div class="col-md-4">
		<div style="border-bottom:1px solid #ccc;"><b>Display Location</b></div>
		<div class="form-group pt-2">
			<b>Where would you like to display the Course</b>
			<select class="form-control course_display course_canvas_select" name="course_display">
				<option value="under_catgeory">Under a Category</option>
			</select>
		</div>
		<div class="form-group pt-2 under_catgeory">
			<b>Which category would you like to display it under</b>
			<?php 
			$content_cat = get_term_by('slug','content-category','category');
			$args = array(
				 'child_of'      => $content_cat->term_id,
				 'hide_empty' => false, 
			); 
			$get_subcategofparent = get_terms('category', $args);
			/* foreach( $get_subcategofparent as $contentcat ){ */
			?>
			<div class="row">
				<?php 
				foreach( $get_subcategofparent as $contentcat ){
					$ccat_checked = '';
					if( in_category($contentcat->slug,$edit_course_id) == 1 ){
						$ccat_checked = 'checked';
					}
				?>
				<div class="col-md-6">
					<label for="cc_<?php echo $contentcat->slug;?>">
						<input type="checkbox" name="chk_content_categories[]" <?php echo $ccat_checked;?> value="<?php echo $contentcat->term_id;?>" id="chk_content_category"/> <?php echo $contentcat->name;?>
					</label>
				</div>
				<?php } ?>
			</div>
		</div>
</div>
<?php
return;
}
/** function for course preview ui **/
function course_preview_ui($edit_id){
	global $wpdb,$color_palette,$square_icon,$page_devider;
	if(isset($edit_id)){
		$edit_course_id=$edit_id;
		$make_featured = get_post_meta( $edit_course_id,'lx_make_featured',true);
	}else{
		$edit_course_id='';
	}
	
	if(is_super_admin()){
		$post_author='';
	}else{
		$post_author=get_current_user_id();
	}
	$course_info = get_posts(
		array(
			'post_type' => 'lx_course',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'author'=>$post_author,
			'post__not_in'=> array($edit_course_id),
			'meta_query' => array(
				array(
					'key' => 'community_id',
					'compare' => 'NOT EXISTS'
				),
			)
		)
	);
	if(!empty($edit_course_id)){ 
		$macro_course = get_post_meta( $edit_course_id,'lx_associated_macro_course')[0];
	}
	
	if(!empty($edit_course_id)){ 
		$navigation_options = get_post_meta( $edit_course_id,'lx_navigation_options',true);
		$certificate = get_post_meta( $edit_course_id,'lx_certificate',true);
		$macro_course = get_post_meta( $edit_course_id,'lx_associated_macro_course',true);
		$cpd_points = get_post_meta( $edit_course_id,'lx_course_cpd_points',true);
		$course_time = get_post_meta( $edit_course_id,'lx_course_time',true);
		$course_level = get_post_meta( $edit_course_id,'lx_course_levels',true);
		$make_featured = get_post_meta( $edit_course_id,'lx_make_featured',true);
	}
	$navigation_options_array = array(
		array("free","Free"),
		array("restricted","Restricted"),
	);
	$cpd_ceu_pda_levels_array = array(
		array("basic","Basic"),
		array("intermediate","Intermediate"),
		array("intermediate - advanced","Intermediate - Advanced"),
		array("advanced","Advanced")
	);
	
	$add_opt = get_post_meta($edit_course_id,'additional_option',true);
	$add_div = '';$add_chk='checked';
	if( $add_opt != 'on' ){
		$add_div = 'style="display:none;"';
		$add_chk = '';
	}
	if(empty($add_opt)){
		$add_div = '';
		$add_chk='checked';
	}
	?>
	<div class="col-md-4">
		<div class="form-group row ai_center">
			<div class="col-md-6">
				<strong>Show Advance Options&nbsp;</strong>
			</div>
			<div class="col-md-6">
				<label class="lx_toggle">
					<input type="checkbox" class="course_additional_option" id="course_additional_option" name="course_additional_option" <?php echo $add_chk;?>>
					<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
					<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
				</label>
			</div>
		</div>
		<div class="additional_option_div" <?php echo $add_div;?>>
			<div class="form-group pt-2">
				<div class="a_macro_course pb-2">
					<strong for="" data-toggle="popover" title="Associated Macro Course" id="a-macro-course-popover" data-placement="bottom"> Associated Macro Course (optional)&nbsp;<label class="question_style"><i class="<?php  echo $square_icon['support'];?>" aria-hidden="true"></i></label>
					</strong>
				   <style>
					.popover{
						max-width:35%;
					}
					@media (max-width: 767px){
						.popover{
							max-width:75%;
						}
					}
					.popover-header{	
						text-align: center;	
					}

					</style>
					<div id="a-macro-course-popover-content" class="popover-content">
						<div>
							<span>This platform has micro and macro courses.  A micro course will count towards a macro course.
							</span>
							<br/>
							<span>If this course is a micro-credential, you can select the associated main course here.</span>
							<br/>
							<br/>
							<div class="text-center">
								<div style="cursor: pointer;float:center" data-hide_info="a-macro-course-popover" class="btn btn_normal_state btn_got_it_a_macro_course">Got It</div>
							</div>
						</div>
					</div>
				</div>
				<style>
				.lx_associated_macro_course_main .select2{
					width:100% !important;
				}
				</style>
				<div class="lx_associated_macro_course_main">
					<?php
					$commid = get_post_meta($edit_course_id,'lx_attach_this_course',true);
					if(!empty($commid)){
						$get_couses = $wpdb->get_results("select p.* from ".$wpdb->prefix."posts as p,".$wpdb->prefix."postmeta as pm where p.ID=pm.post_id and pm.meta_key like 'community_id' and pm.meta_value='".$commid."' and p.ID !='".$edit_course_id."' and p.post_type='lx_course' and p.post_status='publish'");
					}else{
						$get_couses = get_posts(
							array(
								'post_type' => 'lx_course',
								'post_status' => 'publish',
								'posts_per_page' => -1,
								'post__not_in'=> array($edit_course_id),
								'meta_query' => array(
								array(
									'key' => 'community_id',
									'compare' => 'NOT EXISTS'
									),
								)
							)
						);
					}
					$macro_course = get_post_meta($edit_course_id,'lx_associated_macro_course',true);
					?>
					<select name="lx_associated_macro_course" class="form-control macro_course course_canvas_select" onmouseover="this.size=<?php echo $data_size; ?>;" onmouseout="this.size=1;" style="overflow: auto;" size="1">
						<option value="0">Please select from dropdown</option>
						<?php 
						foreach($get_couses as $course){ 
							$mc_selected = '';
							if( $macro_course == $course->ID ){
								$mc_selected = 'selected';
							}
							 ?>
							<option value="<?php echo $course->ID; ?>" <?php echo $mc_selected;?>><?php echo $course->post_title; ?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
			<div class="form-group pt-2">
				<div class="main_cpd_and_time">
					<div class="cpd_points_main_div">
						<strong for="" data-toggle="popover" title="CPD Points" id="cpd-points-popover" data-placement="bottom" class="label_text">CPD Points (optional) &nbsp;<label class="question_style"><i class="<?php  echo $square_icon['support'];?>" aria-hidden="true"></i></label></strong>
						<div id="cpd-points-popover-content" class="popover-content">
							<div>
								<span>
									If your site uses CPD Points, then some Course Tiles will display this information.  Otherwise it will just be displayed on the Course Page.
								</span>
								<br/>
								<br/>
								<div class="text-center">
									<div class="btn btn_normal_state btn_got_it_cpd_points" style="cursor: pointer;">Got It</div>
								</div>
							</div>
						</div>
						<input type="number" name="lx_course_cpd_points" min='1' id="lx_course_cpd_points" class="course_cpd_points" <?php if(isset($cpd_points) && !empty($cpd_points)){ echo "value=".$cpd_points; } ?>>
					</div>
					
					<div class="course_time_main_div">
						<strong for="" data-toggle="popover" title="Time" id="course-time-popover" data-placement="bottom" class="label_text">Time (hrs) (optional) &nbsp;<label class="question_style"><i class="<?php  echo $square_icon['support'];?>" aria-hidden="true"></i></label></strong>
						<div id="course-time-popover-content" class="popover-content">
							<div>
								<span>
									Some Course Tiles will display this information.  Otherwise it will just be displayed on the Course Page.
								</span>
								<br/>
								<br/>
								<div class="text-center">
									<div class="btn btn_normal_state btn_got_it_course_time" style="cursor: pointer;">Got It</div>
								</div>
							</div>
						</div>
						<input type="text" name="lx_course_time" id="lx_course_time" class="course_time" <?php if(isset($course_time) && !empty($course_time)){ echo "value=".$course_time; } ?>>
					</div>
				</div>
			</div>
			<div class="form-group pt-2">
				<div>
					<strong for="" data-toggle="popover" title="CPD/CEU/PDA Levels" id="course-levels-popover" data-placement="bottom" class="label_text">CPD/CEU/PDA Levels (optional) &nbsp;<label class="question_style"><i class="<?php  echo $square_icon['support'];?>" aria-hidden="true"></i></label></strong>
					<div id="course-levels-popover-content" class="popover-content">
						<div>
							<span>
								If your site uses CPD/CEU/PDA Levels, then some Course Tiles will display this information.  Otherwise it will just be displayed on the Course Page.
							</span>
							<br/>
							<br/>
							<div class="text-center">
								<div class="btn btn_normal_state btn_got_it_course_levels" style="cursor: pointer;">Got It</div>
							</div>
						</div>
					</div>
				</div>
				<style>
					.course_lvl_div .select2{
						width:100% !important;
					}
				</style>
				<div class="course_lvl_div">
					<select name="lx_course_levels" class="form-control lx_course_levels course_canvas_select">
						<option value="0">Please select</option>
						<?php foreach( $cpd_ceu_pda_levels_array as $levels_info ){ ?>
								<option value="<?php echo $levels_info[0]; ?>" <?php if( $course_level == $levels_info[0] ){ echo 'selected'; } ?>><?php echo $levels_info[1]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="pb-2">
				<strong>Summary</strong>
			</div>
			<div class="form-group">
				<textarea class="form-control lx_course_summary vw_border_charcoal" id="lx_course_summary" name="lx_course_summary" rows="3" maxlength="800" placeholder="Summary (optional)"><?php if(!empty($edit_course_id)){ echo get_post_meta( $edit_course_id,'lx_course_summary')[0];}?></textarea>
				<div class="textarea_max_chars">
					<small style="color:#ccc;"><span id="summary_chars">800</span> characters remaining</small>
				</div>
			</div>
			<div class="pb-2">
				<strong>Outcomes</strong>
			</div>
			<div class="form-group">
				<textarea class="form-control lx_course_outcomes vw_border_charcoal" id="lx_course_outcomes" name="lx_course_outcomes" rows="3" maxlength="800" placeholder="Outcomes (optional)"><?php if(!empty($edit_course_id)){ echo get_post_meta( $edit_course_id,'lx_course_outcomes')[0];}?></textarea>
				<div class="textarea_max_chars">
					<small style="color:#ccc;"><span id="outcomes_chars">800</span> characters remaining</small>
				</div>
			</div>
			<div class="pb-2">
				<strong>Requirements</strong>
			</div>
			<div class="form-group">
				<textarea class="form-control lx_course_requirements vw_border_charcoal" id="lx_course_requirements" name="lx_course_requirements" rows="3" maxlength="800" placeholder="Requirements (optional)"><?php if(!empty($edit_course_id)){  echo get_post_meta( $edit_course_id,'lx_course_requirements')[0];}?></textarea>
				<div class="textarea_max_chars">
					<small style="color:#ccc;"><span id="requirements_chars">800</span> characters remaining</small>
				</div>
			</div>
			<?php 
			if(isset($make_featured)){
				if($make_featured=="on"){
					$display_content_category = "block";
				}else{
					$display_content_category = "none";
				}
			} else{
				$display_content_category = "none";
			}
			?>
			<div class="course_category_info_main" style="display:<?php echo $display_content_category; ?>;">
				<strong>Category</strong>
				<div class="row">
					<?php 
						$parent_cat_id = get_term_by('slug', 'content-category', 'category')->term_id;
						$course_taxonomy_info = get_terms( array(
							'taxonomy' => 'category',
							'hide_empty' => false,
							 'parent' => $parent_cat_id
						) );
						$wpdb->insert($wpdb->prefix."term_relationships", array(
							'term_taxonomy_id' => $term_taxonomy,
							'term_order' => '0',
							'object_id' => $course_id
						));
						if(!empty($edit_course_id)){						
							$content_category_data = $wpdb->get_results("SELECT term_taxonomy_id FROM ".$wpdb->prefix."term_relationships WHERE object_id = '".$edit_course_id."'");
							$content_category_info = array();
							foreach($content_category_data as $term_info){
								array_push($content_category_info,$term_info->term_taxonomy_id);
							}
						}
						foreach($course_taxonomy_info as $course_taxonomy){ 
							if(isset($content_category_info)){
								if (in_array($course_taxonomy->term_id, $content_category_info)){
									$checked_content_info = "checked";
								} else{
									$checked_content_info = "";
								}
							} else{
								$checked_content_info = "";
							}
						?>
						<div class="col-md-4">
							<label class="checkbox-inline pt-2 course_content_category">
								<input type="checkbox" class="chk_content_category" id="chk_content_category" name="chk_content_category[]" value="<?php echo $course_taxonomy->term_id; ?>" <?php echo $checked_content_info; ?>>&nbsp;<?php echo $course_taxonomy->name; ?>
							</label>
						</div>
					<?php
						}
					?>
				</div>
			</div>
		</div>
	</div>
	<script>
	jQuery(function(){
		jQuery("#formatting-popover").popover({
			html : true, 
			content: function() {
			  return jQuery("#formatting-popover-content").html();
			},
			title: function() {
			  return jQuery("#formatting-popover-title").html();
			}
		});
	});
	</script>
	<?php
	return;
}
/** function for course canvas bottom **/
function course_bottom_ui($edit_id){
	global $wpdb,$color_palette,$square_icon,$page_devider;
	if(isset($edit_id)){
		$edit_course_id=$edit_id;
		$status_info = get_post($edit_course_id)->post_status;
		if($status_info == 'draft'){
			$btn_text = 'SAVE AS DRAFT';
			$btn_publish_text = 'PUBLISH';
		}else if($status_info == 'publish'){
			$btn_text = 'UNPUBLISH';
			$btn_publish_text = 'UPDATE';
		}
	}else{
		$edit_course_id='';
		$btn_text = 'SAVE AS DRAFT';
		$btn_publish_text = 'PUBLISH';
	}
	?>
		</div>
		<div class="mt-2 standarized_tab2">
			<div class="standarized_tab_inner4 course_button_div course_bottom_button_div">
				<div class="button_top_inside_div">
				</div>
				<div class="button_top_inside_div course_buttons">
					<button class="btn_normal_state lx_save_course draft_lx_course"><?php echo $btn_text; ?></button>
					<button class="btn_normal_state lx_save_course publish_lx_course"><?php 	 echo $btn_publish_text; ?></button>
					<button class="btn_dark_state course_back_link">CANCEL</button>
				</div>
			</div>
		</div>
		</form>
		</div>
		<input type="hidden" class="hidden_back_link_course" value="<?php echo  $_SERVER['HTTP_REFERER'];?>"/>
		</div>
		<script>
		var userid_obj = {'userids':"<?php echo get_the_ID();?>"} 
		var my_ajax_object = {'ajax_anchor':"<?php echo admin_url( 'admin-ajax.php' );?>"} 
		var http_referer = {'back':"<?php echo $_SERVER['HTTP_REFERER'];?>"} 

		jQuery('#title-click').click(function() {
		   jQuery('.hide_title').css('display','block');
			jQuery('#title-click').css('display','none');
		});

		jQuery(document).ready(function(){
			var maxLength = 80;
			var length = jQuery('.lx_course_title').val().length;
		  	var length = maxLength-length;
		  	jQuery('#lx_title_chars').text(length);
			jQuery('.lx_course_title').keyup(function(){
				var maxLength = 80;
				var length = jQuery(this).val().length;
				  var length = maxLength-length;
				  jQuery('#lx_title_chars').text(length);
			});
		});
		
		jQuery(document).ready(function(){
			var maxLength = 80;
			var length = jQuery('.lx_course_subtitle').val().length;
		  	var length = maxLength-length;
		  	jQuery('#lx_subtitle_chars').text(length);
			jQuery('.lx_course_subtitle').keyup(function(){
				var maxLength = 80;
				var length = jQuery(this).val().length;
				  var length = maxLength-length;
				  jQuery('#lx_subtitle_chars').text(length);
			});
		});

		var maxLength = 2000;
		var length = jQuery('.lx_course_description').val().length;
		var length = maxLength-length;
		jQuery('#chars').text(length);
		jQuery('.lx_course_description').keyup(function() {
		  var maxLength = 2000;
		  var length = jQuery(this).val().length;
		  var length = maxLength-length;
		  jQuery('#chars').text(length);
		});
		
		var maxLength = 800;
		var length = jQuery('.lx_course_summary').val().length;
		var length = maxLength-length;
		jQuery('#summary_chars').text(length);
		jQuery('.lx_course_summary').keyup(function() {
		  var maxLength = 800;
		  var length = jQuery(this).val().length;
		  var length = maxLength-length;
		  jQuery('#summary_chars').text(length);
		});
		
		var maxLength = 800;
		var length = jQuery('.lx_course_outcomes').val().length;
		var length = maxLength-length;
		jQuery('#outcomes_chars').text(length);
		jQuery('.lx_course_outcomes').keyup(function() {
		  var maxLength = 800;
		  var length = jQuery(this).val().length;
		  var length = maxLength-length;
		  jQuery('#outcomes_chars').text(length);
		});
		
		var maxLength = 800;
		var length = jQuery('.lx_course_requirements').val().length;
		var length = maxLength-length;
		jQuery('#requirements_chars').text(length);
		jQuery('.lx_course_requirements').keyup(function() {
		  var maxLength = 800;
		  var length = jQuery(this).val().length;
		  var length = maxLength-length;
		  jQuery('#requirements_chars').text(length);
		});

		jQuery('.lx_course_title').on('keydown, keyup', function () {
		  if( jQuery('.lx_course_title').val()=='')
		  {
			 var texInputValue="example title";
		  }else{
			var texInputValue = jQuery('.lx_course_title').val();
		  }
		   jQuery('.display_title').html(texInputValue);
		});

		jQuery('.lx_course_description').on('keydown, keyup', function () {
		  if( jQuery('.lx_course_description').val()=='')
		  {
			 var texInputValue="description";
		  }else{
			var texInputValue = jQuery('.lx_course_description').val();
		  }
		   jQuery('.display_desc').html(texInputValue);
		});
		
		</script>
	<?php
	return;
}
/** function for update course **/
function course_update($post){
	if(isset($post['edited_course_status']) && $post['edited_course_status']=='edit'){
		$course_id=$post['edited_course_id'];
	}else{
		$course_id=$post['course_id'];
	}
	$lx_course_title = $post['lx_course_title'];
	$lx_course_description = $post['lx_course_description'];
	$lx_course_status = $post['save_status_info'];
	$my_post = array(
	  'ID'            => $course_id,
	  'post_title'    =>  $lx_course_title,
	  'post_content'  => $lx_course_description,
	  'post_status'   => $lx_course_status,
	  'post_type'   => 'lx_course',
	  'guid' => sanitize_title_with_dashes($lx_course_title)
	);
	$course_id=wp_update_post($my_post);
	return $course_id;
}
/** function for add course meta **/
function add_course_meta($course_id,$post){
	global $wpdb;
	$lx_course_category=$post['lx_course_category'];
	add_post_meta($course_id,'display_in',$post['availablity_option']);
	$insert_relation_ship = $wpdb->query("insert into ".$wpdb->prefix."term_relationships (object_id,term_taxonomy_id,term_order) values ('".$course_id."','".$lx_course_category."','0')");
	return;
}
/** function for update course meta **/
function update_course_meta($course_id,$post){
	global $wpdb;
	$cnavi = 0;
	if( $post['lx_free_navigation'] == 'on' ){
		$cnavi = 'free';
	}
	$cost = 0;
	if( $post['course_fee'] == 'on' ){
		$cost = $post['lx_course_cost'];
	}
	
	$add_option = 'off';
	if($post['course_additional_option'] == 'on'){
		$add_option = $post['course_additional_option'];
	}
	update_post_meta($course_id,'additional_option',$add_option);
	update_post_meta($course_id,'course_display',$post['course_display']);
	update_post_meta($course_id,'lx_course_feechk',$post['course_fee']);
	update_post_meta($course_id,'lx_course_cost',$cost);
	update_post_meta($course_id,'lx_navigation_options',$cnavi);
	update_post_meta($course_id,'lx_certificate',$post['chk_certificate']);
	update_post_meta($course_id,'lx_course_subtitle',$post['lx_course_subtitle']);
	
	$macro_course = $post['lx_associated_macro_course'];
	$cpd_pt = $post['lx_course_cpd_points'];
	$c_time = $post['lx_course_time'];
	$c_level = $post['lx_course_levels'];
	$c_summ = $post['lx_course_summary'];
	$c_outcome = $post['lx_course_outcomes'];
	$c_req = $post['lx_course_requirements'];
	if( $post['course_additional_option'] != 'on' ){
		$macro_course = 0;$cpd_pt = '';$c_time = '';$c_level = '';$c_summ = '';$c_outcome = '';$c_req = '';
	}
	update_post_meta($course_id,'lx_associated_macro_course',$macro_course);
	update_post_meta($course_id,'lx_course_cpd_points',$cpd_pt);
	update_post_meta($course_id,'lx_course_time',$c_time);
	update_post_meta($course_id,'lx_course_levels',$c_level);
	update_post_meta($course_id,'lx_course_summary',$c_summ);
	update_post_meta($course_id,'lx_course_outcomes',$c_outcome);
	update_post_meta($course_id,'lx_course_requirements',$c_req);
	
	$content_catselect = array();
	$content_catselect = $post['chk_content_categories'];
	if( $_POST['course_featured_cat'] == 'on' ){
		$feature_cat = get_term_by('slug','featured','category')->term_id;
		array_push($content_catselect,$feature_cat);
	}
	
	$wpdb->delete( $wpdb->prefix."term_relationships", array( 'object_id' => $course_id ) );
	foreach($content_catselect as $term_taxonomy){
		$wpdb->insert($wpdb->prefix."term_relationships", array(
			'term_taxonomy_id' => $term_taxonomy,
			'term_order' => '0',
			'object_id' => $course_id
		));
	}
	return;
}
/** function for validate file formate **/
function file_validation($file){
	$error = '';
	$filename=$file['name'];
	$fileExt = explode('.', $filename)[1];
	if((!empty($file)) && ($file["error"] == 0)){
        if($fileExt != "jpg" && $fileExt != "jpeg" && $fileExt != "png" && $fileExt != "gif"){
            $error = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    }else{
        $error = "Select an image file to upload.";
    } 
	if($error){
		$data=['status'=>"0",'msg'=>$error];
	}else{
		$data=['status'=>"1",'msg','success'];
	}
	return $data;
}
/** function for store uploaded data locally  **/
function store_file_locally($dataurl,$filename){
	$data = file_get_contents($dataurl);
	$url = wp_upload_dir()['url'].'/'.$filename;
	$path = wp_upload_dir()['path'].'/'.$filename;
	$upload =file_put_contents($path, $data);
	$resize=imageresize($path);
	return $path;
}
/** function for set course thumb upload attributes **/
function course_thumb_upload_arr($data,$file,$path){
	$course_id=$data['course_id'];
	$arr=array(
		'course_id'=>$course_id,
		'files' => $file,
		'path' => $path,
		'dir'=> 'site-assets/course/'.$course_id.'/'
	);
	if(isset($data['mode']) && $data['mode']=='edit')
	{
		$old_image['cropped']=get_post_meta($course_id,'lx_course_thumbnail_path',true);
		$old_image['original']=get_post_meta($course_id,'lx_course_thumbnail_original',true);	
		$arr['old_image']=$old_image;
	}
	return $arr;
}
/** function for get module upload directory **/
function get_module_upload_dir($course_id,$module_id){
	$dir='site-assets/course/'.$course_id.'/module-'.$module_id.'/';
	return $dir;
}
/** function for get course data **/
function get_course($course_id)
{
	global $color_palette,$tiles_style,$breakpoint;
	$user_id=get_current_user_id();
	$course=get_post($course_id);
	$post_title=$course->post_title;
	$post_type=$course->post_type;
	$course_length = wp_strip_all_tags($course->post_content);
	if(strlen($course_length) > 70 ){		
		$post_description = substr($course_length, 0, 60);
		$length = strripos($post_description,' ');
		$post_description = substr($course_length, 0, $length).'...';
	}else{
		$post_description = $course_length;	
	}
	$url=get_permalink($course_id);
	$post_id = $course_id;
	$thumbnail_image=get_post_meta($course_id,'lx_course_thumbnail_path')[0];
	?>
	<div class="<?php echo $breakpoint['class'];?>">
	<?php 
		$info = "course_info";
		$com_id=get_post_meta($course_id,'community_id',true);
		$progress=lx_course_progress($course_id);
		$bg=$progress['background'];
		$bg_tile = $color_palette['black'];
		$status=$progress['status'];
		$btn_name=$progress['btn_text'];
		$author_id = $course->post_author;
		if(!empty($tiles_style['course_tile'])){
			include ($tiles_style['course_tile'] );
		}else{
			global $lx_plugin_paths;
			include ($lx_plugin_paths['lx_lms_lite'].'template/tiles/tiles_style_2_ui.php');
		} ?>
	</div>
	<?php
	return;
}
/** function for get course other modules **/
function course_other_modules_in_series($other_modules_array){
	global $wpdb,$lx_lms_settings,$lx_plugin_urls;
	$i=1;
	if(!empty($other_modules_array['check_other_modules'])){
		foreach($other_modules_array['check_other_modules'] as $other_modules){
			$post_id = $other_modules->ID;
		?>
		<div class="row <?php if($i != '0'){ echo "pb-4"; }?>">
			<div class="col-md-3">
				<?php  
					$course_thumb = get_post_meta($post_id,'lx_course_thumbnail_path')[0];
					if(empty($course_thumb)){
						$course_thumb = $lx_plugin_urls['lx_lms_lite'].'assets/img/sample_broken_img.jpg';
					}
				?>
				<div class="the_thumb">
					<img src="<?php echo $course_thumb;?>"/>
				</div>
			</div>
			<div class="col-md-6">
				<div>			
					<h3 class="head_h3"><?php echo $other_modules->post_title; ?></h3>
				</div>
				<div>
					<div class="description_body micro_module_description"><?php echo FnFormatMytextNLignore($other_modules->post_content);?></div>
				</div>
			</div>
			<div class="col-md-3">
				<?php 
				if($lx_lms_settings['course_purchasing_settings'] == 'on'){
					$cost = get_post_meta( $post_id,'lx_course_cost')[0];
					if(!empty($cost)){
						$btn_info = $cost;
					} else{
						$btn_info = "0.00";
					}
				} else{
					$btn_info = "0.00";
				}
				$btn_text = $lx_lms_settings['course_currency_symbol']."".$btn_info;
				if(get_current_user_id() == $other_modules->post_author){ ?>
					<a href="<?php echo get_permalink($post_id); ?>">
						<button class="btn_normal_state btn_micro_module">View</button>
					</a>
				<?php
					
				} elseif(($other_modules_array['macro_course_id'] == 0 || empty($other_modules_array['macro_course_id'])) || isset($other_modules_array['micro_course_order_existance']) && !empty($other_modules_array['micro_course_order_existance']) || empty($lx_lms_settings['course_purchasing_settings'])){ ?>
					<a href="<?php echo get_permalink($post_id); ?>">
						<button class="btn_normal_state btn_micro_module">View</button>
					</a>
				<?php
				} else{
					if($btn_info !='0.00'){
						$payment_content = do_shortcode( '[accept_stripe_payment id="'.$post_id.'" description="#'.$post_id.'" name="'.get_post($post_id)->post_title.'" price="'.$cost.'" button_text="'.$btn_text.'" billing_address="0" shipping_address="0" payment_info= "custom_payment" class="btn_normal_state btn_micro_module" currency="'.$lx_lms_settings['course_currency_setting'].'"]');
						
						$static_content = '[accept_stripe_payment id="'.$post_id.'" description="#'.$post_id.'" name="'.get_post($post_id)->post_title.'" price="'.$cost.'" button_text="'.$btn_text.'" billing_address="0" shipping_address="0" payment_info= "custom_payment" class="btn_normal_state btn_micro_module" currency="'.$lx_lms_settings['course_currency_setting'].'"]';
						
						if( $payment_content != $static_content ){
							echo $payment_content;
						}else{
							echo "<span class='lx_lms_sub_text'>No payment method available</span>";
						}
					}elseif($btn_info == '0.00'){
						?>	
						<a href="<?php echo get_permalink($post_id); ?>">	
							<button class="btn_normal_state btn_micro_module">View</button>
						</a>
						<?php
					}else{ 
						?>				
						<button class="btn_normal_state btn_micro_module"><?php echo $btn_text; ?></button>
						<?php
					}	
				}
				?>
			</div>
		</div>
	<?php
		$i++;
		}		
	}
	return;
}
/** function for course popover **/
function course_popover_ui(){ ?>
	<script>
		/* popover macro course */
		jQuery(function(){
			 /* Enables popover */
			jQuery("#a-macro-course-popover").popover({
				html : true, 
				content: function() {
				  return jQuery("#a-macro-course-popover-content").html();
				},
				title: function() {
				  return jQuery("#a-macro-course-popover-title").html();
				}
			});
			jQuery("#a-this-course-popover").popover({
				html : true, 
				content: function() {
				  return jQuery("#a-this-course-popover-content").html();
				},
				title: function() {
				  return jQuery("#a-this-course-popover-title").html();
				}
			});
		});
		/* popover xapi tumbnail */
		jQuery(function(){
			 /* Enables popover */
			jQuery("#xapi-thumb-popover").popover({
				html : true, 
				content: function() {
				  return jQuery("#xapi-thumb-popover-content").html();
				},
				title: function() {
				  return jQuery("#xapi-thumb-popover-title").html();
				}
			});
		});
		/* popover navigation options */
		jQuery(function(){
			 /* Enables popover */
			jQuery("#navigation-options-popover").popover({
				html : true, 
				content: function() {
				  return jQuery("#navigation-options-popover-content").html();
				},
				title: function() {
				  return jQuery("#navigation-options-popover-title").html();
				}
			});
		});
		/* popover CPD Points*/
		jQuery(function(){
			 /* Enables popover */
			jQuery("#cpd-points-popover").popover({
				html : true, 
				content: function() {
				  return jQuery("#cpd-points-popover-content").html();
				},
				title: function() {
				  return jQuery("#cpd-points-popover-title").html();
				}
			});
		});
		/* popover course time*/
		jQuery(function(){
			 /* Enables popover */
			jQuery("#course-time-popover").popover({
				html : true, 
				content: function() {
				  return jQuery("#course-time-popover-content").html();
				},
				title: function() {
				  return jQuery("#course-time-popover-title").html();
				}
			});
		});
		/* popover course levels*/
		jQuery(function(){
			 /* Enables popover */
			jQuery("#course-levels-popover").popover({
				html : true, 
				content: function() {
				  return jQuery("#course-levels-popover-content").html();
				},
				title: function() {
				  return jQuery("#course-levels-popover-title").html();
				}
			});
		});
		jQuery(document).on('click','.btn_got_it_navigation_options',function(){
			jQuery('#navigation-options-popover').popover('hide');
		});
		jQuery(document).on('click','.btn_got_it_xapi_thumb',function(){
			jQuery('#xapi-thumb-popover').popover('hide');
		});
		jQuery(document).on('click','.btn_got_it_a_macro_course',function(){
			jQuery('#a-macro-course-popover').popover('hide');
		});
		jQuery(document).on('click','.btn_got_it_cpd_points',function(){
			jQuery('#cpd-points-popover').popover('hide');
		});
		jQuery(document).on('click','.btn_got_it_course_time',function(){
			jQuery('#course-time-popover').popover('hide');
		});
		jQuery(document).on('click','.btn_got_it_course_levels',function(){
			jQuery('#course-levels-popover').popover('hide');
		});
	</script>
<?php
}
/** function for check course order exists or not **/
function check_lx_course_order_exists($post_id,$user_id){
	
	$meta_query=array(
		'relation'=>'AND',
		array(
			'key'=>'lx_product_id',
			'value'=>$post_id,
			'compare'=>'='
		),
		array(
			'key'=>'lx_order_user_id',
			'value'=>$user_id,
			'compare'=>'IN'
		),
		array(
			'key'=>'lx_order_status',
			'value'=>'paid',
			'compare'=>'IN'
		)
	);
	$order_existance = get_posts(
		array(
			'post_type'=>'lx_course_order',
			'post_satus'=>'publish',
			'meta_query'=>$meta_query
		)
	);
	return $order_existance;
}

function freecourseenrolled( $course_id , $lessonid, $user_id ){
	if( empty($course_id) ){
		$course_id = get_post_meta( $lessonid,'course_id',true );
	}
	
	$meta_query=array(
			'relation'=>'AND',
			array(
				'key'=>'lx_product_id',
				'value'=>$course_id,
				'compare'=>'='
			),
			array(
				'key'=>'lx_order_user_id',
				'value'=> $user_id,
				'compare'=>'IN'
			),
		);
		
	$args_array = array(
		'post_type'=>'lx_course_order',
		'author' => $user_id,
		'posts_per_page' => -1,
		'post_status'=> 'publish',
		'meta_query'=>$meta_query
	);
	$free_courseorder_existance = get_posts($args_array);
	$purchasable_courseorder = check_lx_course_order_exists($course_id,$user_id);
	if( empty($free_courseorder_existance) && empty($purchasable_courseorder) ){
		$enrollcoursetitle = get_post($course_id)->post_title .' '.'Enrolled'.' '.$user_id;
		$args_array['post_title'] = $enrollcoursetitle; 
		$args_array['post_author'] = $user_id;
		$order_id = wp_insert_post($args_array);
		update_post_meta($order_id,'lx_product_id',$course_id);
		update_post_meta($order_id,'lx_order_user_id',$user_id); 
		update_post_meta($order_id,'lx_trans_date',date("d-m-Y"));  
	}
}
?>