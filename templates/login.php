<?php

//Conectar BD
require_once '../database.php';
$bd = conectarDB();

function comprobar_usuario($username, $pass)
{
    //Nos conectamos a la BD y lo igualamos a bd que sera donde se guarde la conexion
    $bd = conectarDB();
    //preparar la consulta
    $consulta = $bd->prepare("SELECT id, nombre, username, rol FROM usuarios WHERE username = ? AND pass = ?");
    //sustituir los ? por los valores $usuario y $pass
    $consulta->bind_param("ss", $username, $pass);
    //lanzar la consulta
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return array("id" => $row['id'], "username" => $row['username'], "nombre" => $row['nombre'], "rol" => $row['rol']);
    } else
        return FALSE;
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
    <link rel="stylesheet" href="css/style-index.css" type="text/css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>Ezequiel</title>
</head>

<body>
    <div class="container">
        <div class="wrapper">
            <img src="assets/imgs/logo.png" alt="">
            <h1>Iniciar Sesion</h1>

            <?php
            if (isset($err)) {
                echo "<p class='incorrect'>usuario o contraseña incorrectos</p>";
            }
            ?>

            <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="POST">
                <div>
                    <label for="username">Usuario: </label>
                    <input value="<?php if (isset($usuario)) echo $usuario; ?>" name="username" placeholder="Usuario...">
                </div>
                <div>
                    <label for="pass">Contraseña: </label>
                    <input type="password" name="pass" placeholder="Contraseña...">
                </div>

                <button action="submit">Enviar</button>
            </form>
            <a href="./templates/registro.php">¿No tienes cuenta? Registrate</a>
        </div>
    </div>

</body>

</html>