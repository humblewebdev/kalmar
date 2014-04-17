<?php
$posts = $_POST;
$files = $_FILES;



/*
 * foreach ( $posts as $key => $value ) { echo $key . ': ' . $value . "\n"; } echo "\n\n###FILES###\n\n"; foreach ( $files as $file ) { echo "\n"; var_dump ( $files ); echo "\n"; foreach ( $file as $key => $value ) { echo $key . ': ' . $value . "\n"; } echo "\n"; }
 */

global $wpdb;

// mil_Product
$product_id = $_POST ['mil_product_id'];
$product_name = $_POST ['mil_product_name' . $product_id];
$product_image = $_POST ['mil_product_image_placeholder' . $product_id];
$product_desc = $_POST ['edit_mil_product_desc' . $product_id];

$product_data = $wpdb->get_results ("SELECT * FROM wp_dummy_sitemil_product WHERE mil_product_id = $product_id");
$page_title = get_page_by_title( 'Military - '.$product_data[0]->mil_product_name);

if (isset ( $_FILES ['mil_product_image' . $product_id] )) {
	$allowedExts = array (
			"gif",
			"jpeg",
			"jpg",
			"png" 
	);
	$temp = explode ( ".", $_FILES ['mil_product_image' . $product_id] ["name"] );
	$extension = end ( $temp );
	if ((($_FILES ['mil_product_image' . $product_id] ["type"] == "image/gif") || ($_FILES ['mil_product_image' . $product_id] ["type"] == "image/jpeg") || ($_FILES ['mil_product_image' . $product_id] ["type"] == "image/jpg") || ($_FILES ['mil_product_image' . $product_id] ["type"] == "image/pjpeg") || ($_FILES ['mil_product_image' . $product_id] ["type"] == "image/x-png") || ($_FILES ['mil_product_image' . $product_id] ["type"] == "image/png")) && ($_FILES ['mil_product_image' . $product_id] ["size"] < 4 * 1048576) && in_array ( $extension, $allowedExts )) {
		if ($_FILES ['mil_product_image' . $product_id] ["error"] > 0) {
			$product_image = $_POST ['mil_product_image_placeholder'];
		} else {
			$product_image_name = time () . '.' . $extension;
			if (file_exists ( get_template_directory () . "/images/product_images/" . $product_image_name )) {
				echo $product_image_name . " already exists. ";
			} else {
				move_uploaded_file ( $_FILES ['mil_product_image' . $product_id] ["tmp_name"], get_template_directory () . "/images/product_images/" . $product_image_name );
				$product_image = get_template_directory_uri () . "/images/product_images/" . $product_image_name;
			}
		}
	}
}
try {
	$wpdb->update ( 'wp_dummy_sitemil_product', array (
			'mil_product_name' => $product_name,
			'mil_product_image' => $product_image,
			'mil_product_desc' => $product_desc 
	), array (
			'mil_product_id' => $product_id 
	) );
	if (! empty ( $wpdb->last_error )) {
		echo '<div class="alert alert-danger">A problem occured while trying to update your Specifications!' . $wpdb->last_error . '</div><br>';
	}
} catch ( Exception $e ) {
	echo $e->getMessage ();
}

// ###### mil_features ######

$feature_count = 1;

