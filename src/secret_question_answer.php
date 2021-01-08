<?php
if (empty($_SESSION['loginQuestion']))
{
	header('Location: ../public/index.php?page=secret_question_login');
}
// Form prepare
$request = $bdd->prepare('SELECT id_user,question,answer FROM members WHERE login = :login');
$request->execute(['login' => $_SESSION['loginQuestion']]);
$userDatas = $request->fetch();
$idUser = $userDatas['id_user'];
$secretQuestion = $userDatas['question'];
$secretAnswer = $userDatas['answer'];
$request->closeCursor();
?>
<section class="form">
	<h1>Connexion</h1>
		<form action="../public/index.php?page=secret_question_answer" method="POST"> 
			<fieldset>
				<p class="secret-question">
					<label><?php echo htmlspecialchars($secretQuestion);?> :<br />
						<input type="password" name="answer" id="answer"
						<?php echo 'maxlength="' . MAX_SENTENCES_LENGTH . '"';?> />
					</label><br />
				<?php 
				// Secret answer verification
				if (isset($_POST['answer']))
				{
					if(password_verify($_POST['answer'], $secretAnswer))
					{
						if (isset($_POST['auto_connection']))
						{
							$_SESSION['auto_connection'] = true;
						} 
						$_SESSION['id_user'] = $idUser;
						$request = $bdd->prepare('SELECT lastname,firstname,login,password FROM members WHERE id_user = :id_user');
						$request->execute(['id_user' => $idUser]);
						$userAllDatas = $request->fetch();
						$_SESSION['login'] = $userAllDatas['login'];
						$_SESSION['hash_password'] = $userAllDatas['password'];
						$_SESSION['name'] = $userAllDatas['lastname'];
						$_SESSION['firstname'] = $userAllDatas['firstname'];
						$_SESSION['loginQuestion'] = '';		
						$request->closeCursor();
						header('Location: ../public/index.php?page=home');					
					}
					else
					{
						echo '<span class="invalid">Cette réponse est invalide</span>';		
					}
				} 
				?></p>
				<p><label><input type="checkbox" name="auto_connection" id="auto_connection"/>Connexion automatique</label></p>
				<p><input type="submit" value="Envoyer" class="button"/>  </p> 
			</fieldset>
		</form>		
		<p><a href="../public/index.php?page=secret_question_login" class="square-button">Changer d'identifiant</a></p>
		<p><a href="../public/index.php?page=connection" class="square-button">Revenir à la connexion avec mot de passe</a></p>
		<p>Vous ne possédez pas de compte ? <a href="../public/index.php?page=registration">Inscrivez-vous</a></p>
</section>