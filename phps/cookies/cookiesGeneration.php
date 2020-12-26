<?php
// Crée les cookies de connexion automatique 
if (isset($_SESSION['autoConnexion']) && $_SESSION['autoConnexion'])
{
	setcookie('connexion_auto', true, time() + 365*24*3600, null, null, false, true);
	setcookie('login', $_SESSION['login'], time() + 365*24*3600, null, null, false, true);
	setcookie('passwordHash', $_SESSION['passwordHash'], time() + 365*24*3600, null, null, false, true);
}