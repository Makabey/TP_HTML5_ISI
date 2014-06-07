<?php
$sPageTitle = "Gestion des produits | ";

require_once "assets/inc/csvFunctions.inc.php";

// Éléments de $_GET qui doivent avoir un défaut numérique
if(!array_key_exists('product_ID', $_GET)) $_GET['product_ID'] = -1;
// Éléments de $_GET qui doivent avoir un défaut chaine
$elementsGetChaine = array('actionAFaire', 'nom', 'prix', 'nbrEnInventaire', 'fichierImage', 'description');
foreach($elementsGetChaine as $element){
	if(!array_key_exists($element, $_GET)) $_GET[$element] = '';
}
// Éléments de $_GET qui doivent être des tableaux
$elementsGetTbl = array('categories', 'couleurs', 'materiaux');
for($iCmpt=0;$iCmpt<3;$iCmpt++){
	if(!array_key_exists($elementsGetTbl[$iCmpt], $_GET)) $_GET[$elementsGetTbl[$iCmpt]] = array();
}

$sErreurEcriture = '';
if($_GET['product_ID'] != -1){
	$retour = ecrireCSV_VersTblIdx($_GET, 'assets/res/table_produits.csv');
	if($retour === false){
		$sErreurEcriture = "<div>L'item #" . $_GET['product_ID'] . " n'as pas pu être écris.</div>" . PHP_EOL;
	}
}

$retour = chargerProduits($arrProduits);

// Cet appel sert à initialiser l'Array JS pour l'affichage des Produits
$sDetailsProduits = formaterProduitsPourJS($arrProduits);

if($_GET['actionAFaire'] == 'consulter'){
	if(array_key_exists($_GET['product_ID'], $arrProduits)){
		$_GET = array_merge($_GET, $arrProduits[$_GET['product_ID']]);

		// Éléments de $_GET qui doivent être des tableaux
		for($iCmpt=0;$iCmpt<3;$iCmpt++){
			$_GET[$elementsGetTbl[$iCmpt]] = explode('¤', $_GET[$elementsGetTbl[$iCmpt]]);
		}
	}else{
		$_GET['product_ID'] = -1;
	}
}

require_once "assets/inc/header.inc.php";

