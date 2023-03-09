<?php
/**** for iconography settings ui ****/
global $kit_code,$flipicons; 
?>
<div class="row pt-3 pb-3">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">FONT AWESOME PRO</h4>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label lass="col-form-label">Kit Code</label>
	</div>
	<div class="col-md-3">
		<input type="text" name="icon[kit_code]" id="kit_code" class="form-control" value="<?php echo $kit_code;?>">
	</div>
	<div class="col-md-6"></div>
</div>
<div class="row pt-3">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">MENU ICONS</h4>
	</div>
</div>
<?php 
//fetch dynamic menu
	$menu_items = get_dynamic_menu(); 
	foreach ($menu_items as $item) {
		$parent=get_post_meta($item->ID,'_menu_item_menu_item_parent',true);
		if($parent==0)
		{
			$main_menu[]=$item;
		}
		else{
			$sub_menu[]=$item;
		}
	}
?>
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-3"></div>
		<div class="col-md-6"><i class="font_gray">Defaults (Pro required)</i></div>
	</div>
	<?php foreach ($main_menu as $item) { 
		if( $item->title == "" ){
			$item->title = 'User Profile';
		}
	?>
	<div class="row form-group">
		<div class="col-md-3">
			<input type="hidden"name="icon[menu_info][]" id="txt_menu_info[]" value="<?php echo $item->ID; ?>" />
			<label for="" class="col-form-label"><?php echo $item->title; ?></label>
		</div>
		<div class="col-md-3">
			<?php $menu_value = get_post_meta($item->ID,'user_setting_menu_icon')[0]; ?>
			<input name="icon[menu][]" type="text" id="txt_menu[]" class="form-control" value="<?php if(isset($menu_value)){ echo $menu_value; } ?>">
		</div>
		<div class="col-md-6"></div>
	</div>
<?php } ?>
<div class="row pt-3 pb-3">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">ADMIN/AUTHORING ICONS</h4>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_edit" class="col-form-label">Edit</label>
	</div>
	<div class="col-md-3">
		<input name="icon[edit]" type="text" id="txt_edit" class="form-control" value="<?php if(isset($square_icon['edit'])){ echo $square_icon['edit']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fas fa-pen</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_plus" class="col-form-label">Plus</label>
	</div>
	<div class="col-md-3">
		<input name="icon[plus]" type="text" id="txt_plus" class="form-control" value="<?php if(isset($square_icon['plus'])){ echo $square_icon['plus']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fas fa-plus</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_save" class="col-form-label">Save</label>
	</div>
	<div class="col-md-3">
		<input name="icon[save]" type="text" id="txt_save" class="form-control" value="<?php if(isset($square_icon['save'])){ echo $square_icon['save']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fas fa-save</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_toggle_on" class="col-form-label">Toggle-on</label>
	</div>
	<div class="col-md-3">
		<input name="icon[toggle_on]" type="text" id="txt_toggle_on" class="form-control" value="<?php if(isset($square_icon['toggle_on'])){ echo $square_icon['toggle_on']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fal fa-toggle-on</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_toggle_on" class="col-form-label">Toggle-off</label>
	</div>
	<div class="col-md-3">
		<input name="icon[toggle_off]" type="text" id="txt_toggle_off" class="form-control" value="<?php if(isset($square_icon['toggle_off'])){ echo $square_icon['toggle_off']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fal fa-toggle-off</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_trash" class="col-form-label">Trash</label>
	</div>
	<div class="col-md-3">
		<input name="icon[trash]" type="text" id="txt_trash" class="form-control" value="<?php if(isset($square_icon['trash'])){ echo $square_icon['trash']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fas fa-trash</i>
	</div>
</div>

