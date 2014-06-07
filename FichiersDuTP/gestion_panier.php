<?php
$sPageTitle = "Votre panier | ";
require_once "assets/inc/csvFunctions.inc.php";

session_start();

function mettreAJourQuantitePanier(){
	// Ici on lit les quantité qui étaient sur la page et on met à jour $_SESSION
	foreach($_SESSION['panier'] as $pid => $details){
		// Si la quantité est 0 ou NULL alors on retire le produit du panier.
		if(($_POST['panierQte_'.$pid] == 0)){
			unset($_SESSION['panier'][$pid]);
		}else{
			$_SESSION['panier'][$pid]['quantite'] = $_POST['panierQte_'.$pid];
		}
	}

	$retour = array(
		'pid' => $pid,
		'qte' => $_POST['panierQte_'.$pid]
		);

	return $retour;
}

if(isset($_SESSION['user'])){
	$charger_produits = chargerProduits($produits_charger);
	$retour = chargerCouleurs($couleurs);

	//panier client
	if(!isset($_SESSION['panier'])){
		$_SESSION['panier'] = array();
	}

	if('POST' == $_SERVER['REQUEST_METHOD']){
		$operation = (isset($_POST['oper']))?$_POST['oper']:null;
		$produits = (isset($_POST['pid']))?$_POST['pid'] : null;
	}else{
		// variables de traitement des operation ajout/suppression de produits dans le panier
		$operation = (isset($_GET['oper']))?$_GET['oper'] : null;
		$produits = (isset($_GET['pid']))?$_GET['pid'] : null;
		$quantite = (isset($_GET['qte']))?$_GET['qte'] : null;
		$couleur = (isset($_GET['clr']))?$_GET['clr'] : null;
	}

	if(isset($operation)){
		switch($operation){
			case 'ajout' :
					if(isset($produits)){
						$_SESSION['panier'][$produits] = array(
								'quantite' => $quantite,
								'couleur' => $couleur
								);
					}
			break;
			case 'retirer' :
					// Juste au cas ou le client as changé une quantite, enregistrer
					$retour = mettreAJourQuantitePanier();

					if(isset($produits)){
						unset($_SESSION['panier'][$produits]);
					}
					
					if(empty($_SESSION['panier'])){
						header("Location:produits.php");
						exit();
					}
			break;
			case 'vider' :
				$_SESSION['panier'] = null;
				header("Location:produits.php");
				exit();
			break;

			case 'magasiner': // L'usager as cliqué le lien "Continuer de magasiner"
				$retour = mettreAJourQuantitePanier();

				header("Location:produits.php?pid={$retour['pid']}&qte={$retour['qte']}");
				exit();
			break;

			case 'facturer': // L'usager as cliqué l'icône "Payer"
				$retour = mettreAJourQuantitePanier();

				$retour = chargerUsager($data_user, $_SESSION['user']);

				if($retour !== false){
					$retour = ecrireFacture($_SESSION['panier'], $data_user[key($data_user)]['client_ID']);
				}

				if($retour !== false){
					$_SESSION['panier'] = null;
					$dnrFacture = lireCompteur('facture_ID');
					header("Location:facture_client.php?oper=payer&nrof=".$dnrFacture);
					exit();
				}
			break;
		}
	}

	require_once "assets/inc/header.inc.php";

	if((isset($_SESSION['panier'])) && (!empty($_SESSION['panier']))){
?>
	<!-- Tableau d'affichage de la liste de produits dans le panier -->
	<form id="frmPanier" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
		<input id="oper" name="oper" value="" type="hidden" />
		<input id="pid" name="pid" value="" type="hidden" />
		<table id="itemsDuClient">
			<caption>Votre panier</caption>
			<tr>
				<th>ID</th>
				<th>Produit</th>
				<th>Couleur</th>
				<th>Prix</th>
				<th>Quantitée</th>
				<th>&nbsp;</th>
			</tr>
			<?php
					// boucle d'affichage du panier
					#$odd_even_row = 'odd';
					foreach($_SESSION['panier'] as $pid => $details){
						#echo '<tr class="',$odd_even_row,'">
						/*echo '
							<tr class="rangeeItem">
								<td class="listePanier_ID">',$pid,'</td>
								<td class="listePanier_PROD">',$produits_charger[$pid]['nom'],'</td>
								<td class="listePanier_CLR">',couleursTokensVersNoms($details['couleur']),'</td>
								<td class="listePanier_PRIX">',number_format($produits_charger[$pid]['prix'], 2),'$CDN</td>
								<td class="listePanier_QTE"><input type="text" class="panier_qte_input" name="panierQte_',$pid,'" value="',$details['quantite'],'" maxlength="4" /></td>
								<td class="listePanier_BTN"><img src="assets/images/cross.png" class="panier_retirer cursor_hand" alt="Retirer cet item" title="Retirer cet item" data-pid="',$pid,'" /></td>
							</tr>
						';*/
						echo '
							<tr class="rangeeItem">
								<td>',$pid,'</td>
								<td>',$produits_charger[$pid]['nom'],'</td>
								<td>',couleursTokensVersNoms($details['couleur']),'</td>
								<td>',number_format($produits_charger[$pid]['prix'], 2),'$CDN</td>
								<td><input type="number" class="panier_qte_input" name="panierQte_',$pid,'" value="',$details['quantite'],'" min="1" max="99" /></td>
								<td><img src="assets/images/cross.png" class="panier_retirer cursor_hand" alt="Retirer cet item" title="Retirer cet item" data-pid="',$pid,'" /></td>
							</tr>
						';
						#$odd_even_row	= ($odd_even_row == 'odd')?'even':'odd';
					}
			?>
			<!--<tr><td colspan="7">&nbsp;</td></tr>-->
			<tr><td class="textright" colspan="3">Sous-total : </td><td class="textright"><output class="textright" id="listePanierSousTotal"><?php echo number_format($panierSousTotal, 2),'$CDN'; ?></output></td><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td colspan="3"><span id="listePanier_Magasiner" class="cursor_hand">&lt;-- Continuer de magasiner.</span></td>
				<td id="listePanier_Payer" colspan="2"><img class="cursor_hand icons_basket" id="gp_Payer" alt="Payer" title="Payer" src="assets/images/shopping-cart-buy.png" /></td>
				<td id="listePanier_Vider"><img class="cursor_hand icons_basket" id="gp_Vider" alt="Vider le panier" title="Vider le panier" src="assets/images/shopping-cart-remove.png" /></td>
			</tr>
		</table>
	</form>
<?php
	}else{
		echo '<h2>Désolé, votre panier est vide. <a href="produits.php">Retourner au catalogue...</a></h2>';
	}

# FIN DE if(isset($_SESSION['user']))
}else{
	require_once "assets/inc/header.inc.php";

	echo '<h2>Désolé, les fonctionnalitées de cette page ne sont pas disponible si vous n\'êtes pas authentifié.</h2>';
}

require_once "assets/inc/footer.inc.php";
?>
