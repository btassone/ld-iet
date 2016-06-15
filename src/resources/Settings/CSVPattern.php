<?php

return array(
	'course_title' => null,
	'status' => null,
	'visibility' => null,
	'featured_img' => null,
	'categories' => null,
	'tags' => null,
	'restrictions' => null,
	'course_materials' => (object) array(
		'name'      => 'Course Materials',
		'example'   => 'These are test course materials',
		'values'    => 'string | empty string'
	),
	'course_price_type' => (object) array(
		'name'      => 'Course Price Type',
		'example'   => 'open',
		'values'    => 'open | closed | free | paynow | subscribe'
	),
	'course_price' => (object) array(
		'name'      => 'Course Price',
		'example'   => '500.00',
		'values'    => 'string | empty string'
	),
	'course_access_list' => (object) array(
		'name'      => 'Course Access List',
		'example'   => '1, 2',
		'values'    => 'string | empty string'
	),
	'course_lesson_orderby' => (object) array(
		'name'      => 'Course Lesson Order By',
		'example'   => 'date',
		'values'    => 'title | date | menu_order | empty string'
	),
	'course_lesson_order' => (object) array(
		'name'      => 'Course Lesson Order',
		'example'   => 'ASC',
		'values'    => 'ASC | DESC | empty string'
	),
	'course_prerequisite' => (object) array(
		'name'      => 'Course Prerequisite',
		'example'   => '42 (Post ID)',
		'values'    => 'string | 0'
	),
	'disable_lesson_progression' => (object) array(
		'name'      => 'Disable Lesson Progression',
		'example'   => 'on',
		'values'    => 'on | don\'t include in csv'
	),
	'expire_access' => (object) array(
		'name'      => 'Expire Access',
		'example'   => 'on',
		'values'    => 'on | don\'t include in csv'
	),
	'expire_access_days' => (object) array(
		'name'      => 'Expire Access Days',
		'example'   => '10',
		'values'    => 'string | empty string'
	),
	'expire_access_delete_progress' => (object) array(
		'name'      => 'Expire Access Delete Progress',
		'example'   => 'on',
		'values'    => 'on | don\'t include in csv'
	),
	'course_disable_content_table' => (object) array(
		'name'      => 'Disable Content Table',
		'example'   => 'on',
		'values'    => 'on | don\'t include in csv'
	),
	'certificate' => (object) array(
		'name'      => 'Certificate',
		'example'   => '46 (Post ID)',
		'values'    => 'string | 0'
	),
	'custom_button_url' => (object) array(
		'name'      => 'Custom Button Url',
		'example'   => 'http://www.google.com',
		'values'    => 'string | empty string'
	)
);