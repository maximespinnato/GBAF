<?php
if (empty($_SESSION['pseudoQuestion']))
{
	header('Location: index.php?page=question_secrete_1');
}
// Préparation du formulaire
$requete = $bdd->prepare('SELECT id_user,question,answer FROM members WHERE login = :pseudo');
$requete->execute(['pseudo' => $_SESSION['pseudoQuestion']]);
$donnees = $requete->fetch();
$id_user = $donnees['id_user'];
$questionSecrete = $donnees['question'];
$reponseSecrete = $donnees['answer'];
$requete->closeCursor();
?>
<section class="formulaire">
	<h1>Connexion</h1>
		<form action="index.php?page=question_secrete_2" method="POST"> 
			<fieldset>
				<p class="questionSecrete">
					<label><?php echo htmlspecialchars($questionSecrete);?> :<br />
						<input type="password" name="reponse" id="reponse"
						<?php echo 'maxlength="' . MAX_PHRASES . '"';?> />
					</label><br />
				<?php 
				// Vérification de la réponse secrete
				if (isset($_POST['reponse']))
				{
					if(password_verify($_POST['reponse'], $reponseSecrete))
					{
						if (isset($_POST['connexion_auto']))
						{
							$_SESSION['connexion_auto'] = true;
						} 
						$_SESSION['id_user'] = $id_user;
						$requete = $bdd->prepare('SELECT lastname,firstname,login,password FROM members WHERE id_user = :id_user');
						$requete->execute(['id_user' => $id_user]);
						$donnees = $requete->fetch();
						$_SESSION['pseudo'] = $donnees['login'];
						$_SESSION['motdepasse_hache'] = $donnees['password'];
						$_SESSION['nom'] = $donnees['lastname'];
						$_SESSION['prenom'] = $donnees['firstname'];
						$_SESSION['pseudoQuestion'] = '';		
						$requete->closeCursor();
						header('Location: index.php?page=espace');					
					}
					else
					{
						echo '<span class="invalide">Cette reponse est invalide</span>';		
					}
				} 
				?></p>
				<p><label><input type="checkbox" name="connexion_auto" id="connexion_auto"/>Connexion automatique</label></p>
				<p><input type="submit" value="Envoyer" class="bouton"/>  <!-- submit : bouton d'envoi --></p> 
			</fieldset>
		</form>		
		<p><a href="index.php?page=question_secrete_1" class="boutonCarre">Changer d'identifiant</a></p>
		<p><a href="index.php?page=connexion" class="boutonCarre">Revenir à la connexion avec mot de passe</a></p>
		<p>Vous ne possédez pas de compte ? <a href="index.php?page=inscription">Inscrivez-vous</a></p>
</section>