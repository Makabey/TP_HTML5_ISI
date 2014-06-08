<?php

require_once "assets/inc/csvFunctions.inc.php";

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
	#var_dump($retour);
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


elseif(isset($_POST['login'])){
// formulaire de connexion ----->
	if(isset($_POST['passwordLog'])){
		$username = test_input($_POST['login']);
		$password = test_input($_POST['passwordLog']);
		#var_dump($username);
		#var_dump($password);
		$resultat = authentifier_user($username, $password);
		if($resultat === true){
			$_SESSION['user'] = $username;
			header("Location:index.php");
			exit();
		}elseif(($resultat == 2) || ($resultat == 3)){
			$messErreurLogin = "Erreur, recommencez";
		}
	}
}