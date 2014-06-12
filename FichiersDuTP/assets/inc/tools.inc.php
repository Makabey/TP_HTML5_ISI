<?php
define('TAUX_TAXE_TPS', 0.05);
define('TAUX_TAXE_TVQ', 0.09975);

/*
	Fonctions pour les formulaires
*/
// function pour éliminer les characetres spéciaux
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = strtolower($data);

	return $data;
}


/*
	Fonctions générales
*/
function calculerTaxes($fMontant, $iDecimales = -1){
	// Référence :: http://www.revenuquebec.ca/fr/entreprise/taxes/tvq_tps/calcul-taxes.aspx
	$retour = false;

	if(is_float($fMontant)){
		$tps = $fMontant * TAUX_TAXE_TPS;
		$tvq = $fMontant * TAUX_TAXE_TVQ;

		$retour = $tps + $tvq;
		if($iDecimales > -1){
			$retour = round($retour, $iDecimales);
		}
	}

	return $retour;
}


function ajouterTaxes($fMontant, $iDecimales = -1){
	// Référence :: http://www.revenuquebec.ca/fr/entreprise/taxes/tvq_tps/calcul-taxes.aspx
	$retour = calculerTaxes($fMontant);
	if($retour !== false){
		$retour += $fMontant;

		if($iDecimales > -1){
			$retour = round($retour, $iDecimales);
		}
	}

	return $retour;
}


function tabs($nombre){
	return str_repeat(chr(9), $nombre);
}


function walkDirectory($pathToSearch, $seekedExtensions){
	/*
		But :	sonder un répertoire spécifique et retourner tout les fichiers
				dont le type corresponds à ce qui est recherché

		$pathToSearch : Le répertoire à sonder
		$seekedExtensions : Les extensions à rechercher, séparées par des pipes '|'

		Retourne:
			false = le répertoire n'existe pas
			<rien> = le répertoire ne contient aucun fichier recherché
			chaine = liste des fichiers séparés par des pipes '|'
	*/
	$retour = false;

	if($resSearchedPath = @opendir($pathToSearch)){

		$strAcceptableImgExts = ""; // Contiendra les extensions valables "parsées"
		$seekedExtensions = strtolower($seekedExtensions);
		$seekedExtensions = explode('|', $seekedExtensions);
		for($iCmpt=0;$iCmpt<count($seekedExtensions);$iCmpt++){
			if(strlen($seekedExtensions[$iCmpt])>3){
				$seekedExtensions[$iCmpt]=substr($seekedExtensions[$iCmpt], -3);
				$strAcceptableImgExts .= $seekedExtensions[$iCmpt];
			}else{
				$strAcceptableImgExts .= '.'.$seekedExtensions[$iCmpt];
			}
		}
		$arrNomsFichs = array();
		while(false !== ($strFileName = readdir($resSearchedPath))){
			if($strFileName != '.' && $strFileName != '..'){ // Si autre que '.' ou '..' qui sont des répertoires parents dans Linux
				$sTmpExt = strtolower(substr($strFileName, -3));
				if(substr_count($strAcceptableImgExts, $sTmpExt) > 0){
					$arrNomsFichs[] = $strFileName;
				}
			}
		}
		$retour = implode('|', $arrNomsFichs);
		closedir($resSearchedPath);
	}

	return $retour;
}

/* == EOF == */
