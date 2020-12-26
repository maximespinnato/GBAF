<?php

// Inscription, insertion dans la base de données membres
insertNewUser($_POST['lastname'], $_POST['firstname'], $_POST['login'], $_POST['password'], $_POST['question'], $_POST['answer']);

// Recherche de l'id_user du nouvel inscrit
$id_user = getIdUser($_POST['login']);

// Insertion des nouveaux likes potentiels (1 vote / user / acteur)
$request = getIdActors();
while ($datas = $request->fetch())
{
	insertLikesRows($id_user, $datas['id_actor']);			
}
$request->closeCursor();
setcookie('registration', true, time() + 365*24*3600, null, null, false, true);
header('Location: index.php?page=connexion');
