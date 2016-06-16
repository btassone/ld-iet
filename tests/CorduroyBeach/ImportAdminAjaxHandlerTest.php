<?php

namespace CorduroyBeach;

require_once("constants.php");

use CorduroyBeach\Utilities\LDUtility;
use CorduroyBeach\Ajax\ImportAdminAjaxHandler;
use CorduroyBeach\Database\ImportDatabaseActions;

class ImportAdminAjaxHandlerTest extends \WP_UnitTestCase {

	private $csv_json_obj;
	private $csv_local_path;
	private $options;
	private $csv_data_arr;
	private $serialized_data;

	// Setup before each test
	public function setUp() {
		$this->csv_json_obj = 'csv_json_obj';
		$this->csv_local_path = realpath(dirname(__FILE__) . '/..') . "/resources/CSV/ld-test-import.csv";
		$this->csv_data_arr = array_map('str_getcsv', file($this->csv_local_path));
		$this->options = array(
			'ld_settings_course_csv_pattern' => '["course_title","course_price_type","course_price","course_access_list","course_materials","course_lesson_orderby","course_lesson_order","course_prerequisite","custom_button_url","certificate","expire_access_days"]',
			'ld_settings_course_csv_pattern_disabled' => '["disable_lesson_progression","expire_access_delete_progress","expire_access","course_disable_content_table"]'
		);
		$this->serialized_data = LDUtility::CreateSerializedDataString(
			LDUtility::LD_DB_PREFIX,
			$this->options,
			$this->csv_data_arr);

		$_POST[$this->csv_json_obj] = array(
			"id" => 25
		);
	}

	// Given certain conditions make sure the output that is echoed out to the page is what it should be
	public function test_ajax_handler_output_and_ensure_correct_data() {
		$db_actions = $this->getMockBuilder(ImportDatabaseActions::class)
		                         ->setMethods(['importCsv'])
		                         ->getMock();

		$db_actions->expects($this->once())
	                 ->method('importCsv')
	                 ->willReturn(array(1,2,3,4,5));

		$iaah = new ImportAdminAjaxHandler('some_name', 'some_action_name', $this->csv_json_obj, $this->options, $this->csv_local_path);
		$iaah->setDbActions($db_actions);
		$iaah->ajaxHandler();

		$shouldMatch = (object) array(
			"status" => "Finished",
			"csv_data" => $this->csv_data_arr,
			"serialized_data" => $this->serialized_data,
			"created_id" => array(1,2,3,4,5)
		);

		$this->expectOutputString(json_encode($shouldMatch));
	}
}