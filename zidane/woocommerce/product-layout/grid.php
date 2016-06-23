<?php 
	$_delay = 200;
	$_count = 1;
	$class_animation = '';
	if( isset( $is_animation ) && $is_animation ){
		$class_animation = ' wow fadeInUp';
	}

?>

<div class="row">
<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
	<?php
        $class_fix = '';
        // Store loop count we're currently on
        if ( 0 == ( $_count - 1 ) % $columns_count || 1 == $columns_count )
            $class_fix .= ' first';
        if ( 0 == $_count % $columns_count )
            $class_fix .= ' last';
    ?>
	<!-- Product Item -->
	<div class="<?php echo esc_attr( $class_column . $class_fix . $class_animation ); ?> product-col" data-wow-duration="800ms" data-wow-delay="<?php echo esc_attr( $_delay ); ?>ms">
		<?php 
			if( isset( $is_deals ) && $is_deals ){
				wc_get_template_part( 'content', 'product-deal' );
			}else{
				wc_get_template_part( 'content', 'product-grid' );
			}
		?>
	</div>
	<?php $_delay+=300; ?>
	<!-- End Product Item -->
	<?php
		if($_count==$columns_count){
			$_count=0;$_delay=200;
		}
		$_count++;
	?>
<?php endwhile; ?>
</div>