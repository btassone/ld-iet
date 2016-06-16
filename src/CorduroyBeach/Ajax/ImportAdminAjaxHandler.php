<?php

namespace CorduroyBeach\Ajax;

use CorduroyBeach\Database\ImportDatabaseActions;
use CorduroyBeach\Utilities\LDUtility;

/**
 * Class ImportAdminAjaxHandler
 * @package CorduroyBeach\Ajax
 */
class ImportAdminAjaxHandler extends BaseAjaxHandler {

	/**
	 * @var string
	 */
	private $csv_json_obj;

	/**
	 * @var string
	 */
	private $csv_local_path;
	
	/**
	 * @var array
	 */
	private $options;

	/**
	 * @var ImportDatabaseActions
	 */
	private $db_actions;

	/**
	 * ImportAdminAjaxHandler constructor.
	 *
	 * @param $name
	 * @param $action_name
	 * @param $csv_json_obj
	 * @param $options
	 * @param $csv_local_path
	 */
	public function __construct( $name, $action_name, $csv_json_obj, $options, $csv_local_path = "" ) {
		parent::__construct($name, $action_name);

		$this->setCsvJsonObj($csv_json_obj);
		$this->setOptions($options);
		$this->setCsvLocalPath($csv_local_path);
	}

	/**
	 * Initializes the wordpress based actions (useful for testing since we can bypass this step)
	 */
	public function init() {
		add_action($this->getActionName(), array($this, 'ajaxHandler'));
	}

	/**
	 * The handler for the ImportAdminAjaxHandler. This is the brains of the operation
	 */
	public function ajaxHandler() {
		$csv_json_obj = $_POST[$this->getCsvJsonObj()];
		$csv_local_path = $this->getCsvLocalPath();
		$csv_data_arr = [];
		$created_ids = [];

		if(!$csv_local_path) {
			$csv_local_path = get_attached_file($csv_json_obj['id']);
		}

		$csv_data_arr = array_map('str_getcsv', file($csv_local_path));

		$serialized_data = LDUtility::CreateSerializedDataString(
			LDUtility::LD_DB_PREFIX,
			$this->getOptions(),
			$csv_data_arr );
		
		$created_ids = $this->getDbActions()->importCsv($serialized_data);

		$pre_response_obj = (object) array(
			"status" => "Finished",
			"csv_data" => $csv_data_arr,
			"serialized_data" => $serialized_data,
			"created_id" => $created_ids
		);

		$response_obj = json_encode($pre_response_obj);
		
		echo $response_obj;

		if(is_admin()) {
			exit();
		}
	}

	/**
	 * @return mixed
	 */
	public function getCsvJsonObj() {
		return $this->csv_json_obj;
	}
	/**
	 * @param mixed $csv_json_obj
	 */
	public function setCsvJsonObj( $csv_json_obj ) {
		$this->csv_json_obj = $csv_json_obj;
	}

	/**
	 * @return mixed
	 */
	public function getCsvLocalPath() {
		return $this->csv_local_path;
	}
	/**
	 * @param mixed $csv_local_path
	 */
	public function setCsvLocalPath( $csv_local_path ) {
		$this->csv_local_path = $csv_local_path;
	}

	/**
	 * @return mixed
	 */
	public function getOptions() {
		return $this->options;
	}
	/**
	 * @param mixed $options
	 */
	public function setOptions( $options ) {
		$this->options = $options;
	}

	/**
	 * @return mixed
	 */
	public function getDbActions() {
		return $this->db_actions;
	}
	/**
	 * @param mixed $db_actions
	 */
	public function setDbActions( $db_actions ) {
		$this->db_actions = $db_actions;
	}
}