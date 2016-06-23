<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$product = wc_get_product( get_the_id() );
	
// $class_add = $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '';
$cart_text = esc_html( $product->add_to_cart_text() );
$class_button = array(
	'btn-cart',
	isset( $class ) ? $class : 'button'
);
$attr_button = array(
	'rel="nofollow"',
	'href="'				. esc_url( $product->add_to_cart_url() ) .'"',
	'title="'				. esc_attr( $cart_text ) .'"',
	'data-product_id="'		. esc_attr( $product->id ) .'"',
	'data-product_sku="' 	. esc_attr( $product->get_sku() ) . '"',
	'data-quantity="' 		. esc_attr( isset( $quantity ) ? $quantity : 1 ) . '"',
	// 'data-toggle="tooltip"',
	'class="' 				. implode( ' ', $class_button) . '"'
);

echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<a ' . implode( ' ', $attr_button ) . '>%s</a>',
		'<i class="icon-basket"></i><span class="cart-text">' . $cart_text . '</span>'
	),
$product );