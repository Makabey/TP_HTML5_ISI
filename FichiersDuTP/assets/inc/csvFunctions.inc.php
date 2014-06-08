<?php
/*
	constantes et array utilisés par "chargerFactureCSV"
*/
define('CLIENT_ID', 0);
define('FACTURE_ID', 1);
define('DATE_ACHAT', 2);
define('PRODUCT_ID', 3);
define('COULEURS', 4);
define('QUANTITE', 5);
define('BASE_REP_FICHIERS', '../res/');

########################################

function chargerCategories(&$refArrDonnees, $sIndexMode='fichier'){
	/* Wrapper */
	return lireCSV_VersTblIdx($refArrDonnees, BASE_REP_FICHIERS.'table_categories.csv', $sIndexMode);
}

function chargerCouleurs(&$refArrDonnees, $sIndexMode='fichier'){
	/* Wrapper */
	return lireCSV_VersTblIdx($refArrDonnees, BASE_REP_FICHIERS.'table_couleurs.csv', $sIndexMode);
}

function chargerMateriaux(&$refArrDonnees, $sIndexMode='fichier'){
	/* Wrapper */
	return lireCSV_VersTblIdx($refArrDonnees, BASE_REP_FICHIERS.'table_materiaux.csv', $sIndexMode);
}

function chargerProduits(&$refArrDonnees, $sIndexMode='fichier'){
	/* Wrapper */
	return lireCSV_VersTblIdx($refArrDonnees, BASE_REP_FICHIERS.'table_produits.csv', $sIndexMode);
}

function chargerPanier(&$refArrDonnees, $iID_Client){
	/* Wrapper */
	if($iID_Client < 10) $iID_Client = '0'.$iID_Client;
	$iID_Client = BASE_REP_FICHIERS.'panier_'.$iID_Client.'.csv';

	$retour = lireCSV_VersTblIdx($refArrDonnees, $iID_Client);

	if($retour !== false){
		foreach($refArrDonnees as $cle => $val){
			$refArrDonnees[$cle] = intval($val['quantite']);
		}
	}

	return $retour;
}

function ecrireProduits(&$refArrDonnees, $sModeEcriture='ajout'){
	/* Wrapper */
	# Pour rendre ecrireCSV_VersTblIdx générique, il suffirait de transformer les sous-array en chaines ici??
	return ecrireCSV_VersTblIdx($refArrDonnees, BASE_REP_FICHIERS.'table_produits.csv');
}

function chargerUsager(&$refArrDonnees, $iID_Client=-1){
	/* Wrapper */
	return lireCSV_VersTblIdx($refArrDonnees, BASE_REP_FICHIERS.'table_usagers.csv', 'fichier', $iID_Client);
}

function chargerFacture(&$refArrDonnees, $iID_Client=-1){
	/* Wrapper */
	return chargerFactureCSV($refArrDonnees, BASE_REP_FICHIERS.'clients_factures.csv', $iID_Client);
}


function formaterProduitsPourJS(&$arrProduits, $iCategorie=-1){
	/*
		Retour :
			FALSE	: si problème autre que "$arrProduits" as zéro éléments
			-1			: arrProduits est vide
			chaine	: le contenu généré
	*/

	if((isset($arrProduits)) && (!empty($arrProduits))){
		$retour = chargerCouleurs($arrCouleurs);
		if($retour !== false){
			//$retour = chargerMateriaux($arrMateriaux);
			//if($retour !== false){
				$retour = chargerCategories($arrCategories);
			//}
		}

		if($retour !== false){
			$retour = null;
			foreach($arrProduits as $cleProd => $produit){
				if($iCategorie != -1){
					$pos = stripos($produit['categories'], $arrCategories[$iCategorie]['token']);
				}else{
					$pos = false;
				}

				if(($iCategorie == -1) || (false !== $pos)){
					$retour .= '"' . $cleProd . '" : {';
					foreach($produit as $cleDetail => $detail){
						if($cleDetail == 'couleurs'){
							$arrCouleursProduit = explode('¤',$detail);
							foreach($arrCouleursProduit as $cleClrProd => $cetteCouleur){
								foreach($arrCouleurs as $cleCouleur => $detailsCouleur){
									if($detailsCouleur['html'] == $arrCouleursProduit[$cleClrProd]){
										$arrCouleursProduit[$cleClrProd] .= ';' . $detailsCouleur['nom'];
									}
								}
							}
							$detail = implode('¤', $arrCouleursProduit);
						}
						if($cleDetail == 'materiaux'){
							$detail = str_replace('¤', ', ', $detail);
						}
						$retour .= '"' . $cleDetail . '" : "' . $detail . '", ';
					}
					$retour .= '}, '.PHP_EOL;
				}
			}
		}
	}else{
		$retour = -1;
	}

	return $retour;
}

