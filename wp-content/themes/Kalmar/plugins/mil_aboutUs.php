<div class="wrapper">
	<div class="well">
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
		<h2>About Us</h2>
  		<div class="form-group">
  		
  			<?php 
  			
  			$id=267;
  			$post = get_page($id);
  			$content = apply_filters('the_content', $post->post_content);
  			
  			wp_editor($content, 'mil_aboutus_page'); ?>
  		</div>
  		<button class="btn btn-primary" type="submit">Submit about us page Form</button>
	</form>
	
	</div>
</div>