while ( isset ( $_POST ['mil_feature_id' . $feature_count] ) ) {
	$feature_id = $_POST ['mil_feature_id' . $feature_count];
	$feature_title = $_POST ['mil_feature_title' . $feature_count];
	$feature_image = $_POST ['featureImageHolder' . $feature_count];
	$feature_bullets = $_POST ['mil_feature_bullets' . $feature_count];
	
	if (isset ( $_FILES ['mil_feature_image' . $feature_count] )) {
		$allowedExts = array (
				"gif",
				"jpeg",
				"jpg",
				"png" 
		);
		$temp = explode ( ".", $_FILES ['mil_feature_image' . $feature_count] ["name"] );
		$extension = end ( $temp );
		if ((($_FILES ['mil_feature_image' . $feature_count] ["type"] == "image/gif") || ($_FILES ['mil_feature_image' . $feature_count] ["type"] == "image/jpeg") || ($_FILES ['mil_feature_image' . $feature_count] ["type"] == "image/jpg") || ($_FILES ['mil_feature_image' . $feature_count] ["type"] == "image/pjpeg") || ($_FILES ['mil_feature_image' . $feature_count] ["type"] == "image/x-png") || ($_FILES ['mil_feature_image' . $feature_count] ["type"] == "image/png")) && ($_FILES ['mil_feature_image' . $feature_count] ["size"] < 4 * 1048576) && in_array ( $extension, $allowedExts )) {
			if ($_FILES ['mil_feature_image' . $feature_count] ["error"] > 0) {
				global $feature_image;
				$feature_image = $_POST ['featureImageHolder' . $feature_count];
			} else {
				$product_image_name = time () . $_FILES ['mil_feature_image' . $feature_count] ["name"];
				if (file_exists ( get_template_directory () . "/images/product_images/" . $product_image_name )) {
					echo $product_image_name . " already exists. ";
				} else {
					move_uploaded_file ( $_FILES ['mil_feature_image' . $feature_count] ["tmp_name"], get_template_directory () . "/images/featured_images/" . $product_image_name );
					global $feature_image;
					$feature_image = get_template_directory_uri () . "/images/featured_images/" . $product_image_name;
				}
			}
		}
	}
	
	try {
		$wpdb->update ( 'wp_dummy_sitemil_feature', array (
				'mil_feature_title' => $feature_title,
				'mil_feature_image' => $feature_image,
				'mil_feature_bullets' => $feature_bullets 
		), array (
				'mil_feature_id' => $feature_id 
		) );
		if (! empty ( $wpdb->last_error )) {
			echo '<div class="alert alert-danger">A problem occured while trying to update your features!' . $wpdb->last_error . '</div><br>';
		}
	} catch ( Exception $e ) {
		$e->getMessage ();
	}
	$feature_count ++;
}
while ( (isset ( $_POST ['mil_feature_title' . $feature_count] )) ) {
	$new_feature_array;
	if ((! empty ( $_POST ['mil_feature_title' . $feature_count] ) && (! empty ( $_POST ['mil_feature_bullets' . $feature_count] ) && (! empty ( $_FILES ['mil_feature_image' . $feature_count] ["name"] ))))) {
		$new_feature_array ['mil_feature_title'] = $_POST ['mil_feature_title' . $feature_count];
		$new_feature_array ['mil_feature_bullets'] = $_POST ['mil_feature_bullets' . $feature_count];
		$new_feature_array ['mil_product_id'] = $product_id;
		
		if (isset ( $_FILES ['mil_feature_image' . $feature_count] )) {
			$allowedExts = array (
					"gif",
					"jpeg",
					"jpg",
					"png" 
			);
			$temp = explode ( ".", $_FILES ['mil_feature_image' . $feature_count] ["name"] );
			$extension = end ( $temp );
			if ((($_FILES ['mil_feature_image' . $feature_count] ["type"] == "image/gif") || ($_FILES ['mil_feature_image' . $feature_count] ["type"] == "image/jpeg") || ($_FILES ['mil_feature_image' . $feature_count] ["type"] == "image/jpg") || ($_FILES ['mil_feature_image' . $feature_count] ["type"] == "image/pjpeg") || ($_FILES ['mil_feature_image' . $feature_count] ["type"] == "image/x-png") || ($_FILES ['mil_feature_image' . $feature_count] ["type"] == "image/png")) && ($_FILES ['mil_feature_image' . $feature_count] ["size"] < 4 * 1048576) && in_array ( $extension, $allowedExts )) {
				if ($_FILES ['mil_feature_image' . $feature_count] ["error"] > 0) {
				} else {
					$product_image_name = time () . $_FILES ['mil_feature_image' . $feature_count] ["name"];
					if (file_exists ( get_template_directory () . "/images/product_images/" . $product_image_name )) {
						echo $product_image_name . " already exists. ";
					} else {
						move_uploaded_file ( $_FILES ['mil_feature_image' . $feature_count] ["tmp_name"], get_template_directory () . "/images/featured_images/" . $product_image_name );
						$new_feature_array ['mil_feature_image'] = get_template_directory_uri () . "/images/featured_images/" . $product_image_name;
					}
				}
			}
		}
		try {
			$wpdb->insert ( 'wp_dummy_sitemil_feature', $new_feature_array );
			if (! empty ( $wpdb->last_error )) {
				echo '<div class="alert alert-danger">A problem occured while trying to update your features!' . $wpdb->last_error . '</div><br>';
			}
		} catch ( Exception $e ) {
			$e->getMessage ();
		}
	} else {
		echo '<div class="alert alert-danger">Please fill out all fields</div>';
	}
	$feature_count ++;
}
// mil_specs
$mil_specs_array;
// Engine
$mil_specs_array ['mil_engine_make'] = $_POST ['mil_engine_make'];
$mil_specs_array ['mil_engine_model'] = $_POST ['mil_engine_model'];
$mil_specs_array ['mil_engine_cylinders'] = $_POST ['mil_engine_cylinders'];
$mil_specs_array ['mil_engine_power'] = $_POST ['mil_engine_power'];
$mil_specs_array ['mil_engine_displacement'] = $_POST ['mil_engine_displacement'];
$mil_specs_array ['mil_engine_cooling'] = $_POST ['mil_engine_cooling'];
$mil_specs_array ['mil_engine_fuel'] = $_POST ['mil_engine_fuel'];
// Performance
$mil_specs_array ['mil_performance_speedUnladen'] = $_POST ['mil_performance_speedUnladen'];
$mil_specs_array ['mil_performance_speedLaden'] = $_POST ['mil_performance_speedLaden'];
$mil_specs_array ['mil_performance_speedReverse'] = $_POST ['mil_performance_speedReverse'];
$mil_specs_array ['mil_performance_gradeability'] = $_POST ['mil_performance_gradeability'];
$mil_specs_array ['mil_performance_unladen'] = $_POST ['mil_performance_unladen'];
$mil_specs_array ['mil_performance_laden'] = $_POST ['mil_performance_laden'];
$mil_specs_array ['mil_performance_fordingDepth'] = $_POST ['mil_performance_fordingDepth'];
// Transmission
$mil_specs_array ['mil_transmission_make'] = $_POST ['mil_transmission_make'];
$mil_specs_array ['mil_transmission_model'] = $_POST ['mil_transmission_model'];
$mil_specs_array ['mil_transmission_type'] = $_POST ['mil_transmission_type'];
$mil_specs_array ['mil_transmission_gears'] = $_POST ['mil_transmission_gears'];
// weight
$mil_specs_array ['mil_weight_curb'] = $_POST ['mil_weight_curb'];
$mil_specs_array ['mil_weight_frontAxelWeight'] = $_POST ['mil_weight_frontAxelWeight'];
$mil_specs_array ['mil_weight_rearAxelWeight'] = $_POST ['mil_weight_rearAxelWeight'];
// Axel
$mil_specs_array ['mil_axel_make'] = $_POST ['mil_axel_make'];
$mil_specs_array ['mil_axel_model'] = $_POST ['mil_axel_model'];
$mil_specs_array ['mil_axel_frontModel'] = $_POST ['mil_axel_frontModel'];
$mil_specs_array ['mil_axel_rearModel'] = $_POST ['mil_axel_rearModel'];
// Service
$mil_specs_array ['mil_service_fuel'] = $_POST ['mil_service_fuel'];
$mil_specs_array ['mil_service_hydraulic'] = $_POST ['mil_service_hydraulic'];
// tire
$mil_specs_array ['mil_tire_size'] = $_POST ['mil_tire_size'];
// brake
$mil_specs_array ['mil_brake_service'] = $_POST ['mil_brake_service'];
$mil_specs_array ['mil_brake_parking'] = $_POST ['mil_brake_parking'];
// Other
$mil_specs_array ['mil_electrical_system'] = $_POST ['mil_electrical_system'];
$mil_specs_array ['mil_alternator'] = $_POST ['mil_alternator'];
// Spec Sheet

