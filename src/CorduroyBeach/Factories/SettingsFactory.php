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
			add_menu_page(
				$settingsSet->wrap["page_title"],
				$settingsSet->wrap["menu_title"],
				$settingsSet->wrap['capability'],
				$settingsSet->wrap['menu_slug'],
				$settingsSet->wrap['callback'],
				$settingsSet->wrap['icon'],
				$settingsSet->wrap['position']
			);
		}
	}

	/**
	 * Sets and registers the options to a given page
	 */
	public function setupOptions() {
		foreach($this->getSettings() as $settingsSet) {
			register_setting($settingsSet->register_setting[0], $settingsSet->register_setting[1]);

			foreach($settingsSet->settings_sections as $section) {
				add_settings_section(
					$section["id"],
					$section["title"],
					$section["callback"],
					$section["page"]
				);
			}

			foreach($settingsSet->settings_fields as $field) {
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