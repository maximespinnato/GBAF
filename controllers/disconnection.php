<?php 
// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();

// Suppression des cookies de connexion automatique
setcookie('connexion_auto', '');
setcookie('login', '');
setcookie('passwordHash', '');

header('Location: index.php?page=connexion');