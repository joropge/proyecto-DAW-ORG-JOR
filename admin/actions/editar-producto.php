<?php
// Verificar si se proporcionó un ID de producto válido en la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID de producto no válido";
    exit;
}

// Conectar a la base de datos
require_once '../../database.php';
$db = conectarDB();

// Obtener el ID del producto desde la URL
$id = $_GET['id'];

// Consultar para obtener categoriaes
$consulta = "SELECT * FROM categoria";
$resultadoCat = mysqli_query($db, $consulta);

// Consulta para obtener la información del producto
$query = "SELECT * FROM productos WHERE id = $id";
$resultado = mysqli_query($db, $query);

// Verificar si se encontró el producto
if (mysqli_num_rows($resultado) === 0) {
    echo "Producto no encontrado.";
    exit;
}

// Obtener los datos del producto
$producto = mysqli_fetch_assoc($resultado);

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

// Procesar el formulario de actualización si se envió
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = $_POST["nombre"];
    $racion = $_POST["racion"];
    $precioKg = $_POST["precioKg"];
    $fecha_produccion = $_POST["fecha_produccion"];
    $fecha_caducidad = $_POST["fecha_caducidad"];
    // $imagen = $_POST["imagen"];
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
        echo "No hay errores <br>";
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

        // Consulta para actualizar el producto
        $query_update = "UPDATE productos SET nombre='$nombre', racion='$racion', precioKg='$precioKg', fecha_produccion = '$fecha_produccion', fecha_caducidad = '$fecha_caducidad' ,imagen='$nombreImagen', categoria_id = $categoria_id WHERE id=$id";
        $resultado_update = mysqli_query($db, $query_update);

        // Verificar si se realizó la actualización
        if ($resultado_update) {
            echo "Producto actualizado correctamente.";
            //Redirige a index de admin
            header("Location: ../../admin");
        } else {
            echo "Error al actualizar el producto: " . mysqli_error($db);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/output.css">
    <link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon">
</head>

<body class="bg-black p-8">

    <div class="max-w-md mx-auto bg-gray-800 p-8 rounded-md shadow-md">
        <div class="logo mb-4 flex flex-col items-center justify-center">
            <img src="../../assets/img/logo-menu.png" alt="Logo Ezequiel" class="w-20">
        </div>

        <h2 class="text-2xl font-bold mb-4 text-white">Editar Producto</h2>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-white">Producto:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $producto['nombre']; ?>" class="mt-1 p-2 border rounded-md w-full">
            </div>

            <div class="mb-4">
                <label for="racion" class="block text-sm font-medium text-white">Ración:</label>
                <input type="text" id="racion" name="racion" value="<?php echo $producto['racion']; ?>" class="mt-1 p-2 border rounded-md w-full">
            </div>

            <div class="mb-4">
                <label for="precioKg" class="block text-sm font-medium text-white">Precio por Kg:</label>
                <input type="text" id="precioKg" name="precioKg" value="<?php echo $producto['precioKg']; ?>" class="mt-1 p-2 border rounded-md w-full">
            </div>

            <div class="mb-4">
                <label for="fecha_produccion" class="block text-sm font-medium text-white">Fecha de Producción:</label>
                <input type="date" id="fecha_produccion" name="fecha_produccion" value="<?php echo $producto['fecha_produccion']; ?>" class="mt-1 p-2 border rounded-md w-full">
            </div>

            <div class="mb-4">
                <label for="fecha_caducidad" class="block text-sm font-medium text-white">Fecha de Caducidad:</label>
                <input type="date" id="fecha_caducidad" name="fecha_caducidad" value="<?php echo $producto['fecha_caducidad']; ?>" class="mt-1 p-2 border rounded-md w-full">
            </div>

            <div class="mb-4">
                <label for="imagen" class="block text-sm font-medium text-white">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpg" name="imagen" class="mt-1 p-2 border rounded-md w-full text-white">
            </div>

            <div class="mb-4">
                <label for="categoria_id" class="block text-sm font-medium text-white">Categoría:</label>
                <select name="categoria_id" class="mt-1 p-2 border rounded-md w-full">
                    <option value="">-- Seleccione --</option>
                    <?php while ($categoria = mysqli_fetch_assoc($resultadoCat)) : ?>
                        <option <?php echo $producto['categoria_id'] == $categoria["id"] ? 'selected' : ''; ?> value="<?php echo $categoria["id"]; ?>">
                            <?php echo $categoria["tipo_animal"] . " - " . $categoria["procedencia"]; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mt-6 mb-4 w-full flex flex-row justify-center items-center gap-3">
                <input type="submit" value="Actualizar" class="w-full bg-yellow-500 text-white py-2 px-4 rounded-md cursor-pointer">

                <a href="../../admin" class="w-full text-center bg-yellow-500 text-white py-2 px-4 rounded-md ">Volver</a>

            </div>
        </form>

    </div>

</body>

</html>

<?php
// Cerrar conexión
mysqli_close($db);
?>