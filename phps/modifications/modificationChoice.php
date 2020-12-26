<?php
// Vérification du choix de modification
if (isset($_GET['field']))
{
	if ($_GET['field'] === '1' || $_GET['field'] === '2')
	{
		$modification = (int) $_GET['field'];
	}
	else 
	{
		header('Location: index.php?page=parameters');
	}
}
else 
{
	header('Location: index.php?page=parameters');
}

// Affichage mot de passe ou question
if ($modification === 1)
{
	$title = 'Modifier le mot de passe';
	$formPassword = '<p><label>Nouveau mot de passe : <br/>
				<input type="password" name="password" 
				maxlength="' . MAX_LOGIN . '"/>
			</label></p> <p><label>Vérification du mot de passe : <br/>
				<input type="password" name="verification" 
				maxlength="' . MAX_LOGIN . '"/>
			</label></p>';
}
else
{
	$title = 'Modifier la réponse secrète';
	$formPassword = '<p><label>Nouvelle réponse secrète : <br/>
				<input type="password" name="answer"
				maxlength="' . MAX_SENTENCES . '"/>
			</label></p>';
} 