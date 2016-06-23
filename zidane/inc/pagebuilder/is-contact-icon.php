<?php
vc_map( array(
    "name" 		=> esc_html__("Contact Icon", 'zidane'),
    "base" 		=> "is_contact_icon",
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
			"type" 			=> "textfield",
			"heading"	 	=> esc_html__("Icon", 'zidane'),
			"param_name" 	=> "icon"
		),
	)
));

class WPBakeryShortCode_Is_Contact_Icon extends WPBakeryShortCode{}