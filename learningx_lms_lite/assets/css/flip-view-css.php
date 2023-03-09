<?php global $color_palette,$community_tiles_interface,$font_family;?>
<style>
.hide_in_front{
	display: none;
}
.img_edit_topic_mul img{	
	height:100px !important;	
	width:100px !important;
}
.nav-tabs{
	background: <?php echo $color_palette['black'];?>;
}
#myTab .active{
	background-color: <?php echo $color_palette['green'];?>;
	color: <?php echo $color_palette['white'];?>;
}
.txt_show{
	display: block !important;
}
.btn{
	align-items: center !important;
}

#wpadminbar {
    z-index: 100 !important;
}
.page-id-146 #main, .page-id-144 #main{
    margin: 0px !important;
    margin-top: -20px !important;
}
.page-id-146 .entry-content, .page-id-144 .entry-content{
    margin: 0em 0 15px;
}
.information_tab{
	display:none;
	background:<?php echo $color_palette['white'];?>;
	color:<?php echo $color_palette['black'];?>;
	height: 100%;
	top: 45px;
	left: 0px;
	position:fixed;
	padding-top: 10px;
}

.panel-title {
  position: relative;
  cursor: pointer;
}
.panel-heading{
	border: 1px solid <?php echo $color_palette['border'];?>;
    padding: 10px;
    box-shadow: 0px 0px 10px 2px <?php echo $color_palette['light_grey'];?>;
    margin: 10px 0 10px;
}
.panel-heading h4{margin-bottom:0 !important;text-align: left;font-weight: 700;}
.panel-collapse{margin-bottom: 20px;}
.panel-body p{margin-bottom:0em;}
.panel-title::after {
	content: "\f107";
	color:<?php echo $color_palette['charcoal'];?>;
	top: -2px;
	right: 0px;
	position: absolute;
    font-family: "FontAwesome"
}

