<?php 

function conectarDB() : mysqli {
    $db = mysqli_connect('localhost', 'root', 'admin', 'ezequiel', 3306);

    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    }

    return $db;

}