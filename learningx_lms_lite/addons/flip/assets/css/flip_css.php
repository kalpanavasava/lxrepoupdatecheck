<?php
global $color_palette;
?>
<style>
<?php /***** Fliplist CSS *****/ ?>
.main-navigation,.loggedin_logo{
	display:none;
}
.crop_img_fliplist{
	width: 280px;
    height: 170px;
    background-color: rgb(33,150,243,0.3);
    border: 1px solid <?php echo $color_palette['light_grey'];?>;
    border-radius: 3px;
    text-align: center;
}
.fliplist_select{
	background-color: #ffffff !important;
	width:100%;
}
.alert_box_draft_popup{
	z-index:1050;
}
	
<?php /***** Flip Recording CSS *****/?>
.rst_audio_btn, .rst_video_btn,.delete_recording_icon{
	color: <?php echo $color_palette['white'];?>;
    background-color: <?php echo $color_palette['red'];?>;
	border:1px solid<?php echo $color_palette['red'];?>;
}
.rst_audio_btn:hover:enabled, .rst_video_btn:hover:enabled{
	color: <?php echo $color_palette['red'];?>;
    background-color: <?php echo $color_palette['white'];?>;
	border:1px solid<?php echo $color_palette['red'];?>;
}
.rst_upload_btn{
	background-color:<?php echo $color_palette['blue'];?>;
	color:<?php echo $color_palette['white'];?>;
	border:1px solid<?php echo $color_palette['blue'];?>;
}
.save_recording_icon{
	color: <?php echo $color_palette['white'];?>;
    background-color: <?php echo $color_palette['green'];?>;
	border:1px solid<?php echo $color_palette['green'];?>;
}
.save_recording_icon:hover:enabled{
	color: <?php echo $color_palette['green'];?>;
    background-color: <?php echo $color_palette['white'];?>;
	border:1px solid<?php echo $color_palette['green'];?>;
}
.save_recording_icon:disabled, .delete_recording_icon:disabled{
	color:<?php echo $color_palette['grey'];?>;
	background-color: <?php echo $color_palette['white'];?>;
	border:1px solid<?php echo $color_palette['mid_grey'];?>;
}
.vw_flip_canvas .rst_upload_btn:hover:enabled{
	color: <?php echo $color_palette['blue'];?>;
    background-color: <?php echo $color_palette['white'];?>;
}
.vw_flip_canvas .rst_video_btn:disabled,.vw_flip_canvas .rst_upload_btn:disabled{
	color:<?php echo $color_palette['grey'];?>;
	background-color: <?php echo $color_palette['light_grey'];?>;
	border:1px solid<?php echo $color_palette['mid_grey'];?>;
}
.delete_recording_icon:hover:enabled{
	color: <?php echo $color_palette['red'];?>;
	background-color: <?php echo $color_palette['white'];?>;
	border:1px solid<?php echo $color_palette['red'];?>;
}
.rst_audio_btn:disabled{
	color:<?php echo $color_palette['black'];?>;
	background-color: <?php echo $color_palette['light_grey'];?>;
	border:1px solid<?php echo $color_palette['mid_grey'];?>;
}
.flip_progress_bar .progress-bar,.flip_recording_progress_bar .progress-bar{
	background-color:<?php echo $color_palette['hyperlinks'];?>;
}
.flip_progress_bar,.flip_recording_progress_bar{
	height: 0.7rem;
    border: 1px solid <?php echo $color_palette['light_grey'];?>;
    background: <?php echo $color_palette['white'];?>;
}
.trash_icon_recording{
	color: <?php echo $color_palette['red'];?>;
}
.alert_box_del_recording_popup{
	z-index:1050;
}
.del_recording_popup_main_class{
	margin-top: 10px;
}

.alert_box_del_images_popup{
	z-index:1050;
}
.del_images_popup_main_class{
	margin-top: 10px;
}
.selectadd_fliplists .fliplistangledown{
	float: right;
    top: 3px;
    position: relative;
	color:<?php echo $color_palette['border'];?>;
}
.selectadd_fliplists{
	border: 1px solid <?php echo $color_palette['border'];?>;
    border-radius: 5px;
    padding: 5px;
	cursor:pointer;
}
.add_to_this_fliplist_div{
	border: 1px solid <?php echo $color_palette['border'];?>;
	position:absolute;
	background-color:#fff;
	width:100%;
	z-index: 1;
	min-height: 34px;
    max-height: 150px;
    overflow: auto;
}
.indfliplists{
	padding: 5px;
    border-bottom: 1px solid <?php echo $color_palette['border'];?>;
	cursor:pointer;
}
.mycommunity_fliplist_div{
	border-bottom:1px solid <?php echo $color_palette['border'];?>;
	margin: auto;
}
.file_upload_pdf,.file_upload_pdf img{
	width:50px;
	height:50px;
}
.deletemycomfliplist,.deletemyplayfliplist{
	cursor:pointer;
	color:<?php echo $color_palette['red'];?>;
}
.all_playlist{
	border-bottom:1px solid <?php echo $color_palette['border'];?>;
}
.fliprecsampletextblock{
	height:200px;
	border:1px solid<?php echo $color_palette['light_grey'];?>;
}
.fliprecsamplepdfblock,.fliprecpdfblockdiv{
	height:167px;
	border:1px solid<?php echo $color_palette['light_grey'];?>;
}
.flirecsamplemulimageblock,.flirecmulimageblock{
	height:300px;
	border:1px solid<?php echo $color_palette['light_grey'];?>;
}
.img_list{
	height: 133px;
}
.images1{
	align-items:center;
}
.flip_icons{
	font-size:20px;
	color:<?php echo $color_palette['blue'];?>;
}
.vw_flip_canvas .block_border{
	border: 1px solid <?php echo $color_palette['blue'];?>;
	border-radius: 10px 10px 0px 0px;
	padding: 10px;
}
.flipinfoicon{
	font-size:20px;
	color:<?php echo $color_palette['infobox_icon']; ?>;
}
.fliprecmulpdfview{
	height:64px;
	overflow:auto;
}
.fliprecadditional_notes{
	height:200px !important;
	border:1px solid<?php echo $color_palette['light_grey'];?>;	
	resize: none;
}
.flipfontcenter{
	position: absolute;
    width: 100%;
    text-align: center;
    font-size: 50px;
	color:<?php echo $color_palette['light_grey'];?>;
}
.allinversebtn{
	position: absolute;
    top: 0px;
}
.flipviewblock{
	position: relative;
    align-items: center;
    display: flex;
}
.audio_start,.audio_pause{
	border-radius: 50%;
    height: 46px;
    width: 49px;
    font-size: 20px;
	margin:0px;
}
.rst_video_btn{
	border-radius: 50%;
    height: 41px;
    width: 43px;
    font-size: 16px;
	margin:0px;
}
.rst_upload_btn{
    width: 44px;
    height: 34px;
    font-size: 14px;
	margin:0px;
}
</style>






