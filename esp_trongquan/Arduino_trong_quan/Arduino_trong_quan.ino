
int const esp_pin[9] = {-1, 4, 5, 6, 7, 8, 9, 10, 11};

String data = "";
int temp = 0;
String state = "";

int const led_pin = 13;

void setup() {
  Serial.begin(115200);
  pinMode(led_pin, OUTPUT);
  digitalWrite(led_pin, HIGH);
  
  for(int i = 1; i <= 8; i++)
  {
    pinMode(esp_pin[i], OUTPUT);
    digitalWrite(esp_pin[i], HIGH);
  }
  Serial.println("Board Arduino Uno R3 support for ESP8266 v01");

  /*
  String test = "\"role1\":\"1\",\"sleep\":\"5200\"";
  String result = "";
  int temp = test.indexOf("sleep");
  if(temp > 0)
  {
   temp += 8;
    while(test[temp++] != '"')
    {
      result += test[temp-1];
    }
    Serial.print("Result int: "); Serial.println(result.toInt());
    Serial.println(String("Result: ") + result);
    Serial.println(String("Sleeping in " + result + " miliseconds"));
    int a = millis();
    delay(result.toInt());
    Serial.println(String("Sleeped time: ") + (millis()-a));
  }
  else
  {
    Serial.println("Not found!");
  }
  //Serial.println(test.substring(temp+8, temp+9));

  */

  digitalWrite(led_pin, LOW);
}

void loop() {
  while (Serial.available()) {
    digitalWrite(led_pin, HIGH);
    data = Serial.readStringUntil('\n');
    Serial.println("[Response: " + data + "]");
    temp = data.indexOf("role1");
    if(temp >= 0)
    {
      state = data.substring(temp+8, temp+9);
      Serial.println(state);
      if(state == String("1"))
      {
        digitalWrite(esp_pin[1], LOW);
        Serial.println("role1: on");
      }
      else if (state == String("0"))
      {
        digitalWrite(esp_pin[1], HIGH);
        Serial.println("role1: off");
      }
    }

    temp = data.lastIndexOf("role2");
    if(temp >= 0)
    {
      state = data.substring(temp+8, temp+9);
      if(state == String("1"))
      {
        digitalWrite(esp_pin[2], LOW);
        //Serial.println("role2: on");
      }
      else if (state == String("0"))
      {
        digitalWrite(esp_pin[2], HIGH);
        //Serial.println("role2: off");
      }
    }

    temp = data.lastIndexOf("role3");
    if(temp >= 0)
    {
      state = data.substring(temp+8, temp+9);
      if(state == String("1"))
      {
        digitalWrite(esp_pin[3], LOW);
        //Serial.println("role3: on");
      }
      else if (state == String("0"))
      {
        digitalWrite(esp_pin[3], HIGH);
        //Serial.println("role3: off");
      }
    }

    temp = data.lastIndexOf("role4");
    if(temp >= 0)
    {
      state = data.substring(temp+8, temp+9);
      if(state == String("1"))
      {
        digitalWrite(esp_pin[4], LOW);
        //Serial.println("role4: on");
      }
      else if (state == String("0"))
      {
        digitalWrite(esp_pin[4], HIGH);
        //Serial.println("role4: off");
      }
    }

    temp = data.lastIndexOf("role5");
    if(temp >= 0)
    {
      state = data.substring(temp+8, temp+9);
      if(state == String("1"))
      {
        digitalWrite(esp_pin[5], LOW);
        //Serial.println("role5: on");
      }
      else if (state == String("0"))
      {
        digitalWrite(esp_pin[5], HIGH);
        //Serial.println("role5: off");
      }
    }

    temp = data.lastIndexOf("role6");
    if(temp >= 0)
    {
      state = data.substring(temp+8, temp+9);
      if(state == String("1"))
      {
        digitalWrite(esp_pin[6], LOW);
        //Serial.println("role6: on");
      }
      else if (state == String("0"))
      {
        digitalWrite(esp_pin[6], HIGH);
        //Serial.println("role6: off");
      }
    }

    temp = data.lastIndexOf("role7");
    if(temp >= 0)
    {
      state = data.substring(temp+8, temp+9);
      if(state == String("1"))
      {
        digitalWrite(esp_pin[7], LOW);
        //Serial.println("role7: on");
      }
      else if (state == String("0"))
      {
        digitalWrite(esp_pin[7], HIGH);
        //Serial.println("role7: off");
      }
    }

    temp = data.lastIndexOf("role8");
    if(temp >= 0)
    {
      state = data.substring(temp+8, temp+9);
      if(state == String("1"))
      {
        digitalWrite(esp_pin[8], LOW);
        //Serial.println("role8: on");
      }
      else if (state == String("0"))
      {
        digitalWrite(esp_pin[8], HIGH);
        //Serial.println("role8: off");
      }
    }
    
    data = "";
    digitalWrite(led_pin, LOW);
  }
}

