#include <Wire.h> 
#include <WiFi.h>
#include <LiquidCrystal_I2C.h>
#include <ArduinoHttpClient.h>
#include <WiFiNINA.h>
#include <math.h>

LiquidCrystal_I2C lcd = LiquidCrystal_I2C(0x27, 16, 2);

const char server[] = "als040320sh.hemsida.eu";  // server name
int port = 80;

String str_score;
String auth;

char ssid[] = "visit Alingsas";
char pass[] = "";

int status = WL_IDLE_STATUS;

WiFiClient wifi;
HttpClient client = HttpClient(wifi, server, port);

int button_state;
int reset_state;
int last_button_state;
int last_reset_state;

int record = 60000;

int start = 0;
unsigned long score = 0;

unsigned long current_millis = 0;
unsigned long previous_millis = 0;
int interval = random(5000, 10000);

int button_pin = 3;
int reset_button_pin = 2;

int green_pin = 9;
int blue_pin = 8;
int red_pin = 7;

void setup() {
  Serial.begin(115200);
  pinMode(button_pin, INPUT);
  pinMode(reset_button_pin, INPUT);

  pinMode(blue_pin, OUTPUT);
  pinMode(red_pin, OUTPUT);
  pinMode(green_pin, OUTPUT);

  digitalWrite(green_pin, 255);
  digitalWrite(red_pin, 255);
  digitalWrite(blue_pin, 255);

  randomSeed(analogRead(0));

  current_millis = 0;
  previous_millis = 0;
  
  lcd.init();
  lcd.backlight();
  lcd.clear();  

  Serial.begin(115200);
  while ( status != WL_CONNECTED) {
    Serial.print("Attempting to connect to Network named: ");
    Serial.println(ssid);                   // print the network name (SSID);

    // Connect to WPA/WPA2 network:
    status = WiFi.begin(ssid, pass);
  }

  // print the SSID of the network you're attached to:
  Serial.print("SSID: ");
  Serial.println(WiFi.SSID());

  // print your WiFi shield's IP address:
  IPAddress ip = WiFi.localIP();
  Serial.print("IP Address: ");
  Serial.println(ip);
}

void loop() { 
  button_state = digitalRead(button_pin);
  reset_state = digitalRead(reset_button_pin);

  current_millis = millis();

  if (reset_state != last_reset_state) {  
    if (reset_state == HIGH) {     
      previous_millis = current_millis;

      lcd.clear();
        
      digitalWrite(red_pin, 0);
      digitalWrite(green_pin, 255);
        
      start = 1; 
               
      }
      delay(50);   
          
    }    
  last_reset_state = reset_state;

  if (current_millis - previous_millis >= interval and start == 1) {
    start = 1;
    
    digitalWrite(green_pin, 0);
    digitalWrite(red_pin, 255);
    
    start = 1;
    score = current_millis - previous_millis - interval;             
    }
          
  if (button_state != last_button_state and start == 1) {    
    if (button_state == HIGH) {          
      if (score <= record and score != 0) {
      record = score;
      }
    
    String httpRequestData = "score=";
    
    lcd.home();
    lcd.setCursor(0,0);
    lcd.noBlink();
    lcd.print("Your Time:");
    lcd.setCursor(10, 0);
    lcd.print(score/1, DEC);
    lcd.setCursor(14, 0);
    lcd.print("ms");
    lcd.setCursor(0, 1);
    lcd.print("Best Time:");
    lcd.setCursor(10, 1);
    lcd.print(record/1, DEC);
    lcd.setCursor(14, 1);
    lcd.print("ms");
      
    start = 0;

    if(score != 0){
      str_score = String(score);

      digitalWrite(green_pin, 255); 

      auth = String(pow(score, 2));

      httpRequestData += str_score +"&auth=" + auth + "&leaderboard=16";
      Serial.println("making POST request");
      String contentType = "application/x-www-form-urlencoded";
      String postData = httpRequestData;

      client.post("/toplist/outsideAdd.php", contentType, postData);

      // read the status code and body of the response
      int statusCode = client.responseStatusCode();
      Serial.print("Status code: ");
      Serial.println(statusCode);
      String response = client.responseBody();
      Serial.print("Response: ");
      Serial.println(response);
    }
    
    score = 0;
    str_score = "";
    httpRequestData = "";

    }    
    delay(50);
         
  }    
  last_button_state = button_state;    
  
}