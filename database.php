<?php 

function conectarDB() : mysqli {
<<<<<<< HEAD
    $db = mysqli_connect('localhost', 'root', 'admin', 'ezequiel_daw', 3306);
=======
    $db = mysqli_connect('localhost', 'root', 'admin', 'ezequiel', 3306);
>>>>>>> 262c51cc07c90cd32fc79fb0f30140dbba9d5b96

    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    }

    return $db;

}