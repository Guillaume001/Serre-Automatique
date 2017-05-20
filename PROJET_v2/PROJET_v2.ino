/*********************************************************************************************************

  Projet ISN BAC 2017
  Nom du projet : Serre Automatique 2.0
  Developpeurs : Paul OLIVA & Guillaume COURS
  Lien du projet : https://github.com/Guillaume001/Serre-Automatique

*********************************************************************************************************/

#include <Wire.h> //Ports I2C
#include "rgb_lcd.h" //Ecran LCD
#include <SHT31.h> //Capteur humidité et température
#include <Base.h> //Appel fonctions de bases
#include <Capteurs_INT.h> //Les capteurs intérieurs
#include <OLED.h> //Affichage OLED
#include <LCD.h> //Affichage LCD
#include <Compare_DATA.h> //Comparer les données
#include <Carte_SD.h> //Carte SD de sauvegarde
#include <Actions.h> //Actions
#include <Sauvegarde.h> //Sauvegarde via port série

//DEBUT "Déclaration des pins"
#define pinBut 2
#define pinSwitch 3
#define pinPoto A1
#define pinLum A2
#define pinHum A3
#define pinTemp A0
//FIN "Déclaration des pins"

#define stateBut digitalRead(pinBut) //Pour des facilités de lecture stateBut est remplacé par la fonction à la compilation
#define stateSwitch digitalRead(pinSwitch) //stateSwitch est remplacé par la fonction qui renvoie l'état du switch

//DEBUT "Déclaration objets"
rgb_lcd lcd; //Déclaration objet LCD
SHT31 capteurs_ext = SHT31(); //On déclare le capteur humidité et température
Base base; //Fonctions de bases
Capteurs_INT capteurs_int; //Fonctions capteurs intérieur
OLED oled; //Fonctions écran OLED
LCD LCD; //Fonctions écran LCD
Compare_DATA compare; //Fonctions de traitements des données
Carte_SD CarteSD; //Fonctions Carte SD
Actions action; //Fonctions qui gère les actions
Sauvegarde sauvegarde; //Fonctions de sauvegarde via raspberryPI
//FIN "Déclaration objets"

//DEBUT "Déclaration des variables statiques"
static bool mode = 0; //MODE 0 : OK - MODE 1 : MODIF
static byte modif = 0; //Variable qui gère les différents menus de modification
static unsigned long dernier_bouton = 0; //Stoke la dernière fois que le bouton a été activé
//FIN "Déclaration des variables statiques"

//DEBUT "Contraintes pour le mode modif"
static float intTempMin = 10.00; //Valeur mise par défaut pour la temp MIN
static float intTempMax = 40.00; //Valeur mise par défaut pour la temp MAX
static int intHumMin = 0; //Valeur mise par défault pour l'humidité
static int intLumMin = 100; //Valeur mise par défault pour la luminosité
//FIN "Contraintes pour le mode modif"

void setup() {

  Serial.begin(19200); //Initialise le port série

  //DEBUT "Déclaration des modes d'E/S"
  pinMode(pinBut, INPUT);
  pinMode(pinPoto, INPUT);
  pinMode(pinLum, INPUT);
  pinMode(pinHum, INPUT);
  pinMode(pinSwitch, INPUT);
  //FIN "Déclaration des modes d'E/S"

  attachInterrupt(digitalPinToInterrupt(pinBut), action_bouton, RISING); //Lorsque la tension du pinBut monte la procédure action_bouton est executée

  Wire.begin(); //On initialise les Wires (I2C)

  LCD.begin(); //Initialisation de l'écran LCD
  oled.begin(); //Initialise l'OLED

  capteurs_ext.begin(); //Initialise le capteur extérieur

  CarteSD.begin(); //Initialise la carte SD

  action.begin(); //Initialise les actions

  //Récupération des contraintes sur la carte SD
  CarteSD.lecture();

}

void loop() {

  float* donnees = recuperation(); //On garde les données dans la variable donnees

  sauvegarde.envoie(donnees); //Vérification de sauvegarde

  affichage(donnees); //Affichage des 2 écrans

}

float* recuperation () { //Récupère l'intrégralité des données nécessaires au traitement des autres fonctions
  float recup[9];
  recup[0] = capteurs_int.getTemperature(pinTemp); //On récup la temp int actuelle
  recup[1] = capteurs_int.getLuminosity(pinLum); //On récup la lumi int actuelle
  recup[2] = capteurs_int.getHumidity(pinHum); //On récup l'humi int actuelle
  recup[3] = capteurs_ext.getTemperature(); //On récup la temp ext actuelle
  recup[4] = capteurs_ext.getHumidity(); //On récup l'humi ext actuelle
  delay(100); //Delai pour ne pas avoir d'erreur lors de la récupération des données capteurms
  recup[5] = CarteSD.tempMin; //On récup la temp min
  recup[6] = CarteSD.tempMax; //On récup la temp max
  recup[7] = CarteSD.humMin; //On récup l'hum min
  recup[8] = CarteSD.lumMin; //On récup la lum min
  delay(100); //Delai pour ne pas avoir d'erreur lors de la récupération des données
  recup[9] = action.CheckEau(); //Vérifie si il y a de l'eau
  delay(100); //Delai pour ne pas avoir d'erreur lors de la récupération des données
  return recup;
}

