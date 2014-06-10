<?php
$sPageTitle = "Vidéos | Galerie | ";

#require_once "assets/inc/csvFunctions.inc.php";
require_once "assets/inc/header.inc.php";

$path_Media = "assets/videos/";
$types_Media = "mov|avi|mp4|ogv|ogg";
#$reject_Media = '';

$str_Media = walkDirectory($path_Media, $types_Media);

#var_dump($str_Media);

#$str_Media = str_replace($reject_Media, '', $str_Media);
#$str_Media = str_replace('||', '|', $str_Media);

var_dump($str_Media);

// fonction qui analyse les noms et les classent avec les extensions
$arr_Medias = (!empty($str_Media))?explode('|', $str_Media):null;
$arr_MediasClasses=null;
if(!empty($arr_Medias)){
	foreach($arr_Medias as $nom_media){
		$nom_mediaExp = explode('.', $nom_media);
		$arr_MediasClasses[$nom_mediaExp[0]][$nom_mediaExp[count($nom_mediaExp)-1]] = $nom_media;
	}
}

var_dump($arr_Medias);
var_dump($arr_MediasClasses);
exit();
?>
			<h1>Galerie vidéos</h1>
			<div>
			<?php
				if(!empty($arr_MediasClasses)){
					$iCmpt=1;
					# Code ci-dessous à réécrire une fois que j'aurais de vrai données!
					foreach($arr_Medias as $image){
						echo '<div>';
						echo '<img src="', $path_Media, $image, '" alt="', $image, '" />';
						echo '
						
						
									<video id="movie" width="320" height="240">
				<source src="video/small.mp4" type="video/mp4">
				<source src="video/small.ogv" type="video/ogg">
				<source src="video/small.webm" type="video/webm">
				<source src="video/small.3gp" type="video/3gp">
				<object data="video/small.mp4" width="320" height="240">
					<embed src="video/small.flv" width="320" height="240">
				</object>
			</video>
						';
						echo '</div>';
						echo PHP_EOL;

						$iCmpt++;
						if($iCmpt % 2 == 0){
							echo '</div>',  PHP_EOL, '<div>';
						}
					}
				}
			?>
			</div>
			
<?php
require_once "assets/inc/footer.inc.php";
?>
