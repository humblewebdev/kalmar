<?php
/*
Template Name: inner Military
*/
?>
<?php get_header();?>
<body>
	<!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
<style>
	header{
		background:none;
	}
</style>

	<header>
			<div class=" branding wrapper">
				<a href="../military-products/"><img src="<?php bloginfo('template_directory');?>/images/kalmar_logo.png" width="314px" height="75px"></a>
			</div>
			
				<?php
				$main_defaults = array(
                    'theme_location' => 'mil-tan-header-menu',
                    'menu' => '',
                    'container' => 'div',
                    'container_class' => '',
                    'container_id' => '',
                    'menu_class' => 'menu',
                    'menu_id' => '',
                    'echo' => true,
                    'fallback_cb' => 'wp_page_menu',
                    'before' => '',
                    'after' => '',
                    'link_before' => '',
                    'link_after' => '',
                    'items_wrap' => '<div class="tan_nav pull-right"><ul class="tan_nav">%3$s</ul></div>',
                    'depth' => 0,
                    'walker' => ''
                );

                wp_nav_menu($main_defaults);
                ?>
			
		<div class="clear"></div>
		
		  <?php
                $main_defaults = array(
                    'theme_location' => 'mil-header-menu',
                    'menu' => '',
                    'container' => 'div',
                    'container_class' => '',
                    'container_id' => '',
                    'menu_class' => 'menu',
                    'menu_id' => '',
                    'echo' => true,
                    'fallback_cb' => 'wp_page_menu',
                    'before' => '',
                    'after' => '',
                    'link_before' => '',
                    'link_after' => '',
                    'items_wrap' => '<nav class="navbar navbar-default" id="military" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target=".navbar-ex1-collapse">
					<div class="pull-left">
						<span class="sr-only">Toggle navigation</span> <span
							class="icon-bar"></span> <span class="icon-bar"></span> <span
							class="icon-bar"></span>
					</div>
					<p class="pull-right">Navigation</p>
				</button>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav">%3$s	</ul>

			</div>
		</nav>',
                    'depth' => 0,
                    'walker' => ''
                );

                wp_nav_menu($main_defaults);
                ?>	
	</header>
		<div class="content_area">
		<div class="wrapper">
		
			<?php //echo $myrows = $wpdb->insert('wp_dummy_sitemil_product',array('mil_product_name' => 'test','mil_product_image' => 'test.png', 'mil_product_desc' => 'This is an awesome military description'));?>
		
			 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				 <div class="underlined_page_header"><?php the_title(); ?></div>
				 <p><?php the_content(__('(more...)')); ?></p> 
				<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
			</div>
	</div>
	<footer class="military">
<?php include (TEMPLATEPATH . '/footer2.php'); ?>