void action_bouton() { //Executé avec le bouton
  if ((millis() - dernier_bouton > 1000) && stateSwitch == 1) //Condition vrai si l'intervalle de temps est supérieure à 1000ms et si l'interrupteur est sur ON
  {
    dernier_bouton = millis(); //On récupère le temps qui tourne depuis l'execution du programme
    //Instructions
    if (mode == 1 && modif < 4) { //Si on est dans le menu modif et qu'on a pas dépassé 4 alors...
      modif++; //Incrémente le compteur de pages
    } else { //Sinon on retourne à la première page
      modif = 0;
    }
    if (mode == 0 && modif == 0) { //Si on est dans le mode normal et que le menu modif est sur 0 alors...
      mode = 1; //On passe dans le mode modif
      modif = 0; //Première page de modif
    }
  }
}

void affichage(float* donnees) { //Procédure qui appelle toutes les autres suivant des conditions

  switch (mode) {
    case 0:
      action.led(2); //LED VERTE
      compare.affichageParam(donnees); //On appelle la fonction qui affiche et qui vérifie tous les paramètres
      break;
    case 1:
      action.led(1); //LED ROUGE
      affichageModif(modif); //Sinon on part sur la procédure d'affichage pour l'état modif
      break;
  }
  oled.affichage(donnees); //Affichage de l'écran OLED
}

void affichageModif(byte modif) { //Gère l'affichage des pages de modifications

  action.reset(); //Pour des raisons de sécurité avec les actionneurs on les met a zéro pendant le menu modif

  lcd.clear(); //On efface le LCD
  lcd.home(); //On part de 0,0
  lcd.print("Etat : MODIF"); //Affiche la première ligne
  lcd.setRGB(223, 109, 20); //Couleur orange

  lcd.setCursor(0, 1); //Deuxième ligne
  switch (modif) { //Utilisation d'un switch suivant les pages du menu
    case 0: //Page de la température MIN
      lcd.write(1); //Affiche l'icone de la température
      lcd.print(" min : ");
      lcd.setCursor(13, 1);
      lcd.print((char)223); //Affiche le petit degrès
      lcd.print("C ");
      while (1) {
        lcd.setCursor(8, 1);
        intTempMin = base.arrondiCinq(0.17 * base.getAnglePoto(pinPoto) + 10); //On ramène la variable sur 10 à 40
        lcd.print(intTempMin);
        delay(50);
        if (stateBut == 1)break; //On sort de la while
      }
      break;
    case 1: //Page de la température MAX
      lcd.write(1); //Affiche l'icone de la température
      lcd.print(" max : ");
      lcd.setCursor(13, 1);
      lcd.print((char)223); //Affiche le petit degrès
      lcd.print("C ");
      while (1) {
        lcd.setCursor(8, 1);
        intTempMax = base.arrondiCinq(0.17 * base.getAnglePoto(pinPoto) + 10); //On ramène la variable sur 10 à 40
        lcd.print(intTempMax);
        delay(50);
        if (stateBut == 1)break; //On sort de la while
      }
      break;
    case 2: //Page de la luminosité
      lcd.write(2); //Affiche l'icone de la luminosité
      lcd.print(" : ");
      while (1) {
        lcd.setCursor(4, 1);
        intLumMin = map(base.getAnglePoto(pinPoto), 0, 180, 0, 100); //On ramène la variable sur 0 à 100
        lcd.print(intLumMin);
        lcd.print("% ");
        delay(50);
        if (stateBut == 1)break; //On sort de la while
      }
      break;
    case 3: //Page de l'humidité
      lcd.write(3); //Affiche l'icone de l'humidité
      lcd.print(" : ");
      while (1) {
        lcd.setCursor(4, 1);
        intHumMin = map(base.getAnglePoto(pinPoto), 0, 180, 0, 100); //On ramène la variable sur 0 à 100
        lcd.print(intHumMin);
        lcd.print("% ");
        delay(50);
        if (stateBut == 1)break; //On sort de la while
      }
      break;
    case 4: //Page de redirection
      if (intTempMax > intTempMin && intTempMax - intTempMin >= 5.00 ) { //Vérificaion : MAX sup MIN et la différence sup à 5°C
        lcd.print("VALIDATION..."); //Petit message de transition
        //Sauvegarde des contraintes
        CarteSD.tempMin = intTempMin;
        CarteSD.tempMax = intTempMax;
        CarteSD.lumMin = intLumMin;
        CarteSD.humMin = intHumMin;

        CarteSD.save(intTempMin, intTempMax, intLumMin, intHumMin); //Sauvegarde sur la carte SD

        delay(500);
        mode = 0; //On bascule sur le mode normal
        modif = 0; //Remise à zéro du compteur modif
      } else {
        lcd.print("ERREUR PARAM");
        mode = 1; //Reste sur le menu modif
        modif = 0; //Retour à la première page de modif
      }
      break;
    default: //Si le modif n'est pas compris entre 1 et 4 alors...
      lcd.print("ERREUR 404");
      mode = 0; //On renvoie sur l'affichage normal
      modif = 0; //On remet l'indice à la page 1
      break;
  }
}

/*********************************************************************************************************
  FIN FICHIER
*********************************************************************************************************/
