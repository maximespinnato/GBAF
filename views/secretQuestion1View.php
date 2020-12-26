<section class="formulaire">
	<h1>Connexion</h1>
	<form action="index.php?page=secretQuestion1" method="POST"> 
		<fieldset>
			<p><label>Identifiant:<br />
				<input type="text" name="login" id="login" maxlength="<?= MAX_LOGIN ?>"/>
				</label><br />
				<?= $invalidMessage ?>
			</p>				
			<p><input type="submit" value="Question secrète" class="bouton"/></p> 
		</fieldset>
	</form>				
	<p><a href="index.php?page=connexion" class="boutonCarre" >Revenir à la connexion avec mot de passe</a></p>
	<p>Vous ne possédez pas de compte ? <a href="index.php?page=registration">Inscrivez-vous</a></p>
</section>