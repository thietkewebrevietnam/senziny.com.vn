<article id="post-<?php the_ID(); ?>" <?php post_class('blog-container clearfix'); ?>>
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
					if( is_home() ){
						the_content('');
					}else{
						the_excerpt();
					}
					
				?>
				<div class="link-readmore">
					<a href="<?php the_permalink(); ?>"><?php echo esc_html__( 'Continue Reading', 'zidane' ); ?> <i class="fa fa-long-arrow-right"></i></a>
				</div>
			</div><!-- .entry-content -->
		</div>

	</div>

</article><!-- #post-## -->
