<?php
global $wpdb;
$support_service_data = $wpdb->get_results ( "SELECT support_manuals, support_parts, support_service, support_training, support_warranty, support_sourcing FROM wp_dummy_sitesupportServices WHERE support_id = 1" );

?>
<h2>Support Pages for Military Products <span style="font-size: .6em"> - Each section creates its own tab</span></h2>
<div class="wrapper">
	<div class="well">
		<h2>Manuals</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<input type="hidden" name="">
			<div class="form-group">
			<?php wp_editor(stripslashes ($support_service_data[0]->support_manuals), 'mil_manuals_desc'); ?>
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
			<?php wp_editor(stripslashes ($support_service_data[0]->support_parts), 'mil_parts_desc'); ?>
		</div>
			<button class="btn btn-primary" type="submit">Save Changes</button>
		</form>
	</div>
	<div class="well">
		<h2>Service</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<input type="hidden" name="">
			<div class="form-group">
			<?php wp_editor(stripslashes ($support_service_data[0]->support_service), 'mil_service_desc'); ?>
		</div>
			<button class="btn btn-primary" type="submit">Save Changes</button>
		</form>
	</div>
	<div class="well">
		<h2>Training</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<input type="hidden" name="">
			<div class="form-group">
			<?php wp_editor(stripslashes ($support_service_data[0]->support_training), 'mil_training_desc'); ?>
		</div>
			<button class="btn btn-primary" type="submit">Save Changes</button>
		</form>
	</div>
	<div class="well">
		<h2>Warranty</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<input type="hidden" name="">
			<div class="form-group">
			<?php wp_editor(stripslashes ($support_service_data[0]->support_warranty), 'mil_warranty_desc'); ?>
		</div>
			<button class="btn btn-primary" type="submit">Save Changes</button>
		</form>
	</div>
	<div class="well">
		<h2>Sourcing</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<input type="hidden" name="">
			<div class="form-group">
			<?php wp_editor(stripslashes ($support_service_data[0]->support_sourcing), 'mil_sourcing_desc'); ?>
		</div>
			<button class="btn btn-primary" type="submit">Save Changes</button>
		</form>
	</div>
	
</div>