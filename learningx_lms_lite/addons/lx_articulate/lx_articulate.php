<?php
/*
Plugin Name: Lx Articulate
Description: Use To create web based atriculate content.
Version: 1.0
Author: VW Priyanka
*/


global $lx_articulate_plugin_path,$lx_articulate_plugin_url;
$lx_articulate_plugin_path=plugin_dir_path(__FILE__);
$lx_articulate_plugin_url=plugin_dir_url(__FILE__);

require($lx_articulate_plugin_path.'/classes/class_articulate_post.php');
$lx_articulate=new lx_articulate_post();
require($lx_articulate_plugin_path.'/classes/class_include_assets.php');
$lx_articulate_assets=new lx_articulate_assets();
require($lx_articulate_plugin_path.'/classes/class_articulate_ajax.php');
$lx_articulate_ajax=new lx_articulate_ajax();
require($lx_articulate_plugin_path.'/functions/functions.php');