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
<title>Administrador de productos Ezequiel</title>
<link rel="stylesheet" href="../css/output.css" />
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19" rel="stylesheet">
</head>
 
<body class="bg-black text-white font-sans">
<main class="container mx-auto px-4 py-8">
<h1 class="text-yellow-500 text-3xl font-bold mb-4">Administrador de productos Ezequiel</h1>
<a href="./actions/crear-producto.php"
            class="inline-block bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300 ease-in-out">Añadir
            producto</a>
 
        <table class="mt-8 w-full table-auto">
<thead>
<tr>
<th class="px-4 py-2">Nombre</th>
<th class="px-4 py-2">Racion</th>
<th class="px-4 py-2">Precio KG</th>
<th class="px-4 py-2">Imagen</th>
<th class="px-4 py-2">Acción</th>
</tr>
</thead>
<tbody>
<?php
                // Your PHP code to display the products from the "productos" table goes here
                $query = "SELECT * FROM productos";
                $resultado = mysqli_query($db, $query);
 
                
while ($row = mysqli_fetch_assoc($resultado)) {
    echo "<tr class='h-full'>";
    echo "<td class='px-4 py-2 text-center'>" . $row['nombre'] . "</td>";
    echo "<td class='px-4 py-2 text-center'>" . $row['racion'] . "</td>";
    echo "<td class='px-4 py-2 text-center'>" . $row['precioKg'] . "</td>";
    if (!empty($row['imagen'])) {
        echo "<td class=' h-[150px] w-[150px] overflow-auto'><img class='h-[150px] w-[150px]' src='../imagenes/" . $row['imagen'] . "  '></td>";
    } else {
        echo "<td class='h-[150px] w-[150px] '><img src='https://via.placeholder.com/150'></td>";
    }
    echo "<td class='px-4 py-2 mx-5'>
    <div class=' w-full h-full flex flex-col justify-center items-center gap-2'>
        <a href=" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?borrarProducto=" . $row["id"] . " id='delete-btn' class='inline-block bg-red-500 text-white px-8 py-2 rounded-md hover:bg-red-600 transition duration-300 ease-in-out'>Borrar</a>
        </br>
        <a href='./actions/editar-producto.php?id=" . $row["id"] . "' id='edit-btn' class='inline-block bg-blue-500 text-white px-8 py-2 rounded-md hover:bg-blue-600 transition duration-300 ease-in-out'>Editar</a>
    </div>    
        </td>";
    //Añadir enlace para editar
    
    echo "</tr>";
}
?>
 
            </tbody>
</table>
</main>
</body>
 
</html>