<?php
// Get actor datas
if (isset($_GET['actor']))
{
	$validPage = false;
	$request = $bdd->prepare('SELECT actor, description FROM actors WHERE id_actor = :id_actor');
	$request->execute(['id_actor' => (int) $_GET['actor']]);
	$actorSelection = $request->fetch();
	if (!empty($actorSelection['actor']))
	{
		$validPage = true;
		$idActor = (int) $_GET['actor'];
		$actor = $actorSelection['actor'];
		$description = $actorSelection['description'];
	}
	$request->closeCursor();
	if (!$validPage)
	{
		header('Location: ../public/index.php?page=home');
	}
}
else
{
	header('Location: ../public/index.php?page=home');
}
?>

<main>
<section id="actor">
	<?php 
	// Actor display
	$imageName = preg_replace('# #','_',$actor);
	echo '<div id="actor-image"><img src="../public/img/logo_' . $imageName . '.png" alt="logo_' . $imageName . '"></div>';
	echo '<div id="actor-description"><h2>' . $actor . '</h2>' ;
	echo '<p>' . $description . '</p></div>';
	?>
</section>

<section id="comments">
	<?php

	// Comment add
	if (!empty($_POST['content']) && strlen($_POST['content']) <= MAX_LOGIN_LENGTH)
	{
		$request = $bdd->prepare('INSERT INTO comments(id_user,id_actor,date_add,content) VALUES(:id_user,:id_actor,NOW(),:content)');
		$request->execute([
			'id_user' => $_SESSION['id_user'],
			'id_actor' => $idActor,
			'content' => $_POST['content']
		]);
		$request->closeCursor();
	}

	echo '<div id="comments-and-likes">';
	echo '<div id="comments-number">';
	// Number of comments
	$request = $bdd->prepare('SELECT COUNT(*) AS comments_number FROM comments WHERE id_actor = :id_actor');
	$request->execute(['id_actor' => $idActor]);
	$countComments = $request->fetch();
	if ($countComments['comments_number'] > 1)
	{
		$textComment = 'commentaires';	
	}
	else
	{
		$textComment = 'commentaire';			
	}
	echo sprintf('<p>%d %s</p>',$countComments['comments_number'],$textComment);
	$request->closeCursor();
	echo '</div>';

	echo '<div id="likesDislikes">';
	// Like taken into account
	if (isset($_GET['note']))
	{
		if ($_GET['note'] === '0' || $_GET['note'] === '1' || $_GET['note'] === '-1')
		{
			$note = (int) $_GET['note'];
		}
		$request = $bdd->prepare('UPDATE likes SET note = :note WHERE id_user = :id_user AND id_actor = :id_actor');
			$request->execute([
				'note' => $note,
				'id_user' => $_SESSION['id_user'],
				'id_actor' => $idActor
			]);
		$request->closeCursor();
	}

	// User like value indication
	$request = $bdd->prepare('SELECT note FROM likes WHERE id_user = :id_user AND id_actor = :id_actor');
	$request->execute([
		'id_user' => $_SESSION['id_user'],
		'id_actor' => $idActor
	]);
	$valueOfLike = $request->fetch();
	$noteValue = $valueOfLike['note'];
	$request->closeCursor();

	// Number of likes
	$request = $bdd->prepare('SELECT COUNT(*) AS likes_number FROM likes WHERE id_actor = :id_actor AND note = 1');
	$request->execute(['id_actor' => $idActor]);
	$numberOfLikes = $request->fetch();
	echo '<p>' . $numberOfLikes['likes_number'] . '  ';
	$request->closeCursor();

	// Like button
	if ($noteValue === '1')
	{
		$color = 'green';
		$linkValue = '0';
	}
	else
	{
		$color = 'white';
		$linkValue = '1';
	}
	echo sprintf('<a href="../public/index.php?page=actor_page&amp;actor=%s&amp;note=%s"><img src="../public/img/happy_%s_transparent.png" alt="happy_$s_smiley" ></a>',$idActor,$linkValue,$color,$color);

	// Number of dislikes
	$request = $bdd->prepare('SELECT COUNT(*) AS dislikes_number FROM likes WHERE id_actor = :id_actor AND note = -1');
	$request->execute(['id_actor' => $idActor]);
	$numberOfDislikes = $request->fetch();
	echo '  ' . $numberOfDislikes['dislikes_number'] . '  ';
	$request->closeCursor();

	// Dislike button
	if ($noteValue === '-1')
	{
		$color = 'red';
		$linkValue = '0';
	}
	else
	{
		$color = 'white';
		$linkValue = '-1';
	}
	echo sprintf('<a href="../public/index.php?page=actor_page&amp;actor=%s&amp;note=%s"><img src="../public/img/unhappy_%s_transparent.png" alt="unhappy_$s_smiley" ></a>',$idActor,$linkValue,$color,$color);
	echo '</p></div></div>';

	// Comments form
	echo '<form action="../public/index.php?page=actor_page&amp;actor=' . $idActor . '" method="POST">'; ?>
		<p><textarea name="content" rows=2 cols=30></textarea></p>
		<p><input type="submit" value="Ajouter un commentaire" class="button"/></p>
	</form>


	<!-- Comments post  -->
	<section id="comments-table">
	<?php
	$commentColor = 'blanc';
	$request = $bdd->prepare('SELECT id_user,content,DATE_FORMAT(date_add,"Le %d/%m/%Y à %H:%i:%s") AS date_add_fr FROM comments WHERE id_actor = :id_actor ORDER BY date_add');
	$request->execute(['id_actor' => $idActor]);
	while ($commentDatas = $request->fetch())
	{
		$firstname = $bdd->prepare('SELECT firstname FROM members WHERE id_user = :id_user');
		$firstname->execute(['id_user' => $commentDatas['id_user']]);
		while ($firstnameDatas = $firstname->fetch())
		{
			if ($commentColor === 'blanc')
			{
				$classComment = 'white-comment';
				echo sprintf('<div class="%s"><p>%s<br/>',$classComment,htmlspecialchars($firstnameDatas['firstname']));
				$commentColor = 'gris';	
			}
			else
			{
				$classComment = 'grey-comment';
				echo sprintf('<div class="%s"><p>%s<br/>',$classComment,htmlspecialchars($firstnameDatas['firstname']));
				$commentColor = 'blanc';
			}
		}
		$firstname->closeCursor();
		echo $commentDatas['date_add_fr'] . '<br/>';
		echo htmlspecialchars($commentDatas['content']) . '</p></div>'; 
	}
	$request->closeCursor();
?>
</section>
</section>
<p><a href="../public/index.php?page=home">Retour à l'accueil</a></p>
</main>