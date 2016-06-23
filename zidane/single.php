<?php get_header(); ?>

<div id="is-content" class="is-content" data-is-full-width="true">
	<div class="content-area container">
		<div class="is-row-full-width"></div>
		<div class="row">
			<main class="single-main <?php echo apply_filters( 'is_main_class', '' ); ?>">
				<?php

				// Start the loop.
				while ( have_posts() ) : the_post();
					
					get_template_part( 'templates/single/standard', get_post_format() );

				endwhile;
				?>

			</main><!-- .site-main -->

			<?php 
				// Sidebar Render
				zidane_framework()->the_sidebar();
			?>
		</div>
	</div><!-- .content-area -->
</div>

<?php get_footer(); ?>

