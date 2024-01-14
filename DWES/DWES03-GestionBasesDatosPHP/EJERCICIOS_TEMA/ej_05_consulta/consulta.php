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
    $productos = $conexion->query($queryProductos);

} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: ".$e->getMessage());
}

if(!empty($_POST)){
    if(isset($_POST['consultar'])) {
        $prodSelect = $_POST['prodSelect'];
        $queryStocks = "SELECT tiendas.nombre, stocks.unidades, stocks.tienda FROM stocks, tiendas WHERE  stocks.tienda = tiendas.id AND stocks.producto = $prodSelect";
        $stocks = $conexion->query($queryStocks);
    }

    if(isset($_POST['actualizar_stock'])) {
        $productoId = $_POST['productoId'];
        $tiendaId = $_POST['tiendaId'];
        $unidades = $_POST['unidades'];

        $update = "UPDATE stocks SET unidades=$unidades WHERE tienda = $tiendaId AND producto = $productoId";
        $registrosAfectados = $conexion->exec($update);
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
            <?php if(isset($productos)): 
                while($producto = $productos->fetch(PDO::FETCH_ASSOC)):?>
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
    <?php if(isset($stocks)): ?>
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
            <?php while($stock = $stocks->fetch(PDO::FETCH_ASSOC)): ?>
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
    <?php if(isset($registrosAfectados)): ?>
        <p>Actualizado correctamente:<?= $registrosAfectados ?> registros afectados. </p>
    <?php endif; ?>
</body>
</html>
<?php
    $conexion = null;
?>