#include <dht.h> // for humidity and temperature

dht DHT;
int photocellPin = 0;
int encoderPin = 1;
int photocellReading;
int chk;

#define DHT11_PIN 7

void setup() {
  Serial.begin( 9600 );
}

void loop() {
  chk = DHT.read11( DHT11_PIN );
  Serial.print( analogRead( photocellPin ) ); // light intesity
  Serial.print( " " );
  Serial.print( analogRead( encoderPin ) ); // ground humidity
  Serial.print( " " );
  Serial.print( DHT.humidity ); // air humidity
  Serial.print( " " );
  Serial.println( DHT.temperature ); // temperature
  delay(500);
}

