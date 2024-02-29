<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contacto</title>
    <!--Estilos por Mario-->
    <!-- <link rel="stylesheet" href="../css/contacto.css"> -->
    <link rel="stylesheet" href="../css/output.css">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
</head>

<body class="font-sans bg-black text-white font-medium">
    <div class="py-4">
        <div class="flex justify-between items-center mb-8">
            <div class="logo ml-8">
                <a href="../index.php">
                    <img src="../assets/img/logo-menu.png" alt="Logo Ezequiel" />
                </a>
            </div>
            <div class="menu mr-8">
                <ul class="flex">
                    <li><a href="../index.php" class="mr-4">Inicio</a></li>
                    <li><a href="./acercaDe.php" class="mr-4">Acerca de</a></li>
                    <li><a href="./contacto.php">Contacto</a></li>
                </ul>
            </div>
        </div>

        <div class="content flex gap-20 px-10">
            <div class="informacion flex-1">
                <h1 class="text-yellow-500 text-2xl mb-4 font-bold">Datos de información</h1>
                <h3 class="text-xl mb-2 font-bold">FÁBRICA DE EMBUTIDOS Y JAMONES EZEQUIEL / OFICINAS CENTRALES</h3>
                <p class="mb-2">Teléfono/Fax: 985 555 555</p>
                <p class="mb-2">Teléfono: + 34 699 69 69 69</p>
                <p class="mb-4">Email: atencionalcliente@embutidosezequiel.es</p>
                <h3 class="text-xl mb-2 font-bold">RESTAURANTE VILLAMANÍN</h3>
                <p class="mb-2">Dirección: Ctra. Nacional 630, km 99,5, 24680 Villamanín, León</p>
                <p class="mb-2">Teléfono: +34 985 555 555</p>
                <p class="mb-4">Email: reservas@embutidosezequiel.es</p>
                <h3 class="text-xl mb-2 font-bold">Horarios:</h3>
                <p class="mb-2">Lunes a Domingo: 07:00 - 24:00</p>
                <p>Turnos de comida: 14:00 y 15:30 horas</p>
            </div>
            <div class="contacto flex-1">
                <form action="#" method="post">
                    <label for="nombre" class="block mb-2">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="w-full p-2 mb-4 border border-gray-300 rounded" />
                    <label for="email" class="block mb-2">Email</label>
                    <input type="email" id="email" name="email" class="w-full p-2 mb-4 border border-gray-300 rounded" />
                    <label for="telefono" class="block mb-2">Teléfono</label>
                    <input type="number" id="telefono" name="telefono" class="w-full p-2 mb-4 border border-gray-300 rounded" />
                    <label for="consulta" class="block mb-2">Consulta</label>
                    <select name="consulta" id="consulta" class="w-full p-2 mb-4 border border-gray-300 text-black rounded">
                        <option value="atencion">Atención al cliente</option>
                        <option value="restaurante">Restaurante</option>
                        <option value="administracion">Administración Fábrica</option>
                        <option value="otros">Otros</option>
                    </select>
                    <label for="mensaje" class="block mb-2">Mensaje</label>
                    <textarea name="mensaje" id="mensaje" class=" h-28 w-full p-2 mb-4 border border-gray-300 resize-none rounded" placeholder="Escriba lo que quiera decirnos"></textarea>
                    <input type="submit" value="Enviar" class="bg-yellow-500 text-black font-semibold w-full mb-10 py-2 px-4 cursor-pointer transition-colors duration-300 hover:bg-yellow-600 rounded" />
                </form>
            </div>
        </div>

        <footer class="border-t border-solid border-gray-300 text-white text-center py-4">
            <p>&copy; 2023 Ezequiel. Todos los derechos reservados.</p>
        </footer>

        <script src="/js/main.js" type="module"></script>
</body>


</html>