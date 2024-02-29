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

<body class="font-sans bg-black text-white font-medium ">
    <main class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-4 py-2 px-4 rounded">Añadir producto</h1>

        <!-- Boton de volver -->
        <a href="../../admin" class="bg-yellow-500 text-white px-4 py-2 mb-4 inline-block rounded">Volver</a>

        <?php foreach ($errores as $error) : ?>
            <div class="bg-red-500 text-white p-4 mb-4">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="bg-black p-6 shadow-md rounded-md ml-4" method="POST" action="../../admin/actions/crear-producto.php" enctype="multipart/form-data">
            <fieldset>
                <legend class="text-lg font-bold">Información General</legend>

                <label for="nombre" class="block mt-4">Producto</label>
                <input type="text" id="nombre" name="nombre" class="border border-gray-300 p-2 w-1/2 rounded text-black" placeholder="Producto" value="<?php echo $nombre; ?>">

                <label for="racion" class="block mt-4">Racion</label>
                <input type="number" id="racion" name="racion" class="border border-gray-300 p-2 w-1/2 rounded text-black" placeholder="Cantidad Racion" value="<?php echo $racion; ?>">

                <label for="precioKg" class="block mt-4">Precio/Kg:</label>
                <input type="number" id="precioKg" name="precioKg" class="border border-gray-300 p-2 w-1/2 rounded text-black " placeholder="Precio/Kg" value="<?php echo $precioKg; ?>">

                <label for="fecha_produccion" class="block mt-4">Fecha de Produccion</label>
                <input type="date" id="fecha_produccion" name="fecha_produccion" class="border border-gray-300 p-2 w-1/2 rounded text-black" value="<?php echo $fecha_produccion; ?>">

                <label for="fecha_caducidad" class="block mt-4">Fecha de Caducidad:</label>
                <input type="date" id="fecha_caducidad" name="fecha_caducidad" class="border border-gray-300 p-2 w-1/2 rounded text-black" value="<?php echo $fecha_caducidad; ?>">

                <label for="imagen" class="block mt-4">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/jpg, image/png" name="imagen" class="mt-2">
            </fieldset>

            <fieldset class="mt-4">
                <legend class="text-lg font-bold">Categoria:</legend>

                <select name="categoria_id" class="border border-gray-300 p-2 w-1/2 rounded text-black">
                    <option value="">-- Seleccione --</option>
                    <?php while ($categoria = mysqli_fetch_assoc($resultado)) : ?>
                        <option <?php echo $categoria === $categoria["id"] ? 'selected' : ''; ?> value="<?php echo $categoria["id"]; ?>"><?php echo $categoria["tipo_animal"] . " - " . $categoria["procedencia"]; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </fieldset>

            <input type="submit" value="Introducir Producto" class="bg-yellow-500 text-black px-4 py-2 mt-4 inline-block rounded">
        </form>
    </main>

    <script src="/js/main.js" type="module"></script>
</body>

</html>
