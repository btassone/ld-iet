<?php

return array(
	'course_title' => (object) array(
		'column_info' => (object) array(
			'name'      => 'Course Title',
			'example'   => 'Some Course Title',
			'values'    => 'string | empty string'
		),
		'has_close' => false,
		'uses_prefix' => false
	),
	'course_materials' => (object) array(
		'column_info' => (object) array(
			'name'      => 'Course Materials',
			'example'   => 'These are test course materials',
			'values'    => 'string | empty string'
		),
		'has_close' => false,
		'uses_prefix' => true
	),
	'course_price_type' => (object) array(
		'column_info' => (object) array(
			'name'      => 'Course Price Type',
			'example'   => 'open',
			'values'    => 'open | closed | free | paynow | subscribe'
		),
		'has_close' => false,
		'uses_prefix' => true
	),
	'course_price' => (object) array(
		'column_info' => (object) array(
			'name'      => 'Course Price',
			'example'   => '500.00',
			'values'    => 'string | empty string'
		),
		'has_close' => false,
		'uses_prefix' => true
	),
	'course_access_list' => (object) array(
		'column_info' => (object) array(
			'name'      => 'Course Access List',
			'example'   => '1, 2',
			'values'    => 'string | empty string'
		),
		'has_close' => false,
		'uses_prefix' => true
	),
	'course_lesson_orderby' => (object) array(
		'column_info' => (object) array(
			'name'      => 'Course Lesson Order By',
			'example'   => 'date',
			'values'    => 'title | date | menu_order | empty string'
		),
		'has_close' => false,
		'uses_prefix' => true
	),
	'course_lesson_order' => (object) array(
		'column_info' => (object) array(
			'name'      => 'Course Lesson Order',
			'example'   => 'ASC',
			'values'    => 'ASC | DESC | empty string'
		),
		'has_close' => false,
		'uses_prefix' => true
	),
	'course_prerequisite' => (object) array(
		'column_info' => (object) array(
			'name'      => 'Course Prerequisite',
			'example'   => '42 (Post ID)',
			'values'    => 'string | 0'
		),
		'has_close' => false,
		'uses_prefix' => true
	),
	'disable_lesson_progression' => (object) array(
		'column_info' => (object) array(
			'name'      => 'Disable Lesson Progression',
			'example'   => 'on',
			'values'    => 'on | don\'t include in csv'
		),
		'has_close' => true,
		'uses_prefix' => true
	),
	'expire_access' => (object) array(
		'column_info' => (object) array(
			'name'      => 'Expire Access',
			'example'   => 'on',
			'values'    => 'on | don\'t include in csv'
		),
		'has_close' => true,
		'uses_prefix' => true
	),
	'expire_access_days' => (object) array(
		'column_info' => (object) array(
			'name'      => 'Expire Access Days',
			'example'   => '10',
			'values'    => 'string | empty string'
		),
		'has_close' => false,
		'uses_prefix' => true
	),
	'expire_access_delete_progress' => (object) array(
		'column_info' => (object) array(
			'name'      => 'Expire Access Delete Progress',
			'example'   => 'on',
			'values'    => 'on | don\'t include in csv'
		),
		'has_close' => true,
		'uses_prefix' => true
	),
	'course_disable_content_table' => (object) array(
		'column_info' => (object) array(
			'name'      => 'Disable Content Table',
			'example'   => 'on',
			'values'    => 'on | don\'t include in csv'
		),
		'has_close' => true,
		'uses_prefix' => true
	),
	'certificate' => (object) array(
		'column_info' => (object) array(
			'name'      => 'Certificate',
			'example'   => '46 (Post ID)',
			'values'    => 'string | 0'
		),
		'has_close' => false,
		'uses_prefix' => true
	),
	'custom_button_url' => (object) array(
		'column_info' => (object) array(
			'name'      => 'Custom Button Url',
			'example'   => 'http://www.google.com',
			'values'    => 'string | empty string'
		),
		'has_close' => false,
		'uses_prefix' => true
	)
);