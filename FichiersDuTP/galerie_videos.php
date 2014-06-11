<?php
$sPageTitle = "Vidéos | Galerie | ";

#require_once "assets/inc/csvFunctions.inc.php";
require_once "assets/inc/header.inc.php";

$videoWidth = 500; #320
$videoHeight = 281; #180

$path_Media = "assets/videos/";
$types_Media = "mp4|ogv|ogg|3gp|flv|webm";
#$reject_Media = '';

$str_Media = walkDirectory($path_Media, $types_Media);

#var_dump($str_Media);

#$str_Media = str_replace($reject_Media, '', $str_Media);
#$str_Media = str_replace('||', '|', $str_Media);

#var_dump($str_Media);

// fonction qui analyse les noms et les classent avec les extensions
$arr_Medias = (!empty($str_Media))?explode('|', $str_Media):null;
$arr_MediasClasses=null;
if(!empty($arr_Medias)){
	foreach($arr_Medias as $nom_media){
		$nom_mediaExp = explode('.', strtolower($nom_media));
		$arr_MediasClasses[$nom_mediaExp[0]][$nom_mediaExp[count($nom_mediaExp)-1]] = $nom_media;
	}
}

#var_dump($arr_Medias);
#var_dump($arr_MediasClasses);
?>
			<h1>Galerie vidéos</h1>
			<!--<div>-->
			<?php
				if(!empty($arr_MediasClasses)){
					#$iCmpt=1;
					$vFallback=null;
					# Code ci-dessous à réécrire une fois que j'aurais de vrai données!
					foreach($arr_MediasClasses as $videoName => $videoFormats){
						#echo '<div>';
						#echo '<video id="movie" width="', $videoWidth, '" height="', $videoHeight, '" controls="controls">', PHP_EOL;
						echo '<video id="movie" controls="controls">', PHP_EOL;
						foreach($videoFormats as $vFormat => $nomFichier){
							if($vFormat != 'flv'){
								echo '<source src="', $path_Media, $nomFichier, '" type="video/';
								echo (substr($vFormat, 0, 2) == "og")?'ogg':$vFormat;
								echo '">', PHP_EOL;
							}
							if(($vFormat == 'mp4') && (false !== array_key_exists('flv', $videoFormats))){
								$vFallback = '<object data="' . $path_Media . $videoName . '.mp4" width="' . $videoWidth . '" height="' . $videoHeight . '">'. PHP_EOL;
								$vFallback .= '<embed src="' . $path_Media . $videoName . '.flv" width="'. $videoWidth. '" height="'. $videoHeight. '">'. PHP_EOL;
								$vFallback .= '</object>';
							}
						}
						echo $vFallback;
						echo '</video>', PHP_EOL;
						#echo '</div>';
						echo PHP_EOL;

						/*$iCmpt++;
						if($iCmpt % 2 == 0){
							echo '</div>', PHP_EOL, '<div>';
						}*/
					}
				}else{
					echo '<div class="boiteErreursFormulaires" id="boiteErreursFormulaires_Login"><span>Erreur! Aucune vidéo trouvée!</span></div>';
				}
			?>
			<!--</div>-->
			
<?php
require_once "assets/inc/footer.inc.php";
?>
