<?php
/*
	Le test permet à une page (ici il n'y as que "gestion_panier" qui le fasse aussi) de démarrer elle-même
	la SESSION avant qu'on arrive ici. La nécessité découle du besoin d'afficher le nombre exact d'items dans le panier.
*/
if(strlen(session_id()) == 0){
	session_start();
}

$sImages_PathProduits = "assets/images/produits/"; # le path doit finir par un '/'
$sImages_PathSlider = "assets/images/slider/"; # le path doit finir par un '/',
$sNomDeCettePage = substr($_SERVER['SCRIPT_NAME'], (strrpos($_SERVER['SCRIPT_NAME'],'/')+1));
$sNomDeCettePage = substr($sNomDeCettePage, 0, (strpos($sNomDeCettePage,'.')));

require_once "assets/inc/tools.inc.php";
require_once "assets/inc/csvFunctions.inc.php";
require_once "assets/inc/menus.inc.php";
?>
<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<title><?php echo $sPageTitle; ?>La Fabrique de Jouet</title>
		<meta name="author" content="Eric Robert et Olivier Berthier" />
		<meta name="description" content="Petite fabrique de jouets en bois naturels, utilisant le strict minimum de matériaux autres tel que peinture, métaux et plastiques." />
		<meta name="keywords" content="jouets, bois, jouets en bois, jouets sur mesure, naturel, durable, enfant" />
		<link rel="stylesheet" href="assets/css/styles.css" media="only screen" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!--<script src="assets/js/functions.js"></script>-->
		<script>
		"use strict";
		var PageTitle = "La Fabrique de Jouet"; // cette variable est pour l'éventuel changement à la page catalogue pour permettre d'avoir un nom de base pour dynamiquement reconstruire le title de la page.

		window.addEventListener("load", function(){ // J'utilise un listener pour éviter de marcher sur les platebandes de jQuery
			// Support pour les sous-menus
			var li_fix_padding = $('header nav .centrerMenu > ul > li:last-child > a').text();
			if(li_fix_padding == "Se connecter / s'enregistrer"){
				$('header nav .centrerMenu > ul > li:last-child').css('padding','0');
			}
		});
		/* Variables nécessaires pour le fichier JS qui suit, si applicable */
		<?php
		echo tabs(3),"var sImages_PathProduits = '$sImages_PathProduits';", PHP_EOL;

		switch($sNomDeCettePage){
			case 'index':
				echo tabs(3),"var sImages_PathSlider = '$sImages_PathSlider';", PHP_EOL;
				echo tabs(3),'var arrImages = new Array("menuiserie1.jpg", "menuiserie2.jpg", "menuiserie3.jpg", "menuiserie4.jpg");', PHP_EOL;
				break;

			case 'produits':
				$cat_noms = array();
				$cat_affichages = array();
				foreach($arrNomsCategories as $categorie){ // $arrNomsCategories provient de 'produits.php'
					$cat_noms[] = $categorie['token'];
					$cat_affichages[] = $categorie['nom'];
				}
				echo tabs(3),"var arrNomsCategories = new Array('",implode(", ", $cat_noms),"');", PHP_EOL;
				echo tabs(3),"var arrNomsCategories_affichage = new Array('",implode(", ", $cat_affichages),"');", PHP_EOL;
				echo tabs(3),"var iProduit_ID = '$iProduit_ID';", PHP_EOL; // $iProduit_ID provient de 'produits.php'
				echo tabs(3),'var arrProduits = {',$sDetailsProduits,'};',PHP_EOL; // remplir un array JS avec les valeurs de tout les produits
				break;

			case 'gestion_produits':
				echo tabs(3),'var arrProduits = {',$sDetailsProduits,'};',PHP_EOL; // remplir un array JS avec les valeurs de tout les produits
				break;

			case 'gestion_panier':
				$panierSousTotal = 0; // Utilisé dans 'gestion_panier.php'
				$panierPrix = '';
				if((isset($_SESSION['panier'])) && (!empty($_SESSION['panier']))){
					$retour = chargerProduits($produits_charger);
					if($retour !== false){
						foreach($_SESSION['panier'] as $pid => $details){
							$panierSousTotal += ($details['quantite'] * $produits_charger[$pid]['prix']);
							$panierPrix .= '"'.$pid.'":"'.$produits_charger[$pid]['prix'].'", ';
						}
					}
				}
				echo tabs(3),'var arrPanierPrix = {',$panierPrix,'};',PHP_EOL;
				break;
		}
		?>
		</script>
		<!-- Fichier JS spécifique à la page -->
		<?php
			// NE PAS modifier $sNomDeCettePage parce qu'elle est utilisée aussi dans "menus.inc.php"
			if(file_exists('assets/js/'.$sNomDeCettePage.'.js')){
				echo '<script src="assets/js/',$sNomDeCettePage,'.js"></script>',PHP_EOL;
			}
			if($sNomDeCettePage == 'authentify'){
				echo '<script src="assets/xhr/xhrFunctions.js"></script>',PHP_EOL;
			}
		?>
	</head>
	<body id="<?php echo $sNomDeCettePage; ?>">
		<header role="banner">
		<?php
			$MenusID="header_"; # chaines à ajouter aux noms de classes dans "menu.php" pour distinguer entre l'utilisation dans le header et dans le footer
			spawnMainMenu();
		?>
		</header>
		<div id="container">
			<div id="content" role="main">
