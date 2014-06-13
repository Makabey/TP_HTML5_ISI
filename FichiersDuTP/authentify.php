<?php
$sPageTitle = "Authentification | ";

require_once "assets/inc/csvFunctions.inc.php";
require_once "assets/inc/tools.inc.php";
require_once "assets/inc/header.inc.php";

// Formulaire d'enregistrement ------>
$formValidation = array(
	'client_ID' => null,
	'nom' => null,
	'nomFamille' => null,
	'prenom' => null,
	'password' => null,
	'adresse' => null,
	'email' => null,
);

$messErreur = null;

// validation des champs formulaire
if(isset($_POST['nomReg'])){
	$formValidation['nom'] = test_input($_POST['nomReg']);
	$formValidation['nomFamille'] = "";
	$formValidation['prenom'] = "";
	$formValidation['password'] = test_input($_POST['passwordReg']);
	$formValidation['adresse'] = "";
	$formValidation['email'] = test_input($_POST['email']);

	$return = chargerUsager($usagertest,$formValidation['nom']);

	if(!empty($usagertest)){
		$messErreur = 'Usager existant';
	}else{
		$formValidation['client_ID'] = incrementerCompteur('client_ID');
		$return = ecrireUsager($formValidation);

		$_SESSION['user'] = $formValidation['nom'];
		header("Location:index.php");
		exit();
	}

	if($return === FALSE){
		$messErreur = "Il y a eu un probleme d'écriture.";
	}
}
?>
			<div class="boiteErreursFormulaires hidden" id="boiteErreursFormulaires_Login"><span></span></div>
			<div id="loginDiv">
				<!-- DÉBUT formulaire login -->
				<form id="formLogin" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
					<h3>Identifiez-vous !</h3>
					<p>Entrez votre identifiant et mot de passe.</p>
					<fieldset>
						<label for="login">Votre identifiant : </label>
						<div>
							<input id="login" name="login" type="text" required="required" autofocus="autofocus" placeholder="votre identifiant" pattern="[a-zA-Z0-9]{4,12}" title="De 4 à 12 caractères" />
						</div>
					</fieldset>
					<fieldset>
						<label for="passwordLog">Mot de passe : </label>
						<div>
							<input id="passwordLog" name="passwordLog" type="password" required="required" pattern="[a-zA-Z0-9]{6,12}" title="De 6 à 12 caractères" />
						</div>
					</fieldset>
					<fieldset>
						<button type="submit" id="connecter">Connexion</button>
					</fieldset>
				</form><!-- FIN formulaire login -->

				<!-- DÉBUT formulaire inscription -->
				<form id="formRegister" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>" autocomplete ="off">
					<h3>Pas déjà membre ?</h3>
					<p>Veuillez remplir tous les champs pour vous inscrire.</p>
					<fieldset>
						<label for="nomReg">Choisir un identifiant : </label>
						<div>
							<input id="nomReg" name="nomReg" type="text" required="required" placeholder="Au moins 4 charactères" pattern="[a-zA-Z0-9]{4,12}" title="De 4 à 12 caractères" list="suggestionsIdent"/>
							<datalist id="suggestionsIdent"></datalist> <!-- Remplir avec javacript -->
						</div>
					</fieldset>
					<fieldset>
						<label for="passwordReg">Choisir un mot de passe : </label>
						<div>
							<input id="passwordReg" name="passwordReg" type="password" required="required" placeholder="Au moins 6 charactères" pattern="[a-zA-Z0-9]{6,12}" title="De 6 à 12 caractères." />
						</div>
					</fieldset>
					<fieldset>
						<label for="passwordRegConfirm">Confirmez votre mot de passe : </label>
						<div>
							<input id="passwordRegConfirm" type="password" required="required" placeholder="Tapez-le ici de nouveau" pattern="[a-zA-Z0-9]{6,12}" title="De 6 à 12 caractères." />
						</div>
					</fieldset>
					<fieldset>
						<label for="email">Votre courriel : </label>
						<div>
							<input id="email" name="email" type="email" required="required" placeholder="utilisateur@domaine.com" />
						</div>
					</fieldset>
					<fieldset>
						<button type="submit" id="register">Envoyer</button>
					</fieldset>
				</form><!-- FIN formulaire inscription -->
			</div>
<?php
require_once "assets/inc/footer.inc.php";
?>
