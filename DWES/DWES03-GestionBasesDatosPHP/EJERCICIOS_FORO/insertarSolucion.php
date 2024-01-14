<?php

if (filter_has_var(INPUT_POST, 'crear_familia')) {
    try {
        $bd = new mysqli('localhost', 'gestor', 'secreto', 'proyecto');
        $bd->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;
    } catch (mysqli_sql_exception $e) {
        // Handle the exception
        die("MySQLi Exception: " . $e->getMessage());
    }

    $codigo = filter_input(INPUT_POST, 'codigo', FILTER_UNSAFE_RAW);
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_UNSAFE_RAW);

    try {
        $familiaInsertada = $bd->query("INSERT INTO familias VALUES ('$codigo', '$nombre')");
    } catch (mysqli_sql_exception $e) {
        // Handle the exception
        $errorInsercion = $e->getMessage();
        $familiaInsertada = false;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inserción de una familia</title>
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
            <h1>Familia de productos</h1>
            <form class="form" name="form_creacion_familia" 
                  action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="input-section">
                    <label for="codigo">Código:</label> 
                    <input id="codigo" type="text" required  name="codigo" value="<?= $codigo ?? '' ?>"/>
                </div>
                <div class="input-section">
                    <label for="numero">Nombre:</label> 
                    <input id="codigo" type="text" required  name="nombre" value="<?= $nombre ?? '' ?>"/>
                </div>
                <div class="submit-section">
                    <input class="submit" type="submit" 
                           value="Crear" name="crear_familia" /> 
                </div>
                <?php if (isset($familiaInsertada)): ?>
                    <h4><?= ($familiaInsertada) ? "Familia intertada con éxito" : "Problema al insertar la familia. $errorInsercion" ?></h4>
                <?php endif ?>

            </form>

        </div>

    </body>

</html>


