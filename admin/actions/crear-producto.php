<?php

// Conectar a la base de datos
require_once '../../database.php';
$db = conectarDB();

// Consultar para obtener categoriaes
$consulta = "SELECT * FROM categoria";
$resultado = mysqli_query($db, $consulta);

// Arreglo con mensajes de errores
$errores = [];

// Inicializar variables
$nombre = '';
$racion = '';
$precioKg = '';
$fecha_produccion = '';
$fecha_caducidad = '';
$imagen = '';
$categoria_id = '';

// Ejecutar el código después de que el usuario envía el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    // echo "<pre>";
    // var_dump($_FILES);
    // echo "</pre>";

    $nombre = $_POST["nombre"];
    $racion = $_POST["racion"];
    $precioKg = $_POST["precioKg"];
    $fecha_produccion = $_POST["fecha_produccion"];
    $fecha_caducidad = $_POST["fecha_caducidad"];
    $imagen = $_POST["imagen"];
    $categoria_id = $_POST["categoria_id"];

    // Asignar files hacia una variable
    $imagen = $_FILES["imagen"];

    // if (!$nombre) {
    //     $errores[] = "Debes añadir un nombre";
    // }
    
    // if (!$racion) {
    //     $errores[] = "La racion es obligatorio";
    // }


    // if (!$precioKg) {
    //     $errores[] = "Introduce un precio valido";
    // }

    // if (!$fecha_produccion) {
    //     $errores[] = "Introduce una fecha de produccion valida";
    // }

    // if (!$fecha_caducidad) {
    //     $errores[] = "Introduce una fecha de caducidad valida";
    // }

    // if (!$categoria_id) {
    //     $errores[] = "Elige una categoria";
    // }

    // if (!$imagen["name"] || $imagen["error"]) {
    //     $errores[] = "La imagen es obligatoria";
    // }

    (!$nombre) ? $errores[] = "Debes añadir un nombre" : null;
    (!$racion) ? $errores[] = "La racion es obligatorio" : null;
    (!$precioKg) ? $errores[] = "Introduce un precio valido" : null;
    (!$fecha_produccion) ? $errores[] = "Introduce una fecha de produccion valida" : null;
    (!$fecha_caducidad) ? $errores[] = "Introduce una fecha de caducidad valida" : null;
    (!$categoria_id) ? $errores[] = "Elige una categoria" : null;
    (!$imagen["name"] || $imagen["error"]) ? $errores[] = "La imagen es obligatoria" : null;


    // Validar por tamaño (1mb máximo)
    $medida = 1000 * 1000;

    if ($imagen["size"] > $medida) {
        $errores[] = "La imagen es muy pesada";
    }

    // Revisar que el arreglo de errores esté vacío
    if (empty($errores)) {
        echo "No hay errores";
        // Subida de archivos
        // Crear carpeta
        $carpetaImagenes = '../../imagenes/';
        if(!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        // Generar un nombre único
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

        // Subir la imagen
        move_uploaded_file($imagen["tmp_name"], $carpetaImagenes . $nombreImagen);

        // Insertar en la base de datos
        $query = "INSERT INTO productos (nombre, racion, precioKg, fecha_produccion, fecha_caducidad, imagen, categoria_id) VALUES ('$nombre', '$racion', '$precioKg', '$fecha_produccion', '$fecha_caducidad', '$nombreImagen', '$categoria_id')";

        echo $query;

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            echo "Insertado correctamente";
            header("Location: /proyecto-daw-org-afh/admin");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/output.css">
</head>
<body class="bg-black text-white font-sans font-medium">
<main class="contenedor seccion mb-0 my-auto">

<div class="header flex justify-between items-center py-2 px-10">
            <div class="logo">
                <a href="./index.html"><img src="../assets/img/logo-menu.png" alt="Logo Ezequiel" class="w-20" /></a>
            </div>
            <div class="menu flex justify-between items-center">
                <ul class="flex justify-between items-center gap-5 whitespace-nowrap">
                    <li><button id="inicio"
                            class="bg-transparent border-none text-neutral-400 text-md cursor-pointer hover:text-white">Inicio</button>
                    </li>
                    <li><button id="acerca"
                            class="bg-transparent border-none text-neutral-400 text-md cursor-pointer hover:text-white">Acerca
                            de</button></li>
                    <li><button id="contacto"
                            class="bg-transparent border-none text-neutral-400 text-md cursor-pointer hover:text-white">Contacto</button>
                    </li>
                </ul>

                <svg class="w-8 h-8 ml-5 cursor-pointer p-1 hover:bg-light-gray rounded-full" id="basket"
                    viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g id="Basket" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect id="Container" x="0" y="0" width="24" height="24"> </rect>
                            <path
                                d="M4,10 L20,10 L20,16 C20,18.209139 18.209139,20 16,20 L8,20 C5.790861,20 4,18.209139 4,16 L4,10 L4,10 Z"
                                id="shape-1" stroke="#fff" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" stroke-dasharray="0,0"> </path>
                            <path
                                d="M7,4 L17,4 L17,5 C17,7.76142375 14.7614237,10 12,10 C9.23857625,10 7,7.76142375 7,5 L7,4 L7,4 Z"
                                id="shape-2" stroke="#fff" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" stroke-dasharray="0,0"
                                transform="translate(12.000000, 7.000000) scale(1, -1) translate(-12.000000, -7.000000) ">
                            </path>
                            <line x1="12" y1="13" x2="12" y2="17" id="shape-3" stroke="#fff" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="0,0"> </line>
                            <line x1="16" y1="13" x2="16" y2="17" id="shape-4" stroke="#fff" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="0,0"> </line>
                            <line x1="8" y1="13" x2="8" y2="17" id="shape-5" stroke="#fff" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="0,0"> </line>
                        </g>
                    </g>
                </svg>

                <div
                    class="counter absolute top-7 right-8 w-5 h-5 bg-red-600 text-white rounded-full flex items-center justify-center text-sm select-none">
                    <p id="counter">0</p>
                </div>

            </div>
        </div>

    
   

    </main>
</body>
</html>

<!-- Formulario para rellenar los datos -->


