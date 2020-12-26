<?php
// Vérification du login
if (isset($_POST['login'])) 
{
	if (!empty($_POST['login']) && strlen($_POST['login']) <= MAX_LOGIN)
	{
		// Vérification de l'identifiant et affichage de la question secrète
		
		$request = getLogins();
		while ($datas = $request->fetch())
		{
			if ($_POST['login'] === $datas['login'])
			{
				$_SESSION['loginQuestion'] = $_POST['login'];
				$request->closeCursor();
				header('Location: index.php?page=secretQuestion2');
			}
		}
		$invalidMessage =  '<span class="invalide">Cet identifiant est invalide</span>';
		$request->closeCursor();
	}
	else
	{
		$invalidMessage = '<span class="invalide">Cet identifiant est invalide</span>';
	}
} 
else $invalidMessage = '';
