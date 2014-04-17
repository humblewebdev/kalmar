<div class="wrapper">
<h2>No Dealers for Military <span style="font-size: .6em"> - so there's a how to purchase page</span></h2>
	<div class="well">
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
			enctype="multipart/form-data">
			<h2>How to Purchase Page</h2>
			<div class="form-group">
<?php
$id = 307;
$post = get_page ( $id );
$content = apply_filters ( 'the_content', $post->post_content );

wp_editor ( $content, 'mil_dealer_page' );
?>
  		</div>
			<button class="btn btn-primary" type="submit">Save Changes</button>
		</form>

	</div>
</div>
