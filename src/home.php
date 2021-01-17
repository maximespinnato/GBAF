<?php
// Creation of auto connection cookies
if (isset($_SESSION['auto_connection']) && $_SESSION['auto_connection'])
{
	setcookie('auto_connection', true, time() + 365*24*3600, null, null, false, true);
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
			Nous vous présentons ici les acteurs avec qui nous travaillons. Vous pouvez consulter leur description et donner votre avis professionnel sur chacun d'entre eux.
		</p>
	</section>
	<section id="actors">
		<?php
		// Actors display
		$request = $bdd->prepare('SELECT id_actor,actor,description FROM actors');
		$request->execute();
		while ($actorDatas = $request->fetch())
		{
			$imageName = preg_replace("# #","_", $actorDatas['actor']);
			echo '<article><div><a href="../public/index.php?page=actor_page&amp;actor=' . $actorDatas['id_actor'] . '"><img src="../public/img/logo_' . $imageName . '.png" alt="logo_' . $actorDatas['actor'] . '" ></a></div>';
			echo '<div><a href="../public/index.php?page=actor_page&amp;actor=' . $actorDatas['id_actor'] . '"><h3>' . $actorDatas['actor'] . '</h3></a>';
			echo '<p>' . substr($actorDatas['description'], 0, strpos($actorDatas['description'], '<br')) . '</p></div>';
			echo '<div><a href="../public/index.php?page=actor_page&amp;actor=' . $actorDatas['id_actor'] . '">Lire plus</a></div></article>';
		}
		$request->closeCursor();
		?>
	</section>
</main>