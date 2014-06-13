<?php
session_start();
if(!isset($_SESSION['user'])){
	header("Location:index.php");
	#header("Location:".$_SERVER['REFERER']);
	exit();
}

$sPageTitle = "Mon profil | ";

require_once "assets/inc/csvFunctions.inc.php";
require_once "assets/inc/header.inc.php";

$retour = chargerUsager($arrUsager, $_SESSION['user']);
if(false !== $retour){
	$arrUsager = $arrUsager[key($arrUsager)];
}else{
	$arrUsager['nom'] = $_SESSION['user'];
	$arrUsager['password'] = "123456";
	$arrUsager['email'] = "personne@domaine.com";
}

/*
	Il n'y as aucune validation, aucun traitement
	parce que ce n'est pas le but de l'exercice!
*/
?>
			<h1>Mon Profil</h1>

			<div class="boiteMessagesFormulaires hidden" id="boiteMessagesFormulaires"><span>Merci, vos changements ont été enregistrés.</span></div>
			<div id="loginDiv">
				<form id="formIdentite" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
					<fieldset>
						<legend>Votre identitée</legend>
						<ul>
							<li><span>Votre identifiant :</span><input type="text" disabled="disabled" value="<?php echo $_SESSION['user']; ?>" /></li>
							<li><label for="prenom">Votre prénom :</label><input id="prenom" name="prenom" type="text" placeholder="3 à 24 caractères" pattern="[A-Z][a-zA-Z]{2,25}" title="Majuscule suivie d'au plus 25 charactères" /></li>
							<li><label for="nomFamille">Votre nom :</label><input id="nomFamille" name="nomFamille" type="text" placeholder="2 à 24 caractères" pattern="[A-Z][a-zA-Z]{1,25}" title="Majuscule suivie d'au plus 25 charactères" /></li>
							<li><label for="adresse">Votre adresse civique :</label><input id="adresse" name="adresse" type="text" placeholder="111111, rue du finfin, #1A" pattern="[0-9]{1,6},?\ ?[a-zA-Z\.\ ]{3,30},?\ ?#?[0-9A-Z]{1,5}" title="Numéro civique, rue et appartement; au plus 40 charactères" /></li>
							<li><label for="courriel">Votre courriel :</label><input id="courriel" name="courriel" type="email" required="required" placeholder="utilisateur@domaine.com" value="<?php echo $arrUsager['email']; ?>" /></li>
							<li><span>Vous êtes : </span>
								<ul>
									<li><input id="genreF" name="genre" type="radio" value="femme" /><label for="genreF">Une femme</label></li>
									<li><input id="genreH" name="genre" type="radio" value="homme" /><label for="genreH">Un homme</label></li>
									<li><input id="genreA" name="genre" type="radio" value="secret" checked="checked" /><label for="genreA">Secret</label></li>
								</ul>	
							</li>
						</ul>
						<button type="submit">Enregistrer</button>
					</fieldset>
				</form>

				<form id="formInfosCredits" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
					<fieldset>
						<legend>Vos informations de crédit</legend>
						<ul>
							<li><span>Adresse de livraison : </span>
								<ul>
									<li><input id="choixAdresseLivraison1" name="choixAdresseLivraison" type="radio" value="principale" checked="checked" /><label for="choixAdresseLivraison1">Idem que principale</label></li>
									<li><input id="choixAdresseLivraison2" name="choixAdresseLivraison" type="radio" value="autre" /><input id="adresseLivraisonAutre" name="adresseLivraisonAutre" type="text" placeholder="111111, rue du finfin, #1A" pattern="[0-9]{1,6},?\ ?[a-zA-Z\.\ ]{3,30},?\ ?#?[0-9A-Z]{1,5}" title="Numéro civique, rue et appartement; au plus 40 charactères" /></li>
								</ul>
							</li>
							<li><span>Mode de paiement : </span>
								<ul>
									<li><input id="mpCC_Visa" name="modePaiement" type="radio" value="cc_visa" checked="checked" /><label for="mpCC_Visa"><img src="assets/images/paiement/visa-curved-32px.png" alt="icone carte de crédit Visa" /></label></li>
									<li><input id="mpCC_MasterC" name="modePaiement" type="radio" value="cc_mastercard" /><label for="mpCC_MasterC"><img src="assets/images/paiement/mastercard-curved-32px.png" alt="icone carte de crédit MasterCard" /></label></li>
									<li><input id="mpCC_Discover" name="modePaiement" type="radio" value="cc_discover" /><label for="mpCC_Discover"><img src="assets/images/paiement/discover-curved-32px.png" alt="icone carte de crédit discover" /></label></li>
									<li><input id="mpITN_Paypal" name="modePaiement" type="radio" value="itn_Paypal" /><label for="mpITN_Paypal"><img src="assets/images/paiement/paypal-curved-32px.png" alt="icone internet paypal" /></label></li>
								</ul>
							</li>
							<li><label for="mpCC_INT_Nro">Numéro de carte ou de compte :</label><input id="mpCC_INT_Nro" name="mpCC_INT_Nro" type="text" required="required" placeholder="12 chiffres" pattern="[0-9]{3}\ ?[0-9]{3}\ ?[0-9]{3}\ ?[0-9]{3}" maxlength="15" title="12 chiffres avec ou sans espaces" autocomplete="off" /><input id="mpCC_INT_NroVerif" name="mpCC_INT_NroVerif" type="text" required="required" pattern="\d{3,4}" maxlength="4" placeholder="CVC" title="numéro de contrôle (CVC/CVV) ou 000 pour Paypal" autocomplete="off" /></li>
						</ul>
						<button type="submit">Enregistrer</button>
					</fieldset>
				</form>

				<form id="formMDP" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>" autocomplete="off">
					<fieldset>
						<legend>Modifier votre mot de passe</legend>
						<ul>
							<li><label for="passwordOld">Mot de passe actuel :</label><input id="passwordOld" name="passwordOld" type="password" required="required" pattern="[a-zA-Z0-9]{6,12}" title="De 6 à 12 caractères" /></li>
							<li><label for="passwordNew">Nouveau mot de passe :</label><input id="passwordNew" name="passwordNew" type="password" required="required" pattern="[a-zA-Z0-9]{6,12}" title="De 6 à 12 caractères" /></li>
							<li><label for="passwordCnf">Retapez le mot de passe :</label><input id="passwordCnf" name="passwordCnf" type="password" required="required" pattern="[a-zA-Z0-9]{6,12}" title="De 6 à 12 caractères" /></li>
						</ul>
						<button type="submit">Enregistrer</button>
					</fieldset>
				</form>

				<form id="formInterets" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
					<fieldset>
						<legend>Les produits qui vous intéressent</legend>
						<ul>
							<li><input id="interet1" name="interets[]" type="checkbox" value="casse_tetes" /><label for="interet1">Casse-têtes</label></li>
							<li><input id="interet2" name="interets[]" type="checkbox" value="poupees" /><label for="interet2">Poupées</label></li>
							<li><input id="interet3" name="interets[]" type="checkbox" value="marionettes" /><label for="interet3">Marionettes</label></li>
							<li><input id="interet4" name="interets[]" type="checkbox" value="vehicules" /><label for="interet4">Véhicules</label></li>
						</ul>
						<button type="submit">Enregistrer</button>
					</fieldset>
				</form>

				<form id="formCommentaires" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>" autocomplete="off">
					<fieldset>
						<legend>Des questions ou des commentaires?</legend>
						<ul>
							<li><label for="choixSujet">De quoi voulez-vous nous entretenir ? </label><select id="choixSujet" name="choixSujet">
								<option value="sujet1">Requête de jouet</option>
								<option value="sujet2">Le service à la clientèle</option>
								<option value="sujet3">La qualité de vos produits</option>
								<option value="sujet4">Produits à venir</option>
							</select></li>
							<li><label for="commentaire">Votre commentaire :</label><textarea id="commentaire" name="commentaire" placeholder="Laissez-nous un message d'au plus 1024 caractères" title="Laissez-nous un message d'au plus 1024 caractères" required="required"></textarea></li>
						</ul>
						<button type="submit">Envoyer</button>
					</fieldset>
				</form>
			</div>
<?php
require_once "assets/inc/footer.inc.php";
?>