function categoriesTokensVersNoms($sCategories){
	$retour = chargerCategories($arrCategories);

	if($retour !== false){
		$sCategories = str_replace('¤', ', ', $sCategories);
		foreach($arrCategories as $categorie){
			$sCategories = str_replace($categorie['token'], $categorie['nom'], $sCategories);
		}
		$retour = $sCategories;
	}
	return $retour;
}

function couleursTokensVersNoms($sCouleurs){
	$retour = chargerCouleurs($arrCouleurs);

	if($retour !== false){
		$sCouleurs = str_replace('¤', ', ', $sCouleurs);
		foreach($arrCouleurs as $couleur){
			$sCouleurs = str_replace($couleur['html'], $couleur['nom'], $sCouleurs);
		}
		$retour = $sCouleurs;
	}
	return $retour;
}

#########################################################

function lireCSV_VersTblIdx(&$refArrDonnees, $sNomFichier, $sIndexMode='fichier', $idOuNomRechercher=-1){
	/*
		Lit $sNomFichier et met dans $refArrDonnees les lignes lues.

		Entrées:
			$refArrDonnees	: le tableau qui devra contenir les lignes lues, sera vidé avant de commencer
			$sNomFichier	: chemin et nom du fichier (incluant l'extension ".csv") CSV voulu
			$sIndexMode
					'binaire'		: 	en utilisant un index de puissance de 2, ce qui permettra d'additionner l'index des valeurs vers un nombre unique les représentants plutôt que toutes les indiquer, séparée par un charactère de séparation. ex: "5" pour les items aux index 1 et 4 plutôt que "1,4"
					'fichier'		: garde les index imposés par le fichier
					'sequentiel'	: index de 0+

		Retour:
			false	: erreur d'ouverture de fichier
			0+		: le nombre de lignes lues
	*/
	$retour = false;
	$refArrDonnees = array(); # S'assurer que le tableau est vide
	if(is_numeric($idOuNomRechercher) && ($idOuNomRechercher < -1)) $idOuNomRechercher = -1;

	$sIndexMode = trim(strtolower($sIndexMode));
	if(($sIndexMode != 'binaire') &&
		($sIndexMode != 'fichier') &&
		($sIndexMode != 'sequentiel')){
		$sIndexMode = 'fichier';
	}

	# Par sanité, vérifier si $sNomFichier existe et est en fait ou non un nom de répertoire
	if(is_readable($sNomFichier)){
		if(!is_dir($sNomFichier)){
			# Tenter d'ouvrir le fichier
			if(($HndFichier = fopen($sNomFichier, 'rb')) !== false){
				$iIndexBin = ($sIndexMode == 'binaire')?1:0; # Si $sIndexMode='binaire', commencer à 1, sinon 0, considérant que pour 'fichier' la valeur est forcé avant l'utilisation, 0 ou 1 n'as aucune importance
				$retour = 0;
				$clesChamps=array(); # Pour retenir les noms des champs si le premier champs de la première ligne est du texte

				if($idOuNomRechercher === -1){ # Si on n'as pas précisé de ID ou NOM à rechercher
					while(($ligne = fgetcsv($HndFichier, 1000, ";")) !== false){
						$sPremierChamps = array_shift($ligne);
						if(!is_numeric($sPremierChamps) && empty($clesChamps)){
							$clesChamps = $ligne;
						}else{
							if($sIndexMode == 'fichier'){
								if(is_numeric($sPremierChamps)){
									$sPremierChamps += 0; # devrait faire comme "intval"
								}
								$iIndexBin = $sPremierChamps;
							}

							if(!empty($clesChamps)){ # Si les entetes sont présentes
								$refArrDonnees[$iIndexBin] = array_combine($clesChamps, $ligne);
							}else{
								$refArrDonnees[$iIndexBin] = $ligne;
							}

							if($sIndexMode == 'binaire'){
								$iIndexBin *= 2;
							}elseif($sIndexMode == 'sequentiel'){
								$iIndexBin++;
							}

							$retour++;
						}
					}
				}else{
					$clesChamps = fgetcsv($HndFichier, 1000, ";"); # On suppose que la premiere ligne sera toujours du texte...
					$cleNom = in_array('nom', $clesChamps) ;

					if($clesChamps !== false){
						while(($ligne = fgetcsv($HndFichier, 1000, ";")) !== false){
							if(intval($ligne[0]) == $idOuNomRechercher){
								unset($ligne[0]);
								unset($clesChamps[0]);
								$refArrDonnees = array($idOuNomRechercher => array_combine($clesChamps, $ligne));
								$retour=1;
								break; # devrait sortir de la boucle avec la seule ligne voulue
							}elseif(($cleNom !== false) && ($idOuNomRechercher === $ligne[$cleNom])){
								// Si $ligne[$cleNom] === RIEN, alors bogue!!
								unset($ligne[$cleNom]);
								unset($clesChamps[$cleNom]);
								$refArrDonnees = array($idOuNomRechercher => array_combine($clesChamps, $ligne));
								$retour=1;
								break; # devrait sortir de la boucle avec la seule ligne voulue
							}
						}
					}
				}
				fclose($HndFichier); # Inutile mais fait par mesure de propreté
			}else{$retour=-3;} # impossible de lire le fichier
		}else{$retour=-2;} # fichier est un répertoire
	}else{$retour=-1;} # fichier non lisible

	return $retour;
}


