<?php
global $wpdb;
$product_data = $wpdb->get_results ( "SELECT * FROM wp_dummy_sitemil_product WHERE mil_product_id = $product->mil_product_id" );
echo $wpdb->last_error;
$features_data = $wpdb->get_results ( "SELECT * FROM wp_dummy_sitemil_feature WHERE mil_product_id = $product->mil_product_id" );
echo $wpdb->last_error;
$specs_data = $wpdb->get_results ( "SELECT * FROM wp_dummy_sitemil_specs WHERE mil_product_id = $product->mil_product_id " );
echo $wpdb->last_error;
$gallery_data = $wpdb->get_results ( "SELECT * FROM wp_dummy_sitemil_gallery WHERE mil_product_id = $product->mil_product_id" );
echo $wpdb->last_error;
?>
<ul class="nav nav-tabs">
	<li class="active"><a
		href="#edithome<?php echo stripslashes ($product->mil_product_id);?>"
		data-toggle="tab">Product</a></li>
	<li><a href="#editfeatures<?php echo $product->mil_product_id;?>"
		data-toggle="tab">Features</a></li>
	<li><a href="#editspecifications<?php echo $product->mil_product_id;?>"
		data-toggle="tab">Specifications</a></li>
	<li><a href="#editgallery<?php echo $product->mil_product_id;?>"
		data-toggle="tab">Gallery</a></li>
