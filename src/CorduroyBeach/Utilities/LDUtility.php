<?php

namespace CorduroyBeach\Utilities;

/**
 * Class LDUtility
 *
 * General utility for the LD IET plugin
 *
 * @package CorduroyBeach\Utilities
 */
class LDUtility {
	
	/**
	 * The courses prefix for data that needs to be serialized to postmeta
	 */
	const LD_DB_PREFIX = "sfwd-courses_";

	/**
	 * @param $prefix
	 * @param $postfixes
	 * @param $data
	 *
	 * Takes a prefix, array of $postfixes, and an array of data and creates a serialized string for the db
	 *
	 * @return array
	 */
	public static function CreateSerializedDataString( $prefix, $postfixes, $data ) {
		return array();
	}

	/**
	 * @param string A place to get a CSVPattern array
	 * 
	 * @return array
	 */
	public static function getCsvPattern($location = null) {
		if($location)
			return include($location);
		else
			return include(LD_IET_SETTINGS_BASE . "CSVPattern.php");
	}
}