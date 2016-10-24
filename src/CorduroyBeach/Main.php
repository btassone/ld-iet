<?php

namespace CorduroyBeach;

use CorduroyBeach\Ajax\CSVAjaxHandler;
use CorduroyBeach\Ajax\CSVCourseImportAjaxHandler;
use CorduroyBeach\Database\ImportDatabaseActions;
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
	 * @var array Holds the adminAjaxHandlers that get created just in case a reference is needed in the future
	 */
	private static $adminAjaxHandlers = [];

	/**
	 * The main action of the plugin. Fires up all the main processes for the plugin
	 */
	public static function Run() {
		// Initialize Actions
		Main::InitializeActions();

		// Initialize Ajax Handlers
		Main::InitializeAjaxHandlers();
	}

	/**
	 * Setup the AdminAjaxHandlers to handle certain actions for the plugin
	 */
	public static function InitializeAjaxHandlers() {
		$preview_import_func = require_once(LD_IET_SETTINGS_BASE . "AjaxHandlers/PreviewImport.php");
		$import_csv_func = require_once(LD_IET_SETTINGS_BASE . "AjaxHandlers/ImportCSV.php");

		$piah = new CSVAjaxHandler('PreviewImport', 'wp_ajax_ld_csv_preview', 'csv_json_obj', get_option('ld_options'), $preview_import_func);
		$piah->init();

		$icsvh = new CSVCourseImportAjaxHandler('ImportCSV', 'wp_ajax_ld_csv_import', 'csv_json_obj', get_option('ld_options'), $import_csv_func);
		$icsvh->setDbActions(new ImportDatabaseActions());
		$icsvh->init();

		self::getAdminAjaxHandlers()[] = $piah;
		self::getAdminAjaxHandlers()[] = $icsvh;
	}

	/**
	 * The main action registering function. Adds the main javascript and css files and sets up the main functions
	 * used for supporting the plugin
	 */
	public static function InitializeActions() {
		// CSS and Javascript Helpers
		add_action('admin_enqueue_scripts', array('CorduroyBeach\Main', 'LoadAdminStyles'));
		add_action('admin_enqueue_scripts', array('CorduroyBeach\Main', 'LoadAdminJavascript'));

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
		wp_register_script( 'ld-iet-epreview-states',
			LD_IET_RESOURCE_URL_BASE . 'js/Enums/EPreviewStates.js', array(), '', true);
		wp_register_script( 'ld-iet-general-utility',
			LD_IET_RESOURCE_URL_BASE . 'js/Utilities/GeneralUtility.js', array(), '', true);
		wp_register_script( 'ld-iet-import-response-handler',
			LD_IET_RESOURCE_URL_BASE . 'js/Utilities/ImportResponseUtility.js', array(), '', true);
		wp_register_script( 'ld-iet-base-handler',
			LD_IET_RESOURCE_URL_BASE . 'js/Handlers/BaseHandler.js', array(), '', true);
		wp_register_script( 'ld-iet-click-handler',
			LD_IET_RESOURCE_URL_BASE . 'js/Handlers/ClickHandler.js', array(), '', true);
		wp_register_script( 'ld-iet-change-handler',
			LD_IET_RESOURCE_URL_BASE . 'js/Handlers/ChangeHandler.js', array(), '', true);
		wp_register_script( 'ld-iet-draggable-handler',
			LD_IET_RESOURCE_URL_BASE . 'js/Handlers/DraggableHandler.js', array(), '', true);
		wp_register_script( 'ld-iet-main',
			LD_IET_RESOURCE_URL_BASE . 'js/Main.js', array(), '', true);

		wp_enqueue_media();

		wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-1.12.4.min.js', false, false, true );
		wp_enqueue_script( 'jquery-form' );
		wp_enqueue_script( 'jquery-ext-ui', '//code.jquery.com/ui/1.12.0/jquery-ui.min.js', 'jquery', false, true );

		wp_enqueue_script( 'ld-iet-eimport-response-statuses' );
		wp_enqueue_script( 'ld-iet-epreview-states' );
		wp_enqueue_script( 'ld-iet-general-utility' );
		wp_enqueue_script( 'ld-iet-import-response-handler' );
		wp_enqueue_script( 'ld-iet-base-handler' );
		wp_enqueue_script( 'ld-iet-change-handler' );
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

	/**
	 * @return mixed
	 */
	public static function getAdminAjaxHandlers() {
		return self::$adminAjaxHandlers;
	}
	/**
	 * @param mixed $adminAjaxHandlers
	 */
	public static function setAdminAjaxHandlers( $adminAjaxHandlers ) {
		self::$adminAjaxHandlers = $adminAjaxHandlers;
	}
}