.panel-title[aria-expanded="true"]::after{content: "\f106";}
.fa-check-circle:before{
	content: "\f058";color:<?php echo $color_palette['green'];?>;
	font-size: 15px;
}
.flips_member_level{border:unset !important;
	width:95%;
	margin: auto; 
	padding-top: 10px;
}
.flips_member_level td{
	padding:1px;
	font-size:12px;
	color:<?php echo $color_palette['black'];?>;
	border:unset !important;
}
.flips_member_hr{
	background:<?php echo $color_palette['black'];?>;
	color:<?php echo $color_palette['white'];?> !important;
	text-align:center;font-size:14px !important;
	border:unset !important;
}
.flips_top_head{
	background:<?php echo $color_palette['black'];?>;
	color:<?php echo $color_palette['white'];?> !important;
	text-align:center;font-size:12px;
}
.getting_involved{background:<?php echo $color_palette['green'];?>;}
.getting_involved td{
	color:<?php echo $color_palette['white'];?> !important;
	text-align:right;
	font-size:14px !important;
}
.flip_txt_right{text-align:right !important;}
.flips_member_level .fa-check-circle{text-align:center;}
.flips_create_forums, .flips_create_topics, .flips_community_type{
	background: #aade444d;
	color: <?php echo $color_palette['black'];?>;
	border:unset !important;
}
.flips_create_forums td, .flips_create_topics td, .flips_community_type td{
	text-align:right;
}
.flips_gray_bg{background: <?php echo $color_palette['mid_grey'];?>;}
.flips_gray_t td, .flips_gray_border td{
	border-top:1px solid <?php echo $color_palette['green'];?> !important;
}
.flips_gray_b td{border-bottom:2px solid <?php echo $color_palette['green'];?> !important;}
.star{
	color: <?php echo $color_palette['orange'];?> !important;
}
.flips_orange_border td{
	border-top: 1px solid <?php echo $color_palette['orange'];?> !important;
}
.mp_join{
    background: <?php echo $color_palette['blue'];?> !important;
	color: <?php echo $color_palette['white'];?> !important;
	font-size: 14px !important;
    border-radius: 20px !important;
    border: 2px solid <?php echo $color_palette['border'];?> !important;
    box-shadow: 2px 3px 15px 5px <?php echo $color_palette['custom1'];?> !important;
    display: block;
    width: 45%;
    padding: unset;
}
.mp_join:visited{
	color: <?php echo $color_palette['white'];?> !important;
}
.dropdown-menu-toggle{
	display: none !important;
}
.audio_response_tab{
	position: relative;
	background: <?php echo $color_palette['white'];?>;
	display: flex;
	margin: 0 auto;
	border:1px solid <?php echo $color_palette['border'];?>;
	max-width: unset !important;
	flex:0.45 !important;
	border-bottom: none;
	box-shadow: 1px -3px 10px 1px <?php echo $color_palette['custom1'];?>;
	cursor: pointer;
    padding:unset !important;
}
.audio_response_up{
	left:0 !important;	
	max-width: 100% !important;	
	background:<?php echo $color_palette['blue'];?> !important;	
	color:<?php echo $color_palette['white'];?> !important;	
	top:0%;	z-index:1;	
	position: fixed; 
	cursor: pointer;
}
.side_tab{
	position: fixed;	
	background: <?php echo $color_palette['charcoal'];?>;
	padding:0;
	width: 50px;
	z-index: 99;
	display: none;
	top:48%;
	float: right;
	right: 0;
} 
.side_tab .btn{
	border-radius: unset !important;
}
.audio_response_tab .flip_icon{
	min-height: 35px !important;
	position: relative;
	bottom: 3px;
}
.ad_info{
	color: <?php echo $color_palette['blue'];?>;
}
.btn_common{
	background: <?php echo $color_palette['white'];?>;
	color:<?php echo $color_palette['charcoal'];?>;
	border: none;
	border-radius: unset;
}
.btn_common:focus{
	color: <?php echo $color_palette['black'];?>;
	background-color: unset;
}
.btn_common:hover{
	background: <?php echo $color_palette['white'];?>;
	color: <?php echo $color_palette['charcoal'];?>;
	border: none;
}
.btn_common_2{
	background: <?php echo $color_palette['charcoal'];?>;
	color:<?php echo $color_palette['white'];?>;
	border: none;
	display: flex;
	flex-direction: column;
	max-width: 100%;
}
.bg_white{
	background: <?php echo $color_palette['white'];?>;
	color: <?php echo $color_palette['charcoal'];?>;
	border-bottom: 1px solid <?php echo $color_palette['charcoal'];?>;
	height: 100%;
	top: 45px;
	left:0px;
	position: fixed;
	padding-top: 10px;
}
.generate-back-to-top, .generate-back-to-top:visited {
    z-index: 0 !important;
}
.min_audio_player{
	z-index: 1;
}
.audio_response_up .expander{
	flex: unset !important;
	margin: 0 auto;
}
.containers{ 
  position: relative;
}
.mepr-price-box-title{
	font-size: 1.2em!important;
	color:<?php echo $color_palette['heading_text'];?>;
	text-align: center;
	margin-bottom: unset !important;
    min-height: 3em;
    display: flex;
    align-items: center;
    justify-content: center;
}
.community_tile_body{
	padding: 0.25rem !important;
}
.community_thumb{
	display: flex;
	height: 200px;
}
.community_thumb img{
	max-width: unset !important;
    width: 100% !important;
}
.community_thumb .home_favicon img{
	max-width: unset !important;
	width: 20% !important;
	position: absolute;
	bottom: 50px;
	left: 10px;
	width: 50px !important;
	padding: 0px !important;
}
.status_bar{
	position: absolute;
	width: 50%;
	right: 4px;
	height: inherit;
	padding: 15px;
	text-align: left;
}
.favicon{
	margin-right: 10px;
}
.lx_view_course{
	width:35%;position: absolute;right: 10px;bottom: 10px;
}
.lx_view_course .btn{
	float: right;
	width: 100%;
}
.c_desc{
	word-break: break-word;
	display: -webkit-box;
	-webkit-box-orient: vertical;
	-moz-box-orient: vertical;
	-webkit-line-clamp: 4;
	overflow: hidden;
	color: <?php echo $color_palette['white'];?>;
	font-size: 0.8em;
	margin-top: 10px;
	min-height: 80px;
}
.c_category{
	position: relative;
    float: right;
    font-size: 12px;
    text-transform: uppercase;
    font-weight: 700;	
    padding: 5px;
}

