<?php
$sPageTitle = "La Fabrique de Jouet - À propos de nous";

require_once "assets/inc/header.inc.php";
?>
				<article>
					<h3>Nos méthodes de fabrication</h3>
					<div>
						<img src="assets/images/apropos_img1.jpg" alt="Utilisation d'outils moderne pour découper nos pièces" title="Utilisation d'outils moderne pour découper nos pièces" />
						<p> Donec pharetra dui in mattis luctus. Quisque vitae commodo erat. Etiam ultrices tempor quam, vel fermentum libero porta condimentum. Vivamus volutpat consectetur massa, ac commodo libero interdum id. Praesent feugiat est odio, nec luctus justo congue at. Mauris sed laoreet arcu. Aliquam vel diam eu augue vulputate gravida id non ipsum. Proin eleifend sollicitudin imperdiet. In tempor mauris ultricies justo vehicula, vitae consequat ipsum pulvinar. Pellentesque sollicitudin dolor at facilisis aliquet. Suspendisse dignissim in urna et fringilla.</p>
						<p>Proin tempus vestibulum sapien, nec lobortis nibh faucibus ac. Pellentesque dignissim, libero nec ultrices pellentesque, dui dui ultricies ligula, eget molestie augue dolor eu felis. Donec quis dignissim odio. Phasellus quis augue ac dui consequat tincidunt. Quisque quis lectus velit. Vestibulum quis orci nisi. Vestibulum sollicitudin ut est nec fermentum. Suspendisse quis arcu in tortor porttitor tincidunt at iaculis justo. Sed quis vestibulum justo. Maecenas sagittis erat vel porttitor pellentesque. Proin consequat vehicula erat a hendrerit. Maecenas sit amet tellus et quam semper ullamcorper vel ac justo. Vestibulum bibendum pharetra libero, sed facilisis enim porta vitae. Duis nec fermentum sem. Ut ullamcorper dui in mollis pulvinar. Mauris lacus arcu, viverra ut consequat et, sodales eu quam.</p>
					</div>
				</article>

				<article>
					<h3>Notre service de jouet "sur mesure"</h3>
					<div>
						<img src="assets/images/apropos_img2.jpg" alt="Les ciseaux à bois, notre principal outils" title="Les ciseaux à bois, notre principal outils" />
						<p>Morbi in lorem dui. Aenean mattis, dolor ac faucibus adipiscing, ligula nibh aliquet augue, quis hendrerit dui lacus vel libero. Curabitur vulputate ac diam id sagittis. Quisque non gravida nibh. Praesent ligula tortor, adipiscing vitae nisi a, cursus ultricies ipsum. Sed lobortis justo feugiat cursus adipiscing :</p>
						<ul>
							<li>Duis adipiscing mi</li>
							<li>Maecenas non est nec</li>
							<li>Phasellus nec lacus</li>
							<li>Aliquam dictum fringilla</li>
							<li>Nullam faucibus</li>
							<li>Mauris facilisis</li>
						</ul>
						<p>Cras ultricies tincidunt pretium. Etiam vitae ultricies diam, non fringilla urna. Nam suscipit feugiat tortor, tempor interdum ipsum tempor eget. Nam volutpat enim id ipsum auctor, vel ullamcorper orci tincidunt. Cras aliquet eros at luctus aliquam. Etiam ornare nisi eget lobortis lacinia. Aliquam ornare adipiscing purus. Proin porttitor bibendum ipsum, sed sollicitudin diam feugiat eget. Donec a facilisis elit. Proin ligula nulla, ornare nec ipsum et, convallis luctus enim.</p>
					</div>
				</article>

				<article>
					<h3>Une petite histoire de notre entreprise</h3>
					<div>
						<img src="assets/images/apropos_img3.jpg" alt="Tracer trois fois plutôt qu'une" title="Tracer trois fois plutôt qu'une" />
						<p>Pellentesque dolor sem, varius non aliquam eu, non sem. Maecenas ac odio et augue ultrices malesuada. Mauris feugiat tellus sed eleifend condimentum. Morbi mattis bibendum tempor. Ut dui quam, pretium ut elementum a, pretium varius risus. Praesent eros dui, facilisis eget nisi eget, placerat aliquam dui. Aenean vel iaculis risus, non gravida turpis. Sed accumsan tortor in lorem condimentum pharetra. Donec ornare massa sit amet est malesuada cursus. Sed quis posuere elit. Quisque malesuada sapien enim, quis porta tellus consectetur eget. Aenean tincidunt varius lectus ac pharetra. Maecenas euismod, enim ac adipiscing accumsan, arcu nibh sollicitudin nibh, consectetur adipiscing enim eros ultricies erat. Nullam auctor lectus ut diam fringilla tempus eu a nunc. Phasellus malesuada nunc nec tortor faucibus congue. Donec elit sapien, accumsan vitae lacus blandit, posuere suscipit libero.</p>
					</div>
				</article>

				<section>
					<h3>Contactez-nous</h3>
					<div>
						<div>
							<div>
								<h4>Notre boutique est située au:</h4>
								<p>138 Rue du Collège</p>
								<p>Saint-Adolphe-d'Howard, QC</p>
								<p>J0T 2B0</p>
								<p>tél: 819-289-9415</p>
								<table>
									<tr><th colspan="2">Heures d'ouverture:</th></tr>
									<tr><td>Lundi au Mercredi: </td><td>10h - 18h</td></tr>
									<tr><td>Jeudi et Vendredi:</td><td>10h - 20h</td></tr>
									<tr><td>Samedi:</td><td>10h - 17h</td></tr>
									<tr><td>Dimanche:</td><td>12h - 17h</td></tr>
								</table>
								<div>
									<div>
										<div></div>
										<div></div>
									</div>
									<h4>Itinéraire</h4>
									<div></div>
									<!--
									http://maps.googleapis.com/maps/api/distancematrix/json?origins=45.5440916,-73.6402476&destinations=45.970071,-74.337835&language=fr-FR
									http://maps.googleapis.com/maps/api/directions/json?origin=45.5440916,-73.6402476&destination=45.970071,-74.337835&language=fr-FR
									-->
								</div>
							</div>
						</div>
						<div id="map-canvas"></div>
					</div>
				</section>
<?php
require_once "assets/inc/footer.inc.php";
?>
