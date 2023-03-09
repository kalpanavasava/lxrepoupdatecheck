<?php
global $il2_plugin_path;
$il2_plugin_path  = plugin_dir_path(__FILE__);
global $il2_plugin_url;
$il2_plugin_url = plugin_dir_url(__FILE__);
require_once $il2_plugin_path."includes/il_configurations.php";
$ilconf2 = new ILConfigurations();