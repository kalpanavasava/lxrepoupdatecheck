<?php global $color_palette; ?>
<style>
.white-box { 
    position: relative;
    background: #fefefe;
    border: 1px solid <?php echo $color_palette['border'];?>;
    box-sizing: border-box
}
.counter_interval,.counter_interval2 {
  text-align: center;
  
}
.counter_interval .minutes,.seconds,.dot{
    font-family: Open Sans,sans-serif;
    font-size: 2.5em;
    font-weight: 600;
    color: #8f8f8f;
    margin: 1em 0;
    line-height: 0.5em;
}
.counter_interval2 .minutes2,.seconds2,.dot{
    font-family: Open Sans,sans-serif;
    font-size: 2.5em;
    font-weight: 600;
    color: #8f8f8f;
    margin: 1em 0;
    line-height: 0.5em;
}
.counter_interval .dot{
  padding:bottom
}
.counter_interval2 .dot{
  padding:bottom
}

.middle_stip{
    background-color: #f8f8f8;
    color: #777;
    font-size: 1em;
    padding: .2em;
    text-align: center;
    line-height: 1.5em;
    font-family: Arial,Open Sans,sans-serif;
}
.record_title{    text-align: center;
    color: <?php echo $color_palette['black'];?>;
    font-size: 1.00em;
    margin-bottom: 1em;
    line-height: 1.5em;
    font-family: Arial,Open Sans,sans-serif;
}
.recordButton{
    min-width: 8.2em;
    background-color: #d95354;
    color: <?php echo $color_palette['white'];?>;
    border-color: #d95354;
    border: 2px solid <?php echo $color_palette['border'];?>;
    box-sizing: border-box;
    font-size: .8em;
    font-family: Open Sans,sans-serif;
    padding: .708em 1.25em;
    border-radius: 2em;
    margin: 0 0 2em;
    border: 0;
    display: inline-block;
    cursor: pointer;
    text-decoration: none !important;
    font-weight: 600;
    white-space: nowrap;
    margin-top:2em;
}
.fa-microphone{
  padding-top: 0.5em;
}
.refresh{
  display: inline-block;
    background-color: #5e5e5e !important;
    color: <?php echo $color_palette['white'];?>;
    border-color: #5e5e5e;
    box-sizing: border-box;
    font-family: Open Sans,sans-serif;
    padding: 0.300em 1.00em;
    border-radius: 2em;
    margin: 0 .5em;
    border: 0;
    display: inline-block;
    cursor: pointer;
    text-decoration: none !important;
    font-weight: 600;
    white-space: nowrap;
}
.pauseButton:hover{color:#d95354 !important}
.pauseButton{
    background-color: <?php echo $color_palette['white'];?> !important;
    margin-bottom: 2em !important;
    color: #d95354;
    border: 2px solid <?php echo $color_palette['border'];?>;
    box-sizing: border-box;
    font-size: 1.042em;
    font-family: Open Sans,sans-serif;
    padding: .708em 1.25em;
    border-radius: 2em;
    display: inline-block;
    cursor: pointer;
    text-decoration: none !important;
    font-weight: 600;
    white-space: nowrap;
    box-sizing: border-box;
    margin-top: 2em !important;
}
.stopButton:hover{color:#29ab64;}
.stopButton{
    background-color: <?php echo $color_palette['white'];?> !important;
    color: #1f824c;
    border: 2px solid <?php echo $color_palette['border'];?> !important;
    box-sizing: border-box;
    color: #29ab64;
    border-color: #29ab64;
    font-family: Open Sans,sans-serif;
    padding: 0.300em 1.00em;
    border-radius: 2em;
    margin: 0 .5em;
    border: 0;
    display: inline-block;
    cursor: pointer;
    text-decoration: none !important;
    font-weight: 600;
    white-space: nowrap;
}
.uploading_wav_file:hover{background: #1860cc;}
.uploading_wav_file_save:hover{ background: #1860cc;}
.uploading_wav_file,.uploading_wav_file_save{
  background: #1860cc;
  border: 1px solid <?php echo $color_palette['border'];?>;
  border-radius: 0px;
}

.text-align-center{
	text-align: center;
}

.lx_save_success p,.lx_update_success p{
	margin: 1em !important;
}
.lx_save_success, .lx_update_success{
	padding-right: 38px;
	position: relative;
	margin: 5px 0 15px;
	border-left-color: <?php echo $color_palette['green'];?> !important;
	background: <?php echo $color_palette['white'];?>;
	border: 1px solid <?php echo $color_palette['border'];?>;
	border-left-width: 4px;
	box-shadow: 0 1px 1px rgba(0,0,0,.04);
	padding: 1px 12px;
	height: 50px;
	padding-top: 12px;
}

.PDloading {
	position: fixed;
	z-index: 999;
	overflow: show;
	margin: auto;
	top: 0;
	left: 0;
	bottom: 0;
	right: 0;
}

.PDloading:before {
	content: '';
	display: block;
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background-color: rgba(0,0,0,0.3);
}

#PDloader {
	position: fixed;
	left: 50%;
	top: 50%;
	z-index: 1;
	margin: -40px 0 0 -40px;
	border: 10px solid <?php echo $color_palette['border'];?>;
	border-radius: 50%;
	border-top: 10px solid #3498db;
	border-bottom: 10px solid #3498db;
	width: 80px;
	height: 80px;
	-webkit-animation: spin 2s linear infinite;
	animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
	0% { -webkit-transform: rotate(0deg); }
	100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
	0% { transform: rotate(0deg); }
	100% { transform: rotate(360deg); }
}

.lx_save_success_p,.fl1p_update_success_p{
	display:inline;
}
.lx_save_success_dismiss,.lx_update_success_dismiss{
    display: inline-block;
    float: right;
    background: <?php echo $color_palette['white'];?>;
    color: <?php echo $color_palette['charcoal'];?>;
    position: relative;
    bottom: 11px!important;
}
.lx_update_success_dismiss:hover{
  `background: <?php echo $color_palette['white'];?>;
    color: <?php echo $color_palette['black'];?>;
}
.lx_save_success_dismiss:hover{
    background: <?php echo $color_palette['white'];?>;
    color: <?php echo $color_palette['black'];?>;
}
.lx_update_success_dismiss:focus{
    background: <?php echo $color_palette['white'];?>;
    color: <?php echo $color_palette['black'];?>;
}
.lx_save_success_dismiss:focus{
    background: <?php echo $color_palette['white'];?>;
    color: <?php echo $color_palette['black'];?>;
}
.flip_back_linkk:hover{ background: #000;}
.flip_back_linkk{
  background: <?php echo $color_palette['black'];?>;
  border: 1px solid <?php echo $color_palette['border'];?>;
  border-radius: 0px;
}

.add_podcast,.add_flip{
  background-color: <?php echo $color_palette['white'];?>;
}
.add_podcast h1,.add_flip h1{
  color: <?php echo $color_palette['white'];?>;
}

.lx_make_featured_switch{
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.lx_make_featured_switch input{
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.lx_make_featured_switch .slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.lx_make_featured_switch .slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: <?php echo $color_palette['white']; ?>;
  -webkit-transition: .4s;
  transition: .4s;
}

.lx_make_featured_switch input:checked + .slider {
  background-color: <?php echo $color_palette['hyperlinks']; ?>;
}

.lx_make_featured_switch input:focus + .slider {
  box-shadow: 0 0 1px <?php echo $color_palette['hyperlinks']; ?>;
}

.lx_make_featured_switch input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}
.form-control:disabled{
	background-color: #e9ecef !important;
    opacity: 1;
}
/* Rounded sliders */
.lx_make_featured_switch .slider.round {
  border-radius: 34px;
}

.lx_make_featured_switch .slider.round:before {
	border-radius: 50%;
}
.main_make_featured{
	display: flex;
    align-items: center;
}
/* for new course ui */
.course_canvas_select,#lx_course_cost,#lx_course_cpd_points,#lx_course_time{
	background-color: #ffffff !important;
}
.attach_course_note{
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.cpd_points_main_div .course_time_main_div{
	width:50%;
}
.main_cpd_and_time{
	width:100%;
}
@media(max-width:767px){
  .have_edit{
    margin-top: -40px;
  } 
  .gp_edit_forum_icon{
    right: -12px;
  }
  .nav-search-enabled .main-navigation .menu-toggle {
    height: 50px !important;
  }

}
@media(min-width:768px){
	.have_edit{
		margin-top: -10px;
	}
	.gp_edit_forum_icon{
		right: -9px;
	}
	.tab_title_col{
		margin-right: 0px;
	}
}
@media(max-width:1023px){
	.dropzone .upload-icon {
		text-align: center;
		margin-top: 60px;
	}
}
@media(min-width:1024px){
  .dropzone .upload-icon {
    text-align: center;
    margin-top: 60px;
  }
}
.delete_course_thumbnail{
  position: absolute;
  top: 0;
  right: 0;
}
.crop_img_course,.crop_img_topic,.crop_img_module{
    width: 100%;
    height: 170px;
    background-color: rgb(33,150,243,0.3);
    border: 1px solid <?php echo $color_palette['border'];?>;
    border-radius: 3px;
    text-align: center;
}
.dropzone_multiple{
  width: 100px;
  height:100px;
  background-color: rgb(33,150,243,0.3);
  border: 1px solid <?php echo $color_palette['border'];?>;
  border-radius: 3px;
  text-align: center;
}
.dropzone_multiple .upload-icon{
  text-align: center;
  margin-top: 38px;
}
.dropzone_multiple .upload-icon i{
  color: <?php echo $color_palette['white'];?>;
  font-size: 20px;
}

.crop_img_course .upload-icon svg,.crop_img_module .upload-icon svg{
  color: <?php echo $color_palette['white'];?>;
  font-size: 40px;
}

.dropzone .upload-input {
  position: relative;
  top: -62px;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
}

.dropzone_multiple .upload-input {
  position: relative;
  top: -62px;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
}
.hide_title,.hide_title_flip{
  display:none;
  margin-top: 20px;
}

.lx_course_description{
  border: 1px solid <?php echo $color_palette['border'];?>;
}

.placeholder {
  color: <?php echo $color_palette['black'];?>;
  position: absolute;
  z-index: 1;
}
.textarea_max_chars{
  text-align: right;
}
.form-control {
  background:none;
  border: 1px solid <?php echo $color_palette['border'];?>;
  }
.form-control:focus {
  background-color: <?php echo $color_palette['white'];?>;
  box-shadow:none;
  border-color: <?php echo $color_palette['border'];?>;
}
.podcast_back_link, .flip_back_linkk{
  background-color: none !important;
  border: 1px solid <?php echo $color_palette['border'];?> !important;
  color:<?php echo $color_palette['white'];?> !important;
}
.podcast_back_link:hover, .flip_back_linkk:hover{
  color:<?php echo $color_palette['white'];?>;
}
.fl1_tips span{
    font-size: 14px;
    text-transform: uppercase;
}
.fl1_tips p{
  font-size: 12px;
}
.record_flip i.fa-3x{
  color:<?php echo $color_palette['white'];?>;
  font-size: 35px;
}
.record_flip #recordButton{
  margin-left: 125px;
}
#blah_flip{
  margin-bottom: 10px;
}
.dropzone_multiple input[type="add_flip_mul_image"] {
  display: block;
}
.imageThumb {
  border: 2px solid;
  padding: 1px;
  cursor: pointer;
}
.pip {
  height: 100px;
  width: 100px;
  display: inline-block;
  margin: 10px 10px 0 0;
}
.podcast_view{
  background-color: <?php echo $color_palette['white'];?>;
}
.podcast_img{
  border:1px solid <?php echo $color_palette['border'];?>;
}
.right{
  padding:10px;
}
.column {
    position: relative;
    display: inline-block;
    font-size: 0;
}
.column .delete_flip_mul_image {
    position: absolute;
    top: 0px;
    right: 0px;
    z-index: 100;
    background-color: <?php echo $color_palette['white'];?>;
    padding: 4px 3px;
    
    color: <?php echo $color_palette['black'];?>;
    font-weight: bold;
    cursor: pointer;
   
    text-align: center;
    font-size: 15px;
    line-height: 10px;
    border-radius: 50%;
    border:1px solid <?php echo $color_palette['border'];?>;
}
.column:hover .delete_flip_mul_image {
    opacity: 1;
}
.meta-artist .the-name{ color:<?php echo $color_palette['white'];?> !important; }
.ap-controls .scrubbar{
  background-color:<?php echo $color_palette['white'];?> !important;
}
#lx_course_category:focus{
  border: 1px solid <?php echo $color_palette['border'];?>;
}
#lx_course_category:focus,#fl1p_podcast_visiblity:focus,#lx_course_description:focus,#lx_course_summary:focus,#lx_course_outcomes:focus,#lx_course_requirements:focus{
  border: 1px solid <?php echo $color_palette['black'];?>;
}
#lx_course_title,#community_title,#lx_course_subtitle{
    background: <?php echo $color_palette['white'];?>;
    border: 1px solid <?php echo $color_palette['border'];?>;
    border-radius: 5px;
}
#fl1p_podcast_category_shown{
    background: <?php echo $color_palette['white'];?>;
    border: 1px solid <?php echo $color_palette['border'];?>;
    border-radius: 5px;
}
.add_flip_title:focus{
    background: <?php echo $color_palette['white'];?>;
    border: 1px solid;
    border-radius: 5px;
}
.add_flip_title{
    background: <?php echo $color_palette['white'];?> !important;
    border-radius: 5px !important;
}
.container{
  max-width: 100% !important; 
}
.flip_container,.xapi_content{
  padding-top: 50px !important;
}
.progress{
  background:<?php echo $color_palette['white'];?> !important;
  border:1px solid <?php echo $color_palette['border'];?> !important;
}
.course_close,.topic_close{
    float: right;
    color: <?php echo $color_palette['mid_grey'];?>;
    font-size: 24px;
    font-weight: 600;
    position: relative;
    font-family: cursive;
    top: 10px;
    cursor:pointer;
}
.option_div{
    padding-top:10px;
}
.option_div span{
    padding-left:10px;
}
#lx_form_savecourses .progress .progress-bar {
    transition: width 0.3s ease 0s !important;
    background: <?php echo $color_palette['blue'];?> !important;
}
.have_edit{
    cursor: pointer;
  position: relative;
    float: left;
    z-index: 99;
    padding: 0;
    display: none;
}
.thumb_edit{
    cursor: pointer;
    position: relative;
    float: left;
    z-index: 99;
    bottom: 24px;
}
.thumb_delete{
    position: relative;
    cursor: pointer;
    bottom: 24px;
    float: right;
}

@media (min-width: 769px)
{
  .display_img_podcast{
    max-width: 25% !important;
    margin: 0 auto;
  }
  .flip_container,.xapi_content{
     margin: auto;
  }
}

/*LearningX CSS*/
.xapi_label{
  padding-top: 10px !important;
  margin-bottom: 5px !important;
}
.flip_canvas_close,.xapi_canvas_close{
  position: relative;
  float: right;
  margin-top: -20px;
  cursor: pointer;
  font-size: 40px;
  color: <?php echo $color_palette['mid_grey'];?>;
  font-weight: 600;
}
.heading{
  font-size: 20px;
  font-weight:600;
}
.title_div{
  margin-top: 2rem !important;
}
.save_courses_info .thumb_edit,.thumb_delete ,.have_edit{
    width: 35px;
}
.save_courses_info .have_edit{  
	width:35px; 
	margin-top:10px;
	display:none; 
} 
.save_courses_info .display_title{  
   color: <?php echo $color_palette['heading_text'];?>; 
} 
.save_courses_info .display_desc{ 
   color: <?php echo $color_palette['body_text'];?>;  
}
.form-check{
  margin-bottom: 0.5em !important;
}
.form-check-label{
  margin-top: 3px !important;
}
.course_cost_main_div{
	display: flex;
    align-items: baseline;
}
.lx_course_cost{
	width: 36%;
}
.course_cost_main_div .cost_div{
	display: flex;
	align-items: baseline;
}
.lbl_site_currency_code{
	font-weight: 500;
}
.lbl_once_off{
	width: 30%;
	text-align: center;
}
.save_courses_info .popover-content {
    display: none;
}
.save_courses_info .lbl_api_inclusion {
    display: flex;
    align-items: center;
}
.save_courses_info .question_style{
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.course_button_div{
	align-items: center;
	display: flex;
	margin-left: 0px !important;
	margin-right: 0px !important;
}
.button_top_inside_div{
	width:50%;
}
.course_buttons{
	text-align:end;
}
.course_bottom_button_div{
	border-bottom:unset !important;
	border-top: 2px solid #0000001a;
}
.draft_popup_btn_main_class,.del_thumb_popup_main_class{
	margin-top: 10px;
}
.draft_popup_btn_main_class .btn_draft_popup_yes, .del_thumb_popup_main_class .btn_del_thumb_popup_yes{
	width: 70px;
    margin-right: 10px;
}
.draft_popup_btn_main_class .btn_draft_popup_cancel, .del_thumb_popup_main_class .btn_del_thumb_popup_cancel{
	width: 70px;
}
.alert_box_del_thumb_popup, .alert_box_draft_popup{
	z-index:1050;
}
.chk_xapi_certificate_div{
	display:flex;
	align-items:center;
}
.xapi_container .popover-content {
    display: none;
}
.lx_xapi_thumbnail .question_style{
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.macro_course:disabled {
	background-color: #e9ecef !important;
	opacity: 1;
}
.main_cpd_and_time{
	display: flex;
}
.cpd_points_main_div, .course_time_main_div{
	width:46%;
}
.course_time_main_div{
	margin-left: 15px;
}
@media (max-width:767px){
	.save_courses_info .course_bottom_buttons{
		margin-top:20px;
	}
	.course_buttons{
		display: grid !important;
		width: 100% !important;
	}
	.button_top_inside_div{
		width:100% !important;
		margin-top:10px;
	}
	.course_button_div{
		flex-direction: column;
		padding: unset;
	}
	.course_buttons Button, .btn_cancel_xapi{
		margin-bottom:10px;
	}
	.course_canvas_select{
		width:100%;
	}
	.draft_popup_btn_main_class, .del_thumb_popup_main_class{
		display: flex;
		justify-content: center;
	}
	.alert_box_draft_popup, .alert_box_del_thumb_popup{
		width: auto !important;
		margin: auto 10% !important;
	}
	.main_cpd_and_time {
		display: grid;
	}
	.course_time_main_div{
		margin-top: 1em;
	}
}
</style>