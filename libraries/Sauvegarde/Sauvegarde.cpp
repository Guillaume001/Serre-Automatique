#include "Arduino.h"
#include "Sauvegarde.h"
#include "DS1307.h" //Fonctions RTC

DS1307 clock_save; //Déclaration de l'objet clock_save

void Sauvegarde::envoie(float* data){
	if (Serial.available())  {
    int message = Serial.read()-'0';  // on soustrait le caractère 0 qui vaut 48 en ASCII
    switch(message){
      case 0: //Appel de sauvegarde
        Serial.println(data[0]);
		delay(100);
        Serial.println(data[1]);
		delay(100);
        Serial.println(data[2]);
		delay(100);
        Serial.println(data[3]);
		delay(100);
        Serial.println(data[4]);
		delay(100);
		Serial.println(data[5]);
		delay(100);
        Serial.println(data[6]);
		delay(100);
        Serial.println(data[7]);
		delay(100);
        Serial.println(data[8]);
		delay(100);
        Serial.println(data[9]);
      break;
	  case 1: //Remise à l'heure
		clock_save.begin();
		clock_save.fillByYMD(2000,1,1);//01/01/2000
		clock_save.fillByHMS(04,30,00);// remise à 4h30
		clock_save.fillDayOfWeek(SAT);//Saturday (nom du jour)
		clock_save.setTime();//On écrit l'heure dans la RTC
      break;
	  case 2: //Vérification bug
		Serial.println(1); //Renvoie la valeur 1
	  break;
    }
  }
}