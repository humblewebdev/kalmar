
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
</style>


<div class="wrapper">
	<h1>Military Landing Page</h1>
	<div class="well">
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<div class="form-group">
				<label for="mil_page_text">Military Page Text</label> 
						<?php wp_editor($content, 'mil_page_text'); ?>
			</div>
			
			<button class="btn btn-primary" type="submit">Submit</button>
		</form>
	</div>
</div>

