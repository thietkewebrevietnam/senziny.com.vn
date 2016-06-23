<?php

vc_map( array(
	"name"                    => esc_html__( "Testimonial", "inspius" ),
	"icon"                    => "icon-wpb-inspius",
	"base"                    => "is_testimonial",
	"as_parent"               => array( 'only' => 'is_testimonial_item' ),
	// Use only|except attributes to limit child shortcodes (separate multiple values with comma)
	"content_element"         => true,
	"show_settings_on_create" => false,
	"is_container"            => true,
	"category"                => esc_html__( "Inspius", 'zidane' ),
	"params"                  => array(
		array(
			"type"       => "dropdown",
			"class"      => "",
			"heading"    => esc_html__( "Columns", "inspius" ),
			"param_name" => "columns",
			"value"      => array(
				"1" => "1",
				"2" => "2",
				"3" => "3",
			),
			"std"        => 1
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Extra class name', 'zidane' ),
			'param_name'  => 'css_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'zidane' )
		),
	),
	"js_view"                 => 'VcColumnView'
) );

class WPBakeryShortCode_Is_Testimonial extends WPBakeryShortCodesContainer {
}

