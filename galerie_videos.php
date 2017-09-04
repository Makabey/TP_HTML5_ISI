<?php
$sPageTitle = "Vidéos | Galerie";

require_once "inc/header.inc.php";

$videoWidth = 500;
$videoHeight = 281;
$path_Media = "videos/";
$types_Media = "mp4|ogv|ogg|3gp|flv|webm";
$str_Media = walkDirectory($path_Media, $types_Media);

// fonction qui analyse les noms et les classent avec les extensions
$arrMedias = (!empty($str_Media))?explode('|', $str_Media):null;
$arrMediasClasses=null;
$arrNomsVideos=null;
if(!empty($arrMedias)){
	foreach($arrMedias as $nom_media){
		$nom_mediaExp = explode('.', $nom_media);
		$arrMediasClasses[$nom_mediaExp[0]][strtolower($nom_mediaExp[count($nom_mediaExp)-1])] = $nom_media;
	}
	$retour = chargerNomsVideos($arrNomsVideos);
}
?>
			<h1>Galerie vidéos</h1>
			<?php
				if(!empty($arrMediasClasses)){
					$numeroVideo = 0;
					foreach($arrMediasClasses as $videoName => $videoFormats){
						$numeroVideo++;
						$vFallback=null;
						echo '<div>', PHP_EOL, '<video id="movie',$numeroVideo,'" controls="controls">', PHP_EOL;
						foreach($videoFormats as $vFormat => $nomFichier){
							if($vFormat != 'flv'){
								$path_complet = str_replace(chr(32), "%20", $path_Media . $nomFichier);
								echo '<source src="', $path_complet, '" type="video/';
								echo (substr($vFormat, 0, 2) == "og")?'ogg':$vFormat;
								echo '">', PHP_EOL;
							}
							if(($vFormat == 'mp4') && (false !== array_key_exists('flv', $videoFormats))){
								$path_complet = str_replace(chr(32), "%20", $path_Media . $videoFormats['mp4']);
								$vFallback .= '<embed src="' . $path_complet . '" type="application/x-shockwave-flash" width="'. $videoWidth . '" height="'. $videoHeight . '" allowscriptaccess="always" allowfullscreen="true" autoplay="false">'. PHP_EOL;
							}
						}
						echo $vFallback, '</video>', PHP_EOL;

						if(!empty($arrNomsVideos)){
							if(isset($arrNomsVideos[$videoName])){
								echo '<h4>', $arrNomsVideos[$videoName]['titre'], '</h4>', PHP_EOL;
								if(!empty($arrNomsVideos[$videoName]['lien'])){
									echo '<p><a href="', $arrNomsVideos[$videoName]['lien'], '">( Acheter ce produit )</a></p>', PHP_EOL;
								}
							}else{
								echo '<h4>"', $videoName, '"</h4>', PHP_EOL;
							}
						}
						echo '</div>', PHP_EOL;
					}
				}else{
					echo '<div class="boiteErreursFormulaires" id="boiteErreursFormulaires_Login"><span>Erreur! Aucune vidéo trouvée!</span></div>';
				}

require_once "inc/footer.inc.php";
?>
