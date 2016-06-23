<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<div class="input-group">
		
		<?php if( zidane_framework()->is_request( 'woocommerce' ) ): ?>
			<div class="input-group-btn is-woo-categories-dropdown">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="title">All</span> <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<?php
						$list_categories 	= Inspius_Woocommerce::instance()->get_list_categories(false);
						$cat 				= get_query_var( 'product_cat', '' );
						$selected 			= ( $cat == '' ) ? ' class="active"' : '';
						echo '<li' . $selected . '><a data-value="" href="#">All</a></li>';
						foreach ($list_categories as $value) {
							$selected 			= ( $cat == $value['value'] ) ? ' class="active"' : '';
							echo '<li' . $selected . '><a data-value="' . $value['value'] . '" href="#">' . $value['label'] . '</a></li>';
						}
					?>
				</ul>
				<input type="hidden" name="product_cat" value="" class="product_cat">
				<input type="hidden" name="post_type" value="product" />
			</div><!-- /btn-group -->
		<?php endif; ?>

		<input type="search" class="form-control" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" placeholder="<?php echo esc_html__( 'Search', 'zidane' ); ?>...">
		<div class="input-group-btn">
			<button class="btn btn-primary"><i class="icon-magnifier"></i><span class="text"><?php echo esc_html__( 'Search', 'zidane' ); ?></span></button>
		</div>
	</div><!-- /input-group -->
</form>