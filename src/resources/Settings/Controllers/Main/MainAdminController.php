<?php

class MainAdminController {
	public static function columnPatternView() {
		// TODO: Separate this out into it's own testable function
		$options = get_option('ld_options');
		$csv_ops = $options['ld_settings_course_csv_pattern'];

		$csv_pattern = [];

		if(!$csv_ops || $csv_ops == "") {
			$csv_pattern = array(
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
				'sort_lesson_by',
				'sort_lesson_direction',
				'course_prerequisites',
				'disable_lesson_progression',
				'expire_access',
				'hide_course_content_table',
				'associated_certificate'
			);

			$csv_pattern = json_encode($csv_pattern);
		} else {
			$csv_pattern = $options['ld_settings_course_csv_pattern'];
		}

		return array('csv_pattern' => $csv_pattern);
	}

	public static function uploaderFieldsView() {
		return array();
	}

	public static function runImportView() {
		return array();
	}
}