<?php
global $button_styling,$color_palette,$lx_plugin_urls,$font_family,$lightbox_settings,$style_2_tiles_interface;
$dev_tools = get_option('developer_tools');
?>
<style>
a{
	color:<?php echo $color_palette['hyperlinks'];?>
}
.site-footer .site-info{
	padding: 10px 40px !important;
	font-size: 0.8em;
}
button:focus {
	outline: none !important;
}
.btn_normal_state{
	<?php echo $button_styling['normal_state']; ?>
}
.btn_normal_inverse_state,.btn_normal_inverse_state:hover,.btn_normal_inverse_state:focus{
	<?php echo $button_styling['hover_state']; ?>
}
.btn_normal_state_who{
	<?php echo $button_styling['normal_state']; ?>
}
.btn_normal_state:hover{
	<?php echo $button_styling['hover_state']; ?>
}
.btn_normal_state:focus{
	<?php echo $button_styling['normal_state']; ?>
}
.btn_selected_state{
	<?php echo $button_styling['selected_state']; ?>
}
.btn_disabled_state{
	<?php echo $button_styling['disabled_state']; ?>
}
.btn_disabled_state:hover{
	<?php echo $button_styling['disabled_state']; ?>
}
.btn_dark_state:hover{
	<?php echo $button_styling['dark_hover_state']; ?>
}
.btn_dark_state:focus{
	<?php echo $button_styling['dark_state']; ?>
}
.btn_dark_state{
	<?php echo $button_styling['dark_state']; ?>
}
.btn_danger_state{
	<?php echo $button_styling['danger_state']; ?>
}
.btn_danger_state:hover{
	<?php echo $button_styling['danger_hover_state']; ?>
}
.btn_danger_state:focus{
	<?php echo $button_styling['danger_state']; ?>
}
.btn_inverse_danger_state{
	<?php echo $button_styling['inverse_danger_state']; ?>
}
.btn_inverse_danger_state:hover{
	<?php echo $button_styling['inverse_danger_hover_state']; ?>
}
.color_palette_hyperlinks{
	color:<?php echo $color_palette['hyperlinks']; ?> !important;
}
.color_palette_heading_text{
	color:<?php echo $color_palette['heading_text']; ?> !important;
}
.color_palette_body_text{
	color:<?php echo $color_palette['body_text']; ?>;
}
.color_palette_blue{
	color:<?php echo $color_palette['blue']; ?>;
}
.color_palette_green{
	color:<?php echo $color_palette['green']; ?>;
}
.color_palette_orange{
	color:<?php echo $color_palette['orange']; ?>;
}
.color_palette_red{
	color:<?php echo $color_palette['red']; ?>;
}
.color_palette_purple{
	color:<?php echo $color_palette['purple']; ?>;
}
.color_palette_black{
	color:<?php echo $color_palette['black']; ?>;
}
.color_palette_charcoal{
	color:<?php echo $color_palette['charcoal']; ?>;
}
.color_palette_white{
	color:<?php echo $color_palette['white']; ?>
}
.color_palette_light_grey{
	color:<?php echo $color_palette['light_grey']; ?>;
}
.color_palette_mid_grey{
	color:<?php echo $color_palette['mid_grey']; ?>;
}
.color_palette_custom1{
	color:<?php echo $color_palette['custom1']; ?>;
}
.color_palette_custom2{
	color:<?php echo $color_palette['custom2']; ?>;
}
.color_palette_custom3{
	color:<?php echo $color_palette['custom3']; ?>;
}
.color_palette_custom4{
	color:<?php echo $color_palette['custom4']; ?>;
}
.color_palette_blue_bg{
	background :<?php echo $color_palette['blue']; ?>;
}
.color_palette_green_bg{
	background:<?php echo $color_palette['green']; ?>;
}
.color_palette_orange_bg{
	background:<?php echo $color_palette['orange']; ?>;
}
.color_palette_red_bg{
	background:<?php echo $color_palette['red']; ?> !important;
}
.color_palette_purple_bg{
	background:<?php echo $color_palette['purple']; ?>;
}
.color_palette_black_bg{
	background:<?php echo $color_palette['black']; ?>;
}
.color_palette_charcoal_bg{
	background:<?php echo $color_palette['charcoal']; ?>;
}
.color_palette_white_bg{
	background:<?php echo $color_palette['white']; ?>
}
.color_palette_light_grey_bg{
	background:<?php echo $color_palette['light_grey']; ?>;
}
.color_palette_mid_grey_bg{
	background:<?php echo $color_palette['mid_grey']; ?>;
}
.color_palette_custom1_bg{
	background:<?php echo $color_palette['custom1']; ?>;
}
.color_palette_custom2_bg{
	background:<?php echo $color_palette['custom2']; ?>;
}
.color_palette_custom3_bg{
	background:<?php echo $color_palette['custom3']; ?>;
}
.color_palette_custom4_bg{
	background:<?php echo $color_palette['custom4']; ?>;
}
.tab_bottom{
	cursor:pointer;
	border-bottom: 2px solid <?php echo $color_palette['hyperlinks'];?> !important;
}
@font-face {
	font-family: Cera Pro Bold;
	src: url(<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/fonts/Cera_Pro_Bold.ttf'?>);
	font-weight: normal;
}
@font-face {
	font-family: Cera Pro Regular Italic;
	src: url(<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/fonts/Cera_Pro_Regular_Italic.otf'?>);
	font-weight: normal;
}
@font-face {
	font-family: Cera Pro Medium;
	src: url(<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/fonts/Cera_Pro_Medium.ttf'?>);
	font-weight: normal;
} 
@font-face {
	font-family: Gotham Bold;
	src: url(<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/fonts/Gotham_Bold.otf';?>);
	font-weight: normal;
} 
@font-face {
	font-family: Gotham Regular;
	src: url(<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/fonts/Gotham_Book_Regular.otf';?>);
	font-weight: normal;
} 
@font-face {
	font-family: Nunito Sans;
	src: url(<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/fonts/nunito-sans.regular.ttf'?>);
	font-weight: normal;
}
@font-face {
	font-family: Montserrat;
	src: url(<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/fonts/Montserrat-Regular.ttf'?>);
	font-weight: normal;
}
@font-face {
	font-family: Oswald;
	src: url(<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/fonts/Oswald-Regular.ttf'?>);
	font-weight: normal;
}
@font-face {
	font-family: Poppins;
	src: url(<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/fonts/Poppins-Regular.ttf'?>);
	font-weight: normal;
}
@font-face {
	font-family: Raleway;
	src: url(<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/fonts/Raleway-Regular.ttf'?>);
	font-weight: normal;
}
@font-face {
	font-family: SourceSansPro;
	src: url(<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/fonts/SourceSansPro-Regular.ttf'?>);
	font-weight: normal;
}
h1,h2,h3,h4,h5,h6{
	font-family:<?php echo $font_family['heading_font'];?>
}
.head_h1,h1{
	<?php 
	if(!empty($font_family['h1_font'])){
		echo $font_family['h1_font']; 
	}else{ ?>
		font-size: 1.6em;
		font-weight: 600;
		letter-spacing: 0px;
	<?php } ?>
	
}
.head_h2,h2{
	<?php 
	if(!empty($font_family['h2_font'])){
		echo $font_family['h2_font']; 
	}else{ ?>
		font-size: 1.2em;
		font-weight: 600;
		letter-spacing: 0px;
	<?php } ?>
}
.head_h3,h3{
	<?php 
	if(!empty($font_family['h3_font'])){
		echo $font_family['h3_font']; 
	}else{ ?>
		font-size: 1em;
		font-weight: 600;
		letter-spacing: 0px;
	<?php } ?>
}
.head_h4,h4{

	<?php 
	if(!empty($font_family['h4_font'])){
		echo $font_family['h4_font']; 
	}else{ ?>
		font-size: 20px;
		font-weight: 600;
		letter-spacing: 0px;
	<?php } ?>
}
.head_h5,h5{
	<?php 
	if(!empty($font_family['h5_font'])){
		echo $font_family['h5_font']; 
	}else{ ?>
		font-size: 18px;
		font-weight: 600;
		letter-spacing: 0px;
	<?php } ?>
}
.head_h6,h6{
	<?php 
	if(!empty($font_family['h6_font'])){
		echo $font_family['h6_font']; 
	}else{ ?>
		font-size: 16px;
		font-weight: 600;
		letter-spacing: 0px;
	<?php } ?>
}
<?php
if ( ! is_admin() ) {
?>
body{
	<?php 
	if(!empty($font_family['body_font_size'])){
		?>
		font-size:<?php echo $font_family['body_font_size']; ?>px;
		font-family:<?php echo $font_family['body_font']; ?>;
		<?php
	}else{ ?>
		font-size: 14px;
		font-weight: 400;
		letter-spacing: 0px;
	<?php } ?>
}
<?php }else{
	?>
body{
	<?php 
	if(!empty($font_family['body_font_size'])){
		?>
		font-size:<?php echo $font_family['body_font_size']; ?>px;
	<?php }else{ ?>
	font-size:14px;
	<?php } ?>
}
	<?php
} ?>
.body_bold_font{
	<?php
		if(!empty($font_family['body_bold_font'])){
			echo $font_family['body_bold_font']; 
		}else{
			?>
			font-size: 14px;
			font-weight: 600;
			letter-spacing: 0px;
			<?php
		}
	?>
}
.lx_lms_sub_text{
	<?php
	if(!empty($font_family['sub_text_font']))
	{
		echo $font_family['sub_text_font'];
	}else{ ?>
		font-size: 0.8em;
	<?php } ?>
}
.course_info_hr{
	margin-bottom: 5px !important;
    margin-top: 5px !important;
}
.card_blog_description{
	word-break: break-word;
}
a:hover {
	text-decoration: none !important;
}
.style_3_main_div .view_status_div{
	position: relative;
	float:right;
}
.style_3_main_div .description_info{
	margin-bottom: 20px !important;
}
.style_3_main_div {
   /*  margin: 10px; */
    padding: 5px;
}
.card_blog_title a ,.card_blog_title a:hover ,.card_blog_title a:focus {
	color:<?php echo $color_palette['hyperlinks']; ?> !important;
}
.view_content_status_div{
	position: relative;
	float:right;
	display: flex;
	align-items: center;
}

.content_title a, .content_title a :hover, .content_title a :focus{
	color:<?php echo $color_palette['hyperlinks'];?> !important;
}
.community_title a, .community_title a :hover, .community_title a :focus{
	color:<?php echo $color_palette['hyperlinks'];?> !important;
}
.course_title a, .course_title a :hover, .course_title a :focus{
	color:<?php echo $color_palette['hyperlinks'];?> !important;
}
.content_course_title a , .content_course_title a :hover , .content_course_title a :focus {
	color:<?php echo $color_palette['hyperlinks'];?> !important;
}
.card_course_content_lightbox{
	cursor: pointer;
}
.style_6_modal_main_div .modal_header_main_div{
	width:100%;
	align-items: center;
}
.style_6_modal_main_div .alt_modal_title{
	color: <?php echo $lightbox_settings['modal_title_color'];?>;
	font-size: <?php if(!isset($lightbox_settings['modal_title_size']) || empty($lightbox_settings['modal_title_size']) ){ ?>1.2em;<?php }else{ echo $lightbox_settings['modal_title_size']; } ?>;
}
.style_6_main_div .articulate_title{
	overflow-wrap: anywhere;
}
.style_6_main_div{
	display: grid;
}
.lx_home_main .equal-height {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
}
.lx_home_main .equal-height .equal-column {
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    overflow: hidden;
}
.lx_home_main .equal-column {
	width:100%;
}
.wp-block{
	max-width: calc(1800px - 40px - 40px) !important;
}
.lbl_articulate_format, .lbl_articulate_category{
	margin:3px;
}
@media (max-width:767px){
	.lx_home_main .equal-height,.equal-column{
		display:unset !important;
	}
}
<?php
if( !isset($lightbox_settings['modal_top_bar_title_alignment']) || $lightbox_settings['modal_top_bar_title_alignment']=="center" ){ ?>
	.style_6_modal_main_div .alt_modal_title_adjustment{
		display: inline-block;
		align-items: center;
	}
	.style_6_modal_main_div .modal-title{
		text-align: center!important;
	}
<?php
}else{
?>
	.style_6_modal_main_div .alt_modal_title_adjustment{
		display: flex;
		align-items: center;
	}
	.alt_modal_title{
		padding-left: 10px;
	}
<?php
} 
?>
.style_5_main_div .btn-view-data , .style_5_main_div .btn-view-data:hover , .style_5_main_div .btn-view-data:focus{
	padding-top: 9px !important;
}
.style_5_main_div .post-title{
	text-align: center;
	margin-top: 10px;
	min-height: 3em;
    display: flex;
    align-items: center;
    justify-content: center;
}
.articulate_delete{
	cursor: pointer;
}
.fav_img{
	position: absolute;
	left: 5px;
	width: 16%;
	bottom: 54%;
}
.style3_fav_img{
	position: absolute;
	left: 10px;
	width: 16%;
	bottom: 60%;
}
.community_existance{
	display: none;
}
.btn_reset_main{
	display: flex;
    align-items: center;
}
#btn_reset .svg-inline--fa{
	height: 1.8em;
}
<?php if(!is_user_logged_in()){
	?>
	#new-royalslider-1{
		display:none;
	}
	<?php
}?>
.upload-certificates-file-input {
	display: inline-block;
	text-align: left;
	background: #FFFFFF;
	padding: 5px;
	width: 100%;
	position: relative;
	border-radius: 3px;
	border: 1px solid #EFEFEF;
	cursor: pointer !important;
}
.upload-certificates-file-input>[type='file'] {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	opacity: 0;
	z-index: 10;
	cursor: pointer !important;
}

.upload-certificates-file-input>.button {
	display: inline-block;
	cursor: pointer;
	background: <?php echo $color_palette['hyperlinks'];?> !important;
	color: <?php echo $color_palette['white'];?> !important;
	padding: 3px 6px;
	border-radius: 4px;
	margin-right: 8px;
	border-color: unset;
}

.upload-certificates-file-input:hover>.button {
	background: <?php echo $color_palette['hyperlinks'];?> !important;
	color: <?php echo $color_palette['white'];?> !important;
}

.upload-certificates-file-input>.label {
	color: <?php echo $color_palette['charcoal'];?> !important;
	white-space: nowrap;
	position: relative;
	top: 9px;
}

.upload-certificates-file-input.-chosen>.label {
	opacity: 1;
}
.cfg_del{
	border: 1px solid <?php echo $color_palette['border'];?>;
	margin: -5px;
	float: right;
	font-family: cursive;
	padding: 13px 13px;
	position: relative;
}
.backend_alert_box {
	position: fixed;
	border: 1px solid #e0e0e0;
	border-radius: 15px;
	text-align: center;
	margin: auto 8%;
	width: 50%;
	padding: 30px;
	z-index: 100;
	background: #fff;
	top: 40%;
	box-shadow: 0px 1px 15px 10px rgb(0 0 0 / 35%);
}
.alert_box_del_popup {
	z-index: 1050;
}
.delete_popup_btn_main_class {
	margin-top: 10px;
}
.delete_popup_btn_main_class .btn_delete_popup_yes {
	width: 70px;
	margin-right: 10px;
}
.delete_popup_btn_main_class .btn_delete_popup_cancel {
	width: 70px;
}
.sm_on{
	background: #ff8d00;
    color: #fff;
    padding: 5px 10px;
    font-weight: 500;
    display: none;
}
.pv_spinner img,.sv_spinner img,.pv_lrs_spinner img,.sv_lrs_spinner img{
	width: 40px;
    padding: 10px;
}
.pv_spinner,.sv_spinner,.pv_lrs_spinner,.sv_lrs_spinner{
	display: none;
}
.lb_grid{
	display: grid;
}
.description_body{
	<?php echo $font_family['body_font_info'];?>
	color:<?php echo $color_palette['body_text']; ?>;
}
.create_certificate_note{
    margin-left: auto;
    margin-right: 65px;
    border: 2px solid skyblue;
    padding:10px; 
    width: fit-content;
}
.current_template{
	margin: 5px;
}
.font_gray{
	color: #969896;
}
.settings_iconography .form-group{
	align-items: center;
}
.lx_toggle{
	width: 55px;
	height: 50px;
}
.lx_toggle input{
	opacity: 0;
	width: 0;
	height: 0;
}
.lx_toggle span{
	position: absolute;
	width: inherit;
	height: inherit;
	top: 5px;
}
.lx_toggle .svg-inline--fa{
	height: auto;
}
.lx_toggle .fa-toggle-off{
	color: <?php echo $color_palette['mid_grey'];?>;
}
.lx_toggle .fa-toggle-on{
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.ai_center{
	align-items: center;
}
#wpbody .lx_toggle span{
	left: 15px;
}
.community_row,.front_page_info{
	justify-content: center;
}
.info_box{
	border: 1px solid <?php echo $color_palette['infobox_border'];?>;
	padding: 10px;
	margin-bottom: 10px;
	display: flex;
	align-items: center	;
}
.info_box_icon{
	padding: 5px;
	color: <?php echo $color_palette['infobox_icon'];?>;
}
.info_box_icon svg{
	font-size: 26px;
}
.btn_edit_tiles{
	position: absolute;
    float: right;
    right: 0px;
}
/* Fl1p Recording tile Css */
.fr_style1 .fr_card_body,.fr_style2 .fr_card_body{
	padding: 0.5rem;
}
.fr_style3 .fr_card_body{
	padding: 0;
}
.fr_card_img a{
	position: relative;
}
.fr_card_edit{
	position: absolute;
	top: 0;
	right: 0;
}
.fr_center_bar_div{
	background: <?php echo $style_2_tiles_interface['completion_bg_color']; ?>;
    opacity: 95%;
    height: 50px;
    display: flex;
    align-items: center;
    position: relative;
}
.fr_style2 .fr_view_btn{
	position: absolute;	
	right: 5px;
}
.fr_style3{
	padding: 5px;
}
@media (max-width:767px) { 
	.style_6_modal_main_div .alt_modal_favicon{
		display:none;
	}
	.fav_img{
		bottom: 46% !important;
	}
	.style3_fav_img{
		bottom: 50%;
	}
	.home_course_main{
		margin:10px;
	}
}
@media (max-width:768px) and (min-height:1024px){
	.view_content_status_div{
		font-size:9px !important;
	}
	.style_3_main_div .view_status_div{
		display: contents;
	}
	.style_3_main_div .course_status{
		font-size: 11px !important;
	}
	.style_3_main_div .btn-view{
		font-size: 12px !important;
	}
	
}
@media (max-width:1024px) and (min-height:1366px){ 
	.style_3_main_div .view_status_div{
		display: contents;
	}
	.style_3_main_div .course_status{
		font-size: 11px !important;
	}
}
</style>
<?php 
if($dev_tools=='off' || empty($dev_tools)){
?>
<script>
jQuery(document).ready(function()
{ 
    jQuery(document).bind("contextmenu",function(e){
        return false;
    }); 
    document.onkeydown = function(e) {
		if(event.keyCode == 123) {
			return false;
		}
		if(e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.keyCode == 'H'.charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.keyCode == 'A'.charCodeAt(0)){
			return false;
		}
	}
});
</script>
<?php
}
?>