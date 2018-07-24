class RoLe{
  private:
  char const NUM = 5;
  char const PIN[5] = {-1, 5, 4, 14, 12};
  
	public:
  char STATE[5] = {0, 0, 0, 0, 0};
  void begin()
  {
    for(int i = 1; i < 5; i++)
    {
      pinMode(PIN[i], OUTPUT);
      digitalWrite(PIN[i], 1);
    }
  }

  void setstate(int role, int state)
  {
    STATE[role] = state;
    digitalWrite(PIN[role], !STATE[role]);
    //Serial.print("[setstate: "); Serial.print(role);
    //Serial.print(" to ");        
    Serial.println(state);
    //Serial.println("]"); 
  }

  String getstate(int role_id)
  {
    String returnstr = "1";
    if(STATE[role_id] == 1) 
    {
      return returnstr;
    }
    else
    {
      returnstr = "0";
      return returnstr;
    }
  }
  
  void stringsetstate(String strstate) 
  {
    if(strstate.length() == 4)
    {
      for(int i = 1; i < 5; i++) 
      {
        STATE[i] = strstate.substring((i-1), i).toInt();
        digitalWrite(PIN[i], !STATE[i]);
      }
    }
  }

};
