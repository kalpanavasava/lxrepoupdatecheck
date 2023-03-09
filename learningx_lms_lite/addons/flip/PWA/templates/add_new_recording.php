<?php 
global $wpdb,$color_palette,$lx_plugin_urls,$square_icon,$flipicons;
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
.pwaaudiouploadbtndis,.pwaaudiouploadbtndis:hover{
	color:<?php echo $color_palette['grey'];?>;
	background-color: <?php echo $color_palette['light_grey'];?>;
	border:1px solid<?php echo $color_palette['mid_grey'];?>;
}
.pwacapturedimage{
	width:50%;
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
<?php 
include FL1PPATH . '/assets/css/flip_css.php';
?>
<link href='<?php echo $lx_plugin_urls['lx_lms_lite'];?>addons/flip/assets/css/flip.css' />
<script src='<?php echo $lx_plugin_urls['lx_lms_lite'];?>addons/flip/assets/js/recorder.js'></script>
<input type="hidden" class="redcolor" value="<?php echo $color_palette['red'];?>"/>
<input type="hidden" class="trash_icon" value="<?php echo $square_icon['trash'];?>"/>
<input type="hidden" class="flip_list_idparent" name="flip_list_id" value="<?php echo $flip_list_id;?>"/>
<input type="hidden" class="recreturnurl" name="" value="<?php echo $return_url;?>"/>
<input type="hidden" class="pwa_unique" value="" />
<div class="container vw_flip_canvas">
	<form method="post" class="flip_recording_form">
		<input type="hidden" id="recording_id" name="recording_id" value="<?php echo $recording_id;?>">
		<input type="hidden" class="author_id" value="<?php echo $author_id;?>">
		<input type="hidden" id="mode" value="<?php echo $mode;?>">
		<input type="hidden" id="audio" value="<?php echo $audio;?>">
		<input type="hidden" id="backlink" value="<?php echo site_url().'/pwa-fl1plist/';?>">
		<div class="mt-2 mb-4 standarized_tab">
			<div class="standarized_tab_inner_top">
				<div class="d-flex rectitlediv">
					<img id="favicon_lx" class="fliprec_favicon_lx" src="<?php echo get_stylesheet_directory_uri().'/assets/icons/favicon_learningx.png';?>">&nbsp;&nbsp;
					<div class="top_div_head" style="margin-top:auto;">
						<h6 class="head_h6">Fl1p Recording</h6>
					</div>
				</div>
				<div class="top_div_button rectopbtndiv">
					<button type="button" class="btn_normal_state pwaflip_record_save" data-status="publish">PUBLISH</button>
					<a href="<?php echo site_url().'/pwa-fl1plist/';?>"><button type="button" class="btn_dark_state pwafliprec_cancel">CANCEL</button></a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 flipreccolone">
				<div class="form-group">
					<button type="button" class="btn_normal_state pwa_captureimagestart">Camera</button><button type="button" class="btn_normal_state pwa_captureimagestop" style="display:none;">Click to Capture</button>
					<label for="pwarecording_sliderimgagesfld"> 
						<div class="">
							<div class="btn_normal_state pwa_galleryimage" style="cursor:pointer;" id="recording_sliderimgages">Gallery</div>
							<input type="file" class="upload-input pwarecording_sliderimgagesfld upload_file" id="pwarecording_sliderimgagesfld" name="pwarecording_sliderimgagesfld" accept="image/jpg, image/jpeg, image/png" hidden multiple />
						</div>
					</label>				
					<div class="pwa_cameratoggle" style="display:none;">
						<div><strong>Front and back</strong></div>
						<label class="lx_toggle">
							<input type="checkbox" class="pwa_cameraenv" id="pwa_cameraenv" name="pwa_cameraenv">
							<span class="off" style="top: 60px;"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
							<span class="on" style="display:none;top: 60px;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
						</label>				
					</div>
					<video id="capturevideo" class="mt-2" style="display:none;width:100%;"></video>
					<canvas id="capturecanvas" class="mt-2" style="display:none;"></canvas>
					<div class="pwacapturedimagediv mt-2">
					</div>
				</div>
				<div class="form-group">
					<div class="fliprecsampletextblock flipviewblock">
						<button type="button" class="fliprecsampletextblockntn btn_normal_inverse_state m-2 allinversebtn">
							<i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
						</button>
						<div class="flipfontcenter">
							<i class="<?php echo $flipicons['text'];?>" aria-hidden="true"></i>
						</div>
					</div>
					<div class="fliprectextblockdiv" style="display:none">
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
				
				<?php /* echo "<pre>";print_r($color_palette['hyperlinks']); */?>
			</div>
			<div class="col-md-8 flipreccoltwo">
				<div class="form-group">
					<?php 
					/* $sliderimage = get_post_meta($recording_id,'recording_multiple_image_path',true);
					$sliderimgsmplestyle = '';$sliderimgstyle = 'style="display:none;"';
					if(!empty($sliderimage)){
						$sliderimgsmplestyle = 'style="display:none;"';
						$sliderimgstyle = '';
					} */
					?>
					<div class="flirecsamplemulimageblock flipviewblock" style="display:none;">
						<button type="button" class="flirecsamplemulimageblockbtn btn_normal_inverse_state m-2 allinversebtn">
							<i class="<?php echo $square_icon['plus'];?>" aria-hidden="true"></i>
						</button>
						<div class="flipfontcenter">
							<i class="<?php echo $flipicons['images'];?>" aria-hidden="true"></i>
						</div>
					</div>
					<div class="Image_block flirecmulimageblock p-3">
						<div class="">
							<?php 
							/* <div class="pt-1 pwasliderimageuploaddiv">
								<label for="pwarecording_sliderimgagesfld"> 
									<div class="file_upload">
										<img id="recording_sliderimgages" class="recording_sliderimgages" name="recording_sliderimgages" 
										src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/add.png'; 
										?>"/>
										<input type="file" class="upload-input pwarecording_sliderimgagesfld upload_file" id="pwarecording_sliderimgagesfld" name="pwarecording_sliderimgagesfld" accept="image/jpg, image/jpeg, image/png" hidden multiple />
									</div>
								</label>
							</div> */
							?>
							<div class="img_list" style="height:258px;">
								<?php 
								/* if(!empty($sliderimage)){
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
								} */
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="config_and_setting_block d-none">
				<div>
					<h6 class="d-flex align-items-center">
						<i class="fa-solid fa-gear attach_icon-bg" aria-hidden="true"></i>
						<span class="pl-1">Configuration & Setting</span>
					</h6>
				</div>
				<div class="block_border">
					<div>
						<label for="actual-btn"> 
							<input type="file" id="actual-btn" hidden />
							<img src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/img/add.png'; ?>">
							<!--<button class="btn btn_edit"><i class="fa fa-pencil" aria-hidden="true"></i></button>-->
						</label>
						<div class="form-group  default_img_attach_progress">
							<div class="progress flip_progress_bar">
								<div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
								</div>
							</div>
							<small id="emailHelp" class="form-text"></small>
						</div>
					</div>
					<div class="form-group d-flex ai_center m-0">
						<div>
							<label class="lx_toggle flip_recording_toggles">
								<input type="checkbox" class="turncommunitywebhookon_pro" id="turncommunitywebhookon_pro" name="turncommunitywebhookon_pro" disabled>
									<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
									<span class="on toggle_on"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
							</label>
						</div>
						<div class="p-1">
							<strong>Allow Replies/ Responses</strong>
						</div>
					</div>
					<div class="form-group d-flex ai_center m-0">
						<div>
							<label class="lx_toggle flip_recording_toggles">
								<input type="checkbox" class="turncommunitywebhookon_pro" id="turncommunitywebhookon_pro" name="turncommunitywebhookon_pro" <?php echo $add_setting;?> disabled>
									<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
									<span class="on toggle_on"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
							</label>
						</div>
						<div class="p-1">
							<strong>Replies/ Responses are visible to everyone (default id ONLY Admin/Owner/Manager)</strong>
						</div>
					</div>
					<?php
					/* $flip_list_id */
					if( !is_plugin_active(VWPLUGIN_PRO) ){ 
					?>
					<div class="form-group pt-4">
						<label for="add_to_this_fliplist">Add to a Fl1plist</label>
					</div>
					<?php
					}else{
						RecordingCommunityRelatedUI($flip_list_id);
					} 
					?>
					
				</div>
			</div>
		</div>
		<!-- Modal -->
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
						<h5 class="modal-title" id="exampleModalLabel">Confirguration & Settings</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label class="label"><strong>Thumbnail</strong>
								<div class="fliprecthumbdiv" style="position:relative">
									<?php /* <div class="btn_normal_state fliplistthumbedit"><i class="<?php echo $square_icon['edit'];?>"></i></div> */ ?>
									<?php 
									$recthumbimg = $lx_plugin_urls['lx_lms_lite'].'assets/img/flip_thumbnail.png';
									if( !empty(get_post_meta($atts['fliprec_id'],'thumbnail_image',true)) ){
										$recthumbimg = get_post_meta($atts['fliprec_id'],'thumbnail_image',true)['cropped'];
									}
									?>
									<img id="recording_img" class="recording_img" name="recording_img" src="<?php echo $recthumbimg; ?>"/>
								</div>
								<?php /* <div class="fliplist_thumb_input">
									<input type="file" class="upload-input fliprecording_thumbnail" id="fliprecording_thumbnail" name="fliprecording_thumbnail" accept="image/jpg, image/jpeg, image/png"/> </div> */ ?>
								
							</label>
							<?php
							$current_user_id = get_current_user_id();
							?>
							<input type="hidden" value="<?php echo $flip_list_id;?>"/>
							<input type="hidden" class="trash_icon" value="<?php echo $square_icon['trash'];?>"/>
							<small><i>This recording appears in:</i></small>
							<div class="">
								<div class="col-md-12 all_playlist">
									<b>My Playlist/s</b>
								</div>
								<div class="flipmyredsplaylistdiv" style="margin:auto;">
									<?php 
									$getsettings = get_post_meta($recording_id,'settings_array',true);
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
									?>
									<div class='row myplaylistdivind myplaylistdivind<?php echo $defaultfliplist[0]->ID;?>' data-flipid='<?php echo $defaultfliplist[0]->ID;?>'><div class="col-md-12 myplayfliplistind<?php echo $defaultfliplist[0]->ID;?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $defaultfliplist[0]->post_title;?></div></div>
												
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Modal -->
		
		<div class="row mt-3">
			<div class="col-md-4">
				<div class="basic_info_block flipsettingbtn" style="cursor:pointer;">
					<div class="basic_info_div block_border">
						<div class="row">
							<div class="col-md-1"><i class="<?php echo $square_icon['infobox'];?> flipinfoicon" aria-hidden="true"></i></div>
							<div class="col-md-9">
								
								<div>Replies: <span class="fliprecsetreplies" style="color:<?php echo $color_palette['green'];?>">OFF</span></div>
								<div>Replies Visibility: <span class="fliprecsetrest" style="color:<?php echo $color_palette['green'];?>">Restricted</span></div>
								<div>Communities: None</div>
								<div>My Fl1plists: <span class="fliprecsetmyfliplist" style="color:<?php echo $color_palette['green'];?>"><?php echo $defaultfliplist[0]->post_title;?></span></div>
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
				/* $audiorec = '';
				if( !empty( get_post_meta( $recording_id,'flip_recording_audio',true ) ) ){
					$audiorec = get_post_meta( $recording_id,'flip_recording_audio',true );
				} */
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
						$uid = get_current_user_ID();
						$rectitle = get_user_meta($uid ,'first_name',true).' '.get_user_meta($uid ,'last_name',true);
						if(empty(trim($rectitle))){
							$rectitle = get_user_by( 'id' , $uid )->user_nicename;
						}
						
						if( get_post($recording_id)->post_title != 'temp-recording' && !empty(get_post($recording_id)->post_title) && !empty($recording_id) ){
							$rectitle = get_post($recording_id)->post_title;
						}
						?>
						<div class="fliptitleprevdiv" style="color:#fff;font-size:20px;">
							<span class="fliptitleprevdivspan"><?php echo $rectitle;?></span>
							<i style="float:right;font-size: 14px;cursor:pointer;" class="<?php echo $square_icon['edit'];?> edittitlebtn"></i>
						</div>
						<div class="fliptitlefielddiv" style="display:none;">
							<input type="text" class="form-control inp_title fliprectitle" id="" value="<?php echo $rectitle;?>" placeholder="Fl1p Recording Title">
						</div>
					</div>
					<div class="form-group m-1">
						<?php 
						$subtitle = date('jS F Y - h:i A');
						if( !empty(get_post_meta($recording_id,'subtitle',true)) ){
							$subtitle = get_post_meta($recording_id,'subtitle',true);
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
			<div class="col-md-8">
				<div class="d-flex recording_tools_main_div">
					<div class="text-center">
					<?php 
					$audiogt = get_post_meta($recording_id,'flip_recording_audio',true);
					/* echo "<pre>";print_r($flipicons); */
					$isdelete = 'disabled="disabled"';$is_start = '';$rectxt = '';
					if(!empty($audiogt)){
						$isdelete = '';
						$is_start = 'disabled="disabled"';
						$rectxt = 'style="display:none;"';
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
					<div class="d-flex align-items-center">
						&nbsp;&nbsp;<strong><span style=""> Or </span></strong> &nbsp;&nbsp;
						<label for="pwaaudioupload"><span class="btn_normal_state pwaaudiouploadbtn" style="width: auto;"><i class="fa fa-upload" aria-hidden="true"></i></span>
						</label>
						<input type="file" name="" class="pwaaudioupload" id="pwaaudioupload" style="display:none;" accept=".mp3" />
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
<script src='<?php echo $lx_plugin_urls['lx_lms_lite'] . 'addons/flip/PWA/js/idb.js'?>' ></script>
<script src='<?php echo $lx_plugin_urls['lx_lms_lite'] . 'addons/flip/PWA/js/index.js'?>' ></script>
<script src='<?php echo $lx_plugin_urls['lx_lms_lite'] . 'addons/flip/PWA/js/pwaaudio.js'?>' ></script>