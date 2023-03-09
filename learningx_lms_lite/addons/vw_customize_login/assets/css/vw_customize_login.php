<?php global $color_palette,$font_family; ?>
<style>
.vw_customize_login_main .is_logo_img img{
	width:18%;
}
.vw_customize_login_main .main_header_div{
	display:flex;
	flex-direction: column;
}
.vw_customize_login_main .title_info{
	padding: 10px;
	font-weight: 700;
    font-size: 23px;
}
.vw_customize_login_main{
	position: relative !important;
}
.email_resend_div #txt_resend_email{
	background: #fff;
}
.vw_customize_login_main .email_resend_div{
	margin-top: 20px;
}
.vw_customize_login_main .cancel_div,.vw_customize_login_main .resend_div{
	padding-top: 20px;
}
.vw_customize_login_main .cancel_div .btn_cancel,.vw_customize_login_main .resend_div .resend_verification_email{
	width:100%;
}
.vw_customize_login_main .lbl_error_msg {
    display: none;
    color: #ff0000;
	float: left;
    margin-top: 5px;
}
.verification_resend .alert-danger{
	color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
}
.verification_resend .alert{
	position: relative;
    padding: .75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: .25rem;
}
.error_msg_div{
	margin-top:20px;
	margin-bottom:20px;
}
.verification_resend .btn_register{
	margin-top:20px;
	margin-bottom:20px;
	width:100%;
}
.btn_verify_login{
	width:100%;
	margin-top:20px;
}
.resend_email_close{
	position: relative;
    left: 48%;
	color: <?php echo $color_palette['hyperlinks'];?>;
	font-size: 20px;
}
.forgot_pwd_css , .forgot_pwd_css:hover{
	color: <?php echo $color_palette['hyperlinks'];?>;
	cursor: pointer;
}
.forgot_password_link{
	margin-top: 20px;
	float: left;
	font-size: 22px;
	font-family: <?php echo $font_family['body_font'];?>;
	
}
.vw_customize_login_main .note{
	font-family: <?php echo $font_family['body_font'];?>;
	font-size:15px;
}
.vw_customize_login_main .main_header_div{
	font-family: <?php echo $font_family['heading_font'];?>;
}
.vw_customize_login_main .custom_forgot_password_modal{
	display:none;
}
.forgot_main_div{
	display: flex;
    justify-content: center;
    align-items: center;
}
.lbl-header-title {
	color:#ffffff;
}
.alert-login-msg{
    font-size: 1rem;
}
.alert-login-msg1{
    font-size: 1.1rem;
    background: #ffffff !important;
    color: red !important;
    border-color: #ffffff !important;
    float: center;
}
.center {
  display: flex;
  justify-content: center;
  align-items: center; 
}
.login_container .btn-login, .login_container .btn-join {
	background-color: <?php echo $color_palette['hyperlinks'];?> !important;
	border-color: <?php echo $color_palette['hyperlinks'];?> !important;
	width:100% !important;
	margin-top:15px;
	color: #fff !important;
}
.btn-register{
	background-color: <?php echo $color_palette['green'];?> !important;
	border-color: <?php echo $color_palette['green'];?> !important;
	width:100% !important;
	color: #fff !important;
}
.btn_reg_cancel{
	background-color: <?php echo $color_palette['light_grey'];?> !important;
	border-color: <?php echo $color_palette['light_grey'];?> !important;
	width:100% !important;
	margin-top:15px !important;
	margin-right:15px !important;
	color: #000 !important;
}
.reg_label{
	color: <?php echo $color_palette['hyperlinks'];?> !important;
	font-size: 14px !important;
	font-weight: 400 !important;
}
.lp_label{
	color: #000 !important;
	font-size: 14px !important;
	font-weight: 400 !important;
}
.login_container .btn-login:hover {
	background-color: <?php echo $color_palette['hyperlinks'];?> !important;
	border-color: <?php echo $color_palette['hyperlinks'];?> !important;
	width:100% !important;
}
.login_container .btn-login:focus{
	background-color: <?php echo $color_palette['hyperlinks'];?> !important;
	border-color: <?php echo $color_palette['hyperlinks'];?> !important;
	width:100% !important;
	box-shadow: none !important;
}
.forgot_pwd_css, .email_verification_link{
	font-size:18px !important;
	color: <?php echo $color_palette['hyperlinks'];?> !important;
}
.is_logo_img img{
	width:18%;
}
.lbl_error_msg{
	display: none;
	color: #ff0000;
}
.mainheader{
	display:none;
}
.main_header_div{
	display:flex;
	flex-direction: column;
}
.title_info{
	padding: 10px;
    font-weight: 700;
    font-size: 23px;
}
.divider_form{
	padding: 5px;
}
label{
	font-weight: 700;
}
.uwp_login{
	max-width: 500px !important;
}
.custom_login{
	max-width: 500px !important;
}
.login_container .locked_open{
	width: 100%;
}
.login_row .card{
	position: relative;
	transform:translateY(100%) scale(0.8);
    box-shadow: 0 0 40px 4px #111118;
}
.login_row .locked_open{
	opacity: 1;
	transform: translateY(0%) scale(1);
	transition: transform 0.6s, opacity 0.6s;
    transition-delay: 0.5s;
    margin: auto;
}
.receipt_font{
	font-size:30px;
	font-family: <?php echo $font_family['body_font'];?>;
}
.receipt_content{
	background-color: white;
	height: 10000px;
	display:none;
}
.receipt_favicon{
	width:15%;
}
.receipt_header_text{
	font-size:20px;
	font-family: <?php echo $font_family['body_font'];?>;
}
@media (max-width: 768px){
	.login_container{
		width: 100% !important;
	}
}
article{
	overflow: hidden;
}
.login_close{
	position: relative;
    left: 47%;
	top: 4px;
	color: <?php echo $color_palette['hyperlinks'];?>;
	font-size: 20px;
	cursor: pointer;
}
.login_container .strong, .login_container .medium{
	color:#008000;
}
.login_container .short, .login_container .weak{
	color:#ff0000;
}
.login_container .email_verification_div{
	margin-top:10px;
}
.login_container .alert{
	display: flex;
    align-items: center;
}
.invalid_error_msg{
	margin-left: 5px;
}
.register_title{
	color: <?php echo $color_palette['hyperlinks'];?>;
	font-size: 18px;
	margin-top: 10px;
}
hr {
    margin-top: 0rem !important;
}
.step_container .dot{
	border-radius: 50%;
    background-color: #fff;
    display: flex;
	align-items: center;
	font-size: 1.7em;
}
.step_container_info .dot{
	height: 77px;
    width: 77px;
}
.step_container .line,.line1{
	width: 100%;
    position: relative;
	border-bottom: 5px solid <?php echo $color_palette['hyperlinks'];?>;
}
.step_container .line{
	top: 77px;
}
.step_container .line1{
	top: 63px;
}
.step_container .fname_div{
	margin-top:30px;
}
.not_perform_step{
	background-color: <?php echo $color_palette['hyperlinks'].'38';?> !important;
	color: <?php echo $color_palette['hyperlinks']; ?> !important; 
}
.step_label{
	min-height: 2.2em;
}
.not_perform_step_text{
	position: absolute;
    top: 65px;
    right: 33px;
    font-size: 20px;
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.step_label_disabled{
	color:#e9ecef;
}
.bsui .text-center{
	background: #fff;
    margin: 0;
    padding: 0;
}
.payment_step_container .dot{
	height: 55px;
    width: 55px;
}
.active{
	border: 5px solid <?php echo $color_palette['hyperlinks'];?>;
}
.steps_label_main{
	font-size:11px !important;
}
.bsui .steps_label_main .col-1{
	flex: 0 0 8.33333% !important;
    max-width: 28.33333% !important;
}
.step_container .step_container .row{
	margin-right: 0;
    margin-left: 0;
}
.five_step_text{
	margin-right: -27px !important;
	margin-left: -29px !important;
}
@media (max-width:767px){
	.step_container .dot{
		height: 52px !important;
		width: 52px !important;
	}
	.step_container .line{
		top:66px !important;
	}
	.payment_step_container .dot{
		height: 40px !important;
		width: 40px !important;
	}
	.line1{
		top:23px !important;
	}
	.five_step_text{
		text-align: center;
		margin-left: -11px !important;
		margin-right: -9px !important;
		font-size: 11px;
	}
	.five_step_text .col{
		padding-right: 0px !important;
		padding-left: 0px !important;
	}
	.rc-anchor-normal .rc-anchor-pt{
		padding-right: 35px !important;
	}
	.g-recaptcha{
		transform:scale(0.82);
		-webkit-transform:scale(0.82);
		transform-origin:0 0;
		-webkit-transform-origin:0 0;
	}
}
@media (max-width: 280px) {
	.step_container .dot{
		height: 45px !important;
		width: 45px !important;
	}
	.step_container .line{
		top: 60px !important;
	}
	.step_container .step_container{
		padding: unset;
	}
	.step_info_text_info {
		bottom: 38px !important;
		font-size: 9px !important;
	}
	.step_info_text {
		bottom: 25px !important;
		font-size: 9px !important;
	}
	.g-recaptcha{
		transform:scale(0.70);
		-webkit-transform:scale(0.70);
		transform-origin:0 0;
		-webkit-transform-origin:0 0;
	}
}
.step_container .text-center{
	flex-grow: inherit !important;
}
.bsui .payment_step_container .col-1 {
    max-width: 12.33333%;
}
.fname_div{
	margin-top: 20px;
}
/* custom stylings */
:root {
  --active-bg-color: #1975CF;
  --active-text-color: white;
  --inactive-bg-color: #C4DDF4;
  --inactive-text-color: #3480D2;
  --line-width: 5%;
  --active-circle-diam: 30px;
  --inactive-circle-diam: 50px;
}
.ul_steps {
	font-family: Arial;
}


/* --- breadcrumb component --- */
.ul_steps {
	position:relative;
	display:flex;
	justify-content: space-between;
	align-items: center;
	padding: 0;
}
.ul_steps li:only-child {
	margin: auto;
}

/* lines */
.ul_steps li:not(:last-child):after {
	content: '';
	position: absolute;
	top: calc((100% - var(--line-width)) / 2);
	height: var(--line-width);
	z-index: -1;
}
/* circles */
.ul_steps li {
	overflow: hidden;
	text-align:center;
	border-radius: 50%;
	text-indent: 0;
	list-style-type: none;
}

/* active styling */
.lx_steps_info_li,
.lx_steps_info_li:not(:last-child):after {
  background: <?php echo $color_palette['hyperlinks'];?> !important;
	color: var(--active-text-color);
}

/* inactive styling */
.ul_steps li.active:after,
.ul_steps li.active ~ li,
.ul_steps li.active ~ li:not(:last-child):after {
  background: var(--inactive-bg-color);
	color: var(--inactive-text-color);
}

/* circle sizing */
.ul_steps li.active {
	width: var(--active-circle-diam);
	height: var(--active-circle-diam);
	line-height: calc(var(--active-circle-diam) + 0.1rem);
	font-size: calc(var(--active-circle-diam) / 1.6);
}
.ul_steps li:not(.active) {
	width: var(--inactive-circle-diam);
	height: var(--inactive-circle-diam);
	line-height: calc(var(--inactive-circle-diam) + 0.1rem);
	font-size: calc(var(--inactive-circle-diam) / 1.6);
}

/* 
Calculate ddynamic width using css3 only.
N.B. if you know the total count, hardcode away!
*/

.ul_steps li:first-child:nth-last-child(2):not(:last-child):after,
.ul_steps li:first-child:nth-last-child(2) ~ li:not(:last-child):after {
    width: calc((100% - 2rem) / 1);
}
.ul_steps li:first-child:nth-last-child(3):not(:last-child):after,
.ul_steps li:first-child:nth-last-child(3) ~ li:not(:last-child):after {
    width: calc((100% - 2rem) / 2);
}
.ul_steps li:first-child:nth-last-child(4):not(:last-child):after,
.ul_steps li:first-child:nth-last-child(4) ~ li:not(:last-child):after {
    width: calc((100% - 2rem) / 3);
}
.ul_steps li:first-child:nth-last-child(5):not(:last-child):after,
.ul_steps li:first-child:nth-last-child(5) ~ li:not(:last-child):after {
    width: calc((100% - 2rem) / 4);
}
.ul_steps li:first-child:nth-last-child(6):not(:last-child):after,
.ul_steps li:first-child:nth-last-child(6) ~ li:not(:last-child):after {
    width: calc((100% - 2rem) / 5);
}
.ul_steps li:first-child:nth-last-child(7):not(:last-child):after,
.ul_steps li:first-child:nth-last-child(7) ~ li:not(:last-child):after {
    width: calc((100% - 2rem) / 6);
}

.ul_steps li:first-child:nth-last-child(8):not(:last-child):after,
.ul_steps li:first-child:nth-last-child(8) ~ li:not(:last-child):after {
    width: calc((100% - 2rem) / 7);
}
ol, ul {
    margin: unset !important;
}
.follow_step{
	background: #fff !important;
	border: solid 2px <?php echo $color_palette['hyperlinks'];?> !important;
	color: #000000 !important;
}
@media (max-width: 320px) {
	:root {
		--inactive-circle-diam: 33px !important;
	}
}
.receipt_and_access_main_div hr{
	margin-top:0px !important
}
<?php 
	$colour = $color_palette['hyperlinks'];
	$brightness = 0.2;
	$newColour = colourBrightness($colour, $brightness);
?>
.not_follow_steps{
	background: <?php echo $newColour;?> !important;
	color: <?php echo $color_palette['hyperlinks'];?> !important;
}
.modal-content{
	background-color: unset !important;
}
.step_info_text{
	position: absolute;
	bottom: 36px;
	font-size: 12px;
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.step_info_text_main{
	display: flex;
	justify-content: center;
	align-items: center;
}
.step_info_text_info{
	position: absolute;
	bottom: 53px;
	font-size: 12px;
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.finished_step{
	background: <?php echo $color_palette['hyperlinks'];?> !important;
    color: #fff !important;
	box-shadow: 0px 0px 8px #000000 ;
    border: solid 1px#fff;
}
.remaining_steps{
	color: #dedada;
}
.steps_margin{
	margin: -2px;
}
.payment_title_info{
	letter-spacing: normal;
	width: 100%;
	text-align: center;
}
.is_logo_img{
	text-align: center;
	margin-top: 20px;
}
.txt_payment_title{
	color: <?php echo $color_palette['hyperlinks'];?>;
}
.step_design_payment{
	width:100%;
	letter-spacing: normal;
}
.lx_payment_buttons_main_div{
	padding:20px;
	display: flex;
	justify-content: center;
}
</style>