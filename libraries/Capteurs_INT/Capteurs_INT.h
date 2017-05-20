/*
	
Capteurs_INT.h
Utiliser pour exploiter les capteurs intérieurs.

*/

// Permet de s'assurer que cette description de bibliothèque est inclus qu'une seule fois
#ifndef Capteurs_INT_h
#define Capteurs_INT_h

#include "Arduino.h"

class Capteurs_INT
{
public:
	byte getTemperature(int pinTemp); //Renvoie un float de la température intérieur
	byte getLuminosity(int pinLum); //Renvoie un short de la luminosité interieur
	byte getHumidity(int pinHum); //Renvoie un short de l'humidité
};

#endif
