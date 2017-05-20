#include "Arduino.h"
#include "Compare_DATA.h"

#include "Actions.h" //Procédure d'actions
#include "rgb_lcd.h" //Ecran compare_lcd

rgb_lcd compare_lcd; //On déclare l'objet écran compare_lcd
Actions action_compare; //On déclare l'objet action_compare

void Compare_DATA::reset(){ //Remet les paramètres à zéro
	lum_check = false; //FALSE : lum pas bonne / TRUE : lum bonne
	hum_check = false; //FALSE : hum pas bonne / TRUE : hum bonne
	temp_check = false; //FALSE : temp pas bonne / TRUE : temp bonne
}

void Compare_DATA::check(float* data_check){
	
	reset(); //Remise des valeurs locales à zéro
	
	//Valeurs actuelles des capteurs
	float actu_temp = data_check[0];
	byte actu_lum = data_check[1];
	byte actu_hum = data_check[2];
	
	//Paramètres de références
	float temp_min = data_check[5];
	float temp_max = data_check[6];
	byte hum_min = data_check[7];
	byte lum_min = data_check[8];
	
	bool eau = data_check[9];
	
	
	////TEMPERATURE////
	bool temp_etat = 0; //Variable pour savoir si la temp est faible ou forte ou bonne
	if (actu_temp <= temp_max && actu_temp >= temp_min) { //Regarde si la temp est comprise entre le min et le max
		temp_check = true; //Vaut 1 si la temp est bonne
	}
	
	if(actu_temp >= temp_max ){
		temp_etat = false;
	}
	
	if(actu_temp <= temp_min){
		temp_etat = true;
	}
	
	////LUMINOSITE////
	if (actu_lum >= lum_min) {
		lum_check = true; //Vaut 1 si la lumi est bonne
	}

	////HUMIDITE////
	if (actu_hum >= hum_min) {
		hum_check = true; //Vaut 1 si l'humi est bonne
	}
	
	float temp_ext = data_check[3]; //Pour sécuriser si la temp ext est trop haute on ne chauffe pas et on n'allume pas la lumimère
	
	//Appel des actions
	action_compare.envoie(temp_etat, temp_check, lum_check, hum_check, eau, temp_ext);
	
}


void Compare_DATA::affichageParam(float* data) { //Gère l'affichage lorsque l'état est incorrect

	check(data); //Appel pour vérifier les paramètres
	
	byte somme_check = temp_check + lum_check + hum_check; //Somme qui permet de déduire si tout les param sont bons ou non

	if (somme_check < 3) { //Vérifie si les 3 param sont bons
		//Instructions quand les param sont mauvais
		compare_lcd.setRGB(255, 0, 0); //Couleur rouge
		compare_lcd.clear(); //Efface écran
		compare_lcd.home(); //Haut à gauche en 0,0
		compare_lcd.print("Etat : INCORRECT"); //Affiche la première ligne
	} else {
		//Instructions quand les param sont bons
		compare_lcd.setRGB(0, 255, 0); //Couleur vert
		compare_lcd.clear(); //Efface écran
		compare_lcd.home(); //Haut à gauche en 0,0
		compare_lcd.print("Etat : CORRECT"); //Affiche la première ligne
	}

	//Passage à la deuxième ligne

	////TEMPERATURE////
	compare_lcd.setCursor(0, 1); //Gauche de l'écran
	compare_lcd.write(1); //Icône temp
	compare_lcd.print(":");
	if (temp_check == true) { //Si la temp est bonne alors...
		compare_lcd.print("OK"); //Affiche OK
	} else {
		compare_lcd.print("KO"); //Sinon on affiche KO
	}

	////LUMINOSITE////
	compare_lcd.setCursor(6, 1); //Centre de l'écran
	compare_lcd.write(2); //Icône lum
	compare_lcd.print(":");
	if (lum_check == true) { //Si la lum est bonne alors...
		compare_lcd.print("OK"); //Affiche OK
	} else {
		compare_lcd.print("KO"); //Sinon on affiche KO
	}

	////HUMIDITE////
	compare_lcd.setCursor(12, 1); //Droite de l'écran
	compare_lcd.write(3); //Icône hum
	compare_lcd.print(":");
	if (hum_check == true) { //Si la hum est bonne alors...
		compare_lcd.print("OK"); //Affiche OK
	} else {
		compare_lcd.print("KO"); //Sinon on affiche KO
	}
}
