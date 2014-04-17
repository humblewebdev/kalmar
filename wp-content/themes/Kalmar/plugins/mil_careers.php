<?php 
global $wpdb;

$data = $wpdb->get_results("SELECT careers_introduction, careers_benefits, careers_jobOppurtunities, careers_smallBusiness FROM wp_dummy_sitecareers WHERE careers_id = 1");
?>
<h2>Military Careers Page <span style="font-size: .6em"> - Each section creates its own tab</span></h2>
<div class="wrapper">
	<div class="well">
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">

		<div class="form-group">
  			<label for="mil_contact_page">Introduction</label>
  			<?php wp_editor(stripslashes($data[0]->careers_introduction), 'mil_careers_introduction'); ?>
  		</div>
  		<div class="form-group">
  			<label for="mil_contact_page">Benefits</label>
  			<?php wp_editor(stripslashes($data[0]->careers_benefits), 'mil_careers_benefits'); ?>
  		</div>
  		<div class="form-group">
  			<label for="mil_contact_page">Job Opportunities</label>
  			<?php wp_editor(stripslashes($data[0]->careers_jobOppurtunities), 'mil_careers_jobOppurtunities'); ?>
  		</div>
  		<div class="form-group">
  			<label for="mil_contact_page">Small Business</label>
  			<?php wp_editor(stripslashes($data[0]->careers_smallBusiness), 'mil_careers_smallBusiness'); ?>
  		</div>
  		<button class="btn btn-primary" type="submit">Save Changes</button>
	</form>
	
	</div>
</div>