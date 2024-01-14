<?php
    require_once './error_handler.php';
    require_once './conexion.php';
    require './funciones.php';
    
    if(filter_has_var(INPUT_POST, 'eliminar')) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $id = filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
        
        if($id) {
            try {
                $stmtEliminarProducto = $conexionbd->prepare('DELETE FROM productos WHERE id = :id');
                $stmtEliminarProducto->execute([':id'=>$id]);
                $mensajeExito = "El producto con código $id ha sido eliminado correctamente.";
                $stmtEliminarProducto = null;
            } catch (Exception $ex) {
                $mensajeError = "Error: El producto con código $id NO ha podido ser eliminado.";
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
        <title>Borrar producto</title>
    </head>
    <body class="bg-body-secondary">
        <div class="container bg-dark-subtle p-4 rounded mt-4">
            <?php if ($mensajeExito ?? false) : ?>
                <div class="alert alert-success" role="alert"><?= $mensajeExito ?></div>
            <?php endif; ?>
            <?php if ($mensajeError ?? false) : ?>
                <div class="alert alert-danger" role="alert"><?= $mensajeError ?></div>
            <?php endif; ?>
             <a href="./listado.php"><button type="button" class="btn btn-outline-success mt-4" name="Volver">Volver</button></a>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>
<?php
$conexionbd = null;
?>
