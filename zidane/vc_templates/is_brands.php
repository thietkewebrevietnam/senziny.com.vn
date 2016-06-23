<?php
extract(shortcode_atts(array(
    'css_class' => '',
    'columns'   => 5
), $atts));

$wrapper_attributes = array(
	'class="brands owl-middle '. esc_attr( $css_class ) .'"',
	'data-owl="slide"',
	'data-item-slide="' . esc_attr( $columns ) . '"',
	'data-dot="false"',
	'data-nav="true"'
);

$output  = '<div class="owl-container">';
$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
$output .= do_shortcode( $content ) ;
$output .= '</div>';
$output .= '</div>';

echo $output;