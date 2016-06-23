<?php
final class Inspius_Page_Builder extends Inspius_Page_Builder_Base {
	public function __construct() {
		$this->add_element( array(
			'is-brand',
			'is-service',
			'is-brands',
			'is-testimonial-item',
			'is-testimonial',
			'is-tab',
			'is-tabs',
			'is-blogs',
			'is-gmap',
			'is-video-banner',
			'is-contact-icon',
		) );

		if( Inspius_Functions::instance()->is_request( 'woocommerce' ) ){
			$this->add_element( 'is-products' );
		}

		parent::__construct();
	}
}

new Inspius_Page_Builder();

