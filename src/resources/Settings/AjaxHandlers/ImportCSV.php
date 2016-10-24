<?php

use CorduroyBeach\Utilities\LDUtility;

return function($csv_json_obj, $csv_local_path) {
	$csv_data_arr = [];
	$created_ids = [];

	if(!$csv_local_path) {
		$csv_local_path = get_attached_file($csv_json_obj['id']);
	}

	$csv_data_arr = array_map('str_getcsv', file($csv_local_path));
	$serialized_data = LDUtility::CreateSerializedDataString(
		LDUtility::LD_DB_PREFIX,
		$this->getOptions(),
		$csv_data_arr );

	$created_ids = $this->getDbActions()->importCsv($serialized_data);
	$pre_response_obj = (object) array(
		"status" => "Finished",
		"csv_data" => $csv_data_arr,
		"serialized_data" => $serialized_data,
		"created_id" => $created_ids
	);
	$response_obj = json_encode($pre_response_obj);

	return $response_obj;
};