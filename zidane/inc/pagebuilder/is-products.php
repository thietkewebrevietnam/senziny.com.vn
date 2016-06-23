<?php
vc_map( array(
	'name'        => esc_html__( 'Products', 'zidane' ),
	'base'        => 'is_products',
	'icon'        => 'icon-wpb-inspius',
	'category'    => esc_html__( 'Inspius', 'zidane' ),
	'description' => esc_html__( 'Display products set as "featured"', 'zidane' ),
	'params'      => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Per page', 'zidane' ),
			'value'       => 8,
			'param_name'  => 'per_page',
			'save_always' => true,
			'description' => esc_html__( 'The "per_page" shortcode determines how many products to show on the page', 'zidane' ),
		),
		array(
            "type"          => "dropdown",
            "heading"       => esc_html__("Columns", "inspius"),
            "param_name"    => "columns",
            "value"         =>array(
                                    "1" => "1", 
                                    "2" => "2", 
                                    "3" => "3",
                                    "4" => "4",
                                    "5" => "5",
                                    "6" => "6",
                                ),
            "std"           => 4
        ),
		array(
			"type" 			=> "dropdown",
			"heading" 		=> esc_html__("Style", 'zidane'),
			"param_name" 	=> "style",
			"value" 		=> array(
								'Grid' 		=> 'grid',
								'List' 		=>'list',
								'Carousel'  =>'carousel'
							),
		),
		array(
			"type" 			=> "dropdown",
			"heading" 		=> esc_html__("Type", 'zidane'),
			"param_name" 	=> "type",
			"value" 		=> array(
								esc_html__('Recent Products', 'zidane') 	=> 'recent_product',
								esc_html__('Best Selling', 'zidane') 		=> 'best_selling',
								esc_html__('Featured Products', 'zidane')	=> 'featured_product',
								esc_html__('Top Rate', 'zidane') 			=> 'top_rate',
								esc_html__('On Sale', 'zidane') 			=> 'on_sale',
								esc_html__('Recent Review', 'zidane') 		=> 'recent_review', 
								esc_html__('Product Deals', 'zidane') 		=> 'deals' 
							),
			"admin_label" 	=> true,
			"std" 			=> 'recent_product',
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Category', 'zidane' ),
			'value'       => Inspius_Woocommerce::instance()->get_list_categories(),
			'param_name'  => 'category',
			'save_always' => true,
			'description' => esc_html__( 'Product category list', 'zidane' ),
			'std'         => 'all',
			"admin_label" => true,
		),
	)
) );

class WPBakeryShortCode_Is_Products extends WPBakeryShortCode {}