</ul>
<div id="error"></div>
<div class="tab-content">

	<!--
			Home Panel
			############################################################
			-->
	<div class="tab-pane well active"
		id="edithome<?php echo $product->mil_product_id; ?>">

		<!--<div class="alert alert-danger" id="productError"></div>-->
		<input type="hidden" name="mil_product_id" id="mil_product_id"
			value="<?php echo $product_data[0]->mil_product_id ?>">
		<div class="form-group">
			<label for="mil_product_name">Product Name</label> <input type="text"
				class="form-control"
				name="mil_product_name<?php echo  $product->mil_product_id?>"
				id="mil_product_name <?php echo  $product->mil_product_id?>"
				placeholder="Product Name"
				value="<?php echo $product_data[0]->mil_product_name ?>">
		</div>

		<div class="form-group">

			<label for="mil_product_image"><img
				src="<?php echo $product_data[0]->mil_product_image;?>"
				height="80px">Product Image (Max Size: 3MB Allowable filetypes: jpg,
				jpeg, png, gif)</label><br> <input type="file"
				name="mil_product_image<?php echo  $product->mil_product_id?>"
				id="mil_product_image<?php echo  $product->mil_product_id?>"
				class="form-control"> <input type="hidden"
				name="mil_product_image_placeholder<?php echo  $product->mil_product_id?>"
				id="mil_product_image_placeholder"
				value="<?php echo $product_data[0]->mil_product_image ?>">
		</div>

		<div class="form-group">
			<label for="mil_product_desc">Product Description</label>
						
		    				<?php wp_editor($product_data[0]->mil_product_desc, 'edit_mil_product_desc'.$product->mil_product_id); ?>
				</div>


	</div>

	<!-- 
					Features Panel
					############################################################
					-->
	<div class="tab-pane well"
		id="editfeatures<?php echo $product->mil_product_id;?>">

		<div class="editfeatures_content">
			<a href="#" class="btn btn-success" id="addProductFeature">Add
				Feature</a>
				<?php
				if (! empty ( $features_data )) {
					$features_count = count ( $features_data );
					$counter = 1;
					$features_count = <<<EOL
					<input type="hidden" class="mil_features_count" name="mil_features_count{$product->mil_product_id}"
			value="0">
EOL;
					
					foreach ( $features_data as $feature ) {
						
						$features_template = <<<EOL
	
	<div class='form-inline panel'>
	<img class="pull-left" src="{$feature->mil_feature_image}"
				height="120px">
				<input type='hidden'
				name='mil_feature_id{$counter}' id='featureid{$counter}'
		 		value='{$feature->mil_feature_id}'>
	<div class='form-group'>
		<label for='featureTitle{$counter}'>Feature Title</label> <input type='text'
			class='form-control' name='mil_feature_title{$counter}' id='featureTitle{$counter}'
			placeholder='Feature Title' value="{$feature->mil_feature_title}">
	</div>
	<div class='form-group'>
		<label for='featureImage{$counter}'>Feature Image(Leave empty if you dont want to change)</label> <input type='file'
			class='form-control' id='featureImage{$counter}' name='mil_feature_image{$counter}'
			placeholder='Feature Image'>
			<input type="hidden" name="featureImageHolder{$counter}" value="{$feature->mil_feature_image}">
			
	</div>
	<div class='form-group'>
		<label for='bullets{$counter}'>Feature bullet points</label>
		<textarea id='bullets{$counter}' class='form-control'
			name='mil_feature_bullets{$counter}' cols='100'
			placeholder='place each bullet on a new line'>{$feature->mil_feature_bullets}</textarea>
	</div>
	<a href='#' data-id="{$feature->mil_feature_id}" class='pull-right removeProductFeature btn btn-danger'><span
		class='glyphicon glyphicon-minus'></span></a>
</div>

EOL;
						
						echo $features_template;
						$counter ++;
					}
				}
				?>
				
				</div>

		
	</div>
	<!-- 
					Specifications Panel
					############################################################
					-->
	<div class="tab-pane well"
		var_dump($specs_data);
		id="editspecifications<?php echo $product->mil_product_id;?>">
		<h2>Engine</h2>
		<div class="form-inline">
			<!-- #####Engine Make##### -->
			<div class="form-group">
				<label for="mil_engine_make">Make</label> <input type="text"
					class="form-control" name="mil_engine_make" id="mil_engine_make"
					placeholder="Engine Make"
					value="<?php echo $specs_data[0]->mil_engine_make?>">
			</div>
			<!-- #####Engine Model##### -->
			<div class="form-group">
				<label for="mil_engine_model">Model</label> <input type="text"
					class="form-control" name="mil_engine_model" id="mil_engine_model"
					placeholder="Engine Model"
					value="<?php echo $specs_data[0]->mil_engine_model?>">
			</div>
			<!-- #####Engine Cylinders##### -->
			<div class="form-group">
				<label for="mil_engine_cylinders">Cylinders</label> <input
					type="text" class="form-control" name="mil_engine_cylinders"
					id="mil_engine_cylinders" placeholder="Engine Cylinders"
					value="<?php echo $specs_data[0]->mil_engine_cylinders?>">
			</div>
			<!-- #####Engine Power##### -->
			<div class="form-group">
				<label for="mil_engine_power">Power</label> <input type="text"
					class="form-control" name="mil_engine_power" id="enginePower"
					placeholder="Engine Power"
					value="<?php echo $specs_data[0]->mil_engine_power?>">
			</div>
			<!-- #####Engine Displacement##### -->
			<div class="form-group">
				<label for="mil_engine_displacement">Displacement</label> <input
					type="text" class="form-control" name="mil_engine_displacement"
					id="mil_engine_displacement" placeholder="Engine Displacement"
					value="<?php echo $specs_data[0]->mil_engine_displacement?>">
			</div>
			<!-- #####Engine Cooling##### -->
			<div class="form-group">
				<label for="mil_engine_cooling">Cooling</label> <input type="text"
					class="form-control" name="mil_engine_cooling"
					id="mil_engine_cooling" placeholder="Engine Cooling"
					value="<?php echo $specs_data[0]->mil_engine_cooling?>">
			</div>
			<!-- #####Engine Fuel##### -->
			<div class="form-group">
				<label for="mil_engine_fuel">Fuel</label> <input type="text"
					class="form-control" name="mil_engine_fuel" id="mil_engine_fuel"
					placeholder="Engine Fuel"
					value="<?php echo $specs_data[0]->mil_engine_fuel?>">
			</div>
		</div>

		<h2>Performance</h2>
		<div class="form-inline">
			<!-- #####Performance Travel Speed Unladen##### -->
			<div class="form-group">
				<label for="mil_performance_speedUnladen">Travel Speed, Unladen</label>
				<input type="text" class="form-control"
					name="mil_performance_speedUnladen"
					id="mil_performance_speedUnladen"
					placeholder="Travel Speed, Unladen"
					value="<?php echo $specs_data[0]->mil_performance_speedUnladen?>">
			</div>
			<!-- #####Performance Travel Speed Laden##### -->
			<div class="form-group">
				<label for="mil_performance_speedLaden">Travel Speed, Laden</label>
				<input type="text" class="form-control"
					name="mil_performance_speedLaden" id="mil_performance_speedLaden"
					placeholder="Travel Speed, Laden"
					value="<?php echo $specs_data[0]->mil_performance_speedLaden?>">
			</div>
			<!-- #####Performance Travel Speed Reverse##### -->
			<div class="form-group">
				<label for="mil_performance_speedReverse">Travel Speed, Reverse</label>
				<input type="text" class="form-control"
					name="mil_performance_speedReverse"
					id="mil_performance_speedReverse"
					placeholder="Travel Speed, Reverse"
					value="<?php echo $specs_data[0]->mil_performance_speedReverse?>">
			</div>
			<!-- #####Performance Gradeability##### -->
			<div class="form-group">
				<label for="mil_performance_gradeability">Gradeablity</label> <input
					type="text" class="form-control"
					name="mil_performance_gradeability"
					id="mil_performance_gradeability" placeholder="Gradeability"
					value="<?php echo $specs_data[0]->mil_performance_gradeability?>">
			</div>
			<!-- #####Performance Unladen##### -->
			<div class="form-group">
				<label for="mil_performance_unladen">Unladen</label> <input
					type="text" class="form-control" name="mil_performance_unladen"
					id="mil_performance_unladen" placeholder="Unladen"
					value="<?php echo $specs_data[0]->mil_performance_unladen?>">
			</div>
			<!-- #####Performance Laden##### -->
			<div class="form-group">
				<label for="mil_performance_laden">Laden</label> <input type="text"
					class="form-control" name="mil_performance_laden"
					id="mil_performance_laden" placeholder="Laden"
					value="<?php echo $specs_data[0]->mil_performance_laden?>">
			</div>
			<!-- #####Performance Fording Depth##### -->
			<div class="form-group">
				<label for="mil_performance_fordingDepth">Fording Depth</label> <input
					type="text" class="form-control"
					name="mil_performance_fordingDepth"
					id="mil_performance_fordingDepth" placeholder="Fording Depth"
					value="<?php echo $specs_data[0]->mil_performance_fordingDepth?>">
			</div>
		</div>

		<h2>Transmission</h2>
		<div class="form-inline">
			<!-- #####Transmission Make##### -->
			<div class="form-group">
				<label for="mil_transmission_make">Transmission Make</label> <input
					type="text" class="form-control" name="mil_transmission_make"
					id="mil_transmission_make" placeholder="Transmission Make"
					value="<?php echo $specs_data[0]->mil_transmission_make?>">
			</div>
			<!-- #####Transmission Model##### -->
			<div class="form-group">
				<label for="mil_transmission_model">Transmission Model</label> <input
					type="text" class="form-control" name="mil_transmission_model"
					id="mil_transmission_model" placeholder="Transmission Model"
					value="<?php echo $specs_data[0]->mil_transmission_model?>">
			</div>
			<!-- #####Transmission Type##### -->
			<div class="form-group">
				<label for="mil_transmission_type">Transmission Type</label> <input
					type="text" class="form-control" name="mil_transmission_type"
					id="mil_tranmission_type" placeholder="Transmission Type"
					value="<?php echo $specs_data[0]->mil_transmission_type?>">
			</div>
			<!-- #####Transmission Gears##### -->
			<div class="form-group">
				<label for="mil_transmission_gears">Transmission Gears</label> <input
					type="text" class="form-control" name="mil_transmission_gears"
					id="mil_transmission_gears" placeholder="Transmission Gears"
					value="<?php echo $specs_data[0]->mil_transmission_gears?>">
			</div>
		</div>

		<h2>Weight</h2>
		<div class="form-inline">
			<!-- #####Weight Curb Weight##### -->
			<div class="form-group">
				<label for="mil_weight_curb">Curb Weight</label> <input type="text"
					class="form-control" name="mil_weight_curb" id="mil_weight_curb"
					placeholder="Curb Weight"
					value="<?php echo $specs_data[0]->mil_weight_curb?>">
			</div>
			<!-- #####Weight Front Axel##### -->
			<div class="form-group">
				<label for="mil_weight_frontAxelWeight">Front Axel Weight</label> <input
					type="text" class="form-control" name="mil_weight_frontAxelWeight"
					id="mil_weight_frontAxelWeight" placeholder="Front Axel Weight"
					value="<?php echo $specs_data[0]->mil_weight_frontAxelWeight?>">
			</div>
			<!-- #####Weight Rear Axel##### -->
			<div class="form-group">
				<label for="mil_weight_rearAxelWeight">Rear Axel Weight</label> <input
					type="text" class="form-control" name="mil_weight_rearAxelWeight"
					id="mil_weight_rearAxelWeight" placeholder="Rear Axel Weight"
					value="<?php echo $specs_data[0]->mil_weight_rearAxelWeight?>">
			</div>
		</div>


		<h2>Axels</h2>
		<div class="form-inline">
			<!-- #####Axels Make##### -->
			<div class="form-group">
				<label for="mil_axel_make">Axels Make</label> <input type="text"
					class="form-control" name="mil_axel_make" id="mil_axel_make"
					placeholder="Axels Make"
					value="<?php echo $specs_data[0]->mil_axel_make?>">
			</div>
			<div class="form-group">
				<label for="mil_axel_model">Axels Model</label> <input type="text"
					class="form-control" name="mil_axel_model" id="mil_axel_model"
					placeholder="Axels Make"
					value="<?php echo $specs_data[0]->mil_axel_model?>">
			</div>
			<!-- #####Axels Front Model##### -->
			<div class="form-group">
				<label for="mil_axel_frontModel">Front Axel Model</label> <input
					type="text" class="form-control" name="mil_axel_frontModel"
					id="mil_axel_frontModel" placeholder="Front Axel Model"
					value="<?php echo $specs_data[0]->mil_axel_frontModel?>">
			</div>
			<!-- #####Axels Rear Model##### -->
			<div class="form-group">
				<label for="mil_axel_rearModel">Rear Axel Model</label> <input
					type="text" class="form-control" name="mil_axel_rearModel"
					id="mil_axel_rearModel" placeholder="Rear Axel Model"
					value="<?php echo $specs_data[0]->mil_axel_rearModel?>">
			</div>
		</div>

		<h2>Service Capacity</h2>
		<div class="form-inline">
			<!-- #####Service Capacities Fuel##### -->
			<div class="form-group">
				<label for="mil_service_fuel">Fuel Tank</label> <input type="text"
					class="form-control" name="mil_service_fuel" id="mil_service_fuel"
					placeholder="Fuel Tank"
					value="<?php echo $specs_data[0]->mil_service_fuel?>">
			</div>
			<!-- #####Service Capacities Hydraulic##### -->
			<div class="form-group">
				<label for="mil_service_hydraulic">Hydraulic Tank</label> <input
					type="text" class="form-control" name="mil_service_hydraulic"
					id="mil_service_hydraulic" placeholder="Hydraulic Tank"
					value="<?php echo $specs_data[0]->mil_service_hydraulic?>">
			</div>
		</div>


		<h2>Tires</h2>
		<div class="form-inline">
			<!-- #####Tire size##### -->
			<div class="form-group">
				<label for="mil_tire_size">Tire Size</label> <input type="text"
					class="form-control" name="mil_tire_size" id="mil_tire_size"
					placeholder="Tire Size"
					value="<?php echo $specs_data[0]->mil_tire_size?>">
			</div>
		</div>



		<h2>Brakes</h2>
		<div class="form-inline">
			<!-- #####Brakes Service##### -->
			<div class="form-group">
				<label for="mil_brake_service">Service</label> <input type="text"
					class="form-control" name="mil_brake_service"
					id="mil_brake_service" placeholder="Service"
					value="<?php echo $specs_data[0]->mil_brake_service?>">
			</div>
			<!-- #####Brakes Parking##### -->
			<div class="form-group">
				<label for="mil_brake_parking">Parking</label> <input type="text"
					class="form-control" name="mil_brake_parking"
					id="mil_brake_parking" placeholder="Hydraulic Tank"
					value="<?php echo $specs_data[0]->mil_brake_parking?>">
			</div>
		</div>


		<h2>Additional Data</h2>
		<div class="form-inline">
			<!-- #####Additional Data Electrical System##### -->
			<div class="form-group">
				<label for="mil_electrical_system">Electrical System</label> <input
					type="text" class="form-control" name="mil_electrical_system"
					id="mil_electrical_system" placeholder="Electrical System"
					value="<?php echo $specs_data[0]->mil_electrical_system?>">
			</div>
			<!-- #####Additional Data Alternator##### -->
			<div class="form-group">
				<label for="mil_alternator">Alternator</label> <input type="text"
					class="form-control" id="mil_alternator" name="mil_alternator"
					placeholder="Alternator"
					value="<?php echo $specs_data[0]->mil_alternator?>">
			</div>
		</div>

		<h2>Specs Sheet</h2>
		<div class="form-inline">
			<!-- #####Specs Sheet Upload##### -->
			<div class="form-group">
				<label for="mil_spec_sheet">Specifications Sheet</label> <input
					type="file" class="form-control" name="mil_spec_sheet"
					id="mil_spec_sheet" placeholder="Service"> <label
					for="mil_spec_sheet">Saved Specifications Sheet</label> <input
					type="text" disabled name="stored_spec_sheet" class="form-control"
					value="<?php echo $specs_data[0]->mil_spec_sheet?>">
			</div>
		</div>



	</div>
	<!--
					Gallery Panel
					############################################################
					-->
	<div class="tab-pane well"
		id="editgallery<?php echo $product->mil_product_id;?>">

		<div class="addinput">
			<a href="#" class="addImage btn btn-success"> <span
				class="glyphicon glyphicon-camera"></span> Add Image
			</a> <a href="#" class="addVideo btn btn-success"> <span
				class="glyphicon glyphicon-film"></span> Add YouTube Video
			</a>
		<?php
		$image_template = <<<EOL
				<div class="gallery_image">
					
					<div class="input-group">
						<img class="pull-right" src="###LOCATION###" height="80px">	
						<label for="gallery_image_###COUNT###">Add An Image</label>
						<input type="hidden" name="gallery_image_###COUNT###_id" value="###ID###">
						<input type="file" class="form-control" id="gallery_image_###COUNT###" size="40" name="gallery_image_###COUNT###" value="" placeholder="Upload An Image for Your Gallery">
						<a href="#" data-id = "###ID###" class="input-group-btn removeImage btn btn-danger"><span class="glyphicon glyphicon-minus"></span></a>
					</div>
				</div>
				<div class="clear"></div>
