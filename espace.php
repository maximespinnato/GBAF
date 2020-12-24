<?php
// Crée les cookies de connexion automatique 
if (isset($_SESSION['connexion_auto']) && $_SESSION['connexion_auto'])
{
	setcookie('connexion_auto', true, time() + 365*24*3600, null, null, false, true);
	setcookie('pseudo', $_SESSION['pseudo'], time() + 365*24*3600, null, null, false, true);
	setcookie('motdepasse_hache', $_SESSION['motdepasse_hache'], time() + 365*24*3600, null, null, false, true);
}
?>
<main>
	<section id="banner">
		<h1>Groupement Banque Assurances Français</h1>
		<p>
			Représentant de la profession bancaire et des assureurs sur tous
			les axes de la réglementation financière française
		</p>
		<span id="img_banniere"></span>
		<!--<img src="images/gbaf_banniere.jpg" alt="gbaf_banniere" id="img_banniere" height="30em" />-->
	</section>
	<section id="presentation_acteurs">
		<h2>Partenaires</h2>
		<p>
			Nous vous présentons ici les acteurs avec qui on travaille. Vous pouvez consulter leur description, et donner votre avis professionnel sur chacun d'entre eux.
		</p>
	</section>
	<section id="acteurs">
		<?php
		// Affichage des acteurs
		$requete = $bdd->prepare('SELECT id_actor,actor,description FROM actors');
		$requete->execute();
		while ($donnees = $requete->fetch())
		{
			echo '<article><div><a href="index.php?page=page_acteur&amp;acteur=' . $donnees['id_actor'] . '"><img src="images/logo_' . $donnees['actor'] . '.png" alt="logo_' . $donnees['actor'] . '" /></a></div>';
			echo '<div><a href="index.php?page=page_acteur&amp;acteur=' . $donnees['id_actor'] . '"><h3>' . $donnees['actor'] . '</h3></a>';
			echo '<p>' . substr($donnees['description'], 0, strpos($donnees['description'], '<br')) . '</p></div>';
			echo '<div><a href="index.php?page=page_acteur&amp;acteur=' . $donnees['id_actor'] . '">Lire plus</a></article></div>';
		}
		$requete->closeCursor();
		?>
	</section>
</main>