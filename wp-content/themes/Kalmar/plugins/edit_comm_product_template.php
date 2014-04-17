<?php
global $wpdb;
$product_data = $wpdb->get_results ( "SELECT * FROM wp_dummy_sitecomm_product WHERE comm_product_id = $product->comm_product_id" );
echo $wpdb->last_error;
$features_data = $wpdb->get_results ( "SELECT * FROM wp_dummy_sitecomm_feature WHERE comm_product_id = $product->comm_product_id" );
echo $wpdb->last_error;
$specs_data = $wpdb->get_results ( "SELECT * FROM wp_dummy_sitecomm_specs WHERE comm_product_id = $product->comm_product_id " );
echo $wpdb->last_error;
$gallery_data = $wpdb->get_results ( "SELECT * FROM wp_dummy_sitecomm_gallery WHERE comm_product_id = $product->comm_product_id" );
echo $wpdb->last_error;
?>
<ul class="nav nav-tabs">
	<li class="active"><a
		href="#edithome<?php echo stripslashes ($product->comm_product_id);?>"
		data-toggle="tab">Product</a></li>
	<li><a href="#editfeatures<?php echo $product->comm_product_id;?>"
		data-toggle="tab">Features</a></li>
	<li><a href="#editspecifications<?php echo $product->comm_product_id;?>"
		data-toggle="tab">Specifications</a></li>
	<li><a href="#editgallery<?php echo $product->comm_product_id;?>"
		data-toggle="tab">Gallery</a></li>
