<?php

//Conectar BD
require_once '../database.php';
$bd = conectarDB();

function comprobar_usuario($username, $pass)
{
    //Nos conectamos a la BD y lo igualamos a bd que sera donde se guarde la conexion
    $bd = conectarDB();
    //preparar la consulta
    $consulta = $bd->prepare("SELECT id, nombre, username, pass, rol FROM usuarios WHERE username = ?");
    //sustituir los ? por el valor de $username
    $consulta->bind_param("s", $username);
    //lanzar la consulta
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        // Verificar si la contraseña ingresada coincide con la contraseña hasheada almacenada en la base de datos

        if (password_verify($pass, $row['pass'])) {
            return array("id" => $row['id'], "username" => $row['username'], "nombre" => $row['nombre'], "rol" => $row['rol']);
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $usu = comprobar_usuario($_POST["username"], $_POST["pass"]);
    if ($usu == FALSE) {
        $err = TRUE;
        $usuario = $_POST["username"];
    } else {
        session_start();
        $_SESSION['id'] = $usu['id'];
        $_SESSION['username'] = $_POST["username"];
        $_SESSION['nombre'] = $usu['nombre'];
        $_SESSION['rol'] = $usu['rol'];
        if ($usu['rol'] == '1') {
            header("Location: ../admin");
        } else if ($usu['rol'] == '2') {
            header("Location: ../index.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="css/style-index.css" type="text/css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>Ezequiel</title>
</head>

<body class="text-white bg-black flex flex-col items-center justify-center h-screen">

    <!-- Nuevo logo -->
    <div class="logo mb-4">
        <a href="./index.php"><img src="../assets/img/logo-menu.png" alt="Logo Ezequiel" class="w-20" /></a>
    </div>

    <div class="container">
        <div class="wrapper py-8 mx-auto text-center bg-gray-800 bg-opacity-80 rounded-lg shadow-lg max-w-md w-full">
            <h1 class="text-3xl font-bold text-yellow-500 mb-4">Iniciar Sesión</h1>

            <?php
            if (isset($err)) {
                echo "<p class='incorrect'>Usuario o contraseña incorrectos</p>";
            }
            ?>

            <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="POST" class="mx-auto">
                <div class="mb-4">
                    <label for="username" class="text-white">Usuario: </label>
                    <input value="<?php if (isset($usuario)) echo $usuario; ?>" name="username" placeholder="Usuario..." class="w-64 p-2 border border-gray-300 rounded mx-auto block  text-black">
                </div>
                <div class="mb-4">
                    <label for="pass" class="text-white">Contraseña: </label>
                    <input type="password" name="pass" placeholder="Contraseña..." class="w-64 p-2 border border-gray-300 rounded mx-auto block  text-black">
                </div>

                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded mx-auto block">Enviar</button>
            </form>
            <a href="./registro.php" class="text-blue-500 block mb-4">¿No tienes cuenta? Regístrate</a>


        </div>
    </div>

</body>

</html>