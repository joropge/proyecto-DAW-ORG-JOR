<?php

// Conectar a la base de datos
require_once '../../database.php';
$db = conectarDB();

$consulta = "SELECT nombre, racion, precioKg, fecha_produccion, fecha_caducidad, categoria_id, imagen FROM productos";
$resultado = mysqli_query($db, $consulta);

if ($resultado) {
    $productos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    echo json_encode($productos);
} else {
    echo json_encode(['error' => 'Failed to fetch products']);
}

mysqli_close($db);
