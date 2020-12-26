<?php

require ("phps/parameters/simpleModifications.php");
require ("phps/parameters/validationMessages.php");

$datas = getUserSimpleDatas($_SESSION['id_user']);

require ("views/parametersView.php");