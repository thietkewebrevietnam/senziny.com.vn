<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="is-content" class="is-content" data-is-full-width="true">
	<section id="woo-container" class="content-area woo-container container" role="main">
		<div class="is-row-full-width"></div>
		<div class="row">
			<main class="site-main <?php echo apply_filters( 'is_main_class', '' ); ?>">