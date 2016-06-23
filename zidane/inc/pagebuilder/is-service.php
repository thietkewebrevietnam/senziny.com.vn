<?php
vc_map( array(
    "name" 		=> esc_html__("Service", 'zidane'),
    "base" 		=> "is_service",
    "category" 	=> esc_html__('Inspius','zidane'),
    "icon" 		=> "icon-wpb-inspius",
    "params" 	=> array(
    	array(
			"type" 			=> "textfield",
			"heading" 		=> esc_html__("Title", 'zidane'),
			"param_name" 	=> "title",
			'admin_label' 	=> true,
		),
		array(
	        'type' 			=> 'textarea',
	        'heading' 		=> esc_html__( 'Description', 'zidane' ),
	        'param_name' 	=> 'desc',
		),
		array(
			"type" 			=> "textfield",
			"heading" 		=> esc_html__("Icon", 'zidane'),
			"param_name" 	=> "icon"
		),
		array(
			"type" 			=> "colorpicker",
			"heading" 		=> esc_html__("Background", 'zidane'),
			"param_name" 	=> "bg",
			"value" 		=>'#87c24e'
		),
		array(
			'type'        	=> 'textfield',
			'heading'     	=> esc_html__( 'Extra class name', 'zidane' ),
			'param_name'  	=> 'css_class',
			'description' 	=> esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'zidane' )
		),
	)
));

class WPBakeryShortCode_Is_Service extends WPBakeryShortCode{}