#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <Wire.h>

const char* ssid     = "GANTI KE NAMA WIFI KALIAN";
const char* password = "GANTI KE PASS WIFI KALIAN";

const char* serverName = "http://172.16.0.118/object_detector/post.php";

String apiKeyValue = "APIKEY";

String sensorName = "HCSR-04";

// HCSR-04 //
unsigned long timer = 0;

const int trigPin = D4;
const int echoPin = D3;

// define sound velocity in cm/uS
#define SOUND_VELOCITY 0.034
#define CM_TO_INCH 0.393701

long duration;
float distanceCm;
float distanceInch;

void setup() {
  Serial.begin(9600);
  
  WiFi.begin(ssid, password);
  Serial.println("Connecting");

  // HCSR //
  pinMode(trigPin, OUTPUT); // Sets the trigPin as an Output
  pinMode(echoPin, INPUT);  // Sets the echoPin as an Input
  
  while(WiFi.status() != WL_CONNECTED) { 
    delay(500);
    Serial.print(". belum");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

}
void loop() {
  //Check WiFi connection status
  if(WiFi.status()== WL_CONNECTED){
    HTTPClient http;
    WiFiClient wifi;
    
    // Your Domain name with URL path or IP address with path
    http.begin(wifi,serverName);
    
    // Specify content-type header
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    //  HCSR  //

    digitalWrite(trigPin, LOW);
    delayMicroseconds(2);

    digitalWrite(trigPin, HIGH);
    delayMicroseconds(10);
    digitalWrite(trigPin, LOW);

    duration = pulseIn(echoPin, HIGH);

    distanceCm = duration * SOUND_VELOCITY / 2;

    distanceInch = distanceCm * CM_TO_INCH;

    Serial.print(distanceCm);

    // Prepare your HTTP POST request data
    String httpRequestData = "api_key=" + apiKeyValue + "&sensor_name=" + sensorName
                          + "&value=" + String(distanceCm);
    Serial.print("httpRequestData: ");
    Serial.println(httpRequestData);
        
    int httpResponseCode = http.POST(httpRequestData);
    
    if (httpResponseCode>0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
    }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }
    
    http.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }
  //Send an HTTP POST request every 15 seconds
  delay(500);  
}

