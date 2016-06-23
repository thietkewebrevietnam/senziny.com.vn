<?php

class Inspius_Metabox extends Inspius_Metabox_Base{
    private $prefix = '_is_';

    public function __construct(){
        parent::__construct();

        // Page Config Metabox
        add_filter( 'cmb2_admin_init', array( $this, 'setup_page_config' ) );
        add_filter( 'cmb2_admin_init', array( $this, 'setup_post_config' ) );
        add_filter( 'cmb2_admin_init', array( $this, 'setup_breadcrumb_config' ) );
    }


    public function setup_page_config(){
        $cmb = new_cmb2_box(array(
            'id'            => 'page_config',
            'title'         => esc_html__( 'Page Config', 'zidane' ),
            'object_types'  => array('page'), // Post type
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true, // Show field names on the left
        ));

        $cmb->add_field(array(
            'name'      => esc_html__( 'Layout', 'zidane' ),
            'desc'      => esc_html__( 'Select Layout', 'zidane' ),
            'id'        => $this->prefix . 'page_layout',
            'type'      => 'layout',
            'default'   => '1'
        ));

        $cmb->add_field(array(
            'name'      => 'Choose Sidebar',
            'id'        => $this->prefix . 'page_sidebar',
            'type'      => 'sidebar',
        ));
    }

    public function setup_breadcrumb_config(){
        $cmb = new_cmb2_box(array(
            'id'            => 'breadcrumb_config',
            'title'         => esc_html__( 'Breadcrumb Config', 'zidane' ),
            'object_types'  => array( 'page', 'post' ), // Post type
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true, // Show field names on the left
        ));

        $cmb->add_field(array(
            'name'      => 'Enable Breadcrumb',
            'id'        => $this->prefix . 'page_is_breadcrumb',
            'type'      => 'radio_inline',
            'options'   => array(
                    '0'         => esc_html__( 'Yes', 'zidane' ),
                    'no'        => esc_html__( 'No' , 'zidane' ),
                ),
        ));

        $cmb->add_field(array(
            'name'      => 'Background Color',
            'id'        => $this->prefix . 'page_is_breadcrumb_bg_color',
            'type'      => 'colorpicker',
            'default'   => '',
            
        ));

        $cmb->add_field(array(
            'name'      => 'Background Image',
            'id'        => $this->prefix . 'page_is_breadcrumb_bg_images',
            'type'      => 'file',
            'options'   => array(
                    'url'                   => false, // Hide the text input for the url
                    'add_upload_file_text'  => esc_html__( 'Add Image', 'zidane' ) // 
                ),
        ));

        $cmb->add_field(array(
            'name'      => 'Background Repeat',
            'id'        => $this->prefix . 'page_is_breadcrumb_bg_repeat',
            'type'      => 'select',
            'options'   => array(
                    ''          => 'Use Global',
                    'no-repeat' => 'No Repeat',
                    'repeat'    => 'Repeat All',
                    'repeat-x'  => 'Repeat Horizontally',
                    'repeat-y'  => 'Repeat Vertically',
                    'inherit'   => 'Inherit',
                ),
        ));

        $cmb->add_field(array(
            'name'      => 'Background Size',
            'id'        => $this->prefix . 'page_is_breadcrumb_bg_size',
            'type'      => 'select',
            'options'   => array(
                    ''          => 'Use Global',
                    'inherit'   => 'Inherit',
                    'cover'     => 'Cover',
                    'contain'   => 'Contain',
                ),
        ));

        $cmb->add_field(array(
            'name'      => 'Background Position',
            'id'        => $this->prefix . 'page_is_breadcrumb_bg_position',
            'type'      => 'select',
            'options'   => array(
                    ''              => 'Use Global',
                    'left top'      => 'Left Top',
                    'left center'   => 'Left Center',
                    'left bottom'   => 'Left Bottom',
                    'center top'    => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                    'right top'     => 'Right Top',
                    'right center'  => 'Right Center',
                    'right bottom'  => 'Right Bottom',
                ),
        ));

    }

    public function setup_post_config(){
        $cmb = new_cmb2_box(array(
            'id'            => 'post_format_config',
            'title'         => esc_html__( 'Post Format Config', 'zidane' ),
            'object_types'  => array('post'), // Post type
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true, // Show field names on the left
        ));

        $cmb->add_field(array(
            'name'      => esc_html__( 'Link Video or Audio', 'zidane'),
            'desc'      => esc_html__( 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'zidane' ),
            'id'        => $this->prefix . 'post_video',
            'type'      => 'oembed',
        ));

        $cmb->add_field(array(
            'name'      => esc_html__( 'Gallery Images', 'zidane'),
            'id'        => $this->prefix . 'post_gallery',
            'type'      => 'file_list',
        ));

        $cmb->add_field(array(
            'name'      => esc_html__( 'Status, Link, Quote', 'zidane'),
            'id'        => $this->prefix . 'post_descript',
            'type'      => 'textarea',
        ));

    }
    
}

new Inspius_Metabox();