function ecrireCSV_VersTblIdx(&$refArrDonnees, $sNomFichier){
	/*
		Pour le moment cette fonction n'est compatible qu'avec le format du fichier Produits

		Écrit vers $sNomFichier les données de $refArrDonnees selon l'opération $sModeEcriture

		Entrées:
			$refArrDonnees	: le tableau qui devra contenir les données à manipuler
			$sNomFichier		: chemin et nom du fichier (incluant l'extension ".csv") CSV voulu
			X$iIndexAEcrire		: index que doit avoir la ligne, ici je ne vais pas supporter les mode fichier, sequentiel ou binaire, donc aucune complication!
			X$sModeEcriture
					'ajout'			:	ajouter
					'modifier'		:	modifier l'item (à voir si nécessaire, selon logique développée de la fonction)
					'effacer'		:	quoi d'autres? <--- retirer pour le moment, sinon demanderait d'ouvrir un fichier sous le nom '$sNomFichier.new' pour retranscrire les bonnes lignes

		Retour:
			false	: erreur d'ouverture de fichier
			0+		: le nombre de caractères écrits
	*/

	$retour = false;

	if(isset($refArrDonnees['actionAFaire'])){
		if(($refArrDonnees['actionAFaire'] == 'enregistrer') ||
		($refArrDonnees['actionAFaire'] == 'effacer')){
			# Par sanité, vérifier si $sNomFichier existe et est en fait ou non un nom de répertoire
			if(is_readable($sNomFichier)){
				if(!is_dir($sNomFichier)){
					# Tenter d'ouvrir le fichier
					if(($HndFichier_Source = fopen($sNomFichier, 'rb')) !== false){
						# Lire la premiere ligne
						$ligne = fgetcsv($HndFichier_Source, 1000, ";");

						# La premiere ligne DOIT etre les noms des champs!
						if(!is_numeric($ligne[0])){ # On s'attend à 'product_ID'
							# Forcer l'ordre et le contenu des données
							$iDonneesManquantes = 0;
							foreach($ligne as $Champs){
								if(!isset($refArrDonnees[$Champs])){
									$iDonneesManquantes++;
								}else{
									$arrDonneesAEcrire[$Champs] = $refArrDonnees[$Champs];
									if(($Champs == 'categories') ||
										($Champs == 'materiaux') ||
										($Champs == 'couleurs')){
										$arrDonneesAEcrire[$Champs] = implode('¤', $refArrDonnees[$Champs]);
									}
								}
							}

							if($iDonneesManquantes == 0){
								$sModeEcriture = $refArrDonnees['actionAFaire'];
								$iIndexAEcrire = $refArrDonnees['product_ID'];
								$iIndexAEcrire_Trouver = false;
								$retour = 0;

								if(($HndFichier_Destination= fopen($sNomFichier.'.new', 'wb')) !== false){
									$retour = fputcsv($HndFichier_Destination, $ligne, ';');
									while(($ligne = fgetcsv($HndFichier_Source, 1000, ";")) !== false){
										if($ligne[0] == $iIndexAEcrire){
											$iIndexAEcrire_Trouver = true;
											if($sModeEcriture == 'enregistrer'){
												$retour = fputcsv($HndFichier_Destination, $arrDonneesAEcrire, ';');
											}# else on veux effacer? alors il suffit de ne pas réécrire!
										}else{
											$retour = fputcsv($HndFichier_Destination, $ligne, ';');
										}
									}

									if(($iIndexAEcrire_Trouver == false) && ($sModeEcriture == 'enregistrer')){
										$retour = fputcsv($HndFichier_Destination, $arrDonneesAEcrire, ';');
									}
									fclose($HndFichier_Destination);
									fclose($HndFichier_Source);
									$renommer = rename ($sNomFichier, $sNomFichier.'.old');
									if($renommer){
										rename ($sNomFichier.'.new', $sNomFichier);
									}
								}
							}
						}
					}
				}
			}
		}elseif($refArrDonnees['actionAFaire'] == 'consulter'){
			$retour = true;
		}
	}

	return $retour;
}

