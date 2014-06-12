<?php
/*
	Refonte du fichier où je construit 2 menus différents selon si c'est celui du NAV/Footer ou de LOGIN
*/
require_once "assets/inc/csvFunctions.inc.php";

#if(false === function_exists('spawnMainMenu')){
	function spawnMainMenu(){
		global $MenusID;
		global $sNomDeCettePage;
		$retour = chargerCategories($arrCategories);
?>
						<nav<?php if($MenusID == 'header_') echo ' role="navigation"'; ?>>
							<div class="centrerMenu">
								<ul>
									<?php echo genererMenuTopItem('index'); ?>
										<a href="index.php"<?php if($sNomDeCettePage == 'index') echo ' class="aActiveFix"'; ?>>Accueil</a>
									</li>
									<?php echo genererMenuTopItem('produits'); ?><span class="spanFix_li_hover<?php if($sNomDeCettePage == 'produits') echo ' aActiveFix'; ?>">Catalogue</span><img src="assets/images/arrow_down_menu.png" alt=">" />
										<ul>
											<!--<li>Catégories<img src="assets/images/arrow_down_menu.png" alt=">" />-->
												<!--<ul>-->
													<?php
													foreach($arrCategories as $index => $details){
														if($index>0){ # Ne pas afficher catégorie "tout", alias "0"
															echo tabs(2),'<li><a href="produits.php?cat=',$index,'">',$details['nom'],'</a></li>',PHP_EOL;
														}
													}
													?>
												<!--</ul>-->
											<!--</li>-->
											<!--<li><a href="galerie.php">Galerie</a></li>-->
											<li><a href="galerie_photos.php">Galerie</a><img src="assets/images/arrow_down_menu.png" alt=">"/>
												<ul>
													<li><a href="galerie_photos.php">Photos</a></li>
													<li><a href="galerie_videos.php">Vidéos</a></li>
												</ul>
											</li>
										</ul>
									</li>
										<?php
											#If(isset($_SESSION['user']) && ($_SESSION['user'] != 'admin')){
											/*If(isset($_SESSION['user'])){
												echo genererMenuTopItem('gestion_profil');
											?><span class="spanFix_li_hover<?php if($sNomDeCettePage == 'gestion_profil') echo ' aActiveFix'; ?>">Mon Profil</span>
											<?php spawnMonProfilMenu(); ?>
											</li>
											<?php } */?>
											<?php echo genererMenuTopItem('apropos'); ?>
											<a href="apropos.php"<?php if($sNomDeCettePage == 'apropos') echo ' class="aActiveFix"'; ?>>À Propos</a>
										</li>
										<li>
											<?php
												if((isset($_SESSION['panier'])) && (!empty($_SESSION['panier']))){
														echo '<div><a href="gestion_panier.php">';
														$nombreItems = count($_SESSION['panier']);
														echo "$nombreItems</a></div>";
													}
											?>
										</li>
										<li>
											<?php
												$return = false;
												// Tester si un usagé est authentifié et s'il est possible de charger ses informations
												if(isset($_SESSION['user'])){
													$return = chargerUsager($usagertest, $_SESSION['user']);
												}

												if($return !== false){
													#$client_ID = key($usagertest);
													#$userFullName = ucwords($usagertest[$client_ID]['prenom'] . ' ' . $usagertest[$client_ID]['nomFamille']);
													#var_dump($_SESSION['user']);
													#var_dump($userFullName);
													#if(strlen($userFullName) < 3){
														$userFullName = $_SESSION['user'];
													#}
													echo '<span>Bonjour, ',$userFullName,'</span><img src="assets/images/arrow_down_menu.png" alt=">"/>';
													spawnMonProfilMenu();
													else{
															/*echo'<div>&nbsp;</div>';*/
														}
														#echo '<div><a href="logout.php">Déconnexion</a></div>';
													}
													else{
														echo '<a href="authentify.php">Se connecter / s\'enregistrer</a>';
													}
												echo PHP_EOL;
											?>
										</li>
								</ul>
							</div>
						</nav>
						<!--<div class="clearFloat"></div>-->
	<?php
	} # fin de "spawnMainMenu"
#}

#if(false === function_exists('spawnMonProfilMenu')){
	function spawnMonProfilMenu(){
	?>
		<ul>
			<li><a href="mon_profil.php">Mon Profil</a></li>
			<?php
			$retour = chargerUsager($arrUsager, $_SESSION['user']);
			if((false !== $retour) &&  ($_SESSION['user'] != 'admin')){
				echo '<li><a href="gestion_produits_factures.php?nroc=', $arrUsager[key($arrUsager)]['client_ID'], '">Mes factures</a></li>', PHP_EOL;
			}
			?>
			<?php
			If($_SESSION['user'] == 'admin'){
			?>
				<li><a href="gestion_produits.php">Produits</a></li>
				<li><a href="gestion_produits_inventaire.php">Inventaire</a></li>
				<li><a href="gestion_produits_factures.php">Factures clients</a></li>
			<?php
				}
			 ?>
			<li><a href="logout.php">Déconnexion</a></li>
		</ul>
	<?php
	} # fin de "spawnMonProfilMenu"
#}

#if(false === function_exists('genererMenuTopItem')){
	// La definition doit se faire ici et ne peux l'etre plus d'une fois
	function genererMenuTopItem($nomMenu){
		// Crée le titre du menu passé pour utiliser les bonnes classes CSS selon si ou non on est sur la page correspondant à $nomMenu
		global $MenusID;
		global $sNomDeCettePage;

		$retour = '<li';
		#$retour .= ' id="'. $MenusID . $nomMenu . '"';
		if(($sNomDeCettePage == $nomMenu) && ($MenusID == 'header_')){
			$retour .= ' class="activePage"';
		}
		$retour .= '>' . PHP_EOL;

		return $retour;
	}
#}
