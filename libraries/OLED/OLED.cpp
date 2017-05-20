#include "Arduino.h"
#include "OLED.h"
#include <SeeedGrayOLED.h> //Ecran OLED
#include "DS1307.h" //RTC

DS1307 clock_oled; //Déclaration de l'objet clock_oled

void OLED::ajout_zero(unsigned char var) //Renvoie un "0" sur l'écran OLED
{
	if (var < 10) { //Si la valeur est plus petite strictement que 10 alors...
		SeeedGrayOled.putString("0"); //Affiche un 0 sur l'écran LCD
	}
}

void OLED::affHeure(unsigned char heure, unsigned char minute, unsigned char second) //Affiche l'heure en x et y
{
	SeeedGrayOled.setTextXY(10, 2); //Se place suivant les paramètres x et y de la procédure
	ajout_zero(heure); //On ajout un 0 si la valeur est plus petite que 10 pour garder un nombre à 2 chiffres
	SeeedGrayOled.putNumber(heure); //Affiche l'heure
	SeeedGrayOled.putString(":"); //Espace des heures
	ajout_zero(minute); //On ajout un 0 si la valeur est plus petite que 10 pour garder un nombre à 2 chiffres
	SeeedGrayOled.putNumber(minute); //Affiche les minutes
	SeeedGrayOled.putString(":"); //Espace des heures
	ajout_zero(second); //On ajout un 0 si la valeur est plus petite que 10 pour garder un nombre à 2 chiffres
	SeeedGrayOled.putNumber(second); //Affiche les secondes
	SeeedGrayOled.putString(" "); //Par précaution on place un espace après les secondes
}

void OLED::param(float* data) //Affiche toutes les valeurs des capteurs sur l'écran OLED
{
	//On traite les valeurs du tableau directement dans des variables pour une meilleure visibilitée
	float temp_int = data[0];
	int lum_int = data[1];
	int hum_int = data[2];
	float temp_ext = data[3];
	int hum_ext = data[4];

	SeeedGrayOled.setTextXY(0, 0); //On part d'en haut à gauche
	SeeedGrayOled.putString("CAPTEURS INT");
	SeeedGrayOled.setTextXY(1, 0); //Seconde ligne
	SeeedGrayOled.putString("TEMP : ");
	SeeedGrayOled.putFloat(temp_int);
	SeeedGrayOled.setTextXY(2, 0); //3ème ligne
	SeeedGrayOled.putString("HUM : ");
	ajout_zero(hum_int); //Affiche un 0 si la valeur est inférieur à 10
	SeeedGrayOled.putNumber(hum_int);
	SeeedGrayOled.putString("% ");
	
	
	SeeedGrayOled.setTextXY(4, 0); //5ème ligne
	SeeedGrayOled.putString("CAPTEURS EXT");
	SeeedGrayOled.setTextXY(5, 0); //6ème ligne
	SeeedGrayOled.putString("TEMP : ");
	SeeedGrayOled.putFloat(temp_ext);
	SeeedGrayOled.setTextXY(6, 0); //7ème ligne
	SeeedGrayOled.putString("LUM : ");
	ajout_zero(lum_int); //Affiche un 0 si la valeur est inférieur à 10
	SeeedGrayOled.putNumber(lum_int);
	SeeedGrayOled.putString("% ");
	SeeedGrayOled.setTextXY(7, 0); //8ème ligne
	SeeedGrayOled.putString("HUM : ");
	ajout_zero(hum_ext); //Affiche un 0 si la valeur est inférieur à 10
	SeeedGrayOled.putNumber(hum_ext);
	SeeedGrayOled.putString("% ");
}

void OLED::affichage(float* data) //Affiche la totalité de l'écran OLED
{
	clock_oled.getTime(); //On récupère l'heure de la RAM du module RTC
	int heure = clock_oled.hour; //Renvoie l'heure
	int minute = clock_oled.minute; //Renvoie les minutes
	int second = clock_oled.second; //Renvoie les secondes
	
	affHeure(heure, minute, second); //Affiche l'heure sur l'écran
	param(data); //Affiche toutes les valeurs des capteurs sur l'écran OLED
}

void OLED::efface() //Procédure efface écran
{
	SeeedGrayOled.clearDisplay(); //Clear de l'OLED
}

void OLED::begin() //Procédure d'initialisation
{
	SeeedGrayOled.init(); //Initialisation de l'OLED
	SeeedGrayOled.clearDisplay(); //Petit clear de l'OLED
	SeeedGrayOled.setNormalDisplay(); //On définit l'affichage en normal sur l'OLED
	SeeedGrayOled.setVerticalMode(); //Affichage vertical sur OLED
}