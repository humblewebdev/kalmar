<?php
class Specifications {
	public static function addSpecifications($features) {
		try {
			global $wpdb;
			$wpdb->insert ( 'wp_dummy_sitemil_specs', $features );
			echo $wpdb->last_error;
		} catch ( Exception $e ) {
			echo $e->getMessage ();
		}
	}
	public static function addCommSpecifications($features) {
		try {
			global $wpdb;
			$wpdb->insert ( 'wp_dummy_sitecomm_specs', $features );
			echo $wpdb->last_error;
		} catch ( Exception $e ) {
			echo $e->getMessage ();
		}
	}
	public static function deleteSpecifications() {
	}
	public static function editSpecifications() {
	}
}
?>