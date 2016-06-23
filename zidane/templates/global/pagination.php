<?php
	$prev_post = get_previous_post();
	$next_post = get_next_post();
?>
<div class="post-control clearfix">
	<?php if (!empty( $prev_post )) : ?>
		<a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="prev"><span>
			<i class="icon-arrow-left"></i>
			<?php echo esc_html__( 'Previous post', 'zidane' ); ?></span>
		</a>
	<?php endif; ?>
	<?php if (!empty( $next_post )) : ?>
		<a href="<?php echo get_permalink( $next_post->ID ); ?>" class="next">
			<span><i class="icon-arrow-right"></i>
			<?php echo esc_html__( 'Next post', 'zidane' ); ?></span>
		</a>
	<?php endif; ?>
</div>