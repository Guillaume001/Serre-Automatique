//-------------------------------------------------------------------------------------------------------------
#include <SoftwareSerial.h>
SoftwareSerial RFID(A0, A0); // RX and TX
int data1 = 0;
int ok = -1;
int yes = 6;
int no = 5;
// use first sketch in http://wp.me/p3LK05-3Gk to get your tag numbers
int tag1[14] = {2, 48, 48, 48, 48, 57, 55, 48, 57, 53, 53, 67, 66, 3};
int tag2[14] = {2, 52, 48, 48, 48, 56, 54, 67, 54, 54, 66, 54, 66, 3};
int newtag[14] = { 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0}; // used for read comparisons
void setup()
{
  RFID.begin(9600); // start serial to RFID reader
  Serial.begin(9600); // start serial to PC
  pinMode(yes, OUTPUT); // for status LEDs
  pinMode(no, OUTPUT);
  //attachInterrupt(0,readTags,FALLING);
  //attachInterrupt(1,readTags,FALLING);
}
boolean comparetag(int aa[14], int bb[14])
{
  boolean ff = false;
  int fg = 0;
  for (int cc = 0 ; cc < 14 ; cc++)
  {
    if (aa[cc] == bb[cc])
    {
      fg++;
    }
  }
  if (fg == 14)
  {
    ff = true;
  }
  return ff;
}
void checkmytags() // compares each tag against the tag just read
{
  ok = 0; // this variable helps decision-making,
  // if it is 1 we have a match, zero is a read but no match,
  // -1 is no read attempt made
  if (comparetag(newtag, tag1) == true)
  {
    ok++;
  }
  if (comparetag(newtag, tag2) == true)
  {
    ok++;
  }
}
void readTags()
{
  ok = -1;
  if (RFID.available() > 0)
  {
    // read tag numbers
    delay(100); // needed to allow time for the data to come in from the serial buffer.
    for (int z = 0 ; z < 14 ; z++) // read the rest of the tag
    {
      newtag[z] = RFID.read();
      Serial.print(newtag[z]);
    }
    RFID.flush(); // stops multiple reads
    // do the tags match up?
    checkmytags();
  }
  // now do something based on tag type
  if (ok > 0) // if we had a match
  {
    Serial.println(" : Accepted");
    digitalWrite(yes, HIGH);
    delay(1000);
    digitalWrite(yes, LOW);
    ok = -1;
  }
  else if (ok == 0) // if we didn't have a match
  {
    Serial.println(" : Rejected");
    digitalWrite(no, HIGH);
    delay(1000);
    digitalWrite(no, LOW);
    ok = -1;
  }
}
void loop()
{
  readTags();
}
// ------------------------------------------------------------------------------------
