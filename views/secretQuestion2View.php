<section class="formulaire">
	<h1>Connexion</h1>
	<form action="index.php?page=secretQuestion2" method="POST"> 
		<fieldset>
			<p class="questionSecrete">
				<label><?= htmlspecialchars($secretQuestion) ?> :<br />
					<input type="password" name="answer" id="answer" maxlength=" <?= MAX_SENTENCES ?>" />
				</label><br />
				<?= $messageAnswer ?>
			</p>
			<p><label><input type="checkbox" name="connexion_auto" id="connexion_auto"/>Connexion automatique</label></p>
			<p><input type="submit" value="Envoyer" class="bouton"/>  <!-- submit : bouton d'envoi --></p> 
		</fieldset>
	</form>		
	<p><a href="index.php?page=secretQuestion1" class="boutonCarre">Changer d'identifiant</a></p>
	<p><a href="index.php?page=connexion" class="boutonCarre">Revenir à la connexion avec mot de passe</a></p>
	<p>Vous ne possédez pas de compte ? <a href="index.php?page=registration">Inscrivez-vous</a></p>
</section>