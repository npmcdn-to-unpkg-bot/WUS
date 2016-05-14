<content>
	<div class="options">
		<?php

			include_once('ajax/controller.system_preference.php');

			if(getSystemPreference('mod_login')->mod_login == 1) {

				if (session_status() == PHP_SESSION_NONE) {
				    session_start();
				}

				echo('<div class="connexion">
						<div class="link">');

				if(isset($_SESSION['user_auth']) && $_SESSION['user_auth'] == '1') {
					echo('<a href="#logout" id="deconnexion">DECONNEXION</a>');
				} else {
					echo('<a href="#login" id="connexion">CONNEXION</a>');
				}

				echo('</div>
				</div>');

				require('html/login.html');
			}
		?>

		<?php

			echo('<div class="functions">
					<div class="home active"></div>
					<div class="search"></div>
				</div>');

		?>


		<?php

			/*include_once('ajax/controller.system_preference.php');

			if(getSystemPreference('mod_search')->mod_search == 1) {

				// FONCTION DESACTIVE CAR A CODER
				echo('<div class="recherche">
						<div class="link">
							<a href="#" id="recherche"></a>
						</div>
						<div class="data">
							<input type="text" id="recherche_texte" placeholder="Recherche..." />
						</div>
					</div>');

			}*/
		?>
		<!--<div class="preferences">
			<div class="title">
				<label class="title">PREFERENCES</label>
			</div>
			<div class="data">
				<?php 
					/*if (session_status() == PHP_SESSION_NONE) {
					    session_start();
					}
					
					if(isset($_SESSION['user_auth']) && $_SESSION['user_auth'] == '1') {
						require('preferences.php');
					} else {
						require('categories.php');
					}*/
				?>
			</div>

			<?php 
				/*if (session_status() == PHP_SESSION_NONE) {
				    session_start();
				}
				
				if(isset($_SESSION['user_auth']) && $_SESSION['user_auth'] == '1') {
					echo('<div class="button">
								<a href="#" id="preferences_valider" class="preferences_enregistrer"></a>
							</div>
							<div class="link">
								<a href="#" id="preferences_enregistrer" class="preferences_enregistrer">Enregistrer mes préférences</a>
							</div>');
				}*/
			?>
		</div>-->

		<?php 
			if (session_status() == PHP_SESSION_NONE) {
			    session_start();
			}
			
			if(!isset($_SESSION['user_auth']) || $_SESSION['user_auth'] == '0') {
				echo('<div class="medias">
					<div class="title">
						<label class="title">Mes abonnements</label>
					</div>
					<div class="data">');
							require('websites.php');
				echo('</div>
					</div>');

				echo('<div class="search-info">
						<label class="info">Abonne-toi à tes médias préférés pour les voir s\'afficher dans ton d\'actualité en cliquant sur l\'icône <span>Home</span> rouge.</label>
					</div>');
			}
		?>
	</div>
	<div class="articles active">

		<?php 
			if (session_status() == PHP_SESSION_NONE) {
			    session_start();
			}
			
			if(isset($_SESSION['user_auth']) && $_SESSION['user_auth'] == '1') {

				require('personnal-content.php');

			} else {
				include_once('ajax/controller.system_preference.php');

				if(getSystemPreference('mod_carrousel')->mod_carrousel == 1) {

					echo('<div class="caroussel">');
					require('caroussel.php');
					echo('</div>');
				}

				echo('<div class="timeline">');
				require('timeline.php');
				echo('</div>');
			}
		?>
	</div>
	<div class='recherche'>

		<div class='barre'>
			<div class='texte'>
				<input type="text" class='searched' placeholder="Recherche..."></input>
			</div>
			<div class='button'>
				<input type="button" class='searching'></input>
			</div>
		</div>
		<div class='resultat'></div>

	</div>
	<div class="informations">

		<?php

			include_once('ajax/controller.system_preference.php');

			if(getSystemPreference('mod_collaboration')->mod_collaboration == 1) {

				// FONCTION DESACTIVE CAR A CODER
				echo('<div class="collaborateurs">
						<div class="title">
							<label class="title">NOS COLLABS</label>
						</div>
						<div class="wrapper">
						<div class="data auto-slick">');
				
				require('collaboration.php');

				echo('</div>
					  </div>
						<div class="link">
							<a href="#">Voir la collection</a>
						</div>
					</div>');
			}
		?>

		<?php

			if(!isset($_SESSION['user_auth']) || $_SESSION['user_auth'] == '0') {

				include_once('ajax/controller.system_preference.php');

				if(getSystemPreference('mod_newsletter')->mod_newsletter == 1) {

					echo('<div class="newsletter">
							<div class="logo">
							</div>
							<div class="title">
								<label>INSCRIS-TOI A LA NEWSLETTER<br/>POUR NE RATER AUCUNE NEWS</label>
							</div>
							<div class="data">
								<div class="input">
									<input type="text" id="newsletter_email" placeholder="Saisis ton adresse e-mail" />
								</div>
								<div class="button">
									<a href="#" id="newsletter_valider" class="newsletter_valider"></a>
								</div>
								<div class="newsletter valid" style="color:green; display:none;border:0;font-size:18px">Enregistré.</div>
							</div>
						</div>');
				}
			}
		?>
		
		<?php

			/*if(isset($_SESSION['user_auth']) && $_SESSION['user_auth'] == '1') {

				include_once('ajax/controller.system_preference.php');

				if(getSystemPreference('mod_suggestion')->mod_suggestion == 1) {

					echo('<div class="suggestions">
							<div class="title">
								<label>SUGGESTIONS</label>
							</div>
							<div class="data">');
							require('suggestions.php');
							echo('</div>
						</div>');
				}
			}*/
		?>
		
		<div class="legale">
			<?php require('document.php'); ?>
		</div>
		<div class="account-link">
			<?php 
				if (session_status() == PHP_SESSION_NONE) {
				    session_start();
				}
				
				if(isset($_SESSION['user_auth']) && $_SESSION['user_auth'] == '1') {
					echo('<a href="/account">Mon compte</a>');
				}
			?>
		</div>
		<div class='copyright'>
			<label id='copyright'>What's Up Agency <?php echo(date('Y')); ?></label>
		</div>
	</div>
</content>