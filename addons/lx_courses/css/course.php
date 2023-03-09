<?php 
global $color_palette,$lx_lms_settings,$font_family;
?>
<style>
#primary{
	overflow: hidden;
}
.content_tab .c_title {
	font-size:30px!important;
	padding-top:10px !important;
}
.c_description {
	font-size:15px!important;
	padding-top:10px !important;
	padding-right:5px !important;
	color: <?php echo $color_palette['body_text'];?>;
}
.author{	
	display: grid;
}
.author  .the_author{	
	color: <?php echo $color_palette['hyperlinks'];?>;    
	text-decoration: underline;    
	text-transform: capitalize;
}
<?php 
if($lx_lms_settings['author_visiblity']=="OFF"){ ?>
.author{
	display:none;
}
<?php } ?>
.content_heading{
	font-size: 24px;
	font-family: <?php echo $font_family['heading_font'];?>;
}
.content_status{
	width: 22px;
    height: 22px;
    border: 2px solid <?php echo $color_palette['border'];?> ;
    border-radius: 50%;
    margin: 0px 10px 0px 0px;
    flex-basis: 22px;
    flex-shrink: 0
}

.content_list_item{
	padding: 5px;
    border: 1.5px solid <?php echo $color_palette['border'];?> ;
    margin-bottom: 10px;
    cursor: pointer;
    display: flex;
}
.content_list_item_head{
	padding: 5px;
    margin-bottom: 10px;
    display: flex;
	align-items: center;
}
.sectionHeadingMain{
	border-bottom: 1px solid <?php echo $color_palette['mid_grey'];?> ;
}
.content_list_link{
	flex: 0.9;
	align-items:center;
}
.content_title {
    color: <?php echo $color_palette['heading_text'];?> ;
}
.content_list_link .content_title:hover{
	color: <?php echo $color_palette['hyperlinks'];?> ;
}
.content_action{
	display: flex;
	flex: 0.1;
	position: relative;
	left: 20px;
}
.content_action .btn{
	width: 35px;
	height: 35px;
	margin-right: 15px;
	color:<?php echo $color_palette['white'];?>;
}
.swap_up_down{
	display: flex;
	flex-direction: column;
	width: 50px;
	margin-top: -5px;
}
.swap_up,.swap_down{
	background: <?php echo $color_palette['white'];?> ;
    padding: unset;
    width: 25px;
    height: 20px;
    color: <?php echo $color_palette['hyperlinks'];?>;
}
.swap_up .fa,.swap_down .fa{
	font-size:28px;
}
.swap_up:hover,.swap_down:hover,.swap_up:focus,.swap_down:focus{
	background-color: <?php echo $color_palette['white'];?>  !important;
	color: <?php echo $color_palette['hyperlinks'];?>  !important;
}
.btn_back{
	margin-left: 1em;
    border-radius: unset !important;
    margin-top: 10px;
}
.btn_course_edit {
	padding: 5px;
    width: 35px;
}
.add_content_div{
	text-align: center;
    border: 2.5px solid <?php echo $color_palette['border'];?> ;
    border-style: dashed;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 15px;
}	
.add_content{
	color:<?php echo $color_palette['hyperlinks'];?> !important;
	cursor: pointer;
	background: #fff !important;
}
.add_content:hover{
	color:<?php echo $color_palette['hyperlinks'];?> !important;
	background: #fff !important;
}
.content_title1{
	font-size: 14px;
	font-weight: 600;
}
.ld-breadcrumbs-course-nav{	
	background:  <?php echo $color_palette['light_grey'];?>;
    padding: .5rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.nav_course_parent_community_name{	
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.nav_course_parent_community_name:hover{	
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.nav_course_parent_community_name:focus{	
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.course_progress {
	display: flex;
	align-items: center;
	justify-content: center;
}
.course_progress span{
	font-size: 11px;
}
.lx_progress_bar {
	height: 7px;
   background-color: <?php echo $color_palette['white'];?>;
   border-radius: 7px;
   margin: 5px 5px;
   overflow: hidden;
	background: #e2e7ed;
	width: 27%;
	margin-top: 6px;
}
.lx-progress-heading {
    display: flex;
    justify-content: space-between;
    font-size: .75em;
    line-height: 1em;
}
.lx-progress-stats {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
}
.lx-progress-percentage{
	margin-right: 1.5em;
	color: <?php echo $color_palette['course_completed'];?>
}
.lx-progress-bar-percentage{
	height: -webkit-fill-available;
    background: <?php echo $color_palette['course_completed'];?>;
}
.course_content .c_description, .content_title,.content_title1{	
   color: <?php echo $color_palette['body_text'];?>;
   font-family:<?php echo $font_family['body_font'];?>;
   font-size: 1em !important;
}
.course_percent{
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.course_status{
	padding: 4px 20px !important;
    margin: -2px 10px;
    height: 24px !important;
	text-transform:uppercase !important;
}
.cpd_points_main{
	display:flex;
}
.course_cpd_points, .course_time{
	width:50%;
}
.course_info_left_div{
	display: grid;
    grid-auto-flow: column;
}
.course_info_left_inside_div{
	width: 90%;
}
.course_info_left_div .edit_course{
	text-align: end;
}
.course_content_info{
	border-bottom: 1px solid <?php echo $color_palette['border'];?> ;
}
.course_content_main .course_title_main_div .c_title h1, .course_content_main .course_title_main_div .course_sub_title h2{
	word-break: break-word;
	display: -webkit-box;
	-webkit-box-orient: vertical;
	-moz-box-orient: vertical;
	-webkit-line-clamp: 2;
	overflow: hidden;
}
/*********STYLE 4*********/
#style-4::-webkit-scrollbar-track {
	-webkit-box-shadow: inset 0 0 6px #333;
	background-color: #ccc;
}

#style-4::-webkit-scrollbar {
	width: 5px;
	background-color: #ccc;
}

#style-4::-webkit-scrollbar-thumb {
	background-color: <?php echo $color_palette['hyperlinks'];?>;
	border: 0px solid <?php echo $color_palette['charcoal'];?>;
}
.scrollbar{
	overflow-y: auto;
    overflow-x: hidden;
}
.course_content_heading{
	height:40px;
}
.course_content_heading h2{
	border-bottom: 1px solid <?php echo $color_palette['border'];?>;
}
.add_content_main_div{
	padding-left: 5px;
    padding-right: 5px;
}
.tab_title_col{
	margin-right: 10px;
	display:flex;
	justify-content: center;
	align-items:center;
	height: 45px;
    padding: 13px 10px;
	cursor: pointer;
	font-size: 12px;
    font-weight: 600;
}
.active_tab{
	background-color: <?php echo $color_palette['white'];?>;
    color: <?php echo $color_palette['hyperlinks'];?>;
	outline-style:solid;  
    outline-color:<?php echo $color_palette['hyperlinks'];?>;    
    outline-width:1px;
}
.not_active_tab{
	background-color: <?php echo $color_palette['hyperlinks'];?>;
	color: <?php echo $color_palette['white'];?>;
}
.tab_content_row{
	display:none;
}
<?php /* .tab_content_info{
	color: <?php echo $color_palette['body_text'];?>;
	font-family:<?php echo $font_family['body_font'];?>;
	font-size: 1em !important;
}  */
?>
.row_tab{
	margin:0 auto !important;
	display: flex;
    text-align: center;
    justify-content: center;
}
.row_tab a h4{
	text-align: center;
}
.card_micro{
	padding:30px;
}
.micro_title, .micro_module_title{
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.micro_module_description{
	word-break: break-word;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -moz-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
}
.btn_micro_module{
	width: 110px;
}
.course_content_main .course_content .c_title,.content_heading, .modal-title{	
   color: <?php echo $color_palette['heading_text'];?>;	
   font-family: <?php echo $font_family['heading_font'];?>;
}	
.course_content_main .course_content .c_description,.course_content_main  .content_title1{	
   color: <?php echo $color_palette['body_text'];?>;	
}
.course_content_main .course_status{
	border-radius: 12px;
    text-align: center;
    padding: 5px 12px;
    text-transform: uppercase;
    font-weight: 700 !important;
    letter-spacing: .5px;
    font-size: 10px !important;
    line-height: 1.2;
}
.course_content_main .tab_title_col label{
	 cursor: pointer;
}
.certificate_include_buttons button{
	width:70px;
}
.asp_product_buy_btn_container{ width:100%; }
.lbl_include_certificate{
	display: flex;
    align-items: center;
}
.btn_cerfificate_disable{
	pointer-events: none;
}
.certificate_del_main{
	display:flex;
	border: 1px solid <?php echo $color_palette['border'];?>;
	align-items: center;
}
.certificate_link{
	width: 50%;
}
.certificate_del_btn{
	width: 50%;
	text-align: center;
}
.btn_delete_certificate_link{
	cursor:pointer;
	float:right;
}
.certificate_error_msg{
	color: <?php echo $color_palette['red'];?>;
}
.certificate_del_btn .btn_delete_certificate_link {
	margin-right: 15px;
    margin-top: 6px;
}
.content_list_item .content_title{
	word-break: break-word;
}
.content_list_item{
	align-items: baseline;
}
.delete_course_thumbnail{
	position: absolute;
	top: 0;
	right: 0;
}
@media (max-width: 767px){ 
	.course_content_main .course_status {
		line-height: 1.4;
	}
	.tab_title_col {
		margin-right: 0px !important;
	}
	.row_tab {
		margin: 13px !important;
	}
	.tab_content_info {
		margin: 13px !important;
	}
	.prgress_and_lessons{
		padding:2em !important;
	}
	.content_tab {
		padding-left: 30px !important;
	    padding-right: 30px !important;
	}
	.content_title{
		font-size: 14px !important;
	}
	.add_content_div{
		margin-top: 15px;
	}
	.course_right_row{
		margin-top: 50px;
	}
	.tab_main_class .tab_title_col{
		margin-bottom: 10px;
	}
	.course_content_main .course_progress{
		display: flex;
		flex-wrap:wrap;
		text-align: center;
		align-items: center;
	}
	.course_content_main .lx_progress_bar{
		width:100% !important;
	}
	.course_content_main .course_status{
		margin-top:10px;
	}
	.course_content_main .course_status_main{
		display: flex;
		justify-content: center;
		width: 100%;
	}
	.course_content_main .status_label_text, .last_time_stamp{
		width: 100%;
		display: flex;
		justify-content: center;
	}
	.course_content_main .last_time_stamp{
		margin-top: 5px;
	}
	.course_content_main .progress_main_div{
		display: flex;
		justify-content: center;
	}
	.course_content_main .course_title_main_div .c_title, .course_content_main .course_title_main_div .course_sub_title{
		text-align: center;
	}
	.course_content_main .progress_main_div, .card_micro{
		margin-top:10px;
	}
	.course_content_main .progress_ststus_main_div{
		display: flex;
		justify-content: center;
		width: 100%;
	}
	.content_list_item{
		display:block !important;
	}
	.content_action{
		left: 0px !important;
		justify-content: end;
	}

}
@media(min-width: 768px){
	.prgress_and_lessons{
		padding:1em 2em 0 0 !important;
	}
	.content_tab {
		padding:  1em 1.2em 1em 2em !important  
	}
	.tab_main_class{
		margin-top: 5.2em;
	}
}	
@media (min-width:767px) and (max-width:1024px){
	.course_content_main .lx_progress_bar {
		width:26% !important;
	}
	.course_content_main .tab_title_col{
		height: auto;
		padding: 8px 11px;
		display:grid;
	}
	.progress_ststus_main_div .course_status {
		font-size: 7px !important;
		line-height: 2.1;
	}
	.course_content_main .course_progress span {
		font-size: 7px !important;
		font-weight: 600;
	}
	.course_content_main .lx_progress_bar {
		    margin-top: 7px;
	}
	.content_action{
		left: 5px !important;
	}
	.tab_main_class{
		margin-top: 5.2em;
	}
	.course_info_left_inside_div, .course_cpd_points, .course_time{
		width: 100% !important;
	}
	.cpd_points_main {
		display: flex !important;
		flex-direction: column !important;
	}
	.btn_edit_icon, .btn_delete_icon {
		height: 35px !important;
		width: 35px !important;
		padding: 6px 9px !important;
	}
	.content_list_item .content_title{
		word-break: break-all;
		width: 75px;
	}
}
</style>