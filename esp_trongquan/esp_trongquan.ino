/* Project : Home Automation
 * Author  : Vu Van Duc 
 * Contact : ducduc08@gmail.com 
 * 
 * esp_trongquan.php
 */
#include <ESP8266WiFi.h>

/* Wifi Router to connect */
const char* ssid="Vnpt tap hoa Hoan huong";
const char* password="hoanhuong";
const char* host = "ducduc.000webhostapp.com";
String entry_id;

int const led_pin = 2;

void setup() {
  pinMode(led_pin, OUTPUT);
  digitalWrite(led_pin, LOW);
  Serial.begin(115200); Serial.println();  Serial.print("Connecting to ");  Serial.println(ssid);
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);

  while(WiFi.status()!= WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println();
  Serial.print("Station IP address: "); Serial.println(WiFi.localIP());
  digitalWrite(led_pin, HIGH);
}

String line = "";
String url_uri = String("/esp8266/state.php");
String sub = "";

void loop()
{
  digitalWrite(led_pin, LOW);
  WiFiClientSecure client;
  if (client.connect(host, 443)) {
    client.print(String("GET ") + url_uri + " HTTP/1.1\r\n" +
                 "Host: " + host + "\r\n" +
                 "Connection: close\r\n" +
                 "\r\n"
                );

    //Serial.println("[Response:]");
    while (client.connected()) {
      if (client.available())
      {
        line += client.readStringUntil('\n');
      }
    }
    sub = line.substring(line.indexOf("{\""), line.indexOf("\"}")+2);
    if(sub.length() > 0 )
    {
      Serial.println(sub);
    }
    else
    {
      Serial.print("no json return!!");
      Serial.println(" -->[Disconnected]");
    }

    sub = "";
    line = "";
    client.stop();
  }
  else {
    Serial.println("[connection failed!]");
    client.stop();
  }
  digitalWrite(led_pin, HIGH);
  delay(10000);
}









/* End program */
