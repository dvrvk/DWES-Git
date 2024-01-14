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
    die("Error en la conexión a la base de datos: ". $e->getMessage());
}

if(!empty($_POST)) {
    if(isset($_POST['consultar'])) {
        // Saco valor seleccionado
        $prodSelect = $_POST['prodSelect'];
        // Realizo la consulta
        $query = "SELECT tiendas.nombre, stocks.unidades, stocks.tienda  FROM stocks, tiendas WHERE stocks.tienda = tiendas.id AND stocks.producto = $prodSelect";
        //var_dump($consulta);
        $stocks = $conexion->query($query);
        //var_dump($stocks->fetch_object());
    } else if(isset($_POST['actualizar_stock'])){
        $productoId = $_POST['productoId'];
        $tiendaId = $_POST['tiendaId'];
        $unidades = $_POST['unidades'];

        $stmt = $conexion->stmt_init();
        $stmt->prepare('UPDATE stocks SET unidades = ? WHERE tienda=? AND producto=?');
        $stmt->bind_param('iii',$unidades,$tiendaId,$productoId);
        $resultado = $stmt->execute();     
    }
    
    
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
                    <?= (!empty($_POST) && $producto->id == ($prodSelect??null)) ?"selected":""?>
                >
                    <?= $producto->nombre ?>
                </option>
            <?php endwhile ?>
        </select>
        <input type="submit" name="consultar" value="Consultar Stock">
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
                <td>
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                        <input type="number" name="unidades" min="0" value="<?= $stock->unidades  ?>">
                        <input type="hidden" name="tiendaId" value="<?= $stock->tienda ?>">
                        <input type="hidden" name="productoId" value="<?= $prodSelect ?>">
                        <input type="submit" name="actualizar_stock" value="Actualizar">
                    </form>                
                </td>
            </tr>    
        <?php endwhile; ?>
        </table>
    <?php elseif(isset($stmt)): 
        if($resultado): ?>
            <p>Stock actualizado correctamente</p>
        <?php else:  ?>
            <p>Error, no se ha podido actualizar el stock</p>    
    <?php endif; endif; ?>
</body>
</html>
<?php
    if(isset($stmt)) {
        $stmt->close();
    }
    $conexion->close();
?>