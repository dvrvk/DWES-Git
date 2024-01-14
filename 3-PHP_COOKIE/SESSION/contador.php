<?php
    // Cambiar el nombre de la sesion (opcional/automático)
    session_name('MISESION');
    // Modificar el id de la sesion (opcional/automático)
    //session_id('php');
    // Crear una sesion
    session_start();

    // Crear datos de session
    if(isset($_SESSION['contador'])) {
        $_SESSION['contador']++;
    } else {
        $_SESSION['contador'] = 1;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contador</title>
</head>
<body>
    <h1>Contador</h1>
    <?= session_id() ?>
    <br>
    <?php echo "Has recargado " . $_SESSION['contador'] . " veces" ?>
    <br>
    <a href="index.php">Inicio</a>
    <br>
    <a href="cerrar.php">Cerrar</a>
</body>
</html>