<?php

$noSend = false;
$_SESSION['loginQuestion'] = '';


require('phps/registration/checkSignDatas.php');

// Inscription réussie
if (!$noSend)
{
	require('phps/registration/insertionUser.php');
}

require("views/registrationView.php");