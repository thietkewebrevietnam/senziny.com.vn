<?php

define( 'INSPIUS_PATH_URL', get_template_directory() );
define( 'INSPIUS_PATH_URI', get_template_directory_uri() );

require_once INSPIUS_PATH_URL . '/framework/init.php';

if ( ! class_exists( 'Inspius_Framework' ) ) {
	Class Inspius_Framework extends Inspius_Core {

		public static $_instance;

		/**
		 * Main Inspius_Framework Instance
		 *
		 * Ensures only one instance of Inspius_Framework is loaded or can be loaded.
		 *
		 * @static
		 * @return Inspius_Framework - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}


		/**
		 * Inspius_Framework Constructor.
		 */
		public function __construct() {

			parent::__construct();

			$this->init_hooks();

		}

		/**
		 * Hook into actions and filters
		 */
		private function init_hooks() {
			add_action( 'after_setup_theme', array( $this, 'init_after_setup' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'init_scripts' ) );

			// Register widget area
			add_action( 'widgets_init', array( $this, 'init_widgets' ) );

			//Style Breadcrumb
			add_filter( 'is_style_breadcrumb', array( $this, 'style_breadcrumb_override' ) );
			
			// Fix iframe
			add_filter( 'oembed_result', array( $this, 'fix_oembeb' ) );
		}

		public function init_scripts() {

			$protocol = is_ssl() ? 'https:' : 'http:';
			$version  = $this->get_theme_version();

			//init Script
			wp_enqueue_script( 'jquery' );
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

			$this->add_google_font( array(
				'Montserrat:400,700',
				'Merriweather:300italic',
			) );

			wp_register_script( 'theme-gmap-core', 		$protocol .'//maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places', array(), $version, true );
    		wp_register_script( 'theme-gmap-api', 		INSPIUS_PATH_URI . '/js/gmap.js', array(), $version, true );

			wp_enqueue_script( 'theme-bootstrap', 		INSPIUS_PATH_URI . '/js/bootstrap.min.js', array(), $version, true );
			wp_enqueue_script( 'theme-owl-carousel_js', INSPIUS_PATH_URI . '/js/owl.carousel.min.js', array(), $version, true );
			wp_enqueue_script( 'theme-wow_js', 			INSPIUS_PATH_URI . '/js/jquery.wow.min.js', array(), $version, true );
			wp_enqueue_script( 'theme-modernizr_js', 	INSPIUS_PATH_URI . '/js/modernizr.custom.js', array(), $version, true );
			wp_enqueue_script( 'theme-uk_js', 			INSPIUS_PATH_URI . '/js/uikit.min.js', array(), $version, true );
			wp_enqueue_script( 'theme-main_js', 		INSPIUS_PATH_URI . '/js/theme.js', array(), $version, true );

			// Init Style
			$skin_theme = $this->get_option( 'styling_skin', 'cigarette' );
			wp_enqueue_style( 'bootstrap', 				INSPIUS_PATH_URI . '/css/' . $skin_theme . '/bootstrap.css' );
			wp_enqueue_style( 'inspius-woocommerce', 	INSPIUS_PATH_URI . '/css/' . $skin_theme . '/woocommerce.css' );
			wp_enqueue_style( 'main_css', 				INSPIUS_PATH_URI . '/css/' . $skin_theme . '/main.css' );
			wp_enqueue_style( 'font-awesome', 			INSPIUS_PATH_URI . '/css/font-awesome.css' );
			wp_enqueue_style( 'font-simpleline', 		INSPIUS_PATH_URI . '/css/simple-line-icons.css' );
			wp_enqueue_style( 'animation', 				INSPIUS_PATH_URI . '/css/animation.css' );

			if ( is_child_theme() ) {
				wp_enqueue_style( 'parent-style', 		INSPIUS_PATH_URI . '/style.css' );
				wp_enqueue_style( 'inspius-style', get_stylesheet_uri(), array( 'parent-style' ) );
			} else {
				wp_enqueue_style( 'inspius-style', get_stylesheet_uri() );
			}

		}

		/**
		 * Set Plugins required
		 */
		public function set_required_plugins() {
			$this->plugins[] = array(
				'name'     => 'WooCommerce', // The plugin name
				'slug'     => 'woocommerce', // The plugin slug (typically the folder name)
				'required' => true, // If false, the plugin is only 'recommended' instead of required
			);
			
			$this->plugins[] = array(
				'name'     => 'Redux Framework', // The plugin name
				'slug'     => 'redux-framework', // The plugin slug (typically the folder name)
				'required' => true, // If false, the plugin is only 'recommended' instead of required
			);

			$this->plugins[] = array(
                'name'     => 'Contact Form 7', // The plugin name
                'slug'     => 'contact-form-7', // The plugin slug (typically the folder name)
                'required' => false, // If false, the plugin is only 'recommended' instead of required
            );

			$this->plugins[] = array(
				'name'     => 'Metabox', // The plugin name
				'slug'     => 'cmb2', // The plugin slug (typically the folder name)
				'required' => true, // If false, the plugin is only 'recommended' instead of required
			);
			$this->plugins[] = array(
                'name'     => 'YITH WooCommerce Zoom Magnifier', // The plugin name
                'slug'     => 'yith-woocommerce-zoom-magnifier', // The plugin slug (typically the folder name)
                'required' =>  false
            );

            $this->plugins[] = array(
                'name'     => 'YITH WooCommerce Wishlist', // The plugin name
                'slug'     => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
                'required' => false
            );

            $this->plugins[] = array(
                'name'     => 'Inspius Core', // The plugin name
                'slug'     => 'inspius_core', // The plugin slug (typically the folder name)
	            'required' => true,
	            'source'   => INSPIUS_PATH_URL . '/plugins/inspius_core.zip', // The plugin source
            );

            $this->plugins[] = array(
                'name'     => 'WPBakery Visual Composer', // The plugin name
                'slug'     => 'js_composer', // The plugin slug (typically the folder name)
                'required' => true,
                'source'   => 'http://theme.inspius.com/server_update/plugins/js_composer.zip', // The plugin source
            );

        	$this->plugins[] = array(
                'name'     => 'Revolution Slider', // The plugin name
                'slug'     => 'revslider', // The plugin slug (typically the folder name)
                'required' => true, // If false, the plugin is only 'recommended' instead of required
                'source'   => 'http://theme.inspius.com/server_update/plugins/revslider.zip', // The plugin source
            );
		}

		public function init_widgets() {

			register_sidebar( array(
				'name'          => esc_html__( 'Shop Sidebar', 'zidane' ),
				'id'            => 'shop-sidebar',
				'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'zidane' ),
				'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title"><span>',
				'after_title'   => '</span></h3>'
			) );

			register_sidebar( array(
				'name'          => esc_html__( 'Shop Single Sidebar', 'zidane' ),
				'id'            => 'shop-single-sidebar',
				'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'zidane' ),
				'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title"><span>',
				'after_title'   => '</span></h3>'
			) );

			register_sidebar( array(
				'name'          => esc_html__( 'Blog Sidebar', 'zidane' ),
				'id'            => 'blog-sidebar',
				'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'zidane' ),
				'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title"><span>',
				'after_title'   => '</span></h3>'
			) );

			register_sidebar( array(
				'name'          => esc_html__( 'Footer 1', 'zidane' ),
				'id'            => 'footer-1',
				'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'zidane' ),
				'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title"><span>',
				'after_title'   => '</span></h3>'
			) );

			register_sidebar( array(
				'name'          => esc_html__( 'Footer 2', 'zidane' ),
				'id'            => 'footer-2',
				'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'zidane' ),
				'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title"><span>',
				'after_title'   => '</span></h3>'
			) );
			register_sidebar( array(
				'name'          => esc_html__( 'Footer 3', 'zidane' ),
				'id'            => 'footer-3',
				'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'zidane' ),
				'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title"><span>',
				'after_title'   => '</span></h3>'
			) );
			register_sidebar( array(
				'name'          => esc_html__( 'Footer 4', 'zidane' ),
				'id'            => 'footer-4',
				'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'zidane' ),
				'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title"><span>',
				'after_title'   => '</span></h3>'
			) );
		}

		public function init_after_setup() {

			load_theme_textdomain( 'zidane', get_template_directory() . '/languages' );
			
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );

			add_theme_support( 'post-thumbnails' );

			add_theme_support( 'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption'
			) );

			add_theme_support( 'post-formats', array(
		       'image', 
		       'video', 
		       'audio', 
		       'gallery', 
		       'status'
		    ) );


			register_nav_menus( array(
				'mainmenu' => esc_html__( 'Main Menu', 'zidane' ),
			) );

		}

		public function style_breadcrumb_override(){
			if( is_page() || is_single() ){
				$style= array();

				$bg_image 		= $this->get_metabox( '_is_page_is_breadcrumb_bg_images', '' );
				$bg_repeat 		= $this->get_metabox( '_is_page_is_breadcrumb_bg_repeat', '' );
				$bg_size 		= $this->get_metabox( '_is_page_is_breadcrumb_bg_size', '' );
				$bg_position 	= $this->get_metabox( '_is_page_is_breadcrumb_bg_position', '' );
				$bg_color 		= $this->get_metabox( '_is_page_is_breadcrumb_bg_color', '' );
				// return $bg_image;
				if( $bg_position != '' ){
					$style[] = 'background-position:' . $bg_position;
				}
				if( $bg_size != '' ){
					$style[] = 'background-size:' . $bg_size;
				}
				if( $bg_repeat != '' ){
					$style[] = 'background-repeat:' . $bg_repeat;
				}
				if( $bg_color != '' ){
					$style[] = 'background-color:' . $bg_color;
					if( $bg_image == '' ){
						$style[] = 'background-image: none';
					}
				}
				if( $bg_image != '' ){
					$style[] = 'background-image: url(' . esc_url( $bg_image ) . ')';
				}

				if( empty( $style ) ){
					return '';
				}
				
				return 'style="' . implode( ';', $style ) . '"';
			}
			return '';
		}

		public function fix_oembeb( $url ){
		    $array = array (
		        'webkitallowfullscreen'     => '',
		        'mozallowfullscreen'        => '',
		        'frameborder="0"'           => '',
		        'scrolling="no"'           	=> '',
		        'frameborder="no"'          => '',
		        '</iframe>)'        		=> '</iframe>'
		    );
		    $url = strtr( $url, $array );

		    if ( strpos( $url, "<embed src=" ) !== false ){
		        return str_replace('</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $url);
		    }
		    elseif ( strpos ( $url, 'feature=oembed' ) !== false ){
		        return str_replace( 'feature=oembed', esc_url('feature=oembed&wmode=opaque'), $url );
		    }
		    else{
		        return $url;
		    }
		}

		public function the_header(){
			$header_layout = $this->get_option( 'styling_skin', 'cigarette' );
			get_template_part( 'templates/header/' . $header_layout );
		}

		public function the_footer_custom_content(){
			global $footer_content;
			echo '<div id="footer"><div class="container">' . $footer_content . '</div></div>'; 
		}
		
	}
}

/**
 * Returns the main instance of InspiusFramework to prevent the need to use globals.
 */

if ( ! function_exists( 'zidane_framework' ) ) {
	function zidane_framework() {
		return Inspius_Framework::instance();
	}
	Inspius_Framework::instance();
}












