#include "Arduino.h"
#include "Carte_SD.h"
#include <SPI.h> //Interface Série pour périphériques (Carte SD)
#include <SD.h> //Fonctions carte SD


//Variables publiques par défauts
float tempMin = 10.00;
float tempMax = 40.00;
int lumMin = 100;
int humMin = 0;

void Carte_SD::begin() { //Procédure d'initialisation de la carte SD
	
	SD.begin(4);
	
}


void Carte_SD::save(float temp_min, float temp_max, int lum, int hum) { //Gère l'envoie d'information sur la carte SD

	//Récupère l'intégralité des données de la serre
	String tempMin = String(temp_min);
	String tempMax = String(temp_max);
	String Lum = String(lum);
	String Hum = String(hum);
	
	//Assemblage de la ligne avec les paramètres à exporter
	String espace = ";"; //Plus simple pour l'assemblage des valeurs
	
	String chaine = tempMin + espace + tempMax + espace + Lum + espace + Hum;
	
	SD.remove("data.txt"); //Supprime le fichier existant
	
	File param = SD.open("data.txt", FILE_WRITE); //On ouvre le fichier en écriture dans param
	
	
	if (param) { //Si le fichier est disponible
		
		param.print(chaine); //On inscrit la chaine

		param.close(); //On ferme le fichier
		
	}
}

void Carte_SD::lecture() { //Procédure de lecture des contraintes

	String resultat; //Variable de sortie
	
	File param = SD.open("data.txt", FILE_WRITE); //On ouvre le fichier en écriture dans param
	
	if (param) { //Si le fichier est disponible
		
		for (int i = 0; i < param.size(); i++ ) { //Boucle qui récupère chaque caractères un par un

			param.seek(i); //Se positionne à la position i
			resultat = resultat + String(char(param.peek())); //Construction de la chaine de sortie

		}
		
		param.close(); //Ferme le fichier

	}
	
	char* text = resultat.c_str(); //Convertion du String en char* (tableau derrière le pointeur)
	
	text = strtok(text, ";"); //On récupère le premier bout de l'occurrence
	
	byte compteur = 0; //Variable qui compte pour l'indice du tabelau de chaine
	String chaine[4]; //Variable de sortie
	
	chaine[compteur] = String(text); //On stoke le premier paramètre dans la chaine[0]
	
	while (text != NULL) { //Tant que le text n'est pas NULL (vide) on continue
		compteur++; //Incrémente le compteur
		text = strtok(NULL, ";"); //On stoke le paramètre dans "text"
		chaine[compteur] = String(text); //On le garde dans chaine[] en String
	}
	
	
	
	float temp_min = chaine[0].toFloat(); //On ramène le String en Float
	float temp_max = chaine[1].toFloat(); //On ramène le String en Float
	int lum = chaine[2].toInt(); //String en Int
	int hum = chaine[3].toInt(); //String en Int
	
	
	//Stokage des valeurs en publique
	varSave(temp_min, temp_max, lum, hum);
}


void Carte_SD::varSave(float tMax, float tMin, int intLum, int intHum){ //Procédure de sauvegarde des variables de contraintes
	//Sauvegarde...
	tempMin = tMax;
	tempMax = tMin;
	lumMin = intLum;
	humMin = intHum;
}