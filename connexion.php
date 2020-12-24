<?php
$pseudo = '';
$motdepasse = '';
$cookieMotdepasse = '';
$_SESSION['pseudoQuestion'] = '';

?>
<section class="formulaire">
<?php 
if (isset($_COOKIE['inscription']) && $_COOKIE['inscription'])
{
	echo '<p class="messageVerif"><span class="modifie">Vous vous êtes bien inscrit</span></p>';
	setcookie('inscription','');
}
if (isset($_COOKIE['desinscription']) && $_COOKIE['desinscription'])
{
	echo '<p class="messageVerif"><span class="modifie">Vous vous êtes bien désinscrit</span></p>';
	setcookie('desinscription','');
}
?>
<h1>Connexion</h1>
<form action="index.php?page=connexion" method="POST"> 
	<fieldset>
		<p><label>Identifiant:<br />
				<input type="text" name="pseudo" id="pseudo" 
					<?php echo 'maxlength="' . MAX_LOGIN . '"';?> />
			</label></p>
		<p><label>Mot de passe :<br />
				<input type="password" name="motdepasse" id="motdepasse" 
					<?php echo 'maxlength="' . MAX_LOGIN . '"';?>
			/></label></p>
		<p><input type="checkbox" name="connexion_auto" id="connexion_auto"/><label for="connexion_auto">Connexion automatique</label></p>
		<p><input type="submit" value="Connexion" class="bouton"/><!-- submit : bouton d'envoi --></p>
	</fieldset> 
</form>
<?php		
// Vérification des cookies si la connexion automatique est activée
if (isset($_COOKIE['connexion_auto']) && $_COOKIE['connexion_auto'])
{
	$pseudo = $_COOKIE['pseudo'];
	$cookieMotdepasse = $_COOKIE['motdepasse_hache'];
}

// Vérification des identifiants de connexion
if (!empty($_POST['pseudo']) && strlen($_POST['pseudo']) <= MAX_LOGIN
    && !empty($_POST['motdepasse']) && strlen($_POST['motdepasse']) <= MAX_LOGIN)
{
	$pseudo = $_POST['pseudo'];
	$motdepasse = $_POST['motdepasse'];
} 


// Vérification des identifiants dans la base de données et envoi si correct
$requete = $bdd->prepare('SELECT id_user, lastname, firstname, login, password, question, answer FROM members');
$requete->execute();
while ($donnees = $requete->fetch())
{
	if ($pseudo === $donnees['login'] && $cookieMotdepasse === $donnees['password'] 
		|| $pseudo === $donnees['login'] && password_verify($motdepasse, $donnees['password']))
	{
		if (isset($_POST['connexion_auto']))
		{
			$_SESSION['connexion_auto'] = true;				
		}
		$_SESSION['id_user'] = $donnees['id_user'];
		$_SESSION['pseudo'] = $donnees['login'];
		$_SESSION['motdepasse_hache'] = $donnees['password'];
		$_SESSION['nom'] = $donnees['lastname'];
		$_SESSION['prenom'] = $donnees['firstname'];
		$requete->closeCursor();
		header('Location: index.php?page=espace');
	}
}	
$requete->closeCursor();
if (!empty($_POST['pseudo']) || !empty($_POST['motdepasse'])) 
{
	echo '<p class="messageVerif"><span class="invalide">L\'identification est invalide</span></p>';
}
?>
	<p>Mot de passe oublié ? <a href="index.php?page=question_secrete_1">Répondez à la question secrète</a></p>
	<p>Vous ne possédez pas de compte ? <a href="index.php?page=inscription">Inscrivez-vous</a></p>
</section>