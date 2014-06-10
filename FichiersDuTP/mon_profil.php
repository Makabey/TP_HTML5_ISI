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
	Il n'y as aucune validation, aucun traitement parce que ce n'est pas le but de l'exercice!
*/
?>
			<h1>Mon Profil</h1>

			<div class="boiteMessagesFormulaires" id="boiteMessagesFormulaires"><span>Merci, vos changements ont été enregistrés.</span></div>
			<div id="loginDiv">
				<form id="formIdentite" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
					<fieldset>
						<legend>Votre identitée</legend>
						<dl>
							<dt><span>Votre identifiant : </span></dt>
							<dd><span><?php echo $_SESSION['user']; ?></span></dd>

							<dt><label for="prenom">Votre prénom : </label></dt>
							<dd><input id="prenom" name="prenom" type="text" placeholder="3 à 24 caractères" pattern="[A-Z][a-zA-Z]{2,25}" title="Majuscule suivie d'au plus 25 charactères" /></dd>

							<dt><label for="nomFamille">Votre nom : </label></dt>
							<dd><input id="nomFamille" name="nomFamille" type="text" placeholder="2 à 24 caractères" pattern="[A-Z][a-zA-Z]{1,25}" title="Majuscule suivie d'au plus 25 charactères" /></dd>

							<dt><label for="adresse">Votre adresse civique : </label></dt>
							<dd><input id="adresse" name="adresse" type="text" placeholder="111111, rue du finfin, #1A" pattern="[0-9]{1,6},?\ ?[a-zA-Z\.\ ]{3,30},?\ ?#?[0-9A-Z]{1,5}" title="Numéro civique, rue et appartement; au plus 40 charactères" /></dd>

							<dt><label for="courriel">Votre courriel : </label></dt>
							<dd><input id="courriel" name="courriel" type="email" required="required" placeholder="utilisateur@domaine.com" value="<?php echo $arrUsager['email']; ?>" /></dd>

							<dt><span>Vous êtes : </span></dt>
							<dd><input name="genre" type="radio" value="femme" /><label for="genreF">Une femme</label>
									<input name="genre" type="radio" value="homme" /><label for="genreH">Un homme</label>
									<input name="genre" type="radio" value="secret" checked="checked" /><label for="genreA">Secret</label></dd>
						</dl>
						<button type="submit">Enregistrer</button>
					</fieldset>
				</form>

				<form id="formInfosCredits" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
					<fieldset>
						<legend>Vos informations de crédit</legend>
						<dl>
							<dt><span>Adresse de livraison : </span></dt>
							<dd><input id="choixAdresseLivraison1" name="choixAdresseLivraison" type="radio" value="principale" checked="checked" /><label for="choixAdresseLivraison1">Idem que principale</label>
									<input id="choixAdresseLivraison2" name="choixAdresseLivraison" type="radio" value="autre" /><input id="adresseLivraisonAutre" name="adresseLivraisonAutre" type="text" placeholder="111111, rue du finfin, #1A" pattern="[0-9]{1,6},?\ ?[a-zA-Z\.\ ]{3,30},?\ ?#?[0-9A-Z]{1,5}" title="Numéro civique, rue et appartement; au plus 40 charactères" /></dd>
							<dt><span>Mode de paiement : </span></dt>
							<dd>
								<dl>
									<dt><input id="mpCC_Visa" name="modePaiement" type="radio" value="cc_visa" checked="checked" /><label for="mpCC_Visa"><img src="assets/images/paiement/visa-curved-32px.png" alt="icone carte de crédit Visa" /></label></dt>
									<dd><input id="mpCC_MasterC" name="modePaiement" type="radio" value="cc_mastercard" /><label for="mpCC_MasterC"><img src="assets/images/paiement/mastercard-curved-32px.png" alt="icone carte de crédit MasterCard" /></label></dd>
									<dt><input id="mpCC_Discover" name="modePaiement" type="radio" value="cc_discover" /><label for="mpCC_Discover"><img src="assets/images/paiement/discover-curved-32px.png" alt="icone carte de crédit discover" /></label></dt>
									<dd><input id="mpITN_Paypal" name="modePaiement" type="radio" value="itn_Paypal" /><label for="mpITN_Paypal"><img src="assets/images/paiement/paypal-curved-32px.png" alt="icone internet paypal" /></label></dd>
								</dl>
							</dd>
							<dt><label for="mpCC_INT_Nro">Numéro de carte ou de compte : </label></dt>
							<dd><input id="mpCC_INT_Nro" name="mpCC_INT_Nro" type="text" required="required" placeholder="Numéro de 12 chiffres" pattern="[0-9]{3}\ ?[0-9]{3}\ ?[0-9]{3}\ ?[0-9]{3}" maxlength="15" title="12 chiffres avec ou sans espaces" autocomplete="off" /><input id="mpCC_INT_NroVerif" name="mpCC_INT_NroVerif" type="text" required="required" pattern="\d{3,4}" maxlength="4" placeholder="CVC" title="numéro de contrôle (CVC/CVV) ou 000 pour Paypal" autocomplete="off" /></dd>
						</dl>
						<button type="submit">Enregistrer</button>
					</fieldset>
				</form>

				<form id="formMDP" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>" autocomplete="off">
					<fieldset>
						<legend>Modifier votre mot de passe</legend>
						<dl>
							<dt><label for="passwordOld">Mot de passe actuel : </label></dt>
							<dd><input id="passwordOld" name="passwordOld" type="password" required="required" pattern="[a-zA-Z0-9]{6,12}" title="De 6 à 12 caractères" /></dd>
							<dt><label for="passwordNew">Nouveau mot de passe : </label></dt>
							<dd><input id="passwordNew" name="passwordNew" type="password" required="required" pattern="[a-zA-Z0-9]{6,12}" title="De 6 à 12 caractères" /></dd>
							<dt><label for="passwordCnf">Retapez le mot de passe : </label></dt>
							<dd><input id="passwordCnf" name="passwordCnf" type="password" required="required" pattern="[a-zA-Z0-9]{6,12}" title="De 6 à 12 caractères" /></dd>
						</dl>
						<button type="submit">Enregistrer</button>
					</fieldset>
				</form>

				<form id="formInterets" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
					<fieldset>
						<legend>Les produits qui vous intéressent</legend>
						<dl>
							<dt><label for="interet1"><input id="interet1" name="interets[]" type="checkbox" value="casse_tetes" />Casse-têtes</label></dt>
							<dd><label for="interet2"><input id="interet2" name="interets[]" type="checkbox" value="poupees" />Poupées</label></dd>
							<dt><label for="interet3"><input id="interet3" name="interets[]" type="checkbox" value="marionettes" />Marionettes</label></dt>
							<dd><label for="interet4"><input id="interet4" name="interets[]" type="checkbox" value="vehicules" />Véhicules</label></dd>
						</dl>
						<button type="submit">Enregistrer</button>
					</fieldset>
				</form>

				<form id="formCommentaires" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>" autocomplete="off">
					<fieldset>
						<legend>Des questions ou des commentaires?</legend>
						<dl>
							<dt><label for="choixSujet">De quoi voulez-vous nous entretenir ? </label></dt>
							<dd><select name="choixSujet">
								<option value="sujet1">Requête de jouet</option>
								<option value="sujet2">Le service à la clientèle</option>
								<option value="sujet3">La qualité de vos produits</option>
								<option value="sujet4">Produits à venir</option>
							</select></dd>
							<dt><label for="commentaire">Votre commentaire : </label></dt>
							<dd><textarea id="commentaire" name="commentaire" placeholder="Laissez-nous un message d'au plus 1024 caractères" title="Laissez-nous un message d'au plus 1024 caractères" pattern=".{1,1024}" required="required"></textarea></dd>
						</dl>
						<button type="submit">Envoyer</button>
					</fieldset>
				</form>
			</div>
<?php
require_once "assets/inc/footer.inc.php";
?>
