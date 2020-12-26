<?php

function dbconnect()
{
	$bdd = new PDO('mysql:host=mysql-gbaf.alwaysdata.net;dbname=gbaf_mysql','gbaf','patate64', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
	return $bdd;
}


// Fonctions de la page espace
function getActor()
{
	$request = dbconnect()->prepare('SELECT id_actor,actor,description FROM actors');
	$request->execute();
	return $request;
}

// Fonctions de la page acteur
function getActorAll($actor)
{
	$request = dbconnect()->prepare('SELECT actor, description FROM actors WHERE id_actor = :id_actor');
	$request->execute(['id_actor' => (int) $actor]);
	$datas = $request->fetch();
	$request->closeCursor();
	return $datas;
}

function commentInsertion($id_user, $id_actor, $content)
{
	$request = dbconnect()->prepare('INSERT INTO comments(id_user,id_actor,date_add,content) VALUES(:id_user,:id_actor,NOW(),:content)');
	$request->execute([
		'id_user' => $id_user,
		'id_actor' => $id_actor,
		'content' => $content
	]);
	$request->closeCursor();
}

function countComments($id_actor)
{
	$request = dbconnect()->prepare('SELECT COUNT(*) AS numberComments FROM comments WHERE id_actor = :id_actor');
	$request->execute(['id_actor' => $id_actor]);
	$datas = $request->fetch();
	$request->closeCursor();
	return $datas['numberComments'];
}

function updateLikeValue($note, $id_user, $id_actor)
{
	$request = dbconnect()->prepare('UPDATE likes SET note = :note WHERE id_user = :id_user AND id_actor = :id_actor');
	$request->execute([
		'note' => $note,
		'id_user' => $id_user,
		'id_actor' => $id_actor
	]);
	$request->closeCursor();
}

function getLikeValue($id_user, $id_actor)
{
	$request = dbconnect()->prepare('SELECT note FROM likes WHERE id_user = :id_user AND id_actor = :id_actor');
	$request->execute([
		'id_user' => $id_user,
		'id_actor' => $id_actor
	]);
	$datas = $request->fetch();
	$request->closeCursor();
	return $datas['note'];
}


function getNumberOfVotes($id_actor, $voteValue)
{
	$request = dbconnect()->prepare('SELECT COUNT(*) AS numberLikes FROM likes WHERE id_actor = :id_actor AND note = :note');
	$request->execute(['id_actor' => $id_actor, 'note' => $voteValue]);
	$datas = $request->fetch();
	$request->closeCursor();
	return $datas['numberLikes'];
}


function getComments($id_actor)
{
	$request = dbconnect()->prepare('SELECT id_user,content,DATE_FORMAT(date_add,"Le %d/%m/%Y à %H:%i:%s") AS date_add_fr FROM comments WHERE id_actor = :id_actor ORDER BY date_add');
	$request->execute(['id_actor' => $id_actor]);
	return $request;
}


function getFirstname($id_user)
{
	$firstname = dbconnect()->prepare('SELECT firstname FROM members WHERE id_user = :id_user');
	$firstname->execute(['id_user' => $id_user]);
	$datasfirstname = $firstname->fetch();
	$firstname->closeCursor();
	return $datasfirstname ;
}

// Fonctions désinscription
function getPassword($id_user)
{
	$request = dbconnect()->prepare('SELECT password FROM members WHERE id_user = :id_user');
	$request->execute(['id_user' => $id_user]);
	$datas = $request->fetch();
	$request->closeCursor();
	return $datas;
}

function deleteUserDatas($id_user)
{
	$delete = dbconnect()->prepare('DELETE FROM members WHERE id_user = :id_user');
	$delete->execute(['id_user' => $id_user]);
	$delete->closeCursor();
	$delete = dbconnect()->prepare('DELETE FROM likes WHERE id_user = :id_user');
	$delete->execute(['id_user' => $id_user]);
	$delete->closeCursor();
	$delete = dbconnect()->prepare('DELETE FROM comments WHERE id_user = :id_user');
	$delete->execute(['id_user' => $id_user]);
	$delete->closeCursor();
}


// Fonctions paramètres
function getUserSimpleDatas($id_user)
{
	$request = dbconnect()->prepare('SELECT lastname,firstname,login,password,question,answer FROM members WHERE id_user = :id_user');
	$request->execute(['id_user' => $id_user]);
	$datas = $request->fetch();
	$request->closeCursor(); 
	return $datas;
}

function updateLastname($id_user, $newLastname)
{
	$update = dbconnect()->prepare('UPDATE members SET lastname = :lastname WHERE id_user = :id_user');
	$update->execute([
		'lastname' => $newLastname,
		'id_user' => $id_user
	]);
	$update->closeCursor();	
}


function updateFirstname($id_user, $newFirstname)
{
	$update = dbconnect()->prepare('UPDATE members SET firstname = :firstname WHERE id_user = :id_user');
	$update->execute([
		'firstname' => $newFirstname,
		'id_user' => $id_user
	]);
	$update->closeCursor();
}



function updateLogin($id_user, $newLogin)
{
	$update = dbconnect()->prepare('UPDATE members SET login = :login WHERE id_user = :id_user');
	$update->execute([
		'login' => $newLogin,
		'id_user' => $id_user
	]);
	$update->closeCursor();	
}

function existingLogin($newLogin)
{
	$request = dbconnect()->prepare('SELECT login FROM members');
	$request->execute();
	while($datas = $request->fetch())
	{
		if ($newLogin === $datas['login'])
		{
			$request->closeCursor();
			return true;
		}	
	}
	$request->closeCursor();
	return false;
}

function updateQuestion($id_user, $newQuestion)
{
	$update = dbconnect()->prepare('UPDATE members SET question = :question WHERE id_user = :id_user');
	$update->execute([
		'question' => $newQuestion,
		'id_user' => $id_user
	]);
	$update->closeCursor();
}

// Fonctions Modifications
function getQuestion($id_user)
{
	$request = dbconnect()->prepare('SELECT question FROM members WHERE id_user = :id_user');
	$request->execute(['id_user' => $id_user]);
	$datas = $request->fetch();
	$request->closeCursor();
	return $datas['question'];
}

function getPasswordAnswer($id_user)
{
	$request = dbconnect()->prepare('SELECT password,answer FROM members WHERE id_user = :id_user');
	$request->execute(['id_user' => $id_user]);
	$datas = $request->fetch();
	$request->closeCursor();
	return $datas;
}


function updateHashPassword($id_user, $newPassword)
{
	$hashPassword = password_hash($newPassword, PASSWORD_DEFAULT);
	$update = dbconnect()->prepare('UPDATE members SET password = :password WHERE id_user = :id_user');
	$update->execute([
		'password' => $hashPassword,
		'id_user' => $id_user
	]);
	$update->closeCursor();
}


function updateHashAnswer($id_user, $newAnswer)
{
	$answerHash = password_hash($newAnswer, PASSWORD_DEFAULT);
	$update = dbconnect()->prepare('UPDATE members SET answer = :answer WHERE id_user = :id_user');
	$update->execute([
		'answer' => $answerHash,
		'id_user' => $id_user
	]);
	$update->closeCursor();
}


// Fonctions question secrete 1
function getLogins()
{
	$request = dbconnect()->prepare('SELECT login FROM members');
	$request->execute();
	return $request;
}

// Fonctions question secrete 2
function getAnswerDatas($login)
{
	$request = dbconnect()->prepare('SELECT id_user,question,answer FROM members WHERE login = :login');
	$request->execute(['login' => $login]);
	$datas = $request->fetch();
	$request->closeCursor();
	return $datas;
}


function getSomeUserDatas($id_user)
{
	$request = dbconnect()->prepare('SELECT lastname,firstname,login,password FROM members WHERE id_user = :id_user');
	$request->execute(['id_user' => $id_user]);
	$datas = $request->fetch();
	$request->closeCursor();
	return $datas;
}



// Fonctions connexion
function getAllUserDatas()
{
	$request = dbconnect()->prepare('SELECT id_user, lastname, firstname, login, password, question, answer FROM members');
	$request->execute();
	return $request;
}


// Fonctions registration

function insertNewUser($lastname, $firstname, $login, $password, $question, $answer)
{
	$passHash = password_hash($password, PASSWORD_DEFAULT);
	$answerHash = password_hash($answer, PASSWORD_DEFAULT);
	$request = dbconnect()->prepare('INSERT INTO members(lastname,firstname,login,password,question,answer) VALUES(:lastname,:firstname,:login,:password,:question,:answer)');
	$request->execute([
		'lastname' => $lastname,
		'firstname' => $firstname,
		'login' => $login,
		'password' => $passHash,
		'question' => $question,
		'answer' => $answerHash
	]);
	$request->closeCursor();
}

function getIdUser($login)
{
	$request = dbconnect()->prepare('SELECT id_user FROM members WHERE login = :login');
	$request->execute(['login' => $login]);
	$datas = $request->fetch();
	$request->closeCursor();
	return $datas['id_user'];
}

function getIdActors()
{
	$request = dbconnect()->prepare('SELECT id_actor FROM actors');
	$request->execute();
	return $request;
}

function insertLikesRows($id_user, $id_actor)
{
	$insertion = dbconnect()->prepare('INSERT INTO likes(id_user,id_actor,note) VALUES(:id_user,:id_actor,0)');
	$insertion->execute([
		'id_user' => $id_user,
		'id_actor' => $id_actor
	]);
	$insertion->closeCursor();
}