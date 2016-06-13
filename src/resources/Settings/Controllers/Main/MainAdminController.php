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

		if(!$csv_ops || $csv_ops == "" || $csv_ops == "[]") {
			$csv_pattern = json_encode( LDUtility::getCsvPattern() );
		} else {
			$csv_pattern = $options['ld_settings_course_csv_pattern'];

			LDUtility::setCsvPattern( json_decode( $csv_pattern ) );
		}

		return array('csv_pattern' => $csv_pattern);
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

	/**
	 * Handles the pre processing of data for the settings section
	 *
	 * @return array
	 */
	public static function settingsSectionView() {
		return array();
	}
}