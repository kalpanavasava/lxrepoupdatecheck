<?php 
global $color_palette,$font_family;
$manually=false;
if(metadata_exists('post',$post->ID,'tool')){
    $manually=true;
}
if($manually){
?>
<style>
    body{
        position: fixed;
        width:100%;
    }
    /*.lesson_content{
        overflow-y: scroll;
        overflow-x: hidden;
    }*/
    .row{
        margin-right: unset !important;
        margin-left: unset !important;
    }
</style>
<?php   
}
?>
<style>
	<?php if(is_user_logged_in()){ ?>
	.loggedin_logo{
		display: none;
	}
	.join-site{
		display:none;
	}
	.main-navigation,.site-footer{
		display: none;
	}
	<?php } ?>
	a {
		transition: background 0.2s, color 0.2s;
	}

	a:hover,
	a:focus {
		text-decoration: none;
	}
	.main_header .div_border {
		border-right: 1px solid #e2e7ed;
	}

	.mb_toggle_btn {
		color: #000;
		font-size: 22px;
	}

	.main_header .ld_progress .progress_percentage {
		text-transform: uppercase;
		color: <?php echo $color_palette['hyperlinks']?>;
	}

	.main_header .ld_progress .progress {
		height: 8px;
	}

	#wrapper {
		padding-left: 0;
		transition: all 0.5s ease;
		position: relative;
	}

	#sidebar-wrapper {
		z-index: 1000;
		position: fixed;
		left: 350px;
		width: 0;
		height: 100%;
		margin-left: -350px;
		overflow-y: auto;
		overflow-x: hidden;
		background-color: <?php echo $color_palette['white']?>;
		border-right: 1px solid #e2e7ed;
		transition: all 0.5s ease;
	}

	#wrapper.toggled #sidebar-wrapper {
		width: 350px;
	}

	.sidebar-brand {
		position: absolute;
		top: 0;
		width: 350px;
		text-align: center;
		padding: 20px 10px;
		background-color: <?php echo $color_palette['hyperlinks']?>;
	}

	.sidebar-brand h2 {
		margin: 0;
		font-weight: 600;
		font-size: 24px;
		color: <?php echo $color_palette['white']?>;
	}

	.sidebar-nav {
		position: absolute;
		width: 350px;
		margin: 0;
		padding: 0;
		list-style: none;
	}

	.sidebar-nav>li {
		padding: 10px;
		border-bottom: 1px solid #e2e7ed;
		background-color: <?php echo $color_palette['white']?>;
	}

	.sidebar-nav>li a {
		display: flex;
		text-decoration: none;
		color: #757575;
		font-weight: 600;
		font-size: 18px;
		align-items: center;
	}

	.sidebar-nav>li>a:hover,
	.sidebar-nav>li.active>a {
		color: <?php echo $color_palette['hyperlinks']?>;
	}

	.sidebar-nav>li>a i.fa {
		font-size: 24px;
		width: 60px;
	}

	#navbar-wrapper {
		width: 100%;
		position: absolute;
		z-index: 2;
	}

	#wrapper.toggled #navbar-wrapper {
		position: absolute;
		margin-right: -350px;
	}

	#navbar-wrapper .navbar {
		border-width: 0 0 0 0;
		background-color: #eee;
		margin-bottom: 0;
		border-radius: 0;
	}



	#navbar-wrapper .navbar .navbar-header .toggle_btn {
	   transform: translateY(-50%) translateX(25%);
		position: absolute;
		top: 33px;
		left: -30px;
		border-radius: 50%;
		color: <?php echo $color_palette['white']?>;
		background-color: <?php echo $color_palette['hyperlinks']?>;
		z-index: 1;
		font-size: 14px;
		padding: 5px 11px
	}

	#navbar-wrapper .navbar a {
		color:<?php echo $color_palette['hyperlinks']?>;
	}

	#navbar-wrapper .navbar a:hover {
		color: <?php echo $color_palette['hyperlinks']?>;
	}

	#navbar-wrapper .navbar .navbar-header .ld_status {
		border-radius: 15px;
		background-color:  <?php echo $color_palette['hyperlinks']?> !important;
		text-align: center;
		padding: 0px 12px;
		margin: 4px;
		text-transform: uppercase;
		font-weight: 700;
		letter-spacing: .5px;
		font-size: 11px;
		color: <?php echo $color_palette['white']?>;
		float: right;
	}

	#content-wrapper {
		width: 100%;
		position: absolute;
		top: 100px;
	}

	#wrapper.toggled #content-wrapper {
		position: absolute;
		margin-right: -250px;
	}

	.sidebar-brand .ld_lesson_title {
		color: <?php echo $color_palette['white']?>;
		margin-right: 35px;
	}

	.sidebar-brand .ld_icon {
		font-size: 20px;
		margin-right: 10px;
		color: <?php echo $color_palette['white']?>;
	}

	.sidebar-brand .ld_lesson_title {
		font-weight: 500;
	}

	.ld_status_icon {
		width: 15px;
		height: 15px;
		flex: 0 0 15px;
		border: 0;
		text-align: center;
		margin-right: 10px;
		margin-top: .15em;
		border-radius: 50%;
	}

	.ld_status_incomplete {
		border: 2px solid #e2e7ed;
	}

	.ld_lesson_title {
		font-size: 1em;
		font-weight: 400;
		flex: 1;
		display: flex;
		font-family: <?php echo $font_family['heading_font'];?>;
	}
	.ld_content_title{
		font-size: 14px;
		font-weight: 400;
		flex: 1;
		display: flex;
		font-family: <?php echo $font_family['body_font'];?>;
	}
	.breadcrumb_item_size {
		overflow: hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
		align-items: center;
	}
	.btn_brd_home{ 
		height: unset !important;
		padding: 2px 20px !important;
		margin-right: 5px;
		font-size: 16px;
		font-weight: 500;
	}
	.breadcrumb-item+.breadcrumb-item::before {
		display: inline-block;
		padding-right: .5rem;
		color: #6c757d;
		content: ">";
	}
	.breadcrumb-item{
		font-family: <?php echo $font_family['body_font'];?>;
		color: <?php echo $color_palette['charcoal'];?> !important;
	}
	.ld_mark_complete{
		align-self: center;
		text-align: center;
	}
	.vw_lession_mark_complete{
		border-radius: 20px !important;
	}
	.ld_content_action{
		display: flex;
	}
	.content_list_href .fa-check-circle{
		color: <?php echo $color_palette['hyperlinks'];?>;
		font-size: 15px;
	}
	.progress-bar{
		background-color: <?php echo $color_palette['hyperlinks'];?> !important;
	}
	.progress_text,.ld_text{
		font-size: 0.9em;
		font-family: <?php echo $font_family['body_font'];?>;
	}
	.ld_text:hover{
		color: <?php echo $color_palette['hyperlinks'];?>;
	}
	@media (min-width: 992px) {
		.main_header .ld_content_action {
			border-top: none;
		}

		.mb_toggle_btn {
			display: none;
		}

		#wrapper {
			padding-left: 50px;
		}

		#wrapper.toggled {
			padding-left: 350px;
		}

		#sidebar-wrapper {
			width: 350px;
			left: unset;
			z-index: 0;
		}

		#wrapper.toggled #sidebar-wrapper .sidebar-nav {
			opacity: 1;
		}
		#sidebar-wrapper .sidebar-nav {
			opacity: 0;
		}

		#wrapper.toggled #navbar-wrapper {
			position: absolute;
			margin-right: -190px;
		}

		#wrapper.toggled #content-wrapper {
			position: absolute;
			margin-right: -190px;
		}

		#navbar-wrapper {
			position: relative;
		}
		
		#content-wrapper {
			position: relative;
			top: 0;
		}

		#wrapper.toggled #navbar-wrapper,
		#wrapper.toggled #content-wrapper {
			position: relative;
			margin-right: 60px;
		}
	}

	@media (min-width: 768px) and (max-width: 991px) {
		.main_header .div_border {
			border-right: none;
		}

		#navbar-wrapper .navbar .navbar-header .toggle_btn {
			display: none;
		}

		#wrapper.toggled #navbar-wrapper {
			position: absolute;
			margin-right: -250px;
		}

		#wrapper.toggled #content-wrapper {
			position: absolute;
			margin-right: -250px;
		}

		#navbar-wrapper {
			position: relative;
		}

		#content-wrapper {
			position: relative;
			top: 0;
		}

		#wrapper.toggled #navbar-wrapper,
		#wrapper.toggled #content-wrapper {
			position: relative;
			margin-right: 250px;
		}
	}

	@media (max-width: 767px) {
		.main_header .ld_content_action {
			border-top: 1px solid #e2e7ed;
		}

		.main_header .div_border {
			border-right: none;
		}

		#navbar-wrapper .navbar .navbar-header .ld_status {
			width: 100%;
			float: unset;
		}

		#wrapper {
			padding-left: 0;
		}

		#sidebar-wrapper {
			width: 0;
		}

		#wrapper.toggled #navbar-wrapper {
			position: absolute;
			margin-right: -250px;
		}

		#wrapper.toggled #content-wrapper {
			position: absolute;
			margin-right: -250px;
		}

		#navbar-wrapper {
			position: relative;
		}
		
		#navbar-wrapper .navbar .navbar-header .toggle_btn {
			display: none;
		}

		#content-wrapper {
			position: relative;
			top: 0;
		}

		#wrapper.toggled #navbar-wrapper,
		#wrapper.toggled #content-wrapper {
			position: relative;
			margin-right: 250px;
		}
	}
	.lesson_content{
		width: 100%;
		position: absolute;
		top: 0;
	}
	#poll_modal .pollcontent_card{
		width: 100% !important;
	}
	.poll_content{
		margin-bottom: 15px !important;
		padding: 0 !important;
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
</style>