if (isset ( $_FILES ['mil_spec_sheet'] )) {
	$allowedExts = array (
			"pdf" 
	);
	$temp = explode ( ".", $_FILES ['mil_spec_sheet'] ["name"] );
	$extension = end ( $temp );
	if (($_FILES ['mil_spec_sheet'] ["type"] == "application/pdf") && ($_FILES ['mil_spec_sheet'] ["size"] < 64 * 1048576) && in_array ( $extension, $allowedExts )) {
		if ($_FILES ['mil_spec_sheet'] ["error"] > 0) {
			global $feature_image;
			$feature_image = $_POST ['featureImageHolder' . $feature_count];
		} else {
			$spec_sheet_name = time () . $_FILES ['mil_spec_sheet'] ["name"];
			if (file_exists ( get_template_directory () . "/plugins/Spec_sheets/" . $spec_sheet_name )) {
				echo $spec_sheet_name . " already exists. ";
			} else {
				move_uploaded_file ( $_FILES ['mil_spec_sheet'] ["tmp_name"], get_template_directory () . "/plugins/spec_Sheets/" . $spec_sheet_name );
				$mil_specs_array ['mil_spec_sheet'] = get_template_directory_uri () . "/plugins/spec_Sheets/" . $spec_sheet_name;
			}
		}
	}
}

