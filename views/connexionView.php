<section class="formulaire">
	<p class="messageVerif">
		<span class="modifie"><?= $checkSign ?></span>
	</p>
	<h1>Connexion</h1>
	<form action="index.php?page=connexion" method="POST"> 
		<fieldset>
			<p><label>Identifiant:<br />
					<input type="text" name="login" id="login" maxlength="<?= MAX_LOGIN ?>"/>
				</label></p>
			<p><label>Mot de passe :<br />
					<input type="password" name="password" id="password" maxlength="<?= MAX_LOGIN ?>"/>
			   </label></p>
			<p><input type="checkbox" name="connexion_auto" id="connexion_auto"/><label for="connexion_auto">Connexion automatique</label></p>
			<p><input type="submit" value="Connexion" class="bouton"/></p>
		</fieldset> 
	</form>

	<p class="messageVerif"><span class="invalide"><?= $messageCheck ?></span></p>
	<p>Mot de passe oublié ? <a href="index.php?page=secretQuestion1">Répondez à la question secrète</a></p>
	<p>Vous ne possédez pas de compte ? <a href="index.php?page=registration">Inscrivez-vous</a></p>
</section>