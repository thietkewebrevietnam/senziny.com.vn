!function($) {
	if($('#geocomplete').length>0){
		var _lat_lng 	= $('#is_element-map input[type=hidden]').val();
		var loca 		= _lat_lng;
		_lat_lng 		= _lat_lng.split(',');
		var center 		= new google.maps.LatLng(_lat_lng[0],_lat_lng[1]);
	    $("#geocomplete").geocomplete({
			map: ".map_canvas",
			types: ["establishment"],
			country: "de",
			details: ".mapdetail",
			markerOptions: {
				draggable: true
			},
			location:loca,
			mapOptions: {
				scrollwheel :true,
				zoom:15,
				center:center
			}
	    });
	    $(".googlefind button.find").click(function(){
			$("#geocomplete").trigger("geocode");
		});
	    $("#geocomplete").bind("geocode:dragged", function(event, latLng){
			$("input[name=lat]").val(latLng.lat());
			$("input[name=lng]").val(latLng.lng());
			$(".wpb_el_type_hidden input[name=link]").val(latLng.lat()+','+latLng.lng());
	    }).bind("geocode:result",function(event, result){
	    	$('.is_latgmap').trigger('change');
	    });

	    $('.is_latgmap,.is_lnggmap').keyup(function(event) {
	    	var value = $('.is_latgmap').val()+','+$('.is_lnggmap').val();
	    	$("#is_element-map input[type=hidden]").val(value);
	    }).change(function(){
	    	var value = $('.is_latgmap').val()+','+$('.is_lnggmap').val();
	    	$("#is_element-map input[type=hidden]").val(value);
	    });
	}
}(window.jQuery);
