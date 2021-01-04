<?php
if (empty($_SESSION['loginQuestion']))
{
	header('Location: index.php?page=secret_question_1');
}
// Form prepare
$request = $bdd->prepare('SELECT id_user,question,answer FROM members WHERE login = :login');
$request->execute(['login' => $_SESSION['loginQuestion']]);
$datas = $request->fetch();
$idUser = $datas['id_user'];
$secretQuestion = $datas['question'];
$secretAnswer = $datas['answer'];
$request->closeCursor();
?>
<section class="form">
	<h1>Connexion</h1>
		<form action="index.php?page=secret_question_2" method="POST"> 
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
						if (isset($_POST['auto_connexion']))
						{
							$_SESSION['auto_connexion'] = true;
						} 
						$_SESSION['id_user'] = $idUser;
						$request = $bdd->prepare('SELECT lastname,firstname,login,password FROM members WHERE id_user = :id_user');
						$request->execute(['id_user' => $idUser]);
						$datas = $request->fetch();
						$_SESSION['login'] = $datas['login'];
						$_SESSION['hash_password'] = $datas['password'];
						$_SESSION['name'] = $datas['lastname'];
						$_SESSION['firstname'] = $datas['firstname'];
						$_SESSION['loginQuestion'] = '';		
						$request->closeCursor();
						header('Location: index.php?page=home');					
					}
					else
					{
						echo '<span class="invalid">Cette réponse est invalide</span>';		
					}
				} 
				?></p>
				<p><label><input type="checkbox" name="auto_connexion" id="auto_connexion"/>Connexion automatique</label></p>
				<p><input type="submit" value="Envoyer" class="button"/>  </p> 
			</fieldset>
		</form>		
		<p><a href="index.php?page=secret_question_1" class="square-button">Changer d'identifiant</a></p>
		<p><a href="index.php?page=connexion" class="square-button">Revenir à la connexion avec mot de passe</a></p>
		<p>Vous ne possédez pas de compte ? <a href="index.php?page=registration">Inscrivez-vous</a></p>
</section>