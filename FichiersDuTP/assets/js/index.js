"use strict";
/*
	Fonctions pour index.php seulement
*/

$(function(){
	/*
		Mise en place des événements pour index.php
	*/
	var tSlider; // Originalement, servait à un mécanisme de pause, celui-ci as été enlevé

	// Tenter de remplir le slider et si ça va, lancer un interval
	if(fillSlideShowElement(sImages_PathSlider, "sliderJQ_img", arrImages)){
		tSlider = startSliderAnimation();
	}
});


function startSliderAnimation(){
	/*
		Démarre un temporisateur pour changer l'image visible de #sliderJQ_img
	*/
	var tSliderStarting = setInterval(function(){
		$("#sliderJQ_img>ul").animate({marginLeft:-1024},800,function(){$(this).css({marginLeft:0}).find("li:last").after($(this).find("li:first"));});

		//$("#sliderJQ_desc span").text($("#sliderJQ_img>ul>li:nth-of-type(2) img").attr("alt"));
		}, 3500);

	return tSliderStarting;
}


function fillSlideShowElement(sPathImage, sSliderElementID, arrTableauImages){
	/*
		sPathImage : Le chemin de base des Images
		sSliderElementID : Le ID de l'élément avec lequel interagir
		arrTableauImages : Le tableau comprenant le nom de toutes les images de la galerie courante

		Vide puis remplis sSliderElementID avec les images passées
	*/
	var sAltText="";
	var iIndexSlider;
	var retour = false;

	if(sSliderElementID.indexOf('#') != 0){
		sSliderElementID = "#"+sSliderElementID;
	}

	if(arrTableauImages.length){
		if(arrTableauImages[0] !== false){
			if(arrTableauImages[0].length <= 0){
				$(sSliderElementID+" img").attr("alt", "Le répertoire '"+sPathImage+"' est vide ou ne contient aucun fichier image.");
			}else{
				$(sSliderElementID+">ul").html(""); // On remplace la totalité des enfants...
				for(iIndexSlider=0;iIndexSlider<arrTableauImages.length;iIndexSlider++){
					sAltText=arrTableauImages[iIndexSlider].substring(0, arrTableauImages[iIndexSlider].indexOf('_'));
					$(sSliderElementID+">ul").append('<li><a href="produits.php?cat='+(iIndexSlider+1)+'"><img src="'+sPathImage+arrTableauImages[iIndexSlider]+'" alt="'+sAltText+'" title="" /></a></li>');
				}
				retour = true;
			}
		}else{
			sAltText = '<li><img src="" alt="Le répertoire \''+sPathImage+'\' est invalide." title="" /></li>';
			$(sSliderElementID+">ul").append(sAltText);
		}
	}
	return retour;
}

/** == EOF == **/
