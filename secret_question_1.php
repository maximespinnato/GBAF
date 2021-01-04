<?php
$_SESSION['loginQuestion'] = '';
?>
<section class="form">
	<h1>Connexion</h1>
		<form action="index.php?page=secret_question_1" method="POST"> 
			<fieldset>
				<p><label>Identifiant:<br />
					<input type="text" name="login" id="login"
					<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
				   </label><br />
				<?php 
				// Login verification
				if (isset($_POST['login'])) 
				{
					if (!empty($_POST['login']) && strlen($_POST['login']) <= MAX_LOGIN_LENGTH)
					{
						// Login verification and secret question display
						$request = $bdd->prepare('SELECT login FROM members');
						$request->execute();
						while ($datas = $request->fetch())
						{
							if ($_POST['login'] === $datas['login'])
							{
								$_SESSION['loginQuestion'] = $_POST['login'];
								$request->closeCursor();
								header('Location: index.php?page=secret_question_2');
							}
						}
						echo '<span class="invalid">Cet identifiant est invalide</span>';
						$request->closeCursor();
					}
					else
					{
						echo '<span class="invalid">Cet identifiant est invalide</span>';
					}
				} ?>
				</p>				
				<p><input type="submit" value="Question secrète" class="button"/>  <!-- submit : Bouton d'envoi --></p> 
			</fieldset>
		</form>				
		<p><a href="index.php?page=connexion" class="square-button" >Revenir à la connexion avec mot de passe</a></p>
		<p>Vous ne possédez pas de compte ? <a href="index.php?page=registration">Inscrivez-vous</a></p>
</section>