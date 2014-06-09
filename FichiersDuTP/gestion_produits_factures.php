<?php
$sPageTitle = "Gestion des factures | ";

require_once "assets/inc/csvFunctions.inc.php";
require_once "assets/inc/header.inc.php";

#echo tabs(4),'<div>',PHP_EOL;

$retour = chargerProduits($arrProduits);
if($retour === false){
	echo 'Une erreur est survenue lors du chargement des produits; impossible de continuer.',PHP_EOL;
}else{
	/*
		si on recoit un parametre, c'est que la page est appellée du choix menu-client "mes factures";
		question sécuritée, c'est de la bouette parce que cette même page est utilisée par les admins,
		sinon pour illustration, ça va!
	*/
	$client_ID  = (isset($_GET['nroc']))?strval($_GET['nroc']):-1;

	$retour = chargerFacture($arrFactures, $client_ID);

	if($retour === false){
		echo 'Une erreur est survenue lors du chargement des factures; impossible de continuer.',PHP_EOL;
	}else{
?>
					<table>
						<tr>
							<th>No Facture</th>
							<th>Date d'achat</th>
							<th>Nom du client</th>
							<th>Total (taxes incluse)</th>
							<th>Détails</th>
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
										#$class_fctr = ($nroLigne % 2 == 0)?'odd':'even';
										$total = 0;
										foreach($produits['produits'] as $product_ID => $details){
											if(isset($arrProduits[$product_ID])){ # c'est pas a cette page de dire si ou non un item de la facture est valide!
												$total += ($details['quantite'] * $arrProduits[$product_ID]['prix']);
											}
										}
										$total = ajouterTaxes($total, 2);
										
										#echo '<tr class="',$class_fctr,'">',PHP_EOL;
										echo '<tr>',PHP_EOL;
										echo '<td>',str_pad($facture_ID, 6, '0', STR_PAD_LEFT),'</td>';
										$dateAchatRemixed = explode(' ',$produits['dateAchat']);
										$dateAchatRemixed[0] = explode('/', $dateAchatRemixed[0]);
										echo '<td><time datetime="',$dateAchatRemixed[0][2],'-',$dateAchatRemixed[0][1],'-',$dateAchatRemixed[0][0],' ',$dateAchatRemixed[1],'">',$produits['dateAchat'],'</time></td>';
										$nomClient = $client[$client_ID]['prenom'].'&nbsp;'.$client[$client_ID]['nomFamille'];
										echo '<td>',ucwords($nomClient),'</td>';
										echo '<td>',number_format($total, 2),'$CDN</td>';
										echo '<td><a href="facture_client.php?oper=consulter&amp;nrof=',$facture_ID,'">Afficher</a></td>';
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

#echo tabs(4),'</div>',PHP_EOL;

require_once "assets/inc/footer.inc.php";
?>
