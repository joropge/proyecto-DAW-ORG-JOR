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
            header("Location: ../../admin");
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
</head>
<body>
<main class="contenedor seccion">
    <h1>Añadir producto</h1>

    <!-- Boton de volver -->
    <a href="../../admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" action="../../admin/actions/crear-producto.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>

            <label for="nombre">Producto</label>
            <input type="text" id="nombre" name="nombre" placeholder="Producto" value="<?php echo $nombre; ?>">

            <label for="racion">Racion</label>
            <input type="number" id="racion" name="racion" placeholder="Cantidad Racion" value="<?php echo $racion; ?>">

            <label for="precioKg">Precio/Kg:</label>
            <input type="number" id="precioKg" name="precioKg" placeholder="Precio/Kg"><?php echo $precioKg; ?>

            <label for="fecha_produccion">Fecha de Produccion</label>
            <input type="date" id="fecha_produccion" name="fecha_produccion" value="<?php echo $fecha_produccion; ?>">

            <label for="fecha_caducidad">Fecha de Caducidad:</label>
            <input type="date" id="fecha_caducidad" name="fecha_caducidad" value="<?php echo $fecha_caducidad; ?>">
            
            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/jpg, image/png" name="imagen">

        </fieldset>

        <fieldset>
            <legend>Categoria:</legend>

            <select name="categoria_id">
                <option value="">-- Seleccione --</option>
                <?php while ($categoria = mysqli_fetch_assoc($resultado)) : ?>
                    <option <?php echo $categoria === $categoria["id"] ? 'selected' : ''; ?> value="<?php echo $categoria["id"]; ?>"><?php echo $categoria["tipo_animal"] . " - " . $categoria["procedencia"]; ?></option>
                <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" value="Introducir Producto" class="boton boton-verde">
    </form>
</main>
</body>
</html>

<!-- Formulario para rellenar los datos -->


