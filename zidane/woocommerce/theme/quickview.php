<?php
    $product = wc_get_product();
    $post_id = get_the_id();
    $attachment_ids = $product->get_gallery_attachment_ids();
    $images_thumb =array();
    $is_count = count( $attachment_ids );
    if( has_post_thumbnail() ){
        $image = get_the_post_thumbnail( $post_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ));
        $images_thumb[] = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'shop_single' );
    }else{
        $image = '<img src="'.wc_placeholder_img_src().'"/>';
    }
    if( $is_count > 0 ){
        foreach ( $attachment_ids as $attachment_id ) {
            $images_thumb[]       = wp_get_attachment_image_src( $attachment_id, 'shop_single' );
        }
    }
        
?> 
<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class('product'); ?>>
	<div id="quickview" class="row woocommerce">
		<div class="col-sm-6 images">
            <div class="image-thumb">
                <?php echo wp_kses_post( $image ); ?>
            </div>
            <div class="quickview-slides row owl-theme owl-carousel" itemprop="image">
                <?php foreach ($images_thumb as $key => $value) {
                    echo '<div class="item' . (( $key==0 )? ' active': '') . '"><img data-src="' . esc_url( $value[0] ) . '" src="'. esc_url( $value[0] ) .'"></div>';
                } ?>
            </div>
        </div>
        <div class="col-sm-6 content">
            <div class="summary entry-summary">
                <?php
                    /**
                     * woocommerce_single_product_summary hook
                     *
                     * @hooked woocommerce_template_single_title - 5
                     * @hooked woocommerce_template_single_rating - 10
                     * @hooked woocommerce_template_single_price - 10
                     * @hooked woocommerce_template_single_excerpt - 20
                     * @hooked woocommerce_template_single_add_to_cart - 30
                     * @hooked woocommerce_template_single_meta - 40
                     * @hooked woocommerce_template_single_sharing - 50
                     */
                    do_action( 'woocommerce_single_product_summary' );
                ?>
            </div><!-- .summary -->
        </div>
	</div>
</div>

<?php if( $product->product_type == 'variable' ){ ?>
<script>
var wc_add_to_cart_variation_params = <?php echo json_encode( array(
					'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.', 'woocommerce' ),
					'i18n_unavailable_text'            => esc_attr__( 'Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce' ),
				) ); ?>;
