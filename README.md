#Général :
- J'ai mis ici le contenu de "Plan.md" pour simplifier la gestion un peu, considérant que c'est le premier fichier vu sur l'interface web et dans l'application Windows
- Tout les fichiers sont dans leur propre sous-répertoire pour pouvoir trouver aisément tout autre fichier (dont README.md) que l'on voudrais include hors du projet, peut-etre un fichier de lien, référence, quelques chose comme ça. 

#Olivier :
- [CSS] Passer au travers du CSS pour rassembler les règles qui se chevauchent ou s'annulent (en admettant qu'il y ais X+1 règles pour une seule entitée)
- [CSS] Éliminer les règles mortes
- [CSS, HTML] Passer le HTML au peigne fin pour voir ce qui pourrait se passer de classe ou ID et éliminer ou réécrire les règles concernées
- Incorporer au moins une animation CSS3. (slider? -> demande du TP, point 5)


#Eric :
- {FAIT} [TOUT] Tout copier (la version du cours de PHP) sur GitHub (à partir de l'application Windows)
- [JS, HTML, CSS] Réécrire/retirer le JS de la page formulaires/inscription pour utiliser au max les nouvelles tag/attributs HTML5, càd pousser en HTML/CSS
- {EN COURS}[HTML] Utiliser/ajouter les tags HTML5 tel que header, footer etc
- [HTML, CSS] Sous "Mon Profil"(nouvelle option qui apparait à côté du nom quand on est identifié); Ajouter une page de profil où les gens peuvent mettre leurs contacts et informations de paiement (pas obligé de supporter l'enregistrement?) (demande du TP, point 4)
- [CSS, JS] Une fois la règle en place, enlever le code hover en jQ et les ID dans PHP
- Dans "facture_client", "gestion_panier" remplacer le code autour de "$odd_even_row "  et dans "gestion_produits_factures" autour de "$class_fctr = ($nroLigne % 2 == 0)?'odd':'even';" pour utiliser la règle CSS "nth-child(event)" ci-dessous

###changements fait au HTML influencant le CSS:
* (div) #header => header
* (div) #header_menu => header nav
* (div) #footer => footer
* (div) #footer_menu => footer nav

###suggestions de changements au CSS:
1. {FAIT}  la classe cursor_hand devrais se lire (j'ai trouvé cette correction durant le cours de SEO)
.cursor_hand{
	cursor:pointer;
	/*cursor:hand;*/ /* IE 5.0, 5.5 */
}

2. Changer la règle "#listePanier tr.even, #factureClient tr.even" pour "#listePanier tr:nth-child(even),  #factureClient tr:nth-child(even)"

##Ce dont on devrais pouvoir se passer :
25. Fichier .htaccess
26. Ajouter plus de jouets

##Reserve
8. [HTML, CSS] Nécessairement explorer bootstrap ou au minimum intégrer les principes de responsives qui seront vu en classe
9. [HTML, CSS] Sous "Mon Profil"; permettre de consulter ses factures passées
10. [HTML, CSS] Sous "Mon Profil"; permettre de changer son mot de passe?
11. [HTML, VIDEO] Trouver un vidéo démo de jouet et ajouter ce jouet en image statique au catalogue
12. [VIDEO] conversion en tout les formats supportés
13. [HTML] composer le texte de la page (demande du TP, point 1)
14. [HTML, CSS] visionneuse d'image  (demande du TP, point 2) pourrais simplement être (une copie du) catalogue réarrangé
15. [CSS] Remplacer le code jQuery (qui ne fonctionne pas vraiment) pour animer l'apparition des sous-menu par une/des transitions sous une règle "li:hover>ul" ? Les IDs ne servent que pour jQuery donc si on suit "header nav>ul>li:nth-child(2)>ul",  "header nav>ul>li:nth-child(4)>ul" et "header nav>ul>li:nth-child(5)>ul" on devrais pouvoir éliminer les "<?php echo $MenusID; ?>menuNiv1_Item1_submenuX"

à propos question : le choix du fichier css se fait par PHP, JS, le navigateur en sachant à quel média chaque feuille est destinée? on cherche la réponse nous-même?

##"Stretch goals"
13. [3D, HTML, video] Représentation 3D d'un des jouets (l'un des monstres devrait être simple) qui tourne en turntable, et donc compter comme un media video
14. [HTML] Utiliser le "local storage" pour garder une copie du panier ?
15. [CSS, JS] Changer le code pour appliquer un filtre (CSS::class ou JS::style?) sur les images du catalogue pour simuler les couleurs?
16. [DB, AJAX] Passer en tout ou en partie les lectures en AJAX, ex: dans le catalogue, quand on clique une section {tout, puzzle, etc}, on remplace le contenu du array que PHP charge avec AJAX mais on ne fait rien (de différent) quand on clique les boutons prev/next jouet
17. [DB] Passer de CSV à MySQLi
18. [DB, AJAX] Passer la page d'ajouts des produits à AJAX pour lecture/écriture, l'exeption initiale est le chargement par PHP de la liste des items connus
19. [PHP] Pousser les fonctions qui s'occupent des items vers une/des classes?
20. [PHP] Pousser le panier plus loin pour qu'il sépare et reconnaisse les couleurs de jouets de façon à pouvoir commander le même en plusieurs couleurs?
21. [PHP, JS] Quand on ajoute un item au panier, qu'il y en as déjà ET que c'est la même couleur, demander si on doit ajouter à la quantité ou remplacer la quantité? Ou alors par défaut on ajoute ET on l'indique en haut de la page pour que le client sache ce qu'il s'est passé  
22. [HTML] Ajouter les éléments SEO (meta keywords/author/description/...), pour une version "porte-folio"
23. [WEB] Acheter un domaine et créer une page simple mais intéressante visuellement pour mener à chacun des projets (avec entre parenthèses si c'était un sujet imposé ou non et peut-être faits dans quels cours)
24. [TOUT] Site supplémentaire de 1-2 pages avec [média son] d'un concurrent qui vend des jouets électronique en plastique et qui se moque des ébéniste en faisant rouler un camion téléguidé sur une copie de la page d'accueil de la Fabrique en laissant des traces de pneus. "Le bois c'est pour les cure-dents!"
