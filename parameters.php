<?php
$updateLastname = false;
$updateFirstname = false;
$existingLogin = false;
$updateLogin = false;
$updatePassword = false;
$updateQuestion = false;
$updateAnswer = false;

// Lastname modification
if (!empty($_POST['name']) && strlen($_POST['name']) <= MAX_LOGIN_LENGTH)
{
	$_SESSION['name'] = $_POST['name'];
	$update = $bdd->prepare('UPDATE members SET lastname = :name WHERE id_user = :id_user');
	$update->execute([
		'name' => $_POST['name'],
		'id_user' => $_SESSION['id_user']
	]);
	$update->closeCursor();	
	$updateLastname = true;
}

// Firstname modification
if (!empty($_POST['firstname']) && strlen($_POST['firstname']) <= MAX_LOGIN_LENGTH)
{
	$_SESSION['firstname'] = $_POST['firstname'];
	$update = $bdd->prepare('UPDATE members SET firstname = :firstname WHERE id_user = :id_user');
	$update->execute([
		'firstname' => $_POST['firstname'],
		'id_user' => $_SESSION['id_user']
	]);
	$update->closeCursor();
	$updateFirstname = true;
}

// Login modification
if (!empty($_POST['login']) && strlen($_POST['login']) <= MAX_LOGIN_LENGTH)
{
	$request = $bdd->prepare('SELECT login FROM members');
	$request->execute();
	while($datas = $request->fetch())
	{
		if ($_POST['login'] === $datas['login'])
		{
			$existingLogin = true;
		}	
	}
	$request->closeCursor();
	if ($existingLogin === false)
	{
		$update = $bdd->prepare('UPDATE members SET login = :login WHERE id_user = :id_user');
		$update->execute([
			'login' => $_POST['login'],
			'id_user' => $_SESSION['id_user']
		]);
		$update->closeCursor();	
		$updateLogin = true;		
	}
}

// Password modification
if (!empty($_POST['password']) && strlen($_POST['password']) <= MAX_LOGIN_LENGTH)
{
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$update = $bdd->prepare('UPDATE members SET password = :password WHERE id_user = :id_user');
	$update->execute([
		'password' => $password,
		'id_user' => $_SESSION['id_user']
	]);
	$update->closeCursor();	
	$updatePassword = true;	
}

// Question modification
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

// Answer modification
if (!empty($_POST['answer']) && strlen($_POST['answer']) <= MAX_SENTENCES_LENGTH)
{
	$answer = password_hash($_POST['answer'], PASSWORD_DEFAULT);
	$update = $bdd->prepare('UPDATE members SET answer = :answer WHERE id_user = :id_user');
	$update->execute([
		'answer' => $_POST['answer'],
		'id_user' => $_SESSION['id_user']
	]);
	$update->closeCursor();
	$updateAnswer = true;	
}
?>
<section class="form">
<h2>Paramètres</h2>

<?php
// Parameters form
$request = $bdd->prepare('SELECT lastname,firstname,login,password,question,answer FROM members WHERE id_user = :id_user');
$request->execute(['id_user' => $_SESSION['id_user']]);
$datas = $request->fetch();
echo '<form action="index.php?page=parameters" method="POST">';
echo '<fieldset>';
echo '<p><label>Nom : <br/>
			<input type="text" name="name" placeholder="' . htmlspecialchars($datas['lastname']) . '" maxlength="' . MAX_LOGIN_LENGTH . '"/>
		 </label></p>';
echo '<p><label>Prénom : <br/>
			<input type="text" name="firstname" placeholder="' . htmlspecialchars($datas['firstname']) . '" maxlength="' . MAX_LOGIN_LENGTH . '"/>
		 </label></p>';	
echo '<p><label>Identifiant : <br/>
			<input type="text" name="login" placeholder="' . htmlspecialchars($datas['login']) . '" maxlength="' . MAX_LOGIN_LENGTH . '"/>
		 </label></p>';		
echo '<p><label>Question secrète : <br/>
			<input type="text" name="question" placeholder="' . htmlspecialchars($datas['question']) . '" maxlength="' . MAX_SENTENCES_LENGTH . '"/>
		 </label></p>';
echo '<p><input type="submit" value="Modifier" name="submitted" class="button"/></p>';
echo '</fieldset>';
echo '</form>';
$request->closeCursor();
echo '<p class= check-message>';
if (isset($_POST['submitted'])
    && empty($_POST['name'])
    && empty($_POST['firstname'])
    && empty($_POST['login'])
    && empty($_POST['question']))
{
	echo '<span class="invalid">Vous n\'avez rien modifié</span>';
}

// Validation of the modifications
if ($updateLastname === true)
{
	echo '<span class="modified">Votre nom a bien été modifié</span><br/>';	
}
if ($updateFirstname === true)
{
	echo '<span class="modified">Votre prénom a bien été modifié</span><br/>';	
}
if ($updateLogin === true)
{
	echo '<span class="modified">Votre identifiant a bien été modifié</span><br/>';	
} 
if($existingLogin === true)
{
	echo '<span class="invalid">Cet identifiant existe déjà</span><br/>';
}
if ($updatePassword === true)
{
	echo '<span class="modified">Votre mot de passe a bien été modifié</span><br/>';	
}
if ($updateQuestion === true)
{
	echo '<span class="modified">Votre question secrète a bien été modifiée</span><br/>';	
}
if ($updateAnswer === true)
{
	echo '<span class="modified">Votre réponse secrète a bien été modifiée</span><br/>';	
}
?>
</p>
<div id="buttons-group">
	<p><a href="index.php?page=modification&amp;field=1" class="square-button">Modifier le mot de passe</a></p>
	<p><a href="index.php?page=modification&amp;field=2" class="square-button">Modifier la réponse secrète</a></p>
	<p><a href="index.php?page=unsubscription" class="square-button" id="unsubscribe">Se désinscrire</a></p>
</div>
<p><a href="index.php?page=home">Retour à l'accueil</a></p>
</section>