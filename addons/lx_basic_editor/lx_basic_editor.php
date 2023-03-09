<?php
/*
Plugin Name: Lx Basic Editor
Description: Lx Editor
Version: 1.3
Author: VW Krish
*/

global $wpdb;
define( 'lx_plugin_url' , plugin_dir_url(__FILE__) );
define( 'plugin_dir_path' , plugin_dir_path(__FILE__) );
global $lx_plugin_url;
global $lx_plugin_path;
$lx_plugin_url = lx_plugin_url;
$lx_plugin_path=plugin_dir_path;

require(dirname(__FILE__).'/classes/class_lx_get_data.php');
$lx_get_data = new lx_get_data();
require(dirname(__FILE__).'/classes/class_lx_ajax.php');
$lx_ajax = new lx_ajax();
$lx_ajax->lxed_all_data = $lx_get_data;
require(dirname(__FILE__).'/classes/class_lx_include_assets.php');
$lx_include_assets = new lx_include_assets();
$lx_include_assets->lx_get_datas = $lx_get_data;
require(dirname(__FILE__).'/classes/class_lx_templates.php');
$lx_cl_templates = new lx_cl_templates();
$lx_cl_templates->vw_var_get_all_categories = $lx_get_data;