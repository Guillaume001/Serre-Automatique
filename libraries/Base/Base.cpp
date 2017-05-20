#include "Arduino.h"
#include "Base.h"

float Base::getVoltage(int pin) //Renvoie le voltage d'un pin
{
	int valeur_analog = analogRead(pin); //Récupère la valeur analogique entre 0 et 1023
	float voltage = (float(valeur_analog)*5)/1023; //On ramène 1023 à 5V
	return voltage;
}

float Base::getAnglePoto(int pin) //Renvoie un angle entre 0 et 180° suivant la tension
{
	float voltage = getVoltage(pin); //Récupère le voltage du pin
	float angle = (voltage*180)/5; //On ramène 5V à 180°
	return angle;
}

float Base::arrondiCinq(float var) //Renvoie la valeur arrondi à 0.5 près
{
	float val_dec = (var - (int)var); //On recupère la partie décimale du nombre

	if(val_dec >= 0.25 && val_dec <= 0.74) //Si celui ci est compris entre 0.25 et 0.74
	{
		return (int)var + 0.5; //Alors on rajoute 0.5 à la partie entière et on renvoie la valeur
	}
	else {
		return ((int)var + (val_dec > 0.5)); //Sinon si la val_dec est sup à 0.5 on fait +1 sinon +0
	}
}

float Base::arrondiUnite(float nombre) //Renvoie la valeur arrondi à l'unité
{
	if(nombre - (int)nombre >= 0.5) //On recupère la partie décimale du nombre et si sup à 0.5
	{
		return (int)nombre++; //Alors on rajoute 0.5 à la partie entière et on renvoie le résultat
	} else {
		return (int)nombre; //Sinon on laisse la partie entière tel quel et on renvoie le résultat
	}
}