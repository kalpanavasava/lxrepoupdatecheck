<?php
function FlipRecordingCanvasLite() {
	ob_start();
	global $lx_plugin_urls;
?>
	<script src="<?php echo $lx_plugin_urls['lx_lms_lite'].'assets/js/select2.min.js'; ?>" ></script>
<?php
	FlipRecordingUI();
?>
	<script>
		jQuery(document).ready(function() {
			jQuery('.fliplist_selection').select2();
		});
	</script>
<?php
	$ob = ob_get_clean();
	return $ob;
}
add_shortcode( 'fliprecording', 'FlipRecordingCanvasLite', 20);