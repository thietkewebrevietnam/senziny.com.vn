

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-container blog-status clearfix'); ?>>
	<div class="inner clearfix">
		<div class="entry-icon pull-left">
			<i class="icon-link"></i>
		</div>
		<div class="status-content">
			<?php
				
				the_title( '<h2 class="entry-title">', '</h2>' );

				$status = get_post_meta( get_the_id(), '_is_post_descript', true );

				printf('<div class="entry-status">%s</div>', $status);
			?>
		</div>

	</div>

</article><!-- #post-## -->
