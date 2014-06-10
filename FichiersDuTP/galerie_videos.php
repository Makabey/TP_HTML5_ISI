<?php
$sPageTitle = "Photos | Galerie | ";

#require_once "assets/inc/csvFunctions.inc.php";
require_once "assets/inc/header.inc.php";

$path_Media = "assets/images/videos";
$reject_Media = 'broken_toy.jpg';

$str_Media = walkDirectory($path_Media, "mov|avi|mp4|ogv|ogg");

var_dump($str_Media);

$str_Media = str_replace($reject_Media, '', $str_Media);
$str_Media = str_replace('||', '|', $str_Media);

var_dump($str_Media);

?>
			<h1>Galerie vidéos</h1>

			
<?php
require_once "assets/inc/footer.inc.php";
?>
