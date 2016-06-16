<?php

use CorduroyBeach\Utilities\LDUtility;

return function() {
	global $wpdb;

	$csv_json_obj = $_POST['csv_json_obj'];
	$csv_local_path = get_attached_file($csv_json_obj['id']);
	$csv_data_arr = array_map('str_getcsv', file($csv_local_path));
	$created_ids = [];

	$serialized_data = LDUtility::CreateSerializedDataString(
		LDUtility::LD_DB_PREFIX,
		get_option('ld_options'),
		$csv_data_arr );

	foreach($serialized_data as $data) {
		$serialized   = $data["serialized"];
		$unSerialized = $data["un-serialized"];

		$wpdb->insert( 'wp_posts', $unSerialized );
		$created_id = $wpdb->insert_id;
		$created_ids[] = $created_id;

		$wpdb->insert( 'wp_postmeta', array(
			'post_id'    => $created_id,
			'meta_key'   => '_sfwd-courses',
			'meta_value' => $serialized
		));
	}

	$pre_response_obj = (object) array(
		"status" => "Finished",
		"csv_data" => $csv_data_arr,
		"serialized_data" => $serialized_data,
		"created_id" => $created_ids
	);

	$response_obj = json_encode($pre_response_obj);

	echo $response_obj;

	wp_die();
};