"use strict";

$(function(){
	$("#formLogin").submit(function(){
		/*
			On doit attrapper l'évènement SUBMIT directement sur le FORM parce que si on agit sur le
			CLICK d'un bouton et que le FORM n'est pas valide selon le BROWSER, la fonction du
			bouton est appellée malgré tout.
		*/
		var xhr = getXhr();
		var urlAuthentify="assets/xhr/authentify.xhr.php";
		var queryString;

		// On défini ce qu'on va faire quand on aura la réponse
		xhr.onreadystatechange = function(){
			// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
			if(xhr.readyState == 4 && xhr.status == 200){
				if(xhr.responseText == true){
					window.location.href="index.php";
				}else{
					$("#boiteErreursFormulaires_Login>span").text("[Authentification] Le nom d'usager ou le mot de passe est invalide!");
					$("#boiteErreursFormulaires_Login").css("display", "block");
				}
			}
		}

		queryString = "login=" + $("#login").val();
		queryString += "&passwordLog=" + $("#passwordLog").val();

		xhr.open("POST", urlAuthentify, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(queryString);

		return false;
	});
});

/* == EOF == */
