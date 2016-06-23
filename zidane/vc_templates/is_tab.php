<?php
extract(shortcode_atts(array(
    'title' 	=> '',
    'tab_id'    => '',
), $atts));


$this->setListTab( array(
	'tab-id'  	=> $tab_id,
	'title'		=> $title,
	'content' 	=> $content
) );