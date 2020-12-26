<header>
	<div id="barreSuperieure">
		<p>Site fictif pour projet étudiant</p>
	</div>
	<div id="en_tete">
		<div id="logo_entete">
			<a href="index.php?page=home"><img src="images/logo_gbaf.png" alt="logo_gbaf" height="80"/></a>
		</div>
		<div id="titre_entete">
			<a href="index.php?page=home"><p>Groupement Banque Assurances Français</p></a>
		</div>

		<?php
		if ($_SESSION['title'] === 'Connexion' || $_SESSION['title'] === 'Inscription')
		{
		?>
			<nav class="Menu">
				<a href="index.php?page=registration" class="bouton">S'inscrire</a>
				<a href="index.php?page=connexion" class="bouton">Se connecter</a>
			</nav>
		<?php
		}
		else 
		{  ?>
			<nav class="Menu">
				<div id="Accueil">
					<a href="index.php?page=home" class="bouton">Accueil</a>
				</div>
				<div id="name_firstname">
					<a class="bouton"><?= htmlspecialchars($_SESSION['lastname']) . ' ' . htmlspecialchars($_SESSION['firstname']) ?></a>
					<div id="Menu_espace_personnel">
						<a href="index.php?page=parameters">Paramètres</a>
						<a href="index.php?page=disconnection">Déconnexion</a>
					</div>
				</div>
			</nav>
		<?php } ?>
	</div>
</header>