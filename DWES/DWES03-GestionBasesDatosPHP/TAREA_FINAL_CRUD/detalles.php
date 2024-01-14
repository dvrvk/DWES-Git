<?php
    require_once './error_handler.php';
    require_once './conexion.php';
    require './funciones.php';

    if(filter_has_var(INPUT_GET, 'id')) {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $id = filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
        
        if($id) {
            try {
                $stmtDetalles = $conexionbd->prepare('SELECT * FROM productos WHERE id=?');
                $stmtDetalles->bindParam(1, $id, PDO::PARAM_INT);
                $stmtDetalles->execute();
                $detalles = $stmtDetalles->fetch(PDO::FETCH_OBJ);
            } catch (Exception $ex) {
                $errorDetalles = "Error: no se pudo consultar el producto - intentelo más tarde.";
            }
                                    
        } else {
            redirigir();
        }
        
    } else {
        redirigir();
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>Detalles de producto</title>
    </head>
    <body class="bg-body-secondary">
        <h1 class="h1 text-center pt-4">Detalle producto</h1>
        <div class="container rounded">
            <?php if($errorDetalles ?? false) : ?>
            <div class="alert alert-danger" role="alert"><?= $errorDetalles ?></div>
            <a href="./listado.php"><button type="button" class="btn btn-outline-success" name="Volver">Volver</button></a>
            <?php else: ?>
            <div class="card border border-success">
                <h5 class="card-header text-center text-bg-success"><?= $detalles->nombre ?></h5>
                <div class="card-body bg-dark-subtle">
                    <h5 class="card-title">Código <?= $detalles->id ?></h5>
                    <ul class="card-text">
                        <li><span class="fw-semibold">Nombre:</span> <?= $detalles->nombre ?></li>
                        <li><span class="fw-semibold">Nombre corto:</span> <?= $detalles->nombre_corto ?></li>
                        <li><span class="fw-semibold">Código familia:</span> <?= $detalles->familia ?></li>
                        <li><span class="fw-semibold">PVP (€):</span> <?= $detalles->pvp ?></li>
                        <li><span class="fw-semibold">Descripción:</span> <?= $detalles->descripcion ?></li>
                    </ul>
                    <a href="./listado.php" class="btn btn-outline-success">Volver</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>
<?php
    $stmtDetalles = null;
    $conexionbd = null;
?>