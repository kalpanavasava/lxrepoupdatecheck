<?php 
global $color_palette,$font_family;
$heading_text=$color_palette['heading_text'];
$body_text=$color_palette['body_text'];
?>
<style>
.lxed_width_100{
	width:100% !important;
}
.lxed_button_question{
	background: <?php echo $color_palette['white'];?>;
    color: <?php echo $color_palette['black'];?>;
    border: 1px solid <?php echo $color_palette['border'];?>;
}
.lxed_answer_radio{
	transform: scale(1.5);
}
.lxed_single_chose_feedback{
	color:<?php echo $color_palette['mid_grey'];?>;
}
.disabled_single_choice{
	cursor:pointer;
	color:<?php echo $color_palette['mid_grey'];?>;
}
.lxed_button_question:hover{
	background: <?php echo $color_palette['mid_grey'];?> !important;
}
.lxed_font_20{
	font-size:20px;
}
.lx_editor_blog_page .card-image {
  position: relative;
  margin: 2px;
}
.lx_editor_blog_page h2{
	font-weight:400;
}
.lx_editor_blog_page .image-overlay {
	position: absolute;
	top: 0;
	bottom: 0;
	left: 0;
	right: 0;
	height: 100%;
	width: 100%;
	opacity: 0;
	transition: .5s ease;
	background: rgba(0, 0, 0, 0.5);
}

