<?php
/*
	Refonte du fichier où je construit 2 menus différents selon si c'est celui du NAV/Footer ou de LOGIN
*/
require_once "assets/inc/csvFunctions.inc.php";

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
								<?php
								foreach($arrCategories as $index => $details){
									if($index>0){ # Ne pas afficher catégorie "tout", alias "0"
										echo tabs(2),'<li><a href="produits.php?cat=',$index,'">',$details['nom'],'</a></li>',PHP_EOL;
									}
								}
								?>
								<li><a href="galerie_photos.php">Galerie</a><img src="assets/images/arrow_down_menu.png" alt=">"/>
									<ul>
										<li><a href="galerie_photos.php">Photos</a></li>
										<li><a href="galerie_videos.php">Vidéos</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<?php echo genererMenuTopItem('apropos'); ?>
							<a href="apropos.php"<?php if($sNomDeCettePage == 'apropos') echo ' class="aActiveFix"'; ?>>À Propos</a>
						</li>
						<li>
							<?php
								if((isset($_SESSION['panier'])) && (!empty($_SESSION['panier']))){
										echo '<div><a href="gestion_panier.php">';
										$nombreItems = count($_SESSION['panier']);
										echo '<img src="assets/images/cart.png" alt="panier" /><span>',$nombreItems,'</span>';
										echo '</a></div>';
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
									$userFullName = $_SESSION['user'];
									echo '<span>Bonjour, ',$userFullName,'</span><img src="assets/images/arrow_down_menu.png" alt=">" />';
									spawnMonProfilMenu();
								}else{
									echo '<a href="authentify.php">Se connecter / s\'enregistrer</a>';
								}
								echo PHP_EOL;
							?>
						</li>
					</ul>
				</div>
			</nav>
	<?php
	} # fin de "spawnMainMenu"


function spawnMonProfilMenu(){
?>
	<ul>
		<li><a href="mon_profil.php">Mon Profil</a></li>
		<?php
		$retour = chargerUsager($arrUsager, $_SESSION['user']);
		if((false !== $retour) && ($_SESSION['user'] != 'admin')){
			echo '<li><a href="gestion_produits_factures.php?nroc=', $arrUsager[key($arrUsager)]['client_ID'], '">Mes factures</a></li>', PHP_EOL;
		}

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


function genererMenuTopItem($nomMenu){
	// Crée le titre du menu passé pour utiliser les bonnes classes CSS selon si ou non on est sur la page correspondant à $nomMenu
	global $MenusID;
	global $sNomDeCettePage;

	$retour = '<li';
	if(($sNomDeCettePage == $nomMenu) && ($MenusID == 'header_')){
		$retour .= ' class="activePage"';
	}
	$retour .= '>' . PHP_EOL;

	return $retour;
}

/* == EOF == */