function incrementerCompteur($sCompteur){
	/*
	Augmente et retourne le compteur demandé par $sCompteur, s'il n'existe pas, le crée et retourne 0

	retour
		FALSE si problème
		0+ pour le decompte courant
	*/
	$sNomFichier = BASE_REP_FICHIERS.'table_compteur.csv';
	$retour = false;

	# Tenter d'ouvrir le fichier
	if(($HndFichier = fopen($sNomFichier, 'cb+')) !== false){

		# Lire la premiere ligne
		$entetes = fgetcsv($HndFichier, 1000, ";");
		$donnees=array();

		if($entetes === false){ # Le fichier était vide
			$entetes[] = $sCompteur;
			$donnees[] = 0;
			$iIndex=0;
		}else{
			if(!is_numeric($entetes[0])){
				// Avant de determiner si $entetes contient $sCompteur, voir si on as bien une seconde ligne contenant les donnees
				$donnees = fgetcsv($HndFichier, 1000, ";");
				if($donnees !== false){
					// Est-ce que $entetes et $donnees contiennent le même nombre de champs?
					if(count($entetes) == count($donnees)){
						$iIndex = array_search($sCompteur, $entetes);
						if($iIndex === false){ # Index pas trouvé
							$entetes[] = $sCompteur;
							$donnees[] = 0;
							$iIndex = count($donnees)-1;
						}else{
							$donnees[$iIndex]++;
						}
						$retour = true; // Pas d'erreur? L'indiquer pour plus loin
					}
				}
			}
		}

		// S'il n'y as eut aucune erreur jusqu'ici...
		if($retour === true){
			$retour = rewind($HndFichier);
			if($retour === true){
				$retour = fputcsv($HndFichier, $entetes, ';');
				if($retour !== false){
					$retour = fputcsv($HndFichier, $donnees, ';');
					if($retour !== false){
						$retour = $donnees[$iIndex]; # Puisque l'entete et la donnee sont bien ecrit, retourner le compte
					}
				}
			}
		}
	}

	return $retour;
}


function lireCompteur($sCompteur){
	/*
	l'idee est de ne pas devoir lire chaque fichiers pour connaitre l'index le plus haut
	ex: produits_ID

	retour
		FALSE si problème
		0+ pour le decompte courant, c'est à dire l'index le plus haut pour $sCompteur
	*/

	$sNomFichier = BASE_REP_FICHIERS.'table_compteur.csv';
	$retour = false;
	# Par sanité, vérifier si $sNomFichier existe et est en fait ou non un nom de répertoire
	if(is_readable($sNomFichier)){
		# Tenter d'ouvrir le fichier
		if(($HndFichier = fopen($sNomFichier, 'rb')) !== false){
			# Lire la premiere ligne
			$entetes = fgetcsv($HndFichier, 1000, ";");

			if($entetes !== false){ # Le fichier n'est pas vide
				$iIndex = array_search($sCompteur, $entetes);
				if($iIndex !== false){ # Index trouvé
					$donnees = fgetcsv($HndFichier, 1000, ";");
					if(($donnees !== false) && isset($donnees[$iIndex])){
						$retour = intval($donnees[$iIndex]);
					}
				}
			}
		}
	}

	return $retour;
}


