<?php
// Creation of auto connexion cookies
if (isset($_SESSION['auto_connexion']) && $_SESSION['auto_connexion'])
{
	setcookie('auto_connexion', true, time() + 365*24*3600, null, null, false, true);
	setcookie('login', $_SESSION['login'], time() + 365*24*3600, null, null, false, true);
	setcookie('hash_password', $_SESSION['hash_password'], time() + 365*24*3600, null, null, false, true);
}
?>
<main>
	<section id="banner">
		<h1>Groupement Banque Assurances Français</h1>
		<p>
			Représentant de la profession bancaire et des assureurs sur tous
			les axes de la réglementation financière française
		</p>
		<span id="banner-image"></span>
	</section>
	<section id="actors-presentation">
		<h2>Partenaires</h2>
		<p>
			Nous vous présentons ici les acteurs avec qui on travaille. Vous pouvez consulter leur description, et donner votre avis professionnel sur chacun d'entre eux.
		</p>
	</section>
	<section id="actors">
		<?php
		// Actors display
		$request = $bdd->prepare('SELECT id_actor,actor,description FROM actors');
		$request->execute();
		while ($datas = $request->fetch())
		{
			$imageName = preg_replace("# #","_", $datas['actor']);
			echo '<article><div><a href="index.php?page=actor_page&amp;actor=' . $datas['id_actor'] . '"><img src="images/logo_' . $imageName . '.png" alt="logo_' . $datas['actor'] . '" ></a></div>';
			echo '<div><a href="index.php?page=actor_page&amp;actor=' . $datas['id_actor'] . '"><h3>' . $datas['actor'] . '</h3></a>';
			echo '<p>' . substr($datas['description'], 0, strpos($datas['description'], '<br')) . '</p></div>';
			echo '<div><a href="index.php?page=actor_page&amp;actor=' . $datas['id_actor'] . '">Lire plus</a></div></article>';
		}
		$request->closeCursor();
		?>
	</section>
</main>