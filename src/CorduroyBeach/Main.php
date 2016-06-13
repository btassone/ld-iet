<?php

namespace CorduroyBeach;

use CorduroyBeach\Factories\SettingsFactory;


/**
 * Class Main
 *
 * The main class of the plugin. This is the brain of all major operations and should be used as such
 *
 * @package CorduroyBeach
 */
class Main {


	/**
	 * @var SettingsFactory Holds the settings factory class that does all the menu page handling.
	 */
	private static $settingsFactory;

	/**
	 * The main action of the plugin. Fires up all the main processes for the plugin
	 */
	public static function Run() {
		// Initialization actions
		Main::InitializeActions();
	}

	/**
	 * The main action registering function. Adds the main javascript and css files and sets up the main functions
	 * used for supporting the plugin
	 */
	public static function InitializeActions() {
		// CSS and Javascript Helpers
		add_action('admin_enqueue_scripts', array('CorduroyBeach\Main', 'LoadAdminStyles'));
		add_action('admin_enqueue_scripts', array('CorduroyBeach\Main', 'LoadAdminJavascript'));

		// Admin ajax handling for the importer
		add_action('wp_ajax_ld_csv_import', array('CorduroyBeach\Main', 'AdminAjaxImportHandler'));

		// Menu page initializer
		add_action('admin_menu', array('CorduroyBeach\Main', 'MenuPagesInit'));
	}

	/**
	 * Loads all the styles for the admin section of the plugin
	 */
	public static function LoadAdminStyles() {
		wp_register_style( 'ld-iet-admin-css', LD_IET_RESOURCE_URL_BASE . 'css/main.css');
		wp_enqueue_style( 'ld-iet-admin-css' );
	}

	/**
	 * Loads all of the javascript used to support the admin side of the plugin
	 */
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

	/**
	 * Handles the setting up of all the admin pages
	 */
	public static function MenuPagesInit() {
		$settings = array();

		// TODO: Automate this process if possible by dynamic file discovery
		$mainAdminSettings = require_once(LD_IET_SETTINGS_BASE . "MainAdminSettings.php");
		
		$settings[] = $mainAdminSettings;
		
		self::setSettingsFactory(new SettingsFactory($settings));
		self::getSettingsFactory()->setupAdminPages();
		self::getSettingsFactory()->setupOptions();
	}

	/**
	 * Ajax handler that is the main brain of the importer on the php side.
	 *
	 * TODO: Setup test for this function
	 * TODO: Might be better to move this to an AdminAjax class or something of the like
	 */
	public static function AdminAjaxImportHandler() {
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