function ecrireUsager(&$refArrDonnees, $sModeEcriture = 'enregistrer'){
	/*
	Écrit dans le fichier usager

	entrée
		$refArrDonnees	: Le tableau des valeurs
		$sModeEcriture		: le mode, soit "enregistrer" ou "effacer"

	retour
		FALSE si problème
		0+ nombre de caractère écrits
	*/

	$sNomFichier = BASE_REP_FICHIERS.'table_usagers.csv';
	$retour = false;

	# Tenter d'ouvrir le fichier
	if(($HndFichier_Source = fopen($sNomFichier, 'cb+')) !== false){
		# Lire la premiere ligne
		$ligne = fgetcsv($HndFichier_Source, 1000, ";");

		if($ligne === false){ # Si le fichier est vide...
			$cles = array_keys($refArrDonnees);
			$retour = fputcsv($HndFichier_Source, $cles, ';');
			$retour = fputcsv($HndFichier_Source, $refArrDonnees, ';');
		}else{
			# La premiere ligne DOIT etre les noms des champs!
			if(!is_numeric($ligne[0])){
				# Forcer l'ordre et le contenu des données
				$iDonneesManquantes = 0;
				foreach($ligne as $Champs){
					if(!isset($refArrDonnees[$Champs])){
						$iDonneesManquantes++;
					}else{
						$arrDonneesAEcrire[$Champs] = $refArrDonnees[$Champs];
					}
				}

				if($iDonneesManquantes == 0){
					# Trouver le premier champs et sa valeur, ex: produits_ID = 0
					$cle = array_keys($arrDonneesAEcrire);
					$iIndexAEcrire = $arrDonneesAEcrire[$cle[0]];
					unset($cle);

					$iIndexAEcrire_Trouver = false;
					$retour = 0;

					if(($HndFichier_Destination= fopen($sNomFichier.'.new', 'wb')) !== false){
						$retour = fputcsv($HndFichier_Destination, $ligne, ';');
						while(($ligne = fgetcsv($HndFichier_Source, 1000, ";")) !== false){
							if($ligne[0] == $iIndexAEcrire){
								$iIndexAEcrire_Trouver = true;
								if($sModeEcriture == 'enregistrer'){
									$retour = fputcsv($HndFichier_Destination, $arrDonneesAEcrire, ';');
								}# else effacer? alors ne pas réécrire!
							}else{
								$retour = fputcsv($HndFichier_Destination, $ligne, ';');
							}
						}

						if(($iIndexAEcrire_Trouver == false) && ($sModeEcriture == 'enregistrer')){
							$retour = fputcsv($HndFichier_Destination, $arrDonneesAEcrire, ';');
						}
						fclose($HndFichier_Destination);
						fclose($HndFichier_Source);
						$renommer = rename ($sNomFichier, $sNomFichier.'.old');
						if($renommer){
							$renommer = rename ($sNomFichier.'.new', $sNomFichier);
							if(!$renommer) 	$retour = $renommer;
						}else{
							$retour = $renommer;
						}
					}
				}
			}
		}
	}

	return $retour;
}

function ecrirePanier(&$refArrDonnees, $iID_Client){
	/*
		écrit les items du panier

		entrées
			refArrDonnees	: les données à écrire
			iID_Client			: le id du client

		retour
			FALSE	: si problème
			0+			: nombre de caractères écrits
	*/
	$retour = false;

	if(!empty($refArrDonnees)){
		if($iID_Client < 10) $iID_Client = '0'.$iID_Client;
		$sNomFichier = BASE_REP_FICHIERS.'panier_'.$iID_Client.'.csv';

		if(($HndFichier = fopen($sNomFichier, 'wb')) !== false){
			$entetes = array('produit_ID', 'quantite');
			$retour = fputcsv($HndFichier, $entetes, ';');
			if($retour !== false){
				foreach($refArrDonnees as $cle => $val){
					$ligne = array($cle, $val);
					$retour = fputcsv($HndFichier, $ligne, ';');
					if($retour === false) break;
				}
			}
		}
	}

	return $retour;
}

