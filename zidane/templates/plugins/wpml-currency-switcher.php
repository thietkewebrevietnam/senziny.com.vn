<?php
$c_active = $c = array();
foreach ( $currencies as $currency ) {
	if ( $woocommerce_wpml->settings['currency_options'][ $currency ]['languages'][ $sitepress->get_current_language() ] == 1 ) {


		$currency_format = preg_replace( array( '#%name%#', '#%symbol%#', '#%code%#' ),
			array(
				$wc_currencies[ $currency ],
				get_woocommerce_currency_symbol( $currency ),
				$currency
			), $args['format'] );

		if( $currency == $woocommerce_wpml->multi_currency_support->get_client_currency() ){
			$c_active['currency'] = $currency;
			$c_active['currency_format'] = $currency_format;
		}else{
			$c[] = array(
				'currency' 			=> $currency,
				'currency_format' 	=> $currency_format,
			);
		}
	}
}
?>

<div class="currency-switch">	
	<div class="dropdown">
		<a href="#" data-toggle="dropdown">
			<span class="title"><?php esc_html_e( 'Currency : ', 'zidane' ); ?></span>
			<?php echo esc_html( $c_active['currency_format'] ); ?>
		</a>
		<?php if( !empty( $c ) ){ ?>
		<ul class="dropdown-menu wcml_currency_switcher">
			<?php foreach ($c as $value) { ?>
			<li rel="<?php echo esc_attr( $value['currency'] ); ?>">
				<a href="#" onclick="return false;">
					<?php echo esc_html( $value['currency_format'] ); ?>
				</a>
			</li>
			<?php } ?>
		</ul>
		<?php } ?>
	</div>
</div>