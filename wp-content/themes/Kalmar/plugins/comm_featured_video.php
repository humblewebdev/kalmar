<?php 
global $wpdb;
$featured_data = $wpdb->get_results("SELECT featured_video, featured_title, featured_text FROM wp_dummy_sitefeaturedVideopages WHERE featured_id = 2");
?>



<h2>Featured Video <span style="font-size: .6em"> - Contains a dropdown with video and text</span></h2>
<div class="wrapper">
	<div class="well">
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
		<div class="form-group">
    		<label for="mil_featured_video">Video</label>
    		<textarea class="form-control" id="mil_featured_video" name="mil_feature_video"> <?php echo stripslashes($featured_data[0]->featured_video);?> </textarea>
  		</div>
  		<div class="form-group">
    		<label for="mil_featured_title">Title</label>
    		<input type="text" class="form-control" id="mil_featured_title" name="mil_feature_title" value="<?php echo stripslashes($featured_data[0]->featured_title); ?>" placeholder="Give Your Featured Text a title">
  		</div>
  		<div class="form-group">
  			
  			<?php wp_editor(stripslashes($featured_data[0]->featured_text), 'mil_video_desc'); ?>
  		</div>
  		<button class="btn btn-primary" type="submit">Submit Featured Video Form</button>
	</form>
	
	</div>
</div>