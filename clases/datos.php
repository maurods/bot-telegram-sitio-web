<?php

class datos{
    
    function consultar($sql){
        $mysqli = new mysqli("IP O DOMINIO", "USUARIO", "CONTRASEÑA", "NOMBRE BASE DE DATOS");
        $mysqli->set_charset("utf8");
        if ($mysqli->connect_errno) {
            echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
         }else{
            echo "Conecto a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
         }
     
        $result = mysqli_query($mysqli, $sql);
       
        mysqli_close($mysqli);
        return $result;
    }
    

    function guardar($sql){
        $mysqli = new mysqli("IP O DOMINIO", "USUARIO", "CONTRASEÑA", "NOMBRE BASE DE DATOS");
        $mysqli->set_charset("utf8");
        if ($mysqli->connect_errno) {
           echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
         }
     
       if (mysqli_query($mysqli, $sql)) {
            $result = "OK";
           } else {
            $result = "Error"; 
           }
       
        mysqli_close($mysqli);
        return $result;
    }


}



?>