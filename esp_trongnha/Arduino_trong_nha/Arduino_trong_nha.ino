
int const esp_pin[9] = {-1, 4, 5, 6, 7, 8, 9, 10, 11};

String data = "";
int temp = 0;
String state = "";

int const led_pin = 13;

void setup() {
  pinMode(led_pin, OUTPUT);
  digitalWrite(led_pin, HIGH);
  for(int i = 1; i <= 8; i++)
  {
    pinMode(esp_pin[i], OUTPUT);
    digitalWrite(esp_pin[i], HIGH);
  }
  Serial.begin(115200);
  Serial.println("Board Arduino Uno R3 support for ESP8266 v01");
  digitalWrite(led_pin, LOW);

  /*
  String test = "asdfsdf{012001}sadfasdf";
  int temp = test.lastIndexOf("{");
  if(temp >= 0)
  {
    state = test.substring(temp+1, temp+2);
    Serial.println(state);
    state = test.substring(temp+2, temp+3);
    Serial.println(state);
  }
  else
  {
    Serial.println("Not found!");
  }
  */
}

void set_state(int id, String state)
{
  if(state == "1")
  {
      digitalWrite(esp_pin[id], LOW);
      Serial.println(String("role: ") + id + " on");
  }
  else if (state == "0")
  {
      digitalWrite(esp_pin[id], HIGH);
      Serial.println(String("role: ") + id + " off");
  }
  else
  {
    Serial.println(state);
    Serial.println("Not understand state!");
  }
}

void loop() {
  while (Serial.available()) {
    digitalWrite(led_pin, HIGH);
    data = Serial.readStringUntil('\n');
    Serial.println("[Response: " + data + "]");

    if(data.indexOf("{") < 0)
    {
      break ;
    }

    
    temp = data.indexOf("role1");
    if(temp >= 0)
    {
      set_state(1, data.substring(temp+8, temp+9));
    }
    else
    {
      Serial.println("Not found role 1!");
    }

    temp = data.indexOf("role2");
    if(temp >= 0)
    {
      set_state(2, data.substring(temp+8, temp+9));
    }
    else
    {
      Serial.println("Not found role 2!");
    }

    temp = data.indexOf("role3");
    if(temp >= 0)
    {
      set_state(3, data.substring(temp+8, temp+9));
    }
    else
    {
      Serial.println("Not found role 3!");
    }

    temp = data.indexOf("role4");
    if(temp >= 0)
    {
      set_state(4, data.substring(temp+8, temp+9));
    }
    else
    {
      Serial.println("Not found role 4!");
    }

    temp = data.indexOf("role5");
    if(temp >= 0)
    {
      set_state(5, data.substring(temp+8, temp+9));
    }
    else
    {
      Serial.println("Not found role 5!");
    }

    temp = data.indexOf("role");
    if(temp >= 0)
    {
      set_state(6, data.substring(temp+8, temp+9));
    }
    else
    {
      Serial.println("Not found role 6!");
    }

    temp = data.indexOf("role7");
    if(temp >= 0)
    {
      set_state(7, data.substring(temp+8, temp+9));
    }
    else
    {
      Serial.println("Not found role 7!");
    }

    temp = data.indexOf("role8");
    if(temp >= 0)
    {
      set_state(8, data.substring(temp+8, temp+9));
    }
    else
    {
      Serial.println("Not found role 8!");
    }

    data = "";
    digitalWrite(led_pin, LOW);
  }
}
