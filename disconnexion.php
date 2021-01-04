<?php 
// Delete of session and session variables
$_SESSION = array();
session_destroy();

// Delete of auto connexion cookies
setcookie('auto_connexion', '');
setcookie('login', '');
setcookie('hash_password', '');

header('Location: index.php?page=connexion');
?>