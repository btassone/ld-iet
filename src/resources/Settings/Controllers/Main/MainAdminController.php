<?php
use CorduroyBeach\Utilities\LDUtility;

/**
 * Class MainAdminController
 *
 * Controller for the Main Admin page for the plugin. Handles the pre processing of data before it goes to the view
 *
 * TODO: Create base class that handles this dynamically
 */
class MainAdminController {

	/**
	 * Handles the pre processing of data for the column pattern settings section
	 *
	 * @return array
	 */
	public static function columnPatternView() {
		// TODO: Separate this out into it's own testable function
		$options = get_option('ld_options');
		$csv_ops = $options['ld_settings_course_csv_pattern'];

		$csv_pattern = [];

		if(!$csv_ops || $csv_ops == "" || $csv_ops == "[]" || $csv_ops == "Array") {
			$csv_pattern = json_encode( array_keys(LDUtility::getCsvPattern()) );
		} else {
			$csv_pattern = $options['ld_settings_course_csv_pattern'];
		}

		$data = LDUtility::getCsvPattern();
		$ordered_data = LDUtility::OrderCsvPatternToSavedPattern($data, json_decode($csv_pattern));

		return array(
			'csv_pattern' => $csv_pattern,
			'ordered_data' => $ordered_data,
		);
	}

	/**
	 * @return array
	 */
	public static function disabledPatternView() {
		$options = get_option('ld_options');
		$disabled_ops = $options['ld_settings_course_csv_pattern_disabled'];

		$data = LDUtility::getCsvPattern();
		$ordered_data = LDUtility::OrderCsvPatternToSavedPattern($data, json_decode($disabled_ops));

		return array(
			'disabled_data' => $disabled_ops,
			'ordered_data' => $ordered_data
		);
	}

	/**
	 * Handles the pre processing of data for the uploader fields settings section
	 *
	 * @return array
	 */
	public static function uploaderFieldsView() {
		return array();
	}

	/**
	 * Handles the pre processing of data for the run import settings section
	 *
	 * @return array
	 */
	public static function runImportView() {
		return array();
	}

	public static function importPreviewView() {
		return array();
	}

	/**
	 * Handles the pre processing of data for the settings section
	 *
	 * @return array
	 */
	public static function settingsSectionView() {
		$csv_pattern = json_decode(get_option('ld_options')['ld_settings_course_csv_pattern']);
		
		return array('csv_pattern' => $csv_pattern);
	}
}