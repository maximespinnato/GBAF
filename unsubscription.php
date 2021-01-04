<section class="form">
<h2>Souhaitez-vous vraiment vous désinscrire ?</h2>
<form action="index.php?page=unsubscription" method="POST">
	<p><label>Mot de passe : 
		<input type="password" name="password" id="password"
		<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
	</label></p>
	<p><input type="submit" value="Se désinscrire" class="square-button"/></p>
</form>
<?php
// Password verification
if (!empty($_POST['password']) && strlen($_POST['password']) <= MAX_LOGIN_LENGTH)
{
	$request = $bdd->prepare('SELECT password FROM members WHERE id_user = :id_user');
	$request->execute(['id_user' => $_SESSION['id_user']]);
	$datas = $request->fetch();
	// Account deletion
	if (password_verify($_POST['password'], $datas['password']))
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
		$request->closeCursor();
		setcookie('unsubscription', true, time() + 365*24*3600, null, null, false, true);
		header('Location: index.php?page=disconnexion');
	}
	$request->closeCursor();
	echo '<p class="check-message"><span class="invalid">Le mot de passe est invalide.</span></p>';
}
?>
<p><a href="index.php?page=parameters">Retour aux paramètres</a></p>
</section>