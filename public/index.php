<?php
session_start();
include('../src/database_connection.php');
define('MAX_LOGIN_LENGTH', 40);
define('MAX_SENTENCES_LENGTH', 400);

$connectionArray = [
	'registration' => 'Inscription',
	'connection' => 'Connexion',
	'secret_question_login' => 'Connexion',
	'secret_question_answer' => 'Connexion'
];

$memberArray = [
	'home' => 'Accueil',
	'parameters' => 'Paramètres',
	'modification' => 'Modification',
	'unsubscription' => 'Désinscription',
	'actor_page' => 'Acteur',
	'disconnection' => 'Déconnexion'
];

$pagesArray = [$connectionArray,$memberArray];

// New tab ?
if(!empty($_SESSION['page']) && !empty($_GET['page']))
{
	// Verification of session place and redirection if necessary
	$connectionSession = array_key_exists($_GET['page'], $connectionArray);
	$memberSession = array_key_exists($_GET['page'], $memberArray);
	if ($connectionSession && !empty($_SESSION['id_user']))
	{
		$_SESSION['page'] = 'home';
		$_SESSION['title'] = 'Accueil';
		header('Location: index.php?page=home.php');
	}
	elseif ($memberSession && empty($_SESSION['id_user']))
	{
		$_SESSION['page'] = 'connection';
		$_SESSION['title'] = 'Connexion';
		header('Location: index.php?page=connection.php');
	}
	// Analysis of GET (page research)
	foreach ($pagesArray as $idArray)  // Array selection
	{
		foreach ($idArray as $page => $title) // Pages research
		{
			if ($_GET['page'] === $page)  // Page verification
			{ 
				if (($idArray === $connectionArray && empty($_SESSION['id_user']))
					|| ($idArray === $memberArray && !empty($_SESSION['id_user'])))
				{  // Connexion verification
					$_SESSION['page'] = $page;
				} 
				else
				{
					header('Location: index.php?page=' . $_SESSION['page']);
				}
				if ($page === 'actor_page' && !empty($_GET['actor']))
				{
					$actorTitleRequest = $bdd->prepare('SELECT actor FROM actors WHERE id_actor = :id_actor');
					$actorTitleRequest->execute(['id_actor' => (int) $_GET['actor']]);
					$titleActor = $actorTitleRequest->fetch();
					$actorTitleRequest->closeCursor();
					$title = $titleActor['actor'];
					if (empty($title))
					{
						$title = 'Acceuil';
					}	
				}
				$_SESSION['title'] =  $title;
			}
		}
	}
}
// New tab : start or current session
elseif (!empty($_SESSION['id_user']))
{
	$_SESSION['page'] = 'home';
	$_SESSION['title'] = 'Accueil';
	header('Location: index.php?page=home.php');
}
elseif (!empty($_COOKIE['unsubscription']) && $_COOKIE['unsubscription'])
{
	$_SESSION['page'] = 'connection';
	$_SESSION['title'] = 'Connexion';
}
else
{
	$_SESSION['page'] = 'connection';
	$_SESSION['title'] = 'Connexion';
}
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width" />
		<link rel="stylesheet" media="all" href="css/style.css" />
		<link rel="stylesheet" media="(min-width: 1281px)" href="css/style_desktop.css" />
		<link rel="stylesheet" media="(min-width: 651px) and (max-width: 1280px)" href="css/style_tablet.css" />
		<link rel="stylesheet" media="(max-width: 650px)" href="css/style_smartphone.css" />
		<link rel="shortcut icon" href="img/logo_gbaf.png">
		<?php echo '<title>' . (string) $_SESSION['title'] . '</title>'; ?>
	</head>

	<body>
		<?php 
		include ('../src/header.php');
		include ('../src/' . $_SESSION['page'] . '.php');
		include ('../src/footer.php'); 
		?>
	</body>
</html>