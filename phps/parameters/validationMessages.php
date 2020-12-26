<?php
ob_start();
if (isset($_POST['submitted'])
    && empty($_POST['lastname'])
    && empty($_POST['firstname'])
    && empty($_POST['login'])
    && empty($_POST['question']))
{
	echo '<span class="invalide">Vous n\'avez rien modifié</span>';
}

// Validation des modifications
if ($updatename)
{
	echo '<span class="modifie">Votre nom a bien été modifié</span><br/>';	
}
if ($updatefirstname)
{
	echo '<span class="modifie">Votre prénom a bien été modifié</span><br/>';	
}
if ($updatelogin)
{
	echo '<span class="modifie">Votre identifiant a bien été modifié</span><br/>';	
} 
if($existingLogin)
{
	echo '<span class="invalide">Cet identifiant existe déjà</span><br/>';
}
if ($updateQuestion)
{
	echo '<span class="modifie">Votre question secrète a bien été modifiée</span><br/>';	
}
$validationMessages = ob_get_clean();