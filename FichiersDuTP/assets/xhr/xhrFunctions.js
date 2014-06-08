/*
	 Référence :: http://siddh.developpez.com/articles/ajax/
*/

function getXhr(){
	var xhr = null; 

	if(window.XMLHttpRequest){ // Firefox et autres
		xhr = new XMLHttpRequest(); 
	}else if(window.ActiveXObject){ // Internet Explorer 
		try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
	}
	else { // XMLHttpRequest non supporté par le navigateur 
		alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
		xhr = false; 
	} 
	return xhr;
}

/** EXEMPLE!!!
* Méthode qui sera appelée sur le click du bouton
*/
/*function go(){
	var xhr = getXhr()
	// On défini ce qu'on va faire quand on aura la réponse
	xhr.onreadystatechange = function(){
		// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
		if(xhr.readyState == 4 && xhr.status == 200){
			alert(xhr.responseText);
		}
	}
	xhr.open("GET","ajax.php",true);
	xhr.send(null);

	//		dans l'exemple sur la page, 'ajax.php' contient simplement
	//
	//	<?php
	//		echo "Bonjour de php";
	//	?>
		
	//	l'auteur argumente qu'utiliser XMLHttpRequest avec une page PHP, ce n'est pas réellement du AJAX si la page n'est pas du pur XML, mais plutôt simplement utiliser XMLHttpRequest
}*/
