"use strict";
/*
	Fonctions pour produits.php seulement
*/

const cstPID = 7; // Index de 'product_ID' dans "arrProduits"

$(function(){
	/*
		Remplir un tableau contenant les données fictives des produits, celles-ci servent à populer l'interface.
	*/
	var iIndexFiche = 0;
	var iIndex_Produit = 0;
	var iCmptProduit = -1;
	var arrProduitsDetails = new Array;
	var arrProduits_length = Object.keys(arrProduits).length;
	var sLienPanier='';

	if(arrProduits_length > 0){
		/*
			Remplissage du array pour cette Catégorie
		*/
		for(iIndex_Produit in arrProduits){
			iCmptProduit++;
			arrProduitsDetails[iCmptProduit] = [
				arrProduits[iIndex_Produit]['fichierImage'],
				arrProduits[iIndex_Produit]['nom'],
				arrProduits[iIndex_Produit]['materiaux'],
				arrProduits[iIndex_Produit]['couleurs'],
				arrProduits[iIndex_Produit]['nbrEnInventaire'],
				arrProduits[iIndex_Produit]['description'],
				arrProduits[iIndex_Produit]['prix'],
				iIndex_Produit
				];

			if(iProduit_ID == iIndex_Produit){

				iIndexFiche = iCmptProduit; // Si on as passé un nom a la page (par $_GET['pid']) et qu'on l'as trouvé, noter son index
			}
		}

		$("#produits_infos_prodid").click(function(){
			//if($("#produits_infos_prodqte").val().length==0) $("#produits_infos_prodqte").val('1');
			//if($("#produits_infos_ajouterpanier>input[type=number]").val().length==0) $("#produits_infos_ajouterpanier>input[type=number]").val('1');
			//sLienPanier = "gestion_panier.php?oper=ajout&pid="+arrProduitsDetails[iIndexFiche][cstPID]+"&qte="+$("#produits_infos_prodqte").val()+"&clr="+$("#produits_infos_clrdispo").data("couleur");
			sLienPanier = "gestion_panier.php?oper=ajout&pid="+arrProduitsDetails[iIndexFiche][cstPID]+"&qte="+$("#produits_infos_ajouterpanier>label>input[type=number]").val()+"&clr="+$("#produits_infos_clrdispo").data("couleur");
			document.location.href=sLienPanier;
		});

		$("#produits_infos_clrdispo").delegate('.produits_ColorChoiceBox', 'click', function(){
			// Passer la couleur de l'enfant à son parent, celui-ci la passera au lien (vers la page 'panier') au moment de son activation
			if($("#produits_infos_clrdispo").data("couleur") != $(this).data("couleur")){
				$("#produits_infos_clrdispo").data("couleur", $(this).data("couleur"));
				$("#produits_infos_clrdispo").children().each(function(){
					$(this).removeClass("selected");
				});
				$(this).addClass("selected");
			}
		});
	}else{
		arrProduitsDetails[0]=['broken_toy.jpg','Aucun item dans cette catégorie','&nbsp;','&nbsp;','&nbsp;','&nbsp;'];
		iIndexFiche = 0;
	}

	if(arrProduits_length > 1){
		/*
			Mise en place des événements pour produits.php

			Si la page as recu un nom via $_GET['pid'], ce nom correspond à une image "produit", son index est mis dans "iIndexFiche" pour forcer la navigation à commencer sur ce produit.
		*/
		$("#produits_infos_btns").show();

		$("#prod_btnPrev").click(function (){
			iIndexFiche--;
			if(iIndexFiche < 0){ iIndexFiche = arrProduitsDetails.length-1; }
			remplirFicheProduit(arrProduitsDetails[iIndexFiche]);
		});

		$("#prod_btnNext").click(function (){
			iIndexFiche++;
			if(iIndexFiche >= arrProduitsDetails.length){ iIndexFiche = 0; }
			remplirFicheProduit(arrProduitsDetails[iIndexFiche]);
		});
	}else{
		$("#produits_infos_btns").hide();
	}

	remplirFicheProduit(arrProduitsDetails[iIndexFiche]); // Force le remplissage de la première fiche.
});

function remplirFicheProduit(arrFicheProduit){
	/*
		Cette fonction ne sert que pour remplir les fiches de la page 'produits.php'

		sImages_PathProduits est globale
	*/
	var arrElementsFicheProduit = [
		'produits_infos_img',
		'produits_infos_nom',
		'produits_infos_mats',
		'produits_infos_clrdispo',
		'produits_infos_nbrdispo',
		'produits_infos_desc',
		'produits_infos_prix'
		];
	var iIndexElement;
	var arrCouleurs;
	var iIndexClr;
	var sEnfants = "";
	var bCouleurAttribuee = false;
	var sChaine;
	var arrSousCouleurs;

	// Changer la source de l'image dans la fiche
	$("#"+arrElementsFicheProduit[0]).attr("src", sImages_PathProduits+arrFicheProduit[0]);
	$("#"+arrElementsFicheProduit[0]).attr("alt", arrFicheProduit[0]);
	$("#"+arrElementsFicheProduit[0]).attr("title", arrFicheProduit[0]);

	// Copier le reste des cellules comme texte dans les champs de la fiche, à droite de l'image
	for(iIndexElement=1;iIndexElement<arrElementsFicheProduit.length;iIndexElement++){
		/*
			Au cours de la copie des contenus, il est nécessaire d'initialiser "produits_infos_clrdispo" à la valeur de
			son premier enfant (dont le contenu est dans arrFicheProduit) et réécrire tout ses enfants.
		*/
		sChaine = arrFicheProduit[iIndexElement];
		if(arrElementsFicheProduit[iIndexElement] == 'produits_infos_clrdispo'){
			sChaine = '';
			arrCouleurs = arrFicheProduit[iIndexElement].split('¤');

			for(iIndexClr=0;iIndexClr<arrCouleurs.length;iIndexClr++){
				arrSousCouleurs = arrCouleurs[iIndexClr].split(';');
				sChaine += '<div class="produits_ColorChoiceBox cursor_hand '+arrSousCouleurs[0];
				if(!bCouleurAttribuee){
					$("#"+arrElementsFicheProduit[iIndexElement]).data("couleur", arrSousCouleurs[0]);
					bCouleurAttribuee = true;
					sChaine += ' selected';
				}
				sChaine +='" data-couleur="'+arrSousCouleurs[0]+'" title="'+arrSousCouleurs[1]+'"> </div>';
			}
		}

		if(arrElementsFicheProduit[iIndexElement] == 'produits_infos_prix'){
			sChaine += "$CDN";
		}

		$("#"+arrElementsFicheProduit[iIndexElement]).html(sChaine);
	}
}

/** == EOF == **/
