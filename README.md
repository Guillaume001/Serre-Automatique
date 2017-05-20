# Serre Automatique 2.0

<p align="center">
Projet ISN pour l'épreuve du BAC 2017<br>
<img height="400px" src="https://github.com/Guillaume001/Serre-Automatique/blob/master/Dossier/Serre%20v1.png">
</p>

## Objectifs

- Allumer automatiquement la lumière dans la serre lorsque la nuit tombe.
- Ouvrir la trappe de ventilation lorsque la température passe au-dessus d’un certain seuil et allumer la led rouge.
- L’action sur le poussoir « visite de la serre » est prioritaire. Elle doit arrêter l’arrosage, ouvrir la trappe, allumer le voyant vert, ceci pendant 10 min. Ensuite le programme retrouve son fonctionnement normal.

 [En savoir plus sur les objectifs](https://github.com/Guillaume001/Serre-Automatique/wiki/Objectifs-en-d%C3%A9tails)

## Composants

- Arduino UNO et MEGA
- Ecran LCD (I2C)
- Ecran OLED (I2C)
- Hub I2C (I2C)
- 2 Relais (Analogique)
- Bouton poussoir (Analogique)
- Bouton toucher (Analogique) (NON UTILISE)
- Potensiomètre (Analogique)
- Horloge RTC (Batterie CR1225) (I2C)
- Antenne RFID + Badges (Analogique) (PROBLEME AVEC LOOP)
- Servomoteur (Analogique)
- LED (Analogique)
- Buzzer (Analogique)
- Carte Shield
- Carte adaptateur SD
- Convertisseur I2C vers Analogique (I2C->Analogique)
- Capteur de température (Analogique)
- Capteur de luminosité (Analogique)
- Capteur d'humidité (Analogique)
- Capteur de température et humidité (I2C)

## Documentation

Pour en savoir plus consulter notre wiki dans la barre de navigation en haut.

## Developpeurs
- Paul OLIVA
- Guillaume COURS
