<?php
function admin_register_head() {
	echo "<script src='//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js'></script>";
	//echo "<script src='http://code.jquery.com/jquery-1.9.1.js'></script>";
	echo "<script src='http://code.jquery.com/ui/1.10.3/jquery-ui.js'></script>";
}
add_action ( 'admin_head', 'admin_register_head' );

add_action ( "admin_menu", "milMenus" );
add_action ( "admin_menu", "commMenus" );
function milMenus() {
	add_menu_page ( 'Military', 'Military', 'manage_options', 'militarypage', 'milFeatured', get_theme_root_uri () . '/Kalmar/plugins/icons/mil.png', 6 );
	add_submenu_page ( "militarypage", "militaryindustries", "Featured Video", 0, "mil-industries", "milFeatured" );
	add_submenu_page ( "militarypage", "militaryproducts", "Products", 0, "mil-products", "militaryProduct" );
	add_submenu_page ( "militarypage", "militarysupport", "Support / Services", 0, "mil-support-services", "milSupport" );
	add_submenu_page ( "militarypage", "militaryDealers", "Dealers", 0, "mil-dealers", "milDealers" );
	add_submenu_page ( "militarypage", "militarycontact", "Contact", 0, "mil-contact", "milContact" );
	add_submenu_page ( "militarypage", "militaryAboutUs", "About Us", 0, "mil-about-us", "milAboutUs" );
	add_submenu_page ( "militarypage", "militarylocations", "Locations", 0, "mil-locations", "milLocations" );
	add_submenu_page ( "militarypage", "militarycareers", "Careers", 0, "mil-careers", "milCareers" );
}
function commMenus() {
	add_menu_page ( 'custom menu title2', 'Commercial', 'manage_options', 'commercialpage', 'commercialFeatured', get_theme_root_uri () . '/Kalmar/plugins/icons/comm.png', 7 );
	add_submenu_page ( "commercialpage", "commercialfeatured", "Featured Video", 0, "comm-featured", "commercialFeatured" );
	add_submenu_page ( "commercialpage", "commercialproducts", "Products", 0, "comm-products", "commercialProduct" );
	add_submenu_page ( "commercialpage", "commercialsupport", "Support / Services", 0, "comm-support-services", "commercialSupport" );
	add_submenu_page ( "commercialpage", "commercialIndustries", "Industries", 0, "com-industries", "commercialIndustries" );
	add_submenu_page ( "commercialpage", "commercialDealers", "Dealers", 0, "com-dealers", "commercialDealers" );
	add_submenu_page ( "commercialpage", "commercialContact", "Contact", 0, "com-contact", "commercialContact" );
	add_submenu_page ( "commercialpage", "commercialAboutUs", "About Us", 0, "com-about-us", "commercialAboutUs" );
	add_submenu_page ( "commercialpage", "commercialLoctions", "Locations", 0, "com-locations", "commercialLocations" );
	add_submenu_page ( "commercialpage", "commercialCareers", "Careers", 0, "com-careers", "commercialCareers" );
}

/*
 * Add military Home Form #########################################################################################
 */
function military() {
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
	} else {
		require_once (get_theme_root () . '/Kalmar/plugins/military.php');
	}
}

/*
 * Add military Products #########################################################################################
 */
