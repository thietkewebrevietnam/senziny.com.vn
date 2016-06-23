<?php
extract(shortcode_atts(array(
    'name' => '',
    'position' => '',
    'photo' => '',
    'text' => ''
), $atts));

$image = wp_get_attachment_image( $photo, '', '', array('alt' => $name));
?>

<div class="testimonial-item">
	<div class="content">
		<div class="pull-left icon">
			<i class="fa fa-quote-left"></i>
		</div>
		<div class="text">
			<?php echo esc_html( $text ); ?>
		</div>
	</div>
	<div class="meta">
		<div class="image pull-left">
			<?php echo wp_kses_post( $image ); ?>
		</div>
		<div class="inner">
			<h5><?php echo esc_html( $name ); ?></h5>
			<div class="position"><?php echo wp_kses_post( $position ); ?></div>
		</div>
	</div>
</div>
