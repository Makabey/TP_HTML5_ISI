<?php
$sPageTitle = "La Fabrique de Jouet - Gestion des factures";

require_once "assets/inc/csvFunctions.inc.php";
require_once "assets/inc/header.inc.php";

echo tabs(4),'<div id="gestionFactures">',PHP_EOL;

$retour = chargerProduits($arrProduits);
if($retour === false){
	echo 'Une erreur est survenue lors du chargement des produits; impossible de continuer.',PHP_EOL;
}else{
	$retour = chargerFacture($arrFactures);

	if($retour === false){
		echo 'Une erreur est survenue lors du chargement des factures; impossible de continuer.',PHP_EOL;
	}else{
?>
					<table>
						<tr>
							<th id="gpFacture_no">No Facture</th>
							<th id="gpFacture_date">Date d'achat</th>
							<th id="gpFacture_nomclient">Nom du client</th>
							<th class="gpFacture_total">Total (taxes incluse)</th>
							<th id="gpFacture_lien">Détails</th>
						</tr>
						<?php
						$nroLigne = 0;
						foreach($arrFactures as $client_ID => $facture){
							$retour = chargerUsager($client, $client_ID);

							if($retour === false){
								echo '<tr><td colspan="5">Une erreur est survenue lors du chargement du client #',$client_ID,'</td></tr>',PHP_EOL;
							}else{
								if(!empty($client)){
									
									foreach($facture as $facture_ID => $produits){
										$class_fctr = ($nroLigne % 2 == 0)?'odd':'even';
										$total = 0;
										foreach($produits['produits'] as $product_ID => $details){
											if(isset($arrProduits[$product_ID])){ # c'est pas a cette page de dire si ou non un item de la facture est valide!
												$total += ($details['quantite'] * $arrProduits[$product_ID]['prix']);
											}
										}
										$total = ajouterTaxes($total, 2);
										
										echo '<tr class="',$class_fctr,'">',PHP_EOL;
										echo '<td>',str_pad($facture_ID, 6, '0', STR_PAD_LEFT),'</td>';
										echo '<td>',$produits['dateAchat'],'</td>';
										$nomClient = $client[$client_ID]['prenom'].'&nbsp;'.$client[$client_ID]['nomFamille'];
										echo '<td>',ucwords($nomClient),'</td>';
										echo '<td class="gpFacture_total">',number_format($total, 2),'$CDN</td>';
										echo '<td><a href="facture_client.php?oper=consulter&nrof=',$facture_ID,'">Afficher</a></td>';
										echo '</tr>',PHP_EOL;
										$nroLigne++;
									}
								}else{
									echo '<tr><td colspan="5">Le client #',$client_ID," n'existe pas dans la base de données.</td></tr>",PHP_EOL;
								}
							}
						}
						?>
					</table>
<?php
	}
}

echo tabs(4),'</div>',PHP_EOL;

require_once "assets/inc/footer.inc.php";
?>