.home_course{
	cursor:pointer;
}
.esg-entry-media-wrapper{
	z-index: 3 !important;
}
.esg-media-cover-wrapper{
	cursor: pointer !important;
}
.eg-forum_carousel-container {
	background: <?php echo $color_palette['custom3'];?> !important;
}
.btn-primary{
	background: <?php echo $color_palette['blue'];?> !important;
	border:1px solid <?php echo $color_palette['border'];?> !important;
	border-radius:  5px !important;
}
.uploading_wav_file,.uploading_wav_file_save{
	background: <?php echo $color_palette['blue'];?> !important;
	border-radius: 5px !important;
	border:1px <?php echo $color_palette['border'];?> !important;
}
.flip_back_linkk{
	background: <?php echo $color_palette['charcoal'];?> !important;
	border-radius: 5px !important;
	border:1px white !important;
}
.bg_black{
	background: <?php echo $color_palette['charcoal'];?> !important;
}

.site-content{
	overflow: hidden;
}
.thumbnail_flip img{
	width: 100% !important;
	position: relative;
	border: 1px solid <?php echo $color_palette['border'];?>;
	
}

.btn_common3 .flip_icon {
	height: 35px !important;
    width: 40px !important;
}
.other_podcast .card
{
	cursor: pointer;
	border-radius: 1.25rem !important;
	padding: 1rem !important; 
	width: 100% !important;
}

.audioplayer.skin-wave .audioplayer-inner {
    position: relative !important;
}
.min_audio_player .navigation-method-mouseover{
	background: <?php echo $color_palette['charcoal'];?>; 
	position: absolute; 
	bottom: 195px; 
	display: none;
}
.navigation-method-mouseover{
	height:auto !important;
}
.zoomsounds-nav{
	opacity:1 !important;
}
.disabled{
	background: <?php echo $color_palette['custom1'];?> !important;
}
.response_but:focus{
	box-shadow:<?php echo $color_palette['black'];?> !important;
}
.reply_tab {
    position: absolute;
    bottom: 5px;
    float: right;
    right: 0;
}
.reply_but{
	position:relative;
	background: <?php echo $color_palette['purple'];?> !important;
	border-radius:0px !important;
	height: 40px;
    font-size: 1em;
	z-index: 1;
	padding-top: 1px !important;
	float: right;
 	margin-left: 5px;
}
.response_tab{
	display: block;
    background: <?php echo $color_palette['charcoal'];?>;
    position: absolute;
    width: 50% !important;
    height: 100vh;
    bottom: 0px;
    z-index: 99;
    opacity: 0.95;
}
#add_flip_discription:focus{	
	border:1px solid <?php echo $color_palette['border'];?> !important;
}
audio{
	width: -webkit-fill-available !important;
}
/* 
*@ Reply on topic css
*/
.replyModal hr{
	border: <?php echo $color_palette['border'];?>;
	margin-bottom: 10px !important;
    margin-top: 10px !important;
}
.replyModal .flip_container{
	padding-top:unset !important;
} 
.replyModal .topic_close{
	top: -53px;
    color: <?php echo $color_palette['custom2'];?>;
    font-family: unset !important;
}
.replyModal .replyHead{
	font-weight: 600;
	font-size: 1em;
}
.replyEditModal hr{
	border: <?php echo $color_palette['border'];?>;
	margin-bottom: 10px !important;
    margin-top: 10px !important;
}
.replyEditModal .flip_container{
	padding-top:unset !important;
} 
.replyEditModal .replyHead{
	font-weight: 600;
	font-size: 1em;
}
.replyEditModal .topic_close{
	display:none;
}
.replyEditModal .standarized_tab_inner4
{
	display: none;
}
.topic_audio_upload::-webkit-file-upload-button {
	visibility: hidden;
}
.topic_audio_upload::before {
	content: 'Choose File';
	display: inline-block;
	border: 1px solid <?php echo $color_palette['border'];?>;
	border-radius: 5px;
	padding: 5px 8px;
	outline: none;
	white-space: nowrap;
	-webkit-user-select: none;
	cursor: pointer;
	font-weight: 700;
	font-size: 1em;
	color:<?php echo $color_palette['white'];?>;
	background:<?php echo $color_palette['blue'];?>;
}
.topic_audio_upload:active::before {
	background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
}
.topic_attachment::-webkit-file-upload-button {
	visibility: hidden;
}
.topic_attachment::before {
	content: 'Choose File';
	display: inline-block;
	border: 1px solid <?php echo $color_palette['border'];?>;
	border-radius: 5px;
	padding: 5px 8px;
	outline: none;
	white-space: nowrap;
	-webkit-user-select: none;
	cursor: pointer;
	font-weight: 700;
	font-size: 1em;
	color:#fff;
	background: <?php echo $color_palette['blue'];?>;
}
.topic_attachment:active::before {
	background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
}
.main-nav .flip_icon{
	height:40px !important;
}
.btn_common3{
	height:50px;
	z-index: 1;
	background:<?php echo $color_palette['charcoal'];?>;
}