function militaryProduct() {
	// echo get_theme_root().'/plugins/mil_products.php';
	Require_once (get_theme_root () . '/Kalmar/plugins/core/theme_classes_init.php');
	
	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	echo "<script src='http://code.jquery.com/jquery-1.9.1.js'></script>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
		// ############PRODUCT INPUTS############
		$errors = array ();
		$clean_products_array = array ();
		$clean_attributes_array = array ();
		$clean_specs_array = array ();
		$clean_gallery_array = array ();
		
		// Product
		if (isset ( $_POST ['mil_product_name'] ) && ! empty ( $_POST ['mil_product_name'] ) && isset ( $_POST ['mil_product_desc'] ) && ! empty ( $_POST ['mil_product_desc'] ) && isset ( $_FILES ['mil_product_image'] ) && ! empty ( $_FILES ['mil_product_image'] )) {
			
			$validProductText = new ValidFluent ( $_POST );
			
			$validProductText->name ( 'mil_product_name' )->required ()->maxSize ( pow ( 2, 24 ) - 1 );
			$validProductText->name ( 'mil_product_desc' )->required ()->maxSize ( pow ( 2, 24 ) - 1 );
			
			if ($validProductText->isGroupValid ()) {
				$clean_products_array ['name'] = $validProductText->getValue ( 'mil_product_name' );
				$clean_products_array ['description'] = $validProductText->getValue ( 'mil_product_desc' );
				$allowedExts = array (
						"gif",
						"jpeg",
						"jpg",
						"png" 
				);
				$temp = explode ( ".", $_FILES ["mil_product_image"] ["name"] );
				$extension = end ( $temp );
				if ((($_FILES ["mil_product_image"] ["type"] == "image/gif") || ($_FILES ["mil_product_image"] ["type"] == "image/jpeg") || ($_FILES ["mil_product_image"] ["type"] == "image/jpg") || ($_FILES ["mil_product_image"] ["type"] == "image/pjpeg") || ($_FILES ["mil_product_image"] ["type"] == "image/x-png") || ($_FILES ["mil_product_image"] ["type"] == "image/png")) && ($_FILES ["mil_product_image"] ["size"] < 4 * 1048576) && in_array ( $extension, $allowedExts )) {
					if ($_FILES ["mil_product_image"] ["error"] > 0) {
						echo "Return Code: " . $_FILES ["mil_product_image"] ["error"] . "<br>";
					} else {
						$product_image_name = time () . '.' . $extension;
						// echo "Upload: " . $_FILES ["mil_product_image"] ["name"] . "<br>";
						// echo "Type: " . $_FILES ["mil_product_image"] ["type"] . "<br>";
						// echo "Size: " . ($_FILES ["mil_product_image"] ["size"] / 1048576) . " mb<br>";
						// echo "Temp file: " . $_FILES ["mil_product_image"] ["tmp_name"] . "<br>";
						
						if (file_exists ( get_theme_root () . "/Kalmar/images/product_images/" . $product_image_name )) {
							echo $product_image_name . " already exists. ";
						} else {
							
							move_uploaded_file ( $_FILES ["mil_product_image"] ["tmp_name"], get_theme_root () . "/Kalmar/images/product_images/" . $product_image_name );
							$clean_products_array ['image_location'] = get_theme_root () . "/Kalmar/images/product_images/" . $product_image_name;
							require_once (get_theme_root_uri () . '/Kalmar/plugins/classes/Product.class.php');
							try {
								
								$name = $clean_products_array ['name'];
								$image_location = $clean_products_array ['image_location'];
								$description = $clean_products_array ['description'];
								global $product_id;
								$product_id = Product::addProduct ( $name, $image_location, $description, true );
								
								global $wpdb;
								$productInsertionCheck = $wpdb->get_results ( "SELECT COUNT(mil_product_id) FROM " . $wpdb->prefix . "mil_product WHERE mil_product_id = " . $product_id . " && mil_product_name = " . $name );
								
								if (empty ( $productInsertionCheck ) || $product_id != - 1) {
									echo '<div class="alert alert-success">You Product was added</div>';
									/*
									 * ############Features INPUTS############ name: image: Description:
									 */
									require_once (get_theme_root () . '/Kalmar/plugins/classes/Features.class.php');
									$features_count = ( int ) $_POST ['mil_features_count'];
									$features_inputs = new ValidFluent ( $_POST );
									while ( $features_count > 0 ) {
										
										$title;
										$image;
										$bullets;
										
										$features_inputs->name ( 'mil_feature_title' . $features_count )->alfaNum ()->maxSize ( pow ( 2, 24 ) - 1 );
										$features_inputs->name ( 'mil_feature_bullets' . $features_count )->alfanum ()->maxSize ( pow ( 2, 24 ) - 1 );
										
										if ($features_inputs->isGroupValid ()) {
											$title = $features_inputs->getValue ( 'mil_feature_title' . $features_count );
											$bullets = $features_inputs->getValue ( 'mil_feature_bullets' . $features_count );
											
											$allowedExts = array (
													"gif",
													"jpeg",
													"jpg",
													"png" 
											);
											$temp = explode ( ".", $_FILES ['mil_feature_image' . $features_count] ["name"] );
											$extension = end ( $temp );
											if ((($_FILES ['mil_feature_image' . $features_count] ["type"] == "image/gif") || ($_FILES ['mil_feature_image' . $features_count] ["type"] == "image/jpeg") || ($_FILES ["mil_feature_image" . $features_count] ["type"] == "image/jpg") || ($_FILES ["mil_feature_image" . $features_count] ["type"] == "image/pjpeg") || ($_FILES ["mil_feature_image" . $features_count] ["type"] == "image/x-png") || ($_FILES ["mil_feature_image" . $features_count] ["type"] == "image/png")) && ($_FILES ["mil_feature_image" . $features_count] ["size"] < 4 * 1048576) && in_array ( $extension, $allowedExts )) {
												if ($_FILES ["mil_feature_image" . $features_count] ["error"] > 0) {
													echo "<div class='alert alert-danger'>" . $_FILES ["mil_feature_image" . $features_count] ["error"] . "</div><br>";
												} else {
													
													if (! file_exists ( get_theme_root () . "/Kalmar/images/featured_images/" . $_FILES ['mil_featured_image' . $features_count] ["name"] )) {
														move_uploaded_file ( $_FILES ["mil_featured_image"] ["tmp_name"], get_theme_root () . "/Kalmar/images/featured_images/" . $_FILES ["mil_featured_image" . $features_count] ["name"] );
														$imageLocation = get_theme_root_uri () . "/Kalmar/images/featured_images/" . $_FILES ["mil_featured_image" . $features_count] ["name"];
													}
												}
											} else {
												echo "<div class='alert alert-danger'>Invalid file</div>";
											}
											Features::addfeature ( $title, $imageLocation, $bullets, $product_id );
										} else {
											echo '<div class="alert alert-danger">Unable to add Feature!</div>';
										}
										$features_count --;
									}
									
									/*
									 * ############PRODUCT INPUTS############ name: image: Description:
									 */
									// get features inputs
									$specifications_inputs = new ValidFluent ( $_POST );
									
									// Engine
									$specifications_inputs->name ( 'mil_engine_make' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_engine_model' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_engine_cylinders' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_engine_power' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_engine_displacement' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_engine_cooling' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_engine_fuel' )->maxSize ( pow ( 2, 24 ) - 1 );
									// Performance
									$specifications_inputs->name ( 'mil_performance_speedLaden' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_performance_speedReverse' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_performance_gradeability' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_performance_unladen' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_performance_laden' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_performance_fordingDepth' )->maxSize ( pow ( 2, 24 ) - 1 );
									// Transmission
									$specifications_inputs->name ( 'mil_transmission_make' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_transmission_model' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_transmission_type' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_transmission_gears' )->maxSize ( pow ( 2, 24 ) - 1 );
									// Weight
									$specifications_inputs->name ( 'mil_weight_curb' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_weight_frontAxelWeight' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_weight_rearAxelWeight' )->maxSize ( pow ( 2, 24 ) - 1 );
									// Axel
									$specifications_inputs->name ( 'mil_axel_make' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_axel_model' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_axel_frontModel' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_axel_rearModel' )->maxSize ( pow ( 2, 24 ) - 1 );
									// Service
									$specifications_inputs->name ( 'mil_service_fuel' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_service_hydraulic' )->maxSize ( pow ( 2, 24 ) - 1 );
									// Tires
									$specifications_inputs->name ( 'mil_tire_size' )->maxSize ( pow ( 2, 24 ) - 1 );
									// Brakes
									$specifications_inputs->name ( 'mil_brake_seervice' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_brake_service' )->maxSize ( pow ( 2, 24 ) - 1 );
									// Other
									$specifications_inputs->name ( 'mil_electrical_system' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'mil_alternator' )->maxSize ( pow ( 2, 24 ) - 1 );
									
									global $product_id;
									
									// Spec Sheet
									if ($specifications_inputs->isGroupValid () && ! empty ( $product_id )) {
										// Engine
										
										$clean_specs_array ['mil_engine_make'] = $specifications_inputs->getValue ( 'mil_engine_make' );
										$clean_specs_array ['mil_engine_model'] = $specifications_inputs->getValue ( 'mil_engine_model' );
										$clean_specs_array ['mil_engine_cylinders'] = $specifications_inputs->getValue ( 'mil_engine_cylinders' );
										$clean_specs_array ['mil_engine_power'] = $specifications_inputs->getValue ( 'mil_engine_power' );
										$clean_specs_array ['mil_engine_displacement'] = $specifications_inputs->getValue ( 'mil_engine_displacement' );
										$clean_specs_array ['mil_engine_cooling'] = $specifications_inputs->getValue ( 'mil_engine_cooling' );
										$clean_specs_array ['mil_engine_fuel'] = $specifications_inputs->getValue ( 'mil_engine_fuel' );
										// Performance
										$clean_specs_array ['mil_performance_speedUnladen'] = $specifications_inputs->getValue ( 'mil_performance_speedUnladen' );
										$clean_specs_array ['mil_performance_speedLaden'] = $specifications_inputs->getValue ( 'mil_performance_speedLaden' );
										$clean_specs_array ['mil_performance_speedReverse'] = $specifications_inputs->getValue ( 'mil_performance_speedReverse' );
										$clean_specs_array ['mil_performance_gradeability'] = $specifications_inputs->getValue ( 'mil_performance_gradeability' );
										$clean_specs_array ['mil_performance_unladen'] = $specifications_inputs->getValue ( 'mil_performance_unladen' );
										$clean_specs_array ['mil_performance_laden'] = $specifications_inputs->getValue ( 'mil_performance_laden' );
										$clean_specs_array ['mil_performance_fordingDepth'] = $specifications_inputs->getValue ( 'mil_performance_fordingDepth' );
										// Transmission
										$clean_specs_array ['mil_transmission_make'] = $specifications_inputs->getValue ( 'mil_trasmission_make' );
										$clean_specs_array ['mil_transmission_model'] = $specifications_inputs->getValue ( 'mil_transmission_model' );
										$clean_specs_array ['mil_transmission_type'] = $specifications_inputs->getValue ( 'mil_transmission_type' );
										$clean_specs_array ['mil_transmission_gears'] = $specifications_inputs->getValue ( 'mil_transmission_gears' );
										// weight
										$clean_specs_array ['mil_weight_curb'] = $specifications_inputs->getValue ( 'mil_weight_curb' );
										$clean_specs_array ['mil_weight_frontAxelWeight'] = $specifications_inputs->getValue ( 'mil_weight_frontAxelWeight' );
										$clean_specs_array ['mil_weight_rearAxelWeight'] = $specifications_inputs->getValue ( 'mil_weight_rearAxelWeight' );
										// Axel
										$clean_specs_array ['mil_axel_make'] = $specifications_inputs->getValue ( 'mil_axel_make' );
										$clean_specs_array ['mil_axel_model'] = $specifications_inputs->getValue ( 'mil_axel_model' );
										$clean_specs_array ['mil_axel_model'] = $specifications_inputs->getValue ( 'mil_axel_frontModel' );
										$clean_specs_array ['mil_axel_frontModel'] = $specifications_inputs->getValue ( 'mil_axel_frontModel' );
										$clean_specs_array ['mil_axel_rearModel'] = $specifications_inputs->getValue ( 'mil_axel_rearModel' );
										// Service
										$clean_specs_array ['mil_service_fuel'] = $specifications_inputs->getValue ( 'mil_service_fuel' );
										$clean_specs_array ['mil_service_hydraulic'] = $specifications_inputs->getValue ( 'mil_service_hydraulic' );
										// Tires
										$clean_specs_array ['mil_tire_size'] = $specifications_inputs->getValue ( 'mil_tire_size' );
										// Brakes
										$clean_specs_array ['mil_brake_service'] = $specifications_inputs->getValue ( 'mil_brake_service' );
										$clean_specs_array ['mil_brake_parking'] = $specifications_inputs->getValue ( 'mil_brake_parking' );
										// Other
										$clean_specs_array ['mil_electrical_system'] = $specifications_inputs->getValue ( 'mil_electrical_system' );
										$clean_specs_array ['mil_alternator'] = $specifications_inputs->getValue ( 'mil_alternator' );
										
										$clean_specs_array ['mil_product_id'] = $product_id;
										
										echo $_FILES ['mil_spec_sheet'] ['type'];
										
										if (! empty ( $_FILES ['mil_spec_sheet'] )) {
											$specSheetAllowed = array (
													'pdf' 
											);
											$specSheetTemp = explode ( ".", $_FILES ["mil_spec_sheet"] ["name"] );
											$specSheetExtension = end ( $specSheetTemp );
											if (in_array ( $specSheetExtension, $specSheetAllowed )) {
												
												// ###############Add code to save spec sheet################
												$spec_sheet_name = time () . '.pdf';
												move_uploaded_file ( $_FILES ["mil_spec_sheet"] ["tmp_name"], get_theme_root () . "/Kalmar/plugins/spec_Sheets/" . $spec_sheet_name );
												$clean_specs_array ['mil_spec_sheet'] = get_theme_root_uri () . "/Kalmar/plugins/spec_Sheets/" . $spec_sheet_name;
											} else {
												if ($_FILES ['mil_spec_sheet'] ['error'] != 4) {
													echo '<div class="alert alert-danger">Spec Sheet must be in PDF format</div>';
												} else {
													echo '<div class="alert alert-warning">A Problem occured with the Spec Sheet!</div>';
												}
											}
										}
										
										// Add Specs to specs database
										require_once (get_theme_root () . '/Kalmar/plugins/classes/Specifications.class.php');
										$clean_specs_array = array_filter ( $clean_specs_array );
										Specifications::addSpecifications ( $clean_specs_array );
										
										/*
										 * ############Gallery INPUTS############ name: image: Description:
										 */
										$videoCount = $_POST ['mil_image_count'];
										$imageCount = $_POST ['mil_video_count'];
										require_once (get_theme_root () . '/Kalmar/plugins/classes/Gallery.class.php');
										
										/*
										 * ############Youtube Videos############
										 */
										
										while ( $videoCount > 0 ) {
											$type = 'video';
											if (! empty ( $_POST ['gallery_video_' . $videoCount] )) {
												
												$location = $_POST ['gallery_video_' . $videoCount];
												
												Gallery::addToGallery ( $type, $location, $product_id );
											}
											$videoCount --;
										}
										
										/*
										 * ############Youtube Gallery############
										 */
										while ( $imageCount > 0 ) {
											$type = 'image';
											$location;
											$allowedExts = array (
													"gif",
													"jpeg",
													"jpg",
													"png" 
											);
											$temp = explode ( ".", $_FILES ['gallery_image_' . $imageCount] ["name"] );
											$extension = end ( $temp );
											if ((($_FILES ['gallery_image_' . $imageCount] ["type"] == "image/gif") || ($_FILES ['gallery_image_' . $imageCount] ["type"] == "image/jpeg") || ($_FILES ["gallery_image_" . $imageCount] ["type"] == "image/jpg") || ($_FILES ["gallery_image_" . $imageCount] ["type"] == "image/pjpeg") || ($_FILES ["gallery_image_" . $imageCount] ["type"] == "image/x-png") || ($_FILES ["gallery_image_" . $imageCount] ["type"] == "image/png")) && ($_FILES ["gallery_image_" . $imageCount] ["size"] < 4 * 1048576) && in_array ( $extension, $allowedExts )) {
												if ($_FILES ["gallery_image_" . $imageCount] ["error"] > 0) {
													echo "<div class='alert alert-danger'>" . $_FILES ["gallery_image_" . $imageCount] ["error"] . "</div><br>";
												} else {
													
													if (! file_exists ( get_theme_root () . "/Kalmar/images/features_images/" . $_FILES ['gallery_image_' . $imageCount] ["name"] )) {
														move_uploaded_file ( $_FILES ['gallery_image_' . $imageCount] ["tmp_name"], get_theme_root () . "/Kalmar/images/gallery_images/" . $_FILES ['gallery_image_' . $imageCount] ["name"] );
														$location = get_theme_root_uri () . "/Kalmar/images/gallery_images/" . $_FILES ["mil_featured_image" . $imageCount] ["name"];
													}
												}
											} else {
												echo "<div class='alert alert-danger'>Invalid file</div>";
											}
											Gallery::addToGallery ( $type, $location, $product_id );
											$imageCount --;
										}
									} else {
										echo '<div class="alert alert-danger">Error with your specifications</div>';
									}
								} 								// product was inserted
								else {
									echo 'No product created, please created a product';
								} // product wasn't inserted
							} catch ( Exception $e ) {
								echo $e->getMessage ();
							}
						}
					}
				} else {
					echo "<div class='alert alert-danger'>Please Enter all Required Fields!</div></br>";
				}
			} else {
				if (! $validProductText->isValid ( 'mil_product_name' )) {
					echo '<div class="alert alert-danger" id="productNameError">' . $validProductText->getError ( 'mil_product_name' ) . '</div>';
				}
				if (! $validProductText->isValid ( 'mil_product_desc' )) {
					echo '<div class="alert alert-danger" id="productDescError">' . $validProductText->getError ( 'mil_product_desc' ) . '</div>';
				}
			}
		}
		$product_page_template = <<<EOL
<style>
	.panel-body h1 {
		font-size: 1.313em;
		color:#222222;
		padding:10px 0;
		font-weight:bold;
		font-facommy:arial;
	}
	.panel-body p {
		font-size: .875em;
		color:#333333;
		font-facommy:arial;
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
				<li><a href="###SPECSHEETURL###" data-toggle="collapse"
					data-parent="#accordion">Spec Sheet</a></li>
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
$product_info = $wpdb->get_results("SELECT * FROM wp_dummy_sitecomm_product WHERE comm_product_id = $product_id");
$product_name = $product_info[0]->comm_product_name;
$product_desc = $product_info[0]->comm_product_desc;
$product_image = $product_info[0]->comm_product_image;

$product_template = <<<EOL
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<img src="{$product_image}" alt="{$product_name}" width="100%" >
		<h1>{$product_name}</h1>
		<p>{$product_desc}</p>
	</div>
EOL;



//Put title of product in first accordian
$product_page_template = str_replace ( '###PRODUCTTITLE###', $product_name, $product_page_template );
$product_page_template = str_replace ( '###Product###', $product_template, $product_page_template );


//FEATURES
$features_info = $wpdb->get_results("SELECT * FROM wp_dummy_sitecomm_feature WHERE comm_product_id = $product_id");
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
	$lines = explode(PHP_EOL, $feature_info->comm_feature_bullets);
	$str;
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
	$this_template = str_replace ( '###FEATUREIMAGE###', $feature_info->comm_feature_image, $this_template );
	$this_template = str_replace ( '###FEATURETITLE###', $feature_info->comm_feature_title, $this_template );
	$all_features .= $this_template;
}

$product_page_template = str_replace ( '###FEATURES###', $all_features, $product_page_template );

//SPECS
$specs_info = $wpdb->get_results("SELECT * FROM wp_dummy_sitecomm_specs WHERE comm_product_id = $product_id");

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
			<td>{$specs_info[0]->comm_engine_make}</td>
		</tr>
		<tr>
			<td>Model</td>
			<td>{$specs_info[0]->comm_engine_model}</td>
		</tr>
		<tr>
			<td>Cylinders</td>
			<td>{$specs_info[0]->comm_engine_cylinders}</td>
		</tr>
		<tr>
			<td>Power</td>
			<td>{$specs_info[0]->comm_engine_power}</td>
		</tr>
		<tr>
			<td>Displacement</td>
			<td>{$specs_info[0]->comm_engine_displacement}</td>
		</tr>
		<tr>
			<td>Cooling</td>
			<td>{$specs_info[0]->comm_engine_cooling}</td>
		</tr>
		<tr>
			<td>Fuel</td>
			<td>{$specs_info[0]->comm_engine_power}</td>
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
			<td>{$specs_info[0]->comm_performance_speedUnladen}</td>
		</tr>
		<tr>
			<td>Speed Laden</td>
			<td>{$specs_info[0]->comm_performance_laden}</td>
		</tr>
		<tr>
			<td>Speed Reverse</td>
			<td>{$specs_info[0]->comm_performance_speedReverse}</td>
		</tr>
		<tr>
			<td>Gradeability</td>
			<td>{$specs_info[0]->comm_performance_gradeability}</td>
		</tr>
		<tr>
			<td>Unladen</td>
			<td>{$specs_info[0]->comm_performance_unladen}</td>
		</tr>
		<tr>
			<td>Laden</td>
			<td>{$specs_info[0]->comm_performance_laden}</td>
		</tr>
		<tr>
			<td>Fording Depth</td>
			<td>{$specs_info[0]->comm_performance_fordingDepth}</td>
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
			<td>{$specs_info[0]->comm_trasnmission_make}</td>
		</tr>
		<tr>
			<td>Model</td>
			<td>{$specs_info[0]->comm_transmission_model}</td>
		</tr>
		<tr>
			<td>Type</td>
			<td>{$specs_info[0]->comm_transmisssion_type}</td>
		</tr>
		<tr>
			<td>Gears</td>
			<td>{$specs_info[0]->comm_transmission_gears}</td>
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
			<td>{$specs_info[0]->comm_weight_curb}</td>
		</tr>
		<tr>
			<td>Front Axel Weight</td>
			<td>{$specs_info[0]->comm_weight_frontAxelWeight}</td>
		</tr>
		<tr>
			<td>Rear Axel Weight</td>
			<td>{$specs_info[0]->comm_weight_rearAxelWeight}</td>
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
			<td>{$specs_info[0]->comm_axel_make}</td>
		</tr>
		<tr>
			<td>Axel Model</td>
			<td>{$specs_info[0]->comm_axel_model}</td>
		</tr>
		<tr>
			<td>Front Axel Model</td>
			<td>{$specs_info[0]->comm_axel_frontModel}</td>
		</tr>
		<tr>
			<td>rear Axel Model</td>
			<td>{$specs_info[0]->comm_axel_rearModel}</td>
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
			<td>{$specs_info[0]->comm_service_fuel}</td>
		</tr>
		<tr>
			<td>Hydraulic</td>
			<td>{$specs_info[0]->comm_service_hydraulic}</td>
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
			<td>{$specs_info[0]->comm_tire_size}</td>
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
			<td>{$specs_info[0]->comm_brake_service}</td>
		</tr>
		<tr>
			<td>Parking</td>
			<td>{$specs_info[0]->comm_brake_parking}</td>
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
			<td>{$specs_info[0]->comm_electrical_system}</td>
		</tr>
		<tr>
			<td>Alternator</td>
			<td>{$specs_info[0]->comm_alternator}</td>
		</tr>
	</table>
</div>
EOL;
$all_specs = $Engine_template.PHP_EOL.$performance_template.PHP_EOL.$transmission_template.PHP_EOL.$weight_template.PHP_EOL.$axel_template.PHP_EOL.$service_template.PHP_EOL.$tire_template.PHP_EOL.$brake_template.PHP_EOL.$additional_template;
$product_page_template = str_replace ( '###SPECSHEETURL###', $specs_info[0]->comm_spec_sheet, $product_page_template );
$product_page_template = str_replace ( '###SPECIFICATIONS###', $all_specs, $product_page_template );



//GALLERY
$gallery_info = $wpdb->get_results("SELECT * FROM wp_dummy_sitecomm_gallery WHERE comm_product_id = $product_id");
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
<div class="row">
<h1>Images</h1>
EOL;

$video_gallery = <<<EOL
	<div class="row">
	<h1>Videos</h1>
EOL;

foreach($gallery_info as $gallery_item){
	
	if($gallery_item->comm_gallery_type == "image"){
		$image_gallery .= '<a class="productGallery" href="'.$gallery_item->comm_gallery_location.'"><img class=" col-lg-3 col-md-3 col-sm-3 col-xs-3" src="'.$gallery_item->comm_gallery_location.'"></a>';
	}else {
		$pattern = '(//www.youtube.com/embed/)';
		$get_link_end = preg_replace($pattern, '', $gallery_item->comm_gallery_location); 
		$video_image = "http://img.youtube.com/vi/".$get_link_end."/3.jpg";
		$video_gallery .= '<a class="various fancybox.iframe" href="'.stripslashes ($gallery_item->comm_gallery_location).'"><img class="col-lg-4 col-md-4 col-sm-4 col-xs-4" src="'.$video_image.'"></a>';
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
		'post_title'     => 'Commercial - '.$product_name, //The title of your post.
		'post_type'      => 'page', //You may want to insert a regular post, page, link, a menu item or some custom post type
		'filter'		 => 'true'
);

wp_insert_post( $post, $wp_error);

$wpdb->last_error;


$products = $wpdb->get_results("SELECT * FROM wp_dummy_sitecomm_product");

$productListNav;
$productPanel;
$counter = 0;

$strNum = array(One, Two, Three, Four, Five, Six, Seven, Eight, Nine, Ten);
foreach($products as $product){
	$productListNav .= 	'<li><a href="#collapse'.$strNum[$counter].'" data-toggle="collapse" data-parent="#accordion">'.$product->comm_product_name.'</a></li>';
	$isFirst = ($counter==0)? 'in':'';
	$productPanel .= '<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title"><a href="#collapse'.$strNum[$counter].'" data-toggle="collapse" data-parent="#accordion">'.$product->comm_product_name.'</a></h4>
						</div>
						<div class="panel-collapse collapse '.$isFirst.'" id="collapse'.$strNum[$counter].'">
							<div class="panel-body">
								<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<img src="'.$product->comm_product_image.'" alt="'.$product->comm_product_name.'" width="100%">
										<h1>'.$product->comm_product_name.'</h1>
										<p>'.$product->comm_product_desc.'</p>
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
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		<div class="red_box">
			<ul>
				###NAV###
			</ul>
		</div>
		<div class="black_box">
			<h1>For MORE INFO</h1>
			<a class="btn btn-danger" href="http://www.webtegstage.com/kalmar/request-a-quote/">REQUEST A QUOTE</a>
			</br>
			<h1>OR CALL</h1>
			<h2>800-232-1236</h2>
		</div>
	</div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
		<div class="panel-group" id="accordion">
			###PRODUCTPANEL###
		</div>
	</div>
</div>
EOL;

$comm_product_template = str_replace ( '###PRODUCTPANEL###', $productPanel, $comm_product_template );
$comm_product_template = str_replace ( '###NAV###', $productListNav , $comm_product_template );

$post = array(
		'ID'             => 123 , //Are you updating an existing post?
		'comment_status' => 'closed', // 'closed' means no comments.
		'post_content'   => stripslashes($comm_product_template) , //The full text of the post.
		'post_status'    => 'publish' , //Set the status of the new post.
		'post_title'     => 'Commercial Products', //The title of your post.
		'post_type'      => 'page', //You may want to insert a regular post, page, link, a menu item or some custom post type
		'filter'		 => 'true'
);

wp_insert_post( $post, $wp_error);

	}
	require_once (get_theme_root () . '/Kalmar/plugins/mil_products.php');
}

/*
 * Military Support/Services #########################################################################################
 */
function milSupport() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
		
		global $wpdb;
		$post_keys = array_keys ( $_POST );
		foreach ( $post_keys as $postkey ) {
			//echo $postkey;
			switch($postkey){
				case(mil_manuals_desc):
					$data = stripslashes ($_POST['mil_manuals_desc']);
					$wpdb->update('wp_dummy_sitesupportServices',array('support_manuals'=>$data), array('support_id' => 1));
					echo '<div class="alert alert-success">Military manual section has been updated</div>';
					break;
				case(mil_parts_desc):
					$data = stripslashes ($_POST['mil_parts_desc']);
					$wpdb->update('wp_dummy_sitesupportServices',array('support_parts'=>$data), array('support_id' => 1));
					echo '<div class="alert alert-success">Military parts section has been updated</div>';
					break;
				case(mil_service_desc):
					$data = stripslashes ($_POST['mil_service_desc']);
					$wpdb->update('wp_dummy_sitesupportServices',array('support_service'=>$data), array('support_id' => 1));
					echo '<div class="alert alert-success">Military service section has been updated</div>';
					break;
				case(mil_training_desc):
					$data = stripslashes ($_POST['mil_training_desc']);
					$wpdb->update('wp_dummy_sitesupportServices',array('support_training'=>$data), array('support_id' => 1));
					echo '<div class="alert alert-success">Military training section has been updated</div>';
					break;
				case(mil_warranty_desc):
					$data = stripslashes ($_POST['mil_warranty_desc']);
					$wpdb->update('wp_dummy_sitesupportServices',array('support_warranty'=>$data), array('support_id' => 1));
					echo '<div class="alert alert-success">Military warranty section has been updated</div>';
					break;
				case(mil_sourcing_desc):
					$data = stripslashes ($_POST['mil_sourcing_desc']);
					$wpdb->update('wp_dummy_sitesupportServices',array('support_sourcing'=>$data), array('support_id' => 1));
					echo '<div class="alert alert-success">Military sourcing section has been updated</div>';
					break;	
		}
		
		
		$data = $wpdb->get_results("SELECT support_manuals, support_parts, support_service, support_training, support_warranty, support_sourcing FROM wp_dummy_sitesupportServices WHERE support_id = 1");
		
		$content = <<<EOL
	<div class="row">
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
<div class="green_box">
<ul>
	<li><a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">Manuals</a></li>
	<li><a href="#collapseTwo" data-toggle="collapse" data-parent="#accordion">Parts</a></li>
	<li><a href="#collapseThree" data-toggle="collapse" data-parent="#accordion">Service</a></li>
    <li><a href="#collapseFour" data-toggle="collapse" data-parent="#accordion">Training</a></li>
	<li><a href="#collapseFive" data-toggle="collapse" data-parent="#accordion">Warranty</a></li>
	<li><a href="#collapseSix" data-toggle="collapse" data-parent="#accordion">Sourcing</a></li>
</ul>
</div>
<div class="black_box">
<h1>For MORE INFO</h1>
<a class="btn btn-danger" href="http://www.webtegstage.com/kalmar/request-a-quote/">REQUEST A QUOTE</a>
</br>
OR CALL
<h2>800-232-1236</h2>
</div>
</div>
		
<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
<div class="panel-group" id="accordion">
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">
Manuals
</a></h4>
</div>
<div class="panel-collapse collapse in" id="collapseOne">
<div class="panel-body">
{$data[0]->support_manuals}
</div>
</div>
</div>
		
		
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseTwo" data-toggle="collapse" data-parent="#accordion">
Parts
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseTwo">
<div class="panel-body">
{$data[0]->support_parts}
</div>
</div>
</div>
		
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseThree" data-toggle="collapse" data-parent="#accordion">
Service
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseThree">
<div class="panel-body">
{$data[0]->support_service}
</div>
</div>
</div>
		
		
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseFour" data-toggle="collapse" data-parent="#accordion">
Training
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseFour">
<div class="panel-body">
{$data[0]->support_training}
</div>
</div>
</div>
		
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseFive" data-toggle="collapse" data-parent="#accordion">
Warranty
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseFive">
<div class="panel-body">
{$data[0]->support_warranty}
</div>
</div>
</div>
		

<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseSix" data-toggle="collapse" data-parent="#accordion">
Sourcing
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseSix">
<div class="panel-body">
{$data[0]->support_sourcing}
</div>
</div>
</div>		
</div>
</div>
</div>
EOL;
		
		$post = array(
				'ID'             => 226 , //Are you updating an existing post?
				'comment_status' => 'closed', // 'closed' means no comments.
				'post_content'   => stripslashes($content) , //The full text of the post.
				'post_status'    => 'publish' , //Set the status of the new post.
				'post_title'     => 'Military - Support/Services', //The title of your post.
				'post_type'      => 'page', //You may want to insert a regular post, page, link, a menu item or some custom post type
				'filter'		 => 'true'
		);
		
		wp_insert_post( $post, $wp_error);
		
		echo '<div class="alert alert-success">Military careers page updated!</div>';
	}
	/*
	 * $manuals = $_POST['mil_manuals_desc']; 
	 * $parts = $_POST['mil_parts_desc']; 
	 * $service = $_POST['mil_service_desc']; 
	 * $training = $_POST['mil_training_desc']; 
	 * $warranty = $_POST['mil_warranty_desc']; 
	 * $sourcing = $_POST['mil_sourcing_desc']; 
	 * $wpdb->update('wp_dummy_sitesupportServices',array('support_manuals'=>$manuals,'support_parts'=>$parts,'support_service' => $service, 'support_training' => $training, 'support_warranty' => $warranty, 'support_sourcing' = $sourcing),array('support_id' => 1)); 
	 * var_dump($wpdb->last_error); 
	 * echo '<div class="alert alert-success">Military Featured Video has been updated</div>';
	 */
} 
		require_once (get_theme_root () . '/Kalmar/plugins/mil_support.php');
}

/*
 * Military Dealers #########################################################################################
 */
function milDealers() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
		$content = $_POST['mil_dealer_page'];
		
		
		$post = array(
				'ID'             => 307 , //Are you updating an existing post?
				'comment_status' => 'closed', // 'closed' means no comments.
				'post_content'   => $content , //The full text of the post.
				'post_status'    => 'publish' , //Set the status of the new post.
				'post_title'     => 'Military - Dealers', //The title of your post.
				'post_type'      => 'page' //You may want to insert a regular post, page, link, a menu item or some custom post type
		);
		
		wp_insert_post( $post, $wp_error);
		
		echo '<div class="alert alert-success">Military dealerx	 page updated</div>';
	} 
		require_once (get_theme_root () . '/Kalmar/plugins/mil_dealers.php');
}

/*
 * Military Contact #########################################################################################
 */
function milContact() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
		
		$content = $_POST['mil_contact_page'];
		
		
		$post = array(
				'ID'             => 265 , //Are you updating an existing post?
				'comment_status' => 'closed', // 'closed' means no comments.
				'post_content'   => $content , //The full text of the post.
				'post_status'    => 'publish' , //Set the status of the new post.
				'post_title'     => 'Military - Contact', //The title of your post.
				'post_type'      => 'page' //You may want to insert a regular post, page, link, a menu item or some custom post type
		);
		
		wp_insert_post( $post, $wp_error);

		echo '<div class="alert alert-success">Military contact page updated</div>';
		
	} 
		require_once (get_theme_root () . '/Kalmar/plugins/mil_contact.php');
}

