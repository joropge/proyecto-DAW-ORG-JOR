<?php
include_once "database.php";
$db = conectarDB();


session_start();




// Si tenemos un post, es decir, si se ha enviado un formulario y hay usuario con id distinto de null
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id'])) {
    // Obtener el id del usuario
    $id_usuario = $_SESSION['id'];

    // Obtener el total del pedido
    $total = $_POST['total'];

    // Crear el pedido
    $consulta = $db->prepare("INSERT INTO pedidos (idUser, precioTotal, fechaPedido) VALUES (?, ?, NOW())");
    // bindear parametros, un string y un decimal
    $consulta->bind_param('id', $id_usuario, $total);
    $consulta->execute();
    header("Location: ./templates/gracias.php");
}



function cerrarSesion()
{
    session_unset();
    session_destroy();
    header("Location: ./index.php");
}
// Lógica para cerrar sesion
if (isset($_GET["cerrar_sesion"])) {
    cerrarSesion();
}

?>





<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ezequiel -
        <?php
        if (isset($_SESSION["nombre"])) {
            echo $_SESSION["nombre"];
        } else {
            echo "Inicio";
        }
        ?>
    </title>
    <!-- <link rel="stylesheet" href="css/styles.css" /> -->
    <!-- <link rel="stylesheet" href="css/output.css" /> -->

    <link rel="stylesheet" href="css/output.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body class="bg-black text-white font-sans">
    <div class="my-0 mx-auto">
        <div class="header flex justify-between items-center py-2 px-10">
            <div class="logo">
                <a href="./index.php"><img src="assets/img/logo-menu.png" alt="Logo Ezequiel" class="w-20" /></a>
            </div>
            <div class="menu flex justify-between items-center">
                <ul class="flex justify-between items-center gap-5 whitespace-nowrap">
                    <li><a href="index.php" id="inicio" class="bg-transparent border-none text-neutral-400 text-md cursor-pointer hover:text-white">Inicio</a>
                    </li>
                    <li><a href="./templates/acercaDe.php" id="acerca" class="bg-transparent border-none text-neutral-400 text-md cursor-pointer hover:text-white">Acerca
                            de</a></li>
                    <li>
                        <a href="./templates/contacto.php" class="bg-transparent border-none text-neutral-400 text-md cursor-pointer hover:text-white">
                            Contacto
                        </a>
                    </li>
                    <li class="flex items-center">
                        <?php
                        if (isset($_SESSION["nombre"])) {
                            //Imprimir el nombre de usuario
                            echo "<p class='text-white text-md font-bold mr-4'>" . $_SESSION["nombre"] . "</p>";
                            // Hacer un enlace cerrar sesion que aplique el metodo cerrarSesion
                            echo "<a href='./index.php?cerrar_sesion' id='cerrar_sesion' class='bg-red-600 hover:bg-red-500 rounded-full p-2'>
                            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' style='height: 1.3rem;'>
                            <path stroke-linecap='round' stroke-linejoin='round' d='M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15' />
                          </svg>
                          
                            </a>";

                            if ($_SESSION["rol"] == "1") {
                                echo "<a href='./admin' id='admin' class='bg-transparent border-none text-neutral-400 text-md cursor-pointer hover:text-white ml-5'>Administrar</a>";
                            }
                        } else {
                            echo "<a href='./templates/login.php' id='login' class='bg-transparent border-none text-neutral-400 text-md cursor-pointer hover:text-white'>Iniciar Sesion</a>";
                        }
                        ?>
                    </li>
                </ul>

                <?php if (isset($_SESSION["username"])) {
                    echo "<svg class='w-8 h-8 ml-5 cursor-pointer p-1 hover:bg-light-gray rounded-full' id='basket' viewBox='0 0 24 24' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' fill='#000000'>
                    <g id='SVGRepo_bgCarrier' stroke-width='0'></g>
                    <g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g>
                    <g id='SVGRepo_iconCarrier'>
                        <g id='Basket' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'>
                            <rect id='Container' x='0' y='0' width='24' height='24'> </rect>
                            <path d='M4,10 L20,10 L20,16 C20,18.209139 18.209139,20 16,20 L8,20 C5.790861,20 4,18.209139 4,16 L4,10 L4,10 Z' id='shape-1' stroke='#fff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' stroke-dasharray='0,0'> </path>
                            <path d='M7,4 L17,4 L17,5 C17,7.76142375 14.7614237,10 12,10 C9.23857625,10 7,7.76142375 7,5 L7,4 L7,4 Z' id='shape-2' stroke='#fff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' stroke-dasharray='0,0' transform='translate(12.000000, 7.000000) scale(1, -1) translate(-12.000000, -7.000000) '>
                            </path>
                            <line x1='12' y1='13' x2='12' y2='17' id='shape-3' stroke='#fff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' stroke-dasharray='0,0'> </line>
                            <line x1='16' y1='13' x2='16' y2='17' id='shape-4' stroke='#fff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' stroke-dasharray='0,0'> </line>
                            <line x1='8' y1='13' x2='8' y2='17' id='shape-5' stroke='#fff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' stroke-dasharray='0,0'> </line>
                        </g>
                    </g>
                </svg>

                <div class='counter absolute top-7 right-8 w-5 h-5 bg-red-600 text-white rounded-full flex items-center justify-center text-sm select-none'>
                    <p id='counter'>0</p>
                </div>";
                }
                ?>

            </div>
        </div>

        <div class="order flex-col gap-5 bg-white text-black w-96 max-h-[500px] p-5 rounded-md absolute top-20 right-10 z-[100] overflow-y-auto hidden" id="order">
            <div id="full-basket" class="hidden">
                <form method="POST">
                    <h1 class="text-lg font-bold mb-4">Resumen pedido</h1>
                    <ul id="list-order" class="flex flex-col gap-3">
                    </ul>
                    <p class="hidden p-2 border-t border-b border-white font-bold text-right mt-3" id="total-text">Total:
                        <span id="total">0</span>€

                    </p>
                    <input type="hidden" name="total" id="total_input">
                    <button type="submit" id="pagar" class="w-full py-3 border-none rounded-md bg-black text-white text-center cursor-pointer mt-4 font-bold hover:bg-light-gray transition-all duration-200 ease-in-out">Finalizar
                        pedido</button>
                </form>
            </div>
            <div id="empty-basket">
                <h1 class="text-lighter-gray text-sm font-semibold text-center">No hay productos en el carrito</h1>
            </div>

        </div>

        <div class="banner h-[500px] overflow-y-hidden">
            <!-- <img src="./assets/img/restaurante-banner.jpg" alt="Banner"> -->
            <!-- CODIGO SLIDER -->
            <div id="slider-container" class="relative max-w-full m-auto">
                <img src="assets/img/ezequiel1.jpg" class="slider-img active absolute w-full h-[500px] opacity-100 transition duration-100 ease-in-out" alt="Image 1">
                <img src="assets/img/ezequiel2.jpg" class="slider-img absolute w-full h-[500px] opacity-0 transition duration-100 ease-in-out" alt="Image 2">
                <img src="assets/img/ezequiel3.jpg" class="slider-img absolute w-full h-[500px] opacity-0 transition duration-100 ease-in-out" alt="Image 3">
            </div>
        </div>
    </div>
    <div class="content p-10">
        <div class="main">
            <h1 class="text-2xl">Nuestros productos</h1>
        </div>
        <!-- Prueba para alvaro -->
        <div class="display grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 items-center py-5" id="display">
        </div>
    </div>

    <footer class="text-white text-center p-5 w-full text-xs border-t border-light-gray">
        <p>&copy; 2023 Ezequiel. Todos los derechos reservados.</p>
    </footer>


    <script src="./js/main.js" type="module"></script>
    </div>
</body>

</html>