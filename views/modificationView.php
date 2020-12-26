<section class="formulaire">
	<h2> <?= $title ?> </h2>

	<form action="index.php?page=modification&amp;field=<?= $modification ?>" method="POST"> 
		<fieldset id="passActuel">
			<p><label>Entrez votre mot de passe actuel : <br/>
				<input type="password" name="currentPassword" maxlength="<?= MAX_LOGIN ?>"/>
			   </label>
			</p>
			<p>OU</p>
			<p class="questionSecrete">
				<label>Entrez votre réponse secrète actuelle : <br/>
					<input type="password" name="currentAnswer" maxlength="<?= MAX_SENTENCES ?>"/>
				</label><br/>
				(Question secrète : <?= htmlspecialchars($question) ?>)
			</p>	
		</fieldset>
		<fieldset>
			<?= $formPassword ?>
			<p><input type="submit" value="Modifier" name="submitted" class="bouton"/></p>
		</fieldset>
	</form>

	<p class="messageVerif">
		<?= $message1 ?>
		<?= $message2 ?>
	</p>
	<p><a href="index.php?page=parameters" >Retour aux paramètres</a></p>
</section>