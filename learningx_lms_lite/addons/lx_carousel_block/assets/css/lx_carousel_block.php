<?php global $color_palette,$community_tiles_interface,$font_family; ?>
<style>
/* css for community */
.custom_block .mepr-price-box-title h3{
	color:<?php echo $community_tiles_interface['community_name_color'];?>;
	font-family:<?php echo $font_family['heading_font'];?>;
	font-size: 1.2em!important;
	text-align: center!important;
}
.custom_block .community_tile_body {
    padding: 0.25rem !important;
}
.custom_block .community_thumb {
    display: flex;
	height: 155px;
}
.custom_block .community_row .card, .home_course_main .card, .course_main .card{
	padding:unset !important;
}
.custom_block .community_row .status_bar{
	opacity:<?php echo $community_tiles_interface['tiles_colored_bg_opacity'];?> !important;
	font-size: 0.7em;
}
.custom_block .status_bar {
    position: absolute;
    width: 50%;
    right: 4px;
    height: inherit;
    padding: 15px;
    text-align: left;
}
.custom_block .community_thumb .home_favicon img{
	max-width: unset !important;
	width: 20% !important;
	position: absolute;
	bottom: 38px;
	left: 10px;
	width: 50px !important;
	padding: 0px !important;
	border: 2px solid<?php echo $color_palette['border'];?>;
}
.custom_block .mepr-price-box-button {
    position: absolute;
    position: absolute;
    left: 60%;
    width: 30%;
    text-align: center;
    bottom: 40px;
}
/* css for courses */
.custom_block .course_tab_row .card{
	padding:unset !important;
}
.custom_block .course_tab_row .favicon_course .course_status{
	font-family:<?php echo $font_family['body_font'];?>;
    font-size: 13px;
    padding-top: 14px;
}
.custom_block .content_status {
    width: 22px;
    height: 22px;
    border: 2px solid;
    border-radius: 50%;
    margin: 11px 5px 0px 3px;
    flex-basis: 22px;
    flex-shrink: 0;
}
.custom_block .card_blog_title,.custom_block  .course_title, .post-title {	
	color:<?php echo $color_palette['heading_text'];?> !important;	
	font-family:<?php echo $font_family['heading_font'];?>;
}
.custom_block .home_course_main .course_status {
    font-family: <?php echo $font_family['body_font'];?>;
    font-size: 13px;
    padding-top: 14px;
}
.custom_block h1{
	<?php 
	if(!empty($font_family['h1_font'])){
		echo $font_family['h1_font']; 
	}else{ ?>
		font-size: 1.6em;
		font-weight: 600;
		letter-spacing: 0px;
	<?php } ?>
	
}
.custom_block h2{
	<?php 
	if(!empty($font_family['h2_font'])){
		echo $font_family['h2_font']; 
	}else{ ?>
		font-size: 1.2em;
		font-weight: 600;
		letter-spacing: 0px;
	<?php } ?>
}
.custom_block .card_blog_title h3{
	
		font-size: 1em !important;
		font-weight: 600 !important;
		letter-spacing: 0px !important;
}
.custom_block h4{
	<?php 
	if(!empty($font_family['h4_font'])){
		echo $font_family['h4_font']; 
	}else{ ?>
		font-size: 20px;
		font-weight: 600;
		letter-spacing: 0px;
	<?php } ?>
}
.custom_block  h5{
	<?php 
	if(!empty($font_family['h5_font'])){
		echo $font_family['h5_font']; 
	}else{ ?>
		font-size: 18px;
		font-weight: 600;
		letter-spacing: 0px;
	<?php } ?>
}
.custom_block  h6{
	<?php 
	if(!empty($font_family['h6_font'])){
		echo $font_family['h6_font']; 
	}else{ ?>
		font-size: 16px;
		font-weight: 600;
		letter-spacing: 0px;
	<?php } ?>
}
.custom_block .section_title_community{
	display:none;
}
.custom_block input[type=text]:focus {
    border-color: #fff !important;
    box-shadow: 0 0 0 1px #fff !important;
    outline: 2px solid transparent !important;
	text-align: center;
	position: absolute;
    bottom: 90%;
}
.custom_block input[type=text] {
    border-color: #fff !important;
    box-shadow: 0 0 0 1px #fff !important;
    outline: 2px solid transparent !important;
	text-align: center;
	position: absolute;
    bottom: 90%;
}
.custom_block .standarized_tab_innr1 {
    color: #333;
    font-size: 1.2em;
    padding: 7px;
    width: 100%;
    text-align: center;
    background: #fff;
    border-bottom: 1px solid #EFEFEF;
}
.custom_block .c_desc{
	word-break: break-word !important;
	display: -webkit-box !important;
	-webkit-box-orient: vertical !important;
	-moz-box-orient: vertical !important;
	-webkit-line-clamp: 4 !important;
	overflow: hidden !important;
	color: <?php echo $color_palette['white'];?> !important;
	font-size: 0.8em;
	margin-top: 10px !important;
	min-height: 80px !important;
}
.custom_block .c_category {
    position: relative;
    float: right;
    font-size: 12px;
    text-transform: uppercase;
    font-weight: 700;
    padding: 5px;
}
.custom_block .community_type_color{
	color:<?php echo $community_tiles_interface['community_type_color'];?>;
	font-family:<?php echo $font_family['heading_font'];?>;
	font-size: 0.8em!important;
}
.custom_block .selection_msg{
	display:block !important;
}
.custom_block .course_main .course_status{
	padding: 10px;
}
.custom_block .standarized_tab_innr_course{
	border-bottom: 3px solid #EFEFEF !important;
}
.editor-block-list-item-lx-course-content-block-lx-block .dashicons, .editor-block-list-item-lx-course-blocks-lx-block .dashicons, .editor-block-list-item-lx-articulate-web-block-lx-block .dashicons, .editor-block-list-item-lx-community-block-lx-block .dashicons{
	color:<?php echo $color_palette['hyperlinks'];?> !important;
}
</style>
<script type="text/javascript">	
	/* function for change course tab */
	function opentabinfo(evt, tabevent, class_info) {
		var j=1;
		jQuery( ".course_tab_row" ).each(function( index ) {
			jQuery( this ).addClass( "course_tab_row_"+j );
			jQuery(this).find('.tablinks').attr('data-id',j);
			j=j+1;
		});
		var i, tabcontent, tablinks;
		var tab_count = evt.path[0].getAttribute('data-id');
		jQuery('.course_tab_row_'+tab_count).find('.tab_bottom').removeClass('tab_bottom');
		jQuery('.course_tab_row_'+tab_count+' .'+ class_info).addClass('tab_bottom');
		jQuery('.'+ class_info).children().css('color' , "#000000");
		tabcontent = document.getElementsByClassName("tabcontent");
		jQuery('.course_tab_row_'+tab_count+' .tab_course_content').hide();
		tablinks = document.getElementsByClassName("course_tab_row_"+tab_count+" "+"tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		jQuery('.course_tab_row_'+tab_count+" ."+tabevent).show();
		evt.currentTarget.className += " active";
	}
	/* function for change articulate tab */
	function opentabinfoAltWeb(evt, tabevent, class_info) {
		var j=1;
		jQuery( ".alt_web_tab_row" ).each(function( index ) {
			jQuery( this ).addClass( "alt_web_tab_row_"+j );
			jQuery(this).find('.alt_web_tablinks').attr('data-id',j);
			j=j+1;		
		});
		var i, tabcontent, tablinks;
		var tab_count = evt.path[0].getAttribute('data-id');
		jQuery('.alt_web_tab_row_'+tab_count).find('.alt_web_tab_bottom').removeClass('alt_web_tab_bottom');
		jQuery('.alt_web_tab_row_'+tab_count+' .'+ class_info).addClass('alt_web_tab_bottom');	jQuery('.'+ class_info).children().css('color' , "#000000");
		tabcontent = document.getElementsByClassName("alt_web_tabcontent");
		jQuery('.alt_web_tab_row_'+tab_count+' .articulate_content').hide();
		tablinks = document.getElementsByClassName("alt_web_tab_row_"+tab_count+" "+"alt_web_tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		jQuery('.alt_web_tab_row_'+tab_count+" ."+tabevent).show();		evt.currentTarget.className += " active";
	}
	/* function for change fliplist tab */
	function opentabinfo_fl1plist(evt, tabevent, class_info) {
	    var j=1;
	    jQuery( ".fl1plist_tab_row" ).each(function( index ) {
	        jQuery( this ).addClass( "fl1plist_tab_row_"+j );
	        jQuery(this).find('.tablinks').attr('data-id',j);
	        j=j+1;
	    });
	    var i, tabcontent, tablinks;
	    var tab_count = evt.path[0].getAttribute('data-id');
	    jQuery('.fl1plist_tab_row_'+tab_count).find('.tab_bottom').removeClass('tab_bottom');
	    jQuery('.fl1plist_tab_row_'+tab_count+' .'+ class_info).addClass('tab_bottom');
	    jQuery('.'+ class_info).children().css('color' , "#000000");
	    tabcontent = document.getElementsByClassName("tabcontent");
	    jQuery('.fl1plist_tab_row_'+tab_count+' .tab_fl1plist_content').hide();
	    tablinks = document.getElementsByClassName("fl1plist_tab_row_"+tab_count+" "+"tablinks");
	    for (i = 0; i < tablinks.length; i++) {
	        tablinks[i].className = tablinks[i].className.replace(" active", "");
	    }
	    jQuery('.fl1plist_tab_row_'+tab_count+" ."+tabevent).show();
	    evt.currentTarget.className += " active";
	}
	var my_ajax_object = {'ajax_anchor':"<?php echo admin_url( 'admin-ajax.php' );?>"}
</script>