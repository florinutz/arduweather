int aoPin = 0;
int reading = 0;

void setup() {
  Serial.begin(9600);
}

void loop() {
  reading  = analogRead(aoPin);
  Serial.println(reading);
  delay(500);
}
