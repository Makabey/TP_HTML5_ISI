"use strict";

$(function(){
	$("#formLogin").submit(function(){
		/*
			On doit attrapper l'évènement SUBMIT directement sur le FORM parce que si on agit sur le CLICK d'un bouton et que le FORM
			n'est pas valide selon le BROWSER, la fonction du bouton est 	appellée malgré tout.
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

		/*
		http://fr.openclassrooms.com/informatique/cours/ajax-et-l-echange-de-donnees-en-javascript/l-objet-xmlhttprequest-1 ::

		Dans le cas de GET les variables sont transmises directement dans l'URL :

		xhr.open("GET", "handlingData.php?variable1=truc&variable2=bidule", true);
		xhr.send(null);

		Pour POST, il faut spécifier les variables dans l'argument de send :
		*/

		xhr.open("POST", urlAuthentify, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(queryString);

		return false;
	});
});

// Fonctions générique de validation des champs pour un formulaire
/*function validationAlpha(saisie, error, valid){
		if(saisie.match(/^[a-zA-Z]+$/)){
			$(valid).text("Ok");
			$(error).text("");
		}
		else if(saisie == ""){
			$(error).text("");
			$(valid).text("");
		}
		else{
			$(error).text("* Veuillez entrer des lettres seulement");
			$(valid).text("");
		}
	}
*/
/*
function validationAlphaNumerique(saisie, error, valid){
	if(saisie.match(/^[a-zA-Z0-9]+$/)){
		$(valid).text("Ok");
			$(error).text("");
		}
		else if(saisie == ""){
			$(error).text("");
			$(valid).text("");
		}
		else{
			$(error).text("* Aucun caractère spéciaux permis !");
			$(valid).text("");
		}
}
*/
/*
function validationAlphaNumSpace(saisie, error, valid){
	if(saisie.match(/^[a-zA-Z0-9\s]+$/)){
		$(valid).text("Ok");
			$(error).text("");
		}
		else if(saisie == ""){
			$(error).text("");
			$(valid).text("");
		}
		else{
			$(error).text("* Aucun caractère spéciaux permis !");
			$(valid).text("");
		}
}
*/
/*
function validationCourriel(saisie, error, valid){
	if(saisie.match(/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/)){
		$(valid).text("Ok");
		$(error).text("");
		}
		else if(saisie == ""){
			$(error).text("");
			$(valid).text("");
		}
		else{
			$(error).text("* La forme doit être 'nom@domaine.com' !");
			$(valid).text("");
		}
}
*/
/* == EOF == */
