<?php

// Conectar a la base de datos
require_once '../../database.php';
$db = conectarDB();

// Consultar para obtener categorias
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

    $nombre = $_POST["nombre"];
    $racion = $_POST["racion"];
    $precioKg = $_POST["precioKg"];
    $fecha_produccion = $_POST["fecha_produccion"];
    $fecha_caducidad = $_POST["fecha_caducidad"];
    $imagen = $_POST["imagen"];
    $categoria_id = $_POST["categoria_id"];

    // Asignar files hacia una variable
    $imagen = $_FILES["imagen"];

    (!$nombre) ? $errores[] = "Debes añadir un nombre" : null;
    (!$racion) ? $errores[] = "La racion es obligatorio" : null;
    (!$precioKg) ? $errores[] = "Introduce un precio valido" : null;
    (!$fecha_produccion) ? $errores[] = "Introduce una fecha de produccion valida" : null;
    (!$fecha_caducidad) ? $errores[] = "Introduce una fecha de caducidad valida" : null;
    (!$categoria_id) ? $errores[] = "Elige una categoria" : null;
    (!$imagen["name"] || $imagen["error"]) ? $errores[] = "La imagen es obligatoria" : null;


    // Validar por tamaño (10mb máximo)
    $medida = 1000 * 1000 * 10;

    if ($imagen["size"] > $medida) {
        $errores[] = "La imagen es muy pesada";
    }

    // Revisar que el arreglo de errores esté vacío
    if (empty($errores)) {
        echo "No hay errores";
        // Subida de archivos
        // Crear carpeta
        $carpetaImagenes = '../../imagenes/';
        if (!is_dir($carpetaImagenes)) {
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
            header("Location: ../../admin");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Producto</title>
    <link rel="stylesheet" href="../../css/output.css">
    <link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon" />
</head>

<body class="bg-black p-8">

    <main>

        <?php foreach ($errores as $error) : ?>
            <div class="bg-red-500 text-white p-4 mb-4">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <div class="max-w-md mx-auto bg-gray-800 p-8 rounded-md shadow-md">
            <div class="logo mb-4 flex flex-col items-center justify-center">
                <img src="../../assets/img/logo-menu.png" alt="Logo Ezequiel" class="w-20">
            </div>
            <h2 class="text-2xl font-bold mb-4 text-white">Añadir Producto</h2>
            <form action="../../admin/actions/crear-producto.php" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-white">Producto:</label>
                    <input type="text" id="nombre" name="nombre" class="mt-1 p-2 border rounded-md w-full">
                </div>
                <div class="mb-4">
                    <label for="racion" class="block text-sm font-medium text-white">Ración:</label>
                    <input type="text" id="racion" name="racion" class="mt-1 p-2 border rounded-md w-full">
                </div>
                <div class="mb-4">
                    <label for="precioKg" class="block text-sm font-medium text-white">Precio por Kg:</label>
                    <input type="text" id="precioKg" name="precioKg" class="mt-1 p-2 border rounded-md w-full">
                </div>
                <div class="mb-4">
                    <label for="fecha_produccion" class="block text-sm font-medium text-white">Fecha de Producción:</label>
                    <input type="date" id="fecha_produccion" name="fecha_produccion" class="mt-1 p-2 border rounded-md w-full">
                </div>
                <div class="mb-4">
                    <label for="fecha_caducidad" class="block text-sm font-medium text-white">Fecha de Caducidad:</label>
                    <input type="date" id="fecha_caducidad" name="fecha_caducidad" class="mt-1 p-2 border rounded-md w-full">
                </div>
                <div class="mb-4">
                    <label for="imagen" class="block text-sm font-medium text-white">Imagen:</label>
                    <input type="file" id="imagen" accept="image/jpg" name="imagen" class="mt-1 p-2 border rounded-md w-full text-white">
                </div>

                <fieldset class="mb-4">
                    <legend class="text-lg font-bold text-white">Categoria:</legend>
                    <select name="categoria_id" class="border border-gray-300 p-2 w-1/2 rounded text-black w-full">
                        <option value="">-- Seleccione --</option>
                        <?php while ($categoria = mysqli_fetch_assoc($resultado)) : ?>
                            <option <?php echo $categoria === $categoria["id"] ? 'selected' : ''; ?> value="<?php echo $categoria["id"]; ?>"><?php echo $categoria["tipo_animal"] . " - " . $categoria["procedencia"]; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </fieldset>
                <div class="mt-6 mb-4 w-full flex flex-row justify-center items-center gap-3">
                    <input type="submit" value="Introducir Producto" class="w-full bg-yellow-500 text-white py-2 px-4 rounded-md cursor-pointer">
                    <a href="../../admin" class="w-full text-center bg-yellow-500 text-white py-2 px-4 rounded-md ">Volver</a>
                </div>
            </form>
        </div>
    </main>

    <script src="/js/main.js" type="module"></script>
</body>

</html>