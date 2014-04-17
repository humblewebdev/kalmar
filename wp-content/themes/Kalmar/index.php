<?php get_header();?>
	
<body>
	<!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

<div class="commercial-bkgd">
	<header>
		<div class=" branding wrapper">
			<a href="../kalmar/index.php"><img
				src="<?php bloginfo('template_directory');?>/images/kalmar_logo.png"
				width="314px" height="75px"></a>
		</div>
			<?php
			$main_defaults = array (
					'theme_location' => 'comm-tan-header-menu',
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
			
			wp_nav_menu ( $main_defaults );
			?>
		<div class="clear"></div>
		
		<?php
		$defaults = array (
				'theme_location' => 'comm-header-menu',
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
				'items_wrap' => '<nav class="navbar navbar-default" role="navigation">
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
		
		wp_nav_menu ( $defaults );
		?>
		
		<div class="slider"></div>
	</header>
</div><!--End Commercial Bkgd -->
	<div class="featured">
			<div class="wrapper">
			<div class="page_header  pull-left">
				<a href="#" onclick='return false' id="military_featured_image">Watch Featured
					Video</a>
			</div>
			
			<?php
			global $wpdb;
			$featured_data = $wpdb->get_results ( "SELECT featured_video, featured_title, featured_text FROM wp_dummy_sitefeaturedVideopages WHERE featured_id=2" );
			// var_dump($featured_data);
			?>
			
			
				<div class="featured_area">
					<div class="featured_video col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="video-container">
						<?php echo stripslashes($featured_data[0]->featured_video);?>
					</div>
					</div>

					<div class="featured_text col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<h2><?php echo $featured_data[0]->featured_title;?></h2>
						<p><?php echo stripslashes($featured_data[0]->featured_text); ?></p>
					</div>
					<div class="clear"></div>
				</div>
			<script>
				$(document).ready(function(){
					$('.featured_area').fadeOut('fast',function(){
								$('.featured').animate({"min-height": "0"}, 'easeInOutCubic');
					});
					$('#military_featured_image').on('click', function(){
						var height = $('.featured').height();
						if(height > 0){

							$('.featured_area').fadeOut('fast',function(){
								$('.featured').animate({"min-height": "0"}, 'easeInOutCubic');
							});
							
						} else {

							$('.featured').animate({"min-height": "400px"}, 'easeInOutCubic', function() {
								$('.featured_area').fadeIn();
							});
						}
					});				
				});
			</script>

		</div>
	</div>
	<div class="content_area">
		<div class="wrapper	">
		 <div class="underlined_page_header"><?php the_title(); ?></div>
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
		<?php  if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<p><?php the_content(__('(more...)')); ?></p> 
			<?php endwhile; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?> 
			</div>
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<div class="black_box">
					<h1>For MORE INFO</h1>
					<a class="btn btn-danger" href="http://www.webtegstage.com/kalmar/request-a-quote/">REQUEST A QUOTE</a>
					</br>
					<h1>OR CALL</h1>
					<h2>800-232-1236</h2>
				</div>
				
				<div class="newsEvents">
					<div class="newsSpacer">NEWS AND EVENTS</div>
					
					<div class="newsContainer">
					
					<?php
					$args = array(
						'posts_per_page'   => 3,
						'offset'           => 0,
						'category'         => '',
						'orderby'          => 'post_date',
						'order'            => 'DESC',
						'include'          => '',
						'exclude'          => '',
						'meta_key'         => '',
						'meta_value'       => '',
						'post_type'        => 'post',
						'post_mime_type'   => '',
						'post_parent'      => '',
						'post_status'      => 'publish',
						'suppress_filters' => true );
					?>
					<?php 
						$posts_array = get_posts( $args ); 
						
						foreach($posts_array as $postObject){
						
							echo '<div class="newsArticle">';
							echo "<br>";
							$newDate = date("m/d", strtotime($postObject->post_date));
							echo "<h1>".$newDate."</h1><br>";
							echo "<p>".$postObject->post_title."</p><br>";
							$newDate = date("d-m-Y", strtotime($postObject->post_date));
							echo '<a class="btn btn-link" href="'.$postObject->guid.'">Read More</a><br>';
							echo "<br>";
							echo "</div>";
						}
					
					?> 
					</div>
					
					
					<div class="newsSpacer"></div>
				</div>
			</div>
		</div>
	</div>
</div>
	<footer>
<?php get_footer();?>