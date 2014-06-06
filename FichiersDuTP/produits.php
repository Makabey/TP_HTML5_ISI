<?php
require_once "assets/inc/csvFunctions.inc.php";

$sPageTitle = "Produits | ";

# $sDetailsProduits est utilisé dans "header.inc.php" pour le JS
$retour = chargerProduits($arrProduits);
$retour = chargerCategories($arrNomsCategories);

// Relever le numéro de catégorie Max et le ID Max des Produits
$iArrProd_pos = end($arrProduits);
$iArrProd_pos = key($arrProduits);
$maxNomsCat = (count($arrNomsCategories)-1);
$arrGets = array(
	'cat' => array(
		'nom' => 'iProduit_Cat',
		'max' => $maxNomsCat
		),
	'pid' => array(
		'nom' => 'iProduit_ID',
		'max' => $iArrProd_pos
		),
	'qte' => array(
		'nom' => 'iProduit_QTE',
		'max' => 999
		)
	);

/*
	En passant par des variables variable, attribuer soit la valeur trouvée dans $_GET (et vérifier qu'elle ne
	dépasse pas le Max) soit -1 si non trouvé
 */
foreach($arrGets as $get_var => $dtl_var){
	if(array_key_exists($get_var, $_GET)){
		$$dtl_var['nom'] = 0+$_GET[$get_var];
		if($$dtl_var['nom'] < 0) $$dtl_var['nom'] = 0;
		if($$dtl_var['nom'] > $dtl_var['max']) $$dtl_var['nom'] = $dtl_var['max'];
	}else{
		$$dtl_var['nom'] = -1;
	}
}

// Si par hasard le iProduit_ID alias $_GET['pid'] n'existe pas parce qu'il y as un saut de ID dans la table, alors forcer -1
if(!array_key_exists($iProduit_ID, $arrProduits)) $iProduit_ID = -1;

# A cause d'une disparité entre mes fonctions et ici, -1 et 0 veulent tout les deux dire "tout les produits"
if($iProduit_Cat == -1) $iProduit_Cat = 0;

if($iProduit_QTE <1) $iProduit_QTE = 1;

$sPageTitle = $arrNomsCategories[$iProduit_Cat]['nom'] . ' | '. $sPageTitle;

/*
	Si iProduit_ID n'est pas vide, trouver à quelle catégorie l'objet appartient
	et attribuer à iProduit_Cat l'index trouvé
*/
if($iProduit_ID != -1){
	foreach($arrNomsCategories as $key => $val){
		$iPos = stripos($arrProduits[$iProduit_ID]['categories'], $val['token']);
		if($iPos !== false){
			$iProduit_Cat = $key;
			break;
		}
	}
}

$iProdCat = ($iProduit_Cat == 0)?-1:$iProduit_Cat;
$sDetailsProduits = formaterProduitsPourJS($arrProduits, $iProdCat);

require_once "assets/inc/header.inc.php";
?>
			<!--<div id="produits">-->
				<nav id="produits_categories">
					<ul><?php
						echo "\n";
						for($iCmpt=0;$iCmpt<count($arrNomsCategories);$iCmpt++){
							echo tabs(6),'<li>';
							if($iProduit_Cat==$iCmpt){
								$openTag = '<span class="rounded selected">';
								$closeTag = '</span>';
							}else{
								$openTag = '<a class="rounded" href="'.$_SERVER['SCRIPT_NAME'].'?cat='.$iCmpt.'">';
								$closeTag = '</a>';
							}
							echo $openTag,$arrNomsCategories[$iCmpt]['nom'],$closeTag,"</li>\n";
						}
					?>
					</ul>
				</nav>
				<div id="produits_infos">
					<!--<div id="produits_infos_pic">-->
						<img id="produits_infos_img" src="assets/images/produits/broken_toy.jpg" alt="Catégorie vide" title="Catégorie vide" />
					<!--</div>
					<div id="produits_infos_dl">-->
						<dl>
							<dt>Nom : </dt>
							<dd id="produits_infos_nom"></dd>
							<dt>Matériaux : </dt>
							<dd id="produits_infos_mats"></dd>
							<dt>Couleurs disponibles : </dt>
							<dd id="produits_infos_clrdispo"></dd>
							<dt>Disponibilitée : </dt>
							<dd id="produits_infos_nbrdispo"></dd>
							<dt>Prix unitaire : </dt>
							<dd id="produits_infos_prix"></dd>
							<dt>Description : </dt>
							<dd id="produits_infos_desc"></dd>
						</dl>
					<!--</div>-->
					<div id="produits_infos_btns">
						<button type="button" id="prod_btnPrev" class="rounded">&lt; Précédent</button>
						<button type="button" id="prod_btnNext" class="rounded">Suivant &gt;</button>
					</div>
					<?php if(isset($_SESSION['user'])){ ?>
					<div id="produits_infos_ajouterpanier">
						<label>Quantitée : <input type="text" maxlength="4" id="produits_infos_prodqte" value="<?php echo $iProduit_QTE; ?>" /></label>
						<img class="cursor_hand icons_basket" id="produits_infos_prodid" src="assets/images/shopping-cart-add1.png" alt="Ajouter au panier" title="Ajouter au panier" />
					</div>
					<?php } ?>
				</div>
			<!--</div>-->
<?php
require_once "assets/inc/footer.inc.php";
?>