echo $sErreurEcriture;
?>
				<div id="GestionProduits">
					<form id="formGestionProduits" method="get" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
						<legend>Gestion des produits</legend>
						<fieldset id="gestion_fiche">
							<caption>Fiche :</caption>
							<input type="hidden" id="actionAFaire" name="actionAFaire" />
							<ul>
								<li>
									<ul>
										<li><label for="product_ID">ID du produit :</label></li>
										<li>
											<select id="product_ID" name="product_ID" title="géré automatiquement">
												<?php
													$cle=-1;
													if(!empty($arrProduits)){
														foreach($arrProduits as $cle => $produit){
															echo '<option value="',$cle;
															echo ($_GET['product_ID'] == $cle)?'" selected="selected">':'">';
															echo str_pad($cle,3,'0',STR_PAD_LEFT),' (',$produit['nom'],')</option>',PHP_EOL;
														}
													}
													$cle++;
													echo '<option value="',$cle;
													echo ($_GET['product_ID'] == -1)?'" selected="selected':'';
													echo '">',str_pad($cle,3,'0',STR_PAD_LEFT),' (Nouveau)</option>',PHP_EOL;
												?>
											</select>
										</li>
									</ul>
								</li>
								<li>
									<ul>
										<li><label for="nom">Nom :</label></li>
										<li><input type="text" id="nom" name="nom" title="Nom entre 3 et 25 caractères" size="25" value="<?php echo $_GET['nom']; ?>" /></li>
									</ul>
								</li>
								<li>
									<ul>
										<li><label for="prix">Prix :</label></li>
										<li><input type="text" id="prix" name="prix" title="format préféré : 5.2 ex: 31275.98" value="<?php echo $_GET['prix']; ?>" /></li>
									</ul>
								</li>
								<li>
									<ul>
										<li><label for="nbrEnInventaire">Nombre en inventaire :</label></li>
										<li><input type="text" id="nbrEnInventaire" name="nbrEnInventaire" title="Entre 0 et 32767" value="<?php echo $_GET['nbrEnInventaire']; ?>" /></li>
									</ul>
								</li>
								<li>
									<ul>
										<li><label for="gestion_fiche_description">Description :</label></li>
										<li><textarea id="gestion_fiche_description" name="description" title="Entre 3 et 240 caractères" cols="100" rows="7"><?php echo $_GET['description']; ?></textarea></li>
									</ul>
								</li>
								<!-- accept="image/*" n'est pas une validation mais une petite restriction/guide! -->
								<li>
									<ul>
										<li><label for="fichierImage_browse">Image :</label></li>
										<li><input type="file" id="fichierImage_browse" accept="image/*" />
											<input type="hidden" id="fichierImage" name="fichierImage" value="<?php echo $_GET['fichierImage']; ?>"/>
											<img id="imageProduit"<?php if(strlen($_GET['fichierImage'])) echo ' src="',$sImages_PathProduits,$_GET['fichierImage'],'"'; ?> /></li>
									</ul>
								</li>
							</ul>
						</fieldset>
						<fieldset class="gestion_fiche_choix">
							<caption>Catégories :</caption>
							<ul id="checks_categories">
								<?php
									if(false === chargerCategories($arrCategories)){
										echo '<li>Erreur lors de la lecture du fichier "Catégories"</li>',PHP_EOL;
									}else{
										foreach($arrCategories as $cle => $categorie){
											if($cle > 0){ # La catégorie 0 est "TOUT", inutile de la voir, un item n'est pas supposé de faire parti de TOUT, cette catégorie est là seulement pour pouvoir tout afficher dans la page produits/catégorie
												echo '<li><label><input type="checkbox" id="categories',$cle,'" name="categories[]" value="',$categorie['token'];
												echo (in_array($categorie['token'], $_GET['categories']))?'" checked="checked':'';
												echo '" />',$categorie['nom'],'</label></li>',PHP_EOL;
											}
										}
									}
								?>
							</ul>
						</fieldset>
						<fieldset class="gestion_fiche_choix">
							<caption>Couleurs :</caption>
							<ul id="checks_couleurs">
								<?php
									if(false === chargerCouleurs($arrCouleurs)){
										echo '<li>Erreur lors de la lecture du fichier "Couleurs"</li>',PHP_EOL;
									}else{
										foreach($arrCouleurs as $cle => $couleur){
											echo '<li><label><input type="checkbox" id="couleurs',$cle,'" name="couleurs[]" value="',$couleur['html'];
											echo (in_array($couleur['html'], $_GET['couleurs']))?'" checked="checked':'';
											echo '" />',$couleur['nom'],'</label></li>',PHP_EOL;
										}
									}
								?>
							</ul>
						</fieldset>
						<fieldset class="gestion_fiche_choix">
							<caption>Matériaux :</caption>
							<ul id="checks_materiaux">
								<?php
									if(false === chargerMateriaux($arrMateriaux)){
										echo '<li>Erreur lors de la lecture du fichier "Matériaux"</li>',PHP_EOL;
									}else{
										foreach($arrMateriaux as $cle => $materiaux){
											echo '<li><label><input type="checkbox" id="materiaux',$cle,'" name="materiaux[]" value="',$materiaux['nom'];
											echo (in_array($materiaux['nom'], $_GET['materiaux']))?'" checked="checked':'';
											echo '" />',$materiaux['nom'],'</label></li>',PHP_EOL;
										}
									}
								?>
							</ul>
						</fieldset>
						<fieldset>
							<input type="button" class="frmGP_Btns" id="btnEnregistrer" value="Enregistrer" />
							<input type="button" class="frmGP_Btns" id="btnEffacer" value="Effacer" />
						</fieldset>
					</form>
				</div>
<?php
require_once "assets/inc/footer.inc.php";
?>
