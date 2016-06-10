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
define('LD_IET_RESOURCE_URL_BASE', plugin_dir_url(__FILE__) . 'resources/');

function menu_pages_init() {
	add_menu_page(
		'Learn Dash Import / Export Tool',
		'LearnDash IET',
		'manage_options',
		'ld-settings-page',
		'ld_settings_page_cb',
		LD_IET_RESOURCE_URL_BASE . 'img/plugin-icon-20x20.png');
}

function ld_settings_page_cb() {


	?>
	<div class="ld-iet-settings-wrap">
		<div class="ld-iet-header-wrap">
			<h1 class="ld-iet-page-title">Learn Dash Import / Export</h1>
			<h5 class="ld-iet-sub-title">Temporary page containing basic functionality relevant to the tool. Will be broken up into other sections later</h5>
		</div>
		<div>
			<form action="options.php" method="post">
				<?php
					settings_fields('ld_options');
					do_settings_sections('ld-settings-page');
					submit_button();
				?>
			</form>
		</div>
	</div>
	<?php
}

function ld_settings_fun() {
	add_settings_section(
		'ld_settings_section',
		'Main settings page field section',
		function() {
			echo "Temporary csv uploader section";
		},
		'ld-settings-page'
	);

	add_settings_field(
		'ld_setting_course_csv',
		'Upload course CSV file',
		function(){
			?>
			<div class="uploader">
				<input type="hidden" id="ld_setting_course_csv" value="" size="50" />
				<input type="button" id="ld_setting_course_csv_upload_btn" data-txt-field="ld_setting_course_csv" class="button" value="Upload Course CSV" />
			</div>
			<pre class="uploaded-csv-information"></pre>
			<?php
		},
		'ld-settings-page',
		'ld_settings_section'
	);

	add_settings_field(
		'ld_settings_course_csv_run',
		'Run the CSV Import',
		function() {
			?>
			<div class="import-action">
				<input type="button" disabled id="ld_settings_course_csv_import" name="ld_settings_course_csv_import" value="Run Import" />
			</div>
			<div class="import-response-status">
				<label>Import Status: </label>
				<span class="status"></span>
			</div>
			<div class="import-response-error">
				
			</div>
			<?php
		},
		'ld-settings-page',
		'ld_settings_section'
	);

	register_setting('ld_options', 'ld_options');
}

function load_ld_iet_admin_styles() {
	wp_register_style( 'ld-iet-admin-css', LD_IET_RESOURCE_URL_BASE . 'css/main.css');
	wp_enqueue_style( 'ld-iet-admin-css' );
}

function load_ld_iet_javascript() {
	wp_register_script( 'ld-iet-main', LD_IET_RESOURCE_URL_BASE . 'js/main.js', array());
	
	wp_enqueue_script( 'ld-iet-basehandler' );
	wp_enqueue_script( 'ld-iet-clickhandler' );
	wp_enqueue_script( 'ld-iet-main' );

	wp_localize_script( 'ld-iet-main', 'ld_iet_ajax_obj', array('ajax_url' => admin_url( 'admin-ajax.php' )) );
}

// TODO: Setup test for this function
function ld_ajax_settings_handler() {
	$csv_json_obj = $_POST['csv_json_obj'];
	$csv_local_path = get_attached_file($csv_json_obj['id']);
	$csv_data_arr = array_map('str_getcsv', file($csv_local_path));

	$pre_response_obj = (object) array(
		"status" => "Finished",
		"csv_data" => $csv_data_arr
	);

	$response_obj = json_encode($pre_response_obj);

	// Test the processing status
	// TODO: Remove this line once actual import takes place.
	sleep(5);

	echo $response_obj;

	wp_die();
}

add_action('admin_menu', 'menu_pages_init');
add_action('admin_enqueue_scripts', 'load_ld_iet_admin_styles');
add_action('admin_enqueue_scripts', 'load_ld_iet_javascript');
add_action( 'admin_init', 'ld_settings_fun' );
add_action( 'wp_ajax_ld_csv_import', 'ld_ajax_settings_handler');