<?php 

require_once '../database.php';
$db = conectarDB();

function borrarProducto($db, $id)
{

    //borrar la imagen en carpeta imagenes en la raiz
    $consulta = $db->prepare('SELECT imagen FROM productos WHERE id = ?');
    $consulta->bind_param('i', $id);
    $consulta->execute();
    $resultado = $consulta->get_result();
    $producto = $resultado->fetch_assoc();
    $imagen = $producto['imagen'];
    unlink('../imagenes/' . $imagen);

    $consulta = $db->prepare('DELETE FROM productos WHERE id = ?');
    $consulta->bind_param('i', $id);
    $consulta->execute();

    


}

// Lógica para eliminar producto
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['borrarProducto'])) {
    $id = $_GET['borrarProducto'];

    // Assuming $db is your mysqli connection object
    borrarProducto($db, $id);
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body class="bg-black text-white font-sans">
    <main class="contenedor seccion">
        <h1>Administrador de productos Ezequiel</h1>
        <a href="./actions/crear-producto.php" class="boton boton-verde">Añadir producto</a>

        <?php
        // Your PHP code to display the products from the "productos" table goes here
        $query = "SELECT * FROM productos";
        $resultado = mysqli_query($db, $query);

        echo "<table>";
        echo "<tr><th>Nombre</th><th>Racion</th><th>Precio KG</th><th>Imagen</th></tr>";
        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['racion'] . "</td>";
            echo "<td>" . $row['precioKg'] . "</td>";
            if (!empty($row['imagen'])) {
                echo "<td><img src='../imagenes/" . $row['imagen'] . "' width='100'></td>";
            } else {
                echo "<td><img src='https://via.placeholder.com/150' width='100'></td>";
            }
            echo "<td class='enlace deleteBtn'><a href=" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?borrarProducto=" . $row["id"] . "id='delete-btn' class='delete-btn'>Borrar</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>


    </main>
</body>

</html>