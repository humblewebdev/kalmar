<div class="wrapper">
	<div class="well">
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
		<h2>Contact Page</h2>
  		<div class="form-group">
  			
  			<?php 
  			
  			$id=265;
  			//$post = get_page($id);
  			$content = get_post($id);
  			
  			//$content = apply_filters('the_content', $post->post_content);
  			
  			
  			wp_editor($content->post_content, 'mil_contact_page'); ?>
  		</div>
  		<button class="btn btn-primary" type="submit">Submit contact page Form</button>
	</form>
	
	</div>
</div>