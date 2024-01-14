<?php
// Haremos un formulario de registro de cliente con los campos nombre, clave, mail, fecha de nacimiento, Tienda más cercana (menú desplegable con los valores Madrid, Barcelona y Valencia, edad (botones con las opciones: más joven de 25, entre 25 y 50, mayor de 50), y una casilla de verficación sobre la suscripción a la revista corporativa.
if(!empty($_POST)){
    $vFiltrados = [];
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $vFiltrados['nombre'] = filter_var($nombre, FILTER_VALIDATE_REGEXP, ['options' => ["regexp" => "/^[a-z A-ZáéíóúÁÉÍÓÚ]{3,25}$/" ]]);

    $password = filter_input(INPUT_POST,'password', FILTER_SANITIZE_STRING);
    $vFiltrados['password'] = filter_var($password, FILTER_VALIDATE_REGEXP, ['options' => ["regexp" => "/^[\w!@#\$%\^&\*\(\)\+]{6,8}$/" ]]);

    $email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
    $vFiltrados['email'] = filter_var($email, FILTER_VALIDATE_EMAIL);

    $fnacimiento = filter_input(INPUT_POST,'fnacimiento', FILTER_SANITIZE_STRING);
    if(!empty($fnacimiento)) {
        $arrFecha = explode("-", $fnacimiento);
        $vFiltrados['fnacimiento'] = (checkdate($arrFecha[1], $arrFecha[2], $arrFecha[0])) ? $fnacimiento : false;
    } else {
        $vFiltrados['fnacimiento'] = false;
    }
    
    $telefono = filter_input(INPUT_POST,'telefono', FILTER_SANITIZE_NUMBER_INT);
    $vFiltrados['telefono'] = filter_var($telefono, FILTER_VALIDATE_INT);

    $tienda = filter_input(INPUT_POST,'tienda');
    $vFiltrados['tienda'] = ($tienda === 'Madrid' || $tienda === 'Barcelona' || $tienda === 'Valencia') ? $tienda : false;

    $edad = filter_input(INPUT_POST,'edad', FILTER_SANITIZE_STRING);
    $vFiltrados['edad'] = (is_null($edad) ? false : $edad);

    $suscripcion = filter_input(INPUT_POST, 'suscripcion', FILTER_VALIDATE_BOOLEAN) ?? false;
    
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Registro</title>
</head>

<body>
    <main>
        <?php if(empty($_POST) || array_search(false, $vFiltrados)) : ?>
        <h1>Customer Registration</h1>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Introduce tu nombre"
                value="<?= $vFiltrados['nombre'] ?? ''?>">
            </div>
            <?= (isset($vFiltrados['nombre']) && !$vFiltrados['nombre']) ? "<p class='error'>Nombre incorrecto</p>" : "";?>

            <div class="campo">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Introduce tu password"
                value="<?= $vFiltrados['password'] ?? ''?>">
            </div>
            <?= (isset($vFiltrados['password']) && !$vFiltrados['password']) ? "<p class='error'>Password incorrecto</p>" : "";?>

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Introduce tu email"
                value="<?= $vFiltrados['email'] ?? ''?>">
            </div>
            <?= (isset($vFiltrados['email']) && !$vFiltrados['email']) ? "<p class='error'>Email incorrecto</p>" : "";?>

            <div class="campo">
                <label for="fnacimiento">Fecha nacimiento</label>
                <input type="date" id="fnacimiento" name="fnacimiento"
                value="<?= $vFiltrados['fnacimiento'] ?? ''?>">
            </div>
            <?= (isset($vFiltrados['fnacimiento']) && !$vFiltrados['fnacimiento']) ? "<p class='error'>Fecha incorrecta</p>" : "";?>

            <div class="campo">
                <label for="telefono">Télefono</label>
                <input type="tel" id="telefono" name="telefono" placeholder="Introduce tu télefono"
                value="<?= $vFiltrados['telefono'] ?? ''?>">
            </div>
            <?= (isset($vFiltrados['telefono']) && !$vFiltrados['telefono']) ? "<p class='error'>Teléfono incorrecto</p>" : "";?>

            <div class="campo">
                <label for="tienda">Tienda más cercana</label>
                <select name="tienda" id="tienda">
                    <option value="" selected disabled>Selecciona una tienda</option>
                    <option value="Madrid" 
                        <?= (isset($vFiltrados['tienda']) && $vFiltrados['tienda'] === "Madrid") ? "selected" : ""; ?>
                    >Madrid</option>
                    <option value="Barcelona"
                        <?= (isset($vFiltrados['tienda']) && $vFiltrados['tienda'] === "Barcelona") ? "selected" : ""; ?>
                    >Barcelona</option>
                    <option value="Valencia"
                        <?= (isset($vFiltrados['tienda']) && $vFiltrados['tienda'] === "Valencia") ? "selected" : ""; ?>
                    >Valencia</option>
                </select>
            </div>
            <?= (isset($vFiltrados['tienda']) && !$vFiltrados['tienda']) ? "<p class='error'>Selecciona una tienda</p>" : "";?>

            <div class="campo">
                <label>Edad</label>
                <div class="edades">
                    <div class="op-edades">
                        <input type="radio" name="edad" value="menor de 25" id="menor"
                            <?= (isset($vFiltrados['edad']) && $vFiltrados['edad'] === "menor de 25") ? "checked" : ""; ?>
                        >
                        <label for="menor">Menor de 25</label>
                    </div>
                    <div class="op-edades">
                        <input type="radio" name="edad" value="entre 25 y 50" id="medio"
                            <?= (isset($vFiltrados['edad']) && $vFiltrados['edad'] === "entre 25 y 50") ? "checked" : ""; ?>
                        >
                        <label for="medio">Entre 25 y 50</label>
                    </div>
                    <div class="op-edades">
                        <input type="radio" name="edad" value="mayor de 50" id="mayor"
                            <?= (isset($vFiltrados['edad']) && $vFiltrados['edad'] === "mayor de 50") ? "checked" : ""; ?>
                        >
                        <label for="mayor">Mayor de 50</label>
                    </div>
                    
                </div>
            </div>
            <?= (isset($vFiltrados['edad']) && !$vFiltrados['edad']) ? "<p class='error'>Selecciona una edad</p>" : "";?>

            <div class="campo">
                <label for="suscripcion">Suscripción novedades</label>
                <input type="checkbox" name="suscripcion" id="suscripcion">
            </div>
            <input type="submit" value="Registrarme">
        </form>
        <?php else: ?>
            <h1>Datos del cliente</h1>
            <div class="datos">
                <p><span>Nombre: </span><?= $vFiltrados['nombre']?></p>
                <p><span>Password: </span><?= $vFiltrados['password'] ?></p>
                <p><span>Email: </span><?= $vFiltrados['email'] ?></p>
                <p><span>Fecha de nacimiento: </span><?= $vFiltrados['fnacimiento'] ?></p>
                <p><span>Teléfono: </span><?= $vFiltrados['telefono'] ?></p>
                <p><span>Tienda: </span><?= $vFiltrados['tienda'] ?></p>
                <p><span>Edad: </span><?= $vFiltrados['edad'] ?></p>
                <p><span>Suscripcion: </span><?= ($suscripcion)? "Suscrito": "No suscrito" ?></p>
            </div>
            
        <?php endif; ?>
    </main>

</body>

</html>