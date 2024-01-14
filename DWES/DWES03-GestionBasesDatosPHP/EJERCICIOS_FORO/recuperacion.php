<?php
if (!empty($_POST)) {
    // Extraigo datos del formulario
    $familia = filter_input(INPUT_POST, 'familia', FILTER_SANITIZE_STRING);
    
    // Activo el control de errores por excepciones
    $controlador = new mysqli_driver();
    $controlador->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

    try {
        $conexionBD = new mysqli('localhost', 'gestor', 'secreto', 'proyecto');
        $query = "SELECT id, nombre, pvp FROM productos WHERE familia = '$familia'";
        //var_dump($query);
        $resultados = $conexionBD->query($query);
        
    } catch (mysqli_sql_exception $ex) {
        die("Error en la conexión de datos: " . $ex->getMessage());
    }
}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Consulta Productos</title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>
    <body>
        <main>
            <h1>Productos de una familia</h1>
            <div class="container">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="campo">
                        <label for="familia">Familia: </label>
                        <input type="text" id="familia" name="familia" class="input">
                    </div>
                    <input type="submit" value="Buscar" name="buscar" class="btn">
                </form>
                <?php if($resultados ?? false): ?>
                <div class="resultados">
                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($producto = $resultados->fetch_object()): ?>
                            <tr>
                                <td><?= $producto->id ?></td>
                                <td><?= $producto->nombre ?></td>
                                <td><?= $producto->pvp ?></td>
                            </tr>
                        <?php endwhile;?>
                        </tbody>
                    </table>
                </div>  
                <?php endif; ?>
                
            </div>


        </main>

    </body>
</html>
<?php
    if(isset($conexionBD)) {
       $conexionBD->close(); 
    }
    
?>


