<?php
/*
	Plugin Name: LearnDash Import/Export Tool
	Plugin URI: http://corduroybeach.com
	Description: Imports / Exports Course and Other Data
	Author: Brandon Tassone
	Version: 0.1
	Author URI: http://brandont.me
*/

define('LD_IET_PLUGIN_BASE', plugin_dir_path(__FILE__));
define('LD_IET_SETTINGS_BASE', plugin_dir_path(__FILE__) . "src/resources/Settings/");
define('LD_IET_AJAX_HANDLERS', plugin_dir_path(__FILE__) . "src/resources/Settings/AjaxHandlers/");
define('LD_IET_VIEW_BASE', plugin_dir_path(__FILE__) . 'views/');
define('LD_IET_RESOURCE_URL_BASE', plugin_dir_url(__FILE__) . 'resources/');

// Composer Autoload Files
require_once("vendor/autoload.php");

if(is_admin()) {
	CorduroyBeach\Main::Run();
}