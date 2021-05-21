import carte
import random
import joueur

class Paquet:

	VALEURS = ["As", "Deux", "Trois", "Quatre", "Cinq", "Six", "Sept", "Huit", "Neuf", "Dix", "Valet", "Dame", "Roi"]
	COULEURS = ["Coeur", "Pique", "Carreau", "Trèfle"]
	PAQUETS = []

	def __init__(self, nom):
		self.liste = []
		self.nom = nom


	def montrer_paquet(self):
		print("Montrage du paquet : ", self.nom)
		for carte in self.liste:
			print(carte.nom, carte.couleur)

	def montrer_n_cartes(self, nombre):
		print("Montrage de", nombre, "cartes")
		n = 0
		for carte in self.liste:
			print(carte.nom, carte.couleur)
			n = n + 1
			if n == 5:
				break

	def creation_paquet_52_cartes(self):
		print("Création du paquet de cartes : ", self.nom)
		for couleur in self.COULEURS:
			for nom in self.VALEURS:
				nouvelle_carte = carte.Carte(nom, couleur)
				print(nouvelle_carte.nom, nouvelle_carte.couleur)
				self.liste.append(nouvelle_carte)

	def melange(self):
		print("Mélange du paquet : ", self.nom)
		for n in range(100000):
			carte_deplacee = self.liste[0]
			self.liste.pop(0)
			nombre_aleatoire = random.randint(0, 51)
			self.liste.insert(nombre_aleatoire, carte_deplacee)


	def distribution_cartes(self, nombre_joueurs):
		print("Distribution du :", self.nom, "en ", nombre_joueurs, "paquets")
		for numero_paquet in range(1, nombre_joueurs + 1):
			nouveau_paquet = Paquet("Paquet n° " + str (numero_paquet))
			print("Création du", nouveau_paquet.nom)
			Paquet.PAQUETS.append(nouveau_paquet)
		while len(self.liste) != 0:
			for paquet in Paquet.PAQUETS:
				if len(self.liste) == 0:
					break
				carte = self.liste[0]
				self.liste.pop(0)
				paquet.liste.append(carte)
		paquet_central = Paquet("Paquet central")
		Paquet.PAQUETS.insert(0, paquet_central)


	def verification_autorisations(self):
		joueur.Joueur.AUTORISATION_TAPER = False
		if self.liste[0].nom == "Dix" and self.liste[0].penalite == False:
			print("Le dix ! On peut taper !")
			joueur.Joueur.AUTORISATION_TAPER = True
		if len(self.liste) >= 2 and self.liste[0].nom == self.liste[1].nom and self.liste[1].penalite == False:
			print("Paires ! On peut taper !")
			joueur.Joueur.AUTORISATION_TAPER = True
		if len(self.liste) >= 3 and self.liste[0].nom == self.liste[2].nom and self.liste[2].penalite == False:
			print("Sandwich ! On peut taper !")
			joueur.Joueur.AUTORISATION_TAPER = True
		if len(self.liste) >= 2 and self.liste[1].nom == "Valet" and self.liste[1].penalite == False and self.liste[0].is_tete == False:
			print("Celui qui a mis le Valet peut prendre !")
			joueur.Joueur.AUTORISATION_PRENDRE = joueur.Joueur.AUTORISATION_JOUER -1
			joueur.Joueur.AUTORISATION_JOUER = 0
		if len(self.liste) >= 3 and self.liste[2].nom == "Dame" and self.liste[2].penalite == False and self.liste[1].is_tete == False and self.liste[0].is_tete == False:
			print("Celui qui a mis la Dame peut prendre !")
			joueur.Joueur.AUTORISATION_PRENDRE = joueur.Joueur.AUTORISATION_JOUER -1
			joueur.Joueur.AUTORISATION_JOUER = 0
		if len(self.liste) >= 4 and self.liste[3].nom == "Roi" and self.liste[3].penalite == False and self.liste[2].is_tete == False and self.liste[1].is_tete == False and self.liste[0].is_tete == False:
			print("Celui qui a mis le Roi peut prendre !")
			joueur.Joueur.AUTORISATION_PRENDRE = joueur.Joueur.AUTORISATION_JOUER -1
			joueur.Joueur.AUTORISATION_JOUER = 0
		if len(self.liste) >= 5 and self.liste[4].nom == "As" and self.liste[4].penalite == False and self.liste[3].is_tete == False and self.liste[2].is_tete == False and self.liste[1].is_tete == False and self.liste[0].is_tete == False:
			print("Celui qui a mis l'As peut prendre !")
			joueur.Joueur.AUTORISATION_PRENDRE = joueur.Joueur.AUTORISATION_JOUER -1
			joueur.Joueur.AUTORISATION_JOUER = 0