try {
	$wpdb->update ( 'wp_dummy_sitemil_specs', $mil_specs_array, array (
			'mil_product_id' => $product_id 
	) );
	if (! empty ( $wpdb->last_error )) {
		echo '<div class="alert alert-danger">A problem occured while trying to update your Specifications!' . $wpdb->last_error . '</div><br>';
	}
} catch ( Exception $e ) {
	echo $e->getMessage ();
}
// mil_gallery
$image_counter = 1;
$video_counter = 1;
while ( isset ( $_POST ['gallery_video_' . $video_counter . '_id'] ) ) {
	$video_id = $_POST ['gallery_video_' . $video_counter . '_id'];
	$video_location = $_POST ['gallery_video_' . $video_counter];
	try {
		global $wpdb;
		$wpdb->update ( 'wp_dummy_sitemil_gallery', array (
				'mil_gallery_location' => $video_location 
		), array (
				'mil_gallery_id' => $video_id 
		) );
	} catch ( Exception $e ) {
		echo $e->getMessage ();
	}
	$video_counter ++;
}
while ( isset ( $_POST ['gallery_image_' . $image_counter . '_id'] ) ) {
	if (! empty ( $_FILES ['gallery_image_' . $image_counter] ["name"] )) {
		$image_id = $_POST ['gallery_image_' . $image_counter . '_id'];
		$image_location;
		$allowedExts = array (
				"gif",
				"jpeg",
				"jpg",
				"png" 
		);
		$temp = explode ( ".", $_FILES ['gallery_image_' . $image_counter] ["name"] );
		$extension = end ( $temp );
		if ((($_FILES ['gallery_image_' . $image_counter] ["type"] == "image/gif") || ($_FILES ['gallery_image_' . $image_counter] ["type"] == "image/jpeg") || ($_FILES ['gallery_image_' . $image_counter] ["type"] == "image/jpg") || ($_FILES ['gallery_image_' . $image_counter] ["type"] == "image/pjpeg") || ($_FILES ['gallery_image_' . $image_counter] ["type"] == "image/x-png") || ($_FILES ['gallery_image_' . $image_counter] ["type"] == "image/png")) && ($_FILES ['gallery_image_' . $image_counter] ["size"] < 4 * 1048576) && in_array ( $extension, $allowedExts )) {
			if ($_FILES ['gallery_image_' . $image_counter] ["error"] > 0) {
			} else {
				$product_image_name = time () . $_FILES ['gallery_image_' . $image_counter] ["name"];
				if (file_exists ( get_template_directory () . "/images/product_images/" . $product_image_name )) {
					echo $product_image_name . " already exists. ";
				} else {
					move_uploaded_file ( $_FILES ['gallery_image_' . $image_counter] ["tmp_name"], get_template_directory () . "/images/featured_images/" . $product_image_name );
					$image_location = get_template_directory_uri () . "/images/featured_images/" . $product_image_name;
				}
			}
		}
		$wpdb->update ( 'wp_dummy_sitemil_gallery', array (
				'mil_gallery_location' => $image_location 
		), array (
				'mil_gallery_id' => $image_id 
		) );
	}
	$image_counter ++;
}

while ( isset ( $_POST ['gallery_video_' . $video_counter] ) ) {
	$video_location = $_POST ['gallery_video_' . $video_counter];
	global $wpdb;
	$wpdb->insert ( 'wp_dummy_sitemil_gallery', array (
			'mil_gallery_type' => 'video',
			'mil_gallery_location' => $video_location,
			'mil_product_id' => $product_id 
	) );
	$video_counter ++;
}

while ( isset ( $_FILES ['gallery_image_' . $image_counter] ) ) {
	if (! empty ( $_FILES ['gallery_image_' . $image_counter] ["name"] )) {
		$image_location;
		$allowedExts = array (
				"gif",
				"jpeg",
				"jpg",
				"png" 
		);
		$temp = explode ( ".", $_FILES ['gallery_image_' . $image_counter] ["name"] );
		$extension = end ( $temp );
		if ((($_FILES ['gallery_image_' . $image_counter] ["type"] == "image/gif") || ($_FILES ['gallery_image_' . $image_counter] ["type"] == "image/jpeg") || ($_FILES ['gallery_image_' . $image_counter] ["type"] == "image/jpg") || ($_FILES ['gallery_image_' . $image_counter] ["type"] == "image/pjpeg") || ($_FILES ['gallery_image_' . $image_counter] ["type"] == "image/x-png") || ($_FILES ['gallery_image_' . $image_counter] ["type"] == "image/png")) && ($_FILES ['gallery_image_' . $image_counter] ["size"] < 4 * 1048576) && in_array ( $extension, $allowedExts )) {
			if ($_FILES ['gallery_image_' . $image_counter] ["error"] > 0) {
			} else {
				$product_image_name = time () . $_FILES ['gallery_image_' . $image_counter] ["name"];
				if (file_exists ( get_template_directory () . "/images/product_images/" . $product_image_name )) {
					echo $product_image_name . " already exists. ";
				} else {
					move_uploaded_file ( $_FILES ['gallery_image_' . $image_counter] ["tmp_name"], get_template_directory () . "/images/featured_images/" . $product_image_name );
					$image_location = get_template_directory_uri () . "/images/featured_images/" . $product_image_name;
				}
			}
		}
		$wpdb->insert ( 'wp_dummy_sitemil_gallery', array (
				'mil_gallery_location' => $image_location,
				'mil_gallery_type' => 'image',
				'mil_product_id' => $product_id 
		) );
	}
	$image_counter ++;
}

