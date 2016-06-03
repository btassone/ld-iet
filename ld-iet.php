<?php
/*
	Plugin Name: LearnDash Import/Export Tool
	Plugin URI: http://corduroybeach.com
	Description: Imports / Exports Course and Other Data
	Author: Brandon Tassone
	Version: 0.1
	Author URI: http://brandont.me
*/

// Composer Autoload Files
require_once("vendor/autoload.php");

function menu_pages_init() {
	add_menu_page('Learn Dash Import / Export Tool', 'LearnDash IET', 'manage_options', 'ld-iet-main', '',  plugin_dir_url(__FILE__) . '/resources/img/plugin-icon-20x20.png');
}

add_action('admin_menu', 'menu_pages_init');