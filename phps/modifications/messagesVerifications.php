<?php 

if (isset($_POST['submitted'])
    && empty($_POST['currentPassword'])
	   && empty($_POST['currentAnswer']))
{
	$message1 = '<span class="invalide">Veuillez remplir votre mot de passe ou réponse secrète</span>';	
}
else $message1 = '';


// Vérification de l'ancien mot de passe
if (!empty($_POST['currentPassword']) && strlen($_POST['currentPassword']) <= MAX_LOGIN 
	|| !empty($_POST['currentAnswer']) && strlen($_POST['currentAnswer']) <= MAX_SENTENCES)
{
	$datas = getPasswordAnswer($_SESSION['id_user']);
	if (password_verify($_POST['currentPassword'], $datas['password']) || 
		password_verify($_POST['currentAnswer'], $datas['answer']))
	{
		// Modification du mot de passe
		if ($modification === 1)
		{
			if (!empty($_POST['password']) && strlen($_POST['password']) <= MAX_LOGIN
			    && isset($_POST['verification']))
			{
				if ($_POST['password'] === $_POST['verification'])
				{
					updateHashPassword($_SESSION['id_user'], $_POST['password']);
					$message2 = '<span class="modifie">Votre mot de passe a bien été modifié</span>';
				}
				else
				{
					$message2 = '<span class="invalide">La vérification du mot de passe ne correspond pas</span>';				
				}
			}
			else
			{
				$message2 = '<span class="invalide">Votre nouveau mot de passe n\'est pas valide</span>';
			}
		}
		// Modification de la réponse secrète
		else
		{
			if (!empty($_POST['answer']) && strlen($_POST['answer']) <= MAX_SENTENCES)
			{
				updateHashAnswer($_SESSION['id_user'], $_POST['answer']);
				$message2 = '<span class="modifie">Votre réponse secrète a bien été modifiée</span>';
			}
			else
			{
				$message2 = '<span class="invalide">Votre réponse secrète n\'est pas valide</span>';
			}				
		}
	}
	else
	{
		$message2 = '<span class="invalide">Votre mot de passe actuel ou votre réponse secrète actuelle n\'est pas correct(e)</span>';
	}
}
else $message2 = '';