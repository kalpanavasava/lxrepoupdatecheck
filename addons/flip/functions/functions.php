<?php
/* Fliplist Top UI */
function Fl1plistTopUI(){
	global $wpdb,$flipicons;
	$fliplist_id = isset($_POST['fliplist_id'])?$_POST['fliplist_id']:'';
	$author_id = get_current_user_id();
	if( $fliplist_id == '' ){
		$temp_fliplist = $wpdb->get_results(" select * from ".$wpdb->prefix."posts where post_title='temp-fliplist' and post_type='flip_list' and post_status='draft' and post_author='".$author_id."' ");
		
		if( empty($temp_fliplist) ){
			$arr = array(
					'post_type'=>'flip_list',
					'post_status'=>'draft',
					'post_title'=>'temp-fliplist',
					'post_author'=>$author_id
			);
			$fliplist_id = wp_insert_post($arr);
		}else{
			$fliplist_id = $temp_fliplist[0]->ID;
		}
		$mode = 'add';
		$fliplist_status='';
		$btn_draft_text = 'SAVE AS DRAFT';
		$btn_publish_text = 'PUBLISH';
	}else{
		$mode = 'edit';
		$fliplist_status = get_post($fliplist_id)->post_status;
		if( $fliplist_status == 'draft' ){
			$btn_draft_text = 'SAVE AS DRAFT';
			$btn_publish_text = 'PUBLISH';
		}else if($fliplist_status == 'publish'){
			$btn_draft_text = 'UNPUBLISH';
			$btn_publish_text = 'UPDATE';
		}
	}  
?>
<style>
.container{
	max-width:100%;
}
.fliptitlediv,.fliptopbtndiv{
	width:50%;
	float:left;
}
@media (max-width: 767px){
	.fliptitlediv,.fliptopbtndiv{
		width:100%;
	}
}
.fliptopbtndiv{
	text-align:end;
}
@media (max-width: 767px){
	.fliptopbtndiv{
		text-align:inherit;
	}
}
.fliplist_favicon_lx{
	width:6%;
}
@media (max-width: 767px){
	.fliplist_favicon_lx {
		width:13%;
	}
}
.site-footer{
	display:none;
}
.select2-container{
	width:100% !important;
}
</style>
<div class="container mt-4">
	<div class="vertical-text">
		<form method="post" class="fliplist_form" id="save_fliplist_form">
			<input type="hidden" id="fliplist_id" name="fliplist_id" value="<?php echo $fliplist_id;?>">
			<input type="hidden" class="author_id" value="<?php echo $author_id;?>">
			<input type="hidden" id="mode" value="<?php echo $mode;?>">
			<input type="hidden" name="fliplist_darft_info" id="fliplist_darft_info">
			<input type="hidden" name="fliplist_oldstatus" id="fliplist_oldstatus" value="<?php echo $fliplist_status; ?>">
			<input type="hidden" name="fliplist_save_status" id="fliplist_save_status">
			<input type="hidden" id="blah" value="<?php echo get_stylesheet_directory_uri().'/assets/icons/image_preview2.jpg';?>">
			<div class="mt-2 fliplist_tab_top standarized_tab">
				<div class="fliplist_tab_inner_top">
					<div class="fliptitlediv d-flex">
						<img id="favicon_lx" class="fliplist_favicon_lx" src="<?php echo get_stylesheet_directory_uri().'/assets/icons/favicon_learningx.png';?>">&nbsp;&nbsp;
						<div class="fliplist_head">
							<h6 class="head_h6">Fl1plist</h6>
						</div>&nbsp;&nbsp;
					</div>
					<div class="fliplist_top_button fliptopbtndiv">
						<button type="submit" class="btn_normal_state status_draft"><?php echo $btn_draft_text; ?></button>
						<button type="submit" class="btn_normal_state status_publish"><?php echo $btn_publish_text; ?></button>
						<button type="button" class="btn_dark_state btn_cancel_fliplist">CANCEL</button>
					</div>
				</div>
			</div><br>
			<div class="row">
<?php	
}

