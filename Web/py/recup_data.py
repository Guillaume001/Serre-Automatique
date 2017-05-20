#!/usr/bin/env python
# -*- coding: UTF-8 -*-

import serial  # bibliothèque permettant la communication série
import time    # pour le délai d'attente entre les messages
import MySQLdb

ser = serial.Serial('/dev/ttyACM0', 19200, timeout=2)

ser.write('0')

intTemp = ser.readline()
intLum = ser.readline()
intHum = ser.readline()
extTemp = ser.readline()
extHum = ser.readline()

intTempMin = ser.readline()
intTempMax = ser.readline()
intHumMin = ser.readline()
intLumMin = ser.readline()
eau = ser.readline()

heure = time.time()

# Open database connection
db = MySQLdb.connect("localhost","arduino","hps69g9TR4dVyKbf","arduino" )

# prepare a cursor object using cursor() method
cursor = db.cursor()

# Prepare SQL query to INSERT a record into the database.
add_data = "INSERT INTO live (heure, int_temp, int_hum, int_lum, ext_temp, ext_hum, param_temp_min, param_temp_max, param_hum, param_lum, eau) VALUES (%s, %s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s)" % (heure, intTemp, intHum, intLum, extTemp, extHum, intTempMin, intTempMax, intHumMin, intLumMin, eau)

try:
  # Execute the SQL command
  cursor.execute("TRUNCATE TABLE live;")
  cursor.execute(add_data)
  # Commit your changes in the database
  db.commit()
  
except:
  # Rollback in case there is any error
  db.rollback()
  # disconnect from server
  db.close()