$product_page_template = <<<EOL
<style>
	.panel-body h1 {
		font-size: 1.313em;
		color:#222222;
		padding:10px 0;
		font-weight:bold;
		font-family:arial;
	}
	.panel-body p {
		font-size: .875em;
		color:#333333;
		font-family:arial;
	}
	
	.panel-body li {
		list-style-type:disc;	
	}
</style>
<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		<div class="red_box">
			<ul>
				<li><a href="#collapseOne" data-toggle="collapse"
					data-parent="#accordion">###PRODUCTTITLE###</a></li>
				<li><a href="#collapseTwo" data-toggle="collapse"
					data-parent="#accordion">Features</a></li>
				<li><a href="#collapseThree" data-toggle="collapse"
					data-parent="#accordion">Specifications</a></li>
				<li><a href="#collapseFour" data-toggle="collapse"
					data-parent="#accordion">Gallery</a></li>
				<li><a href="###SPECSHEETURL###">Spec Sheet</a></li>
			</ul>
		</div>
		<div class="black_box">
			<h1>For MORE INFO</h1>
			<a class="btn btn-danger" href="http://www.webtegstage.com/kalmar/request-a-quote/">REQUEST A QUOTE</a><h1>OR CALL</h1>
			<h2>800-232-1236</h2>
		</div>
	</div>
	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a href="#collapseOne" data-toggle="collapse"
							data-parent="#accordion"> ###PRODUCTTITLE### </a>
					</h4>
				</div>
				<div class="panel-collapse collapse in" id="collapseOne">
					<div class="panel-body">
						###Product###
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a href="#collapseTwo" data-toggle="collapse"
							data-parent="#accordion"> Features </a>
					</h4>
				</div>
				<div class="panel-collapse collapse" id="collapseTwo">
					<div class="panel-body">
						###FEATURES###
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a href="#collapseThree" data-toggle="collapse"
							data-parent="#accordion"> Specifications </a>
					</h4>
				</div>
				<div class="panel-collapse collapse" id="collapseThree">
					<div class="panel-body">
						###SPECIFICATIONS###
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a href="#collapseFour" data-toggle="collapse"
							data-parent="#accordion"> Gallery </a>
					</h4>
				</div>
				<div class="panel-collapse collapse" id="collapseFour">
					<div class="panel-body">
							###GALLERY###
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clear"></div>
EOL;


global $wpdb;
//PRODUCT 
$product_info = $wpdb->get_results("SELECT * FROM wp_dummy_sitemil_product WHERE mil_product_id = $product_id");
$product_name = $product_info[0]->mil_product_name;
$product_desc = $product_info[0]->mil_product_desc;
$product_image = $product_info[0]->mil_product_image;

$product_template = <<<EOL
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<img src="{$product_image}" alt="{$product_name}" width="100%" >
		<p>{$product_desc}</p>
	</div>
EOL;



//Put title of product in first accordian
$product_page_template = str_replace ( '###PRODUCTTITLE###', $product_name, $product_page_template );
$product_page_template = str_replace ( '###Product###', $product_template, $product_page_template );


//FEATURES
$features_info = $wpdb->get_results("SELECT * FROM wp_dummy_sitemil_feature WHERE mil_product_id = $product_id");
$all_features;

$one_feature_template = <<<EOL
	<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<img src="###FEATUREIMAGE###" alt="###FEATURETITLE###" class="img-rounded col-lg-3 col-md-3 col-sm-3 col-xs-3 pull-left">
			<div class="pull-right col-lg-9 col-md-9 col-sm-9 col-xs-9">
				<h1>###FEATURETITLE###</h1>
				<p>###FEATUREBULLETS###</p>
			</div>
			<div class="clear"></div>
	</div>

