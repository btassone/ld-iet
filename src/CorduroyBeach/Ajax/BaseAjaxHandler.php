<?php

namespace CorduroyBeach\Ajax;

abstract class BaseAjaxHandler {
	private $name;
	private $action_name;
	
	abstract public function init();
	abstract public function ajaxHandler();

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