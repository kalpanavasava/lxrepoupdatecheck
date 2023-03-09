<?php
global $flip_plugin_path;
$flip_plugin_path  = plugin_dir_path(__FILE__);
global $flip_plugin_url;
$flip_plugin_url = plugin_dir_url(__FILE__);
require_once $flip_plugin_path."includes/flip_configurations.php";
$ilconf = new FlipConfigurations();