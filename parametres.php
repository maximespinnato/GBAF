<?php
$updateNom = false;
$updatePrenom = false;
$pseudoExistant = false;
$updatePseudo = false;
$updateMotdepasse = false;
$updateQuestion = false;
$updateReponse = false;

// Modification du nom
if (!empty($_POST['nom']) && strlen($_POST['nom']) <= MAX_LOGIN_LENGTH)
{
	$_SESSION['nom'] = $_POST['nom'];
	$update = $bdd->prepare('UPDATE members SET lastname = :nom WHERE id_user = :id_user');
	$update->execute([
		'nom' => $_POST['nom'],
		'id_user' => $_SESSION['id_user']
	]);
	$update->closeCursor();	
	$updateNom = true;
}

// Modification du prénom
if (!empty($_POST['prenom']) && strlen($_POST['prenom']) <= MAX_LOGIN_LENGTH)
{
	$_SESSION['prenom'] = $_POST['prenom'];
	$update = $bdd->prepare('UPDATE members SET firstname = :prenom WHERE id_user = :id_user');
	$update->execute([
		'prenom' => $_POST['prenom'],
		'id_user' => $_SESSION['id_user']
	]);
	$update->closeCursor();
	$updatePrenom = true;
}

// Modification du pseudo
if (!empty($_POST['pseudo']) && strlen($_POST['pseudo']) <= MAX_LOGIN_LENGTH)
{
	$requete = $bdd->prepare('SELECT login FROM members');
	$requete->execute();
	while($donnees = $requete->fetch())
	{
		if ($_POST['pseudo'] === $donnees['login'])
		{
			$pseudoExistant = true;
		}	
	}
	$requete->closeCursor();
	if ($pseudoExistant === false)
	{
		$update = $bdd->prepare('UPDATE members SET login = :pseudo WHERE id_user = :id_user');
		$update->execute([
			'pseudo' => $_POST['pseudo'],
			'id_user' => $_SESSION['id_user']
		]);
		$update->closeCursor();	
		$updatePseudo = true;		
	}
}

// Modification du mot de passe
if (!empty($_POST['motdepasse']) && strlen($_POST['motdepasse']) <= MAX_LOGIN_LENGTH)
{
	$motdepasse = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);
	$update = $bdd->prepare('UPDATE members SET password = :motdepasse WHERE id_user = :id_user');
	$update->execute([
		'motdepasse' => $motdepasse,
		'id_user' => $_SESSION['id_user']
	]);
	$update->closeCursor();	
	$updateMotdepasse = true;	
}

// Modification de la question
if (!empty($_POST['question']) && strlen($_POST['question']) <= MAX_SENTENCES_LENGTH)
{
	$update = $bdd->prepare('UPDATE members SET question = :question WHERE id_user = :id_user');
	$update->execute([
		'question' => $_POST['question'],
		'id_user' => $_SESSION['id_user']
	]);
	$update->closeCursor();
	$updateQuestion = true;	
}

// Modification de la réponse
if (!empty($_POST['reponse']) && strlen($_POST['reponse']) <= MAX_SENTENCES_LENGTH)
{
	$reponse = password_hash($_POST['reponse'], PASSWORD_DEFAULT);
	$update = $bdd->prepare('UPDATE members SET answer = :reponse WHERE id_user = :id_user');
	$update->execute([
		'reponse' => $_POST['reponse'],
		'id_user' => $_SESSION['id_user']
	]);
	$update->closeCursor();
	$updateReponse = true;	
}
?>
<section class="formulaire">
<h2>Paramètres</h2>

<?php
// Formulaire des paramètres
$requete = $bdd->prepare('SELECT lastname,firstname,login,password,question,answer FROM members WHERE id_user = :id_user');
$requete->execute(['id_user' => $_SESSION['id_user']]);
$donnees = $requete->fetch();
echo '<form action="index.php?page=parametres" method="POST">';
echo '<fieldset>';
echo '<p><label>Nom : <br/>
			<input type="text" name="nom" placeholder="' . htmlspecialchars($donnees['lastname']) . '" maxlength="' . MAX_LOGIN_LENGTH . '"/>
		 </label></p>';
echo '<p><label>Prénom : <br/>
			<input type="text" name="prenom" placeholder="' . htmlspecialchars($donnees['firstname']) . '" maxlength="' . MAX_LOGIN_LENGTH . '"/>
		 </label></p>';	
echo '<p><label>Identifiant : <br/>
			<input type="text" name="pseudo" placeholder="' . htmlspecialchars($donnees['login']) . '" maxlength="' . MAX_LOGIN_LENGTH . '"/>
		 </label></p>';		
echo '<p><label>Question secrète : <br/>
			<input type="text" name="question" placeholder="' . htmlspecialchars($donnees['question']) . '" maxlength="' . MAX_SENTENCES_LENGTH . '"/>
		 </label></p>';
echo '<p><input type="submit" value="Modifier" name="soumis" class="bouton"/></p>';
echo '</fieldset>';
echo '</form>';
$requete->closeCursor();
echo '<p class= messageVerif>';
if (isset($_POST['soumis'])
    && empty($_POST['nom'])
    && empty($_POST['prenom'])
    && empty($_POST['pseudo'])
    && empty($_POST['question']))
{
	echo '<span class="invalide">Vous n\'avez rien modifié</span>';
}

// Validation des modifications
if ($updateNom === true)
{
	echo '<span class="modifie">Votre nom a bien été modifié</span><br/>';	
}
if ($updatePrenom === true)
{
	echo '<span class="modifie">Votre prénom a bien été modifié</span><br/>';	
}
if ($updatePseudo === true)
{
	echo '<span class="modifie">Votre identifiant a bien été modifié</span><br/>';	
} 
if($pseudoExistant === true)
{
	echo '<span class="invalide">Cet identifiant existe déjà</span><br/>';
}
if ($updateMotdepasse === true)
{
	echo '<span class="modifie">Votre mot de passe a bien été modifié</span><br/>';	
}
if ($updateQuestion === true)
{
	echo '<span class="modifie">Votre question secrète a bien été modifiée</span><br/>';	
}
if ($updateReponse === true)
{
	echo '<span class="modifie">Votre réponse secrète a bien été modifiée</span><br/>';	
}
?>
</p>
<div id="groupeBoutons">
	<p><a href="index.php?page=modification&amp;champs=1" class="boutonCarre">Modifier le mot de passe</a></p>
	<p><a href="index.php?page=modification&amp;champs=2" class="boutonCarre">Modifier la réponse secrète</a></p>
	<p><a href="index.php?page=desinscription" class="boutonCarre" id="desinscrire">Se désinscrire</a></p>
</div>
<p><a href="index.php?page=espace">Retour à l'accueil</a></p>
</section>