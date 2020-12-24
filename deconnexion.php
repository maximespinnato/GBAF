<?php 
// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();

// Suppression des cookies de connexion automatique
setcookie('connexion_auto', '');
setcookie('pseudo', '');
setcookie('motdepasse_hache', '');

header('Location: index.php?page=connexion');
?>