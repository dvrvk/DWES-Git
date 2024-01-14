<?php
$host = 'localhost';
$db = 'proyecto';
$user = 'gestor';
$pass = 'secreto';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {

    $conexion = new PDO($dsn, $user, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $commit = true;
    // Inicio transaccion
    $conexion->beginTransaction();

    $update = "UPDATE stocks SET unidades=1 WHERE producto=(SELECT id FROM productos WHERE nombre_corto='PAPYRE62GB ') AND tienda=1";
    if (!$conexion->exec($update)) {
        $commit = false;
    }
    $insert = "INSERT INTO stocks SELECT id, 2, 1 FROM productos WHERE nombre_corto='PAPYRE62GB'";
    //es equivalente a insert into stocks values(15, 2, 1)
    if (!$conexion->exec($insert)) {
        $commit = false;
    }

    // Si es correcto confirmamos cambios
    // Si no es correcto los deshacemos
    if ($commit) {
        $conexion->commit();
    } else {
        $conexion->rollBack();
    }

} catch (PDOException $e) {
    die("Error en la conexión o la consulta: " . $e->getMessage());
}

// Cerramos conexión
$conexion = null;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0,
              maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- enlaces para usar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Transacciones en PDO </title>
</head>

<body class="bg-info">
    <h3 class="text-center mt-2 font-weight-bold">Ejercicio Transacción con PDO </h3>
    <div class="container mt-3">
        <?php if ($commit) : ?>
            <p class='text-primary font-weight-bold'>Los cambios se realizaron correctamente.</p>
        <?php else : ?>
            <p class='text-danger font-weight-bold'>No se han podido realizar los cambios.</p>
        <?php endif ?>
    </div>
</body>

</html>