/*
 * Military About Us #########################################################################################
 */
function milAboutUs() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
		
		$content = $_POST['mil_aboutus_page'];
		
		
		$post = array(
				'ID'             => 267 , //Are you updating an existing post?
				'comment_status' => 'closed', // 'closed' means no comments.
				'post_content'   => $content , //The full text of the post.
				'post_status'    => 'publish' , //Set the status of the new post.
				'post_title'     => 'Military - About Us', //The title of your post.
				'post_type'      => 'page' //You may want to insert a regular post, page, link, a menu item or some custom post type
		);
		
		wp_insert_post( $post, $wp_error);
		
		echo '<div class="alert alert-success">Military about us page updated</div>';
		
	} 
		require_once (get_theme_root () . '/Kalmar/plugins/mil_aboutUs.php');
}

/*
 * Military Featured Video #########################################################################################
 */
function milFeatured() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
		
		global $wpdb;
		$video = $_POST ['mil_feature_video'];
		$title = $_POST ['mil_feature_title'];
		$desc = $_POST ['mil_video_desc'];
		
		$wpdb->update ( 'wp_dummy_sitefeaturedVideopages', array (
				'featured_video' => $video,
				'featured_title' => $title,
				'featured_text' => $desc 
		), array (
				'featured_id' => 1 
		) );
		
		echo '<div class="alert alert-success">Military Featured Video has been updated</div>';
	}
	require_once (get_theme_root () . '/Kalmar/plugins/mil_featured_video.php');
}

