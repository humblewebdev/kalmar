<?php
global $wpdb;
$support_service_data = $wpdb->get_results( "SELECT * FROM wp_dummy_sitesupportServices WHERE support_id = 2" );
?>
<h2>Pages for Commercial Products<span style="font-size: .6em"> - Each section creates its own tab</span></h2>
<div class="wrapper">
	<div class="well">
		<h2>Service</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<div class="form-group">
			<?php wp_editor($support_service_data[0]->support_service, 'com_service_desc'); ?>
		</div>
			<button class="btn btn-primary" type="submit">Save Changes</button>
	
	</div>
	<div class="well">
		<h2>Financing</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<div class="form-group">
			<?php wp_editor($support_service_data[0]->support_financing, 'com_financing_desc'); ?>
		</div>
			<button class="btn btn-primary" type="submit">Save Changes</button>
	
	</div>
	<div class="well">
		<h2>Manuals</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<input type="hidden" name="">
			<div class="form-group">
			<?php wp_editor($support_service_data[0]->support_manuals, 'com_manuals_desc'); ?>
		</div>
			<button class="btn btn-primary" type="submit">Save Changes</button>
		</form>
	</div>
	<div class="well">
		<h2>Parts</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<input type="hidden" name="">
			<div class="form-group">
			<?php wp_editor($support_service_data[0]->support_parts, 'com_parts_desc'); ?>
		</div>
			<button class="btn btn-primary" type="submit">Save Changes</button>
		</form>
	</div>
	<div class="well">
		<h2>Training</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<div class="form-group">
			<?php wp_editor($support_service_data[0]->support_training, 'com_training_desc'); ?>
		</div>
			<button class="btn btn-primary">Save Changes</button>
		</form>
	</div>
	<div class="well">
		<h2>Warranty</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<div class="form-group">
			<?php wp_editor($support_service_data[0]->support_warranty, 'com_warranty_desc'); ?>
		</div>
			<button class="btn btn-primary" type="submit">Save Changes</button>
		</form>
	</div>
	<div class="well">
		<h2>Sourcing</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<div class="form-group">
			<?php wp_editor($support_service_data[0]->support_sourcing, 'com_sourcing_desc'); ?>
		</div>
			<button class="btn btn-primary" type="submit">Save Changes</button>
		</form>
	</div>
</div>