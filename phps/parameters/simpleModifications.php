<?php 

$updatename = false;
$updatefirstname = false;
$existingLogin = false;
$updatelogin = false;
$updateQuestion = false;

// Modification du name
if (!empty($_POST['lastname']) && strlen($_POST['lastname']) <= MAX_LOGIN)
{
	$_SESSION['lastname'] = $_POST['lastname'];
	updateLastname($_SESSION['id_user'], $_POST['lastname']);
	$updatename = true;
}

// Modification du préname
if (!empty($_POST['firstname']) && strlen($_POST['firstname']) <= MAX_LOGIN)
{
	$_SESSION['firstname'] = $_POST['firstname'];
	updateFirstname($_SESSION['id_user'], $_POST['firstname']);
	$updatefirstname = true;
}

// Modification du login
if (!empty($_POST['login']) && strlen($_POST['login']) <= MAX_LOGIN)
{
	if (!existingLogin($_POST['login']))
	{
		updateLogin($_SESSION['id_user'], $_POST['login']);
		$updatelogin = true;		
	}
	else
	{
		$existingLogin = true;
	}
}

// Modification de la question
if (!empty($_POST['question']) && strlen($_POST['question']) <= MAX_SENTENCES)
{
	updateQuestion($_SESSION['id_user'], $_POST['question']);
	$updateQuestion = true;	
}