/*
 * Military Careers #########################################################################################
 */
function milCareers() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
		
		$introduction 	= stripslashes($_POST['mil_careers_introduction']);
		$benefits 		= stripslashes($_POST['mil_careers_benefits']);
		$oppurtunities  = stripslashes($_POST['mil_careers_jobOppurtunities']);
		$smallBussiness = stripslashes($_POST['mil_careers_smallBusiness']);
		
		global $wpdb;
		$wpdb->update('wp_dummy_sitecareers',array('careers_introduction' => $introduction, 'careers_benefits' => $benefits, 'careers_jobOppurtunities' => $oppurtunities, 'careers_smallBusiness' => $smallBussiness),array('careers_id' => 1));
		//echo $wpdb->last_error;
		
		$content = <<<EOL
	<div class="row">
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
<div class="red_box">
<ul>
	<li><a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">Introduction</a></li>
	<li><a href="#collapseTwo" data-toggle="collapse" data-parent="#accordion">Benefits</a></li>
	<li><a href="#collapseThree" data-toggle="collapse" data-parent="#accordion">Job Oppurtunities</a></li>
    <li><a href="#collapseFour" data-toggle="collapse" data-parent="#accordion">Small Business</a></li>
</ul>
</div>
<div class="black_box">
<h1>For MORE INFO</h1>
<a class="btn btn-danger" href="http://www.webtegstage.com/kalmar/request-a-quote/">REQUEST A QUOTE</a>
</br>
<h1>OR CALL</h1>
<h2>800-232-1236</h2>
</div>
</div>

<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
<div class="panel-group" id="accordion">
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">
Introduction
</a></h4>
</div>
<div class="panel-collapse collapse in" id="collapseOne">
<div class="panel-body">
{$introduction}
</div>
</div>
</div>


<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseTwo" data-toggle="collapse" data-parent="#accordion">
Benefits
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseTwo">
<div class="panel-body">
		{$benefits}
</div>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseThree" data-toggle="collapse" data-parent="#accordion">
Job Oppurtunities
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseThree">
<div class="panel-body">
{$oppurtunities}
</div>
</div>
</div>


<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseFour" data-toggle="collapse" data-parent="#accordion">
Small Business
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseFour">
<div class="panel-body">
{$smallBussiness}
</div>
</div>
</div>

</div>
</div>
</div>
EOL;
		
		$post = array(
				'ID'             => 271 , //Are you updating an existing post?
				'comment_status' => 'closed', // 'closed' means no comments.
				'post_content'   => stripslashes($content) , //The full text of the post.
				'post_status'    => 'publish' , //Set the status of the new post.
				'post_title'     => 'Military - Careers', //The title of your post.
				'post_type'      => 'page', //You may want to insert a regular post, page, link, a menu item or some custom post type
				'filter'		 => 'true'		
		);
		
		wp_insert_post( $post, $wp_error);
		echo '<div class="alert alert-success">Military careers page updated!</div>';
	} 
		require_once (get_theme_root () . '/Kalmar/plugins/mil_careers.php');
}

/*
 * Military Locations #########################################################################################
 */
function milLocations() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
		
		$content = $_POST['mil_locations_page'];
		
		
		$post = array(
				'ID'             => 269 , //Are you updating an existing post?
				'comment_status' => 'closed', // 'closed' means no comments.
				'post_content'   => $content , //The full text of the post.
				'post_status'    => 'publish' , //Set the status of the new post.
				'post_title'     => 'Military - Locations', //The title of your post.
				'post_type'      => 'page' //You may want to insert a regular post, page, link, a menu item or some custom post type
		);
		
		wp_insert_post( $post, $wp_error);
		
		echo '<div class="alert alert-success">Military locations page updated</div>';
		
	}
		require_once (get_theme_root () . '/Kalmar/plugins/mil_locations.php');
}

/*
 * Commercial Home #########################################################################################
 */
function commercial() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
	} else {
		require_once (get_theme_root () . '/Kalmar/plugins/commercial.php');
	}
}

/*
 * Commercial Featured Video #########################################################################################
 */
function commercialFeatured() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
		
		global $wpdb;
		$video = $_POST ['mil_feature_video'];
		$title = $_POST ['mil_feature_title'];
		$desc = $_POST ['mil_video_desc'];
		
		$wpdb->update ( 'wp_dummy_sitefeaturedVideopages', array (
				'featured_video' => $video,
				'featured_title' => $title,
				'featured_text' => $desc 
		), array (
				'featured_id' => 2
		) );
		
		echo '<div class="alert alert-success">Commercial Featured Video has been updated</div>';
	}
	require_once (get_theme_root () . '/Kalmar/plugins/comm_featured_video.php');
}


/*
 * Add Commercial Products #########################################################################################
 */
