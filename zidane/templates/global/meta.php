<div class="author-avatar">
	<?php
		echo get_avatar( get_the_author_meta( 'user_email' ), 80 );
	?>
</div><!-- .author-avatar -->

<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="author-title">
	<?php echo get_the_author(); ?>
</a>

<time>
	<?php echo get_the_date(); ?>
</time>

<span class="comments-link">
	<?php 
		comments_popup_link( 
			'<span class="count">0 </span>' . esc_html__( 'Comment', 'zidane' ), 
			'<span class="count">1 </span>' . esc_html__( 'Comment', 'zidane' ), 
			'<span class="count">% </span>' . esc_html__( 'Comments', 'zidane')
		); 
	?>
</span>

<?php edit_post_link( esc_html__( 'Edit', 'zidane' ), '<span class="edit-link">', '</span>' ); ?>