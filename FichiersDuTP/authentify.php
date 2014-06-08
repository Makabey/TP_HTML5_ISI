<?php
$sPageTitle = "Authentification | ";

require_once "assets/inc/csvFunctions.inc.php";
require_once "assets/inc/header.inc.php";

// function pour éliminer les characetres spéciaux
function test_input($data) {
 $data = trim($data);
 $data = stripslashes($data);
 $data = htmlspecialchars($data);
 $data = strtolower($data);
 return $data;
}

function authentifier_user($nom_user, $password_user){
	$retour = chargerUsager($data_user, $nom_user);
	#var_dump($retour);
	if($retour !== FALSE){
		if(!empty($data_user)){
			if($data_user[key($data_user)]['password']==$password_user){
				$retour = true; // Tout correspond
			}
			else{
				$retour = 2; // Mot de passe invalide
			}
		}
		else{
			$retour = 3; // Usager inexistant
		}
	}
	return $retour;
}

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
$messErreurLogin = null;

// validation des champs formulaire
if(isset($_POST['nomReg'])){
	$formValidation['nom'] = test_input($_POST['nomReg']);
	$formValidation['nomFamille'] = ""; #test_input($_POST['nomFamilleReg']);
	$formValidation['prenom'] = ""; #test_input($_POST['prenomReg']);
	$formValidation['password'] = test_input($_POST['passwordReg']);
	$formValidation['adresse'] = ""; #test_input($_POST['adresse']);
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
elseif(isset($_POST['login'])){
// formulaire de connexion ----->
	if(isset($_POST['passwordLog'])){
		$username = test_input($_POST['login']);
		$password = test_input($_POST['passwordLog']);
		#var_dump($username);
		#var_dump($password);
		$resultat = authentifier_user($username, $password);
		if($resultat === true){
			$_SESSION['user'] = $username;
			header("Location:index.php");
			exit();
		}elseif(($resultat == 2) || ($resultat == 3)){
			$messErreurLogin = "Erreur, recommencez";
		}
	}
}
?>
			<div id="loginDiv">
				<!-- DÉBUT formulaire login -->
				<form id="formLogin" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
					<h3>Identifiez-vous !</h3>
					<p>Entrez votre identifiant et mot de passe.</p>
					<fieldset>
						<label for="login">Votre identifiant : </label>
						<div>
							<input id="login" name="login" type="text" required="required" autofocus="autofocus" placeholder="votre identifiant" pattern="[a-zA-Z0-9]{4,12}" title="De 4 à 12 caractères" />
							<!--<span id="loginOk" class="spanValid"></span> -->
						</div>
						<!--<span id="errorLogin" class="spanError"></span> -->
					</fieldset>
					<fieldset>
						<label for="passwordLog">Mot de passe : </label>
						<div>
							<input id="passwordLog" name="passwordLog" type="password" required="required" pattern="[a-zA-Z0-9]{6,12}" title="De 6 à 12 caractères" />
						</div>
						<!--<span id="errorPasswordLog" class="spanError"></span> -->
					</fieldset>
					<fieldset>
						<button type="submit" id="connecter">Connexion</button>
						<span id="userInvalid"><?php echo $messErreurLogin; ?></span>
						<!--<span id="errorFormLog" class="spanError"></span> -->
					</fieldset>
				</form><!-- FIN formulaire login -->

				<!-- DÉBUT formulaire inscription -->
				<form id="formRegister" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>" autocomplete ="off">
					<h3>Pas déjà membre ?</h3>
					<p>Veuillez remplir tous les champs pour vous inscrire.</p>
					<fieldset>
						<label for="nomReg">Choisir un identifiant : </label>
						<div>
							<span id="userTakenReg"><?php echo $messErreur; ?></span>
							<input id="nomReg" name="nomReg" type="text" required="required" placeholder="Au moins 4 charactères" pattern="[a-zA-Z0-9]{4,12}" title="De 4 à 12 caractères" list="suggestionsIdent"/>
							<datalist id="suggestionsIdent"></datalist> <!-- Remplir avec javacript -->
							<!--<span id="nomOk" class="spanValid"></span> -->
						</div>
						<!--<span id="errorNomReg" class="spanError"></span> -->
					</fieldset>
					<!--<fieldset>
						<label for="prenomReg">Votre prénom : </label>
						<div>
							<input id="prenomReg" name="prenomReg" type="text" required="required" placeholder="Au moins 3 charactères" pattern="[A-Z][a-zA-Z0-9]{3,19}" title="Une majuscule suivie de 3 à 19 caractères." />
							<! --<span id="prenomOk" class="spanValid"></span> -- >
						</div>
						<! --<span id="errorPrenomReg" class="spanError"></span> -- >
					</fieldset>
					<fieldset>
						<label for="nomFamilleReg">Votre nom : </label>
						<div>
							<input id="nomFamilleReg" name="nomFamilleReg" type="text" required="required" placeholder="Au moins 3 charactères" pattern="[A-Z][a-zA-Z0-9]{3,19}" title="Une majuscule suivie de 3 à 19 caractères." />
							<! --<span id="nomFamilleOk" class="spanValid"></span> -- >
						</div>
						<! --<span id="errorNomFamilleReg" class="spanError"></span> -- >
					</fieldset>-->
					<fieldset>
						<label for="passwordReg">Choisir un mot de passe : </label>
						<div>
							<input id="passwordReg" name="passwordReg" type="password" required="required" placeholder="Au moins 6 charactères" pattern="[a-zA-Z0-9]{6,12}" title="De 6 à 12 caractères." />
							<!--<span id="passwordOkReg" class="spanValid"></span> -->
						</div>
						<!--<span id="errorPasswordReg" class="spanError"></span> -->
					</fieldset>
					<fieldset>
						<label for="passwordRegConfirm">Confirmez votre mot de passe : </label>
						<div>
							<input id="passwordRegConfirm" type="password" required="required" placeholder="Tapez-le ici de nouveau" pattern="[a-zA-Z0-9]{6,12}" title="De 6 à 12 caractères." />
							<!--<span id="passwordRegConfirmOk" class="spanValid"></span>-->
						</div>
						<span id="passwordRegConfirmError" class="spanError"></span>
					</fieldset>
					<!--<fieldset>
						<label for="adresse">Votre adresse civique : </label>
						<div>
							<input id="adresse" name="adresse" />
							<! --<span id="adresseOk" class="spanValid"></span> -- >
						</div>
						<! --<span id="errorAdresse" class="spanError"></span> -- >
					</fieldset>-->
					<fieldset>
						<label for="email">Votre courriel : </label>
						<div>
							<input id="email" name="email" type="email" required="required" placeholder="utilisateur@domaine.com" />
							<!--<span id="emailOk" class="spanValid"></span> -->
						</div>
						<!--<span id="errorEmail" class="spanError"></span> -->
					</fieldset>
					<fieldset>
						<button type="submit" id="register">Envoyer</button>
						<!--<span id="errorFormReg" class="spanError"></span> -->
					</fieldset>
				</form><!-- FIN formulaire inscription -->
			</div>
<?php
require_once "assets/inc/footer.inc.php";
?>
