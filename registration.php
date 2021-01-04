<?php
$notSend = false;
$_SESSION['loginQuestion'] = '';
?>
<section class="form">
<h1>Inscription</h1>
<form action="index.php?page=registration" method="POST" id="inscriptionform"> 
	<fieldset>
		<p><label>Nom :<br />
			<input type="text" name="name" id="name"
			<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
		</label><br />
		<?php 
		// Lastname verification
		if (isset($_POST['name']))
		{
			if (empty($_POST['name']) || strlen($_POST['name']) > MAX_LOGIN_LENGTH)
			{
				echo '<span class="invalid">Ce nom est invalide</span>';
				$notSend = true;
			}
		} 
		else 
		{
			$notSend = true;
		}
		?></p>
		<p><label>Prénom :<br />
			<input type="text" name="firstname" id="firstname"
			<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
		</label><br />
		<?php 
		// Firstname verification
		if (isset($_POST['firstname']))
		{
			if (empty($_POST['firstname']) || strlen($_POST['firstname']) > MAX_LOGIN_LENGTH)
			{
				echo '<span class="invalid">Ce prénom est invalide</span>';
				$notSend = true;
			}
		} 
		else 
		{
			$notSend = true;
		}
		?></p>
		<p><label>Identifiant :<br />
			<input type="text" name="login" id="login"
			<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
		</label><br />
		<?php 
		// Login verification
		if (isset($_POST['login']))
		{
			if (!empty($_POST['login']) && strlen($_POST['login']) <= MAX_LOGIN_LENGTH)
			{
				$request = $bdd->prepare('SELECT login FROM members');
				$request->execute();
				while ($datas = $request->fetch())
				{
					if ($_POST['login'] === $datas['login'])
					{
						echo '<span class="invalid">Cet identifiant est déjà pris</span>';
						$notSend = true;
					}
				}
				$request->closeCursor();
			}
			else
			{
				echo '<span class="invalid">Cet identifiant est invalide</span>';
				$notSend = true;
			}
		} 
		else 
		{
			$notSend = true;
		}
		?></p>
		<p><label>Mot de passe :<br />
			<input type="password" name="password" id="password"
			<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
		</label><br />
		<?php 
		// Password verification
		if (isset($_POST['password'])) 
		{
			if (empty($_POST['password']) || strlen($_POST['password']) > MAX_LOGIN_LENGTH)
			{
				echo '<span class="invalid">Ce mot de passe est invalide</span>';
				$notSend = true;	
			}
		}
		else
		{
			$notSend = true;
		}
		?></p>
		<p><label>Vérification du mot de passe :<br />
			<input type="password" name="verification" id="verification"
			<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
		</label><br />
		<?php 
		// Verification of password verification
		if (isset($_POST['verification']))
		{
			if (empty($_POST['verification'])
			    || strlen($_POST['verification']) > MAX_LOGIN_LENGTH
			    || $_POST['verification'] != $_POST['password'])
			{
				echo '<span class="invalid">La vérification ne correspond pas au mot de passe</span>';				
				$notSend = true;
			}
		} 
		else
		{				
			$notSend = true;
		}
		?>
		<p><label>Question secrète :<br />
			<input type="text" name="question" id="question"
			<?php echo 'maxlength="' . MAX_SENTENCES_LENGTH . '"';?> />
		</label><br />
		<?php 
		// Secret question verification
		if (isset($_POST['question']))
		{
			if (empty($_POST['question']) || strlen($_POST['question']) > MAX_SENTENCES_LENGTH)
			{
				echo '<span class="invalid">Cette question est invalide</span>';
				$notSend = true;
			}
		} 
		else 
		{
			$notSend = true;
		}
		?></p>
		<p><label>Réponse secrete :<br />
			<input type="password" name="answer" id="answer"
			<?php echo 'maxlength="' . MAX_SENTENCES_LENGTH . '"';?> />
		</label><br />
		<?php 
		// Secret answer verification
		if (isset($_POST['answer'])) 
		{
			if (empty($_POST['answer']) || strlen($_POST['answer']) > MAX_SENTENCES_LENGTH)
			{
				echo '<span class="invalid">Cette réponse est invalide</span>';
				$notSend = true;
			}			
		}
		else
		{
			$notSend = true;
		}
		?></p>
		<p><input type="submit" value="S'inscrire" class="button"/>  </p> 
	</fieldset>
</form>
<p>Vous possédez déjà un compte ? <a href="index.php?page=connexion">Connectez-vous</a></p>
</section>
<?php
// Registration success
if (!$notSend)
{
	// Registration, insertion in table members of database
	$hashPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$hashAnswer = password_hash($_POST['answer'], PASSWORD_DEFAULT);
	$request = $bdd->prepare('INSERT INTO members(lastname,firstname,login,password,question,answer) VALUES(:name,:firstname,:login,:password,:question,:answer)');
	$request->execute([
		'name' => $_POST['name'],
		'firstname' => $_POST['firstname'],
		'login' => $_POST['login'],
		'password' => $hashPassword,
		'question' => $_POST['question'],
		'answer' => $hashAnswer
	]);
	$request->closeCursor();

	// Id research of the new registrated user
	$request = $bdd->prepare('SELECT id_user FROM members WHERE login = :login');
	$request->execute(['login' => $_POST['login']]);
	$datas = $request->fetch();
	$idUser = $datas['id_user'];
	$request->closeCursor();

	// Insertion of the new potential likes (1 note / user / actor)
	$request = $bdd->prepare('SELECT id_actor FROM actors');
	$request->execute();
	while ($datas = $request->fetch())
	{
		$insertion = $bdd->prepare('INSERT INTO likes(id_user,id_actor,note) VALUES(:id_user,:id_actor,0)');
		$insertion->execute([
			'id_user' => $idUser,
			'id_actor' => $datas['id_actor']
		]);
		$insertion->closeCursor();			
	}
	$request->closeCursor();
	setcookie('registration', true, time() + 365*24*3600, null, null, false, true);
	header('Location: index.php?page=connexion');
}
?>