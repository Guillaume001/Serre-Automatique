#include "Arduino.h"
#include "LCD.h" //Besoin de l'LCD
#include "Servo.h" //Fonctions servo

#include "Actions.h"

LCD lcd_action; //On déclare l'écran LCD
Servo trappe; //On déclare le servo moteur de la trappe

#define pinEau A0

#define servo 30
#define pinVentilo 40
#define pinLampTemp 41
#define pinLampLum 42
#define pinVanne 5
//LED RGB
#define pinLedR 44
#define pinLedG 45
#define pinLedB 46

unsigned long dernier_temp;
unsigned long dernier_lum;
unsigned long dernier_hum;

void Actions::begin(){ //Procédure d'initialisation
	
	trappe.attach(servo); //Initialise le servo moteur
	
	//Déclare les pins des actionneurs comme des sorties
	pinMode(pinEau, INPUT);
	pinMode(pinVentilo, OUTPUT);
	pinMode(pinLampTemp, OUTPUT);
	pinMode(pinLampLum, OUTPUT);
	pinMode(pinVanne, OUTPUT);
	pinMode(pinLedR, OUTPUT);
	pinMode(pinLedG, OUTPUT);
	pinMode(pinLedB, OUTPUT);
	
	//Remet à zéro avec reset
	reset();
	dernier_temp = 0;
	dernier_lum = 0;
	dernier_hum = 0;
}

void Actions::reset(){ //Procédure de remise à zéro
	//Met LOW sur tous les actionneurs
	digitalWrite(pinVentilo, HIGH);
	digitalWrite(pinLampTemp, HIGH);
	digitalWrite(pinLampLum, HIGH);
	digitalWrite(pinVanne, LOW);
	trappe.write(0); //Fermeture trappe
}

void Actions::envoie(bool temp_etat, bool temp_check, bool lum_check, bool hum_check, bool eau, float temp_ext){ //Procédure de temporisation
	if(temp_ext < 40.00){ //Si la température extérieure est inférieure à 40°C
		if(millis() - dernier_temp > 30000){ //Toutes les 30 secondes
			dernier_temp = millis();
			/////TEMPERATURE/////
			if(temp_check == false){ //Si temp mauvaise...
				if(temp_etat == true){ //Si temp trop faible...
					digitalWrite(pinLampTemp, LOW); //On allume la lampe
					digitalWrite(pinVentilo, HIGH); //On éteint le ventilo
					trappe.write(0); //Fermeture trappe
				} else { //Sinon temp chaude...
					digitalWrite(pinLampTemp, HIGH); //On éteint la lampe
					digitalWrite(pinVentilo, LOW); //On allume le ventilo
					trappe.write(45); //Ouverture trappe
				}
			} else { //Sinon si la temp est bonne...
				digitalWrite(pinLampTemp, HIGH); //On éteint la lampe
				digitalWrite(pinVentilo, HIGH); //On éteint le ventilo
			}
		}
		
		if(millis() - dernier_lum > 1800000){ //Toutes les 30 minutes
			dernier_lum = millis();
			/////LUMINOSITE/////
			if(lum_check == false){ //Si la lum est mauvaise...
				digitalWrite(pinLampLum, LOW); //On allume la lampe
			} else { //Sinon si la lum est bonne...
				digitalWrite(pinLampLum, HIGH); //On éteint la lampe
			}
		}
		
	} else { //Sinon on se met en sécurité donc...
		digitalWrite(pinLampLum, HIGH); //On éteint la lampe de LUM
		digitalWrite(pinLampTemp, HIGH); //On éteint la lampe de TEMP
		digitalWrite(pinVentilo, LOW); //On allume le ventilo
		trappe.write(45); //Ouverture trappe
	}
	
	
	if(millis() - dernier_hum > 30000){ //Toutes les 30 secondes
		dernier_hum = millis();
		/////HUMIDITE/////
		if(eau == 1){ //S'il y a de l'eau alors...
			if(hum_check == false){ //Si la hum est mauvaise...
				digitalWrite(pinVanne, HIGH); //On ouvre la vanne
			} else { //Sinon si la hum est bonne...
				digitalWrite(pinVanne, LOW); //On ferme la vanne
			}
		} else { //Sinon pas d'eau alors...
			digitalWrite(pinVanne, LOW); //On ferme la vanne
		}
	}
}

void Actions::led(int color){ //Procédure LED RGB
	switch(color){
	case 1: //ROUGE
		digitalWrite(pinLedR, HIGH);
		digitalWrite(pinLedG, LOW);
		digitalWrite(pinLedB, LOW);
		break;
	case 2: //VERT
		digitalWrite(pinLedR, LOW);
		digitalWrite(pinLedG, HIGH);
		digitalWrite(pinLedB, LOW);
		break;
	}
}

bool Actions::CheckEau(){ //Vérifie s'il y a de l'eau dans la reserve
	
	if(analogRead(A0) > 5){ //S'il y a un contact dans l'eau alors...
		return true; //Renvoie vrai
	} else {
		return false; //Sinon non
	}
	
}