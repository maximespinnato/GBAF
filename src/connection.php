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
<form action="../public/index.php?page=connection" method="POST"> 
	<fieldset>
		<p><label>Identifiant:<br />
				<input type="text" name="login" id="login" 
					<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
			</label></p>
		<p><label>Mot de passe :<br />
				<input type="password" name="password" id="password" 
					<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?>
			/></label></p>
		<p><input type="checkbox" name="auto_connection" id="auto_connection"/><label for="auto_connection">Connexion automatique</label></p>
		<p><input type="submit" value="Connexion" class="button"/><!-- submit : Bouton d'envoi --></p>
	</fieldset> 
</form>
<?php		
// Cookies verification if auto connection is enabled
if (isset($_COOKIE['auto_connection']) && $_COOKIE['auto_connection'])
{
	$login = $_COOKIE['login'];
	$cookiePassword = $_COOKIE['hash_password'];
}

// Vérification of logins of connection
if (!empty($_POST['login']) && strlen($_POST['login']) <= MAX_LOGIN_LENGTH
    && !empty($_POST['password']) && strlen($_POST['password']) <= MAX_LOGIN_LENGTH)
{
	$login = $_POST['login'];
	$password = $_POST['password'];
} 


// Vérification of logins in the database, and sending if correct
$request = $bdd->prepare('SELECT id_user, lastname, firstname, login, password, question, answer FROM members WHERE login = :login');
$request->execute(['login' => $login]);
$userDatas = $request->fetch();
	if (!empty($userDatas['password']) && ($cookiePassword === $userDatas['password'] || password_verify($password, $userDatas['password'])))
	{
		if (isset($_POST['auto_connection']))
		{
			$_SESSION['auto_connection'] = true;				
		}
		$_SESSION['id_user'] = $userDatas['id_user'];
		$_SESSION['login'] = $userDatas['login'];
		$_SESSION['hash_password'] = $userDatas['password'];
		$_SESSION['name'] = $userDatas['lastname'];
		$_SESSION['firstname'] = $userDatas['firstname'];
		$request->closeCursor();
		header('Location: ../public/index.php?page=home');
	}
$request->closeCursor();
if (!empty($_POST['login']) || !empty($_POST['password'])) 
{
	echo '<p class="check-message"><span class="invalid">L\'identification est invalide</span></p>';
}
?>
	<p>Mot de passe oublié ? <a href="../public/index.php?page=secret_question_login">Répondez à la question secrète</a></p>
	<p>Vous ne possédez pas de compte ? <a href="../public/index.php?page=registration">Inscrivez-vous</a></p>
</section>