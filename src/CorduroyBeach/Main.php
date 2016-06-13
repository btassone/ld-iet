<?php

namespace CorduroyBeach;

use CorduroyBeach\Factories\SettingsFactory;

class Main {

	private static $settingsFactory;

	public static function Run() {
		Main::InitializeActions();
	}

	public static function InitializeActions() {
		add_action('admin_enqueue_scripts', array('CorduroyBeach\Main', 'LoadAdminStyles'));
		add_action('admin_enqueue_scripts', array('CorduroyBeach\Main', 'LoadAdminJavascript'));
		add_action('wp_ajax_ld_csv_import', array('CorduroyBeach\Main', 'AdminAjaxHandler'));

		add_action('admin_menu', array('CorduroyBeach\Main', 'MenuPagesInit'));
	}
	
	public static function LoadAdminStyles() {
		wp_register_style( 'ld-iet-admin-css', LD_IET_RESOURCE_URL_BASE . 'css/main.css');
		wp_enqueue_style( 'ld-iet-admin-css' );
	}

	public static function LoadAdminJavascript() {
		wp_register_script( 'ld-iet-eimport-response-statuses',
			LD_IET_RESOURCE_URL_BASE . 'js/Enums/EImportResponseStatuses.js', array(), '', true);
		wp_register_script( 'ld-iet-import-response-handler',
			LD_IET_RESOURCE_URL_BASE . 'js/Utilities/ImportResponseUtility.js', array(), '', true);
		wp_register_script( 'ld-iet-base-handler',
			LD_IET_RESOURCE_URL_BASE . 'js/Handlers/BaseHandler.js', array(), '', true);
		wp_register_script( 'ld-iet-click-handler',
			LD_IET_RESOURCE_URL_BASE . 'js/Handlers/ClickHandler.js', array(), '', true);
		wp_register_script( 'ld-iet-draggable-handler',
			LD_IET_RESOURCE_URL_BASE . 'js/Handlers/DraggableHandler.js', array(), '', true);
		wp_register_script( 'ld-iet-main',
			LD_IET_RESOURCE_URL_BASE . 'js/Main.js', array(), '', true);

		wp_enqueue_script( 'ld-iet-eimport-response-statuses' );
		wp_enqueue_script( 'ld-iet-import-response-handler' );
		wp_enqueue_script( 'ld-iet-base-handler' );
		wp_enqueue_script( 'ld-iet-click-handler' );
		wp_enqueue_script( 'ld-iet-draggable-handler' );
		wp_enqueue_script( 'ld-iet-main' );

		wp_localize_script( 'ld-iet-main', 'ld_iet_ajax_obj', array('ajax_url' => admin_url( 'admin-ajax.php' )) );
	}

	public static function MenuPagesInit() {
		$settings = array();

		// TODO: Automate this process if possible by dynamic file discovery
		$mainAdminSettings = require_once(LD_IET_SETTINGS_BASE . "MainAdminSettings.php");
		
		$settings[] = $mainAdminSettings;
		
		Main::setSettingsFactory(new SettingsFactory($settings));
		Main::getSettingsFactory()->setupAdminPages();
		Main::getSettingsFactory()->setupOptions();
	}

	// TODO: Setup test for this function
	public static function AdminAjaxHandler() {
		$csv_json_obj = $_POST['csv_json_obj'];
		$csv_local_path = get_attached_file($csv_json_obj['id']);
		$csv_data_arr = array_map('str_getcsv', file($csv_local_path));

		$pre_response_obj = (object) array(
			"status" => "Finished",
			"csv_data" => $csv_data_arr
		);

		$response_obj = json_encode($pre_response_obj);

		// Test the processing status
		// TODO: Remove this line once actual import takes place.
		sleep(5);

		echo $response_obj;

		wp_die();
	}

	/**
	 * @return mixed
	 */
	public static function getSettingsFactory() {
		return self::$settingsFactory;
	}
	/**
	 * @param mixed $settingsFactory
	 */
	public static function setSettingsFactory( $settingsFactory ) {
		self::$settingsFactory = $settingsFactory;
	}
}