!function(a,b,c,d){a.fn.wc_variation_form=function(){var c=this,f=c.closest(".product"),g=parseInt(c.data("product_id"),10),h=c.data("product_variations"),i=h===!1,j=!1,k=c.find(".reset_variations");return c.unbind("check_variations update_variation_values found_variation"),c.find(".reset_variations").unbind("click"),c.find(".variations select").unbind("change focusin"),c.on("click",".reset_variations",function(){return c.find(".variations select").val("").change(),c.trigger("reset_data"),!1}).on("reload_product_variations",function(){h=c.data("product_variations"),i=h===!1}).on("reset_data",function(){var b={".sku":"o_sku",".product_weight":"o_weight",".product_dimensions":"o_dimensions"};a.each(b,function(a,b){var c=f.find(a);c.attr("data-"+b)&&c.text(c.attr("data-"+b))}),c.wc_variations_description_update(""),c.trigger("reset_image"),c.find(".single_variation_wrap").slideUp(200).trigger("hide_variation")}).on("reset_image",function(){var a=f.find("div.images img:eq(0)"),b=f.find("div.images a.zoom:eq(0)"),c=a.attr("data-o_src"),e=a.attr("data-o_srcset"),g=a.attr("data-o_sizes"),h=a.attr("data-o_title"),i=a.attr("data-o_title"),j=b.attr("data-o_href");c!==d&&a.attr("src",c),e!==d&&a.attr("srcset",e),g!==d&&a.attr("sizes",g),j!==d&&b.attr("href",j),h!==d&&(a.attr("title",h),b.attr("title",h)),i!==d&&a.attr("alt",i)}).on("change",".variations select",function(){if(c.find('input[name="variation_id"], input.variation_id').val("").change(),c.find(".wc-no-matching-variations").remove(),i){j&&j.abort();var b=!0,d=!1,e={};c.find(".variations select").each(function(){var c=a(this).data("attribute_name")||a(this).attr("name");0===a(this).val().length?b=!1:d=!0,e[c]=a(this).val()}),b?(e.product_id=g,j=a.ajax({url:wc_cart_fragments_params.wc_ajax_url.toString().replace("%%endpoint%%","get_variation"),type:"POST",data:e,success:function(a){a?(c.find('input[name="variation_id"], input.variation_id').val(a.variation_id).change(),c.trigger("found_variation",[a])):(c.trigger("reset_data"),c.find(".single_variation_wrap").after('<p class="wc-no-matching-variations woocommerce-info">'+wc_add_to_cart_variation_params.i18n_no_matching_variations_text+"</p>"),c.find(".wc-no-matching-variations").slideDown(200))}})):c.trigger("reset_data"),d?"hidden"===k.css("visibility")&&k.css("visibility","visible").hide().fadeIn():k.css("visibility","hidden")}else c.trigger("woocommerce_variation_select_change"),c.trigger("check_variations",["",!1]),a(this).blur();c.trigger("woocommerce_variation_has_changed")}).on("focusin touchstart",".variations select",function(){i||(c.trigger("woocommerce_variation_select_focusin"),c.trigger("check_variations",[a(this).data("attribute_name")||a(this).attr("name"),!0]))}).on("found_variation",function(a,b){var e=f.find("div.images img:eq(0)"),g=f.find("div.images a.zoom:eq(0)"),h=e.attr("data-o_src"),i=e.attr("data-o_srcset"),j=e.attr("data-o_sizes"),k=e.attr("data-o_title"),l=e.attr("data-o_alt"),m=g.attr("data-o_href"),n=b.image_src,o=b.image_link,p=b.image_caption,q=b.image_title;c.find(".single_variation").html(b.price_html+b.availability_html),h===d&&(h=e.attr("src")?e.attr("src"):"",e.attr("data-o_src",h)),i===d&&(i=e.attr("srcset")?e.attr("srcset"):"",e.attr("data-o_srcset",i)),j===d&&(j=e.attr("sizes")?e.attr("sizes"):"",e.attr("data-o_sizes",j)),m===d&&(m=g.attr("href")?g.attr("href"):"",g.attr("data-o_href",m)),k===d&&(k=e.attr("title")?e.attr("title"):"",e.attr("data-o_title",k)),l===d&&(l=e.attr("alt")?e.attr("alt"):"",e.attr("data-o_alt",l)),n&&n.length>1?(e.attr("src",n).attr("srcset",b.image_srcset).attr("sizes",b.image_sizes).attr("alt",q).attr("title",q),g.attr("href",o).attr("title",p)):(e.attr("src",h).attr("srcset",i).attr("sizes",j).attr("alt",l).attr("title",k),g.attr("href",m).attr("title",k));var r=c.find(".single_variation_wrap"),s=f.find(".product_meta").find(".sku"),t=f.find(".product_weight"),u=f.find(".product_dimensions");s.attr("data-o_sku")||s.attr("data-o_sku",s.text()),t.attr("data-o_weight")||t.attr("data-o_weight",t.text()),u.attr("data-o_dimensions")||u.attr("data-o_dimensions",u.text()),b.sku?s.text(b.sku):s.text(s.attr("data-o_sku")),b.weight?t.text(b.weight):t.text(t.attr("data-o_weight")),b.dimensions?u.text(b.dimensions):u.text(u.attr("data-o_dimensions"));var v=!1,w=!1;b.is_purchasable&&b.is_in_stock&&b.variation_is_visible||(w=!0),b.variation_is_visible||c.find(".single_variation").html("<p>"+wc_add_to_cart_variation_params.i18n_unavailable_text+"</p>"),""!==b.min_qty?r.find(".quantity input.qty").attr("min",b.min_qty).val(b.min_qty):r.find(".quantity input.qty").removeAttr("min"),""!==b.max_qty?r.find(".quantity input.qty").attr("max",b.max_qty):r.find(".quantity input.qty").removeAttr("max"),"yes"===b.is_sold_individually&&(r.find(".quantity input.qty").val("1"),v=!0),v?r.find(".quantity").hide():w||r.find(".quantity").show(),w?r.is(":visible")?c.find(".variations_button").slideUp(200):c.find(".variations_button").hide():r.is(":visible")?c.find(".variations_button").slideDown(200):c.find(".variations_button").show(),c.wc_variations_description_update(b.variation_description),r.slideDown(200).trigger("show_variation",[b])}).on("check_variations",function(c,d,f){if(!i){var g=!0,j=!1,k={},l=a(this),m=l.find(".reset_variations");l.find(".variations select").each(function(){var b=a(this).data("attribute_name")||a(this).attr("name");0===a(this).val().length?g=!1:j=!0,d&&b===d?(g=!1,k[b]=""):k[b]=a(this).val()});var n=e.find_matching_variations(h,k);if(g){var o=n.shift();o?(l.find('input[name="variation_id"], input.variation_id').val(o.variation_id).change(),l.trigger("found_variation",[o])):(l.find(".variations select").val(""),f||l.trigger("reset_data"),b.alert(wc_add_to_cart_variation_params.i18n_no_matching_variations_text))}else l.trigger("update_variation_values",[n]),f||l.trigger("reset_data"),d||l.find(".single_variation_wrap").slideUp(200).trigger("hide_variation");j?"hidden"===m.css("visibility")&&m.css("visibility","visible").hide().fadeIn():m.css("visibility","hidden")}}).on("update_variation_values",function(b,d){i||(c.find(".variations select").each(function(b,c){var e,f=a(c);f.data("attribute_options")||f.data("attribute_options",f.find("option:gt(0)").get()),f.find("option:gt(0)").remove(),f.append(f.data("attribute_options")),f.find("option:gt(0)").removeClass("attached"),f.find("option:gt(0)").removeClass("enabled"),f.find("option:gt(0)").removeAttr("disabled"),e="undefined"!=typeof f.data("attribute_name")?f.data("attribute_name"):f.attr("name");for(var g in d)if("undefined"!=typeof d[g]){var h=d[g].attributes;for(var i in h)if(h.hasOwnProperty(i)){var j=h[i];if(i===e){var k="";d[g].variation_is_active&&(k="enabled"),j?(j=a("<div/>").html(j).text(),j=j.replace(/'/g,"\\'"),j=j.replace(/"/g,'\\"'),f.find('option[value="'+j+'"]').addClass("attached "+k)):f.find("option:gt(0)").addClass("attached "+k)}}}f.find("option:gt(0):not(.attached)").remove(),f.find("option:gt(0):not(.enabled)").attr("disabled","disabled")}),c.trigger("woocommerce_update_variation_values"))}),c.trigger("wc_variation_form"),c};var e={find_matching_variations:function(a,b){for(var c=[],d=0;d<a.length;d++){var f=a[d];e.variations_match(f.attributes,b)&&c.push(f)}return c},variations_match:function(a,b){var c=!0;for(var e in a)if(a.hasOwnProperty(e)){var f=a[e],g=b[e];f!==d&&g!==d&&0!==f.length&&0!==g.length&&f!==g&&(c=!1)}return c}};a.fn.wc_variations_description_update=function(b){var c=this,d=c.find(".woocommerce-variation-description"),e=c.find(".single_variation_wrap");if(0===d.length)b&&(e.prepend(a('<div class="woocommerce-variation-description" style="border:1px solid transparent;">'+b+"</div>").hide()),e.is(":visible")?c.find(".woocommerce-variation-description").slideDown(200):c.find(".woocommerce-variation-description").show());else{var f=d.outerHeight(!0),g=0,h=!1;d.css("height",f),d.html(b),d.css("height","auto"),g=d.outerHeight(!0),Math.abs(g-f)>1&&(h=!0,d.css("height",f)),h&&d.animate({height:g},{duration:200,queue:!1,always:function(){d.css({height:"auto"})}})}},a(function(){"undefined"!=typeof wc_add_to_cart_variation_params&&a(".variations_form").each(function(){a(this).wc_variation_form().find(".variations select:eq(0)").change()})})}(jQuery,window,document);
</script>
<?php } ?>
