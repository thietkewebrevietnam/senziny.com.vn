(function($){
	var Inspius_LayoutImage_Sidebar = function(id){
		var $sidebar = $('.cmb2-metabox [class*="is-page-sidebar"]');
		switch(id){
			case 1:
				$sidebar.hide();
				break;
			case 2:
				$sidebar.show();
				break;
			case 3:
				$sidebar.show();
				break;
			default:
				$sidebar.show();
				break;
		}
	}

	$(document).ready(function(){
		
		Inspius_LayoutImage_Sidebar(parseInt($('#_is_page_layout').val()));
		$('.layout-image img').on("click",function(){
			$('.layout-image img').removeClass('active');
			var $val = $(this).addClass('active').data('value');
			$(this).parent().next().val($val);
			Inspius_LayoutImage_Sidebar($val);
		});

	});
})(jQuery)
