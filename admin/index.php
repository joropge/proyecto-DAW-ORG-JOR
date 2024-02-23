<?php 

require_once '../database.php';
$db = conectarDB();

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
        <h1>Administrador de Bienes Raices</h1>
        <a href="./actions/crear-producto.php" class="boton boton-verde">Añadir producto</a>

        <?php
        // Your PHP code to display the products from the "productos" table goes here
        $query = "SELECT * FROM productos";
        $resultado = mysqli_query($db, $query);

        echo "<table>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Precio</th></tr>";
        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['racion'] . "</td>";
            echo "<td>" . $row['precioKg'] . "</td>";
            echo "<td><img src='../imagenes/" . $row['imagen'] . "' width='100'></td>";


            echo "</tr>";
        }
        echo "</table>";
        ?>


    </main>
</body>

</html>