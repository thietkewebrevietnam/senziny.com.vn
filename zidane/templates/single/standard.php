<article id="post-<?php the_ID(); ?>" <?php post_class('blog-container single-container clearfix'); ?>>
	<?php
		// Post thumbnail.
		zidane_framework()->the_post_thumbnail();
	?>
	<div class="inner">

		<div class="inner-content clearfix">
			<div class="entry-meta text-center">
				<?php get_template_part( 'templates/global/meta' ); ?>
			</div>
			<div class="entry-content">
				<header class="entry-header">
					<?php
						if ( is_single() ) :
							the_title( '<h1 class="entry-title">', '</h1>' );
						else :
							the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
						endif;
					?>
				</header><!-- .entry-header -->
				<?php
					/* translators: %s: Name of current post */
					the_content();

					wp_link_pages( array( 'before' => '<p class="link-page">' . esc_html__( 'Pages:', 'zidane' ) ) );
				?>
			</div><!-- .entry-content -->
		</div>
		
		<?php

			get_template_part( 'templates/global/pagination' );

			get_template_part( 'templates/global/share' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			
		?>

	</div>

</article><!-- #post-## -->
