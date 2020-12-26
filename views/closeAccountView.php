<section class="formulaire">
	<h2>Souhaitez-vous vraiment vous désinscrire ?</h2>
	<form action="index.php?page=closeAccount" method="POST">
		<p>
			<label>Mot de passe : 
				<input type="password" name="password" id="password" maxlength="<?= MAX_LOGIN ?>" />
		   </label>
		</p>
		<p><input type="submit" value="Se désinscrire" class="boutonCarre"/></p>
	</form>
	
	<?= $invalidMessage ?>

	<p><a href="index.php?page=parameters">Retour aux paramètres</a></p>
</section>