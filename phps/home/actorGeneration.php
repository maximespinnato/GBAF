<?php
ob_start();
$request = getActor();
while ($datas = $request->fetch())
{
?>
<article>
	<div>
		<a href="index.php?page=actorPage&amp;actor=<?= $datas['id_actor'] ?>">
			<img src="images/logo_<?= $datas['actor'] ?>.png" alt="logo_<?= $datas['actor'] ?>" />
		</a>
	</div>
	<div>
		<a href="index.php?page=actorPage&amp;actor=<?= $datas['id_actor'] ?>">
			<h3><?= $datas['actor'] ?></h3>
		</a>
	<p><?= substr($datas['description'], 0, strpos($datas['description'], '<br')) ?></p>
	</div>
	<div>
		<a href="index.php?page=actorPage&amp;actor=<?= $datas['id_actor'] ?>">Lire plus</a>
	</div>
</article>
<?php	
}
$request->closeCursor();
$generationActeurs = ob_get_clean();