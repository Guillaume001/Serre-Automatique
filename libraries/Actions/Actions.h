/*
	
Actions.h
Réaliser les actions suivant les capteurs

*/

// Permet de s'assurer que cette description de bibliothèque est inclus qu'une seule fois
#ifndef Actions_h
#define Actions_h

#include "Arduino.h"

class Actions
{
public:
	void begin(); //Initialise les pins
	void envoie(bool temp_etat, bool temp_check, bool lum_check, bool hum_check, bool eau, float temp_ext); //Procédure de temporisation
	void led(int color); //Procédure LED RGB
	void reset(); //Remet les valeurs par default
	bool CheckEau(); //Renvoie s'il y a le l'eau dans la réserve
};

#endif
