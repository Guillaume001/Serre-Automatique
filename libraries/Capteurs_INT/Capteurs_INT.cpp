#include "Arduino.h"
#include "Capteurs_INT.h"
#include "Base.h" //On a besoin de la base

Base base_capteurs_int; //Déclaraton de l'objet base_capteurs_int

byte Capteurs_INT::getTemperature(int pinTemp) //Renvoie la température à 0.5 près
{
	float voltage = base_capteurs_int.getVoltage(pinTemp); //Vaut la tension du capteur
	byte temperature = base_capteurs_int.arrondiCinq(-21.25+0.9642*voltage+25.53*pow(voltage,2)-11.07*pow(voltage,3)+1.413*pow(voltage,4)+2.5); //Opération trouvé via des expériences avec un thermomètre de référence
	return temperature; //Renvoie la température
}

byte Capteurs_INT::getLuminosity(int pinLum) //Renvoie le taux de lumière à l'unité
{
	float voltage = base_capteurs_int.getVoltage(pinLum); //Vaut la tension du capteur
	byte luminosite = base_capteurs_int.arrondiUnite((voltage*100)/4.98); //4.98V est la tension max que renvoie le capteur
	return luminosite; //Renvoie la luminosité
}

byte Capteurs_INT::getHumidity(int pinHum) //Renvoie le taux d'humudité à l'unité
{
	float voltage = base_capteurs_int.getVoltage(pinHum); //Vaut la tension du capteur
	byte humidite = base_capteurs_int.arrondiUnite((voltage*100)/3.42); //3.42V est la tension max que renvoie le capteur
	return humidite; //Renvoie l'humidité
}