/* Fliplist Details UI */
function Fl1plistDetailsUI(){
	global $lx_plugin_urls,$square_icon,$flipicons,$color_palette;
	$fliplist_id = isset($_POST['fliplist_id'])?$_POST['fliplist_id']:'';
	if( $fliplist_id !='' ){
		$mode = 'edit';
		$fliplist_thumb = get_post_meta($fliplist_id,'fliplist_cropped_thumb')[0];
		$title = get_post($fliplist_id)->post_title; 
		$subtitle = get_post_meta( $fliplist_id,'fliplist_subtitle')[0];
		$description = get_post($fliplist_id)->post_content;
	}else{
		$mode = 'add';
	}
	$defaultlist = get_post_meta( $fliplist_id ,'registertimelist' , true );

?>
	
<style>
.flip_progress_bar{
	height: 0.7rem;
    background: #FFFFFF;
    border: 1px solid <?php echo $color_palette['border'];?>;
}
.fliplistthumbedit{
	position:absolute;
	right:0px;
	top: 0;
	cursor:pointer;
}
</style>
	<div class="col-md-4">
		<div class="fliplist_details_ui">
			<div class="fliplist_thumbnail_div">
				<input type="hidden" class="fliplistediticon" value="<?php echo $square_icon['edit'];?>">
				<label class="label"><strong>Thumbnail</strong>
					<div class="fliplistthumbdiv" style="position:relative">
						<?php 
						$fliplistthumb = $lx_plugin_urls['lx_lms_lite'].'assets/img/add.png';
						if( !empty($fliplist_thumb) ){
							$fliplistthumb = $fliplist_thumb;
							?>
							<div class="btn_normal_state fliplistthumbedit"><i class="<?php echo $square_icon['edit'];?>"></i></div>
							<?php
						}
						?>
						<img id="fliplist_img" class="fliplist_img" name="fliplist_img" 
						src="<?php echo $fliplistthumb;?>" data-uploaded="0"/>
					</div>
					<div class="fliplist_thumb_input">
						<input type="file" class="upload-input fliplist_thumbnail" id="fliplist_thumbnail" name="fliplist_thumbnail" accept="image/jpg, image/jpeg, image/png"/>		
					</div>
				</label>
				<div class="form-group thumbnail_progress_main_div">
					<div class="progress flip_progress_bar">
						<div class="progress-bar" id="fliplist_thumb_progress" role="progressbar" aria-valuenow="25" aria-valuemin="0"
							aria-valuemax="100">
						</div>
					</div>
					<div class="d-flex justify-content-end">
						<div><small id="emailHelp" class="form-text fliplist_thumb_upload_status"></small></div>
						<div><small id="emailHelp" class="form-text upload_thumb_txt">Upload Thumbnail</small></div>
					</div>
				</div>
			</div>
			<div class="form-group pt-2">
				<div class="row fliplist_categories">
					<div class="col-md-3">
						<label class="sponsored_text">Sponsored</label>
					</div>
					<div class="col-md-3 toggle_div">
						<label class="lx_toggle">
							<input type="checkbox" class="fliplist_sponsored_category" id="fliplist_sponsored_category" name="fliplist_sponsored_category" disabled >
							<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
							<span class="on toggle_on"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
						</label>
					</div>
					<div class="col-md-3">
						<label class="featured_text">Featured&nbsp;</label>
					</div>
					<?php 
					$feature_checked = '';
					if( in_category('featured',$fliplist_id) == 1 ){
						$feature_checked = 'checked';
					}
					?>
					<div class="col-md-3 toggle_div">
						<label class="lx_toggle">
							<input type="checkbox" <?php if(!empty($defaultlist)){echo 'disabled';} ?> class="fliplist_featured_category" id="fliplist_featured_category" name="fliplist_featured_category" <?php echo $feature_checked;?> >
							<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
							<span class="on toggle_on"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
						</label>
					</div>
				</div>
			</div>
			<div class="form-group title_div">
				<input type="text" <?php if(!empty($defaultlist)){echo 'readonly';} ?>  class="form-control fliplist_title" maxlength="80" id="fliplist_title" name="fliplist_title" value="<?php isset($title)? print $title:'';?>" placeholder="Click to add the Fl1plist Title">
				<div class="textarea_max_chars">
					<small class="small_txt_right"><span id="fliplist_title_chars">80</span> characters remaining</small>
				</div>
			</div>
			<div class="form-group title_div">
				<strong>Subtitle</strong>
				<input type="text" <?php if(!empty($defaultlist)){echo 'readonly';} ?>  class="form-control fliplist_subtitle" maxlength="80" id="fliplist_subtitle" name="fliplist_subtitle" value="<?php isset($subtitle)?print $subtitle:'';?>" placeholder="Click to add a Fl1plist Subtitle (optional)">
				<div class="textarea_max_chars">
					<small class="small_txt_right"><span id="fliplist_subtitle_chars">80</span> characters remaining</small>
				</div>
			</div>
			<div class="form-group">
				<strong>Fl1plist description</strong>
				<textarea type="text" <?php if(!empty($defaultlist)){echo 'readonly';} ?>  class="form-control fliplist_description" maxlength="800" id="fliplist_description" name="fliplist_description" placeholder="Click to add a description of your Fl1plist"><?php echo $description;?></textarea>
				<div class="textarea_max_chars">
					<small>
						<a href="javascript:void(0);" data-toggle="popover" title="Tips for formatting" id="formatting-popover" data-placement="bottom"><span>Tips for formatting</span></a>
						<div id="formatting-popover-content" class="popover-content">
							<b>Bold</b> = *enter text here*<br>
							<i>Italic</i> = _enter text here_<br>
							Next line = ENTER<br>
							Next paragraph = {N} enter text here<br>
						</div>
					</small>
					<small class="small_txt_right">
						<span id="fliplist_description_chars">800</span> characters remaining
					</small>
				</div>
			</div>
		</div>
	</div>
<?php	
}

