<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$config = Inspius_Woocommerce::instance()->get_archive_config();

?>
<li <?php post_class( $config['classes'] ); ?>>

	<?php wc_get_template_part( 'content', 'product-' . $config['layout'] ); ?>

</li>
