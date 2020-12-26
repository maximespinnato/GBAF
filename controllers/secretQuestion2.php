<?php

if (empty($_SESSION['loginQuestion']))
{
	header('Location: index.php?page=secretQuestion1');
}

// Obtention des question et réponse secrètes
$datas = getAnswerDatas($_SESSION['loginQuestion']);
$id_user = $datas['id_user'];
$secretQuestion = $datas['question'];
$secretAnswer = $datas['answer'];


// Vérification de la réponse secrete
if (isset($_POST['answer']))
{
	if(password_verify($_POST['answer'], $secretAnswer))
	{
		if (isset($_POST['autoConnexion']))
		{
			$_SESSION['autoConnexion'] = true;
		} 
		$_SESSION['id_user'] = $id_user;
		$datas = getSomeUserDatas($id_user);
		$_SESSION['login'] = $datas['login'];
		$_SESSION['passwordHash'] = $datas['password'];
		$_SESSION['lastname'] = $datas['lastname'];
		$_SESSION['firstname'] = $datas['firstname'];
		$_SESSION['loginQuestion'] = '';		
		
		require('phps/cookies/cookiesGeneration.php');
		header('Location: index.php?page=home');					
	}
	else
	{
		$messageAnswer = '<span class="invalide">Cette réponse est invalide</span>';		
	}
} 
else $messageAnswer = '';



require("views/secretQuestion2View.php");