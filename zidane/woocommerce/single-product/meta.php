<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$post_id = get_the_id();

$product = wc_get_product( $post_id );

$cat_count = sizeof( get_the_terms( $post_id, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post_id, 'product_tag' ) );

?>
<ul class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<li><span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span></li>

	<?php endif; ?>

	<?php echo $product->get_categories( ', ', '<li><span class="posted_in">' . _n( 'Category:', 'Categories:', $cat_count, 'woocommerce' ) . ' ', '</span></li>' ); ?>

	<?php echo $product->get_tags( ', ', '<li><span class="tagged_as">' . _n( 'Tag:', 'Tags:', $tag_count, 'woocommerce' ) . ' ', '</span></li>' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</ul>
