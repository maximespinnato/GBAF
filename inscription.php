<?php
$pasEnvoyer = false;
$_SESSION['pseudoQuestion'] = '';
?>
<section class="Formulaire">
<h1>Inscription</h1>
<form action="index.php?page=inscription" method="POST" id="inscriptionform"> 
	<fieldset>
		<p><label>Nom :<br />
			<input type="text" name="nom" id="nom"
			<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
		</label><br />
		<?php 
		// Vérification du nom
		if (isset($_POST['nom']))
		{
			if (empty($_POST['nom']) || strlen($_POST['nom']) > MAX_LOGIN_LENGTH)
			{
				echo '<span class="Invalide">Ce nom est invalide</span>';
				$pasEnvoyer = true;
			}
		} 
		else 
		{
			$pasEnvoyer = true;
		}
		?></p>
		<p><label>Prénom :<br />
			<input type="text" name="prenom" id="prenom"
			<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
		</label><br />
		<?php 
		// Vérification du prenom
		if (isset($_POST['prenom']))
		{
			if (empty($_POST['prenom']) || strlen($_POST['prenom']) > MAX_LOGIN_LENGTH)
			{
				echo '<span class="Invalide">Ce prénom est invalide</span>';
				$pasEnvoyer = true;
			}
		} 
		else 
		{
			$pasEnvoyer = true;
		}
		?></p>
		<p><label>Identifiant :<br />
			<input type="text" name="pseudo" id="pseudo"
			<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
		</label><br />
		<?php 
		// Vérification du pseudo
		if (isset($_POST['pseudo']))
		{
			if (!empty($_POST['pseudo']) && strlen($_POST['pseudo']) <= MAX_LOGIN_LENGTH)
			{
				$requete = $bdd->prepare('SELECT login FROM members');
				$requete->execute();
				while ($donnees = $requete->fetch())
				{
					if ($_POST['pseudo'] === $donnees['login'])
					{
						echo '<span class="Invalide">Cet identifiant est déjà pris</span>';
						$pasEnvoyer = true;
					}
				}
				$requete->closeCursor();
			}
			else
			{
				echo '<span class="Invalide">Cet identifiant est invalide</span>';
				$pasEnvoyer = true;
			}
		} 
		else 
		{
			$pasEnvoyer = true;
		}
		?></p>
		<p><label>Mot de passe :<br />
			<input type="password" name="motdepasse" id="motdepasse"
			<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
		</label><br />
		<?php 
		// Vérification du mot de passe
		if (isset($_POST['motdepasse'])) 
		{
			if (empty($_POST['motdepasse']) || strlen($_POST['motdepasse']) > MAX_LOGIN_LENGTH)
			{
				echo '<span class="Invalide">Ce mot de passe est invalide</span>';
				$pasEnvoyer = true;	
			}
		}
		else
		{
			$pasEnvoyer = true;
		}
		?></p>
		<p><label>Vérification du mot de passe :<br />
			<input type="password" name="verification" id="verification"
			<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
		</label><br />
		<?php 
		// Vérification du mot de passe de vérif
		if (isset($_POST['verification']))
		{
			if (empty($_POST['verification'])
			    || strlen($_POST['verification']) > MAX_LOGIN_LENGTH
			    || $_POST['verification'] != $_POST['motdepasse'])
			{
				echo '<span class="Invalide">La vérification ne correspond pas au mot de passe</span>';				
				$pasEnvoyer = true;
			}
		} 
		else
		{				
			$pasEnvoyer = true;
		}
		?>
		<p><label>Question secrète :<br />
			<input type="text" name="question" id="question"
			<?php echo 'maxlength="' . MAX_SENTENCES_LENGTH . '"';?> />
		</label><br />
		<?php 
		// Vérification du de la question secrète
		if (isset($_POST['question']))
		{
			if (empty($_POST['question']) || strlen($_POST['question']) > MAX_SENTENCES_LENGTH)
			{
				echo '<span class="Invalide">Cette question est invalide</span>';
				$pasEnvoyer = true;
			}
		} 
		else 
		{
			$pasEnvoyer = true;
		}
		?></p>
		<p><label>Réponse secrete :<br />
			<input type="password" name="reponse" id="reponse"
			<?php echo 'maxlength="' . MAX_SENTENCES_LENGTH . '"';?> />
		</label><br />
		<?php 
		// Vérification du mot de passe
		if (isset($_POST['reponse'])) 
		{
			if (empty($_POST['reponse']) || strlen($_POST['reponse']) > MAX_SENTENCES_LENGTH)
			{
				echo '<span class="Invalide">Cette réponse est invalide</span>';
				$pasEnvoyer = true;
			}			
		}
		else
		{
			$pasEnvoyer = true;
		}
		?></p>
		<p><input type="submit" value="S'inscrire" class="Bouton"/>  <!-- submit : Bouton d'envoi --></p> 
	</fieldset>
</form>
<p>Vous possédez déjà un compte ? <a href="index.php?page=connexion">Connectez-vous</a></p>
</section>
<?php
// Inscription réussie
if (!$pasEnvoyer)
{
	// Inscription, insertion dans la base de données membres
	$pass_hache = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);
	$reponse_hache = password_hash($_POST['reponse'], PASSWORD_DEFAULT);
	$requete = $bdd->prepare('INSERT INTO members(lastname,firstname,login,password,question,answer) VALUES(:nom,:prenom,:pseudo,:motdepasse,:question,:reponse)');
	$requete->execute([
		'nom' => $_POST['nom'],
		'prenom' => $_POST['prenom'],
		'pseudo' => $_POST['pseudo'],
		'motdepasse' => $pass_hache,
		'question' => $_POST['question'],
		'reponse' => $reponse_hache
	]);
	$requete->closeCursor();

	// Recherche de l'id_user du nouvel inscrit
	$requete = $bdd->prepare('SELECT id_user FROM members WHERE login = :pseudo');
	$requete->execute(['pseudo' => $_POST['pseudo']]);
	$donnees = $requete->fetch();
	$idUser = $donnees['id_user'];
	$requete->closeCursor();

	// Insertion des nouveaux likes potentiels (1 vote / user / acteur)
	$requete = $bdd->prepare('SELECT id_actor FROM actors');
	$requete->execute();
	while ($donnees = $requete->fetch())
	{
		$insertion = $bdd->prepare('INSERT INTO likes(id_user,id_actor,note) VALUES(:id_user,:id_actor,0)');
		$insertion->execute([
			'id_user' => $idUser,
			'id_actor' => $donnees['id_actor']
		]);
		$insertion->closeCursor();			
	}
	$requete->closeCursor();
	setcookie('inscription', true, time() + 365*24*3600, null, null, false, true);
	header('Location: index.php?page=connexion');
}
?>