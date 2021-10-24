<?php

require __DIR__ . '/clases/variables.php';  
require __DIR__ . '/clases/enviar.php';  
require __DIR__ . '/clases/token.php';  
require_once __DIR__ . '/clases/iconos.php'; 
require_once __DIR__ . '/clases/datos.php';  
require_once __DIR__ . '/clases/teclados.php';
require_once __DIR__ . '/clases/iconos.php'; 
require_once __DIR__ . '/dbmilo/_funciones.php'; 

$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);

//Instancias
$variable = new variables($update);
$enviar = new enviar();
$icono = new iconos();


if($variable->estadoempresa() == 'activo' || $variable->estadoempresa() == 'inactivo'){
    
    if($variable->estadousuario() == 'activo'){

        require __DIR__ . '/clases/comandos.php';  

    }else{
        $enviar->texto($variable->usuarioid(), "El usuario se encuentra bloqueado");
    }
    
}elseif($variable->estadoempresa() == 'bloqueado'){
    
    $enviar->texto($variable->usuarioid(), "La empresa se encuentra bloqueada");

}else{
    require __DIR__ . '/clases/activar.php';  
 
}





?>