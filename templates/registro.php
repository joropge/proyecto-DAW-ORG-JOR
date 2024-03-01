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

        $consulta = $conn->prepare("INSERT INTO usuarios (nombre, correo, username, pass, rol) VALUES (?,?,?,?, 2 )");
        $consulta->bind_param('ssss', $_POST['nombre'], $_POST['correo'], $_POST['username'], $_POST['pass']);

        try {
            $consulta->execute();
            session_start();
            $_SESSION['nombre'] = $_POST['nombre'];
            $_SESSION['correo'] = $_POST['correo'];
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['pass'] = $_POST['pass'];
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
<!-- Hay que linkar bien las rutas para las vista del register -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-registro.css" type="text/css">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <title>Registro</title>
</head>

<body>
    <div class="container">
        <div class="wrapper">
            <img src="../assets/imgs/logo.png" alt="">
            <h1>REGISTRO</h1>
            <a href="./login.php">¿Ya tienes cuenta? Inicia Sesion</a>
            <?php
            if (isset($err)) {
                echo "<p class='incorrect'>No puede haber campos vacios</p>";
            }
            ?>

            <form method="POST">
                <div>
                    <label for="nombre">Introduzca nombre:</label>
                    <input type="text" name="nombre" placeholder="Nombre completo...">
                </div>
                <div>
                    <label for="correo">Introduzca email:</label>
                    <input type="text" name="correo" placeholder="Introduzca email...">
                </div>
                <div>
                    <label for="username">Itroduce tu nombre de usuatio:</label>
                    <input type="text" name="username" placeholder="Nombre de usuario...">
                </div>
                <div>
                    <label for="pass">Introduzca clave:</label>
                    <input type="password" name="pass" placeholder="Contraseña...">
                </div>
                <button action="submit">Enviar</button>
            </form>
        </div>
    </div>
</body>

</html>