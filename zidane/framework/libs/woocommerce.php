<?php  

class Inspius_Woocommerce_Base{
	
	public $is_function;

	public function __construct(){
		$this->is_function = Inspius_Functions::instance();
		$this->init_hook();
	}

	private function init_hook(){

		add_action( 'after_setup_theme', 						array( $this, 'woocommerce_support' ) );
		// Remove base CSS
		add_filter( 'woocommerce_enqueue_styles', 				array( $this, 'remove_base_stylesheet' ) );

		// Add new Style
		add_action( 'wp_enqueue_scripts', 						array( $this, 'init_scripts' ), 15 );

		add_action( 'is_before_wrapper', 						array( $this, 'add_cart_canvas' ) );
		add_action( 'add_to_cart_fragments', 					array( $this, 'ajax_add_to_cart' ) );

		//Ajax Remove product in cart
		add_action( 'wp_ajax_cart_remove_product', 				array( $this, 'ajax_remove_product_in_cart' ) );
		add_action( 'wp_ajax_nopriv_cart_remove_product', 		array( $this, 'ajax_remove_product_in_cart' ) );



		// Effect Image Hover thumbnail
		if( $this->is_function->get_option( 'woo_effect_image', true ) ){
			remove_action( 'woocommerce_before_shop_loop_item_title', 	'woocommerce_template_loop_product_thumbnail', 10 );
			add_action( 'woocommerce_before_shop_loop_item_title', 		array( $this, 'effect_image_hover' ) , 10 );
			add_filter( 'body_class', 									array( $this, 'effect_hover_skin' ) );
		}

		// Archive Page
		add_filter( 'woocommerce_show_page_title', 				array( $this, 'switch_show_page_title' ) );		

		// Upsells Display setup
		remove_action( 'woocommerce_after_single_product_summary', 		'woocommerce_upsell_display', 15 );
		add_action( 'woocommerce_after_single_product_summary', 		array( $this, 'upsells_display' ), 15 );

		// Related Display setup
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_display' ) );

		// Cross Sells Display setup
		add_action( 'woocommerce_cross_sells_columns', 			array( $this, 'cross_sells_columns' ) );
		add_action( 'woocommerce_cross_sells_total', 			array( $this, 'cross_sells_total' ) );

		// Woocommerce Config display
		add_filter( 'loop_shop_columns', 						array( $this, 'archive_product_col' ), 1 );
		add_filter( 'loop_shop_per_page', 						array( $this, 'archive_product_show' ) , 20 );
		add_filter( 'is_woocommerce_column_class', 				array( $this, 'set_archive_column_class' ) );


		// QuickView
		add_action( 'wp_ajax_is_quickview', 		array( $this, 'woocoomerce_quickView' ) );
		add_action( 'wp_ajax_nopriv_is_quickview', 	array( $this, 'woocoomerce_quickView' ) );

		// Ajax Wishlist
		if( $this->is_function->is_request( 'wishlist' ) ){
			$wishlist = YITH_WCWL::get_instance();
			add_action( 'wp_ajax_is_quickview', 		array( $wishlist, 'add_to_wishlist' ) );
			add_action( 'wp_ajax_nopriv_is_quickview', 	array( $wishlist, 'add_to_wishlist' ) );
		}

		// Cart Effect Fly
		add_filter( 'body_class', array( $this, 'cart_effect_fly' ) );
	}

	public function switch_show_page_title(){
		return $this->is_function->get_option( 'woo_show_page_title', true );
	}

	public function woocoomerce_quickView(){
		global $post, $product, $woocommerce;
	    $prod_id 	= $_POST["product"];
	    $post 		= get_post( $prod_id );
	    $product 	= get_product( $prod_id );

	    woocommerce_get_template( 'theme/quickview.php');
	    
	    exit();
	}

	public function init_scripts(){
		
		wp_enqueue_script(  'inspius-popup-js', 		INSPIUS_PATH_URI . '/js/jquery.magnific-popup.js', array( 'jquery' ) );
		wp_enqueue_script(  'inspius-countdown-js', 	INSPIUS_PATH_URI . '/framework/assets/js/countdown.js', array( 'jquery' ) );
		wp_localize_script( 'inspius-countdown-js',  	'is_countdown_l10n', $this->get_label_countdown() );

		wp_enqueue_script( 'inspius-woocommerce-js', 	INSPIUS_PATH_URI . '/js/woocommerce.js', array(), false, true );
	}

