#include <MD_MAX72xx.h>

#define HARDWARE_TYPE MD_MAX72XX::DR0CR0RR1_HW
#define NUM_OF_MATRIX 3
#define CLK_PIN   6
#define DATA_PIN  7
#define CS_PIN    5

MD_MAX72XX cartel = MD_MAX72XX(HARDWARE_TYPE, DATA_PIN, CLK_PIN, CS_PIN, NUM_OF_MATRIX);

String mensaje = "";
String proximo_mensaje;

void setup() {
  // inicializar el objeto mx
  cartel.begin();

  // Establecer intencidad a un valor de 5
  cartel.control(MD_MAX72XX::INTENSITY, 10);

  // Desactivar auto-actualizacion
  cartel.control( MD_MAX72XX::UPDATE, false );

  // inicializar puerto Serie a 9600 baudios
  delay(1000);
  Serial.begin(9600);
}

void loop() {
  if (Serial.available() > 0) {
    String stringVal = Serial.readString();     
      
    char charVal[stringVal.length() + 1];                      //initialise character array to store the values
    stringVal.toCharArray(charVal , stringVal.length() + 1);     //passing the value of the string to the character array
   
    mensaje = stringVal + "";
    
    slide_text(30);
  }
}

void slide_text(int ms_delay){
  int col = 0;
  int last_pos;
  bool completo = false;
  
  cartel.clear();

  while(completo == false ){
    last_pos = printText(col, mensaje);
    delay(ms_delay);
    col++;
    if(last_pos > (int)cartel.getColumnCount()){
      completo = true;
    }
  }
}

int printText(int pos, const String text){
  int w;
  
  for(int i = 0; i < text.length(); i++){
    // imprimir letra
    w = cartel.setChar(pos, text[i]);
    
    // la proxima letra empieza donde termina esta
    pos = pos - w; 
    
    // Se deja una columna entre letras.
    cartel.setColumn(pos, B00000000);
    
    pos = pos - 1;
    
    if( pos < 0 ){
      break; 
    }
  }
  
  cartel.update();
  return pos;
}