function commercialProduct() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	// echo get_theme_root().'/plugins/comm_products.php';
	Require_once (get_theme_root () . '/Kalmar/plugins/core/theme_classes_init.php');
	echo "<script src='http://code.jquery.com/jquery-1.9.1.js'></script>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
		// ############PRODUCT INPUTS############
		$errors = array ();
		$clean_products_array = array ();
		$clean_attributes_array = array ();
		$clean_specs_array = array ();
		$clean_gallery_array = array ();
		
		// Product
		if (isset ( $_POST ['comm_product_name'] ) && ! empty ( $_POST ['comm_product_name'] ) && isset ( $_POST ['comm_product_desc'] ) && ! empty ( $_POST ['comm_product_desc'] ) && isset ( $_FILES ['comm_product_image'] ) && ! empty ( $_FILES ['comm_product_image'] )) {
			
			$validProductText = new ValidFluent ( $_POST );
			
			$validProductText->name ( 'comm_product_name' )->required ()->maxSize ( pow ( 2, 24 ) - 1 );
			$validProductText->name ( 'comm_product_desc' )->required ()->maxSize ( pow ( 2, 24 ) - 1 );
			
			if ($validProductText->isGroupValid ()) {
				$clean_products_array ['name'] = $validProductText->getValue ( 'comm_product_name' );
				$clean_products_array ['description'] = $validProductText->getValue ( 'comm_product_desc' );
				$allowedExts = array (
						"gif",
						"jpeg",
						"jpg",
						"png" 
				);
				$temp = explode ( ".", $_FILES ["comm_product_image"] ["name"] );
				$extension = end ( $temp );
				if ((($_FILES ["comm_product_image"] ["type"] == "image/gif") || ($_FILES ["comm_product_image"] ["type"] == "image/jpeg") || ($_FILES ["comm_product_image"] ["type"] == "image/jpg") || ($_FILES ["comm_product_image"] ["type"] == "image/pjpeg") || ($_FILES ["comm_product_image"] ["type"] == "image/x-png") || ($_FILES ["comm_product_image"] ["type"] == "image/png")) && ($_FILES ["comm_product_image"] ["size"] < 4 * 1048576) && in_array ( $extension, $allowedExts )) {
					if ($_FILES ["comm_product_image"] ["error"] > 0) {
						echo "Return Code: " . $_FILES ["comm_product_image"] ["error"] . "<br>";
					} else {
						$product_image_name = time () . '.' . $extension;
						// echo "Upload: " . $_FILES ["comm_product_image"] ["name"] . "<br>";
						// echo "Type: " . $_FILES ["comm_product_image"] ["type"] . "<br>";
						// echo "Size: " . ($_FILES ["comm_product_image"] ["size"] / 1048576) . " mb<br>";
						// echo "Temp file: " . $_FILES ["comm_product_image"] ["tmp_name"] . "<br>";
						
						if (file_exists ( get_theme_root () . "/Kalmar/images/product_images/" . $product_image_name )) {
							echo $product_image_name . " already exists. ";
						} else {
							
							move_uploaded_file ( $_FILES ["comm_product_image"] ["tmp_name"], get_theme_root () . "/Kalmar/images/product_images/" . $product_image_name );
							$clean_products_array ['image_location'] = get_theme_root () . "/Kalmar/images/product_images/" . $product_image_name;
							require_once (get_theme_root_uri () . '/Kalmar/plugins/classes/Product.class.php');
							try {
								
								$name = $clean_products_array ['name'];
								$image_location = $clean_products_array ['image_location'];
								$description = $clean_products_array ['description'];
								global $product_id;
								$product_id = Product::addCommProduct ( $name, $image_location, $description, true );
								
								global $wpdb;
								$productInsertionCheck = $wpdb->get_results ( "SELECT COUNT(comm_product_id) FROM " . $wpdb->prefix . "comm_product WHEREcomm_product_id = " . $product_id . " &&comm_product_name = " . $name );
								
								if (empty ( $productInsertionCheck ) || $product_id != - 1) {
									echo '<div class="alert alert-success">You Product was added</div>';
									/*
									 * ############Features INPUTS############ name: image: Description:
									 */
									require_once (get_theme_root () . '/Kalmar/plugins/classes/Features.class.php');
									$features_count = ( int ) $_POST ['comm_features_count'];
									$features_inputs = new ValidFluent ( $_POST );
									while ( $features_count > 0 ) {
										
										$title;
										$image;
										$bullets;
										
										$features_inputs->name ( 'comm_feature_title' . $features_count )->alfaNum ()->maxSize ( pow ( 2, 24 ) - 1 );
										$features_inputs->name ( 'comm_feature_bullets' . $features_count )->alfanum ()->maxSize ( pow ( 2, 24 ) - 1 );
										
										if ($features_inputs->isGroupValid ()) {
											$title = $features_inputs->getValue ( 'comm_feature_title' . $features_count );
											$bullets = $features_inputs->getValue ( 'comm_feature_bullets' . $features_count );
											
											$allowedExts = array (
													"gif",
													"jpeg",
													"jpg",
													"png" 
											);
											$temp = explode ( ".", $_FILES ['comm_feature_image' . $features_count] ["name"] );
											$extension = end ( $temp );
											if ((($_FILES ['comm_feature_image' . $features_count] ["type"] == "image/gif") || ($_FILES ['comm_feature_image' . $features_count] ["type"] == "image/jpeg") || ($_FILES ["comm_feature_image" . $features_count] ["type"] == "image/jpg") || ($_FILES ["comm_feature_image" . $features_count] ["type"] == "image/pjpeg") || ($_FILES ["comm_feature_image" . $features_count] ["type"] == "image/x-png") || ($_FILES ["comm_feature_image" . $features_count] ["type"] == "image/png")) && ($_FILES ["comm_feature_image" . $features_count] ["size"] < 4 * 1048576) && in_array ( $extension, $allowedExts )) {
												if ($_FILES ["comm_feature_image" . $features_count] ["error"] > 0) {
													echo "<div class='alert alert-danger'>" . $_FILES ["comm_feature_image" . $features_count] ["error"] . "</div><br>";
												} else {
													
													if (! file_exists ( get_theme_root () . "/Kalmar/images/featured_images/" . $_FILES ['comm_featured_image' . $features_count] ["name"] )) {
														move_uploaded_file ( $_FILES ["comm_featured_image"] ["tmp_name"], get_theme_root () . "/Kalmar/images/featured_images/" . $_FILES ["comm_featured_image" . $features_count] ["name"] );
														$imageLocation = get_theme_root_uri () . "/Kalmar/images/featured_images/" . $_FILES ["comm_featured_image" . $features_count] ["name"];
													}
												}
											} else {
												echo "<div class='alert alert-danger'>Invalid file</div>";
											}
											Features::addCommFeature ( $title, $imageLocation, $bullets, $product_id );
										} else {
											echo '<div class="alert alert-danger">Unable to add Feature!</div>';
										}
										$features_count --;
									}
									
									/*
									 * ############PRODUCT INPUTS############ name: image: Description:
									 */
									// get features inputs
									$specifications_inputs = new ValidFluent ( $_POST );
									
									// Engine
									$specifications_inputs->name ( 'comm_engine_make' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_engine_model' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_engine_cylinders' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_engine_power' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_engine_displacement' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_engine_cooling' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_engine_fuel' )->maxSize ( pow ( 2, 24 ) - 1 );
									// Performance
									$specifications_inputs->name ( 'comm_performance_speedLaden' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_performance_speedReverse' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_performance_gradeability' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_performance_unladen' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_performance_laden' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_performance_fordingDepth' )->maxSize ( pow ( 2, 24 ) - 1 );
									// Transmission
									$specifications_inputs->name ( 'comm_transmission_make' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_transmission_model' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_transmission_type' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_transmission_gears' )->maxSize ( pow ( 2, 24 ) - 1 );
									// Weight
									$specifications_inputs->name ( 'comm_weight_curb' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_weight_frontAxelWeight' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_weight_rearAxelWeight' )->maxSize ( pow ( 2, 24 ) - 1 );
									// Axel
									$specifications_inputs->name ( 'comm_axel_make' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_axel_model' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_axel_frontModel' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_axel_rearModel' )->maxSize ( pow ( 2, 24 ) - 1 );
									// Service
									$specifications_inputs->name ( 'comm_service_fuel' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_service_hydraulic' )->maxSize ( pow ( 2, 24 ) - 1 );
									// Tires
									$specifications_inputs->name ( 'comm_tire_size' )->maxSize ( pow ( 2, 24 ) - 1 );
									// Brakes
									$specifications_inputs->name ( 'comm_brake_seervice' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_brake_service' )->maxSize ( pow ( 2, 24 ) - 1 );
									// Other
									$specifications_inputs->name ( 'comm_electrical_system' )->maxSize ( pow ( 2, 24 ) - 1 );
									$specifications_inputs->name ( 'comm_alternator' )->maxSize ( pow ( 2, 24 ) - 1 );
									
									global $product_id;
									
									// Spec Sheet
									if ($specifications_inputs->isGroupValid () && ! empty ( $product_id )) {
										// Engine
										
										$clean_specs_array ['comm_engine_make'] = $specifications_inputs->getValue ( 'comm_engine_make' );
										$clean_specs_array ['comm_engine_model'] = $specifications_inputs->getValue ( 'comm_engine_model' );
										$clean_specs_array ['comm_engine_cylinders'] = $specifications_inputs->getValue ( 'comm_engine_cylinders' );
										$clean_specs_array ['comm_engine_power'] = $specifications_inputs->getValue ( 'comm_engine_power' );
										$clean_specs_array ['comm_engine_displacement'] = $specifications_inputs->getValue ( 'comm_engine_displacement' );
										$clean_specs_array ['comm_engine_cooling'] = $specifications_inputs->getValue ( 'comm_engine_cooling' );
										$clean_specs_array ['comm_engine_fuel'] = $specifications_inputs->getValue ( 'comm_engine_fuel' );
										// Performance
										$clean_specs_array ['comm_performance_speedUnladen'] = $specifications_inputs->getValue ( 'comm_performance_speedUnladen' );
										$clean_specs_array ['comm_performance_speedLaden'] = $specifications_inputs->getValue ( 'comm_performance_speedLaden' );
										$clean_specs_array ['comm_performance_speedReverse'] = $specifications_inputs->getValue ( 'comm_performance_speedReverse' );
										$clean_specs_array ['comm_performance_gradeability'] = $specifications_inputs->getValue ( 'comm_performance_gradeability' );
										$clean_specs_array ['comm_performance_unladen'] = $specifications_inputs->getValue ( 'comm_performance_unladen' );
										$clean_specs_array ['comm_performance_laden'] = $specifications_inputs->getValue ( 'comm_performance_laden' );
										$clean_specs_array ['comm_performance_fordingDepth'] = $specifications_inputs->getValue ( 'comm_performance_fordingDepth' );
										// Transmission
										$clean_specs_array ['comm_transmission_make'] = $specifications_inputs->getValue ( 'comm_trasmission_make' );
										$clean_specs_array ['comm_transmission_model'] = $specifications_inputs->getValue ( 'comm_transmission_model' );
										$clean_specs_array ['comm_transmission_type'] = $specifications_inputs->getValue ( 'comm_transmission_type' );
										$clean_specs_array ['comm_transmission_gears'] = $specifications_inputs->getValue ( 'comm_transmission_gears' );
										// weight
										$clean_specs_array ['comm_weight_curb'] = $specifications_inputs->getValue ( 'comm_weight_curb' );
										$clean_specs_array ['comm_weight_frontAxelWeight'] = $specifications_inputs->getValue ( 'comm_weight_frontAxelWeight' );
										$clean_specs_array ['comm_weight_rearAxelWeight'] = $specifications_inputs->getValue ( 'comm_weight_rearAxelWeight' );
										// Axel
										$clean_specs_array ['comm_axel_make'] = $specifications_inputs->getValue ( 'comm_axel_make' );
										$clean_specs_array ['comm_axel_model'] = $specifications_inputs->getValue ( 'comm_axel_model' );
										$clean_specs_array ['comm_axel_model'] = $specifications_inputs->getValue ( 'comm_axel_frontModel' );
										$clean_specs_array ['comm_axel_frontModel'] = $specifications_inputs->getValue ( 'comm_axel_frontModel' );
										$clean_specs_array ['comm_axel_rearModel'] = $specifications_inputs->getValue ( 'comm_axel_rearModel' );
										// Service
										$clean_specs_array ['comm_service_fuel'] = $specifications_inputs->getValue ( 'comm_service_fuel' );
										$clean_specs_array ['comm_service_hydraulic'] = $specifications_inputs->getValue ( 'comm_service_hydraulic' );
										// Tires
										$clean_specs_array ['comm_tire_size'] = $specifications_inputs->getValue ( 'comm_tire_size' );
										// Brakes
										$clean_specs_array ['comm_brake_service'] = $specifications_inputs->getValue ( 'comm_brake_service' );
										$clean_specs_array ['comm_brake_parking'] = $specifications_inputs->getValue ( 'comm_brake_parking' );
										// Other
										$clean_specs_array ['comm_electrical_system'] = $specifications_inputs->getValue ( 'comm_electrical_system' );
										$clean_specs_array ['comm_alternator'] = $specifications_inputs->getValue ( 'comm_alternator' );
										
										$clean_specs_array ['comm_product_id'] = $product_id;
										
										echo $_FILES ['comm_spec_sheet'] ['type'];
										
										if (! empty ( $_FILES ['comm_spec_sheet'] )) {
											$specSheetAllowed = array (
													'pdf' 
											);
											$specSheetTemp = explode ( ".", $_FILES ["comm_spec_sheet"] ["name"] );
											$specSheetExtension = end ( $specSheetTemp );
											if (in_array ( $specSheetExtension, $specSheetAllowed )) {
												
												// ###############Add code to save spec sheet################
												$spec_sheet_name = time () . '.pdf';
												move_uploaded_file ( $_FILES ["comm_spec_sheet"] ["tmp_name"], get_theme_root () . "/Kalmar/plugins/spec_Sheets/" . $spec_sheet_name );
												$clean_specs_array ['comm_spec_sheet'] = get_theme_root_uri () . "/Kalmar/plugins/spec_Sheets/" . $spec_sheet_name;
											} else {
												if ($_FILES ['comm_spec_sheet'] ['error'] != 4) {
													echo '<div class="alert alert-danger">Spec Sheet must be in PDF format</div>';
												} else {
													echo '<div class="alert alert-warning">A Problem occured with the Spec Sheet!</div>';
												}
											}
										}
										
										// Add Specs to specs database
										require_once (get_theme_root () . '/Kalmar/plugins/classes/Specifications.class.php');
										$clean_specs_array = array_filter ( $clean_specs_array );
										Specifications::addCommSpecifications ( $clean_specs_array );
										
										/*
										 * ############Gallery INPUTS############ name: image: Description:
										 */
										$videoCount = $_POST ['comm_image_count'];
										$imageCount = $_POST ['comm_video_count'];
										require_once (get_theme_root () . '/Kalmar/plugins/classes/Gallery.class.php');
										
										/*
										 * ############Youtube Videos############
										 */
										
										while ( $videoCount > 0 ) {
											$type = 'video';
											if (! empty ( $_POST ['gallery_video_' . $videoCount] )) {
												
												$location = $_POST ['gallery_video_' . $videoCount];
												
												Gallery::addToGallery ( $type, $location, $product_id );
											}
											$videoCount --;
										}
										
										/*
										 * ############Youtube Gallery############
										 */
										while ( $imageCount > 0 ) {
											$type = 'image';
											$location;
											$allowedExts = array (
													"gif",
													"jpeg",
													"jpg",
													"png" 
											);
											$temp = explode ( ".", $_FILES ['gallery_image_' . $imageCount] ["name"] );
											$extension = end ( $temp );
											if ((($_FILES ['gallery_image_' . $imageCount] ["type"] == "image/gif") || ($_FILES ['gallery_image_' . $imageCount] ["type"] == "image/jpeg") || ($_FILES ["gallery_image_" . $imageCount] ["type"] == "image/jpg") || ($_FILES ["gallery_image_" . $imageCount] ["type"] == "image/pjpeg") || ($_FILES ["gallery_image_" . $imageCount] ["type"] == "image/x-png") || ($_FILES ["gallery_image_" . $imageCount] ["type"] == "image/png")) && ($_FILES ["gallery_image_" . $imageCount] ["size"] < 4 * 1048576) && in_array ( $extension, $allowedExts )) {
												if ($_FILES ["gallery_image_" . $imageCount] ["error"] > 0) {
													echo "<div class='alert alert-danger'>" . $_FILES ["gallery_image_" . $imageCount] ["error"] . "</div><br>";
												} else {
													
													if (! file_exists ( get_theme_root () . "/Kalmar/images/features_images/" . $_FILES ['gallery_image_' . $imageCount] ["name"] )) {
														move_uploaded_file ( $_FILES ['gallery_image_' . $imageCount] ["tmp_name"], get_theme_root () . "/Kalmar/images/gallery_images/" . $_FILES ['gallery_image_' . $imageCount] ["name"] );
														$location = get_theme_root_uri () . "/Kalmar/images/gallery_images/" . $_FILES ["comm_featured_image" . $imageCount] ["name"];
													}
												}
											} else {
												echo "<div class='alert alert-danger'>Invalid file</div>";
											}
											Gallery::addToCommGallery ( $type, $location, $product_id );
											$imageCount --;
										}
									} else {
										echo '<div class="alert alert-danger">Error with your specifications</div>';
									}
								} 								// product was inserted
								else {
									echo 'No product created, please created a product';
								} // product wasn't inserted
							} catch ( Exception $e ) {
								echo $e->getMessage ();
							}
						}
					}
				} else {
					echo "<div class='alert alert-danger'>Please Enter all Required Fields!</div></br>";
				}
			} else {
				if (! $validProductText->isValid ( 'comm_product_name' )) {
					echo '<div class="alert alert-danger" id="productNameError">' . $validProductText->getError ( 'comm_product_name' ) . '</div>';
				}
				if (! $validProductText->isValid ( 'comm_product_desc' )) {
					echo '<div class="alert alert-danger" id="productDescError">' . $validProductText->getError ( 'comm_product_desc' ) . '</div>';
				}
			}
		}
		
		$product_page_template = <<<EOL
<style>
	.panel-body h1 {
		font-size: 1.313em;
		color:#222222;
		padding:10px 0;
		font-weight:bold;
		font-facommy:arial;
	}
	.panel-body p {
		font-size: .875em;
		color:#333333;
		font-facommy:arial;
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
				<li><a href="###SPECSHEETURL###" data-toggle="collapse"
					data-parent="#accordion">Spec Sheet</a></li>
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
$product_info = $wpdb->get_results("SELECT * FROM wp_dummy_sitecomm_product WHERE comm_product_id = $product_id");
$product_name = $product_info[0]->comm_product_name;
$product_desc = $product_info[0]->comm_product_desc;
$product_image = $product_info[0]->comm_product_image;

$product_template = <<<EOL
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<img src="{$product_image}" alt="{$product_name}" width="100%" >
		<h1>{$product_name}</h1>
		<p>{$product_desc}</p>
	</div>
EOL;



//Put title of product in first accordian
$product_page_template = str_replace ( '###PRODUCTTITLE###', $product_name, $product_page_template );
$product_page_template = str_replace ( '###Product###', $product_template, $product_page_template );


//FEATURES
$features_info = $wpdb->get_results("SELECT * FROM wp_dummy_sitecomm_feature WHERE comm_product_id = $product_id");
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
	$lines = explode(PHP_EOL, $feature_info->comm_feature_bullets);
	$str;
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
	$this_template = str_replace ( '###FEATUREIMAGE###', $feature_info->comm_feature_image, $this_template );
	$this_template = str_replace ( '###FEATURETITLE###', $feature_info->comm_feature_title, $this_template );
	$all_features .= $this_template;
}

$product_page_template = str_replace ( '###FEATURES###', $all_features, $product_page_template );

//SPECS
$specs_info = $wpdb->get_results("SELECT * FROM wp_dummy_sitecomm_specs WHERE comm_product_id = $product_id");

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
			<td>{$specs_info[0]->comm_engine_make}</td>
		</tr>
		<tr>
			<td>Model</td>
			<td>{$specs_info[0]->comm_engine_model}</td>
		</tr>
		<tr>
			<td>Cylinders</td>
			<td>{$specs_info[0]->comm_engine_cylinders}</td>
		</tr>
		<tr>
			<td>Power</td>
			<td>{$specs_info[0]->comm_engine_power}</td>
		</tr>
		<tr>
			<td>Displacement</td>
			<td>{$specs_info[0]->comm_engine_displacement}</td>
		</tr>
		<tr>
			<td>Cooling</td>
			<td>{$specs_info[0]->comm_engine_cooling}</td>
		</tr>
		<tr>
			<td>Fuel</td>
			<td>{$specs_info[0]->comm_engine_power}</td>
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
			<td>{$specs_info[0]->comm_performance_speedUnladen}</td>
		</tr>
		<tr>
			<td>Speed Laden</td>
			<td>{$specs_info[0]->comm_performance_laden}</td>
		</tr>
		<tr>
			<td>Speed Reverse</td>
			<td>{$specs_info[0]->comm_performance_speedReverse}</td>
		</tr>
		<tr>
			<td>Gradeability</td>
			<td>{$specs_info[0]->comm_performance_gradeability}</td>
		</tr>
		<tr>
			<td>Unladen</td>
			<td>{$specs_info[0]->comm_performance_unladen}</td>
		</tr>
		<tr>
			<td>Laden</td>
			<td>{$specs_info[0]->comm_performance_laden}</td>
		</tr>
		<tr>
			<td>Fording Depth</td>
			<td>{$specs_info[0]->comm_performance_fordingDepth}</td>
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
			<td>{$specs_info[0]->comm_trasnmission_make}</td>
		</tr>
		<tr>
			<td>Model</td>
			<td>{$specs_info[0]->comm_transmission_model}</td>
		</tr>
		<tr>
			<td>Type</td>
			<td>{$specs_info[0]->comm_transmisssion_type}</td>
		</tr>
		<tr>
			<td>Gears</td>
			<td>{$specs_info[0]->comm_transmission_gears}</td>
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
			<td>{$specs_info[0]->comm_weight_curb}</td>
		</tr>
		<tr>
			<td>Front Axel Weight</td>
			<td>{$specs_info[0]->comm_weight_frontAxelWeight}</td>
		</tr>
		<tr>
			<td>Rear Axel Weight</td>
			<td>{$specs_info[0]->comm_weight_rearAxelWeight}</td>
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
			<td>{$specs_info[0]->comm_axel_make}</td>
		</tr>
		<tr>
			<td>Axel Model</td>
			<td>{$specs_info[0]->comm_axel_model}</td>
		</tr>
		<tr>
			<td>Front Axel Model</td>
			<td>{$specs_info[0]->comm_axel_frontModel}</td>
		</tr>
		<tr>
			<td>rear Axel Model</td>
			<td>{$specs_info[0]->comm_axel_rearModel}</td>
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
			<td>{$specs_info[0]->comm_service_fuel}</td>
		</tr>
		<tr>
			<td>Hydraulic</td>
			<td>{$specs_info[0]->comm_service_hydraulic}</td>
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
			<td>{$specs_info[0]->comm_tire_size}</td>
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
			<td>{$specs_info[0]->comm_brake_service}</td>
		</tr>
		<tr>
			<td>Parking</td>
			<td>{$specs_info[0]->comm_brake_parking}</td>
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
			<td>{$specs_info[0]->comm_electrical_system}</td>
		</tr>
		<tr>
			<td>Alternator</td>
			<td>{$specs_info[0]->comm_alternator}</td>
		</tr>
	</table>
</div>
EOL;
$all_specs = $Engine_template.PHP_EOL.$performance_template.PHP_EOL.$transmission_template.PHP_EOL.$weight_template.PHP_EOL.$axel_template.PHP_EOL.$service_template.PHP_EOL.$tire_template.PHP_EOL.$brake_template.PHP_EOL.$additional_template;
$product_page_template = str_replace ( '###SPECSHEETURL###', $specs_info[0]->comm_spec_sheet, $product_page_template );
$product_page_template = str_replace ( '###SPECIFICATIONS###', $all_specs, $product_page_template );



//GALLERY
$gallery_info = $wpdb->get_results("SELECT * FROM wp_dummy_sitecomm_gallery WHERE comm_product_id = $product_id");
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
<div class="row">
<h1>Images</h1>
EOL;

$video_gallery = <<<EOL
	<div class="row">
	<h1>Videos</h1>
EOL;

foreach($gallery_info as $gallery_item){
	
	if($gallery_item->comm_gallery_type == "image"){
		$image_gallery .= '<a class="productGallery" href="'.$gallery_item->comm_gallery_location.'"><img class=" col-lg-3 col-md-3 col-sm-3 col-xs-3" src="'.$gallery_item->comm_gallery_location.'"></a>';
	}else {
		$pattern = '(//www.youtube.com/embed/)';
		$get_link_end = preg_replace($pattern, '', $gallery_item->comm_gallery_location); 
		$video_image = "http://img.youtube.com/vi/".$get_link_end."/3.jpg";
		$video_gallery .= '<a class="various fancybox.iframe" href="'.stripslashes ($gallery_item->comm_gallery_location).'"><img class="col-lg-4 col-md-4 col-sm-4 col-xs-4" src="'.$video_image.'"></a>';
	}
}

$video_gallery .= '</div>';

$image_gallery .=  '</div>	'.$video_gallery;

$product_page_template = str_replace ( '###GALLERY###', $image_gallery, $product_page_template );

$post = array(
		'ID'             => $product_id , //Are you updating an existing post?
		'comment_status' => 'closed', // 'closed' means no comments.
		'post_content'   => stripslashes($product_page_template) , //The full text of the post.
		'post_status'    => 'publish' , //Set the status of the new post.
		'post_title'     => 'Commercial - '.$product_name, //The title of your post.
		'post_type'      => 'page', //You may want to insert a regular post, page, link, a menu item or some custom post type
		'filter'		 => 'true'
);

wp_insert_post( $post, $wp_error);

$wpdb->last_error;


$products = $wpdb->get_results("SELECT * FROM wp_dummy_sitecomm_product");

$productListNav;
$productPanel;
$counter = 0;
$strNum = array(One, Two, Three, Four, Five, Six, Seven, Eight, Nine, Ten);
foreach($products as $product){
	//$productListNav .= 	'<li><a href="#collapse'.$strNum[$counter].'" data-toggle="collapse" data-parent="#accordion">'.$product->comm_product_name.'</a></li>';
	//$isFirst = ($counter==0)? 'in':'';
	$productPanel .= '<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title"><a href="#collapse'.$strNum[$counter].'" data-toggle="collapse" data-parent="#accordion">'.$product->comm_product_name.'</a></h4>
						</div>
						<div class="panel-collapse collapse in" id="collapse'.$strNum[$counter].'">
							<div class="panel-body">
								<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<img src="'.$product->comm_product_image.'" alt="'.$product->comm_product_name.'" width="100%">
										<h1>'.$product->comm_product_name.'</h1>
										<p>'.$product->comm_product_desc.'</p>
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
</div>
EOL;

$comm_product_template = str_replace ( '###PRODUCTPANEL###', $productPanel, $comm_product_template );
//$comm_product_template = str_replace ( '###NAV###', $productListNav , $comm_product_template );

$post = array(
		'ID'             => 123 , //Are you updating an existing post?
		'comment_status' => 'closed', // 'closed' means no comments.
		'post_content'   => stripslashes($comm_product_template) , //The full text of the post.
		'post_status'    => 'publish' , //Set the status of the new post.
		'post_title'     => 'Commercial Products', //The title of your post.
		'post_type'      => 'page', //You may want to insert a regular post, page, link, a menu item or some custom post type
		'filter'		 => 'true'
);

wp_insert_post( $post, $wp_error);

print_r($wp_error);

		
	}
	require_once (get_theme_root () . '/Kalmar/plugins/com_products.php');
}



/*
 * Commercial Support/Services #########################################################################################
 */
function commercialSupport() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
		
		global $wpdb;
		$post_keys = array_keys ( $_POST );
		foreach ( $post_keys as $postkey ) {
			//echo $postkey;
			switch($postkey){
				case(com_service_desc):
					$data = $_POST['com_service_desc'];
					$wpdb->update('wp_dummy_sitesupportServices',array('support_service'=>stripslashes($data)), array('support_id' => 2));
					echo '<div class="alert alert-success">Commercial manual section has been updated</div>';
					break;
				case(com_financing_desc):
					$data = $_POST['com_financing_desc'];
					$wpdb->update('wp_dummy_sitesupportServices',array('support_financing'=>stripslashes($data)), array('support_id' => 2));
					echo '<div class="alert alert-success">Commercial financing section has been updated</div>';
					break;
				case(com_parts_desc):
					$data = $_POST['com_parts_desc'];
					$wpdb->update('wp_dummy_sitesupportServices',array('support_parts'=>stripslashes($data)), array('support_id' => 2));
					echo '<div class="alert alert-success">Commercial parts section has been updated</div>';
					break;
				case(com_manuals_desc):
					$data = $_POST['com_manuals_desc'];
					$wpdb->update('wp_dummy_sitesupportServices',array('support_manuals'=>stripslashes($data)), array('support_id' => 2));
					echo '<div class="alert alert-success">Commercial manuals section has been updated</div>';
					break;
				case(com_training_desc):
					$data = $_POST['com_training_desc'];
					$wpdb->update('wp_dummy_sitesupportServices',array('support_training'=>stripslashes($data)), array('support_id' => 2));
					echo '<div class="alert alert-success">Commercial training section has been updated</div>';
					break;
				case(com_warranty_desc):
					$data = $_POST['com_warranty_desc'];
					$wpdb->update('wp_dummy_sitesupportServices',array('support_warranty'=>stripslashes($data)), array('support_id' => 2));
					echo '<div class="alert alert-success">Commercial warranty section has been updated</div>';
					break;
				case(com_sales_desc):
					$data = $_POST['com_sales_desc'];
					$wpdb->update('wp_dummy_sitesupportServices',array('support_sales'=>stripslashes($data)), array('support_id' => 2));
					echo '<div class="alert alert-success">Commercial Sales section has been updated</div>';
					break;
				case(com_sourcing_desc):
					$data = $_POST['com_sourcing_desc'];
					$wpdb->update('wp_dummy_sitesupportServices',array('support_sourcing'=>stripslashes($data)), array('support_id' => 2));
					echo '<div class="alert alert-success">Commercial sourcing section has been updated</div>';
					break;	
		}
		
		
		$data = $wpdb->get_results("SELECT * FROM wp_dummy_sitesupportServices WHERE support_id = 2");
		echo $wpdb->last_error;
		$content = <<<EOL
	<div class="row">
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
<div class="red_box">
<ul>
	<li><a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">Manuals</a></li>
	<li><a href="#collapseTwo" data-toggle="collapse" data-parent="#accordion">Financing</a></li>
	<li><a href="#collapseThree" data-toggle="collapse" data-parent="#accordion">Parts</a></li>
	<li><a href="#collapseFour" data-toggle="collapse" data-parent="#accordion">Sales</a></li>
	<li><a href="#collapseFive" data-toggle="collapse" data-parent="#accordion">Service</a></li>
    <li><a href="#collapseSix" data-toggle="collapse" data-parent="#accordion">Training</a></li>
	<li><a href="#collapseSeven" data-toggle="collapse" data-parent="#accordion">Warranty</a></li>
	<li><a href="#collapseEight" data-toggle="collapse" data-parent="#accordion">Sourcing</a></li>
</ul>
</div>
<div class="black_box">
<h1>For MORE INFO</h1>
<a class="btn btn-danger" href="http://www.webtegstage.com/kalmar/request-a-quote/">REQUEST A QUOTE</a>
</br>
<h1>OR CALL</h1>
<h2>800-232-1236</h2>
</div>
</div>
		
<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
<div class="panel-group" id="accordion">
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">
Manuals
</a></h4>
</div>
<div class="panel-collapse collapse in" id="collapseOne">
<div class="panel-body">
{$data[0]->support_manuals}
</div>
</div>
</div>
		

<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseTwo" data-toggle="collapse" data-parent="#accordion">
Financing
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseTwo">
<div class="panel-body">
{$data[0]->support_financing}
</div>
</div>
</div>

		
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseThree" data-toggle="collapse" data-parent="#accordion">
Parts
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseThree">
<div class="panel-body">
{$data[0]->support_parts}
</div>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseFour" data-toggle="collapse" data-parent="#accordion">
Sales
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseFour">
<div class="panel-body">
{$data[0]->support_sales}
</div>
</div>
</div>
		
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseFive" data-toggle="collapse" data-parent="#accordion">
Service
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseFive">
<div class="panel-body">
{$data[0]->support_service}
</div>
</div>
</div>
		
		
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseSix" data-toggle="collapse" data-parent="#accordion">
Training
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseSix">
<div class="panel-body">
{$data[0]->support_training}
</div>
</div>
</div>
		
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseSeven" data-toggle="collapse" data-parent="#accordion">
Warranty
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseSeven">
<div class="panel-body">
{$data[0]->support_warranty}
</div>
</div>
</div>
		

<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseEight" data-toggle="collapse" data-parent="#accordion">
Sourcing
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseEight">
<div class="panel-body">
{$data[0]->support_sourcing}
</div>
</div>
</div>		
</div>
</div>
</div>
EOL;
		
		$post = array(
				'ID'             => 181 , //Are you updating an existing post?
				'comment_status' => 'closed', // 'closed' means no comments.
				'post_content'   => stripslashes($content) , //The full text of the post.
				'post_status'    => 'publish' , //Set the status of the new post.
				'post_title'     => 'Commercial - Support/Services', //The title of your post.
				'post_type'      => 'page', //You may want to insert a regular post, page, link, a menu item or some custom post type
				'filter'		 => 'true'
		);
		
		wp_insert_post( $post, $wp_error);
		
		echo '<div class="alert alert-success">Commercial Support page updated!</div>';
	}
	/*
	 * $manuals = $_POST['mil_manuals_desc']; 
	 * $parts = $_POST['mil_parts_desc']; 
	 * $service = $_POST['mil_service_desc']; 
	 * $training = $_POST['mil_training_desc']; 
	 * $warranty = $_POST['mil_warranty_desc']; 
	 * $sourcing = $_POST['mil_sourcing_desc']; 
	 * $wpdb->update('wp_dummy_sitesupportServices',array('support_manuals'=>$manuals,'support_parts'=>$parts,'support_service' => $service, 'support_training' => $training, 'support_warranty' => $warranty, 'support_sourcing' = $sourcing),array('support_id' => 1)); 
	 * var_dump($wpdb->last_error); 
	 * echo '<div class="alert alert-success">Military Featured Video has been updated</div>';
	 */
} 
		require_once (get_theme_root () . '/Kalmar/plugins/comm_support.php'); 
}

/*
 * Commercial Industries #########################################################################################
 */
function commercialIndustries() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
if ($_SERVER ["REQUEST_METHOD"] == "POST") {
		
		global $wpdb;
		$post_keys = array_keys ( $_POST );
		foreach ( $post_keys as $postkey ) {
			//echo $postkey;
			switch($postkey){
				case(industries_energy):
					$data = $_POST['industries_energy'];
					$wpdb->update('wp_dummy_siteindustries',array('industries_energy'=>$data), array('industries_id' => 1));
					echo '<div class="alert alert-success">Industries Energy section has been updated</div>';
					break;
				case(industries_heavyConstruction):
					$data = $_POST['industries_heavyConstruction'];
					$wpdb->update('wp_dummy_siteindustries',array('industries_heavyConstruction'=>$data), array('industries_id' => 1));
					echo '<div class="alert alert-success">Industries Heavy Cosntruction section has been updated</div>';
					break;
				case(industries_logistics):
					$data = $_POST['industries_logistics'];
					$wpdb->update('wp_dummy_siteindustries',array('industries_logistics'=>$data), array('industries_id' => 1));
					echo '<div class="alert alert-success">Industries logistics section has been updated</div>';
					break;
				case(industries_naturalResources):
					$data = $_POST['industries_naturalResources'];
					$wpdb->update('wp_dummy_siteindustries',array('industries_naturalResources'=>$data), array('industries_id' => 1));
					echo '<div class="alert alert-success">Industries Natural Resources section has been updated</div>';
					break;
				/*case(industries_govMil):
					$data = $_POST['industries_govMil'];
					$wpdb->update('wp_dummy_siteindustries',array('industries_govMil'=>$data), array('industries_id' => 1));
					echo '<div class="alert alert-success">Industries Government / Military section has been updated</div>';
					break;
				*/
		}
		
		
		$data = $support_service_data = $wpdb->get_results ( "SELECT industries_energy, industries_heavyConstruction, industries_logistics, industries_naturalResources, industries_govMil FROM wp_dummy_siteindustries WHERE industries_id = 1" );
		
		$content = <<<EOL
	<div class="row">
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
<div class="red_box">
<ul>
	<li><a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">Energy</a></li>
	<li><a href="#collapseTwo" data-toggle="collapse" data-parent="#accordion">Heavy Construction</a></li>
	<li><a href="#collapseThree" data-toggle="collapse" data-parent="#accordion">Logistics</a></li>
    <li><a href="#collapseFour" data-toggle="collapse" data-parent="#accordion">Natural Resources</a></li>
</ul>
</div>
<div class="black_box">
<h1>For MORE INFO</h1>
<a class="btn btn-danger" href="http://www.webtegstage.com/kalmar/request-a-quote/">REQUEST A QUOTE</a>
</br>
<h1>OR CALL</h1>
<h2>800-232-1236</h2>
</div>
</div>
		
<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
<div class="panel-group" id="accordion">
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">
Energy
</a></h4>
</div>
<div class="panel-collapse collapse in" id="collapseOne">
<div class="panel-body">
{$data[0]->industries_energy}
</div>
</div>
</div>
		
		
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseTwo" data-toggle="collapse" data-parent="#accordion">
Heavy Construction
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseTwo">
<div class="panel-body">
{$data[0]->industries_heavyConstruction}
</div>
</div>
</div>
		
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseThree" data-toggle="collapse" data-parent="#accordion">
Logistics
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseThree">
<div class="panel-body">
{$data[0]->industries_logistics}
</div>
</div>
</div>
		
		
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseFour" data-toggle="collapse" data-parent="#accordion">
Natural Resources
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseFour">
<div class="panel-body">
{$data[0]->industries_naturalResources}
</div>
</div>
</div>
		
</div>
</div>
</div>
EOL;
		
		$post = array(
				'ID'             => 132 , //Are you updating an existing post?
				'comment_status' => 'closed', // 'closed' means no comments.
				'post_content'   => stripslashes($content) , //The full text of the post.
				'post_status'    => 'publish' , //Set the status of the new post.
				'post_title'     => 'Commercial - Industries', //The title of your post.
				'post_type'      => 'page', //You may want to insert a regular post, page, link, a menu item or some custom post type
				'filter'		 => 'true'
		);
		
		wp_insert_post( $post, $wp_error);
		
		echo '<div class="alert alert-success">Commercial Industries page updated!</div>';
	}
	/*
	 * $manuals = $_POST['mil_manuals_desc']; 
	 * $parts = $_POST['mil_parts_desc']; 
	 * $service = $_POST['mil_service_desc']; 
	 * $training = $_POST['mil_training_desc']; 
	 * $warranty = $_POST['mil_warranty_desc']; 
	 * $sourcing = $_POST['mil_sourcing_desc']; 
	 * $wpdb->update('wp_dummy_sitesupportServices',array('support_manuals'=>$manuals,'support_parts'=>$parts,'support_service' => $service, 'support_training' => $training, 'support_warranty' => $warranty, 'support_sourcing' = $sourcing),array('support_id' => 1)); 
	 * var_dump($wpdb->last_error); 
	 * echo '<div class="alert alert-success">Military Featured Video has been updated</div>';
	 */
} 
		require_once (get_theme_root () . '/Kalmar/plugins/com_industries.php'); 
}

/*
 * Commercial Dealers #########################################################################################
 */
function commercialDealers() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
		$content = $_POST['mil_dealer_page'];
		
		$post = array(
				'ID'             => 178 , //Are you updating an existing post?
				'comment_status' => 'closed', // 'closed' means no comments.
				'post_content'   => $content , //The full text of the post.
				'post_status'    => 'publish' , //Set the status of the new post.
				'post_title'     => 'Commercial - Dealers', //The title of your post.
				'post_type'      => 'page' //You may want to insert a regular post, page, link, a menu item or some custom post type
		);
		
		wp_insert_post( $post, $wp_error);
		
		echo '<div class="alert alert-success">Commercial dealer page updated</div>';
	} 
		require_once (get_theme_root () . '/Kalmar/plugins/comm_dealers.php');
}