.lx_editor_blog_page .card:hover .image-overlay {
	opacity: 1;
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
.have_edit{
    cursor: pointer;
    position: relative;
    float: left;
    z-index: 99;
    padding: unset;
    display: none;
}
.crop_img_course{
    width: 280px;
    height: 170px;
    background-color: rgb(33,150,243,0.3);
    border: 1px solid <?php echo $color_palette['border'];?>;
    border-radius: 3px;
    text-align: center;
}
.crop_img_course .upload-icon svg{
  color:<?php echo $color_palette['white'];?>;
  font-size: 40px;
}
@media only screen and (min-width: 768px) {
	
	.lxed_block_padding{
		padding: 0em 10em 0em 10em;
	}
}
.lxed_inp_css:focus{
	border:none;
}
.lxed_inp_css{
	width: 100%;
    background: <?php echo $color_palette['white'];?> !important;
    border: none !important;
}
.rendered_block{
	margin-top:2em;
}
.lx_editor_blog_page .lx_editor_blog_page_edit, .lx_editor_blog_page .lx_editor_blog_page_view{
	position: relative;
    width:40%;
	display: flex;
    justify-content: center;
    width: 100%;
}
.lx_editor_blog_page .lx_editor_blog_page_edit button, .lx_editor_blog_page .lx_editor_blog_page_view button{
	width: 40%;
}
.lx_editor_blog_page .lx_editor_blog_page_edit{
    top: 20%; 
}
.lx_editor_blog_page .lx_editor_blog_page_view{
    top: 25%;
}
.lx_editor_blog_page .card-text{
    font-size: 0.8em;
}
.lx_editor_blog_page .card_blog_description{
	font-family:<?php echo $font_family['body_font'];?>;
}
.lx_input{
	border:1px solid <?php echo $color_palette['border'];?> !important;
	background:<?php echo $color_palette['white'];?> !important;
	width:100%;
}
.lx_input_bn:focus{
	outline: none !important;
	border-color: #719ECE;
}
.lx_editor_questions:focus{
	outline: none !important;
}
.lxed_var_post_title{font-weight: 600;font-size: 1.4em;}
.label_heading{font-weight:600;}
.lxed_add_section{cursor:pointer;}
.lxed_add_section .svg-inline--fa {
	vertical-align: -0.25em !important;
}
.text-divider{margin: 1.5em 0em 26px; line-height: 0; text-align: center;}
.text-divider span{
	background-color:<?php echo $color_palette['charcoal'];?>;
    padding: 7px 12px 9px 12px;
    position: relative;
    bottom: 11px;
    color: <?php echo $color_palette['white'];?>;
    border-radius: 40px;
    font-size: 15px;
}
.lxed_border_bottom,.lxed_border_bottom_break{
	border-bottom: .4rem solid <?php echo $color_palette['custom3'];?>!important;
    padding: 0px 0 1.5rem;
}
.lx_editor_addnew_blog .row{
	margin-right:unset !important;
}
.rendered_lxed_page_breakprev,.rendered_lxed_page_breaknext{
    padding: 20px;
    text-align: center;
    background: <?php echo $color_palette['light_grey'];?>;
    cursor: pointer;
}
.lx_editor_addnew_blog .lx_editor_blocks{
	text-align:center;
	border: 1px dashed <?php echo $color_palette['border'];?>;
	width: 80%;
    margin: 3em auto;
}
.lx_editor_addnew_blog .lx_block_img, .lx_editor_addnew_blog .lx_block_button{
	height: 100px;
    width: 100px;
    max-width: unset !important;
}
.lx_editor_addnew_blog .lx_block_img{
	bottom: 2px;
    position: relative;
}
.lx_editor_addnew_blog .lx_block_button_section_video{
	background:<?php echo $color_palette['custom1'];?>;
	height: 70px;
    width: 70px;
	border:1px solid <?php echo $color_palette['border'];?>;
}
.lx_editor_addnew_blog .lx_block_button_section{
	background:<?php echo $color_palette['white'];?>;
	border:1px solid <?php echo $color_palette['border'];?>;
	color:<?php echo $color_palette['black'];?>;
	height: 70px;
}
.lx_editor_addnew_blog .lx_editor_blocks_inner{
	cursor:pointer;
}
.lx_editor_addnew_blog .lx_editor_blocks_inner:hover{
	background:<?php echo $color_palette['light_grey'];?>;
}
.lx_editor_blocks
{
    width:100%;
    text-align: center;
}
.lx_block_jt
{
    display: inline-block;
	padding: 10px;
}
.lx_area_edit,.lx_area_delete{
	font-size: 27px !important;
	cursor:pointer;
}
.lx_area_edit{
	padding-right: 18px;
}
.lx_area_delete{
	bottom: 2px;
    position: relative;
}
.lx_editor_drop_zone{
	padding:20px;
	border: 1px dashed <?php echo $color_palette['border'];?>;
}
.image-upload>input {
  display: none;
}
.lx_editor_addnew_blog .lxed_thumbnail_img{
	width:100%;
}
.lx_editor_addnew_blog .image-upload label{
	width:100%;
}
.lx_collapse{
	text-align:center;
}
.lx_collapse i{
	font-size: 20px;
	cursor:pointer;
}
.lx_new_section_area_block{
    margin-top: 20px;
}
.text-divider:before{ content: " "; display: block; border-top: 1px solid <?php echo $color_palette['light_grey'];?>; border-bottom: 1px solid <?php echo $color_palette['custom3'];?>;}

.lxed_button{
    margin-right: 5px !important;
}
.lxed_button_dark{
	background-color: <?php echo $color_palette['charcoal'];?> !important;
	border: 1px <?php echo $color_palette['border'];?> solid !important;
    margin-right: 5px !important;
}
.rend_single_choice_block .lxed_single_chose_feedback {
	display:none;
}

.rend_btn_block p{
	margin-bottom:0px !important;
}
.rend_btn_block{
	width:60% !important;
	margin:0 auto !important;
}
.rend_text_block,.break_section,.rend_img_text_block,.rend_text_img_block,.rend_video_block{
	width:80% !important;
	margin:0 auto !important;
}

.rend_img_textonly_block{
	text-align:left;
}
/****/
/** Render CSS Here **/
.render_main_section{
	background: <?php echo $color_palette['light_grey'];?>;
    padding: 15px;
    box-shadow: 5px 5px 5px 0px <?php echo $color_palette['custom1'].'80';?>;
    text-align: center;
	margin-top: 20px;
}
/****/
.rend_img_block{
	width: 75% !important;
	margin:0 auto !important;
}
@media only screen and (min-width: 1025px) {
	.lx_editor_blog_page .lx_editor_blog_page_inner{
		width:20%;
		padding: 15px;
	}
	.rend_img_block{
		width: 60% !important;
		margin:0 auto !important;
	}
	.rend_single_choice_block{
		width:75%;
		margin:0 auto;
	}
}

@media (min-width: 992px){
	.modal-lg {
		max-width: 1000px;
	}
}

/* css by harsh */

.lx_editor_blog_page .card-image .div_top_right {
	position: absolute;
	top: 0px;
	right: 0;
	display: flex;
}
.lx_editor_blog_page .card-image .div_bottom {
	position: absolute;
    bottom: 0;
    width: 100%;
    height: 50px
}
.lx_editor_blog_page .card-body .about {
	word-break: break-word;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -moz-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
    color: <?php echo $color_palette['body_text'];?>;
	padding-left:5px;
	padding-right:5px;
	padding-bottom:5px;
}
.lxed_edit_mode{
	padding: unset;
	width: 35px;
    margin: 5px 10px 0px 0px;
    height: 30px;
}
.lxed_edit_mode img{
	height: inherit !important;
}
.tab_section .nav-link{
	color: <?php echo $color_palette[$heading_text];?>;
	margin-top:10px;
}
.tab_section .nav-link:focus, .nav-link:hover,#nav-tab .active {
   text-decoration: none;
   background: <?php echo $color_palette['white'];?>;
   border-bottom: 2px solid <?php echo $color_palette['green'];?>;
   color: <?php echo $color_palette['green'];?>;
   margin-top:10px;
}
.category span{
	position: relative;
	float: right;
	text-transform: uppercase;
    font-size: 11px;
    color: <?php echo $color_palette['light_grey'];?>;
    right: 3px;
}
.favicon img{
	width: 50px !important;
	padding:5px !important;
	background: <?php echo $color_palette['white'];?>;
	border: 2px solid <?php echo $color_palette['border'];?>;
}
.lxed_check_results{
	background-color: <?php echo $color_palette['blue'];?> !important;	
}
@media (max-width:768px){
	.lx_editor_blog_page_inner{
		margin-top:15px;
	}
}
.lx_editor_addnew_blog .blog_thumb_edit{
	cursor: pointer;
    position: relative;
    float: left;
    z-index: 99;
    bottom: 25px;
}
.lx_editor_addnew_blog .blog_thumb_delete{
	position: relative;
    cursor: pointer;
    bottom: 25px;
    float: right;
}
.lx_editor_addnew_blog .crop_img_course{
	width:80%;
	margin:0 auto;
}
.lx_editor_addnew_blog .have_edit{
	top: 25px !important;
	display:none;
}
.lxed_buttonblocklabel,.lxed_buttonblockdestination{
	background: #fff !important;
    border: unset !important;
    border-bottom: 1px solid #ccc !important;
    padding-left: 0px !important;
}
.lxed_buttonblocklabel:focus,.lxed_buttonblockdestination:focus{
	box-shadow:unset;
}
.lxed_buttonblockdesc:focus-visible {
	outline:unset !important;
}
.lxed_buttonblockdesc p{
	margin-bottom:0px !important;
}
.lxed_buttonblockdesc{
	border-bottom: 1px solid #ccc;
    padding: 10px 0px;
	font-size: 1rem;
}

@media (min-width: 1024px){
.lx_editor_addnew_blog .upload-icon{
	margin-top: 40px !important;
}
}

@media (max-width: 1023px){
.lx_editor_addnew_blog .upload-icon {

    margin-top: 45px !important;
}
}
@media (max-width:767px) { 
	 .have_edit{
	    margin-top: auto;
	  }
	.lx_editor_addnew_blog .blog_title{
		margin-top:20px;
	}
	.lx_editor_addnew_blog .have_edit{
		margin-bottom: 30px;
		margin-top: 0px;
	}
	.lx_editor_addnew_blog .top_button{
		display: flex;
		flex-direction: column;
		width: 95%;
		padding: 10px;
	}
	.lx_editor_addnew_blog .lxed_button{
		margin-top: 10px;
	}
	.lx_editor_addnew_blog .lxed_var_post_title{
		margin-top: 15px;
	}
}
@media(min-width:768px){
  .have_edit{
    margin-top: -10px;
  }
 }
</style>