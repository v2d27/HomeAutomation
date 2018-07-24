/* Project : Home Automation
 * Author  : Vu Van Duc 
 * Contact : ducduc08@gmail.com 
 */
#include <ESP8266WiFi.h>
#include <ArduinoJson.h>
#include "class.h"

/* Define server for ESP8266 */
RoLe role;

/* Define JSON object tree*/

/* Wifi Router to connect */
const char* ssid="Vnpt tap hoa Hoan huong";
const char* password="hoanhuong";
const char* host = "ducduc.000webhostapp.com";
String entry_id;
const int led_pin = 2;

void setup() {
  pinMode(led_pin, OUTPUT);
  digitalWrite(led_pin, HIGH);
  Serial.begin(115200); Serial.println();  Serial.print("Connecting to ");  Serial.println(ssid);
  WiFi.begin(ssid,password);
  digitalWrite(led_pin, LOW);
  while(WiFi.status()!= WL_CONNECTED) {
    digitalWrite(led_pin, LOW);
    delay(500);
    Serial.print(".");
    digitalWrite(led_pin, HIGH);
  }
  Serial.println();
  Serial.print("Station IP address: "); Serial.println(WiFi.localIP());
  role.begin();
  digitalWrite(led_pin, HIGH);
}

void loop()
{
  digitalWrite(led_pin, LOW);
  WiFiClientSecure client;
  Serial.printf("\n[%s ... ", host);
  if (client.connect(host, 443))
  {
    Serial.println("connected]");

    //Serial.println("[Sending a request]");
    String url_uri = String("/esp8266/state.php?entry_id=") + entry_id + 
                     "&role1=" + role.getstate(1) +
                     "&role2=" + role.getstate(2) +
                     "&role3=" + role.getstate(3) +
                     "&role4=" + role.getstate(4);    
    client.print(String("GET ") + url_uri + " HTTP/1.1\r\n" +
                 "Host: " + host + "\r\n" +
                 "Connection: close\r\n" +
                 "\r\n"
                );

    Serial.println("[Response:]");
    String line = "";
    //int time_init = millis();
    while (client.connected())
    {
      if (client.available())
      {
        line += client.readStringUntil('\n');
      }
    }
    String sub = line.substring(line.indexOf("{"), line.indexOf("}")+1);
    StaticJsonBuffer<200> jsonBuffer;
    JsonObject& json = jsonBuffer.parseObject(sub);
    if(json.success())
    {
      role.setstate(1, int(json["role1"]));
      role.setstate(2, int(json["role2"]));
      role.setstate(3, int(json["role3"]));
      role.setstate(4, int(json["role4"]));
      entry_id = String((int)json["entry_id"]);
    }
    else
    {
      Serial.println(line);
      Serial.println("  !Convert to JSON failed.");
    }
    //Serial.println(sub);
    
    client.stop();
    Serial.println("-->[Disconnected]");
  }
  else
  {
    Serial.println("connection failed!]");
    client.stop();
  }
  digitalWrite(led_pin, HIGH);
  delay(5000);
}






/* End program */
