<?php

vc_map( array(
	'name'        => esc_html__( 'Google Map', 'zidane' ),
	'base'        => 'is_gmap',
	'icon'        => 'icon-wpb-inspius',
	'category'    => esc_html__( 'Inspius', 'zidane' ),
	'description' => esc_html__( 'Display Google Map', 'zidane' ),
	'params'      => array(
		array(
	         "type" 		=> "location",
	         "heading" 		=> esc_html__("Location",'zidane'),
	         "param_name" 	=> "location",
	         "std" 			=> '1.282183,103.85079900000005',
	         'save_always' 	=> true,
		),
		array(
            "type" 			=> "textfield",
            "heading" 		=> esc_html__("Size", "inspius"),
            "param_name" 	=> "size",
            "description" 	=> esc_html__("Enter map height in pixels. Example: 300.", "inspius"),
            'admin_label' 	=> true,
            'std' 			=> 300,
            'save_always' 	=> true,
        ),
		array(
	         "type" 		=> "checkbox",
	         "heading" 		=> esc_html__("Remove Zoom Control",'zidane'),
	         "param_name" 	=> "zoomcontrol",
	         "value" 		=> array(
	         				 'Yes, please' => true
	         			)
	    ),
	),
	'admin_enqueue_js' => array(
		'http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places',
		INSPIUS_PATH_URI . '/framework/assets/js/jquery.geocomplete.min.js'
	),

));

class WPBakeryShortCode_Is_Gmap extends WPBakeryShortCode {}