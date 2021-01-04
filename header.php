<header>
	<div id="barreSuperieure">
		<p>Site fictif pour projet étudiant</p>
	</div>
	<div id="en_tete">
		<div id="logo_entete">
			<a href="index.php?page=espace"><img src="images/logo_gbaf.png" alt="logo_gbaf" height="80"/></a>
		</div>
		<div id="titre_entete">
			<a href="index.php?page=espace"><p>Groupement Banque Assurances Français</p></a>
		</div>

		<?php
		if ($_SESSION['titre'] === 'Connexion' || $_SESSION['titre'] === 'Inscription')
		{
		?>
			<nav class="Menu">
				<a href="index.php?page=inscription" class="Bouton">S'inscrire</a>
				<a href="index.php?page=connexion" class="Bouton">Se connecter</a>
			</nav>
		<?php
		}
		else 
		{  ?>
			<nav class="Menu">
				<div id="Accueil">
					<a href="index.php?page=espace" class="Bouton">Accueil</a>
				</div>
				<div id="Nom_prenom">
					<a class="Bouton"><?php echo htmlspecialchars($_SESSION['nom']) . ' ' . htmlspecialchars($_SESSION['prenom']);?></a>
					<div id="Menu_espace_personnel">
						<a href="index.php?page=parametres">Paramètres</a>
						<a href="index.php?page=deconnexion">Déconnexion</a>
					</div>
				</div>
			</nav>
		<?php } ?>

	</div>
</header>