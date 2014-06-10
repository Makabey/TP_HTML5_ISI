<?php
$sPageTitle = "Photos | Galerie | ";

#require_once "assets/inc/csvFunctions.inc.php";
require_once "assets/inc/header.inc.php";

$path_Media = "assets/images/produits/";
$reject_Media = 'broken_toy.jpg';

$str_Media = walkDirectory($path_Media, "jpg");

#var_dump($str_Media);

$str_Media = str_replace($reject_Media, '', $str_Media);
$str_Media = str_replace('||', '|', $str_Media);

$arr_Media = explode('|', $str_Media);

#var_dump($arr_Media);

?>
			<h1>Galerie photos</h1>
			<div>
			<?php
				foreach($arr_Media as $image){
					echo '<div>';
					echo '<img src="', $path_Media, $image, '" alt="', $image, '" />';
					echo '</div>';
					echo PHP_EOL;
				}
			?>
			</div>
<?php
require_once "assets/inc/footer.inc.php";
?>

<!--
/* galerie photo tiles */
#galerie_photos #content{
	text-align:center;
}

#galerie_photos #content>div{
/*.galerie_photos_tiles{*/
	border:1px dashed green;
	margin:0 auto;
	width:800px; /*100%;*/
	position:relative;
	/*display:flex;
	flex-direction:row;*/
}
/*#galerie_photos #content>div>div{
	border:1px dotted blue;
	display:inline-block;
}*/
#galerie_photos #content>div img{
	/*height:100%;*/
	width:170px;
	/*vertical-align:middle;*/
	/*display:table-cell;*/
	margin:20px;
	transition:1s all;
	border:1px dotted green;
}
#galerie_photos #content>div img:hover{
	/*z-index:10;*/
	/*height:250px;*/
	width:190px;
	margin:0;
}

/* \galerie photo tiles */
-->