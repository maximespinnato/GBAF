class Carte:


	def __init__(self, nom, couleur):
		self.nom = nom
		self.couleur = couleur
		self.penalite = False


	@property 
	def is_tete(self):
		if self.nom == "As" or self.nom == "Valet" or self.nom == "Dame" or self.nom == "Roi":
			istete = True
		else : istete = False
		return istete


	def devenir_penalite(self):
		self.penalite = True

	def devenir_normale(self):
		self.penalite = False