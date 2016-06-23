<?php

class Inspius_Functions{

	public static $_instance;

	/**
	 * Main Inspius_Framework Instance
	 *
	 * Ensures only one instance of Inspius_Framework is loaded or can be loaded.
	 *
	 * @static
	 * @see inspius_framework()
	 * @return Inspius_Framework - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function the_breadcrumb() {
		if( is_page() || is_single() ){
			global $wp_query;
			$page_id = $wp_query->get_queried_object_id();
			if( $this->get_post_meta( $page_id, '_is_page_is_breadcrumb', true ) === 'no' ){
				return false;
			}
		}
		$args =array(
			'home'        => _x( 'Trang chủ', 'breadcrumb', 'zidane' )
		);

		$breadcrumbs = new Inspius_Breadcrumb();

		if ( $args['home'] ) {
			$breadcrumbs->add_crumb( $args['home'], home_url() );
		}

		$args['breadcrumb'] = $breadcrumbs->generate();

		extract( $args );

		include_once( INSPIUS_PATH_URL . '/templates/global/breadcrumb.php' );
	}

	public function get_post_meta( $id, $key, $default ){
		$value = get_post_meta( $id, $key, true );
		if( $value == '' ){
			$value = $default;
		}
		return $value;
	}
	
	/**
	 * What type of request is this?
	 * string $type ajax, frontend or admin
	 * @return bool
	 */
	public function is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
			case 'ajax' :
				return defined( 'DOING_AJAX' );
			case 'cron' :
				return defined( 'DOING_CRON' );
			case 'frontend' :
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
			case 'redux':
				return in_array( 'redux-framework/redux-framework.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
				// return is_plugin_active( '' );
			case 'woocommerce':
				return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
			case 'visual-composer':
				return in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
			case 'metabox':
				return in_array( 'cmb2/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
			case 'customize':
				return is_file( INSPIUS_PATH_URL . '/customize.xml' );
			case 'wpml-woocommerce':
				return in_array( 'woocommerce-multilingual/wpml-woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
			case 'wpml':
				return in_array( 'sitepress-multilingual-cms/sitepress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
			case 'wpml_woo':
				return in_array( 'woocommerce-multilingual/wpml-woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
			case 'mailchimp':
				return in_array( 'mailchimp-for-wp/mailchimp-for-wp.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
			case 'newsletter':
				return in_array( 'wysija-newsletters/index.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
			case 'zoom_magnifier':
				return in_array( 'yith-woocommerce-zoom-magnifier/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
			case 'wishlist':
				return in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
			case 'revslider':
				return in_array( 'revslider/revslider.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
		}
	}


	public function the_post_thumbnail(){
	    global $post;
	    $postid 	= $post->ID;
	    $link_embed = get_post_meta( $postid, 		'_is_post_video', 	true );
	    $gallery 	= get_post_meta( $postid,   	'_is_post_gallery', true );
	    
	    $is_thumb 	= false;
	    $content 	= $output = $start = $end = '';
	    
	    if( has_post_format( 'video' ) && $link_embed!='' ){
	        $content 	='<div class="video-responsive">' . wp_oembed_get($link_embed) . '</div>';
	        $is_thumb 	= true;
	    }else if ( has_post_format( 'audio' ) ){
	        $content 	='<div class="audio-responsive">' . wp_oembed_get($link_embed) . '</div>';
	        $is_thumb 	= true;
	    }else if ( has_post_format( 'gallery' ) && $gallery != '' ){
	        $count = 0;
	        $content 	=  '<div id="post-slide-'. esc_attr( $postid ) .'" class="carousel slide" data-ride="carousel">
	                        <div class="carousel-inner">';
	        foreach ($gallery as $key => $id){
	            $img_src  = wp_get_attachment_image_src($key, apply_filters( 'is_gallery_image_size','full' ));
	            $content .='<div class="item '.(($count==0) ? 'active' : '' ).'">
	                        <img src="'. esc_url( $img_src[0] ) .'" alt="' . esc_attr( $post->post_title ) . '">
	                    </div>';
	            $count++;
	        }
	        $content 	.='</div>
				            <a class="left carousel-control" href="#post-slide-' 	. esc_attr( $postid ) . '" data-slide="prev"><i class="icon-logout"></i></a>
				            <a class="right carousel-control" href="#post-slide-'	. esc_attr( $postid ) . '" data-slide="next"><i class="icon-login"></i></a>
				        </div>';
	        $is_thumb = true;
	    }else if( has_post_thumbnail() ){
	        $content 	= get_the_post_thumbnail( $postid, apply_filters( '_single_image_size', 'full' ) );
	        $is_thumb 	= true;
	    }

	    if( $is_thumb ){
	        $start 	= '<div class="post-thumb">';
	        $end 	= '</div>';
	    }

	    $output = $start . $content . $end;

	    echo $output;
	}

	public function the_sharebox(){
		get_template_part( 'templates/global/share' );
	}	

	public function get_theme_version(){
		$my_theme = wp_get_theme();
		return $my_theme->get( 'Version' );
	}

	public function add_google_font( $font_families, $subset = 'latin-ext' ){
		$query_args = array(
	        'family' => urlencode( implode( '|', $font_families ) ),
	        'subset' => urlencode( $subset ),
	    );

		$fonts_url = esc_url_raw(add_query_arg( $query_args, '//fonts.googleapis.com/css' ));

    	wp_enqueue_style( 'theme-fonts', $fonts_url );
	}

	/**
	 * Get Options
	 *
	 * Get option value in Redux Framework.
	 */
	public function get_option( $id, $default='' ){
		global $theme_option;
		if( is_array( $id ) ){
			if( isset( $theme_option[ $id[0] ] ) && isset( $theme_option[ $id[0] ][ $id[1] ] ) && $theme_option[ $id[0] ][ $id[1] ]!='' ){
				return $theme_option[$id[0]][$id[1]];
			}
		}else{
			if( isset( $theme_option[ $id ] ) )
				return $theme_option[ $id ];
		}
		return $default;
	}

	/**
	 * Get Metabox
	 *
	 * Get metabox value in Cmb2.
	 */
	public function get_metabox( $id, $default='' ){
		global $post;
		$meta = '';
		$meta = get_post_meta( $post->ID, $id, true ); 
		if( $meta ){
			return $meta;
		}else{
			return $default;
		}
	}

	/**
	 * Make id
	 *
	 * initialization random string
	 */
	public function get_make_id($length = 5){
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}

	/**
	 * Comment Form
	 *
	 * initialization comment form
	 */
	public function the_comment_form($arg,$class='btn-primary',$id='submit'){
		ob_start();
		comment_form($arg);
		$form = ob_get_clean();
		echo str_replace('id="submit"','id="'.$id.'" class="btn '.$class.'"', $form);
	}

	/**
	 * 
	 */
	 public function get_string_limit_words($string, $word_limit){
	    $words = explode(' ', $string, ($word_limit + 1));

	    if(count($words) > $word_limit) {
	        array_pop($words);
	    }

	    return implode(' ', $words);
	}

	/**
	 * 
	 * Function setup <head> tag
	 * 
	 */
	public function the_head(){
	?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php 
		    if( ! function_exists( 'has_site_icon' ) || ! has_site_icon() || zidane_framework()->get_option( array('general_favicon','url') ) != '' ){
		       echo '<link rel="shortcut icon" href="'.esc_url( zidane_framework()->get_option( array('general_favicon','url') ) ).'" type="image/x-icon">';
		    }
		?>
		<?php if( zidane_framework()->get_option( array('general_apple','url') ) != '' ):?>
		<link rel="apple-touch-icon" href="<?php echo esc_url( zidane_framework()->get_option( array('general_apple','url') ) ); ?>" />
		<?php endif;?>

		<?php if( zidane_framework()->get_option( array('general_apple','url') ) != '' ):?>
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo esc_url( zidane_framework()->get_option( array('general_apple','url') ) ); ?>" />
		<?php endif;?>

		<?php if( zidane_framework()->get_option( array('general_apple_72','url') ) != '' ):?>
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url( zidane_framework()->get_option( array('general_apple_72','url') ) ); ?>" />
		<?php endif;?>

		<?php if( zidane_framework()->get_option( array('general_apple_114','url') ) != '' ):?>
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url( zidane_framework()->get_option( array('general_apple_114','url') ) ); ?>" />
		<?php endif;?>

		<?php if( zidane_framework()->get_option( array('general_apple_144','url') ) != '' ):?>
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo esc_url( zidane_framework()->get_option( array('general_apple_144','url') ) ); ?>" />
		<?php endif;?>
		<!--[if lt IE 9]>
		<script src="<?php echo INSPIUS_PATH_URI; ?>/js/html5.js"></script>
		<script src="<?php echo INSPIUS_PATH_URI; ?>/js/respond.js"></script>
		<![endif]-->
		<?php
	}


	/**
	 * Pagination
	 *
	 */
	public function the_pagination( $prev = 'Prev', $next = 'Next', $pages='' ,$args=array( 'class'=>'' ) ){
		global $wp_query, $wp_rewrite;
	    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
	    if($pages==''){
	        global $wp_query;
	         $pages = $wp_query->max_num_pages;
	         if(!$pages)
	         {
	             $pages = 1;
	         }
	    }

	    $pagination = array(
	        'base' 		=> @add_query_arg('paged','%#%'),
	        'format' 	=> '',
	        'total' 	=> $pages,
	        'current' 	=> $current,
	        'prev_text' => $prev,
	        'next_text' => $next,
	        'type' 		=> 'array'
	    );


	    if( $wp_rewrite->using_permalinks() )
	        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

	    if( !empty($wp_query->query_vars['s']) ){
	        $pagination['add_args'] = array( 's' => get_query_var( 's' ) );
	    }
	    
	    if(paginate_links( $pagination )!=''){
	        $paginations = paginate_links( $pagination );
	        echo '<div class="is-paging-footer clearfix"><nav class="paging">';
	        echo '<ul class="pagination '.$args["class"].'">';
	            foreach ($paginations as $key => $pg) {
	                echo '<li>'.$pg.'</li>';
	            }
	        echo '</ul>';
	        echo '</nav></div>';
	    }
	}

	public function get_list_category() {
			
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
			'taxonomy'     => 'category',
			'pad_counts'   => false,

		);
		$categories = get_categories( $args );

		$categories_dropdown = array( 'All' => 'all' );
		$this->set_category_childs_full( 0, 0, $categories, 0, $categories_dropdown );

		return $categories_dropdown;
	}

	private function set_category_childs_full( $parent_id, $pos, $array, $level, &$dropdown ) {

		for ( $i = $pos; $i < count( $array ); $i ++ ) {
			if ( $array[ $i ]->category_parent == $parent_id ) {
				$name       = str_repeat( "- ", $level ) . $array[ $i ]->name;
				$value      = $array[ $i ]->slug;
				$dropdown[] = array( 'label' => $name, 'value' => $value );
				$this->set_category_childs_full( $array[ $i ]->term_id, $i, $array, $level + 1, $dropdown );
			}
		}

	}


	/**
	 * 
	 * Render Megamenu
	 * 
	 */
	public function the_megamenu( $config = array() ){
		

		$config['animation'] 	= $this->get_option('megamenu-animation','effect-none');
		$config['duration'] 	= $this->get_option('megamenu-duration','400');

		$menu_locations 		= get_nav_menu_locations();
		if( !isset( $menu_locations[$config['theme_location']] ) ){
			return;
		}else{
			$menu_id 			= $menu_locations[$config['theme_location']];
		}

	    $menu_build 			= new Megamenu_Buider_Front( $menu_id );
		$menu_build_options 	= array('settings'=>json_decode( get_option( 'IS_MEGAMENU_DATA_' . $menu_id ), true ), 'params' => $config );
	    
	    echo $menu_build->output( $menu_build_options );

	}
	
	/**
	 * 
	 * Render Sidebar
	 * 
	 */
	public function the_sidebar(){ ?>
		<?php $sidebar = apply_filters( 'is_sidebar_area', '' ); ?>
	    <?php if(apply_filters( 'is_check_sidebar_left' , false )){ ?>
	        <div class="is-sidebar sidebar-left <?php echo apply_filters( 'is_sidebar_left_class', 'col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-9' ); ?>">	            
	            <?php if(is_active_sidebar($sidebar)): ?>
	                <div class="sidebar-inner">
	                    <?php dynamic_sidebar($sidebar); ?>
	                </div>
	            <?php endif; ?>
	        </div>
	    <?php } ?>

	    <?php if(apply_filters( 'is_check_sidebar_right' , false )){ ?>
	        <div class="is-sidebar sidebar-right <?php echo apply_filters( 'is_sidebar_right_class', 'col-sm-4 col-md-3' ); ?>">            
	            <?php if(is_active_sidebar($sidebar)): ?>
	                <div class="sidebar-inner">
	                    <?php dynamic_sidebar($sidebar); ?>
	                </div>
	            <?php endif; ?>
	        </div>
	    <?php } 
	}


	/**
	 * Get Logo
	 */
	public function the_logo(){
		$logo_url = $this->get_option( array( 'general_logo', 'url' ), INSPIUS_PATH_URI . '/images/logo.png' );
	?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
	        <img class="main-logo" src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>">
	        <img class="sticky-logo" src="<?php echo esc_url( $this->get_option( array( 'general_logo_menu_sticky', 'url' ), $logo_url ) ); ?>" alt="<?php bloginfo( 'name' ); ?>">
	    </a>
	<?php
	}

}

// Inspius_Functions::instance();