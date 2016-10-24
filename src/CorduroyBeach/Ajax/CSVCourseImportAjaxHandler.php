<?php

namespace CorduroyBeach\Ajax;

class CSVCourseImportAjaxHandler extends CSVAjaxHandler {
	private $db_actions;

	public function __construct( $name, $action_name, $csv_json_obj, $options, $ajaxFunc, $csv_local_path = "" ) {
		parent::__construct($name, $action_name, $csv_json_obj, $options, $ajaxFunc, $csv_local_path);
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