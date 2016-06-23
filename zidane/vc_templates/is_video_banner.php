<?php
extract(shortcode_atts(array(
    'link_video' 	=> '',
    'image' 	=> '',
    'css_class' => ''

),$atts));
?>

<div class="video-banner">
	<video style="width:100%;height:100%;">
		<source src="<?php echo esc_url( $link_video ); ?>" type="video/mp4">
	</video>
	<?php echo wp_get_attachment_image( $image, 'full' ); ?>
</div>