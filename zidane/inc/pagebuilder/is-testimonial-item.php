<?php
vc_map( array(
	"name"            => esc_html__( "Testimonial Item", "inspius" ),
	"icon"            => "icon-wpb-inspius",
	"base"            => "is_testimonial_item",
	"content_element" => true,
	"as_child"        => array( 'only' => 'is_testimonial' ),
	"category"        => esc_html__( 'Inspius', 'zidane' ),
	"params"          => array(
		// add params same as with any other content element
		array(
			"type"        => "textfield",
			"heading"     => esc_html__( "Name", "inspius" ),
			"param_name"  => "name",
			"admin_label" => true,
		),
		array(
			"type"       => "textfield",
			"heading"    => esc_html__( "Position", "inspius" ),
			"param_name" => "position",
		),
		array(
			"type"        => "attach_image",
			"heading"     => esc_html__( "Photo", "inspius" ),
			"param_name"  => "photo",
			"description" => esc_html__( 'Select image from media library.', "inspius" )
		),
		array(
			'type'       => 'textarea',
			'heading'    => esc_html__( 'Testimonial text', 'zidane' ),
			'param_name' => 'text',
		),
	)
) );

class WPBakeryShortCode_Is_Testimonial_Item extends WPBakeryShortCode {
}

