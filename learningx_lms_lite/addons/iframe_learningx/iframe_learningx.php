<?php
global $il_plugin_path;
$il_plugin_path  = plugin_dir_path(__FILE__);
global $il_plugin_url;
$il_plugin_url = plugin_dir_url(__FILE__);
require_once $il_plugin_path."includes/il_configuration.php";
$ilconf = new ILConfiguration();