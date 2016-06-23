<?php
vc_map( array(
	'name'        => esc_html__( 'Blogs', 'zidane' ),
	'base'        => 'is_blogs',
	'icon'        => 'icon-wpb-inspius',
	'category'    => esc_html__( 'Inspius', 'zidane' ),
	'description' => esc_html__( 'Display blog', 'zidane' ),
	'params'      => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Per page', 'zidane' ),
			'value'       => 8,
			'param_name'  => 'per_page',
			'save_always' => true,
			'description' => esc_html__( 'The "per_page" shortcode determines how many Post to show on the page', 'zidane' ),
		),
		array(
			"type"       => "dropdown",
			"heading"    => esc_html__( "Columns", "inspius" ),
			"param_name" => "columns",
			"value"      => array(
				"1" => "1",
				"2" => "2",
				"3" => "3",
				"4" => "4",
				"5" => "5",
				"6" => "6",
			),
			"std"        => 4
		),
		array(
			"type"       => "dropdown",
			"heading"    => esc_html__( "Layout", "inspius" ),
			"param_name" => "layout",
			"value"      => array(
				'Default' => 'default',
				'Style 2' => 'style-2',
			),
			"std"        => 4
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Category', 'zidane' ),
			'value'       => zidane_framework()->get_list_category(),
			'param_name'  => 'category',
			'save_always' => true,
			'description' => esc_html__( 'Category list', 'zidane' ),
			'std'         => 'all',
		),
	)
) );

class WPBakeryShortCode_Is_Blogs extends WPBakeryShortCode {}
