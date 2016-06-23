<?php
if (!class_exists('Inspius_Redux_Framework')) {

    final class Inspius_Redux_Framework extends Inspius_Redux_Framework_Base{

        

        public function __construct(){
            parent::__construct();
        }

        public function set_sections()
        {
            $this->general_section();
            $this->favicon_section();
            $this->styling_section();
            $this->breadcrumb_section();
            $this->header_section();
            $this->topbar_section();
            $this->footer_section();

            if( $this->function->is_request( 'woocommerce' ) ){
                $this->woocommerce_section();
            }
            
            $this->blog_section();
            $this->blog_single_section();
            $this->megamenu_sction();

        }

        private function general_section(){

            $this->sections[] = array(
                'icon'      => 'el el-home',
                'title'     => esc_html__('General Setting', 'zidane'),
                'fields'    => array(
                    array(
                        'id'        => 'general_logo',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => esc_html__('Logo', 'zidane'),
                    ),
                    array(
                        'id'        => 'general_logo_menu_sticky',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => esc_html__('Logo Menu Sticky', 'zidane'),
                    ),
                    array(
                        'id'        => 'general_back_to_top',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Back to Top button', 'zidane'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'general_animation',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable animation scroll', 'zidane'),
                        'default'   => true,
                    ),
                )
            );

        }

        private function favicon_section(){

            $this->sections[] = array(
                'icon'          => 'el el-opensource',
                'title'         => esc_html__('Favicon Setting', 'zidane'),
                'subsection'    => true,
                'fields'        => array(
                   
                    array(
                        'id'        => 'general_favicon',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => esc_html__('Favicon', 'zidane'),
                    ),

                    array(
                        'id'        => 'general_apple',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => esc_html__('Apple Touch Icon', 'zidane'),
                        'desc'      => esc_html__('Upload your Apple touch icon 57x57.', 'zidane'),
                    ),

                    array(
                        'id'        => 'general_apple_72',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => esc_html__('Apple Touch Icon 72x72', 'zidane'),
                        'desc'      => esc_html__('Upload your Apple touch icon 72x72.', 'zidane'),
                    ),

                    array(
                        'id'        => 'general_apple_114',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => esc_html__('Apple Touch Icon 114x114', 'zidane'),
                        'desc'      => esc_html__('Upload your Apple touch icon 114x114.', 'zidane'),
                    ),

                    array(
                        'id'        => 'general_apple_144',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => esc_html__('Apple Touch Icon 144x144', 'zidane'),
                        'desc'      => esc_html__('Upload your Apple touch icon 144x144.', 'zidane'),
                    ),
                )
            );

        }

        private function breadcrumb_section(){

            $this->sections[] = array(
                'icon' => 'el el-indent-left',
                'title' => esc_html__('Breadcrumb Options', 'zidane'),
                'fields' => array(
                    array(
                        'id'        => 'breadcrumb_color',
                        'type'      => 'color_rgba',
                        'title'     => 'Text Color',
                        'options'       => array(
                            'show_input'                => true,
                            'show_initial'              => true,
                            'show_alpha'                => true,
                            'show_palette'              => true,
                            'show_palette_only'         => false,
                            'show_selection_palette'    => true,
                            'max_palette_size'          => 10,
                            'allow_empty'               => true,
                            'clickout_fires_change'     => false,
                            'choose_text'               => esc_html__( 'Choose', 'zidane' ),
                            'cancel_text'               => esc_html__( 'Cancel', 'zidane' ),
                            'show_buttons'              => true,
                            'use_extended_classes'      => true,
                            'palette'                   => null,  // show default
                            'input_text'                => 'Select Color'
                        ),   
                        'output'    => array( 'color' => '.is-breadcrumb, .is-breadcrumb a' ),
                    ),
                    array(
                        'id'             => 'breadcrumb_padding',
                        'type'           => 'spacing',
                        'output'         => array('.is-breadcrumb'),
                        'mode'           => 'padding',
                        'units'          => 'px',
                        'units_extended' => 'true',
                        'left'           => 'false',
                        'right'          => 'false',
                        'title'          => esc_html__('Padding', 'zidane'),
                        'subtitle'       => esc_html__('___________________', 'zidane'),
                        'desc'           => esc_html__('___________________', 'zidane'),
                        'default'        => array(
                            'padding-top'       => '120px', 
                            'padding-bottom'    => '120px',
                        )
                    ),
                    array(         
                        'id'                    => 'breadcrumb_bg',
                        'type'                  => 'background',
                        'title'                 => esc_html__( 'Breadcrumb Background', 'zidane' ),
                        'subtitle'              => esc_html__( '____________', 'zidane' ),
                        'desc'                  => esc_html__( '____________', 'zidane' ),
                        'preview_media'         => true,
                        'background-attachment' => 'false',
                        'output'                => array('.is-breadcrumb')
                    )
                )
            );
            
            if( $this->function->is_request( 'woocommerce' ) ){
                $this->breadcrumb_woocommerce_section();
            }

            //$this->breadcrumb_404_section();

        }

        private function breadcrumb_woocommerce_section(){
            $this->sections[] = array(
                'subsection'    => true,
                'title'         => esc_html__('Woo Breadcrumb', 'zidane'),
                'fields'        => array(
                    array(
                        'id'        => 'breadcrumb_woo_color',
                        'type'      => 'color_rgba',
                        'title'     => 'Text Color',
                        'options'       => array(
                            'show_input'                => true,
                            'show_initial'              => true,
                            'show_alpha'                => true,
                            'show_palette'              => true,
                            'show_palette_only'         => false,
                            'show_selection_palette'    => true,
                            'max_palette_size'          => 10,
                            'allow_empty'               => true,
                            'clickout_fires_change'     => false,
                            'choose_text'               => esc_html__( 'Choose', 'zidane' ),
                            'cancel_text'               => esc_html__( 'Cancel', 'zidane' ),
                            'show_buttons'              => true,
                            'use_extended_classes'      => true,
                            'palette'                   => null,  // show default
                            'input_text'                => 'Select Color'
                        ),   
                        'output'    => array( 'color' => '.woocommerce-page .is-breadcrumb, .woocommerce-page .is-breadcrumb a' ),
                    ),
                    array(
                        'id'             => 'breadcrumb_woo_padding',
                        'type'           => 'spacing',
                        'output'         => array('.woocommerce-page .is-breadcrumb'),
                        'mode'           => 'padding',
                        'units'          => 'px',
                        'units_extended' => 'false',
                        'left'           => 'false',
                        'right'          => 'false',
                        'title'          => esc_html__('Padding', 'zidane'),
                        'subtitle'       => esc_html__('___________________', 'zidane'),
                        'desc'           => esc_html__('___________________', 'zidane'),
                        'default'        => array(
                            'padding-top'       => '120px', 
                            'padding-bottom'    => '120px',
                        )
                    ),
                    array(         
                        'id'                    => 'breadcrumb_woo_bg',
                        'type'                  => 'background',
                        'preview_media'         => true,
                        'title'                 => esc_html__( 'Breadcrumb Background', 'zidane' ),
                        'subtitle'              => esc_html__( '____________', 'zidane' ),
                        'desc'                  => esc_html__( '____________', 'zidane' ),
                        'background-attachment' => 'false',
                        'output'                => array('.woocommerce-page .is-breadcrumb')
                    )
                )
            );

        }

        private function breadcrumb_404_section(){
            $this->sections[] = array(
                'subsection'    => true,
                'title'         => esc_html__('404 Breadcrumb', 'zidane'),
                'fields'        => array(
                    array(
                        'id'        => 'breadcrumb_404_color',
                        'type'      => 'color_rgba',
                        'title'     => 'Text Color',
                        'options'       => array(
                            'show_input'                => true,
                            'show_initial'              => true,
                            'show_alpha'                => true,
                            'show_palette'              => true,
                            'show_palette_only'         => false,
                            'show_selection_palette'    => true,
                            'max_palette_size'          => 10,
                            'allow_empty'               => true,
                            'clickout_fires_change'     => false,
                            'choose_text'               => esc_html__( 'Choose', 'zidane' ),
                            'cancel_text'               => esc_html__( 'Cancel', 'zidane' ),
                            'show_buttons'              => true,
                            'use_extended_classes'      => true,
                            'palette'                   => null,  // show default
                            'input_text'                => 'Select Color'
                        ),   
                        'output'    => array( 'color' => '.woocommerce-page .is-breadcrumb, .woocommerce-page .is-breadcrumb a' ),
                    ),
                    array(
                        'id'             => 'breadcrumb_404_padding',
                        'type'           => 'spacing',
                        'output'         => array('.woocommerce-page .is-breadcrumb'),
                        'mode'           => 'padding',
                        'units'          => 'px',
                        'units_extended' => 'false',
                        'left'           => 'false',
                        'right'          => 'false',
                        'title'          => esc_html__('Padding', 'zidane'),
                        'subtitle'       => esc_html__('___________________', 'zidane'),
                        'desc'           => esc_html__('___________________', 'zidane'),
                        'default'        => array(
                            'padding-top'       => '120px', 
                            'padding-bottom'    => '120px',
                        )
                    ),
                    array(         
                        'id'                    => 'breadcrumb_404_bg',
                        'type'                  => 'background',
                        'preview_media'         => true,
                        'title'                 => esc_html__( 'Breadcrumb Background', 'zidane' ),
                        'subtitle'              => esc_html__( '____________', 'zidane' ),
                        'desc'                  => esc_html__( '____________', 'zidane' ),
                        'background-attachment' => 'false',
                        'output'                => array('.woocommerce-page .is-breadcrumb')
                    )
                )
            );

        }

        private function styling_section(){

            $this->sections[] = array(
                'icon' => 'el el-website',
                'title' => esc_html__('Styling Options', 'zidane'),
                'fields' => array(
                    array(
                        'id'        => 'styling_frontend',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Frontend Customize', 'zidane'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'styling_skin',
                        'type'      => 'select',
                        'title'     => esc_html__('Skin Template', 'zidane'),
                        'options'   => $this->get_skin_options(),
                        'default'   => 'cigarette',
                    ),
                    array(
                        'id'        => 'styling_csscode',
                        'type'      => 'ace_editor',
                        'title'     => esc_html__('CSS Code', 'zidane'),
                        'mode'      => 'css',
                        'theme'     => 'monokai',
                    ),
                )
            );

            $this->sections = apply_filters( 'customize_section', $this->sections );

        }

        private function header_section(){

            $this->sections[] = array(
                'icon' => 'el el-qrcode',
                'title' => esc_html__('Header Setting', 'zidane'),
                'fields' => array(
                    array(
                        'id'        => 'header_sticky',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Header Sticky', 'zidane'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'header_text',
                        'type'      => 'editor',
                        'title'     => esc_html__('Header Text', 'zidane'),
                        'default'   => '',
                    ),
                )
            );

        }

        private function topbar_section(){

            $this->sections[] = array(
                'title' => esc_html__('Top Bar Setting', 'zidane'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'        => 'header_topbar_enable',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Top B ar', 'zidane'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'header_topbar_text',
                        'type'      => 'textarea',
                        'title'     => esc_html__('Top Bar Text', 'zidane'),
                        'default'   => 'HOTLINE: (65) 8575 0171',
                        'required' => array( 
                            array( 'header_topbar_enable', 'equals', '1')
                        )
                    ),
                ),
            );

        }

        private function woocommerce_section(){

            $this->sections[] = array(
                'title'     => esc_html__('Woocommerce', 'zidane'),
                'icon'      => 'el el-shopping-cart',
                'fields'    => array(
                    array(
                        'id'        => 'woo_quickview',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Quick View', 'zidane'),
                        'default'   => true,
                    ),

                    array(
                        'id'        => 'woo_cart_fly',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Cart Effect Fly Images', 'zidane'),
                        'default'   => false,
                    ),

                    array(
                        'id'        => 'woo_effect_image',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Effect Image', 'zidane'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'woo_effect_skin',
                        'type'      => 'select',
                        'title'     => esc_html__('Effect Skin', 'zidane'),
                        'options'   => array(
                            'we-fade'               => 'Fade',
                            'we-bottom-to-top'      => 'Bottom to Top',
                            'we-flip-horizontal'    => 'Flip Horizontal',
                        ),
                        'default'   => 'we-fade',
                        'required'  => array( 'woo_effect_image', '=', '1' ),
                    ),
                )
            );

            $this->woocommerce_archive_section();

            $this->woocommerce_detail_section();

        }

        private function woocommerce_archive_section(){

            $this->sections[] = array(
                'title' => esc_html__('Product Archive', 'zidane'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'        => 'woo_show_page_title',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Page Title', 'zidane'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'woo_layout',
                        'type'      => 'image_select',
                        'title'     => esc_html__('Shop Layout', 'zidane'),
                        'subtitle'  => esc_html__('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.', 'zidane'),
                        'options'   => array(
                            '1' => array(
                                'alt' => '1 Column',
                                'img' => get_template_directory_uri() . '/images/1c.png'
                            ),
                            '2' => array(
                                'alt' => '2 Column Left',
                                'img' => get_template_directory_uri() . '/images/2cl.png'
                            ),
                            '3' => array(
                                'alt' => '3 Column Right',
                                'img' => get_template_directory_uri() . '/images/2cr.png'
                            ),
                        ),
                        'default' => '2',
                    ),
                    array(
                        'id'        => 'woo_sidebar',
                        'type'      => 'select',
                        'data'      => 'sidebars',
                        'title'     => esc_html__( 'Sidebar', 'zidane' ),
                        'default'   => 'shop-sidebar',
                        'required'  => array( 'woo_layout', '!=', '1' ),
                    ),
                    array(
                        'id'        => 'woo_archive_show',
                        'type'      => 'text',
                        'title'     => esc_html__('Number of products', 'zidane'),
                        'desc'      => esc_html__('To Change number of products displayed at products, category page.', 'zidane'),
                        'default'   => '9',
                        'validate'  => 'numeric',
                    ),
                    array(
                        'id'        => 'woo_archive_col',
                        'type'      => 'select',
                        'title'     => esc_html__('Archive Columns', 'zidane'),
                        'options'   => array(
                            '2' => '2 Columns',
                            '3' => '3 Columns',
                            '4' => '4 Columns',
                            '5' => '5 Columns',
                            '6' => '6 Columns',
                        ),
                        'default'   => '3',
                    ),
                ),
            );

        }


        private function woocommerce_detail_section(){

            $this->sections[] = array(
                'title' => esc_html__('Product Detail', 'zidane'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'        => 'woo_detail_layout',
                        'type'      => 'image_select',
                        'title'     => esc_html__('Shop Layout', 'zidane'),
                        'subtitle'  => esc_html__('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.', 'zidane'),
                        'options'   => array(
                            '1' => array(
                                'alt' => '1 Column',
                                'img' => get_template_directory_uri() . '/images/1c.png'
                            ),
                            '2' => array(
                                'alt' => '2 Column Left',
                                'img' => get_template_directory_uri() . '/images/2cl.png'
                            ),
                            '3' => array(
                                'alt' => '3 Column Right',
                                'img' => get_template_directory_uri() . '/images/2cr.png'
                            ),
                        ),
                        'default' => '1'
                    ),

                    array(
                        'id'        => 'woo_details_single',
                        'type'      => 'select',
                        'title'     => esc_html__('Single Sidebar', 'zidane'),
                        'data'      => 'sidebar',
                        'default'   => '1',
                        'required'  => array( 'woo_detail_layout', '!=', '1' ),
                    ),
                    array(
                        'id'        => 'woo_detail_related_show',
                        'type'      => 'text',
                        'title'     => esc_html__('Number of Related Products', 'zidane'),
                        'desc'      => esc_html__('To Change number of products displayed related.', 'zidane'),
                        'default'   => '3',
                        'validate'  => 'numeric',
                    ),

                    array(
                        'id'        => 'woo_detail_related_col',
                        'type'      => 'select',
                        'title'     => esc_html__('Related Columns', 'zidane'),
                        'options'   => array(
                            '2' => '2 Columns',
                            '3' => '3 Columns',
                            '4' => '4 Columns',
                            '5' => '5 Columns',
                            '6' => '6 Columns',
                        ),
                        'default' => '3',
                    ),
                    array(
                        'id'        => 'woo_detail_upsells_show',
                        'type'      => 'text',
                        'title'     => esc_html__('Number of UpSell Products', 'zidane'),
                        'desc'      => esc_html__('To Change number of products displayed up-sell.', 'zidane'),
                        'default'   => '3',
                        'validate'  => 'numeric',
                    ),
                    array(
                        'id'        => 'woo_detail_upsells_col',
                        'type'      => 'select',
                        'title'     => esc_html__('Upsells Columns', 'zidane'),
                        'options'   => array(
                            '2' => '2 Columns',
                            '3' => '3 Columns',
                            '4' => '4 Columns',
                            '5' => '5 Columns',
                            '6' => '6 Columns',
                        ),
                        'default' => '3',
                    ),
                    array(
                        'id'        => 'woo_detail_cross_sell_show',
                        'type'      => 'text',
                        'title'     => esc_html__('Number of Cross Sells Products', 'zidane'),
                        'desc'      => esc_html__('To Change number of products displayed cross sells.', 'zidane'),
                        'default'   => '8',
                        'validate'  => 'numeric',
                    ),

                    array(
                        'id'        => 'woo_detail_cross_sell_col',
                        'type'      => 'select',
                        'title'     => esc_html__('Cross Sells Columns', 'zidane'),
                        'options'   => array(
                            '2' => '2 Columns',
                            '3' => '3 Columns',
                            '4' => '4 Columns',
                            '5' => '5 Columns',
                            '6' => '6 Columns',
                        ),
                        'default'   => '4',
                    ),
                ),
            );

        }

        private function blog_section(){

            $this->sections[] = array(
                'title' => esc_html__('Blog Setting', 'zidane'),
                'icon' => 'el el-bold',
                'fields' => array(
                    array(
                        'id'        => 'blog_layout',
                        'type'      => 'image_select',
                        'title'     => esc_html__('Blog Layout', 'zidane'),
                        'options'   => array(
                            '1' => array(
                                'alt' => '1 Column',
                                'img' => get_template_directory_uri() . '/images/1c.png'
                            ),
                            '2' => array(
                                'alt' => '2 Column Left',
                                'img' => get_template_directory_uri() . '/images/2cl.png'
                            ),
                            '3' => array(
                                'alt' => '2 Column Right',
                                'img' => get_template_directory_uri() . '/images/2cr.png'
                            ),
                        ),
                        'default'   => '1',
                    ),
                    array(
                        'id'        => 'blog_sidebar',
                        'type'      => 'select',
                        'data'      => 'sidebars',
                        'title'     => esc_html__('Sidebar', 'zidane'),
                        'default'   => 'blog-sidebar',
                    ),
                )
            );

        }

        private function blog_single_section(){

            $this->sections[] = array(
                'title'         => esc_html__('Single Setting', 'zidane'),
                'subsection'    => true,
                'fields'        => array(
                    array(
                        'id'        => 'single_layout',
                        'type'      => 'image_select',
                        'title'     => esc_html__('Single Layout', 'zidane'),
                        'options'   => array(
                            '1' => array(
                                'alt' => '1 Column',
                                'img' => get_template_directory_uri() . '/images/1c.png'
                            ),
                            '2' => array(
                                'alt' => '2 Column Left',
                                'img' => get_template_directory_uri() . '/images/2cl.png'
                            ),
                            '3' => array(
                                'alt' => '2 Column Right',
                                'img' => get_template_directory_uri() . '/images/2cr.png'
                            ),
                        ),
                        'default'   => '1',
                    ),
                    array(
                        'id'        => 'single_sidebar',
                        'type'      => 'select',
                        'data'      => 'sidebars',
                        'title'     => esc_html__('Sidebar', 'zidane'),
                        'default'   => 'blog-sidebar',
                        'required'  => array( 'single_layout', '!=', '1' ),
                    ),
                    array(
                        'id'        => 'single_authorbio',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Author Bio', 'zidane'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'single_social',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Social Share', 'zidane'),
                        'default'   => true,
                    ),
                )
            );

        }

        private function megamenu_sction(){

            $this->sections[] = array(
                'title' => esc_html__('Megamenu Setting', 'zidane'),
                'icon' => 'el el-icon-lines',
                'fields' => array(
                    array(
                        'id'        => 'megamenu-animation',
                        'type'      => 'select',
                        'title'     => esc_html__('Animation', 'zidane'),
                        'options'   => array(
                                'effect-none'   => 'None',
                                'bottom-to-top' => 'Bottom to top',
                                'slide'         => 'Slide',
                                'elastic'       => 'Elastic',
                                'zoom'          => 'Zoom',
                            ),
                        'desc'      => 'Select animation for Megamenu.',
                        'default'   => 'effect-none',
                    ),
                    array(
                        'id'        => 'megamenu-duration',
                        'type'      => 'text',
                        'title'     => esc_html__('Duration', 'zidane'),
                        'desc'      => esc_html__('Animation effect duration for dropdown of Megamenu (in miliseconds).', 'zidane'),
                        'validate'  => 'numeric',
                        'default'   => '400',
                    ),
                ),
            );

        }

        private function footer_section(){

            $footers_type = get_posts( array(
                'posts_per_page' => -1,
                'post_type'=>'footer'
            ));
            $footers_option = array();
            if( !empty( $footers_type ) ){
                foreach ( $footers_type as $key => $value ) {
                    $footers_option[$value->ID] = $value->post_title;
                }
            }

            $this->sections[] = array(
                'title'     => esc_html__('Footer Setting', 'zidane'),
                'icon'      => 'el el-list-alt',
                'fields'    => array(
                    array(
                        'id'        => 'footer_custom',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Footer Customize', 'zidane'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'footer',
                        'type'      => 'select',
                        'required'  => array( 'footer_custom', '=', '1'),
                        'title'     => esc_html__('Footer Item', 'zidane'),
                        'options'   => $footers_option,
                        'default'   => ''
                    ),
                    array(
                        'id'        => 'footer_top',
                        'type'      => 'editor',
                        'title'     => esc_html__('Footer Top', 'zidane'),
                        'subtitle'  => esc_html__("You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]", 'zidane'),
                        'args'      => array(
                            'teeny'         => true,
                            'textarea_rows' => 10,
                        ),
                        'required'  => array( 'footer_custom', '=', '0' ),
                    ),
                    array(
                        'id'        => 'footer_copyright',
                        'type'      => 'editor',
                        'title'     => esc_html__('Footer Copyright', 'zidane'),
                        'subtitle'  => esc_html__("YYou can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]", 'zidane'),
                        'args'      => array(
                            'teeny'         => true,
                            'textarea_rows' => 10,
                        ),
                        'default'   => 'Copyright &copy;2016 zidane by Inspius. All right Reserved',
                    ),

                )
            );

        }

        private function import_section(){

            $this->sections[] = array(
                'title'         => esc_html__('Import / Export', 'zidane'),
                'desc'          => esc_html__('Import and Export your Redux Framework settings from file, text or URL.', 'zidane'),
                'icon'          => 'el el-refresh',
                'fields'        => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );

        }
    }
}

new Inspius_Redux_Framework();

