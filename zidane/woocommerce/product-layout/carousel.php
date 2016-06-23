<?php
	$_delay = 200;
?>
<div class="owl-container">
	<div data-owl="slide" 
		data-item-slide="<?php echo esc_attr( $columns_count ); ?>" 
		class="product-slide"
		data-nav="true"
		data-dot="false"
		>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<div class="wow fadeInUp" data-wow-duration="800ms" data-wow-delay="<?php echo esc_attr( $_delay ); ?>ms">
			<?php 
				if( isset($is_deals) && $is_deals ){
					wc_get_template_part( 'content', 'product-deal' );
				}else{
					wc_get_template_part( 'content', 'product-grid' );
				}
			?>
			</div>
			<?php $_delay+=300; ?>
		<?php endwhile; ?>
	</div>
</div>
