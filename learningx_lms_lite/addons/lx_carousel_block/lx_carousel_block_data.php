<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
global $wpdb;
global $lx_carousel_block_paths,$lx_carousel_block_urls;
$lx_carousel_block_paths = plugin_dir_path(__FILE__);
$lx_carousel_block_urls = plugin_dir_url(__FILE__);
require_once($lx_carousel_block_paths.'classes/class_lx_carousel_block_course.php');
require_once($lx_carousel_block_paths.'classes/class_lx_carousel_block_course_content.php');
require_once($lx_carousel_block_paths.'classes/class_lx_carousel_block_articulate_web.php');
require_once($lx_carousel_block_paths.'classes/class_lx_carousel_block_fliprecording.php');
require_once($lx_carousel_block_paths.'classes/class_lx_fliplist_carousel.php');
require_once($lx_carousel_block_paths.'functions/functions.php');
?>