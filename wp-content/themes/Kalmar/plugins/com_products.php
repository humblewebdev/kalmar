<style>
#wp-featureContent-wrap {
	width: 1000px;
}

textarea {
	resize: vertical;
}

.wrapper {
	width: 100%;
	padding: 0 20px;
}

#featureContent {
	height: 100px;
}

.modal-dialog {
	width: 80%;
}
</style>
<script src="http://malsup.github.com/jquery.form.js"></script>

<div class="wrapper">
	<h1>Commercial Products</h1>
	<?php
	global $wpdb;
	
	$products = $wpdb->get_results ( "SELECT comm_product_id, comm_product_name, comm_product_image, comm_product_desc FROM wp_dummy_sitecomm_product" );
	?>
	
	<?php
	foreach ( $products as $product ) {
		?>
	
	<div class="modal fade"
		id="myModal<?php echo $product->comm_product_id;?>" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"><?php echo 'Edit '.$product->comm_product_name;?></h4>
				</div>

				<div class="modal-body">
					<form class="editForm"
						action="/kalmar/wp-admin/admin-ajax.php" method="post"
						enctype="multipart/form-data">
						<fieldset>
									<?php include (get_theme_root () . '/Kalmar/plugins/edit_comm_product_template.php');?>
						<div class="progress progress-striped active">
								<div class="progress-bar progress-bar-danger" role="progressbar"
									aria-valuemin="0" aria-valuemax="100">
									<span class="sr-only">45% Complete</span>
								</div>
							</div>
							<div id="message"></div>
							<input type="hidden" name="action" value="editComm" />
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
							</fieldset>
				</form>
				</div>
				<div class="modal-footer">
					
					
					

				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
			<?php
	}
	?>	
				
	<div class="table-responsive panel panel-default">
		<table class="table table-striped">
			<tbody>
				<tr>
					<td>Image</td>
					<td>Name</td>
					<td>Description</td>
					<td>Options</td>
				</tr>
				<?php
				foreach ( $products as $product ) {
					?>
					
						
				<tr>
					<td><img class="img-rounded"
						src="<?php echo $product->comm_product_image;?>" height="180px"</td>
					<td><?php echo $product->comm_product_name;?></td>
					<td><?php echo $product->comm_product_desc;?></td>
					<td><button class="btn btn-primary" data-toggle="modal"
							data-target="#myModal<?php echo $product->comm_product_id;?>">
							<span class="glyphicon glyphicon-cog"></span> edit
						</button>
						<button class="btn btn-danger">
							<span class="glyphicon glyphicon-minus-sign"></span> Delete
						</button></td>
				</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>

<h2>Add a New Product <span style="font-size: .6em"> - Use this Form Below</span></h2>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#home" data-toggle="tab">Product</a></li>
		<li><a href="#features" data-toggle="tab">Features</a></li>
		<li><a href="#specifications" data-toggle="tab">Specifications</a></li>
		<li><a href="#gallery" data-toggle="tab">Gallery</a></li>
	</ul>
	<div id="error"></div>

	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
		enctype="multipart/form-data">
		<div class="tab-content">

			<!--
			Home Panel
			############################################################
			-->
			<div class="tab-pane well active" id="home">

				<!--<div class="alert alert-danger" id="productError"></div>-->

				<div class="form-group">
					<label for="comm_product_name">Product Name</label> <input
						type="text" class="form-control" name="comm_product_name"
						id="comm_product_name" placeholder="Product Name"
						value="<?php echo (!empty($_POST['comm_product_name'])) ? $_POST['comm_product_name'] : '' ?>">
				</div>

				<div class="form-group">
					<label for="comm_product_image">Product Image (Max Size: 3MB
						Allowable filetypes: jpg, jpeg, png, gif)</label><br> <input
						type="file" name="comm_product_image" id="comm_product_image"
						class="form-control" value="">
				</div>

				<div class="form-group">
					<label for="comm_product_desc">Product Description</label>
		    				<?php wp_editor($content, 'comm_product_desc'); ?>
				</div>


			</div>

			<!-- 
					Features Panel
					############################################################
					-->
			<div class="tab-pane well" id="features">
				<input type="hidden" class="comm_features_count"
					name="comm_features_count" value="0">
				<div class="editfeatures_content">
					<a href="#" class="btn btn-success addProductFeature">Add Feature</a>
				</div>
					<script>
				$(document).ready(function() {
					$(document).on('click', '.addProductFeature', function(){
						var addDiv = $(this).parent('.editfeatures_content');
						var j = $(this).closest('.editfeatures_content ').children('.form-inline').size();
						$(this).closest('.comm_features_count').val(j);
						console.log(j);
						if(j<=50){
							j++;
							$("<div class='form-inline panel'><div class='form-group'><label for='featureTitle"+j+"'>Feature Title</label> <input type='text' class='form-control' name='comm_feature_title"+j+"' id='featureTitle"+ j +"' placeholder='Feature Title'></div><div class='form-group'><label for='featureImage"+j+"'>Feature Image</label> <input type='file' class='form-control' id='featureImage"+j+"' name='comm_feature_image"+j+"' placeholder='Feature Image'></div><div class='form-group'><label for='bullets"+j+"'>Feature bullet points</label><textarea id='bullets"+j+"' class='form-control' name='comm_feature_bullets"+j+"' cols='100' placeholder='place each bullet on a new line'></textarea></div><a href='#' class='pull-right removeFeature btn btn-danger'><span class='glyphicon glyphicon-minus'></span></a></div>").appendTo(addDiv);
							$('#comm_features_count').val(j);
							console.log(j);
							return false;
						} else {
							var error = $('#error');
							$('<div class="alert alert-danger">Maximum allowable input fields met.</div>').appendTo(error);
							$("#error").show().delay(5000).fadeOut();
						}
					});

					$(document).on('click','.removeProductFeature', function(){
						var id = $(this).data("id");
						var j = $(this).closest('.editfeatures_content ').children('.form-inline').size();
						if(typeof(id) != "undefined" && id !== null) {	
							if (confirm('Are you sure you want to delete this feature?')) {
								jQuery.ajax({

									type:"POST",

									url: "http://webtegstage.com/kalmar/wp-admin/admin-ajax.php", // our PHP handler file

									data: {action: 'deleteFromCommFeatures', featureid: id},

									success:function(results){
										console.log(results);
									}

								});
								$(this).parent('.form-inline').remove();
								var j = $(this).closest('.editfeatures_content ').children('.form-inline').size();
								$('#comm_features_count').val(j);
							} else {
							    // Do nothing!
							}									
						}else {
							$(this).parent('.form-inline').remove();
							var j = $(this).closest('.editfeatures_content ').children('.form-inline').size();
							$('#comm_features_count').val(j);
						}
					});	
				
				});

				</script>
			</div>
			<!-- 
					Specifications Panel
					############################################################
					-->
			<div class="tab-pane well" id="specifications">
				<h2>Engine</h2>
				<div class="form-inline">
					<!-- #####Engine Make##### -->
					<div class="form-group">
						<label for="comm_engine_make">Make</label> <input type="text"
							class="form-control" name="comm_engine_make" id="comm_engine_make"
							placeholder="Engine Make">
					</div>
					<!-- #####Engine Model##### -->
					<div class="form-group">
						<label for="comm_engine_model">Model</label> <input type="text"
							class="form-control" name="comm_engine_model"
							id="comm_engine_model" placeholder="Engine Model">
					</div>
					<!-- #####Engine Cylinders##### -->
					<div class="form-group">
						<label for="comm_engine_cylinders">Cylinders</label> <input
							type="text" class="form-control" name="comm_engine_cylinders"
							id="comm_engine_cylinders" placeholder="Engine Cylinders">
					</div>
					<!-- #####Engine Power##### -->
					<div class="form-group">
						<label for="comm_engine_power">Power</label> <input type="text"
							class="form-control" name="comm_engine_power" id="enginePower"
							placeholder="Engine Power">
					</div>
					<!-- #####Engine Displacement##### -->
					<div class="form-group">
						<label for="comm_engine_displacement">Displacement</label> <input
							type="text" class="form-control" name="comm_engine_displacement"
							id="comm_engine_displacement" placeholder="Engine Displacement">
					</div>
					<!-- #####Engine Cooling##### -->
					<div class="form-group">
						<label for="comm_engine_cooling">Cooling</label> <input type="text"
							class="form-control" name="comm_engine_cooling"
							id="comm_engine_cooling" placeholder="Engine Cooling">
					</div>
					<!-- #####Engine Fuel##### -->
					<div class="form-group">
						<label for="comm_engine_fuel">Fuel</label> <input type="text"
							class="form-control" name="comm_engine_fuel" id="comm_engine_fuel"
							placeholder="Engine Fuel">
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
							placeholder="Travel Speed, Unladen">
					</div>
					<!-- #####Performance Travel Speed Laden##### -->
					<div class="form-group">
						<label for="comm_performance_speedLaden">Travel Speed, Laden</label>
						<input type="text" class="form-control"
							name="comm_performance_speedLaden" id="comm_performance_speedLaden"
							placeholder="Travel Speed, Laden">
					</div>
					<!-- #####Performance Travel Speed Reverse##### -->
					<div class="form-group">
						<label for="comm_performance_speedReverse">Travel Speed, Reverse</label>
						<input type="text" class="form-control"
							name="comm_performance_speedReverse"
							id="comm_performance_speedReverse"
							placeholder="Travel Speed, Reverse">
					</div>
					<!-- #####Performance Gradeability##### -->
					<div class="form-group">
						<label for="comm_performance_gradeability">Gradeablity</label> <input
							type="text" class="form-control"
							name="comm_performance_gradeability"
							id="comm_performance_gradeability" placeholder="Gradeability">
					</div>
					<!-- #####Performance Unladen##### -->
					<div class="form-group">
						<label for="comm_performance_unladen">Unladen</label> <input
							type="text" class="form-control" name="comm_performance_unladen"
							id="comm_performance_unladen" placeholder="Unladen">
					</div>
					<!-- #####Performance Laden##### -->
					<div class="form-group">
						<label for="comm_performance_laden">Laden</label> <input
							type="text" class="form-control" name="comm_performance_laden"
							id="comm_performance_laden" placeholder="Laden">
					</div>
					<!-- #####Performance Fording Depth##### -->
					<div class="form-group">
						<label for="comm_performance_fordingDepth">Fording Depth</label> <input
							type="text" class="form-control"
							name="comm_performance_fordingDepth"
							id="comm_performance_fordingDepth" placeholder="Fording Depth">
					</div>
				</div>

				<h2>Transmission</h2>
				<div class="form-inline">
					<!-- #####Transmission Make##### -->
					<div class="form-group">
						<label for="comm_transmission_make">Transmission Make</label> <input
							type="text" class="form-control" name="comm_transmission_make"
							id="comm_transmission_make" placeholder="Transmission Make">
					</div>
					<!-- #####Transmission Model##### -->
					<div class="form-group">
						<label for="comm_transmission_model">Transmission Model</label> <input
							type="text" class="form-control" name="comm_transmission_model"
							id="comm_transmission_model" placeholder="Transmission Model">
					</div>
					<!-- #####Transmission Type##### -->
					<div class="form-group">
						<label for="comm_transmission_type">Transmission Type</label> <input
							type="text" class="form-control" name="comm_transmission_type"
							id="comm_tranmission_type" placeholder="Transmission Type">
					</div>
					<!-- #####Transmission Gears##### -->
					<div class="form-group">
						<label for="comm_transmission_gears">Transmission Gears</label> <input
							type="text" class="form-control" name="comm_transmission_gears"
							id="comm_transmission_gears" placeholder="Transmission Gears">
					</div>
				</div>

				<h2>Weight</h2>
				<div class="form-inline">
					<!-- #####Weight Curb Weight##### -->
					<div class="form-group">
						<label for="comm_weight_curb">Curb Weight</label> <input
							type="text" class="form-control" name="comm_weight_curb"
							id="comm_weight_curb" placeholder="Curb Weight">
					</div>
					<!-- #####Weight Front Axel##### -->
					<div class="form-group">
						<label for="comm_weight_frontAxelWeight">Front Axel Weight</label>
						<input type="text" class="form-control"
							name="comm_weight_frontAxelWeight" id="comm_weight_frontAxelWeight"
							placeholder="Front Axel Weight">
					</div>
					<!-- #####Weight Rear Axel##### -->
					<div class="form-group">
						<label for="comm_weight_rearAxelWeight">Rear Axel Weight</label> <input
							type="text" class="form-control" name="comm_weight_rearAxelWeight"
							id="comm_weight_rearAxelWeight" placeholder="Rear Axel Weight">
					</div>
				</div>


				<h2>Axels</h2>
				<div class="form-inline">
					<!-- #####Axels Make##### -->
					<div class="form-group">
						<label for="comm_axel_make">Axels Make</label> <input type="text"
							class="form-control" name="comm_axel_make" id="comm_axel_make"
							placeholder="Axels Make">
					</div>
					<div class="form-group">
						<label for="comm_axel_model">Axels Model</label> <input type="text"
							class="form-control" name="comm_axel_model" id="comm_axel_model"
							placeholder="Axels Make">
					</div>
					<!-- #####Axels Front Model##### -->
					<div class="form-group">
						<label for="comm_axel_frontModel">Front Axel Model</label> <input
							type="text" class="form-control" name="comm_axel_frontModel"
							id="comm_axel_frontModel" placeholder="Front Axel Model">
					</div>
					<!-- #####Axels Rear Model##### -->
					<div class="form-group">
						<label for="comm_axel_rearModel">Rear Axel Model</label> <input
							type="text" class="form-control" name="comm_axel_rearModel"
							id="comm_axel_rearModel" placeholder="Rear Axel Model">
					</div>
				</div>

				<h2>Service Capacity</h2>
				<div class="form-inline">
					<!-- #####Service Capacities Fuel##### -->
					<div class="form-group">
						<label for="comm_service_fuel">Fuel Tank</label> <input type="text"
							class="form-control" name="comm_service_fuel"
							id="comm_service_fuel" placeholder="Fuel Tank">
					</div>
					<!-- #####Service Capacities Hydraulic##### -->
					<div class="form-group">
						<label for="comm_service_hydraulic">Hydraulic Tank</label> <input
							type="text" class="form-control" name="comm_service_hydraulic"
							id="comm_service_hydraulic" placeholder="Hydraulic Tank">
					</div>
				</div>


				<h2>Tires</h2>
				<div class="form-inline">
					<!-- #####Tire size##### -->
					<div class="form-group">
						<label for="comm_tire_size">Tire Size</label> <input type="text"
							class="form-control" name="comm_tire_size" id="comm_tire_size"
							placeholder="Tire Size">
					</div>
				</div>



				<h2>Brakes</h2>
				<div class="form-inline">
					<!-- #####Brakes Service##### -->
					<div class="form-group">
						<label for="comm_brake_service">Service</label> <input type="text"
							class="form-control" name="comm_brake_service"
							id="comm_brake_service" placeholder="Service">
					</div>
					<!-- #####Brakes Parking##### -->
					<div class="form-group">
						<label for="comm_brake_parking">Parking</label> <input type="text"
							class="form-control" name="comm_brake_parking"
							id="comm_brake_parking" placeholder="Hydraulic Tank">
					</div>
				</div>


				<h2>Additional Data</h2>
				<div class="form-inline">
					<!-- #####Additional Data Electrical System##### -->
					<div class="form-group">
						<label for="comm_electrical_system">Electrical System</label> <input
							type="text" class="form-control" name="comm_electrical_system"
							id="comm_electrical_system" placeholder="Electrical System">
					</div>
					<!-- #####Additional Data Alternator##### -->
					<div class="form-group">
						<label for="comm_alternator">Alternator</label> <input type="text"
							class="form-control" id="comm_alternator" name="comm_alternator"
							placeholder="Alternator">
					</div>
				</div>

				<!--<h2>Specs Sheet</h2>
				<div class="form-inline">
					#####Specs Sheet Upload#####
					<div class="form-group">
						<label for="comm_spec_sheet">Specifications Sheet</label> <input
							type="file" class="form-control" name="comm_spec_sheet"
							id="comm_spec_sheet" placeholder="Service">
					</div>
				</div>-->



			</div>
			<!--
					Gallery Panel
					############################################################
					-->
			<div class="tab-pane well" id="gallery">
				<script>
					$(document).ready(function(){
						$(document).on('click', '.addImage', function(){
							var imageCount = $(this).siblings('.gallery_image').length;
							var addDiv = $(this).closest('.addinput');
							console.log(imageCount);
							if(imageCount<=50){
								imageCount++;
								$('<div class="gallery_image"><label for="gallery_image_'+ imageCount +'">Add An Image</label><div class="input-group"><input type="file" class="form-control" id="gallery_image_'+ imageCount +'" size="40" name="gallery_image_'+ imageCount +'" value="" placeholder="Upload An Image for Your Gallery"><a href="#" class="input-group-btn removeImage btn btn-danger"><span class="glyphicon glyphicon-minus"></span></a></div></div>').prependTo(addDiv);
								$(this).closest('.comm_image_count').val(imageCount);
								return false;
							} else {
								var error = $(this).closest('.error');
								$('<div class="alert alert-danger">Maximum allowable input fields met.</div>').appendTo(error);
								$("#error").show().delay(5000).fadeOut();
							}
						});

						$(document).on('click', '.addVideo', function(){
							var addDiv = $(this).closest('.addinput');
							var videoCount = $(this).siblings('.gallery_video').length;
							if(videoCount<=50){
								videoCount++;
								$('<div class="gallery_video"><label for="gallery_video_'+ videoCount +'">Add A YouTube Video</label><div class="input-group"><input type="text" class="form-control" id="gallery_video_'+ videoCount +'" size="40" name="gallery_video_'+ videoCount +'" value="" placeholder="Paste Your YouTube Embed code here"><a href="#" class="input-group-btn removeVideo btn btn-danger"><span class="glyphicon glyphicon-minus"></span></a></div></div>').prependTo(addDiv);
								$('.comm_video_count').val(videoCount);
								return false;
							} else {
								var error = $('#error');
								$('<div class="alert alert-danger">Maximum allowable input fields met.</div>').appendTo(error);
								$("#error").show().delay(5000).fadeOut();
							}
						});
						
						$(document).on('click','.removeImage', function(){
							var imageCount = $(this).closest('#addinput .gallery_image').size();
							var id = $(this).data("id");
							if(typeof(id) != "undefined" && id !== null) {	
								if (confirm('Are you sure you want to delete this item from the gallery?')) {
									jQuery.ajax({

										type:"POST",

										url: "admin-ajax.php", // our PHP handler file

										data: {action: 'deleteFromCommGallery', galleryid: id},

										success:function(results){
											console.log(results);
										}

									});
									var paragraph = $(this).parents('.gallery_image').remove();
									imageCount--;
									$(this).closest('.comm_image_count').val(imageCount);
								} else {
								    // Do nothing!
								}									
							}else {
									var paragraph = $(this).parents('.gallery_image').remove();
									imageCount--;
									$(this).closest('.comm_image_count').val(imageCount);
							}
									
						});
						$(document).on('click','.removeVideo', function(){
							var videoCount = $(this).closest('#addinput .gallery_image').size();
							var id = $(this).data("id");
							if(typeof(id) != "undefined" && id !== null) {	
								if (confirm('Are you sure you want to delete this item from the gallery?')) {
									jQuery.ajax({

										type:"POST",

										url: "admin-ajax.php", // our PHP handler file

										data: {action: 'deleteFromCommGallery', galleryid: id},

										success:function(results){
											console.log(results);
										}

									});
									var paragraph = $(this).parents('.gallery_video').remove();
									videoCount--;
									$(this).closest('.comm_video_count').val(videoCount);
								} else {
								    // Do nothing!
								}									
							}else {
								var paragraph = $(this).parents('.gallery_video').remove();
								videoCount--;
								$(this).closest('.comm_video_count').val(videoCount);
							}
						
							//var paragraph = $(this).parents('.gallery_video').remove();
							videoCount--;
							$(this).closest('.comm_video_count').val(videoCount);
						});
					});
				</script>


				<div class="addinput">
					<a href="#" class="addImage btn btn-success"> <span
						class="glyphicon glyphicon-camera"></span> Add Image
					</a> <a href="#" class="addVideo btn btn-success"> <span
						class="glyphicon glyphicon-film"></span> Add YouTube Video
					</a> <input type="hidden" class="comm_image_count"
						name="comm_image_count"> <input type="hidden" class="comm_video_count"
						name="comm_video_count">
				</div>
			</div>
		</div>
		<input class="btn btn-primary" type="submit"
			value="Add commercial Product" />
	</form>

	<script
		src="<?php echo get_template_directory_uri();?>/plugins/updateProduct.js"></script>