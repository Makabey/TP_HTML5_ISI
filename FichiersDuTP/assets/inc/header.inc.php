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

require_once "assets/inc/tools.inc.php";
require_once "assets/inc/csvFunctions.inc.php";
?>
<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<title><?php echo $sPageTitle; ?></title>
		<meta name="author" content="Eric Robert et Olivier Berthier" />
		<meta name="description" content="HTML5 - TP - Eric et Olivier" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" type="text/css" href="assets/css/styles.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!--<script type="text/javascript" src="assets/js/functions.js"></script>-->
		<script type="text/javascript">
		"use strict";

		window.addEventListener("load", function(){ // J'utilise un listener pour éviter de marcher sur les platebandes de jQuery
			// Support pour les sous-menus
			$("#header_produits").hover(function () {
				if ($("#header_menuNiv1_Item1_submenu2").is(":hidden")) {
					$("#header_menuNiv1_Item1_submenu2").slideDown(100);
				} else {
					$("#header_menuNiv1_Item1_submenu2").slideUp(100);
				}
			});

			$("#header_gestion_produits").hover(function () {
				if ($("#header_menuNiv1_Item1_submenu6").is(":hidden")) {
					$("#header_menuNiv1_Item1_submenu6").slideDown(50);
				} else {
					$("#header_menuNiv1_Item1_submenu6").slideUp(50);
				}
			});
		});

		/* Variables nécessaires pour le fichier JS qui suit, si applicable */
		<?php
		echo tabs(3),"var sImages_PathProduits = '$sImages_PathProduits';", PHP_EOL;
		$sNomDeCettePage = substr($_SERVER['SCRIPT_NAME'], (strrpos($_SERVER['SCRIPT_NAME'],'/')+1));
		$sNomDeCettePage = substr($sNomDeCettePage, 0, (strpos($sNomDeCettePage,'.')));

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
				$panierSousTotal  = 0; // Utilisé dans 'gestion_panier.php'
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
			// NE PAS modifier $sNomDeCettePage parce qu'elle est utilisée aussi dans "menu.inc.php"
			if(file_exists('assets/js/'.$sNomDeCettePage.'.js')){
				echo '<script type="text/javascript" src="assets/js/',$sNomDeCettePage,'.js"></script>',PHP_EOL;
			}
		?>
	</head>
	<body>
		<div id="container">
<<<<<<< HEAD
			<header role="banner">
=======
			<header id="header">
>>>>>>> f8fca89d2fe2cd3c722e3262254e5531f9a6bb1a
				<div id="center_menu">
					<a href="index.php"><img src="assets/images/logo.png" alt="Logo de 'La Fabrique'" /></a>
					<?php
					echo '<div id="userWrap">';
					$return = false;
					// Tester si un usagé est authentifié et s'il est possible de charger ses informations
					if(isset($_SESSION['user'])){
						$return = chargerUsager($usagertest, $_SESSION['user']);
					}

					if($return !== false){
						$client_ID = key($usagertest);
						$userFullName = ucwords($usagertest[$client_ID]['prenom'] . ' ' . $usagertest[$client_ID]['nomFamille']);
						echo "<div>Bonjour, $userFullName</div>";
						if((isset($_SESSION['panier'])) && (!empty($_SESSION['panier']))){
							echo '<div><a href="gestion_panier.php">';
							$nombreItems = count($_SESSION['panier']);
							$pluriel = ($nombreItems> 1)?'s':'';
							echo "$nombreItems item$pluriel au panier</a></div>";
						}else{
							echo'<div>&nbsp;</div>';
						}
						echo '<div><a href="logout.php">Déconnexion</a></div>';
					}else{
						echo '<div><a href="formulaire.php">Se connecter / s\'enregister</a></div>';
					}
					echo '</div>', PHP_EOL;
					$MenusID="header_"; # chaines à ajouter aux noms de classes dans "menu.php" pour distinguer entre l'utilisation dans le header et dans le footer
					require "assets/inc/menu.inc.php";
					?>
				</div>
			</header>

			<content id="content">
