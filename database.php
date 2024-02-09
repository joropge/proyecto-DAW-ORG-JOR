<?php
    function conectarBD()
    {
        //Funcion ue nos conecta a la base de datos, tenemos que mandarle la direccion ip del host, el usuario, la clave y el nombre de la BD
        $cadena_conexion = 'mysql:dbname=ezequiel-daw;host=127.0.0.1';
        $usuario = "root";
        $clave = "admin";
        try {
            //Se crea el objeto de conexion a la base de datos y se devueve
            $bd = new PDO($cadena_conexion, $usuario, $clave);
            return $bd;
        } catch (PDOException $e) {
            echo "Error conectar BD: " . $e->getMessage();
        }
    }