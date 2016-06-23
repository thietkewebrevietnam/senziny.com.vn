<?php get_header(); ?>

<div id="is-content" class="is-content" data-is-full-width="true">
	<div class="content-area container">
		<div class="is-row-full-width"></div>
		<div class="row">
			<main class="site-main <?php echo apply_filters( 'is_main_class', '' ); ?>">

				<?php if ( have_posts() ) : ?>
					
					<?php
					// Start the loop.
					while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'templates/blog/standard', get_post_format() );

					// End the loop.
					endwhile;

					// Previous/next page navigation.
					zidane_framework()->the_pagination($prev = '&laquo;', $next = '&raquo;');

				// If no content, include the "No posts found" template.
				else :
					get_template_part( 'templates/content', 'none' );

				endif;
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

