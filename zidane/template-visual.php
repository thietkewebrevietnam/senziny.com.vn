<?php
/*
*Template Name: Visual Composer Template
*
*/

get_header();

?>
	<div id="is-content" class="is-content">
		<div class="content-area container">
			<?php 
			// Start the loop.
			while ( have_posts() ) : the_post();

				the_content();

			// End the loop.
			endwhile;
			?>
		</div>
	</div>

<?php

get_footer();