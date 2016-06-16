<?php

namespace CorduroyBeach\Database;

/**
 * Class ImportDatabaseActions
 * @package CorduroyBeach\Database
 */
class ImportDatabaseActions {

	/**
	 * @param $csvData
	 *
	 * @return array
	 */
	public function importCsv($csvData) {
		global $wpdb;

		$created_ids = [];
		
		foreach($csvData as $data) {
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
		
		return $created_ids;
	}
}