	protected function get_label_countdown(){}

	public function set_archive_column_class( $value ){
		global $woocommerce_loop;
		switch ($woocommerce_loop['columns']) {
			case '2':
				$value[] = 'col-sm-6';
				break;
			case '3':
				$value[] = 'col-sm-4';
				break;
			case '4':
				$value[] = 'col-md-3 col-sm-6';
				break;
			case '5':
				$value[] = 'col-md-20 col-sm-4';
				break;
			case '6':
				$value[] = 'col-sm-4 col-md-2';
				break;
			default:
				$value[] = 'col-md-3 col-sm-6';
				break;
		}
		return $value;
	}

	public function archive_product_show( $cols ){
		return $this->is_function->get_option( 'woo_archive_show', 9 );
	}

	public function archive_product_col(){
		return $this->is_function->get_option( 'woo_archive_col', 3 );
	}

	public function cross_sells_columns(){
		return $this->is_function->get_option( 'woo_detail_cross_sell_col', 4 );
	}
	public function cross_sells_total(){
		return $this->is_function->get_option( 'woo_detail_cross_sell_show', 8 );
	}

	public function related_display( $args ){
		$args['posts_per_page'] = $this->is_function->get_option( 'woo_detail_related_show', 3 );
		$args['columns'] 		= $this->is_function->get_option( 'woo_detail_related_col', 3 );
		return $args;
	}

	public function upsells_display() {
	    woocommerce_upsell_display( 
	    	$this->is_function->get_option( 'woo_detail_upsells_show', 3 ), 
	    	$this->is_function->get_option( 'woo_detail_upsells_col', 3 )
	    ); 
	}

	/*
	 * Enable support for Woocommerce.
	 */
	public function woocommerce_support(){
		add_theme_support( 'woocommerce' );
	}

	public function remove_base_stylesheet( $enqueue_styles ){
		return array();
	}

	public function ajax_add_to_cart(){
		ob_start();
			get_template_part( 'woocommerce/theme/cart-icon' );
			$fragments['.shoppingcart'] = ob_get_clean();
		ob_start();
			get_template_part( 'woocommerce/theme/cart-canvas' );
			$fragments['#is_cart_canvas .cart_container'] = ob_get_clean();
		return $fragments;
	}

	public function ajax_remove_product_in_cart(){
		$cart = WC()->instance()->cart;
		$key = $_POST['product_key'];
		
	   	$cart->set_quantity( $key, 0 );

		$output = array();
		$output['subtotal'] = $cart->get_cart_subtotal();
		$output['count'] = $cart->cart_contents_count;
		print_r( json_encode( $output ) );
	    exit();
	}

	/*
	 * Add Cart canvas
	 */
	public function add_cart_canvas(){
		echo '<div id="is_cart_canvas" class="uk-offcanvas">';
	        get_template_part( 'woocommerce/theme/cart-canvas' );
	    echo '</div>';
	}

	public function effect_image_hover(){
		global $post, $product, $woocommerce;
		$placeholder_width = get_option('shop_catalog_image_size');
		$placeholder_width = $placeholder_width['width'];
		
		$placeholder_height = get_option('shop_catalog_image_size');
		$placeholder_height = $placeholder_height['height'];
		
		$output='<div class="product-image"><div class="image">';
		if( has_post_thumbnail() ){
			$attachment_ids = $product->get_gallery_attachment_ids();
			$output.=get_the_post_thumbnail( $post->ID,'shop_catalog',array('class'=> ($attachment_ids) ? 'image-hover' : 'image-effect-none' ) );
			if($attachment_ids) {
				$output.=wp_get_attachment_image($attachment_ids[0],'shop_catalog',false,array('class'=>"attachment-shop_catalog image-effect"));
			}
			
		}else{
			$output .= '<img src="' . esc_html( $this->placeholder_img_src() ) . '" alt="' . esc_html__('Placeholder' , 'zidane').'" class="image-placeholder" width="'.esc_attr($placeholder_width).'" height="'.esc_attr($placeholder_height).'" />';
		}
		$output .= '</div></div>';

		echo wp_kses_post( $output );
	}

