<?php
$_SESSION['pseudoQuestion'] = '';
?>
<section class="formulaire">
	<h1>Connexion</h1>
		<form action="index.php?page=question_secrete_1" method="POST"> 
			<fieldset>
				<p><label>Identifiant:<br />
					<input type="text" name="pseudo" id="pseudo"
					<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
				   </label><br />
				<?php 
				// Vérification du pseudo
				if (isset($_POST['pseudo'])) 
				{
					if (!empty($_POST['pseudo']) && strlen($_POST['pseudo']) <= MAX_LOGIN_LENGTH)
					{
						// Vérification de l'identifiant et affichage de la question secrète
						$requete = $bdd->prepare('SELECT login FROM members');
						$requete->execute();
						while ($donnees = $requete->fetch())
						{
							if ($_POST['pseudo'] === $donnees['login'])
							{
								$_SESSION['pseudoQuestion'] = $_POST['pseudo'];
								$requete->closeCursor();
								header('Location: index.php?page=question_secrete_2');
							}
						}
						echo '<span class="invalide">Cet identifiant est invalide</span>';
						$requete->closeCursor();
					}
					else
					{
						echo '<span class="invalide">Cet identifiant est invalide</span>';
					}
				} ?>
				</p>				
				<p><input type="submit" value="Question secrète" class="bouton"/>  <!-- submit : bouton d'envoi --></p> 
			</fieldset>
		</form>				
		<p><a href="index.php?page=connexion" class="boutonCarre" >Revenir à la connexion avec mot de passe</a></p>
		<p>Vous ne possédez pas de compte ? <a href="index.php?page=inscription">Inscrivez-vous</a></p>
</section>