<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column_Inner
 */
$el_class = $width = $css = $offset = '';
$output = $el_effect = $is_animation = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$wrapper_attributes = array();

$is_animation = explode( '|', $is_animation);
if( $is_animation[0]!='none' & count( $is_animation ) == 3 ){
	$wrapper_attributes[] = 'data-wow-delay="' . esc_attr( $is_animation[2] ) . 'ms"';
	$wrapper_attributes[] = 'data-wow-duration="' . esc_attr( $is_animation[1] ) . 'ms" ';
	$el_effect = ' wow '.esc_attr( $is_animation[0] );
}

$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );

$css_classes = array(
	$this->getExtraClass( $el_class ),
	'wpb_column',
	'vc_column_container',
	$el_effect,
	$width,
	vc_shortcode_custom_css_class( $css ),
);



$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
$output .= '<div class="wpb_wrapper">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
$output .= '</div>';

echo $output;