	protected function placeholder_img_src(){
		return get_template_directory_uri() . '/images/product-default.png';
	}

	public function effect_hover_skin($classes){
		$classes[] = $this->is_function->get_option( 'woo_effect_skin', 'we-fade' );
		return $classes;
	}

	public function cart_effect_fly( $classes ){
		if( $this->is_function->get_option( 'woo_cart_fly', false ) ){
			$classes[] = 'cart-fly';
		}
		return $classes;
	}

	public function get_query_args( $type, $post_per_page=-1, $cat='' ){
		global $woocommerce;
	    remove_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_popularity_post_clauses' ) );
		remove_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
	    $args = array(
	        'post_type' => 'product',
	        'posts_per_page' => $post_per_page,
	        'post_status' => 'publish'
	    );
	    switch ($type) {
	        case 'best_selling':
	            $args['meta_key']='total_sales';
	            $args['orderby']='meta_value_num';
	            $args['ignore_sticky_posts']   = 1;
	            $args['meta_query'] = array();
	            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
	            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
	            break;
	        case 'featured_product':
	            $args['ignore_sticky_posts']=1;
	            $args['meta_query'] = array();
	            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
	            $args['meta_query'][] = array(
	                         'key' => '_featured',
	                         'value' => 'yes'
	                     );
	            $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
	            break;
	        case 'top_rate':
	            add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
	            $args['meta_query'] = array();
	            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
	            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
	            break;
	        case 'recent_product':
	            $args['meta_query'] = array();
	            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
	            break;
	        case 'on_sale':
	            $args['meta_query'] = array();
	            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
	            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
	            $args['post__in'] = wc_get_product_ids_on_sale();
	            break;
	        case 'recent_review':
	            if($number == -1) $_limit = 4;
	            else $_limit = $number;
	            global $wpdb;
	            $query = "SELECT c.comment_post_ID FROM {$wpdb->prefix}posts p, {$wpdb->prefix}comments c WHERE p.ID = c.comment_post_ID AND c.comment_approved > 0 AND p.post_type = 'product' AND p.post_status = 'publish' AND p.comment_count > 0 ORDER BY c.comment_date ASC LIMIT 0, ". $_limit;
	            $results = $wpdb->get_results($query, OBJECT);
	            $_pids = array();
	            foreach ($results as $re) {
	                $_pids[] = $re->comment_post_ID;
	            }

	            $args['meta_query'] = array();
	            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
	            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
	            $args['post__in'] = $_pids;
	            break;
	        case 'deals':
	            $args['meta_query'] = array();
	            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
	            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
	            $args['meta_query'][] = array(
	                                 'key' => '_sale_price_dates_to',
	                                 'value' => '0',
	                                 'compare' => '>');
	            $args['post__in'] = wc_get_product_ids_on_sale();
	            break;
	    }

	    if( $cat!='all'  ){
	        $args['product_cat']= $cat;
	    }
	    return $args;
	}

	public function get_list_categories( $default = true ){
		$args       = array(
			'type'         => 'post',
			'child_of'     => 0,
			'parent'       => '',
			'orderby'      => 'id',
			'order'        => 'ASC',
			'hide_empty'   => false,
			'hierarchical' => 1,
			'exclude'      => '',
			'include'      => '',
			'number'       => '',
			'taxonomy'     => 'product_cat',
			'pad_counts'   => false,

		);
		$categories = get_categories( $args );
		if( $default ){
			$product_categories_dropdown = array( 'All' => 'all' );
		}else{
			$product_categories_dropdown = array();
		}
		$this->get_category_childs_full( 0, 0, $categories, 0, $product_categories_dropdown );
		return $product_categories_dropdown;
	}

	private function get_category_childs_full( $parent_id, $pos, $array, $level, &$dropdown ) {

		for ( $i = $pos; $i < count( $array ); $i ++ ) {
			if ( $array[ $i ]->category_parent == $parent_id ) {
				$name       = str_repeat( "- ", $level ) . $array[ $i ]->name;
				$value      = $array[ $i ]->slug;
				$dropdown[] = array( 'label' => $name, 'value' => $value );
				$this->get_category_childs_full( $array[ $i ]->term_id, $i, $array, $level + 1, $dropdown );
			}
		}
		
	}

}