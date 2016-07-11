<content class="row">
	<div class="col-*-12">
		<!-- left part -->
        <div class="options hidden-xs hidden-sm col-md-3 col-lg-2">
        	<div class="row">
        		<div class="col-md-12 col-lg-12 container-logout">
        			<a class="logout">DECONNEXION</a>
        		</div>
        		<?php
					require('html/login.html');
				?>
        	</div>

        	<div class="row">
    			<div class="col-md-12 col-lg-12 container-functions">
					<div class="col-md-6 col-lg-6 home active"></div>
					<div class="col-md-6 col-lg-6 search"></div>
				</div>
        	</div>

        	<div class="row">
        		<div class="col-md-12 col-lg-12 container-subscription">
        			<div class="medias">
						<div class="title">
							<label class="title">Mes abonnements</label>
						</div>
						<div class="data">
							<ul>
							<?php 
								if (session_status() == PHP_SESSION_NONE) session_start();
								require('websites.php');
							?>
							</ul>
						</div>
					</div>
					<div class="search-info">
						<label class="info">Abonne-toi à tes médias préférés pour les voir s'afficher dans ton d'actualité en cliquant sur l'icône <span>Home</span> rouge.</label>
					</div>
        		</div>
        	</div>

        	<div class="row">
    			<div class="col-md-12 col-lg-12 container-legale">
					<?php require('document.php'); ?>
				</div>
        	</div>

        	<div class="row">
    			<div class="col-md-12 col-lg-12 container-account-link">
					<a href="/account">Mon compte</a>
				</div>
        	</div>

        	<div class="row">
    			<div class='col-md-12 col-lg-12 container-copyright'>
					<label id='copyright'>What's Up Agency <?php echo(date('Y')); ?></label>
				</div>
        	</div>
        </div>
        <!-- right part -->
        <div class="col-xs-12 col-md-9 col-xl-10">
			<div class="row articles">
				<div class="col-md-12 col-lg-12 timeline grid" data-masonry='{ "itemSelector": ".grid-item", "percentPosition": true, "gutter": 10 }'>
				<?php 
					if (session_status() == PHP_SESSION_NONE) session_start();
					require('timeline.php');
				?>
				</div>
			</div>
			<div class='row recherche'>
				<div class='col-md-12 col-lg-12 barre'>
					<div class='texte'>
						<input type="text" class='searched' placeholder="Recherche..."></input>
					</div>
					<div class='button'>
						<input type="button" class='searching'></input>
					</div>
				</div>
				<div class='col-md-12 col-lg-12 result-searching grid' data-masonry='{ "itemSelector": ".grid-item", "percentPosition": true, "gutter": 10 }'></div>
			</div>
        </div>
    </div>
</content>