<div class="row pt-3 pb-3">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">Fl1p Icons</h4>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="360_image" class="col-form-label">360 image</label>
	</div>
	<div class="col-md-3">
		<input name="flipicon[360_image]" type="text" id="360_image" class="form-control" value="<?php if(isset($flipicons['360_image'])){ echo $flipicons['360_image']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fas fa-360-degrees</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="attachment" class="col-form-label">Attachment</label>
	</div>
	<div class="col-md-3">
		<input name="flipicon[attachment]" type="text" id="attachment" class="form-control" value="<?php if(isset($flipicons['attachment'])){ echo $flipicons['attachment']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fas fa-paperclip</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="audio_recording" class="col-form-label">Audio recording</label>
	</div>
	<div class="col-md-3">
		<input name="flipicon[audio_recording]" type="text" id="audio_recording" class="form-control" value="<?php if(isset($flipicons['audio_recording'])){ echo $flipicons['audio_recording']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fas fa-microphone-lines</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="fullsceenon" class="col-form-label">Fullscreen - ON</label>
	</div>
	<div class="col-md-3">
		<input name="flipicon[fullsceenon]" type="text" id="fullsceenon" class="form-control" value="<?php if(isset($flipicons['fullsceenon'])){ echo $flipicons['fullsceenon']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">far fa-up-right-and-down-left-from-center</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="fullsceenoff" class="col-form-label">Fullscreen - OFF</label>
	</div>
	<div class="col-md-3">
		<input name="flipicon[fullsceenoff]" type="text" id="fullsceenoff" class="form-control" value="<?php if(isset($flipicons['fullsceenoff'])){ echo $flipicons['fullsceenoff']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">far fa-down-left-and-up-right-to-center</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="images" class="col-form-label">Images</label>
	</div>
	<div class="col-md-3">
		<input name="flipicon[images]" type="text" id="images" class="form-control" value="<?php if(isset($flipicons['images'])){ echo $flipicons['images']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fas fa-images</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="navigation_left" class="col-form-label">Navigation left</label>
	</div>
	<div class="col-md-3">
		<input name="flipicon[navigation_left]" type="text" id="navigation_left" class="form-control" value="<?php if(isset($flipicons['navigation_left'])){ echo $flipicons['navigation_left']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">far fa-chevron-left</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="navigation_right" class="col-form-label">Navigation right</label>
	</div>
	<div class="col-md-3">
		<input name="flipicon[navigation_right]" type="text" id="navigation_right" class="form-control" value="<?php if(isset($flipicons['navigation_right'])){ echo $flipicons['navigation_right']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">far fa-chevron-right</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="pause" class="col-form-label">Pause</label>
	</div>
	<div class="col-md-3">
		<input name="flipicon[pause]" type="text" id="pause" class="form-control" value="<?php if(isset($flipicons['pause'])){ echo $flipicons['pause']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">far fa-circle-pause</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="play" class="col-form-label">Play</label>
	</div>
	<div class="col-md-3">
		<input name="flipicon[play]" type="text" id="play" class="form-control" value="<?php if(isset($flipicons['play'])){ echo $flipicons['play']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">far fa-circle-play</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="reply" class="col-form-label">Reply (add)</label>
	</div>
	<div class="col-md-3">
		<input name="flipicon[reply]" type="text" id="reply" class="form-control" value="<?php if(isset($flipicons['reply'])){ echo $flipicons['reply']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">far fa-comment-plus</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="responses" class="col-form-label">Responses</label>
	</div>
	<div class="col-md-3">
		<input name="flipicon[responses]" type="text" id="responses" class="form-control" value="<?php if(isset($flipicons['responses'])){ echo $flipicons['responses']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">far fa-comment-plus</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="text" class="col-form-label">Text</label>
	</div>
	<div class="col-md-3">
		<input name="flipicon[text]" type="text" id="text" class="form-control" value="<?php if(isset($flipicons['text'])){ echo $flipicons['text']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fas fa-font-case</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="uploadtocloud" class="col-form-label">Upload to cloud</label>
	</div>
	<div class="col-md-3">
		<input name="flipicon[uploadtocloud]" type="text" id="uploadtocloud" class="form-control" value="<?php if(isset($flipicons['uploadtocloud'])){ echo $flipicons['uploadtocloud']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fas fa-cloud-arrow-up</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="video" class="col-form-label">Video(no sound)</label>
	</div>
	<div class="col-md-3">
		<input name="flipicon[video]" type="text" id="video" class="form-control" value="<?php if(isset($flipicons['video'])){ echo $flipicons['video']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fas fa-video</i>
	</div>
</div>

