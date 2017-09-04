<?php
/*
	Refonte du fichier où je construit 2 menus différents selon si c'est celui du NAV/Footer ou de LOGIN
*/
require_once "inc/csvFunctions.inc.php";

function spawnMainMenu($sNomDeCettePage, $isHeaderMenu = false){
	$arrCategories = ''; // remplis par 'chargerCategories';
	$retour = chargerCategories($arrCategories);
	$template = '
			<nav%1$s>
				<div class="centrerMenu">
					<ul>
						%2$s

						%3$s<span class="spanFix_li_hover%4$s">Catalogue</span><img src="images/arrow_down_menu.png" alt=">" />
							<ul>
								%5$s
								<li><a href="galerie_photos.php">Galerie</a><img src="images/arrow_down_menu.png" alt=">"/>
									<ul>
										<li><a href="galerie_photos.php">Photos</a></li>
										<li><a href="galerie_videos.php">Vidéos</a></li>
									</ul>
								</li>
							</ul>
						</li>

						%6$s

						<li>
							%7$s
						</li>

						<li>
							%8$s
						</li>
					</ul>
				</div>
			</nav>
		' . PHP_EOL;

	$frag1 = ($isHeaderMenu)?' role="navigation"':'';

	$frag2 = '<li' . (('index' == $sNomDeCettePage && $isHeaderMenu)?' class="activePage"':'');
	$frag2 .= '><a href="index.php"';
	$frag2 .= ($sNomDeCettePage == 'index')?' class="aActiveFix"':'';
	$frag2 .= '>Accueil</a></li>' . PHP_EOL;

	$frag3 = '<li' . (('produits' == $sNomDeCettePage && $isHeaderMenu)?' class="activePage">':'>') . PHP_EOL;

	$frag4 = ($sNomDeCettePage == 'produits')?' aActiveFix':'';

	$frag5 = '';
	foreach($arrCategories AS $index => $details){
		if($index>0){ // Ne pas afficher catégorie "tout", alias "0"
			$frag5 .= tabs(2) . '<li><a href="produits.php?cat=' . $index . '">' . $details['nom'] . '</a></li>' . PHP_EOL;
		}
	}

	$frag6 = '<li' . (('apropos' == $sNomDeCettePage && $isHeaderMenu)?' class="activePage"':'');
	$frag6 .= '><a href="apropos.php"';
	$frag6 .= ($sNomDeCettePage == 'apropos')?' class="aActiveFix"':'';
	$frag6 .= '>À Propos</a></li>' . PHP_EOL;

	$frag7 = '';
	if(!empty($_SESSION['panier'])){
		$frag7 = '
			<div>
				<a href="gestion_panier.php">
					<img src="images/cart.png" alt="panier" />
					<span>' . count($_SESSION['panier']) . '</span>
				</a>
			</div>
		';
	}

	$frag8 = '';
	$return = false;
	// Tester si un usagé est authentifié et s'il est possible de charger ses informations
	if(!empty($_SESSION['user'])){
		$return = chargerUsager($usagertest, $_SESSION['user']);
	}

	if($return !== false){
		$frag8 .= '<a href="#">Bonjour, ' . $_SESSION['user'] . '<img src="images/arrow_down_menu.png" alt="v" /></a>';
		$frag8 .= spawnMonProfilMenu();
	}else{
		$frag8 .= '<a href="authentify.php">Se connecter / s\'enregistrer</a>';
	}

	printf($template,
		$frag1,
		$frag2,
		$frag3,
		$frag4,
		$frag5,
		$frag6,
		$frag7,
		$frag8
	);
} // fin de "spawnMainMenu"


function spawnMonProfilMenu(){
	$menu = '<ul><li><a href="mon_profil.php">Mon Profil</a></li>';

	if($_SESSION['user'] != 'admin'){
		$retour = chargerUsager($arrUsager, $_SESSION['user']);
		if(!empty($arrUsager)){
			$menu .= '<li><a href="gestion_produits_factures.php?nroc=' . $arrUsager[key($arrUsager)]['client_ID'] . '">Mes factures</a></li>';
		}
	}else{
		$menu .= '
			<li><a href="gestion_produits.php">Produits</a></li>
			<li><a href="gestion_produits_inventaire.php">Inventaire</a></li>
			<li><a href="gestion_produits_factures.php">Factures clients</a></li>
		';
	}

	$menu .= '<li><a href="logout.php">Déconnexion</a></li></ul>' . PHP_EOL;

	return $menu;
} // fin de "spawnMonProfilMenu"

/* == EOF == */