/*
 * Commercial Contact #########################################################################################
 */
function commercialContact() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") { 
		
		$content = $_POST['mil_contact_page'];
		
		
		$post = array(
				'ID'             => 256 , //Are you updating an existing post?
				'comment_status' => 'closed', // 'closed' means no comments.
				'post_content'   => $content , //The full text of the post.
				'post_status'    => 'publish' , //Set the status of the new post.
				'post_title'     => 'Commercial - Contact', //The title of your post.
				'post_type'      => 'page' //You may want to insert a regular post, page, link, a menu item or some custom post type
		);
		
		wp_insert_post( $post, $wp_error);

		echo '<div class="alert alert-success">Commercial contact page updated</div>';
		
	} 
		require_once (get_theme_root () . '/Kalmar/plugins/comm_contact.php');
} 
/*
 * Commercial About Us #########################################################################################
 */
function commercialAboutUs() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
		
		$content = $_POST['mil_aboutus_page'];
		
		
		$post = array(
				'ID'             => 259 , //Are you updating an existing post?
				'comment_status' => 'closed', // 'closed' means no comments.
				'post_content'   => $content , //The full text of the post.
				'post_status'    => 'publish' , //Set the status of the new post.
				'post_title'     => 'Commercial - About Us', //The title of your post.
				'post_type'      => 'page' //You may want to insert a regular post, page, link, a menu item or some custom post type
		);
		
		wp_insert_post( $post, $wp_error);
		
		echo '<div class="alert alert-success">Commercial about us page updated</div>';
		
	} 
		require_once (get_theme_root () . '/Kalmar/plugins/comm_aboutUs.php');
}

