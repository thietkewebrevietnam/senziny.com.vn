<div class="cart_container uk-offcanvas-bar uk-offcanvas-bar-flip" data-text-emptycart="<?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?>">
	<div class="uk-panel">
		<h3 class="widget-title"><?php echo esc_html__('Cart','zidane'); ?></h3>
		<ul class="cart_list product_list_widget">
		
			<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

				<?php
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							?>
							<li class="media">
								<a href="<?php echo get_permalink( $product_id ); ?>" class="cart-image pull-left">
									<?php echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ); ?>						
								</a>
								<div class="cart-main-content media-body">
									<div class="name">
										<a href="<?php echo get_permalink( $product_id ); ?>">
											<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );; ?>
										</a>								
									</div>
									<p class="cart-item">
										<?php echo WC()->cart->get_item_data( $cart_item ); ?>
										<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) ) . '</span>', $cart_item, $cart_item_key ); ?>
									</p>
								</div>
								<a href="#" data-product-key="<?php echo esc_attr($cart_item_key); ?>" class="is_product_remove">
									<i class="fa fa-close"></i>
								</a>
							</li>
							<?php
						}
					}
				?>

			<?php else : ?>

				<li class="empty"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></li>

			<?php endif; ?>

		</ul><!-- end product list -->

		<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

			<p class="total"><strong><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

			<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

			<p class="buttons">
				<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="btn btn-primary btn-viewcart"><?php esc_html_e( 'View Cart', 'woocommerce' ); ?></a>
				<a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="btn btn-primary btn-checkout"><?php esc_html_e( 'Checkout', 'woocommerce' ); ?></a>
			</p>

		<?php endif; ?>
	</div>
</div>