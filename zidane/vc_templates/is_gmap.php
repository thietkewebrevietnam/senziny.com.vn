<?php
extract(shortcode_atts(array(
    'location' => '21.0173222,105.78405279999993',
    'size' => 300,
    'zoomcontrol'=> 'true',
), $atts));

wp_enqueue_script('theme-gmap-core');
wp_enqueue_script('theme-gmap-api');

$wrapper_attributes = array(
	'data-gmap="map"',
    'data-zoom="15"',
	'data-center="' . esc_attr( $location ) . '"',
	'style="height:' . esc_attr( $size ) . 'px;"',
);

echo '<div ' . implode( ' ', $wrapper_attributes ) . '></div>';

