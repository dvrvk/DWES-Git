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
    $consultaProducto = "select nombre , nombre_corto from productos where id=$codProd";
    $consultaStock = "select unidades, tiendas.nombre as tienda from stocks, tiendas where tienda=tiendas.id AND producto=$codProd";
    $resultadoConsultaProducto = $conProyecto->query($consultaProducto);
    $datosProducto = $resultadoConsultaProducto->fetch_assoc();
    $resultadoStockProducto = $conProyecto->query($consultaStock);
} else {
    $consultaProductos = "select id, nombre, nombre_corto from productos order by nombre";
    $resultadoProductos = $conProyecto->query($consultaProductos);
    $datosProductos = $resultadoProductos->fetch_all(MYSQLI_ASSOC);
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

        <title>Conjuntos de resultados en MySQLi </title>
    </head>
    <body class="bg-info">
        <h3 class="text-center mt-2 font-weight-bold">Unidades de un producto</h3>
        <div class="container mt-3">
            <?php if (!empty($_POST)): ?>
                <h4 class="mt-3 mb-3 text-center">Unidades del Producto: <?= "{$datosProducto['nombre']} {$datosProducto['nombre_corto']}" ?></h4>
                <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-success m-2">Consultar Otro Artículo</a>
                <table class="table table-striped table-dark">
                    <thead>
                        <tr class="text-center font-weight-bold"><th>Nombre Tienda</th>
                            <th>Stock</th></tr>
                    </thead>
                    <tbody>
                        <?php while ($stockProducto = $resultadoStockProducto->fetch_assoc()): ?>
                            <tr>
                                <td><?= $stockProducto['tienda'] ?></td>
                                <td class="textcenter"><?= $stockProducto['unidades'] ?></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else: ?>
                <form name="formulario" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="row">
                        <label for="p" class="font-weight-bold">Elige un producto </label>
                        <select class="form-control" id="p" name="producto">
                            <?php foreach ($datosProductos as $producto): ?>
                                <option value="<?= $producto['id'] ?>"><?= $producto['nombre'] ?></option>
                            <?php endforeach ?>
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