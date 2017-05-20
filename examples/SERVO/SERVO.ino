#include <Servo.h>
#define bouton 2
int etatbout = 0;
int angle = 0;
Servo servo1;


void setup() {
  Serial.begin(9600);
  pinMode(bouton, INPUT);
  servo1.attach(7);
}

void loop() {
  etatbout = digitalRead(bouton);
  Serial.print("EtatBout = ") ;
  Serial.println(etatbout);
  
  Serial.println("Degré = ");
  Serial.print(servo1.read());
  
  if(etatbout == 1){
  servo1.write(angle);
  }
  delay(1000);
}
