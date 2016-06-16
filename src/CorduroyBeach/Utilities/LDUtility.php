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
		$import_fields = json_decode($postfixes['ld_settings_course_csv_pattern']);
		$orig_col_data = LDUtility::getCsvPattern();
		$import_arr = [];
		$change_columns = array(
			"course_title" => "post_title"
		);

		foreach($data as $index => $row) {
			$import_arr[] = array(
				"serialized" => array(),
				"un-serialized" => array()
			);

			for($i = 0; $i < count($row); $i++) {
				$ordered_field = $import_fields[$i];
				$col_data = $orig_col_data[$ordered_field];
				$uses_prefix = $col_data->uses_prefix;
				$item = $row[$i];

				if($uses_prefix) {
					$import_arr[$index]["serialized"][$prefix . $ordered_field] = $item;
				} else {
					if($change_columns[$ordered_field]) {
						$import_arr[$index]["un-serialized"][$change_columns[$ordered_field]] = $item;
					} else {
						$import_arr[$index]["un-serialized"][$ordered_field] = $item;
					}
				}
			}

			$import_arr[$index]["un-serialized"]["post_type"] = "sfwd-courses";
			$import_arr[$index]["serialized"] = serialize($import_arr[$index]["serialized"]);
		}

		return $import_arr;
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
	
	public static function OrderCsvPatternToSavedPattern($data, $saved) {
		$reorganized_column_data = [];

		foreach($saved as $item) {
			if($data[$item])
				$reorganized_column_data[$item] = $data[$item];
		}
		
		return $reorganized_column_data;
	}

	public static function CreateBookCaseString($string, $delim) {
		$sItem = str_replace($delim, " ", $string);
		$uc = ucwords($sItem);

		return $uc;
	}
}