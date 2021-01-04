<?php
// Récupération des données de l'acteur
if (isset($_GET['acteur']))
{
	$pageValide = false;
	$requete = $bdd->prepare('SELECT actor, description FROM actors WHERE id_actor = :id_actor');
	$requete->execute(['id_actor' => (int) $_GET['acteur']]);
	$donnees = $requete->fetch();
	if (!empty($donnees['actor']))
	{
		$pageValide = true;
		$idActeur = (int) $_GET['acteur'];
		$acteur = $donnees['actor'];
		$description = $donnees['description'];
	}
	$requete->closeCursor();
	if (!$pageValide)
	{
		header('Location: index.php?page=espace');
	}
}
else
{
	header('Location: index.php?page=espace');
}
?>

<main>
<section id="acteur">
	<?php 
	// Affichage de l'acteur
	echo '<div id="imgActeur"><img src="images/logo_' . $acteur . '.png" alt="logo_' . $acteur . '"/></div>';
	echo '<div id="descriptionActeur"><h2>' . $acteur . '</h2>' ;
	echo '<p>' . $description . '</p></div>';
	?>
</section>

<section id="commentaires">
	<?php

	// Ajout d'un commentaire
	if (!empty($_POST['content']) && strlen($_POST['content']) <= MAX_CHARACTERS)
	{
		$requete = $bdd->prepare('INSERT INTO comments(id_user,id_actor,date_add,content) VALUES(:id_user,:id_actor,NOW(),:content)');
		$requete->execute([
			'id_user' => $_SESSION['id_user'],
			'id_actor' => $idActeur,
			'content' => $_POST['content']
		]);
		$requete->closeCursor();
	}

	echo '<div id="comsLikes">';
	echo '<div id="nombreComs">';
	// Nombre de commentaires
	$requete = $bdd->prepare('SELECT COUNT(*) AS nb_coms FROM comments WHERE id_actor = :id_actor');
	$requete->execute(['id_actor' => $idActeur]);
	$donnees = $requete->fetch();
	if ($donnees['nb_coms'] > 1)
	{
		$commentTexte = 'commentaires';	
	}
	else
	{
		$commentTexte = 'commentaire';			
	}
	echo sprintf('<p>%d %s</p>',$donnees['nb_coms'],$commentTexte);
	$requete->closeCursor();
	echo '</div>';

	echo '<div id="likesDislikes">';
	// Prise en compte du like
	if (isset($_GET['note']))
	{
		if ($_GET['note'] === '0' || $_GET['note'] === '1' || $_GET['note'] === '-1')
		{
			$note = (int) $_GET['note'];
		}
		$requete = $bdd->prepare('UPDATE likes SET note = :note WHERE id_user = :id_user AND id_actor = :id_actor');
			$requete->execute([
				'note' => $note,
				'id_user' => $_SESSION['id_user'],
				'id_actor' => $idActeur
			]);
		$requete->closeCursor();
	}

	// Indication de la valeur du like de l'utilisateur
	$requete = $bdd->prepare('SELECT note FROM likes WHERE id_user = :id_user AND id_actor = :id_actor');
	$requete->execute([
		'id_user' => $_SESSION['id_user'],
		'id_actor' => $idActeur
	]);
	$donnees = $requete->fetch();
	$valeurnote = $donnees['note'];
	$requete->closeCursor();

	// Nombre de likes
	$requete = $bdd->prepare('SELECT COUNT(*) AS nb_likes FROM likes WHERE id_actor = :id_actor AND note = 1');
	$requete->execute(['id_actor' => $idActeur]);
	$donnees = $requete->fetch();
	echo '<p>' . $donnees['nb_likes'] . '  ';
	$requete->closeCursor();

	// Bouton like
	if ($valeurnote === '1')
	{
		$color = 'green';
		$valeurlien = '0';
	}
	else
	{
		$color = 'white';
		$valeurlien = '1';
	}
	echo sprintf('<a href="index.php?page=page_acteur&amp;acteur=%s&amp;note=%s"><img src="images/happy %s transparent.png" </img></a>',$idActeur,$valeurlien,$color);

	// Nombre de dislikes
	$requete = $bdd->prepare('SELECT COUNT(*) AS nb_dislikes FROM likes WHERE id_actor = :id_actor AND note = -1');
	$requete->execute(['id_actor' => $idActeur]);
	$donnees = $requete->fetch();
	echo '  ' . $donnees['nb_dislikes'] . '  ';
	$requete->closeCursor();

	// Bouton dislike
	if ($valeurnote === '-1')
	{
		$color = 'red';
		$valeurlien = '0';
	}
	else
	{
		$color = 'white';
		$valeurlien = '-1';
	}
	echo sprintf('<a href="index.php?page=page_acteur&amp;acteur=%s&amp;note=%s"><img src="images/unhappy %s transparent.png" </img></a>',$idActeur,$valeurlien,$color);
	echo '</p></div></div>';

	// Formulaire commentaire
	echo '<form action="index.php?page=page_acteur&amp;acteur=' . $idActeur . '" method="POST">'; ?>
		<p><textarea name="content" rows=2 cols=30></textarea></p>
		<p><input type="submit" value="Ajouter un commentaire" class="Bouton"/></p>
	</form>


	<!-- Publication des commentaires  -->
	<section id="tableCommentaires">
	<?php
	$couleurCom = 'blanc';
	$requete = $bdd->prepare('SELECT id_user,content,DATE_FORMAT(date_add,"Le %d/%m/%Y à %H:%i:%s") AS date_add_fr FROM comments WHERE id_actor = :id_actor ORDER BY date_add');
	$requete->execute(['id_actor' => $idActeur]);
	while ($donnees = $requete->fetch())
	{
		$prenom = $bdd->prepare('SELECT firstname FROM members WHERE id_user = :id_user');
		$prenom->execute(['id_user' => $donnees['id_user']]);
		while ($donneesPrenom = $prenom->fetch())
		{
			if ($couleurCom === 'blanc')
			{
				$classComment = 'CommentBlanc';
				echo sprintf('<div class="%s"><p>%s<br/>',$classComment,htmlspecialchars($donneesPrenom['firstname']));
				$couleurCom = 'gris';	
			}
			else
			{
				$classComment = 'CommentGris';
				echo sprintf('<div class="%s"><p>%s<br/>',$classComment,htmlspecialchars($donneesPrenom['firstname']));
				$couleurCom = 'blanc';
			}
		}
		$prenom->closeCursor();
		echo $donnees['date_add_fr'] . '<br/>';
		echo htmlspecialchars($donnees['content']) . '</p></div>'; 
	}
	$requete->closeCursor();
?>
</section>
</section>
<p><a href="index.php?page=espace">Retour à l'accueil</a></p>
</main>