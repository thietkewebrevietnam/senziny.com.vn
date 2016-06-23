<?php
require_once( INSPIUS_PATH_URL . '/framework/libs/functions.php' );

class Inspius_Core extends Inspius_Functions {

	protected $plugins = array();

	public function __construct() {

		$this->set_required_plugins();
		$this->includes();
		$this->init_hooks();

	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function includes() {

		if ( $this->is_request( 'redux' ) ) {
			include_once( INSPIUS_PATH_URL . '/framework/libs/themeoptions.php' );
			include_once( INSPIUS_PATH_URL . '/inc/themeoptions.php' );
		}

		if ( $this->is_request( 'woocommerce' ) ) {
			include_once( INSPIUS_PATH_URL . '/framework/libs/woocommerce.php' );
			include_once( INSPIUS_PATH_URL . '/inc/woocommerce.php' );
		}

		if ( $this->is_request( 'visual-composer' ) ) {
			include_once( INSPIUS_PATH_URL . '/framework/libs/pagebuilder.php' );
			include_once( INSPIUS_PATH_URL . '/inc/pagebuilder.php' );
		}

		if ( $this->is_request( 'metabox' ) ) {
			include_once( INSPIUS_PATH_URL . '/framework/libs/metabox.php' );
			include_once( INSPIUS_PATH_URL . '/inc/metabox.php' );
		}

		if ( $this->is_request( 'wpml' ) ) {
			include_once( INSPIUS_PATH_URL . '/framework/libs/wpml.php' );
		}

		//Plugin Required
		include_once( INSPIUS_PATH_URL . '/framework/libs/plugin-activation.php' );

		// Megamenu
		include_once( INSPIUS_PATH_URL . '/framework/megamenu/megamenu.php' );

		// Breadcrumb
		include_once( INSPIUS_PATH_URL . '/framework/libs/breadcrumb.php' );

	}

	/**
	 *
	 * Hook into actions and filters
	 *
	 */
	private function init_hooks() {

		if ( ! isset( $content_width ) ) {
			$content_width = 900;
		}
		$tags = get_the_tags();

		add_action( 'tgmpa_register', array( $this, 'required_plugins' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'init_admin_scripts' ) );

		// Config layout
		add_action( 'wp_head', array( $this, 'layout_config' ) );
		add_action( 'wp_head', array( $this, 'init_ajax_url' ), 15 );

		// Mobile main menu
		add_action( 'is_before_wrapper', array( $this, 'menu_offcanvas' ) );

		// Javascript & CSS Action
		add_action( 'wp_enqueue_scripts', array( $this, 'init_css' ) );
		add_action( 'wp_footer', array( $this, 'init_javascript' ) );

		//Add Shortcode Widget Text
		add_filter( 'widget_text', 'do_shortcode' );

		//Setup Footer Custom
		add_action( 'wp_head', array( $this, 'init_footer_custom' ) );

	}

	public function init_javascript() {
		$gmap = wp_script_is( 'theme-gmap-api' ) ? 'true' : 'false';
		?>
		<script>
			jQuery(document).ready(function ($) {
				$('body').InspiusFrontend({
					BackToTop:          <?php echo ( $this->get_option( 'general_back_to_top', true ) ) ? 'true' : 'false'; ?>,
					AnimationScroll:    <?php echo ( $this->get_option( 'general_animation', true ) ) ? 'true' : 'false'; ?>,
					GMap:                <?php echo esc_attr( $gmap ); ?>,
					StickyMenu:        <?php echo ( $this->get_option( 'header_sticky', true ) ) ? 'true' : 'false'; ?>,
				});
			});
		</script>
		<?php
	}

	public function init_footer_custom() {
		if ( ! $this->get_option( 'footer_custom', false ) ) {
			return false;
		}
		$footer_id = $this->get_option( 'footer', false );
		if ( $footer_id ) {
			global $footer_content;
			$footer_content = get_post( $footer_id )->post_content;
			$style          = preg_match_all( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $footer_content, $matches );
			if ( $style ) {
				echo '<style type="text/css">';
				foreach ( $matches[0] as $value ) {
					echo $value . "\n";
				}
				echo '</style>';
			}
			$footer_content = do_shortcode( $footer_content );
		}
	}

	public function init_ajax_url() {
		?>
		<script type="text/javascript">
			var ajaxurl = '<?php echo esc_url( admin_url('admin-ajax.php') ); ?>';
		</script>
		<?php
	}

	public function init_css() {
		wp_add_inline_style( 'inspius-style-custom', $this->get_option( 'styling_csscode', '' ) );
	}

	public function init_admin_scripts() {
		wp_enqueue_style( 'inspius_backend', INSPIUS_PATH_URI . '/framework/assets/css/backend.css' );

		wp_enqueue_script( 'inspius_backend', INSPIUS_PATH_URI . '/framework/assets/js/backend.js' );
	}

	public function menu_offcanvas() {

		?>
		<div id="is-off-canvas" class="uk-offcanvas">
			<?php
			$args = array(
				'theme_location'  => 'mainmenu',
				'container_class' => 'uk-offcanvas-bar',
				'menu_class'      => 'uk-nav uk-nav-offcanvas uk-nav-parent-icon',
				'fallback_cb'     => '',
				'menu_id'         => 'main-menu-offcanvas',
				'items_wrap'      => '<ul id="%1$s" class="%2$s" data-uk-nav>%3$s</ul>',
				'walker'          => new Inspius_Megamenu_Offcanvas()
			);
			wp_nav_menu( $args );
			?>
		</div>
		<?php
	}

	public function list_comments( $comment, $args, $depth ) {
		$path = INSPIUS_PATH_URL . '/templates/global/list-comments.php';
		if ( is_file( $path ) ) {
			require( $path );
		}
	}

	public function layout_config() {
		global $wp_query;
		$layout = '';
		if ( is_post_type_archive( 'product' ) || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) {
			$layout = $this->get_option( 'woo_layout', '2' );
		} else if ( function_exists( 'is_product' ) && is_product() ) {
			$layout = $this->get_option( 'woo_detail_layout', '1' );
		} else if ( is_page() ) {
			$page_id = $wp_query->get_queried_object_id();
			$layout  = get_post_meta( $page_id, '_is_page_layout', true );
		} else if ( is_single() ) {
			$layout = $this->get_option( 'single_layout', '1' );
		} else {
			$layout = $this->get_option( 'blog_layout', '1' );
		}

		add_filter( 'is_sidebar_area', array( $this, 'set_sidebar_area' ) );

		switch ( $layout ) {
			// Two Sidebar
			case '4':
				add_filter( 'is_sidebar_left_class', create_function( '', 'return "col-sm-6 col-md-3 col-md-pull-6";' ) );
				add_filter( 'is_sidebar_right_class', create_function( '', 'return "col-sm-6  col-md-3";' ) );
				add_filter( 'is_main_class', create_function( '', 'return "col-md-6 col-md-push-3 is-main-two-sidebar";' ) );
				add_filter( 'is_check_sidebar_left', create_function( '', 'return true;' ) );
				add_filter( 'is_check_sidebar_right', create_function( '', 'return true;' ) );
				break;
			//One Sidebar Right
			case '3':
				add_filter( 'is_sidebar_right_class', create_function( '', 'return "col-md-3";' ) );
				add_filter( 'is_main_class', create_function( '', 'return "col-md-9 is-main-right-sidebar";' ) );
				add_filter( 'is_check_sidebar_right', create_function( '', 'return true;' ) );
				break;
			// One Sidebar Left
			case '2':
				add_filter( 'is_sidebar_left_class', create_function( '', 'return "col-md-3 col-md-pull-9";' ) );
				add_filter( 'is_main_class', create_function( '', 'return "col-md-9 col-md-push-3 is-main-left-sidebar";' ) );
				add_filter( 'is_check_sidebar_left', create_function( '', 'return true;' ) );
				break;
			// Fullwidth
			default:
				add_filter( 'is_main_class', create_function( '', 'return "col-xs-12 is-main-no-sidebar";' ) );
				add_filter( 'is_check_sidebar_left', create_function( '', 'return false;' ) );
				add_filter( 'is_check_sidebar_right', create_function( '', 'return false;' ) );
				break;
		}
	}

	public function set_sidebar_area() {
		global $wp_query;
		$sidebar = '';
		if ( is_post_type_archive( 'product' ) || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) {
			$sidebar = $this->get_option( 'woo_sidebar', 'shop-sidebar' );
		} elseif ( function_exists( 'is_product' ) && is_product() ) {
			$sidebar = $this->get_option( 'woo_sidebar', 'shop-sidebar' );
		} else if ( is_page() ) {
			$page_id = $wp_query->get_queried_object_id();
			$sidebar = get_post_meta( $page_id, '_is_page_sidebar', true );
		} else {
			$sidebar = $this->get_option( 'blog_sidebar', 'blog-sidebar' );
		}

		return $sidebar;
	}

	/**
	 *
	 * Function required plugins
	 *
	 */
	public function set_required_plugins() {
	}


	// Hook plugins required
	public function required_plugins() {
		$config = array(
			'id'           => 'zidane',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $this->plugins, $config );
	}
}