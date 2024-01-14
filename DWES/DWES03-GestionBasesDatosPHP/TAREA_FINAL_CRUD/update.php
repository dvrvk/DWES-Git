<?php
require_once './error_handler.php';
require_once './conexion.php';
require './funciones.php';

$consultaFamilias = "SELECT cod, nombre FROM familias";
$consultaDetallesProducto = "SELECT * FROM productos WHERE id=?";

// Consulta de familias de prodcutos - listado select
try {
    $stmtListadoFamilias = $conexionbd->prepare($consultaFamilias);
    $stmtListadoFamilias->execute();
} catch (Exception $ex) {
    $errorFamilias = "Error: no se ha podido listar las familias de producto - intentelo más tarde.";
}

// Consulta de los detalles del producto
$stmtDetalles = $conexionbd->prepare('SELECT * FROM productos WHERE id=:id');

// Peticion POST 
if (filter_has_var(INPUT_POST, 'modificar')) {
    // Sanitizo los valores del formulario
    $nombre = filter_input(INPUT_POST, 'nombreProd', FILTER_SANITIZE_STRING);
    $nombreCorto = filter_input(INPUT_POST, 'nombreCortoProd', FILTER_SANITIZE_STRING);
    $precio = filter_input(INPUT_POST, 'precioProd', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $familia = filter_input(INPUT_POST, 'familiaProd', FILTER_SANITIZE_STRING);
    $descripcion = filter_input(INPUT_POST, 'descripcionProd', FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Valido los valores del formulario
    $errores = [];

    if (!filter_var($nombre, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^.{1,200}$/']])) {
        $errores['nombre'] = "*El nombre es obligatorio (1-200 caracteres)";
    }

    if (!filter_var($nombreCorto, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^.{1,50}$/']])) {
        $errores['nombreCorto'] = "*El nombre corto es obligatorio (1-50 caracteres)";
    } else {
        $nombreCorto = strtoupper($nombreCorto);
    }

    if (!filter_var($precio, FILTER_VALIDATE_FLOAT, ['options' => ['min_range' => 0]])) {
        $errores['precio'] = "*El precio es obligatorio (mínimo 0)";
    } else if (!filter_var($precio, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]+(\.[0-9]{0,2})?$/']])) {
        $errores['precio'] = "*Error en el formato precio utiliza '.' para indicar los decimales. Ej: 10.50";
        $precio = 0;
    }

    if ($familia == 0) {
        $errores['familia'] = "*La familia es un campo obligatorio";
    }

    // Existe el producto
    $stmtDetalles->execute(['id' => $id]);
    $detallesProducto = $stmtDetalles->fetch(PDO::FETCH_OBJ);
    if (!filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) || !$detallesProducto) {
        $errores['id'] = "*El id es incorrecto - vuelve a la página principal.";
        header('refresh:5;url=listado.php');
    }

    if (empty($errores)) {
        try {
            $stmtCrearProducto = $conexionbd->prepare("UPDATE productos SET nombre = :nombre, nombre_corto = :nombre_corto, descripcion = :descripcion, pvp = :precio, familia = :familia WHERE id = :id");
            $stmtCrearProducto->bindParam(':nombre', $nombre, PDO::PARAM_STR, 200);
            $stmtCrearProducto->bindParam(':nombre_corto', $nombreCorto, PDO::PARAM_STR, 50);
            $stmtCrearProducto->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
            $stmtCrearProducto->bindParam(':precio', $precio, PDO::PARAM_STR);
            $stmtCrearProducto->bindParam(':familia', $familia, PDO::PARAM_STR);
            $stmtCrearProducto->bindParam(':id', $id, PDO::PARAM_INT);
            $resultadoInsercion = $stmtCrearProducto->execute();
            $stmtCrearProducto = null;
            $precio = number_format($precio, 2, ".");
        } catch (PDOException $ex) {
            $errores['update'] = 'Error al actualizar: ' . $ex->getMessage();
        }
    }
} else if (($_SERVER['REQUEST_METHOD'] == 'GET') && filter_has_var(INPUT_GET, 'id')) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $stmtDetalles->execute(['id' => $id]);
    $detallesProducto = $stmtDetalles->fetch(PDO::FETCH_OBJ);

    if (!$detallesProducto) {
        redirigir();
    }

    $nombre = $detallesProducto->nombre;
    $nombreCorto = $detallesProducto->nombre_corto;
    $precio = $detallesProducto->pvp;
    $familia = $detallesProducto->familia;
    $descripcion = $detallesProducto->descripcion;
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
        <title>Actualizar producto</title>
    </head>
    <body class="bg-body-secondary">
        <h1 class="h1 text-center pt-4">Actualizar producto</h1>

        <div class="container bg-dark-subtle p-4 rounded">
            <?php if($errorFamilias ?? false) : ?>
            <div class="alert alert-danger" role="alert"><?= $errorFamilias ?></div>
            <a href="./listado.php"><button type="button" class="btn btn-outline-success" name="Volver">Volver</button></a>
            <?php else: ?>
            <form action="<?= $_SERVER['PHP_SELF'] . "?$id" ?>" method="POST" class="row">

                <input type="hidden" name="id" value="<?= $id ?>">
                <?php if ($resultadoInsercion ?? false) : ?>
                    <div class="alert alert-success" role="alert">Producto modificado con éxito.</div>
                <?php endif; ?>
                
                <?php if ($errores['update'] ?? false) : ?>
                    <div class="alert alert-danger" role="alert"><?= $errores['update'] ?></div>
                <?php elseif ($errores['id'] ?? false) : ?>
                    <div class="alert alert-danger" role="alert"><?= $errores['id'] ?></div>
                <?php endif; ?>

                <div class="mb-3 col-md-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control <?= ($errores['nombre'] ?? false) ? 'is-invalid' : '' ?>"
                           id="nombre" placeholder="Nombre del producto" name="nombreProd" value="<?= $nombre ?? '' ?>">
<?php if ($errores['nombre'] ?? false) : ?>
                        <div class="invalid-feedback">
                               <?= $errores['nombre'] ?>
                        </div>
                        <?php endif; ?>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="nombreCorto" class="form-label">Nombre corto</label>
                    <input type="text" class="form-control <?= ($errores['nombreCorto'] ?? false) ? 'is-invalid' : '' ?>" 
                           id="nombreCorto" placeholder="Nombre corto del producto" name="nombreCortoProd" value="<?= $nombreCorto ?? '' ?>">
<?php if ($errores['nombreCorto'] ?? false) : ?>
                        <div class="invalid-feedback">
                               <?= $errores['nombreCorto'] ?>
                        </div>
                        <?php endif; ?>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="precio" class="form-label">Precio (€)</label>
                    <input type="text" class="form-control <?= ($errores['precio'] ?? false) ? 'is-invalid' : '' ?>"
                           id="precio" placeholder="Precio del producto (€)" name="precioProd" min="0" value="<?= $precio ?? '' ?>">
<?php if ($errores['precio'] ?? false) : ?>
                        <div class="invalid-feedback">
                               <?= $errores['precio'] ?>
                        </div>
                        <?php endif; ?>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="familia" class="form-label">Familia</label>
                    <select class="form-select <?= ($errores['familia'] ?? false) ? 'is-invalid' : '' ?>"
                            name="familiaProd">
                        <option value="0" <?= (!($familia ?? false)) ? "selected" : '' ?> disabled>Selecciona una familia</option>
<?php while ($familiaDatos = $stmtListadoFamilias->fetch(PDO::FETCH_OBJ)) : ?>
                            <option value="<?= $familiaDatos->cod ?>" <?= (($familia ?? false) == ($familiaDatos->cod)) ? "selected" : '' ?>>
                            <?= $familiaDatos->nombre ?>
                            </option>
                            <?php endwhile; ?>
                    </select>
                        <?php if ($errores['familia'] ?? false) : ?>
                        <div class="invalid-feedback">
                        <?= $errores['familia'] ?>
                        </div>
                        <?php endif; ?>
                </div>
                <div class="mb-3 col-md-12">
                    <label for="descripcionProd" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcionProd" name="descripcionProd" rows="6" maxlength="200"><?= $descripcion ?? '' ?></textarea>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success fw-semibold" name="modificar">Modificar</button>
                    <a href="./listado.php"><button type="button" class="btn btn-outline-success" name="Volver">Volver</button></a>
                </div>
            </form>
            <?php endif; ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>
<?php 
if($stmtDetalles ?? false) {
    $stmtDetalles = null;
}
if($stmtListadoFamilias ?? false) {
    $stmtListadoFamilias = null;
}
$conexionbd = null;
?>
