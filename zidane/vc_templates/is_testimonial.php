<?php
extract(shortcode_atts(array(
    'columns' 	=> '2',
    'css_class' => ''

),$atts));

$wrapper_attributes = array(
	'class="testimonial '. esc_attr( $css_class ) .'"',
	'data-owl="slide"',
	'data-item-slide="' . esc_attr( $columns ) . '"',
	'data-dot="true"',
	'data-nav="false"'
);

$output  = '<div class="owl-container">';
$output .= '<div '. implode( ' ', $wrapper_attributes ) .'>';
$output .= do_shortcode($content);
$output .= '</div>';
$output .= '</div>';

echo  $output;