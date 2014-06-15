<?php
define('RES_BASE_DIR', '../res/');

$resultat = false;

if(isset($_POST['fichier'])){
	$sNomFichier = RES_BASE_DIR . $_POST['fichier'] . '.json';

	if(file_exists($sNomFichier)){
		$resultat = @readfile($sNomFichier);
		if(false !== $resultat) exit();
	}
}

echo $resultat; /* résultat final retourné à XHR */

/* == EOF == */
