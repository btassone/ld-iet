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

define('LD_IET_VIEW_BASE', plugin_dir_path(__FILE__) . 'views/');
define('LD_IET_VIEW_ID_BASE', 'ld-iet/views/');
define('LD_IET_RESOURCE_URL_BASE', plugin_dir_url(__FILE__) . 'resources/');

function menu_pages_init() {
	add_menu_page(
		'Learn Dash Import / Export Tool',
		'LearnDash IET',
		'manage_options',
		LD_IET_VIEW_BASE . 'settings/settings.php',
		'',
		LD_IET_RESOURCE_URL_BASE . 'img/plugin-icon-20x20.png');
}

function load_ld_iet_admin_styles() {
	wp_register_style( 'ld-iet-admin-css', LD_IET_RESOURCE_URL_BASE . 'css/main.css');
	wp_enqueue_style( 'ld-iet-admin-css' );
}

add_action('admin_menu', 'menu_pages_init');
add_action('admin_enqueue_scripts', 'load_ld_iet_admin_styles');