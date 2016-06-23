<div class="product-block product product-list">
  <div class="product-list-inner clearfix">
  	<div class="list-thumb pull-left">
          <a href="<?php the_permalink(); ?>">
              <?php
                  /**
                  * woocommerce_before_shop_loop_item_title hook
                  *
                  * @hooked woocommerce_show_product_loop_sale_flash - 10
                  * @hooked woocommerce_template_loop_product_thumbnail - 10
                  */
                  do_action( 'woocommerce_before_shop_loop_item_title' );
              ?>
          </a>
  	</div>
  	<div class="product-meta">
  		<h4 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
          <?php do_action('woocommerce_after_shop_loop_item'); ?>
  	</div>
  </div>
</div>