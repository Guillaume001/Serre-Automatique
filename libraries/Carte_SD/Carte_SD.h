/*

Carte_SD.h
Utiliser pour des fonctions de bases

*/

// Permet de s'assurer que cette description de bibliothèque est inclus qu'une seule fois
#ifndef Carte_SD_h
#define Carte_SD_h

#include "Arduino.h"

class Carte_SD
{
private:
	void varSave(float tMax, float tMin, int intLum, int intHum); //Procédure de sauvegarde des variables
public:
	void begin(); //Procédure d'initialisation
	
	void save(float temp_min, float temp_max, int lum, int hum); //Procédure de sauvegarde sur la carte SD
	
	void lecture(); //Procédure de lecture
	
	//Variables de contraintes
	float tempMin;
	float tempMax;
	int lumMin;
	int humMin;
};

#endif
