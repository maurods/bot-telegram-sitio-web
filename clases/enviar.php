<?php

define('apitelegram', 'apitelegram');

class enviar{
   
    public function texto($chatId, $response, $keyboard = NULL){

        if (isset($keyboard)) {
            $teclado = '&reply_markup={"keyboard":['.$keyboard.'], "resize_keyboard":false, "one_time_keyboard":true}';  
            
            $url = $GLOBALS[apitelegram].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response).$teclado;
            file_get_contents($url);  
        }else{
            
            $url = $GLOBALS[apitelegram].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
            file_get_contents($url);  
        }
    }


    public function imagen($chatId, $imagen, $keyboard = NULL){
    
            if (isset($keyboard)) {
                $teclado = '&reply_markup={"keyboard":['.$keyboard.'], "resize_keyboard":false, "one_time_keyboard":true}';  
                
                $url = $GLOBALS[apitelegram].'/sendPhoto?chat_id='.$chatId.'&parse_mode=HTML&photo='.urlencode($imagen).$teclado;
                file_get_contents($url);  
            }else{
                
                $url = $GLOBALS[apitelegram].'/sendPhoto?chat_id='.$chatId.'&parse_mode=HTML&photo='.urlencode($imagen);
                file_get_contents($url);  
            }
    }


    public function eliminarmensaje($chatId, $msjid){

        $url = $GLOBALS[apitelegram].'/deleteMessage?chat_id='.$chatId.'&message_id='.$msjid;
        file_get_contents($url);  
     
    }
    
    function numero($chatId, $response){

        $keyboard = '["7", "8", "9"],["4", "5", "6"],["1", "2", "3"],["SALIR"]';
        $teclado = '&reply_markup={"keyboard":['.$keyboard.'], "resize_keyboard":false, "one_time_keyboard":true}';  
            
        $url = $GLOBALS[apitelegram].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&number='.urlencode($response).$teclado;
        file_get_contents($url);  
         
    }
    
    
    /*
    function sendQR($chatId, $texto){

        $qrCode = new QrCode($texto);//Creo una nueva instancia de la clase
        $qrCode->setSize(450);//Establece el tamaño del qr
        //header('Content-Type: '.$qrCode->getContentType());
        $image= $qrCode->writeString();//Salida en formato de texto 
         
        $imageData = base64_encode($image);//Codifico la imagen usando base64_encode
    
        $imagen = file_put_contents('image.jpg', $imageData);
    
        
    
        $url = $GLOBALS[website].'/sendPhoto?chat_id='.$chatId.'&parse_mode=HTML&photo='.urlencode($imagen);
        file_get_contents($url); 
    
    
    }
    */



}





?>