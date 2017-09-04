<?php
$sPageTitle = "Photos | Galerie";

require_once "inc/header.inc.php";

$path_Media = "images/produits/";
$types_Media = "jpg";
$reject_Media = 'broken_toy.jpg';
$str_Media = walkDirectory($path_Media, $types_Media);
$str_Media = str_replace($reject_Media, '', $str_Media);
$str_Media = str_replace('||', '|', $str_Media);
$arr_Medias = explode('|', $str_Media);

echo '<h1>Galerie photos</h1>', PHP_EOL;
echo '<div>', PHP_EOL;
foreach($arr_Medias as $image){
	echo '<div><img src="', $path_Media, $image, '" alt="', $image, '" /></div>', PHP_EOL;
}
echo '</div>', PHP_EOL;

require_once "inc/footer.inc.php";
?>
