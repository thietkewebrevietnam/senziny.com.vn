<?php

class Inspius_Wpml_Base {

	public function __construct() {

		if ( get_option( 'wpml_woo_config', false ) ) {
			$this->set_up_config();
			add_option( 'wpml_woo_config', true );
		}

		add_action( 'inspius_custom_wpml_switcher', array( $this, 'custom_wpml_switcher' ) );

	}

	public function custom_wpml_switcher() {

		//Language switcher template
		$languages = apply_filters( 'wpml_active_languages', null, '' );
		if ( is_file( INSPIUS_PATH_URL . '/templates/plugins/wpml-languages-switcher.php' ) ) {
			include_once( INSPIUS_PATH_URL . '/templates/plugins/wpml-languages-switcher.php' );
		}


		//Currentcy switcher template
		if ( !zidane_framework()->is_request( 'wpml_woo' ) ) {
			return '';
		}

		global $sitepress, $woocommerce_wpml;
		if ( ! isset( $woocommerce_wpml->multi_currency_support ) ) {
			require_once WCML_PLUGIN_PATH . '/inc/multi-currency-support.class.php';
			$woocommerce_wpml->multi_currency_support = new WCML_Multi_Currency_Support;
		}


		if ( is_page( wc_get_page_id( 'myaccount' ) ) ) {
			return '';
		}

		$settings = $woocommerce_wpml->get_settings();

		if ( isset( $settings['display_custom_prices'] ) && $settings['display_custom_prices'] ) {

			if ( is_page( wc_get_page_id( 'cart' ) ) ||
			     is_page( wc_get_page_id( 'checkout' ) )
			) {
				return '';
			} elseif ( is_product() ) {
				$current_product_id        = wc_get_product()->id;
				$original_product_language = $woocommerce_wpml->products->get_original_product_language( $current_product_id );

				if ( ! get_post_meta( apply_filters( 'translate_object_id', $current_product_id, get_post_type( $current_product_id ), true, $original_product_language ), '_wcml_custom_prices_status', true ) ) {
					return '';
				}
			}

		}

		if ( ! isset( $args['switcher_style'] ) ) {
			$args['switcher_style'] = isset( $settings['currency_switcher_style'] ) ? $settings['currency_switcher_style'] : 'dropdown';
		}

		if ( ! isset( $args['orientation'] ) ) {
			$args['orientation'] = isset( $settings['wcml_curr_sel_orientation'] ) ? $settings['wcml_curr_sel_orientation'] : 'vertical';
		}

		if ( ! isset( $args['format'] ) ) {
			$args['format'] = isset( $settings['wcml_curr_template'] ) && $settings['wcml_curr_template'] != '' ? $settings['wcml_curr_template'] : '%name% (%symbol%) - %code%';
		}


		$wc_currencies = get_woocommerce_currencies();

		if ( ! isset( $settings['currencies_order'] ) ) {
			$currencies = $woocommerce_wpml->multi_currency_support->get_currency_codes();
		} else {
			$currencies = $settings['currencies_order'];
		}

		//include template file
		if ( is_file( INSPIUS_PATH_URL . '/templates/plugins/wpml-currency-switcher.php' ) ) {
			include_once( INSPIUS_PATH_URL . '/templates/plugins/wpml-currency-switcher.php' );
		}
	}


}

new Inspius_Wpml_Base();