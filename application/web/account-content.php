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
		<!--<div class="preferences">
			<div class="title">
				<label class="title">MES PREFERENCES</label>
			</div>
			<div class="data">-->
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
			<!--</div>-->

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
		<!--</div>-->
	</div>
	<div class="compte">
		<div class="title">
			MON COMPTE
		</div>
		<div class="data">

			<?php

			    require_once(dirname(dirname(__FILE__)) . "/common/php/class/class.user.php");
			    require_once(dirname(dirname(__FILE__)) . "/common/php/class/class.user_newsletter.php");

			    global $bdd;
			    global $_TABLES;
			    global $config;

			    $content_html = "<label for='last-name'>Nom : </label>
								<input class='input-text' type='text' name='last-name' id='account-last-name' placeholder='Nom' value='%%last-name%%' />
								<br/>
								<label for='first-name'>Prénom : </label>
								<input class='input-text' type='text' name='first-name' id='account-first-name' placeholder='Prénom' value='%%first-name%%' />
								<br/>
								<label for='birthday'>Date de naissance : </label>
								<input class='input-text' type='text' name='birthday' id='account-birthday' placeholder='Date de naissance : JJ / MM / AAAA' value='%%birthday%%' />
								<br/>
								<div>
									<label for='sex'>Sexe : </label>
									<input type='radio' name='sex' class='account-sex' value='1' %%sex-1%%>Homme</input>
									<input type='radio' name='sex' class='account-sex' value='0' %%sex-0%%>Femme</input>
								</div>
								<label for='email'>Email : </label>
								<input class='input-text' name='email' type='text' id='account-email' placeholder='Adresse email' value='%%email%%' />
								<br/>
								<label for='password'>Mot de passe : </label>
								<input class='input-text' name='password' type='password' id='account-password' placeholder='Mot de passe' />
								<br/>
								<label for='newsletter'>Newsletter : </label>
								<input type='checkbox' name='newsletter' id='account-newsletter' %%newsletter%% />";


			    if (session_status() == PHP_SESSION_NONE) {
			        session_start();
			    }

			    if(isset($_SESSION['user_id'])) {
			       	
			    	if(!is_null($bdd) && !is_null($_TABLES)) {
	                    $objUser = new User($bdd, $_TABLES);
	                    $user = $objUser->getData($_SESSION['user_id']);

	                    if(!is_null($user)) {
	                        $content_html = str_replace('%%last-name%%', $user->last_name, $content_html);
	                        $content_html = str_replace('%%first-name%%', $user->first_name, $content_html);

	                        $temp_birthday = explode("-", $user->birthday);
	                        $birthday = $temp_birthday[2] . '/' . $temp_birthday[1] . '/' . $temp_birthday[0];
	                        $content_html = str_replace('%%birthday%%', $birthday, $content_html);

	                        $content_html = str_replace('%%sex-' . $user->sex . '%%', 'checked', $content_html);
	                        if($user->sex) $content_html = str_replace('%%sex-0%%', '', $content_html);
	                        else $content_html = str_replace('%%sex-1%%', '', $content_html);

	                        $content_html = str_replace('%%email%%', $user->email, $content_html);

	                        $objUserNewsletter = new UserNewsletter($bdd, $_TABLES, $config);
	                        $user_newsletter = $objUserNewsletter->getExist($user->email);

	                        if($user_newsletter && !is_null($user_newsletter)) {
	                        	$content_html = str_replace('%%newsletter%%', 'checked', $content_html);
	                        }
	                        else {
	                        	$content_html = str_replace('%%newsletter%%', '', $content_html);
	                        }
	                        
	                        echo($content_html);
	                    }
	                    else {
	                        // 404
	                        echo "404 Not Found";
	                    }
	                }
	                else {
	                    error_log("BDD ERROR : " . $bdd);
	                    error_log("TABLES ERROR : " . $_TABLES);
	                }

			    } else {
			        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/");
			    }

			?>
			
		</div>
		<div class="button-validate account clickable"></div>
		<div class="account message valid">Mise à jour effectuée.</div>
		<div class="account message error">Une erreur est survenue.</div>
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