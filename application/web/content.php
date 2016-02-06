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
					echo('<a href="#logout" id="deconnexion">DECONNEXION</a><br/>');
					echo('<a href="#params" id="params">PARAMETRES</a><br/>');
				} else {
					echo('<a href="#login" id="connexion">CONNEXION</a>');
				}

				echo('</div>
				</div>');

				include('html/login.html');
			}
		?>
		<?php

			include_once('ajax/controller.system_preference.php');

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

			}
		?>
		<div class="preferences">
			<div class="title">
				<label class="title">MES PREFERENCES</label>
			</div>
			<div class="data">
				<?php 
					if (session_status() == PHP_SESSION_NONE) {
					    session_start();
					}
					
					if(isset($_SESSION['user_auth']) && $_SESSION['user_auth'] == '1') {
						include('preferences.php');
					} else {
						include('categories.php');
					}
				?>
			</div>

			<?php 
				if (session_status() == PHP_SESSION_NONE) {
				    session_start();
				}
				
				if(isset($_SESSION['user_auth']) && $_SESSION['user_auth'] == '1') {
					echo('<div class="button">
								<a href="#" id="preferences_valider" class="preferences_enregistrer"></a>
							</div>
							<div class="link">
								<a href="#" id="preferences_enregistrer" class="preferences_enregistrer">Enregistrer mes préférences</a>
							</div>');
				}
			?>
		</div>
	</div>
	<div class="articles">
		<?php

			include_once('ajax/controller.system_preference.php');

			if(getSystemPreference('mod_carrousel')->mod_carrousel == 1) {

				echo('<div class="caroussel">');
				include('caroussel.php');
				echo('</div>');
			}
		?>
		<div class="timeline">
			<?php include('timeline.php'); ?>
		</div>
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
				
				include('collaboration.php');

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

					// FONCTION DESACTIVE CAR A CODER
					echo('<div class="newsletter">
							<div class="title">
								<label>NEWSLETTER</label>
							</div>
							<div class="data">
								<div class="input">
									<input type="text" id="newsletter_email" placeholder="Saisissez votre adresse e-mail" />
								</div>
								<div class="button">
									<a href="#" id="newsletter_valider" class="newsletter_valider"></a>
								</div>
							</div>
						</div>');
				}
			}
		?>
		
		<?php

			include_once('ajax/controller.system_preference.php');

			if(getSystemPreference('mod_suggestion')->mod_suggestion == 1) {

				// FONCTION DESACTIVE CAR A CODER
				echo('<div class="suggestions">
						<div class="title">
							<label>SUGGESTIONS</label>
						</div>
						<div class="data">
							<br/><br/><br/>
						</div>
					</div>');
			}
		?>
		
		<div class="legale">
			<?php include('document.php'); ?>
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