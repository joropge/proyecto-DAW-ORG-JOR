<?php
include_once "../database.php";

$bd = conectarDB();
//Esto hace que no se ejecute esto hasta que haya algo del post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['usuario'] && $_POST['nombre'] && $_POST['clave'] && $_POST['email'] !== '') {
        $conn = new mysqli("localhost", "usuario", "clave", "basedatos");

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        $consulta = $conn->prepare("INSERT INTO usuario (nombre, correo, username, pass, fecha_registro, rol) VALUES (:nombre, :correo, :username, :clave, NOW(), 2 )");
        $consulta->bind_param('ssss', $_POST['nombre'], $_POST['email'], $_POST['username'], $_POST['clave']);

        try {
            $consulta->execute();
            session_start();
            $_SESSION['nombre'] = $_POST['nombre'];
            $_SESSION['correo'] = $_POST['correo'];
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['pass'] = $_POST['clave'];
            $_SESSION['fecha_registro'] = date('Y-m-d H:i:s');
            $_SESSION['rol'] = 2;
            // header("Location: pedido.php");
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
    <link rel="stylesheet" href="../css/style-registro.css" type="text/css">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <title>Registro</title>
</head>

<body>
    <div class="container">
        <div class="wrapper">
        <img src="../assets/imgs/logo.png" alt="">
            <h1>REGISTRO</h1>
            <a href="../index.php">¿Ya tienes cuenta? Inicia Sesion</a>
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
                    <label for="clave">Introduzca clave:</label>
                    <input type="password" name="clave" placeholder="Contraseña...">
                </div>
                <button action="submit">Enviar</button>
            </form>
        </div>
    </div>
</body>

</html>