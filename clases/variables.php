<?php

define('tokentelegram', 'tokentelegram');
require_once __DIR__ . '/datos.php';  

//Instancias
$dato = new datos();

class variables{

    private $updateid, $comandoanterior, $messageId, $userId, $message, $latitud, $longitud, $widthimg, $heightimg, 
              $file_id_imgsmall, $file_id_imgmedium, $file_id_imgbig, $directorio, $nombrempresa,
              $estadoempresa, $hashinactividad, $empresaid, $idusuariobd, $estadousuario, $todoeljson;  

    function __construct($update){

        if(isset($update)){
            $this->updateid = $update["update_id"];
        }
        if(isset($update["message"]['message_id'])){
            $this->messageId = $update["message"]['message_id'];
        }
        if(isset($update["message"]['from']['id'])){
            $this->userId = $update["message"]['from']['id'];
        }
        if(isset($update["message"]["text"])){
            $this->message = $update["message"]["text"];
        }
        if(isset($update["message"]["location"]['latitude'])){
            $this->latitud = $update["message"]["location"]['latitude'];
        }
        if(isset($update["message"]["location"]['longitude'])){
            $this->longitud = $update["message"]["location"]['longitude'];
        }
        if(isset($update['message']['photo'][0]["width"])){
            $this->widthimg = $update['message']['photo'][0]["width"];
        }
        if(isset($update['message']['photo'][0]["height"])){
            $this->heightimg = $update['message']['photo'][0]["height"];
        }
        if(isset($update['message']['photo'][0]["file_id"])){
            $this->file_id_imgsmall = $update['message']['photo'][0]["file_id"];
        }
        if(isset($update['message']['photo'][1]["file_id"])){
            $this->file_id_imgmedium = $update['message']['photo'][1]["file_id"];
        }
        if(isset($update['message']['photo'][2]["file_id"])){
            $this->file_id_imgbig = $update['message']['photo'][2]["file_id"];
        }

      

        //Instancias
        $dato = new datos();
        
        //si la empresa existe y no esta bloqueada
        $resultado = $dato->consultar('SELECT usuarios.idusuario, useridbot, email, empresa.idempresa, empresa.directorio, empresa.nombre, empresa.estado as estadoempresa, usuarios.estado as estadousuario, hashinactividad FROM usuarios, empresa where empresa.idempresa = usuarios.idempresa and useridbot = "'.$this->userId.'";');
            
        //si encuentra datos del usuario y empresa
        if (mysqli_num_rows($resultado) > 0) {

            while($row = mysqli_fetch_assoc($resultado)) {
                $this->directorio = $row["directorio"];
                $this->nombrempresa = $row["nombre"];
                $this->estadoempresa = $row["estadoempresa"];
                $this->hashinactividad = $row["hashinactividad"];
                $this->empresaid = $row["idempresa"];
                $this->idusuariobd = $row["idusuario"];
                $this->estadousuario = $row["estadousuario"];
                $this->email = $row["email"];
                
            }

        }


        
    }

    function updateid(){
        return $this->updateid;
    }

    function usuarioemail(){
        return $this->email;
    }

    function mensajeid(){
       return $this->messageId;
    }

    function usuarioid(){
        return $this->userId;
    }
    
    function mensaje(){
        //quita caracteres no validos del mensaje
        $this->message = str_replace("'=", '', $this->message);
        $this->message = str_replace("<script", '', $this->message);
        $this->message = str_replace("<Script", '', $this->message);
        $this->message = str_replace("</script>", '', $this->message);
        return $this->message;
    }

    function latitud(){
        return $this->latitud;
    }

    function longitud(){
        return $this->longitud;
    }

    function anchoimagen(){
        return $this->widthimg;
    }

    function alturaimagen(){
        return $this->heightimg;
    }

    function todoeljson(){
        return $this->todoeljson;
    }


    //----------------CALCULOS DE VARIABLES-------------------

    function comando(){
        //Extraemos el Comando
        $arr = explode(' ',trim($this->message));
        $command = $arr[0];
        return $command;
    }

    function imagenchica(){
        $link_img_small = "https://api.telegram.org/bot".$GLOBALS[tokentelegram]."/getFile?file_id=".$this->file_id_imgsmall;
        $data_img_telegram_small = file_get_contents($link_img_small);
        $data_img_telegram_small_json = json_decode($data_img_telegram_small, TRUE);
        $file_path_small = $data_img_telegram_small_json["result"]["file_path"];
        return $file_path_small;
    }

    function imagenmediana(){
        $link_img_smedium = "https://api.telegram.org/bot".$GLOBALS[tokentelegram]."/getFile?file_id=".$this->file_id_imgmedium;
        $data_img_telegram_medium = file_get_contents($link_img_smedium);
        $data_img_telegram_medium_json = json_decode($data_img_telegram_medium, TRUE);
        $file_path_medium = $data_img_telegram_medium_json["result"]["file_path"];
        return $file_path_medium; 
    }

    function imagengrande(){
        $link_img_big = "https://api.telegram.org/bot".$GLOBALS[tokentelegram]."/getFile?file_id=".$this->file_id_imgbig;
        $data_img_telegram_big = file_get_contents($link_img_big);
        $data_img_telegram_big_json = json_decode($data_img_telegram_big, TRUE);
        $file_path_big = $data_img_telegram_big_json["result"]["file_path"];
        return $file_path_big; 
    }




    //--------------------VARIABLES INTERNAS-----------------------------------

    function directorio(){
        return $this->directorio;
    }
    function nombrempresa(){
        return $this->nombrempresa;
    }
    function estadoempresa(){
        return $this->estadoempresa;
    }
    function hashinactividad(){
        return $this->hashinactividad;
    }
    function empresaid(){
        return $this->empresaid;
    }
    function idusuariobd(){
        return $this->idusuariobd;
    }
    function estadousuario(){
        return $this->estadousuario;
    }



     


}





?>