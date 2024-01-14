<?php
// Activar las excepciones para el control de errores
$controlador = new mysqli_driver();
$controlador->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;


try {
    $conProyecto = new mysqli('localhost', 'gestor','secreto', 'proyecto');
} catch (mysqli_sql_exception $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}

$commit=true;
$conProyecto->autocommit(false);
$update ="UPDATE stocks set unidades=1 WHERE producto=(select id from productos where nombre_corto='3DSNG') AND tienda=1";

if (!$conProyecto->query($update)) {
    $commit = false;
}

//fijate en este insert, el select devolverá el productos.id del producto de nombre_corto='3DSNG' 3 y 1 es decir
// estamos haciendo un insert into stocks(producto, tienda, unidades) lo valores 1, 3, 1
$insert = "INSERT INTO stocks(producto, tienda, unidades) SELECT id, 3, 1 FROM productos WHERE nombre_corto='3DSNG'";

if (!$conProyecto->query($insert)) {
    $commit = false;  
}

//Si todo fue bien hacemos el commit si no el rollback
if ($commit) {
    $conProyecto->commit();
} else {
    $conProyecto->rollback();
}
$conProyecto->close();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0,
              maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- enlaces para usar Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" 
              integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <title>Transacciones MySQLi </title>
    </head>
    <body class="bg-primary">
        <h3 class="text-center mt-2 font-weight-bold">Transacción con Mysqli</h3>
        <div class="container mt-3">
            <?php if ($commit): ?>
                <p class='text-primary font-weight-bold'>Los cambios se realizaron correctamente.</p>
            <?php else: ?>
                <p class='text-danger font-weight-bold'>No se han podido realizar los cambios.</p>
            <?php endif ?>
        </div>
    </body>
</html>