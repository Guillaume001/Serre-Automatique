/*

Base.h
Utiliser pour des fonctions de bases

*/

// Permet de s'assurer que cette description de bibliothèque est inclus qu'une seule fois
#ifndef Base_h
#define Base_h

#include "Arduino.h"

class Base
{
public:
	float getVoltage(int pin); //Renvoie la tension d'un pin
	float getAnglePoto(int pin); //Renvoie un angle entre 0 et 180
	float arrondiCinq(float var); //Arrondi à 0.5 près un float
	float arrondiUnite(float nombre); //Arrondi à l'unité un float
};

#endif