EOL;

echo $wpdb->last_error;

foreach($features_info as $feature_info){
	$lines = explode(PHP_EOL, $feature_info->mil_feature_bullets);
	$str = '';
	foreach($lines as $line){
		$str .= '<li>'.$line.'</li>';
	}
	
	$bullets = <<<EOL
	<ul>
	###BULLETS###
	</ul>
EOL;
	$this_bullets = str_replace ( '###BULLETS###', $str, $bullets );
	$this_template = str_replace ( '###FEATUREBULLETS###', $this_bullets, $one_feature_template );
	$this_template = str_replace ( '###FEATUREIMAGE###', $feature_info->mil_feature_image, $this_template );
	$this_template = str_replace ( '###FEATURETITLE###', $feature_info->mil_feature_title, $this_template );
	$all_features .= $this_template;
}

$product_page_template = str_replace ( '###FEATURES###', $all_features, $product_page_template );

//SPECS
$specs_info = $wpdb->get_results("SELECT * FROM wp_dummy_sitemil_specs WHERE mil_product_id = $product_id");

$all_specs;
$Engine_template = <<<EOL
<div class="well">
	<table class="table table-striped">
		<tr>
			<th>Engine</th>
			<th></th>
		</tr>
		<tr>
			<td>Make</td>
			<td>{$specs_info[0]->mil_engine_make}</td>
		</tr>
		<tr>
			<td>Model</td>
			<td>{$specs_info[0]->mil_engine_model}</td>
		</tr>
		<tr>
			<td>Cylinders</td>
			<td>{$specs_info[0]->mil_engine_cylinders}</td>
		</tr>
		<tr>
			<td>Power</td>
			<td>{$specs_info[0]->mil_engine_power}</td>
		</tr>
		<tr>
			<td>Displacement</td>
			<td>{$specs_info[0]->mil_engine_displacement}</td>
		</tr>
		<tr>
			<td>Cooling</td>
			<td>{$specs_info[0]->mil_engine_cooling}</td>
		</tr>
		<tr>
			<td>Fuel</td>
			<td>{$specs_info[0]->mil_engine_power}</td>
		</tr>
	</table>
</div>
EOL;

$performance_template = <<<EOL
	<div class="well">
	<table class="table table-striped">
		<tr>
			<th>Performance</th>
			<th></th>
		</tr>
		<tr>
			<td>Speed Unladen</td>
			<td>{$specs_info[0]->mil_performance_speedUnladen}</td>
		</tr>
		<tr>
			<td>Speed Laden</td>
			<td>{$specs_info[0]->mil_performance_laden}</td>
		</tr>
		<tr>
			<td>Speed Reverse</td>
			<td>{$specs_info[0]->mil_performance_speedReverse}</td>
		</tr>
		<tr>
			<td>Gradeability</td>
			<td>{$specs_info[0]->mil_performance_gradeability}</td>
		</tr>
		<tr>
			<td>Unladen</td>
			<td>{$specs_info[0]->mil_performance_unladen}</td>
		</tr>
		<tr>
			<td>Laden</td>
			<td>{$specs_info[0]->mil_performance_laden}</td>
		</tr>
		<tr>
			<td>Fording Depth</td>
			<td>{$specs_info[0]->mil_performance_fordingDepth}</td>
		</tr>
	</table>
</div>
EOL;

$transmission_template = <<<EOL
	<div class="well">
	<table class="table table-striped">
		<tr>
			<th>Transmission</th>
			<th></th>
		</tr>
		<tr>
			<td>Make</td>
			<td>{$specs_info[0]->mil_trasnmission_make}</td>
		</tr>
		<tr>
			<td>Model</td>
			<td>{$specs_info[0]->mil_transmission_model}</td>
		</tr>
		<tr>
			<td>Type</td>
			<td>{$specs_info[0]->mil_transmisssion_type}</td>
		</tr>
		<tr>
			<td>Gears</td>
			<td>{$specs_info[0]->mil_transmission_gears}</td>
		</tr>
	</table>
</div>
EOL;

$weight_template = <<<EOL
	<div class="well">
	<table class="table table-striped">
		<tr>
			<th>Weight</th>
			<th></th>
		</tr>
		<tr>
			<td>Curb Weight</td>
			<td>{$specs_info[0]->mil_weight_curb}</td>
		</tr>
		<tr>
			<td>Front Axel Weight</td>
			<td>{$specs_info[0]->mil_weight_frontAxelWeight}</td>
		</tr>
		<tr>
			<td>Rear Axel Weight</td>
			<td>{$specs_info[0]->mil_weight_rearAxelWeight}</td>
		</tr>
	</table>
