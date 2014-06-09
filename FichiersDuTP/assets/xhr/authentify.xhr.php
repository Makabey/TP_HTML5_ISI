<?php

/*
	Le test permet à une page de démarrer elle-même la SESSION sans nuire aux autres pages
	qui voudrait faire de même, parce des appels multiples engendrent une erreur
*/
if(strlen(session_id()) == 0){
	session_start();
}

define('CSV_BASE_DIR', '../res/');
require_once "../inc/csvFunctions.inc.php";

// function pour éliminer les characetres spéciaux
function test_input($data) {
 $data = trim($data);
 $data = stripslashes($data);
 $data = htmlspecialchars($data);
 $data = strtolower($data);
 return $data;
}

function authentifier_user($nom_user, $password_user){
	$retour = chargerUsager($data_user, $nom_user);

	if($retour !== FALSE){
		if(!empty($data_user)){
			if($data_user[key($data_user)]['password']==$password_user){
				$retour = true; // Tout correspond
			}
			else{
				$retour = 2; // Mot de passe invalide
			}
		}
		else{
			$retour = 3; // Usager inexistant
		}
	}
	return $retour;
}

$resultat = false;
if(isset($_POST['login'])){
	// formulaire de connexion ----->
	if(isset($_POST['passwordLog'])){
		$username = test_input($_POST['login']);
		$password = test_input($_POST['passwordLog']);
		$resultat = authentifier_user($username, $password);
		if($resultat === true){
			$_SESSION['user'] = $username;
		}
	}
}

echo $resultat; /* résultat final retourné à XHR */

/* == EOF == */