/*
 * Commercial Locations #########################################################################################
 */
function commercialLocations() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
		
		$content = $_POST['mil_locations_page'];
		
		
		$post = array(
				'ID'             => 261 , //Are you updating an existing post?
				'comment_status' => 'closed', // 'closed' means no comments.
				'post_content'   => $content , //The full text of the post.
				'post_status'    => 'publish' , //Set the status of the new post.
				'post_title'     => 'Commercial - Locations', //The title of your post.
				'post_type'      => 'page' //You may want to insert a regular post, page, link, a menu item or some custom post type
		);
		
		wp_insert_post( $post, $wp_error);
		
		echo '<div class="alert alert-success">Commercial locations page updated</div>';
		
	}
		require_once (get_theme_root () . '/Kalmar/plugins/comm_locations.php');
}

/*
 * Commercial Careers #########################################################################################
 */
function commercialCareers() {

	echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>";
	echo "<link rel='stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css'>";
	if ($_SERVER ["REQUEST_METHOD"] == "POST") {
	$introduction 	= stripslashes($_POST['mil_careers_introduction']);
		$benefits 		= stripslashes($_POST['mil_careers_benefits']);
		$oppurtunities  = stripslashes($_POST['mil_careers_jobOppurtunities']);
		$smallBussiness = stripslashes($_POST['mil_careers_smallBusiness']);
		
		global $wpdb;
		$wpdb->update('wp_dummy_sitecareers',array('careers_introduction' => $introduction, 'careers_benefits' => $benefits, 'careers_jobOppurtunities' => $oppurtunities, 'careers_smallBusiness' => $smallBussiness),array('careers_id' => 2));
		//echo $wpdb->last_error;
		
		$content = <<<EOL
	<div class="row">
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
<div class="red_box">
<ul>
	<li><a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">Introduction</a></li>
	<li><a href="#collapseTwo" data-toggle="collapse" data-parent="#accordion">Benefits</a></li>
	<li><a href="#collapseThree" data-toggle="collapse" data-parent="#accordion">Job Oppurtunities</a></li>
    <li><a href="#collapseFour" data-toggle="collapse" data-parent="#accordion">Small Business</a></li>
</ul>
</div>
<div class="black_box">
<h1>For MORE INFO</h1>
<a class="btn btn-danger" href="http://www.webtegstage.com/kalmar/request-a-quote/">REQUEST A QUOTE</a>
</br>
<h1>OR CALL</h1>
<h2>800-232-1236</h2>
</div>
</div>

<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
<div class="panel-group" id="accordion">
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">
Introduction
</a></h4>
</div>
<div class="panel-collapse collapse in" id="collapseOne">
<div class="panel-body">
{$introduction}
</div>
</div>
</div>


<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseTwo" data-toggle="collapse" data-parent="#accordion">
Benefits
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseTwo">
<div class="panel-body">
		{$benefits}
</div>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseThree" data-toggle="collapse" data-parent="#accordion">
Job Oppurtunities
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseThree">
<div class="panel-body">
{$oppurtunities}
</div>
</div>
</div>


<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><a href="#collapseFour" data-toggle="collapse" data-parent="#accordion">
Small Business
</a></h4>
</div>
<div class="panel-collapse collapse" id="collapseFour">
<div class="panel-body">
{$smallBussiness}
</div>
</div>
</div>

</div>
</div>
</div>
EOL;
		
		$post = array(
				'ID'             => 459 , //Are you updating an existing post?
				'comment_status' => 'closed', // 'closed' means no comments.
				'post_content'   => stripslashes($content) , //The full text of the post.
				'post_status'    => 'publish' , //Set the status of the new post.
				'post_title'     => 'Commercial - Careers', //The title of your post.
				'post_type'      => 'page', //You may want to insert a regular post, page, link, a menu item or some custom post type
				'filter'		 => 'true'		
		);
		
		wp_insert_post( $post, $wp_error);
		echo '<div class="alert alert-success">Commercial careers page updated!</div>';
	}
	
	require_once (get_theme_root () . '/Kalmar/plugins/comm_careers.php');
}

/*
 * ########################## Navigation Registration ###########################
 */
