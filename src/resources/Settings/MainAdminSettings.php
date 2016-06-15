<?php

// Pull in the MainAdminController for use here
require_once(LD_IET_SETTINGS_BASE . "Controllers/Main/MainAdminController.php");

use CorduroyBeach\Utilities\LDUtility;

// Returns the settings object for use in Admin Page creation.
return (object) array(
	"wrap" => array(
		'page_title' => 'Learn Dash Import / Export Tool',
		'menu_title' => 'LearnDash IET',
		'capability' => 'manage_options',
		'menu_slug' => 'ld-settings-page',
		'callback' => function(){
			require_once(LD_IET_SETTINGS_BASE . "Views/Main/MainViewWrap.php");
		},
		'icon' => LD_IET_RESOURCE_URL_BASE . 'img/plugin-icon-20x20.png',
		'position' => null
	),
	"register_setting" => ["ld_options", "ld_options"],
	"settings_sections" => array(
		array(
			'id' => 'ld_settings_section',
			'title' => 'Main settings page field section',
			'callback' => function() {
				$returned_data = MainAdminController::settingsSectionView();

				$csv_pattern = $returned_data['csv_pattern'];

				$csv_column_data = LDUtility::getCsvPattern();

				$reorganized_column_data = [];

				foreach($csv_pattern as $item) {
					if($csv_column_data[$item])
						$reorganized_column_data[$item] = $csv_column_data[$item];
				}
				
				require_once(LD_IET_SETTINGS_BASE . "Views/Main/MainViewSettingsSection.php");
			},
			'page' => 'ld-settings-page'
		)
	),
	"settings_fields" => array(
		array(
			'id' => 'ld_setting_course_csv',
			'title' => 'Upload course CSV file',
			'callback' => function() {
				$returned_data = MainAdminController::uploaderFieldsView();
				
				require_once(LD_IET_SETTINGS_BASE . "Views/Main/MainViewUploaderFields.php");
			},
			'page' => 'ld-settings-page',
			'section' => 'ld_settings_section'
		),
		array (
			'id' => 'ld_settings_course_csv_pattern',
			'title' => 'Set CSV Import Column Pattern',
			'callback' => function() {
				$returned_data = MainAdminController::columnPatternView();

				$csv_pattern = $returned_data['csv_pattern'];

				require_once(LD_IET_SETTINGS_BASE . "Views/Main/MainViewColumnPattern.php");
			},
			'page' => 'ld-settings-page',
			'section' => 'ld_settings_section'
		),
		array(
			'id' => 'ld_settings_course_csv_run',
			'title' => 'Run the CSV Import',
			'callback' => function() {
				$returned_data = MainAdminController::runImportView();
				
				require_once(LD_IET_SETTINGS_BASE . "Views/Main/MainViewRunImport.php");
			},
			'page' => 'ld-settings-page',
			'section' => 'ld_settings_section'
		)
	)
);