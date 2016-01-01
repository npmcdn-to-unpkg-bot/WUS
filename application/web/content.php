<content>
	<div class="options">
		<div class="connexion">
			<div class="link">
				<?php 
					if (session_status() == PHP_SESSION_NONE) {
					    session_start();
					}

					if(isset($_SESSION['user_auth']) && $_SESSION['user_auth'] == '1') {
						echo('<a href="#logout-box" id="deconnexion">DECONNEXION</a>');
					} else {
						echo('<a href="#login-box" id="connexion">CONNEXION</a>');
					}
				?>				
				<?php include('html/login.html'); ?>
			</div>
		</div>
		<div class="recherche">
			<div class="link">
				<a href="#" id="recherche"></a>
			</div>
			<div class="data">
				<input type="text" id="recherche_texte" placeholder="Recherche..." />
			</div>
		</div>
		<div class="preferences">
			<div class="title">
				<label class="title">MES PREFERENCES</label>
			</div>
			<div class="data">
				<?php include('categories.php'); ?>
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
		<div class="caroussel">
			<?php include('caroussel.php'); ?>
		</div>
		<div class="timeline">
			<?php include('timeline.php'); ?>
		</div>
	</div>
	<div class="informations">
		<div class="collaborateurs">
			<div class="title">
				<label class="title">NOS COLLABS</label>
			</div>
			<div class="data">
				<br/><br/><br/>
			</div>
			<div class="link">
				<a href="#">Voir la collection</a>
			</div>
		</div>
		<div class="newsletter">
			<div class="title">
				<label>NEWSLETTER</label>
			</div>
			<div class="data">
				<input type="text" id="newsletter_email" placeholder="Saisissez votre adresse e-mail" />
			</div>
		</div>
		<div class="suggestions">
			<div class="title">
				<label>SUGGESTIONS</label>
			</div>
			<div class="data">
				<br/><br/><br/>
			</div>
		</div>
		<div class="legale">
			<a href="#" id="faq">F.A.Q</a>
			<a href="#" id="cgu">Conditions générales d'utilisation</a>
			<a href="#" id="ml">Mentions légales</a>
		</div>
		<div class='copyright'>
			<label id='copyright'>What's Up Agency <?php echo(date('Y')); ?></label>
		</div>
	</div>
</content>