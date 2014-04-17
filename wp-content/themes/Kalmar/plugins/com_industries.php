<?php
global $wpdb;
$support_service_data = $wpdb->get_results ( "SELECT industries_energy, industries_heavyConstruction, industries_logistics, industries_naturalResources, industries_govMil FROM wp_dummy_siteindustries WHERE industries_id = 1" );
echo $wpdb->last_error;

?>
<h2>Kalmar Industries <span style="font-size: .6em"> - Each section creates its own tab</span></h2>
<div class="wrapper">
	<div class="well">
		<h2>Energy</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<input type="hidden" name="">
			<div class="form-group">
			<?php wp_editor(stripslashes ($support_service_data[0]->industries_energy), 'industries_energy'); ?>
		</div>
			<button class="btn btn-primary" type="submit">Save Changes</button>
		</form>
	</div>
	<div class="well">
		<h2>Heavy Construction</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<input type="hidden" name="">
			<div class="form-group">
			<?php wp_editor(stripslashes ($support_service_data[0]->industries_heavyConstruction), 'industries_heavyConstruction'); ?>
		</div>
			<button class="btn btn-primary" type="submit">Save Changes</button>
		</form>
	</div>
	<div class="well">
		<h2>Logistics</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<div class="form-group">
			<?php wp_editor(stripslashes ($support_service_data[0]->industries_logistics), 'industries_logistics'); ?>
		</div>
			<button class="btn btn-primary" type="submit">Save Changes</button>
	
	</div>
	<div class="well">
		<h2>Natural Resources</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<div class="form-group">
			<?php wp_editor(stripslashes ($support_service_data[0]->industries_naturalResources), 'industries_naturalResources'); ?>
		</div>
			<button class="btn btn-primary">Save Changes</button>
		</form>
	</div>
	<!-- <div class="well">
		<h2>Government / Military</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<div class="form-group">
			<?php wp_editor(stripslashes ($support_service_data[0]->industries_govMil), 'industries_govMil'); ?>
		</div>
			<button class="btn btn-primary">Save Changes</button>
		</form>
	</div> -->
	
</div>