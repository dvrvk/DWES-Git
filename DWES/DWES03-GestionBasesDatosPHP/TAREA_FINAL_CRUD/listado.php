<?php
require_once './error_handler.php';
require_once './conexion.php';

// consulta productos - listado productos
$consultaProductos = "SELECT id, nombre FROM productos";
try {
    $stmtListadoProductos = $conexionbd->prepare($consultaProductos);
    $stmtListadoProductos->execute();
} catch (Exception $ex) {
    $errorProductos = "Error: no se pueden cargar los productos - Intentelo más tarde.";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>CRUD productos</title>
    </head>
    <body class="bg-body-secondary">
        
        <div class="container">
            <h1 class="h1 text-center pt-4">Gestor de productos</h1>
            <a href="./crear.php"><button type="button" class="btn btn-success fw-semibold mb-4">Crear</button></a>
            <?php if($errorProductos ?? false):  ?>
            <div class="alert alert-danger" role="alert"><?= $errorProductos ?></div>
            <?php else: ?>
            <table class="table table-dark table-striped text-center table-hover">
                <thead>
                    <tr>
                        <th>Detalle</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr> 
                </thead>
                <tbody>
                <?php while($producto = $stmtListadoProductos->fetch(PDO::FETCH_OBJ)): ?>
                    <tr>
                        <td>
                            <a href="./detalles.php?id=<?= $producto->id ?>"><button type="button" class="btn btn-primary fw-semibold">Detalles</button></a>
                        </td>
                        <td><?= $producto->id ?></td>
                        <td><?= $producto->nombre ?></td>
                        <td>
                            <div class="d-flex justify-content-evenly flex-wrap">
                                <a href="./update.php?id=<?= $producto->id ?>">
                                    <button type="button" class="btn btn-success fw-semibold">Actualizar</button>
                                </a>
                                <form method="POST" action="./borrar.php">
                                    <input type="hidden" value="<?= $producto->id ?>" name="id">
                                    <button type="submit" class="btn btn-danger fw-semibold mt-2 mt-lg-0" name="eliminar">Eliminar</button>
                                </form>  
                            </div>
                            
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>
<?php
    $stmtListadoProductos = null;
    $conexionbd = null;
?>
