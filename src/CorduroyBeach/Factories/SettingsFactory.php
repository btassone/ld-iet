<?php

namespace CorduroyBeach\Factories;

// TODO: Find a way to test this class!
class SettingsFactory {
	private $settings = array();

	public function __construct($settings) {
		$this->setSettings($settings);
	}
	
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