<?php
// Activar las excepciones para el control de errores
$controlador = new mysqli_driver();
$controlador->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

// Hacer la conexión
try {
    $conexion = new mysqli('localhost', 'gestor','secreto', 'proyecto');

    // Sacar productos
    $query = "SELECT *  FROM productos ORDER BY nombre";
    $productos = $conexion->query($query);
} catch (mysqli_sql_exception $err) {
    die("Error en la conexión a la base de datos: ".$e->getMessage());
}

if(!empty($_POST)) {
    // Saco valor seleccionado
    $prodSelect = $_POST['prodSelect'];
    // Realizo la consulta
    $query = "SELECT tiendas.nombre, stocks.unidades  FROM stocks, tiendas WHERE stocks.tienda = tiendas.id AND stocks.producto = $prodSelect";
    //var_dump($consulta);
    $stocks = $conexion->query($query);
    //var_dump($stocks->fetch_object());
    
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>
    <link rel="stylesheet" href="styles.css" class="css">
</head>
<body>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        <label for="productos">Selecciona un producto</label>
        <select name="prodSelect" id="prodSelect">
                <option value="0" <?= (empty($_POST)) ?"selected":""; ?> disabled>Selecciona producto</option>
            <?php while($producto = $productos->fetch_object()) :?>
                <option value="<?= $producto->id ?>"
                    <?= (!empty($_POST) && $producto->id == $prodSelect) ?"selected":""?>
                >
                    <?= $producto->nombre ?>
                </option>
            <?php endwhile ?>
        </select>
        <input type="submit" value="Consultar Stock">
    </form>
    <?php if(isset($stocks)): ?>
        <table>
        <thead>
            <tr>
                <th>Tienda</th>
                <th>Unidades</th>
            </tr>
        </thead>
        <?php while($stock = $stocks->fetch_object()): ?>
            <tr>
                <td><?= $stock->nombre ?></td>
                <td><?= $stock->unidades ?></td>
            </tr>    
        <?php endwhile; ?>
        </table>
    <?php endif; ?>
</body>
</html>
<?php
    $conexion->close();
?>