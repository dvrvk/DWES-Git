<?php

$host = "localhost";
$db = "proyecto";
$user = "gestor";
$pass = "secreto";
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $conexion = new PDO($dsn, $user, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $queryProductos = "SELECT id, nombre  FROM productos ORDER BY nombre";
    $stmtProductos = $conexion->prepare($queryProductos);
    $stmtProductos->execute();

} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: ".$e->getMessage());
}

if(!empty($_POST)){
    if(isset($_POST['consultar'])) {
        $prodSelect = $_POST['prodSelect'];
        $queryStocks = "SELECT tiendas.nombre, stocks.unidades, stocks.tienda FROM stocks, tiendas WHERE  stocks.tienda = tiendas.id AND stocks.producto = :prodSelect";
        $stmtStocks = $conexion->prepare($queryStocks);
        $stmtStocks->bindParam(':prodSelect', $prodSelect, PDO::PARAM_INT, 2);
        $stmtStocks->execute();
    }

    if(isset($_POST['actualizar_stock'])) {
        $productoId = $_POST['productoId'];
        $tiendaId = $_POST['tiendaId'];
        $unidades = $_POST['unidades'];

        $update = "UPDATE stocks SET unidades=:unidades WHERE tienda = :tiendaId AND producto = :productoId";
        $stmtActualizar = $conexion->prepare($update);
        $stmtActualizar->execute([':unidades'=>$unidades, ':productoId'=>$productoId, ':tiendaId'=>$tiendaId]);
    }

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        <label for="prodSelect">Selecciona producto</label>
        <select name="prodSelect" id="prodSelect">
            <option value="0" <?= (empty($_POST)) ?"selected":""; ?> disabled>Selecciona un producto</option>
            <?php if(isset($stmtProductos)): 
                while($producto = $stmtProductos->fetch(PDO::FETCH_ASSOC)):?>
                <option value="<?= $producto['id']?>">
                    <?= $producto['nombre'] ?>
                </option>
            <?php
                // Guardo en una variable el nombre de la selccion
                if(isset($prodSelect) && $producto['id'] == $prodSelect): 
                    $nombreProdSelect = $producto['nombre'];
                endif;
            endwhile; ?>
            <?php endif; ?>
        </select>
        <input type="submit" name="consultar" value="Consultar">
    </form>
    <?php if(isset($stmtStocks)): ?>
    <div id="resultados-stock">
        
        <table>
            <caption><?= $nombreProdSelect ?></caption>
            <thead>
                <tr>
                    <th>Tienda</th>
                    <th>Unidades</th>
                </tr>
            </thead>
            <tbody>
            <?php while($stock = $stmtStocks->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= $stock['nombre']; ?></td>
                    <td>
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                        <input type="number" name="unidades" min="0" value="<?= $stock['unidades']  ?>">
                        <input type="hidden" name="tiendaId" value="<?= $stock['tienda'] ?>">
                        <input type="hidden" name="productoId" value="<?= $prodSelect ?>">
                        <input type="submit" name="actualizar_stock" value="Actualizar">
                    </form>                             
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table> 
    </div>
    <?php endif; ?>
    <?php if(isset($stmtActualizar)): 
        echo ($stmtActualizar) 
            ? "<p>Registro actualizado correctamente</p>" 
            : "<p>No se ha podido actualizar el registro</p>";
    endif; ?>
</body>
</html>
<?php
    $conexion = null;
?>