</div>
EOL;

$axel_template = <<<EOL
	<div class="well">
	<table class="table table-striped">
		<tr>
			<th>Axel</th>
			<th></th>
		</tr>
		<tr>
			<td>Axel Make</td>
			<td>{$specs_info[0]->mil_axel_make}</td>
		</tr>
		<tr>
			<td>Axel Model</td>
			<td>{$specs_info[0]->mil_axel_model}</td>
		</tr>
		<tr>
			<td>Front Axel Model</td>
			<td>{$specs_info[0]->mil_axel_frontModel}</td>
		</tr>
		<tr>
			<td>rear Axel Model</td>
			<td>{$specs_info[0]->mil_axel_rearModel}</td>
		</tr>
		
	</table>
</div>
EOL;

$service_template = <<<EOL
	<div class="well">
	<table class="table table-striped">
		<tr>
			<th>Service</th>
			<th></th>
		</tr>
		<tr>
			<td>Fuel</td>
			<td>{$specs_info[0]->mil_service_fuel}</td>
		</tr>
		<tr>
			<td>Hydraulic</td>
			<td>{$specs_info[0]->mil_service_hydraulic}</td>
		</tr>
	</table>
</div>
EOL;

$tire_template = <<<EOL
	<div class="well">
	<table class="table table-striped">
		<tr>
			<th>Tires</th>
			<th></th>
		</tr>
		<tr>
			<td>Tire Size</td>
			<td>{$specs_info[0]->mil_tire_size}</td>
		</tr>
	</table>
</div>
EOL;

$brake_template = <<<EOL
	<div class="well">
	<table class="table table-striped">
		<tr>
			<th>Brakes</th>
			<th></th>
		</tr>
		<tr>
			<td>Service</td>
			<td>{$specs_info[0]->mil_brake_service}</td>
		</tr>
		<tr>
			<td>Parking</td>
			<td>{$specs_info[0]->mil_brake_parking}</td>
		</tr>
	</table>
</div>
EOL;

$additional_template = <<<EOL
	<div class="well">
	<table class="table table-striped">
		<tr>
			<th>Additional Data</th>
			<th></th>
		</tr>
		<tr>
			<td>Electrical System</td>
			<td>{$specs_info[0]->mil_electrical_system}</td>
		</tr>
		<tr>
			<td>Alternator</td>
			<td>{$specs_info[0]->mil_alternator}</td>
		</tr>
	</table>
</div>
EOL;
$all_specs = $Engine_template.PHP_EOL.$performance_template.PHP_EOL.$transmission_template.PHP_EOL.$weight_template.PHP_EOL.$axel_template.PHP_EOL.$service_template.PHP_EOL.$tire_template.PHP_EOL.$brake_template.PHP_EOL.$additional_template;
$product_page_template = str_replace ( '###SPECSHEETURL###', $specs_info[0]->mil_spec_sheet, $product_page_template );
$product_page_template = str_replace ( '###SPECIFICATIONS###', $all_specs, $product_page_template );



//GALLERY
$gallery_info = $wpdb->get_results("SELECT * FROM wp_dummy_sitemil_gallery WHERE mil_product_id = $product_id");
$template_uri = get_template_directory_uri();
$image_gallery = <<<EOL
<link rel="stylesheet" href="{$template_uri}/js/fancybox/jquery.fancybox.css"></link>
<script src="{$template_uri}/js/fancybox/jquery.fancybox.pack.js"></script>

<script>
	$(document).ready(function() {
		$(".productGallery").fancybox({
			fitToView	: true,
			'overlayShow'	: false,
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic'
		});
		
		$(".various").fancybox({
			maxWidth	: 800,
			maxHeight	: 600,
			fitToView	: false,
			width		: '70%',
			height		: '70%',
			autoSize	: false,
			closeClick	: false,
			openEffect	: 'none',
			closeEffect	: 'none'
		});
	});
</script>
<h1>Images</h1>
<div class="row">
EOL;

$video_gallery = <<<EOL
	<h1>Videos</h1>
	<div class="row">
EOL;

$videoCount = 0;
$imageCount = 0;

