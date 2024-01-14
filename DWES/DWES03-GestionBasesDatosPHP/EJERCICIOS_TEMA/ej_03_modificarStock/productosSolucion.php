<?php
$controlador = new mysqli_driver();
$controlador->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;
try {
    $conProyecto = new mysqli('localhost', 'gestor', 'secreto', 'proyecto');
} catch (mysqli_sql_exception $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}

if (isset($_POST['enviar'])) {
    $codProd = filter_input(INPUT_POST, 'producto', FILTER_UNSAFE_RAW);
    $consultaProducto = "select nombre , nombre_corto from productos where id=?";
    $stmtConsultaProducto = $conProyecto->prepare($consultaProducto);
    $stmtConsultaProducto->bind_param('i', $codProd);
    $stmtConsultaProducto->execute();
    $stmtConsultaProducto->bind_result($nombre, $nombreCorto);
    $stmtConsultaProducto->fetch(); //esta consulta solo devuelve una fila, no es necesario el while
    $stmtConsultaProducto->close();
    $consultaStock = "select unidades, tienda, producto, tiendas.nombre as nombreTienda from stocks, tiendas where tienda=tiendas.id AND producto=?";
    $stmtConsultaStock = $conProyecto->prepare($consultaStock);
    $stmtConsultaStock->bind_param('i', $codProd);
    $stmtConsultaStock->execute();
    $resultadoStockProducto = $stmtConsultaStock->get_result();
    $stmtConsultaStock->close();
} elseif (isset($_POST['enviar_stock'])) {
    $codTienda = filter_input(INPUT_POST, 'codigo_tienda', FILTER_UNSAFE_RAW);
    $codProducto = filter_input(INPUT_POST, 'codigo_producto', FILTER_UNSAFE_RAW);
    $unidades = filter_input(INPUT_POST, 'stock', FILTER_UNSAFE_RAW);
    $consultaUpdateStock = "update stocks set unidades=? where producto=? AND tienda=?";
    $stmtConsultaUpdateStock = $conProyecto->prepare($consultaUpdateStock);
    $stmtConsultaUpdateStock->bind_param('iii', $unidades, $codProducto, $codTienda);
    $stmtConsultaUpdateStock->execute();
    $stmtConsultaUpdateStock->close();
} else {
    $consultaProductos = "select id, nombre from productos order by nombre";
    $stmtConsultaProductos = $conProyecto->prepare($consultaProductos);
    $stmtConsultaProductos->execute();
    $stmtConsultaProductos->store_result();
    $stmtConsultaProductos->bind_result($producto['id'], $producto['nombre']);
    $numProductos = $stmtConsultaProductos->num_rows();
}
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
        <title>Conjuntos de resultados en MySQLi</title>
    </head>
    <body class="bg-info">
        <h3 class="text-center mt-2 font-weight-bold">Actualización de stock de producto</h3>
        <div class="container mt-3">
            <?php if (isset($_POST['enviar'])): ?>
                <h4 class="mt-3 mb-3 text-center">Unidades del Producto: <?= "$nombre ($nombreCorto)" ?></h4>
                <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-success m-2">Consultar Otro Artículo</a>
                <table class="table table-striped table-dark">
                    <thead>
                        <tr class="text-center font-weight-bold">
                            <th>Nombre Tienda</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($stock = $resultadoStockProducto->fetch_assoc()): ?>
                            <tr>
                                <td><?= $stock['nombreTienda'] ?></td>
                                <td class="textcenter">
                                    <form name='formulario_actualiza_stock' action='<?= $_SERVER['PHP_SELF'] ?>' method='POST' class='form-inline'>
                                        <div class="input-group">
                                            <input type="number" class="form-control" step="1" min="0" name="stock" value="<?= $stock['unidades'] ?>">
                                            <input type="hidden" name="codigo_tienda" value="<?= $stock['tienda'] ?>">
                                            <input type="hidden" name="codigo_producto" value="<?= $stock['producto'] ?>">
                                            <input type="submit" class="btn btn-warning" name="enviar_stock" value="Actualizar">
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table> 
            <?php elseif (isset($_POST['enviar_stock'])): ?>
                <p class="font-weight-bold text-success mt-3">Unidades Actualizadas Correctamente</p>
                <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-success mb-2">Consultar Otro Artículo</a>
            <?php else: ?>
                <form name="formulario" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="row">
                        <label for="p" class="font-weight-bold">Elige un producto </label>
                        <select class="form-control" id="p" name="producto">
                            <?php while ($stmtConsultaProductos->fetch()): ?> 
                                <option value='<?= $producto['id'] ?>'><?= $producto['nombre'] ?></option>
                            <?php endwhile ?>
                            <?php
                            $stmtConsultaProductos->free_result();
                            $stmtConsultaProductos->close();
                            ?>
                        </select>
                    </div>
                    <div class="mt-2">
                        <input type="submit" class="btn btn-warning me-3" value="Consultar Stock" name="enviar">
                    </div>
                </form>
            </div>
        <?php endif ?>
    </body>
</html>
<?php
$conProyecto->close();
?>