</ul>
<div id="error"></div>
<div class="tab-content">

	<!--
			Home Panel
			############################################################
			-->
	<div class="tab-pane well active"
		id="edithome<?php echo $product->comm_product_id; ?>">

		<!--<div class="alert alert-danger" id="productError"></div>-->
		<input type="hidden" name="comm_product_id" id="comm_product_id"
			value="<?php echo $product_data[0]->comm_product_id ?>">
		<div class="form-group">
			<label for="comm_product_name">Product Name</label> <input type="text"
				class="form-control"
				name="comm_product_name<?php echo  $product->comm_product_id?>"
				id="comm_product_name <?php echo  $product->comm_product_id?>"
				placeholder="Product Name"
				value="<?php echo $product_data[0]->comm_product_name ?>">
		</div>

		<div class="form-group">

			<label for="comm_product_image"><img
				src="<?php echo $product_data[0]->comm_product_image;?>"
				height="80px">Product Image (Max Size: 3MB Allowable filetypes: jpg,
				jpeg, png, gif)</label><br> <input type="file"
				name="comm_product_image<?php echo  $product->comm_product_id?>"
				id="comm_product_image<?php echo  $product->comm_product_id?>"
				class="form-control"> <input type="hidden"
				name="comm_product_image_placeholder<?php echo  $product->comm_product_id?>"
				id="comm_product_image_placeholder"
				value="<?php echo $product_data[0]->comm_product_image ?>">
		</div>

		<div class="form-group">
			<label for="comm_product_desc">Product Description</label>
						
		    				<?php wp_editor($product_data[0]->comm_product_desc, 'edit_comm_product_desc'.$product->comm_product_id); ?>
				</div>


	</div>

	<!-- 
					Features Panel
					############################################################
					-->
	<div class="tab-pane well"
		id="editfeatures<?php echo $product->comm_product_id;?>">

		<div class="editfeatures_content">
			<a href="#" class="btn btn-success addProductFeature">Add Feature</a>
				<?php
				if (! empty ( $features_data )) {
					$features_count = count ( $features_data );
					$counter = 1;
					$features_count = <<<EOL
					<input type="hidden" class="comm_features_count" name="comm_features_count{$product->comm_product_id}"
			value="0">
EOL;
					
					foreach ( $features_data as $feature ) {
						
						$features_template = <<<EOL
	
	<div class='form-inline panel'>
	<img class="pull-left" src="{$feature->comm_feature_image}"
				height="120px">
				<input type='hidden'
				name='comm_feature_id{$counter}' id='featureid{$counter}'
		 		value='{$feature->comm_feature_id}'>
	<div class='form-group'>
		<label for='featureTitle{$counter}'>Feature Title</label> <input type='text'
			class='form-control' name='comm_feature_title{$counter}' id='featureTitle{$counter}'
			placeholder='Feature Title' value="{$feature->comm_feature_title}">
	</div>
	<div class='form-group'>
		<label for='featureImage{$counter}'>Feature Image(Leave empty if you dont want to change)</label> <input type='file'
			class='form-control' id='featureImage{$counter}' name='comm_feature_image{$counter}'
			placeholder='Feature Image'>
			<input type="hidden" name="featureImageHolder{$counter}" value="{$feature->comm_feature_image}">
			
	</div>
	<div class='form-group'>
		<label for='bullets{$counter}'>Feature bullet points</label>
		<textarea id='bullets{$counter}' class='form-control'
			name='comm_feature_bullets{$counter}' cols='100'
			placeholder='place each bullet on a new line'>{$feature->comm_feature_bullets}</textarea>
	</div>
	<a href='#' data-id="{$feature->comm_feature_id}" class='pull-right removeProductFeature btn btn-danger'><span
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
		id="editspecifications<?php echo $product->comm_product_id;?>">
		<h2>Engine</h2>
		<div class="form-inline">
			<!-- #####Engine Make##### -->
			<div class="form-group">
				<label for="comm_engine_make">Make</label> <input type="text"
					class="form-control" name="comm_engine_make" id="comm_engine_make"
					placeholder="Engine Make"
					value="<?php echo $specs_data[0]->comm_engine_make?>">
			</div>
			<!-- #####Engine Model##### -->
			<div class="form-group">
				<label for="comm_engine_model">Model</label> <input type="text"
					class="form-control" name="comm_engine_model" id="comm_engine_model"
					placeholder="Engine Model"
					value="<?php echo $specs_data[0]->comm_engine_model?>">
			</div>
			<!-- #####Engine Cylinders##### -->
			<div class="form-group">
				<label for="comm_engine_cylinders">Cylinders</label> <input
					type="text" class="form-control" name="comm_engine_cylinders"
					id="comm_engine_cylinders" placeholder="Engine Cylinders"
					value="<?php echo $specs_data[0]->comm_engine_cylinders?>">
			</div>
			<!-- #####Engine Power##### -->
			<div class="form-group">
				<label for="comm_engine_power">Power</label> <input type="text"
					class="form-control" name="comm_engine_power" id="enginePower"
					placeholder="Engine Power"
					value="<?php echo $specs_data[0]->comm_engine_power?>">
			</div>
			<!-- #####Engine Displacement##### -->
			<div class="form-group">
				<label for="comm_engine_displacement">Displacement</label> <input
					type="text" class="form-control" name="comm_engine_displacement"
					id="comm_engine_displacement" placeholder="Engine Displacement"
					value="<?php echo $specs_data[0]->comm_engine_displacement?>">
			</div>
			<!-- #####Engine Cooling##### -->
			<div class="form-group">
				<label for="comm_engine_cooling">Cooling</label> <input type="text"
					class="form-control" name="comm_engine_cooling"
					id="comm_engine_cooling" placeholder="Engine Cooling"
					value="<?php echo $specs_data[0]->comm_engine_cooling?>">
			</div>
			<!-- #####Engine Fuel##### -->
			<div class="form-group">
				<label for="comm_engine_fuel">Fuel</label> <input type="text"
					class="form-control" name="comm_engine_fuel" id="comm_engine_fuel"
					placeholder="Engine Fuel"
					value="<?php echo $specs_data[0]->comm_engine_fuel?>">
			</div>
		</div>

		<h2>Performance</h2>
		<div class="form-inline">
			<!-- #####Performance Travel Speed Unladen##### -->
			<div class="form-group">
				<label for="comm_performance_speedUnladen">Travel Speed, Unladen</label>
				<input type="text" class="form-control"
					name="comm_performance_speedUnladen"
					id="comm_performance_speedUnladen"
					placeholder="Travel Speed, Unladen"
					value="<?php echo $specs_data[0]->comm_performance_speedUnladen?>">
			</div>
			<!-- #####Performance Travel Speed Laden##### -->
			<div class="form-group">
				<label for="comm_performance_speedLaden">Travel Speed, Laden</label>
				<input type="text" class="form-control"
					name="comm_performance_speedLaden" id="comm_performance_speedLaden"
					placeholder="Travel Speed, Laden"
					value="<?php echo $specs_data[0]->comm_performance_speedLaden?>">
			</div>
			<!-- #####Performance Travel Speed Reverse##### -->
			<div class="form-group">
				<label for="comm_performance_speedReverse">Travel Speed, Reverse</label>
				<input type="text" class="form-control"
					name="comm_performance_speedReverse"
					id="comm_performance_speedReverse"
					placeholder="Travel Speed, Reverse"
					value="<?php echo $specs_data[0]->comm_performance_speedReverse?>">
			</div>
			<!-- #####Performance Gradeability##### -->
			<div class="form-group">
				<label for="comm_performance_gradeability">Gradeablity</label> <input
					type="text" class="form-control"
					name="comm_performance_gradeability"
					id="comm_performance_gradeability" placeholder="Gradeability"
					value="<?php echo $specs_data[0]->comm_performance_gradeability?>">
			</div>
			<!-- #####Performance Unladen##### -->
			<div class="form-group">
				<label for="comm_performance_unladen">Unladen</label> <input
					type="text" class="form-control" name="comm_performance_unladen"
					id="comm_performance_unladen" placeholder="Unladen"
					value="<?php echo $specs_data[0]->comm_performance_unladen?>">
			</div>
			<!-- #####Performance Laden##### -->
			<div class="form-group">
				<label for="comm_performance_laden">Laden</label> <input type="text"
					class="form-control" name="comm_performance_laden"
					id="comm_performance_laden" placeholder="Laden"
					value="<?php echo $specs_data[0]->comm_performance_laden?>">
			</div>
			<!-- #####Performance Fording Depth##### -->
			<div class="form-group">
				<label for="comm_performance_fordingDepth">Fording Depth</label> <input
					type="text" class="form-control"
					name="comm_performance_fordingDepth"
					id="comm_performance_fordingDepth" placeholder="Fording Depth"
					value="<?php echo $specs_data[0]->comm_performance_fordingDepth?>">
			</div>
		</div>

		<h2>Transmission</h2>
		<div class="form-inline">
			<!-- #####Transmission Make##### -->
			<div class="form-group">
				<label for="comm_transmission_make">Transmission Make</label> <input
					type="text" class="form-control" name="comm_transmission_make"
					id="comm_transmission_make" placeholder="Transmission Make"
					value="<?php echo $specs_data[0]->comm_transmission_make?>">
			</div>
			<!-- #####Transmission Model##### -->
			<div class="form-group">
				<label for="comm_transmission_model">Transmission Model</label> <input
					type="text" class="form-control" name="comm_transmission_model"
					id="comm_transmission_model" placeholder="Transmission Model"
					value="<?php echo $specs_data[0]->comm_transmission_model?>">
			</div>
			<!-- #####Transmission Type##### -->
			<div class="form-group">
				<label for="comm_transmission_type">Transmission Type</label> <input
					type="text" class="form-control" name="comm_transmission_type"
					id="comm_tranmission_type" placeholder="Transmission Type"
					value="<?php echo $specs_data[0]->comm_transmission_type?>">
			</div>
			<!-- #####Transmission Gears##### -->
			<div class="form-group">
				<label for="comm_transmission_gears">Transmission Gears</label> <input
					type="text" class="form-control" name="comm_transmission_gears"
					id="comm_transmission_gears" placeholder="Transmission Gears"
					value="<?php echo $specs_data[0]->comm_transmission_gears?>">
			</div>
		</div>

		<h2>Weight</h2>
		<div class="form-inline">
			<!-- #####Weight Curb Weight##### -->
			<div class="form-group">
				<label for="comm_weight_curb">Curb Weight</label> <input type="text"
					class="form-control" name="comm_weight_curb" id="comm_weight_curb"
					placeholder="Curb Weight"
					value="<?php echo $specs_data[0]->comm_weight_curb?>">
			</div>
			<!-- #####Weight Front Axel##### -->
			<div class="form-group">
				<label for="comm_weight_frontAxelWeight">Front Axel Weight</label> <input
					type="text" class="form-control" name="comm_weight_frontAxelWeight"
					id="comm_weight_frontAxelWeight" placeholder="Front Axel Weight"
					value="<?php echo $specs_data[0]->comm_weight_frontAxelWeight?>">
			</div>
			<!-- #####Weight Rear Axel##### -->
			<div class="form-group">
				<label for="comm_weight_rearAxelWeight">Rear Axel Weight</label> <input
					type="text" class="form-control" name="comm_weight_rearAxelWeight"
					id="comm_weight_rearAxelWeight" placeholder="Rear Axel Weight"
					value="<?php echo $specs_data[0]->comm_weight_rearAxelWeight?>">
			</div>
		</div>


		<h2>Axels</h2>
		<div class="form-inline">
			<!-- #####Axels Make##### -->
			<div class="form-group">
				<label for="comm_axel_make">Axels Make</label> <input type="text"
					class="form-control" name="comm_axel_make" id="comm_axel_make"
					placeholder="Axels Make"
					value="<?php echo $specs_data[0]->comm_axel_make?>">
			</div>
			<div class="form-group">
				<label for="comm_axel_model">Axels Model</label> <input type="text"
					class="form-control" name="comm_axel_model" id="comm_axel_model"
					placeholder="Axels Make"
					value="<?php echo $specs_data[0]->comm_axel_model?>">
			</div>
			<!-- #####Axels Front Model##### -->
			<div class="form-group">
				<label for="comm_axel_frontModel">Front Axel Model</label> <input
					type="text" class="form-control" name="comm_axel_frontModel"
					id="comm_axel_frontModel" placeholder="Front Axel Model"
					value="<?php echo $specs_data[0]->comm_axel_frontModel?>">
			</div>
			<!-- #####Axels Rear Model##### -->
			<div class="form-group">
				<label for="comm_axel_rearModel">Rear Axel Model</label> <input
					type="text" class="form-control" name="comm_axel_rearModel"
					id="comm_axel_rearModel" placeholder="Rear Axel Model"
					value="<?php echo $specs_data[0]->comm_axel_rearModel?>">
			</div>
		</div>

		<h2>Service Capacity</h2>
		<div class="form-inline">
			<!-- #####Service Capacities Fuel##### -->
			<div class="form-group">
				<label for="comm_service_fuel">Fuel Tank</label> <input type="text"
					class="form-control" name="comm_service_fuel" id="comm_service_fuel"
					placeholder="Fuel Tank"
					value="<?php echo $specs_data[0]->comm_service_fuel?>">
			</div>
			<!-- #####Service Capacities Hydraulic##### -->
			<div class="form-group">
				<label for="comm_service_hydraulic">Hydraulic Tank</label> <input
					type="text" class="form-control" name="comm_service_hydraulic"
					id="comm_service_hydraulic" placeholder="Hydraulic Tank"
					value="<?php echo $specs_data[0]->comm_service_hydraulic?>">
			</div>
		</div>


		<h2>Tires</h2>
		<div class="form-inline">
			<!-- #####Tire size##### -->
			<div class="form-group">
				<label for="comm_tire_size">Tire Size</label> <input type="text"
					class="form-control" name="comm_tire_size" id="comm_tire_size"
					placeholder="Tire Size"
					value="<?php echo $specs_data[0]->comm_tire_size?>">
			</div>
		</div>



		<h2>Brakes</h2>
		<div class="form-inline">
			<!-- #####Brakes Service##### -->
			<div class="form-group">
				<label for="comm_brake_service">Service</label> <input type="text"
					class="form-control" name="comm_brake_service"
					id="comm_brake_service" placeholder="Service"
					value="<?php echo $specs_data[0]->comm_brake_service?>">
			</div>
			<!-- #####Brakes Parking##### -->
			<div class="form-group">
				<label for="comm_brake_parking">Parking</label> <input type="text"
					class="form-control" name="comm_brake_parking"
					id="comm_brake_parking" placeholder="Hydraulic Tank"
					value="<?php echo $specs_data[0]->comm_brake_parking?>">
			</div>
		</div>


		<h2>Additional Data</h2>
		<div class="form-inline">
			<!-- #####Additional Data Electrical System##### -->
			<div class="form-group">
				<label for="comm_electrical_system">Electrical System</label> <input
					type="text" class="form-control" name="comm_electrical_system"
					id="comm_electrical_system" placeholder="Electrical System"
					value="<?php echo $specs_data[0]->comm_electrical_system?>">
			</div>
			<!-- #####Additional Data Alternator##### -->
			<div class="form-group">
				<label for="comm_alternator">Alternator</label> <input type="text"
					class="form-control" id="comm_alternator" name="comm_alternator"
					placeholder="Alternator"
					value="<?php echo $specs_data[0]->comm_alternator?>">
			</div>
		</div>

		<!--<h2>Specs Sheet</h2>
		<div class="form-inline">-->
			<!-- #####Specs Sheet Upload##### -->
			<!--<div class="form-group">
				<label for="comm_spec_sheet">Specifications Sheet</label> <input
					type="file" class="form-control" name="comm_spec_sheet"
					id="comm_spec_sheet" placeholder="Service"> <label
					for="comm_spec_sheet">Saved Specifications Sheet</label> <input
					type="text" disabled name="stored_spec_sheet" class="form-control"
					value="<?php echo $specs_data[0]->comm_spec_sheet?>">
			</div>
		</div>-->



	</div>
	<!--
					Gallery Panel
					############################################################
					-->
	<div class="tab-pane well"
		id="editgallery<?php echo $product->comm_product_id;?>">

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
				<div class="clear"></div>
EOL;
		
		$image_count = 0;
		$video_count = 0;
		foreach ( $gallery_data as $gallery_item ) {
			
			switch ($gallery_item->comm_gallery_type) {
				case ('video') :
					$video_count ++;
					$this_template = str_replace ( '###COUNT###', $video_count, $video_template );
					$this_template = str_replace ( '###ID###', $gallery_item->comm_gallery_id, $this_template );
					$this_template = str_replace ( '###LOCATION###', stripslashes ( $gallery_item->comm_gallery_location ), $this_template );
					echo $this_template;
					break;
				case ('image') :
					$image_count ++;
					$this_template = str_replace ( '###COUNT###', $image_count, $image_template );
					$this_template = str_replace ( '###ID###', $gallery_item->comm_gallery_id, $this_template );
					$this_template = str_replace ( '###LOCATION###', $gallery_item->comm_gallery_location, $this_template );
					echo $this_template;
					break;
			}
		}
		?>
		
			<input type="hidden" class="comm_image_count" name="comm_image_count"> <input
				type="hidden" class="comm_video_count" name="comm_video_count">
		</div>
	</div>
</div>
