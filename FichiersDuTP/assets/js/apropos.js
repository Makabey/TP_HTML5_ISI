window.addEventListener("load", function(){
	var mapOptions;
	var map;
	var geoRequestLocked = false;
	var baliseDeGeolocalisation = "#apropos #content section>div>div:first-child>div>div>div:last-child";
	var xhrAnswer_MapDistance;

	$("#apropos #content section>div>div:first-child>div>div").click(function(){
		if(true === geoRequestLocked) return;

		if(true === geoON){
			$(baliseDeGeolocalisation).html("<p>Localisation en cours...<img src='assets/images/wait_circle2.png' class='waitCircle' alt='attendez...' /></p>");

			geoRequestLocked = true;
			navigator.geolocation.getCurrentPosition(show_map, error_map, {timeout: 15000, maximumAge: 75000});
		}else{
			$(baliseDeGeolocalisation).html("<p>Désolé, la fonction de Géolocalisation ne fonctionne pas avec votre fureteur.");
		}
	});

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
		};

		 map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map
		});
	}

	function show_map(position) {
		var myLatLng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);

		mapOptions = {
			zoom: 10,
			center: myLatLng,
			disableDefaultUI: true,
			scrollwheel: false,
			draggable: false
		};

		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		var marker_Ori = new google.maps.Marker({
		position: myLatLng,
		map: map
		});
		$(baliseDeGeolocalisation).html("<p>Localisation réussie!</p><p>Estimation de la distance...<img src='assets/images/wait_circle2.png' class='waitCircle' alt='attendez...' /></p>");
		read_mapDistance();
	}

	function error_map(err) {
		 switch(err.code){
			case 2: $(baliseDeGeolocalisation).html("<p>Désolé, il est impossible de déterminer votre position.</p>"); break; // POSITION_UNAVAILABLE
			case 3: $(baliseDeGeolocalisation).html("<p>Désolé, le délai de réponse pour calculer votre position s'est écoulé.</p>"); break; // TIMEOUT
			default: $(baliseDeGeolocalisation).html("<p>L'usager as refusé de partager sa position.</p>");
		 }
		geoRequestLocked = false;
	}


	function read_mapDistance(){
		var xhr = getXhr();
		var urlAuthentify="assets/xhr/apropos.xhr.php";
		var queryString;

		// On défini ce qu'on va faire quand on aura la réponse
		xhr.onreadystatechange = function(){
			// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
			if(xhr.readyState == 4 && xhr.status == 200){
				xhrAnswer_MapDistance = JSON.parse(xhr.responseText);

				if(xhrAnswer_MapDistance['status'] == 'OK'){
					$(baliseDeGeolocalisation).html("<p>Localisation réussie!</p><p>Distance estimée à " + xhrAnswer_MapDistance.rows[0].elements[0].distance.text + "</p><p>Récupération de l'itinéraire...<img src='assets/images/wait_circle2.png' class='waitCircle' alt='attendez...' /></p>");
					read_mapDirections();
				}else{
					$(baliseDeGeolocalisation).html("<p>Localisation réussie!</p><p>La récupération de la distance as échouée.<img src='assets/images/wait_circle2.png' class='waitCircle' alt='attendez...' /></p>");
				}
			}
		}

		queryString = "fichier=google_distanceMatrix";

		xhr.open("POST", urlAuthentify, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(queryString);

	}

	function read_mapDirections(){
		$(baliseDeGeolocalisation).html("<p>Localisation réussie!</p><p>Distance estimée à " + xhrAnswer_MapDistance.rows[0].elements[0].distance.text + "</p><p>Itinéraire affiché</p>");

		var avgLat = (45.9700711+45.5440838) /2;
		var avgLng = (-74.337835-73.6402269) /2;
		var myLatLng = new google.maps.LatLng(avgLat,avgLng);

		mapOptions = {
			zoom: 9,
			center: myLatLng,
			disableDefaultUI: true,
			scrollwheel: false,
			draggable: false
		};

		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		var latLng = new google.maps.LatLng(45.9700711,-74.337835);
		var marker = new google.maps.Marker({ position: latLng, map: map, title: "La Fabrique"});
		var latLng = new google.maps.LatLng(45.5440838,-73.6402269);
		var marker = new google.maps.Marker({ position: latLng, map: map, title: "Vous"});
	}

	initialize_GoogleMap();
	var geoON = supports_geolocation();
});
