<?php
if (!empty($_POST)) {
    // Extraigo datos del formulario
    $familia = filter_input(INPUT_POST, 'familia', FILTER_SANITIZE_STRING);
    
    
    // Datos de la conexión
    $host = "localhost";
    $db = "proyecto";
    $user = "gestor";
    $pass = "secreto";
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    
    try {
        // Creo la conexión
        $conexionBD = new PDO($dsn, $user, $pass);
        // Establezco que los errores lancen una PDOException
        $conexionBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Realizo la consulta
        $query = "SELECT id, nombre, pvp FROM productos WHERE familia = '$familia'";
        $resultados = $conexionBD->query($query);
        
    } catch (PDOException $ex) {
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
                        <?php while($producto = $resultados->fetch(PDO::FETCH_OBJ)): ?>
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
       $conexionBD = null; 
    }
    
?>


