<?php
// FILEPATH: /D:/OneDrive/OneDrive - TuniverS Formación/2º DAW/DAW/Tareas Evaluables/T4-Organizacion/proyecto-DAW-ORG-AFH/templates/login.php

//Conectar BD
require_once 'database.php';
$bd = conectarDB();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Register">
    </form>
</body>

</html>