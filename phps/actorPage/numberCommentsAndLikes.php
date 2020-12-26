<?php 

// nombre de commentaires
$nbComments = countComments($idActor);
if ($nbComments > 1)
{
	$textComment = 'commentaires';	
}
else
{
	$textComment = 'commentaire';			
}
$numberOfComments = sprintf('<p>%d %s</p>',$nbComments,$textComment);




// Indication de la valeur du like de l'utilisateur
$noteValue = getLikeValue($_SESSION['id_user'], $idActor);

// Boutons like / dislike
if ($noteValue === '1')
{
	$colorLike = 'green';
	$likeLinkValue = '0';
	$colorDislike = 'white';
	$dislikeLinkValue = '-1';

}
elseif ($noteValue === '-1')
{
	$colorLike = 'white';
	$likeLinkValue = '1';
	$colorDislike = 'red';
	$dislikeLinkValue = '0';
}
else
{
	$colorLike = 'white';
	$likeLinkValue = '1';
	$colorDislike = 'white';
	$dislikeLinkValue = '-1';
}


$numberOfLikes = getNumberOfVotes($idActor, 1);

$logoLike = sprintf('<a href="index.php?page=actorPage&amp;actor=%s&amp;note=%s"><img src="images/happy %s transparent.png" </img></a>',$idActor,$likeLinkValue,$colorLike);

$numberOfDislikes = getNumberOfVotes($idActor, -1);

$logoDislike = sprintf('<a href="index.php?page=actorPage&amp;actor=%s&amp;note=%s"><img src="images/unhappy %s transparent.png" </img></a>',$idActor,$dislikeLinkValue,$colorDislike);
