<?php 

require_once '../database.php';
$db = conectarDB();

//Iniciar la sesion con el usuario traido del login, si el rol del usuario es diferente a 1, redirigir a index.php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../index.php");
}

function cerrarSesion()
{
    session_unset();
    session_destroy();
    header("Location: ../index.php");
}

// Lógica para cerrar sesion
if (isset($_GET["cerrar_sesion"])) {
    cerrarSesion();
}

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

//funcion para editar los productos
function editarProducto($db, $id)
{
    // Preparar y ejecutar la consulta para obtener los detalles del producto por su ID
    $consulta = $db->prepare("SELECT * FROM productos WHERE id = ?");
    $consulta->bind_param('i', $id);
    $consulta->execute();
    $resultado = $consulta->get_result();
    // Devuelve los detalles del producto como un array asociativo
    return $resultado->fetch_assoc();
}

// Lógica para editar producto
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['editarProducto'])) {
    $id = $_GET['editarProducto'];

    // Assuming $db is your mysqli connection object
    editarProducto($db, $id);
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/tailwind.css">
    <title>Document</title>
</head>

<body>
    <main class="contenedor seccion">
        <!-- Poner en el titulo el nombre del usuario que tenemos de la sesion-->
        <h1>Bienvenido, <?php echo $_SESSION['nombre'] ?></h1>  
        <!-- Boton cerrar sesion aplicando el metodo php cerrarSesion -->
        <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>?cerrar_sesion=true" class="boton boton-rojo">Cerrar sesión</a>
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
            //boton editar
            echo "<td class='enlace'><a href='./actions/editar-producto.php?id=" . $row["id"] . "id='edit-btn' class='edit-btn'>Editar</a></td>";
            echo "</tr>";
        }
        echo "</table>";

        ?>


    </main>
</body>

</html>