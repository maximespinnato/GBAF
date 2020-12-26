<?php 

// Récupération des données de l'acteur
if (isset($_GET['actor']))
{
	$pageValide = false;
	$datas = getActorAll($_GET['actor']);
		
	if (!empty($datas['actor']))
	{
		$pageValide = true;
		$idActor = (int) $_GET['actor'];
		$actor = $datas['actor'];
		$description = $datas['description'];
	}
	if (!$pageValide)
	{
		header('Location: index.php?page=home');
	}
}
else
{
	header('Location: index.php?page=home');
}