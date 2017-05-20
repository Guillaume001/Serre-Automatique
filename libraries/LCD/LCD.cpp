#include "Arduino.h"
#include "LCD.h"
#include "rgb_lcd.h" //Ecran LCD

rgb_lcd LCD_lcd; //On déclare l'objet écran LCD

void LCD::begin() //Procédure d'initialisation
{
	
	LCD_lcd.begin(16, 2); //16 colonnes sur 2 lignes
	LCD_lcd.clear(); //On clear l'écran LCD

	byte temp[8] = { //Icone température
		0b00100,
		0b01010,
		0b01010,
		0b01010,
		0b01110,
		0b11111,
		0b11111,
		0b01110
	};

	byte lum[8] = { //Icone luminosité
		0b00000,
		0b10101,
		0b01110,
		0b11011,
		0b01110,
		0b10101,
		0b00000,
		0b00000
	};

	byte hum[8] = { //Icone humidité
		0b00100,
		0b01110,
		0b01110,
		0b11111,
		0b11101,
		0b11111,
		0b11111,
		0b01110
	};
	
	LCD_lcd.createChar(1, temp); //Déclaration de l'icone temp en 1
	LCD_lcd.createChar(2, lum); //Déclaration de l'icone lum en 2
	LCD_lcd.createChar(3, hum); //Déclaration de l'icone hum en 3

}