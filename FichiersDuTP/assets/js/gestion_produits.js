"use strict";
/*
	Fonctions pour gestion_produits.php seulement
*/

$(function(){
	/*
		Mise en place des événements pour gestion_produits.php
	*/

	$("#product_ID").change(function(){
		var iIndex = $(this).val();

		// remplir tout les champs selon le ID selectionné
		var arrControles1 = new Array ('nom', 'prix', 'nbrEnInventaire', 'fichierImage');
		var arrControles2 = new Array ('categories', 'couleurs', 'materiaux');
		var arrControles3 = new Array ('description', 'gestion_fiche_description');
		var iCmpt=0;
		var sID = '';
		var sTmpVal = '';

		if(arrProduits[iIndex]){ // si cet index existe.. c'est un hash alors tester comme ça ou avec OBJECT (je crois)
			for(iCmpt=0;iCmpt<arrControles1.length;iCmpt++){
				sTmpVal = arrProduits[iIndex][arrControles1[iCmpt]];
				$("#"+arrControles1[iCmpt]).val(sTmpVal);
			}

			if(arrProduits[iIndex]['fichierImage'].length >0){
				var fullPath = sImages_PathProduits + arrProduits[iIndex]['fichierImage'];
				$("#imageProduit").attr("src", fullPath);
			}else{
				$("#imageProduit").removeAttr("src");
			}

			for(iCmpt=0;iCmpt<arrControles2.length;iCmpt++){
				sID = "#checks_"+arrControles2[iCmpt]+" input[type=checkbox]";
				$(sID).each(function(){
					$(this).prop("checked", false);

					sTmpVal = arrProduits[iIndex][arrControles2[iCmpt]];
					if(sTmpVal.length>0){
						if(sTmpVal.indexOf($(this).val()) != -1){
							$(this).prop("checked", true);
						}
					}
				});
			}

			sTmpVal = arrProduits[iIndex][arrControles3[0]];

			$("#"+arrControles3[1]).val(sTmpVal);
		}else{
			for(iCmpt=0;iCmpt<arrControles1.length;iCmpt++){
				$("#"+arrControles1[iCmpt]).val('');
			}

			$("#imageProduit").removeAttr("src");

			for(iCmpt=0;iCmpt<arrControles2.length;iCmpt++){
				sID = "#checks_"+arrControles2[iCmpt]+" input[type=checkbox]";

				$(sID).each(function(){
					$(this).prop("checked", false);
				});
			}

			$("#"+arrControles3[1]).val('');
		}
	});


	$("#fichierImage_browse").change(function(){
		var fullPath = sImages_PathProduits+$(this).val();
		$("#imageProduit").attr("src", fullPath);
		$("#fichierImage").val($(this).val());
	});


	/*$("#btnEnregistrer").click(function(){
		$("#actionAFaire").val('enregistrer');
		$("#formGestionProduits").submit();
	});*/


	$("#btnEffacer").click(function(){
		//$("#actionAFaire").val('effacer');
		//$("#formGestionProduits").submit();
		alert("Ce bouton ne fait rien...");
	});
});

/** == EOF == **/
