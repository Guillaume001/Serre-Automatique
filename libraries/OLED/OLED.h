/*

OLED.h
Contient toutes les procédures pour l'affichage de l'écran OLED

*/

// Permet de s'assurer que cette description de bibliothèque est inclus qu'une seule fois
#ifndef OLED_h
#define OLED_h

#include "Arduino.h"

class OLED
{
private:
	void ajout_zero(unsigned char var); //Rajoute un "0" avant les nombres compris entre 0 et 10 pour l'affichage
	void affHeure(unsigned char heure, unsigned char minute, unsigned char second); //Affiche l'heure en x et y
	void param(float* data); //Affiche toutes les valeurs des capteurs sur l'écran OLED
public:
	void affichage(float* data); //Affiche la totalité de l'écran OLED
	void begin(); //Procédure d'initialisation
};

#endif