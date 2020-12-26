<?php


require("phps/modifications/modificationChoice.php");
$question = getQuestion($_SESSION['id_user']);

require("phps/modifications/messagesVerifications.php");


require("views/modificationView.php");