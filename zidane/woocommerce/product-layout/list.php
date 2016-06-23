<ul class="product_list_widget">
	<?php 
		$_delay = 200; 
		while ( $loop->have_posts() ) : $loop->the_post();
			wc_get_template( 
				'content-widget-product.php',
				array( 
					'show_rating' 	=> true , 
					'show_category'	=> true , 
					'is_animate'	=> true , 
					'delay' 		=> $_delay 
				) 
			); 
			$_delay+=300;
		endwhile; 
	?>
</ul>