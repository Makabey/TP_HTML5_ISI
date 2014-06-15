window.addEventListener("load", function(){
	var mapOptions;
	var map;

	function supports_geolocation() {
		return 'geolocation' in navigator;
	}

	function initialize_GoogleMap() {
		var myLatLng = new google.maps.LatLng(45.970071,-74.337835);
		mapOptions = {
			zoom: 15,
			center: myLatLng,
			disableDefaultUI: true,
			scrollwheel: false,
			draggable: false
		}

		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map
		});
	}

	$("#btnGeo").click(function(){
		if(true === geoON){
			function show_map(position) {
				var myLatLng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);

				mapOptions = {
					zoom: 10,
					center: myLatLng,
					disableDefaultUI: true,
					scrollwheel: false,
					draggable: false
				}

				map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

				var marker_Ori = new google.maps.Marker({
				position: myLatLng,
				map: map
				});
				$("#btnGeo").text("Lancer la géolocalisation");
				$("#btnGeo").removeAttr("disabled");
			}

			function error_map(err) {
				  switch(err.code){
					case 2: alert("Désolé, il est impossible de déterminer votre position."); break; // POSITION_UNAVAILABLE
					case 3: alert("Désolé, le délai de réponse pour calculer votre position s'est écoulé."); break; // TIMEOUT
					default: alert("L'usager as refusé de partager sa position.");
				 }
				$("#btnGeo").text("Lancer la géolocalisation");
				$("#btnGeo").removeAttr("disabled");
			}

			navigator.geolocation.getCurrentPosition(show_map, error_map, {timeout: 15000, maximumAge: 75000});
			$(this).text("Requête lancée...");
			$(this).attr("disabled", "disabled");
		}else{
			alert('Désolé, la fonction de Géolocalisation ne fonctionne pas avec votre fureteur.');
		}
	});

	initialize_GoogleMap();
	var geoON = supports_geolocation();

});
