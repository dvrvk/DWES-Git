<?php
if (filter_has_var(INPUT_POST, "buscar_productos")) {
    $buscarProductos = true;
    try {
        $bd = new mysqli('localhost', 'gestor', 'secreto', 'proyecto');
        $bd->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;
        
    } catch (mysqli_sql_exception $e) {
        // Handle the exception
        die("MySQLi Exception: " . $e->getMessage());
    }
    $familia = filter_input(INPUT_POST, 'familia', FILTER_UNSAFE_RAW);
    
    $stmtConsultaProductosPorFamilia = $bd->stmt_init();
    $consultaProductos = 'SELECT id, nombre, pvp FROM productos WHERE familia=?';
    try {
        $stmtConsultaProductosPorFamilia->prepare($consultaProductos);
        $stmtConsultaProductosPorFamilia->bind_param('s', $familia);
        $stmtConsultaProductosPorFamilia->execute();
        $result = $stmtConsultaProductosPorFamilia->get_result();
        
    } catch (mysqli_sql_exception $e) {
        // Handle the exception
        $errorConsulta = $e->getMessage();
        $consultaProductos = false;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Obtener los productos de una familia MySQLi</title>
        <style>
            body {
                box-sizing: border-box;
            }

            .page {
                display: flex;
                flex-flow: column nowrap;
                align-items: center;
                font-size: 1.5em;
            }

            .form {
                display: flex;
                flex-flow: column nowrap;
                width: 300px;
                padding: 20px;
                border: 5px solid orange;
            }

            table {
                font-size: 0.75em;
            }

            th, td {
                padding: 15px;
            }

            .input-section {
                display:flex;
                justify-content: space-between;
                flex-flow: row nowrap;
                margin-bottom: 10px;
            }

            input {
                max-width: 80px;
                flex: 0 1 80px;
            }

            .submit-section {
                align-self: center;
                margin: 30px;
            }

            .submit {
                background: orange;
            }
        </style>
    </head>
    <body>
        <div class ="page">
            <h1>Productos de una familia</h1>
            <form class="form" name="form_obtener_productos" 
                  action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="input-section">
                    <label for="familia">Familia:</label> 
                    <input id="familia" value="<?= $familia ?? '' ?>" name="familia"/>
                </div>
                <div class="submit-section">
                    <input class="submit" type="submit" 
                           value="Buscar" name="buscar_productos" /> 
                </div>
                <?php if (isset($buscarProductos)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($consultaProductos) && $consultaProductos): ?>
                                <?php while ($producto = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $producto['id'] ?></td>
                                        <td><?= $producto['nombre'] ?></td>
                                        <td> <?= $producto['pvp'] ?></td>
                                    </tr>
                                <?php endwhile ?>
                            <?php else: ?>
                            <h4><?= "Problema al consultar los productos. $errorConsulta" ?></h4>
                        <?php endif ?>
                        </tbody>
                    </table>
                <?php endif ?>
            </form>
        </div>
    </body>
</html>
