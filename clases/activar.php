<?php
require_once __DIR__ . '/variables.php';  
require_once __DIR__ . '/datos.php';  
require_once __DIR__ . '/enviar.php';  
require_once __DIR__ . '/teclados.php'; 
require_once __DIR__ . '/iconos.php'; 


    //Instancias
    $variable = new variables($update);
    $dato = new datos();
    $teclado = new teclados();
    $enviar = new enviar();
    $icono = new iconos();

    //Si el usuario existe y el hash de activacion ingresado por el usuario es igual al de la bd
    $resultado = $dato->consultar('SELECT empresa.idempresa, usuarios.idusuario, usuarios.estado , idactivacionbot FROM usuarios, empresa where empresa.idempresa = usuarios.idempresa and idactivacionbot = "'.$variable->comando().'";');
     
   //si encuentra, guarda el chatid y userid del usuario en la bd, para luego ser validado el ingreso
   if (mysqli_num_rows($resultado) > 0) {
        
    while($row = mysqli_fetch_assoc($resultado)) {
            $idempresa = $row["idempresa"];
            $idusuario = $row["idusuario"];
    }

    //activa la cuenta
     $date = date("YmdHis"); 
     $hash = hash("sha256", $date);

     $dato->guardar('UPDATE usuarios, empresa SET usuarios.useridbot= "'.$variable->usuarioid().'", idactivacionbot = "'.$hash.'" where usuarios.idempresa = empresa.idempresa and empresa.idempresa = "'.$idempresa.'" and usuarios.idusuario = "'.$idusuario.'" ;');
     $enviar->texto($variable->usuarioid(), "Cuenta verificada, consulte la guia de ayuda si desea una introducción de uso.", $teclado->principal());


    }else{

        //Este hash tiene una longitud de 64 caracteres
        if(!strlen($variable->comando()) == 64){
            $enviar->texto($variable->usuarioid(), "El hash no es invalido, pruebe nuevamente con el correcto.");
        }else{

            switch ($variable->comando()) {

                case '/start':
                    
                    $enviar->texto($variable->usuarioid(), "Le damos la bienvenida desde DOMINIO", $teclado->perfilnoregistrado());

                break;

                case 'REGISTRAR':
                    
                    $enviar->texto($variable->usuarioid(), $icono->aviso()."Debe de ingresar al siguiente enlace para crear el registro de su empresa.");
                    $enviar->texto($variable->usuarioid(), "www.DOMINIO/registro.php", $teclado->perfilnoregistrado());

                break;

                case 'RESTABLECER':
                    
                    $enviar->texto($variable->usuarioid(), $icono->escribir()."Ingrese su correo electrónico que utilizo para el registro de su empresa");

                break;

                default:

                if (filter_var($variable->comando(), FILTER_VALIDATE_EMAIL)){
                
                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Ingrese a su casilla de correo para reestablecer el ingreso desde alli");
            
                    $resultado = $dato->consultar('SELECT email FROM usuarios where email="'.$variable->comando().'";');
         
                    if (mysqli_num_rows($resultado) > 0) {

                        //activa la cuenta
                        $date = date("YmdHis"); 
                        $hash = hash("sha256", $date);

                        $dato->guardar('UPDATE usuarios SET idactivacionbot="'.$hash.'" where email="'.$variable->comando().'";');
                    
                        $subject = 'Reestablecer ingreso - DOMINIO';
                        $headers = 'From:noreply@DOMINIO'."\r\n";
                        $mensaje = 'Reestablecer ingreso

                        Ingrese al siguiente link para reestablecer el ingreso. 
                        https://DOMINIO//validacion.php?hash='.$hash;

                        mail($variable->comando(),$subject,$mensaje,$headers);
            
                    }

                }else{

                    $enviar->texto($variable->usuarioid(), "Para poder utilizar el bot, anteriormente debe estar registrado");
                    $enviar->texto($variable->usuarioid(), "https://DOMINIO/registro.php", $teclado->perfilnoregistrado());
 
                }
    
               
                break;

            }
                

           
      
        }

        

    }


?>