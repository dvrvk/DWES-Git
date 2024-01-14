<?php
// Activo el control de errores por excepciones
$controlador = new mysqli_driver();
$controlador->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;
    
try {
    $conexionBD = new mysqli('localhost', 'gestor', 'secreto', 'proyecto');
    $querySelect = "SELECT cod, nombre FROM familias";
    //var_dump($query);
    $resultadosSelect = $conexionBD->query($querySelect);
    
} catch (mysqli_sql_exception $ex) {
    die("Error en la conexión de datos: " . $ex->getMessage());
}

if (!empty($_POST)) {
    // Extraigo datos del formulario
    $familia = filter_input(INPUT_POST, 'familia', FILTER_SANITIZE_STRING);  

    try {
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
        <style>
            h1 {
                text-align: center;
            }

            .container {
                border: 4px solid orange;
                padding: 10px;
                margin: auto;
                width: 30%;
            }

            form {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .campo {
                display: flex;
                justify-content: space-between;
            }

            .btn {
                max-width: 100px;
                margin: 0 auto;
            }

            .resultados {
                margin: 10px auto;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }

            th, td {
                padding: 5px;
                text-align: center;
            }

            select {
                width: 100%;
                margin: 0 5px;
            }
            
            .no-result {
                text-align: center;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <main>
            <h1>Productos de una familia</h1>
            <div class="container">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="campo">
                        <label for="familia">Familia: </label>
                        <select name="familia">
                            <option value="0" <?= !isset($resultados) ? "selected" : ""?> disabled>Selecciona familia</option>
                            <?php while($option = $resultadosSelect->fetch_assoc()) : ?>
                            // Creo las opciones y mantengo el valor seleccioando
                            <option value="<?= $option['cod']?>" <?= (isset($familia) && $familia == $option['cod'])? "selected" : "" ?> >
                                    <?= $option['cod'] . "-" . $option['nombre']?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <input type="submit" value="Buscar" name="buscar" class="btn">
                </form>
                <?php if ($resultados ?? false): ?>
                    <?php if($resultados->num_rows == 0): ?>
                    <p class="no-result">No hay resultados</p>
                    <?php else : ?>
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
                            <?php while ($producto = $resultados->fetch_object()): ?>
                                    <tr>
                                        <td><?= $producto->id ?></td>
                                        <td><?= $producto->nombre ?></td>
                                        <td><?= $producto->pvp ?></td>
                                    </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>  
                <?php endif; 
                endif; ?>

            </div>


        </main>

    </body>
</html>
<?php
if (isset($conexionBD)) {
    $conexionBD->close();
}
?>
