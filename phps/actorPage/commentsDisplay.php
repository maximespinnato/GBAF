<?php
// Affichage des commentaires
ob_start() ;
$colorComment = 'blanc';
$request = getComments($idActor);
while ($datas = $request->fetch())
{
	$donneesfirstname = getFirstName($datas['id_user']);
	if ($colorComment === 'blanc')
	{
		$classComment = 'commentBlanc';
		echo sprintf('<div class="%s"><p>%s<br/>',$classComment,htmlspecialchars($donneesfirstname['firstname']));
		$colorComment = 'gris';	
	}
	else
	{
		$classComment = 'commentGris';
		echo sprintf('<div class="%s"><p>%s<br/>',$classComment,htmlspecialchars($donneesfirstname['firstname']));
		$colorComment = 'blanc';
	}
	echo $datas['date_add_fr'] . '<br/>';
	echo htmlspecialchars($datas['content']) . '</p></div>'; 
}
$request->closeCursor();
$commentsDisplay = ob_get_clean();