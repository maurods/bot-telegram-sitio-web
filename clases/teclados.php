<?php
 
    class teclados{
        
        function principal(){
            $principal = '["PERFIL"],["TITULO"],["DESCRIPCION"],["REDES"],["PARRAFOS"],["IMAGENES"],["UBICACION"],["CLAVES"],["SALIR"]';
         return $principal;
        }
        
        function perfilactivo(){
            $perfilactivo = '["VER"],["DESACTIVAR"],["RESTABLECER"],["SALIR"]';
         return $perfilactivo;
        }
        function perfilinactivo(){
            $perfilinactivo = '["VER"],["ACTIVAR"],["RESTABLECER"],["SALIR"]';
         return $perfilinactivo;
        }

        function perfilnoregistrado(){
            $perfilinactivo = '["REGISTRAR"],["RESTABLECER"]';
         return $perfilinactivo;
        }
        
        function parrafos(){
            $parrafos = '["PRIMERO"],["SEGUNDO"],["TERCERO"],["CUARTO"],["QUINTO"],["SEXTO"],["SEPTIMO"],["OCTAVO"],["SALIR"]';
         return $parrafos;
        }
        function imagenes(){
            $imagenes = '["PORTADA"],["PRINCIPAL"],["IZQUIERDA"],["DERECHA"],["SALIR"]';
         return $imagenes;
        }
        function redesociales(){
            $redesociales = '["WHATSAPP"],["INSTAGRAM"],["FACEBOOK"],["TWITTER"],["SALIR"]';
         return $redesociales;
        }
        function claves(){
            $claves = '["LISTAR"],["AGREGAR"],["ELIMINAR"],["SALIR"]';
         return $claves;
        }
        function publicidad(){
            $publicidad = '["VISTAS"],["CREAR"],["BORRAR"],["SALIR"]';
         return $publicidad;
        }
        function publicidadcrear(){
            $publicidadcrear = '["TIEMPO"],["IMAGEN"],["DEPARTAMENTO"],["REGISTRAR"],["SALIR"]';
         return $publicidadcrear;
        }
        function publicidadeliminar(){
            $publicidadeliminar = '["ELIMINAR-PUBLICIDAD"],["SALIR"]';
         return $publicidadeliminar;
        }
        function publicidadcreardias(){
            $publicidadcreardias = '["7"],["14"],["30"],["365"],["SALIR"]';
         return $publicidadcreardias;
        }
        

    }

    
    
    
     
    
    
    
    
    
    




?>