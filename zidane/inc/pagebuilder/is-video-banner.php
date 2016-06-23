<?php

vc_map( array(
	"name"     	=> esc_html__( "Video Banner", "inspius" ),
	"icon"     	=> "icon-wpb-inspius",
	"base"      => "is_video_banner",
	"category"  => esc_html__( "Inspius", 'zidane' ),
	"params"    => array(
		array(
            "type" 			=> "textfield",
            "heading" 		=> esc_html__("Image banner", "inspius"),
            "param_name" 	=> "link_video",
        ),
        array(
            "type" 			=> "attach_image",
            "heading" 		=> esc_html__("Image banner", "inspius"),
            "param_name" 	=> "image",
            "description" 	=> esc_html__('Select image from media library.', "inspius"),
        ),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Extra class name', 'zidane' ),
			'param_name'  => 'css_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'zidane' )
		),
	),
) );

class WPBakeryShortCode_Is_Video_Banner extends WPBakeryShortCode {
}

