<?php
// Vérification of modification choice
if (isset($_GET['field']))
{
	if ($_GET['field'] === 'password' || $_GET['field'] === 'answer')
	{
		$modification = $_GET['field'];
	}
	else 
	{
		header('Location: ../public/index.php?page=parameters');
	}
}
else 
{
	header('Location: ../public/index.php?page=parameters');
}


echo '<section class="form">';

if ($modification === 'password')
{
	echo '<h2>Modifier le mot de passe</h2>';
}
else
{
	echo '<h2>Modifier la réponse secrète</h2>';
} 

// Modification form
echo '<form action="../public/index.php?page=modification&amp;field=' . $modification .'" method="POST">';  
?>
	<fieldset id="current-password">
		<p><label>Entrez votre mot de passe actuel : <br/>
			<input type="password" name="current_password"
			<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
		</label></p>
		<p>OU</p>
		<p class="secret-question">
			<label>Entrez votre réponse secrète actuelle : <br/>
				<input type="password" name="current_answer"
				<?php echo 'maxlength="' . MAX_SENTENCES_LENGTH . '"';?> />
			</label><br/>
		<?php 
		$request = $bdd->prepare('SELECT question FROM members WHERE id_user = :id_user');
		$request->execute(['id_user' => $_SESSION['id_user']]);
		$userQuestion = $request->fetch();
		echo '(Question secrète : ' . htmlspecialchars($userQuestion['question']) . ')</p>';		
		$request->closeCursor();
	echo '</fieldset>';
	echo '<fieldset>';
		if ($modification === 'password')
		{
			echo'<p><label>Nouveau mot de passe : <br/>
						<input type="password" name="password" 
						maxlength="' . MAX_LOGIN_LENGTH . '"/>
					</label></p>';
			echo'<p><label>Vérification du mot de passe : <br/>
						<input type="password" name="verification" 
						maxlength="' . MAX_LOGIN_LENGTH . '"/>
					</label></p>';
		}
		else
		{
			echo'<p><label>Nouvelle réponse secrète : <br/>
						<input type="password" name="answer"
						maxlength="' . MAX_SENTENCES_LENGTH . '"/>
					</label></p>';
		}
		?>
		<p><input type="submit" value="Modifier" name="submitted" class="button"/></p>
	</fieldset>;
</form>

<p class="check-message">
<?php
if (isset($_POST['submitted'])
    && empty($_POST['current_password'])
    && empty($_POST['current_answer']))
{
	echo '<span class="invalid">Veuillez remplir votre mot de passe ou réponse secrète</span>';	
}
// Vérification of the old password
if (!empty($_POST['current_password']) && strlen($_POST['current_password']) <= MAX_LOGIN_LENGTH 
	|| !empty($_POST['current_answer']) && strlen($_POST['current_answer']) <= MAX_SENTENCES_LENGTH)
{
	$correctPassword = false;
	$request = $bdd->prepare('SELECT password,answer FROM members WHERE id_user = :id_user');
	$request->execute(['id_user' => $_SESSION['id_user']]);
	$userPasswords = $request->fetch();
	if (password_verify($_POST['current_password'], $userPasswords['password']) || 
		password_verify($_POST['current_answer'], $userPasswords['answer']))
	{
		$correctPassword = true;
		// Password modification
		if ($modification === 'password')
		{
			if (!empty($_POST['password']) && strlen($_POST['password']) <= MAX_LOGIN_LENGTH
			    && isset($_POST['verification']))
			{
				if ($_POST['password'] === $_POST['verification'])
				{
					$hashPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
					$update = $bdd->prepare('UPDATE members SET password = :password WHERE id_user = :id_user');
					$update->execute([
						'password' => $hashPassword,
						'id_user' => $_SESSION['id_user']
					]);
					$update->closeCursor();
					echo '<span class="modified">Votre mot de passe a bien été modifié</span>';
				}
				else
				{
					echo '<span class="invalid">La vérification du mot de passe ne correspond pas</span>';						
				}
			}
			else
			{
				echo '<span class="invalid">Votre nouveau mot de passe n\'est pas valide</span>';
			}
		}
		// Secret answer modification
		else
		{
			if (!empty($_POST['answer']) && strlen($_POST['answer']) <= MAX_SENTENCES_LENGTH)
			{
				$hashAnswer = password_hash($_POST['answer'], PASSWORD_DEFAULT);
				$update = $bdd->prepare('UPDATE members SET answer = :answer WHERE id_user = :id_user');
				$update->execute([
					'answer' => $hashAnswer,
					'id_user' => $_SESSION['id_user']
				]);
				$update->closeCursor();
				echo '<span class="modified">Votre réponse secrète a bien été modifiée</span>';
			}
			else
			{
				echo '<span class="invalid">Votre réponse secrète n\'est pas valide</span>';
			}				
		}
	}
	$request->closeCursor();
	if ($correctPassword === false)
	{
		echo '<span class="invalid">Votre mot de passe actuel ou votre réponse secrète actuelle n\'est pas correct(e)</span>';
	}
}
?>
</p>
<p><a href="../public/index.php?page=parameters" >Retour aux paramètres</a></p>
</section>