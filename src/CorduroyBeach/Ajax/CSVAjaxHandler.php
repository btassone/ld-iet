<?php

namespace CorduroyBeach\Ajax;

class CSVAjaxHandler extends BaseAjaxHandler {
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
	 * @var
	 */
	private $ajaxFunc;

	public function __construct( $name, $action_name, $csv_json_obj, $options, $ajaxFunc, $csv_local_path = "" ) {
		parent::__construct($name, $action_name);

		$this->setCsvJsonObj($csv_json_obj);
		$this->setOptions($options);
		$this->setCsvLocalPath($csv_local_path);
		$this->setAjaxFunc($ajaxFunc);
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
		$bound_func = \Closure::bind($this->getAjaxFunc(), $this);
		$response_obj = $bound_func($_POST[$this->getCsvJsonObj()], $this->getCsvLocalPath());

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
	public function getAjaxFunc() {
		return $this->ajaxFunc;
	}
	/**
	 * @param mixed $ajaxFunc
	 */
	public function setAjaxFunc( $ajaxFunc ) {
		$this->ajaxFunc = $ajaxFunc;
	}
}