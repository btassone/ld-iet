<?php
/*
	Plugin Name: LearnDash Import/Export Tool
	Plugin URI: http://corduroybeach.com
	Description: Imports / Exports Course and Other Data
	Author: Brandon Tassone
	Version: 0.1
	Author URI: http://brandont.me
*/

require_once("constants.php");

// Composer Autoload Files
require_once("vendor/autoload.php");

if(is_admin()) {
	CorduroyBeach\Main::Run();
}