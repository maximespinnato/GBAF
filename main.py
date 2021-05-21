import joueur
import paquet
import carte
import random
import time

# Faire la logique lorsqu'on n'a plus de cartes
# Sauter les joueurs qui n'ont plus de cartes
# Faire les conditions pour la fin d'une partie
# Régler plus finement le niveau des ordis
# Essayer la classe Jeu ! 
# Installer le module keyboard pour la détection des touches
# Commencer le graphique


### Conditions fin de partie : 
# Si le joueur n'a plus de cartes et qu'il n'y a pas de têtes en jeu:
	# Nombre de joueurs perdants = 0
	# Parcourir les paquets:
		# Si le paquet est vide :
			# Augmenter le nombre de joueurs perdants
		# else : gagnant = joueur.
	# Si le nombre de joueurs perdants = nombre de joueurs - 1
		# Joueur.FIN = True !!
		# Le gagnant est : gagnant

### Sauter les joueurs qui n'ont plus de cartes
# Tant que Autorisation = n
	# Si le joueur n+1 a encore des cartes:
		# Autoriser le joueur n+1 à jouer
	# Sinon : incrementer n


### Logique lorsque plus de cartes:
# Si il y a une tête : 
	# TETE EN COURS = TRUE

# Si joueur n n'a plus de cartes et TETE EN COURS et JOUEUR AIDEE = 0:
	# AUTORISATION JOUER = n+1 
	# JOUEUR AIDEE = n

# Si joueur n+1 n'a plus de cartes et TETE EN COURS et JOUEUR AIDEE = n:
	# AUTORISATION JOUER = n+2 

# Si un joueur récupère (en prenant ou tapant) :
	# JOUEUR AIDEE = 0

# Si il y a une tete et JOUEUR AIDEE = n :
	# JOUEUR AIDEE = 0
	# AUTORISATION PRENDRE = n
	# AUTORISATION JOUER = n + 1






def main():
	print("Réalisation du main")

	joueur.Joueur.initialize(7,4)
	#joueur.Joueur.AUTORISATION_TAPER = True
	print(joueur.Joueur.AUTORISATION_TAPER)
	print(joueur.Joueur.AUTORISATION_JOUER)

	paquet_complet = paquet.Paquet("Paquet complet")
	paquet_complet.creation_paquet_52_cartes()
	print(len(paquet_complet.liste))
	paquet_complet.melange()
	paquet_complet.montrer_paquet()
	paquet_complet.distribution_cartes(len(joueur.Joueur.JOUEURS))

	joueur.Joueur.JOUEURS[0].poser_carte()
	joueur.Joueur.JOUEURS[1].poser_carte()
	joueur.Joueur.JOUEURS[2].poser_carte()
	joueur.Joueur.JOUEURS[3].poser_carte()
	joueur.Joueur.JOUEURS[4].poser_carte()
	joueur.Joueur.JOUEURS[5].poser_carte()
	joueur.Joueur.JOUEURS[6].poser_carte()
	joueur.Joueur.JOUEURS[0].poser_carte()
	joueur.Joueur.JOUEURS[1].poser_carte()
	joueur.Joueur.JOUEURS[2].poser_carte()
	joueur.Joueur.JOUEURS[3].poser_carte()
	joueur.Joueur.JOUEURS[4].poser_carte()
	joueur.Joueur.JOUEURS[5].poser_carte()
	joueur.Joueur.JOUEURS[6].poser_carte()
	joueur.Joueur.JOUEURS[0].poser_carte()
	joueur.Joueur.JOUEURS[1].poser_carte()
	joueur.Joueur.JOUEURS[2].poser_carte()
	joueur.Joueur.JOUEURS[3].poser_carte()
	joueur.Joueur.JOUEURS[4].poser_carte()
	joueur.Joueur.JOUEURS[5].poser_carte()
	joueur.Joueur.JOUEURS[6].poser_carte()
	joueur.Joueur.JOUEURS[0].poser_carte()
	joueur.Joueur.JOUEURS[1].poser_carte()
	joueur.Joueur.JOUEURS[2].poser_carte()
	joueur.Joueur.JOUEURS[3].poser_carte()
	joueur.Joueur.JOUEURS[4].poser_carte()
	joueur.Joueur.JOUEURS[5].poser_carte()
	joueur.Joueur.JOUEURS[6].poser_carte()
	joueur.Joueur.JOUEURS[0].poser_carte()
	joueur.Joueur.JOUEURS[1].poser_carte()
	joueur.Joueur.JOUEURS[2].poser_carte()
	joueur.Joueur.JOUEURS[3].poser_carte()
	joueur.Joueur.JOUEURS[4].poser_carte()
	joueur.Joueur.JOUEURS[5].poser_carte()
	joueur.Joueur.JOUEURS[6].poser_carte()
	joueur.Joueur.JOUEURS[0].poser_carte()
	joueur.Joueur.JOUEURS[1].poser_carte()
	joueur.Joueur.JOUEURS[2].poser_carte()
	joueur.Joueur.JOUEURS[3].poser_carte()
	joueur.Joueur.JOUEURS[4].poser_carte()
	joueur.Joueur.JOUEURS[5].poser_carte()
	joueur.Joueur.JOUEURS[6].poser_carte()
	joueur.Joueur.JOUEURS[0].poser_carte()
	joueur.Joueur.JOUEURS[1].poser_carte()
	joueur.Joueur.JOUEURS[2].poser_carte()
	joueur.Joueur.JOUEURS[3].poser_carte()
	joueur.Joueur.JOUEURS[4].poser_carte()
	joueur.Joueur.JOUEURS[5].poser_carte()
	joueur.Joueur.JOUEURS[6].poser_carte()
	joueur.Joueur.JOUEURS[0].poser_carte()
	joueur.Joueur.JOUEURS[1].poser_carte()
	joueur.Joueur.JOUEURS[2].poser_carte()
	joueur.Joueur.JOUEURS[3].poser_carte()
	joueur.Joueur.JOUEURS[4].poser_carte()
	joueur.Joueur.JOUEURS[5].poser_carte()
	joueur.Joueur.JOUEURS[6].poser_carte()
	print("Attendons un peu...")
	time.sleep(10)
	print("Voilà, c'est bon !")


main()