<?php

namespace CorduroyBeach\Ajax;

/**
 * Class BaseAjaxHandler
 * @package CorduroyBeach\Ajax
 */
abstract class BaseAjaxHandler {

	/**
	 * @var
	 */
	private $name;

	/**
	 * @var
	 */
	private $action_name;

	/**
	 * @return mixed
	 */
	abstract public function init();

	/**
	 * @return mixed
	 */
	abstract public function ajaxHandler();

	/**
	 * BaseAjaxHandler constructor.
	 *
	 * @param $name
	 * @param $action_name
	 */
	public function __construct($name, $action_name) {
		$this->setName($name);
		$this->setActionName($action_name);
	}

	/**
	 * @return string
	 */
	public function getActionName() {
		return $this->action_name;
	}
	/**
	 * @param string $action_name
	 */
	public function setActionName( $action_name ) {
		$this->action_name = $action_name;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	/**
	 * @param string $name
	 */
	public function setName( $name ) {
		$this->name = $name;
	}
}