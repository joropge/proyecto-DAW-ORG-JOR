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
    $imagen = $resultado->fetch_assoc();
    if ($imagen) {
        $imagen = $imagen['imagen'];
        unlink("../imagenes/" . $imagen);
    }


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
    <style>
        tbody tr:nth-child(even) {
            background-color: #171819;
        }

        tbody tr:nth-child(odd) {
            background-color: #222324;
        }
    </style>
</head>

<body class="bg-black text-white font-sans">
    <main class="container mx-0 px-4 py-8">
        <div class="flex justify-between  mb-4">
            <h1 class="text-yellow-500 text-3xl font-bold">Administrador de productos Ezequiel</h1>
            <a href="../index.php" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300 ease-in-out">Ver tienda</a>
        </div>

        <div>
            <h2 class="text-white text-2xl font-bold mb-4">Productos</h2>
            <div class="flex justify-between items-center" style="height: 3rem;">

                <input type="text" id="search" class="w-80 border-2 border-gray-800 px-5 pr-16 rounded-lg text-sm focus:outline-none h-full text-black" style="height:100%; width:40rem;" placeholder="Buscar por nombre...">

                <a href="./actions/crear-producto.php" class="inline-block bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300 ease-in-out">Añadir
                    producto</a>
            </div>

            <table class="mt-8 w-full">
                <thead class="border-b-2 border-green-500">
                    <tr class="border-b-2 border-green-500">
                        <th class="px-4 py-2 text-xl">Nombre</th>
                        <th class="px-4 py-2 text-xl">Racion</th>
                        <th class="px-4 py-2 text-xl">Precio KG</th>
                        <th class="px-4 py-2 text-xl">Imagen</th>
                        <th class="px-4 py-2 text-xl">Acción</th>
                    </tr>
                </thead>
                <tbody class="odd:bg-slate-300">
                    <?php
                    // Your PHP code to display the products from the "productos" table goes here
                    $query = "SELECT * FROM productos";
                    $resultado = mysqli_query($db, $query);

                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "<tr class='h-full'>";
                        echo "<td id='nameSearch' class='px-4 py-2 text-center'>" . $row['nombre'] . "</td>";
                        echo "<td class='px-4 py-2 text-center'>" . $row['racion'] . "</td>";
                        echo "<td class='px-4 py-2 text-center'>" . $row['precioKg'] . "</td>";
                        if (!empty($row['imagen'])) {
                            echo "<td class=' h-[150px] w-[150px] overflow-auto p-3'><img class='h-[150px] w-[150px] rounded-lg' src='../imagenes/" . $row['imagen'] . "  '></td>";
                        } else {
                            echo "<td class='h-[150px] w-[150px] p-3'><div class='rounded-lg h-[150px] w-[150px] grid place-content-center ' style='background-color: #404040; color: gray;'>" . $row['nombre'] . "</div></td>";
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
        </div>

        <br><br><br>

        <h2 class="text-white text-2xl font-bold mb-4">Pedidos</h2>


        <table class="mt-8 w-full">
            <thead class="border-b-2 border-green-500">
                <tr class="border-b-2 border-green-500">
                    <th class="px-4 py-2 text-xl">Usuario</th>
                    <th class="px-4 py-2 text-xl">Fecha Pedido</th>
                    <th class="px-4 py-2 text-xl">Importe Total</th>

                </tr>
            </thead>
            <tbody class="odd:bg-slate-300">
                <?php
                // Your PHP code to display the products from the "pedidos" table goes here
                $query = "SELECT pedidos.*, usuarios.nombre FROM pedidos INNER JOIN usuarios ON pedidos.idUser = usuarios.id";
                $resultado = mysqli_query($db, $query);

                while ($row = mysqli_fetch_assoc($resultado)) {
                    echo "<tr class='h-full'>";
                    echo "<td id='nameSearch' class='px-4 py-2 text-center'>" . $row['nombre'] . "</td>";
                    echo "<td class='px-4 py-2 text-center'>" . $row['fechaPedido'] . "</td>";
                    echo "<td class='px-4 py-2 text-center'>" . $row['precioTotal'] . "</td>";

                    echo "</tr>";
                }
                ?>

            </tbody>
        </table>
    </main>

    <script>
        const search = document.getElementById('search');
        search.addEventListener('keyup', function() {
            let value = search.value.toLowerCase();
            let rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                let nameCell = row.querySelector('#nameSearch');
                let rowText = nameCell.textContent.toLowerCase();
                if (rowText.includes(value)) {
                    row.style.display = '';

                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>