function register_my_comm_menu() {
	register_nav_menu ( 'comm-header-menu', __ ( 'Com Header Menu' ) );
}
add_action ( 'init', 'register_my_comm_menu' );
function register_my_mil_menu() {
	register_nav_menu ( 'mil-header-menu', __ ( 'Mil Header Menu' ) );
}
add_action ( 'init', 'register_my_mil_menu' );
function register_my_mil_tan_menu() {
	register_nav_menu ( 'mil-tan-header-menu', __ ( 'mil tan Header Menu' ) );
}
add_action ( 'init', 'register_my_mil_tan_menu' );
function register_my_comm_tan_menu() {
	register_nav_menu ( 'comm-tan-header-menu', __ ( 'comm tan Header Menu' ) );
}
add_action ( 'init', 'register_my_comm_tan_menu' );

/*
 * ########################## END Navigation Registration ###########################
 */



/*
########################## Create Database Tables ###########################
*/
$mil_product = $wpdb->prefix . 'mil_product';
$mil_features = $wpdb->prefix . 'mil_features';
$mil_specs = $wpdb->prefix . 'mil_specs';
$mil_gallery = $wpdb->prefix . 'mil_gallery';

// function to create the DB / Options / Defaults
function your_plugin_options_install() {
	global $wpdb;
	global $your_db_name;
	
	// create the ECPT metabox database table
	if ($wpdb->get_var ( "show tables like '$your_db_name'" ) != $mil_product) {
		$sql = "CREATE TABLE " . $mil_product . " (
		`mil_product_id` int(11) NOT NULL AUTO_INCREMENT,
		`mil_product_name` mediumtext NOT NULL,
		`mil_product_image` mediumtext NOT NULL,
		`mil_product_desc` mediumtext NOT NULL,
		UNIQUE KEY id (mil_product_id)
		);";
		
		require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta ( $sql );
	}
	
	if ($wpdb->get_var ( "show tables like '$your_db_name'" ) != $mil_feature) {
		$sql = "CREATE TABLE " . $mil_feature . " (
		`mil_feature_id` int(11) NOT NULL AUTO_INCREMENT,
		`mil_feature_title` mediumtext NOT NULL,
		`mil_feature_image` mediumtext NOT NULL,
		`mil_feature_bullets` mediumtext NOT NULL,
		`mil_product_id` int(11) NOT NULL,
		UNIQUE KEY id (mil_feature_id)
		);";
		
		require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta ( $sql );
	}
	
	if ($wpdb->get_var ( "show tables like '$your_db_name'" ) != $mil_specs) {
		$sql = "CREATE TABLE " . $mil_specs . " (
		`mil_specs_id` int(11) NOT NULL AUTO_INCREMENT,
		`mil_engine_make` tinytext NOT NULL,
		`mil_engine_model` tinytext NOT NULL,
		`mil_engine_cylinders` tinytext NOT NULL,
		`mil_engine_power` tinytext NOT NULL,
		`mil_engine_displacement` tinytext NOT NULL,
		`mil_engine_cooling` tinytext NOT NULL,
		`mil_engine_fuel` tinytext NOT NULL,
		
		`mil_performance_speedUnladen` tinytext NOT NULL,
		`mil_performance_speedLaden` tinytext NOT NULL,
		`mil_performance_speedReverse` tinytext NOT NULL,
		`mil_performance_gradeability` tinytext NOT NULL,
		`mil_performance_unladen` tinytext NOT NULL,
		`mil_performance_laden` tinytext NOT NULL,
		`mil_performance_fordingDepth` tinytext NOT NULL,
		
		`mil_transmission_make` tinytext NOT NULL,
		`mil_transmission_model` tinytext NOT NULL,
		`mil_transmission_type` tinytext NOT NULL,
		`mil_transmission_gears` tinytext NOT NULL,
		
		`mil_weight_curb` tinytext NOT NULL,
		`mil_weight_frontAxelWeight` tinytext NOT NULL,
		`mil_weight_rearAxelWeight` tinytext NOT NULL,
		
		`mil_axel_make` tinytext NOT NULL,
		`mil_axel_model` tinytext NOT NULL,
		`mil_axel_frontModel` tinytext NOT NULL,
		`mil_axel_rearModel` tinytext NOT NULL,
		
		`mil_service_fuel` tinytext NOT NULL,
		`mil_service_hydraulic` tinytext NOT NULL,
		
		`mil_tire_size` tinytext NOT NULL,
		
		`mil_brake_service` tinytext NOT NULL,
		`mil_brake_parking` tinytext NOT NULL,
		
		`mil_electrical_system` tinytext NOT NULL,
		`mil_alternator` tinytext NOT NULL,
		
		`mil_spec_sheet` tinytext NOT NULL,
		
		`mil_product_id` int(11) NOT NULL,
		UNIQUE KEY id (mil_specs_id)
		);";
		
		require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta ( $sql );
	}
	
	if ($wpdb->get_var ( "show tables like '$your_db_name'" ) != $mil_gallery) {
		$sql = "CREATE TABLE " . $mil_gallery . " (
		`mil_gallery_id` int(11) NOT NULL AUTO_INCREMENT,
		`mil_gallery_type` mediumtext NOT NULL,
		'mil_gallery_url' mediumtext NOT NULL,
		`mil_product_id` int(11) NOT NULL,
		UNIQUE KEY id (mil_gallery_id)
		);";
		
		require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta ( $sql );
	}
}
// run the install scripts upon plugin activation
register_activation_hook ( __FILE__, 'your_plugin_options_install' );

/*
 * ########################## END Create Database Tables ###########################
 */



/*
########################## Register Commercial Widgets ###########################
*/
if (function_exists ( 'register_sidebar' )) {
	register_sidebar ( array (
			'name' => 'Left Footer Widgets',
			'id' => 'Left Footer Widgets',
			'description' => '3 Column and logo area footer',
			'before_widget' => '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">',
			'after_widget' => '</div>',
			'before_title' => '<h1>',
			'after_title' => '</h1>' 
	) );
}

if (function_exists ( 'register_sidebar' )) {
	register_sidebar ( array (
			'name' => 'Center Footer Widgets',
			'id' => 'Center Footer Widgets',
			'description' => '3 Column and logo area footer',
			'before_widget' => '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">',
			'after_widget' => '</div>',
			'before_title' => '<h1>',
			'after_title' => '</h1>' 
	) );
}

if (function_exists ( 'register_sidebar' )) {
	register_sidebar ( array (
			'name' => 'Right Footer Widgets',
			'id' => 'Right Footer Widgets',
			'description' => '3 Column and logo area footer',
			'before_widget' => '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">',
			'after_widget' => '</div>',
			'before_title' => '<h1>',
			'after_title' => '</h1>' 
	) );
}

/*
 * ########################## END Register Widgets ###########################
 */

/*
########################## Register Military Widgets ###########################
*/
if (function_exists ( 'register_sidebar' )) {
	register_sidebar ( array (
			'name' => 'Left Footer Widget Military',
			'id' => 'Left Footer Widget Military',
			'description' => '3 Column and logo area footer',
			'before_widget' => '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">',
			'after_widget' => '</div>',
			'before_title' => '<h1>',
			'after_title' => '</h1>' 
	) );
}

if (function_exists ( 'register_sidebar' )) {
	register_sidebar ( array (
			'name' => 'Center Footer Widget Military',
			'id' => 'Center Footer Widget Military',
			'description' => '3 Column and logo area footer',
			'before_widget' => '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">',
			'after_widget' => '</div>',
			'before_title' => '<h1>',
			'after_title' => '</h1>' 
	) );
}

if (function_exists ( 'register_sidebar' )) {
	register_sidebar ( array (
			'name' => 'Right Footer Widget Military',
			'id' => 'Right Footer Widget Military',
			'description' => '3 Column and logo area footer',
			'before_widget' => '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">',
			'after_widget' => '</div>',
			'before_title' => '<h1>',
			'after_title' => '</h1>' 
	) );
}

/*
 * ########################## END Register Widgets ###########################
 */




/*
########################## Register CSS and Javascript ###########################
*/
if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js", false, null);
   wp_enqueue_script('jquery');
}

function kalmar_scripts() {
	wp_enqueue_style ( 'base_css', get_stylesheet_uri () );
	wp_enqueue_style ( 'bootstrap_css', '//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css' );
	wp_enqueue_style ( 'bootstrap_theme_css', '//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css' );
	wp_enqueue_style ( 'jquery_ui_css', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css' );
	wp_enqueue_script ( 'jquery-1.10.2', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', array (), '1.0.0', true );
	wp_enqueue_script ( 'jquery-1.9.1', 'http://code.jquery.com/jquery-1.9.1.js', array (), '1.0.0', true );
	wp_enqueue_script ( 'jquery-ui', 'http://code.jquery.com/ui/1.10.3/jquery-ui.js', array (), '1.0.0', true );
	wp_enqueue_script ( 'bootstrap-js', '//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js', array (), '1.0.0', true );
}

add_action ( 'wp_enqueue_scripts', 'kalmar_scripts' );



/*
 * ########################## END Register CSS and Javascript ###########################
 */


/*
 * ########################## Remove auto paragraph tags ###########################
 */
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );
/*
 * ########################## END Remove auto paragraph tags ###########################
 */


function addCustomer(){
	require(get_template_directory().'/plugins/editProduct.php');
	die();
}
add_action('wp_ajax_addCustomer', 'addCustomer');
add_action('wp_ajax_nopriv_addCustomer', 'addCustomer');


function editComm(){
	require(get_template_directory().'/plugins/editCommProduct.php');
	die();
}
add_action('wp_ajax_editComm', 'editComm');
add_action('wp_ajax_nopriv_editComm', 'editComm');


function deleteFromGallery(){
	//do something
	$mil_gallery_id = $_POST['galleryid']; 
	try{
		global $wpdb;
		$wpdb->delete('wp_dummy_sitemil_gallery',array('mil_gallery_id' => $mil_gallery_id));
		if($wpdb->last_error != null){
			Throw new Exception ($WPDB->last_error);
		}
	}catch(Exception $e){
		echo $e->getMessage();
	}
	die();
}
add_action('wp_ajax_deleteFromGallery', 'deleteFromGallery');
add_action('wp_ajax_nopriv_deleteFromGallery', 'deleteFromGallery');
function deleteFromCommGallery(){
	//do something
	$posts = $_POST;
	foreach($posts as $post){
		echo PHP_EOL.$post.PHP_EOL;
	}
	$comm_gallery_id = $_POST['galleryid']; 
	echo $comm_gallery_id;
	try{
		global $wpdb;
		$wpdb->delete('wp_dummy_sitecomm_gallery',array('comm_gallery_id' => $comm_gallery_id));
		echo $wpdb->last_error;
	}catch(Exception $e){
		echo $e->getMessage();
	}
	die();
}
add_action('wp_ajax_deleteFromCommGallery', 'deleteFromCommGallery');
add_action('wp_ajax_nopriv_deleteFromCommGallery', 'deleteFromCommGallery');


function deleteFromFeatures(){
	echo "Deleting From Features!";
	$mil_feature_id = $_POST['featureid'];
	echo $mil_feature_id;
	try{
		global $wpdb;
		$wpdb->delete('wp_dummy_sitemil_feature',array('mil_feature_id' => $mil_feature_id));
	}catch(Exception $e){
		echo $e->getMessage();
	}
	die();
}
add_action('wp_ajax_deleteFromFeatures', 'deleteFromFeatures');
add_action('wp_ajax_nopriv_deleteFromFeatures', 'deleteFromFeatures');

function deleteFromCommFeatures(){
	echo "Deleting From Features!";
	$comm_feature_id = $_POST['featureid'];
	echo $mil_feature_id;
	try{
		global $wpdb;
		$wpdb->delete('wp_dummy_sitecomm_feature',array('comm_feature_id' => $comm_feature_id));
	}catch(Exception $e){
		echo $e->getMessage();
	}
	die();
}
add_action('wp_ajax_deleteFromCommFeatures', 'deleteFromCommFeatures');
add_action('wp_ajax_nopriv_deleteFromCommFeatures', 'deleteFromCommFeatures');



/*
 * ########################## Hide Pages ###########################
 */
 
 add_action( 'pre_get_posts' ,'exclude_this_page' );
function exclude_this_page( $query ) {
	if( !is_admin() )
		return $query;

	global $pagenow;


	if( 'edit.php' == $pagenow && ( get_query_var('post_type') && 'page' == get_query_var('post_type') ) )
		$query->set( 'post__not_in', array(259, 459, 256, 178, 132, 261, 129, 126, 181, 123, 150, 267, 271, 265, 307, 230, 269, 222, 241, 238, 226) );
		
		
	return $query;
}
 
/*
 * ########################## END Hide Pages ###########################
 */
 
 // Replace Posts label as Articles in Admin Panel 

function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News / Events';
    $submenu['edit.php'][5][0] = 'News / Events';
    $submenu['edit.php'][10][0] = 'Add News / Events';
    echo '';
}
function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'News / Events';
        $labels->singular_name = 'News / Event';
        $labels->add_new = 'Add News / Events';
        $labels->add_new_item = 'Add News / Events';
        $labels->edit_item = 'Edit News / Events';
        $labels->new_item = 'News / Events';
        $labels->view_item = 'View News / Events';
        $labels->search_items = 'Search News / Events';
        $labels->not_found = 'No News / Events found';
        $labels->not_found_in_trash = 'No News / Events found in Trash';
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );
?>