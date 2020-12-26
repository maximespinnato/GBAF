<section class="formulaire">
	<h2>Paramètres</h2>

	<form action="index.php?page=parameters" method="POST">
		<fieldset>
			<p><label>Nom : <br/>
				<input type="text" name="lastname" placeholder="<?= htmlspecialchars($datas['lastname']) ?>" maxlength="<?= MAX_LOGIN ?>"/>
			   </label></p>
			<p><label>Prénom : <br/>
				<input type="text" name="firstname" placeholder="<?= htmlspecialchars($datas['firstname']) ?>" maxlength="<?= MAX_LOGIN ?>"/>
			   </label></p>
			<p><label>Identifiant : <br/>
				<input type="text" name="login" placeholder="<?= htmlspecialchars($datas['login']) ?>" maxlength="<?= MAX_LOGIN ?>"/>
			   </label></p>
			<p><label>Question secrète : <br/>
				<input type="text" name="question" placeholder="<?= htmlspecialchars($datas['question']) ?>" maxlength="<?= MAX_SENTENCES ?>"/>
			   </label></p>
			<p><input type="submit" value="Modifier" name="submitted" class="bouton"/></p>
		</fieldset>
	</form>

	<p class= messageVerif>
	<?= $validationMessages ?>
	</p>

	<div id="groupeBoutons">
		<p><a href="index.php?page=modification&amp;field=1" class="boutonCarre">Modifier le mot de passe</a></p>
		<p><a href="index.php?page=modification&amp;field=2" class="boutonCarre">Modifier la réponse secrète</a></p>
		<p><a href="index.php?page=closeAccount" class="boutonCarre" id="desinscrire">Se désinscrire</a></p>
	</div>
	
	<p><a href="index.php?page=home">Retour à l'accueil</a></p>
</section>