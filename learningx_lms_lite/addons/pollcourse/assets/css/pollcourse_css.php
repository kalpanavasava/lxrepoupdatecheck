<?php global $color_palette;
/*echo "<pre>";print_r($color_palette);echo "</pre>";	*/
?>
<style>
<?php if(metadata_exists('post',$post->ID,'content_type')){?>
  body{
        position: fixed;
        width:100%;
    }
<?php } ?>
.main-navigation,.loggedin_logo,.site-info{
	display:none;
}
.entry-content{
	padding:25px;
}
.question_heading{
	background-color: <?php echo $color_palette['mid_grey'];?>;
	margin-top: 10px;
    margin-bottom: 20px;
	margin-left:0px;
	margin-right:0px;
}
.answer_heading{
	background-color: <?php echo $color_palette['mid_grey'];?>;
	padding: 5px;
    margin-bottom: 10px;
}
.textarea_max_chars{
	color: <?php echo $color_palette['mid_grey'];?>;
	margin-bottom: 20px;
}
.small_right{
	float: right;
}
.ans_error,.question_error{
	display: none;
	color: red;
}
.feedback_txt1,.feedback_txt2,.new_feedback_txt,.new_answer_txt{
	color: <?php echo $color_palette['mid_grey'];?>;
	margin-bottom: 0px;
}
.switch{
	position: relative;
	display: inline-block;
	width: 60px;
	height: 34px;
	margin-bottom: 0px;
}

/* Hide default HTML checkbox */
.switch input{
	opacity: 0;
	width: 0;
	height: 0;
}

/* The slider */
.switch .slider {
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

.switch .slider:before {
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

.switch input:checked + .slider {
	background-color: <?php echo $color_palette['hyperlinks']; ?>;
}

.switch input:focus + .slider {
	box-shadow: 0 0 1px <?php echo $color_palette['hyperlinks']; ?>;
}

.switch input:checked + .slider:before {
	-webkit-transform: translateX(26px);
	-ms-transform: translateX(26px);
	transform: translateX(26px);
}

#pc_title,#pc_subtitle,#primary_recipient_email,#secondary_recipient_email,#in_course_btn_label{
    background: <?php echo $color_palette['white'];?>;
    border-radius: 5px;
}
.pc_new_answer_option,.pc_new_question_option{
	border: 2px dotted <?php echo $color_palette['border'];?>;
	padding:10px;
	text-align:center;
	cursor: pointer;
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.remove_QueButton{
	color:<?php echo $color_palette['white'];?>;
	background: <?php echo $color_palette['red'];?>;
	padding:10px;
	border-radius: 5px;
	display: inline-flex;
}

.prompt_error_msg{
	color:<?php echo $color_palette['red'];?>;
	text-align: left; 
}
.crop_intro_img_poll,.crop_que_img_poll{
	width: 280px;
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
.have_edit {
    margin-top: 35px;
    display: none;
    float: left;
}
.dropzone .upload-icon {
    text-align: center;
    margin-top: 60px;
}
.upload-icon svg{
    color: #FFFFFF;
    font-size: 40px;
}
.text-muted {
    float: right !important;
}
.small-left {
    float: left !important;
}
.main_preview_test_div{
	border: 20px solid #d3d3d352;
}
.intro_content,.question_div_item{
	padding: 20px;
}
.ans_div_item{
	padding: 5px;
    border: 1px solid <?php echo $color_palette['hyperlinks'];?>;
    margin-top: 5px;	
    cursor: pointer;
}
.selected_ans,.selected_answer{
	background: <?php echo $color_palette['hyperlinks'];?>;
    color: #fff;
}
.answer_div_content{
	border: 1px solid <?php echo $color_palette['hyperlinks'];?>;
    padding: 5px;
    margin-top: 10px;
	cursor: pointer;
}
.feedback_div{
	padding: 5px;
    border: 1px solid #b7b7b7;
    border-top: unset;
    background: <?php echo $color_palette['hyperlinks'].'1a';?>;
}
.feedback_div_main{
	border: 1px solid lightgray;
	padding: 5px;
	display:none;
	background: <?php echo $color_palette['hyperlinks'].'1a';?>;
}
.lesson_content{
	background: <?php echo $color_palette['charcoal'];?>;
	overflow: auto !important;
}
.poll_actions .form-group{
	margin-bottom: 0px;
}
@media (min-width: 769px){
	.pollcontent_card{
		width: 75%!important;
	    margin: 0 auto;
	}
}
.pollcontent_card{
	margin-bottom: 30px;
}
.hide_show{
	padding: 5px 8px;	
}
.dblock{
	color: white;
	background-color:<?php echo $color_palette['green'];?>;
}
.dblock:hover,.dblock:focus{
	color: white !important;
	background-color:<?php echo $color_palette['green'];?> !important;
}
.hide{
	color: white;
	background-color:<?php echo $color_palette['orange'];?>;
}
.hide:hover,.hide:focus{
	color: white !important;
	background-color:<?php echo $color_palette['orange'];?> !important;
}
.introduction_section .popover-content{
	display: none;
}
.lx_toggle{
	position: relative;
	top: 5px;
}
 .pollcourse_form .progress-bar{
 	background-color: <?php echo $color_palette['hyperlinks'];?>;
 }
</style>	