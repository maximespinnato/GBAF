<section class="formulaire">
<h2>Souhaitez-vous vraiment vous désinscrire ?</h2>
<form action="index.php?page=desinscription" method="POST">
	<p><label>Mot de passe : 
		<input type="password" name="motdepasse" id="motdepasse"
		<?php echo 'maxlength="' . MAX_LOGIN . '"';?> />
	</label></p>
	<p><input type="submit" value="Se désinscrire" class="boutonCarre"/></p>
</form>
<?php
// Vérification du mot de passe
if (!empty($_POST['motdepasse']) && strlen($_POST['motdepasse']) <= MAX_LOGIN)
{
	$requete = $bdd->prepare('SELECT password FROM members WHERE id_user = :id_user');
	$requete->execute(['id_user' => $_SESSION['id_user']]);
	$donnees = $requete->fetch();
	// Suppression du compte
	if (password_verify($_POST['motdepasse'], $donnees['password']))
	{
		$suppression = $bdd->prepare('DELETE FROM members WHERE id_user = :id_user');
		$suppression->execute(['id_user' => $_SESSION['id_user']]);
		$suppression->closeCursor();
		$suppression = $bdd->prepare('DELETE FROM likes WHERE id_user = :id_user');
		$suppression->execute(['id_user' => $_SESSION['id_user']]);
		$suppression->closeCursor();
		$suppression = $bdd->prepare('DELETE FROM comments WHERE id_user = :id_user');
		$suppression->execute(['id_user' => $_SESSION['id_user']]);
		$suppression->closeCursor();
		$requete->closeCursor();
		setcookie('desinscription', true, time() + 365*24*3600, null, null, false, true);
		header('Location: index.php?page=deconnexion');
	}
	$requete->closeCursor();
	echo '<p class="messageVerif"><span class="invalide">Le mot de passe est invalide.</span></p>';
}
?>
<p><a href="index.php?page=parametres">Retour aux paramètres</a></p>
</section>