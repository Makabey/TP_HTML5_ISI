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
	#var_dump($retour);
	#echo  '[authentifier_user] retour = '.(($retour===false)?'false':$retour).'; '; # test
	
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

#$retour = ''; #false;
$resultat = false;
if(isset($_GET['login'])){
#$retour .= "login = {$_GET['login']}; "; # test
// formulaire de connexion ----->
	if(isset($_GET['passwordLog'])){
		#$retour .= "pwd = {$_GET['passwordLog']}; "; # test
		$username = test_input($_GET['login']);
		$password = test_input($_GET['passwordLog']);
		#var_dump($username);
		#var_dump($password);
		$resultat = authentifier_user($username, $password);
		#var_dump($resultat);
		if($resultat === true){
			#$retour .= 'true; '; # test
			$_SESSION['user'] = $username;
			/*header("Location:index.php");
			exit();*/
			#$retour = true;
		}#elseif(($retour == 2) || ($retour == 3)){
			#$messErreurLogin = "Erreur, recommencez";
		#	echo false;
		#}
	}
#}else{
#	echo false;
}
#$retour .= 'resultat = '.(($resultat===false)?'false':$resultat).'; '; # test

#echo $retour; /* résultat final retourné à XHR */
echo $resultat; /* résultat final retourné à XHR */

/* == EOF == */
