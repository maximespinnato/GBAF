<section class="formulaire">
	<h1>Inscription</h1>
	<form action="index.php?page=registration" method="POST" id="inscriptionform"> 
		<fieldset>
			<p><label>Name :<br />
				<input type="text" name="lastname" id="lastname" maxlength="<?= MAX_LOGIN ?>"/>
			   </label><br />
			   <span class="invalide"><?= $messageName ?></span>
			</p>
			<p><label>Prénom :<br />
				<input type="text" name="firstname" id="firstname" maxlength="<?= MAX_LOGIN ?>"/>
			   </label><br />			
				<span class="invalide"><?= $messageFirstname ?></span>
			</p>
			<p><label>Identifiant :<br />
				<input type="text" name="login" id="login" maxlength="<?= MAX_LOGIN ?>"/>
			   </label><br /> 
			    <span class="invalide"><?= $messageExistingLogin ?></span>
				<span class="invalide"><?= $messageLogin ?></span>
			</p>
			<p><label>Mot de passe :<br />
				<input type="password" name="password" id="password" maxlength="<?= MAX_LOGIN ?>" />
			   </label><br />
				<span class="invalide"><?= $messagePassword ?></span>
			</p>
			<p><label>Vérification du mot de passe :<br />
				<input type="password" name="verification" id="verification" maxlength="<?= MAX_LOGIN ?>" />
			   </label><br />
				<span class="invalide"><?= $messageVerification ?></span>
			</p>
			<p><label>Question secrète :<br />
				<input type="text" name="question" id="question" maxlength="<?= MAX_SENTENCES ?>" />
			   </label><br />
				<span class="invalide"><?= $messageQuestion ?></span>
			</p>
			<p><label>Réponse secrete :<br />
				<input type="password" name="answer" id="answer" maxlength="<?= MAX_SENTENCES ?>" />
			   </label><br />
				<span class="invalide"><?= $messageAnswer ?></span>
			</p>
			<p>
				<input type="submit" value="S'inscrire" class="bouton"/>
			</p> 
		</fieldset>
	</form>
	<p>Vous possédez déjà un compte ? <a href="index.php?page=connexion">Connectez-vous</a></p>
</section>