/* Fliplist Display Location Lite UI */
function DisplayLocationLiteUI(){ 
	$fliplist_id = isset($_POST['fliplist_id'])?$_POST['fliplist_id']:'';
	$defaultlist = get_post_meta( $fliplist_id ,'registertimelist' , true );
?>
	<div class="col-md-4">
		<div style="border-bottom:1px solid #ccc;">
			<strong>DISPLAY LOCATIONS</strong>
		</div>
		<br>
		<div class="form-group pt-2">
			<strong>Where would you like to display the Fl1plist?</strong>
			<select class="form-control display_in fliplist_select" id="display_in" name="display_in" style="font-size: 14px;">
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
			?>
			<div class="row">
				<?php 
				foreach( $get_subcategofparent as $contentcat ){
					$ccat_checked = '';
					if( in_category($contentcat->slug,$fliplist_id) == 1 ){
						$ccat_checked = 'checked';
					}
				?>
				<div class="col-md-6">
					<label for="cc_<?php echo $contentcat->slug;?>">
						<input type="checkbox" <?php if(!empty($defaultlist)){echo "style='pointer-events: none;'";} ?> id="chk_content_category" name="chk_content_categories[]" value="<?php echo $contentcat->term_id;?>" <?php echo $ccat_checked;?>/> <?php echo $contentcat->name;?>
					</label>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php
}

/* Fliplist Bottom UI */
function Fl1plistBottomUI(){
	$fliplist_id = isset($_POST['fliplist_id']) ? $_POST['fliplist_id']:'';
	if( empty($fliplist_id) ){
		$mode = 'add';
		$btn_draft_text = 'SAVE AS DRAFT';
		$btn_publish_text = 'PUBLISH';
	}else{
		$mode = 'edit';
		$fliplist_status = get_post($fliplist_id)->post_status;
		if( $fliplist_status == 'draft' ){
			$btn_draft_text = 'SAVE AS DRAFT';
			$btn_publish_text = 'PUBLISH';
		}else if($fliplist_status == 'publish'){
			$btn_draft_text = 'UNPUBLISH';
			$btn_publish_text = 'UPDATE';
		}
	}
?>
</div>
<div class="mt-2 fliplist_tab_bottom">
	<div class="fliplist_tab_inner_bottom">
		<div class="fliplist_bottom_button">
			<button type="submit" class="btn_normal_state status_draft"><?php echo $btn_draft_text; ?></button>
			<button type="submit" class="btn_normal_state status_publish"><?php echo $btn_publish_text; ?></button>
			<button type="button" class="btn_dark_state btn_cancel_fliplist">CANCEL</button>
		</div>
	</div>
	</div>
</form>
</div>
<input type="hidden" class="hidden_back_link_fliplist" value="<?php echo  $_SERVER['HTTP_REFERER'];?>"/>
</div>
<input type="hidden" class="hid_fliplist_img_click" value="">
<div class="alert" role="alert"></div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="modalLabel">Crop the image</h5>
		<button type="button" class="close fliplist_cropping_close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		<div class="img-container" style="margin:50px;">
		  <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
		</div>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn_normal_state" id="fliplist_crop_image_btn">Crop</button>
	  </div>
	</div>
  </div>
</div>
<?php
}

/* Fliplist File Validation */
function fliplist_file_validation($file){
	$error = '';
	$filename = $file['name'];
	$fileExt = explode('.', $filename)[1];
	if((!empty($file)) && ($file["error"] == 0)){
        if($fileExt != "jpg" && $fileExt != "jpeg" && $fileExt != "png" && $fileExt != "gif"){
            $error = "Sorry, only JPG, JPEG, PNG files are allowed.";
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

function DeleteFlipDataOnRefresh( $recording_id ){
	global $s3_settings;
	if(!empty($s3_settings)):
	$bucket = $s3_settings['s3_bucket'];
	$s3 = vw_lx_s3_uploadto_s3();
	
	/** remove multiple image **/
	$mulimg = get_post_meta($recording_id , 'recording_multiple_image_path',true );
	if(!empty($mulimg)){
		foreach( $mulimg as $data ){
			$s3->deleteObject([
				'Bucket' => $bucket,
				'Key'    => 'site-assets/fl1p-recording/'.$recording_id.'/slider/'.urldecode( basename($data['original']) )
			]);
			$s3->deleteObject([
				'Bucket' => $bucket,
				'Key'    => 'site-assets/fl1p-recording/'.$recording_id.'/slider/'.urldecode( basename($data['resized']) )
			]);
		}
	}
	
	update_post_meta($recording_id,'recording_multiple_image_path',array());
	
	/** remove the multiple pdfs **/
	$mulpdfs = get_post_meta( $recording_id, 'recordingpdf_upload', true);
	
	if(!empty($mpdfdata)){
		foreach( $mulpdfs as $mpdfdata ){
			$s3->deleteObject([
				'Bucket' => $bucket,
				'Key'    => 'site-assets/fl1p-recording/'.$recording_id.'/pdf/'.urldecode( basename($mpdfdata) )
			]);
		}
	}
	update_post_meta($recording_id,'recordingpdf_upload',array()); 
	
	/** Remove the Recording **/
	$audio = get_post_meta($recording_id,'flip_recording_audio',true);
	if(!empty($audio)){
		$s3->deleteObject([
			'Bucket' => $bucket,
			'Key'    => 'site-assets/fl1p-recording/'.$recording_id.'/audio/'.urldecode( basename($audio) )
		]);
	}
	update_post_meta($recording_id,'flip_recording_audio',array()); 
	
	/** Remove the Thumbnail **/
	$thumbnail = get_post_meta($recording_id,'thumbnail_image',true);
	if(!empty($thumbnail)){
		foreach( $thumbnail as $key=>$thumbdata ){
			if(!empty($thumbnail[$key])){
				$s3->deleteObject([
					'Bucket' => $bucket,
					'Key'    => 'site-assets/fl1p-recording/'.$recording_id.'/thumbnail/'.urldecode( basename($thumbnail[$key]) )
				]);
			}
		}
	}
	update_post_meta($recording_id,'thumbnail_image',array()); 
	
	endif;
}

/* Flip Recording Canvas */
function FlipRecordingUI(){
	global $wpdb,$post,$color_palette,$square_icon,$frontend_icon,$lx_plugin_urls,$flipicons;
	if( !is_user_logged_in() || current_user_can('subscriber') ){
		echo "<div class='text-center' style='color:".$color_palette['red']."'>You are not allowed to view this page</div>";
		return;
	}
	$post_id = get_the_ID();
	$current_user_id = get_current_user_id();
	$flip_list_id = $_POST['fliplist_id'];
	$user = new WP_User( $current_user_id );
	if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
		foreach ( $user->roles as $role )
		?>
		<input type="hidden" value="<?php echo $role; ?>"/>
		<?php
	}
	
	$recording_id = isset($_POST['recording_id'])?$_POST['recording_id']:'';
	$author_id = $current_user_id;
	if( $recording_id == '' ){
		$temp_recording = $wpdb->get_results(" select * from ".$wpdb->prefix."posts where post_title='temp-recording' and post_type='flip_recording' and post_status='draft' and post_author='".$author_id."' ");
		
		if( empty($temp_recording) ){
			$arr = array(
					'post_type'=>'flip_recording',
					'post_status'=>'draft',
					'post_title'=>'temp-recording',
					'post_author'=>$author_id
			);
			$recording_id = wp_insert_post($arr);
		}else{
			$recording_id = $temp_recording[0]->ID;
		}
		$mode = 'add';
		$audio = get_post_meta($recording_id,'flip_recording_audio')[0];
		$isdel = DeleteFlipDataOnRefresh( $recording_id );
		if( isset($_POST['response_id']) && !empty($_POST['response_id']) ){
			$recording_id = $_POST['response_id'];
		}
	}else{
		$mode = 'edit';
		if( isset($_POST['response_id']) && !empty($_POST['response_id']) ){
			$recording_id = $_POST['response_id'];
		}
	}
	$return_url = site_url();
	if(!empty($_SERVER['HTTP_REFERER'])){
		$return_url = $_SERVER['HTTP_REFERER'];
	}
?>
<style>
.container{
	max-width:100%;
}
.site-footer{
	display:none;
}
.fliprec_favicon_lx{
	width:6%;
}
@media (max-width: 767px){
	.fliprec_favicon_lx {
		width:13%;
	}
}
.rectitlediv,.rectopbtndiv{
	width:50%;
	float:left;
}
@media (max-width: 767px){
	.rectitlediv,.rectopbtndiv{
		width:100%;
	}
}
.rectopbtndiv{
	text-align:end;
}
@media (max-width: 767px){
	.rectopbtndiv{
		text-align:inherit;
	}
}
audio{
	border: 1px solid;
    border-radius: 25px;
    color: #343a40;
}
<?php
$hex = $color_palette['blue'];
list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
$rgbcolor = $r.','.$g.','.$b;
?>
audio::-webkit-media-controls-panel {
  background-color: rgba(<?php echo $rgbcolor;?>,0.2);
}
audio::-webkit-media-controls-play-button,audio::-webkit-media-controls-mute-button{
	color:<?php echo $color_palette['blue'];?>;
	background-color:<?php echo $color_palette['blue'];?>;
	border-radius:50%;
}
</style>
<script src='<?php echo $lx_plugin_urls['lx_lms_lite'];?>addons/flip/assets/js/recorder.js'></script>
<input type="hidden" class="redcolor" value="<?php echo $color_palette['red'];?>"/>
<input type="hidden" class="trash_icon" value="<?php echo $square_icon['trash'];?>"/>
<input type="hidden" class="flip_list_idparent" name="flip_list_id" value="<?php echo $flip_list_id;?>"/>
<input type="hidden" class="recreturnurl" name="" value="<?php echo $return_url;?>"/>
<div class="container vw_flip_canvas">
	<?php 
	if( !empty($_POST['parentfliplistid']) && !empty($_POST['parentrec_id']) ){ ?>
	<form method="post" action="<?php echo get_permalink( $_POST['parentrec_id'] );?>">
		<input type="hidden" id="parentfliplistid" name="parentfliplistid" value="<?php echo $_POST['parentfliplistid']; ?>" />
		<button type="submit" class="btn_normal_state backtoplay" style="display:none;"></button>
	</form>
	<?php } ?>
	<form method="post" class="flip_recording_form">
		<input type="hidden" id="parentrec_id" name="parentrec_id" value="<?php echo $_POST['parentrec_id']; ?>">
		<input type="hidden" id="recording_id" name="recording_id" value="<?php echo $recording_id;?>">
		<input type="hidden" class="author_id" value="<?php echo $author_id;?>">
		<input type="hidden" id="mode" value="<?php echo $mode;?>">
		<input type="hidden" id="audio" value="<?php echo $audio;?>">
		<input type="hidden" id="fliprec_status" name="fliprec_status">
		<div class="mt-2 mb-4 standarized_tab">
			<div class="standarized_tab_inner_top">
				<div class="d-flex rectitlediv">
					<img id="favicon_lx" class="fliprec_favicon_lx" src="<?php echo get_stylesheet_directory_uri().'/assets/icons/favicon_learningx.png';?>">&nbsp;&nbsp;
					<div class="top_div_head" style="margin-top:auto;">
						<h6 class="head_h6">Fl1p Recording</h6>
					</div>
				</div>
				<div class="top_div_button rectopbtndiv">
					<button type="button" class="btn_normal_state status_draft flip_record_save" data-status="draft">SAVE AS DRAFT</button>
					<button type="button" class="btn_normal_state status_publish flip_record_save" data-status="publish">PUBLISH</button>
					<button type="button" class="btn_dark_state fliprec_cancel">CANCEL</button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 flipreccolone">
				<div class="form-group">
					<?php 
					$get_additional_notes = get_post_meta($recording_id,'additional_notes',true);
					$adtxtvis = 'style="display:none"';$adtxtsmplevis = '';
					if( !empty($get_additional_notes) ){
						$adtxtvis = '';
						$adtxtsmplevis = 'style="display:none"';
					}
					?>
					<div class="fliprecsampletextblock flipviewblock" <?php echo $adtxtsmplevis;?>>
						<button type="button" class="fliprecsampletextblockntn btn_normal_inverse_state m-2 allinversebtn">
							<i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
						</button>
						<div class="flipfontcenter">
							<i class="<?php echo $flipicons['text'];?>" aria-hidden="true"></i>
						</div>
					</div>
					<div class="fliprectextblockdiv" <?php echo $adtxtvis;?>>
						<textarea type="text" class="form-control fliprecadditional_notes" maxlength="2000" id="fliprecadditional_notes" name="fliprecadditional_notes" placeholder="Enter your text here..."><?php echo $get_additional_notes;?></textarea>
						<div class="textarea_max_chars">
							<small>
								<a href="javascript:void(0);" data-toggle="popover" title="Formatting Tips" id="formatting-popover" data-placement="bottom"><span>Formatting Tips</span></a>
								<div id="formatting-popover-content" class="popover-content">
									<b>Bold</b> = *enter text here*<br>
									<i>Italic</i> = _enter text here_<br>
									Next line = ENTER<br>
									Next paragraph = {N} enter text here<br>
								</div>
							</small>
							<small class="small_txt_right">
								<span id="additional_notes_chars">2000</span> characters remaining
							</small>
						</div>
					</div>
				</div>
				<div class="form-group">
					<?php 
					$allpdf = get_post_meta($recording_id,'recordingpdf_upload',true);
					$milpdf = 'style="display:none;"';$milpdfsmple = '';
					if(!empty($allpdf)){
						$milpdf = '';	
						$milpdfsmple = 'style="display:none;"';
					}
					?>
					<div class="fliprecsamplepdfblock flipviewblock" <?php echo $milpdfsmple;?>>
						<button type="button" class="fliprecsamplepdfblockbtn btn_normal_inverse_state m-2 allinversebtn">
							<i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
						</button>
						<div class="flipfontcenter">
							<i class="<?php echo $flipicons['attachment'];?>" aria-hidden="true"></i>
						</div>
					</div>
					<div class="fliprecpdfblockdiv p-2" <?php echo $milpdf;?>>
						<div class="fliprecmulpdfview">
							<?php
							$total_pdfcnt = 0;
							if(!empty($allpdf)){
								$total_pdfcnt = count($allpdf);
								foreach( $allpdf as $pdfurl ){
								?>
								<div class="row mulpdfindrow" style="margin:unset">
									<div class="col-md-10">
										<i class="<?php echo $flipicons['attachment'];?>" aria-hidden="true"></i>
										<span id="all_pdfspans"><?php echo urldecode( basename( $pdfurl ) );?></span>
									</div>
									<div class="col-md-2 d-flex justify-content-end">
										<a href="javascript:void(0);" data-pdfname="<?php echo urldecode( basename( $pdfurl ) );?>" class="btn p-0 pdftrashsingle trash_icon_pdf" style="color:<?php echo $color_palette['red'];?>" ><i class="<?php echo $square_icon['trash'];?>" aria-hidden="true"></i></a>
									</div>
								</div>
								<?php }
							} ?>
						</div>
						<div class="pdf_attach_progress pt-1">
							<div class="progress flip_progress_bar">
								<div class="progress-bar" id="fliprec_mulpdf_progress" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
								</div>
							</div>
							<div style="height: 20px;"><small id="ispdfupload" class="ispdfupload"></small></div>
							<!--<small id="emailHelp" class="form-text d-flex justify-content-end">80% uploaded</small>-->
						</div>
						<?php 
						$flippdfuploadstuff = '';
						if( $total_pdfcnt >= 2 ){
							$flippdfuploadstuff = 'style="display:none;"';	
						}
						?>
						<div class="pt-1 fliprecmulpdffielddiv" <?php echo $flippdfuploadstuff; ?>>
							<label for="fliprecmulpdfupload">
								<input type="file" class="fliprecmulpdfupload" id="fliprecmulpdfupload" hidden accept=".pdf" />
								<div class="file_upload_pdf">
									<img for="actual-btn" src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/add.png'; ?>">
								</div>
							</label>
							<span id="file-chosen">No file chosen</span>
						</div>
					</div>
				</div>
				<?php /* echo "<pre>";print_r($color_palette['hyperlinks']); */?>
			</div>
			<div class="col-md-8 flipreccoltwo">
				<div class="form-group">
					<?php 
					$sliderimage = get_post_meta($recording_id,'recording_multiple_image_path',true);
					/* echo "<pre>";print_r($sliderimage); */
					$sliderimgsmplestyle = '';$sliderimgstyle = 'style="display:none;"';
					if(!empty($sliderimage)){
						$sliderimgsmplestyle = 'style="display:none;"';
						$sliderimgstyle = '';
					}
					?>
					<div class="flirecsamplemulimageblock flipviewblock" <?php echo $sliderimgsmplestyle;?>>
						<button type="button" class="flirecsamplemulimageblockbtn btn_normal_inverse_state m-2 allinversebtn">
							<i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
						</button>
						<div class="flipfontcenter">
							<i class="<?php echo $flipicons['images'];?>" aria-hidden="true"></i>
						</div>
					</div>
					<div class="Image_block flirecmulimageblock p-3" <?php echo $sliderimgstyle;?>>
						<div class="">
							<div class="pt-1">
								<label for="recording_sliderimgagesfld"> 
									<div class="file_upload">
										<img id="recording_sliderimgages" class="recording_sliderimgages" name="recording_sliderimgages" 
										src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/add.png'; 
										?>"/>
										<input type="file" class="upload-input recording_sliderimgagesfld upload_file" id="recording_sliderimgagesfld" name="recording_sliderimgagesfld" accept="image/jpg, image/jpeg, image/png" hidden multiple />
									</div>
								</label>
							</div>
							<div class="img_list">
								<?php 
								if(!empty($sliderimage)){
									foreach( $sliderimage as $sliderimg ){
										?>
										<div class="dynamic_images">
											<div class="img_div" style="position: relative;margin: 10px;">
												<img class="recording_multi_img" src="<?php echo $sliderimg['original'];?>"/>
												<button type="button" data-img_name="<?php echo basename($sliderimg['resized']);?>" class="btn_danger_state trash_recording_img delete_multi_img" style="position: absolute;right: 0;"><i class="<?php echo $square_icon['trash'];?>" aria-hidden="true"></i></button>
											</div>
										</div>
										<?php
									}
								}
								?>
							</div>
							<div class="mt-1">
								<div class="images_attach_progress_div">
									<div class="progress flip_progress_bar">
										<div class="progress-bar" id="recording_images_progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
										</div>
									</div>
									<small id="emailHelp" class="form-text recording_images_upload_status"></small>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php 
		echo do_shortcode( '[FlipFunctionSettingsUIHK fliprec_id="'.$recording_id.'" fliplistselected="'.$flip_list_id.'"]' );
		?>
		<div class="row mt-3">
			<div class="col-md-4">
				<div class="basic_info_block flipsettingbtn" style="cursor:pointer;">
				<?php 
				$settingtabstyle = '';
				if( !empty($_POST['parentrec_id']) ){
					$settingtabstyle = 'style="padding:15px;"';
				} ?>
					<div class="basic_info_div block_border" <?php echo $settingtabstyle;?>>
						<div class="row">
							<div class="col-md-1"><i class="<?php echo $square_icon['infobox'];?> flipinfoicon" aria-hidden="true"></i></div>
							<div class="col-md-9">
								<?php
								$getsettings = get_post_meta($recording_id,'settings_array',true);
								if(isset($_POST['parentrec_id']) && !empty($_POST['parentrec_id'])){
									$getsettings = get_post_meta($_POST['parentrec_id'],'settings_array',true);
								}
								$getflipargs = array(
									'post_type' => 'flip_list',
									'post_status' => 'publish',
									'posts_per_page' => -1,
									'author' => get_current_user_ID(),
								);
								$get_flip_list = get_posts($getflipargs);
								$defaultfliplist = array();
								foreach( $get_flip_list as $fliplists ){
									if( !empty( get_post_meta($fliplists->ID,'registertimelist',true) ) ) {
										$defaultfliplist[] = $fliplists;
									}
								}
								/* echo "<pre>";print_r($defaultfliplist); */
								$set_comm = 'None';$set_myfliplist = $defaultfliplist[0]->post_title;$setcolorcomm=$color_palette['grey'];
								
								if( !empty($getsettings['communities']) ){
									$set_comm = $getsettings['communities'];
									$setcolorcomm = $color_palette['green'];
								}
								if(!empty($flip_list_id) && $mode !='edit'){
									$selcomid = get_post_meta($flip_list_id,'attach_this_fliplist',true);
									$getselcomtit = 'None';
									if(!empty($selcomid)){
										$getselcomtit = get_post($selcomid)->post_title;
									}
									$setcolorcomm = $color_palette['green'];
									$set_comm = $getselcomtit;
								}
								if(!empty($getselcomtit) && !empty($set_comm) && $set_comm !='None' && $getselcomtit !=$set_comm){
									$set_comm = 'Multiple';
								}
								if( !empty($getsettings['my_fliplist']) ){
									$set_myfliplist = $getsettings['my_fliplist'];
								}
								if(!empty($getselcomtit) && !empty($set_myfliplist)){
									$set_myfliplist = 'Multiple';
								}
								?>
								<input type="hidden" value="<?php echo $color_palette['green'];?>" class="color-green" />
								<input type="hidden" value="<?php echo $color_palette['grey'];?>" class="color-grey" />
								<?php 
								if( empty( $_POST['parentrec_id'] ) ){
									$replies = 'OFF';
									if( !empty($getsettings['replies']) ){
										$replies = $getsettings['replies'];
									}
									$repliesvis = 'Restricted';
									if( !empty($getsettings['repliesvis']) ){
										$repliesvis = $getsettings['repliesvis'];
									}
								?>
									<div>Replies: 
										<span class="fliprecsetreplies" style="color:<?php echo $color_palette['green'];?>"><?php echo $replies;?></span>
									</div>
									<div>Replies Visibility: 
										<span class="fliprecsetrest" style="color:<?php echo $color_palette['green'];?>"><?php echo $repliesvis; ?></span>
									</div>
									<?php 
								}
								if(is_plugin_active(VWPLUGIN_PRO)){
								?>
									<div>Communities: <span class="fliprecsetcomm" style="color:<?php echo $setcolorcomm;?>"><?php echo $set_comm;?></span></div>
								<?php } ?>
								<div>My Fl1plists: <span class="fliprecsetmyfliplist" style="color:<?php echo $color_palette['green'];?>"><?php echo $set_myfliplist;?></span></div>
							</div>
							<div class="col-md-1 d-flex align-items-end">
								<i class="fal fa-gear flip_icons" style="cursor:pointer;" aria-hidden="true"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<?php 
				$audiorec = '';
				if( !empty( get_post_meta( $recording_id,'flip_recording_audio',true ) ) ){
					$audiorec = get_post_meta( $recording_id,'flip_recording_audio',true );
					/* $audiorec = 'https://interactive-examples.mdn.mozilla.net/media/cc0-audio/t-rex-roar.mp3'; */
				}
				?>
				<div class="audio_control_preview">
					<audio controls controlsList="nodownload noplaybackrate" src="<?php echo $audiorec; ?>" id="auidosource">
						Your browser does not support the audio element.
					</audio>
				</div>
			</div>
		</div>
		<div class="row bg-dark">
			<div class="col-md-4">
				<div>
					<div class="form-group m-1">
						<?php 
						if( empty($_POST['parentrec_id']) ){
							$uid = get_current_user_ID();
							$rectitle = get_user_meta($uid ,'first_name',true).' '.get_user_meta($uid ,'last_name',true);
							if(empty(trim($rectitle))){
								$rectitle = get_user_by( 'id' , $uid )->user_nicename;
							}
							if( get_post($recording_id)->post_title != 'temp-recording' && !empty(get_post($recording_id)->post_title) ){
								$rectitle = get_post($recording_id)->post_title;
							}
						}
						if(isset($_POST['parentrec_id']) && !empty($_POST['parentrec_id'])){
							$rectitle = get_post($_POST['parentrec_id'])->post_title;
						}
						?>
						<div class="fliptitleprevdiv" style="color:#fff;font-size:20px;">
							<span class="fliptitleprevdivspan"><?php echo $rectitle;?></span>
							<?php if( empty($_POST['parentrec_id']) ){
								?>
								<i style="float:right;font-size: 14px;cursor:pointer;" class="<?php echo $square_icon['edit'];?> edittitlebtn"></i>
								<?php
							}?>
						</div>
						<div class="fliptitlefielddiv" style="display:none;">
							<input type="text" class="form-control inp_title fliprectitle" id="" value="<?php echo $rectitle;?>" placeholder="Fl1p Recording Title">
						</div>
					</div>
					<div class="form-group m-1">
						<?php 
						if( empty($_POST['parentrec_id']) ){
							$subtitle = date('jS F Y - h:i A',strtotime( get_post( $recording_id )->post_date ));
							if( !empty(get_post_meta($recording_id,'subtitle',true)) ){
								$subtitle = get_post_meta($recording_id,'subtitle',true);
							}
						}
						if(isset($_POST['parentrec_id']) && !empty($_POST['parentrec_id'])){
							$subtitle = get_post_meta($_POST['parentrec_id'],'subtitle',true);
						}
						?>
						<div class="flipsubtitleprevdiv" style="color:#fff;">
							<?php echo $subtitle;?>
						</div>
						<div class="flipsubtitlefielddiv" style="display:none;">
							<input type="text" class="form-control inp_subtitle fliprecsubtit" id="" value="<?php echo $subtitle;?>" placeholder="Fl1p Recording Subtitle">
						</div>
					</div>
				</div>
			</div>
			<?php if(isset($_POST['parentrec_id']) && !empty($_POST['parentrec_id']) ){ ?>
			<div class="col-md-4">
				<div>
					<div class="form-group m-1">
						<?php 
						$uid = get_current_user_ID();
						$resrectitle = get_user_meta($uid ,'first_name',true).' '.get_user_meta($uid ,'last_name',true);
						if(empty(trim($resrectitle))){
							$resrectitle = get_user_by( 'id' , $uid )->user_nicename;
						}
						if( get_post($recording_id)->post_title != 'temp-recording' && !empty(get_post($recording_id)->post_title) ){
							$resrectitle = get_post($recording_id)->post_title;
						}
						?>
						<div class="fliprestitleprevdiv" style="color:#fff;font-size:20px;">
							<span class="fliprestitleprevdivspan"><?php echo $resrectitle;?></span>
							<i style="float:right;font-size: 14px;cursor:pointer;" class="<?php echo $square_icon['edit'];?> editrestitlebtn"></i>
						</div>
						<div class="fliprestitlefielddiv" style="display:none;">
							<input type="text" class="form-control inp_title flipresrectitle" id="" value="<?php echo $resrectitle;?>" placeholder="Fl1p Response Recording Title">
						</div>
					</div>
					<div class="form-group m-1">
						<?php 
						$resrecsubtitle = date('jS F Y - h:i A',strtotime( get_post( $recording_id )->post_date ));
						if( !empty(get_post_meta($recording_id,'subtitle',true)) ){
							$resrecsubtitle = get_post_meta($recording_id,'subtitle',true);
						}
						?>
						<div class="flipressubtitleprevdiv" style="color:#fff;">
							<?php echo $resrecsubtitle;?>
						</div>
						<div class="flipressubtitlefielddiv" style="display:none;">
							<input type="text" class="form-control inp_subtitle flipresrecsubtitle" id="" value="<?php echo $resrecsubtitle;?>" placeholder="Fl1p Response Recording Subtitle">
						</div>
					</div>
				</div>
			</div>
			<?php
				}
			?>
			<div class="<?php if(isset($_POST['parentrec_id']) && !empty($_POST['parentrec_id']) ){ echo 'col-md-4';}else{ echo 'col-md-8';}?>">
				<div class="d-flex recording_tools_main_div">
					<div class="text-center">
					<?php 
					$audiogt = get_post_meta($recording_id,'flip_recording_audio',true);
					/* echo "<pre>";print_r($audiogt); */
					$isdelete = 'disabled="disabled"';$is_start = '';$rectxt = '';
					if(!empty($audiogt)){
						$isdelete = '';
						/* $is_start = 'disabled="disabled"'; */
						/* $rectxt = 'style="display:none;"'; */
					}
					?>
					
						<input type="hidden" class="pauseicon" value="<?php echo $flipicons['pause'];?>">
						<input type="hidden" class="starticon" value="<?php echo $flipicons['audio_recording'];?>">
						<input type="hidden" class="reclap" value="1">
						<button type="button" class="btn rst_audio_btn audio_start" <?php echo $is_start;?> id="audio_start"><i class="<?php echo $flipicons['audio_recording'];?>" aria-hidden="true"></i></button>
						<button type="button" class="btn rst_audio_btn audio_pause" id="audio_pause" style="display:none;"><i class="<?php echo $flipicons['pause'];?>" aria-hidden="true"></i></button>
						<button type="button" class="btn rst_video_btn" disabled><i class="<?php echo $flipicons['video'];?>" aria-hidden="true"></i></button>
						<button type="button" class="btn rst_upload_btn" disabled><i class="<?php echo $flipicons['uploadtocloud'];?>" aria-hidden="true"></i></button>
					</div>
					<div class="flip_recording_progress_div d-flex align-items-center">
						<div class="progress flip_recording_progress_bar" style="margin-top: -10px;">
							<div class="progress-bar" id="flip_recording_progress" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
							</div>
						</div>
						<small id="emailHelp" class="form-text flip_recording_upload_status" style="margin-top: -10px;"></small>
						<small id="emailHelp" class="form-text flip_recording_progress_text" style="margin-top: -10px;"></small>
					</div>
				</div>
				<input type="hidden" id="ResetStaus" value="0">
				<div class="d-flex center_div">
					<div class="p-1">
						<div class="text-center text-white">
							<span class="rectooltxt" <?php echo $rectxt; ?>>Recording Tools</span>
							<div class="recording" id="aud-record-status">
								<div><strong id="timer"></strong></div>
								<div id="timer_text">of 15:00 max</div>
							</div>
							<!--<span>of 15:00 max</span> -->
						</div>
					</div>
					<div class="align-items-center d-flex">
						<div class="p-2" style="margin-left: 20px;">
							<button type="button" class="btn btn-light m-1 save_recording_icon btn_save_recording" id="btn_save_recording" disabled="disabled"><i class="<?php echo $square_icon['save'];?>" aria-hidden="true"></i></button>
							
							<button type="button" class="btn btn-light m-1 delete_recording_icon btn_delete_recording" data-id="<?php echo $recording_id;?>" <?php echo $isdelete; ?>><i class="<?php echo $square_icon['trash'];?>" aria-hidden="true"></i></button>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</form>
<input type="hidden" class="hidden_back_link_recording" value="<?php echo  $_SERVER['HTTP_REFERER'];?>"/>
</div>
<script src='<?php echo $lx_plugin_urls['lx_lms_lite'] . '/addons/flip/assets/js/audio.js'?>' ></script>
<?php	
}
function FlipFunctionSettingsUI( $atts ) {
	global $wpdb,$square_icon,$color_palette,$lx_plugin_urls;
	$total_fliplist = get_post_meta( $atts['fliprec_id'] , 'total_fliplist', true );
	$selectedfliplist = $atts['fliplistselected'];
	$all_community_fliplist = array();
	if( !empty($total_fliplist) ){
		foreach( $total_fliplist as $listids ){
			$display_in = get_post_meta($listids,'display_in',true);
			$is_commtitle = 'none';
			if( $display_in == 'in_community' ){
				$all_community_fliplist[] = $listids;
			}
		}
	}
	$mycommfliplistvis = 'style="display:none"';
	if( !empty($all_community_fliplist) ){
		$mycommfliplistvis = '';
	}
	/* echo "<pre>";print_r($all_community_fliplist); */
	?>
	<style>
	.flip_progress_bar{
		height: 0.7rem;
		background: #FFFFFF;
		border: 1px solid <?php echo $color_palette['border'];?>;
	}
	.fliplistthumbedit{
		position:absolute;
		right:0px;
		top: 0;
		cursor:pointer;
	}
	</style>
	<div class="modal fade" id="flipsettingmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Configuration & Settings</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="label"><strong>Thumbnail</strong>
							<div class="fliprecthumbdiv" style="position:relative">
								<div class="btn_normal_state fliplistthumbedit"><i class="<?php echo $square_icon['edit'];?>"></i></div>
								<?php 
								$recthumbimg = $lx_plugin_urls['lx_lms_lite'].'assets/img/flip_thumbnail.png';
								if( !empty(get_post_meta($atts['fliprec_id'],'thumbnail_image',true)) ){
									$recthumbimg = get_post_meta($atts['fliprec_id'],'thumbnail_image',true)['cropped'];
								}
								?>
								<img id="recording_img" class="recording_img" name="recording_img" src="<?php echo $recthumbimg; ?>"/>
							</div>
							<div class="fliplist_thumb_input">
								<input type="file" class="upload-input fliprecording_thumbnail" id="fliprecording_thumbnail" name="fliprecording_thumbnail" accept="image/jpg, image/jpeg, image/png"/>		
							</div>
						</label>
						<div class="form-group thumbnail_progress_main_div">
							<div class="progress flip_progress_bar">
								<div class="progress-bar" id="fliprec_thumb_progress" role="progressbar" aria-valuenow="25" aria-valuemin="0"
									aria-valuemax="100">
								</div>
							</div>
							<div class="d-flex justify-content-end" style="position:relative">
								<div style="position: absolute;left: 0;"><small id="emailHelp" class="form-text fliprec_thumb_upload_status"></small></div>
								<div><small id="emailHelp" class="form-text upload_thumb_txt">Upload Thumbnail</small></div>
							</div>
						</div>
						<?php
						$current_user_id = get_current_user_id();
						?>
						<input type="hidden" value="<?php echo $flip_list_id;?>"/>
						<input type="hidden" class="trash_icon" value="<?php echo $square_icon['trash'];?>"/>
						<?php 
						if( empty( $_POST['parentrec_id'] ) ){ 
							$settting_arr = get_post_meta($recording_id,'settings_array',true);
							$replies_checked='';$repliesvis_checked='';
						
							$repliesvis_disabled='disabled';$repliesvis_txt='color:#CCC';
							if( $settting_arr['replies'] == 'ON' ){
								$repliesvis_disabled='';
								$repliesvis_txt='';
							}
							if( !empty($settting_arr) ){
								if( $settting_arr['replies'] == 'ON' ){
									$replies_checked='checked';
								}
								if( $settting_arr['replies'] == 'OFF' ){
									$repliesvis_disabled='disabled';
									$repliesvis_txt='color:#CCC';
								}
								if( $settting_arr['repliesvis'] == 'Open' ){
									$repliesvis_checked='checked';
								}
							}
						?>
						<div class="form-group d-flex ai_center m-0">
							<div>
								<label class="lx_toggle flip_recording_toggles">
									<input type="checkbox" class="replies_chk" id="replies_chk" name="replies_chk" <?php echo $replies_checked; ?> >
									<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
									<span class="on toggle_on"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
								</label>
							</div>
							<div class="p-1">
								<strong>Allow Replies / Responses</strong>
							</div>
						</div>
						<div class="form-group d-flex ai_center">
							<div>
								<label class="lx_toggle flip_recording_toggles">
									<input type="checkbox" class="replies_visiblility_chk" id="replies_visiblility_chk" name="replies_visiblility_chk" value="<?php if( !empty($settting_arr['repliesvis']) ){ echo $settting_arr['repliesvis']; }?>" <?php echo $repliesvis_checked; echo $repliesvis_disabled; ?>>
									<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
									<span class="on toggle_on"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
								</label>
							</div>
							<div class="p-1">
								<strong class="repliesvis_text_clr" style="<?php echo $repliesvis_txt; ?>">Replies / Responses are visible to everyone (default id ONLY Admin/Owner/Manager)</strong>
							</div>
						</div> 
						
						<div class="form-group pt-4" style="position:relative;">
							<label for="add_to_this_fliplist">Add to a Fl1plist</label>
							<div class="selectadd_fliplists">Your Fliplist <i class="fa-solid fa-angle-down fliplistangledown"></i></div>
							<div class="add_to_this_fliplist_div" style="display:none;">
								<?php 
								$getflipargs = array(
									'post_type' => 'flip_list',
									'post_status' => 'publish',
									'posts_per_page' => -1,
									'author' => $current_user_id,
								);
								$get_flip_list = get_posts($getflipargs);
								
								$onlycatposts = array();
								foreach( $get_flip_list as $fliplists ){
									if( get_post_meta($fliplists->ID,'display_in',true) != 'in_community' ){
										$onlycatposts[] = $fliplists;
									}
								}
								if(!empty($onlycatposts)){
								foreach( $onlycatposts as $fliplists ){
									$flipid = $fliplists->ID;
									$fliptitle = $fliplists->post_title;
									$display_in = get_post_meta($flipid,'display_in',true);
									$is_commtitle = 'none';
									if( $display_in == 'in_community' ){
										$is_commid = get_post_meta($flipid,'attach_this_fliplist',true);
										$is_commtitle = get_post( $is_commid )->post_title;
									}
									$selected_comm = '';$styleselcom="";
									if(!empty($total_fliplist)){
										if( in_array($flipid,$total_fliplist) ){
											$selected_comm = 'mycommfliplistselected';
											$styleselcom = 'style="background-color:'.$color_palette['border'].'"';
										}
									}
									if( $display_in != 'under_catgeory' ){
										$display_in = 'under_catgeory';
										$selected_comm = 'mycommfliplistselected';
										$styleselcom = 'style="background-color:'.$color_palette['border'].';display:none"';
									}
									if( $display_in != 'under_catgeory' && $display_in != 'in_community' ){
										$display_in = 'under_catgeory';
										$selected_comm = 'mycommfliplistselected';
										$styleselcom = 'style="background-color:'.$color_palette['border'].';display:none"';
									}
									if(count($onlycatposts) == 1 && $fliptitle=='My Flip Recordings'){
										echo 'No Flip List';
									}
									/* echo count($onlycatposts); */
								?>
								<div class="indfliplists indfliplists<?php echo $flipid;?> <?php echo $selected_comm;?>" data-bordercolor="<?php echo $color_palette['border'];?>" data-fliptitle="<?php echo $fliptitle;?>" data-flipid="<?php echo $flipid;?>" data-display_in="<?php echo $display_in;?>" data-commtitle="<?php echo $is_commtitle;?>" <?php echo $styleselcom;?> ><?php echo $fliptitle; ?></div>
								<?php }}else{
									echo "<span class='p-2'>No Flip List</span>";
								} ?>
							</div>
						</div>
						<small><i>This recording appears in:</i></small>
						<div class="mt-3">
							<div class="col-md-12 all_playlist">
								<b>My Fl1plist/s</b>
							</div>
							<div class="flipmyredsplaylistdiv" style="margin:auto;">
								<?php 
								$defaultfliplist = array();
								foreach( $get_flip_list as $fliplists ){
									if( !empty( get_post_meta($fliplists->ID,'registertimelist',true) ) ) {
										$defaultfliplist[] = $fliplists;
									}
								}
								/* echo "<pre>";print_r($defaultfliplist); */
								if(!empty($defaultfliplist)){
								?>
									<div class='row myplaylistdivind myplaylistdivind<?php echo $defaultfliplist[0]->ID;?>' data-flipid='<?php echo $defaultfliplist[0]->ID;?>'><div class="col-md-12 myplayfliplistind<?php echo $defaultfliplist[0]->ID;?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $defaultfliplist[0]->post_title;?></div></div>
								<?php
								}
								if(!empty($total_fliplist)){
									foreach( $total_fliplist as $listids ){
										if( $defaultfliplist[0]->ID != $listids ){
											?>
											<div class='row myplaylistdivind myplaylistdivind<?php echo $listids;?>' data-flipid='<?php echo $listids;?>'><div class='col-md-12 myplayfliplistind<?php echo $listids;?>'><i class='<?php echo $square_icon['trash'];?> deletemyplayfliplist' data-flip-id='<?php echo $listids;?>'></i> <?php echo get_post( $listids )->post_title;?></div></div>
											<?php
										}
									}
								}elseif(!empty($selectedfliplist) && $defaultfliplist[0]->ID != $selectedfliplist ){
									?>
									<div class='row myplaylistdivind myplaylistdivind<?php echo $selectedfliplist;?>' data-flipid='<?php echo $selectedfliplist;?>'><div class='col-md-12 myplayfliplistind<?php echo $selectedfliplist;?>'><i class='<?php echo $square_icon['trash'];?> deletemyplayfliplist' data-flip-id='<?php echo $selectedfliplist;?>'></i> <?php echo get_post( $selectedfliplist )->post_title;?></div></div>
									<?php
								}
								?>
							</div>
						</div>
					<?php
						}
					?>	
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="fliprecthumbnailmodal">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Crop the image</h5>
				<button type="button" class="close fliprec_cropping_close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<div class="img-container" style="margin:50px;">
				  <img id="tofliprecimage" src="https://avatars0.githubusercontent.com/u/3456749">
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn_normal_state" id="fliprec_crop_image_btn">Crop</button>
			  </div>
			</div>
		  </div>
	</div>
	<?php
}
add_shortcode( 'FlipFunctionSettingsUIHK', 'FlipFunctionSettingsUI', 20 );