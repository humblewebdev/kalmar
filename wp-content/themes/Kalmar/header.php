<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php wp_title("", true); ?> | <?php bloginfo('name'); ?></title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_enqueue_script("jquery"); ?>

<?php wp_head(); ?>
<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
<link rel="stylesheet" href="<?php echo home_url()."/wp-content/plugins/gravityforms/css/formsmain.css"?>">
<link rel="icon" type="image/x-icon" href="http://www.webtegstage.com/kalmar/wp-content/uploads/2013/12/favicon.ico" />

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/normalize.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/main.css">
<link rel="stylesheet"
	href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
	href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet"
	href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/modernizr-2.6.2.min.js"></script>

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<!-- Latest compiled and minified JavaScript -->
<script
	src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script>
jQuery(document).ready(function(){
	var URI = jQuery(location).attr('href');
	var active = URI.substring(URI.lastIndexOf('/') + 1);
    if(typeof(active) != "undefined" && active !== null && active != '') {
		$(".panel-collapse.collapse.in").removeClass("in");
		$(active).closest(".collapse").addClass("in");
	}
	jQuery('.gform_button').addClass("btn btn-default");
	
	jQuery('.ginput_container input').addClass("form-control");
	jQuery('.gfield_select').addClass("form-control");
	jQuery('.textarea').addClass("form-control");
});
</script>


</head>