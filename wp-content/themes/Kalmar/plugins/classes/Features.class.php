<?php
class Features {
	public static function addFeature($title, $imageLocation = null, $bulletPoints, $productID) {
		try {
			global $wpdb;
			$wpdb->insert ( $wpdb->prefix . 'mil_feature', array (
					'mil_feature_title' => $title,
					'mil_feature_image' => $imageLocation,
					'mil_feature_bullets' => $bulletPoints,
					'mil_product_id' => $productID 
			) );
		} catch ( Exception $e ) {
			echo '<div class="alert alert-danger">' . $e->getMessage () . '</div>';
		}
	}
	
	public static function addCommFeature($title, $imageLocation = null, $bulletPoints, $productID) {
		try {
			global $wpdb;
			$wpdb->insert ( $wpdb->prefix . 'comm_feature', array (
					'comm_feature_title' => $title,
					'comm_feature_image' => $imageLocation,
					'comm_feature_bullets' => $bulletPoints,
					'comm_product_id' => $productID 
			) );
		} catch ( Exception $e ) {
			echo '<div class="alert alert-danger">' . $e->getMessage () . '</div>';
		}
	}
	
	public static function deleteFeature($featureID) {
	}
	public static function editFeature($featureID, $featureTitle, $featureImageLocation, $bulletPoints) {
	}
}

?>