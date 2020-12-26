<?php

// Vérification du name
if (isset($_POST['lastname']))
{
	if (empty($_POST['lastname']) || strlen($_POST['lastname']) > MAX_LOGIN)
	{
		$messageName = 'Ce nom est invalide';
		$noSend = true;
	}
	else $messageName = '';
} 
else 
{
	$noSend = true;
	$messageName = '';
}

// Vérification du firstname
if (isset($_POST['firstname']))
{
	if (empty($_POST['firstname']) || strlen($_POST['firstname']) > MAX_LOGIN)
	{
		$messageFirstname = '<span class="invalide">Ce prénom est invalide</span>';
		$noSend = true;
	}
	else $messageFirstname = '';
} 
else 
{
	$noSend = true;
	$messageFirstname = '';
}


// Vérification du login
if (isset($_POST['login']))
{
	if (!empty($_POST['login']) && strlen($_POST['login']) <= MAX_LOGIN)
	{
		$request = dbconnect()->prepare('SELECT login FROM members');
		$request->execute();
		while ($datas = $request->fetch())
		{
			if ($_POST['login'] === $datas['login'])
			{
				$messageExistingLogin = 'Cet identifiant est déjà pris';
				$noSend = true;
				break;
			}
			else $messageExistingLogin = '';
		}
		$request->closeCursor();
		$messageLogin = '';
	}
	else
	{
		$messageExistingLogin = '';
		$messageLogin = 'Cet identifiant est invalide';
		$noSend = true;
	}
} 
else 
{
	$messageExistingLogin = '';
	$messageLogin = '';
	$noSend = true;
}


// Vérification du mot de passe
if (isset($_POST['password'])) 
{
	if (empty($_POST['password']) || strlen($_POST['password']) > MAX_LOGIN)
	{
		$messagePassword =  'Ce mot de passe est invalide';
		$noSend = true;	
	}
	else $messagePassword = '';
}
else
{
	$noSend = true;
	$messagePassword = '';
}

// Vérification du mot de passe de vérif
if (isset($_POST['verification']))
{
	if (empty($_POST['verification'])
	    || strlen($_POST['verification']) > MAX_LOGIN
	    || $_POST['verification'] != $_POST['password'])
	{
		$messageVerification = 'La vérification ne correspond pas au mot de passe';				
		$noSend = true;
	}
	else $messageVerification = '';
} 
else
{				
	$noSend = true;
	$messageVerification = '';
}


// Vérification du de la question secrète
if (isset($_POST['question']))
{
	if (empty($_POST['question']) || strlen($_POST['question']) > MAX_SENTENCES)
	{
		$messageQuestion = 'Cette question est invalide';
		$noSend = true;
	}
	else $messageQuestion = '';
} 
else 
{
	$noSend = true;
	$messageQuestion = '';
}

// Vérification du mot de passe
if (isset($_POST['answer'])) 
{
	if (empty($_POST['answer']) || strlen($_POST['answer']) > MAX_SENTENCES)
	{
		$messageAnswer = 'Cette réponse est invalide';
		$noSend = true;
	}			
	else $messageAnswer = '';
}
else
{
	$noSend = true;
	$messageAnswer = '';
}