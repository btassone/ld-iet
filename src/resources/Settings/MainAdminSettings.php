<?php

// Pull in the MainAdminController for use here
require_once(LD_IET_SETTINGS_BASE . "Controllers/Main/MainAdminController.php");

use CorduroyBeach\Utilities\LDUtility;

// Returns the settings object for use in Admin Page creation.
return (object) array(
	"wrap" => array(
		array(
			'page_title' => 'Learn Dash Import / Export Tool',
			'menu_title' => 'LearnDash IET',
			'capability' => 'manage_options',
			'menu_slug' => 'ld-settings-page',
			'callback' => function(){
				$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'course_import';

				require_once(LD_IET_SETTINGS_BASE . "Views/Main/MainViewWrap.php");
			},
			'icon' => LD_IET_RESOURCE_URL_BASE . 'img/plugin-icon-20x20.png',
			'position' => null
       ),
	),
	"register_setting" => array(
		["ld_options", "ld_options"],
		["ld_options", "ld_quiz_ops"]
	),
	"settings_sections" => array(
		array(
			'id' => 'ld_settings_section',
			'title' => '',
			'callback' => function() {
				$returned_data = MainAdminController::settingsSectionView();

				$csv_pattern = $returned_data['csv_pattern'];
				$csv_column_data = LDUtility::getCsvPattern();

				$reorganized_column_data = $csv_column_data;
				
				require_once(LD_IET_SETTINGS_BASE . "Views/Main/MainViewSettingsSection.php");
			},
			'page' => 'ld-settings-page'
		),
		array(
			'id' => 'ld_preview_section',
			'title' => '',
			'callback' => function() {

			},
			'page' => 'ld-preview-page'
		),
		array(
			'id' => 'ld_quiz_section',
			'title' => '',
			'callback' => function() {

			},
			'page' => 'ld-quiz-page'
		)
	),
	"settings_fields" => array(
		"ld_settings_section" => array(
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
			array(
				'id' => 'ld_settings_course_csv_pattern',
				'title' => 'Set CSV Import Column Pattern',
				'callback' => function() {
					$returned_data = MainAdminController::columnPatternView();

					$csv_pattern = $returned_data['csv_pattern'];
					$ordered_data = $returned_data['ordered_data'];

					require_once(LD_IET_SETTINGS_BASE . "Views/Main/MainViewColumnPattern.php");
				},
				'page' => 'ld-settings-page',
				'section' => 'ld_settings_section'
			),
			array(
				'id' => 'ld_settings_course_csv_pattern_disabled',
				'title' => '',
				'callback' => function() {
					$returned_data = MainAdminController::disabledPatternView();

					$disabled_pattern = $returned_data['disabled_data'];
					$ordered_data = $returned_data['ordered_data'];

					require_once(LD_IET_SETTINGS_BASE . "Views/Main/MainViewDisabledPattern.php");
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
		),
		"ld_preview_section" => array(
			array(
				"id" => 'ld_setting_preview_csv',
				'title' => 'CSV Upload Preview',
				'callback' => function() {
					$returned_data = MainAdminController::importPreviewView();

					require_once(LD_IET_SETTINGS_BASE . "Views/Main/MainViewImportPreview.php");
				},
				'page' => 'ld-preview-page',
				'section' => 'ld_preview_section'
			)
		),
		"ld_quiz_section" => array(
			array(
				"id" => 'ld_quiz_import',
				"title" => '',
				"callback" => function(){
					var_dump($_POST['created_id']);
				},
				"page" => 'ld-quiz-page',
				"section" => 'ld_quiz_section'
			)
		)
	)
);