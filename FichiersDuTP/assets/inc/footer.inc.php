
			</div><!-- END of div::content -->

			<footer>
				<div id="footer_content"><?php
					#echo "\n";
					$MenusID="footer_"; # chaines à ajouter aux noms de classes dans "menu.php" pour distinguer entre l'utilisation dans le header et dans le footer
					require "assets/inc/menu.inc.php";
					?>

					<!-- non fonctionnel DÉCORATIF-->
					<div id="langues_regions">
						<a href="index.php">
							<img src="assets/images/drapeau.png" alt="région et langue" class="drapeau" />Français ( Canada )
						</a>
						<a href="index.php">
							<img src="assets/images/arrowregion.png" alt="region et langue" class="arrowregion" /> English ( USA )
						</a>
					</div>
				</div>
			</footer>
		</div>
	</body>
</html>
