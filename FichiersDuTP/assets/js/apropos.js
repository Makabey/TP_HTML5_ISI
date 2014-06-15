window.addEventListener("load", function(){
	function initialize_GoogleMap() {
		var myLatLng = new google.maps.LatLng(45.970071,-74.337835);
		var mapOptions = {
			zoom: 15,
			center: myLatLng,
			disableDefaultUI: true,
			scrollwheel: false,
			draggable: false
		}
		var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		//var image = repImages+'pin.png';
		//var myLatLng = new google.maps.LatLng(Lat, Lng);
		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map
		});
	}

	initialize_GoogleMap();
});
