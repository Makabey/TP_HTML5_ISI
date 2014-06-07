<?php
$sPageTitle = "Mon profil | ";

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
if(isset($_POST['nom'])){
	$formValidation['nom'] = test_input($_POST['nom']);
	$formValidation['nomFamille'] = test_input($_POST['nomFamille']);
	$formValidation['prenom'] = test_input($_POST['prenom']);
	$formValidation['password'] = test_input($_POST['password']);
	$formValidation['adresse'] = test_input($_POST['adresse']);
	$formValidation['email'] = test_input($_POST['email']);

	$return = chargerUsager($usagertest,$formValidation['nom']);

	if(!empty($usagertest)){
		$messErreur = 'Usager existant';
	}
	else{
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
	if(isset($_POST['password'])){
		$username = $_POST['login'];
		$password = $_POST['password'];
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

Un formulaire qui devra contenir des champs de texte, boutons radio, cases à 
cocher, liste déroulante, champ de texte multi ligne, et les nouveaux attributs et 
fonctionnalités de formulaires du HTML5

			<div id="loginDiv">
				<!-- DÉBUT formulaire login -->
				<form id="formLogin" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
					<h3>Identifiez-vous !</h3>
					<p>Entrez votre identifiant et mot de passe.</p>
					<fieldset>
						<label for="login">Votre identifiant : </label>
						<div>
							<input id="login" class="rounded" name="login" />
							<span id="loginOk" class="spanValid"></span>
						</div>
						<span id="errorLogin" class="spanError"></span>
					</fieldset>
					<fieldset>
						<label for="passwordLog">Mot de passe : </label>
						<div>
							<input id="passwordLog" class="rounded" name="password" type="password" />
						</div>
						<span id="errorPasswordLog" class="spanError"></span>
					</fieldset>
					<fieldset>
						<button type="button" id="connecter" class="rounded">Connexion</button>
						<span id="userInvalid"><?php echo $messErreurLogin; ?></span>
						<span id="errorFormLog" class="spanError"></span>
					</fieldset>
				</form><!-- FIN formulaire login -->

				<!-- DÉBUT formulaire inscription -->
				<form id="formRegister" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
					<h3>Pas déjà membre ?</h3>
					<p>Veuillez remplir tous les champs pour vous inscrire.</p>
					<fieldset>
						<label for="nomReg">Choisir un identifiant : </label>
						<div>
							<input id="nomReg" class="rounded" name="nom" />
							<span id="nomOk" class="spanValid"></span>
						</div>
						<span id="errorNomReg" class="spanError"></span>
					</fieldset>
					<fieldset>
						<label for="prenomReg">Votre prénom : </label>
						<div>
							<input id="prenomReg" class="rounded" name="prenom" />
							<span id="prenomOk" class="spanValid"></span>
						</div>
						<span id="errorPrenomReg" class="spanError"></span>
					</fieldset>
					<fieldset>
						<label for="nomFamilleReg">Votre nom : </label>
						<div>
							<input id="nomFamilleReg" class="rounded" name="nomFamille" />
							<span id="nomFamilleOk" class="spanValid"></span>
						</div>
						<span id="errorNomFamilleReg" class="spanError"></span>
					</fieldset>
					<fieldset>
						<label for="passwordReg">Choisir un mot de passe : </label>
						<div>
							<input id="passwordReg" class="rounded" name="password" type="password" />
							<span id="passwordOkReg" class="spanValid"></span>
						</div>
						<span id="errorPasswordReg" class="spanError"></span>
					</fieldset>
					<fieldset>
						<label for="adresse">Votre adresse civique : </label>
						<div>
							<input id="adresse" class="rounded" name="adresse" />
							<span id="adresseOk" class="spanValid"></span>
						</div>
						<span id="errorAdresse" class="spanError"></span>
					</fieldset>
					<fieldset>
						<label for="email">Votre courriel : </label>
						<div>
							<input id="email" class="rounded" name="email" />
							<span id="emailOk" class="spanValid"></span>
						</div>
						<span id="errorEmail" class="spanError"></span>
					</fieldset>
					<fieldset>
						<button type="button" id="register" class="rounded">Envoyer</button>
						<span id="userTaken"><?php echo $messErreur; ?></span>
						<span id="errorFormReg" class="spanError"></span>
					</fieldset>
				</form><!-- FIN formulaire inscription -->
			</div>
<?php
require_once "assets/inc/footer.inc.php";
?>
