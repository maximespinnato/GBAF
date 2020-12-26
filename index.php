<?php
session_start();
define('MAX_LOGIN', 40);
define('MAX_SENTENCES', 400);

$connexionArray = [
	'registration' => 'Inscription',
	'connexion' => 'Connexion',
	'secretQuestion1' => 'Connexion',
	'secretQuestion2' => 'Connexion'
];

$memberArray = [
	'home' => 'Accueil',
	'parameters' => 'Paramètres',
	'modification' => 'Modification',
	'closeAccount' => 'Désinscription',
	'actorPage' => 'Acteur',
	'disconnection' => 'Déconnexion'
];

$pagesArray = [$connexionArray,$memberArray];

// Nouvel onglet ?
if(!empty($_SESSION['page']) && !empty($_GET['page']))
{
	// Vérification de l'espace de session et redirection si nécessaire
	$connexionSession = array_key_exists($_GET['page'], $connexionArray);
	$memberSession = array_key_exists($_GET['page'], $memberArray);
	if ($connexionSession && !empty($_SESSION['id_user']))
	{
		$_SESSION['page'] = 'home';
		$_SESSION['title'] = 'Acceuil';
		header('Location: index.php?page=home.php');
	}
	elseif ($memberSession && empty($_SESSION['id_user']))
	{
		$_SESSION['page'] = 'connexion';
		$_SESSION['title'] = 'Connexion';
		header('Location: index.php?page=connexion.php');
	}
	// Traitement de la demande GET (recherche de la page)
	for ($n = 0 ; $n < 2 ; $n++)  // Sélection du tableau
	{
		foreach ($pagesArray[$n] as $page => $titre) // Parcourir pages
		{
			if ($_GET['page'] === $page)  // Vérification de la page
			{ 
				if (($n === 0 && empty($_SESSION['id_user']))
					|| ($n === 1 && !empty($_SESSION['id_user'])))
				{  // Vérification de la connexion
					$_SESSION['page'] = $page;
				} 
				else
				{
					header('Location: index.php?page=' . $_SESSION['page']);
				}
				if ($page === 'page_acteur' && !empty($_GET['actor']))
				{
					switch ($_GET['actor']) {
					    case '1':
							$titre = 'Formation&Co';
					        break;
					    case '2':
							$titre = 'ProtectPeople';
					        break;
					    case '3':
							$titre = 'DSA France';
					        break;
					    case '4':
							$titre = 'CDE';
					        break;				        
					}
				}
				$_SESSION['title'] = $titre;
			}
		}
	}
}
// Nouvel onglet : début ou session en cours
elseif (!empty($_SESSION['id_user']))
{
	$_SESSION['page'] = 'home';
	$_SESSION['title'] = 'Acceuil';
	header('Location: index.php?page=home.php');
}
else
{
	$_SESSION['page'] = 'connexion';
	$_SESSION['title'] = 'Connexion';
	header('Location: index.php?page=connexion');
}
include('models/model.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" media="(min-device-width: 1280px)" href="css/style.css" />
		<link rel="stylesheet" media="(min-device-width: 450px) and (max-device-width: 1280px)" href="css/style_tablette.css" />
		<link rel="stylesheet" media="(max-device-width: 450px)" href="css/style_smartphone.css" />
		<link rel="shortcut icon" href="images/logo_gbaf.png">
		<?= '<title>' . htmlspecialchars($_SESSION['title']) . '</title>' ?>
	</head>

	<body>
		<?php 
		include('views/header.php');
		include('controllers/' . $_SESSION['page'] . '.php');
		include('views/footer.php'); 
		?>
	</body>
</html>