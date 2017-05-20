/*

Compare_DATA.h
Utiliser pour des fonctions de bases

*/

// Permet de s'assurer que cette description de bibliothèque est inclus qu'une seule fois
#ifndef Compare_DATA_h
#define Compare_DATA_h

#include "Arduino.h"

class Compare_DATA
{
private:
	bool temp_check; //FALSE : temp pas bonne / TRUE : temp bonne
	bool lum_check; //FALSE : lum pas bonne / TRUE : lum bonne
	bool hum_check; //FALSE : hum pas bonne / TRUE : hum bonne
	
	void reset(); //Remise à zéro des variables locales
	void check(float* data_check); //Vérfie les paramètres
public:
	void affichageParam(float* data); //Affiche les paramètres sur l'écran LCD
};

#endif
