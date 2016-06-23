(function( $ ){
	"use strict";
    var InspiusWoocommerce = {
        init : function() {
        	this.quickview();
        	this.switchLayout();
        	this.removeProductInCart();
        	this.countdown();
        	this.buttonQuantity('.woocommerce .quantity');
        	this.buttonQuantityEvent();
        	this.switchMyAccount();
        	this.wishlist();
        	this.cartFly();
        	this.searchDropdownCategories();
        },
        searchDropdownCategories: function(){
        	$('.is-woo-categories-dropdown').each(function() {
        		var $main 	= $(this);
	        	var $title 	= $main.find('.dropdown-toggle .title');
	        	var $hidden = $main.find('.product_cat');
	        	$title.text($main.find('li.active a').text());
	        	$main.on('click', 'a', function() {
	        		$main.removeClass('open').find('li').removeClass('active');
	        		var $this = $(this);
	        		$title.text($this.text());
	        		$hidden.val($this.data('value'));
	        		$this.parent().addClass('active');
	        		return false;
	        	});
        	});
	        	
        },
        cartFly: function(){
        	if( !$('body').hasClass('cart-fly') ){
        		return false;
        	}
        	$(document.body).on('added_to_cart', function(event,fragments,cart_hash,$thisbutton) {
        		var $thisimage 	= $thisbutton.closest('.product-block').find('.image img').first();
        		var $thiscart 	= $('.shoppingcart');
        		var imgclone 	= $thisimage.clone()
	                .offset({
	                top: $thisimage.offset().top,
	                left: $thisimage.offset().left
	            }).css({
	                	'opacity'	: '0.7',
	                    'position'	: 'absolute',
	                    'height'	: '150px',
	                    'width'		: '150px',
	                    'z-index'	: '9999'
	            }).appendTo($('body'))
	                .animate({
	                	'top'		: $thiscart.offset().top + 30,
	                    'left'		: $thiscart.offset().left + 15,
	                    'width'		: 30,
	                    'height'	: 30
	            }, 1000 );

	            //$("body, html").animate({scrollTop : 0}, 900);

	            imgclone.animate({
	                'opacity': 0,
	            }, function () {
	                $(this).detach()
	            });

        	});
        },
        buttonQuantity: function(element){
        	$(element).prepend('<span class="qty-ctrl qty-minus">-</span>').append('<span class="qty-ctrl qty-plus">+</span>');
        },
        buttonQuantityEvent: function(){        	
        	$('body').delegate( '.quantity .qty-plus' ,'click', function() {
        		var $qty = $(this).prev();
				var val = $qty.val();
				val = parseInt(val);
				$qty.val(val + 1);
        	}).delegate( '.quantity .qty-minus' ,'click', function() {
        		var $qty = $(this).next();
				var val = $qty.val();
				val = parseInt(val);
				if( val > 1 ){
					$qty.val(val - 1);
				}
        	});

        },
        wishlist: function(){
        	$('.is-whishlist').on( 'click', function(){

        		var $this = $(this);
        		if( !$this.hasClass('added') ){
	        		var $data = {
		                add_to_wishlist: $this.data( 'product-id' ),
		                product_type: $this.data( 'product-type' ),
		            };

		            $.ajax({
			            type: 'GET',
			            url: ajaxurl,
			            data: $data,
			            dataType: 'json',
			            beforeSend: function(){
			                $this.addClass('loading')
			            },
			            complete: function(){
			            	$this.removeClass('loading');
			            	$this.addClass('added');
			            	$this.attr('href', $this.data('url'));
			            },
			        });
		        	return false;
		        }

        	});
        },
        switchMyAccount: function(){
        	$('.my-account-group').on('click', '.list-group-item', function() {
        		$(this).parent().find('.list-group-item').removeClass('active');
        		$(this).addClass('active');
        	});
        },
        quickview: function(){
        	$('.quickview').on( 'click', function(){
        		var $this 	= $(this);
        		var proid 	= $this.data('proid');
	   			var data 	= { action: 'is_quickview', product: proid };
	   			$.ajax({
	   				url: ajaxurl,
	   				type: 'POST',
	   				data: {
	   					action: 'is_quickview',
	   					product: proid,
	   				},
	   				beforeSend: function(){
	   					$this.addClass('loading');
	   				},
	   				success: function(response){
	   					$.magnificPopup.open({
							items: {
								src: '<div class="product-quickview">'+response+'</div>', // can be a HTML string, jQuery object, or CSS selector
								type: 'inline'
							}
						});
						InspiusWoocommerce.buttonQuantity('.product-quickview .quantity');
						$this.removeClass('loading');

						InspiusWoocommerce.quickviewSlide();
						InspiusWoocommerce.quickviewImage();
	   				}
	   			});
				return false;
        	});
        },
        quickviewSlide: function(){
        	$('.quickview-slides').owlCarousel({
				nav : false,
				dots: false,
				items : 4,
			});
        },
        quickviewImage: function(){
        	$('.quickview-slides .item').on('click', function() {
        		var $this = $(this);
        		var $url = $this.find('img').data('src');

        		$('.quickview-slides .item').removeClass('active');
        		$this.addClass('active');
        		$('#quickview .image-thumb img').attr('src',$url);
        		return false;
        	});
        },
        switchLayout: function(){
			$('.catalog-ordering .switch-layout a').on( 'click', function(){
				var action = $(this).data('action');
	            var $form = $(this).closest('.form-switch-layout');
	            $form.find('input[name="layout"]').val(action);
	            $form.submit();
	            return false;
			});
        },
        removeProductInCart: function(){
        	$('#is_cart_canvas').delegate('.is_product_remove', 'click', function(event) {
        		var $this = $(this);
				var product_key = $this.data('product-key');
				var product_id = $this.data('product-id');
		        $.ajax({
		            type: 'POST',
		            dataType: 'json',
		            url: ajaxurl,
		            data: { action: "cart_remove_product", 
	                    product_key: product_key,
	                    product_id : product_id
		            },success: function(data){
		                var $cart = $('#is_cart_canvas');
		                $('.shoppingcart a span').text( data.count );
		                if(data.count==0){
		                	$cart.find('.cart_list').html('<li class="empty">'+$cart.find('.cart_container').data('text-emptycart')+'</li>');
		                	$cart.find('.total,.buttons').remove();
		                }else{
			                $cart.find('.total .amount').remove();
			                $cart.find('.total').append(data.subtotal);
			                $this.parent().remove();
		                }
		            }
		        });
		        return false;
        	});
        },
        countdown: function(){
			$('.countdown').each(function() {
		        var count = $(this);
		        var austDay =  new Date(count.data('countdown'));
		        $(this).countdown({
		        	labels: [is_countdown_l10n.years, is_countdown_l10n.months, is_countdown_l10n.weeks, is_countdown_l10n.days , is_countdown_l10n.hours, is_countdown_l10n.minutes, is_countdown_l10n.seconds],
					labels1: [is_countdown_l10n.year, is_countdown_l10n.month, is_countdown_l10n.week, is_countdown_l10n.day, is_countdown_l10n.hour, is_countdown_l10n.minute, is_countdown_l10n.second],
		        	until : austDay,
		        	format: 'dHMS'
		        });
		    });
        },   
    };

    $(document).ready(function() {
    	InspiusWoocommerce.init();
    });
})( jQuery );