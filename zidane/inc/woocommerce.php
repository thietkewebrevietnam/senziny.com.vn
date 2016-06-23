<?php

class Inspius_Woocommerce extends Inspius_Woocommerce_Base{

	protected static $_instance;

	/**
	 * Main Inspius_Woocommerce Instance
	 *
	 * Ensures only one instance of Inspius_Woocommerce is loaded or can be loaded.
	 *
	 * @static
	 * @return Inspius_Woocommerce - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct(){
		parent::__construct();

		add_action( 'init', array( $this, 'init_action_woocommerce' ) );
	}

	public function init_action_woocommerce(){
		$this->action_layout();
		$this->action_single_product();
		$this->action_archive_product();
		$this->action_cart_layout();
		$this->action_my_account();
		if( $this->check_skin_template() ){
			$this->action_content_product_fashion();
		}else{
			$this->action_content_product_cigarette();
		}
	}

	private function check_skin_template(){
		$func = Inspius_Functions::instance();
		$skin = $func->get_option( 'styling_skin', 'cigarette' );
		if (strpos($skin, 'fashion') !== false) {
		    return true;
		}
		return false;
	}

	private function action_layout(){
		// Remove Breadcrumb default
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	}

	private function action_archive_product(){
		add_action( 'woocommerce_before_shop_loop', create_function('', 'echo "<div class=\"catalog-ordering clearfix\">";'), 1 );
		add_action( 'woocommerce_before_shop_loop', create_function('', 'echo "</div>";'), 10000 );
		
		//Sidebar default
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );

		//Switch Layout
		add_action( 'woocommerce_before_shop_loop', array( $this, 'switch_layout' ), 20 );

		//Footer pagination
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );
	}


	public function switch_layout(){
		$action = 'grid';
		if( isset($_GET['layout']) ){
			$action = $_GET['layout'];
		}
	?>
		<form method="get" class="form-switch-layout">
			<ul class="switch-layout pull-left list-unstyled">
		        <li>
		        	<a style="position:relative;" data-action="grid" <?php echo ($action=='grid') ? 'class="active"':''; ?> href="#">
		    			<i class="icon-grid"></i>
		    		</a>
		    	</li>
		        <li>
		        	<a style="position:relative;" data-action="list" <?php echo ($action=='list') ? 'class="active"':''; ?> href="#">
		        		<i class="icon-list"></i>
		        	</a>
		        </li>
		    </ul>
		    <input type="hidden" name="layout" value="<?php echo esc_attr($action); ?>">
		    <?php
				// Keep query string vars intact
				foreach ( $_GET as $key => $val ) {
					if ( 'layout' === $key || 'submit' === $key ) {
						continue;
					}
					if ( is_array( $val ) ) {
						foreach( $val as $innerVal ) {
							echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
						}
					
					} else {
						echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
					}
				}
			?>
	    </form>
	<?php
	}

	private function action_cart_layout(){
		remove_action( 'woocommerce_cart_collaterals', 			'woocommerce_cart_totals', 10 );
	}

	private function action_single_product(){
		add_action( 'woocommerce_share', 						array( $this->is_function, 'the_sharebox' ) );
	}

	private function action_content_product_cigarette(){
		if( isset( $_GET['layout'] ) && $_GET['layout'] == 'list' ){
			add_action( 'woocommerce_after_shop_loop_item', 		'woocommerce_template_single_excerpt' );
			add_action( 'woocommerce_after_shop_loop_item', 		'woocommerce_template_loop_rating', 5 );
			add_action( 'woocommerce_after_shop_loop_item', 		array( $this, 'action_group_cart' ) );
			
		}else{
			add_action( 'woocommerce_after_shop_loop_item', 		array( $this, 'action_group_cart' ) );
			add_action( 'is_woocommerce_after_group_cart', 			'woocommerce_template_loop_rating' );
		}
		remove_action( 'woocommerce_after_shop_loop_item', 		 'woocommerce_template_loop_add_to_cart' );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	}

	private function action_content_product_fashion(){
		if( isset( $_GET['layout'] ) && $_GET['layout'] == 'list' ){
			add_action( 'woocommerce_after_shop_loop_item', 		'woocommerce_template_single_excerpt' );
			add_action( 'woocommerce_after_shop_loop_item', 		'woocommerce_template_loop_rating', 5 );
			add_action( 'woocommerce_after_shop_loop_item', 		array( $this, 'action_group_cart' ) );
			
		}else{
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 5 );
			add_action( 'woocommerce_before_shop_loop_item_title', 	'woocommerce_template_loop_product_link_close', 30 );
			add_action( 'woocommerce_before_shop_loop_item_title', 	array( $this, 'action_group_cart' ), 35 );

			add_action( 'woocommerce_shop_loop_item_title', 	'woocommerce_template_loop_product_link_open', 5 );
			// add_action( 'is_woocommerce_after_group_cart', 			'woocommerce_template_loop_rating' );
		}
		remove_action( 'woocommerce_after_shop_loop_item', 		 'woocommerce_template_loop_add_to_cart' );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	}

	private function action_my_account(){
		add_action( 'woocommerce_before_my_account', 			array( $this, 'before_my_account' ) );
		add_action( 'woocommerce_after_my_account', 			array( $this, 'after_my_account' ) );

		// Login Form
		if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'no' ){
			add_action( 'woocommerce_before_customer_login_form', 	array( $this, 'before_customer_login_form' ) );
			add_action( 'woocommerce_after_customer_login_form', 	array( $this, 'after_customer_login_form' ) );
		}

	}

	public function before_customer_login_form(){
		echo '<div class="is-login-form">';
	}

	public function after_customer_login_form(){
		echo '</div>';
	}

	public function before_my_account( $order_count, $edit_address=false ){
		?>
		<div class="row is-my-account">
			<div class="col-sm-3">
				<div class="list-group my-account-group">
					<?php if( $downloads = WC()->customer->get_downloadable_products() ) : ?>
						<a href="#my-download" class="active list-group-item" data-toggle="tab">
							<?php esc_html_e('View Downloads' , 'zidane' ); ?>
						</a>
					<?php endif; ?>
					
					<?php 
						if( function_exists( 'wc_get_order_types' ) && function_exists( 'wc_get_order_statuses' ) ) {
							$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
								'numberposts' 	=> $order_count,
								'meta_key'    	=> '_customer_user',
								'meta_value'  	=> get_current_user_id(),
								'post_type'   	=> wc_get_order_types( 'view-orders' ),
								'post_status' 	=> array_keys( wc_get_order_statuses() )
							) ) );
						} else {
							$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
								'numberposts' 	=> $order_count,
								'meta_key'		=> '_customer_user',
								'meta_value'  	=> get_current_user_id(),
								'post_type'   	=> 'shop_order',
								'post_status' 	=> 'publish'
							) ) );
						}
						if ( $customer_orders ) : ?>
							<a href="#my-orders" data-toggle="tab" class="list-group-item orders <?php if( ! $edit_address && ! WC()->customer->get_downloadable_products() ) { echo 'active'; } ?>">
								<?php esc_html_e('View Orders' , 'zidane' ); ?>
							</a>
						<?php endif; ?>

						<a href="#my-address" data-toggle="tab" class="list-group-item address <?php if( $edit_address || ! WC()->customer->get_downloadable_products() && ! $customer_orders ) { echo 'active'; } ?>">
							<?php esc_html_e('Change Address' , 'zidane' ); ?>
						</a>
						<a href="#edit-my-account" class="list-group-item account" data-toggle="tab">
							<?php esc_html_e('Edit Account' , 'zidane' ); ?>
						</a>
				</div>
			</div>
			<div class="col-sm-9">
				<div class="tab-content">
		<?php
	}

	public function after_my_account(){
		global $woocommerce, $wp;

		$user = wp_get_current_user();

		?>
					<div id="edit-my-account" class="tab-pane">
						<h2 class="edit-account-heading"><?php esc_html_e( 'Edit Account', 'zidane' ); ?></h2>

						<form class="edit-account-form clearfix" action="" method="post">
							<p class="form-row form-row-first">
								<label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
								<input type="text" class="input-text" name="account_first_name" id="account_first_name" value="<?php esc_attr( $user->first_name ); ?>" />
							</p>
							<p class="form-row form-row-last">
								<label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
								<input type="text" class="input-text" name="account_last_name" id="account_last_name" value="<?php esc_attr( $user->last_name ); ?>" />
							</p>
							<p class="form-row form-row-wide">
								<label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
								<input type="email" class="input-text" name="account_email" id="account_email" value="<?php esc_attr( $user->user_email ); ?>" />
							</p>
							<p class="form-row form-row-thirds">
								<label for="password_current"><?php esc_html_e( 'Current Password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
								<input type="password" class="input-text" name="password_current" id="password_current" />
							</p>
							<p class="form-row form-row-thirds">
								<label for="password_1"><?php esc_html_e( 'New Password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
								<input type="password" class="input-text" name="password_1" id="password_1" />
							</p>
							<p class="form-row form-row-thirds">
								<label for="password_2"><?php esc_html_e( 'Confirm New Password', 'woocommerce' ); ?></label>
								<input type="password" class="input-text" name="password_2" id="password_2" />
							</p>
							<div class="clear"></div>

							<p><input type="submit" class="fusion-button button-default button-medium button default medium alignright" name="save_account_details" value="<?php esc_html_e( 'Save changes', 'woocommerce' ); ?>" /></p>

							<?php wp_nonce_field( 'save_account_details' ); ?>
							<input type="hidden" name="action" value="save_account_details" />
							<div class="clearboth"></div>
						</form>
					</div>
					
				</div>
			</div>
		</div>
		<?php
	}

	public function action_group_cart(){
	?>
		<div class="action-group">
			<div class="button-group">
				<?php
					// Add to cart button 
					woocommerce_template_loop_add_to_cart(); 

					// Wishlist Button
					$this->the_wishlist_button();

					// Quick view button
					$this->the_quickview_button();

				?>
			</div>

			<?php do_action( 'is_woocommerce_after_group_cart' ); ?>
		</div>
	<?php
	}

	private function the_quickview_button(){
		global $product;
		$attrs_html = array(
			'class="button quickview"',
			'href="#"',
			// 'data-toggle="tooltip"',
			'title="' 		. esc_html__('Quickview','zidane') . '"',
			'data-proid="' 	. esc_attr( $product->id ) 	. '"',
		);
	?>
		<a <?php echo implode( ' ', $attrs_html ); ?>>
			<i class="icon-magnifier"></i>
		</a>
	<?php
	}

	private function the_wishlist_button(){
		if( $this->is_function->is_request( 'wishlist' ) ){
			global $product;
			$default_wishlists = is_user_logged_in() ? YITH_WCWL()->get_wishlists( array( 'is_default' => true ) ) : false;

			if( ! empty( $default_wishlists ) ){
				$default_wishlist = $default_wishlists[0]['ID'];
			}
			else{
				$default_wishlist = false;
			}

			$url_data 	= YITH_WCWL()->get_wishlist_url();
			$exists 	= YITH_WCWL()->is_product_in_wishlist( $product->id, $default_wishlist );
			if( $exists ){
				$url 	= $url_data;
				$class 	= ' added';
			}else{
				$url 	= '#';
				$class 	= '';
			}

			$attrs_html = array(
				'class="button is-whishlist'. esc_attr( $class ) .'"',
				// 'data-toggle="tooltip"',
				'href="' 				. esc_url( $url ) 	. '"',
				'title="' 				. esc_html__('Wishlist','zidane') 				. '"',
				'data-product-id="' 	. esc_attr( $product->id ) 				. '"',
				'data-product-type="' 	. esc_attr( $product->product_type ) 	. '"',
				'data-url="' 			. esc_url( $url_data ) 					. '"'
			);
			?>
				<a <?php echo implode( ' ', $attrs_html ); ?>>
					<i class="icon-heart"></i>
				</a>
			<?php
		}
	}

	protected function get_label_countdown(){
		return array(
	    	'years' 	=> esc_html__('Years'	,'zidane'),
	    	'months' 	=> esc_html__('Months'	,'zidane'),
	    	'weeks' 	=> esc_html__('Weeks'	,'zidane'),
	    	'days' 		=> esc_html__('Days'	,'zidane'),
	    	'hours' 	=> esc_html__('Hrs'		,'zidane'),
	    	'minutes' 	=> esc_html__('Mins'	,'zidane'),
	    	'seconds' 	=> esc_html__('Secs'	,'zidane'),
	    	'year' 		=> esc_html__('Year'	,'zidane'),
	    	'month' 	=> esc_html__('Month'	,'zidane'),
	    	'week' 		=> esc_html__('Week'	,'zidane'),
	    	'day' 		=> esc_html__('Day'		,'zidane'),
	    	'hour' 		=> esc_html__('Hr'		,'zidane'),
	    	'minute' 	=> esc_html__('Min'		,'zidane'),
	    	'second' 	=> esc_html__('Sec'		,'zidane'),
	    );
	}

	public function product_dropdown_categories( $args = array(), $deprecated_hierarchical = 1, $deprecated_show_uncategorized = 1, $deprecated_orderby = '' ) {
		global $wp_query;

		if ( ! is_array( $args ) ) {
			_deprecated_argument( 'wc_product_dropdown_categories()', '2.1', 'show_counts, hierarchical, show_uncategorized and orderby arguments are invalid - pass a single array of values instead.' );

			$args['show_count']         = $args;
			$args['hierarchical']       = $deprecated_hierarchical;
			$args['show_uncategorized'] = $deprecated_show_uncategorized;
			$args['orderby']            = $deprecated_orderby;
		}

		$current_product_cat = isset( $wp_query->query['product_cat'] ) ? $wp_query->query['product_cat'] : '';
		$defaults            = array(
			'pad_counts'         => 1,
			'show_count'         => 1,
			'hierarchical'       => 1,
			'hide_empty'         => 1,
			'show_uncategorized' => 1,
			'orderby'            => 'name',
			'selected'           => $current_product_cat,
			'menu_order'         => false
		);

		$args = wp_parse_args( $args, $defaults );

		if ( $args['orderby'] == 'order' ) {
			$args['menu_order'] = 'asc';
			$args['orderby']    = 'name';
		}

		$terms = get_terms( 'product_cat', apply_filters( 'wc_product_dropdown_categories_get_terms_args', $args ) );

		if ( ! $terms ) {
			return;
		}

		$output  = "<select name='product_cat' class='is_dropdown_product_cat'>";
		$output .= '<option value="" ' .  selected( $current_product_cat, '', false ) . '>' . esc_html__( 'Select a category', 'woocommerce' ) . '</option>';
		$output .= wc_walk_category_dropdown_tree( $terms, 0, $args );
		if ( $args['show_uncategorized'] ) {
			$output .= '<option value="0" ' . selected( $current_product_cat, '0', false ) . '>' . esc_html__( 'Uncategorized', 'woocommerce' ) . '</option>';
		}
		$output .= "</select>";

		echo $output;
	}

	public function setup_column_cross_sells( $columns ){
		global $woocommerce_loop;
		$woocommerce_loop['columns'] = apply_filters( 'woocommerce_cross_sells_columns', $columns );
	}

	public function setup_column_relate_product( $columns ){
		global $woocommerce_loop;
		$woocommerce_loop['columns'] = $columns;
	}

	public function setup_column_up_sells_product( $columns ){
		global $woocommerce_loop;
		$woocommerce_loop['columns'] = $columns;
	}

	public function setup_product_cat_config(){
		global $woocommerce_loop;

		// Store loop count we're currently on.
		if ( empty( $woocommerce_loop['loop'] ) ) {
			$woocommerce_loop['loop'] = 0;
		}

		// Store column count for displaying the grid.
		if ( empty( $woocommerce_loop['columns'] ) ) {
			$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
		}

		// Increase loop count.
		$woocommerce_loop['loop']++;
	}

	public function get_archive_config(){
		global $product, $woocommerce_loop;

		$action = 'grid';
		if( isset($_GET['layout']) ){
			$action = $_GET['layout'];
		}

		// Store loop count we're currently on
		if ( empty( $woocommerce_loop['loop'] ) ) {
			$woocommerce_loop['loop'] = 0;
		}

		// Store column count for displaying the grid
		if ( empty( $woocommerce_loop['columns'] ) ) {
			$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
		}

		// Ensure visibility
		if ( ! $product || ! $product->is_visible() ) {
			return;
		}

		// Increase loop count
		$woocommerce_loop['loop']++;

		// Extra post classes
		$classes = array();
		if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] ) {
			$classes[] = 'first';
		}
		if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
			$classes[] = 'last';
		}

		if($action == 'list'){
			$classes[] ='col-sm-12 product-col';
			$layout= 'list';
		}
		else{
			$classes = apply_filters( 'is_woocommerce_column_class' , $classes );
			$layout = 'grid';
		}
		return array(
				'layout' 	=> $layout,
				'classes'	=> $classes,
			);
	}

}

Inspius_Woocommerce::instance();


