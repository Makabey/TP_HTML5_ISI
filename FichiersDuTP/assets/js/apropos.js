window.addEventListener("load", function(){
	var mapOptions;
	var map;
	var geoRequestLocked = false;
	var baliseDeGeolocalisation = "#apropos #content section>div>div:first-child>div>div>div:last-child";

	$("#apropos #content section>div>div:first-child>div>div").click(function(){
		if(true === geoRequestLocked) return;

		if(true === geoON){
			$(baliseDeGeolocalisation).html("<p>Localisation en cours...<img src='assets/images/wait_circle2.png' class='waitCircle' alt='attendez...' /></p>");

			geoRequestLocked = true;

			navigator.geolocation.getCurrentPosition(show_map, error_map, {timeout: 15000, maximumAge: 75000});
			//$(this).text("Requête lancée...");
			//$(this).attr("disabled", "disabled");

		}else{
			//alert('Désolé, la fonction de Géolocalisation ne fonctionne pas avec votre fureteur.');
			$(baliseDeGeolocalisation).html("<p>Désolé, la fonction de Géolocalisation ne fonctionne pas avec votre fureteur.");
		}
	});

	initialize_GoogleMap();
	var geoON = supports_geolocation();

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
		//$("#btnGeo").text("Lancer la géolocalisation");
		//$("#btnGeo").removeAttr("disabled");
		//geoRequestLocked = false;
		$(baliseDeGeolocalisation).html("<p>Localisation réussie!</p><p>Estimation de la distance...<img src='assets/images/wait_circle2.png' class='waitCircle' alt='attendez...' /></p>");
		read_mapDistance();
	}

	function error_map(err) {
		 switch(err.code){
			case 2: $(baliseDeGeolocalisation).html("<p>Désolé, il est impossible de déterminer votre position.</p>"); break; // POSITION_UNAVAILABLE
			case 3: $(baliseDeGeolocalisation).html("<p>Désolé, le délai de réponse pour calculer votre position s'est écoulé.</p>"); break; // TIMEOUT
			default: $(baliseDeGeolocalisation).html("<p>L'usager as refusé de partager sa position.</p>");
		 }
		//$("#btnGeo").text("Lancer la géolocalisation");
		//$("#btnGeo").removeAttr("disabled");
		geoRequestLocked = false;
	}


	function read_mapDistance(){

	/*je suis rendu a arranger ce code en me disant qu'il doit charger la distance en premier lieu, puis l'itinéraire et enfin, faire la géo donc chaque fonction appelle la suivante à moins de réussir à en fiare une généraliste qui me retourne seulement le résultat...*/

				var xhr = getXhr();
				var urlAuthentify="assets/xhr/apropos.xhr.php";
				var queryString;
				var xhrAnswer;

				// On défini ce qu'on va faire quand on aura la réponse
				xhr.onreadystatechange = function(){
					// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
					if(xhr.readyState == 4 && xhr.status == 200){
						//console.log(xhr.responseText);
						xhrAnswer = JSON.parse(xhr.responseText);
						console.log(xhrAnswer);
						//xhrAnswer = xhrAnswer.split("\r\n");
						//xhrAnswer = parseInt(xhrAnswer[0]);
						
						if(xhrAnswer['status'] == 'OK'){
							//window.location.href="index.php";
							//$(baliseDeGeolocalisation).html("<p>récupération ok</p>");
							$(baliseDeGeolocalisation).html("<p>Localisation réussie!</p><p>Distance estimée à " + xhrAnswer.rows[0].elements[0].distance.text + "</p><p>Récupération de l'itinéraire...<img src='assets/images/wait_circle2.png' class='waitCircle' alt='attendez...' /></p>");
							read_mapDirections();
						}else{
							//$(baliseDeGeolocalisation).html("<p>La récupération de la distance as échouée</p>");
							$(baliseDeGeolocalisation).html("<p>Localisation réussie!</p><p>La récupération de la distance as échouée.<img src='assets/images/wait_circle2.png' class='waitCircle' alt='attendez...' /></p>");
						}
					}
				}

				queryString = "fichier=google_distanceMatrix";

				xhr.open("POST", urlAuthentify, true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send(queryString);

	}

	function read_mapDIrections(){
		
	}
});
