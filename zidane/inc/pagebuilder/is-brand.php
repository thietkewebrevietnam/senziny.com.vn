<?php

vc_map(array(
    "name"      => esc_html__("Brand", "inspius"),
    "base"      => "is_brand",
    "content_element" => true,
    "icon"      => "icon-wpb-inspius",
    "as_child"  => array('only' => 'is_brands'),
    'category'  => esc_html__('Inspius','zidane'),
    "params"    => array(
        // add params same as with any other content element
        array(
            "type"          => "textfield",
            "heading"       => esc_html__("Brand Name", "inspius"),
            "param_name"    => "name",
            "description"   => esc_html__("Brand name", "inspius"),
            'admin_label'   => true,
        ),
        array(
            "type"          => "textfield",
            "heading"       => esc_html__("Brand link", "inspius"),
            "param_name"    => "link",
            "description"   => esc_html__("Brand link to homepage.", "inspius")
        ),
        array(
            "type"          => "attach_image",
            "heading"       => esc_html__("Brand logo", "inspius"),
            "param_name"    => "logo",
            "description"   => esc_html__('Select image from media library.', "inspius"),
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__('Extra class name', 'zidane'),
            'param_name'    => 'css_class',
            'description'   => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'zidane')
        ),
        array(
            'type'          => 'css_editor',
            'heading'       => esc_html__('CSS box', 'zidane'),
            'param_name'    => 'css',
            'group'         => esc_html__('Design Options', 'zidane')
        ),
    )
));


class WPBakeryShortCode_Is_Brand extends WPBakeryShortCode{}