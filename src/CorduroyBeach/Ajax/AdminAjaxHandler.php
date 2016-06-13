<?php

namespace CorduroyBeach\Ajax;

/**
 * Class AdminAjaxHandler
 * @package CorduroyBeach\Ajax
 */
class AdminAjaxHandler {

	/**
	 * @var string
	 */
	private $name = "";

	/**
	 * @var callable The main brain behind the Ajax handler
	 */
	private $cb;

	/**
	 * AdminAjaxHandler constructor.
	 *
	 * @param $name
	 */
	public function __construct($name, $cb) {
		$this->setName($name);
		$this->setCb($cb);

		// Admin ajax handling for the importer
		add_action('wp_ajax_ld_csv_import', array($this, 'ajaxHandler'));
	}

	/**
	 * Ajax handler that is the main brain of the importer on the php side.
	 *
	 * TODO: Setup test for this function
	 * TODO: Might be better to move this to an AdminAjax class or something of the like
	 */
	public function ajaxHandler() {
		$cb = $this->getCb();
		$cb();
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

	/**
	 * @return mixed
	 */
	public function getCb() {
		return $this->cb;
	}
	/**
	 * @param mixed $cb
	 */
	public function setCb( $cb ) {
		$this->cb = $cb;
	}
	
	
}