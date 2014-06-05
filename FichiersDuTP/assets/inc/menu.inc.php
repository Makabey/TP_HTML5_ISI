<?php
if(false === function_exists('genererMenuTopItem')){
	// La definition doit se faire ici et ne peux l'etre plus d'une fois
	function genererMenuTopItem($nomMenu){
		// Crée le titre du menu passé pour utiliser les bonnes classes CSS selon si ou non on est sur la page correspondant à $nomMenu
		global $MenusID;
		global $sNomDeCettePage;

		$retour = '<li';
		$retour .= ' id="'. $MenusID . $nomMenu . '"';
		if(($sNomDeCettePage == $nomMenu) && ($MenusID == 'header_')){
			$retour .= ' class="activePage"';
		}
		$retour .= '>' . PHP_EOL;

		return $retour;
	}
}

#require_once "assets/inc/arrays.inc.php";
require_once "assets/inc/csvFunctions.inc.php";
$retour = chargerCategories($arrCategories);
?>
<<<<<<< HEAD
					<nav role="navigation" id="<?php echo $MenusID; ?>menu">
						<ul>
=======
					<nav id="<?php echo $MenusID; ?>menu">
						<ul id="<?php echo $MenusID; ?>menuNiv1">
>>>>>>> f8fca89d2fe2cd3c722e3262254e5531f9a6bb1a
							<?php echo genererMenuTopItem('index'); ?>
								<a href="index.php"<?php if($sNomDeCettePage == 'index') echo ' class="aActiveFix"'; ?>>Accueil</a>
							</li>
							<?php echo genererMenuTopItem('produits'); ?><span class="spanFix_li_hover<?php if($sNomDeCettePage == 'produits') echo ' aActiveFix'; ?>">Catégories</span>
								<ul id="<?php echo $MenusID; ?>menuNiv1_Item1_submenu2">
									<?php
									foreach($arrCategories as $index => $details){
										if($index>0){ # Ne pas afficher catégorie "tout", alias "0"
											echo tabs(2),'<li><a href="produits.php?cat=',$index,'">',$details['nom'],'</a></li>',PHP_EOL;
										}
									}
									?>
								</ul>
							</li>
							<?php echo genererMenuTopItem('apropos'); ?>
								<a href="apropos.php"<?php if($sNomDeCettePage == 'apropos') echo ' class="aActiveFix"'; ?>>À Propos</a>
							</li>
							<?php
								#If(isset($_SESSION['user']) && ($_SESSION['user'] != 'admin')){
								If(isset($_SESSION['user'])){
							?>
							<?php echo genererMenuTopItem('gestion_profil'); ?>
								<a href="monprofil.php"<?php if($sNomDeCettePage == 'gestion_profil') echo ' class="aActiveFix"'; ?>>Mon Profil</a>
							</li>
							<?php } ?>
							<?php If(isset($_SESSION['user']) && ($_SESSION['user'] == 'admin')){ ?>
							<?php echo genererMenuTopItem('gestion_produits'); ?><span class="spanFix_li_hover<?php if($sNomDeCettePage == 'gestion_produits') echo ' aActiveFix'; ?>">Gestion</span>
								<ul id="<?php echo $MenusID; ?>menuNiv1_Item1_submenu6">
									<li><a href="gestion_produits.php">Produits</a></li>
									<li><a href="gestion_produits_inventaire.php">Inventaire</a></li>
									<li><a href="gestion_produits_factures.php">Factures clients</a></li>
								</ul>
							</li>
							<?php } ?>
						</ul>
					</nav>
					<div class="clearFloat"></div>
