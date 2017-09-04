<?php

$sPageTitle = "Facture client ";

require_once "inc/csvFunctions.inc.php";
require_once "inc/header.inc.php";

if(isset($_GET['nrof'])){
	// On recoit deux code d' "OPER" mais en fin de compte un seul ou pas du tout ferais l'affaire
	$nrof = $_GET['nrof'];
	$retour = chargerFacture($arrItems, $nrof);

	if(false === $retour){
		echo '<h2>Une erreur est survenue lors de la lecture de la facture, nous en sommes désolés.</h2>';
	}else{
		if(0 == $retour){
			echo "<h2>Désolé, la facture demandée n'existe pas.</h2>";
		}else{
			$client_ID = key($arrItems) ;
			$arrFacture = $arrItems[$client_ID][$nrof];
			$retour = chargerUsager($usager, $client_ID);

			if(empty($usager)){
				echo '<h2>Une erreur est survenue lors de la lecture de la facture, nous en sommes désolés.[Erreur #4]</h2>';
			}else{
				$usager = $usager[$client_ID];
				$retour = chargerProduits($produits_charger);
				if(false === $retour){
					echo '<h2>Une erreur est survenue lors de la lecture de la facture, nous en sommes désolés.[Erreur #3]</h2>';
				}else{
?>
		<table>
			<tr><td>Facture #</td><td><?=str_pad($nrof, 6, '0', STR_PAD_LEFT)?></td></tr>
			<tr><td>Achats faits le</td><td><?=$arrFacture['dateAchat']?></td></tr>
			<tr><td>Par</td><td><?php
				if(!empty($usager['prenom']) || !empty($usager['nomFamille']))
					echo trim($usager['prenom'] . ' ' . $usager['nomFamille']) . ' / ';

				if(!empty($usager['adresse']))
					echo trim($usager['adresse'] . ' / ');

				echo $usager['email'];
			?></td></tr>
		</table>
		<table>
			<tr>
				<th>ID</th>
				<th>Produit</th>
				<th>Couleur</th>
				<th>Prix</th>
				<th>Quantitée</th>
				<th>Total</th>
			</tr>
			<?php
					$sousTotal = 0;
					$total = 0;
					$taxes = 0;
					// boucle d'affichage du panier
					foreach($arrFacture['produits'] as $pid => $details){
						$sommeItem=$details['quantite'] * $produits_charger[$pid]['prix'];
						$sousTotal += $sommeItem;
						echo '
							<tr class="rangeeItem">
								<td>',str_pad($pid, 6, '0', STR_PAD_LEFT),'</td>
								<td>',$produits_charger[$pid]['nom'],'</td>
								<td>',couleursTokensVersNoms($details['couleurs']),'</td>
								<td>',number_format($produits_charger[$pid]['prix'], 2),'$ CDN</td>
								<td>',$details['quantite'],'</td>
								<td>',number_format($sommeItem, 2),'$ CDN</td>
							</tr>
						';
					}
					$taxes = calculerTaxes($sousTotal);
					$total = round($sousTotal + $taxes, 2);
					$taxes = round($taxes, 2);
			?>
			<tr><td colspan="6">&nbsp;</td></tr>
			<tr><td colspan="4">&nbsp;</td><td>Sous-Total</td><td class="listePanier_TTL"><?=number_format($sousTotal, 2),'$ CDN'?></tr>
			<tr><td colspan="4">&nbsp;</td><td>Taxes</td><td class="listePanier_TTL"><?=number_format($taxes, 2),'$ CDN'?></tr>
			<tr><td colspan="4">&nbsp;</td><td>Total</td><td class="listePanier_TTL"><?=number_format($total, 2),'$ CDN'?></tr>
			<?php if(isset($_SESSION['user']) && ($_SESSION['user'] != 'admin')){ ?>
			<tr><td colspan="6">&nbsp;</td></tr>
			<tr><td colspan="6"><a href="produits.php" class="btn">Retourner au catalogue</a></td></tr>
			<?php } ?>
		</table>
<?php
				}
			}
		}
	}
}else{
	echo '<h2>(2)Une erreur est survenue lors de la lecture de la facture, nous en sommes désolés.</h2>';
}

require_once "inc/footer.inc.php";
