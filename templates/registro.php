<?php
include_once "../database.php";

$bd = conectarDB();
//Esto hace que no se ejecute esto hasta que haya algo del post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] && $_POST['nombre'] && $_POST['pass'] && $_POST['correo'] !== '') {
        $conn = conectarDB();

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Hashear la contraseña
        $pass_hasheada = password_hash($_POST['pass'], PASSWORD_DEFAULT);

        $consulta = $conn->prepare("INSERT INTO usuarios (nombre, correo, pass, fecha_registro , username, rol) VALUES (?,?,?,NOW(),?, 2 )");
        $consulta->bind_param('ssss', $_POST['nombre'], $_POST['correo'],$pass_hasheada, $_POST['username']);

        try {
            $consulta->execute();
            session_start();
            $_SESSION['nombre'] = $_POST['nombre'];
            $_SESSION['correo'] = $_POST['correo'];
            $_SESSION['username'] = $_POST['username'];
            // $_SESSION['pass'] = $_POST['pass'];
            // $_SESSION['fecha_registro'] = date('Y-m-d H:i:s');
            $_SESSION['rol'] = 2;
            header("Location: ../index.php");
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        $consulta->close();
        $conn->close();
    } else {
        $err = true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <title>Registro</title>
    <style>
        body {
            background: url('background.jpg') center/cover fixed no-repeat;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #000; /* Cambiado a color negro */
            z-index: -1;
        }
    </style>
</head>

<body class="text-white bg-black flex flex-col items-center justify-center h-screen">

    <div class="logo mb-4">
        <a href="./index.php"><img src="../assets/img/logo-menu.png" alt="Logo Ezequiel" class="w-20" /></a>
    </div>

    <div class="wrapper py-8 mx-auto text-center bg-gray-800 bg-opacity-80 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-3xl font-bold text-yellow-500 mb-4">REGISTRO</h1>
        <a href="./login.php" class="text-blue-500 block mb-4">¿Ya tienes cuenta? Inicia Sesión</a>

        <form method="POST" class="mx-auto">
            <div class="mb-4">
                <label for="nombre" class="text-white">Introduzca nombre:</label>
                <input type="text" name="nombre" placeholder="Nombre completo..."
                    class="w-64 p-2 border border-gray-300 rounded mx-auto block text-black">
            </div>
            <div class="mb-4">
                <label for="correo" class="text-white">Introduzca email:</label>
                <input type="text" name="correo" placeholder="Introduzca email..."
                    class="w-64 p-2 border border-gray-300 rounded mx-auto block  text-black">
            </div>
            <div class="mb-4">
                <label for="username" class="text-white">Introduce tu nombre de usuario:</label>
                <input type="text" name="username" placeholder="Nombre de usuario..."
                    class="w-64 p-2 border border-gray-300 rounded mx-auto block  text-black">
            </div>
            <div class="mb-4">
                <label for="pass" class="text-white">Introduzca clave:</label>
                <input type="password" name="pass" placeholder="Contraseña..."
                    class="w-64 p-2 border border-gray-300 rounded mx-auto block  text-black">
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded mx-auto block">Enviar</button>
        </form>
    </div>

</body>

</html>
