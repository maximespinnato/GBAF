<header>
	<div id="upper-bar">
		<p>Site fictif pour projet étudiant</p>
	</div>
	<div id="top-bar">
		<div id="logo-top-bar">
			<a href="index.php?page=home"><img src="images/logo_gbaf.png" alt="logo_gbaf" height="80"></a>
		</div>
		<div id="title-top-bar">
			<a href="index.php?page=home"><p>Groupement Banque Assurances Français</p></a>
		</div>

		<?php
		if ($_SESSION['title'] === 'Connexion' || $_SESSION['title'] === 'Inscription')
		{
		?>
			<nav class="Menu">
				<a href="index.php?page=registration" class="button">S'inscrire</a>
				<a href="index.php?page=connexion" class="button">Se connecter</a>
			</nav>
		<?php
		}
		else 
		{  ?>
			<nav class="Menu">
				<div id="home">
					<a href="index.php?page=home" class="button">Accueil</a>
				</div>
				<div id="name-and-firstname">
					<a class="button"><?php echo htmlspecialchars($_SESSION['name']) . ' ' . htmlspecialchars($_SESSION['firstname']);?></a>
					<div id="home-menu">
						<a href="index.php?page=parameters">Paramètres</a>
						<a href="index.php?page=disconnexion">Déconnexion</a>
					</div>
				</div>
			</nav>
		<?php } ?>

	</div>
</header>