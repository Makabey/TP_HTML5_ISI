"use strict";

$(function(){
	$("#formIdentite").submit(function(){
		$("#boiteMessagesFormulaires>span").text("Merci, vos changements ont été enregistrés.");
		$("#boiteMessagesFormulaires").css("display", "block");

		return false;
	});
});

/* == EOF == */
