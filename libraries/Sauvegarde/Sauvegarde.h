/*

Sauvegarde.h
Utiliser pour communiquer avec le RaspberryPi

*/

// Permet de s'assurer que cette description de bibliothèque est inclus qu'une seule fois
#ifndef Sauvegarde_h
#define Sauvegarde_h

#include "Arduino.h"

class Sauvegarde
{
private:

public:
	void envoie(float* data);
	
};

#endif
