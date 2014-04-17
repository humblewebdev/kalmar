<?php
class Gallery {
	public static function addToGallery($type, $location, $product_id) {
		try {
			global $wpdb;
			$wpdb->insert ( $wpdb->prefix . 'mil_gallery', array (
					'mil_gallery_type' => $type,
					'mil_gallery_location' => $location,
					'mil_product_id' => $product_id 
			) );
		} catch ( Exception $e ) {
			echo $e->getMessage ();
		}
	}
	public static function addToCommGallery($type, $location, $product_id) {
		try {
			global $wpdb;
			$wpdb->insert ( $wpdb->prefix . 'comm_gallery', array (
					'comm_gallery_type' => $type,
					'comm_gallery_location' => $location,
					'comm_product_id' => $product_id 
			) );
		} catch ( Exception $e ) {
			echo $e->getMessage ();
		}
	}
	public static function deleteFromGallery() {
	}
	public static function editGallery() {
	}
}
?>