/* thumnail size */
.audioplayer.skin-wave .audioplayer-inner .the-thumb {
	background-size: contain !important;
	background-color:<?php echo $color_palette['white'];?> !important;
}
.topics{
	flex: unset !important;
	max-width: 75% !important;
}
.topics .card-text {
    color: #2196F3 !important;
    font-size: 1.2em !important;
    font-weight: 600 !important;
    padding-bottom: 15px;
	cursor:pointer;
	max-width:max-content;
}
.topics .card-description{
	font-size:0.8em;
	color:<?php echo $color_palette['charcoal'];?>;
}
.topic_play {
   position: relative;    
   top: 5px;  
} 
.zoomsounds-nav.skin-wave .menu-item {
    left: 20px;
}
.zoomsounds-nav.skin-wave .menu-item:first-child {
    left: unset !important;
}
.btn:focus{
	box-shadow: unset !important;
}
.slider_load_here{
	text-align: left;
}
.othe_pod_div_thumb img {
    width: 100%;
    height: auto !important;
}
.response_tab{
	overflow-y: scroll !important;
}
.course_thumb{
	position: relative;
  	margin: 10px;
  	border: 1px solid <?php echo $color_palette['border'];?>;
} 
.course_thumb img{
	max-width: unset !important;
    width: 100% !important;
}
.course_thumb .div_bottom {
	margin-top:30px;
    bottom: 70px;
    width: 100%;
    display: flex;
	height: 45px;
}
.home_course .course_thumb .div_bottom .btn-view {
    margin: 5px;
}
.btn-view{   
	margin: 2px !important;
}
.course_title{
	font-size: 18px !important;
    line-height: 19px !important;
    color: <?php echo $color_palette['heading_text'];?> !important;
    font-weight: 700 !important;
    margin-top: 10px;
}
.course_description{
	font-size: 14px !important;
    line-height: 20px !important;
    color: <?php echo $color_palette['body_text'];?> !important;
	
}
.home_course .course_description, .home_course .course_title,.home_course .content_status{
	margin-left:5%;
}
.home_course .course_title{
	font-family:<?php echo $font_family['heading_font'];?>;
	font-size: 1.2em!important;
}
.home_course .course_description, .home_course .course_status{
	font-family:<?php echo $font_family['body_font'];?>;
}
.course_favicon{
	width: 15% !important;
	margin:2px;
}
.course_favicon img{
    background: <?php echo $color_palette['white'];?>;
    border: 1px solid <?php echo $color_palette['border'];?>;
}
.category span{
	position: relative;
	float: right;
	text-transform: uppercase;
    font-size: 11px;
    color: <?php echo $color_palette['hyperlinks'];?>;
    font-weight: 700;
    padding-top: 10px;
}
.content_status{
	width: 22px;
    height: 22px;
    border: 2px solid <?php echo $color_palette['border'];?>;
    border-radius: 50%;
    margin:0px 5px 0px 3px;
    flex-basis: 22px;
    flex-shrink: 0
}
.home_course .course_status{
    font-size: 13px;
    padding-top: 14px;
}
.display_attachment{
	padding-left:0 !important;
	padding-right:0 !important;
}
.display_attachment iframe{
	height: -webkit-fill-available;
}
.show_attachment{
	border: 1px solid <?php echo $color_palette['border'];?>;
    border-radius: 10px;
    margin: 5px;
    color: <?php echo $color_palette['blue'];?>;
    cursor: pointer;
    word-break: break-all;
}
.attach_link_div{
	display:flex;
}
.home_course_main .course_status {
    font-family:<?php echo $font_family['body_font'];?>;
    font-size: 12px;
    padding-top: 3px;
}
.card_blog_title, .course_title, .post-title {	
	color:<?php echo $color_palette['heading_text'];?> !important;	
	font-family:<?php echo $font_family['heading_font'];?>;
}	

