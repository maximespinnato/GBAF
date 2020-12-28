<?php
session_start();
define('MAX_LOGIN_LENGTH', 40);
define('MAX_SENTENCES_LENGTH', 400);

$tableauConnexion = [
	'inscription' => 'Inscription',
	'connexion' => 'Connexion',
	'question_secrete_1' => 'Connexion',
	'question_secrete_2' => 'Connexion'
];

$tableauMembre = [
	'espace' => 'Accueil',
	'parametres' => 'Paramètres',
	'modification' => 'Modification',
	'desinscription' => 'Désinscription',
	'page_acteur' => 'Acteur',  // TODO Améliorer en ajoutant le nom de l'acteur
	'deconnexion' => 'Déconnexion'
];

$tableauPages = [$tableauConnexion,$tableauMembre];

// Nouvel onglet ?
if(!empty($_SESSION['page']) && !empty($_GET['page']))
{
	// Vérification de l'espace de session et redirection si nécessaire
	$sessionConnexion = array_key_exists($_GET['page'], $tableauConnexion);
	$sessionMembre = array_key_exists($_GET['page'], $tableauMembre);
	if ($sessionConnexion && !empty($_SESSION['id_user']))
	{
		$_SESSION['page'] = 'espace';
		$_SESSION['titre'] = 'Accueil';
		header('Location: index.php?page=espace.php');
	}
	elseif ($sessionMembre && empty($_SESSION['id_user']))
	{
		$_SESSION['page'] = 'connexion';
		$_SESSION['titre'] = 'Connexion';
		header('Location: index.php?page=connexion.php');
	}
	// Traitement de la demande GET (recherche de la page)
	foreach ($tableauPages as $idTableau)  // Sélection du tableau
	{
		foreach ($idTableau as $page => $titre) // Parcourir pages
		{
			if ($_GET['page'] === $page)  // Vérification de la page
			{ 
				if (($idTableau === $tableauConnexion && empty($_SESSION['id_user']))
					|| ($idTableau === $tableauMembre && !empty($_SESSION['id_user'])))
				{  // Vérification de la connexion
					$_SESSION['page'] = $page;
				} 
				else
				{
					header('Location: index.php?page=' . $_SESSION['page']);
				}
				if ($page === 'page_acteur' && !empty($_GET['acteur']))
				{
					switch ($_GET['acteur']) {
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
						default:
							$titre = 'Accueil';	        
					}
				}
				$_SESSION['titre'] = $titre;
			}
		}
	}
}
// Nouvel onglet : début ou session en cours
elseif (!empty($_SESSION['id_user']))
{
	$_SESSION['page'] = 'espace';
	$_SESSION['titre'] = 'Accueil';
	header('Location: index.php?page=espace.php');
}
else
{
	$_SESSION['page'] = 'connexion';
	$_SESSION['titre'] = 'Connexion';
	header('Location: index.php?page=connexion');
}
include('connexion_base_de_donnees.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" media="(min-device-width: 1280px)" href="style.css" />
		<link rel="stylesheet" media="(min-device-width: 450px) and (max-device-width: 1280px)" href="style_tablette.css" />
		<link rel="stylesheet" media="(max-device-width: 450px)" href="style_smartphone.css" />
		<link rel="shortcut icon" href="images/logo_gbaf.png">
		<?php echo '<title>' . htmlspecialchars($_SESSION['titre']) . '</title>'; ?>
	</head>

	<body>
		<?php 
		include ('header.php');
		include ($_SESSION['page'] . '.php');
		include ('footer.php'); 
		?>
	</body>
</html>