<?php global $color_palette,$font_family,$page_devider; ?>
<style>
.content_close{
	float: right;
    color: <?php echo $color_palette['mid_grey'];?>;
    font-size: 24px;
    font-weight: 600;
    position: relative;
    font-family: cursive;
    top: 10px;
    cursor: pointer;
    z-index: 1;
    right: 40px;
}
.lx_label{
    margin-bottom: 10px;
    font-size: 16px;
    font-weight: 600;
    margin-right: 10px;
}
.file-input {
    display: inline-block;
    text-align: left;
    background: <?php echo $color_palette['white'];?>;
    padding: 4px;
    width: 90%;
    position: relative;
    border-radius: 3px;
    border: 1px solid <?php echo $color_palette['border'];?>;
}

.file-input>[type='file'] {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    z-index: 10;
    cursor: pointer;
}

.file-input>.button {
    display: inline-block;
    cursor: pointer;
    background: <?php echo $color_palette['hyperlinks'];?>;
    color: <?php echo $color_palette['white'];?>;
    padding: 3px 6px;
    border-radius: 4px;
    margin-right: 8px;
}

.file-input:hover>.button {
    background: <?php echo $color_palette['hyperlinks'];?>;
    color: <?php echo $color_palette['white'];?>;
}

.file-input>.label {
    color: <?php echo $color_palette['charcoal'];?>;
    white-space: nowrap;
}

.file-input.-chosen>.label {
    opacity: 1;
}

.progress {
    display: -ms-flexbox;
    display: flex;
    height: 0.7rem;
    overflow: hidden;
    line-height: 0;
    font-size: .75rem;
    background-color: <?php echo $color_palette['white'];?>;
    border: 1px solid <?php echo $color_palette['border'];?>;
    border-radius: .25rem;
}
.progress-bar{
     background-color: <?php echo $color_palette['hyperlinks'];?>;
}
.form-group small {
    float: right;
}
.small-left{
    float: left !important;   
    margin-bottom: .25rem !important;  
}
#articulate_title,#alt_resource_url{
    background: <?php echo $color_palette['white'];?>;
}
.articulate_web_canvas_buttons {
    display: flex;
	border-bottom: 2px solid <?php echo $page_devider['color'];?>;
	align-items: center;
	padding: 5px 0;
}
.articulate_web_canvas_title,.articulate_web_canvas_buttons .btn_main_div{
	width: 50%;
}
.articulate_web_canvas_title{
	width: 100%;
	margin-bottom: 10px;
}
.articulate_web_canvas_buttons .btn_inside_div{
	float: right;
}
.lx_articulate_main .action_btn_bottom {
    padding-left: unset;
    padding-right: unset;
	border-top: 2px solid <?php echo $page_devider['color'];?>;
    text-align: right;
    padding-top: 5px;
	margin-top: 1.3em;
}
.lbl_articulate_community{
	margin: 3px;
}
.alt_resource_url{
	width:90%
}
.articulate_progress{
	width: 100%;
}
.crop_img_art_web {
	height: 170px;
	background-color: rgb(33,150,243,0.3);
	border: 1px solid #EFEFEF;
	border-radius: 3px;
	text-align: center;
}
.dropzone .upload-input {
	position: relative;
	top: -62px;
	left: 0;
	width: 100%;
	height: 100%;
	opacity: 0;
}
.dropzone .upload-icon {
	text-align: center;
	margin-top: 60px;
}
.crop_img_art_web .upload-icon svg {
	color: #FFFFFF;
	font-size: 40px;
}
.have_edit{
	cursor: pointer;
	position: relative;
	float: left;
	z-index: 99;
	display: none;
}
.textarea_max_chars{
	text-align: right;
	color: <?php echo $color_palette['mid_grey'];?>;
}
#community_title{
	background-color: #fff;
}
#certificate_bg{
	max-width: unset;
	width: 100%;
}
.file-input {
	display: inline-block;
	text-align: left;
	background: <?php echo $color_palette['white'];?>;
	padding: 4px;
	width: 100%;
	position: relative;
	border-radius: 3px;
	border: 1px solid <?php echo $color_palette['border'];?>;
}

.file-input>[type='file'] {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	opacity: 0;
	z-index: 10;
	cursor: pointer;
}

.file-input>.button {
	display: inline-block;
	cursor: pointer;
	background: <?php echo $color_palette['hyperlinks'];?>;
	color: <?php echo $color_palette['white'];?>;
	padding: 3px 6px;
	border-radius: 4px;
	margin-right: 8px;
}

.file-input:hover>.button {
	background: <?php echo $color_palette['hyperlinks'];?>;
	color: <?php echo $color_palette['white'];?>;
}

.file-input>.label {
	color: <?php echo $color_palette['charcoal'];?>;
	white-space: nowrap;
}

.file-input.-chosen>.label {
	opacity: 1;
}
.cfg_del{
	border: 1px solid <?php echo $color_palette['border'];?>;
	margin: -5px;
	float: right;
	font-family: cursive;
	padding: 7px 13px;
}
.popover-content {
  display: none;
}
.popover{
	max-width:35%;
}
.popover-header{	
	text-align: center;	
}
.lx_articulate_main .question_style{
	color: <?php echo $color_palette['hyperlinks'];?>;
	font-size: 14px;
}
.thumb_edit {
    cursor: pointer;
    position: relative;
    float: left;
    z-index: 99;
    bottom: 24px;
	text-align: center;
}
.thumb_delete {
	position: relative;
	cursor: pointer;
	bottom: 24px;
	float: right;
	text-align: center;
}
alert_box_del_thumb_popup {
	width: auto !important;
	margin: auto 10% !important;
}
.alert_box_del_thumb_popup {
	z-index:1050;
}
.del_thumb_popup_main_class {
    margin-top: 10px;
}
.btn_del_alt_thumb_popup_cancel, .btn_del_alt_thumb_popup_yes {
    width: 70px;
}
.btn_del_alt_thumb_popup_yes {
    margin-right: 10px;
}
@media (max-width: 767px){
	.articulate_web_canvas_title {
		width: 100%;
		margin-bottom: 10px;
	}
	.articulate_web_canvas_buttons .btn_main_div{
		width:100%;
	}
	.articulate_web_canvas_buttons .btn_inside_div{
		display: grid;
		float: none;
	}
	.articulate_web_canvas_buttons button, .btn_bottom_inside_div button{
		margin-bottom: 10px;
	}
	.btn_bottom_inside_div{
		display:grid;
	}
	.articulate_web_canvas_buttons .btn_inside_div {
		display: grid;
		float: none;
	}
	.articulate_web_canvas_buttons {
		flex-direction: column;
	}
	.articulate_web_canvas_buttons button, .articulate_web_canvas_buttons a, .btn_bottom_inside_div button, .btn_bottom_inside_div a{
		width: 100%;
	}
	.del_thumb_popup_main_class{
		display: flex;
		justify-content: center;
	}
	.alert_box_del_thumb_popup{
		width: auto !important;
		margin: auto 10% !important;
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
</style>