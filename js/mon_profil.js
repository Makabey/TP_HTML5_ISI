"use strict";

$(function(){
	$("#formIdentite").submit(function(){
		$("#boiteMessagesFormulaires").addClass("boiteMessagesFormulaires");
		$("#boiteMessagesFormulaires").removeClass("boiteErreursFormulaires");

		$("#boiteMessagesFormulaires>span").text("Merci, vos informations personnelles ont été enregistrées.");
		$("#boiteMessagesFormulaires").css("display", "block");

		window.scrollTo(0,0);

		return false;
	});

	$("#formInfosCredits").submit(function(){
		$("#boiteMessagesFormulaires").addClass("boiteMessagesFormulaires");
		$("#boiteMessagesFormulaires").removeClass("boiteErreursFormulaires");

		$("#boiteMessagesFormulaires>span").text("Merci, vos informations de paiement ont été enregistrées.");
		$("#boiteMessagesFormulaires").css("display", "block");

		window.scrollTo(0,0);

		return false;
	});

	$("#formMDP").submit(function(){
		if($("#passwordOld").val() == $("#passwordNew").val()){
			$("#boiteMessagesFormulaires").addClass("boiteErreursFormulaires");
			$("#boiteMessagesFormulaires").removeClass("boiteMessagesFormulaires");
			$("#boiteMessagesFormulaires>span").text("Votre nouveau mot de passe doit être différent de l'ancien.");
		}else if($("#passwordNew").val() != $("#passwordCnf").val()){
			$("#boiteMessagesFormulaires").addClass("boiteErreursFormulaires");
			$("#boiteMessagesFormulaires").removeClass("boiteMessagesFormulaires");
			$("#boiteMessagesFormulaires>span").text("Vous avez mal retapé votre mot de passe.");
		}else{
			$("#boiteMessagesFormulaires").addClass("boiteMessagesFormulaires");
			$("#boiteMessagesFormulaires").removeClass("boiteErreursFormulaires");
			$("#boiteMessagesFormulaires>span").text("Merci, votre mot de passe as été remplaçé.");
		}

		$("#boiteMessagesFormulaires").css("display", "block");

		window.scrollTo(0,0);

		return false;
	});

	$("#formInterets").submit(function(){
		$("#boiteMessagesFormulaires").addClass("boiteMessagesFormulaires");
		$("#boiteMessagesFormulaires").removeClass("boiteErreursFormulaires");

		$("#boiteMessagesFormulaires>span").text("Merci, vos intérêts ont été enregistrés.");
		$("#boiteMessagesFormulaires").css("display", "block");

		window.scrollTo(0,0);

		return false;
	});

	$("#formCommentaires").submit(function(){
		$("#boiteMessagesFormulaires").addClass("boiteMessagesFormulaires");
		$("#boiteMessagesFormulaires").removeClass("boiteErreursFormulaires");

		$("#boiteMessagesFormulaires>span").text("Merci, votre commentaire sera lu et vous recevrez une réponse sous peu.");
		$("#boiteMessagesFormulaires").css("display", "block");

		window.scrollTo(0,0);

		return false;
	});
});

/* == EOF == */
