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
$insertar = new insertar();


switch ($variable->comando()) {

    case '/start':
        
        $enviar->texto($variable->usuarioid(), $icono->bienvenida()."Bienvenido otra vez", $teclado->principal());
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";');
      
    break;


    case 'PERFIL':

        if($variable->estadoempresa() == 'activo'){
            $enviar->texto($variable->usuarioid(), $icono->aviso()."Su perfil se encuentra activo actualmente.", $teclado->perfilactivo());
        }elseif($variable->estadoempresa() == 'inactivo'){
            $enviar->texto($variable->usuarioid(), $icono->aviso()."Luego de editar el perfil a su gusto, lo debe de activar para que sea visible por los usuarios.", $teclado->perfilinactivo());
        }
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";');
     
    break;


    case 'VER':

        if($variable->estadoempresa() == 'activo'){
            $enviar->texto($variable->usuarioid(), $icono->url()."http://DOMINIO/empresa/".$variable->directorio(), $teclado->perfilactivo());
        }
        if($variable->estadoempresa() == 'inactivo'){
            $enviar->texto($variable->usuarioid(), $icono->url()."http://DOMINIO/empresa/".$variable->directorio()."&hashinactividad=".$variable->hashinactividad(), $teclado->perfilinactivo());
        }
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";');
     
    break;

    case 'ACTIVAR':

        if($variable->estadoempresa() == 'inactivo'){
            $dato->guardar('UPDATE empresa SET estado="activo" where idempresa='.$variable->empresaid().';');
            $enviar->texto($variable->usuarioid(), $icono->correcto()."El perfil quedo activado", $teclado->perfilactivo());
        }
       
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";');
      

    break;

    case 'DESACTIVAR':

        if($variable->estadoempresa() == 'activo'){
            $dato->guardar('UPDATE empresa SET estado="inactivo" where idempresa='.$variable->empresaid().';');
            $enviar->texto($variable->usuarioid(), $icono->correcto()."El perfil quedo inactivo momentaneamente", $teclado->perfilinactivo());
        }
       
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";');
      
    break;

    case 'RESTABLECER':
        
        //activa la cuenta
        $date = date("YmdHis"); 
        $hash = hash("sha256", $date);

        $dato->guardar('UPDATE usuarios SET idactivacionbot="'.$hash.'" where useridbot="'.$variable->usuarioid().'";');
      
        $subject = 'Reestablecer ingreso - DOMINIO';
        $headers = 'From:noreply@DOMINIO'."\r\n";
        $mensaje = 'Reestablecer ingreso para : '.$variable->nombrempresa().'

        Ingrese al siguiente link para reestablecer el ingreso. 
        http://DOMINIO/validacion.php?empresa='.$variable->directorio().'&hash='.$hash;

        mail($variable->usuarioemail(),$subject,$mensaje,$headers);
        
        $enviar->texto($variable->usuarioid(), $icono->correcto()."Ingrese a su casilla de correo para continuar. Recuerda que solamente se puede tener una cuenta de Telegram para editar el perfil", $teclado->principal());
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";');
      
    break;


    case 'TITULO':

        $enviar->texto($variable->usuarioid(), $icono->escribir()."Ingrese nuevo título");
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

    break;

    case 'DESCRIPCION':

        $enviar->texto($variable->usuarioid(), $icono->escribir()."Redacte la decripción de la empresa");
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

    break;

    case 'REDES':

        $enviar->texto($variable->usuarioid(), $icono->elegir()."Elija una red social para agregar", $teclado->redesociales());
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

    break;

    case 'WHATSAPP':
           
        $enviar->texto($variable->usuarioid(), $icono->numeros()."Ingrese número. Si no desea incluirlo en el sitio digite No");
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";');  

    break;

    case 'INSTAGRAM':

        $enviar->texto($variable->usuarioid(), $icono->escribir()."Ingrese el nombre de usuario de Instagram. Si no desea incluirlo en el sitio digite: No");
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

    break;

    case 'FACEBOOK':

        $enviar->texto($variable->usuarioid(), $icono->escribir()."Ingrese el nombre de usuario de Facebook. Si no desea incluirlo en el sitio digite: No");
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";');  

    break;

    case 'TWITTER':
  
        $enviar->texto($variable->usuarioid(), $icono->escribir()."Ingrese el nombre de usuario de Twitter. Si no desea incluirlo en el sitio digite: No");
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

    break;

    case 'PARRAFOS':

        $enviar->texto($variable->usuarioid(), $icono->escribir()."Elija que párrafo desea editar", $teclado->parrafos());
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

    break;

    case 'PRIMERO':
    case 'SEGUNDO':
    case 'TERCERO':
    case 'CUARTO':
    case 'QUINTO':
    case 'SEXTO':
    case 'SEPTIMO':
    case 'OCTAVO':

        $enviar->texto($variable->usuarioid(), $icono->escribir()."Redacte el párrafo para ser modificado. Si no desea agregar este párrafo, digite No");
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

    break;

    case 'IMAGENES':
        
        $enviar->texto($variable->usuarioid(), $icono->elegir()."Seleccione la imagen que desea cambiar", $teclado->imagenes());
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

    break;

    case 'PORTADA':

        $enviar->texto($variable->usuarioid(), $icono->buscar()."Inserte imagen");
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

    break;  
    
    case 'PRINCIPAL':

        $enviar->texto($variable->usuarioid(), $icono->buscar()."Inserte imagen");
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";');  

    break;   

    case 'IZQUIERDA':

        $enviar->texto($variable->usuarioid(), $icono->buscar()."Inserte imagen");
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

    break;   
    
    case 'DERECHA':

        $enviar->texto($variable->usuarioid(), $icono->buscar()."Inserte imagen");
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";');  
        
    break;   

    case 'UBICACION':

        $enviar->texto($variable->usuarioid(), $icono->ubicacion().$icono->clip()."Ingrese la ubicación desde la herramienta de Telegram. Si no desea agregar una dirección digite: No ".$icono->ubicacion().$icono->clip());
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

    break;  

    case 'CLAVES':

        $enviar->texto($variable->usuarioid(), $icono->aviso()."Las palabras clave ayuda a los usuarios a encontrar más rápido productos o servicios que venden las empresas. Las palabras clave deberian de ser lo mas exactas en relacion a lo que su empresa vende", $teclado->claves());
         //Inserta el comando en dbmilo
         $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

    break;  
    
    case 'LISTAR':

        $resultado = $dato->consultar('SELECT claves.nombre FROM claves, empresa, usuarios where claves.idempresa = empresa.idempresa and empresa.idempresa = usuarios.idempresa and usuarios.useridbot = "'.$variable->usuarioid().'" and claves.estado = "activo";');
                     
        if (mysqli_num_rows($resultado) > 0) {

            $claves = null;

            while($row = mysqli_fetch_assoc($resultado)) {
                $claves = $claves.$row["nombre"]." ; ";
                
            }
            
            $enviar->texto($variable->usuarioid(), $icono->aviso()."Actualmente las claves registradas son:". PHP_EOL .$claves, $teclado->claves());

        }else{

            $enviar->texto($variable->usuarioid(), $icono->aviso()."No se a registrado ninguna clave aún. Elija la opción AGREGAR", $teclado->claves());

        }

        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

    break; 

    case 'AGREGAR':

        $enviar->texto($variable->usuarioid(), $icono->escribir()."Ingrese una palabra clave o conjunto de palabras. Ejemplos: cortes de pelo, reparacion de celulares, lentes de sol, mecánico de motos, bizcochos, perfumes, etc");
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

    break; 

    case 'ELIMINAR':

        $enviar->texto($variable->usuarioid(), $icono->escribir()."Ingrese una palabra clave o conjunto de palabras que desea eliminar");
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

    break; 

    case 'SALIR':

        $enviar->texto($variable->usuarioid(), $icono->inicio()."Se encuentra en el menu principal", $teclado->principal());
        //Inserta el comando en dbmilo
        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

    break;

    default:
    
        require __DIR__ . '/acciones.php';  

    break;


}






?>