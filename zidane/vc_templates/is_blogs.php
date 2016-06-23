<?php
extract(shortcode_atts(array(
	'per_page' => '8',
	'columns'  => '4',
	'layout'   => 'default',
	'category' => 'all',  // Slugs
), $atts));
$sticky = get_option( 'sticky_posts' );
$args = array(
	'posts_per_page' 		=> $per_page,
	'ignore_sticky_posts' 	=> true,
	'post__not_in'        	=> $sticky
);

if( $category != 'all' ){
	$args['category_name'] = $category;
}

$loop = new WP_Query( $args );

if( !$loop->have_posts() ) return;

$wrapper_attributes = array(
	'class="blogs-visual"',
	'data-owl="slide"',
	'data-item-slide="' . esc_attr( $columns ) . '"',
);

if( $layout == 'default' ){
	$wrapper_attributes[] = 'data-dot="true"';
	$wrapper_attributes[] = 'data-nav="false"';
}else{
	$wrapper_attributes[] = 'data-dot="false"';
	$wrapper_attributes[] = 'data-nav="true"';
}

?>
	<div class="owl-container">
		<div <?php echo implode(' ', $wrapper_attributes) ?>>
			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
				<?php if( $layout == 'default' ){ ?>
					<div class="post-item default clearfix">
						<div class="pull-left">
							<div class="thumbnail">
								<?php the_post_thumbnail( 'thumbnail' ); ?>
							</div>
						</div>
						<div class="content">
							<div class="date"><?php echo get_the_date(); ?></div>
							<h3><?php the_title(); ?></h3>
							<a href="<?php the_permalink(); ?>" class="button button-white-transparent"><?php esc_html_e( 'Read More', 'zidane' ); ?></a>
						</div>
					</div>
				<?php }else{ ?>
					<div class="post-item style-1 clearfix">
						<div class="thumbnail">
							<?php the_post_thumbnail( 'medium' ); ?>
						</div>
						<div class="content">
							<div class="date"><?php echo get_the_date(); ?></div>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<div class="post-excerpt"><?php echo zidane_framework()->get_string_limit_words( get_the_excerpt(), 15 ); ?> ...</div>
							<a href="<?php the_permalink(); ?>" class="button button-white"><?php esc_html_e( 'Read More', 'zidane' ); ?></a>
						</div>
					</div>
				<?php } ?>

			<?php endwhile; ?>
		</div>
	</div>
<?php


wp_reset_postdata();