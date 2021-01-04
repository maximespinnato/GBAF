<?php
session_start();
define('MAX_LOGIN_LENGTH', 40);
define('MAX_SENTENCES_LENGTH', 400);

$connexionArray = [
	'registration' => 'Inscription',
	'connexion' => 'Connexion',
	'secret_question_1' => 'Connexion',
	'secret_question_2' => 'Connexion'
];

$memberArray = [
	'home' => 'Accueil',
	'parameters' => 'Paramètres',
	'modification' => 'Modification',
	'unsubscription' => 'Désinscription',
	'actor_page' => 'Acteur',
	'disconnexion' => 'Déconnexion'
];

$pagesArray = [$connexionArray,$memberArray];

// New tab ?
if(!empty($_SESSION['page']) && !empty($_GET['page']))
{
	// Verification of session place and redirection if necessary
	$connexionSession = array_key_exists($_GET['page'], $connexionArray);
	$memberSession = array_key_exists($_GET['page'], $memberArray);
	if ($connexionSession && !empty($_SESSION['id_user']))
	{
		$_SESSION['page'] = 'home';
		$_SESSION['title'] = 'Accueil';
		header('Location: index.php?page=home.php');
	}
	elseif ($memberSession && empty($_SESSION['id_user']))
	{
		$_SESSION['page'] = 'connexion';
		$_SESSION['title'] = 'Connexion';
		header('Location: index.php?page=connexion.php');
	}
	// Analysis of GET (page research)
	foreach ($pagesArray as $idArray)  // Array selection
	{
		foreach ($idArray as $page => $title) // Pages research
		{
			if ($_GET['page'] === $page)  // Page verification
			{ 
				if (($idArray === $connexionArray && empty($_SESSION['id_user']))
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
					switch ($_GET['actor']) {
					    case '1':
							$title = 'Formation&Co';
					        break;
					    case '2':
							$title = 'ProtectPeople';
					        break;
					    case '3':
							$title = 'DSA France';
					        break;
					    case '4':
							$title = 'CDE';
							break;			
						default:
							$title = 'Accueil';	        
					}
				}
				$_SESSION['title'] = $title;
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
	$_SESSION['page'] = 'connexion';
	$_SESSION['title'] = 'Connexion';
}
else
{
	$_SESSION['page'] = 'connexion';
	$_SESSION['title'] = 'Connexion';
}
include('database_connexion.php');
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" media="(min-width: 1280px)" href="style.css" />
		<link rel="stylesheet" media="(min-width: 450px) and (max-width: 1280px)" href="style_tablet.css" />
		<link rel="stylesheet" media="(max-width: 450px)" href="style_smartphone.css" />
		<link rel="shortcut icon" href="images/logo_gbaf.png">
		<?php echo '<title>' . htmlspecialchars($_SESSION['title']) . '</title>'; ?>
	</head>

	<body>
		<?php 
		include ('header.php');
		include ($_SESSION['page'] . '.php');
		include ('footer.php'); 
		?>
	</body>
</html>