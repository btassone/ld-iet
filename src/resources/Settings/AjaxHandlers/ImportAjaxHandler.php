<?php

use CorduroyBeach\Utilities\LDUtility;

return function() {
	$csv_json_obj = $_POST['csv_json_obj'];
	$csv_local_path = get_attached_file($csv_json_obj['id']);
	$csv_data_arr = array_map('str_getcsv', file($csv_local_path));

	$pre_response_obj = (object) array(
		"status" => "Finished",
		"csv_data" => $csv_data_arr
	);

	$response_obj = json_encode($pre_response_obj);

	$serialized_data = LDUtility::CreateSerializedDataString(
		LDUtility::LD_DB_PREFIX,
		get_option('ld_options'),
		$csv_data_arr );

	// Test the processing status
	// TODO: Remove this line once actual import takes place.
	sleep(5);

	echo $response_obj;

	wp_die();
};