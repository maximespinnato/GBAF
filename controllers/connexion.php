<?php
$login = '';
$password = '';
$cookiePassword = '';
$_SESSION['loginQuestion'] = '';

// Message si registration ou désinscription
if (isset($_COOKIE['registration']) && $_COOKIE['registration'])
{
	$checkSign = 'Vous vous êtes bien inscrit';
	setcookie('registration','');
}
else $checkSign = ''; 
if (isset($_COOKIE['closeAccount']) && $_COOKIE['closeAccount'])
{
	$checkSign = 'Vous vous êtes bien désinscrit';
	setcookie('closeAccount','');
}
else $checkSign = ''; 
	
// Vérification des cookies si la connexion automatique est activée
if (isset($_COOKIE['autoConnexion']) && $_COOKIE['autoConnexion'])
{
	$login = $_COOKIE['login'];
	$cookiePassword = $_COOKIE['passwordHash'];
}

// Vérification des identifiants de connexion
if (!empty($_POST['login']) && strlen($_POST['login']) <= MAX_LOGIN
    && !empty($_POST['password']) && strlen($_POST['password']) <= MAX_LOGIN)
{
	$login = $_POST['login'];
	$password = $_POST['password'];
} 


// Vérification des identifiants dans la base de données et envoi si correct
$request = getAllUserDatas();
while ($datas = $request->fetch())
{
	if ($login === $datas['login'] && $cookiePassword === $datas['password'] 
		|| $login === $datas['login'] && password_verify($password, $datas['password']))
	{
		if (isset($_POST['autoConnexion']))
		{
			$_SESSION['autoConnexion'] = true;				
		}
		$_SESSION['id_user'] = $datas['id_user'];
		$_SESSION['login'] = $datas['login'];
		$_SESSION['passwordHash'] = $datas['password'];
		$_SESSION['lastname'] = $datas['lastname'];
		$_SESSION['firstname'] = $datas['firstname'];
		$request->closeCursor();
		require('phps/cookies/cookiesGeneration.php');
		header('Location: index.php?page=home');
	}
}	
$request->closeCursor();
if (!empty($_POST['login']) || !empty($_POST['password'])) 
{
	$messageCheck = 'L\'identification est invalide';
}
else $messageCheck = '';
	

require('views/connexionView.php');