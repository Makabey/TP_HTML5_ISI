"use strict";
/*
	Fonctions pour gestion_panier.php seulement
*/

$(function(){
	/*
		Mise en place des événements pour gestion_panier.php
	*/

	// S'assurer que l'usager ne peux entrer que des nombres
	/*$('.panier_qte_input').keydown(function(e){
		e = e || window.event;
		var key = e.keycode || e.which;

		if(!(key == 8 || key == 9 || key == 37 || key ==39)){
			if(!e.key.match(/^[0-9]$/)){
				return false;
			}
		}
	});*/

	$('.panier_qte_input').change(function(){
		var iSousTotal = 0;
		var iIndexPrix = 0;
		var iQte = 0;
		$('.panier_qte_input').each(function(){
			iQte = $(this).val();
			if(isNaN(iQte) || iQte==''){
				$(this).val('0');
				iQte = 0;
			}
			iIndexPrix = parseInt($(this).attr("name").replace('panierQte_', ''));
			iSousTotal += (parseInt(iQte) * arrPanierPrix[iIndexPrix]);
		});
		$("#listePanierSousTotal").html(iSousTotal.toFixed(2)+"$CDN");
	});

	$("#listePanier_Magasiner").click(function(){
		$("#oper").val("magasiner");
		$("#frmPanier").attr("action", "gestion_panier.php");
		$("#frmPanier").submit();
	});


	$("#gp_Payer").click(function(){
		$("#oper").val("facturer");
		$("#frmPanier").attr("action", "gestion_panier.php");
		$("#frmPanier").submit();
	});

	$("#gp_Vider").click(function(){
		if(confirm("Voulez-vous réellement vider votre panier?")){
			$("#oper").val("vider");
			$("#frmPanier").attr("action", "gestion_panier.php");
			$("#frmPanier").submit();
		}
	});
	
	$('.panier_retirer').click(function(){
		$("#oper").val("retirer");
		$("#pid").val($(this).data("pid"));
		$("#frmPanier").attr("action", "gestion_panier.php");
		$("#frmPanier").submit();
	});
});

/** == EOF == **/
