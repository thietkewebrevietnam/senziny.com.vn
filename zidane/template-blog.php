<?php
/*
*Template Name: Blog Template
*
*/

get_header(); 

if(is_front_page()) {
	$paged = (get_query_var('page')) ? get_query_var('page') : 1;
} else {
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}

$args = array(
	'post_type' 		=> 'post',
	'paged' 			=> $paged,
	'posts_per_page'	=> 5,
);
$blog = new WP_Query($args);

?>
<div id="is-content" class="is-content" data-is-full-width="true">
	<div class="content-area container">
		<div class="is-row-full-width"></div>
		<div class="row">
			<main class="site-main <?php echo apply_filters( 'is_main_class', '' ); ?>">
				<div class="site-main-inner">
					<?php if ( $blog->have_posts() ) : ?>
						
						<?php
						// Start the loop.
						while ( $blog->have_posts() ) : $blog->the_post();

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							if( get_post_format() == 'status' ){
								get_template_part( 'templates/status' );
							}else{
								get_template_part( 'templates/blog/standard' );
							}
								

						// End the loop.
						endwhile;
						wp_reset_postdata();
						// Previous/next page navigation.
						zidane_framework()->the_pagination($prev = '&laquo;', $next = '&raquo;', $blog->max_num_pages );

					// If no content, include the "No posts found" template.
					else :
						get_template_part( 'templates/content', 'none' );

					endif;
					?>
				</div>
			</main><!-- .site-main -->

			<?php 
				// Sidebar Render
				zidane_framework()->the_sidebar();
			?>
		</div>
	</div><!-- .content-area -->
</div>
<?php get_footer(); ?>

