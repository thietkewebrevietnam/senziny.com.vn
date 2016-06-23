(function( $ ){
	"use strict";
    var InspiusFrontend = {
    	settings: {
    		BackToTop: false,
    		AnimationScroll: false,
    		GMap : false,
    		StickyMenu: true,
    	},
        init : function(options) {
        	var settings = {}
        	$.extend(settings, this.settings, options);

        	// Setup Tooltip
        	$('[data-toggle="tooltip"]').tooltip(); 

        	if( settings.BackToTop ){
        		this.BackToTop();
        	}

        	this.IsotopeFix();
        	this.OwlCarouselInit();

        	if( settings.AnimationScroll && !Modernizr.touch ){
	            var wow = new WOW(
		            {
		            	mobile : false,
		            }
	            );
	            wow.init();
	        }
	        if( settings.GMap ){
	        	this.InitGmap();
	        }

	        if( settings.StickyMenu ){
	        	this.InitStickyMenu();
	        }

	        this.InitSelectInput();

	        this.VideoBanner();

	        this.InitRowFullWidth();

	        this.InitSearchButton();

        },
        InitSearchButton: function(){
        	$('.header-action .search-action').on('click', '.icon-magnifier', function(e) {
        		var $searchform = $('.is-search-form');
        		if( $searchform.hasClass('open') ){
        			$searchform.removeClass('open');
        		}else{
        			$searchform.addClass('open').find('input[type="search"]').focus();
        		}
        		return false;
        	});
        },
        InitStickyMenu: function(){
        	var lastScrollTop = 0;
        	var mainmenu = $('.is-header');
        	$(window).scroll(function() {
        		var st = $(this).scrollTop();
				// if (st > lastScrollTop || st < 350 ){
				if ( st < 350 ){
					mainmenu.removeClass('fixed');
				} else {
					if(st > 350){
						mainmenu.addClass('fixed');
					}
				}
				// lastScrollTop = st;
        	});
        },
        InitRowFullWidth: function(){
    		var $this = $('[data-is-full-width="true"]');
    		var $main = $this.find('main.is-main-no-sidebar');
    		if( !$main.length ){
    			var $is_right 	 = $('main.site-main').hasClass('is-main-right-sidebar'); 
	    		var $win 		 = $(window).width();
	    		var $main_height = $this.outerHeight();
	    		var $container 	 = $this.find('.is-row-full-width');
	    		var $sidebar 	 = $this.find('.is-sidebar');

	    		

	    		$container.after('<div class="is-row-full-container"></div>');
	    		var $container_width = $container.next();
	    		InspiusFrontend.setCssRowFull( $container, $main_height, $sidebar, $win, $container_width, $is_right );

	    		$(window).resize(function() {
	    			$win = $(window).width();
	    			$main_height = $this.outerHeight();
	    			InspiusFrontend.setCssRowFull( $container, $main_height, $sidebar, $win, $container_width, $is_right );
	    		});
    		}
        },
        setCssRowFull: function( element, height, sidebar, win, container_width, is_right ){
        	var $position = (win - container_width.width())/2 + sidebar.outerWidth();
        	if( is_right ){
        		console.log('hello');
        		$position = $position * -1;
        	}

        	element.css({
        		width: win,
        		left: $position,
        		height: height
        	});	
        },
        VideoBanner: function(){
        	$('.video-banner').each(function() {
        		var $this = $(this);
        		var video = $this.find('video')[0];

        		$this.on('click', function() {

        			if (video.paused){
				        video.play(); 
				        $this.addClass('playing');
        			}
				    else{
				        video.pause(); 
				        $this.addClass('pause');
				        $this.removeClass('playing');
				    }
        		});
        	});
        },
        InitSelectInput: function(){
        	$('.is-sidebar select,.variations select,.woocommerce-ordering select,.footer select').each(function() {
        		var item = $(this);
        		item.after('<div class="is-select-custom"><div class="arrow"></div></div>');
        		item.prependTo(item.next());
        	});

        	$('.is-select-custom .arrow').on('click', function() {
        		InspiusFrontend.selectArrowClick($(this).prev());
        	});
        },
        selectArrowClick: function(elem){
        	if (document.createEvent) {
		        var e = document.createEvent("MouseEvents");
		        e.initMouseEvent("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
		        elem[0].dispatchEvent(e);
		    } else if (element.fireEvent) {
		        elem[0].fireEvent("onmousedown");
		    }
        },
        InitGmap : function() {
        	console.log(google.maps.MapTypeId.ROADMAP);
			$('[data-gmap="map"]').each(function(index, el) {
				var $this = $(this);
				var $zoom = $this.data('zoom');
				var $center = $this.data('center');
				var $type = $this.data('type');
				var $marker = {position:$center};
				$(this).gmap({
					scrollwheel : false,
					zoom 		: $zoom,
					center 		: $center,
					callback 	: function() {
						var self = this;
						self.addMarker($marker).click(function(){
							//self.openInfoWindow({'content': '$location'}, self.instance.markers[0]);
						});
					},
					panControl: $(this).data('pancontrol'),
				});
			});
        },
        BackToTop : function( ) {
        	var _html = '<a class="scroll-to-top" href="#" id="scrollToTop"><i class="fa fa-angle-up"></i></a>';
        	$('#wrapper').after(_html);
        	var _isScrolling = false;
	    	$("#scrollToTop").click(function(e) {
				e.preventDefault();
				$("body, html").animate({scrollTop : 0}, 500);
				return false;
			});

			// Show/Hide Button on Window Scroll event.
			$(window).scroll(function() {
				if(!_isScrolling) {
					_isScrolling = true;
					if($(window).scrollTop() > 150) {
						$("#scrollToTop").stop(true, true).addClass("visible");
						_isScrolling = false;
					} else {
						$("#scrollToTop").stop(true, true).removeClass("visible");
						_isScrolling = false;
					}
				}
			});
        },
        OwlCarouselInit: function(){
        	var owl = $('[data-owl="slide"]');
			var $rtl = owl.data('ow-rtl');
			owl.each(function(index, el) {
				var $item = $(this).data('item-slide');
				var $text_next = $(this).data('text-next') ? $(this).data('text-next') : '';
				var $text_prev = $(this).data('text-prev') ? $(this).data('text-prev') : '';
				
				$(this).owlCarousel({
					nav : true,
					dots: true,
					rtl: $rtl,
					items : $item,
					navText : ["<i class='fa fa-angle-left'></i><span>"+$text_prev+"</span>","<span>"+$text_next+"</span><i class='fa fa-angle-right'></i>"],
					responsive:{
						0:{
					      items:1 // In this configuration 1 is enabled from 0px up to 479px screen size 
					    },
					    480:{
					      items:1, // from 480 to 677 
					    },

					    640:{
					      items: ($item == '1') ? $item : 3, // from this breakpoint 678 to 959
					    },

					    991:{
					      items: ($item == '1') ? $item : 3, // from this breakpoint 960 to 1199

					    },
					    1199:{
					      items:$item,
					    }
					}
				});
			});

			$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			    $($(e.target).attr('href')).find('.owl-carousel')
			        .owlCarousel('invalidate', 'width')
			        .owlCarousel('update');
			});
        },
        IsotopeFix: function(){
        	if($().isotope){
				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
					$('.isotope').isotope('reLayout');
				});
				$('[id*="accordion-"]').on('shown.bs.collapse',function(e){
					$('.isotope').isotope('reLayout');
				});
			}
        }
    };

    $.fn.InspiusFrontend = function(options) {
    	InspiusFrontend.init(options);
    };


})( jQuery );
