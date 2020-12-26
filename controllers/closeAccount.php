<?php
$invalidMessage = '';
// Vérification du mot de passe
if (!empty($_POST['password']) && strlen($_POST['password']) <= MAX_LOGIN)
{
	$datas = getPassword($_SESSION['id_user']);
	// Suppression du compte
	if (password_verify($_POST['password'], $datas['password']))
	{
		deleteUserDatas($_SESSION['id_user']);
		setcookie('closeAccount', true, time() + 365*24*3600, null, null, false, true);
		header('Location: index.php?page=disconnection');
	}
	$invalidMessage = '<p class="messageVerif"><span class="invalide">Le mot de passe est invalide.</span></p>';
}

require ("views/closeAccountView.php");