foreach($gallery_info as $gallery_item){
	if($gallery_item->mil_gallery_type == "image"){
		$image_gallery .= ($imageCount%4==0 && $imageCount != 0) ? '</div><br><div class="row">':'';
		$image_gallery .= '<a class="productGallery" href="'.$gallery_item->mil_gallery_location.'"><img class="img-thumbnail col-lg-3 col-md-3 col-sm-3 col-xs-3" src="'.$gallery_item->mil_gallery_location.'"></a>';
		$imageCount++;
	}else {
		$pattern = '(//www.youtube.com/embed/)';
		$get_link_end = preg_replace($pattern, '', $gallery_item->mil_gallery_location); 
		$video_image = "http://img.youtube.com/vi/".$get_link_end."/3.jpg";
		$video_gallery .= ($videoCount%4==0 && $videoCount != 0)? '</div><div class="row">':'';
		$video_gallery .= '<a class="various fancybox.iframe" href="'.stripslashes ($gallery_item->mil_gallery_location).'"><img class="img-thumbnail col-lg-3 col-md-3 col-sm-3 col-xs-3" src="'.$video_image.'"></a>';
		$videoCount++;
	}
}
$video_gallery .= '</div>';

$image_gallery .=  '</div>	'.$video_gallery;

$product_page_template = str_replace ( '###GALLERY###', $image_gallery, $product_page_template );

$post = array(
		'ID'             => $page_title->ID , //Are you updating an existing post?
		'comment_status' => 'closed', // 'closed' means no comments.
		'post_content'   => stripslashes($product_page_template) , //The full text of the post.
		'post_status'    => 'publish' , //Set the status of the new post.
		'post_title'     => 'Military - '.$product_name, //The title of your post.
		'post_type'      => 'page', //You may want to insert a regular post, page, link, a menu item or some custom post type
		'filter'		 => 'true'
);

wp_insert_post( $post, $wp_error);




$products = $wpdb->get_results("SELECT * FROM wp_dummy_sitemil_product");

$productListNav;
$productPanel;
$counter = 0;

$strNum = array(One, Two, Three, Four, Five, Six, Seven, Eight, Nine, Ten);
foreach($products as $product){
	//$productListNav .= 	'<li><a href="#collapse'.$strNum[$counter].'" data-toggle="collapse" data-parent="#accordion">'.$product->mil_product_name.'</a></li>';
	//$isFirst = ($counter==0)? 'in':'';
	$page = get_page_by_title( 'Military - '.$product->mil_product_name );
	$productPanel .= '<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title"><a href="#collapse'.$strNum[$counter].'" data-toggle="collapse" data-parent="#accordion">'.$product->mil_product_name.'</a></h4>
						</div>
						<div class="panel-collapse collapse in" id="collapse'.$strNum[$counter].'">
							<div class="panel-body">
								<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<img src="'.$product->mil_product_image.'" alt="'.$product->mil_product_name.'" width="100%">
										<p>'.$product->mil_product_desc.'</p>
										<a href="'.$page->guid.'" class="btn btn-danger pull-right">View '.$product->mil_product_name.' Details</a>
									<div class="clear"></div>
								</div>
							</div>
						</div>
					</div>';
	$counter++;
}
$comm_product_template = <<<EOL
<style>
	.panel-body h1 {
		font-size: 1.313em;
		color:#222222;
		padding:10px 0;
		font-weight:bold;
		font-family:arial;
	}
	.panel-body p {
		font-size: .875em;
		color:#333333;
		font-family:arial;
	}
	
	.panel-body li {
		list-style-type:disc;	
	}
</style>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
		<div class="panel-group" id="accordion">
			###PRODUCTPANEL###
		</div>
	</div>
	
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		<div class="black_box">
			<h1>For MORE INFO</h1>
			<a class="btn btn-danger" href="http://www.webtegstage.com/kalmar/request-a-quote/">REQUEST A QUOTE</a>
			</br>
			<h1>OR CALL</h1>
			<h2>800-232-1236</h2>
		</div>
	</div>

</div>
EOL;

$comm_product_template = str_replace ( '###PRODUCTPANEL###', $productPanel, $comm_product_template );
//$comm_product_template = str_replace ( '###NAV###', $productListNav , $comm_product_template );

$post = array(
		'ID'             => 222 , //Are you updating an existing post?
		'comment_status' => 'closed', // 'closed' means no comments.
		'post_content'   => stripslashes($comm_product_template) , //The full text of the post.
		'post_status'    => 'publish' , //Set the status of the new post.
		'post_title'     => 'Military - Products', //The title of your post.
		'post_type'      => 'page', //You may want to insert a regular post, page, link, a menu item or some custom post type
		'filter'		 => 'true'
);

wp_insert_post( $post, $wp_error);
?>