function chargerFactureCSV(&$refArrDonnees, $sNomFichier, $iID_Rechercher=-1, $sTypeRechercher='client_ID'){
	/*
		Si je voulais une fonction capable d'aussi sortir une facture de numéro spécifique, suggestion de déclaration (code plus bas à changer aussi, bien sûr) :
		function chargerFacture(&$refArrDonnees, $sNomFichier, $iID_Rechercher=-1, $sTypeRechercher='client_ID')
		$sTypeRechercher ne prendrais que 'client_ID' et 'facture_ID'
		la fonction retournerais un array de la même structure (que maintenant), peu importe les options

		Lit toutes les factures du client $iID_Rechercher s'il est autre que -1, sinon toutes les factures de tout les clients

		Entrées:
			$refArrDonnees	: le tableau qui devra contenir les lignes lues, sera vidé avant de commencer
			$sNomFichier		: chemin et nom du fichier (incluant l'extension ".csv") CSV voulu
			$iID_Rechercher	: le ID du client, si -1 ou non donné renvois toutes les factures
			$sIndexMode
					'binaire'		: en utilisant un index de puissance de 2, ce qui permettra d'additionner l'index des valeurs vers un nombre unique les représentants plutôt que toutes les indiquer, séparée par un charactère de séparation. ex: "5" pour les items aux index 1 et 4 plutôt que "1,4"
					'fichier'		: garde les index imposés par le fichier
					'sequentiel'	: index de 0+

		Retour:
			false	: erreur d'ouverture de fichier
			0+		: le nombre de lignes lues
	*/
	$retour = false;
	$refArrDonnees = array(); # S'assurer que le tableau est vide
	$iID_Rechercher = intval($iID_Rechercher);
	if($iID_Rechercher < -1) $iID_Rechercher = -1;
	$sTypeRechercher += '';
	if(($sTypeRechercher != 'client_ID') && ($sTypeRechercher != 'facture_ID')) $sTypeRechercher = 'client_ID';

	# Par sanité, vérifier si $sNomFichier existe et est en fait ou non un nom de répertoire
	if(is_readable($sNomFichier)){
		if(!is_dir($sNomFichier)){
			# Tenter d'ouvrir le fichier
			if(($HndFichier = fopen($sNomFichier, 'rb')) !== false){
				$clesChamps = fgetcsv($HndFichier, 1000, ";"); # On suppose que la premiere ligne sera toujours du texte...
				if($clesChamps !== false){ # revient à "si le fichier n'est pas vide"
					$retour=0;
					while(($ligne = fgetcsv($HndFichier, 1000, ";")) !== false){
						if(($iID_Rechercher == -1) ||
							(($iID_Rechercher == $ligne[CLIENT_ID]) && $sTypeRechercher == 'client_ID') ||
							(($iID_Rechercher == $ligne[FACTURE_ID]) && $sTypeRechercher == 'facture_ID')
							){
							$iClient_ID = intval($ligne[CLIENT_ID]);
							$iFacture_ID = intval($ligne[FACTURE_ID]);
							$sDateAchat = $ligne[DATE_ACHAT];
							$iProduct_ID = intval($ligne[PRODUCT_ID]);
							$iQte = intval($ligne[QUANTITE]);
							$refArrDonnees[$iClient_ID][$iFacture_ID]['dateAchat'] = $sDateAchat;
							$refArrDonnees[$iClient_ID][$iFacture_ID]['produits'][$iProduct_ID]['couleurs'] = $ligne[COULEURS];
							$refArrDonnees[$iClient_ID][$iFacture_ID]['produits'][$iProduct_ID]['quantite'] = $iQte;
							$retour++;
						}
					}
				}
				fclose($HndFichier); # Inutile mais fait par mesure de propreté
			}
		}
	}

	return $retour;
}

function ecrireFacture(&$refArrDonnees, $iID_Client){
	/*
		écrit la facture

		entrées
			refArrDonnees	: les données à écrire
			iID_Client			: le id du client

		retour
			FALSE		: si problème
			0+			: nombre de caractères écrits
	*/
	$retour = false;
	$sNomFichier = BASE_REP_FICHIERS.'clients_factures.csv';
	$iCumulEcrit = 0; # Le nombre d'Octets écris

	if(!empty($refArrDonnees)){
		if(($HndFichier = fopen($sNomFichier, 'ab+')) !== false){
			$iNoFacture = incrementerCompteur('facture_ID');

			$retour = fgetcsv($HndFichier, 1000, ';');
			if($retour === false){
				$entetes = array('client_ID', 'facture_ID', 'dateAchat', 'product_ID', 'couleurs', 'quantite');
				$retour = fputcsv($HndFichier, $entetes, ';');
			}

			foreach($refArrDonnees as $iProduct_ID => $arrDonnees){
				$arrLigneFacture = array($iID_Client, $iNoFacture, date('d/m/Y H:i:s'), $iProduct_ID, $arrDonnees['couleur'], $arrDonnees['quantite']);
				$retour = fputcsv($HndFichier, $arrLigneFacture, ';');
				if($retour === false){
					break;
				}else{
					$iCumulEcrit += $retour;
				}
			}
			if($retour !== false) $retour = $iCumulEcrit;
		}
	}

	return $retour;
}

/* == EOF == */
