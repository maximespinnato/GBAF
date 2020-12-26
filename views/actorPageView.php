<main>
	<section id="acteur">
		<div id="imgActeur"><img src="images/logo_<?= $actor ?>.png" alt="logo_<?= $actor ?>"/></div>
		<div id="descriptionActeur"><h2><?= $actor ?></h2>
		<p><?= $description ?></p></div>
	</section>	

	<section id="commentaires">
		
		<div id="comsLikes">
			<div id="nombreComs">
				<?= $numberOfComments ?>							
			</div>
			<div id="likesDislikes">
				<p>
				<?= $numberOfLikes . ' ' . $logoLike . ' '  . $numberOfDislikes . ' ' . $logoDislike ?>
				</p>
			</div>
		</div>

		<form action="index.php?page=actorPage&amp;actor=<?= $idActor ?>" method="POST">
			<p><textarea name="content" rows=2 cols=30></textarea></p>
			<p><input type="submit" value="Ajouter un commentaire" class="bouton"/></p>
		</form>


		<!-- Publication des commentaires  -->
		<section id="tableCommentaires">
			<?= $commentsDisplay ?>
		</section>
	</section>
	<p><a href="index.php?page=home">Retour à l'accueil</a></p>
</main>