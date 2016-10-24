<?php

namespace CorduroyBeach\Factories;

/**
 * Class SettingsFactory
 *
 * This factory is what is used to create the admin pages for the plugin. This takes care of all creation
 *
 * TODO: Find a way to test this class!
 *
 * @package CorduroyBeach\Factories
 */
class SettingsFactory {

	/**
	 * @var array Array of settings pulled in from the resources folder
	 */
	private $settings = array();

	/**
	 * SettingsFactory constructor.
	 *
	 * @param $settings
	 */
	public function __construct($settings) {
		$this->setSettings($settings);
	}

	/**
	 * Gets the main admin wrap. This is the page that holds all the options
	 */
	public function setupAdminPages() {
		foreach($this->getSettings() as $settingsSet) {
			foreach($settingsSet->wrap as $wrap) {
				add_menu_page(
					$wrap["page_title"],
					$wrap["menu_title"],
					$wrap['capability'],
					$wrap['menu_slug'],
					$wrap['callback'],
					$wrap['icon'],
					$wrap['position']
				);
			}
		}
	}

	/**
	 * Sets and registers the options to a given page
	 */
	public function setupOptions() {
		foreach($this->getSettings() as $settingsSet) {
			foreach($settingsSet->register_setting as $rs) {
				register_setting( $rs[0], $rs[1] );
			}

			foreach($settingsSet->settings_sections as $section) {
				add_settings_section(
					$section["id"],
					$section["title"],
					$section["callback"],
					$section["page"]
				);

				foreach($settingsSet->settings_fields[$section["id"]] as $field) {
					add_settings_field(
						$field["id"],
						$field["title"],
						$field["callback"],
						$field["page"],
						$field["section"]
					);
				}
			}
		}
	}

	/**
	 * @return array
	 */
	public function getSettings() {
		return $this->settings;
	}
	/**
	 * @param array $settings
	 */
	public function setSettings( $settings ) {
		$this->settings = $settings;
	}
}