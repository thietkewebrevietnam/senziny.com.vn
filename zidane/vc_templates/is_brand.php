<?php

extract(shortcode_atts(array(
    'name' => '',
    'link' => '',
    'logo' => '',
    'css_class' => '',
    'css' => '',
), $atts));

$css_class .= apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
$image = wp_get_attachment_image( $logo, 'full', '', array( 'alt' => $name ) );

if( $link )
    $output = '<div class="brand-item' . esc_attr( $css_class ) . '"><a href=' . esc_url( $link ) . '>' . $image . '</a></div>';
else
    $output = '';

echo $output;