/** other course css **/
.pub_lib_forum .course_thumb img {
	width:100%;
}	
.div_top_right {
	position: absolute;
	top: 0px;
	right: 0;
	display: flex;
}
.more_btn_div{
	display: flex;
    flex-direction: column;
   	 padding: 45px;
    align-items: center;
}
/*********My Account page ********/
#ld-profile .ld-profile-stats{
	display: none !important;
}
/* course content css */
.course_content .modal-body button :hover{
	color:#03A9F4 !important; 
}
.course_content .modal-body button{
	font-size: 14px;
    font-family: monospace;
}
.course_content .modal-body button .block_builder_link{
	color:<?php echo $color_palette['white'];?>;
}
/* home_page_display_community_block */
.mepr-price-box-title{
	color:<?php echo $community_tiles_interface['community_name_color'];?>;
	font-family:<?php echo $font_family['heading_font'];?>;
	font-size: 1.2em!important;
}
.community_type_color{
	color:<?php echo $community_tiles_interface['community_type_color'];?>;
	font-family:<?php echo $font_family['heading_font'];?>;
	font-size: 0.8em!important;
}
.c_desc{
	color:<?php echo $community_tiles_interface['tiles_body_text_color'];?> !important;
	font-family:<?php echo $font_family['body_font'];?>;
}
.status_bar{
	opacity:<?php echo $community_tiles_interface['tiles_colored_bg_opacity'];?> !important;
}
.learndash_post_sfwd-lessons .ld-breadcrumbs{
	padding-left: 25px;
}
.learndash-wrapper .ld-breadcrumbs .ld-breadcrumbs-segments .content_title {
    position: relative;
    top: 2px;
    padding-left: 2px;
}/* css for account page */.ld-account-course-title{	margin:8px;}.ld-text-expand{	margin:8px;}.ld-icon-search-profile{	display:none !important;}
/****************Mobile view******************/
@media(min-width: 768px)
{
	.panel-body{text-align: left;margin-left:40px;}
}
@media(max-width: 767px)
{
	.panel-body{text-align: left;margin-right:40px;}
	.mysbscription{overflow: scroll;}
}
@media(min-width: 1440px){
	.audio_response_tab {
		height: 45px;
		max-width: 34% !important;
	}
	.audio_response_up {
		max-width: 100% !important;
	}
}
@media screen and (min-width: 1800px) and (max-width:1900px){
	.audio_response_tab {
		height: 45px;
		max-width: 27% !important;
	}
	.audio_response_up {
		max-width: 100% !important;
	}
}
@media screen and (min-width: 768px) and (max-width:1024px){
	.center_text {
		width: 65%;
	}
	.login_bg{
		height: 40vh;
	}
}
@media(max-width: 767px){	
	.center_text {
		width: 80%;
	}
	.slide_tab{		
		height: 100vh; 		
		top: 48px;		
		position: fixed;	
		z-index: 0;	
		bottom: 100;	
		left: 0px;		
		padding-top: 15px;
	}
	.audio_response_tab .ad_info{
		padding-top: 10px;
	}
	.audio_response_up .ad_info{
		padding-top: 17px;
		 width: 100%;
	}
	.side_tab {
 	   top: 34%;
	}
	.slider_load_here{
	    overflow-y: scroll;
	    height: 90vh;
	}
	.attach_link_div{
		flex-direction:column;
	}
	 .subscription_table{
		height: 200px;
	} 
	.login_bg{
		height: 36vh;
	}
	.green_text{
		font-size: 13px;
	}
	.sm_text{
		font-size: 10px !important;
	}
}
	
