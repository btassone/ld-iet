<?php

namespace CorduroyBeach\Utilities;

class LDUtility {

	const LD_DB_PREFIX = "sfwd-courses_";
	
	private static $csvPattern = array(
		'course_title',
		'status',
		'visibility',
		'featured_img',
		'categories',
		'tags',
		'restrictions',
		'course_materials',
		'course_price_type',
		'course_price',
		'course_access_list',
		'course_lesson_orderby',
		'course_lesson_order',
		'course_prerequisite',
		'disable_lesson_progression',
		'expire_access',
		'expire_access_days',
		'expire_access_delete_progress',
		'course_disable_content_table',
		'certificate',
		'custom_button_url'
	);

	public static function CreateSerializedDataString( $prefix, $postfixes, $data ) {
		return array();
	}

	/**
	 * @return array
	 */
	public static function getCsvPattern() {
		return LDUtility::$csvPattern;
	}
	/**
	 * @param array $csvPattern
	 */
	public static function setCsvPattern( $csvPattern ) {
		LDUtility::$csvPattern = $csvPattern;
	}
}