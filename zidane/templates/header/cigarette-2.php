<header id="is-header" class="is-header">
	<div class="header-topbar">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-md-4 hidden-xs topbar-text">
					<?php echo zidane_framework()->get_option( 'header_topbar_text', 'HOTLINE: (65) 8575 0171' ); ?>
				</div>
				<div class="col-sm-9 col-md-8 topbar-action">
					<?php

					if ( zidane_framework()->is_request( 'wishlist' ) ) {
						echo '<a href="' . esc_url( YITH_WCWL()->get_wishlist_url() ) . '"><i class="icon-heart"></i> ' . esc_html__( 'Wishlist', 'zidane' ) . '</a>';
					}
					if ( zidane_framework()->is_request( 'woocommerce' ) ) {
						if ( is_user_logged_in() ) {
							echo '<a href="' . get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) . '"><i class="icon-user"></i> ' . esc_html__( 'My Account', 'zidane' ) . '</a>';
							echo '<a href="' . esc_url( wp_logout_url( home_url() ) ) . '"><i class="icon-logout"></i> </a>';
						} else {
							echo '<a href="' . get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) . '"><i class="icon-login"></i> ' . esc_html__( 'Login / Register', 'zidane' ) . '</a>';
						}
					}
					if( zidane_framework()->is_request( 'wpml' ) ){
						do_action( "inspius_custom_wpml_switcher" );
					}

					?>
				</div>
			</div>
		</div>
	</div>
	<div class="header-main">
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-push-4 logo text-center">
					<?php zidane_framework()->the_logo(); ?>
				</div>	
				<div class="col-sm-4 col-sm-pull-4 header-text">
					<?php echo zidane_framework()->get_option( 'header_text', '' ); ?>
				</div>
				<div class="col-sm-4 hidden-xs">
					<?php get_search_form(); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="header-container header-mainmenu">
		<div class="inner">
			<div class="container">
				<div class="header-inner">
					<div class="row">
						<div class="col-md-9 hidden-sm hidden-xs header-menu">
							<?php zidane_framework()->the_megamenu( array(
								'theme_location'  => 'mainmenu',
								'container_class' => 'collapse navbar-collapse navbar-ex1-collapse',
								'menu_class'      => 'nav navbar-nav megamenu',
								'show_toggle'     => false
							) ); ?>
						</div>
						<div class="col-md-3 col-sm-12 header-action">
							<div class="inner">
								<?php if ( zidane_framework()->is_request( 'woocommerce' ) ): ?>
									<?php wc_get_template_part( 'theme/cart-icon' ); ?>
								<?php endif; ?>

								<div class="search-action">
									<a href="#"><i class="icon-magnifier"></i></a>
								</div>
								<div class="menu-action">
									<a href="#" data-uk-offcanvas="{target:'#is-off-canvas'}"><i class="icon-menu"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Start Search Form -->
			<div class="is-search-form">
				<div class="container">
					<?php get_search_form(); ?>
				</div>
			</div>
			<!-- End Search Form -->

		</div>
	</div>
	<!-- End .header-mainmenu -->

</header><!-- End .is-header -->
