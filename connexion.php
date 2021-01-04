<?php
$login = '';
$password = '';
$cookiePassword = '';
$_SESSION['loginQuestion'] = '';

?>
<section class="form">
<?php 
if (isset($_COOKIE['registration']) && $_COOKIE['registration'])
{
	echo '<p class="check-message"><span class="modified">Vous vous êtes bien inscrit</span></p>';
	setcookie('registration','');
}
if (isset($_COOKIE['unsubscription']) && $_COOKIE['unsubscription'])
{
	echo '<p class="check-message"><span class="modified">Vous vous êtes bien désinscrit</span></p>';
	setcookie('unsubscription','');
}
?>
<h1>Connexion</h1>
<form action="index.php?page=connexion" method="POST"> 
	<fieldset>
		<p><label>Identifiant:<br />
				<input type="text" name="login" id="login" 
					<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
			</label></p>
		<p><label>Mot de passe :<br />
				<input type="password" name="password" id="password" 
					<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?>
			/></label></p>
		<p><input type="checkbox" name="auto_connexion" id="auto_connexion"/><label for="auto_connexion">Connexion automatique</label></p>
		<p><input type="submit" value="Connexion" class="button"/><!-- submit : Bouton d'envoi --></p>
	</fieldset> 
</form>
<?php		
// Cookies verification if auto connexion is enabled
if (isset($_COOKIE['auto_connexion']) && $_COOKIE['auto_connexion'])
{
	$login = $_COOKIE['login'];
	$cookiePassword = $_COOKIE['hash_password'];
}

// Vérification of logins of connexion
if (!empty($_POST['login']) && strlen($_POST['login']) <= MAX_LOGIN_LENGTH
    && !empty($_POST['password']) && strlen($_POST['password']) <= MAX_LOGIN_LENGTH)
{
	$login = $_POST['login'];
	$password = $_POST['password'];
} 


// Vérification of logins in the database, and sending if correct
$request = $bdd->prepare('SELECT id_user, lastname, firstname, login, password, question, answer FROM members');
$request->execute();
while ($datas = $request->fetch())
{
	if ($login === $datas['login'] && $cookiePassword === $datas['password'] 
		|| $login === $datas['login'] && password_verify($password, $datas['password']))
	{
		if (isset($_POST['auto_connexion']))
		{
			$_SESSION['auto_connexion'] = true;				
		}
		$_SESSION['id_user'] = $datas['id_user'];
		$_SESSION['login'] = $datas['login'];
		$_SESSION['hash_password'] = $datas['password'];
		$_SESSION['name'] = $datas['lastname'];
		$_SESSION['firstname'] = $datas['firstname'];
		$request->closeCursor();
		header('Location: index.php?page=home');
	}
}	
$request->closeCursor();
if (!empty($_POST['login']) || !empty($_POST['password'])) 
{
	echo '<p class="check-message"><span class="invalid">L\'identification est invalide</span></p>';
}
?>
	<p>Mot de passe oublié ? <a href="index.php?page=secret_question_1">Répondez à la question secrète</a></p>
	<p>Vous ne possédez pas de compte ? <a href="index.php?page=registration">Inscrivez-vous</a></p>
</section>