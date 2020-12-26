<?php
// Ajout d'un commentaire dans la base de données
if (!empty($_POST['content']) && strlen($_POST['content']) <= MAX_SENTENCES)
{
	commentInsertion($_SESSION['id_user'],$idActor,$_POST['content']);
}


// Prise en compte du like
if (isset($_GET['note']))
{
	if ($_GET['note'] === '0' || $_GET['note'] === '1' || $_GET['note'] === '-1')
	{
		$note = (int) $_GET['note'];
	}
	updateLikeValue($note, $_SESSION['id_user'], $idActor);			
}	