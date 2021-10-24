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
    $mostrar = new mostrar();
    $insertar = new insertar();

  
    $resultado = $dato->consultar('SELECT ultimocomando FROM usuarios where useridbot = "'.$variable->usuarioid().'";');         
    if (mysqli_num_rows($resultado) > 0) {
        while($row = mysqli_fetch_assoc($resultado)) { 
            $ultimocomando = $row["ultimocomando"];
        }                          
    }
    mysqli_free_result($result);


    //EJECUTA ACCIONES
    switch ($ultimocomando) {


        case 'TITULO':

            
            $resultado = $dato->guardar('UPDATE empresa, usuarios SET titulo="'.$variable->mensaje().'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');  

            //Confirma si inserto correctamente
            if($resultado == "OK"){
   
                $enviar->texto($variable->usuarioid(), $icono->correcto()."Quedo editado el título", $teclado->principal());
                //Inserta el comando en dbmilo
                $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

            }else{

                $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar el título, pruebe nuevamente", $teclado->principal());

            }
      
        break;

        case 'DESCRIPCION':

            $resultado = $dato->guardar('UPDATE empresa, usuarios, traduccion SET texto="'.$variable->mensaje().'" WHERE empresa.idempresa = traduccion.idempresa AND  empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');
        
            //Confirma si inserto correctamente
            if($resultado == "OK"){

                $enviar->texto($variable->usuarioid(), $icono->correcto()."Se edito la descripción", $teclado->principal());
                //Inserta el comando en dbmilo
                $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 
    
            }else{

                $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar la descripción, pruebe nuevamente", $teclado->principal());

            }

        break;  

        case 'WHATSAPP':
                  
            if($variable->comando() == 'no' || $variable->comando() == 'No'){
            
                $resultado = $dato->guardar('UPDATE empresa, usuarios SET linkwhatsapp="" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');
                
                //Confirma si inserto correctamente
                if($resultado == "OK"){
                    
                    $enviar->texto($variable->usuarioid(), $icono->correcto()."No se agrego Whatsapp al sitio", $teclado->redesociales());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 
    
                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar Whatsapp, pruebe nuevamente", $teclado->redesociales());
                }
                
            }elseif(is_numeric($variable->comando())){

                $resultado = $dato->consultar('SELECT caracteristica from empresa, departamentos, paises, usuarios where empresa.iddepartamento = departamentos.iddepartamento and departamentos.idpais = paises.idpais and empresa.idempresa = usuarios.idempresa and usuarios.useridbot = "'.$variable->usuarioid().'";');
       
                if (mysqli_num_rows($resultado) < 1) {

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar Whatsapp, pruebe nuevamente", $teclado->redesociales());
     
                }else{

                    while($row = mysqli_fetch_assoc($resultado)) {
                        $caracteristica = $row["caracteristica"];
                    }
                    
                    $linkwhatsapp = "https://api.whatsapp.com/send/?phone=".$caracteristica.$variable->comando(); 
                    $resultado = $dato->guardar('UPDATE empresa, usuarios SET linkwhatsapp="'.$linkwhatsapp.'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');
                  
                    //Confirma si inserto correctamente
                    if($resultado == "OK"){
                        
                        $enviar->texto($variable->usuarioid(), $icono->correcto()."Se agrego Whatsapp al sitio", $teclado->redesociales());
                        //Inserta el comando en dbmilo
                        $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

                    }else{

                        $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar Whatsapp, pruebe nuevamente", $teclado->redesociales());

                    }
                }
            }else{
                $enviar->texto($variable->usuarioid(), $icono->error()."Ingrese número. Si no desea incluirlo en el sitio digite No", $teclado->redesociales());

            }
            
            break;  

        case 'INSTAGRAM':
                        
            if($variable->comando() == 'no' || $variable->comando() == 'No'){

                $resultado = $dato->guardar('UPDATE empresa, usuarios SET linkinstagram="" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');
          
                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."No se agrego Instagram al sitio", $teclado->redesociales());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar Instagram, pruebe nuevamente", $teclado->redesociales());
     
                }

            }else{

                $linkinstagram = "https://www.instagram.com/".$variable->comando();
                $resultado = $dato->guardar('UPDATE empresa, usuarios SET linkinstagram="'.$linkinstagram.'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');
      
                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Se agrego Instagram al sitio", $teclado->redesociales());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar Instagram, pruebe nuevamente", $teclado->redesociales());
         
                }

                
            }
                    
        break;  

        case 'FACEBOOK': 
                        
            if($variable->comando() == 'no' || $variable->comando() == 'No'){

                $resultado = $dato->guardar('UPDATE empresa, usuarios SET linkfacebook="" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');

                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."No se agrego Facebook al sitio", $teclado->redesociales());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar Facebook, pruebe nuevamente", $teclado->redesociales());

                }
                                    
            }else{
    
                $linkfacebook = "https://www.facebook.com/".$variable->comando();
                $resultado = $dato->guardar('UPDATE empresa, usuarios SET linkfacebook="'.$linkfacebook.'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');
                        
                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Se agrego Facebook al sitio", $teclado->redesociales());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar Facebook, pruebe nuevamente", $teclado->redesociales());
  
                }
                       
                    
            }
                            
        break; 

        case 'TWITTER':
                        
            if($variable->comando() == 'no' || $variable->comando() == 'No'){

                $resultado = $dato->guardar('UPDATE empresa, usuarios SET linktwitter="" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');
            
                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."No se agrego Twitter al sitio", $teclado->redesociales());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar Twitter, pruebe nuevamente", $teclado->redesociales());
    
                }

            }else{       
        
                $linkfacebook = "https://twitter.com/".$variable->comando();
                $resultado =  $dato->guardar('UPDATE empresa, usuarios SET linktwitter="'.$linkfacebook.'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');

                //Confirma si inserto correctamente
                if ($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Se agrego Twitter al sitio", $teclado->redesociales());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar Twitter, pruebe nuevamente", $teclado->redesociales());
              
                }
                                 
            }
                                    
        break;  
        

        case 'PRIMERO':

            if($variable->mensaje() == 'no' || $variable->mensaje() == 'No'){
            
                $resultado =  $dato->guardar('UPDATE empresa, usuarios SET primerparrafo="" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');
  
                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."No se agregó el primer párrafo", $teclado->parrafos());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar párrafo, pruebe nuevamente", $teclado->parrafos());

                }

            }else{
               
                $resultado = $dato->guardar('UPDATE empresa, usuarios SET primerparrafo="'.$variable->mensaje().'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');

                 //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Se edito el prmier párrafo", $teclado->parrafos());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar párrafo, pruebe nuevamente", $teclado->parrafos());

                }

            }
            
        break;

        case 'SEGUNDO':

            if($variable->mensaje() == 'no' || $variable->mensaje() == 'No'){
            
                $resultado = $dato->guardar('UPDATE empresa, usuarios SET segundoparrafo="" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');
       
                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."No se agregó el segundo párrafo", $teclado->parrafos());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar párrafo, pruebe nuevamente", $teclado->parrafos());

                }

            }else{
        
                $resultado = $dato->guardar('UPDATE empresa, usuarios SET segundoparrafo="'.$variable->mensaje().'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');
      
                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Se edito el segundo párrafo", $teclado->parrafos());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar párrafo, pruebe nuevamente", $teclado->parrafos());

                }
                          
            }
                  
        break; 

        case 'TERCERO':

            if($variable->mensaje() == 'no' || $variable->mensaje() == 'No'){
                
                $resultado = $dato->guardar('UPDATE empresa, usuarios SET tercerparrafo="" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');
        
                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."No se agregó el tercer párrafo", $teclado->parrafos());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 
 
                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar párrafo, pruebe nuevamente", $teclado->parrafos());
        
                }

            }else{

                $resultado = $dato->guardar('UPDATE empresa, usuarios SET tercerparrafo="'.$variable->mensaje().'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');
                   
                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Se edito el tercer párrafo", $teclado->parrafos());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 
 
                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar párrafo, pruebe nuevamente", $teclado->parrafos());
          
                }
         
            }     
                
        break;   

        case 'CUARTO':

            if($variable->mensaje() == 'no' || $variable->mensaje() == 'No'){
                
                $resultado = $dato->guardar('UPDATE empresa, usuarios SET cuartoparrafo="" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');
                
                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."No se agregó el cuarto párrafo", $teclado->parrafos());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 
 
                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar párrafo, pruebe nuevamente", $teclado->parrafos());

                }

            }else{
       
                $resultado = $dato->guardar('UPDATE empresa, usuarios SET cuartoparrafo="'.$variable->mensaje().'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');
    
                //Confirma si inserto correctamente
                if($resultado == "OK"){
                    
                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Se edito el cuarto párrafo", $teclado->parrafos());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 
 
                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar párrafo, pruebe nuevamente", $teclado->parrafos());
       
                }
                
            }
                 
        break;   


        case 'QUINTO':

            if($variable->mensaje() == 'no' || $variable->mensaje() == 'No'){
                
                $resultado = $dato->guardar('UPDATE empresa, usuarios SET quintoparrafo="" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');

                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."No se agregó el quinto párrafo", $teclado->parrafos());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 
 
                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar párrafo, pruebe nuevamente", $teclado->parrafos());

                }

            }else{
                
                $resultado = $dato->guardar('UPDATE empresa, usuarios SET quintoparrafo="'.$variable->mensaje().'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');

                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Se edito el quinto párrafo", $teclado->parrafos());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 
 
                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar párrafo, pruebe nuevamente", $teclado->parrafos());
    
                }
  
            }
                      
        break;   

        case 'SEXTO':

            if($variable->mensaje() == 'no' || $variable->mensaje() == 'No'){
                
                $resultado = $dato->guardar('UPDATE empresa, usuarios SET sextoparrafo="" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');

                //Confirma si inserto correctamente
                if($resultado == "OK"){
                   
                    $enviar->texto($variable->usuarioid(), $icono->correcto()."No se agregó el quinto párrafo", $teclado->parrafos());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 
 
                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar párrafo, pruebe nuevamente", $teclado->parrafos());
    
                }
                 
            }else{
                
                $resultado = $dato->guardar('UPDATE empresa, usuarios SET sextoparrafo="'.$variable->mensaje().'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');

                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Se edito el sexto párrafo", $teclado->parrafos());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 
 
                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar párrafo, pruebe nuevamente", $teclado->parrafos());
     
                }
           
            }
                  
        break;   
   
        case 'SEPTIMO':

            if($variable->mensaje() == 'no' || $variable->mensaje() == 'No'){
                
                $resultado = $dato->guardar('UPDATE empresa, usuarios SET septimoparrafo="" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');

                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."No se agregó el séptimo párrafo", $teclado->parrafos());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 
 
                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar párrafo, pruebe nuevamente", $teclado->parrafos());

                }
                 

            }else{
        
                $resultado = $dato->guardar('UPDATE empresa, usuarios SET septimoparrafo="'.$variable->mensaje().'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');
                
                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Se edito el septimo párrafo", $teclado->parrafos());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 
 
                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar párrafo, pruebe nuevamente", $teclado->parrafos());

                }
   
            }
                     
        break;  

        case 'OCTAVO':

            if($variable->mensaje() == 'no' || $variable->mensaje() == 'No'){
                
                $resultado = $dato->guardar('UPDATE empresa, usuarios SET octavoparrafo="" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');
       
                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."No se agregó el octavo párrafo", $teclado->parrafos());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 
 
                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar párrafo, pruebe nuevamente", $teclado->parrafos());
                
                }

            }else{

                $resultado = $dato->guardar('UPDATE empresa, usuarios SET octavoparrafo="'.$variable->mensaje().'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');

                //Confirma si inserto correctamente
                if($resultado == "OK"){

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Se edito el octavo párrafo", $teclado->parrafos());
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 
 
                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."No se pudo editar párrafo, pruebe nuevamente", $teclado->parrafos());
     
                }
                     
            }
                
        break;  

        case 'PORTADA':
                     
            if($variable->imagengrande()){

                //Descarga la imagen mediana
                $descarga_imagen_mediana = "https://api.telegram.org/file/bot".$GLOBALS[tokentelegram]."/".$variable->imagengrande();
                
                $directorio = '..DIRECTORIO/public_html/images/'.$variable->directorio().'/images/portada.jpg';
                $directoriocomp = '..DIRECTORIO/public_html/images/'.$variable->directorio().'/images/portadacomp.jpg';

                if(file_put_contents($directorio,file_get_contents($descarga_imagen_mediana))) {
                
                    //Cambia las dimensiones
                    $image = new Imagick($directorio);
                    $image->cropThumbnailImage(630,567);
                    $image->writeImage($directorio);

                    $image = new Imagick($directorio);
                    $image->cropThumbnailImage(330,297);
                    $image->writeImage($directoriocomp);

                   // comprimirimagen($directorio , 630 , 567 , $directorio);
                   //comprimirimagen($directorio , 330 , 297 , $directoriocomp);
                   
                    $fechaactual = date("YmdHis");  
                    copy($directorio, '..DIRECTORIO/public_html/images/'.$variable->directorio().'/portada/'.$fechaactual.'.jpg'); 
    
                    //insertar en sql el link a portada
                    $link = 'images/'.$variable->directorio().'/images/portada.jpg';
                    $dato->guardar('UPDATE empresa, usuarios SET imagenprincipal="'.$link.'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Se edito la imágen de portada", $teclado->imagenes());

                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."La imagen no es lo suficiente grande o tiene el formato incorrecto, intente con otra");

                }
            
            }else{

                $enviar->texto($variable->usuarioid(), $icono->error()."La imagen no es lo suficiente grande o tiene el formato incorrecto, intente con otra");

            }
            
            
        break;   

        case 'PRINCIPAL':
                      
            if($variable->imagengrande()){
              
                //Descarga la imagen mediana
                $descarga_imagen_mediana = "https://api.telegram.org/file/bot".$GLOBALS[tokentelegram]."/".$variable->imagengrande();
            
                $directorio = '..DIRECTORIO/public_html/images/'.$variable->directorio().'/images/principal.jpg';
                $directoriocomp = '..DIRECTORIO/public_html/images/'.$variable->directorio().'/images/principalcomp.jpg';

                if(file_put_contents($directorio,file_get_contents($descarga_imagen_mediana))) {
                    
                    //Cambia las dimensiones
                    $image = new Imagick($directorio);
                    $image->cropThumbnailImage(730 , 467);
                    $image->writeImage($directorio);

                    $image = new Imagick($directorio);
                    $image->cropThumbnailImage(430 , 397);
                    $image->writeImage($directoriocomp);

                    //comprimirimagen($directorio , 730 , 467 , $directorio);
                    //comprimirimagen($directorio , 430 , 397 , $directoriocomp);

                    $fechaactual = date("YmdHis");  
                    copy($directorio, '..DIRECTORIO/public_html/images/'.$variable->directorio().'/principal/'.$fechaactual.'.jpg'); 

                    //insertar en sql el link de imagen principal
                    $link = 'images/'.$variable->directorio().'/images/principal.jpg';
                    $dato->guardar('UPDATE empresa, usuarios SET imagengrande="'.$link.'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Se edito la imágen principal", $teclado->imagenes());


                }else{
        
                $enviar->texto($variable->usuarioid(), $icono->error()."La imagen no es lo suficiente grande o tiene el formato incorrecto, intente con otra");

                }
        
            }else{

                $enviar->texto($variable->usuarioid(), $icono->error()."La imagen no es lo suficiente grande o tiene el formato incorrecto, intente con otra");

            }
                  
        break;  

        case 'IZQUIERDA':
                       
            if($variable->imagengrande()){
              
                //Descarga la imagen chica
                $descarga_imagen_chica = "https://api.telegram.org/file/bot".$GLOBALS[tokentelegram]."/".$variable->imagengrande();
              
                $directorio = '..DIRECTORIO/public_html/images/'.$variable->directorio().'/images/izquierda.jpg';
                $directoriocomp = '..DIRECTORIO/public_html/images/'.$variable->directorio().'/images/izquierdacomp.jpg';

                 if(file_put_contents($directorio,file_get_contents($descarga_imagen_chica))) {
                    
                    //Cambia las dimensiones
                    $image = new Imagick($directorio);
                    $image->cropThumbnailImage(360 , 267);
                    $image->writeImage($directorio);

                    $image = new Imagick($directorio);
                    $image->cropThumbnailImage(170 , 127);
                    $image->writeImage($directoriocomp);

                    //comprimirimagen($directorio , 360 , 267 , $directorio);
                    //comprimirimagen($directorio , 170 , 127 , $directoriocomp);

                    $fechaactual = date("YmdHis");  
                    copy($directorio, '..DIRECTORIO/public_html/images/'.$variable->directorio().'/izquierda/'.$fechaactual.'.jpg'); 
 
                    //insertar en sql el link de imagen izquierda
                    $link = 'images/'.$variable->directorio().'/images/izquierda.jpg';
                    $dato->guardar('UPDATE empresa, usuarios SET imagenizquierda="'.$link.'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Se edito la imágen de la izquierda", $teclado->imagenes());

                }else{

                    $enviar->texto($variable->usuarioid(), $icono->error()."La imagen no es lo suficiente grande o tiene el formato incorrecto, intente con otra");

                }

            }else{

                $enviar->texto($variable->usuarioid(), $icono->error()."La imagen no es lo suficiente grande o tiene el formato incorrecto, intente con otra");

            }
            
        break;   

        case 'DERECHA':
                       
            if($variable->imagengrande()){
          
                //Descarga la imagen chica
                $descarga_imagen_chica = "https://api.telegram.org/file/bot".$GLOBALS[tokentelegram]."/".$variable->imagengrande();
             
                $directorio = '..DIRECTORIO/public_html/images/'.$variable->directorio().'/images/derecha.jpg';
                $directoriocomp = '..DIRECTORIO/public_html/images/'.$variable->directorio().'/images/derechacomp.jpg';

                if(file_put_contents($directorio,file_get_contents($descarga_imagen_chica))) {
                 
                    //Cambia las dimensiones
                    $image = new Imagick($directorio);
                    $image->cropThumbnailImage(360 , 267);
                    $image->writeImage($directorio);

                    $image = new Imagick($directorio);
                    $image->cropThumbnailImage(170 , 127);
                    $image->writeImage($directoriocomp);
                    
                    //comprimirimagen($directorio , 360 , 267 , $directorio);
                    //comprimirimagen($directorio , 170 , 127 , $directoriocomp);

                    $fechaactual = date("YmdHis");  
                    copy($directorio, '..DIRECTORIO/public_html/images/'.$variable->directorio().'/derecha/'.$fechaactual.'.jpg'); 
        
                    //insertar en sql el link de imagen izquierda
                    $link = 'images/'.$variable->directorio().'/images/derecha.jpg';
                    $dato->guardar('UPDATE empresa, usuarios SET imagenderecha="'.$link.'" WHERE empresa.idempresa = usuarios.idempresa AND useridbot="'.$variable->usuarioid().'";');

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Se edito la imágen de la derecha", $teclado->imagenes());

            }else{

                $enviar->texto($variable->usuarioid(), $icono->error()."La imagen no es lo suficiente grande o tiene el formato incorrecto, intente con otra");
        
            }

            }else{

                $enviar->texto($variable->usuarioid(), $icono->error()."La imagen no es lo suficiente grande o tiene el formato incorrecto, intente con otra");
            }

                
        break;  
        
        case 'UBICACION':

            if($variable->comando() == 'no' || ($variable->comando() == 'No')){

                //elimina la latitud
                $dato->guardar('UPDATE usuarios, empresa SET latitud="" WHERE usuarios.idempresa = empresa.idempresa AND useridbot ="'.$variable->usuarioid().'";');

                //elimina la longitud
                $dato->guardar('UPDATE usuarios, empresa SET longitud="" WHERE usuarios.idempresa = empresa.idempresa AND useridbot ="'.$variable->usuarioid().'";');

                $enviar->texto($variable->usuarioid(), $icono->correcto()."No se edito la ubicación", $teclado->principal());
 
                //Inserta el comando en dbmilo
                $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

            }else{

                //GUARDAR EN BD                     
                if($variable->longitud()){
                        
                    //inserta la latitud
                    $dato->guardar('UPDATE usuarios, empresa SET latitud="'.$variable->latitud().'" WHERE usuarios.idempresa = empresa.idempresa AND useridbot ="'.$variable->usuarioid().'";');
                    //inserta la longitud
                    $dato->guardar('UPDATE usuarios, empresa SET longitud="'.$variable->longitud().'" WHERE usuarios.idempresa = empresa.idempresa AND useridbot ="'.$variable->usuarioid().'";');

                    $enviar->texto($variable->usuarioid(), $icono->correcto()."Se edito la ubicación", $teclado->principal());
 
                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

                }else{

                    //Inserta el comando en dbmilo
                    $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 
                    $enviar->texto($variable->usuarioid(), $icono->error()."No se encontró dirección, pruebe nuevamente", $teclado->principal());
                
                }
              
            }

        break;

        case 'AGREGAR':
          
            $dato->guardar('INSERT INTO `claves` (`idempresa`, `nombre`, `estado`) VALUES ("'.$variable->empresaid().'", "'.$variable->mensaje().'", "activo");');

            $enviar->texto($variable->usuarioid(), $icono->correcto()."Quedo agregada la palabra clave", $teclado->claves());
 
            //Inserta el comando en dbmilo
            $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

        break; 

        case 'ELIMINAR':

            $resultado = $dato->consultar('SELECT claves.idclave FROM claves, empresa, usuarios where claves.idempresa = empresa.idempresa and empresa.idempresa = usuarios.idempresa and usuarios.useridbot = "'.$variable->usuarioid().'" and claves.nombre = "'.$variable->mensaje().'";');
            if (mysqli_num_rows($resultado) > 0) {
              
                while($row = mysqli_fetch_assoc($resultado)) {
                    $idclave = $row["idclave"];        
                }
              
                $dato->guardar('UPDATE claves SET estado="eliminada" where idclave="'.$idclave.'";');
              
                $enviar->texto($variable->usuarioid(), $icono->correcto()."Se elimino correctamente la clave", $teclado->claves());
          
                //Inserta el comando en dbmilo
                $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 
       
            }else{

                $enviar->texto($variable->usuarioid(), $icono->correcto()."No se encontró registrada esa clave en el sistema, intente nuevamente", $teclado->claves());

            }
            
        break; 

        default:
    
            $enviar->texto($variable->usuarioid(), $icono->inicio()."Se encuentra en el menu principal", $teclado->principal());
            //Inserta el comando en dbmilo
            $dato->guardar('UPDATE usuarios SET ultimocomando="'.$variable->comando().'" where useridbot="'.$variable->usuarioid().'";'); 

        break;

    
    }

?>