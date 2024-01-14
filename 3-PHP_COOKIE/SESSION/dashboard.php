<?php 
    session_name('LOGIN');
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Hola <?= $_SESSION['nombre']?></h1>
    <form action="cerrar.php" method="post">
        <button type="submit">Cerrar sesion</button>
    </form>
</body>
</html>