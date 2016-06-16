<?php

namespace CorduroyBeach;

use CorduroyBeach\Utilities\LDUtility;

require_once("constants.php");

class LDUtilityTest extends \WP_UnitTestCase {

	private $csv_local_path;
	private $csv_data_arr;
	private $options;

	public function setUp() {
		$this->csv_local_path = realpath(dirname(__FILE__) . '/..') . "/resources/CSV/ld-test-import.csv";
		$this->csv_data_arr = array_map('str_getcsv', file($this->csv_local_path));
		$this->options = array(
			'ld_settings_course_csv_pattern' => '["course_title","course_price_type","course_price","course_access_list","course_materials","course_lesson_orderby","course_lesson_order","course_prerequisite","custom_button_url","certificate","expire_access_days"]',
			'ld_settings_course_csv_pattern_disabled' => '["disable_lesson_progression","expire_access_delete_progress","expire_access","course_disable_content_table"]'
		);
	}

	public function test_create_serialized_data_string_and_make_sure_data_is_correct() {
		$import_arr = LDUtility::CreateSerializedDataString(
			LDUtility::LD_DB_PREFIX,
			$this->options,
			$this->csv_data_arr
		);

		$csvPattern = LDUtility::getCsvPattern();
		$csvPrefixCount = 0;

		$this->assertCount(8, $import_arr);

		foreach($import_arr as $set) {
			$this->assertArrayHasKey("serialized", $set);
			$this->assertArrayHasKey("un-serialized", $set);
		}

		foreach($csvPattern as $set) {
			$uses_prefix = $set->uses_prefix;

			if(!$uses_prefix) {
				$csvPrefixCount++;
			}
		}

		$max_length = count($import_arr)-1;
		$added_column_count = 1;
		$random_int = random_int(0, $max_length);
		$random_set = $import_arr[$random_int];

		$this->assertCount($csvPrefixCount + $added_column_count, $random_set['un-serialized']);
	}

	public function test_get_csv_pattern_not_null_and_follows_specific_pattern() {
		$csv_pattern = LDUtility::getCsvPattern();

		$this->assertNotNull($csv_pattern);
		$this->assertNotEmpty($csv_pattern);
		$this->assertGreaterThan(0, $csv_pattern);

		foreach($csv_pattern as $key => $set) {
			$this->assertObjectHasAttribute('column_info', $set);
			$this->assertObjectHasAttribute('has_close', $set);
			$this->assertObjectHasAttribute('uses_prefix', $set);

			$colInfo = $set->column_info;

			$this->assertObjectHasAttribute('name', $colInfo);
			$this->assertObjectHasAttribute('example', $colInfo);
			$this->assertObjectHasAttribute('values', $colInfo);
		}
	}
}