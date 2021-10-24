<?php

class traduccion{

    function traducir($texto, $idioma){
 
        //$ingles_a_español = "en-es";
        //$español_a_ingles = "es-en";
        //$ingles_a_portugues = "en-pt";

        //$resultado = traducir($texto, $idioma);
        //$update = json_decode($resultado, TRUE);
        //$traduccion = $update["translations"][0]["translation"];
        //$palabras = $update["word_count"];  
        //$caracteres = $update["character_count"];
        //echo($caracteres);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.us-south.language-translator.watson.cloud.ibm.com/instances/b36b9b8c-2eda-4684-9f06-660dde99e2d7/v3/translate?version=2018-05-01');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"text\": \" $texto \", \"model_id\":\"$idioma\"}");
        curl_setopt($ch, CURLOPT_USERPWD, 'apikey' . ':' . 'KEY GENERADA EN IBM');
    
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            
        }else{
           
            return $result;
    
        }
    
        curl_close($ch);
    
    }
    
    


}




?>