EOL;
		
		$video_template = <<<EOL
				<div class="gallery_video">
					<label for="gallery_video_###COUNT###">Add A YouTube Video</label>
					<div class="input-group">
						<input type="hidden" name="gallery_video_###COUNT###_id" value="###ID###">
						<textarea type="text" class="form-control" id="gallery_video_###COUNT###" size="40" name="gallery_video_###COUNT###" value="" placeholder="Paste Your YouTube Embed code here">###LOCATION###</textarea>
						<a data-id = "###ID###" href="#" class="input-group-btn removeVideo btn btn-danger"><span class="glyphicon glyphicon-minus"></span></a>
					</div>
				</div>
EOL;
		
		$image_count = 0;
		$video_count = 0;
		foreach ( $gallery_data as $gallery_item ) {
			
			switch ($gallery_item->mil_gallery_type) {
				case ('video') :
					$video_count ++;
					$this_template = str_replace ( '###COUNT###', $video_count, $video_template );
					$this_template = str_replace ( '###ID###', $gallery_item->mil_gallery_id, $this_template );
					$this_template = str_replace ( '###LOCATION###', stripslashes ( $gallery_item->mil_gallery_location ), $this_template );
					echo $this_template;
					break;
				case ('image') :
					$image_count ++;
					$this_template = str_replace ( '###COUNT###', $image_count, $image_template );
					$this_template = str_replace ( '###ID###', $gallery_item->mil_gallery_id, $this_template );
					$this_template = str_replace ( '###LOCATION###', $gallery_item->mil_gallery_location, $this_template );
					echo $this_template;
					break;
			}
		}
		?>
		
			<input type="hidden" class="mil_image_count" name="mil_image_count"> <input
				type="hidden" class="mil_video_count" name="mil_video_count">
		</div>
	</div>
</div>
