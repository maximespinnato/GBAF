<?php
// Vérification du choix de modification
if (isset($_GET['champs']))
{
	if ($_GET['champs'] === '1' || $_GET['champs'] === '2')
	{
		$modification = (int) $_GET['champs'];
	}
	else 
	{
		header('Location: index.php?page=parametres');
	}
}
else 
{
	header('Location: index.php?page=parametres');
}


echo '<section class="formulaire">';

if ($modification === 1)
{
	echo '<h2>Modifier le mot de passe</h2>';
}
else
{
	echo '<h2>Modifier la réponse secrète</h2>';
} 

// Formulaire de modification
echo '<form action="index.php?page=modification&amp;champs=' . $modification .'" method="POST">';  
?>
	<fieldset id="passActuel">
		<p><label>Entrez votre mot de passe actuel : <br/>
			<input type="password" name="motdepasseActuel"
			<?php echo 'maxlength="' . MAX_LOGIN_LENGTH . '"';?> />
		</label></p>
		<p>OU</p>
		<p class="questionSecrete">
			<label>Entrez votre réponse secrète actuelle : <br/>
				<input type="password" name="reponseActuelle"
				<?php echo 'maxlength="' . MAX_SENTENCES_LENGTH . '"';?> />
			</label><br/>
		<?php 
		$requete = $bdd->prepare('SELECT question FROM members WHERE id_user = :id_user');
		$requete->execute(['id_user' => $_SESSION['id_user']]);
		$donnees = $requete->fetch();
		echo '(Question secrète : ' . htmlspecialchars($donnees['question']) . ')</p>';		
		$requete->closeCursor();
	echo '</fieldset>';
	echo '<fieldset>';
		if ($modification === 1)
		{
			echo'<p><label>Nouveau mot de passe : <br/>
						<input type="password" name="motdepasse" 
						maxlength="' . MAX_LOGIN_LENGTH . '"/>
					</label></p>';
			echo'<p><label>Vérification du mot de passe : <br/>
						<input type="password" name="verification" 
						maxlength="' . MAX_LOGIN_LENGTH . '"/>
					</label></p>';
		}
		else
		{
			echo'<p><label>Nouvelle réponse secrète : <br/>
						<input type="password" name="reponse"
						maxlength="' . MAX_SENTENCES_LENGTH . '"/>
					</label></p>';
		}
		?>
		<p><input type="submit" value="Modifier" name="soumis" class="bouton"/></p>
	</fieldset>;
</form>

<p class="messageVerif">
<?php
if (isset($_POST['soumis'])
    && empty($_POST['motdepasseActuel'])
    && empty($_POST['reponseActuelle']))
{
	echo '<span class="invalide">Veuillez remplir votre mot de passe ou réponse secrète</span>';	
}
// Vérification de l'ancien mot de passe
if (!empty($_POST['motdepasseActuel']) && strlen($_POST['motdepasseActuel']) <= MAX_LOGIN_LENGTH 
	|| !empty($_POST['reponseActuelle']) && strlen($_POST['reponseActuelle']) <= MAX_SENTENCES_LENGTH)
{
	$passwordCorrect = false;
	$requete = $bdd->prepare('SELECT password,answer FROM members WHERE id_user = :id_user');
	$requete->execute(['id_user' => $_SESSION['id_user']]);
	$donnees = $requete->fetch();
	if (password_verify($_POST['motdepasseActuel'], $donnees['password']) || 
		password_verify($_POST['reponseActuelle'], $donnees['answer']))
	{
		$passwordCorrect = true;
		// Modification du mot de passe
		if ($modification === 1)
		{
			if (!empty($_POST['motdepasse']) && strlen($_POST['motdepasse']) <= MAX_LOGIN_LENGTH
			    && isset($_POST['verification']))
			{
				if ($_POST['motdepasse'] === $_POST['verification'])
				{
					$motdepasse_hache = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);
					$update = $bdd->prepare('UPDATE members SET password = :motdepasse WHERE id_user = :id_user');
					$update->execute([
						'motdepasse' => $motdepasse_hache,
						'id_user' => $_SESSION['id_user']
					]);
					$update->closeCursor();
					echo '<span class="modifie">Votre mot de passe a bien été modifié</span>';
				}
				else
				{
					echo '<span class="invalide">La vérification du mot de passe ne correspond pas</span>';						
				}
			}
			else
			{
				echo '<span class="invalide">Votre nouveau mot de passe n\'est pas valide</span>';
			}
		}
		// Modification de la réponse secrète
		else
		{
			if (!empty($_POST['reponse']) && strlen($_POST['reponse']) <= MAX_SENTENCES_LENGTH)
			{
				$reponse_hache = password_hash($_POST['reponse'], PASSWORD_DEFAULT);
				$update = $bdd->prepare('UPDATE members SET answer = :reponse WHERE id_user = :id_user');
				$update->execute([
					'reponse' => $reponse_hache,
					'id_user' => $_SESSION['id_user']
				]);
				$update->closeCursor();
				echo '<span class="modifie">Votre réponse secrète a bien été modifiée</span>';
			}
			else
			{
				echo '<span class="invalide">Votre réponse secrète n\'est pas valide</span>';
			}				
		}
	}
	$requete->closeCursor();
	if ($passwordCorrect === false)
	{
		echo '<span class="invalide">Votre mot de passe actuel ou votre réponse secrète actuelle n\'est pas correct(e)</span>';
	}
}
?>
</p>
<p><a href="index.php?page=parametres" >Retour aux paramètres</a></p>
</section>