<div class="row pt-3 pb-3">
	<div class="col-md-12 admin_section_title">
		<h4 class="head_h4">ADDITIONAL ICONS</h4>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_articulate_popups_link" class="col-form-label">Articulate Resources(URL) Tile</label>
	</div>
	<div class="col-md-3">
		<input name="icon[articulate_popups_link]" type="text" id="txt_articulate_popups_link" class="form-control" value="<?php if(isset($frontend_icon['articulate_popups_link'])){ echo $frontend_icon['articulate_popups_link']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fad fa-link</i>
	</div>
</div>
<div class="row form-group">	
	<div class="col-md-3">		
		<label for="txt_articulate_popups" class="col-form-label">Articulate Web Tiles</label>	
	</div>	
	<div class="col-md-3">		
		<input name="icon[articulate_popups]" type="text" id="txt_articulate_popups" class="form-control" value="<?php if(isset($frontend_icon['articulate_popups'])){ echo $frontend_icon['articulate_popups']; } ?>">	
	</div>	
	<div class="col-md-6">	
		<i class="font_gray">fad fa-photo-video</i>
	</div>
</div>

<div class="row form-group">
	<div class="col-md-3">
	<label for="certificate_icon" class="col-form-label">Certificate</label>
	</div>
	<div class="col-md-3">
		<input name="icon[certificate_icon]" type="text" id="certificate_icon" class="form-control" value="<?php if(isset($square_icon['certificate_icon'])){ echo $square_icon['certificate_icon']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fas fa-file-certificate</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
	<label for="close_icon" class="col-form-label">Close</label>
	</div>
	<div class="col-md-3">
		<input name="icon[close_icon]" type="text" id="close_icon" class="form-control" value="<?php if(isset($square_icon['close_icon'])){ echo $square_icon['close_icon']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fas fa-xmark</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
	<label for="download_icon" class="col-form-label">Download</label>
	</div>
	<div class="col-md-3">
		<input name="icon[download_icon]" type="text" id="download_icon" class="form-control" value="<?php if(isset($square_icon['download_icon'])){ echo $square_icon['download_icon']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fal fa-downlaod</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
	<label for="icon_infobox" class="col-form-label">Info boxes</label>
	</div>
	<div class="col-md-3">
		<input name="icon[infobox]" type="text" id="icon_infobox" class="form-control" value="<?php if(isset($square_icon['infobox'])){ echo $square_icon['infobox']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fa fa-info-circle</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
		<label for="txt_learning_data" class="col-form-label">Learning Data</label>
	</div>
	<div class="col-md-3">
		<input name="icon[learning_data]" type="text" id="txt_learning_data" class="form-control" value="<?php if(isset($square_icon['learning_data'])){ echo $square_icon['learning_data']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fas fa-user-chart</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
	<label for="txt_user_management" class="col-form-label">Reset</label>
	</div>
	<div class="col-md-3">
		<input name="icon[reset]" type="text" id="txt_reset" class="form-control" value="<?php if(isset($square_icon['reset'])){ echo $square_icon['reset']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fal fa-undo</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
	<label for="setting_icon" class="col-form-label">Settings</label>
	</div>
	<div class="col-md-3">
		<input name="icon[setting_icon]" type="text" id="setting_icon" class="form-control" value="<?php if(isset($square_icon['setting_icon'])){ echo $square_icon['setting_icon']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fal fa-gear</i>
	</div>
</div>

<div class="row form-group">
	<div class="col-md-3">
	<label for="txt_support" class="col-form-label">Support</label>
	</div>
	<div class="col-md-3">
		<input name="icon[support]" type="text" id="txt_support" class="form-control" value="<?php if(isset($square_icon['support'])){ echo $square_icon['support']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fal fa-question-square</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
	<label for="txt_user_management" class="col-form-label">User Management</label>
	</div>
	<div class="col-md-3">
		<input name="icon[user_management]" type="text" id="txt_user_management" class="form-control" value="<?php if(isset($square_icon['user_management'])){ echo $square_icon['user_management']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fas fa-user-cog</i>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-3">
	<label for="icon_warning" class="col-form-label">Warning</label>
	</div>
	<div class="col-md-3">
		<input name="icon[warning]" type="text" id="icon_warning" class="form-control" value="<?php if(isset($square_icon['warning'])){ echo $square_icon['warning']; } ?>">
	</div>
	<div class="col-md-6">
		<i class="font_gray">fal fa-exclamation-triangle</i>
	</div>
</div>