@media(min-width: 1267px) {	

	.slide_tab{		
		top: 45px;	
		position: fixed;	
		z-index: 0;		
		bottom: 100;		
		left: 0px;		
		padding-top: 15px;	
	}
	.audio_response_tab {
		height: 45px;
	}
	.audio_response_up .ad_info{
		padding-top: 15px;
	}
	.audio_response_tab .ad_info{
		padding-top: 10px;
	}
}
	
@media screen and (max-width: 1023px) and (min-width: 768px) {	
	.audio_response_up{		
		top:0%;		
		z-index:1;	
		position: fixed; 
	}		
	.slide_tab{		
		top: 45px;	
		position: fixed;
		z-index: 0;		
		bottom: 100;	
		left: 0px;	
		padding-top: 35px;
	}
	.audio_response_up .ad_info{
		padding-top: 20px;
	}
}
	
@media screen and (max-width: 1266px) and (min-width: 1024px) {	
	.audio_response_up{		
		top:0%;		
		z-index:1;		
		position: fixed; 
	}	
	.slide_tab{	
		height: 88vh;
		 padding-top: 40px;
 	}
	.audio_response_up .ad_info{
		padding-top: 10px;
	}
}
@media(min-width:768px){
	.close_btn {
		background: <?php echo $color_palette['purple'];?>;
	    font-size: 1em;
	    position: fixed;
	    width: auto;
	    top: 0%;
		right: 50%;
	    left: 47%;
	    z-index: 100;
	    height: 100%;
	    display: none;
	    cursor: pointer;
	}
	.close_tab_rep{
		transform: rotate(90deg);
		position: fixed;
		top: 50%;
		left: -1.5%;
		right: 1%;
		width: 100%;
	}
	.subscription_table{
		height: 255px;
	}
}
@media(min-width:768px){
	.main-navigation .main-nav .my_communities {
		width : 230px !important;
	}
}
@media only screen and (max-width: 425px) {
	.login_btn{
			width: 45% !important;
	}
}

@media only screen and (max-width: 992px) {
	.btn_label{
			display: none;
	}
}

@media all and (max-width: 769px) and (min-width: 425px) {
	.edit_icon_btn{
			font-size: 14px;
			bottom: -29px !important;
	}
}
@media only screen and (max-width: 767px) {
	.standarized_tab_innr1 .span1{
			right:0px !important;
	}
	.replyModal-content {
		width: 85% !important;
	}
	.response_tab{
		width:100% !important;
	}
}
@media only screen and (max-width: 1440px) {
	.wrap{
			position: relative;
			right: 30px !important;
	}
}
@media only screen and (max-width: 1024px) {
	.wrap{
			position: relative;
			right: 10px !important;
	}
}
/**For rotation Mode view of response tab **/
@media screen and (max-height:414px)
{
	.response_tab{
		height: 100vh !important;
	}
}
@media screen and (max-height:375px)
{
	.response_tab{
		height: 100vh !important;
	}
}
@media screen and (max-height:320px)
{
	.response_tab{
		height: 100vh !important;
	}	
}
@media screen and (max-width:320px)
{
	.flip_icon{
		height: 35px !important;
	}
}
@media (min-width: 576px){
	.podcast_div .col-sm-3 {
		max-width: 20% !important;
	}
}
@media screen and (min-width: 576px) and (max-width: 812px){
	.col-sm-3 {
	    flex: 0 0 50% !important;
	    max-width: 45% !important;
	}
}
</style>