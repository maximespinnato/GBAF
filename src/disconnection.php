<?php 
// Delete of session and session variables
$_SESSION = array();
session_destroy();

// Delete of auto connection cookies
setcookie('auto_connection', '');
setcookie('login', '');
setcookie('hash_password', '');

header('Location: ../public/index.php?page=connection');
?>