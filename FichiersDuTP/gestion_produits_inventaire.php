<?php
$sPageTitle = "La Fabrique de Jouet - Gestion de l'inventaire";

require_once "assets/inc/csvFunctions.inc.php";

$retour = chargerProduits($arrProduits);

require_once "assets/inc/header.inc.php";

if($retour === false){
	echo '<div id="inventory_box_parent"><span>Le chargement des produits as raté.</span></div>',PHP_EOL;
}else{
	echo '<div id="inventory_box_parent">',PHP_EOL;
	foreach($arrProduits as $iProduct_ID => $arrDonnees){
		$sCategoriesLisibles = categoriesTokensVersNoms($arrDonnees['categories']);

		echo tabs(3),'<div class="inventory_box';
		echo '"><div><img src="',$sImages_PathProduits,$arrDonnees['fichierImage'],'" alt="',$arrDonnees['fichierImage'],'" /></div>';
		echo '<div><ul><li>(',$iProduct_ID,') ',$arrDonnees['nom'],'</li><li>Nombre : ',$arrDonnees['nbrEnInventaire'],'</li><li>Prix : ',$arrDonnees['prix'],'$CDN</li><li>Catégories : ',$sCategoriesLisibles;
		echo '</li><li><a href="gestion_produits.php?actionAFaire=consulter&product_ID=',$iProduct_ID,'">Consulter/Modifier cet item</a></li></ul></div></div>',PHP_EOL;
	}
	echo '</div>',PHP_EOL;
}

require_once "assets/inc/footer.inc.php";
