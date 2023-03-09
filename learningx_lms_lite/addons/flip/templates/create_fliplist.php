<?php 
function FliplistCanvasLite() {
	ob_start();
	global $lx_plugin_urls;
?>
	<script src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/js/select2.min.js'; ?>" ></script>
<?php
	if( !is_user_logged_in() || current_user_can('subscriber') ){
		echo "<div class='text-center' style='color:".$color_palette['red']."'>You are not allowed to view this page</div>";
		return;
	}
	
	Fl1plistTopUI();
	Fl1plistDetailsUI(); 
	if( !is_plugin_active(VWPLUGIN_PRO) ){ 
		DisplayLocationLiteUI();
	} else { 
		DisplayLocationProUI(); 
	}
	Fl1plistBottomUI(); 
?>
	<script>
		jQuery(document).ready(function() {
			jQuery('.fliplist_select').select2();
		});
		CropFliplistThumbnail();
	</script>
<?php
	$ob = ob_get_clean();
	return $ob;
} 
add_shortcode( 'fliplistcanvas', 'FliplistCanvasLite',20 );
?>