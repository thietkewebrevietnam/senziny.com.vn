<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		// Post thumbnail.
		zidane_framework()->the_post_thumbnail();
	?>
	<div class="inner">

		<div class="page-content entry-content clearfix">
			<?php 
				the_title( '<h1 class="entry-title">', '</h1>' ); 

				the_content();

				wp_link_pages();
			?>
		</div>
		
		<?php

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			
		?>

	</div>

</article><!-- #post-## -->
